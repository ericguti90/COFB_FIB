<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    // Nombre de la tabla en MySQL.
	protected $table='preguntes';
 
	// Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
	// Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
	//protected $primaryKey = 'serie';
 
	// Atributos que se pueden asignar de manera masiva.
	protected $fillable = array('votacio_id','titol','opcions','obligatoria');
 
	// Aquí ponemos los campos que no queremos que se devuelvan en las consultas.
	protected $hidden = ['created_at','updated_at']; 
 
	// Definimos a continuación la relación de esta tabla con otras.
	// Ejemplos de relaciones:
	// 1 usuario tiene 1 teléfono   ->hasOne()
	// 1 teléfono pertenece a 1 usuario   ->belongsTo()
	// 1 post tiene muchos comentarios  -> hasMany()
	// 1 comentario pertenece a 1 post ->belongsTo()
	// 1 usuario puede tener muchos roles  ->belongsToMany()
	//  etc..
 
 
	// Relación de Pregunta con Votacio:
	public function votacio()
	{
		// 1 Pregunta pertenece a una Votacio.
		// $this hace referencia al objeto que tengamos en ese momento de Pregunta.
		return $this->belongsTo('App\Votacio');
	}

	// Relación de Pregunta con Resposta:
	public function assistent()
	{
		// 1 Pregunta tiene muchas respostes
		// $this hace referencia al objeto que tengamos en ese momento de Pregunta.
		return $this->hasMany('App\Resposta');
	}
}
