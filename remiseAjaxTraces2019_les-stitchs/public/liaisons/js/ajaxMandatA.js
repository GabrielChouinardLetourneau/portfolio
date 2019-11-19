define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var AjaxMandatA = /** @class */ (function () {
        function AjaxMandatA() {
            this.inputCouriel = document.getElementById('courrielCreation');
            this.initialiser();
        }
        AjaxMandatA.prototype.initialiser = function () {
            this.inputCouriel.addEventListener('blur', this.verifierCourriel.bind(this.inputCouriel));
            fetch("../ressources/lang/fr_CA.UTF-8/messagesUtilisateurValidation.json")
                .then(function (response) { return response.json(); })
                .then(function (response) {
                AjaxMandatA.objMessages = response;
            });
        };
        AjaxMandatA.retournerResultat = function (data, textStatus, jqXHR) {
            var inputCouriel = document.querySelector('#courrielCreation');
            console.log(data);
            if (data == "Client existant!") {
                // console.log(this.objMessages);
                inputCouriel.closest('.ctnForm')
                    .querySelector('.erreur__message').style.display = "block";
                inputCouriel.closest('.ctnForm').querySelector('.erreur__message').innerHTML = AjaxMandatA.objMessages['courriel']['existant'];
                inputCouriel.closest(".ok-afficher").classList.remove("ok-afficher");
            }
            else if (data == "Client inexistant!") {
                inputCouriel.closest('.ctnForm').querySelector('.erreur__message').innerHTML = AjaxMandatA.objMessages['courriel']['vide'];
            }
        };
        AjaxMandatA.prototype.verifierCourriel = function (courriel) {
            $.ajax({
                url: 'index.php?controleur=client&action=validerCourriel',
                type: 'GET',
                data: 'courriel=' + courriel.target.value,
                dataType: 'html'
            })
                .done(function (data, textStatus, jqXHR) {
                AjaxMandatA.retournerResultat(data, textStatus, jqXHR);
            });
        };
        return AjaxMandatA;
    }());
    exports.AjaxMandatA = AjaxMandatA;
});
//# sourceMappingURL=ajaxMandatA.js.map