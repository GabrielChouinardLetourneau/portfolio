/**
 * @file Méthodes et fonctions utilisées pour la page catalogue
 * @author Gabriel Chouinard Létourneau <chouinardletourneaug@gmail.com>
 * @version versionFinale
 */
define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var MandatB = /** @class */ (function () {
        function MandatB() {
            var _this = this;
            //Références des champs
            this.refJourNaissance = document.querySelector("#jourNaissance");
            this.refMoisNaissance = document.querySelector("#moisNaissance");
            this.refAnneeNaissance = document.querySelector("#anneeNaissance");
            this.refMdp = document.querySelector("#motDePasse");
            this.refBtnAfficherMdp = document.querySelector("#afficherMotDePasse");
            fetch("assets/js/objMessages.json")
                .then(function (response) { return response.json(); })
                .then(function (response) {
                _this.objMessages = response;
            });
            document.querySelector("form").noValidate = true;
        }
        return MandatB;
    }());
    exports.MandatB = MandatB;
});
//# sourceMappingURL=MandatB.js.map