@extends('layouts.masterCOFB')

@section('titulo') Editar esdeveniment @stop

@section('menu')
<h1>Esdeveniments</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li><a href="/esdeveniments">Llistat d'esdeveniments</a></li>
    <li><a href="/esdeveniments/create">Crear nou esdeveniment</a></li>
    <li class="selected"><a href="/esdeveniments/{{$esd->id}}/edit">Modificar esdeveniment</a></li>
    <li><a href="/esdeveniments/{{$esd->id}}">Veure esdeveniment</a></li>
</ul>
@stop


@section('contenido')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
function validar() {
	if($('input[id=lloc]').val()=="") $('input[id=presencial]')[0].checked = false;
	else $('input[id=presencial]')[0].checked = true;
};
</script>
<form method="POST" action="/esdeveniments/{{$esd->id}}" id="form-activ-collegial">
	<div id="fieldsets">
		<!--Actual-->
		<div class="actual">
			<fieldset class="borde-verde">
				<h3>DADES ESDEVENIMENT</h3>
				<div class="row">
					<div class="column-form large-2">
						<label for="name">Nom esdeveniment </label>
						<input type="text" id="name" name="titol" value='{{$esd->titol}}' readonly>
					</div>
					<div class="column-form med-2 margin-t-n">
						<label for="data">Data i hora</label>
						<input id="data" name="dataHora" type="text" placeholder="AAAA-MM-DD HH:MM:SS" value='{{$esd->dataHora}}'>
						<div id="dataError" class="errores" style="display:none">La data no es valida</div>
					</div>
				</div>
				<div class="row">		
					<div class="column-form large-2 margin-t-s">	
						<label for="lloc">Lloc esdeveniment</label>
						<input type="text" name ="lloc" id="lloc" value='{{$esd->lloc}}'>
					</div>
					<div class="column-form med-2 margin-t-n" style="padding-top: 30px;">
						<input type="checkbox" name="inscripcioOberta" id="inscripcioOberta" @if($esd->inscripcioOberta)checked @endif >
						<label for="inscripcioOberta" class="aviso">Inscripció oberta</label>
					</div>
					<div style="display:none">
					<input type="checkbox" name="presencial" id="presencial" @if($esd->presencial)checked @endif >
					<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
					<input type="hidden" name="_method" value="put" /></div>
				</div>
			</fieldset>
		</div>
	</div>
	<div class="warning">
				<h4>important !</h4>
				<p id="warning">Si no s'indica el lloc de l'esdeveniment, s'establirà que l'esdeveniment no és presencial.</p>
			</div>
	<div class="relative">
		<div class="left">
			<button class="btn btn-naranja" onClick="validar()">Editar | Guardar</button>
		</div>
	</div>
</form>

@stop