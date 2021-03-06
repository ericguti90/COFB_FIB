<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Necesitaremos el modelo Fabricante para ciertas tareas.
use App\Esdeveniment;

// Necesitamos la clase Response para crear la respuesta especial con la cabecera de localización en el método Store()
use Response;
use DateTime;
use Auth;
use Redirect;

class EsdevenimentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if ($this->getRouter()->getCurrentRoute()->getPrefix() == '/api') {
            return response()->json(['status'=>'ok','data'=>Esdeveniment::all()], 200);
        }
        else {
            if (!Auth::check()) return Redirect::to('login');
            $esd = Esdeveniment::orderBy('dataHora','desc')->paginate(5);
            foreach ($esd as $item) {
                $count = $item->assistents()->count();
                $item->num = $count;

            }
            return view('esdevenimentLayouts.index')->with("esd",$esd);
        }
    
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (!Auth::check()) return Redirect::to('login');
        return view('esdevenimentLayouts.create');
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
        if (!$request->input('titol') || !$request->input('dataHora') || !$request->input('lloc') || !$request->input('inscripcioOberta') || !$request->input('presencial') )
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
        }
 
        // Insertamos una fila en Fabricante con create pasándole todos los datos recibidos.
        // En $request->all() tendremos todos los campos del formulario recibidos.

        //damos formato dateTime
        $formato = 'Y-m-d H:i:s';
        $fecha = DateTime::createFromFormat($formato, $request->input('dataHora'));
        $request->merge(array('dataHora' => $fecha));

        //control de los booleanos (v1, en la v2 ira fuera)
        if ($request->input('inscripcioOberta') == "true") $request->merge(array('inscripcioOberta' => true));
        else $request->merge(array('inscripcioOberta' => false));
        if ($request->input('presencial') == "true") $request->merge(array('presencial' => true));
        else $request->merge(array('presencial' => false));

        $nouEsdeveniment=Esdeveniment::create($request->all());
        
        // Más información sobre respuestas en http://jsonapi.org/format/
        // Devolvemos el código HTTP 201 Created – [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
        $response = Response::make(json_encode(['data'=>$nouEsdeveniment]), 201)->header('Location', 'http://www.dominio.local/esdeveniments/'.$nouEsdeveniment->id)->header('Content-Type', 'application/json');
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
        // return "Se muestra el Esdeveniment con id: $id";
        // Buscamos un esdeveniment por el id.
        $esdeveniment=Esdeveniment::find($id);
 
        // Si no existe ese fabricante devolvemos un error.
        if ($this->getRouter()->getCurrentRoute()->getPrefix() == '/api') {
            if (!$esdeveniment)
            {
                // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
                // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
                return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un esdeveniment con ese código.'])],404);
            }
     
            return response()->json(['status'=>'ok','data'=>$esdeveniment],200);
        }
        else {
            if (!Auth::check()) return Redirect::to('login');
            $votacions = $esdeveniment->votacions()->select('id','titol','dataHoraIni','dataHoraFin')->get();
            $esdeveniment->votacions = $votacions;
            $num = $esdeveniment->assistents()->count();
            $esdeveniment->num = $num;
            return view('esdevenimentLayouts.show')->with("esd",$esdeveniment);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        if (!Auth::check()) return Redirect::to('login');
        $esdeveniment=Esdeveniment::find($id);
        return view ('esdevenimentLayouts.edit')->with("esd",$esdeveniment);
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
        // Comprobamos si el Esdeveniment que nos están pasando existe o no.
        $esdeveniment=Esdeveniment::find($id);
 
        // Si no existe ese esdeveniment devolvemos un error.
        if (!$esdeveniment)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un esdeveniment con ese código.'])],404);
        }       
 
        // Listado de campos recibidos teóricamente.
        $titol=$request->input('titol');
        $formato = 'Y-m-d H:i:s';
        $fecha = DateTime::createFromFormat($formato, $request->input('dataHora'));
        $dataHora=$fecha;
        $lloc=$request->input('lloc');
        if ($request->input('inscripcioOberta') == "true" || $request->input('inscripcioOberta') == "on") $inscripcioOberta=true;
        else $inscripcioOberta = false;
        if ($request->input('presencial') == "true" || $request->input('presencial') == "on") $presencial=true;
        else $presencial = false;

 
        // Necesitamos detectar si estamos recibiendo una petición PUT o PATCH.
        // El método de la petición se sabe a través de $request->method();
        if ($request->method() === 'PATCH')
        {
            // Creamos una bandera para controlar si se ha modificado algún dato en el método PATCH.
            $bandera = false;
 
            // Actualización parcial de campos.
            if ($titol)
            {
                $esdeveniment->titol = $titol;
                $bandera=true;
            }
 
            if ($dataHora)
            {
                $esdeveniment->dataHora = $dataHora;
                $bandera=true;
            }
 
 
            if ($lloc)
            {
                $esdeveniment->lloc = $lloc;
                $bandera=true;
            }

            if ($inscripcioOberta)
            {
                $esdeveniment->inscripcioOberta = $inscripcioOberta;
                $bandera=true;
            }

            if ($presencial)
            {
                $esdeveniment->presencial = $presencial;
                $bandera=true;
            }
 
            if ($bandera)
            {
                // Almacenamos en la base de datos el registro.
                $esdeveniment->save();
                return response()->json(['status'=>'ok','data'=>$esdeveniment], 200);
            }
            else
            {
                // Se devuelve un array errors con los errores encontrados y cabecera HTTP 304 Not Modified – [No Modificada] Usado cuando el cacheo de encabezados HTTP está activo
                // Este código 304 no devuelve ningún body, así que si quisiéramos que se mostrara el mensaje usaríamos un código 200 en su lugar.
                return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato de esdeveniment.'])],304);
            }
        }
 
 
        // Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
        if (!$titol )
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan titulo'])],422);
        }
        if (!$dataHora)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan dataHora'])],422);
        }
        $esdeveniment->titol = $titol;
        $esdeveniment->dataHora = $dataHora;
        $esdeveniment->lloc = $lloc;
        $esdeveniment->inscripcioOberta = $inscripcioOberta;
        $esdeveniment->presencial = $presencial;
 
        // Almacenamos en la base de datos el registro.
        $esdeveniment->save();
        if ($this->getRouter()->getCurrentRoute()->getPrefix() == '/api')
        return response()->json(['status'=>'ok','data'=>$esdeveniment], 200);
        else return Redirect::to('/esdeveniments/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        // Primero eliminaremos todos los assistents de un esdeveniment y luego el esdeveniment en si mismo.
        // Comprobamos si el esdeveniment que nos están pasando existe o no.
        $esdeveniment=Esdeveniment::find($id);
 
        // Si no existe ese esdeveniment devolvemos un error.
        if (!$esdeveniment)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un esdeveniment con ese código.'])],404);
        }       
 
        // El esdeveniment existe entonces buscamos todos los assistents asociados a ese esdeveniment.
        $assistents = $esdeveniment->assistents; // Sin paréntesis obtenemos el array de todos los assistents.
 
        // Comprobamos si tiene assitents ese esdeveniment.
        if (sizeof($assistents) > 0)
        {
            // Devolveremos un código 409 Conflict - [Conflicto] Cuando hay algún conflicto al procesar una petición, por ejemplo en PATCH, POST o DELETE.
            return response()->json(['code'=>409,'message'=>'Este esdeveniment posee assistents y no puede ser eliminado.'],409);
        }

        //comprobamos si tiene votacions ese esdeveniment.
        $votacions = $esdeveniment->votacions;
        if (sizeof($votacions) >0) {
            // Devolveremos un código 409 Conflict - [Conflicto] Cuando hay algún conflicto al procesar una petición, por ejemplo en PATCH, POST o DELETE.
            return response()->json(['code'=>409,'message'=>'Este esdeveniment posee votacions y no puede ser eliminado.'],409);
        }
 
        // Procedemos por lo tanto a eliminar el fabricante.
        $esdeveniment->delete();
 
        // Se usa el código 204 No Content – [Sin Contenido] Respuesta a una petición exitosa que no devuelve un body (como una petición DELETE)
        // Este código 204 no devuelve body así que si queremos que se vea el mensaje tendríamos que usar un código de respuesta HTTP 200.
        return response()->json(['code'=>204,'message'=>'Se ha eliminado el esdeveniment correctamente.'],204);
    }
}
