/**
 * @file Méthodes et fonctions utilisées pour l'Ajax de la barre de recherche
 * @author Gabriel Chouinard Létourneau <chouinardletourneaug@gmail.com>
 * @version versionFinale
 */

export class AjaxMandatB {

    //Attributs 
    private trouverAuteurs_lier = null;
    private inputRecherche: HTMLInputElement[] = Array.apply(null, document.querySelectorAll(".entete__rechercheSaisieChamp"));
    private zoneResultats: HTMLElement[] = Array.apply(null, document.querySelectorAll(".zoneResultatsRecherche"));
    private criteresRecherche: HTMLSelectElement[] = Array.apply(null, document.querySelectorAll(".criteresRecherche"));

    public constructor() {
        this.initialiser();
    } 

    // Initialisation
    private initialiser() {
        this.trouverAuteurs_lier = this.trouverAuteurs.bind(this);
        this.inputRecherche.forEach((element) => {
            element.addEventListener("input", () => {
                this.trouverAuteurs_lier(element);
            });
        });
    }

    private trouverAuteurs(element):void {
        let valeurChamp = $(element).val();
        console.log(valeurChamp);
        let reference = this; 
        let valeurCritereRecherche = parent.document.querySelector(".criteresRecherche");
 
        if($(valeurCritereRecherche).val() == "auteur") {
            $.ajax({  
                url: 'index.php?controleur=site& action=trouverAuteursParChamp',
                type: 'POST',
                data: 'auteur=' + valeurChamp,
                dataType: 'html',
            })
                .done(function(data, textStatus, jqXHR) {
                    reference.retournerResultat(data, textStatus, jqXHR);
                });
        }
    };

    private retournerResultat(data, textStatus, jqXHR):void {
        this.zoneResultats.forEach((element) => {
            element.innerHTML = data;
        });
    };
}
