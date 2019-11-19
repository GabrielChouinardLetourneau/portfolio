@extends('courriels.gabarit')
@section('contenu')
    <div class="courriel">
        <h1 class="titre">Confirmation</h1>
        <div class="message">
            <div class="commandeRecu">
                <svg class="commandeRecuIcon">
                    <use xlink:href="#order" />
                </svg>
                <p>Nous avons bien reçu votre commande.</p>
            </div>
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
        <section>
            <h3>Adresse de facturation</h3>
            <div>
                <p>{{$facturation['adresse']}}</p>
                <p>{{$facturation['ville']}}</p>
                <p>{{$facturation['province']}}</p>
                <p>{{$facturation['code_postal']}}</p>
            </div>
        </section>
        <section>
            <h3>Informations de facturation</h3>
            <div>
                <div>
                    <p>Mode de paiement : {{$utilitaire->formaterMethodePaiement($facturation['methodePaiement'])}}</p>
                    <p>{{$facturation['nom_complet']}}</p>
                    <p>{{$utilitaire->formaterNumeroCarte($facturation['no_carte'])}}</p>
                    <p>Expiration {{$facturation['mois']}}/{{$facturation['annee']}}</p>
                </div>
                <div>
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
                <div></div>
        </section>
    </div>
@endsection