<?php
declare(strict_types = 1);

namespace App\Controleurs;

use App\App;
use App\Utilitaires;


class ControleurFacturation {
    private $blade = null;
    private $session = null;
    private $tMessagesJson = null;

    public function __construct() {
        $this->blade = App::getInstance()->getBlade();
        $this->session = App::getInstance()->getSession();
        $this->panier = App::getInstance()->getSession();
        // $this->utilitaires = App::getInstance()->getUtilitaires(); --> DUNNO IF NEEEDED REALLY
    }

   public function valider():void {
        $tValidation = [];

        // Section Informations de paiement
        $tValidation = Utilitaires::validerGroupeBtnRadio('methodePaiement', $tValidation);
        $tValidation = Utilitaires::validerChamp('nom_complet', "#^[a-zA-Z-À-ÿ' -]+$#", $tValidation);
        $tValidation = Utilitaires::validerChamp('numeroCarte', "#^[6][0-9]{3}[ ]?[0-9]{4}[ ]?[0-9]{4}[ ]?[0-9]{4}$#", $tValidation);
        if($tValidation['numeroCarte']['valide'] == 'faux'){
            $tValidation = Utilitaires::validerChamp('numeroCarte', "#^[5][0-9]{3}[ ]?[0-9]{4}[ ]?[0-9]{4}[ ]?[0-9]{4}$#",$tValidation);
        } 
        if($tValidation['numeroCarte']['valide'] == 'faux'){
            $tValidation = Utilitaires::validerChamp('numeroCarte', "#[13][0-9]{3}[ ]?[0-9]{4}[ ]?[0-9]{4}[ ]?[0-9]{4}$#",$tValidation);
        }
       $tValidation = Utilitaires::validerChamp('code', "#^[0-9]{3}$#", $tValidation);
       $tValidation = Utilitaires::validerChamp('mois', "#^[0-9]{2}$#", $tValidation);
       $tValidation = Utilitaires::validerChamp('annee', "#^[0-9]{4}$#", $tValidation);

       if($tValidation['mois']['valide'] == 'vrai' && $tValidation['annee']['valide'] == 'vrai'){
            // chemin du fichier JSON
            $url = '../ressources/lang/fr_CA.UTF-8/messagesUtilisateurValidation.json'; 
            // introduit le contenu du JSON dans une variable
            $json = file_get_contents($url);
            // decode le fichier JSON
            $tMessagesJson = json_decode($json, true); 

            $tValidation = Utilitaires::validerDateExpiration($_POST['mois'], $_POST['annee'], $tMessagesJson, $tValidation);
        }

       // Section Adresse de facturation
       if($this->session->getItem('facturation')['adresseFacturation'] == "off") {
            $tValidation = Utilitaires::validerChamp('adresse', "#^[0-9]+[a-zA-ZÀ-ÿ0-9 \-]+$#", $tValidation);
            $tValidation = Utilitaires::validerChamp('ville', "#^[a-zA-ZÀ-ÿ \-]+$#", $tValidation);
            $tValidation = Utilitaires::validerChamp('province', "#^[A-Z]{2}$#", $tValidation);
            $tValidation = Utilitaires::validerChamp('code_postal', "#^[A-Z][0-9][A-Z]( )?[0-9][A-Z][0-9]$#", $tValidation);
        }

       // Tester si tous les champs sont valides dans le tableau de validation
       $sousTableau = array_column($tValidation, 'valide');
       $nonValide = in_array('faux', $sousTableau);
        var_dump($sousTableau);
        var_dump($nonValide);
       // Redirection dépendant de la validité
       if($nonValide) {
            $arrDonneesFacturation = array (
                "methodePaiement" => $_POST['methodePaiement'],
                "nom_complet" => $_POST['nom_complet'],
                "numeroCarte" => $_POST['numeroCarte'],
                "code" => $_POST['code'],
                "mois" => $_POST['mois'],
                "annee" => $_POST['annee'],
                "adresse" => $_POST['adresse'],
                "ville" => $_POST['ville'],
                "province" => $_POST['province'],
                "code_postal" => $_POST['code_postal'],
            );
            $this->session->setItem('facturation', $arrDonneesFacturation);

           $this->session->setItem('arrMessagesErreurs', $tValidation);

            // header('Location: index.php?controleur=facturation&action=afficher');
            // exit;
       }
       else {
            $arrDonneesFacturation = array (
                "methodePaiement" => $_POST['methodePaiement'],
                "nom_complet" => $_POST['nom_complet'],
                "numeroCarte" => $_POST['numeroCarte'],
                "code" => $_POST['code'],
                "mois" => $_POST['mois'],
                "annee" => $_POST['annee'],
                "adresse" => $_POST['adresse'],
                "ville" => $_POST['ville'],
                "province" => $_POST['province'],
                "code_postal" => $_POST['code_postal'],
            );
            $this->session->setItem('facturation', $arrDonneesFacturation);

           header('Location: index.php?controleur=validation&action=afficher');
           exit;
       }
   }

    public function afficher():void {
        if(isset($_SESSION["arrMessagesErreurs"])){
            //Récuérer tValidation provenant de la requête précédente
            $arrMessagesErreurs = $this->session->getItem('arrMessagesErreurs');

            // Supprimer tValidation de la session car spécifique à cette requête
            $this->session->supprimerItem('arrMessagesErreurs');
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

        switch ($this->session->getItem('livraison')['province']) {
            case 'AB':
                $provinceFormatee = 'Alberta';
                break;
            case 'BC':
                $provinceFormatee = 'Colombie-Britannique';
                break;
            case 'MB':
                $provinceFormatee = 'Manitoba';
                break;
            case 'NB':
                $provinceFormatee = 'Nouveau-Brunswick';
                break;
            case 'NS':
                $provinceFormatee = 'Nouvelle-Écosse';
                break;
            case 'SK':
                $provinceFormatee = 'Saskatchewan';
                break;
            case 'ON':
                $provinceFormatee = 'Ontario';
                break;
            case 'QC':
                $provinceFormatee = 'Québec';
                break;
            case 'NL':
                $provinceFormatee = 'Terre-Neuve et Labrador';
                break;
            case 'PE':
                $provinceFormatee = 'Île-du-Prince-Édouard';
                break;
            case 'NU':
                $provinceFormatee = 'Nunavut';
                break;
            case 'NT':
                $provinceFormatee = 'Territoires du Nord-Ouest';
                break;
            case 'YT':
                $provinceFormatee = 'Yukon';
                break;
            default:
                $provinceFormatee = 'Alberta';
                break; 
        }
        if(isset($_SESSION['facturation'])){
            $tDonnees = array (
                "nom" => $this->session->getItem('livraison')['nom'],
                "prenom" => $this->session->getItem('livraison')['prenom'],
                "adresseLivraison" => $this->session->getItem('livraison')['adresse'],
                "villeLivraison" => $this->session->getItem('livraison')['ville'],
                "provinceLivraison" => $provinceFormatee,
                "code_postalLivraison" => $this->session->getItem('livraison')['code_postal'],
                "adresseParDefaut" => $this->session->getItem('livraison')['adresseParDefaut'],
                "adresseFacturation" => $this->session->getItem('livraison')['adresseFacturation'],
                "courrielClient" => $this->session->getItem('client')->courriel,
                "telephoneClient" => $this->session->getItem('client')->telephone,
                "methodePaiement" => $this->session->getItem('facturation')['methodePaiement'],
                "nom_complet" => $this->session->getItem('facturation')['nom_complet'],
                "numeroCarte" => $this->session->getItem('facturation')['numeroCarte'],
                "code" => $this->session->getItem('facturation')['code'],
                "mois" => $this->session->getItem('facturation')['mois'],
                "annee" => $this->session->getItem('facturation')['annee'],
                "adresse" => $this->session->getItem('facturation')['adresse'],
                "ville" => $this->session->getItem('facturation')['ville'],
                "province" => $this->session->getItem('facturation')['province'],
                "code_postal" => $this->session->getItem('facturation')['code_postal']
            );
            $this->session->supprimerItem('facturation');
        }
        else {
            $tDonnees = array (
                "nom" => $this->session->getItem('livraison')['nom'],
                "prenom" => $this->session->getItem('livraison')['prenom'],
                "adresseLivraison" => $this->session->getItem('livraison')['adresse'],
                "villeLivraison" => $this->session->getItem('livraison')['ville'],
                "provinceLivraison" => $provinceFormatee,
                "code_postalLivraison" => $this->session->getItem('livraison')['code_postal'],
                "adresseParDefaut" => $this->session->getItem('livraison')['adresseParDefaut'],
                "adresseFacturation" => $this->session->getItem('livraison')['adresseFacturation'],
                "courrielClient" => $this->session->getItem('client')->courriel,
                "telephoneClient" => $this->session->getItem('client')->telephone,
                "methodePaiement" => "",
                "nom_complet" => "",
                "numeroCarte" => "",
                "code" => "",
                "mois" => "",
                "annee" => "",
                "expiration" => "",
                "adresse" => "",
                "ville" => "",
                "province" => "",
                "code_postal" => ""
            );    
        }
        $tDonnees = array_merge($tDonnees, array('tValidation' => $tValidation));
        // var_dump($arrMessagesErreurs);
        $tDonnees = array_merge($tDonnees, array('arrMessagesErreurs' => $arrMessagesErreurs));

        
        echo $this->blade->run('facturation', $tDonnees);
    }
}
?>
