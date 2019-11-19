<?php
/**
 * Created by PhpStorm.
 * User: marie-lidurand
 * Date: 2019-10-05
 * Time: 8:32 PM
 */

/**
 * @file Modèle Categories contenant les méthodes et fonctions utilisées pour les catégories, utilisées dans la page Catalogue et les fiches de livre
 * @author Gabriel Chouinard Létourneau <chouinardletourneaug@gmail.com> / Marie-Li Durand <_____>
 * @version Post-prototype
 */

declare(strict_types = 1);
namespace App\Modeles;

use App\App;
use \PDO;

class Categories {
    // Attributs
    private $id;
    private $nom_fr;
    private $nom_en;

    // Constructeur
    public function __construct() {

    }

    // Getter/setter magiques
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

    public static function trouverToutesCategoriesFr():array {
        $chaineRequete = "SELECT id, nom_fr FROM categories";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->setFetchMode(PDO::FETCH_CLASS, Categories::class);
        $requete->execute();
        $toutesCategories = $requete->fetchAll();

        return $toutesCategories;
    }

    public static function trouverCategories(int $idLivre):array {
        $chaineRequete = "SELECT categories.id, categories.nom_fr, categories.nom_en FROM categories INNER JOIN categories_livres ON categories.id = categories_livres.categorie_id WHERE categories_livres.livre_id =:unIdLivre";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(":unIdLivre", $idLivre, PDO::PARAM_INT);
        $requete->setFetchMode(PDO::FETCH_CLASS, Categories::class);
        $requete->execute();
        $categories = $requete->fetchAll();

        return $categories;
    }

    public static function trouverCategorie(int $idCategorie):Categories {
        $chaineRequete = "SELECT nom_fr FROM categories WHERE id =:unIdCategorie";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(":unIdCategorie", $idCategorie, PDO::PARAM_INT);
        $requete->setFetchMode(PDO::FETCH_CLASS, Categories::class);
        $requete->execute();
        $categorie = $requete->fetch();

       // print_r($categorie);

        return $categorie;
    }




}
