<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Necesitaremos el modelo Fabricante para ciertas tareas.
use App\Votacio;
use App\Resposta;
use App\Assistent;
use App\Pregunta;

// Necesitamos la clase Response para crear la respuesta especial con la cabecera de localización en el método Store()
use Response;
use DateTime;

class PreguntaRespostaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($idVotacio, $idPregunta)
    {
        // Devolverá todos las preguntas.
        //return "Mostrando los aviones del fabricante con Id $idFabricante";
        $votacio=Votacio::find($idVotacio);
        if ($this->getRouter()->getCurrentRoute()->getPrefix() == '/api') {
            if (! $votacio)
            {
                // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
                // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
                return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un votacio con ese código.'])],404);
            }

            $pregunta=$votacio->preguntes()->find($idPregunta);
            if (! $pregunta)
            {
                // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
                // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
                return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una pregunta con ese código.'])],404);
            }
            return response()->json(['status'=>'ok','data'=>$pregunta->respostes()->get()],200);
            //return response()->json(['status'=>'ok','data'=>$fabricante->aviones],200);
        }
        else {
            $respostes="";
            if($votacio) {
                $pregunta=$votacio->preguntes()->find($idPregunta);
                if($pregunta) $respostes=$pregunta->respostes()->orderBy('dataHora','desc')->paginate(1);
            }
            return view('preguntaRespostaLayouts.show')->with("votacio",$votacio)->with("pregunta",$pregunta)->with("respostes",$respostes);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $idVotacio, $idPregunta)
    {
        // Primero comprobaremos si estamos recibiendo todos los campos.
        if ( !$request->input('idUsuari') || !$request->input('dataHora'))
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
        }
 
        // Buscamos la Votacio.
        $votacio= Votacio::find($idVotacio);
 
        // Si no existe la votacio que le hemos pasado mostramos otro código de error de no encontrado.
        if (!$votacio)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una votacio con ese código.'])],404);
        }

        $pregunta=$votacio->preguntes()->find($idPregunta);
        if (! $pregunta)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una pregunta con ese código.'])],404);
        }
        if ($pregunta->obligatoria == 1 && !$request->input('resposta')) {
            return response()->json(['errors'=>array(['code'=>422,'message'=>'Falta resposta, la pregunta es obligatoria'])],422);
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //queda comprovar l'usuari
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $formato = 'Y-m-d H:i:s';
        $fecha = DateTime::createFromFormat($formato, $request->input('dataHora'));
        $request->merge(array('dataHora' => $fecha));

        //$novaResposta=$pregunta->respostes()->create($request->all());
        $novaResposta = New Resposta();
        $novaResposta->resposta = $request->input('resposta');
        $novaResposta->dataHora = $request->input('dataHora');
        $novaResposta->votacio_id = $votacio->id;
        $novaResposta->pregunta_id = $pregunta->id;
        $novaResposta->usuari_id = $request->input('idUsuari');
        $novaResposta->save();
        // Más información sobre respuestas en http://jsonapi.org/format/
        // Devolvemos el código HTTP 201 Created – [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
        $response = Response::make(json_encode(['data'=>$novaResposta]), 201)->header('Location', 'http://www.dominio.local/respostes/'.$novaResposta->id)->header('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($idVotacio, $idPregunta, $idResposta)
    {
        // Devolverá todos los assistents.
        //return "Mostrando los aviones del fabricante con Id $idFabricante";
        $votacio= Votacio::find($idVotacio);
 
        // Si no existe la votacio que le hemos pasado mostramos otro código de error de no encontrado.
        if (!$votacio)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una votacio con ese código.'])],404);
        }

        $pregunta=$votacio->preguntes()->find($idPregunta);
        if (! $pregunta)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una pregunta con ese código.'])],404);
        }
        $resposta = $pregunta->respostes()->find($idResposta);
        if (! $resposta){
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una resposta con ese código.'])],404);
        }
        return response()->json(['status'=>'ok','data'=>$resposta],200);
        //return response()->json(['status'=>'ok','data'=>$fabricante->aviones],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($idVotacio, $idPregunta, $idResposta)
    {
        // Comprobamos si la votacio que nos están pasando existe o no.
        $votacio= Votacio::find($idVotacio);
 
        // Si no existe la votacio que le hemos pasado mostramos otro código de error de no encontrado.
        if (!$votacio)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una votacio con ese código.'])],404);
        }

        $pregunta=$votacio->preguntes()->find($idPregunta);
        if (! $pregunta)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una pregunta con ese código.'])],404);
        }
        $resposta = $pregunta->respostes()->find($idResposta);
        if (! $resposta){
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una resposta con ese código.'])],404);
        }
 
        // Procedemos por lo tanto a eliminar el assistent.
        $resposta->delete();
 
        // Se usa el código 204 No Content – [Sin Contenido] Respuesta a una petición exitosa que no devuelve un body (como una petición DELETE)
        // Este código 204 no devuelve body así que si queremos que se vea el mensaje tendríamos que usar un código de respuesta HTTP 200.
        return response()->json(['code'=>204,'message'=>'Se ha eliminado la pregunta correctamente.'],204);
    }

    public function respostesAssistents($idVotacio, $idAssistent){
        $assistent = Assistent::find($idAssistent);
        $respostes = Resposta::where('usuari_id', '=', $assistent->usuari)->where('votacio_id', '=', $idVotacio)->get();
        $votacio = Votacio::find($idVotacio);
        //$result = array('votacio'=>$votacio->titol);
        //$result = array_add($result,'usuari',$assistent->usuari);
        //$i = 1;
        //$pregResp = Array();
        if($respostes->count() == $votacio->preguntes()->count()) $total = true;
        else $total = false;
        foreach ($respostes as $res) {
            $pregunta = Pregunta::find($res->pregunta_id);
            $res->pregunta = $pregunta->titol;
            //$pregResp = array_add($pregResp,'pregunta'.$i,$res->resposta);
            //$pregResp = array_add($pregResp,'resposta'.$i,$res->resposta);
            //++$i;
        }
        //$result = array_add($result,'pregResp',$pregResp);

        return view('respostaLayouts.show')->with("result",$respostes)->with("votacio", $votacio->titol)->with("usuari",$assistent->usuari)->with("total",$total);
    }
}
