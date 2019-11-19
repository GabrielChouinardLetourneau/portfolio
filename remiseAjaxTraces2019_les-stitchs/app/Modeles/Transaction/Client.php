<?php

declare(strict_types = 1);

namespace App\Modeles\Transaction;

use App\App;
use \PDO;

class Client {

    // Attributs
    private $id_client;
    private $prenom;
    private $nom;
    private $courriel;
    private $telephone;
    private $mot_de_passe;

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

    public function insererNouveauClient() {
        $chaineRequete = "INSERT INTO transaction_client (courriel, mot_de_passe, prenom, nom, telephone) VALUES (:courriel, :mot_de_passe, :prenom, :nom, :telephone)";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(':courriel',$this->courriel,PDO::PARAM_STR,255);
        $requete->bindParam(':mot_de_passe',$this->mot_de_passe,PDO::PARAM_STR,255);
        $requete->bindParam(':telephone',$this->telephone,PDO::PARAM_STR,10);
        $requete->bindParam(':prenom',$this->prenom,PDO::PARAM_STR,255);
        $requete->bindParam(':nom',$this->nom,PDO::PARAM_STR,255);
        $requete->execute();
        $id = App::getInstance()->getPDO()->lastInsertId();
        $this->id_client = $id;
    }

}