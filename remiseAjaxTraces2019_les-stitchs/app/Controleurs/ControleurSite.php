<?php
declare(strict_types=1);

namespace App\Controleurs;

use App\App;
use App\Modeles\Actualites;
use App\Modeles\Auteur;
use App\Modeles\Livre;
use App\Utilitaires;

class ControleurSite
{

    private $blade = null;
    private $session = null;
    private $utilitaires = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
        $this->session = App::getInstance()->getSession();
        $this->utilitaires = App::getInstance()->getUtilitaires();

    }

    public function accueil(): void
    {
        $actualites = Actualites::trouverTout();
        $nouveautes = Livre::trouverLesNouveautes();
        $coupsDeCoeur = Livre::trouverLivreCoupDeCoeur();

        $utilitaire = $this->utilitaires;
        $panier = App::getInstance()->getSessionPanier();

        $client = $this->session->getItem('client');

        $tDonnees = array("nomPage"=>"Accueil");
        $tDonnees = array_merge($tDonnees, array("actualites"=>$actualites));
        $tDonnees = array_merge($tDonnees, array("utilitaire"=>$utilitaire));
        $tDonnees = array_merge($tDonnees, array("nouveautes"=>$nouveautes));
        $tDonnees = array_merge($tDonnees, array("coupsDeCoeur"=>$coupsDeCoeur));
        $tDonnees = array_merge($tDonnees, array("panier" => $panier));
        $tDonnees = array_merge($tDonnees, array("client" => $client));

        echo $this->blade->run("accueil",$tDonnees);
    }

    public function apropos():void
    {
        $tDonnees = array("nomPage"=>"À propos");
        echo $this->blade->run("apropos",$tDonnees); 
    }


    public function nousjoindre():void
    {
        $tDonnees = array("nomPage"=>"Nous joindre");
        echo $this->blade->run("accueil",$tDonnees); 
    }

    public function trouverAuteursParChamp() {

        $auteur = "";
        if (isset($_POST['auteur'])) {
            $auteur = $_POST['auteur'];
        }

        $arrResultats = array();
        if($auteur !== ""){
            $arrResultats = Auteur::trouverParNom($auteur);
        }

        $tDonnees = array("arrResultats" => $arrResultats);
        echo $this->blade->run("fragments.recherche", $tDonnees);
    }
}

