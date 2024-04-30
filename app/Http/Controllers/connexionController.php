<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PdoGsb;

class connexionController extends Controller
{
    function connecter(){

        return view('connexion')->with('erreurs',null);
    }
    function valider(Request $request){
        $login = $request['login'];
        $mdp = $request['mdp'];
        $visiteur = PdoGsb::getInfosVisiteur($login,$mdp);
        $comptable=PdoGsb::getInfosComptable($login,$mdp);
        $gestionnaire=PdoGsb::getInfosGestionnaire($login,$mdp);
        if(!is_array($visiteur) && !is_array($comptable) && !is_array($gestionnaire)){
            $erreurs[] = "Login ou mot de passe incorrect(s)";
            return view('connexion')->with('erreurs',$erreurs);
        }
        else if(is_array($comptable)){
            session(['comptable' => $comptable]);
            return view('sommaireComptable')->with('comptable',session('comptable'));

        }
        else if(is_array($visiteur)){
            session(['visiteur' => $visiteur]);
            return view('sommaire')->with('visiteur',session('visiteur'));
        }

        else if(is_array($gestionnaire)){
            session(['gestionnaire' => $gestionnaire]);
            return view('sommaireGestionnaire')->with('gestionnaire',session('gestionnaire'));
        }
    }
    function deconnecter(){
        $visiteur=session('visiteur');
        $gestionnaire=session('gestionnaire');
        $comptable=session('comptable');
            if(isset($visiteur)){
                echo "Test deconnexion 1";
                session(['visiteur' => null]);
                return redirect()->route('chemin_connexion');
            }
            else if(isset($comptable)){
                echo "Test deconnexion 2";
                session(['comptable' => null]);
                return redirect()->route('chemin_connexion');
            }
            else if(isset($gestionnaire)){
                echo "Test deconnexion 3";
                session(['gestionnaire' => null]);
                return redirect()->route('chemin_connexion');
            }


    }

}
