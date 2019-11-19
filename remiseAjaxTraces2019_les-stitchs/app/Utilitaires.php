<?php
declare(strict_types = 1);
namespace App;

use \datetime;

class Utilitaires {
/**
* @file Méthodes utilitaires
* @author Élody Levasseur-Côté et Marie-Li Durand
* @version 5.1.1
*/

    public function __construct() {
    }

    /**
     * @method ISBNToEAN
     * @desc Convertit un ISBN en format EAN
     * @param string - ISBN à convertir
     * @return string - ISBN converti en EAN, ou FALSE si erreur dans le format ou la conversion
     */
    public function ISBNToEAN ($strISBN) {
        $myFirstPart = $mySecondPart = $myEan = $myTotal = "";
        if ($strISBN == "")
            return false;
        $strISBN = str_replace("-", "", $strISBN);
        // ISBN-10
        if (strlen($strISBN) == 10)
        {
            $myEan = "978" . substr($strISBN, 0, 9);
            $myFirstPart = intval(substr($myEan, 1, 1)) + intval(substr($myEan, 3, 1)) + intval(substr($myEan, 5, 1)) + intval(substr($myEan, 7, 1)) + intval(substr($myEan, 9, 1)) + intval(substr($myEan, 11, 1));
            $mySecondPart = intval(substr($myEan, 0, 1)) + intval(substr($myEan, 2, 1)) + intval(substr($myEan, 4, 1)) + intval(substr($myEan, 6, 1)) + intval(substr($myEan, 8, 1)) + intval(substr($myEan, 10, 1));
            $tmp = intval(substr((string)(3 * $myFirstPart + $mySecondPart), -1));
            $myControl = ($tmp == 0) ? 0 : 10 - $tmp;

            return $myEan . $myControl;
        }
        // ISBN-13
        else if (strlen($strISBN) == 13) return $strISBN;
        // Autre
        else return false;
    }

    /**
     * @method reduireTexte
     * @desc Réduit le texte après une certaine longueur
     * @param {string} texte - texte original
     * @param {int} longueur -
     * @return
     */
    public function reduireTexte(string $texte, int $longueur):string {
        $texteFin = substr($texte, 0, $longueur);
        $fin = strrpos($texteFin, ' ');
        $texteCouper = $fin? substr($texteFin, 0, $fin) : substr($texteFin, 0);
        $texteCouper = $texteCouper."...";
        return $texteCouper;
    }

    public function formaterNumeroCarte($numeroCarte):string {
        $numeroCarteFormatee = substr_replace($numeroCarte, "XXXX XXXX XXXX ", 0, 12);

        return $numeroCarteFormatee;
    }

    public function formaterMethodePaiement($methodePaiement):string {
        if($methodePaiement == "carteCredit") {
            $methodePaiementFormatee = "carte de crédit";
            return $methodePaiementFormatee;
        } else {
            return "Paypal";
        }
    }

    public function obtenirDeuxiemePartieTexte(string $texteOriginal, string $texteCoupe):string {

        $longueurTexteCoupe = strlen($texteCoupe);

        return substr($texteOriginal, $longueurTexteCoupe-2);
    }

    public function verifierNomFichierImage(string $nomFichier, $unLivre):string{
       if(!file_exists($nomFichier)) {
           $nomFichierUrl="../ressources/liaisons/images/couverture_alternative.svg";

       }
       else {
           $nomFichierUrl = $nomFichier;
          // $nomFichierUrl = "../ressources/liaisons/images/couverture_livres_optim/L".$this->ISBNToEAN($unLivre->isbn)."1";
       }

       return $nomFichierUrl;
    }

    /*
     * Fonction utilitaire qui permet de formater les noms d'un ou des auteurs d'un livre.
     */
    public function formaterNomsAuteurs(string $nomsAuteur, array $arrNomsAuteurs):string {
        $nouveauNomsAuteur = "";

        // S'il n'y a qu'un auteur
        if($nomsAuteur == $arrNomsAuteurs[count($arrNomsAuteurs)-1]->getNomPrenom()) {
            $nouveauNomsAuteur = $nomsAuteur;
        }
        else {
            $nouveauNomsAuteur = $nomsAuteur . ",";
        }

        return $nouveauNomsAuteur;
    }

    /*
     * Fonction utilitaire qui permet de formater le titre de livre
     *
     */
    public function formaterTitreLivre(string $nomLivreOriginal):string {
        $positionParentheseOuvrante = 0;
        $positionParentheseFermee = 0;
        $nomLivreModifiee = "";

        // Si le nom du livre contient une parenthèse ouvrante
        if(strpos($nomLivreOriginal, "(") != false) {
            // Trouve la position de la dernière parenthèse ouvrante du titre
            $positionParentheseOuvrante = strripos($nomLivreOriginal, "(");
            // Trouve la position de la dernière parenthèse fermante du titre
            $positionParentheseFermee = strripos($nomLivreOriginal, ")");
            // Trouve la première lettre du titre
            $premiereLettre = $nomLivreOriginal[0];
            // Trouve ce qui a à l'intérieur des parenthèses
            $nomLivreModifiee = substr($nomLivreOriginal, $positionParentheseOuvrante + 1, ($positionParentheseFermee - $positionParentheseOuvrante)-1 );
            // Modifie le titre
            $nomLivreModifiee = $nomLivreModifiee . " " .strtolower($premiereLettre).substr($nomLivreOriginal, 1, $positionParentheseOuvrante-1);

            // S'il reste des caractères après la parenthèse fermante
            if(strlen($nomLivreOriginal) -1 != $positionParentheseFermee) {
                $nomLivreModifiee = $nomLivreModifiee . substr($nomLivreOriginal, $positionParentheseFermee+1, strlen($nomLivreOriginal)-1);
            }

            return $nomLivreModifiee;

        } else {

            return $nomLivreOriginal;
        }
    }

    /*
     * Fonction utilitaire qui permet de formater la date
     */
    public function formaterDate(string $uneDate):string {
        // Indique le fuseau horaire
        setlocale(LC_TIME, "fr_CA");
        // Transforme la date reçue en paramètre temps UNIX
        $date = strtotime($uneDate);
        // Formate la date
        $dateFormater = strftime("%A, %d %B %G", $date);
        return $dateFormater;
    }
    /*
     * Fonction utilitaire qui permet de formater le prix.
     */
    public function formaterPrix(float $unPrix):string {
        setlocale(LC_MONETARY, 'fr_CA');
        return money_format('%.2n', $unPrix);
    }

    /*
     * Fonction utilitaire qui permet de valider les champs des formulaires
     *
     * Paramètre
     */
    public static function validerChamp(string $nomChamp, string $motif, array $unTableauValidation, bool $accepterValeurVideOuInexistante=false) {
        // chemin du fichier JSON
        $url = '../ressources/lang/fr_CA.UTF-8/messagesUtilisateurValidation.json'; 
        // introduit le contenu du JSON dans une variable
        $json = file_get_contents($url);
        // decode le fichier JSON
        $tMessagesJson = json_decode($json, true); 
        $valeurPost = '';
        $valide = 'faux';
        $message = '';
        if(isset($_POST[$nomChamp])) {
            //Si le champ existe dans POST
            // trim enlève les caractères entourant ce qu'il y a dans le POST
            $valeurPost = trim($_POST[$nomChamp]);
            // var_dump($_POST[$nomChamp]);

            if($valeurPost == '' || $valeurPost == "aaaa" || $valeurPost == "mm"  || $valeurPost == 'defaut') {

                if($nomChamp == "mois") {
                    $message = $tMessagesJson['expiration']['type']['mois'];
                    // var_dump($_POST[$nomChamp]);

                }
                elseif($nomChamp == "annee") {
                    $message = $tMessagesJson['expiration']['type']['annee'];
                }
                elseif($nomChamp == "mois" && $nomChamp == "annee") {
                    $message = $tMessagesJson['expiration']['vide'];
                }
                else{
                    //Si vide
                    $message = $tMessagesJson[$nomChamp]['vide'];
                }
            } else {
                //Si pas vide
                $trouve = preg_match($motif, $_POST[$nomChamp]);
                // echo $nomChamp;
                if(!$trouve) {
                    if($nomChamp == "mois" || $nomChamp == "annee") {
                        $message = $tMessagesJson['expiration']['pattern'];
                    }
                    else {
                        $message = $tMessagesJson[$nomChamp]['pattern'];
                    }
                } 
                else {
                    $valide = 'vrai';
                }
            }
        } else {
            //Si le champ n'existe pas dans $_POST
            if($accepterValeurVideOuInexistante){
                $valide = 'vrai';
            } else {
                $message = $tMessagesJson[$nomChamp]['vide'];
            }
        }
        $unTableauValidation[$nomChamp] = ['valeur'=>$valeurPost, 'valide'=>$valide, 'message'=>$message];
        return $unTableauValidation;
    }


   public static function validerDateExpiration(string $mois, string $annee, array $unTableauMessagesJson, array $unTableauValidation) {
        if(checkdate(intval($mois), 01, intval($annee))) {
            $dateEntree = new DateTime($annee . "-" . $mois . "-01");
            $dateAuj = new DateTime();

            if($dateAuj < $dateEntree) {
                $valide = 'vrai';
                $message = '';
            }
            else {
                $valide = 'faux';
                $message = $unTableauMessagesJson['expiration']['expire'];
            }
        }
        else {
            //Formate date invalide
            $valide = 'faux';
            $message = $unTableauMessagesJson['expiration']['pattern'];
        }

        $unTableauValidation["expiration"] = ['annee_expir'=>$_POST[$annee], 'mois_expir'=>$_POST[$mois], 'valide'=>$valide, 'message'=>$message];
        return $unTableauValidation;
    }

    public static function validerGroupeBtnRadio(string $nomGroupeBtn, array $arrValidation, bool $accepterValeurVideOuInexistante=false):array {
        // chemin du fichier JSON
        $url = '../ressources/lang/fr_CA.UTF-8/messagesUtilisateurValidation.json'; 
        // introduit le contenu du JSON dans une variable
        $json = file_get_contents($url);
        // decode le fichier JSON
        $arrMessagesJson = json_decode($json, true); 
        $valeur = "";
        $valide = 'faux';
        $message = '';

        // Si le groupe existe dans $_POST
        if(isset($_POST[$nomGroupeBtn])) {
            // Si groupe présent dans $_POST
            // Valide
            $valide = 'vrai';
            $message = '';
            $valeur=$_POST[$nomGroupeBtn];
        }
        else {
            // Si pas dans $_POST et pas obligatoire
            if($accepterValeurVideOuInexistante) {
                // Choix valide
                $valide = 'vrai';
                $message = '';
            }
            else {
                // Si pas dans $_POST et obligatoire, invalide
                $valide = 'faux';

                // Message d'erreur vide
                $message = $arrMessagesJson[$nomGroupeBtn]['vide'];
            }
        }
        $arrValidation[$nomGroupeBtn] = ['valeur' => $valeur, 'valide' => $valide, 'message' =>$message];
        return $arrValidation;
    }
}
?>
