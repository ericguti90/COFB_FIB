<?php namespace App\Http\Controllers;
use Auth;
use Redirect;
use Request;
use Input;
use DateTime;
use App\Esdeveniment;
use App\Assistent;
use App\Votacio;
use App\Pregunta;
use App\VotacioAssistent;
 
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
	        	if(!$fecha) {print_r("falta data");die;}
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
 			if($result->isEmpty() && $ass != "") {
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

	public function postVotacions()
	{
		
		if (!Request::input('name')) print_r("falta name");
		else if (!Request::input('dataIni')) print_r("falta dataIni");
		else if (!Request::input('dataFin')) print_r("falta dataFin");
		else if (Request::input('esd') == "Selecciona") print_r("falta esd");
		else {
			$votacio=Votacio::where('titol', '=', Request::input('name'))->get();
 			if($votacio != "[]") print_r("falta name");
 			else {
 				$formato = 'Y-m-d H:i:s';
	        	$fechaIni = DateTime::createFromFormat($formato, Request::input('dataIni'));
	        	if(!$fechaIni) {print_r("falta dataIni");die;}
	        	$fechaFin = DateTime::createFromFormat($formato, Request::input('dataFin'));
	        	if(!$fechaFin) {print_r("falta dataFin");die;}
	        	$esd = Esdeveniment::where('titol', '=', Request::input('esd'))->select('id')->first();
	        	$vota = array('titol'=>Request::input('name'));
	        	$vota = array_add($vota,'dataHoraIni',$fechaIni);
	        	$vota = array_add($vota,'dataHoraFin',$fechaFin);
	        	$vota = array_add($vota,'esdeveniment_id',$esd->id);
	        	$novaVotacio=Votacio::create($vota);
	        	print_r($novaVotacio->id);
	        	print_r(',');
	        	print_r($esd->id);
 			}
		}
	}

	public function postPreguntes()
	{
		$preguntes = Request::input('arr');
		foreach ($preguntes as $preg) {
			$result=Pregunta::where('votacio_id', '=', Request::input('id'))->where('titol', '=', $preg[0])->get();
 			if($result->isEmpty() && $preg[0]!="") {
 				$nouPreg = array('titol'=>$preg[0]);
 				$nouPreg = array_add($nouPreg,'opcions',$preg[1]);
 				$nouPreg = array_add($nouPreg,'votacio_id',Request::input('id'));
 				if($preg[2] == "true") $nouPreg = array_add($nouPreg,'obligatoria',true);
 				else $nouPreg = array_add($nouPreg,'obligatoria',false);
 				$novaPregunta = Pregunta::create($nouPreg);
 			}
		}
	}

	public function getAssistents()
	{
		$ass = Assistent::where('esdeveniment_id', '=', Request::input('id'))->select('usuari')->get();
		$primer = true;
		$result="";
		if($ass){
			foreach ($ass as $assi) {
				if($primer) {
					$primer = false;
				}
				else {
					$result = $result . ",";
				}
				$result = $result . $assi->usuari;
			}
		}
		print_r($result);
	}

	public function postAssistentsVotacio(){
		$array = Request::input('ass');
		if($array){
			foreach ($array as $ass) {
				$id = Assistent::where('usuari', "=", $ass)->select('id')->first();
				$voAs = VotacioAssistent::where('assistent_id', "=", $id->id)->where('votacio_id', '=', Request::input('id'))->get();
				if($voAs->isEmpty()) {
					$result = array('assistent_id'=>$id->id);
					$result = array_add($result,'votacio_id',Request::input('id'));
					$novaVoAs = VotacioAssistent::create($result);
				}
			}
		}
	}
}