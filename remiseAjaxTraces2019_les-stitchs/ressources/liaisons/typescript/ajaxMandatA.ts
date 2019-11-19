export class AjaxMandatA {
    private inputCouriel = <HTMLElement>document.getElementById('courrielCreation');
    private static objMessages: JSON;


    public constructor() {
        this.initialiser();
    } 

    private initialiser() {
        this.inputCouriel.addEventListener('blur', this.verifierCourriel.bind(this.inputCouriel));
        fetch("../ressources/lang/fr_CA.UTF-8/messagesUtilisateurValidation.json")
            .then(response => response.json())
            .then(response => {
                AjaxMandatA.objMessages = response;
            });
    }


    private static retournerResultat(data, textStatus, jqXHR){
        var inputCouriel = <HTMLInputElement>document.querySelector('#courrielCreation');

        console.log(data);

        if(data == "Client existant!") {
            // console.log(this.objMessages);
            inputCouriel.closest('.ctnForm')
                .querySelector('.erreur__message').style.display = "block";
            inputCouriel.closest('.ctnForm').querySelector('.erreur__message').innerHTML = AjaxMandatA.objMessages['courriel']['existant'];
            inputCouriel.closest(".ok-afficher").classList.remove("ok-afficher");
        } else if(data == "Client inexistant!") {
            inputCouriel.closest('.ctnForm').querySelector('.erreur__message').innerHTML = AjaxMandatA.objMessages['courriel']['vide'];
        }
    }

    private verifierCourriel(courriel) {
        $.ajax({
            url: 'index.php?controleur=client&action=validerCourriel',
            type: 'GET',
            data: 'courriel='+courriel.target.value,
            dataType: 'html'
        })
            .done(function(data, textStatus, jqXHR) {
                AjaxMandatA.retournerResultat(data, textStatus, jqXHR);
            })
    }
}
