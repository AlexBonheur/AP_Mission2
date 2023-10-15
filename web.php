<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
        /*-------------------- Use case connexion---------------------------*/
Route::get('/',[
        'as' => 'chemin_connexion',
        'uses' => 'connexionController@connecter'
]);

Route::post('/',[
        'as'=>'chemin_valider',
        'uses'=>'connexionController@valider'
]);
Route::get('deconnexion',[
        'as'=>'chemin_deconnexion',
        'uses'=>'connexionController@deconnecter'
]);

         /*-------------------- Use case état des frais---------------------------*/
Route::get('selectionMois',[
        'as'=>'chemin_selectionMois',
        'uses'=>'etatFraisController@selectionnerMois'
]);

Route::post('listeFrais',[
        'as'=>'chemin_listeFrais',
        'uses'=>'etatFraisController@voirFrais'
]);

        /*-------------------- Use case gérer les frais---------------------------*/

Route::get('gererFrais',[
        'as'=>'chemin_gestionFrais',
        'uses'=>'gererFraisController@saisirFrais'
]);

Route::post('sauvegarderFrais',[
        'as'=>'chemin_sauvegardeFrais',
        'uses'=>'gererFraisController@sauvegarderFrais'
]);

Route::get('test',[
    'as'=>'chemin_test',
    'uses'=>'etatFraisController@test'
]);
Route::get('listePersonne',[
        'as'=>'listepersonne',
        'uses'=>'etatFraisController@listePersonne',
]);

Route::get('supprUtilisateur',[
        'as'=>'supprimeruser',
        'uses'=>'etatFraisController@supprUser'
]);

Route::get('ajoutuser',[
        'as'=>'ajouteruser',
        'uses'=>'etatFraisController@ajoutUser'
]);

Route::get('modifuser',[
        'as'=>'modifieruser',
        'uses'=>'etatFraisController@selectionneruser'
]);// cette lign

Route::post('modificationuser',[
        'as'=>'modificauser',
        'uses'=>'etatFraisController@modifierUser'
]);

Route::post('ajoutUser',[
        'as'=>'ajoutuser',
        'uses'=>'etatFraisController@ajouterUtilisateur'
]);

Route::get('genererPdf',[
        'as'=>'genePdf',
        'uses'=>'etatFraisController@genererEtat'
]);

