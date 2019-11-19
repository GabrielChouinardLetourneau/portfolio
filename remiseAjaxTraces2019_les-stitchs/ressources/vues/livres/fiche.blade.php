@extends('gabarit')

@section('contenu')
    <div class="fiche">
        <div class="fiche__filAriane">
            @include('fragments.filariane')
        </div>
        <div class="fiche__infos">
            <div class="fiche__infosDroite">
                <section class="fiche__infosLivre">
                    <h1 class="fiche__infosLivreTitre"><span class="fiche__infosLivreTitrePremiereLettre">{!!$utilitaire->formaterTitreLivre($livre->titre)[0]!!}</span>{!!$utilitaire->formaterTitreLivre($livre->titre)!!}</h1>
                    <div class="fiche__infosLivreImageParution">
                        <img src="{{$utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($livre->isbn).'1_w320.jpg', $livre)}}@if($utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'.$utilitaire->ISBNToEAN($livre->isbn).'1_w320.jpg', $livre) != '../ressources/liaisons/images/couverture_alternative.svg')"
                             srcset="../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($livre->isbn)}}1_w320.jpg 1x,../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($livre->isbn)}}1_w640.jpg 2x @endif" alt="Image couverture livre {{$utilitaire->formaterTitreLivre($livre->titre)}}" class="fiche__infosLivreImage mobile">

                        <div class="fiche__infosLivreParution mobile">
                            <span class="fiche__parutionTexte">{{$livre->getParution()->etat}}</span>
                        </div>
                    </div>
                @if($livre->sous_titre != null)
                    <p class="fiche__infosLivreSousTitre">{{$livre->sous_titre}}</p>
                @endif
                <ul class="fiche__infosLivreAuteurs">
                    <span>De</span>
                    @foreach($livre->getAuteurs() as $auteur)
                        @if($auteur->url_blogue != null)
                            <li class="fiche__infosLivreAuteursItem"><a href="{{$auteur->url_blogue}}">{{$utilitaire->formaterNomsAuteurs($auteur->getNomPrenom(), $livre->getAuteurs())}}</a></li>
                        @else
                            <li class="fiche__infosLivreAuteursItem">{{$utilitaire->formaterNomsAuteurs($auteur->getNomPrenom(), $livre->getAuteurs())}}</li>
                        @endif
                    @endforeach
                </ul>
                    <p class="fiche__infosCote">
                        <svg class="fiche__infosCoteIcone">
                            <use xlink:href="#review4" />
                        </svg>
                        <span class="fiche__infosCoteTexte">10</span>
                    </p>
            </section>
                <section class="fiche__commande">
                    <p class="fiche__commandePrix">{{$utilitaire->formaterPrix($livre->prix)}}</p>
                    <form action="index.php?controleur=panier&action=ajouterItem&isbn={{$livre->isbn}}" method="post">
                        <ul class="fiche__commandeVersion__liste">
                            <li class="fiche__commandeVersionItem">
                            <label for="versionImprimee" class="fiche__commandeVersionEtiquette">Version imprimée
                                <input type="checkbox" id="versionImprimee">
                                <!-- Ce span permet d'avoir un checkbox personnalisé -->
                                <span></span>
                            </label>
                            <svg class="fiche__commandeVersionIconeImprime">
                                <use xlink:href="#book" />
                            </svg>
                        </li>
                        <li class="fiche__commandeVersionItem">
                            <label for="versionNumerique" class="fiche__commandeVersionEtiquette">Version numérique
                                <input type="checkbox" id="versionNumerique">
                                <!-- Ce span permet d'avoir un checkbox personnalisé -->
                                <span></span>
                            </label>
                            <svg class="fiche__commandeVersionIconeNumerique">
                                <use xlink:href="#epub" />
                            </svg>
                        </li>
                    </ul>
                    <div class="fiche__commandeQuantite">
                        <label for="quantite">Quantité : </label>
                        <div class="fiche__commandeQuantiteListe">
                            <select name="quantite" id="quantite">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                        </div>
                    </div>
                    <button type="submit" class="fiche__commandeBouton boutonOrangePrincipal">
                        <span>AJOUTER AU PANIER</span>
                        <svg class="fiche__commandeBoutonIcone">
                            <use xlink:href="#cart" />
                        </svg>
                    </button>
                </form>
            </section>
                <section class="fiche__description">
                <h2 class="fiche__descriptionTitre"><span class="fiche__descriptionTitrePremiereLettre lettreBeige" aria-hidden="true">D</span>Description</h2>
                    <p></p>
                <p class="fiche__descriptionTexteCoupe">
                    {!! $descriptionCoupee !!}
                </p>
                <p class="fiche__descriptionTexteComplet">
                    {!! $descriptionDeuxiemePartie !!}
                </p>
                <button class="fiche__descriptionLireLaSuite">Lire la suite +</button>
            </section>
                @if($recensions != null)
                    <section class="fiche__critiques">
                        <h2 class="fiche__critiquesTitre"><span class="fiche__critiquesTitrePremiereLettre lettreBeige" aria-hidden="true">C</span>Critiques</h2>
                        @foreach($recensions as $recension)
                            <article class="fiche__critiquesContenu">
                                <button type="button" class="fiche__critiquesContenuTitre">
                                    <div class="fiche__critiquesContenuTitreTexte">
                                        @if($recension->nom_journaliste != null)
                                            <span>{{$recension->nom_journaliste}},</span>
                                        @endif
                                        <span class="fiche__critiquesContenuMedia">{{$recension->nom_media}}</span>
                                    </div>
                                </button>
                                <div class="fiche__critiquesContenuTexte">
                                    <div class="fiche__critiquesContenuTexteConteneur">
                                        <span class="fiche__critiquesContenuTexteTitre h4">{{$utilitaire->formaterTitreLivre($recension->titre)}}</span>
                                        <p class="fiche__critiquesContenuDescription">{!! $recension->description !!}</p>
                                        <footer>{{$utilitaire->formaterDate($recension->date)}}</footer>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </section>
                @endif
                @if($honneurs != null)
                    <section class="fiche__prixRemportes">
                    <h2 class="fiche__prixRemportesTitre"><span class="fiche__prixRemportesTitrePremiereLettre lettreBeige" aria-hidden="true">P</span>Prix remportés</h2>
                    @foreach($honneurs as $honneur)
                        <article class="fiche__prixRemportesContenu">
                            <header class="fiche__prixRemportesContenuTitre">
                                <p>{{$honneur->nom}}</p>
                            </header>
                            <p>{!!$honneur->description!!}</p>
                        </article>
                    @endforeach
                </section>
                @endif
            </div>
        <div class="fiche__infosGauche table">
            <img src="{{$utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($livre->isbn).'1_w320.jpg', $livre)}}@if($utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($livre->isbn).'1_w320.jpg', $livre) != '../ressources/liaisons/images/couverture_alternative.svg')"
                 srcset="../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($livre->isbn)}}1_w320.jpg 1x,../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($livre->isbn)}}1_w640.jpg 2x @endif" alt="Image couverture livre {{$utilitaire->formaterTitreLivre($livre->titre)}}" class="fiche__infosLivreImage table">

            <div class="fiche__parution">
                <span class="fiche__parutionTexte">{{$livre->getParution()->etat}}</span>
            </div>
            <section class="fiche__infosPublication table">
                <div class="fiche__infosPublicationCategories">
                    <span class="fiche__infosPublicationCategoriesTitre">Catégories :</span>
                    <ul class="fiche__infosPublicationCategoriesListe">
                        @foreach($livre->getCategories() as $categorie)
                            <li class="fiche__infosPublicationCategoriesItem">
                                @if($categorie->nom_fr == $livre->getCategories()[count($livre->getCategories())-1]->nom_fr)
                                    {{$categorie->nom_fr}}
                                @else
                                    {{$categorie->nom_fr}} <span class="fiche__infosPublicationCategoriesItemSeparation">|&nbsp;</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
                @if($livre->collection_id !== null)
                    <p class="fiche__infosPublicationCollection">
                        <span class="fiche__infosPublicationCollectionTitre">Collection : </span>
                        <span class="fiche__infosPublicationCollectionNom">{{$livre->getCollection()->nom}},</span>
                        <span class="fiche__infosPublicationCollectionDescription">{{$livre->getCollection()->description}}</span>
                    </p>
                @endif
                <p class="fiche__infosPublicationAnneePublication">
                    <span class="fiche__infosPublicationAnneePublicationTitre">Année de publication : </span>
                    <span class="fiche__infosPublicationAnneePublicationAnnee">{{$livre->annee_publication}}</span>
                </p>
                <div class="fiche__infosPublicationEditeurs">
                    <span class="fiche__infosPublicationEditeursTitre">Éditeurs :</span>
                    <ul class="fiche__infosPublicationEditeursListe">
                        @foreach($editeurs as $editeur)
                            @if($editeur->url !== "")
                                @if($editeur->nom == $editeurs[count($editeurs)-1]->nom)
                                    <li class="fiche__infosPublicationEditeursItem"><a href="{{$editeur->url}}" class="fiche__infosPublicationEditeursLien">{{$editeur->nom}}</a></li>
                                @else
                                    <li class="fiche__infosPublicationEditeursItem"><a href="{{$editeur->url}}" class="fiche__infosPublicationEditeursLien">{{$editeur->nom}} | </a></li>
                                @endif
                            @else
                                @if($editeur->nom == $editeurs[count($editeurs)-1]->nom)
                                    <li class="fiche__infosPublicationEditeursItem">{{$editeur->nom}}</li>
                                @else
                                    <li class="fiche__infosPublicationEditeursItem">{{$editeur->nom}} | </li>
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </div>
                <p class="fiche__infosPublicationIsbn">
                    <span class="fiche__infosPublicationIsbnTitre">ISBN : </span>
                    <span>{{$livre->isbn}}</span>
                </p>
                <p class="fiche__infosPublicationNombrePages">
                    <span class="fiche__infosPublicationNombrePagesTitre">Nombre de pages : </span>
                    <span class="fiche__infosPublicationNombrePagesTitreTexte">{{$livre->nbre_pages}}</span>
                </p>
                <p class="fiche__infosPublicationEstIllustre">
                    <span class="fiche__infosPublicationEstIllustreTitre">Est illustré : </span>
                    <span class="fiche__infosPublicationEstIllustreTexte">
                        @if($livre->est_illustre == "0")
                            Non
                        @else
                            Oui
                        @endif
                        </span>
                </p>
                @if($livre->autres_caracteristiques !== null)
                    <p class="fiche__infosPublicationCaracteristiques">
                        <span class="fiche__infosPublicationCaracteristiquesTitre">Caractéristique : </span>
                        <span class="fiche__infosPublicationCaracteristiquesTexte">{{$livre->autres_caracteristiques}}</span>
                    </p>
                @endif
            </section>
        </div>
    </div>
    <section class="fiche__infosPublication mobile">
            <div class="fiche__infosPublicationCategories">
                <span class="fiche__infosPublicationCategoriesTitre">Catégories :</span>
                <ul class="fiche__infosPublicationCategoriesListe">
                    @foreach($livre->getCategories() as $categorie)
                        <li class="fiche__infosPublicationCategoriesItem">
                            @if($categorie->nom_fr == $livre->getCategories()[count($livre->getCategories())-1]->nom_fr)
                                {{$categorie->nom_fr}}
                            @else
                                {{$categorie->nom_fr}} |
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
            @if($livre->collection_id !== null)
                <p class="fiche__infosPublicationCollection">
                    <span class="fiche__infosPublicationCollectionTitre">Collection : </span>
                    <span class="fiche__infosPublicationCollectionNom">{{$livre->getCollection()->nom}},</span>
                    <span class="fiche__infosPublicationCollectionDescription">{{$livre->getCollection()->description}}</span>
                </p>
            @endif
            <p class="fiche__infosPublicationAnneePublication">
                <span class="fiche__infosPublicationAnneePublicationTitre">Année de publication : </span>
                <span class="fiche__infosPublicationAnneePublicationAnnee">{{$livre->annee_publication}}</span>
            </p>
            <div class="fiche__infosPublicationEditeurs">
                <span class="fiche__infosPublicationEditeursTitre">Éditeurs :</span>
                <ul class="fiche__infosPublicationEditeursListe">
                    @foreach($editeurs as $editeur)
                        @if($editeur->url !== "")
                            <li class="fiche__infosPublicationEditeursItem"><a href="{{$editeur->url}}" class="fiche__infosPublicationEditeursLien">{{$editeur->nom}}</a></li>
                        @else
                            <li class="fiche__infosPublicationEditeursItem">{{$editeur->nom}}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <p class="fiche__infosPublicationIsbn">
                <span class="fiche__infosPublicationIsbnTitre">ISBN : </span>
                <span>{{$livre->isbn}}</span>
            </p>
            <p class="fiche__infosPublicationNombrePages">
                <span class="fiche__infosPublicationNombrePagesTitre">Nombre de pages : </span>
                <span class="fiche__infosPublicationNombrePagesTitreTexte">{{$livre->nbre_pages}}</span>
            </p>
            <p class="fiche__infosPublicationEstIllustre">
                <span class="fiche__infosPublicationEstIllustreTitre">Est illustré : </span>
                <span class="fiche__infosPublicationEstIllustreTexte">
                        @if($livre->est_illustre == "0")
                        Non
                    @else
                        Oui
                    @endif
                        </span>
            </p>
            @if($livre->autres_caracteristiques !== null)
                <p class="fiche__infosPublicationCaracteristiques">
                    <span class="fiche__infosPublicationCaracteristiquesTitre">Caractéristique : </span>
                    <span class="fiche__infosPublicationCaracteristiquesTexte">{{$livre->autres_caracteristiques}}</span>
                </p>
            @endif
        </section>
    <section class="fiche__vousPourriezAimer">
        <h2 class="fiche__vousPourriezAimerTitre"><span class="fiche__vousPourriezAimerTitrePremiereLettre lettreBeige" aria-hidden="true">V</span>Vous pourriez aimer</h2>
        <div class="fiche__vousPourriezAimerCaroussel regular slider">
            @foreach($livresInteresses as $unLivreInteresse)
            <a href="index.php?controleur=livre&action=fiche&id={{$unLivreInteresse->id}}&isbn={{$unLivreInteresse->isbn}}" class="fiche__vousPourriezAimerCarousselLien">
                <article class="fiche__vousPourriezAimerLivre">
                    <header class="fiche__vousPourriezAimerLivreTitre">
                        <p class="fiche__vousPourriezAimerLivreTitreContenu">{{$utilitaire->formaterTitreLivre($unLivreInteresse->titre)}}</p>
                    </header>
                    <ul class="fiche__vousPourriezAimerLivreAuteurs">
                        <span>Par</span>
                        @foreach($unLivreInteresse->getAuteurs() as $unAuteur)
                            <li class="fiche__vousPourriezAimerLivreAuteursItem">{{$utilitaire->formaterNomsAuteurs($unAuteur->getNomPrenom(), $unLivreInteresse->getAuteurs())}}</li>
                        @endforeach
                    </ul>

                    <img src="{{$utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($unLivreInteresse->isbn).'1_w320.jpg', $unLivreInteresse)}}@if($utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($unLivreInteresse->isbn).'1_w320.jpg', $unLivreInteresse) != '../ressources/liaisons/images/couverture_alternative.svg')"
                         srcset="../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($unLivreInteresse->isbn)}}1_w320.jpg 1x,../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($unLivreInteresse->isbn)}}1_w640.jpg 2x @endif" alt="Image couverture livre {{$utilitaire->formaterTitreLivre($unLivreInteresse->titre)}}" class="fiche__vousPourriezAimerLivreImage">
                    <svg class="fiche__vousPourriezAimerLivreCote">
                        <use xlink:href="#review4" />
                    </svg>
                    <p class="fiche__vousPourriezAimerLivrePrix">{{$utilitaire->formaterPrix($unLivreInteresse->prix)}}</p>
                </article>
            </a>
            @endforeach
        </div>
    </section>
    <section class="fiche__commentaires">
        <h2 class="fiche__commentairesTitre"><span class="fiche__commentairesTitrePremiereLettre lettreBeige" aria-hidden="true">C</span>Commentaires</h2>
        <div class="fiche__commentaires__contenu">
            <div class="fiche__commentairesEvaluationGenerale">
                <div class="fiche__commentairesEvaluationGeneraleContenu">
                    <p class="fiche__commentairesEvaluationGeneraleCote">
                        <svg class="fiche__commentairesEvaluationGeneraleCoteIcone">
                            <use xlink:href="#review4" />
                        </svg>
                        <span class="fiche__commentairesEvaluationGeneraleCoteNombreEtoiles">4 sur 5</span>
                    </p>
                    <span class="fiche__commentairesEvaluationGeneraleNombreEvaluation">10 évaluations</span>
                </div>
                <div class="fiche__commentairesEvaluationDetails">
                    <div class="fiche__commentairesEvaluationDetailsEtoile">
                        <span class="fiche__commentairesEvaluationDetailsNombreEtoiles">5 étoiles</span>
                        <!-- rectangle avec bordure -->
                        <div class="fiche__commentairesEvaluationDetailsRectangleVide">
                            <!-- Rectangle plein -->
                            <span class="fiche__commentairesEvaluationDetailsRectanglePlein"></span>
                        </div>
                        <span class="fiche__commentairesEvaluationDetailsNbCommentaires">1</span>
                    </div>
                    <div class="fiche__commentairesEvaluationDetailsEtoile">
                        <span class="fiche__commentairesEvaluationDetailsNombreEtoiles">4 étoiles</span>
                        <!-- rectangle avec bordure -->
                        <div class="fiche__commentairesEvaluationDetailsRectangleVide">
                            <!-- Rectangle plein -->
                            <span class="fiche__commentairesEvaluationDetailsRectanglePlein"></span>
                        </div>
                        <span class="fiche__commentairesEvaluationDetailsNbCommentaires">9</span>
                    </div>
                    <div class="fiche__commentairesEvaluationDetailsEtoile">
                        <span class="fiche__commentairesEvaluationDetailsNombreEtoiles">3 étoiles</span>
                        <!-- rectangle avec bordure -->
                        <div class="fiche__commentairesEvaluationDetailsRectangleVide">
                            <!-- Rectangle plein -->
                            <span class="fiche__commentairesEvaluationDetailsRectanglePlein"></span>
                        </div>
                        <span class="fiche__commentairesEvaluationDetailsNbCommentaires">1</span>
                    </div>
                    <div class="fiche__commentairesEvaluationDetailsEtoile">
                        <span class="fiche__commentairesEvaluationDetailsNombreEtoiles">2 étoiles</span>
                        <!-- rectangle avec bordure -->
                        <div class="fiche__commentairesEvaluationDetailsRectangleVide">
                            <!-- Rectangle plein -->
                            <span class="fiche__commentairesEvaluationDetailsRectanglePlein"></span>
                        </div>
                        <span class="fiche__commentairesEvaluationDetailsNbCommentaires">1</span>
                    </div>
                    <div class="fiche__commentairesEvaluationDetailsEtoile">
                        <span class="fiche__commentairesEvaluationDetailsNombreEtoiles">1 étoile</span>
                        <!-- rectangle avec bordure -->
                        <div class="fiche__commentairesEvaluationDetailsRectangleVide">
                            <!-- Rectangle plein -->
                            <span class="fiche__commentairesEvaluationDetailsRectanglePlein"></span>
                        </div>
                        <span class="fiche__commentairesEvaluationDetailsNbCommentaires">1</span>
                    </div>
                </div>

            </div>
            <div class="fiche__commentairesTextes">
                <article class="fiche__commentairesTextesArticle">
                    <article class="fiche__commentairesTextesInfos">
                        <header class="fiche__commentairesTextesInfosTitre">J'ai adoré ce livre ! Je vous le recommande.</header>
                        <svg class="fiche__commentairesTextesInfosEtoiles">
                            <use xlink:href="#review4" />
                        </svg>
                        <footer class="fiche__commentairesTextesInfosDate">28 septembre 2019</footer>
                    </article>
                    <div class="fiche__commentairesTextesUsager">
                        <svg class="iconeUtilisateur">
                            <use xlink:href="#person" />
                        </svg>
                        <p class="fiche__commentairesTextesUsagerNom">Marie-Li Durand</p>
                    </div>
                </article>
                <article class="fiche__commentairesTextesArticle">
                    <article class="fiche__commentairesTextesInfos">
                        <header class="fiche__commentairesTextesInfosTitre">J’ai adoré ce livre ! Les illustrations sont superbes et donnent le goût de voyager au Canada. </header>
                        <svg class="fiche__commentairesTextesInfosEtoiles">
                            <use xlink:href="#review4" />
                        </svg>
                        <footer class="fiche__commentairesTextesInfosDate">2 septembre 2019</footer>
                    </article>
                    <div class="fiche__commentairesTextesUsager">
                        <svg class="iconeUtilisateur">
                            <use xlink:href="#person" />
                        </svg>
                        <p class="fiche__commentairesTextesUsagerNom">Élody Levasseur-Côté</p>
                    </div>
                </article>
                <article class="fiche__commentairesTextesArticle">
                    <article class="fiche__commentairesTextesInfos">
                        <header class="fiche__commentairesTextesInfosTitre">J’ai adoré ce livre ! Je vous le recommande.</header>
                        <svg class="fiche__commentairesTextesInfosEtoiles">
                            <use xlink:href="#review4" />
                        </svg>
                        <footer class="fiche__commentairesTextesInfosDate">28 septembre 2019</footer>
                    </article>
                    <div class="fiche__commentairesTextesUsager">
                        <svg class="iconeUtilisateur">
                            <use xlink:href="#person" />
                        </svg>
                        <p class="fiche__commentairesTextesUsagerNom">Gabriel Chouinard-Létourneau</p>
                    </div>
                </article>
                <a href="#" class="fiche__commentairesTous">Voir tous les commentaires +</a>
            </div>
        </div>
        <button type="button" class="fiche__commentairesBouton boutonOrangeSecondaire">Écrire un commentaire</button>
    </section>
    <!-- À changer pour des données dynamiques -->
    @if($panier->getLivre() != null)
        <aside class="fiche__ajoutPanier fiche__ajoutPanier">
        <p class="fiche__ajoutPanierFermer">
            <span class="fiche__ajoutPanierFermerTexte">Fermer</span>
            <svg class="fiche__ajoutPanierFermerIcone">
                <use xlink:href="#menuClose" />
            </svg>
        </p>
        <p class="fiche__ajoutPanierRetro"><span>{{$_GET['quantite']}}</span> article(s)
            a été ajouté à votre panier</p>
        <div class="fiche__ajoutPanier__infosLivre">
            <div class="fiche__ajoutPanier__infosLivreTextes">
                <span class="fiche__ajoutPanier__infosLivreTextesTitre">{{$panier->getLivre()->titre}}</span>
                @foreach($panier->getLivre()->getAuteurs() as $auteur)
                    <span class="fiche__ajoutPanier__infosLivreTextesAuteurs">{{$auteur->getNomPrenom()}}</span>
                @endforeach
                <span class="fiche__ajoutPanier__infosLivreTextesPrix">{{$utilitaire->formaterPrix($panier->getLivre()->prix)}}</span>
                <p class="fiche__ajoutPanier__infosLivreTextesVersionImprimee">1x version imprimée</p>
                <p class="fiche__ajoutPanier__infosLivreTextesVersionNumerique">1x version numérique</p>
            </div>

            <img src="{{$utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($panier->getLivre()->isbn).'1_w80.jpg', $panier->getLivre())}}@if($utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($panier->getLivre()->isbn).'1_w80.jpg', $panier->getLivre()) != '../ressources/liaisons/images/couverture_alternative.svg')"
                 srcset="../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($panier->getLivre()->isbn)}}1_w80.jpg 1x,../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($panier->getLivre()->isbn)}}1_w160.jpg 2x @endif" alt="Image couverture livre" class="fiche__ajoutPanier__infosLivreImage">
        </div>
        <div class="fiche__ajoutPanier__infosPanier">
            <p class="fiche__ajoutPanier__infosPanierNbArticles">Nombre d'articles total : {{$panier->getNombreTotalItemsDifferents()}}</p>
            <p class="fiche__ajoutPanier__infosPanierSousTotal">Sous-total : {{$utilitaire->formaterPrix($panier->getMontantSousTotal())}}</p>
        </div>
        <p class="fiche__ajoutPanierVoirPanier">
            <a href="index.php?controleur=panier&action=fiche" class="fiche__ajoutPanierVoirPanierLien">Voir mon panier</a>
            <svg class="fiche__ajoutPanierVoirPanierIcone">
                <use xlink:href="#arrowRight" />
            </svg>
        </p>
        <form
                @if($client != null)
                    action="index.php?controleur=livraison&action=afficher"
                @else
                    action="index.php?controleur=client&action=connexion"
                @endif
                method="post">
                    <button type="submit" class="fiche__ajoutPanierPasserCommande boutonOrangePrincipal">Passer la commande</button>
            </form>
    </aside>
    @endif
    </div>
@endsection

