/**
 * @file Méthodes et fonctions utilisées pour le catalogue
 * @author Gabriel Chouinard Létourneau <chouinardletourneaug@gmail.com>
 * @version versionFinale
 */

export class Catalogue {
    private executerAjax_lier = null;
    private refBtnMenuCategories = <HTMLInputElement>document.getElementById('categoriesMenu');
    private refContenuMobile = <HTMLInputElement>document.getElementById('categoriesMobileContenu');

    public constructor() {
        this.initialiser();
        console.log('mandatA');
    }
 
    private initialiser() {
        console.log("initialiser");
        this.refBtnMenuCategories.addEventListener('click', this.ouvrirMenu.bind(this.refBtnMenuCategories));
    }

    private ouvrirMenu():void {

    }
}
