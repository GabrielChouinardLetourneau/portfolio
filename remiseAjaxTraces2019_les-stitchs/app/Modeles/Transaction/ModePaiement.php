<?php

declare(strict_types = 1);

namespace App\Modeles\Transaction;

use App\App;
use \PDO;

class ModePaiement {

    // Attributs
    private $id_mode_paiement;
    private $est_paypal;
    private $nom_complet;
    private $no_carte;
    private $date_expiration_carte;
    private $code;
    private $est_defaut;

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

    public function insererModePaiment() {
        $chaineRequete = "INSERT INTO transaction_mode_paiement (est_paypal, nom_complet, no_carte, type_carte, date_expiration_carte, code, est_defaut) VALUES (:est_paypal, :nom_complet, :no_carte, :type_carte, :date_expiration_carte, :code, :est_defaut)";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(':est_paypal',$this->mot_de_passe,PDO::PARAM_INT, 1);
        $requete->bindParam(':nom_complet',$this->telephone,PDO::PARAM_STR,100);
        $requete->bindParam(':no_carte',$this->courriel,PDO::PARAM_INT, 20);
        $requete->bindParam(':type_carte',$this->prenom,PDO::PARAM_STR, enum('VISA', 'Master Card', 'American Express'));
        $requete->bindParam(':date_expiration_carte',$this->nom,PDO::PARAM_STR, date);
        $requete->bindParam(':code',$this->nom,PDO::PARAM_INT,10);
        $requete->bindParam(':est_defaut',$this->nom,PDO::PARAM_INT, 1);

        $requete->execute();
        $id = App::getInstance()->getPDO()->lastInsertId();
        $this->id_mode_paiement = $id;
    }

}