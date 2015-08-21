@extends('layouts.masterCOFB')

@section('titulo') Editar esdeveniment @stop

@section('menu')
<h1>Votacions</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li><a href="/votacions">Llistat de votacions</a></li>
    <li><a href="/votacions/create">Crear nova votació</a></li>
    <li><a href="/votacions/{{$vota->id}}">Veure votació</a></li>
    <li class="selected"><a href="/votacions/{{$vota->id}}/edit">Editar votació</a></li>
</ul>
@stop


@section('contenido')
<form method="POST" action="/votacions/{{$vota->id}}" id="form-activ-collegial">
	<div id="fieldsets">
		<!--Actual-->
		<div class="actual">
			<fieldset class="borde-verde">
				<h3>DADES VOTACIÓ</h3>
				<div class="row">
					<div class="column-form large-2">
						<label for="name">Nom votació</label>
						<input type="text" id="name" name="titol" value="{{$vota->titol}}" required>
						<div id="nameError"class="errores" style="display:none">El nom de la votació no es valida</div>
					</div>
					<div class="column-form med-2 margin-t-n">
						<label for="data">Data hora inici</label>
						<input id="dataIni" type="text" name="dataHoraIni" value="{{$vota->dataHoraIni}}" placeholder="AAAA-MM-DD HH:MM:SS">
						<div id="dataIniError" class="errores" style="display:none">La data no es valida</div>
					</div>
				</div>
				<div class="row">		
					<div class="column-form large-2 margin-t-s">	
						<label for="esd">Nom del esdeveniment</label>
						<input id="esd" type="text" name="esdeveniment_id" value="{{$esd->titol}}" readonly>
					</div>
					<div class="column-form med-2 margin-t-n">
						<label for="data">Data hora fin</label>
						<input id="dataFin" type="text" name="dataHoraFin" value="{{$vota->dataHoraFin}}"placeholder="AAAA-MM-DD HH:MM:SS">
						<div id="dataFinError" class="errores" style="display:none">La data no es valida</div>
					</div>
				</div>
				<div style="display:none">
					<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
					<input type="hidden" name="_method" value="put" /></div>
			</fieldset>
			<div class="relative">
		<div class="left">
			<button class="btn btn-naranja">Editar | Guardar</button>
		</div>
	</div>
		</div>
	</div>
</form>
@stop