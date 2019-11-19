/**
 * @file Fichier qui permet de valider les champs dans le formualaire de facturation
 * @author Marie-Li Durand
 * @version
 */
define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var validationFacturation = /** @class */ (function () {
        // Constructeur
        function validationFacturation() {
            var _this = this;
            this.arrMessagesErreurs = new Array();
            // Éléments du formulaire à valider
            this.refArrTypeCarte = Array.apply(null, document.querySelectorAll('[name=methodePaiement'));
            this.refNom = document.querySelector('#nom_complet');
            this.refNumeroCarte = document.querySelector('#numeroCarte');
            this.refCodeSecurite = document.querySelector('#codeSecurite');
            this.refMois = document.querySelector("#mois");
            this.refAnnee = document.querySelector("#annee");
            this.refAdresse = document.querySelector("#adresse");
            this.refVille = document.querySelector("#ville");
            this.refProvince = document.querySelector("#province");
            this.refCodePostal = document.querySelector("#codePostal");
            document.querySelector('form').noValidate = true;
            fetch("../ressources/lang/fr_CA.UTF-8/messagesUtilisateurValidation.json")
                .then(function (response) { return response.json(); })
                .then(function (response) {
                _this.objMessages = response;
            });
            this.initialiser();
        }
        validationFacturation.prototype.initialiser = function () {
            var _this = this;
            this.refArrTypeCarte.forEach(function (btnRadio) { return btnRadio.addEventListener('blur', _this.validerTypeCarte.bind(_this)); });
            this.refNom.addEventListener('blur', this.validerNom.bind(this));
            this.refNumeroCarte.addEventListener('blur', this.validerNumeroCarte.bind(this));
            this.refCodeSecurite.addEventListener('blur', this.validerCodeSecurite.bind(this));
            this.refMois.addEventListener('blur', this.validerDateExpiration.bind(this));
            this.refAnnee.addEventListener('blur', this.validerDateExpiration.bind(this));
            this.refAdresse.addEventListener('blur', this.validerAdresse.bind(this));
            this.refVille.addEventListener('blur', this.validerVille.bind(this));
            this.refProvince.addEventListener('blur', this.validerProvince.bind(this));
            this.refCodePostal.addEventListener('blur', this.validerCodePostal.bind(this));
        };
        /*
        Méthode qui permet de valider le nom de la carte
         */
        validationFacturation.prototype.validerTypeCarte = function (evenement) {
            var element = evenement.currentTarget;
            var elementParent = element.closest('.ctnForm');
            var elementLegend = elementParent.querySelector('legend');
            var message = "";
            if (element.checked === false) {
                message = this.objMessages['methodePaiement']['vide'];
                element.classList.add("elementErreur");
                console.log("message : " + message);
            }
            else {
                element.classList.remove("elementErreur");
            }
            if (message == "") {
                this.effacerErreur(element);
            }
            else {
                this.afficherErreur(element, message);
            }
        };
        validationFacturation.prototype.validerNom = function (evenement) {
            var element = evenement.currentTarget;
            var lePattern = element.pattern;
            var elementParent = element.closest('p');
            var message = "";
            // Si le champ est vide
            if (this.validerSiVide(element) === true) {
                //message = "Entrez le nom complet du titulaire de la carte.";
                message = this.objMessages["nom_complet"]["vide"];
                element.classList.remove("elementSucces");
                element.classList.add("elementErreur");
            }
            // Si le pattern n'est pas respecté
            else if (this.validerPattern(element, lePattern) === false) {
                //message = "Nom du titulaire invalide.";
                message = this.objMessages["nom_complet"]["pattern"];
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
        validationFacturation.prototype.validerNumeroCarte = function (evenement) {
            var element = evenement.currentTarget;
            var lePatternVisa = "^[6][0-9]{3}[ ]?[0-9]{4}[ ]?[0-9]{4}[ ]?[0-9]{4}$";
            var lePattenMasterCard = "^[5][0-9]{3}[ ]?[0-9]{4}[ ]?[0-9]{4}[ ]?[0-9]{4}$";
            var lePatternAmericanExpress = "^[13][0-9]{3}[ ]?[0-9]{4}[ ]?[0-9]{4}[ ]?[0-9]{4}$";
            var elementParent = element.closest('p');
            var message = "";
            // Si le champ est vide
            if (this.validerSiVide(element) === true) {
                message = this.objMessages["no_carte"]["vide"];
                element.classList.remove("elementSucces");
                element.classList.add("elementErreur");
                // Si l'icône de la carte de crédit est présente, on l'a supprime
                var mesEnfants = elementParent.children;
                var nomDernierEnfant = mesEnfants[mesEnfants.length - 2].className;
                if (nomDernierEnfant == "elementIconeCarteCredit") {
                    console.log(elementParent.childNodes.length - 1);
                    elementParent.removeChild(elementParent.childNodes[elementParent.childNodes.length - 2]);
                }
            }
            // Si c'est visa
            else if (element.value[0] == "6") {
                if (this.validerPattern(element, lePatternVisa) === false) {
                    message = this.objMessages["no_carte"]["pattern"];
                    element.classList.remove("elementSucces");
                    element.classList.add("elementErreur");
                    // Si l'icône de la carte de crédit est présente, on l'a supprime
                    var mesEnfants = elementParent.children;
                    var nomDernierEnfant = mesEnfants[mesEnfants.length - 2].className;
                    if (nomDernierEnfant == "elementIconeCarteCredit") {
                        console.log(elementParent.childNodes.length - 1);
                        elementParent.removeChild(elementParent.childNodes[elementParent.childNodes.length - 2]);
                    }
                }
                else {
                    element.classList.remove("elementErreur");
                    element.classList.add("elementSucces");
                    var mesEnfants = elementParent.children;
                    var nomDernierEnfant = mesEnfants[mesEnfants.length - 2].className;
                    if (nomDernierEnfant == "elementIconeCarteCredit") {
                        var elementCarteCredit = elementParent.querySelector('.elementIconeCarteCredit');
                        elementCarteCredit.innerHTML = "<svg class='iconeCarteCredit'><use xlink:href='#visa'/></svg>";
                    }
                    else {
                        var elementTypeCarteCredit = document.createElement("span");
                        elementTypeCarteCredit.classList.add("elementIconeCarteCredit");
                        elementTypeCarteCredit.innerHTML = "<svg class='iconeCarteCredit'><use xlink:href='#visa'/></svg>";
                        elementParent.appendChild(elementTypeCarteCredit);
                    }
                }
            }
            // Si c'est mastercard
            else if (element.value[0] == "5") {
                if (this.validerPattern(element, lePattenMasterCard) === false) {
                    message = this.objMessages["no_carte"]["pattern"];
                    element.classList.remove("elementSucces");
                    element.classList.add("elementErreur");
                    // Si l'icône de la carte de crédit est présente, on l'a supprime
                    var mesEnfants = elementParent.children;
                    var nomDernierEnfant = mesEnfants[mesEnfants.length - 2].className;
                    if (nomDernierEnfant == "elementIconeCarteCredit") {
                        console.log(elementParent.childNodes.length - 1);
                        elementParent.removeChild(elementParent.childNodes[elementParent.childNodes.length - 2]);
                    }
                }
                else {
                    element.classList.remove("elementErreur");
                    element.classList.add("elementSucces");
                    var mesEnfants = elementParent.children;
                    var nomDernierEnfant = mesEnfants[mesEnfants.length - 2].className;
                    if (nomDernierEnfant == "elementIconeCarteCredit") {
                        var elementCarteCredit = elementParent.querySelector('.elementIconeCarteCredit');
                        elementCarteCredit.innerHTML = "<svg class='iconeCarteCredit masterCard'><use xlink:href='#mastercard'/></svg>";
                    }
                    else {
                        var elementTypeCarteCredit = document.createElement("span");
                        elementTypeCarteCredit.classList.add("elementIconeCarteCredit");
                        elementTypeCarteCredit.innerHTML = "<svg class='iconeCarteCredit masterCard'><use xlink:href='#mastercard'/></svg>";
                        elementParent.appendChild(elementTypeCarteCredit);
                    }
                }
            }
            // Si c'est american express
            else if (element.value[0] == "3" || element.value[0] == "1") {
                if (this.validerPattern(element, lePatternAmericanExpress) === false) {
                    message = this.objMessages["no_carte"]["pattern"];
                    element.classList.remove("elementSucces");
                    element.classList.add("elementErreur");
                    // Si l'icône de la carte de crédit est présente, on l'a supprime
                    var mesEnfants = elementParent.children;
                    var nomDernierEnfant = mesEnfants[mesEnfants.length - 2].className;
                    if (nomDernierEnfant == "elementIconeCarteCredit") {
                        console.log(elementParent.childNodes.length - 1);
                        elementParent.removeChild(elementParent.childNodes[elementParent.childNodes.length - 2]);
                    }
                }
                else {
                    element.classList.remove("elementErreur");
                    element.classList.add("elementSucces");
                    var mesEnfants = elementParent.children;
                    var nomDernierEnfant = mesEnfants[mesEnfants.length - 2].className;
                    if (nomDernierEnfant == "elementIconeCarteCredit") {
                        var elementCarteCredit = elementParent.querySelector('.elementIconeCarteCredit');
                        elementCarteCredit.innerHTML = "<svg class='iconeCarteCredit'><use xlink:href='#amex'/></svg>";
                    }
                    else {
                        var elementTypeCarteCredit = document.createElement("span");
                        elementTypeCarteCredit.classList.add("elementIconeCarteCredit");
                        elementTypeCarteCredit.innerHTML = "<svg class='iconeCarteCredit'><use xlink:href='#amex'/></svg>";
                        elementParent.appendChild(elementTypeCarteCredit);
                    }
                }
            }
            else {
                message = this.objMessages["no_carte"]["pattern"];
                element.classList.remove("elementSucces");
                element.classList.add("elementErreur");
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
        validationFacturation.prototype.validerCodeSecurite = function (evenement) {
            var element = evenement.currentTarget;
            var lePattern = element.pattern;
            var elementParent = element.closest('p');
            var message = "";
            if (this.validerSiVide(element) === true) {
                message = this.objMessages["code"]["vide"];
                element.classList.remove("elementSucces");
                element.classList.add("elementErreur");
            }
            else if (this.validerPattern(element, lePattern) === false) {
                message = this.objMessages["code"]["pattern"];
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
        validationFacturation.prototype.validerDateExpiration = function (evenement) {
            var element = evenement.currentTarget;
            var message = "";
            var messageTotal = "";
            var elementParent = this.refAnnee.closest('.facturation__informationsPaiementDateExpirationConteneur');
            // Si aucune date d'expiration n'a été entrée
            if (this.refMois.value === "mm" && this.refAnnee.value === "aaaa") {
                element.classList.remove("elementSucces");
                this.refMois.classList.add("elementErreur");
                this.refAnnee.classList.add("elementErreur");
                message = this.objMessages['expiration']['vide'];
                this.effacerSucces(elementParent);
                this.afficherErreur(element, message);
            }
            // Si l'un des champs est vide
            else if (this.refMois.value === "mm" || this.refAnnee.value === "aaaa") {
                // Validation du mois
                if (this.refMois.value === "mm") {
                    message = this.objMessages['expiration']['type']['mois'];
                    this.arrMessagesErreurs.push(message);
                    this.refMois.classList.remove("elementSucces");
                    this.refMois.classList.add("elementErreur");
                }
                else {
                    this.refMois.classList.remove("elementErreur");
                    this.refMois.classList.add("elementSucces");
                }
                // Validation de l'année
                if (this.refAnnee.value === "aaaa") {
                    message = this.objMessages['expiration']['type']['annee'];
                    this.arrMessagesErreurs.push(message);
                    this.refAnnee.classList.remove("elementSucces");
                    this.refAnnee.classList.add("elementErreur");
                }
                else {
                    this.refAnnee.classList.remove("elementErreur");
                    this.refAnnee.classList.add("elementSucces");
                }
                for (var nbMessages = 0; nbMessages < this.arrMessagesErreurs.length; nbMessages++) {
                    messageTotal += this.arrMessagesErreurs[nbMessages];
                }
                this.afficherErreur(element, messageTotal);
                this.arrMessagesErreurs = [];
            }
            else {
                this.effacerErreur(element);
                element.classList.remove("elementErreur");
                element.classList.add("elementSucces");
                if (this.validerDate() == false) {
                    message = this.objMessages['expiration']['expire'];
                    this.effacerSucces(elementParent);
                    this.afficherErreur(element, message);
                    this.refMois.classList.add('elementErreur');
                    this.refAnnee.classList.add('elementErreur');
                }
                else {
                    this.refAnnee.classList.remove('elementErreur');
                    this.refMois.classList.remove('elementErreur');
                    this.afficherSucces(elementParent);
                }
            }
        };
        validationFacturation.prototype.validerDate = function () {
            var moisExpiration = this.refMois.value;
            var anneeExpiration = this.refAnnee.value;
            var dateExpiration = anneeExpiration + "-" + moisExpiration + "-" + "01";
            if (this.verifierDateExpiration(dateExpiration) == false) {
                return false;
            }
            else {
                return true;
            }
        };
        validationFacturation.prototype.formaterDateAujourdui = function (date) {
            var dateAujourdhui = new Date(date);
            var mois = '' + (dateAujourdhui.getMonth() + 1), jour = '' + dateAujourdhui.getDate(), annee = dateAujourdhui.getFullYear();
            return new Date([annee, mois, jour].join("-"));
        };
        validationFacturation.prototype.verifierDateExpiration = function (uneDateExpiration) {
            var dateExpiration = new Date(uneDateExpiration);
            return this.formaterDateAujourdui(new Date()).getTime() <= dateExpiration.getTime();
        };
        validationFacturation.prototype.validerAdresse = function (evenement) {
            var element = evenement.currentTarget;
            var lePattern = element.pattern;
            var elementParent = element.closest('p');
            var message = "";
            if (this.validerSiVide(element) === true) {
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
        validationFacturation.prototype.validerVille = function (evenement) {
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
        validationFacturation.prototype.validerProvince = function (evenement) {
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
        validationFacturation.prototype.validerCodePostal = function (evenement) {
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
        validationFacturation.prototype.validerSiVide = function (element) {
            if (element.value.length < 1) {
                return true;
            }
            else {
                return false;
            }
        };
        validationFacturation.prototype.validerPattern = function (element, motif) {
            var regexp = new RegExp(motif);
            return regexp.test(element.value);
        };
        validationFacturation.prototype.afficherErreur = function (element, message) {
            console.log("afficher erreur");
            var conteneurFormulaire = element.closest('.ctnForm');
            var conteneurErreur = conteneurFormulaire.querySelector('.erreur');
            var iconeErreur = "<span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>";
            console.log("conteneur formulaire : " + conteneurFormulaire.className);
            conteneurErreur.innerHTML = iconeErreur + "<span class='elementMessageErreur'>" + message + "</span>";
        };
        validationFacturation.prototype.effacerErreur = function (element) {
            var conteneurFormulaire = element.closest('.ctnForm');
            var conteneurErreur = conteneurFormulaire.querySelector('.erreur');
            conteneurErreur.innerHTML = "";
        };
        validationFacturation.prototype.afficherSucces = function (element) {
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
        validationFacturation.prototype.effacerSucces = function (element) {
            var monConteneur = document.querySelector('.' + element.className);
            var mesEnfants = monConteneur.children;
            var nomDernierEnfant = mesEnfants[mesEnfants.length - 1].className;
            if (nomDernierEnfant === "elementIconeSucces") {
                monConteneur.removeChild(monConteneur.childNodes[monConteneur.childNodes.length - 1]);
            }
        };
        return validationFacturation;
    }());
    exports.validationFacturation = validationFacturation;
});
//# sourceMappingURL=validationFacturation.js.map