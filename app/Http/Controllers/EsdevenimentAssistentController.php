<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Necesitaremos el modelo Fabricante para ciertas tareas.
use App\Esdeveniment;
use App\Assistent;
use App\Votacio;

// Necesitamos la clase Response para crear la respuesta especial con la cabecera de localización en el método Store()
use Response;
use DateTime;
use Auth;
use Redirect;

class EsdevenimentAssistentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($idEsdeveniment)
    {
        // Devolverá todos los assistents.
        //return "Mostrando los aviones del fabricante con Id $idFabricante";
        $esdeveniment=Esdeveniment::find($idEsdeveniment);
        
        if ($this->getRouter()->getCurrentRoute()->getPrefix() == '/api') {
            if (! $esdeveniment)
            {
                // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
                // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
                return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un esdeveniment con ese código.'])],404);
            }
     
            return response()->json(['status'=>'ok','data'=>$esdeveniment->assistents()->get()],200);
            //return response()->json(['status'=>'ok','data'=>$fabricante->aviones],200);
        }
        else {
            if (!Auth::check()) return Redirect::to('login');
            $assistents = $esdeveniment->assistents()->paginate(5);
            $assistents->id =$idEsdeveniment;
            return view('assistentLayouts.index')->with("assistents",$assistents);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($idEsdeveniment)
    {
        if (!Auth::check()) return Redirect::to('login');
        $vota = Esdeveniment::find($idEsdeveniment)->first()->votacions;
        return view('assistentLayouts.create')->with("id", $idEsdeveniment)->with("vota", $vota)->with("count", $vota->count());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $idEsdeveniment)
    {
        // Primero comprobaremos si estamos recibiendo todos los campos.
        if ( !$request->input('usuari') || !$request->input('assistit') || !$request->input('dataHora') || !$request->input('delegat') )
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
        }
 
        // Buscamos el Esdeveniment.
        $esdeveniment= Esdeveniment::find($idEsdeveniment);
 
        // Si no existe el esdeveniment que le hemos pasado mostramos otro código de error de no encontrado.
        if (!$esdeveniment)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un esdeveniment con ese código.'])],404);
        }
 

        //damos formato dateTime
        $formato = 'Y-m-d H:i:s';
        $fecha = DateTime::createFromFormat($formato, $request->input('dataHora'));
        $request->merge(array('dataHora' => $fecha));


        //control de los booleanos (v1, en la v2 ira fuera)
        if ($request->input('assistit') == "true") $request->merge(array('assistit' => true));
        else $request->merge(array('assistit' => false));
        if ($request->input('delegat') == "true") $request->merge(array('delegat' => true));
        else $request->merge(array('delegat' => false));

        // Si el esdeveniment existe entonces lo almacenamos.
        // Insertamos una fila en Assistents con create pasándole todos los datos recibidos.
        $nouAssistent=$esdeveniment->assistents()->create($request->all());
 
        // Más información sobre respuestas en http://jsonapi.org/format/
        // Devolvemos el código HTTP 201 Created – [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
        $response = Response::make(json_encode(['data'=>$nouAssistent]), 201)->header('Location', 'http://www.dominio.local/assistents/'.$nouAssistent->id)->header('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($idEsdeveniment, $idAssistent)
    {
        // Devolverá todos los assistents.
        //return "Mostrando los aviones del fabricante con Id $idFabricante";
        $esdeveniment=Esdeveniment::find($idEsdeveniment);
 
        if (! $esdeveniment)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un esdeveniment con ese código.'])],404);
        }
        $assistent = $esdeveniment->assistents()->find($idAssistent);
        if (! $assistent){
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un assistent con ese código.'])],404);
        }
        return response()->json(['status'=>'ok','data'=>$assistent],200);
        //return response()->json(['status'=>'ok','data'=>$fabricante->aviones],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($idEsdeveniment,$idAssistent)
    {
        $assistent=Assistent::find($idAssistent);
        $votaAss =  $assistent->votacions()->select('votacio_id')->get();
        $a = collect([]);
        $b = collect([]);
        foreach ($votaAss as $v) $a->push($v->votacio_id);
        $votacions = Esdeveniment::find($assistent->esdeveniment_id)->votacions()->get();
        foreach ($votacions as $v) $b->push($v->id);
        $diff = $b->diff($a);
        $arrayVota = [];
        $i = 1;
        foreach ($diff as $vota) {
            $votac = Votacio::find($vota);
            $arrayVota = array_add($arrayVota,$i,$votac->titol);
            ++$i;
        }
        return view('assistentLayouts.edit')->with("ass",$assistent)->with("vota",$arrayVota);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $idEsdeveniment, $idAssistent)
    {
        // Comprobamos si el esdeveniment que nos están pasando existe o no.
        $esdeveniment=Esdeveniment::find($idEsdeveniment);
 
        // Si no existe ese esdeveniment devolvemos un error.
        if (!$esdeveniment)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un esdeveniment con ese código.'])],404);
        }       
 
        // El esdeveniment existe entonces buscamos el assistent que queremos editar asociado a ese fabricante.
        $assistent = $esdeveniment->assistents()->find($idAssistent);
 
        // Si no existe ese assistent devolvemos un error.
        if (!$assistent)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un assistent con ese código asociado al esdeveniment.'])],404);
        }   
 
 
        // Listado de campos recibidos teóricamente.
        $usuari=$request->input('usuari');
        if ($request->input('assistit') == "true" || $request->input('assistit') == "on") $assistit=true;
        else $assistit = false;
        $formato = 'Y-m-d H:i:s';
        $fecha = DateTime::createFromFormat($formato, $request->input('dataHora'));
        $dataHora=$fecha;
        if ($request->input('delegat') == "true" || $request->input('delegat') == "on") $delegat=true;
        else $delegat = false;
 
        // Necesitamos detectar si estamos recibiendo una petición PUT o PATCH.
        // El método de la petición se sabe a través de $request->method();
        if ($request->method() === 'PATCH')
        {
            // Creamos una bandera para controlar si se ha modificado algún dato en el método PATCH.
            $bandera = false;
 
            // Actualización parcial de campos.
            if ($usuari)
            {
                $assistent->usuari = $usuari;
                $bandera=true;
            }
 
            if ($assistit)
            {
                $assistent->assistit = $assistit;
                $bandera=true;
            }
 
            if ($dataHora)
            {
                $assistent->dataHora = $dataHora;
                $bandera=true;
            }
 
            if ($delegat)
            {
                $assistent->delegat = $delegat;
                $bandera=true;
            }
 
            if ($bandera)
            {
                // Almacenamos en la base de datos el registro.
                $assistent->save();
                return response()->json(['status'=>'ok','data'=>$assistent], 200);
            }
            else
            {
                // Se devuelve un array errors con los errores encontrados y cabecera HTTP 304 Not Modified – [No Modificada] Usado cuando el cacheo de encabezados HTTP está activo
                // Este código 304 no devuelve ningún body, así que si quisiéramos que se mostrara el mensaje usaríamos un código 200 en su lugar.
                return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del assistent.'])],304);
            }
 
        }
 
        // Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
        if (!$usuari || !$dataHora)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])],422);
        }
 
        $assistent->usuari = $usuari;
        $assistent->assistit = $assistit;
        $assistent->dataHora = $dataHora;
        $assistent->delegat = $delegat;
 
        // Almacenamos en la base de datos el registro.
        $assistent->save();
        if ($this->getRouter()->getCurrentRoute()->getPrefix() == '/api')
        return response()->json(['status'=>'ok','data'=>$assistent], 200);
        else return Redirect::to('/assistents/'.$idAssistent);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($idEsdeveniment, $idAssistent)
    {
        // Comprobamos si el esdeveniment que nos están pasando existe o no.
        $esdeveniment=Esdeveniment::find($idEsdeveniment);
 
        // Si no existe ese esdevenimentd evolvemos un error.
        if (!$esdeveniment)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un fabricante con ese código.'])],404);
        }       
 
        // El esdeveniment existe entonces buscamos el assistent que queremos borrar asociado a ese esdeveniment.
        $assistent = $esdeveniment->assistents()->find($idAssistent);
 
        // Si no existe ese assistent devolvemos un error.
        if (!$assistent)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un assistent con ese código asociado a ese esdeveniment.'])],404);
        }
 
        // Procedemos por lo tanto a eliminar el assistent.
        $assistent->delete();
 
        // Se usa el código 204 No Content – [Sin Contenido] Respuesta a una petición exitosa que no devuelve un body (como una petición DELETE)
        // Este código 204 no devuelve body así que si queremos que se vea el mensaje tendríamos que usar un código de respuesta HTTP 200.
        return response()->json(['code'=>204,'message'=>'Se ha eliminado el assistent correctamente.'],204);
    }
}
