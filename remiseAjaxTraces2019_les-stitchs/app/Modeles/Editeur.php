<?php
/**
 * Created by PhpStorm.
 * User: marie-lidurand
 * Date: 2019-10-05
 * Time: 9:42 PM
 */

declare(strict_types = 1);

namespace App\Modeles;

use App\App;
use \PDO;

class Editeur {
    // Attributs
    private $id;
    private $nom;
    private $url;

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

    public static function trouverEditeurs(int $idLivre):array {
        $chaineRequete = "SELECT * FROM editeurs INNER JOIN editeurs_livres ON editeurs.id = editeurs_livres.editeur_id WHERE editeurs_livres.livre_id= :unIdLivre";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(":unIdLivre", $idLivre, PDO::PARAM_INT);
        $requete->setFetchMode(PDO::FETCH_CLASS, Editeur::class);
        $requete->execute();
        $editeurs = $requete->fetchAll();

        return $editeurs;
    }
}