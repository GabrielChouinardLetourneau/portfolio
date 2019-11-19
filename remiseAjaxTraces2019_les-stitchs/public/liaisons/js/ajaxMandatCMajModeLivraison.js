define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var AjaxMandatCMajModeLivraison = /** @class */ (function () {
        function AjaxMandatCMajModeLivraison() {
            this.executerAjax_lier = null;
            this.executerAjax_lier = this.executerAjax.bind(this);
            this.initialiser();
        }
        AjaxMandatCMajModeLivraison.retournerResultat = function (data, textStatus, jqXHR) {
            var arrDonnees = JSON.parse(data);
            var elementParent = document.querySelector('.panier');
            // Met à jour le montant total
            var champMontantTotal = $(elementParent).find('.panier__commandeTotalPrixMontant');
            $(champMontantTotal).text(arrDonnees["montantTotal"]);
            // Met à jour le montant du mode livraison
            var champMontantModeLivraison = $(elementParent).find('.panier__commandePrixModeLivraisonMontant');
            $(champMontantModeLivraison).text(arrDonnees["montantModeLivraison"]);
            // Met à jour la date de délai de livraison
            var champDateDelaiLivraison = $(elementParent).find('.panier__commandeDateLivraisonDate');
            $(champDateDelaiLivraison).text(arrDonnees["dateDelaiLivraison"]);
        };
        AjaxMandatCMajModeLivraison.prototype.executerAjax = function (evenement) {
            $.ajax({
                url: 'index.php?controleur=panier&action=majModeLivraison',
                type: 'GET',
                data: 'choixModeLivraison=' + $(evenement.currentTarget).val()
            })
                .done(function (data, textStatus, jqXHR) {
                AjaxMandatCMajModeLivraison.retournerResultat(data, textStatus, jqXHR);
            });
            console.log('Ceci s’affichera avant que la méthode retournerResultat ne soit appelée');
        };
        AjaxMandatCMajModeLivraison.prototype.initialiser = function () {
            var arrSelect = document.querySelectorAll('.modeLivraisonListe');
            for (var intCpt = 0; intCpt < arrSelect.length; intCpt++) {
                $(arrSelect[intCpt]).on('change', this.executerAjax_lier);
            }
        };
        return AjaxMandatCMajModeLivraison;
    }());
    exports.AjaxMandatCMajModeLivraison = AjaxMandatCMajModeLivraison;
});
//# sourceMappingURL=ajaxMandatCMajModeLivraison.js.map