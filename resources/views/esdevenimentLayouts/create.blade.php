@extends('layouts.masterCOFB')

@section('titulo') Crear esdeveniment @stop

@section('menu')
<h1>Esdeveniments</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li><a href="/esdeveniments">Llistat d'esdeveniments</a></li>
    <li class="selected"><a href="/esdeveniments/create">Crear nou esdeveniment</a></li>
</ul>
@stop



@section('contenido')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
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
	    send = {'id' : esd};
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

	function nouAssistent(elem){
		$(elem).parent().css("display","none");
		++i;
	  	$("#assistents").prepend("<div class='row'><div class='column-form large-2 margin-t-s'><input type='text' id='ass-"+ i +"' style='margin-left: 55px;'></div><div style='float: right; margin-top: 6px; margin-right: 57px;'><a href='#' class='ver-mas-enlace' onClick='nouAssistent(this)'>Afegir més</a></div></div>");
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
	        else if(data=="falta data") {$('input[id=data]').addClass('error');$("#dataError").css("display","inherit");}
	        else {
	        	$('.borde-verde').css("display","none");
	        	$('.borde-azul').css("display","inherit");
	        	$('#tab1').removeClass('current active'); 
	        	$('#tab2').addClass('current active');
	        	$('.warning').css("display","none");
	        	esd=data;
	        	$('#pas').html('Pas 2 de 3');
	        	$('#next').attr('onclick',"assistents()");
	        }
      	  }
        });
	};
</script>
<form action="" id="form-activ-collegial">
	<ul id="section-tabs">
	<li class="current active arrowright" id="tab1">
		<div class="content-datos">
			<div class="tab-personales">Dades esdeveniment</div>
			<div class="datos-numero">1
		</div>	
	</div></li>
	<li class=" arrowright" id="tab2">
		<div class="content-datos">
			<div class="tab-publiques">Dades assistents</div>
			<div class="datos-numero">2</div>
		</div>	
	</li>
		<li class="arrowright" id="tab3">
			<div class="content-datos">
				<div class="tab-altres-dades">Dades votacions</div>
				<div class="datos-numero">3</div>
			</div>	
		</li>
</ul>
<div id="fieldsets">
	<!--Actual-->
	<div class="actual">
			<fieldset class="borde-verde">
				<h3>DADES ESDEVENIMENT</h3>
				<div class="row">
					<div class="column-form large-2">
						<label for="name">Nom esdeveniment</label>
						<input type="text" id="name" required="">
						<div id="nameError"class="errores" style="display:none">El nom del esdeveniment no es valid</div>
					</div>
					<div class="column-form med-2 margin-t-n">
						<label for="data">Data i hora</label>
						<input id="data" type="text" placeholder="AAAA-MM-DD HH:MM:SS">
						<div id="dataError" class="errores" style="display:none">La data no es valida</div>
					</div>
				</div>
				<div class="row">		
					<div class="column-form large-2 margin-t-s">	
						<label for="lloc">Lloc esdeveniment</label>
						<input type="text" id="lloc" required="">
					</div>
					<div class="column-form med-2 margin-t-n" style="padding-top: 30px;">	
						<input type="checkbox" id="oberta">
						<label for="oberta" class="aviso">Inscripció oberta</label>
					</div>
				</div>
			</fieldset>
			<fieldset class="borde-azul" style="display:none;">
				<h3>ASSISTENTS AL ESDEVENIMENT</h3>
				<div id="assistents">
					<div class="row">
						<div class="column-form large-2 margin-t-s">	
							<input id="ass-1" type="text" style="margin-left: 55px;">
						</div>
						<div style="float: right; margin-top: 6px; margin-right: 57px;">
							<a href="#" class="ver-mas-enlace" onClick="nouAssistent(this)">Afegir més</a>
						</div>
					</div>	
				</div>	
			</fieldset>
			<fieldset class="borde-naranja" style="display:none;">
				<h3>VOTACIONS DEL ESDEVENIMENT</h3>
				<input type="checkbox" id="aviso"><label for="aviso" class="aviso">Desitjo afegir un nova votació a l'esdeveniment creat.</label>
			</fieldset>
			
			<div class="warning">
				<h4>important !</h4>
				<p id="warning">Si no s'indica el lloc de l'esdeveniment, s'establirà que l'esdeveniment no és presencial.</p>
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