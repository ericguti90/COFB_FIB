<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// resource recibe nos parámetros(URI del recurso, Controlador que gestionará las peticiones)
Route::resource('esdeveniments','EsdevenimentController');
Route::resource('votacions','VotacioController');

// Como la clase principal es Esdeveniment y un Assistent no se puede crear si no le indicamos el esdeveniment, 
// entonces necesitaremos crear lo que se conoce como  "Recurso Anidado" de esdeveniment con assistent.
// Definición del recurso anidado:
Route::resource('esdeveniments.assistents','EsdevenimentAssistentController');
Route::resource('votacions.preguntes','VotacioPreguntaController');
Route::resource('votacions.preguntes.respostes','PreguntaRespostaController');