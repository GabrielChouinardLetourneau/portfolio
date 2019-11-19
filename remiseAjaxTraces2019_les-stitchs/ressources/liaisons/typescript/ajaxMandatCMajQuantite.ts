export class AjaxMandatCMajQuantite {
    private executerAjax_lier = null;

    public constructor() {
        this.executerAjax_lier = this.executerAjax.bind(this);
        this.initialiser();
    }
 
    private static retournerResultat(data, textStatus, jqXHR, id): void {
       let donnees = data;
       let arrDonnees = JSON.parse(donnees);
       let idLivre = id;

       // Trouve le préfixe : "m-" ou "t-" selon la résolution de l'écran
        let idPrefixe = id.substring(0, 2);

        let isbn = id.substring(2, id.length);

        let champCourant = document.getElementById(id);

        // Met à jour le montant sous total
        let champMontantSommaireSousTotal = $(champCourant).closest('.panier').find('.m-panier__sousTotalPrixMontant');
        $(champMontantSommaireSousTotal).text(arrDonnees["montantSousTotal"]);

        // Met à jour le montant total de l'item
        let champMontantTotalItem = $(champCourant).closest('.panier__infosLivresContenu').find('.'+idPrefixe + 'panier__infosLivresContenuAutresSousTotal');
        $(champMontantTotalItem).text(arrDonnees["montantTotalItem"]);

        // Met à jour le montant du sous-total
        let champMontantSousTotal = $(champCourant).closest('.panier__contenu').find('.panier__commandePrixSousTotalMontant');
        $(champMontantSousTotal).text(arrDonnees["montantSousTotal"]);

        // Met à jour le montant de la TPS
        let champMontantTps = $(champCourant).closest('.panier__contenu').find('.panier__commandePrixTaxesMontant');
        $(champMontantTps).text(arrDonnees["montantTps"]);

        // Met à jour le montant total
        let champMontantTotal = $(champCourant).closest('.panier__contenu').find('.panier__commandeTotalPrixMontant');
        $(champMontantTotal).text(arrDonnees["montantTotal"]);

        // Met à jour le nombre d'articles dans le titre de la page
        let champNbArticlesPanierTitre = $(champCourant).closest('.panier').find('.panier__titreNbItems');
        $(champNbArticlesPanierTitre).text(arrDonnees["nbTotalArticles"]);

        // Met à jour le nombre d'articles dans l'en-tête
        let champNbArticlesPanier = $('body').find('.entete__deuxiemeRangeePanierNbArticles');
        $(champNbArticlesPanier).text(arrDonnees["nbTotalArticles"]);

        // Met à jour le message de livraison
        let champMessageLivraison = $('.panier').find('.panierMessageLivraisonGratuite');
        if(parseInt(arrDonnees['montantSousTotal']) > 50) {
            $(champMessageLivraison).html("Vous avez le droit à la livraison <span class='panierMessageLivraisonGratuiteEnGras'>gratuite</span>");
        }
        else {
            $(champMessageLivraison).html("Livraison <span class='panierMessageLivraisonGratuiteEnGras'>gratuite</span> à partir de 50,00$ avant taxes");
        }

        // Met à jour la liste déroulante du mode de livraison
       if(parseInt(arrDonnees["montantSousTotal"]) > 50) {
            $(champCourant).closest('.panier__contenu').find('select option[value="gratuit"]').removeAttr('class');

           $(champCourant).closest('.panier__contenu').find('select option[value="gratuit"]').attr("selected", "selected");
       }
       else
       {
           $(champCourant).closest('.panier__contenu').find('select option[value="gratuit"]').addClass('cache');

           $(champCourant).closest('.panier__contenu').find('select option[value="gratuit"]').removeAttr("selected");
       }

       // Met à jour la date de livraison
        let champDateLivraison = $('.panier').find('.panier__commandeDateLivraisonDate');
        $(champDateLivraison).text(arrDonnees['dateDelaiLivraison']) ;


       $(champCourant).closest('.panier__contenu').find('.panier__commandePrixModeLivraisonMontant').text(arrDonnees['montantModeLivraison']);
    }

    private executerAjax(evenement):void {
        $.ajax({
            url: 'index.php?controleur=panier&action=majQuantite&isbn=' + evenement.currentTarget.id,
            type: 'GET',
            data: 'choixQuantite=' + $(evenement.currentTarget).val()
        })
            .done(function (data, textStatus, jqXHR): void {
                AjaxMandatCMajQuantite.retournerResultat(data, textStatus, jqXHR, evenement.currentTarget.id);
            })
        console.log('Ceci s’affichera avant que la méthode retournerResultat ne soit appelée');
    }

    private initialiser():void {
        let arrSelect = document.querySelectorAll('.quantiteListe');

        for(let intCpt:number = 0; intCpt < arrSelect.length; intCpt++) {
            $(arrSelect[intCpt]).on('change', this.executerAjax_lier);
        }
    }

}