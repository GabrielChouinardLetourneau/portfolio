<?php
/**
 * Created by PhpStorm.
 * User: marie-lidurand
 * Date: 2019-10-08
 * Time: 10:37 AM
 */

declare(strict_types = 1);

namespace App\Controleurs;

use App\App;
use App\Modeles\Livre;
use App\Modeles\Transaction\ModeLivraison;


class ControleurPanier {

    private $blade = null;
    private $session = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
        $this->session = App::getInstance()->getSession();
    }

    /*
     * Cette méthode permet de faire ajouter un item dans le panier.
     */
    public function ajouterItem():void {

        $panier = App::getInstance()->getSessionPanier();

        // Vérification du ISBN
        if(isset($_GET['isbn'])) {
            if(preg_match("#^[0-9]-[0-9]{4,6}-[0-9]{2,4}-[0-9a-zA-Z]{1,2}$#", $_GET['isbn'])) {
                $isbn = $_GET['isbn'];
            }
        } else {
            $isbn = -1;
        }

        // Vérification de la quantité
        if(isset($_POST['quantite'])) {
            if(preg_match("#^[0-9]{1,2}$#", $_POST['quantite'])) {
                $quantite = $_POST['quantite'];
            }
        } else {
            $quantite = -1;
        }


        $livre = Livre::trouverParIsbn((string)$isbn);

        $panier->ajouterItem($livre, (int)$quantite);

       header('Location: index.php?controleur=livre&action=fiche&isbn=' . $isbn . '&quantite=' . $quantite);
       exit;
    }

    /*
     * Cette méthode permet de faire supprimer un item du panier.
     */
    public function supprimerItem():void {

        // Vérification du ISBN
        if(isset($_GET['isbn'])) {
            if(preg_match("#^[0-9]-[0-9]{4,6}-[0-9]{2,4}-[0-9a-zA-Z]{1,2}$#", $_GET['isbn'])) {
                $isbn = $_GET['isbn'];
            }
        }
        else {
            $isbn = -1;
        }

        $panier = App::getInstance()->getSessionPanier();
        $utilitaire = App::getInstance()->getUtilitaires();
        $session = App::getInstance()->getSession();

        $panier->supprimerItem((string)$isbn);

        $items = $panier->getItems();

        $client = $this->session->getItem('client');

        $tDonnees = array("items" => $items);
        $tDonnees = array_merge($tDonnees, array("panier" => $panier));
        $tDonnees = array_merge($tDonnees, array("client" => $client));
        $tDonnees = array_merge($tDonnees, array("utilitaire"=> $utilitaire));

        echo $this->blade->run("panier",$tDonnees);

    }

    /*
     * Cette méthode permet de faire mettre à jour la quantité d'un item du panier.
     */
    public function majQuantite():void {
        if(isset($_GET['sansJs'])) {
            if($_GET['sansJs'] == true) {
                // Vérification de la quantité
                if(isset($_POST['quantite'])) {
                    if(preg_match("#^[0-9]{1,2}$#", $_POST['quantite'])) {
                        $quantite = $_POST['quantite'];
                    }
                } else {
                    $quantite = -1;
                }

                // Vérification du ISBN
                if(isset($_GET['isbn'])) {
                    if(preg_match("#^[0-9]-[0-9]{4,6}-[0-9]{2,4}-[0-9a-zA-Z]{1,2}$#", $_GET['isbn'])) {
                        $isbn = $_GET['isbn'];
                    }

                } else {
                    $isbn = -1;
                }


                $panier = App::getInstance()->getSessionPanier();

                $panier->setQuantiteItem((string)$isbn, (int)$quantite);

                if($panier->getMontantSousTotal() < 50) {
                    $modeLivraison = "standard";
                }
                else {
                    $modeLivraison = "gratuit";
                }

                $panier->setModeLivraison($modeLivraison);

                if(isset($_GET['vue'])) {
                    header('Location: index.php?controleur=validation&action=afficher');
                }
                else {
                    header('Location: index.php?controleur=panier&action=fiche');
                }


                exit;

            }
        }
        else {
            if(isset($_GET['choixQuantite'])) {
                if(preg_match("#^[0-9]{1,2}$#", $_GET['choixQuantite'])) {
                    $quantite = $_GET['choixQuantite'];
                }
            } else {
                $quantite = -1;
            }

            // Vérification du ISBN
            if(isset($_GET['isbn'])) {
                $valeurIsbn = $_GET['isbn'];
                $valeurIsbn = strstr($valeurIsbn, $valeurIsbn[2]);
                if(preg_match("#^[0-9]-[0-9]{4,6}-[0-9]{2,4}-[0-9a-zA-Z]{1,2}$#", $valeurIsbn)) {
                    $isbn = $valeurIsbn;
                }

            } else {
                $isbn = -1;
            }


            $panier = App::getInstance()->getSessionPanier();
            $utilitaire = App::getInstance()->getUtilitaires();

            $panier->setQuantiteItem((string)$isbn, (int)$quantite);
            $montantSousTotal = $utilitaire->formaterPrix($panier->getMontantSousTotal());

            if($panier->getMontantSousTotal() < 50) {
                $modeLivraison = "standard";
            }
            else {
                $modeLivraison = "gratuit";
            }

            $panier->setModeLivraison($modeLivraison);

            $montantTps = $utilitaire->formaterPrix($panier->getMontantTPS());
            $montantTotal = $utilitaire->formaterPrix($panier->getMontantTotal());
            $montantTotalItem = $utilitaire->formaterPrix($panier->getMontantTotalItem((string)$isbn));
            $nbTotalArticles = $panier->getNombreTotalItems();
            $montantModeLivraison = $utilitaire->formaterPrix($panier->getMontantModeLivraison());
            $modeLivraison = $panier->getModeLivraison()->mode_livraison;
            $dateDelaiLivraison = $utilitaire->formaterDate($panier->getDelaiLivraison());

            $tDonnees = array("montantSousTotal"=>$montantSousTotal, "montantTps"=>$montantTps, "montantTotal"=>$montantTotal,"montantTotalItem"=>$montantTotalItem, "nbTotalArticles"=>$nbTotalArticles,"montantModeLivraison"=>$montantModeLivraison, "modeLivraison"=>$modeLivraison, "dateDelaiLivraison"=>$dateDelaiLivraison);

            echo json_encode($tDonnees);
        }

    }

    public function majModeLivraison():void {
        if(isset($_GET['sansJs'])) {
            if(isset($_POST['modeLivraison'])) {
                if(preg_match("#^(standard|prioritaire|gratuit)$#", $_POST['modeLivraison'])) {
                    $modeLivraison = $_POST["modeLivraison"];
                }
            }
            else {
                $modeLivraison = "";
            }

            $panier = App::getInstance()->getSessionPanier();

            $panier->setModeLivraison($modeLivraison);

            header('Location: index.php?controleur=panier&action=fiche');
            exit;
        }
        else {
            if(isset($_GET['choixModeLivraison'])) {
                if(preg_match("#^(standard|prioritaire|gratuit)$#", $_GET['choixModeLivraison'])) {
                    $modeLivraison = $_GET["choixModeLivraison"];
                }
            }
            else {
                $modeLivraison = "";
            }

            $panier = App::getInstance()->getSessionPanier();

            $panier->setModeLivraison($modeLivraison);

            $utilitaire = App::getInstance()->getUtilitaires();

            $montantSousTotal = $utilitaire->formaterPrix($panier->getMontantSousTotal());
            $montantTps = $utilitaire->formaterPrix($panier->getMontantTPS());
            $montantTotal = $utilitaire->formaterPrix($panier->getMontantTotal());
            $modeLivraison = $panier->getModeLivraison()->mode_livraison;
            $montantModeLivraison = $utilitaire->formaterPrix($panier->getMontantModeLivraison());
            $dateDelaiLivraison = $utilitaire->formaterDate($panier->getDelaiLivraison());


            $tDonnees = array("montantSousTotal"=>$montantSousTotal, "montantTps"=>$montantTps, "montantTotal"=>$montantTotal,"montantModeLivraison"=>$montantModeLivraison, "dateDelaiLivraison"=>$dateDelaiLivraison, "modeLivraison"=>$modeLivraison);

            echo json_encode($tDonnees);

        }


    }

    /*
     * Cette méthode permet d'afficher le vue du panier.
     */
    public function fiche():void {

        $panier = App::getInstance()->getSessionPanier();

        $utilitaire = App::getInstance()->getUtilitaires();

        $client = $this->session->getItem('client');

        if(isset($_GET['quantite'])) {
            $quantite = $_GET['quantite'];
        }
        else {
            $quantite = 0;
        }


        $tDonnees = array("panier" => $panier);
        $tDonnees = array_merge($tDonnees, array("client" => $client));
        $tDonnees = array_merge($tDonnees, array("utilitaire"=>$utilitaire));
        $tDonnees = array_merge($tDonnees, array("quantite"=>$quantite));


        echo $this->blade->run("panier",$tDonnees);
    }
}