@extends('sommaire')
@section('contenu1')
<div id="contenu">
<form action="{{Route('ajoutuser')}}" method="post">
    {{csrf_field()}}
    <br>
    <label for="fname">Prénom:</label><br>
    <input type="text" id="prenom" name="prenom" >

  <br>
    <label for="lname">Nom:</label><br>
    <input type="text" id="nom" name="nom">

  <br>

  <br>

  <label for="fname">Login:</label><br>
  <input type="text" id="login" name="login">

  <br>

  <br>
    <label for="lname">Mdp:</label><br>
    <input type="text" id="mdp" name="mdp">
  
    <br>

  <br>

  
  <br>

  <label for="fname">Adresse:</label><br>
  <input type="text" id="adresse" name="adresse">

  <br>
  <br>

  <label for="fname">Code Postal:</label><br>
  <input type="text" id="cp" name="cp" value=>

  <br>
  <br>

  <label for="fname">Ville:</label><br>
  <input type="text" id="ville" name="ville">

  <br>
  <label for="fname">Date:</label><br>
  <input type="text" placeholder="yyyy-mm-dd" id="text" name="date">

  <br>
  <br>
  <input type="submit" id="btn" value="Valider">




</form>
</div>
@endsection