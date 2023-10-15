<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PdoGsb;
use MyDate;
use PDF;
class etatFraisController extends Controller
{
    function selectionnerMois(){
        if(session('visiteur') != null){
            $visiteur = session('visiteur');
            $idVisiteur = $visiteur['id'];
            $lesMois = PdoGsb::getLesMoisDisponibles($idVisiteur);
		    // Afin de sélectionner par défaut le dernier mois dans la zone de liste
		    // on demande toutes les clés, et on prend la première,
		    // les mois étant triés décroissants
		    $lesCles = array_keys( $lesMois );
		    $moisASelectionner = $lesCles[0];
            return view('listemois')
                        ->with('lesMois', $lesMois)
                        ->with('leMois', $moisASelectionner)
                        ->with('visiteur',$visiteur);
        }
        else{
            return view('connexion')->with('erreurs',null);
        }

    }

    function voirFrais(Request $request){
        if( session('visiteur')!= null){
            $visiteur = session('visiteur');
            $idVisiteur = $visiteur['id'];
            $leMois = $request['lstMois'];
		    $lesMois = PdoGsb::getLesMoisDisponibles($idVisiteur);
            $lesFraisForfait = PdoGsb::getLesFraisForfait($idVisiteur,$leMois);
		    $lesInfosFicheFrais = PdoGsb::getLesInfosFicheFrais($idVisiteur,$leMois);
		    $numAnnee = MyDate::extraireAnnee( $leMois);
		    $numMois = MyDate::extraireMois( $leMois);
		    $libEtat = $lesInfosFicheFrais['libEtat'];
		    $montantValide = $lesInfosFicheFrais['montantValide'];
            $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
            $dateModif =  $lesInfosFicheFrais['dateModif'];
            $dateModifFr = MyDate::getFormatFrançais($dateModif);
            $vue = view('listefrais')->with('lesMois', $lesMois)
                    ->with('leMois', $leMois)->with('numAnnee',$numAnnee)
                    ->with('numMois',$numMois)->with('libEtat',$libEtat)
                    ->with('montantValide',$montantValide)
                    ->with('nbJustificatifs',$nbJustificatifs)
                    ->with('dateModif',$dateModifFr)
                    ->with('lesFraisForfait',$lesFraisForfait)
                    ->with('visiteur',$visiteur);
            return $vue;
        }
        else{
            return view('connexion')->with('erreurs',null);
        }
    }

    function test(){
        if (session('visiteur')!= null){
            $visiteur = session('visiteur');
            $idVisiteur = $visiteur['id'];
            return view('test') ->with('visiteur', $visiteur);
        } else{
            return view('connexion') ->with('erreurs', null);
        }
    }

    function listePersonne(){
        //cette fonction permet d'afficher la liste des visiteurs inscrits dans la BDD
        if(session('visiteur')!=null){
            $visiteur = session('visiteur');
            $liste=Pdogsb::Listepersonne();
            return view('listepersonne') ->with('liste', $liste)
            ->with('visiteur',$visiteur);
        }else{
            return view('connexion') ->with('erreurs', null);
        }
    }
     function suppruser(Request $request){
        //cette fonction va permettre de supprimer un utilisateur de la BDD
        if(session('visiteur')!=null){
            $visiteur = session('visiteur');
            $id=$request['id'];
            $req=Pdogsb::supprimerUser($id);
            $liste=Pdogsb::listePersonne();
            return view('listepersonne') ->with('liste', $liste) ->with('visiteur',$visiteur);

        }else{
            return view('connexion') ->with('erreurs', null);
        }
     }
     function selectionneruser(Request $request){
        //cette fonction permet de trouver un utilisateur dans la BDD grâce à son id
        //elle va permettre pour une inscription de vérifier si un utilisateur
        //avec le même id existe
        if(session('visiteur')!=null){

            $visiteur = session('visiteur');

            $id=$request['id'];
            //dd($id);
            $liste=Pdogsb::selectionneruser($id);
            return view('formmodif')->with('liste',$liste)
                    ->with('visiteur', $visiteur);
        }else{
            return view('connexion') ->with('erreurs', null);
        }
     }

     function ajouterUtilisateur(Request $request){
        if(session('visiteur')!=null){

            $visiteur = session('visiteur');
            //dd($visiteur);
            $id=$request['id'];
            $login=$request['login'];
            $mdp=$request['mdp'];
            $nom=$request['nom'];
            $prenom=$request['prenom'];
            $adresse=$request['adresse'];
            $ville=$request['ville'];
            $cp=$request['cp'];
            $date=$request['date'];
            $test=Pdogsb::selectionneruser($id);
            if(empty($test)){
                //verification de si l'utilisateur existe
                //s'il est pas existant on peut donc le créer
                $req=Pdogsb::ajouter($id,$nom,$prenom,$login,$mdp,$adresse,$cp,$ville,$date);
                $liste=Pdogsb::listePersonne();
                return view('listepersonne') ->with('liste', $liste) ->with('visiteur',$visiteur);
            }
            else{
                //si le visiteur est déja crée, l'utilisateur va être renvoyé au formulaire d'ajout
                return view('form_ajout')->with('visiteur',$visiteur);
            }
            
        }else{
            return view('connexion') ->with('erreurs', null);
        }
     }

     function modifierUser(Request $request){
        if(session('visiteur')!=null){
            //fonction qui récup les valeurs du formulaire et modifie en conséquence le visiteur
            $visiteur = session('visiteur');
            $id=$request['id'];
            $login=$request['login'];
            $mdp=$request['mdp'];
            $nom=$request['nom'];
            $prenom=$request['prenom'];
            $adresse=$request['adresse'];
            $ville=$request['ville'];
            $cp=$request['cp'];
            $date=$request['date'];
            $req=Pdogsb::modifierUser($id,$nom,$prenom,$login,$adresse,$cp,$ville,$date,$mdp);
            $liste=Pdogsb::Listepersonne();
            return view('listepersonne') ->with('liste', $liste) ->with('visiteur',$visiteur)
            ;
        }else{
            return view('connexion') ->with('erreurs', null);
        }
     }

    function ajoutUser(){
        //cette fonction fait le lien entre la route et la vue du formulaire d'ajout
        if (session('visiteur')!= null){
            $visiteur = session('visiteur');
            
            return view('form_ajout')->with('visiteur',$visiteur);
        }else{
            return view('connexion') ->with('erreurs', null);
        }
     }

     function genererEtat(){
        if (session('visiteur')!= null){
            $visiteur = session('visiteur');
            $liste=Pdo::genererEtat($id);
            return view('form_ajout')->with('visiteur',$visiteur);
        }else{
            return view('connexion') ->with('erreurs', null);
        }
     }

     function generationid(){
        
     }
}

		   
         
      
