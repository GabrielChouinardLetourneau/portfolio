<?php
/**
 * Created by PhpStorm.
 * User: marie-lidurand
 * Date: 2019-11-10
 * Time: 7:14 PM
 */

declare(strict_types = 1);

namespace App\Modeles\Transaction;

use App\App;
use PDO;


class ModeLivraison {

    // Attributs
    private $id_mode_livraison;
    private $date_mise_a_jour;
    private $mode_livraison;
    private $base;
    private $par_item;
    private $delai;
    private $delai_max_jrs;

    public function __construct()
    {
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

    public static function trouverModeLivraison(string $modeLivraison):ModeLivraison {
        $chaineRequete = "SELECT id_mode_livraison, date_mise_a_jour, mode_livraison, base, par_item, delai, delai_max_jrs FROM transaction_mode_livraison WHERE mode_livraison = :unModeLivraison";
        $requete = App::getInstance()->getPDO()->prepare($chaineRequete);
        $requete->bindParam(":unModeLivraison", $modeLivraison, PDO::PARAM_STR);
        $requete->setFetchMode(PDO::FETCH_CLASS, ModeLivraison::class);
        $requete->execute();
        $modeLivraison = $requete->fetch();

        return $modeLivraison;
    }





}



?>