/**
 * @file Fichier qui permet de valider les champs dans le formualaire de facturation
 * @author Marie-Li Durand
 * @version
 */

export class validationFacturation {

    // Attributs
    private objMessages: JSON;
    private arrMessagesErreurs: Array<string> = new Array();

    // Éléments du formulaire à valider
    private refArrTypeCarte: Array<HTMLElement> = Array.apply(null, document.querySelectorAll('[name=methodePaiement'));
    private refNom: HTMLInputElement = document.querySelector('#nom_complet');
    private refNumeroCarte: HTMLInputElement = document.querySelector('#numeroCarte');
    private refCodeSecurite: HTMLInputElement = document.querySelector('#codeSecurite');
    private refMois: HTMLInputElement = document.querySelector("#mois");
    private refAnnee: HTMLInputElement = document.querySelector("#annee");
    private refAdresse: HTMLInputElement = document.querySelector("#adresse");
    private refVille: HTMLInputElement = document.querySelector("#ville");
    private refProvince: HTMLInputElement = document.querySelector("#province");
    private refCodePostal: HTMLInputElement = document.querySelector("#codePostal");

    // Constructeur
    public constructor() {
        document.querySelector('form').noValidate = true;
        fetch("../ressources/lang/fr_CA.UTF-8/messagesUtilisateurValidation.json")
            .then(response => response.json())
            .then(response => {
                this.objMessages = response;
            });
        this.initialiser();
    }

    private initialiser():void {
        this.refArrTypeCarte.forEach(btnRadio => btnRadio.addEventListener('blur', this.validerTypeCarte.bind(this)));
        this.refNom.addEventListener('blur', this.validerNom.bind(this));
        this.refNumeroCarte.addEventListener('blur', this.validerNumeroCarte.bind(this));
        this.refCodeSecurite.addEventListener('blur', this.validerCodeSecurite.bind(this));
        this.refMois.addEventListener('blur', this.validerDateExpiration.bind(this));
        this.refAnnee.addEventListener('blur', this.validerDateExpiration.bind(this));
        this.refAdresse.addEventListener('blur', this.validerAdresse.bind(this));
        this.refVille.addEventListener('blur', this.validerVille.bind(this));
        this.refProvince.addEventListener('blur', this.validerProvince.bind(this));
        this.refCodePostal.addEventListener('blur', this.validerCodePostal.bind(this));
    }

    /*
    Méthode qui permet de valider le nom de la carte
     */
    private validerTypeCarte(evenement):void {
        const element:HTMLInputElement = evenement.currentTarget;
        let elementParent = element.closest('.ctnForm');
        let elementLegend = elementParent.querySelector('legend');
        let message:string = "";

        if(element.checked === false) {
            message = this.objMessages['methodePaiement']['vide'];
            element.classList.add("elementErreur");
            console.log("message : " + message);
        }
        else
        {
            element.classList.remove("elementErreur");
        }

        if(message == "") {
            this.effacerErreur(element);
        }
        else
        {
            this.afficherErreur(element, message);
        }

    }
    private validerNom(evenement):void {
        const element:HTMLInputElement = evenement.currentTarget;
        const lePattern:string = element.pattern;
        const elementParent:HTMLElement = element.closest('p');
        let message:string = "";

        // Si le champ est vide
        if(this.validerSiVide(element) === true) {
            //message = "Entrez le nom complet du titulaire de la carte.";
            message = this.objMessages["nom_complet"]["vide"];
            element.classList.remove("elementSucces");
            element.classList.add("elementErreur");
        }
        // Si le pattern n'est pas respecté
        else if(this.validerPattern(element, lePattern) === false)
        {
            //message = "Nom du titulaire invalide.";
            message = this.objMessages["nom_complet"]["pattern"];

            element.classList.remove("elementSucces");
            element.classList.add("elementErreur");
        }
        else
        {
            element.classList.remove("elementErreur");
            element.classList.add("elementSucces");
        }

        if(message == "") {
            this.effacerErreur(element);
            this.afficherSucces(elementParent);
        }
        else
        {
            this.effacerSucces(elementParent);
            this.afficherErreur(element, message);
        }

    }
    private validerNumeroCarte(evenement):void {
        const element:HTMLElement = evenement.currentTarget;
        const lePatternVisa:string = "^[6][0-9]{3}[ ]?[0-9]{4}[ ]?[0-9]{4}[ ]?[0-9]{4}$";
        const lePattenMasterCard:string = "^[5][0-9]{3}[ ]?[0-9]{4}[ ]?[0-9]{4}[ ]?[0-9]{4}$";
        const lePatternAmericanExpress:string = "^[13][0-9]{3}[ ]?[0-9]{4}[ ]?[0-9]{4}[ ]?[0-9]{4}$";
        const elementParent:HTMLElement = element.closest('p');
        let message:string = "";

        // Si le champ est vide
        if(this.validerSiVide(element) === true) {
            message = this.objMessages["no_carte"]["vide"];

            element.classList.remove("elementSucces");
            element.classList.add("elementErreur");

            // Si l'icône de la carte de crédit est présente, on l'a supprime
            let mesEnfants = elementParent.children;
            let nomDernierEnfant = mesEnfants[mesEnfants.length-2].className;

            if(nomDernierEnfant == "elementIconeCarteCredit") {
                console.log(elementParent.childNodes.length-1);
                elementParent.removeChild(elementParent.childNodes[elementParent.childNodes.length-2]);
            }
        }
        // Si c'est visa
        else if(element.value[0] == "6")
        {
            if(this.validerPattern(element, lePatternVisa) === false) {
                message = this.objMessages["no_carte"]["pattern"];

                element.classList.remove("elementSucces");
                element.classList.add("elementErreur");

                // Si l'icône de la carte de crédit est présente, on l'a supprime
                let mesEnfants = elementParent.children;
                let nomDernierEnfant = mesEnfants[mesEnfants.length-2].className;

                if(nomDernierEnfant == "elementIconeCarteCredit") {
                    console.log(elementParent.childNodes.length-1);
                    elementParent.removeChild(elementParent.childNodes[elementParent.childNodes.length-2]);
                }
            }
            else
            {
                element.classList.remove("elementErreur");
                element.classList.add("elementSucces");

                let mesEnfants = elementParent.children;
                let nomDernierEnfant = mesEnfants[mesEnfants.length-2].className;

                if(nomDernierEnfant == "elementIconeCarteCredit") {
                    let elementCarteCredit = elementParent.querySelector('.elementIconeCarteCredit');
                    elementCarteCredit.innerHTML = "<svg class='iconeCarteCredit'><use xlink:href='#visa'/></svg>"
                }
                else
                {
                    let elementTypeCarteCredit:HTMLElement = document.createElement("span");
                    elementTypeCarteCredit.classList.add("elementIconeCarteCredit");
                    elementTypeCarteCredit.innerHTML = "<svg class='iconeCarteCredit'><use xlink:href='#visa'/></svg>";
                    elementParent.appendChild(elementTypeCarteCredit);
                }
            }
        }
        // Si c'est mastercard
        else if(element.value[0] == "5")
        {
            if(this.validerPattern(element, lePattenMasterCard) === false) {
                message = this.objMessages["no_carte"]["pattern"];

                element.classList.remove("elementSucces");
                element.classList.add("elementErreur");

                // Si l'icône de la carte de crédit est présente, on l'a supprime
                let mesEnfants = elementParent.children;
                let nomDernierEnfant = mesEnfants[mesEnfants.length-2].className;

                if(nomDernierEnfant == "elementIconeCarteCredit") {
                    console.log(elementParent.childNodes.length-1);
                    elementParent.removeChild(elementParent.childNodes[elementParent.childNodes.length-2]);
                }
            }
            else
            {
                element.classList.remove("elementErreur");
                element.classList.add("elementSucces");

                let mesEnfants = elementParent.children;
                let nomDernierEnfant = mesEnfants[mesEnfants.length-2].className;

                if(nomDernierEnfant == "elementIconeCarteCredit") {
                    let elementCarteCredit = elementParent.querySelector('.elementIconeCarteCredit');
                    elementCarteCredit.innerHTML = "<svg class='iconeCarteCredit masterCard'><use xlink:href='#mastercard'/></svg>"
                }
                else
                {
                    let elementTypeCarteCredit:HTMLElement = document.createElement("span");
                    elementTypeCarteCredit.classList.add("elementIconeCarteCredit");
                    elementTypeCarteCredit.innerHTML = "<svg class='iconeCarteCredit masterCard'><use xlink:href='#mastercard'/></svg>";
                    elementParent.appendChild(elementTypeCarteCredit);
                }
            }
        }
        // Si c'est american express
        else if(element.value[0] == "3" || element.value[0] == "1")
        {
            if(this.validerPattern(element, lePatternAmericanExpress) === false) {
                message = this.objMessages["no_carte"]["pattern"];
                element.classList.remove("elementSucces");
                element.classList.add("elementErreur");

                // Si l'icône de la carte de crédit est présente, on l'a supprime
                let mesEnfants = elementParent.children;
                let nomDernierEnfant = mesEnfants[mesEnfants.length-2].className;

                if(nomDernierEnfant == "elementIconeCarteCredit") {
                    console.log(elementParent.childNodes.length-1);
                    elementParent.removeChild(elementParent.childNodes[elementParent.childNodes.length-2]);
                }
            }
            else
            {
                element.classList.remove("elementErreur");
                element.classList.add("elementSucces");

                let mesEnfants = elementParent.children;
                let nomDernierEnfant = mesEnfants[mesEnfants.length-2].className;

                if(nomDernierEnfant == "elementIconeCarteCredit") {
                    let elementCarteCredit = elementParent.querySelector('.elementIconeCarteCredit');
                    elementCarteCredit.innerHTML = "<svg class='iconeCarteCredit'><use xlink:href='#amex'/></svg>"
                }
                else
                {
                    let elementTypeCarteCredit:HTMLElement = document.createElement("span");
                    elementTypeCarteCredit.classList.add("elementIconeCarteCredit");
                    elementTypeCarteCredit.innerHTML = "<svg class='iconeCarteCredit'><use xlink:href='#amex'/></svg>";
                    elementParent.appendChild(elementTypeCarteCredit);
                }
            }
        }
        else
        {
            message = this.objMessages["no_carte"]["pattern"];

            element.classList.remove("elementSucces");
            element.classList.add("elementErreur");
        }
        if(message == "") {
            this.effacerErreur(element);
            this.afficherSucces(elementParent);
        }
        else
        {
            this.effacerSucces(elementParent);
            this.afficherErreur(element, message);
        }
    }
    private validerCodeSecurite(evenement):void {
        const element:HTMLInputElement= evenement.currentTarget;
        const lePattern:string = element.pattern;
        const elementParent:HTMLElement = element.closest('p');
        let message:string = "";

        if(this.validerSiVide(element) === true) {
            message = this.objMessages["code"]["vide"];

            element.classList.remove("elementSucces");
            element.classList.add("elementErreur");
        }
        else if(this.validerPattern(element, lePattern) === false) {
            message = this.objMessages["code"]["pattern"];

            element.classList.remove("elementSucces");
            element.classList.add("elementErreur");
        }
        else
        {
            element.classList.remove("elementErreur");
            element.classList.add("elementSucces");
        }

        if(message == "") {
            this.effacerErreur(element);
            this.afficherSucces(elementParent);
        }
        else
        {
            this.effacerSucces(elementParent);
            this.afficherErreur(element, message);
        }
    }
    private validerDateExpiration(evenement):void {
        const element: HTMLInputElement = evenement.currentTarget;
        let message:string = "";
        let messageTotal: string = "";
        const elementParent = this.refAnnee.closest('.facturation__informationsPaiementDateExpirationConteneur');

        // Si aucune date d'expiration n'a été entrée
        if(this.refMois.value === "mm" && this.refAnnee.value === "aaaa") {
            element.classList.remove("elementSucces");
            this.refMois.classList.add("elementErreur");
            this.refAnnee.classList.add("elementErreur");
            message = this.objMessages['expiration']['vide'];
            this.effacerSucces(elementParent);
            this.afficherErreur(element, message);
        }
        // Si l'un des champs est vide
        else if(this.refMois.value === "mm" || this.refAnnee.value === "aaaa")
        {
            // Validation du mois
            if(this.refMois.value === "mm") {
                message = this.objMessages['expiration']['type']['mois'];
                this.arrMessagesErreurs.push(message);
                this.refMois.classList.remove("elementSucces");
                this.refMois.classList.add("elementErreur");
            }
            else
            {
                this.refMois.classList.remove("elementErreur");
                this.refMois.classList.add("elementSucces");
            }

            // Validation de l'année
            if(this.refAnnee.value === "aaaa") {
                message = this.objMessages['expiration']['type']['annee'];
                this.arrMessagesErreurs.push(message);
                this.refAnnee.classList.remove("elementSucces");
                this.refAnnee.classList.add("elementErreur");
            }
            else {
                this.refAnnee.classList.remove("elementErreur");
                this.refAnnee.classList.add("elementSucces");
            }

            for(let nbMessages:number = 0; nbMessages < this.arrMessagesErreurs.length; nbMessages++) {
                messageTotal += this.arrMessagesErreurs[nbMessages];
            }

            this.afficherErreur(element, messageTotal);
            this.arrMessagesErreurs = [];

        }
        else {
            this.effacerErreur(element);
            element.classList.remove("elementErreur");
            element.classList.add("elementSucces");

            if(this.validerDate() == false) {
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
    }
    private validerDate():boolean {
        const moisExpiration:string = this.refMois.value;
        const anneeExpiration: string = this.refAnnee.value;
        const dateExpiration:string = `${anneeExpiration}-${moisExpiration}-${"01"}`;

        if(this.verifierDateExpiration(dateExpiration) == false) {
            return false;
        }
        else {
            return true;
        }

    }
    private formaterDateAujourdui(date):Date {
        const dateAujourdhui:Date = new Date(date);
 
        let mois = '' + (dateAujourdhui.getMonth() + 1),
            jour = '' + dateAujourdhui.getDate(),
            annee = dateAujourdhui.getFullYear();

        return new Date([annee, mois, jour].join("-"));
    }
    private verifierDateExpiration(uneDateExpiration:string):boolean {
        const dateExpiration = new Date(uneDateExpiration);
        return this.formaterDateAujourdui(new Date()).getTime() <= dateExpiration.getTime();
    }
    private validerAdresse(evenement):void {
        const element:HTMLInputElement = evenement.currentTarget;
        const lePattern:string = element.pattern;
        const elementParent:HTMLElement = element.closest('p');
        let message:string = "";

        if(this.validerSiVide(element) === true) {
            message = this.objMessages["adresse"]["vide"];

            element.classList.remove("elementSucces");
            element.classList.add("elementErreur");
        }
        else if(this.validerPattern(element, lePattern) === false) {
            message = this.objMessages["adresse"]["pattern"];

            element.classList.remove("elementSucces");
            element.classList.add("elementErreur");
        }
        else
        {
            element.classList.remove("elementErreur");
            element.classList.add("elementSucces");
        }

        if(message == "") {
            this.effacerErreur(element);
            this.afficherSucces(elementParent);
        }
        else
        {
            this.effacerSucces(elementParent);
            this.afficherErreur(element, message);
        }
    }
    private validerVille(evenement):void {
        const element:HTMLInputElement = evenement.currentTarget;
        const lePattern:string = element.pattern;
        const elementParent:HTMLElement = element.closest('p');
        let message:string = "";

        if(this.validerSiVide(element) === true) {
            message = this.objMessages["ville"]["vide"];

            element.classList.remove("elementSucces");
            element.classList.add("elementErreur");
        }
        else if(this.validerPattern(element, lePattern) === false) {
            message = this.objMessages["ville"]["pattern"];

            element.classList.remove("elementSucces");
            element.classList.add("elementErreur");
        }
        else
        {
            element.classList.remove("elementErreur");
            element.classList.add("elementSucces");
        }

        if(message == "") {
            this.effacerErreur(element);
            this.afficherSucces(elementParent);
        }
        else
        {
            this.effacerSucces(elementParent);
            this.afficherErreur(element, message);
        }
    }
    private validerProvince(evenement):void {
        const element:HTMLInputElement = evenement.currentTarget;
        const elementParent:HTMLElement = element.closest('div');
        let message: string = "";

        if(element.value === "defaut") {
            message = this.objMessages["province"]["vide"];

            element.classList.remove("elementSucces");
            element.classList.add("elementErreur");
        }
        else
        {
            element.classList.remove("elementErreur");
            element.classList.add("elementSucces");
        }

        if(message == "") {
            this.effacerErreur(element);
            this.afficherSucces(elementParent);
        }
        else
        {
            this.effacerSucces(elementParent);
            this.afficherErreur(element, message);
        }
    }
    private validerCodePostal(evenement):void {
        const element:HTMLInputElement = evenement.currentTarget;
        const lePattern:string = element.pattern;
        const elementParent:HTMLElement = element.closest('p');
        let message:string = "";

        if(this.validerSiVide(element) === true) {
            message = this.objMessages["code_postal"]["vide"];

            element.classList.remove("elementSucces");
            element.classList.add("elementErreur");
        }
        else if(this.validerPattern(element, lePattern) === false) {
            message = this.objMessages["code_postal"]["pattern"];

            element.classList.remove("elementSucces");
            element.classList.add("elementErreur");
        }
        else
        {
            element.classList.remove("elementErreur");
            element.classList.add("elementSucces");
        }

        if(message == "") {
            this.effacerErreur(element);
            this.afficherSucces(elementParent);
        }
        else
        {
            this.effacerSucces(elementParent);
            this.afficherErreur(element, message);
        }
    }

    // Méthodes utilitaires
    private validerSiVide(element):boolean {
        if(element.value.length <  1) {
            return true;
        }
        else
        {
            return false;
        }
    }
    private validerPattern(element, motif):boolean {
        const regexp = new RegExp(motif);
        return regexp.test(element.value);
    }
    private afficherErreur(element, message):void {
        console.log("afficher erreur");
        const conteneurFormulaire:HTMLElement = element.closest('.ctnForm');
        const conteneurErreur:HTMLElement = conteneurFormulaire.querySelector('.erreur');
        const iconeErreur:string = "<span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>";



        console.log("conteneur formulaire : " + conteneurFormulaire.className);


        conteneurErreur.innerHTML = iconeErreur + "<span class='elementMessageErreur'>" + message + "</span>";
    }
    private effacerErreur(element):void {
        const conteneurFormulaire:HTMLElement = element.closest('.ctnForm');
        let conteneurErreur:HTMLElement = conteneurFormulaire.querySelector('.erreur');

        conteneurErreur.innerHTML = "";
    }
    private afficherSucces(element):void {
        let monConteneur:HTMLElement = document.querySelector('.' + element.className);

        if(element.className != "facturation__typeCarteTitre") {
            let mesEnfants = monConteneur.children;
            let nomDernierEnfant = mesEnfants[mesEnfants.length-1].className;

            if(nomDernierEnfant != "elementIconeSucces") {
                let elementSucces:HTMLElement = document.createElement("span");
                elementSucces.classList.add("elementIconeSucces")
                elementSucces.innerHTML = "<svg class='iconeSucces'><use xlink:href='#success'/></svg>";
                monConteneur.appendChild(elementSucces);
            }
        }
        else
        {
            let elementSucces:HTMLElement = document.createElement("span");
            elementSucces.classList.add("elementIconeSucces")
            elementSucces.innerHTML = "<svg class='iconeSucces'><use xlink:href='#success'/></svg>";
            monConteneur.appendChild(elementSucces);
        }
    }
    private effacerSucces(element):void {
        let monConteneur:HTMLElement = document.querySelector('.' + element.className);
        let mesEnfants = monConteneur.children;
        let nomDernierEnfant = mesEnfants[mesEnfants.length-1].className;

        if(nomDernierEnfant === "elementIconeSucces") {
            monConteneur.removeChild(monConteneur.childNodes[monConteneur.childNodes.length-1]);
        }
    }
}