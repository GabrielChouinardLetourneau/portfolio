<?php
declare(strict_types=1);

namespace App;

use App\Modeles\Categories;
use App\Modeles\Livre;

class FilAriane
{

    private $session = null;

    public function __construct()
    {
        $this->session = App::getInstance()->getSession();
    }

    public static function majFilArianne(): array{
        $fil=array();

        //Si le contrôleur est défini
        if(isset($_GET["controleur"])){

            //Si le contrôleur n'est pas celui du site, nous sommes au deuxième niveau
            if($_GET["controleur"] !== 'site') {
                switch(true){
                    //Si l'action est d'afficher une liste de livres
                    case  $_GET["action"] === 'catalogue' :
                        //Lien de retour vers l'accueil
                        $lien0=array("titre"=>"Accueil","lien"=>"index.php?controleur=site&action=accueil");
                        //@todo adapter cet algo pour les catéries...

                        if(isset($_GET["id_categorie"])) {
                            $idCategorie = $_GET['id_categorie'];

                            $lien1 = array("titre" => Categories::trouverCategorie((int)$idCategorie)->nom_fr, "lien" => "index.php?controleur=livre&action=catalogue&id_categorie=$idCategorie");
                        }
                        elseif((isset($_GET["parution_id"]))) {
                            if($_GET["parution_id"] == 3) {
                                $lien1=array("titre"=>"Nouveautés");
                            }
                        }else{
                            $lien1=array("titre"=>"Catalogue");
                        }

                        $fil[0] = $lien0;
                        $fil[1] = $lien1;
                    break;

                    //Si l'action d'afficher une fiche de livre
                    case  $_GET["action"] === 'fiche' :

                        //Lien de retour vers l'accueil
                        $lien0=array("titre"=>"Accueil","lien"=>"index.php?controleur=site&action=accueil");

                        //Lien vers la liste des pages se qualifiant (catégorie, nouveauté...)

                        //@todo adapter cet algo pour les catéries...
                        if(isset($_GET["id_categorie"])) {
                            $idCategorie = $_GET['id_categorie'];

                            $lien1 = array("titre" => Categories::trouverCategorie((int)$idCategorie)->nom_fr, "lien" => "index.php?controleur=livre&action=catalogue&id_categorie=$idCategorie");
                        }
                        else if(isset($_GET["parution_id"])) {
                            if($_GET["parution_id"] == 3) {
                                $lien1=array("titre"=>"Nouveautés","lien"=>"index.php?controleur=livre&action=catalogue&parution_id=".$_GET["parution_id"]);
                            }
                            else {
                                $lien1=array("titre"=>"Catalogue","lien"=>"index.php?controleur=livre&action=catalogue");
                            }
                        }else{
                            $lien1=array("titre"=>"Catalogue","lien"=>"index.php?controleur=livre&action=catalogue");
                        }

                        $fil[0] = $lien0;
                        $fil[1] = $lien1;

                        if(isset($_GET["isbn"])) {
                        $livre = Livre::trouverParIsbn($_GET["isbn"]);
                        $utilitaire = App::getInstance()->getUtilitaires();
                       $titreLivreModifiee = $utilitaire->formaterTitreLivre($livre->titre);
                        $fil[2] = array("titre" => $titreLivreModifiee);
                    }
                        break;
                }
            }
        }
        return $fil;
    }

    // Getter / Setter (magique)

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}