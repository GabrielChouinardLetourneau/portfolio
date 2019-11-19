<?php
/**
 * Created by PhpStorm.
 * User: marie-lidurand
 * Date: 2019-09-12
 * Time: 2:38 PM
 */
declare(strict_types = 1);

namespace App\Modeles;

use App\App;
use \PDO;

class Parution {

    // Attributs
    private $id = 0;
    private $etat = "";

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

    public static function trouver($unIdParution):Parution {
        $chaineRequete = "SELECT * FROM parutions WHERE parutions.id=:unIdParution";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(":unIdParution", $unIdParution, PDO::PARAM_INT);
        $requete->setFetchMode(PDO::FETCH_CLASS, Parution::class);
        $requete->execute();
        $parution = $requete->fetch();

        return $parution;
    }

}