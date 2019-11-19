<?php

declare(strict_types=1);

namespace App; 

use App\Controleurs\ControleurFacturation;
use App\Controleurs\ControleurSite;
use App\Controleurs\ControleurLivre;
use App\Controleurs\ControleurPanier;
use App\Controleurs\ControleurClient;
use App\Controleurs\ControleurLivraison;
use App\Controleurs\ControleurValidation;
use App\Courriels\CourrielConfirmation;
use \PDO;
use eftec\bladeone\BladeOne;
use App\Session\SessionPanier;


class App
{
    private static $instance = null;
    private $pdo = null;
    private $blade = null;
    private $session = null;
    private $cookie = null;
    private $utilitaires = null;

    private function __construct()
    {
    }

    public static function getInstance(): App
    {
        if (App::$instance === null) {
            App::$instance = new App();
        }
        return App::$instance;
    }

    public function demarrer():void
    {
        $this->getSession()->demarrer();
        $this->configurerEnvironnement();
        $this->routerLaRequete();
    }

    private function configurerEnvironnement():void
    {
        if($this->getServeur() === 'serveur-local'){
            error_reporting(E_ALL | E_STRICT);
        }
        date_default_timezone_set('America/Montreal');

    }



    public function getPDO():PDO
    {
        // C'est plus performant en ram de récupérer toujours la même connexion PDO dans toute l'application.
        if($this->pdo === null)
        {
            if($this->getServeur() === 'serveur-local')
            {
                $maConnexionBD = new ConnexionBD('localhost','root','root','19_rpni3_les_stitchs');
                $this->pdo = $maConnexionBD->getNouvelleConnexionPDO();
            }else if($this->getServeur() === 'serveur-production'){
                // echo "Erreur: Vous devez configurer la connexion du serveur de production (timunix2).";
                $maConnexionBD = new ConnexionBD('localhost','19_lesstitchs','canardbleu','19_rpni3_les_stitchs');
                $this->pdo = $maConnexionBD->getNouvelleConnexionPDO();
            }
        }
        return $this->pdo;
    }


    public function getBlade():BladeOne
    {
        if($this->blade === null){
            $cheminDossierVues = '../ressources/vues';
            $cheminDossierCache = '../ressources/cache';
            $this->blade = new BladeOne($cheminDossierVues,$cheminDossierCache,BladeOne::MODE_AUTO);
        }
        return $this->blade;
    }

    public function getSession(): Session
    {
        if($this->session === null){
            $this->session = new Session();
        }
        return $this->session;
    }

    public function getCookie(): Cookie
    {
        if($this->cookie === null){
            $this->cookie = new Cookie();
        }
        return $this->cookie;
    }

    public function getUtilitaires():Utilitaires {
        if($this->utilitaires === null) {
            $this->utilitaires = new Utilitaires();
        }
        return $this->utilitaires;
    }

    public function getFilAriane():FilAriane {
        $filAriane = null;
        if($this->session->getItem('filAriane') == null) {
            $filAriane = new FilAriane();
        }
        else {
            $filAriane = $this->session->getItem('filAriane');
        }

        return $filAriane;
    }

    public function getSessionPanier() {
        $monPanier = $this->getSession()->getItem('panier');

        if($monPanier === null) {
            $monPanier = new SessionPanier();
        }
        return $monPanier;
    }



    public function getServeur(): string
    {
        // Vérifier la nature du serveur (local VS production)
        $env = 'null';
        if ((substr($_SERVER['HTTP_HOST'], 0, 9) == 'localhost') ||
            (substr($_SERVER['HTTP_HOST'], 0, 7) == '192.168')  ||
            (substr($_SERVER['SERVER_ADDR'], 0, 7) == '192.168'))
        {
            $env = 'serveur-local';
        } else {
            $env = 'serveur-production';
        }
        return $env;
    }


    public function routerLaRequete():void
    {
        $controleur = null;
        $action = null;

        // Déterminer le controleur responsable de traiter la requête
        if (isset($_GET['controleur'])){
            $controleur = $_GET['controleur'];
        }else{
            $controleur = 'site';
        }

        // Déterminer l'action du controleur
        if (isset($_GET['action'])){
            $action = $_GET['action'];
        }else{
            $action = 'accueil';
        }

        // Instantier le bon controleur selon la page demandée
        if ($controleur === 'site'){
            $this->monControleur = new ControleurSite();
            switch ($action) {
                case 'accueil':
                    $this->monControleur->accueil();
                    break;
                case 'apropos':
                    $this->monControleur->aPropos();
                    break;
                case 'trouverAuteursParChamp':
                    $this->monControleur->trouverAuteursParChamp();
                    break;    
                default:
                    $this->erreur404();
            }
        }else if($controleur === 'livre') {
            $this->monControleur = new ControleurLivre();
            switch ($action) {
                case 'catalogue':
                    $this->monControleur->catalogue();
                    break;
                case 'fiche':
                    $this->monControleur->fiche();
                    break;
                default:
                    $this->erreur404();  
            }
        } elseif($controleur === 'panier') {
            $this->monControleur = new ControleurPanier();
            switch($action) {
                case 'ajouterItem':
                    echo 'ajouterItem';
                    $this->monControleur->ajouterItem();
                    break;
                case 'supprimerItem':
                    $this->monControleur->supprimerItem();
                    break;
                case 'majQuantite':
                    $this->monControleur->majQuantite();
                    break;
                case 'majModeLivraison':
                    $this->monControleur->majModeLivraison();
                    break;
                case 'fiche':
                    $this->monControleur->fiche();
                    break;
                default:
                    $this->erreur404();
            }

        } elseif($controleur === 'client') {
            $this->monControleur = new ControleurClient();
            switch($action) {
                case 'connexion':
                    $this->monControleur->connexion();
                    break;
                case 'creation':
                    $this->monControleur->creation();
                    break;
                case 'validerClient':
                    $this->monControleur->validerClient();
                    break;
                case 'validerCourriel':
                    $this->monControleur->validerCourriel();
                    break;
                case 'inserer':
                    $this->monControleur->inserer();
                    break;
                case 'deconnexion':
                    $this->monControleur->deconnexion();
                    break;
                default:
                    $this->erreur404();
            }
        } elseif($controleur === "livraison") {
            $this->monControleur = new ControleurLivraison();
            switch($action) {
                case 'afficher':
                    $this->monControleur->afficher();
                    break;
                case 'valider':
                    $this->monControleur->valider();
                    break;
                default:
                    $this->erreur404();
            }
        } elseif($controleur === "facturation") {
            $this->monControleur = new ControleurFacturation();
            switch($action) {
                case 'afficher':
                    $this->monControleur->afficher();
                    break;
                case 'valider':
                    $this->monControleur->valider();
                    break;
                default:
                    $this->erreur404();
            }
        } elseif($controleur === "validation") {
            $this->monControleur = new ControleurValidation();
            switch($action) {
                case 'afficher':
                    $this->monControleur->afficher();
                    break;
                case 'insererBd':
                    $this->monControleur->insererBd();
                    break;
                default:
                    $this->erreur404();
            }
        } elseif($controleur === "confirmation") {
            $this->monControleur = new CourrielConfirmation();
            switch($action) {
                case 'afficher':
                    $this->monControleur->afficher();
                    break;
                default:
                    $this->erreur404();
            }
        } else {
            $this->erreur404();
        }
    }

    public function erreur404():void {
        $panier = $this->getSessionPanier();
        $client = $this->session->getItem('client');

        $tDonnees = array("nomPage"=>"Erreur 404");
        $tDonnees = array_merge($tDonnees, array("client" => $client)); 
        $tDonnees = array_merge($tDonnees,array("panier"=>$panier));
        echo $this->blade->run("erreur404",$tDonnees); 
    }


}