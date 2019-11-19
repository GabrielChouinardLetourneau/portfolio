/**
 * @file    Un menu mobile accordéon jQuery en amélioration progressive.
 * @author Ève Février <eve.fevrier@cegep-ste-foy.qc.ca>
 * @author Yves Hélie <yves.helie@cegep-ste-foy.qc.ca>
 * @version 1.4
 */

//*******************
// Déclaration d'objet(s)
//*******************

var menuAccordeon = {

    refEntete: $('.entete'),
    refMenu: $('.entete .menu'),

    btnMenu : null,

    lblOuvrir : 'Menu',
    lblFermer : 'Fermer',

    configurerNav: function ()
    {
        // Création du libellé qui sera utilisé de base pour tous les boutons
        var libelle = $('<span>').addClass('screen-reader-only').html(this.lblOuvrir);

       this.refEntete.addClass('entete--ferme');

        // On ajoute le bouton pour le menu mobile

        this.btnMenu = $('<button>');
        this.btnMenu.addClass('menu__btnMenu');
        this.btnMenu.addClass('menu__btnMenu--ferme');


        // Création des boutons qui seront utilisés par le menu mobile
        this.refMenu.prepend(this.btnMenu);
        $('.menu__btnMenu').html = "Menu";


        // On ajoute la classe --ferme au menu en général; par défaut il est caché avec JS
        this.refMenu.addClass('menu--ferme');


        // Création de l'écouteur d'événement pour le bouton du menu mobile
        this.refMenu.find('.menu__btnMenu').on('click', this.ouvrirFermerMenu.bind(this));

    },

    /**
     * Méthode pour basculer l'affichage du menu mobile en se basant sur la classe --ferme
     * @param evenement
     */

    ouvrirFermerMenu: function (evenement)
    {
        // Bascule de l'état du bouton
        $(evenement.currentTarget).toggleClass('menu--ferme');

        // Bascule de l'état du menu
        this.refMenu.toggleClass("menu--ferme");

        // Changement du libellé du bouton du menu mobile
        if($(evenement.currentTarget).hasClass("menu--ferme"))
        {
            $(evenement.currentTarget).find('.libelleMenu').html(this.lblFermer);
            this.refEntete.removeClass('entete--ferme').addClass('entete--ouvert');
            $('.entete__recherche').addClass("cache");
        }
        else
        {
            this.refEntete.removeClass('entete--ouvert').addClass('entete--ferme');
            $('.entete__recherche').removeClass("cache");
        }
    },

    /**
     * Méthode pour basculer l'affichage des accordéons en se basant sur la classe --ferme
     * @param evenement
     */

    ouvrirFermerAccordeon: function (evenement)
    {
        console.log('ouvrirFermerAccordeon');

        // Bascule de l'état de la sous-liste
       // $(evenement.currentTarget).next().toggleClass("menu__sousListe--ferme");


        // Changement du libellé du bouton accordéon


        if($(evenement.currentTarget).hasClass('menu__btnAccordeon--ferme')){
            $(evenement.currentTarget).find('.screen-reader-only').html(this.lblOuvrir);
        }
        else {
            $(evenement.currentTarget).find('.screen-reader-only').html(this.lblFermer);
        }


    }
};