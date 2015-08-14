@extends('layouts.masterCOFB')

@section('titulo') Crear esdeveniment @stop

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
	var esd;
	var i = 1;
	var arr = {};
	function assistents(){
		for(var j = 1; j <= i; j++) {
			arr[j] = $('input[id=ass-'+j+']').val();
	      };
		$.ajax({
	      url: '/assistents/ajax',
	      type: "post",
	      //var arr = new Array();
	      data: arr,
	      success: function(data){
	      	alert(data);
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
			<fieldset class="borde-azul">
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
			<!--<fieldset class="borde-amarillo">
				<h3>ADREÇA PERSONAL</h3>
				<div class="row">
					<div class="column-form med-2">
						<label for="tipo-via">Tipus de Vía</label>
							<dl class="dropdown" id="tipo-via">
							    <dt><a href="#"><span>Elige</span></a></dt>
							    <dd>
							        <ul>
							            <li><a href="#">Carrer</a></li>
							            <li><a href="#">Vía</a></li>
							            <li><a href="#">Avenida</a></li>
							        </ul>
							    </dd>
							</dl>
					</div>
					<div class="column-form large-2">
						<label for="adresa">Adresa</label>
						<input id="adresa" type="text">
					</div>
				</div>
				<div class="row">
					<div class="column-form med-2"> 
						<label for="num">Número</label>
						<input id="num" type="text">
					</div>
					<div class="column-form med-2">	
						<label for="pis">Pis</label>
						<input id="pis" type="text">
					</div>
					<div class="column-form med-2 margin-t-n">	
						<label for="portal">Porta</label>
						<input id="portal" type="text">
					</div>			
				</div>	
				<div class="row">
					<div class="column-form med-2 margin-t-s">	
						<label for="escala">Escala</label>
						<input id="escala" type="text">
					</div>
					<div class="column-form med-2 margin-t-n">		
						<label for="cp">CP</label>
						<input id="cp" type="text">
					</div>
					<div class="column-form med-2">	
						<label for="municipi">Municipi</label>
						<input id="municipi" type="text">
					</div>	
				</div>
				<div class="row">
					<div class="column-form med-2">		
						<label for="pob">Poblacó</label>
						<input id="pob" type="text">
					</div>	
					<div class="column-form med-2">								
						<label for="prov">Provincia</label>
						<input id="prov" type="text">
					</div>	
				</div>
			</fieldset>-->
			<!--<div class="warning">
					<h4>important !</h4>
					<p>Si alguna de les dades “no modificables” no és correcta, comuniqui-ho al Colžlegi per telèfon: <b>932440711</b> o per mail: <b>secretaria@cofb.net</b> i l’informarem del procediment a seguir per corregir-les.</p>
			</div>
			<p>En fer clic en “MODIFICAR LES DADES” acceptes haver llegit i estar d’acord amb la Política de Privacitat</p>-->
			<div class="warning">
				<h4>important !</h4>
				<p>Si no s'indica el lloc de l'esdeveniment, s'establirà que l'esdeveniment no és presencial.</p>
			</div>
			<div class="relative">
				<div class="left">
					<input class="btn btn-naranja" type="button" value="Guardar | Continuar" id="next" onClick="assistents()">
				</div>
				<div class="right">
					<a href="#" class="btn-steps right" id="pas">Pas 1 de 3</a>
				</div>
			</div>
		</div>
	</div>			
</form>

@stop