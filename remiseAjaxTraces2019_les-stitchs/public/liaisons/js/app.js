define(["require", "exports", "./ajaxMandatA", "./ajaxMandatB", "./ajaxMandatCMajQuantite", "./ajaxMandatCMajModeLivraison", "./validationLivraison", "./validationClient", "./validationFacturation"], function (require, exports, ajaxMandatA_1, ajaxMandatB_1, ajaxMandatCMajQuantite_1, ajaxMandatCMajModeLivraison_1, validationLivraison_1, validationClient_1, validationFacturation_1) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    if (new URLSearchParams(window.location.search).get('action') == 'creation') {
        new ajaxMandatA_1.AjaxMandatA();
    }
    // Non fonctionnel
    new ajaxMandatB_1.AjaxMandatB();
    if (new URLSearchParams(window.location.search).get('controleur') == 'client') {
        new validationClient_1.validationClient();
    }
    if ($('h1').hasClass("panier__titre") || $('h1').hasClass('validation__titre')) {
        new ajaxMandatCMajQuantite_1.AjaxMandatCMajQuantite();
        new ajaxMandatCMajModeLivraison_1.AjaxMandatCMajModeLivraison();
    }
    if ($('h1').hasClass("livraison__titre")) {
        new validationLivraison_1.validationLivraison();
    }
    if ($('h1').hasClass("facturation__titre")) {
        new validationFacturation_1.validationFacturation();
    }
    document.querySelector("body").classList.add("js");
    document.querySelector("body").classList.remove("nojs");
});
//# sourceMappingURL=app.js.map