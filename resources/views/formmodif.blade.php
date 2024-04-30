@extends('sommaire')
    @section('contenu1')
    <div id="contenu">

        @foreach($liste as $unliste)


        @endforeach
<form action="{{Route('modificauser')}}" method="post">
    @csrf
    <input type="hidden" id="mdp" name="mdp" value="{{$unliste['mdp']}}">
    <input type="hidden" id="id" name="id" value="{{$unliste['id']}}">
  
    <br>
    <br>

  <label for="lname">Nom:</label><br>
  <input type="text" id="nom" name="nom" value="{{$unliste['nom']}}">

  <br>

  <br>

  <label for="fname">Login:</label><br>
  <input type="text" id="login" name="login" value="{{$unliste['login']}}">

  <br>

  <br>

  <label for="fname">Prénom:</label><br>
  <input type="text" id="prenom" name="prenom" value="{{$unliste['prenom']}}">

  <br>
  <br>

  <label for="fname">Adresse:</label><br>
  <input type="text" id="adresse" name="adresse" value="{{$unliste['adresse']}}">

  <br>
  <br>

  <label for="fname">Code Postal:</label><br>
  <input type="text" id="cp" name="cp" value="{{$unliste['cp']}}">

  <br>
  <br>

  <label for="fname">Ville:</label><br>
  <input type="text" id="ville" name="ville" value="{{$unliste['ville']}}">

  <br>
  <label for="fname">Date:</label><br>
  <input type="text" placeholder="yyyy-mm-dd" id="text" name="date" value="{{$unliste['dateEmbauche']}}">

  <br>
  <br>
  <input type="submit" id="btn" value="Valider">




</form>
</div>
@endsection