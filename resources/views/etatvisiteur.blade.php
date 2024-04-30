@extends('sommaire')
    @section('contenu1')
        <div class="container text-center contenu" id="contenu">
            <div class=" corpsForm row">
                <div class="col">
                    <h1>liste des visiteurs</h1>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Login</th>
                                <th>Mdp</th>
                                <th>Adresse</th>
                                <th>Code Postal</th>
                                <th>Ville</th>
                                <th>Date d'embauche</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($liste as $unliste)
                            <tr>
                                <td>{{$unliste['id']}}</td>
                                <td>{{$unliste['nom']}}</td>
                                <td>{{$unliste['prenom']}}</td>
                                <td>{{$unliste['login']}}</td>
                                <td>{{$unliste['mdp']}}</td>
                                <td>{{$unliste['adresse']}}</td>
                                <td>{{$unliste['cp']}}</td>
                                <td>{{$unliste['ville']}}</td>
                                <td>{{$unliste['dateEmbauche']}}</td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                        </table><hr>
                        <a href="{{Route('pdf_test', ['id'=>$unliste['id']])}}">Générer le pdf</a>
                </div> 
            </div>       
        </div>
    @endsection