define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var AjaxMandatC = /** @class */ (function () {
        function AjaxMandatC() {
            this.executerAjax_lier = null;
            this.executerAjax_lier = this.executerAjax.bind(this);
            this.initialiser();
        }
        AjaxMandatC.retournerResultat = function (data, textStatus, jqXHR, id) {
            var arrDonnees = JSON.parse(data);
            var idLivre = id;
            var idPrefixe = id.substring(0, 2);
            var isbn = id.substring(2, id.length);
            var champCourant = document.getElementById(id);
            var champMontantTotalItem = $(champCourant).closest('.panier__infosLivresContenu').find('.' + idPrefixe + 'panier__infosLivresContenuAutresSousTotal');
            $(champMontantTotalItem).text(arrDonnees["montantTotalItem"]);
            var champMontantSousTotal = $(champCourant).closest('.panier__contenu').find('.panier__commandePrixSousTotalMontant');
            $(champMontantSousTotal).text(arrDonnees["montantSousTotal"]);
            var champMontantTps = $(champCourant).closest('.panier__contenu').find('.panier__commandePrixTaxesMontant');
            $(champMontantTps).text(arrDonnees["montantTps"]);
            var champMontantTotal = $(champCourant).closest('.panier__contenu').find('.panier__commandeTotalPrixMontant');
            $(champMontantTotal).text(arrDonnees["montantTotal"]);
            var champNbArticlesPanierTitre = $(champCourant).closest('.panier').find('.panier__titreNbItems');
            $(champNbArticlesPanierTitre).text(arrDonnees["nbTotalArticles"]);
            var champNbArticlesPanier = $('body').find('.entete__deuxiemeRangeePanierNbArticles');
            $(champNbArticlesPanier).text(arrDonnees["nbTotalArticles"]);
            var montantSousTotal = arrDonnees["montantSousTotal"];
            var champMessageLivraison = $('.panier').find('.panierMessageLivraisonGratuite');
            $(champMessageLivraison).html(arrDonnees["messageLivraison"]);
        };
        AjaxMandatC.prototype.executerAjax = function (evenement) {
            console.log(evenement.currentTarget.id);
            $.ajax({
                url: 'index.php?controleur=panier&action=majQuantite&isbn=' + evenement.currentTarget.id,
                type: 'GET',
                data: 'choixQuantite=' + $(evenement.currentTarget).val()
            })
                .done(function (data, textStatus, jqXHR) {
                AjaxMandatC.retournerResultat(data, textStatus, jqXHR, evenement.currentTarget.id);
            });
            console.log('Ceci s’affichera avant que la méthode retournerResultat ne soit appelée');
        };
        AjaxMandatC.prototype.initialiser = function () {
            var arrSelect = document.querySelectorAll('.quantiteListe');
            for (var intCpt = 0; intCpt < arrSelect.length; intCpt++) {
                console.log(arrSelect[intCpt]);
                $(arrSelect[intCpt]).on('change', this.executerAjax_lier);
            }
        };
        return AjaxMandatC;
    }());
    exports.AjaxMandatC = AjaxMandatC;
});
//# sourceMappingURL=ajaxMandatC.js.map