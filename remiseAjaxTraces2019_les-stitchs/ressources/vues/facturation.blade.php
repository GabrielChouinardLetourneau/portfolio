@extends('gabarit')
@section('contenu')
<div class="facturation">
    <section class="barreProgression">
        <ul class="barreProgressionListe">
            <li class="barreProgressionListeItem">
                <div>1. Livraison</div>
            </li>
            <li class="barreProgressionListeItem etapeEncours">
                <div>2. Facturation</div>
            </li>
            <li class="barreProgressionListeItem">
                <div>3. Validation</div>
            </li>
        </ul>
    </section>
        <h1 class="facturation__titre">Facturation</h1>
        <form action="index.php?controleur=facturation&action=valider" method="POST" novalidate>
            <fieldset class="facturation__informationsPaiement">
                <legend><h2 class="facturation__informationsPaiementTitre">Informations de paiement</h2></legend>
                <fieldset class="ctnForm facturation__informationsPaiementTypeCarte">
                    <legend class="facturation__informationsPaiementTypeCarteTitre screen-reader-only">Type de carte</legend>
                    <ul class="facturation__informationsPaiementTypeCarteListe">
                        <li class="facturation__informationsPaiementTypeCarteItem">
                            <label class="radioLabel" for="paypal">Paypal<input class="radio" type="radio" name="methodePaiement" id="paypal" value="paypal" required @if($methodePaiement == "paypal")
                                checked
                            @endif >
                            <span class="checkmark"></span>
                            </label>
                        </li>
                        <li class="facturation__informationsPaiementTypeCarteItem">
                            <div class="facturation__informationsPaiementTypeCarteContenu">
                                <label class="radioLabel" for="carteCredit">Carte de crédit<input class="radio" type="radio" name="methodePaiement" id="carteCredit" value="carteCredit" required @if($methodePaiement == "carteCredit")
                                    checked
                                @endif >
                                <span class="checkmark"></span>
                            </label>
                            </div>
                            <div class="facturation__informationsPaiementTypeCarteCreditChoix">
                                <span>Cartes de crédits acceptées</span>
                                <ul class="facturation__informationsPaiementTypeCarteCreditChoixListe">
                                    <li class="facturation__informationsPaiementTypeCarteCreditChoixItem">
                                        <svg class="facturation__informationsPaiementTypeCarteCreditVisa">
                                            <use xlink:href="#visa" />
                                        </svg>
                                    </li>
                                    <li class="facturation__informationsPaiementTypeCarteCreditChoixItem">
                                        <svg class="facturation__informationsPaiementTypeCarteCreditMasterCard">
                                            <use xlink:href="#mastercard" />
                                        </svg>
                                    </li>
                                    <li class="facturation__informationsPaiementTypeCarteCreditChoixItem">
                                        <svg class="facturation__informationsPaiementTypeCarteCreditAmericanExpress">
                                            <use xlink:href="#amex" />
                                        </svg>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <p class="erreur">
                        @if($arrMessagesErreurs['methodePaiement']['message'] != "")
                            <span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>
                            {{ $arrMessagesErreurs['methodePaiement']['message'] }}
                        @endif
                    </p>
                </fieldset>
                <div class="ctnForm facturation__informationsPaiementNom">
                    <p class="facturation__informationsPaiementNomConteneur">
                        <label for="nom_complet">Nom</label>
                        <input type="text" id="nom_complet" name="nom_complet" class="facturation__informationsPaiementNomChamp" pattern="^[a-zA-ZÀ-ÿ' -]+$" required value="{{$nom_complet}}">
                    </p>
                    <p class="erreur">
                        @if($arrMessagesErreurs['nom_complet']['message'] != "")
                            <span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>
                            {{ $arrMessagesErreurs['nom_complet']['message'] }}
                        @endif
                    </p>
                </div>
                <div class="ctnForm facturation__informationsPaiementNumeroCarte">
                    <p class="facturation__informationsPaiementNumeroCarteConteneur">
                        <label for="numeroCarte">Numéro de la carte</label>
                        <input type="number" id="numeroCarte" name="numeroCarte" class="facturation__informationsPaiementNumeroCarteChamp" required value="@if($numeroCarte != ""){{$numeroCarte}} @endif">
                    </p>
                    <p class="erreur">
                        @if($arrMessagesErreurs['numeroCarte']['message'] != "")
                            <span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>
                            {{ $arrMessagesErreurs['numeroCarte']['message'] }}
                        @endif
                    </p>
                </div>
                <div class="ctnForm facturation__informationsPaiementCodeSecurite">
                    <div class="facturation__informationsPaiementCodeSecuriteConteneur">
                        <p class="facturation__informationsPaiementCodeSecuriteContenu">
                            <label for="codeSecurite">Code de sécurité</label>
                            <input type="text" maxlength="3" name="code" id="codeSecurite" class="facturation__informationsPaiementCodeSecuriteChamp" pattern="^[0-9]{3}$" required value="@if($code != ""){{$code}} @endif">
                        </p>
                        <span>
                            <svg class="facturation__informationsPaiementCodeSecuriteIcone">
                                <use xlink:href="#info" />
                            </svg>
                    </span>
                    </div>
                    <p class="erreur">
                        @if($arrMessagesErreurs['code']['message'] != "")
                            <span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>
                            {{ $arrMessagesErreurs['code']['message'] }}
                        @endif
                    </p>
                </div>
                <fieldset class="ctnForm facturation__informationsPaiementDateExpiration">
                    <legend>Date d'expiration <span class="facturation__informationsPaiementDateExpirationInfo">MM AAAA</span></legend>
                    <div class="facturation__informationsPaiementDateExpirationConteneur">
                        <div class="facturation__informationsPaiementDateExpirationMois">
                        <label for="mois" class="screen-reader-only">Mois</label>
                        <div class="facturation__informationsPaiementDateExpirationMoisListe">
                            <select name="mois" id="mois" required>
                                <option value="mm">MM</option>
                                <option value="01" @if($mois == "01")
                                    selected
                                @endif >01</option>
                                <option value="02" @if($mois == "02")
                                    selected
                                @endif >02</option>
                                <option value="03" @if($mois == "03")
                                    selected
                                @endif >03</option>
                                <option value="04" @if($mois == "04")
                                    selected
                                @endif >04</option>
                                <option value="05" @if($mois == "05")
                                    selected
                                @endif >05</option>
                                <option value="06" @if($mois == "06")
                                    selected
                                @endif >06</option>
                                <option value="07" @if($mois == "07")
                                    selected
                                @endif >07</option>
                                <option value="08" @if($mois == "08")
                                    selected
                                @endif >08</option>
                                <option value="09" @if($mois == "09")
                                    selected
                                @endif >09</option>
                                <option value="10" @if($mois == "10")
                                    selected
                                @endif >10</option>
                                <option value="11" @if($mois == "11")
                                    selected
                                @endif >11</option>
                                <option value="12" @if($mois == "12")
                                    selected
                                @endif >12</option>
                            </select>
                        </div>
                    </div>
                        <div class="facturation__informationsPaiementDateExpirationAnnee">
                        <label for="annee" class="screen-reader-only">Année</label>
                        <div class="facturation__informationsPaiementDateExpirationAnneeListe">
                            <select name="annee" id="annee" required>
                                <option value="aaaa">AAAA</option>
                                <option value="2017" @if($annee == "2017")
                                    selected
                                @endif>2017</option>
                                <option value="2018" @if($annee == "2018")
                                    selected
                                @endif>2018</option>
                                <option value="2019" @if($annee == "2019")
                                    selected
                                @endif>2019</option>
                                <option value="2020" @if($annee == "2020")
                                    selected
                                @endif>2020</option>
                                <option value="2021" @if($annee == "2021")
                                    selected
                                @endif>2021</option>
                                <option value="2022" @if($annee == "2022")
                                    selected
                                @endif>2022</option>
                                <option value="2023" @if($annee == "2023")
                                    selected
                                @endif>2023</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <p class="erreur">
                        @if($arrMessagesErreurs != NULL)
                            @if($arrMessagesErreurs['mois']['message'] != "")
                                <span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>
                                {{ $arrMessagesErreurs['mois']['message'] }}
                            @elseif($arrMessagesErreurs['annee']['message'] != "")
                                <span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>
                                {{ $arrMessagesErreurs['annee']['message'] }}
                            @elseif($arrMessagesErreurs['expiration']['message'] != "")
                                <span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>
                                {{ $arrMessagesErreurs['expiration']['message'] }}
                            @endif
                        @endif
                    </p>
                </fieldset>
            </fieldset>
        @if($adresseFacturation == FALSE)
            <fieldset class="facturation__adresseFacturation">
                <legend><h2 class="facturation__adresseFacturationTitre">Adresse de facturation</h2></legend>
                <div class="ctnForm facturation__adresseFacturationAdresse">
                    <p class="facturation__adresseFacturationAdresseConteneur">
                        <label for="adresse">Adresse</label>
                        <input type="text" id="adresse" name="adresse" class="facturation__adresseFacturationAdresseChamp" pattern="[0-9]+[a-zA-ZÀ-ÿ \-]+$" required value="{{$adresse}}">
                    </p>
                    <p class="erreur">
                        @if($arrMessagesErreurs['adresse']['message'] != "")
                            <span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>
                            {{ $arrMessagesErreurs['adresse']['message'] }}
                        @endif
                    </p>
                </div>
                <div class="ctnForm facturation__adresseFacturationVille">
                    <p class="facturation__adresseFacturationVilleConteneur">
                        <label for="ville">Ville</label>
                        <input type="text" id="ville" name="ville" class="facturation__adresseFacturationVilleChamp" pattern="^[a-zA-ZÀ-ÿ \-]+$" required value="{{$ville}}">
                    </p>
                    <p class="erreur">
                        @if($arrMessagesErreurs['ville']['message'] != "")
                            <span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>
                            {{ $arrMessagesErreurs['ville']['message'] }}
                        @endif
                    </p>
                </div>
                <div class="ctnForm facturation__adresseFacturationProvince">
                    <label for="province">Province</label>
                    <div class="facturation__adresseFacturationProvinceListe">
                        <select name="province" id="province" required>
                            <option value="defaut">Sélectionner une province</option>
                            <option value="AB" @if($province == "AB")
                                selected
                            @endif>Alberta</option>
                            <option value="CB" @if($province == "CB")
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
                <div class="ctnForm facturation__adresseFacturationCodePostal">
                    <p class="facturation__adresseFacturationCodePostalConteneur">
                        <label for="codePostal">
                            Code postal
                            <span class="facturation__adresseFacturationCodePostalInfo">Ex: G1W 4S2</span>
                        </label>
                        <input type="text" id="codePostal" name="code_postal" class="facturation__adresseFacturationCodePostalChamp" pattern="^[A-Z][0-9][A-Z] [0-9][A-Z][0-9]$" required value="{{$code_postal}}">
                    </p>
                    <p class="erreur">
                        @if($arrMessagesErreurs['code_postal']['message'] != "")
                            <span class='elementIconeErreur'><svg class='iconeErreur'><use xlink:href='#danger'/></svg></span>
                            {{ $arrMessagesErreurs['code_postal']['message'] }}
                        @endif
                    </p>
                </div>
            </fieldset>
        @else
            <fieldset class="facturation__adresseFacturationStatique">
                <legend><h2 class="facturation__adresseFacturationStatiqueTitre">Adresse de facturation</h2></legend>
                <div class="ctnForm facturation__adresseFacturationStatiqueContenu">
                    <span class="facturation__adresseFacturationStatiqueNom">{{ $prenom . " " . $nom}}</span>
                    <span>{{ $adresseLivraison }}</span>
                    <span>Ville de {{ $villeLivraison }}</span>
                    <span>{{ $provinceLivraison }}</span>
                    <span>{{ $code_postalLivraison }}</span>
                </div>
            </fieldset>
        @endif
        <fieldset class="facturation__informationsContact">
            <legend><h2 class="facturation__informationsContactTitre">Informations de contact</h2></legend>
            <p class="facturation__informationsContactTexte">Elles seront utilisées pour confirmer votre commande ou vous joindre en cas de besoin pour le suivi de votre commande</p>
            <p class="facturation__informationsContactCourriel">{{ $courrielClient }}</p>
            <p class="facturation__informationsContactTelephone">{{ $telephoneClient }}</p>
        </fieldset>
        <button type="submit" class="facturation__bouton boutonOrangePrincipal">Facturer la commande</button>
    </form>
    </div>
@endsection