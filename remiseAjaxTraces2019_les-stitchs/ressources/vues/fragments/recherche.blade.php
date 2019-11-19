@if(isset($arrResultats))
    <ul>
        @foreach($arrResultats as $resultat)
            <li>
                {{ $resultat -> prenom }} {{  $resultat -> nom }}
            </li>
        @endforeach
    </ul>
@endif