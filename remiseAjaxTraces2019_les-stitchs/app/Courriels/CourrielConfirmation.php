<?php
declare(strict_types = 1);

namespace App\Courriels;

use App\App;
use App\Courriels\Courriel;

class CourrielConfirmation
{

    private $blade = null;
    private $utilitaire = null;
    private $session = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
        $this->utilitaire = App::getInstance()->getUtilitaires();
        $this->session = App::getInstance()->getSession();

    }


    public function afficher(): void
    {

        $tDonnees = [];

        $client = $this->session->getItem('client');

        if($client != null) {
            $courriel = new Courriel($client->courriel);
            $message = $courriel->envoyer();
        }

        $livraison = $this->session->getItem('livraison');
        $facturation = $this->session->getItem('facturation');

        $panier = App::getInstance()->getSessionPanier();
        $utilitaire = $this->utilitaire;

        $tDonnees = array_merge($tDonnees, array("client" => $client));
        $tDonnees = array_merge($tDonnees, array("utilitaire" => $utilitaire));
        $tDonnees = array_merge($tDonnees, array("panier" => $panier));
        $tDonnees = array_merge($tDonnees, array("livraison" => $livraison));
        $tDonnees = array_merge($tDonnees, array("facturation" => $facturation));
        echo $this->blade->run('confirmations', $tDonnees);

    }
}

?>