<?php namespace App\Http\Controllers;
use Auth;
use Redirect;
use Request;
use Input;
use DateTime;
use App\Esdeveniment;
use App\Assistent;
 
class AjaxController extends Controller {
 
 
	// Al recibir los datos del formulario de Login.
	public function postEsdeveniment()
	{
		// Primero comprobaremos si estamos recibiendo todos los campos.
        if (!Request::input('name')) print_r("falta name");
        else if (!Request::input('data')) print_r("falta data");
 		else {
 			$esdeveniment=Esdeveniment::where('titol', '=', Request::input('name'))->get();
 			if($esdeveniment != "[]") print_r("falta name");
 			else {
	 			$esd = array('titol'=>Request::input('name'));
	 			$esd = array_add($esd,'lloc',Request::input('lloc'));
	 			$formato = 'Y-m-d H:i:s';
	        	$fecha = DateTime::createFromFormat($formato, Request::input('data'));
	        	if(!$fecha) {print_r("data incorrecta");die;}
	        	$esd = array_add($esd,'dataHora',$fecha);
	        	if(Request::input('oberta') == "false") $esd = array_add($esd,'inscripcioOberta',false);
	        	else $esd = array_add($esd,'inscripcioOberta', true);
	        	if(Request::input('lloc') == "") $esd = array_add($esd,'presencial', true);
	        	else $esd = array_add($esd,'presencial', false);
	        	//print_r($esd);die;
	        	$nouEsdeveniment=Esdeveniment::create($esd);
	        	print_r($nouEsdeveniment->id);
	        }
 		}
	}

	public function postAssistents()
	{
		$assistent = Request::input('arr');
		foreach ($assistent as $ass) {
			$result=Assistent::where('esdeveniment_id', '=', Request::input('id'))->where('usuari', '=', $ass)->get();
 			if($result->isEmpty()) {
 				$nouAss = array('usuari'=>$ass);
 				$nouAss = array_add($nouAss,'assistit',false);
 				$nouAss = array_add($nouAss,'delegat',false);
 				$nouAss = array_add($nouAss,'esdeveniment_id',Request::input('id'));
 				$formato = 'Y-m-d H:i:s';
 				$fecha = DateTime::createFromFormat($formato, "0-0-0 0:0:0");
 				$nouAss = array_add($nouAss,'dataHora',$fecha);
 				$nouAssistent = Assistent::create($nouAss);
 			}
		}
	}
}