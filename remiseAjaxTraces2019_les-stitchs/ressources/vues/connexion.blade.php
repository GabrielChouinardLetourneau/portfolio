@extends('gabarit')

@section('contenu')
    <h1 class="h1 souligneRouge"><span class="lettreBeige">{{$nomPage[0]}}</span>{{$nomPage}}</h1>
    <form class="connexion__formulaire" method="POST" action="index.php?controleur=client&action=validerClient">
        <input class="visuallyhidden" name="dernierePage" value="{{$dernierePage}}">
        <div class="ctnForm connexion__formulaire__courriel" id="ok-courriel">
            <label for="courrielConnexion">Courriel</label>
            <input name="courriel" type="email" id="courrielConnexion" @if($tValidation['courriel']['valeur']!=='') value="{{$tValidation['courriel']['valeur']}}" @endif required pattern="[a-zA-Z0-9_]+(.[a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+(.[a-zA-Z0-9_]+)*.[a-zA-Z]{2,4}"><svg class="succes">
                    <use xlink:href="#success" />
                </svg>
            <p class="erreur__message" @if($tValidation['courriel']['valide']=='faux') style="display: block;" @endif>
            @if($tValidation['courriel']['valide']=='faux')
                <span class="spriteRETRO spriteRETRO--warning">{{$tValidation['courriel']['message']}}</span>
            @endif
            </p>
        </div>
        <div class="ctnForm connexion__formulaire__motDePasse" id="ok-motDePasse">
            <label for="motDePasseConnexion">Mot de passe</label>
            <input name="motDePasse" type="password" id="motDePasseConnexion" required pattern="(?=.*[a-zà-ÿ])(?=.*[A-ZÀ-Ÿ])(?=.*[0-9]).{8,18}" maxlength="18" minlength="8"><svg class="succes">
                    <use xlink:href="#success" />
                </svg>
            <p class="erreur__message" @if($tValidation['mot_de_passe']['valide']=='faux') style="display: block;" @endif>
            @if($tValidation['mot_de_passe']['valide']=='faux')
                <span class="spriteRETRO spriteRETRO--warning">{{$tValidation['mot_de_passe']['message']}}</span>
            @endif
            </p>
            <div class="connexion__formulaire__motDePasse__checkbox">
                <label class="connexion__formulaire__motDePasse__checkboxEtiquette" for="afficherMotDePasse">Afficher le mot de passe
                    <input name="afficherMotDePasse" type="checkbox" id="afficherMotDePasse">
                    <span></span>
                </label>
            </div>
            <a href="#">Mot de passe oublié?</a>
        </div>  
        <p class="erreur__message" @if($tValidation['connexion']['valide']=='faux') style="display: block;" @endif>
            @if($tValidation['connexion']['valide']=='faux')
                <span class="spriteRETRO spriteRETRO--warning">{{$tValidation['connexion']['message']}}</span>
            @endif
        </p>

        <button class="boutonOrangePrincipal" type="submit">SE CONNECTER</button>
        <div class="connexion__pasDeCompte">
            <p>Vous n'avez pas de compte?</p>
            <a href="index.php?controleur=client&action=creation">Se créer un compte</a>
        </div>
    </form>
@endsection