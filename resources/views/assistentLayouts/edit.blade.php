@extends('layouts.masterCOFB')

@section('titulo') Editar assistent @stop

@section('menu')
<h1>Assistents</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li><a href="/assistents">Llistat d'assistents</a></li>
    <li><a href="/esdeveniments/{{$ass->esdeveniment_id}}/assistents/create">Crear nou assistent</a></li>
    <li class="selected"><a href="/esdeveniments/{{$ass->esdeveniment_id}}/assistents/{{$ass->id}}">Editar assistent</a></li>
</ul>
@stop


@section('contenido')
<form method="POST" action="/esdeveniments/{{$ass->esdeveniment_id}}/assistents/{{$ass->id}}" id="form-activ-collegial">
	<div id="fieldsets">
		<!--Actual-->
		<div class="actual">
			<fieldset class="borde-verde">
				<h3>DADES ESDEVENIMENT</h3>
				<div class="row">
					<div class="column-form large-2">
						<label for="name">Nom del assistent </label>
						<input type="text" id="usuari" name="usuari" value='{{$ass->usuari}}' readonly>
					</div>
					<div class="column-form med-2 margin-t-n" style="padding-top: 30px;">
						<input type="checkbox" name="delegat" id="delegat" @if($ass->delegat)checked @endif >
						<label for="delegat" class="aviso">Delegat</label>
					</div>
				</div>
				<div class="row">
					<div class="column-form large-2">
						<label for="data">Data i hora</label>
						<input id="data" name="dataHora" type="text" placeholder="AAAA-MM-DD HH:MM:SS" value='{{$ass->dataHora}}'>
						<div id="dataError" class="errores" style="display:none">La data no es valida</div>
					</div>
					<div class="column-form med-2 margin-t-n" style="padding-top: 30px;">
						<input type="checkbox" name="assistit" id="assistit" @if($ass->assistit)checked @endif >
						<label for="assistit" class="aviso">Assistit</label>
					</div>		
					<div style="display:none">
					<input type="text" id="id_esdeveniment" name="id_esdeveniment" value='{{$ass->esdeveniment_id}}' readonly>
					<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
					<input type="hidden" name="_method" value="put" /></div>
				</div>
			</fieldset>
			<?php $numVota = 0 ?>
			@if(sizeof($vota)!=0)
			<fieldset class="borde-azul">
				<h3>VOTACIONS DISPONIBLES</h3>
				<div class="row">
				<?php $numVota = 1 ?>
				@foreach($vota as $v)
					<input type='checkbox' id='vota-{{$numVota}}'>
					<label for='vota-{{$numVota}}' class='aviso' style='width:32%;'>{{$v}}</label>
					<?php ++$numVota ?>
				@endforeach		
				</div>
			</fieldset>
			@endif
		</div>
	</div>
	<div class="relative">
		<div class="left">
			<button class="btn btn-naranja" onClick="votacioAssistent()">Editar | Guardar</button>
		</div>
	</div>
</form>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
	function votacioAssistent(){
		var vota = {}
		var aux = 0;
		for (var j = 1; j < {{$numVota}}; ++j) {
			if($('input[id=vota-'+j+']')[0].checked) {
				vota[aux] = $('label[for=vota-'+j+']').text();
				++aux;
			}
		};
		send = {'id' : {{$ass->id}}};
	    send['vota']= vota;
	    $.ajax({
	      url: '/votacions/assistent/ajax',
	      type: "post",
	      //var arr = new Array();
	      data: send,
	      success: function(data){}
        });
	};
</script>
@stop