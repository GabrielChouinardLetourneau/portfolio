<?php

/**
 * @file Méthodes et fonctions utilisées pour les catégories, utilisées dans l'Accueil, la page Catalogue et les fiches de livre
 * @author Gabriel Chouinard Létourneau <chouinardletourneaug@gmail.com> / Marie-Li Durand <_____> / Élody Levasseur-Côté <_____>
 * @version Post-prototype
 */

declare(strict_types=1);

namespace app\Controleurs;

use App\App;
use App\FilAriane;
use App\Modeles\Collection;
use App\Modeles\Editeur;
use App\Modeles\Honneur;
use App\Modeles\Recension;
use App\Session;
use App\Modeles\Livre;
use App\Modeles\Categories;
use App\Utilitaires;

class ControleurLivre
{
    private $blade = null;
    private $utilitaires = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
        $this->session = App::getInstance()->getSession();
        $this->utilitaires = App::getInstance()->getUtilitaires();
    }

    /**
     * Function gérant le contrôleur Livre lié à l'action Catalogue
    */
    public function catalogue(): void{
        if(isset($_GET['page']) == true) {
            $noPage = $_GET['page'];
        } else {
            $noPage = 0;
        }

        if(isset($_GET['id_categorie']) == true) {
            $idCategorie = intval($_GET['id_categorie']);
        } else {
            $idCategorie = 0;
        }

        if(isset($_GET['parution_id']) == true) {
            $idParution = intval($_GET['parution_id']);
        } else {
            $idParution = 0;
        }

        //Implémenter la vérification RegExp pour améliorer la sécurité 

        $ordre = '';
        $tri = '';

        if (isset($_POST['tri'])){
            $valeurTri = $_POST['tri'];
            switch ($valeurTri) {
                case 'asc$':
                    $ordre = 'ASC';
                    $tri = 'prix';
                    break;
                case 'des$':
                    $ordre = 'DESC';
                    $tri = 'prix';
                    break;
                case 'ZA':
                    $ordre = 'DESC';
                    $tri = 'titre';
                    break;
                default:
                    $ordre = 'ASC';
                    $tri = 'titre';
            }
        }
        else{
            $ordre = 'ASC';
            $tri = 'titre';
        }    

        $nbMaxLivreParPage = 9;
        $toutesCategories = Categories::trouverToutesCategoriesFr();
        $nbTotalLivre = Livre::compterNbLivres();
        $indexCourant = $noPage * $nbMaxLivreParPage;
        $nbTotalPage = ceil($nbTotalLivre/$nbMaxLivreParPage)-1;
        $urlPagination = "index.php?controleur=livre&action=catalogue";
        $utilitaire = $this->utilitaires;

        // Trouver les livres dans la limite demandée
        if($idCategorie != 0 && $idParution != 3){
            $livres = Livre::filtrerLivres($idCategorie, $indexCourant, $nbMaxLivreParPage, $ordre, $tri);
        }
        else if($idParution == 3){
            $livres = Livre::trouverNouveauxLivres($indexCourant,$nbMaxLivreParPage, $ordre, $tri);
        }

        else {
            $livres = Livre::chercherTousLivres($indexCourant,$nbMaxLivreParPage, $ordre, $tri);
        }
        // Générer le fil d'Ariane
        $filAriane = FilAriane::majFilArianne();

        $panier = App::getInstance()->getSessionPanier();

        $client = $this->session->getItem('client');



        // Générer le tableau de données
        $tDonnees = array("livres" => $livres);
        $tDonnees = array_merge($tDonnees, array("numeroPage" => $noPage));
        $tDonnees = array_merge($tDonnees, array("toutesCategories" => $toutesCategories));
        $tDonnees = array_merge($tDonnees, array("nombreTotalPages" => $nbTotalPage));
        $tDonnees = array_merge($tDonnees, array("urlPagination" => $urlPagination));
        $tDonnees = array_merge($tDonnees, array("idCategorieActuelle" => $idCategorie));
        $tDonnees = array_merge($tDonnees, array("idParutionActuelle" => $idParution));
        $tDonnees = array_merge($tDonnees, array("filAriane" => $filAriane));
        $tDonnees = array_merge($tDonnees, array("utilitaire" => $utilitaire));
        $tDonnees = array_merge($tDonnees, array("panier"=>$panier));
        $tDonnees = array_merge($tDonnees, array("client" => $client));

        echo $this->blade->run("livres.index",$tDonnees);
    }

    /**
     * Function gérant le contrôleur Livre lié à l'action Fiche
    */
    public function fiche():void
    {
        // Vérifier s'il n'y a pas de caractères bizarres ?
        if(isset($_GET['isbn']) == true) {
            $isbn = $_GET['isbn'];
        } else {
            $isbn = 0;
        }

        if(isset($_GET['id']) == true) {
            $idLivre = $_GET['id'];
        } else {
            $idLivre = 0;
        }


        $livre = Livre::trouverParIsbn((string)$isbn);

        // Permet de trouver la couverture du livre
        $strISBN10 = $livre->isbn;
        $strISBN13 = "L".$this->utilitaires->ISBNToEAN($strISBN10)."1";
        $nomfichier="../ressources/liaisons/images/couverture_livres_optim/".$strISBN13;
        $nomFichierComplet = $nomfichier . "_w320.jpg";



        if (!file_exists($nomFichierComplet)) {
            $nomfichier="../ressources/liaisons/images/couverture_alternative.svg";
        }

        $recensions = Recension::trouverRecension((int)$idLivre);
        $honneurs = Honneur::trouverHonneurs((int)$idLivre);
        $editeurs = Editeur::trouverEditeurs((int)$idLivre);
        $livresInteresses = Livre::trouverLivresInteresses((int)$livre->getCategories()[0]->id, (int)$idLivre);
        $descriptionCoupee = $this->utilitaires->reduireTexte($livre->description, 500);
        $descriptionDeuxiemePartie = $this->utilitaires->obtenirDeuxiemePartieTexte($livre->description, $descriptionCoupee);
        $utilitaire = $this->utilitaires;

        $filAriane = FilAriane::majFilArianne();

        $panier = App::getInstance()->getSessionPanier();

        $client = $this->session->getItem('client');


        $tDonnees = array("nomPage"=>"Fiche");
        $tDonnees = array_merge($tDonnees, array("livre"=>$livre));
        $tDonnees = array_merge($tDonnees, array("recensions"=>$recensions));
        $tDonnees = array_merge($tDonnees, array("honneurs"=>$honneurs));
        $tDonnees = array_merge($tDonnees, array("editeurs"=>$editeurs));
        $tDonnees = array_merge($tDonnees, array("nomFichier" => $nomfichier));
        $tDonnees = array_merge($tDonnees, array("livresInteresses" => $livresInteresses));
        $tDonnees = array_merge($tDonnees, array("descriptionCoupee" => $descriptionCoupee));
        $tDonnees = array_merge($tDonnees, array("utilitaire" => $utilitaire));
        $tDonnees = array_merge($tDonnees, array("descriptionDeuxiemePartie" => $descriptionDeuxiemePartie));
        $tDonnees = array_merge($tDonnees, array("filAriane" =>$filAriane));
        $tDonnees = array_merge($tDonnees, array("panier"=>$panier));
        $tDonnees = array_merge($tDonnees, array("client" => $client));

        echo $this->blade->run("livres.fiche",$tDonnees);
        $panier->setLivre(null);
    }

}
