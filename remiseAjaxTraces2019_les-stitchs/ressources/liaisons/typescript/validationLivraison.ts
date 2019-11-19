/**
 * @file Méthodes et fonctions utilisées pour la validation de l'étape livraison
 * @author Gabriel Chouinard Létourneau <chouinardletourneaug@gmail.com>
 * @version versionFinale
 */

export class validationLivraison {

    // Attributs
    private objMessages: JSON;
    private arrMessagesErreurs: Array<string> = new Array();

    // Éléments du formulaire à valider
    // private refArrTypeCarte: Array<HTMLElement> = Array.apply(null, document.querySelectorAll('[name=typeCarte'));
    private refNom: HTMLInputElement = document.querySelector('#nom');
    private refPrenom: HTMLInputElement = document.querySelector('#prenom');
    private refAdresse: HTMLInputElement = document.querySelector('#adresse');
    private refVille: HTMLInputElement = document.querySelector("#ville");
    private refProvince: HTMLInputElement = document.querySelector("#province");
    private refCodePostal: HTMLInputElement = document.querySelector("#code_postal");


    constructor() {
        fetch("../ressources/lang/fr_CA.UTF-8/messagesUtilisateurValidation.json")
            .then(response => response.json())
            .then(response => {
                this.objMessages = response;
        });
        document.querySelector("form").noValidate = true;
        this.initialiser();
    }

    private initialiser():void {
        this.refNom.addEventListener('blur', this.validerNom.bind(this));
        this.refPrenom.addEventListener('blur', this.validerPrenom.bind(this));
        this.refAdresse.addEventListener('blur', this.validerAdresse.bind(this));
        this.refVille.addEventListener('blur', this.validerVille.bind(this));
        this.refProvince.addEventListener('blur', this.validerProvince.bind(this));
        this.refCodePostal.addEventListener('blur', this.validerCodePostal.bind(this));
    }


    /**
     * Validation de la nom
     * @param {HTMLInputElement} référence du champ envoyé du Jour
     * @param {HTMLInputElement} référence du champ envoyé du Mois
     * @param {HTMLInputElement} référence du champ envoyé de l'Année
     * @param {string} type du champ pour la navigation de l'objet JSON
    */
   private validerNom(evenement):void {
        const element:HTMLInputElement = evenement.currentTarget;
        const lePattern:string = element.pattern;
        const elementParent:HTMLElement = element.closest('p');
        let message:string = "";

        // Si le champ est vide
        if(this.validerSiVide(element) === true) {
            //message = "Entrez le nom complet du titulaire de la carte.";
            message = this.objMessages["nom"]["vide"];
            element.classList.remove("elementSucces");
            element.classList.add("elementErreur");
        }
        // Si le pattern n'est pas respecté
        else if(this.validerPattern(element, lePattern) === false)
        {
        //message = "Nom du titulaire invalide.";
        message = this.objMessages["nom"]["pattern"];

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

   private validerPrenom(evenement):void {
        const element:HTMLInputElement = evenement.currentTarget;
        const lePattern:string = element.pattern;
        const elementParent:HTMLElement = element.closest('p');
        let message:string = "";

        // Si le champ est vide
        if(this.validerSiVide(element) === true) {
            message = this.objMessages["prenom"]["vide"];
            element.classList.remove("elementSucces");
            element.classList.add("elementErreur");
        }
        // Si le pattern n'est pas respecté
        else if(this.validerPattern(element, lePattern) === false)
        {
        //message = "Nom du titulaire invalide.";
        message = this.objMessages["prenom"]["pattern"];

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


    private validerAdresse(evenement):void {
        const element:HTMLInputElement = evenement.currentTarget;
        const lePattern:string = element.pattern;
        const elementParent:HTMLElement = element.closest('p');
        let message:string = "";

        if(this.validerSiVide(element) === true) {
            //message = "Vous devez entrer une adresse.";
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
    /**
     * Validation du pattern
     * @param {HTMLInputElement} référence du champ à tester
     * @param {HTMLInputElement} référence du motif qui sera utilisé pour le test
     * @param {boolean} type réponse au test regex
    */
   private validerPattern(element, motif):boolean {
        const regexp = new RegExp(motif);
        return regexp.test(element.value);
    }

    /**
     * Validation que le champ n'est pas vide
     * @param {HTMLInputElement} référence du champ à tester
     * @param {boolean} type réponse au test regex
    */
    private validerSiVide(element):boolean {
        if(element.value.length <  1) {
            return true;
        }
        else
        {
            return false;
        }
    }
    /**
     * Validation de la nom
     * @param {HTMLInputElement} référence du champ envoyé du Jour
     * @param {String} type message d'erreur
    */
    private afficherErreur(element, message):void {
        const conteneurFormulaire:HTMLElement = element.closest('.ctnForm');
        const conteneurErreur:HTMLElement = conteneurFormulaire.querySelector('.erreur');
        conteneurFormulaire.classList.add("erreurMargin");
 
        const iconeErreur:string = "<span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>"

        conteneurErreur.innerHTML = iconeErreur + "<span>" + message + "</span>";
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
                elementSucces.classList.add("elementIconeSucces");
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


