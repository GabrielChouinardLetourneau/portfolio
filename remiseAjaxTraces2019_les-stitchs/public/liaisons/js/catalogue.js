/**
 * @file Méthodes et fonctions utilisées pour le catalogue
 * @author Gabriel Chouinard Létourneau <chouinardletourneaug@gmail.com>
 * @version versionFinale
 */
define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var Catalogue = /** @class */ (function () {
        function Catalogue() {
            this.executerAjax_lier = null;
            this.refBtnMenuCategories = document.getElementById('categoriesMenu');
            this.refContenuMobile = document.getElementById('categoriesMobileContenu');
            this.initialiser();
            console.log('mandatA');
        }
        Catalogue.prototype.initialiser = function () {
            console.log("initialiser");
            this.refBtnMenuCategories.addEventListener('click', this.ouvrirMenu.bind(this.refBtnMenuCategories));
        };
        Catalogue.prototype.ouvrirMenu = function () {
        };
        return Catalogue;
    }());
    exports.Catalogue = Catalogue;
});
//# sourceMappingURL=catalogue.js.map