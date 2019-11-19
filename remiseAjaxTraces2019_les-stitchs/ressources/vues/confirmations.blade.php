@extends('gabarit')
@section('contenu')
    <div class="confirmation">
    <h1 class="h1 souligneRouge"><span class="lettreBeige">C</span>Confirmation</h1>
        <div class="confirmation__commandeRecu">
            <svg class="confirmation__commandeRecuIcon">
                <use xlink:href="#order" />
            </svg>
            <p>Nous avons bien reçu votre commande.</p>
        </div>
        <div class="confirmation__messages">
            <p>Elle vous sera expediée selon les modalités que vous avez choisies. N'hésitez pas à consulter notre service à la clientèle pour plus d'informations relatives à votre commande ou votre compte.</p>
            <p>Votre numéro de confirmation est le: 000000783452.</p>
            <p>Vous recevrez d'ici quelques minutes une confirmation de votre commande par courriel.</p>
        </div>
        <section class="confirmation__sommaireCommande">
            <h3 class="confirmation__sommaireCommandeTitre">Sommaire de la commande</h3>
            <div class="confirmation__sommaireCommandeAvantTotal">
                <div class="confirmation__sommaireCommandeSousTotal">
                    <span>{{$panier->getNombreTotalItems()}} items</span>
                    <span class="confirmation__prix">CAD {{$utilitaire->formaterPrix($panier->getMontantSousTotal())}}</span>
                </div>
                <div class="confirmation__sommaireCommandeTps">
                    <span>TPS (5%) :</span>
                    <span class="confirmation__prix">CAD {{$utilitaire->formaterPrix($panier->getMontantTPS())}}</span>
                </div>
                <div class="confirmation__sommaireCommandeModeLivraison">
                    <span>Livraison standard : </span>
                    <span class="confirmation__prix">CAD {{$utilitaire->formaterPrix($panier->getMontantFraisLivraison())}}</span>
                </div>
            </div>
            <div class="confirmation__sommaireCommandeTotal">
                <span>Total</span>
                <span class="confirmation__prix">CAD {{$utilitaire->formaterPrix($panier->getMontantTotal())}}</span>
            </div>
        </section>
        <div class="confirmation__adresse">
            <section class="confirmation__adresseLivraison">
                <h3 class="confirmation__adresseLivraisonTitre">Adresse de livraison</h3>
                <div class="confirmation__adresseLivraisonContenu">
                    <span class="confirmation__adresseLivraisonNom">{{$livraison['prenom']}} {{$livraison['nom']}}</span>
                    <span>{{$livraison['adresse']}}</span>
                    <span>{{$livraison['ville']}}</span>
                    <span>{{$livraison['province']}}</span>
                    <span>{{$livraison['code_postal']}}</span>
                </div>
            </section>
            <section class="confirmation__adresseFacturation">
                <h3 class="confirmation__adresseFacturationTitre">Adresse de facturation</h3>
                <div class="confirmation__adresseFacturationContenu">
                    <span>{{$facturation['adresse']}}</span>
                    <span>{{$facturation['ville']}}</span>
                    <span>{{$facturation['province']}}</span>
                    <span>{{$facturation['code_postal']}}</span>
                </div>
            </section>
        </div>
        <section class="confirmation__informationsFacturation">
            <h3 class="confirmation__informationsFacturationTitre">Informations de facturation</h3>
            <div class="confirmation__informationsFacturationConteneur">
                <div class="confirmation__informationsFacturationPaiement">
                    <p class="confirmation__informationsFacturationModePaiement">Mode de paiement : {{$utilitaire->formaterMethodePaiement($facturation['methodePaiement'])}}</p>
                    <p class="confirmation__informationsFacturationCarte">
                        <span class="confirmation__informationsFacturationCarteNom">{{$facturation['nom_complet']}}</span>
                        <p class="confirmation__informationsFacturationCarteNumero">{{$utilitaire->formaterNumeroCarte($facturation['no_carte'])}}</p>
                    </p>
                    <p class="confirmation__informationsFacturationDateExpiration">Expiration {{$facturation['mois']}}/{{$facturation['annee']}}</p>
                </div>
                <div class="confirmation__informationsFacturationInformations">
                    <h4>Informations</h4>
                    <p>{{$client->courriel}}</p>
                    <p>{{$client->telephone}}</p>
                </div>
            </div>
        </section>
        <section class="confirmation__rappelArticles">
            <h3>Article(s)</h3>
            @foreach($panier->getItems() as $item)
                <article class="confirmation__rappelArticlesItem">
                    <div class="confirmation__rappelArticlesItemImg">
                        <img src="{{$utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($item->livre->isbn).'1_w80.jpg', $item->livre)}}@if($utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($item->livre->isbn).'1_w80.jpg', $item->livre) != '../ressources/liaisons/images/couverture_alternative.svg')"
                        srcset="../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($item->livre->isbn)}}1_w80.jpg 1x,../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($item->livre->isbn)}}1_w160.jpg 2x @endif" alt="Image couverture livre" class="confirmation__rappelArticlesItemImage">
                    </div>
                    <div class="confirmation__rappelArticlesItemInfos">
                        <p class="confirmation__rappelArticlesItemInfosTitre">{{$utilitaire->formaterTitreLivre($item->livre->titre)}}</p>
                        @foreach($item->livre->getAuteurs() as $auteur)
                        De
                            <span>{{$utilitaire->formaterNomsAuteurs($auteur->getNomPrenom(), $item->livre->getAuteurs())}}</span>
                        @endforeach
                        <p>{{$utilitaire->formaterPrix($item->livre->prix)}}</p>
                        <div class="confirmation__rappelArticlesItemQuantite">
                             <select name="quantite" class="quantiteListe">
                                    <option value="$item->quantite">{{$item->quantite}}</option>
                                </select>
                                <span class="confirmation__rappelArticlesItemPrix">{{$utilitaire->formaterPrix($item->getMontantTotal())}}</span>
                            </div>
                            <div>
                        </div>
                    </div>
                </article>
                @endforeach
        </section>
        <button type="button" onclick="window.print();" class="boutonOrangePrincipal">IMPRIMER LE REÇU DE VOTRE COMMANDE</button>
        <a class="confirmation__lien" href="index.php?controleur=livre&action=catalogue">CONTINUER À MAGASINER</a>
    </div>
@endsection