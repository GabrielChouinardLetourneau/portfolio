/**
 * @file Méthodes et fonctions utilisées pour l'Ajax de la barre de recherche
 * @author Gabriel Chouinard Létourneau <chouinardletourneaug@gmail.com>
 * @version versionFinale
 */
define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var AjaxMandatB = /** @class */ (function () {
        function AjaxMandatB() {
            //Attributs 
            this.trouverAuteurs_lier = null;
            this.inputRecherche = Array.apply(null, document.querySelectorAll(".entete__rechercheSaisieChamp"));
            this.zoneResultats = Array.apply(null, document.querySelectorAll(".zoneResultatsRecherche"));
            this.criteresRecherche = Array.apply(null, document.querySelectorAll(".criteresRecherche"));
            this.initialiser();
        }
        // Initialisation
        AjaxMandatB.prototype.initialiser = function () {
            var _this = this;
            this.trouverAuteurs_lier = this.trouverAuteurs.bind(this);
            this.inputRecherche.forEach(function (element) {
                element.addEventListener("input", function () {
                    _this.trouverAuteurs_lier(element);
                });
            });
        };
        AjaxMandatB.prototype.trouverAuteurs = function (element) {
            var valeurChamp = $(element).val();
            console.log(valeurChamp);
            var reference = this;
            var valeurCritereRecherche = parent.document.querySelector(".criteresRecherche");
            if ($(valeurCritereRecherche).val() == "auteur") {
                $.ajax({
                    url: 'index.php?controleur=site& action=trouverAuteursParChamp',
                    type: 'POST',
                    data: 'auteur=' + valeurChamp,
                    dataType: 'html',
                })
                    .done(function (data, textStatus, jqXHR) {
                    reference.retournerResultat(data, textStatus, jqXHR);
                });
            }
        };
        ;
        AjaxMandatB.prototype.retournerResultat = function (data, textStatus, jqXHR) {
            this.zoneResultats.forEach(function (element) {
                element.innerHTML = data;
            });
        };
        ;
        return AjaxMandatB;
    }());
    exports.AjaxMandatB = AjaxMandatB;
});
//# sourceMappingURL=ajaxMandatB.js.map