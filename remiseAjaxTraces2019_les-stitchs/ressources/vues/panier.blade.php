@extends('gabarit')
@section('contenu')
    <div class="panier">
        <h1 class="panier__titre">Mon Panier (<span class="panier__titreNbItems">{{$panier->getNombreTotalItems()}}</span>)</h1>
            <span class="panierMessageLivraisonGratuite">
                @if($panier->getMontantSousTotal() > 50)
                    Vous avez le droit à la livraison<span class="panierMessageLivraisonGratuiteEnGras"> gratuite</span>
                @else
                    Livraison <span class="panierMessageLivraisonGratuiteEnGras"> gratuite</span> à partir de 50,00$ avant taxes
                @endif
            </span>
        <div class="panier__contenu">
            <div class="panier__contenuLivres">
                <section class="panier__sousTotal">
            <div class="panier__sousTotalPrix">
                <span>Sous-total </span>
                <span class="m-panier__sousTotalPrixMontant">{{$utilitaire->formaterPrix($panier->getMontantSousTotal())}}</span>

            </div>
            <form
                @if($client != null)
                    action="index.php?controleur=livraison&action=afficher"
                @else
                    action="index.php?controleur=client&action=connexion"
                @endif
                    method="post" class="panier__passerCommande">
                <button type="submit" class="panier__passerCommandeBouton boutonOrangePrincipal">Passer la commande</button>
            </form>
        </section>
                <section class="panier__infosLivres">
        <div class="panier__infosLivresInfosColonnes">
            <span class="panier__infosLivresInfosColonnesProduit">Produit</span>
            <div class="panier__infosLivresInfosColonnesAutres">
                <span class="panier__infosLivresInfosColonnesQuantite">Quantité</span>
                <span class="panier__infosLivresInfosColonnesPrix">Prix</span>
                <span class="panier__infosLivresInfosColonnesSousTotal">Total</span>
            </div>
        </div>
        @foreach($panier->getItems() as $item)
                <article class="panier__infosLivresConteneur">
                    <div class="panier__infosLivresContenu mobile">
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
                                    <form action="index.php?controleur=panier&action=majQuantite&isbn={{$item->livre->isbn}}&sansJs=true" method="post" class="panier__infosLivresContenuFormulaireQuantite">
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
                    <div class="panier__infosLivresContenu table">
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
                            </div>
                                <img src="{{$utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($item->livre->isbn).'1_w80.jpg', $item->livre)}}@if($utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($item->livre->isbn).'1_w80.jpg', $item->livre) != '../ressources/liaisons/images/couverture_alternative.svg')" srcset="../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($item->livre->isbn)}}1_w80.jpg 1x,../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($item->livre->isbn)}}1_w160.jpg 2x @endif" alt="Image couverture livre" class="panier__infosLivresContenuImage">

                        </div>
                        <div class="panier__infosLivresContenuAutres">
                            <form action="index.php?controleur=panier&action=majQuantite&isbn={{$item->livre->isbn}}&sansJs=true" method="post" class="panier__infosLivresContenuFormulaireQuantite">
                                <div class="panier__infosLivresContenuAutresQuantite">
                                    <select name="quantite" id="t-{{$item->livre->isbn}}" class="quantiteListe">
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
                                <button type="submit" class="panier__infosLivresContenuAutresBouton boutonOrangeSecondaire">Mettre à jour la quantité</button>
                            </form>
                            <span class="panier__infosLivresContenuAutresPrix">{{$utilitaire->formaterPrix($item->livre->prix)}}</span>
                            <span class="t-panier__infosLivresContenuAutresSousTotal">{{$utilitaire->formaterPrix($item->getMontantTotal())}}</span>
                        </div>
                        <form action="index.php?controleur=panier&action=supprimerItem&isbn={{$item->livre->isbn}}" method="post" class="panier__infosLivresContenuSupprimer">
                            <button type="submit" class="panier__infosLivresContenuBoutonSupprimer boutonOrangeSecondaire">
                                <span>Supprimer</span>
                                <svg class="panier__infosLivresContenuBoutonSupprimerIcone">
                                    <use xlink:href="#delete" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </article>
            @endforeach
    </section>
            </div>
            <section class="panier__commande">
                <div class="panier__commandePrix">
            <div class="panier__commandePrixSousTotal">
                <span class="panier__commandePrixSousTotalEtiquette">Sous-total </span>
                <span class="panier__commandePrixSousTotalMontant">{{$utilitaire->formaterPrix($panier->getMontantSousTotal())}}</span>
            </div>
            </div>
                <div class="panier__commandePrixTaxes">
                <span class="panier__commandePrixTaxesEtiquette">Taxes (TPS) </span>
                <span class="panier__commandePrixTaxesMontant">{{$utilitaire->formaterPrix($panier->getMontantTPS())}}</span>
            </div>
                <div class="panier__commandePrixModeLivraison">
                <form action="index.php?controleur=panier&action=majModeLivraison&sansJs=true" method="post">
                    <div class="panier__commandePrixModeLivraisonConteneur">
                        <div class="panier__commandePrixModeLivraisonChoix">
                            <label class="panier__commandePrixModeLivraisonChoixEtiquette">Mode de livraison </label>
                            <span class="panier__commandePrixModeLivraisonMontant">{{$utilitaire->formaterPrix($panier->getMontantModeLivraison(
                            ))}}</span>
                        </div>
                        <div class="panier__commandePrixModeLivraisonListe">
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

                    </div>
                    <button type="submit" class="panier__commandePrixModeLivraisonBouton boutonOrangeSecondaire">Mettre à jour le mode de livraison</button>
                    @if($panier->getModeLivraison() != null)
                        <div class="panier__commandeDateLivraison">
                            <span>Date de livraison </span>
                            <span class="panier__commandeDateLivraisonDate">{{$utilitaire->formaterDate($panier->getDelaiLivraison())}}</span>
                        </div>
                    @endif
                </form>
            </div>
                <div class="panier__commandeTotal">
            <span class="panier__commandeTotalPrixEtiquette">Total </span>
            <span class="panier__commandeTotalPrixMontant">CAD {{$utilitaire->formaterPrix($panier->getMontantTotal())}}</span>
        </div>
                <div class="panier__commandeActions">
            <form
                @if($client != null)
                    action="index.php?controleur=livraison&action=afficher"
                @else
                    action="index.php?controleur=client&action=connexion"
                @endif
                method="post" class="panier__commandeActionsPasserCommande">
                    <button type="submit" class="panier__commandeActionsPasserCommandeBouton boutonOrangePrincipal">Passer la commande</button>
            </form>
            <a href="index.php?controleur=livre&action=catalogue" class="panier__commandeActionsContinuerMagasiner boutonOrangeSecondaire">Continuer à magasiner</a>
        </div>
            </section>
        </div>
    </div>
@endsection