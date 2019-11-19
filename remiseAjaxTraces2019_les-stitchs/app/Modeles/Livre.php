<?php

/**
 * @file Modèle Livre contant les méthodes et fonctions utilisées pour les catégories, utilisées dans l'Accueil, la page Catalogue et les fiches de livre
 * @author Gabriel Chouinard Létourneau <chouinardletourneaug@gmail.com> / Marie-Li Durand <_____> / Élody Levasseur-Côté <_____>
 * @version Post-prototype
 */

declare(strict_types = 1);

namespace App\Modeles;

use App\App;
use \PDO;
use App\Modeles\Parution;
use App\Modeles\Auteur;

class Livre
{
    private $id = 0;
    private $titre = "";
    private $nbre_pages = 0;
    private $est_illustre= false;
    private $annee_publication = 0;
    private $langue = "";
    private $prix = 0;
    private $sous_titre = "";
    private $mots_cles = "";
    private $isbn = "";
    private $description = "";
    private $autres_caracteristiques = "";
    private $est_coup_de_coeur = false;
    private $parution_id = 0;
    private $collection_id = 0;
    //private static $arrLivres = [];

    public function __construct() {

    }

    public function __get($property) {
        if(property_exists($this,$property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if(property_exists($this,$property)) {
            $this->$property = $value;
        }
    }

    public function getParution():Parution {
        return Parution::trouver($this->parution_id);
    }

    public function getAuteurs():array {
        return Auteur::trouverParLivre($this->id);
    }

    public function getCollection():Collection {
        if($this->collection_id !== null) {
            return Collection::trouverCollection((int)$this->collection_id);
        }
    }

    public function getCategories():array {
        return Categories::trouverCategories((int)$this->id);
    }

    public static function trouverLivre(int $idLivre):Livre {
        $chaineRequete = "SELECT * FROM livres WHERE id=:unIdLivre";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(':unIdLivre', $idLivre, PDO::PARAM_INT);
        $requete->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        $requete->execute();
        $livre = $requete->fetch();

        return $livre;
    }

    //Méthode appelée lorsque l'on veut filtrer les filtrer par catégorie
    public static function filtrerLivres(int $idCategorie, int $unIndex, int $uneQte, $ordre, $tri):array {
        $chaineRequete = "SELECT DISTINCT livres.id, titre, prix, isbn, description, parution_id
                                    FROM livres 
                                    INNER JOIN categories_livres ON livres.id = categories_livres.livre_id 
                                    INNER JOIN categories ON categories_livres.categorie_id = categories.id 
                                    WHERE categories_livres.categorie_id =:idCategorie 
                                    ORDER BY " . $tri . '  ' . $ordre . "
                                    LIMIT $unIndex,$uneQte";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
        $requete->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        $requete->execute();
        $livres = $requete->fetchAll();


        return $livres;
    }


    public static function chercherTousLivres(int $unIndex, int $uneQte, $ordre, $tri):array {
        $chaineRequete = "SELECT DISTINCT id, titre, prix, isbn, description, parution_id
                                    FROM livres 
                                    ORDER BY " . $tri . '  ' . $ordre . " 
                                    LIMIT $unIndex,$uneQte";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        $requete->execute();
        $livres = $requete->fetchAll();

        return $livres;
    }

    public static function trouverLivreCoupDeCoeur():array {
        $chaineRequete = "SELECT * FROM livres WHERE est_coup_de_coeur=1 LIMIT 4";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        $requete->execute();
        $livresCoupDeCoeur = $requete->fetchAll();

        return $livresCoupDeCoeur;
    }

    public static function trouverNouveauxLivres(int $unIndex, int $uneQte, $ordre, $tri):array {
        $chaineRequete = "SELECT * FROM livres WHERE parution_id = 3 ORDER BY " . $tri . '  ' . $ordre . " 
        LIMIT $unIndex,$uneQte";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        $requete->execute();
        $nouveauxLivres = $requete->fetchAll();

        return $nouveauxLivres;
    }

    public static function trouverLesNouveautes():array {
        $chaineRequete = "SELECT livres.id, livres.nbre_pages, livres.est_illustre, livres.annee_publication, livres.langue, livres.prix, livres.titre, livres.sous_titre, livres.mots_cles, livres.isbn, livres.description, livres.autres_caracteristiques, livres.est_coup_de_coeur, livres.parution_id, livres.collection_id FROM livres INNER JOIN parutions ON livres.parution_id = parutions.id WHERE etat = 'Nouveauté' LIMIT 10";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        $requete->execute();
        $livresNouveautes = $requete->fetchAll();

        return $livresNouveautes;
    }

    public static function trouverLivresInteresses(int $idCategorie, int $idLivre):array {
        $chaineRequete = "SELECT livres.id, livres.nbre_pages, livres.est_illustre, livres.annee_publication, livres.langue, livres.prix, livres.titre, livres.sous_titre, livres.isbn, livres.description, livres.autres_caracteristiques, livres.parution_id, livres.collection_id FROM livres INNER JOIN categories_livres ON livres.id = categories_livres.livre_id WHERE categories_livres.categorie_id =:unIdCategorie AND categories_livres.livre_id <>:unIdLivre LIMIT 0,10";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(":unIdCategorie", $idCategorie,PDO::PARAM_INT);
        $requete->bindParam(":unIdLivre", $idLivre, PDO::PARAM_INT);
        $requete->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        $requete->execute();
        $livresInteresses = $requete->fetchAll();

        return $livresInteresses;

    }

    public static function trouverParIsbn(string $isbnLivre):Livre {
        $chaineRequete = "SELECT * from livres WHERE isbn =:unIsbnLivre";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(":unIsbnLivre", $isbnLivre,PDO::PARAM_STR);
        $requete->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        $requete->execute();
        $livre = $requete->fetch();

        return $livre;
    }

    public static function compterNbLivres():int {
        $chaineRequete = "SELECT COUNT('id') AS nbLivres FROM livres";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->execute();
        $arrLivres = $requete->fetch();

        return (int) $arrLivres['nbLivres'];
    }

}
