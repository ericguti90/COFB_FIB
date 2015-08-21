@extends('layouts.masterCOFB')

@section('titulo') Editar esdeveniment @stop

@section('menu')
<h1>Preguntes</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li><a href="/votacions/{{$preg->votacio_id}}">Veure votació</a></li>
    <li><a href="/votacions/{{$preg->votacio_id}}/preguntes/create">Crear nova pregunta</a></li>
    <li class="selected"><a href="/votacions/{{$preg->votacio_id}}/preguntes/{{$preg->id}}/edit">Editar pregunta</a></li>
    <li><a href="/votacions/{{$preg->votacio_id}}/preguntes/{{$preg->id}}/respostes">Veure respostes</a></li>
</ul>
@stop

@section('contenido')
<form method="POST" action="/votacions/{{$preg->votacio_id}}/preguntes/{{$preg->id}}" id="form-activ-collegial">
	<div id="fieldsets">
		<!--Actual-->
		<div class="actual">
			<fieldset class="borde-azul">
				<h3>DADES PREGUNTES</h3>
				<div id="preguntes">
					<div class="row">
						<div class="column-form large-2 margin-t-s" style="width:100%">	
							<label for="data">Pregunta</label>
							<input id="preg-1" type="text" name="titol" value='{{$preg->titol}}'>
						</div>
					</div>	
					<div class="row">
						<div class="column-form large-2 margin-t-s">
							<label for="data">Resposta tancada</label>
							<input id="resposta-1" type="text" name="opcions" placeholder="Resposta A, Resposta B, Resposta C" value='{{$preg->opcions}}'>
						</div>
						<div class="column-form med-2 margin-t-n" style= "margin-top: 31px; padding-left: 25px;">
							<input type="checkbox" name="obligatoria" id="obligatoria-1" @if($preg->obligatoria) checked @endif>
							<label for="obligatoria-1" class="aviso">Resposta obligatòria</label>
						</div>
					</div>
					<div style="display:none">
					<input id="vota-id" type="text" name="votacio_id" value='{{$preg->votacio_id}}'>
					<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
					<input type="hidden" name="_method" value="put" /></div>
				</div>	
			</fieldset>
			<div class="warning">
				<h4>important !</h4>
				<p id="warning">Les diferents respostes tancades s'han de separar entre elles per una coma i un espai</p>
				<p id="warning">Si no s'indica una resposta tancada, s'establirà què la resposta és oberta.</p>
			</div>
			<div class="relative">
		<div class="left">
			<button class="btn btn-naranja">Editar | Guardar</button>
		</div>
	</div>
		</div>
	</div>
</form>
@stop