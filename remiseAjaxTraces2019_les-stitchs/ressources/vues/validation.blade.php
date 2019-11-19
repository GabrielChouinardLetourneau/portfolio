@extends('gabarit')
@section('contenu')
<div class="validation">
    <section class="barreProgression">
        <ul class="barreProgressionListe">
            <li class="barreProgressionListeItem">
                <div>1. Livraison</div>
            </li>
            <li class="barreProgressionListeItem">
                <div>2. Facturation</div>
            </li>
            <li class="barreProgressionListeItem etapeEncours">
                <div>3. Validation</div>
            </li>
        </ul>
    </section>
            <h1 class="validation__titre">Validation</h1>
            <section class="validation__sommaireCommande">
                <h3 class="validation__sommaireCommandeTitre">Sommaire de la commande</h3>
                <div class="validation__sommaireCommandeAvantTotal">
                    <div class="validation__sommaireCommandeSousTotal">
                        <span>{{$panier->getNombreTotalItems()}} @if($panier->getNombreTotalItems() > 1)
                            items 
                        @else 
                            item    
                        @endif
                        </span>
                        <span>{{$utilitaire->formaterPrix($panier->getMontantSousTotal())}}</span>
                    </div>
                    <div class="validation__sommaireCommandeTps">
                        <span>TPS (5%) :</span>
                        <span>{{$utilitaire->formaterPrix($panier->getMontantTPS())}}</span>
                </div>
                    <div class="validation__sommaireCommandeModeLivraison">
                        <span>Livraison {{$panier->getModeLivraison()->mode_livraison}} : </span>
                        <span>
                            {{$utilitaire->formaterPrix($panier->getMontantModeLivraison())}}
                        </span>
                </div>
                </div>
                <div class="validation__sommaireCommandeTotal">
                    <span>Total</span>
                    <span>{{$utilitaire->formaterPrix($panier->getMontantTotal())}}</span>
                </div>
            </section>
            <section class="validation__adresseLivraison">
                <h3 class="validation__adresseLivraisonTitre">Adresse de facturation</h3>
                <div class="validation__adresseLivraisonConteneur">
                    <div class="validation__adresseLivraisonContenu">
                        <span class="validation__adresseLivraisonNom">{{ $prenom . " " . $nom }}</span>
                        <span>{{ $adresseLivraison }}</span>
                        <span>Ville de {{ $villeLivraison }} </span>
                        <span>{{ $provinceLivraison }}</span>
                        <span>{{ $code_postalLivraison }}</span>
                    </div>
                    <button type="button" class="validation__adresseLivraisonContenuBouton boutonOrangePrincipal">Modifier</button>
                </div>
            </section>
            <section class="validation__informationsFacturation">
                <h3 class="validation__informationsFacturationTitre">Informations de facturation</h3>
                <div class="validation__informationsFacturationConteneur">
                    <div class="validation__informationsFacturationPaiement">
                        <div class="validation__informationsFacturationPaiementContenu">
                            <p class="validation__informationsFacturationModePaiement">Mode de paiement : {{ $methodePaiement }}</p>
                            <p class="validation__informationsFacturationCarte">
                                <span>
                                    <svg class="validation__informationsFacturationCarteIcone">
                                        <use xlink:href="#visa" />
                                    </svg>
                                </span>
                                <span class="validation__informationsFacturationCarteNumero">{{ $numeroCarte }}</span>
                            </p>
                            <p class="validation__informationsFacturationDateExpiration">Expiration {{ $mois }}/{{ $annee }}</p>
                        </div>
                        <button type="button" class="validation__informationsFacturationPaiementBouton boutonOrangePrincipal">Modifier</button>
                    </div>
                    <div class="validation__informationsFacturationAdresseFacturation">
                        <div class="validation__informationsFacturationAdresseFacturationContenu">
                            <h4 class="validation__informationsFacturationAdresseFacturationTitre">Adresse de facturation</h4>
                            <span class="validation__informationsFacturationNom">{{ $nom_complet }}</span>
                            <span>{{ $adresseFacturation }}</span>
                            <span>Ville de {{ $villeFacturation }}</span>
                            <span>{{ $provinceFacturation }}</span>
                            <span>{{ $code_postalFacturation }}</span>
                        </div>
                        <button type="button" class="validation__informationsFacturationAdresseFacturationBouton boutonOrangePrincipal">Modifier</button>
                    </div>
                    <div class="validation__informationsFacturationInformations">
                        <div class="validation__informationsFacturationInformationsContenu">
                            <h4>Informations</h4>
                            <p>{{ $courrielClient }}</p>
                            <p>{{ $telephoneClient }}</p>
                        </div>
                        <button type="button" class="validation__informationsFacturationInformationsBouton boutonOrangePrincipal">Modifier</button>
                    </div>
                </div>
            </section>
            <section class="panier">
                <h2 class="validation__panierTitre">Mon panier <span class="validation__panierTitreNbItems">({{$panier->getNombreTotalItems()}})</span></h2>
                <span class="panierMessageLivraisonGratuite">
                    @if($panier->getMontantSousTotal() > 50)
                        Vous avez le droit à la livraison<span class="panierMessageLivraisonGratuiteEnGras"> gratuite</span>
                    @else
                        Livraison <span class="panierMessageLivraisonGratuiteEnGras"> gratuite</span> à partir de 50,00$ avant taxes
                    @endif
                </span>
                <div class="panier__contenu">
                    <div class="validation__panierSousTotal">
                        <div class="validation__panierSousTotalContenu">
                            <span>Sous-total : </span>
                            <span class="m-validation__panierSousTotalPrix">{{$utilitaire->formaterPrix($panier->getMontantSousTotal())}}</span>
                        </div>
                        <form action="index.php?controleur=validation&action=insererBd" method="post">
                            <button type="submit" class="validation__panierSousTotalBouton boutonOrangePrincipal">Passer la commande</button>
                        </form>
                    </div>
                    @foreach($panier->getItems() as $item)
                        <div class="validation panier__infosLivresContenu">
                            <div class="panier__infosLivresContenuLivre">
                                <div class="panier__infosLivresContenuLivreTextes">
                                    <span class="panier__infosLivresContenuLivreTextesTitre">{{$utilitaire->formaterTitreLivre($item->livre->titre)}}</span>
                                    <ul class="panier__infosLivresContenuLivreTextesAuteurs">
                                        @foreach($item->livre->getAuteurs() as $auteur)
                                            @if($auteur->url_blogue != null)
                                                <li class="panier__infosLivresContenuLivreAuteursItem"><a href="{{$auteur->url_blogue}}" class="panier__infosLivresContenuLivreAuteursLien">{{$utilitaire->formaterNomsAuteurs($auteur->getNomPrenom(), $item->livre->getAuteurs())}}</a></li>
                                            @else
                                                <li class="panier__infosLivresContenuLivreAuteursItem">{{$utilitaire->formaterNomsAuteurs($auteur->getNomPrenom(), $item->livre->getAuteurs())}}</li>
                                                @endif
                                        @endforeach
                                    </ul>
                                    <span class="panier__infosLivresContenuAutresPrix">{{$utilitaire->formaterPrix($item->livre->prix)}}</span>
                                    <div class="panier__infosLivresContenuPrixQuantite">
                                        <form action="index.php?controleur=panier&action=majQuantite&isbn={{$item->livre->isbn}}&sansJs=true&vue=validation" method="post" class="panier__infosLivresContenuFormulaireQuantite">
                                            <div class="panier__infosLivresContenuPrixQuantiteConteneur">
                                                <label>Quantité : </label>
                                                <div class="panier__infosLivresContenuAutresQuantite">
                                                    <select name="quantite" id="m-{{$item->livre->isbn}}" class="quantiteListe">
                                                        <option value="1"
                                                                @if($item->quantite === 1)
                                                                selected="selected"
                                                                @endif
                                                        >1</option>
                                                        <option value="2"
                                                                @if($item->quantite === 2)
                                                                selected="selected"
                                                                @endif
                                                        >2</option>
                                                        <option value="3"
                                                                @if($item->quantite === 3)
                                                                selected="selected"
                                                                @endif
                                                        >3</option>
                                                        <option value="4"
                                                                @if($item->quantite === 4)
                                                                selected="selected"
                                                                @endif
                                                        >4</option>
                                                        <option value="5"
                                                                @if($item->quantite === 5)
                                                                selected="selected"
                                                                @endif
                                                        >5</option>
                                                        <option value="6"
                                                                @if($item->quantite === 6)
                                                                selected="selected"
                                                                @endif
                                                        >6</option>
                                                        <option value="7"
                                                                @if($item->quantite === 7)
                                                                selected="selected"
                                                                @endif
                                                        >7</option>
                                                        <option value="8"
                                                                @if($item->quantite === 8)
                                                                selected="selected"
                                                                @endif
                                                        >8</option>
                                                        <option value="9"
                                                                @if($item->quantite === 9)
                                                                selected="selected"
                                                                @endif
                                                        >9</option>
                                                        <option value="10"
                                                                @if($item->quantite === 10)
                                                                selected="selected"
                                                                @endif
                                                        >10</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="submit" class="panier__infosLivresContenuAutresBouton boutonOrangeSecondaire">Mettre à jour la quantité</button>
                                        </form>
                                    </div>
                                </div>
                                <img src="{{$utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($item->livre->isbn).'1_w80.jpg', $item->livre)}}@if($utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($item->livre->isbn).'1_w80.jpg', $item->livre) != '../ressources/liaisons/images/couverture_alternative.svg')"
                                        srcset="../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($item->livre->isbn)}}1_w80.jpg 1x,../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($item->livre->isbn)}}1_w160.jpg 2x @endif" alt="Image couverture livre" class="panier__infosLivresContenuImage">
                            </div>
                            <form action="index.php?controleur=panier&action=supprimerItem&isbn={{$item->livre->isbn}}" method="post" class="panier__infosLivresContenuSupprimer">
                                <button type="submit" class="panier__infosLivresContenuBoutonSupprimer boutonOrangeSecondaire">
                                    <span>Supprimer</span>
                                    <svg class="panier__infosLivresContenuBoutonSupprimerIcone">
                                        <use xlink:href="#delete" />
                                    </svg>
                                </button>
                            </form>
                            <div class="panier__infosLivresContenuSousTotal">
                                <span class="panier__infosLivresContenuSousTotalEtiquette">Total</span>
                                <span class="m-panier__infosLivresContenuAutresSousTotal">{{$utilitaire->formaterPrix($item->getMontantTotal())}}</span>
                            </div>
                        </div>
                    @endforeach
                    <div class="validation__panierFacture">
                        <div class="panier__commandePrixSousTotal">
                            <span class="panier__commandePrixSousTotalEtiquette">Sous-total </span>
                            <span class="panier__commandePrixSousTotalMontant">{{$utilitaire->formaterPrix($panier->getMontantSousTotal())}}</span>
                        </div>
                        <div class="panier__commandePrixTaxes">
                            <span class="panier__commandePrixTaxesEtiquette">Tps (5%) </span>
                            <span class="panier__commandePrixTaxesMontant">{{$utilitaire->formaterPrix($panier->getMontantTPS())}}</span>
                        </div>
                        <div class="validation__panierFactureModeLivraison">
                            <div class="panier__commandePrixModeLivraisonChoix">
                                <label class="panier__commandePrixModeLivraisonChoixEtiquette">Mode de livraison </label>
                                <span class="panier__commandePrixModeLivraisonMontant">{{$utilitaire->formaterPrix($panier->getMontantModeLivraison(
                                        ))}}</span>
                            </div>
                            <form action="" method="post" class="validation__panierFactureModeLivraisonFormulaire">
                                <div class="validation__panierFactureModeLivraisonListe">
                                    <select name="modeLivraison" id="modeLivraison" class="modeLivraisonListe">
                                            <option value="standard"
                                            @if($panier->getModeLivraison() != null)
                                            @if($panier->getModeLivraison()->id_mode_livraison == 11)
                                            selected="selected"
                                            @endif
                                            @endif
                                    >Standard</option>
                                    <option value="prioritaire"
                                            @if($panier->getModeLivraison() != null)
                                            @if($panier->getModeLivraison()->id_mode_livraison == 12)
                                            selected="selected"
                                            @endif
                                            @endif
                                    >Prioritaire</option>
                                    <option value="gratuit"
                                            @if($panier->getMontantSousTotal() < 50)
                                            class="cache"
                                            @else
                                            @if($panier->getModeLivraison()->mode_livraison == "gratuit")
                                            selected="selected"
                                            @endif
                                            @endif
                                    >Gratuit</option>
                                    </select>
                                </div>
                                <button type="submit" class="validation__panierFactureModeLivraisonBouton boutonOrangeSecondaire">Mettre à jour le mode de livraison</button>
                            </form>
                            <div class="panier__commandeDateLivraison">
                                <span>Date de livraison</span>
                                <span class="panier__commandeDateLivraisonDate">{{$utilitaire->formaterDate($panier->getDelaiLivraison())}}</span>
                            </div>
                        </div>
                        <div class="panier__commandeTotal">
                            <span class="panier__commandeTotalPrixEtiquette">Total</span>
                            <span class="panier__commandeTotalPrixMontant">CAD {{$utilitaire->formaterPrix($panier->getMontantTotal())}}</span>
                        </div>
                        <div class="validation__panierFactureActions">
                            <form action="index.php?controleur=validation&action=insererBd" method="post">
                            <div class="validation__panierFactureActionsPasserCommande">
                                <button type="submit" class="validation__panierFactureActionsPasserCommandeBouton boutonOrangePrincipal">Passer la commande</button>
                            </div>
                            </form>
                            <a href="index.php?controleur=site&action=accueil" class="validation__panierFactureActionsContinuerMagasiner boutonOrangeSecondaire">Continuer à magasiner</a>
                        </div>
                    </div>
                </div>
            </section>

    </div>
@endsection