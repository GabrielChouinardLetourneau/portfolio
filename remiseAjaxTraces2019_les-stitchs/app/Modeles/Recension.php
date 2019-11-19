<?php
/**
 * Created by PhpStorm.
 * User: marie-lidurand
 * Date: 2019-10-04
 * Time: 8:49 PM
 */
declare(strict_types = 1);
namespace App\Modeles;
use App\App;
use \PDO;

class Recension {

    // Attributs
    private $id = 0;
    private $date;
    private $titre;
    private $nom_media;
    private $nom_journaliste;
    private $description;
    private $livre_id;

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

    public static function trouverRecension(int $idLivre):array {
        $chaineRequete = "SELECT id, date, titre, nom_media, nom_journaliste, description, livre_id FROM recensions WHERE livre_id=:unIdLivre";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(":unIdLivre", $idLivre, PDO::PARAM_INT);
        $requete->setFetchMode(PDO::FETCH_CLASS, Recension::class);
        $requete->execute();
        $recensions = $requete->fetchAll();

        return $recensions;
    }


}
