/**
 * @file Méthodes et fonctions utilisées pour la validation des formulaires clients
 * @author Élody Levasseur-Côté <elodylevasseurcote@hotmail.com>
 * @version 1.0
 **/
 
export class validationClient {
    //Objet des messages JSON
    private objMessages: JSON;
    //Toutes les références des inputs
    private refNom:HTMLElement = document.querySelector('#nom');
    private refPrenom:HTMLElement = document.querySelector('#prenom');
    private refCourrielCreation:HTMLElement = document.querySelector('#courrielCreation');
    private refTelephone:HTMLElement = document.querySelector('#telephone');
    private refMotDePasseCreation:HTMLInputElement = document.querySelector('#motDePasseCreation');

    private refCourrielConnexion:HTMLElement = document.querySelector('#courrielConnexion');
    private refMotDePasseConnexion:HTMLInputElement = document.querySelector('#motDePasseConnexion');

    private refBoutonTogglMotDePasse:HTMLElement = document.querySelector('#afficherMotDePasse');


    constructor() {
        var urlParams = new URLSearchParams(window.location.search);

        fetch("../ressources/lang/fr_CA.UTF-8/messagesUtilisateurValidation.json")
            .then(response => response.json())
            .then(response => {
                this.objMessages = response;
            });

        if(urlParams.get('action') == 'connexion') {
            this.connexion();
        } else if(urlParams.get('action') == 'creation') {
            this.creation();
        }
    }

    private connexion():void {
        console.log("connexion");
        this.refCourrielConnexion.addEventListener('blur', this.validerCourriel.bind(this));
        this.refMotDePasseConnexion.addEventListener('blur', this.validerMotDePasse.bind(this));
        this.refBoutonTogglMotDePasse.addEventListener('change', this.togglMotDePasseConnexion.bind(this));
    }

    private creation():void {
        console.log("creation");
        this.refNom.addEventListener('blur', this.validerNom.bind(this));
        this.refPrenom.addEventListener('blur', this.validerPrenom.bind(this));
        this.refCourrielCreation.addEventListener('blur', this.validerCourriel.bind(this));
        this.refTelephone.addEventListener('blur', this.validerTelephone.bind(this));
        this.refMotDePasseCreation.addEventListener('blur', this.validerMotDePasse.bind(this));
        this.refBoutonTogglMotDePasse.addEventListener('change', this.togglMotDePasseCreation.bind(this));
    }

    private validerNom(evenement):void {
        const element = evenement.currentTarget;
        const lePattern = '^[a-zA-ZÀ-ÿ\'-\.]+$';

        if(this.verifierSiVide(element) === true) {
            // Vide
            this.afficherErreur(element, this.objMessages["nom"]["vide"]);
        } else if(this.validerPattern(element, lePattern) === true) {
            // Bon
            this.effacerErreur(element);
            this.montrerSucces(element, "#ok-nom");
        } else {
            // Pas bon
            this.afficherErreur(element, this.objMessages["nom"]["pattern"]);
        }

        // this.verifierFormulaire();
    }

    private validerPrenom(evenement):void {
        const element = evenement.currentTarget;
        const lePattern = '^[a-zA-ZÀ-ÿ\'-\.]+$';

        if(this.verifierSiVide(element) === true) {
            // Vide
            this.afficherErreur(element, this.objMessages["prenom"]["vide"]);
        } else if(this.validerPattern(element, lePattern) === true) {
            // Bon
            this.effacerErreur(element);
            this.montrerSucces(element, "#ok-prenom");
        } else {
            // Pas bon
            this.afficherErreur(element, this.objMessages["prenom"]["pattern"]);
        }

        // this.verifierFormulaire();
    }

    private validerCourriel(evenement):void {
        const element = evenement.currentTarget;
        const lePattern = '^[a-zA-Z0-9_]+(.[a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+(.[a-zA-Z0-9_]+)*.[a-zA-Z]{2,4}$';

        if(this.verifierSiVide(element) === true) {
            // Vide
            this.afficherErreur(element, this.objMessages["courriel"]["vide"]);
        } else if(this.validerPattern(element, lePattern) === true) {
            // Bon
            this.effacerErreur(element);
            this.montrerSucces(element, "#ok-courriel");
        } else {
            // Pas bon
            this.afficherErreur(element, this.objMessages["courriel"]["pattern"]);
        }

        // this.verifierFormulaire();
    }

    private validerTelephone(evenement):void {
        const element = evenement.currentTarget;
        const lePattern = '^[0-9]{10}$';

        if(this.verifierSiVide(element) === true) {
            // Vide
            this.afficherErreur(element, this.objMessages["telephone"]["vide"]);
        } else if(this.validerPattern(element, lePattern) === true) {
            // Bon
            this.effacerErreur(element);
            this.montrerSucces(element, "#ok-telephone");
        } else {
            // Pas bon
            this.afficherErreur(element, this.objMessages["telephone"]["pattern"]);
        }

        // this.verifierFormulaire();
    }

    private validerMotDePasse(evenement):void {
        const element = evenement.currentTarget;
        const lePattern = '^(?=.*[a-zà-ÿ])(?=.*[A-ZÀ-Ÿ])(?=.*[0-9]).{8,20}$';

        if(this.verifierSiVide(element) === true) {
            // Vide
            this.afficherErreur(element, this.objMessages["mot_de_passe"]["vide"]);
        } else if(this.validerPattern(element, lePattern) === true) {
            // Bon
            this.effacerErreur(element);
            this.montrerSucces(element, "#ok-motDePasse");
        } else {
            // Pas bon
            this.afficherErreur(element, this.objMessages["mot_de_passe"]["pattern"]);
        }

        // this.verifierFormulaire();
    }

    // Fonctions utilitaires de validation

    private validerPattern(element, motif = element.pattern):boolean {
        const regexp = new RegExp(motif);
        return regexp.test(element.value);
    }

    private verifierSiVide(element):boolean {
        return element.value === "";
    }

    private afficherErreur(element, message):void {
        element.closest('.ctnForm')
            .querySelector('.erreur__message')
            .style.display = "block";
        element.closest('.ctnForm')
            .querySelector('.erreur__message')
            .innerHTML = message;
        // Mettre les bordures du champs en rouge pour montrer l'erreur
        this.effacerSucces(element);
    }

    private effacerErreur(element):void {
        element.closest('.ctnForm')
            .querySelector('.erreur__message')
            .style.display = "none";
        element.closest('.ctnForm')
            .querySelector('.erreur__message')
            .innerHTML = "";
    }

    private montrerSucces(element, id):void {
        var closest = element.closest(id);
        console.log(closest);
        if(closest.classList.contains("ok-afficher") === false) {
            closest.className += " ok-afficher";
            console.log(closest);
        }
    }

    private effacerSucces(element):void {
        if(element.closest(".ok-afficher") !== null) {
            element.closest(".ok-afficher").classList.remove("ok-afficher");
        }
    }

    private togglMotDePasseConnexion() {
        if (this.refMotDePasseConnexion.type === "password") {
            this.refMotDePasseConnexion.type = "text";
        } else {
            this.refMotDePasseConnexion.type = "password";
        }
    }

    private togglMotDePasseCreation() {
        if (this.refMotDePasseCreation.type === "password") {
            this.refMotDePasseCreation.type = "text";
        } else {
            this.refMotDePasseCreation.type = "password";
        }
    }
}
