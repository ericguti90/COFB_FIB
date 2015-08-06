<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Necesitaremos el modelo Fabricante para ciertas tareas.
use App\Votacio;
use App\Esdeveniment;


// Necesitamos la clase Response para crear la respuesta especial con la cabecera de localización en el método Store()
use Response;
use DateTime;

class VotacioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json(['status'=>'ok','data'=>Votacio::all()], 200);
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
    public function store(Request $request)
    {
        // Primero comprobaremos si estamos recibiendo todos los campos.
        if (!$request->input('titol') || !$request->input('dataHoraIni') || !$request->input('dataHoraFin'))
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
        }
 
        // Insertamos una fila en Fabricante con create pasándole todos los datos recibidos.
        // En $request->all() tendremos todos los campos del formulario recibidos.

        //damos formato dateTime
        $formato = 'Y-m-d H:i:s';
        $fechaIni = DateTime::createFromFormat($formato, $request->input('dataHoraIni'));
        $fechaFin = DateTime::createFromFormat($formato, $request->input('dataHoraFin'));
        $request->merge(array('dataHoraIni' => $fechaIni));
        $request->merge(array('dataHoraFin' => $fechaFin));
        $nouVotacio="";
        //Buscamos el esdeveniment
        if ($request->input('idEsdeveniment')) {
            $esdeveniment= Esdeveniment::find($request->input('idEsdeveniment'));
            // Si no existe el esdeveniment que le hemos pasado mostramos otro código de error de no encontrado.
            if (!$esdeveniment)
            {
                // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
                // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
                return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un esdeveniment con ese código.'])],404);
            }
            // Guardamos el esdeveniment con la foreign key correspondiente.
            $nouVotacio=$esdeveniment->votacions()->create($request->all());
        }
        else $nouVotacio=Votacio::create($request->all());
           
        // Más información sobre respuestas en http://jsonapi.org/format/
        // Devolvemos el código HTTP 201 Created – [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
        $response = Response::make(json_encode(['data'=>$nouVotacio]), 201)->header('Location', 'http://www.dominio.local/votacions/'.$nouVotacio->id)->header('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
        // return "Se muestra Votacio con id: $id";
        // Buscamos una votacio por el id.
        $votacio=Votacio::find($id);
 
        // Si no existe esa votacio devolvemos un error.
        if (!$votacio)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una votacio con ese código.'])],404);
        }
 
        return response()->json(['status'=>'ok','data'=>$votacio],200);
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
        // Comprobamos si la Votacio que nos están pasando existe o no.
        $votacio=Votacio::find($id);
 
        // Si no existe esa votacio devolvemos un error.
        if (!$votacio)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una votacio con ese código.'])],404);
        }       
 
        // Listado de campos recibidos teóricamente.
        $titol=$request->input('titol');
        $formato = 'Y-m-d H:i:s';
        $fecha = DateTime::createFromFormat($formato, $request->input('dataHoraIni'));
        $dataHoraIni=$fecha;
        $fecha = DateTime::createFromFormat($formato, $request->input('dataHoraFin'));
        $dataHoraFin=$fecha;
 
        // Necesitamos detectar si estamos recibiendo una petición PUT o PATCH.
        // El método de la petición se sabe a través de $request->method();
        if ($request->method() === 'PATCH')
        {
            // Creamos una bandera para controlar si se ha modificado algún dato en el método PATCH.
            $bandera = false;
 
            // Actualización parcial de campos.
            if ($titol)
            {
                $votacio->titol = $titol;
                $bandera=true;
            }
 
            if ($dataHoraIni)
            {
                $votacio->dataHoraIni = $dataHoraIni;
                $bandera=true;
            }
 
 
            if ($dataHoraFin)
            {
                $votacio->dataHoraFin = $dataHoraFin;
                $bandera=true;
            }
 
            if ($bandera)
            {
                // Almacenamos en la base de datos el registro.
                $votacio->save();
                return response()->json(['status'=>'ok','data'=>$votacio], 200);
            }
            else
            {
                // Se devuelve un array errors con los errores encontrados y cabecera HTTP 304 Not Modified – [No Modificada] Usado cuando el cacheo de encabezados HTTP está activo
                // Este código 304 no devuelve ningún body, así que si quisiéramos que se mostrara el mensaje usaríamos un código 200 en su lugar.
                return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato de votacio.'])],304);
            }
        }
 
 
        // Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
        if (!$titol || !$dataHoraIni || !$dataHoraFin)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])],422);
        }
 
        $votacio->titol = $titol;
        $votacio->dataHoraIni = $dataHoraIni;
        $votacio->dataHoraFin = $dataHoraFin;
 
        // Almacenamos en la base de datos el registro.
        $votacio->save();
        return response()->json(['status'=>'ok','data'=>$votacio], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        // Primero eliminaremos todos las preguntes de una votació y luego la votacio en si mismo.
        // Comprobamos si el votacio que nos están pasando existe o no.
        $votacio=Votacio::find($id);
 
        // Si no existe ese esdeveniment devolvemos un error.
        if (!$votacio)
        {
            return "hola";
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una votacio con ese código.'])],404);
        }       
 
        // La votacio existe entonces buscamos todos las preguntas asociados a esa votacio.
        $preguntes = $votacio->preguntes; // Sin paréntesis obtenemos el array de todos las preguntes.
 
        // Comprobamos si te preguntes esa votacio.
        if (sizeof($preguntes) > 0)
        {
            // Devolveremos un código 409 Conflict - [Conflicto] Cuando hay algún conflicto al procesar una petición, por ejemplo en PATCH, POST o DELETE.
            return response()->json(['code'=>409,'message'=>'Este votacio posee preguntes y no puede ser eliminado.'],409);
        }
 
        // Procedemos por lo tanto a eliminar el fabricante.
        $votacio->delete();
 
        // Se usa el código 204 No Content – [Sin Contenido] Respuesta a una petición exitosa que no devuelve un body (como una petición DELETE)
        // Este código 204 no devuelve body así que si queremos que se vea el mensaje tendríamos que usar un código de respuesta HTTP 200.
        return response()->json(['code'=>204,'message'=>'Se ha eliminado el esdeveniment correctamente.'],204);
    }
}
