/**
 * @file Méthodes et fonctions utilisées pour la validation des formulaires clients
 * @author Élody Levasseur-Côté <elodylevasseurcote@hotmail.com>
 * @version 1.0
 **/
define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var validationClient = /** @class */ (function () {
        function validationClient() {
            var _this = this;
            //Toutes les références des inputs
            this.refNom = document.querySelector('#nom');
            this.refPrenom = document.querySelector('#prenom');
            this.refCourrielCreation = document.querySelector('#courrielCreation');
            this.refTelephone = document.querySelector('#telephone');
            this.refMotDePasseCreation = document.querySelector('#motDePasseCreation');
            this.refCourrielConnexion = document.querySelector('#courrielConnexion');
            this.refMotDePasseConnexion = document.querySelector('#motDePasseConnexion');
            this.refBoutonTogglMotDePasse = document.querySelector('#afficherMotDePasse');
            var urlParams = new URLSearchParams(window.location.search);
            fetch("../ressources/lang/fr_CA.UTF-8/messagesUtilisateurValidation.json")
                .then(function (response) { return response.json(); })
                .then(function (response) {
                _this.objMessages = response;
            });
            if (urlParams.get('action') == 'connexion') {
                this.connexion();
            }
            else if (urlParams.get('action') == 'creation') {
                this.creation();
            }
        }
        validationClient.prototype.connexion = function () {
            console.log("connexion");
            this.refCourrielConnexion.addEventListener('blur', this.validerCourriel.bind(this));
            this.refMotDePasseConnexion.addEventListener('blur', this.validerMotDePasse.bind(this));
            this.refBoutonTogglMotDePasse.addEventListener('change', this.togglMotDePasseConnexion.bind(this));
        };
        validationClient.prototype.creation = function () {
            console.log("creation");
            this.refNom.addEventListener('blur', this.validerNom.bind(this));
            this.refPrenom.addEventListener('blur', this.validerPrenom.bind(this));
            this.refCourrielCreation.addEventListener('blur', this.validerCourriel.bind(this));
            this.refTelephone.addEventListener('blur', this.validerTelephone.bind(this));
            this.refMotDePasseCreation.addEventListener('blur', this.validerMotDePasse.bind(this));
            this.refBoutonTogglMotDePasse.addEventListener('change', this.togglMotDePasseCreation.bind(this));
        };
        validationClient.prototype.validerNom = function (evenement) {
            var element = evenement.currentTarget;
            var lePattern = '^[a-zA-ZÀ-ÿ\'-\.]+$';
            if (this.verifierSiVide(element) === true) {
                // Vide
                this.afficherErreur(element, this.objMessages["nom"]["vide"]);
            }
            else if (this.validerPattern(element, lePattern) === true) {
                // Bon
                this.effacerErreur(element);
                this.montrerSucces(element, "#ok-nom");
            }
            else {
                // Pas bon
                this.afficherErreur(element, this.objMessages["nom"]["pattern"]);
            }
            // this.verifierFormulaire();
        };
        validationClient.prototype.validerPrenom = function (evenement) {
            var element = evenement.currentTarget;
            var lePattern = '^[a-zA-ZÀ-ÿ\'-\.]+$';
            if (this.verifierSiVide(element) === true) {
                // Vide
                this.afficherErreur(element, this.objMessages["prenom"]["vide"]);
            }
            else if (this.validerPattern(element, lePattern) === true) {
                // Bon
                this.effacerErreur(element);
                this.montrerSucces(element, "#ok-prenom");
            }
            else {
                // Pas bon
                this.afficherErreur(element, this.objMessages["prenom"]["pattern"]);
            }
            // this.verifierFormulaire();
        };
        validationClient.prototype.validerCourriel = function (evenement) {
            var element = evenement.currentTarget;
            var lePattern = '^[a-zA-Z0-9_]+(.[a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+(.[a-zA-Z0-9_]+)*.[a-zA-Z]{2,4}$';
            if (this.verifierSiVide(element) === true) {
                // Vide
                this.afficherErreur(element, this.objMessages["courriel"]["vide"]);
            }
            else if (this.validerPattern(element, lePattern) === true) {
                // Bon
                this.effacerErreur(element);
                this.montrerSucces(element, "#ok-courriel");
            }
            else {
                // Pas bon
                this.afficherErreur(element, this.objMessages["courriel"]["pattern"]);
            }
            // this.verifierFormulaire();
        };
        validationClient.prototype.validerTelephone = function (evenement) {
            var element = evenement.currentTarget;
            var lePattern = '^[0-9]{10}$';
            if (this.verifierSiVide(element) === true) {
                // Vide
                this.afficherErreur(element, this.objMessages["telephone"]["vide"]);
            }
            else if (this.validerPattern(element, lePattern) === true) {
                // Bon
                this.effacerErreur(element);
                this.montrerSucces(element, "#ok-telephone");
            }
            else {
                // Pas bon
                this.afficherErreur(element, this.objMessages["telephone"]["pattern"]);
            }
            // this.verifierFormulaire();
        };
        validationClient.prototype.validerMotDePasse = function (evenement) {
            var element = evenement.currentTarget;
            var lePattern = '^(?=.*[a-zà-ÿ])(?=.*[A-ZÀ-Ÿ])(?=.*[0-9]).{8,20}$';
            if (this.verifierSiVide(element) === true) {
                // Vide
                this.afficherErreur(element, this.objMessages["mot_de_passe"]["vide"]);
            }
            else if (this.validerPattern(element, lePattern) === true) {
                // Bon
                this.effacerErreur(element);
                this.montrerSucces(element, "#ok-motDePasse");
            }
            else {
                // Pas bon
                this.afficherErreur(element, this.objMessages["mot_de_passe"]["pattern"]);
            }
            // this.verifierFormulaire();
        };
        // Fonctions utilitaires de validation
        validationClient.prototype.validerPattern = function (element, motif) {
            if (motif === void 0) { motif = element.pattern; }
            var regexp = new RegExp(motif);
            return regexp.test(element.value);
        };
        validationClient.prototype.verifierSiVide = function (element) {
            return element.value === "";
        };
        validationClient.prototype.afficherErreur = function (element, message) {
            element.closest('.ctnForm')
                .querySelector('.erreur__message')
                .style.display = "block";
            element.closest('.ctnForm')
                .querySelector('.erreur__message')
                .innerHTML = message;
            // Mettre les bordures du champs en rouge pour montrer l'erreur
            this.effacerSucces(element);
        };
        validationClient.prototype.effacerErreur = function (element) {
            element.closest('.ctnForm')
                .querySelector('.erreur__message')
                .style.display = "none";
            element.closest('.ctnForm')
                .querySelector('.erreur__message')
                .innerHTML = "";
        };
        validationClient.prototype.montrerSucces = function (element, id) {
            var closest = element.closest(id);
            console.log(closest);
            if (closest.classList.contains("ok-afficher") === false) {
                closest.className += " ok-afficher";
                console.log(closest);
            }
        };
        validationClient.prototype.effacerSucces = function (element) {
            if (element.closest(".ok-afficher") !== null) {
                element.closest(".ok-afficher").classList.remove("ok-afficher");
            }
        };
        validationClient.prototype.togglMotDePasseConnexion = function () {
            if (this.refMotDePasseConnexion.type === "password") {
                this.refMotDePasseConnexion.type = "text";
            }
            else {
                this.refMotDePasseConnexion.type = "password";
            }
        };
        validationClient.prototype.togglMotDePasseCreation = function () {
            if (this.refMotDePasseCreation.type === "password") {
                this.refMotDePasseCreation.type = "text";
            }
            else {
                this.refMotDePasseCreation.type = "password";
            }
        };
        return validationClient;
    }());
    exports.validationClient = validationClient;
});
//# sourceMappingURL=validationClient.js.map