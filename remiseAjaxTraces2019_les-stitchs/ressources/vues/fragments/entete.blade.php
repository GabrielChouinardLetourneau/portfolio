<!--http://webaim.org/techniques/skipnav/-->
<div class="entete__cadre">
    <div class="conteneur">
        <a href="#contenu" class="visuallyhidden focusable">Aller au contenu</a>
        <div class="entete__contenu">
            <div class="entete__deuxiemeRangee mobile">
                <div class="entete__deuxiemeRangeeLogoPanier">
                    <a href="index.php?controleur=site&action=accueil" class="entete__deuxiemeRangeeLogo"></a>
                    @if(isset($_GET['controleur']) == false)
                        <a href="index.php?controleur=panier&action=fiche" class="entete__deuxiemeRangeePanier entete__deuxiemeRangeePanier--plein" aria-label="panier">
                            <svg class="iconePanier">
                                <use xlink:href="#cart" />
                            </svg>
                            @if(isset($_SESSION['panier']))
                                <span class="entete__deuxiemeRangeePanierNbArticles">{{$panier->getNombreTotalItems()}}</span>
                            @else
                                <span class="entete__deuxiemeRangeePanierNbArticles">0</span>
                            @endif
                        </a>
                    @else
                        @if($_GET['controleur'] != "livraison" && $_GET['controleur'] != "facturation" && $_GET['controleur'] != 'validation' && $_GET['controleur'] != 'confirmation')
                            <a href="index.php?controleur=panier&action=fiche" class="entete__deuxiemeRangeePanier entete__deuxiemeRangeePanier--plein" aria-label="panier">
                                <svg class="iconePanier">
                                    <use xlink:href="#cart" />
                                </svg>
                                @if(isset($_SESSION['panier']))
                                    <span class="entete__deuxiemeRangeePanierNbArticles">{{$panier->getNombreTotalItems()}}</span>
                                @else
                                    <span class="entete__deuxiemeRangeePanierNbArticles">0</span>
                                @endif
                            </a>
                        @endif
                    @endif
                </div>
                @if(isset($_GET['controleur']) == false)
                    <form action="#" method="post" class="entete__formulaireRecherche">
                    <div role="search" class="entete__recherche">
                        <p class="entete__rechercheSaisie">
                            <label for="recherche" class="screen-reader-only">Recherche</label>
                            <input type="text" class="entete__rechercheSaisieChamp">
                            <div class="zoneResultatsRecherche">
                                @include("fragments.recherche")
                            </div>
                        </p>
                        <div class="entete__rechercheCriteresRecherche">
                            <!-- Mettre le label en screen reader only -->
                            <label for="criteresRecherche" class="screen-reader-only">Critères de recherche</label>
                            <div class="entete__rechercheCriteresRechercheListe">
                                <select class="criteresRecherche">
                                    <option value="auteur">Auteur</option>
                                    <option value="sujet">Sujet</option>
                                    <option value="titre">Titre</option>
                                    <option value="isbn">ISBN</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="boutonOrangePrincipal entete__rechercheBouton" aria-label="rechercher">
                            <svg class="iconeRechercher">
                                <use xlink:href="#search" />
                            </svg>
                        </button>
                    </div>
                </form>
                @else
                    @if($_GET['controleur'] != "livraison" && $_GET['controleur'] != "facturation" && $_GET['controleur'] != "validation" && $_GET['controleur'] != 'confirmation')
                        <form action="#" method="post" class="entete__formulaireRecherche">
                            <div role="search" class="entete__recherche">
                                <p class="entete__rechercheSaisie">
                                    <label for="recherche" class="screen-reader-only">Recherche</label>
                                    <input type="text" class="entete__rechercheSaisieChamp">
                                    <div class="zoneResultatsRecherche">
                                        @include("fragments.recherche")
                                    </div>
                                </p>
                                <div class="entete__rechercheCriteresRecherche">
                                    <!-- Mettre le label en screen reader only -->
                                    <label for="criteresRecherche" class="screen-reader-only">Critères de recherche</label>
                                    <div class="entete__rechercheCriteresRechercheListe">
                                        <select class="criteresRecherche">
                                            <option value="auteur">Auteur</option>
                                            <option value="sujet">sujet</option>
                                            <option value="titre">Titre</option>
                                            <option value="isbn">ISBN</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="button" class="boutonOrangePrincipal entete__rechercheBouton" aria-label="rechercher">
                                    <svg class="iconeRechercher">
                                        <use xlink:href="#search" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    @endif
                @endif
            </div>
            <div class="entete__deuxiemeRangee table">
                <a href="index.php?controleur=site&action=accueil" class="entete__deuxiemeRangeeLogo"></a>
                @if(isset($_GET['controleur']) == false)
                    <form action="#" method="post" class="entete__formulaireRecherche">
                    <div role="search" class="entete__recherche">
                        <p class="entete__rechercheSaisie">
                            <label for="recherche" class="screen-reader-only">Recherche</label>
                            <input type="text" class="entete__rechercheSaisieChamp">
                            <div class="zoneResultatsRecherche">
                                @include("fragments.recherche")
                            </div>
                        </p>
                        <div class="entete__rechercheCriteresRecherche">
                            <!-- Mettre le label en screen reader only -->
                            <label for="criteresRecherche" class="screen-reader-only">Critères de recherche</label>
                            <div class="entete__rechercheCriteresRechercheListe">
                                <select class="criteresRecherche">
                                    <option value="auteur">Auteur</option>
                                    <option value="sujet">Sujet</option>
                                    <option value="titre">Titre</option>
                                    <option value="isbn">ISBN</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="boutonOrangePrincipal entete__rechercheBouton" aria-label="rechercher">
                            <svg class="iconeRechercher">
                                <use xlink:href="#search" />
                            </svg>
                        </button>
                    </div>
                </form>
                @else
                    @if($_GET['controleur'] != "livraison" && $_GET['controleur'] != "facturation" && $_GET['controleur'] != 'validation' && $_GET['controleur'] != 'confirmation')
                        <form action="#" method="post" class="entete__formulaireRecherche">
                            <div role="search" class="entete__recherche">
                                <p class="entete__rechercheSaisie">
                                    <label for="recherche" class="screen-reader-only">Recherche</label>
                                    <input type="text" class="entete__rechercheSaisieChamp">
                                    <div class="zoneResultatsRecherche">
                                        @include("fragments.recherche")
                                    </div>
                                </p>
                                <div class="entete__rechercheCriteresRecherche">
                                    <!-- Mettre le label en screen reader only -->
                                    <label for="criteresRecherche" class="screen-reader-only">Critères de recherche</label>
                                    <div class="entete__rechercheCriteresRechercheListe">
                                        <select class="criteresRecherche">
                                            <option value="auteur">Auteur</option>
                                            <option value="sujet">Sujet</option>
                                            <option value="titre">Titre</option>
                                            <option value="isbn">ISBN</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="button" class="boutonOrangePrincipal entete__rechercheBouton" aria-label="rechercher">
                                    <svg class="iconeRechercher">
                                        <use xlink:href="#search" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    @endif
                @endif
                @if(isset($_GET['controleur']) == false)
                    <a href="index.php?controleur=panier&action=fiche" class="entete__deuxiemeRangeePanier entete__deuxiemeRangeePanier--plein" aria-label="panier">
                        <svg class="iconePanier">
                            <use xlink:href="#cart" />
                        </svg>
                        @if(isset($_SESSION['panier']))
                            <span class="entete__deuxiemeRangeePanierNbArticles">{{$panier->getNombreTotalItems()}}</span>
                        @else
                            <span class="entete__deuxiemeRangeePanierNbArticles">0</span>
                        @endif
                    </a>
                @else
                    @if($_GET['controleur'] != "livraison" && $_GET['controleur'] != "facturation" && $_GET['controleur'] != 'validation' && $_GET['controleur'] != 'confirmation')
                        <a href="index.php?controleur=panier&action=fiche" class="entete__deuxiemeRangeePanier entete__deuxiemeRangeePanier--plein" aria-label="panier">
                            <svg class="iconePanier">
                                <use xlink:href="#cart" />
                            </svg>
                            @if(isset($_SESSION['panier']))
                                <span class="entete__deuxiemeRangeePanierNbArticles">{{$panier->getNombreTotalItems()}}</span>
                            @else
                                <span class="entete__deuxiemeRangeePanierNbArticles">0</span>
                            @endif
                        </a>
                    @endif
                @endif
            </div>
            @if(isset($_GET['controleur']) == false)
                <nav role="navigation" class="menu entete__menu entete__menuPrincipal" aria-label="Navigation principale">
            <ul class="entete__menuPrincipalListe">
                <li class="entete__menuPrincipalItem">
                    <a href="index.php?controleur=livre&action=catalogue" class="entete__menuPrincipalLien">Catalogue</a>
                </li>
                <li class="entete__menuPrincipalItem">
                    <a href="index.php?controleur=livre&action=meilleursvendeurs" class="entete__menuPrincipalLien">Meilleurs vendeurs</a>
                </li>
                <li class="entete__menuPrincipalItem">
                    <a href="index.php?controleur=site&action=decouvrirtraces" class="entete__menuPrincipalLien">Découvrir Traces</a>
                </li>
                <li class="entete__menuPrincipalItem">
                    <a href="index.php?controleur=livre&action=auteurs" class="entete__menuPrincipalLien">Auteurs</a>
                </li>
                <li class="entete__menuPrincipalItem">
                    <a href="index.php?controleur=site&action=nousjoindre" class="entete__menuPrincipalLien">Nous joindre</a>
                </li>
            </ul>
        </nav>
                <ul class="entete__menuSecondaire">
                @if($client != null)
                    <li class="entete__menuSecondaireItem">
                        <a href="index.php?controleur=client&action=deconnexion&id={{$client->id}}" class="entete__menuSecondaireLien">Se deconnecter</a>
                    </li>
                    <li class="entete__menuSecondaireItem">
                        <a href="#" class="entete__menuSecondaireLien">Bienvenue, {{$client->prenom}}</a>
                    </li>
                @else
                    <li class="entete__menuSecondaireItem">
                        <a href="index.php?controleur=client&action=connexion" class="entete__menuSecondaireLien">Se connecter</a>
                    </li>
                    <li class="entete__menuSecondaireItem">
                        <a href="#" class="entete__menuSecondaireLien">Mon compte</a>
                    </li>
                @endif
                <li class="entete__menuSecondaireItem">
                    <a href="#" class="entete__menuSecondaireLien">English</a>
                </li>
            </ul>
            @else
                @if($_GET['controleur'] != "livraison" && $_GET['controleur'] != "facturation" && $_GET['controleur'] != 'validation' && $_GET['controleur'] != 'confirmation')
                    <nav role="navigation" class="menu entete__menu entete__menuPrincipal" aria-label="Navigation principale">
                        <ul class="entete__menuPrincipalListe">
                            <li class="entete__menuPrincipalItem">
                                <a href="index.php?controleur=livre&action=catalogue" class="entete__menuPrincipalLien">Catalogue</a>
                            </li>
                            <li class="entete__menuPrincipalItem">
                                <a href="index.php?controleur=livre&action=meilleursvendeurs" class="entete__menuPrincipalLien">Meilleurs vendeurs</a>
                            </li>
                            <li class="entete__menuPrincipalItem">
                                <a href="index.php?controleur=site&action=decouvrirtraces" class="entete__menuPrincipalLien">Découvrir Traces</a>
                            </li>
                            <li class="entete__menuPrincipalItem">
                                <a href="index.php?controleur=livre&action=auteurs" class="entete__menuPrincipalLien">Auteurs</a>
                            </li>
                            <li class="entete__menuPrincipalItem">
                                <a href="index.php?controleur=site&action=nousjoindre" class="entete__menuPrincipalLien">Nous joindre</a>
                            </li>
                        </ul>
                    </nav>
                    <ul class="entete__menuSecondaire">
                        @if($client != null)
                            <li class="entete__menuSecondaireItem">
                                <a href="index.php?controleur=client&action=deconnexion&id={{$client->id}}" class="entete__menuSecondaireLien">Se deconnecter</a>
                            </li>
                            <li class="entete__menuSecondaireItem">
                                <a href="#" class="entete__menuSecondaireLien">Bienvenue, {{$client->prenom}}</a>
                            </li>
                        @else
                            <li class="entete__menuSecondaireItem">
                                <a href="index.php?controleur=client&action=connexion" class="entete__menuSecondaireLien">Se connecter</a>
                            </li>
                            <li class="entete__menuSecondaireItem">
                                <a href="#" class="entete__menuSecondaireLien">Mon compte</a>
                            </li>
                        @endif
                        <li class="entete__menuSecondaireItem">
                            <a href="#" class="entete__menuSecondaireLien">English</a>
                        </li>
                    </ul>
                @endif
            @endif
        </div>
    </div>
</div>


