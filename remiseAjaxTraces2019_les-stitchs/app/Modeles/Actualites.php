<?php

declare(strict_types = 1);

namespace App\Modeles;

use App\App;
use \PDO;

class Actualites {
    // Attributs
    private $id;
    private $date;
    private $titre;
    private $texte;
    private $id_auteur;

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

    public static function trouverTout():array{
        $chaineRequete = "SELECT * FROM actualites LIMIT 3";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->setFetchMode(PDO::FETCH_CLASS, Actualites::class);
        $requete->execute();
        $actualites = $requete->fetchAll();

        return $actualites;
    }

    public function getAuteur():Auteur {
        return Auteur::trouverParId($this->id_auteur);
    }


}