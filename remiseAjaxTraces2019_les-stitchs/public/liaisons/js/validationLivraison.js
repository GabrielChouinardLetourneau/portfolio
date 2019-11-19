/**
 * @file Méthodes et fonctions utilisées pour la validation de l'étape livraison
 * @author Gabriel Chouinard Létourneau <chouinardletourneaug@gmail.com>
 * @version versionFinale
 */
define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var validationLivraison = /** @class */ (function () {
        function validationLivraison() {
            var _this = this;
            this.arrMessagesErreurs = new Array();
            // Éléments du formulaire à valider
            // private refArrTypeCarte: Array<HTMLElement> = Array.apply(null, document.querySelectorAll('[name=typeCarte'));
            this.refNom = document.querySelector('#nom');
            this.refPrenom = document.querySelector('#prenom');
            this.refAdresse = document.querySelector('#adresse');
            this.refVille = document.querySelector("#ville");
            this.refProvince = document.querySelector("#province");
            this.refCodePostal = document.querySelector("#code_postal");
            fetch("../ressources/lang/fr_CA.UTF-8/messagesUtilisateurValidation.json")
                .then(function (response) { return response.json(); })
                .then(function (response) {
                _this.objMessages = response;
            });
            document.querySelector("form").noValidate = true;
            this.initialiser();
        }
        validationLivraison.prototype.initialiser = function () {
            this.refNom.addEventListener('blur', this.validerNom.bind(this));
            this.refPrenom.addEventListener('blur', this.validerPrenom.bind(this));
            this.refAdresse.addEventListener('blur', this.validerAdresse.bind(this));
            this.refVille.addEventListener('blur', this.validerVille.bind(this));
            this.refProvince.addEventListener('blur', this.validerProvince.bind(this));
            this.refCodePostal.addEventListener('blur', this.validerCodePostal.bind(this));
        };
        /**
         * Validation de la nom
         * @param {HTMLInputElement} référence du champ envoyé du Jour
         * @param {HTMLInputElement} référence du champ envoyé du Mois
         * @param {HTMLInputElement} référence du champ envoyé de l'Année
         * @param {string} type du champ pour la navigation de l'objet JSON
        */
        validationLivraison.prototype.validerNom = function (evenement) {
            var element = evenement.currentTarget;
            var lePattern = element.pattern;
            var elementParent = element.closest('p');
            var message = "";
            // Si le champ est vide
            if (this.validerSiVide(element) === true) {
                //message = "Entrez le nom complet du titulaire de la carte.";
                message = this.objMessages["nom"]["vide"];
                element.classList.remove("elementSucces");
                element.classList.add("elementErreur");
            }
            // Si le pattern n'est pas respecté
            else if (this.validerPattern(element, lePattern) === false) {
                //message = "Nom du titulaire invalide.";
                message = this.objMessages["nom"]["pattern"];
                element.classList.remove("elementSucces");
                element.classList.add("elementErreur");
            }
            else {
                element.classList.remove("elementErreur");
                element.classList.add("elementSucces");
            }
            if (message == "") {
                this.effacerErreur(element);
                this.afficherSucces(elementParent);
            }
            else {
                this.effacerSucces(elementParent);
                this.afficherErreur(element, message);
            }
        };
        validationLivraison.prototype.validerPrenom = function (evenement) {
            var element = evenement.currentTarget;
            var lePattern = element.pattern;
            var elementParent = element.closest('p');
            var message = "";
            // Si le champ est vide
            if (this.validerSiVide(element) === true) {
                message = this.objMessages["prenom"]["vide"];
                element.classList.remove("elementSucces");
                element.classList.add("elementErreur");
            }
            // Si le pattern n'est pas respecté
            else if (this.validerPattern(element, lePattern) === false) {
                //message = "Nom du titulaire invalide.";
                message = this.objMessages["prenom"]["pattern"];
                element.classList.remove("elementSucces");
                element.classList.add("elementErreur");
            }
            else {
                element.classList.remove("elementErreur");
                element.classList.add("elementSucces");
            }
            if (message == "") {
                this.effacerErreur(element);
                this.afficherSucces(elementParent);
            }
            else {
                this.effacerSucces(elementParent);
                this.afficherErreur(element, message);
            }
        };
        validationLivraison.prototype.validerAdresse = function (evenement) {
            var element = evenement.currentTarget;
            var lePattern = element.pattern;
            var elementParent = element.closest('p');
            var message = "";
            if (this.validerSiVide(element) === true) {
                //message = "Vous devez entrer une adresse.";
                message = this.objMessages["adresse"]["vide"];
                element.classList.remove("elementSucces");
                element.classList.add("elementErreur");
            }
            else if (this.validerPattern(element, lePattern) === false) {
                message = this.objMessages["adresse"]["pattern"];
                element.classList.remove("elementSucces");
                element.classList.add("elementErreur");
            }
            else {
                element.classList.remove("elementErreur");
                element.classList.add("elementSucces");
            }
            if (message == "") {
                this.effacerErreur(element);
                this.afficherSucces(elementParent);
            }
            else {
                this.effacerSucces(elementParent);
                this.afficherErreur(element, message);
            }
        };
        validationLivraison.prototype.validerVille = function (evenement) {
            var element = evenement.currentTarget;
            var lePattern = element.pattern;
            var elementParent = element.closest('p');
            var message = "";
            if (this.validerSiVide(element) === true) {
                message = this.objMessages["ville"]["vide"];
                element.classList.remove("elementSucces");
                element.classList.add("elementErreur");
            }
            else if (this.validerPattern(element, lePattern) === false) {
                message = this.objMessages["ville"]["pattern"];
                element.classList.remove("elementSucces");
                element.classList.add("elementErreur");
            }
            else {
                element.classList.remove("elementErreur");
                element.classList.add("elementSucces");
            }
            if (message == "") {
                this.effacerErreur(element);
                this.afficherSucces(elementParent);
            }
            else {
                this.effacerSucces(elementParent);
                this.afficherErreur(element, message);
            }
        };
        validationLivraison.prototype.validerProvince = function (evenement) {
            var element = evenement.currentTarget;
            var elementParent = element.closest('div');
            var message = "";
            if (element.value === "defaut") {
                message = this.objMessages["province"]["vide"];
                element.classList.remove("elementSucces");
                element.classList.add("elementErreur");
            }
            else {
                element.classList.remove("elementErreur");
                element.classList.add("elementSucces");
            }
            if (message == "") {
                this.effacerErreur(element);
                this.afficherSucces(elementParent);
            }
            else {
                this.effacerSucces(elementParent);
                this.afficherErreur(element, message);
            }
        };
        validationLivraison.prototype.validerCodePostal = function (evenement) {
            var element = evenement.currentTarget;
            var lePattern = element.pattern;
            var elementParent = element.closest('p');
            var message = "";
            if (this.validerSiVide(element) === true) {
                message = this.objMessages["code_postal"]["vide"];
                element.classList.remove("elementSucces");
                element.classList.add("elementErreur");
            }
            else if (this.validerPattern(element, lePattern) === false) {
                message = this.objMessages["code_postal"]["pattern"];
                element.classList.remove("elementSucces");
                element.classList.add("elementErreur");
            }
            else {
                element.classList.remove("elementErreur");
                element.classList.add("elementSucces");
            }
            if (message == "") {
                this.effacerErreur(element);
                this.afficherSucces(elementParent);
            }
            else {
                this.effacerSucces(elementParent);
                this.afficherErreur(element, message);
            }
        };
        // Méthodes utilitaires
        /**
         * Validation du pattern
         * @param {HTMLInputElement} référence du champ à tester
         * @param {HTMLInputElement} référence du motif qui sera utilisé pour le test
         * @param {boolean} type réponse au test regex
        */
        validationLivraison.prototype.validerPattern = function (element, motif) {
            var regexp = new RegExp(motif);
            return regexp.test(element.value);
        };
        /**
         * Validation que le champ n'est pas vide
         * @param {HTMLInputElement} référence du champ à tester
         * @param {boolean} type réponse au test regex
        */
        validationLivraison.prototype.validerSiVide = function (element) {
            if (element.value.length < 1) {
                return true;
            }
            else {
                return false;
            }
        };
        /**
         * Validation de la nom
         * @param {HTMLInputElement} référence du champ envoyé du Jour
         * @param {String} type message d'erreur
        */
        validationLivraison.prototype.afficherErreur = function (element, message) {
            var conteneurFormulaire = element.closest('.ctnForm');
            var conteneurErreur = conteneurFormulaire.querySelector('.erreur');
            conteneurFormulaire.classList.add("erreurMargin");
            var iconeErreur = "<span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>";
            conteneurErreur.innerHTML = iconeErreur + "<span>" + message + "</span>";
        };
        validationLivraison.prototype.effacerErreur = function (element) {
            var conteneurFormulaire = element.closest('.ctnForm');
            var conteneurErreur = conteneurFormulaire.querySelector('.erreur');
            conteneurErreur.innerHTML = "";
        };
        validationLivraison.prototype.afficherSucces = function (element) {
            var monConteneur = document.querySelector('.' + element.className);
            if (element.className != "facturation__typeCarteTitre") {
                var mesEnfants = monConteneur.children;
                var nomDernierEnfant = mesEnfants[mesEnfants.length - 1].className;
                if (nomDernierEnfant != "elementIconeSucces") {
                    var elementSucces = document.createElement("span");
                    elementSucces.classList.add("elementIconeSucces");
                    elementSucces.innerHTML = "<svg class='iconeSucces'><use xlink:href='#success'/></svg>";
                    monConteneur.appendChild(elementSucces);
                }
            }
            else {
                var elementSucces = document.createElement("span");
                elementSucces.classList.add("elementIconeSucces");
                elementSucces.innerHTML = "<svg class='iconeSucces'><use xlink:href='#success'/></svg>";
                monConteneur.appendChild(elementSucces);
            }
        };
        validationLivraison.prototype.effacerSucces = function (element) {
            var monConteneur = document.querySelector('.' + element.className);
            var mesEnfants = monConteneur.children;
            var nomDernierEnfant = mesEnfants[mesEnfants.length - 1].className;
            if (nomDernierEnfant === "elementIconeSucces") {
                monConteneur.removeChild(monConteneur.childNodes[monConteneur.childNodes.length - 1]);
            }
        };
        return validationLivraison;
    }());
    exports.validationLivraison = validationLivraison;
});
//# sourceMappingURL=validationLivraison.js.map