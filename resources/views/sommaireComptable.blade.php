@extends ('modeles/visiteur')
@section('menu')
    <!-- Division pour le sommaire -->
    <div id="menuGauche">
        <div id="infosUtil">

        </div>
        <ul id="menuList">
            <li >
                <strong>Bonjour {{ $comptable['nom'] . ' ' . $comptable['prenom'] }}</strong>

            </li>
            <li class="smenu">
                <a href="{{ route('chemin_gestionFrais')}}" title="Saisie fiche de frais ">Saisie fiche de frais</a>
            </li>
            <li class="smenu">
                <a href="{{ route('chemin_selectionMois') }}" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
            </li>
            <li class="smenu">
                <a href="{{ route('chemin_test')}}" title="test">2</a>
            </li>
            <li class="smenu">
                <a href="{{ route('chemin_deconnexion') }}" title="Se déconnecter">Déconnexion</a>
            </li>
            <li class="smenu">
                <a href="{{ route('listepersonne') }}" title="Se déconnecter">Liste des utilisateurs</a>
            </li>
        </ul>

    </div>
@endsection
