<?php
declare(strict_types = 1);

namespace App\Controleurs;

use App\App;
use App\Session\SessionPanier;
use App\Panier;
use App\Modeles\Adresse;

class ControleurValidation {

    private $blade = null;
    private $session = null;
    private $utilitaires = null;
    private $panier = null;
    private $adresse = null;
    private $adresseDefaut = null;

    public function __construct() {
        $this->blade = App::getInstance()->getBlade();
        $this->session = App::getInstance()->getSession();
        $this->utilitaires = App::getInstance()->getUtilitaires();
        $this->panier = App::getInstance()->getSessionPanier();
        $this->panier = App::getInstance()->getSessionPanier();

    }


    public function afficher(): void {
        switch ($this->session->getItem('livraison')['province']) {
            case 'AB':
                $provinceLivraisonFormatee = 'Alberta';
                break;
            case 'BC':
                $provinceLivraisonFormatee = 'Colombie-Britannique';
                break;
            case 'MB':
                $provinceLivraisonFormatee = 'Manitoba';
                break;
            case 'NB':
                $provinceLivraisonFormatee = 'Nouveau-Brunswick';
                break;
            case 'NS':
                $provinceLivraisonFormatee = 'Nouvelle-Écosse';
                break;
            case 'SK':
                $provinceLivraisonFormatee = 'Saskatchewan';
                break;
            case 'ON':
                $provinceLivraisonFormatee = 'Ontario';
                break;
            case 'QC':
                $provinceLivraisonFormatee = 'Québec';
                break;
            case 'NL':
                $provinceLivraisonFormatee = 'Terre-Neuve et Labrador';
                break;
            case 'PE':
                $provinceLivraisonFormatee = 'Île-du-Prince-Édouard';
                break;
            case 'NU':
                $provinceLivraisonFormatee = 'Nunavut';
                break;
            case 'NT':
                $provinceLivraisonFormatee = 'Territoires du Nord-Ouest';
                break;
            case 'YT':
                $provinceLivraisonFormatee = 'Yukon';
                break;
            default:
                $provinceLivraisonFormatee = 'Alberta';
                break;
        }

        switch ($this->session->getItem('facturation')['province']) {
            case 'AB':
                $provinceFacturationFormatee = 'Alberta';
                break;
            case 'BC':
                $provinceFacturationFormatee = 'Colombie-Britannique';
                break;
            case 'MB':
                $provinceFacturationFormatee = 'Manitoba';
                break;
            case 'NB':
                $provinceFacturationFormatee = 'Nouveau-Brunswick';
                break;
            case 'NS':
                $provinceFacturationFormatee = 'Nouvelle-Écosse';
                break;
            case 'SK':
                $provinceFacturationFormatee = 'Saskatchewan';
                break;
            case 'ON':
                $provinceFacturationFormatee = 'Ontario';
                break;
            case 'QC':
                $provinceFacturationFormatee = 'Québec';
                break;
            case 'NL':
                $provinceFacturationFormatee = 'Terre-Neuve et Labrador';
                break;
            case 'PE':
                $provinceFacturationFormatee = 'Île-du-Prince-Édouard';
                break;
            case 'NU':
                $provinceFacturationFormatee = 'Nunavut';
                break;
            case 'NT':
                $provinceFacturationFormatee = 'Territoires du Nord-Ouest';
                break;
            case 'YT':
                $provinceFacturationFormatee = 'Yukon';
                break;
            default:
                $provinceFacturationFormatee = 'Alberta';
                break;
        }

        $numeroCarteFormate = $this->utilitaires->formaterNumeroCarte($this->session->getItem('facturation')['numeroCarte']);

        $methodePaiementFormatee = $this->utilitaires->formaterMethodePaiement($this->session->getItem('facturation')['methodePaiement']);
        
        if($this->session->getItem('livraison')['adresseParDefaut'] == "on"){
            $this->adresseDefaut = 1;
        }
        else {
            $this->adresseDefaut = 0;
        }

        if($this->session->getItem('livraisonFacturation')){
            $tDonnees = array(
                "nom" => $this->session->getItem('livraison')['nom'],
                "prenom" => $this->session->getItem('livraison')['prenom'],
                "adresseLivraison" => $this->session->getItem('livraison')['adresse'],
                "villeLivraison" => $this->session->getItem('livraison')['ville'],
                "provinceLivraison" => $provinceLivraisonFormatee,
                "code_postalLivraison" => $this->session->getItem('livraison')['code_postal'],
                "adresseParDefaut" => $this->session->getItem('livraison')['adresseParDefaut'],
                "adresseFacturation" => $this->session->getItem('livraison')['adresseFacturation'],
                "courrielClient" => $this->session->getItem('client')->courriel,
                "telephoneClient" => $this->session->getItem('client')->telephone,
                "methodePaiement" => $methodePaiementFormatee,
                "nom_complet" => $this->session->getItem('facturation')['nom_complet'],
                "numeroCarte" => $numeroCarteFormate,
                "codeSecurite" => $this->session->getItem('facturation')['code'],
                "mois" => $this->session->getItem('facturation')['mois'],
                "annee" => $this->session->getItem('facturation')['annee'],
                "adresseFacturation" => $this->session->getItem('livraisonFacturation')['adresse'],
                "villeFacturation" => $this->session->getItem('livraisonFacturation')['ville'],
                "provinceFacturation" => $provinceFacturationFormatee,
                "code_postalFacturation" => $this->session->getItem('livraisonFacturation')['code_postal']
            );
        }
        else {
            $tDonnees = array(
                "nom" => $this->session->getItem('livraison')['nom'],
                "prenom" => $this->session->getItem('livraison')['prenom'],
                "adresseLivraison" => $this->session->getItem('livraison')['adresse'],
                "villeLivraison" => $this->session->getItem('livraison')['ville'],
                "provinceLivraison" => $provinceLivraisonFormatee,
                "code_postalLivraison" => $this->session->getItem('livraison')['code_postal'],
                "adresseParDefaut" => $this->session->getItem('livraison')['adresseParDefaut'],
                "adresseFacturation" => $this->session->getItem('livraison')['adresseFacturation'],
                "courrielClient" => $this->session->getItem('client')->courriel,
                "telephoneClient" => $this->session->getItem('client')->telephone,
                "methodePaiement" => $methodePaiementFormatee,
                "nom_complet" => $this->session->getItem('facturation')['nom_complet'],
                "numeroCarte" => $numeroCarteFormate,
                "codeSecurite" => $this->session->getItem('facturation')['code'],
                "mois" => $this->session->getItem('facturation')['mois'],
                "annee" => $this->session->getItem('facturation')['annee'],
                "adresseFacturation" => $this->session->getItem('facturation')['adresse'],
                "villeFacturation" => $this->session->getItem('facturation')['ville'],
                "provinceFacturation" => $provinceFacturationFormatee,
                "code_postalFacturation" => $this->session->getItem('facturation')['code_postal']
            );
        }

        $tDonnees = array_merge($tDonnees, array("panier" => $this->panier));
        $tDonnees = array_merge($tDonnees, array("utilitaire" => $this->utilitaires));

        echo $this->blade->run('validation', $tDonnees);

    }

    public function insererBd(): void {

        //Section non fini et commenter pour ne pas contrevenir avec la confirmation d'Élody (Mandat A)
        // 
        // $clientId = $this->session->getItem('client')->id;

        // if($this->session->getItem('livraisonFacturation')){
        //     $adresseLivraison = $this->session->getItem('livraisonFacturation')['adresse'];
        // }
        // else {
        //     $adresseLivraison = $this->session->getItem('livraison')['adresse'];
            
        // }
        // $adresseLivraison = new Adresse();

        // $adresseLivraison->__set('adresse', $adresseLivraison);
        // $adresseLivraison->__set('prenom', $this->session->getItem('livraison')['prenom']);
        // $adresseLivraison->__set('nom', $this->session->getItem('livraison')['nom']);
        // $adresseLivraison->__set('ville', $this->session->getItem('livraison')['ville']);
        // $adresseLivraison->__set('abbr_province', $this->session->getItem('livraison')['province']);
        // $adresseLivraison->__set('code_postal', $this->session->getItem('livraison')['code_postal']);
        // $adresseLivraison->__set('type', 'livraison');
        // $adresseLivraison->__set('est_defaut', $this->adresseDefaut);

        // $adresseLivraison->insererNouvelleAdresse();

        // if($this->session->getItem('livraisonFacturation')) {
        //     $adresseFacturation = new Adresse();

        //     $adresseFacturation->__set('adresse', $this->session->getItem('livraisonFacturation')['adresse']);
        //     $adresseFacturation->__set('prenom', $this->session->getItem('livraisonFacturation')['prenom']);
        //     $adresseFacturation->__set('nom', $this->session->getItem('livraisonFacturation')['nom']);
        //     $adresseFacturation->__set('ville', $this->session->getItem('livraisonFacturation')['ville']);
        //     $adresseFacturation->__set('abbr_province', $this->session->getItem('livraisonFacturation')['province']);
        //     $adresseFacturation->__set('code_postal', $this->session->getItem('livraisonFacturation')['code_postal']);
        //     $adresseFacturation->__set('type', 'facturation');
        //     $adresseFacturation->__set('est_defaut', 0);
    
        //     $adresseFacturation->insererNouvelleAdresse();
    
        // }
        // else {
        //     $adresseFacturation = new Adresse();

        //     $adresseFacturation->__set('adresse', $this->session->getItem('facturation')['adresse']);
        //     $adresseFacturation->__set('prenom', $this->session->getItem('facturation')['prenom']);
        //     $adresseFacturation->__set('nom', $this->session->getItem('facturation')['nom']);
        //     $adresseFacturation->__set('ville', $this->session->getItem('facturation')['ville']);
        //     $adresseFacturation->__set('abbr_province', $this->session->getItem('facturation')['ville']);
        //     $adresseFacturation->__set('code_postal', $this->session->getItem('facturation')['code_postal']);
        //     $adresseFacturation->__set('type', 'facturation');
        //     $adresseFacturation->__set('est_defaut', 0);
    
        //     $adresseFacturation->insererNouvelleAdresse();
        // }

        // if($this->session->getItem('facturation')['modePaiement'] == "paypal") {
        //     $est_paypal = 1;
        // }
        // else {
        //     $est_paypal = 0;
        // }

        // $numeroCarte = $this->session->getItem('facturation')['numeroCarte'];
        // if(substr($numeroCarte, 0, 1) == "6") {
        //     $type_carte = "VISA";
        // }
        // elseif(substr($numeroCarte, 0, 1) == "5") {
        //     $type_carte = "Master Card";
        // }
        // else {
        //     $type_carte = "American Express";
        // }

        // $dateExpiration = $this->session->getItem('annee') . "-" . $this->session->getItem('mois') . "-01";

        // $modePaiement = new ModePaiement();

        // $modePaiement->__set('est_paypal', $est_paypal);
        // $modePaiement->__set('nom_complet', $this->session->getItem('facturation')['nom_complet']);
        // $modePaiement->__set('no_carte', $this->session->getItem('facturation')['numeroCarte']);
        // $modePaiement->__set('type_carte', $type_carte);
        // $modePaiement->__set('date_expiration_carte', $dateExpiration);
        // $modePaiement->__set('code', $this->session->getItem('facturation')['code']);
        // $modePaiement->__set('est_defaut', 0);

        // $modePaiement->insererModePaiment();


        // $this->session->supprimerItem('tValidation');
        
        header('Location: index.php?controleur=confirmation&action=afficher');
        exit;
    }
}

?>