define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var AjaxMandatCMajQuantite = /** @class */ (function () {
        function AjaxMandatCMajQuantite() {
            this.executerAjax_lier = null;
            this.executerAjax_lier = this.executerAjax.bind(this);
            this.initialiser();
        }
        AjaxMandatCMajQuantite.retournerResultat = function (data, textStatus, jqXHR, id) {
            var donnees = data;
            var arrDonnees = JSON.parse(donnees);
            var idLivre = id;
            // Trouve le préfixe : "m-" ou "t-" selon la résolution de l'écran
            var idPrefixe = id.substring(0, 2);
            var isbn = id.substring(2, id.length);
            var champCourant = document.getElementById(id);
            // Met à jour le montant sous total
            var champMontantSommaireSousTotal = $(champCourant).closest('.panier').find('.m-panier__sousTotalPrixMontant');
            $(champMontantSommaireSousTotal).text(arrDonnees["montantSousTotal"]);
            // Met à jour le montant total de l'item
            var champMontantTotalItem = $(champCourant).closest('.panier__infosLivresContenu').find('.' + idPrefixe + 'panier__infosLivresContenuAutresSousTotal');
            $(champMontantTotalItem).text(arrDonnees["montantTotalItem"]);
            // Met à jour le montant du sous-total
            var champMontantSousTotal = $(champCourant).closest('.panier__contenu').find('.panier__commandePrixSousTotalMontant');
            $(champMontantSousTotal).text(arrDonnees["montantSousTotal"]);
            // Met à jour le montant de la TPS
            var champMontantTps = $(champCourant).closest('.panier__contenu').find('.panier__commandePrixTaxesMontant');
            $(champMontantTps).text(arrDonnees["montantTps"]);
            // Met à jour le montant total
            var champMontantTotal = $(champCourant).closest('.panier__contenu').find('.panier__commandeTotalPrixMontant');
            $(champMontantTotal).text(arrDonnees["montantTotal"]);
            // Met à jour le nombre d'articles dans le titre de la page
            var champNbArticlesPanierTitre = $(champCourant).closest('.panier').find('.panier__titreNbItems');
            $(champNbArticlesPanierTitre).text(arrDonnees["nbTotalArticles"]);
            // Met à jour le nombre d'articles dans l'en-tête
            var champNbArticlesPanier = $('body').find('.entete__deuxiemeRangeePanierNbArticles');
            $(champNbArticlesPanier).text(arrDonnees["nbTotalArticles"]);
            // Met à jour le message de livraison
            var champMessageLivraison = $('.panier').find('.panierMessageLivraisonGratuite');
            if (parseInt(arrDonnees['montantSousTotal']) > 50) {
                $(champMessageLivraison).html("Vous avez le droit à la livraison <span class='panierMessageLivraisonGratuiteEnGras'>gratuite</span>");
            }
            else {
                $(champMessageLivraison).html("Livraison <span class='panierMessageLivraisonGratuiteEnGras'>gratuite</span> à partir de 50,00$ avant taxes");
            }
            // Met à jour la liste déroulante du mode de livraison
            if (parseInt(arrDonnees["montantSousTotal"]) > 50) {
                $(champCourant).closest('.panier__contenu').find('select option[value="gratuit"]').removeAttr('class');
                $(champCourant).closest('.panier__contenu').find('select option[value="gratuit"]').attr("selected", "selected");
            }
            else {
                $(champCourant).closest('.panier__contenu').find('select option[value="gratuit"]').addClass('cache');
                $(champCourant).closest('.panier__contenu').find('select option[value="gratuit"]').removeAttr("selected");
            }
            // Met à jour la date de livraison
            var champDateLivraison = $('.panier').find('.panier__commandeDateLivraisonDate');
            $(champDateLivraison).text(arrDonnees['dateDelaiLivraison']);
            $(champCourant).closest('.panier__contenu').find('.panier__commandePrixModeLivraisonMontant').text(arrDonnees['montantModeLivraison']);
        };
        AjaxMandatCMajQuantite.prototype.executerAjax = function (evenement) {
            $.ajax({
                url: 'index.php?controleur=panier&action=majQuantite&isbn=' + evenement.currentTarget.id,
                type: 'GET',
                data: 'choixQuantite=' + $(evenement.currentTarget).val()
            })
                .done(function (data, textStatus, jqXHR) {
                AjaxMandatCMajQuantite.retournerResultat(data, textStatus, jqXHR, evenement.currentTarget.id);
            });
            console.log('Ceci s’affichera avant que la méthode retournerResultat ne soit appelée');
        };
        AjaxMandatCMajQuantite.prototype.initialiser = function () {
            var arrSelect = document.querySelectorAll('.quantiteListe');
            for (var intCpt = 0; intCpt < arrSelect.length; intCpt++) {
                $(arrSelect[intCpt]).on('change', this.executerAjax_lier);
            }
        };
        return AjaxMandatCMajQuantite;
    }());
    exports.AjaxMandatCMajQuantite = AjaxMandatCMajQuantite;
});
//# sourceMappingURL=ajaxMandatCMajQuantite.js.map