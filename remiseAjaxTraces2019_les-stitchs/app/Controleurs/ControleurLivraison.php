<?php
declare(strict_types = 1);

namespace App\Controleurs;

use App\App;
use App\Utilitaires;
use App\Controleurs\ControleurSite;


class ControleurLivraison {

    private $blade = null;
    private $session = null;
    private $tMessagesJson = null;

    public function __construct() {
        $this->blade = App::getInstance()->getBlade();
        $this->session = App::getInstance()->getSession();
    }

    public function valider():void {
        $tValidation = [];

        $tValidation = Utilitaires::validerChamp('nom', "#^[a-zA-ZÀ-ÿ' -]+$#", $tValidation);
        $tValidation = Utilitaires::validerChamp('prenom', "#^[a-zA-ZÀ-ÿ' -]+$#", $tValidation);
        $tValidation = Utilitaires::validerChamp('adresse', "#^[0-9]+[a-zA-ZÀ-ÿ0-9 \-]+$#", $tValidation);
        $tValidation = Utilitaires::validerChamp('ville', "#^[a-zA-ZÀ-ÿ \-]+$#", $tValidation);
        $tValidation = Utilitaires::validerChamp('province', "#^[A-Z]{2}$#", $tValidation);
        $tValidation = Utilitaires::validerChamp('code_postal', "#^[A-Z][0-9][A-Z]( )?[0-9][A-Z][0-9]$#", $tValidation);


        // Tester si tous les champs sont valides dans le tableau de validation
        $sousTableau = array_column($tValidation, 'valide');
        $nonValide = in_array('faux', $sousTableau);


        // Redirection dépendant de la validité
        if($nonValide) {
            $this->session->setItem('arrMessagesErreurs', $tValidation);

            $arrDonneesLivraison = array (
                "nom" => $_POST['nom'],
                "prenom" => $_POST['prenom'],
                "adresse" => $_POST['adresse'],
                "ville" => $_POST['ville'],
                "province" => $_POST['province'],
                "code_postal" => $_POST['code_postal'],
                "adresseParDefaut" => $valeurCheckboxAdresseDefaut,
                "adresseFacturation" => $valeurCheckboxAdresseFacturation
            );
            $this->session->setItem('livraison', $arrDonneesLivraison);

            header('Location: index.php?controleur=livraison&action=afficher');
            exit;
        }
        else { 
            // Si toutes les entrées sont alides
            // Envoi de l'adresse de livraison dans la session ($_SESSION)
            if($_POST['adresseParDefaut'] == "on") {
                $valeurCheckboxAdresseDefaut = TRUE;
            }
            else {     
                $valeurCheckboxAdresseDefaut = FALSE;
            }


            if($_POST['adresseFacturation'] == "on") {
                $valeurCheckboxAdresseFacturation = TRUE;
                $arrDonneesFacturation = array(
                    "adresse" => $_POST['adresse'],
                    "ville" => $_POST['ville'],
                    "province" => $_POST['province'],
                    "code_postal" => $_POST['code_postal'],
                );
                $this->session->setItem('facturation', $arrDonneesFacturation);
            }
            else {     
                $valeurCheckboxAdresseFacturation = FALSE;
            }
            $arrDonneesLivraison = array (
                "nom" => $_POST['nom'],
                "prenom" => $_POST['prenom'],
                "adresse" => $_POST['adresse'],
                "ville" => $_POST['ville'],
                "province" => $_POST['province'],
                "code_postal" => $_POST['code_postal'],
                "adresseParDefaut" => $valeurCheckboxAdresseDefaut,
                "adresseFacturation" => $valeurCheckboxAdresseFacturation
            );
            if($arrDonneesLivraison['adresseFacturation'] == "on") {
                $arrDonneesLivraisonFacturation = array (
                    "nom" => $_POST['nom'],
                    "prenom" => $_POST['prenom'],
                    "adresse" => $_POST['adresse'],
                    "ville" => $_POST['ville'],
                    "province" => $_POST['province'],
                    "code_postal" => $_POST['code_postal'],
                    "adresseParDefaut" => $valeurCheckboxAdresseDefaut,
                    "adresseFacturation" => $valeurCheckboxAdresseFacturation
                );
                $this->session->setItem('livraisonFacturation', $arrDonneesLivraisonFacturation);
            }
            $this->session->setItem('livraison', $arrDonneesLivraison);
            header('Location: index.php?controleur=facturation&action=afficher');
            exit;
        }
    }

    public function afficher():void {
        if($this->session->getItem('arrMessagesErreurs')) {
            $arrMessagesErreurs = $this->session->getItem('arrMessagesErreurs');
        }
        else {
            $arrMessagesErreurs = NULL;
        }

        if(isset($_SESSION["tValidation"])){
            //Récuérer tValidation provenant de la requête précédente
            $tValidation = $this->session->getItem('tValidation');

            // Supprimer tValidation de la session car spécifique à cette requête
            $this->session->supprimerItem('tValidation');
        }
        else {
            $tValidation = [];
        }

        $tDonnees = array(
            "nom" => $this->session->getItem('livraison')['nom'],
            "prenom" => $this->session->getItem('livraison')['prenom'],
            "adresse" => $this->session->getItem('livraison')['adresse'],
            "ville" => $this->session->getItem('livraison')['ville'],
            "province" => $this->session->getItem('livraison')['province'],
            "code_postal" => $this->session->getItem('livraison')['code_postal']
        );
        $tDonnees = array_merge($tDonnees, array('tValidation' => $tValidation));
        $tDonnees = array_merge($tDonnees, array('arrMessagesErreurs' => $arrMessagesErreurs));

        echo $this->blade->run('livraison', $tDonnees);
    }
}
?>