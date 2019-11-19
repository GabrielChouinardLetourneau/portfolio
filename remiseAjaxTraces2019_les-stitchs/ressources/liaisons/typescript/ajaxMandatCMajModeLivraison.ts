export class AjaxMandatCMajModeLivraison {
    private executerAjax_lier = null;

    public constructor() {
        this.executerAjax_lier = this.executerAjax.bind(this);
        this.initialiser();
    }
 
    private static retournerResultat(data, textStatus, jqXHR): void {
        let arrDonnees = JSON.parse(data);

        let elementParent = document.querySelector('.panier');

        // Met à jour le montant total
        let champMontantTotal = $(elementParent).find('.panier__commandeTotalPrixMontant');
        $(champMontantTotal).text(arrDonnees["montantTotal"]);

        // Met à jour le montant du mode livraison
        let champMontantModeLivraison = $(elementParent).find('.panier__commandePrixModeLivraisonMontant');
        $(champMontantModeLivraison).text(arrDonnees["montantModeLivraison"]);

        // Met à jour la date de délai de livraison
        let champDateDelaiLivraison = $(elementParent).find('.panier__commandeDateLivraisonDate');
        $(champDateDelaiLivraison).text(arrDonnees["dateDelaiLivraison"]);
    }

    private executerAjax(evenement):void {
        $.ajax({
            url: 'index.php?controleur=panier&action=majModeLivraison',
            type: 'GET',
            data: 'choixModeLivraison=' + $(evenement.currentTarget).val()
        })
            .done(function (data, textStatus, jqXHR): void {
                AjaxMandatCMajModeLivraison.retournerResultat(data, textStatus, jqXHR);
            })
        console.log('Ceci s’affichera avant que la méthode retournerResultat ne soit appelée');
    }


    private initialiser():void {
        let arrSelect = document.querySelectorAll('.modeLivraisonListe');

        for(let intCpt:number = 0; intCpt < arrSelect.length; intCpt++) {
            $(arrSelect[intCpt]).on('change', this.executerAjax_lier);
        }
    }
}