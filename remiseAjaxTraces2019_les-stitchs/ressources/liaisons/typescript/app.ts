import { Catalogue } from "./catalogue";
import { AjaxMandatA } from "./ajaxMandatA";
import { AjaxMandatB } from './ajaxMandatB';
import { AjaxMandatCMajQuantite } from './ajaxMandatCMajQuantite';
import { AjaxMandatCMajModeLivraison } from './ajaxMandatCMajModeLivraison';
import { validationLivraison } from "./validationLivraison";
import { validationClient } from "./validationClient";
import {validationFacturation} from "./validationFacturation";

if(new URLSearchParams(window.location.search).get('action') == 'creation') {
    new AjaxMandatA();
}

// Non fonctionnel
new AjaxMandatB(); 

if(new URLSearchParams(window.location.search).get('controleur') == 'client') {
    new validationClient();
}

if($('h1').hasClass("panier__titre") || $('h1').hasClass('validation__titre')) {
    new AjaxMandatCMajQuantite();
    new AjaxMandatCMajModeLivraison();
}

if($('h1').hasClass("livraison__titre")) {
    new validationLivraison();
}  
 
if($('h1').hasClass("facturation__titre")) {
    new validationFacturation();
}

document.querySelector("body").classList.add("js");
document.querySelector("body").classList.remove("nojs");