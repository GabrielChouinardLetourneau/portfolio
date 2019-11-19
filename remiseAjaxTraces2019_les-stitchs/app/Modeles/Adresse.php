<?php

declare(strict_types = 1);

namespace App\Modeles\Transaction;

use App\App;
use \PDO;

class Adresse {

    // Attributs
    private $id_adresse;
    private $prenom;
    private $nom;
    private $adresse;
    private $ville;
    private $province;
    private $codePostal;

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

    public static function trouver(int $unIdClient):?Client {
        $chaineRequete = "SELECT * FROM transaction_client WHERE id_client =:idClient";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(':idClient', $unIdClient, PDO::PARAM_INT);
        $requete->setFetchMode(PDO::FETCH_CLASS, Client::class);
        $requete->execute();
        $client = $requete->fetch();
        return $client;
    }

    public static function trouverParCourriel($unCourriel):?Client {
        $chaineRequete = "SELECT prenom, nom, courriel, telephone, mot_de_passe FROM transaction_client WHERE courriel =:courriel";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(':courriel', $unCourriel, PDO::PARAM_STR);
        $requete->setFetchMode(PDO::FETCH_CLASS, Client::class);
        $requete->execute();
        $client = $requete->fetch();
        if($client == false) {
            $client = null;
        }
        return $client;
    }

    public function insererNouvelleAdresse() {
        $chaineRequete = "INSERT INTO adresse (adresse, prenom, nom, ville, code_postal, est_defaut, type,abbr_province) VALUES (:adresse, :prenom, :nom, :ville, :code_postal, :est_defaut, :type,:abbr_province)";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(':prenom',$this->mot_de_passe,PDO::PARAM_STR, 255);
        $requete->bindParam(':nom',$this->telephone,PDO::PARAM_STR, 255);
        $requete->bindParam(':adresse',$this->courriel,PDO::PARAM_STR,255);
        $requete->bindParam(':ville',$this->prenom,PDO::PARAM_STR,100);
        $requete->bindParam(':code_postal',$this->nom,PDO::PARAM_STR, 7);
        $requete->bindParam(':est_defaut',$this->nom,PDO::PARAM_INT,1);
        $requete->bindParam(':type',$this->nom,PDO::PARAM_STR, enum('livraison', 'facturation'));
        $requete->bindParam(':abbr_province',$this->nom,PDO::PARAM_STR, 3);

        $requete->execute();
        $id = App::getInstance()->getPDO()->lastInsertId();
        $this->id_adresse = $id;
    }

}