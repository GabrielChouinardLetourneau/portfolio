<?php
/**
 * Created by PhpStorm.
 * User: marie-lidurand
 * Date: 2019-10-04
 * Time: 9:09 PM
 */

declare(strict_types = 1);
namespace App\Modeles;

use App\App;
use \PDO;

class Honneur {

    // Attributs
    private $id;
    private $nom;
    private $description;

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

    public static function trouverHonneurs(int $idLivre):array {
        $chaineRequete = "SELECT * FROM honneurs INNER JOIN honneurs_livres ON honneurs.id = honneurs_livres.honneur_id WHERE honneurs_livres.livre_id =:unIdLivre";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(":unIdLivre", $idLivre, PDO::PARAM_INT);
        $requete->setFetchMode(PDO::FETCH_CLASS, Honneur::class);
        $requete->execute();
        $honneurs = $requete->fetchAll();

        return $honneurs;
        var_dump("allo" . $honneurs);
    }


}