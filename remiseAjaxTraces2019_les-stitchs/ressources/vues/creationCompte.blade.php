@extends('gabarit')

@section('contenu')
    <h1 class="h1 souligneRouge"><span class="lettreBeige">{{$nomPage[0]}}</span>{{$nomPage}}</h1>
    <form class="creation__formulaire" method="POST" action="index.php?controleur=client&action=inserer">
        <div class="ctnForm creation__formulaire__nom" id="ok-nom">
            <label for="nom">Nom</label>
            <input id="nom" name="nom" type="text" required pattern="^[a-zA-ZÀ-ÿ'-\.]+$" @if($tValidation['nom']['valeur']!=='') value="{{$tValidation['nom']['valeur']}}" @endif><svg class="succes">
                    <use xlink:href="#success" />
                </svg>
            <div class="erreur__message" @if($tValidation['nom']['valide']=='faux') style="display: block;" @endif>
            @if($tValidation['nom']['valide']=='faux')
            <span class="spriteRETRO spriteRETRO--warning"></span>{{$tValidation['nom']['message']}}
            @endif 
            </div>
        </div>
        <div class="ctnForm creation__formulaire__prenom" id="ok-prenom">
            <label for="prenom">Prénom</label>
            <input id="prenom" name="prenom" type="text" required pattern="^[a-zA-ZÀ-ÿ'-\.]+$" @if($tValidation['prenom']['valeur']!=='') value="{{$tValidation['prenom']['valeur']}}" @endif><svg class="succes">
                    <use xlink:href="#success" />
                </svg>
            <div class="erreur__message" @if($tValidation['prenom']['valide']=='faux') style="display: block;" @endif>
            @if($tValidation['prenom']['valide']=='faux')
            <span class="spriteRETRO spriteRETRO--warning"></span>{{$tValidation['prenom']['message']}}
            @endif 
            </div>
        </div> 
        <div class="ctnForm creation__formulaire__courriel" id="ok-courriel">
            <label for="courrielCreation">Courriel</label>
            <input id="courrielCreation" name="courriel" type="email"
            required pattern="^[a-zA-Z0-9][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[.][a-zA-Z]{2,}$" @if($tValidation['courriel']['valeur']!=='') value="{{$tValidation['courriel']['valeur']}}" @endif><svg class="succes">
                    <use xlink:href="#success" />
                </svg>
            <div class="erreur__message" @if($tValidation['courriel']['valide']=='faux') style="display: block;" @endif>
                @if($tValidation['courriel']['valide']=='faux')
                <span class="spriteRETRO spriteRETRO--warning"></span>{{$tValidation['courriel']['message']}}
                @endif 
            </div>
        </div> 
        <div class="ctnForm creation__formulaire__tel" id="ok-telephone">
            <label for="telephone">Téléphone <span>Ex: 4186596600</span></label>
            <input id="telephone" name="telephone" type="tel" required pattern="^[0-9]{10}$" @if($tValidation['telephone']['valeur']!=='') value="{{$tValidation['telephone']['valeur']}}" @endif maxlength="10"><svg class="succes">
                    <use xlink:href="#success" />
                </svg>
            <div class="erreur__message" @if($tValidation['telephone']['valide']=='faux') style="display: block;" @endif>
                @if($tValidation['telephone']['valide']=='faux')
                <span class="spriteRETRO spriteRETRO--warning"></span>{{$tValidation['telephone']['message']}}
                @endif 
            </div>
        </div>  
        <div class="ctnForm creation__formulaire__motDePasse" id="ok-motDePasse">
            <label for="mot_de_passe">Mot de passe <span>8 caractères, lettres et chiffres, une majuscule et une minuscule.</span></label>
            <input id="motDePasseCreation" name="mot_de_passe" type="password" required @if($tValidation['mot_de_passe']['valeur']!=='') value="{{$tValidation['mot_de_passe']['valeur']}}" @endif pattern="(?=.*[a-zà-ÿ])(?=.*[A-ZÀ-Ÿ])(?=.*[0-9]).{8,18}" maxlength="18" minlength="8"><svg class="succes">
                    <use xlink:href="#success" />
                </svg>
            <div class="erreur__message" @if($tValidation['mot_de_passe']['valide']=='faux') style="display: block;" @endif>
                @if($tValidation['mot_de_passe']['valide']=='faux')
                <span class="spriteRETRO spriteRETRO--warning"></span>{{$tValidation['mot_de_passe']['message']}}
                @endif 
            </div>
            <div class="creation__formulaire__motDePasse__checkbox">
                <label class="creation__formulaire__motDePasse__checkboxEtiquette" for="afficherMotDePasse" type="checkbox">Afficher le mot de passe
                    <input name="afficherMotDePasse" type="checkbox" id="afficherMotDePasse">
                    <span></span>
                </label>
            </div>
        </div>
        <p class="erreur__message" @if($tValidation['creation']['valide']=='faux') style="display: block;" @endif  >
            @if($tValidation['creation']['valide']=='faux')
            <span class="spriteRETRO spriteRETRO--warning"></span>{{$tValidation['creation']['message']}}
            @endif 
        </p>
        <button class="boutonOrangePrincipal" type="submit">CRÉER LE COMPTE</button>
        <div class="creation__dejaCompte">
            <p>Vous avez déjà un compte?</p>
            <a href="index.php?controleur=client&action=connexion">Se connecter</a>
        </div>
    </form>
@endsection