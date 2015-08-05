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




/*+--------+----------+------------------------------------------------------------------------+---------------------------------------+--------------------------------------------------------------+------------+

| Domain | Method   | URI                                                                    | Name                                  | Action                                                       | Middleware |

+--------+----------+------------------------------------------------------------------------+---------------------------------------+--------------------------------------------------------------+------------+

|        | GET|HEAD | /                                                                      |                                       | Closure                                                      |            |

|        | GET|HEAD | esdeveniments                                                          | esdeveniments.index                   | App\Http\Controllers\EsdevenimentController@index            |            |

|        | POST     | esdeveniments                                                          | esdeveniments.store                   | App\Http\Controllers\EsdevenimentController@store            |            |

|        | GET|HEAD | esdeveniments/create                                                   | esdeveniments.create                  | App\Http\Controllers\EsdevenimentController@create           |            |

|        | DELETE   | esdeveniments/{esdeveniments}                                          | esdeveniments.destroy                 | App\Http\Controllers\EsdevenimentController@destroy          |            |

|        | PATCH    | esdeveniments/{esdeveniments}                                          |                                       | App\Http\Controllers\EsdevenimentController@update           |            |

|        | PUT      | esdeveniments/{esdeveniments}                                          | esdeveniments.update                  | App\Http\Controllers\EsdevenimentController@update           |            |

|        | GET|HEAD | esdeveniments/{esdeveniments}                                          | esdeveniments.show                    | App\Http\Controllers\EsdevenimentController@show             |            |

|        | POST     | esdeveniments/{esdeveniments}/assistents                               | esdeveniments.assistents.store        | App\Http\Controllers\EsdevenimentAssistentController@store   |            |

|        | GET|HEAD | esdeveniments/{esdeveniments}/assistents                               | esdeveniments.assistents.index        | App\Http\Controllers\EsdevenimentAssistentController@index   |            |

|        | GET|HEAD | esdeveniments/{esdeveniments}/assistents/create                        | esdeveniments.assistents.create       | App\Http\Controllers\EsdevenimentAssistentController@create  |            |

|        | PUT      | esdeveniments/{esdeveniments}/assistents/{assistents}                  | esdeveniments.assistents.update       | App\Http\Controllers\EsdevenimentAssistentController@update  |            |

|        | DELETE   | esdeveniments/{esdeveniments}/assistents/{assistents}                  | esdeveniments.assistents.destroy      | App\Http\Controllers\EsdevenimentAssistentController@destroy |            |

|        | PATCH    | esdeveniments/{esdeveniments}/assistents/{assistents}                  |                                       | App\Http\Controllers\EsdevenimentAssistentController@update  |            |

|        | GET|HEAD | esdeveniments/{esdeveniments}/assistents/{assistents}                  | esdeveniments.assistents.show         | App\Http\Controllers\EsdevenimentAssistentController@show    |            |

|        | GET|HEAD | esdeveniments/{esdeveniments}/assistents/{assistents}/edit             | esdeveniments.assistents.edit         | App\Http\Controllers\EsdevenimentAssistentController@edit    |            |

|        | GET|HEAD | esdeveniments/{esdeveniments}/edit                                     | esdeveniments.edit                    | App\Http\Controllers\EsdevenimentController@edit             |            |

|        | GET|HEAD | votacions                                                              | votacions.index                       | App\Http\Controllers\VotacioController@index                 |            |

|        | POST     | votacions                                                              | votacions.store                       | App\Http\Controllers\VotacioController@store                 |            |

|        | GET|HEAD | votacions/create                                                       | votacions.create                      | App\Http\Controllers\VotacioController@create                |            |

|        | GET|HEAD | votacions/{votacions}                                                  | votacions.show                        | App\Http\Controllers\VotacioController@show                  |            |

|        | PUT      | votacions/{votacions}                                                  | votacions.update                      | App\Http\Controllers\VotacioController@update                |            |

|        | PATCH    | votacions/{votacions}                                                  |                                       | App\Http\Controllers\VotacioController@update                |            |

|        | DELETE   | votacions/{votacions}                                                  | votacions.destroy                     | App\Http\Controllers\VotacioController@destroy               |            |

|        | GET|HEAD | votacions/{votacions}/edit                                             | votacions.edit                        | App\Http\Controllers\VotacioController@edit                  |            |

|        | POST     | votacions/{votacions}/preguntes                                        | votacions.preguntes.store             | App\Http\Controllers\VotacioPreguntaController@store         |            |

|        | GET|HEAD | votacions/{votacions}/preguntes                                        | votacions.preguntes.index             | App\Http\Controllers\VotacioPreguntaController@index         |            |

|        | GET|HEAD | votacions/{votacions}/preguntes/create                                 | votacions.preguntes.create            | App\Http\Controllers\VotacioPreguntaController@create        |            |

|        | PATCH    | votacions/{votacions}/preguntes/{preguntes}                            |                                       | App\Http\Controllers\VotacioPreguntaController@update        |            |

|        | PUT      | votacions/{votacions}/preguntes/{preguntes}                            | votacions.preguntes.update            | App\Http\Controllers\VotacioPreguntaController@update        |            |

|        | GET|HEAD | votacions/{votacions}/preguntes/{preguntes}                            | votacions.preguntes.show              | App\Http\Controllers\VotacioPreguntaController@show          |            |

|        | DELETE   | votacions/{votacions}/preguntes/{preguntes}                            | votacions.preguntes.destroy           | App\Http\Controllers\VotacioPreguntaController@destroy       |            |

|        | GET|HEAD | votacions/{votacions}/preguntes/{preguntes}/edit                       | votacions.preguntes.edit              | App\Http\Controllers\VotacioPreguntaController@edit          |            |

|        | POST     | votacions/{votacions}/preguntes/{preguntes}/respostes                  | votacions.preguntes.respostes.store   | App\Http\Controllers\PreguntaRespostaController@store        |            |

|        | GET|HEAD | votacions/{votacions}/preguntes/{preguntes}/respostes                  | votacions.preguntes.respostes.index   | App\Http\Controllers\PreguntaRespostaController@index        |            |

|        | GET|HEAD | votacions/{votacions}/preguntes/{preguntes}/respostes/create           | votacions.preguntes.respostes.create  | App\Http\Controllers\PreguntaRespostaController@create       |            |

|        | PATCH    | votacions/{votacions}/preguntes/{preguntes}/respostes/{respostes}      |                                       | App\Http\Controllers\PreguntaRespostaController@update       |            |

|        | PUT      | votacions/{votacions}/preguntes/{preguntes}/respostes/{respostes}      | votacions.preguntes.respostes.update  | App\Http\Controllers\PreguntaRespostaController@update       |            |

|        | DELETE   | votacions/{votacions}/preguntes/{preguntes}/respostes/{respostes}      | votacions.preguntes.respostes.destroy | App\Http\Controllers\PreguntaRespostaController@destroy      |            |

|        | GET|HEAD | votacions/{votacions}/preguntes/{preguntes}/respostes/{respostes}      | votacions.preguntes.respostes.show    | App\Http\Controllers\PreguntaRespostaController@show         |            |

|        | GET|HEAD | votacions/{votacions}/preguntes/{preguntes}/respostes/{respostes}/edit | votacions.preguntes.respostes.edit    | App\Http\Controllers\PreguntaRespostaController@edit         |            |

+--------+----------+------------------------------------------------------------------------+---------------------------------------+--------------------------------------------------------------+------------+*/
