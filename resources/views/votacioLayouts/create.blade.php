@extends('layouts.masterCOFB')

@section('titulo') Crear votació @stop

@section('menu')
<h1>Esdeveniments</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li class="selected"><a href="#">Llistat d'esdeveniments</a></li>
    <li><a href="#">Crear nou esdeveniment</a></li>
</ul>
@stop



@section('contenido')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
	var hola = ["hola","uno","dos","tres"];
	var esd = 1;
	var i = 1;
	var arr = {};
	function votacions(){
		if($('input[id=aviso]')[0].checked) $(location).attr('href', '/votacions/create');
		else $(location).attr('href', '/esdeveniments/'+esd);
	};

	function assistents(){
		for(var j = 1; j <= i; j++) {
			arr[j] = $('input[id=ass-'+j+']').val();
	      };
	    send = {'id' : 1};
	    send['arr']= arr;
		$.ajax({
	      url: '/assistents/ajax',
	      type: "post",
	      //var arr = new Array();
	      data: send,
	      success: function(data){
	      	$('.borde-azul').css("display","none");
	      	$('.borde-naranja').css("display","inherit");
	      	$('#tab2').removeClass('current active'); 
	        $('#tab3').addClass('current active');
	        $('.warning').css("display","inherit");
	        $('#warning').html('Es pot afegir una votació nova en qualsevol moment més endavant.');
	        $('#pas').html('Pas 3 de 3');
	        $('#next').attr('value',"Continuar | Sortir");
	        $('#next').attr('onclick',"votacions()");
      	  }
        });
	}

	function novaPregunta(elem){
		$(elem).parent().css("display","none");
		++i;
		$("#preguntes").prepend("<div class='row'><div class='column-form large-2 margin-t-s' style='width:100%''><label for='data'>Pregunta</label><input id='preg-" + i +"' type='text'></div><div style='float: right; margin-top: -82px; margin-right: 7px;'><a href='#' class='ver-mas-enlace' onClick='novaPregunta(this)'>Afegir més</a></div></div><div class='row'><div class='column-form large-2 margin-t-s'><label for='data'>Resposta tancada</label><input id='resposta-" + i +"' type='text' placeholder='Resposta A, Resposta B, Resposta C'></div><div class='column-form med-2 margin-t-n' style= 'margin-top: 31px; padding-left: 25px;'><input type='checkbox' id='obligatoria-" + i + "'><label for='aviso' class='aviso'>Resposta obligatòria</label></div>");
	};
	function esdeveniment(){
	  	$('input[id=name]').removeClass('error');
	  	$('input[id=data]').removeClass('error'); 
	  	$("#nameError").css("display","none");
	  	$("#dataError").css("display","none");             
	    $.ajax({
	      url: '/esdeveniments/ajax',
	      type: "post",
	      data: {'name':$('input[id=name]').val(),'data':$('input[id=data]').val(),'lloc':$('input[id=lloc]').val(),'oberta':$('input[id=oberta]')[0].checked},
	      success: function(data){
	        if(data=="falta name") {$('input[id=name]').addClass('error');$("#nameError").css("display","inherit");}
	        else if(data=="falta data") {$('input[id=data]').addClass('error');$("#dataError").css("display","none");}
	        else {
	        	$('.borde-verde').css("display","none");
	        	$('.borde-azul').css("display","inherit");
	        	$('#tab1').removeClass('current active'); 
	        	$('#tab2').addClass('current active');
	        	$('.warning').css("display","none");
	        	$esd=data;
	        	$('#pas').html('Pas 2 de 3');
	        	$('#next').attr('onclick',"assistents()");
	        }
      	  }
        });
	};

	function assistents2(){
		for (item = 0; item < hola.length; item++) { 
    		$("#list").innerHTML+="holaaaa";
    		//"<input type='checkbox' id='ass-" + item +"'><label for='ass-" + item +"' class='aviso' style='width:32%;'> holaaaa</label>";
		}
	};
	$( document ).ready(function() {
    	assistents2();
	});

</script>
<form action="" id="form-activ-collegial">
	<ul id="section-tabs">
	<li class="current active arrowright" id="tab1">
		<div class="content-datos">
			<div class="tab-personales">Dades votació</div>
			<div class="datos-numero">1
		</div>	
	</div></li>
	<li class=" arrowright" id="tab2">
		<div class="content-datos">
			<div class="tab-publiques">Dades preguntes</div>
			<div class="datos-numero">2</div>
		</div>	
	</li>
		<li class="arrowright" id="tab3">
			<div class="content-datos">
				<div class="tab-altres-dades">Dades assistents</div>
				<div class="datos-numero">3</div>
			</div>	
		</li>
</ul>
<div id="fieldsets">
	<!--Actual-->
	<div class="actual" style="min-height: 311px;">
			<fieldset class="borde-verde" style="display:none;">
				<h3>DADES VOTACIÓ</h3>
				<div class="row">
					<div class="column-form large-2">
						<label for="name">Nom votació</label>
						<input type="text" id="name" required="">
						<div id="nameError"class="errores" style="display:none">El nom de la votació no es valida</div>
					</div>
					<div class="column-form med-2 margin-t-n">
						<label for="data">Data hora inici</label>
						<input id="dataIni" type="text" placeholder="AAAA-MM-DD HH:MM:SS">
						<div id="dataError" class="errores" style="display:none">La data no es valida</div>
					</div>
				</div>
				<div class="row">		
					<div class="column-form large-2 margin-t-s">	
						<label for="lloc">Nom del esdeveniment</label>
						<dl class="dropdown" id="tipo-via">
						    <dt><a href="#"><span>Selecciona</span></a></dt>
						    <dd>
						        <ul style="display: none; overflow: auto; height:110px;">
						            @foreach($ini as $esd)
						            <li><a href="#">{{$esd->titol}}</a></li>
						            @endforeach
						        </ul>
						    </dd>
						</dl>
					</div>
					<div class="column-form med-2 margin-t-n">
						<label for="data">Data hora fin</label>
						<input id="dataFin" type="text" placeholder="AAAA-MM-DD HH:MM:SS">
						<div id="dataError" class="errores" style="display:none">La data no es valida</div>
					</div>
				</div>
			</fieldset>
			<fieldset class="borde-azul" style="display:none;">
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
			<fieldset class="borde-naranja">
				<h3>DADES ASSISTENTS</h3>
				<div id="list"></div>
				
			</fieldset>
			
			<div class="warning">
				<h4>important !</h4>
				<p id="warning">Les diferents respostes tancades s'han de separar entre elles per una coma i un espai</p>
				<p id="warning">Si no s'indica una resposta tancada, s'establirà què la resposta és oberta.</p>
			</div>
			<div class="relative">
				<div class="left">
					<input class="btn btn-naranja" type="button" value="Guardar | Continuar" id="next" onClick="esdeveniment()">
				</div>
				<div class="right">
					<a href="#" class="btn-steps right" id="pas">Pas 1 de 3</a>
				</div>
			</div>
		</div>
	</div>			
</form>
@stop