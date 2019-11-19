<div class="conteneur pied__conteneur">
    @if(isset($_GET['controleur']) == false)
        <ul class="pied__menu">
            <li class="pied__menuItem">
                <a href="index.php?controleur=livre&action=catalogue" class="pied__menuLien">Catalogue</a>
            </li>
            <li class="pied__menuItem">
                <a href="index.php?controleur=livre&action=meilleursvendeurs" class="pied__menuLien">Meilleurs vendeurs</a>
            </li>
            <li class="pied__menuItem">
                <a href="index.php?controleur=site&action=decouvrirtraces" class="pied__menuLien">Découvrir Traces</a>
            </li>
            <li class="pied__menuItem">
                <a href="index.php?controleur=livre&action=auteurs" class="pied__menuLien">Auteurs</a>
            </li>
            <li class="pied__menuItem">
                <a href="index.php?controleur=site&action=nousjoindre" class="pied__menuLien">Nous joindre</a>
            </li>
        </ul>
    @else
        @if($_GET['controleur'] != "livraison" && $_GET['controleur'] != "facturation" && $_GET['controleur'] != "validation" && $_GET['controleur'] != 'confirmation')
            <ul class="pied__menu">
                <li class="pied__menuItem">
                    <a href="index.php?controleur=livre&action=catalogue" class="pied__menuLien">Catalogue</a>
                </li>
                <li class="pied__menuItem">
                    <a href="index.php?controleur=livre&action=meilleursvendeurs" class="pied__menuLien">Meilleurs vendeurs</a>
                </li>
                <li class="pied__menuItem">
                    <a href="index.php?controleur=site&action=decouvrirtraces" class="pied__menuLien">Découvrir Traces</a>
                </li>
                <li class="pied__menuItem">
                    <a href="index.php?controleur=livre&action=auteurs" class="pied__menuLien">Auteurs</a>
                </li>
                <li class="pied__menuItem">
                    <a href="index.php?controleur=site&action=nousjoindre" class="pied__menuLien">Nous joindre</a>
                </li>
            </ul>
        @endif
    @endif
    <div class="pied__deuxiemeRangee">
        <a href="index.php?controleur=site&action=accueil" class="pied__deuxiemeRangeeLogo"></a>
        <div class="pied__nousJoindre">
            <p class="pied__nousJoindreTitre">Nous joindre</p>
            <p class="pied__nousJoindreLieu">
                <svg class="pied__nousJoindreLieuIcone">
                    <use xlink:href="#map" />
                </svg>
                <a href="#"><span>Trouver un magasin</span></a>
            </p>
            <p class="pied__nousJoindreTelephone">
                <svg class="pied__nousJoindreTelephoneIcone">
                    <use xlink:href="#call" />
                </svg>
                <a href="#"><span>1 (800) 999-8787</span></a>
            </p>
        </div>
        <div class="pied__suivezNous">
            <p class="pied__suivezNousTitre">Suivez-nous</p>
            <div class="pied__suivezNousIcones">
                <a href="https://www.facebook.com/" class="pied__suivezNousFacebook">
                    <span class="screen-reader-only">Facebook</span>
                    <svg class="pied__suivezNousFacebookIcone">
                        <use xlink:href="#facebook" />
                    </svg>
                </a>
                <a href="https://twitter.com/" class="pied__suivezNousTwitter">
                    <span class="screen-reader-only">Twitter</span>
                    <svg class="pied__suivezNousTwitterIcone">
                        <use xlink:href="#twitter" />
                    </svg>
                </a>
                <a href="https://www.instagram.com/" class="pied__suivezNousInstagram">
                    <span class="screen-reader-only">Instagram</span>
                    <svg class="pied__suivezNousInstagramIcone">
                        <use xlink:href="#instagram" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="pied__liens">
        <a href="#" class="pied__liensConditionsUtilisation">Conditions d'utilisation</a>
        <a href="#" class="pied__liensPolitiqueConfidentialite">Politique de confidentialité</a>
        <a href="#" class="pied__liensPolitiqueRetour">Politique de retour</a>
    </div>
    <p class="pied__siteSecurise">
        <svg class="pied__siteSecuriseIcone">
            <use xlink:href="#security" />
        </svg>
        <span class="pied__siteSecuriseTexte">Site sécurisé</span>
    </p>
    <p class="pied__credits">
        <small>© 2019 - Tous droits réservés - Librairie Traces</small>
    </p>
</div>