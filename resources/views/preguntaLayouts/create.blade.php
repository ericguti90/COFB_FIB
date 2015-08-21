@extends('layouts.masterCOFB')

@section('titulo') Nova pregunta @stop

@section('menu')
<h1>Preguntes</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li><a href="/votacions/{{$id}}">Veure votació</a></li>
    <li class="selected"><a href="/votacions/{{$id}}/preguntes/create">Crear nova pregunta</a></li>
</ul>
@stop

@section('contenido')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
	var i = 1;
	var arr = {};
	function preguntes(id){
		for(var j = 1; j <= i; j++) {
			arr[j] = [$('input[id=preg-'+j+']').val(),$('input[id=resposta-'+j+']').val(),$('input[id=obligatoria-'+j+']')[0].checked];
	      };
	    send = {'id' : id};
	    send['arr']= arr;
		$.ajax({
	      url: '/preguntes/ajax',
	      type: "post",
	      data: send,
	      success: function(data){
	      	window.location.replace("/votacions/"+id);
      	  }
        });
	}

	function novaPregunta(elem){
		$(elem).parent().css("display","none");
		++i;
		$("#preguntes").prepend("<div class='row'><div class='column-form large-2 margin-t-s' style='width:100%''><label for='data'>Pregunta</label><input id='preg-" + i +"' type='text'></div><div style='float: right; margin-top: -82px; margin-right: 7px;'><a href='#' class='ver-mas-enlace' onClick='novaPregunta(this)'>Afegir més</a></div></div><div class='row'><div class='column-form large-2 margin-t-s'><label for='data'>Resposta tancada</label><input id='resposta-" + i +"' type='text' placeholder='Resposta A, Resposta B, Resposta C'></div><div class='column-form med-2 margin-t-n' style= 'margin-top: 31px; padding-left: 25px;'><input type='checkbox' id='obligatoria-" + i + "'><label for='aviso' class='aviso'>Resposta obligatòria</label></div>");
	};
</script>

<form action="" id="form-activ-collegial">
	<fieldset class="borde-azul">
		<h3>DADES PREGUNTES</h3>
		<div id="preguntes">
			<div class="row">
				<div class="column-form large-2 margin-t-s" style="width:100%">	
					<label for="data">Pregunta</label>
					<input id="preg-1" type="text">
				</div>
				<div style="float: right; margin-top: -82px; margin-right: 7px;">
					<a href="#" class="ver-mas-enlace" onClick="novaPregunta(this)">Afegir més</a>
				</div>
			</div>	
			<div class="row">
				<div class="column-form large-2 margin-t-s">
					<label for="data">Resposta tancada</label>
					<input id="resposta-1" type="text" placeholder="Resposta A, Resposta B, Resposta C">
				</div>
				<div class="column-form med-2 margin-t-n" style= "margin-top: 31px; padding-left: 25px;">
					<input type="checkbox" id="obligatoria-1"><label for="obligatoria-1" class="aviso">Resposta obligatòria</label>
				</div>
			</div>
		</div>
	</fieldset>
	<div class="warning">
		<h4>important !</h4>
		<p id="warning">Les diferents respostes tancades s'han de separar entre elles per una coma i un espai</p>
		<p id="warning">Si no s'indica una resposta tancada, s'establirà què la resposta és oberta.</p>
	</div>
	<div class="relative">
		<div class="left">
			<input class="btn btn-naranja" type="button" value="Guardar | Continuar" id="next" onClick="preguntes({{$id}})">
		</div>
	</div>
</form>

@stop