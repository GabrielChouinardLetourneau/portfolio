/**
 * @file : Ce fichier permet d'ouvrir et de fermer l'accordéon dans la section critiques et d'afficher le texte complet de la description
 * @author : Marie-Li Durand
 */

var accordeon = {

    refTitre: $(".fiche__critiquesContenuTitre"),
    refSvg: $(".fiche__critiquesContenuTitre").find("svg"),
    refNbFois: 0,

    initialiser: function () {

        $('.fiche__descriptionTexteComplet').addClass("fiche__descriptionTexteComplet--cache");

        $('.fiche__descriptionLireLaSuite').on('click', this.afficherReduireTexte.bind(this));

        $("<span class='fiche__critiquesIcone plus'></span>").insertAfter(".fiche__critiquesContenuTitreTexte");

        $(".fiche__commandeBouton").on('click', this.afficherAjoutPanier.bind(this));

        $('.fiche__ajoutPanierFermer').on('click', this.fermerAjoutPanier.bind(this));

        $("#carteCredit").change(function () {
            if ($(this).prop(':checked', true)) {
                $(".facturation__informationsPaiementTypeCarteCreditChoix").removeClass("caché");
                $(".facturation__informationsPaiementTypeCarteCreditChoix").addClass("affiché");
            }
        });

        $("#paypal").change(function () {
            if ($(this).prop(':checked', true)) {
                $(".facturation__informationsPaiementTypeCarteCreditChoix").removeClass("affiché");
                $(".facturation__informationsPaiementTypeCarteCreditChoix").addClass("caché");
            }
        });

        this.reinitialiserAccordeon();
        this.refTitre.on('click', this.ouvrirFermerAccordeon.bind(this));

    },
    reinitialiserAccordeon: function () {

        this.refTitre.removeClass("accordeon--ouvert");
        this.refTitre.addClass("accordeon--ferme");

        $('.fiche__critiquesContenuTitre').find('.fiche__critiquesIcone').removeClass('moins').addClass("plus");

        $('.fiche__critiquesContenuTexte').addClass("cachee");

        this.refTitre.attr("aria-expanded", "false");

    },
    ouvrirFermerAccordeon: function (evenement) {
        console.log("allo");
        this.refNbFois += 1;
        if ($(evenement.currentTarget).hasClass('fiche__critiquesContenuTitre accordeon--ferme')) {
            this.reinitialiserAccordeon();
            $(evenement.currentTarget).removeClass('accordeon--ferme');
            $(evenement.currentTarget).addClass('accordeon--ouvert');

            $(evenement.currentTarget).find('.fiche__critiquesIcone').removeClass("plus").addClass("moins");

            $(evenement.currentTarget).closest('.fiche__critiquesContenu').find('.fiche__critiquesContenuTexte').removeClass("cachee");

            $(evenement.currentTarget).attr("aria-expanded", "true");
        }
        else {
            this.reinitialiserAccordeon();
            $(evenement.currentTarget).attr("aria-expanded", "false");
        }
    },
    afficherReduireTexte: function () {

        if ($('.fiche__descriptionTexteComplet').hasClass('fiche__descriptionTexteComplet--cache')) {
            var texte = "";

            texte = $('.fiche__descriptionTexteCoupe').text();

            texte = texte.trim();

            texte = texte.substring(0, texte.length - 3);

            $('.fiche__descriptionTexteCoupe').text(texte);

            $('.fiche__descriptionTexteComplet').removeClass('fiche__descriptionTexteComplet--cache');
            $('.fiche__descriptionTexteComplet').addClass('fiche__descriptionTexteComplet--affiche');

            $('.fiche__descriptionLireLaSuite').html("Réduire");

        }
        else {
            var texte = "";

            texte = $('.fiche__descriptionTexteCoupe').text();

            texte = texte + "...";

            $('.fiche__descriptionTexteCoupe').text(texte);

            $('.fiche__descriptionTexteComplet').removeClass('fiche__descriptionTexteComplet--affiche');
            $('.fiche__descriptionTexteComplet').addClass('fiche__descriptionTexteComplet--cache');
            $('.fiche__descriptionLireLaSuite').html("Lire la suite +");

        }
    },
    afficherAjoutPanier: function (evenement) {
        if ($('.fiche__ajoutPanier').hasClass("fiche__ajoutPanier--cache")) {
            $('.fiche__ajoutPanier').removeClass("fiche__ajoutPanier--cache");
        }
    },
    fermerAjoutPanier: function () {
        if (!$('.fiche__ajoutPanier').hasClass("fiche__ajoutPanier--cache")) {
            $('.fiche__ajoutPanier').addClass("fiche__ajoutPanier--cache");
        }
    }


}