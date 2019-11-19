@extends('gabarit')

@section('contenu')
    <h1 class="screen-reader-only">Accueil</h1>
    <div class="accueil__banniere">
        <div class="accueil__banniereCadre">
            <p>De mercredi à dimanche seulement</p>
            <p class="accueil__banniereCadreRabais">Jusqu'à 55% de rabais</p>
            <p>Vendredi noir 2019</p>
        </div>
    </div>
        <section class="accueil__coupDeCoeur">
            <h2 class="h2 souligneRouge"><span class="lettreBeige" aria-hidden="true">C</span>Coups de coeur</h2>
            <div class="accueil__coupDeCoeurConteneur">
                @foreach($coupsDeCoeur as $coupDeCoeur)
                    <a class="accueil__coupDeCoeurLien" href="index.php?controleur=livre&action=fiche&id={{$coupDeCoeur->id}}&isbn={{$coupDeCoeur->isbn}}">
                        <article class="accueil__coupDeCoeurLivre">
                            <img class="accueil__coupDeCoeurLivreImg" 
                            src="../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($coupDeCoeur->isbn)}}1_w130.jpg" 
                            srcset="../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($coupDeCoeur->isbn)}}1_w130.jpg 1x,
                            ../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($coupDeCoeur->isbn)}}1_w260.jpg 2x"
                            alt="Image du livre {{$coupDeCoeur->titre}}.">
                            <div>
                                <header>
                                    <p class="h3 accueil__coupDeCoeurLivreTitre">{{$utilitaire->formaterTitreLivre($coupDeCoeur->titre)}}</p>
                                </header>
                                <p class="accueil__coupDeCoeurLivreAuteur">
                                    par
                                    @foreach($coupDeCoeur->getAuteurs() as $auteur)
                                        {{$auteur->getNomPrenom()}}
                                    @endforeach
                                </p>
                                <span class="accueil__coupDeCoeurLivreCote">
                                    <svg class="iconeReview">
                                        <use xlink:href="#review5" />
                                    </svg>
                                </span>
                                <div class="accueil__coupDeCoeurLivrePrix">
                                    <p class="accueil__coupDeCoeurLivrePrixNormal">{{number_format($coupDeCoeur->prix,'2',',', ' ')}}$</p>
                                    <p class="accueil__coupDeCoeurLivrePrixRabais">{{number_format((65*((int)$coupDeCoeur->prix)/100),'2',',', ' ')}}$</p>
                                </div>
                            </div>
                        </article>
                    </a>
                @endforeach
            </div>
    </section>
    <section class="accueil__nouveautes">
        <h2 class="h2 souligneRouge"><span class="lettreBeige" aria-hidden="true">N</span>Nouveautés</h2>
        <div class="accueil__nouveautesCaroussel regular slider">
            @foreach($nouveautes as $nouveaute)
                <a class="accueil__nouveautesCarousselLien" href="index.php?controleur=livre&action=fiche&id={{$nouveaute->id}}&isbn={{$nouveaute->isbn}}&parution_id=3">
                    <article class="accueil__nouveautesCarousselLivre">
                        <img class="accueil__nouveautesCarousselLivre" 
                            src="../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($nouveaute->isbn)}}1_w130.jpg" 
                            srcset="../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($nouveaute->isbn)}}1_w130.jpg 1x,
                            ../ressources/liaisons/images/couverture_livres_optim/L{{$utilitaire->ISBNToEAN($nouveaute->isbn)}}1_w260.jpg 2x"
                            alt="Image du livre {{$nouveaute->titre}}.">
                        <header>
                            <p class="h3 accueil__nouveautesCarousselLivreTitre">{{$utilitaire->formaterTitreLivre($nouveaute->titre)}}</p>
                        </header>
                        <p class="accueil__nouveautesCarousselLivreAuteur">
                            par
                            @foreach($nouveaute->getAuteurs() as $auteur)
                                {{$auteur->getNomPrenom()}}<br>
                            @endforeach
                        </p>
                        <span class="accueil__nouveautesCarousselLivreCote">
                            <svg class="iconeReview">
                                <use xlink:href="#review0" />
                            </svg>
                        </span>
                        <p class="accueil__nouveautesCarousselLivrePrix">{{number_format($nouveaute->prix,'2',',', ' ')}}$</p>
                    </article>
                </a>
            @endforeach
        </div>
        <a class="boutonOrangePrincipal accueil__nouveautesBtn" href="index.php?controleur=livre&action=catalogue&parution_id=3">TOUTES LES NOUVEAUTÉS</a>
    </section>
    <section class="accueil__actualitesLitteraires">
        <h2 class="h2 accueil__actualitesLitterairesTitre souligneRouge"><span class="lettreBeige" aria-hidden="true">A</span>Actualités littéraires</h2>
        <div class="accueil__actualitesLitterairesConteneur">
            @foreach($actualites as $actualite)
                <article class="accueil__actualitesLitterairesLivreDesktop desktop-only">
                    <div class="accueil__actualitesLitterairesLivreDesktopTexte">
                        <div>
                            <div class="accueil__actualitesLitterairesLivreDesktopDate">
                                <p class="h4">{{$utilitaire->formaterDate($actualite->date)}}</p>
                            </div>
                            <p class="h3 accueil__actualitesLitterairesLivreDesktopTitre">{{$actualite->titre}}</p>
                            <p class="accueil__actualitesLitterairesLivreDesktopAuteur">par {{$actualite->getAuteur()->getNomPrenom()}}
                            <p class="accueil__actualitesLitterairesLivreDesktopDescription">{{$utilitaire->reduireTexte($actualite->texte, 300)}}</p>
                        </div>
                    </div>
                    <div>
                        <img class="accueil__actualitesLitterairesLivreDesktopImg" 
                        src="../ressources/liaisons/images/auteurs/auteur_{{$actualite->id_auteur}}_{{strtolower($actualite->getAuteur()->nom)}}-{{strtolower($actualite->getAuteur()->prenom)}}_w200.jpg" 
                        srcset="../ressources/liaisons/images/auteurs/auteur_{{$actualite->id_auteur}}_{{strtolower($actualite->getAuteur()->nom)}}-{{strtolower($actualite->getAuteur()->prenom)}}_w200.jpg 1x,
                        ../ressources/liaisons/images/auteurs/auteur_{{$actualite->id_auteur}}_{{strtolower($actualite->getAuteur()->nom)}}-{{strtolower($actualite->getAuteur()->prenom)}}_w400.jpg 2x"
                        alt="Image de l'auteur {{$actualite->getAuteur()->prenom}} {{$actualite->getAuteur()->nom}}.">
                        <button class="boutonOrangeSecondaire accueil__actualitesLitterairesLivreDesktopBtn" type="button">EN SAVOIR PLUS<span class="screen-reader-only">sur l'arcticle « {{$actualite->titre}} »'</span></button>
                    </div>
                </article>
            @endforeach
            @foreach($actualites as $actualite)
                <article class="accueil__actualitesLitterairesLivreMobile mobile-only">
                    <div class="accueil__actualitesLitterairesLivreMobileDateImg">
                        <div class="accueil__actualitesLitterairesLivreMobileInfo">    
                            <div>
                                <div class="accueil__actualitesLitterairesLivreMobileInfoDate">
                                    <p class="h4">{{$utilitaire->formaterDate($actualite->date)}}</p>
                                </div>                        
                                <div class="accueil__actualitesLitterairesLivreMobileInfoAuteur">
                                    par {{$actualite->getAuteur()->getNomPrenom()}}
                                </div>
                            </div>
                        </div>
                        <img class="accueil__actualitesLitterairesLivreMobileImg" 
                        src="../ressources/liaisons/images/auteurs/auteur_{{$actualite->id_auteur}}_{{strtolower($actualite->getAuteur()->nom)}}-{{strtolower($actualite->getAuteur()->prenom)}}_w200.jpg" 
                        srcset="../ressources/liaisons/images/auteurs/auteur_{{$actualite->id_auteur}}_{{strtolower($actualite->getAuteur()->nom)}}-{{strtolower($actualite->getAuteur()->prenom)}}_w200.jpg 1x,
                        ../ressources/liaisons/images/auteurs/auteur_{{$actualite->id_auteur}}_{{strtolower($actualite->getAuteur()->nom)}}-{{strtolower($actualite->getAuteur()->prenom)}}_w400.jpg 2x"    
                            alt="Image de l'auteur {{$actualite->getAuteur()->prenom}} {{$actualite->getAuteur()->nom}}.">
                    </div>
                    <div class="accueil__actualitesLitterairesLivreMobileTexte">
                        <p class="h3 accueil__actualitesLitterairesLivreMobileTitre">{{$actualite->titre}}</p>
                        <p class="accueil__actualitesLitterairesLivreMobileDescription">{{$utilitaire->reduireTexte($actualite->texte, 300)}}</p>
                    </div>
                    <button class="boutonOrangeSecondaire accueil__actualitesLitterairesLivreMobileBtn" type="button">EN SAVOIR PLUS<span class="screen-reader-only">sur l'arcticle « {{$actualite->titre}} »'</span></button>
                </article>
            @endforeach
        </div>
        <button class="boutonOrangePrincipal accueil__actualitesLitterairesBtn" type="button">TOUTES LES ACTUALITÉS</button>
    </section>
    <div class="accueil__prefooter">
        <div class="accueil__prefooterSection">
            <a class="accueil__prefooterSectionLien" href="#">
                <svg class="iconeJoin">
                    <use xlink:href="#joinUs" />
                </svg>
                <span class="accueil__prefooterSectionLienTexte">Nous joindre</span>
            </a>
        </div>
        <hr>
        <div class="accueil__prefooterSection">
            <a class="accueil__prefooterSectionLien" href="#">
                <svg class="iconeDelivery">
                    <use xlink:href="#freeDelivery" />
                </svg>  
                <span class="accueil__prefooterSectionLienTexte">Livraison gratuite</span>
            </a>
        </div>
        <hr>
        <div class="accueil__prefooterSection">
            <a class="accueil__prefooterSectionLien" href="#">
                <svg class="iconeCommunity">
                    <use xlink:href="#community" />
                </svg>
                <span class="accueil__prefooterSectionLienTexte">Communauté</span>
            </a>
        </div>
    </div>

@endsection