@extends('gabarit')

@section('contenu')
    @include('fragments.filariane')
    <section class="catalogue" id="contenu">
        <h1 class="catalogue__titre souligneRouge"><span class="lettreBeige">C</span>Catalogue</h1>
        <div class="catalogue__contenu">
            <aside role="complementary" class="catalogue__categoriesDesktop">
                <div>
                    <h2 class="catalogue__categoriesTitre"><span class="lettreBeige">C</span>Catégories</h2>
                    <a href="./index.php?controleur=livre&action=catalogue" class="catalogue__categoriesBtn @if(!isset($_GET['id_categorie'])) catalogue__categoriesBtn--actif
                    @endif">Toutes les catégories</a>
                    @foreach ($toutesCategories as $categorie)
                        <a href="./index.php?controleur=livre&action=catalogue&id_categorie={{$categorie -> id}}#contenu" class="catalogue__categoriesBtn @if($_GET['id_categorie'] == $categorie -> id) catalogue__categoriesBtn--actif
                        @endif">{{$categorie -> nom_fr}}</a>
                    @endforeach
                    <a href="#" id="plusCategories">Afficher toutes les catégories +</a>
                </div>
            </aside>
            <div class="catalogue__conteneur">
                <div class="catalogue__interactions">
                    <div class="catalogue__interactionsFirstRow">
                        <div class="catalogue__tri">
                            @if (isset($_GET['id_categorie']))
                                <form action="./index.php?controleur=livre&action=catalogue&id_categorie={{$idCategorieActuelle}}#contenu" method="POST">
                                    <label for="tri" class="catalogue__triLabel">Trier par</label>
                                    <div class="catalogue__triParentRelative">
                                        <select name="tri" id="tri" class="catalogue__triSelect">
                                            <option value="AZ">A-Z</option>
                                            <option value="ZA">Z-A</option>
                                            <option value="asc$">Prix ascendant</option>
                                            <option value="des$">Prix descendant</option>
                                        </select>
                                    </div>
                                    <button id="tri" class="catalogue_triBtn">Trier</button>
                                </form>
                            @elseif (isset($_GET['parution_id']))
                                <form action="./index.php?controleur=livre&action=catalogue&parution_id={{$idParutionActuelle}}#contenu" method="POST">
                                <div class="catalogue__triParentRelative">
                                    <select name="tri" id="tri">
                                        <option value="AZ">A-Z</option>
                                        <option value="ZA">Z-A</option>
                                        <option value="asc$">Prix ascendant</option>
                                        <option value="des$">Prix descendant</option>
                                    </select>
                                </div>
                                <button id="tri" class="boutonOrangePrincipal">Trier</button>
                            </form>
                            @else
                                <form action="./index.php?controleur=livre&action=catalogue" method="POST">
                                    <label for="tri" class="catalogue__triLabel">Trier par</label>
                                    <div class="catalogue__triParentRelative">
                                        <select name="tri" id="tri" class="catalogue__triSelect">
                                            <option value="AZ">A-Z</option>
                                            <option value="ZA">Z-A</option>
                                            <option value="asc$">Prix ascendant</option>
                                            <option value="des$">Prix descendant</option>
                                        </select>
                                    </div>
                                    <button id="tri" class="boutonOrangePrincipal">Trier</button>
                                </form>
                            @endif
                        </div>
                        <aside role="complementary" class="catalogue__categories catalogue__categoriesMobile">
                            <button class="catalogue__categoriesMobileBtnClosed" id="categoriesMenu">
                                <svg class="catalogue__categoriesMobileIcon">
                                    <use xlink:href="#filter" />
                                </svg>
                                <p class="catalogue__categoriesMobileIconLibelle">Catégories</p>
                            </button>
                            <div class="catalogue__categoriesMobileBtnOpen" id="categoriesMobileContenu">
                                <svg class="catalogue__categoriesMobileIcon">
                                    <use xlink:href="#filterOpen" />
                                </svg>
                                <p class="catalogue__categoriesMobileIconLibelle">fermer</p>
                            </div>
                            <div class="catalogue__categoriesMobileContenu">
                                <h2 class="catalogue__categoriesTitre"><span class="lettreBeige">C</span>Catégories</h2>
                                <a href="./index.php?controleur=livre&action=catalogue" class="catalogue__categoriesBtn">Toutes les catégories</a>
                                @foreach ($toutesCategories as $categorie)
                                    <p><a href="./index.php?controleur=livre&action=catalogue&id_categorie={{$categorie -> id}}#contenu" class="catalogue__categoriesBtn">{{$categorie -> nom_fr}}</a></p>
                                @endforeach
                                <a href="#" id="plusCategories">Afficher toutes les catégories +</a>
                            </div>
                        </aside>
                        <div class="pagination">
                            @include('fragments.pagination')
                        </div>
                    </div>
                    <div class="catalogue__interactionsSecondRow">
                        <div class="catalogue__affichage">
                            <p>Mode d'affichage</p>
                            <a href="#">
                                <svg class="catalogue__affichageList">
                                    <use xlink:href="#list" />
                                </svg>
                            </a>
                            <a href="#">
                                <svg class="catalogue__affichageGrid">
                                    <use xlink:href="#grid" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @foreach($livres as $livre)
                    <article class="catalogue__livre catalogue__livreBloc">
                        <a href="./index.php?controleur=livre&action=fiche&id={{ $livre->id }}&isbn={{ $livre->isbn }}
                            @if(isset( $_GET['id_categorie'] ))
                                &id_categorie={{ $_GET['id_categorie'] }}
                            @endif
                        &parution_id={{ $livre->parution_id }}">
                            <header>
                                <img class="catalogue__livreBlocImg" 
                                src="{{$utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($livre->isbn).'1_w130.jpg', $livre)}}@if($utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($livre->isbn).'1_w130.jpg', $livre) == '../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($livre->isbn).'1')_w130.jpg @endif" 
                                srcset="{{$utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($livre->isbn).'1_w130.jpg', $livre)}}@if($utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($livre->isbn).'1_w130.jpg', $livre) == '../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($livre->isbn).'1')_w130.jpg 1x @endif,
                                {{$utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($livre->isbn).'1_w260.jpg', $livre)}}@if($utilitaire->verifierNomFichierImage('../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($livre->isbn).'1_w260.jpg', $livre) == '../ressources/liaisons/images/couverture_livres_optim/L'. $utilitaire->ISBNToEAN($livre->isbn).'1')_w260.jpg 2x @endif"
                                alt="Image du livre {{$livre->titre}}">
                                <p class="catalogue__livreTitre catalogue__livreBlocTitre">{{$livre->titre}}</p>
                            </header>
                            <ul class="catalogue__livreBlocAuteurs catalogue__livreAuteurs">
                                <span>Par :</span>
                            @foreach($livre->getAuteurs() as $auteur)
                                <li>
                                    {{$auteur->getNomPrenom()}}
                                </li>
                            @endforeach
                            </ul>
                            <svg class="catalogue__livreBlocCritique catalogue__livreCritique">
                                <use xlink:href="#review4" />
                            </svg>
                            <p class="catalogue__livreBlocPrix catalogue__livrePrix">{{$livre->prix}}$</p>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
        <div class="pagination pagination__basDePage">
            @include('fragments.pagination')
        </div>
    </section>    
@endsection
