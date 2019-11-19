<?php
declare(strict_types=1);

namespace App\Session;

use App\Modeles\Livre;
use App\App;
use App\Modeles\Transaction\ModeLivraison;
use App\Utilitaires;
use DateTime;

class SessionPanier
{
    private $items = [];
    private $message = "";
    private $session= null;
    private $livreAjoute = null;
    private $modeLivraison = null;

    public function __construct()
    {
        $this->session = App::getInstance()->getSession();

    }

    // Ajoute un item au panier avec la quantité X
    // Attention: Si l'item existe déjà dans le panier alors mettre à jour la quantité (la quantité maximum est de 10 à valider...)
    public function ajouterItem(Livre $unLivre, int $uneQte):void
    {
        if($this->items[$unLivre->isbn] === null) {
            $this->items[$unLivre->isbn] = new SessionItem($unLivre, $uneQte);
        }
        else {
            if($uneQte >= 1 && $uneQte <= 10) {
                $this->items[$unLivre->isbn]->quantite += $uneQte;
            }
        }

        $this->setLivre($unLivre);

        $unMessage = "Vous venez d'ajouter à votre panier << " . $unLivre->titre . ">> à " . money_format('%.2n', (float)$unLivre->prix). "$";

        $this->setMessage($unMessage);

        $this->setModeLivraison('standard');

        $this->sauvegarder();
    }

    // Supprimer un item du panier
    public function supprimerItem(string $isbn):void
    {
        unset($this->items[$isbn]);
        $this->sauvegarder();
    }

    // Retourner le tableau d'items du panier
    public function getItems():array
    {
        return $this->items;
    }

    // Mettre à jour la quantité d'un item
    public function setQuantiteItem(string $isbn, int $uneQte):void
    {
        $this->items[$isbn]->quantite = $uneQte;
        $this->sauvegarder();
    }

    // Retourner la quantité d'un item
    public function getQuantiteItem(string $isbn):int
    {
        return $this->items[$isbn]->quantite;
    }


    // Retourner le nombre d'item différents (unique) dans le panier
    public function getNombreTotalItemsDifferents():int
    {
        return count($this->items);
    }

    // Retourner le nombre de livres total dans le panier (somme de la quantité de chaque item)
    public function getNombreTotalItems():int
    {
        $nbTotalItems = 0;

        foreach($this->items as $item) {
            $nbTotalItems += $this->getQuantiteItem($item->livre->isbn);
        }

        return $nbTotalItems;
    }

    public function getMontantTotalItem(string $isbn):float {
        return $this->items[$isbn]->getMontantTotal();
    }

    // Retourner le montant sousTotal du panier (somme des montantTotals de chaque item)
    public function getMontantSousTotal():float{

        $montant = 0;

        foreach($this->items as $item) {
           $montant += $item->getMontantTotal();
        }

        return $montant;
    }


    // Retourner de montant de la TPS
    // TPS = 5%
    public function getMontantTPS():float{

        return 5 * $this->getMontantSousTotal()/100;
    }


    // Retourner le montant des frais de livraison
    // Frais de livraison (base=4$ + taux par item=3,50$) Exemple, 1livre=7,50$, 2livres=11$ etc.
    // Il n’y a pas de taxes sur les frais de livraison. Ils s’ajoutent en dernier.
    public function getMontantFraisLivraison():float
    {
        if($this->getNombreTotalItemsDifferents() > 0 ) {
            return 4 + (3.50 * $this->getNombreTotalItems());
        }
        else {
            return 0;
        }
    }

    public function setModeLivraison($unModeLivraison):void {
        $this->modeLivraison = ModeLivraison::trouverModeLivraison($unModeLivraison);
    }
    public function getModeLivraison() {
        return $this->modeLivraison;
    }
    public function getMontantModeLivraison():float {

        $montantModeLivraison = 0;

        if($this->getNombreTotalItems() > 0) {
            $montantModeLivraison = $this->modeLivraison->base + $this->modeLivraison->par_item * $this->getNombreTotalItems();
        }

        return $montantModeLivraison;
    }

    public function getDelaiLivraison() {
        $dateAujourdhui = new DateTime();

        return $dateAujourdhui->add(new \DateInterval('P'.$this->modeLivraison->delai_max_jrs.'D'))->format('D d F Y');

    }


    // Retourner le montant total de la commande (montant sous-total + TPS + montant livraison)
    public function getMontantTotal():float
    {
        return $this->getMontantSousTotal() + $this->getMontantTPS() + $this->getMontantModeLivraison();
    }


    // Sauvegarder le panier en variable session nommée: panier
    public function sauvegarder():void
    {
        $this->session->setItem('panier', $this);
    }

    // Supprimer le panier en variable session nommée: panier
    public function supprimer():void {

        $this->session->supprimerItem('panier');
    }

    public function setLivre($unLivre) {
        $this->livreAjoute = $unLivre;
    }
    public function getLivre() {
        if($this->livreAjoute != null) {
            return $this->livreAjoute;
        }
        else {
            return null;
        }

    }

    public function setMessage(string $message) {

        $this->message = $message;
        echo "message : ". $this->message;
    }

    public function getMessage():string {
        var_dump($this->message);
        return $this->message;
    }
}

?>