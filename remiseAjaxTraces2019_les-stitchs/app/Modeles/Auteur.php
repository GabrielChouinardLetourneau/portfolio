<?php

declare(strict_types = 1);

namespace App\Modeles;

use App\App;

use \PDO;

class Auteur {
    // Attributs
    private $id;
    private $nom;
    private $prenom;
    private $biographie;
    private $url_blogue;

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

    public static function trouverParLivre($unIdLivre):array{
        $chaineRequete = "SELECT auteurs.id, auteurs.nom, auteurs.prenom, auteurs.biographie, auteurs.url_blogue FROM auteurs INNER JOIN auteurs_livres ON auteurs.id = auteurs_livres.auteur_id WHERE auteurs_livres.livre_id = :unIdLivre";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(':unIdLivre', $unIdLivre, PDO::PARAM_INT);
        $requete->setFetchMode(PDO::FETCH_CLASS, Auteur::class);
        $requete->execute();
        $auteurs = $requete->fetchAll();

        return $auteurs;
    }

    public static function trouverParId($unIdAuteur):Auteur {
        $chaineRequete = "SELECT nom, prenom FROM auteurs WHERE id=:unIdAuteur";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(':unIdAuteur', $unIdAuteur, PDO::PARAM_INT);
        $requete->setFetchMode(PDO::FETCH_CLASS, Auteur::class);
        $requete->execute();
        $auteur = $requete->fetch();

        return $auteur;
    }

    public static function trouverParNom($nom) {
        $chaineRequete = "SELECT prenom, nom FROM auteurs WHERE nom LIKE '%".$nom."%'";

        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);

        $requete->setFetchMode(PDO::FETCH_CLASS, Auteur::class);
        $requete->execute();
        $auteur = $requete->fetchAll();
        return $auteur;
    }

    public function getNomPrenom():string {
        $nomComplet = $this->prenom ." ". $this->nom;
        return $nomComplet;
    }
}
