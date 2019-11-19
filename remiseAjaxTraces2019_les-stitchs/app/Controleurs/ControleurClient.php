<?php

/**
 * @file Méthodes et fonctions utilisées pour les catégories, utilisées dans l'Accueil, la page Catalogue et les fiches de livre
 * @author Gabriel Chouinard Létourneau <chouinardletourneaug@gmail.com> / Marie-Li Durand <_____> / Élody Levasseur-Côté <_____>
 * @version Post-prototype
 */

declare(strict_types=1);

namespace app\Controleurs;

use App\App;
use App\Modeles\Transaction\Client;
use App\Utilitaires;


class ControleurClient
{
    private $blade = null;
    private $session = null;
    private $utilitaires = null;

    private $tMessagesJson = null;

    private $dernierePage = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
        $this->session = App::getInstance()->getSession();
        $this->utilitaires = App::getInstance()->getUtilitaires();

        $contenuBruteFichierJson = file_get_contents("../ressources/lang/fr_CA.UTF-8/messagesUtilisateurValidation.json");
        $this->tMessagesJson = json_decode($contenuBruteFichierJson, true);

    }

    public function connexion():void {
        $this->dernierePage = $_SERVER['HTTP_REFERER'];
        $tValidation = $this->session->getItem('tValidation');
        $this->session->supprimerItem('tValidation');

        $utilitaire = $this->utilitaires;
        $panier = App::getInstance()->getSessionPanier();

        $client = $this->session->getItem('client');

        $tDonnees = array("nomPage"=>"Connectez-vous");
        $tDonnees = array_merge($tDonnees, array("utilitaire"=>$utilitaire));
        $tDonnees = array_merge($tDonnees, array("panier" => $panier));
        $tDonnees = array_merge($tDonnees, array("tValidation" => $tValidation));
        $tDonnees = array_merge($tDonnees, array("client" => $client));
        $tDonnees = array_merge($tDonnees, array("dernierePage" => $this->dernierePage));
        echo $this->blade->run("connexion",$tDonnees);
    }

    public function deconnexion():void {
        $this->session->supprimerItem('client');
        $this->session->regenererId();
        header('Location: index.php?controleur=site&action=accueil');
        exit;
    }

    public function creation():void {
        $tValidation = $this->session->getItem('tValidation');
        $this->session->supprimerItem('tValidation');

        $panier = App::getInstance()->getSessionPanier();

        $client = $this->session->getItem('client');

        $tDonnees = array("nomPage"=>"Créer un compte");
        $tDonnees = array_merge($tDonnees, array("tValidation" => $tValidation));
        $tDonnees = array_merge($tDonnees, array("panier" => $panier));
        $tDonnees = array_merge($tDonnees, array("client" => $client));
        echo $this->blade->run("creationCompte",$tDonnees);
    }

    public function inserer():void {
        $tValidation = [];

        $tValidation = Utilitaires::validerChamp('courriel','#^[a-zA-Z0-9_]+(.[a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+(.[a-zA-Z0-9_]+)*.[a-zA-Z]{2,4}$#',$tValidation,false);
        $tValidation = Utilitaires::validerChamp('mot_de_passe','#(?=.*[a-zà-ÿ])(?=.*[A-ZÀ-Ÿ])(?=.*[0-9]).{8,20}#',$tValidation,false);
        $tValidation = Utilitaires::validerChamp('telephone','#^[0-9]{10}$#',$tValidation,false);
        $tValidation = Utilitaires::validerChamp('prenom',"#^[a-zA-ZÀ-ÿ\'-\.]+$#",$tValidation,false);
        $tValidation = Utilitaires::validerChamp('nom',"#^[a-zA-ZÀ-ÿ\'-\.]+$#",$tValidation,false);


        if($tValidation['courriel']['valide'] == 'vrai') {
            $client = Client::trouverParCourriel($_POST['courriel']);
            if($client != null) {
                $tValidation['creation']['valide'] = 'faux';
                $tValidation['creation']['message'] = $this->tMessagesJson{"courriel"}{"existant"};
                $this->session->setItem('tValidation', $tValidation);
                header('Location: index.php?controleur=client&action=creation');
                exit;
            }
        }

        $sousTableau = array_column($tValidation, 'valide');
        $trouverFaux = in_array('faux', $sousTableau);

        if(!$trouverFaux) {
            $client = new Client();

            $client->__set('courriel', $tValidation['courriel']['valeur']);
            $client->__set('mot_de_passe', password_hash($tValidation['mot_de_passe']['valeur'], PASSWORD_DEFAULT));
            $client->__set('telephone', $tValidation['telephone']['valeur']);
            $client->__set('prenom', $tValidation['prenom']['valeur']);
            $client->__set('nom', $tValidation['nom']['valeur']);

            $client->insererNouveauClient();

            $this->session->supprimerItem('tValidation');

            $this->session->regenererId();

            $this->session->setItem('client', $client);

            header('Location: index.php?controleur=site&action=accueil');
            exit;
        } else {
            $this->session->setItem('tValidation', $tValidation);
            header('Location: index.php?controleur=client&action=creation');
            exit;
        }
    }

    public function validerClient():void {
        $tValidation = [];

        $tValidation = Utilitaires::validerChamp('courriel','#^[a-zA-Z0-9_]+(.[a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+(.[a-zA-Z0-9_]+)*.[a-zA-Z]{2,4}$#',$tValidation,false);
        $tValidation = Utilitaires::validerChamp('mot_de_passe','#(?=.*[a-zà-ÿ])(?=.*[A-ZÀ-Ÿ])(?=.*[0-9]).{8,20}#',$tValidation,false);

        //Validation du courriel 
        $courriel = '';
        if(isset($_POST['courriel'])) {
            if(preg_match("#^[a-zA-Z0-9_]+(.[a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+(.[a-zA-Z0-9_]+)*.[a-zA-Z]{2,4}$#", $_POST['courriel'])) {
                $courriel = $_POST['courriel'];
            }
            else {
                $tValidation['connexion']['valide'] = 'faux';
                $tValidation['connexion']['message'] = $this->tMessagesJson{"courriel"}{"pattern"};
            }
        } 

        //Valider le mot de passe
        $motDePasse = '';
        if(isset($_POST['motDePasse'])) {
            if(preg_match("#(?=.*[a-zà-ÿ])(?=.*[A-ZÀ-Ÿ])(?=.*[0-9]).{8,20}#", $_POST['motDePasse'])) {
                $motDePasse = $_POST['motDePasse'];
            }
            else {
                $tValidation['connexion']['valide'] = 'faux';
                $tValidation['connexion']['message'] = $this->tMessagesJson{"mot_de_passe"}{"pattern"};
            }
        } 

        if(isset($_POST['dernierePage'])) {
            $this->dernierePage = $_POST['dernierePage'];
        } 

        //Trouver le client selon le email pour vérifier le mot de passe
        $client = Client::trouverParCourriel($courriel);

        if($client == null){
            //Si le client n'existe pas dans la BD
            $tValidation['connexion']['valide'] = 'faux';
            $tValidation['connexion']['message'] = $this->tMessagesJson{"courriel"}{"inexistant"};
            $this->session->setItem('tValidation', $tValidation);
            header('Location: index.php?controleur=client&action=connexion');
            exit;
        } else {
            // S'il existe, on vérifie si le mot de passe correspond
            if(password_verify($motDePasse, $client->mot_de_passe)) {
                $this->session->regenererId();
                $this->session->setItem('client', $client);
                header('Location: '.$this->dernierePage);
                exit;
            } else {
                $tValidation['connexion']['valide'] = 'faux';
                $tValidation['connexion']['message'] = $this->tMessagesJson{"mot_de_passe"}{"incorrect"};
                $this->session->setItem('tValidation', $tValidation);
                header('Location: index.php?controleur=client&action=connexion');
                exit;
            }
        }
    }

    public function validerCourriel() {
        $client = Client::trouverParCourriel($_GET['courriel']);

        if($client == false) {
            $client = null;
            echo "Client inexistant!";
        } else {
            echo "Client existant!";
        }
    }

}
