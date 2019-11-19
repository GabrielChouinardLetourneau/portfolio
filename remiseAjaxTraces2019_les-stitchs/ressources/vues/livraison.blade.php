@extends('gabarit')
@section('contenu')
    <div class="livraison">
        <section class="barreProgression">
            <ul class="barreProgressionListe">
                <li class="barreProgressionListeItem etapeEncours">
                    <div>1. Livraison</div>
                </li>
                <li class="barreProgressionListeItem">
                    <div>2. Facturation</div>
                </li>
                <li class="barreProgressionListeItem">
                    <div>3. Validation</div>
                </li>
            </ul>
        </section>
        <h1 class="livraison__titre livraiso__titre--cachee">Livraison</h1>
        <form action="index.php?controleur=livraison&action=valider" method="POST" novalidate>
            <div class="ctnForm livraison__nomConteneur">
                <p class="livraison__nom">
                    <label for="nom" class="livraison__nomEtiquette">Nom</label>
                    <input type="text" id="nom" required name="nom" pattern="^[a-zA-ZÀ-ÿ' -]+$" class="livraison__nomChamp" value="{{$nom}}"
                    >
                </p>
                <p class="erreur">
                    @if($arrMessagesErreurs['nom']['message'] != "")
                        <span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>
                        {{ $arrMessagesErreurs['nom']['message'] }}
                    @endif
                </p>
            </div>
            <div class="ctnForm livraison__prenomConteneur">
                <p class="livraison__prenom">
                    <label for="prenom" class="livraison__prenomEtiquette">Prénom</label>
                    <input type="text" id="prenom" required pattern="^[a-zA-ZÀ-ÿ' -]+$" name="prenom" class="livraison__prenomChamp" value="{{$prenom}}">
                </p>
                <p class="erreur">
                    @if($arrMessagesErreurs['prenom']['message'] != "")
                        <span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>
                        {{ $arrMessagesErreurs['prenom']['message'] }}
                    @endif
                </p>
            </div>
            <div class="ctnForm livraison__adresseConteneur">
                <p class="livraison__adresse">
                    <label for="adresse" class="livraison__adresseEtiquette">Adresse</label>
                    <input type="text" id="adresse" required name="adresse" pattern="^[0-9]+[a-zA-ZÀ-ÿ0-9 \-]+$" id="adresse" class="livraison__adresseChamp" value="{{$adresse}}">
                </p>
                <p class="erreur">
                    @if($arrMessagesErreurs['adresse']['message'] != "")
                        <span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>
                        {{ $arrMessagesErreurs['adresse']['message'] }}
                    @endif
                </p>
            </div>
            <div class="ctnForm livraison__villeConteneur">
                <p class="livraison__ville">
                    <label for="ville" class="livraison__villeEtiquette">Ville</label>
                    <input type="text" id="ville" required name="ville" pattern="^[a-zA-ZÀ-ÿ \-]+$" class="livraison__villeChamp" value="{{$ville}}">
                </p>
                <p class="erreur">
                    @if($arrMessagesErreurs['ville']['message'] != "")
                        <span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>
                        {{ $arrMessagesErreurs['ville']['message'] }}
                    @endif
                </p>
            </div>
            <div class="ctnForm livraison__provinces">
                <label for="province" class="livraison__provincesEtiquette">Province</label>
                <div class="livraison__provincesListe">
                    <select name="province" id="province" required name="province" pattern="^[A-Z]{2}$">
                        <option value="defaut">Sélectionner une province</option>
                        <option value="AB" @if($province == "AB")
                            selected
                        @endif>Alberta</option>
                        <option value="BC" @if($province == "BC")
                        selected
                        @endif>Colombie-Britannique</option>
                        <option value="MB" @if($province == "MB")
                        selected
                        @endif>Manitoba</option>
                        <option value="NB" @if($province == "NB")
                        selected
                        @endif>Nouveau-Brunswick</option>
                        <option value="NS" @if($province == "NS")
                        selected
                        @endif>Nouvelle-Écosse</option>
                        <option value="SK" @if($province == "SK")
                        selected
                        @endif>Saskatchewan</option>
                        <option value="ON" @if($province == "ON")
                        selected
                        @endif>Ontario</option>
                        <option value="QC" @if($province == "QC")
                        selected
                        @endif>Québec</option>
                        <option value="NL" @if($province == "NL")
                        selected
                        @endif>Terre-Neuve et Labrador</option>
                        <option value="PE" @if($province == "PE")
                        selected
                        @endif>Île-du-Prince-Édouard</option>
                        <option value="NU" @if($province == "NU")
                        selected
                        @endif>Nunavut</option>
                        <option value="NT" @if($province == "NT")
                        selected
                        @endif>Territoires du Nord-Ouest</option>
                        <option value="YT" @if($province == "YT")
                        selected
                        @endif>Yukon</option>
                    </select>
                </div>
                <p class="erreur">
                    @if($arrMessagesErreurs['province']['message'] != "")
                        <span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>
                        {{ $arrMessagesErreurs['province']['message'] }}
                    @endif
                </p>
            </div>
            <div class="ctnForm livraison__codePostalConteneur">
                <p class="livraison__codePostal">
                    <label for="code_postal" class="livraison__codePostalEtiquette">
                        Code postal
                        <span class="livraison__codePostalInfo">Ex: G1W 4S2</span>
                    </label>
                    
                    <input type="text" maxlength="7" pattern="[A-Z][0-9][A-Z]( )?[0-9][A-Z][0-9]" required name="code_postal" aria-required="true" name="code_postal" aria-describedby="infoCodePostal" id="code_postal" class="livraison__codePostalChamp" value="{{$code_postal}}">
                    <p class="erreur">
                        @if($arrMessagesErreurs['code_postal']['message'] != "")
                            <span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>
                            {{ $arrMessagesErreurs['code_postal']['message'] }}
                        @endif
                    </p>
                </p>
            </div>
            <div class="livraison__adresseLivraisonConteneur">
                <p class="livraison__adresseLivraison">
                    <label class="livraison__adresseLivraisonEtiquette">Adresse de livraison par défauts
                        <input type="checkbox" name="adresseParDefaut">
                        <!-- Ce span permet d'avoir un checkbox personnalisé -->
                        <span></span>
                    </label>
                </p>
                <p class="erreur"></p>
            </div>
            <div class="livraison__utiliserCommeAdresseFacturationConteneur">
                <p class="livraison__utiliserCommeAdresseFacturation">
                    <label class="livraison__utiliserCommeAdresseFacturationEtiquette" for="adresseFacturation">Utiliser comme adresse de facturation
                        <input type="checkbox" id="adresseFacturation" name="adresseFacturation" class="livraison__utiliserCommeAdresseFacturationChamp">
                        <!-- Ce span permet d'avoir un checkbox personnalisé -->
                        <span class="livraison__utiliserCommeAdresseFacturationChampPersonnalise"></span>
                    </label>
                </p>
            </div>
            <button type="submit" class="livraison__bouton boutonOrangePrincipal">Livrer à cette adresse</button>
        </form>
    </div>
@endsection
