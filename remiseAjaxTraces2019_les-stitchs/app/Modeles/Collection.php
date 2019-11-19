<?php
/**
 * Created by PhpStorm.
 * User: marie-lidurand
 * Date: 2019-10-05
 * Time: 8:14 PM
 */
declare(strict_types = 1);
namespace App\Modeles;

use App\App;
use \PDO;
class Collection {
    // Attributs
    private $id;
    private $nom;
    private $description;

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

    public static function trouverCollection(int $idCollection){
        $chaineRequete = "SELECT * FROM collections WHERE id=:unIdCollection";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(":unIdCollection", $idCollection, PDO::PARAM_INT);
        $requete->setFetchMode(PDO::FETCH_CLASS, Collection::class);
        $requete->execute();
        $collection = $requete->fetch();

        return $collection;

    }

}