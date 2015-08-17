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
	var esd = 0;
	var vota = 0;
	var i = 1;
	var arr = {};
	function assistents(){
		var ass = {}
		var aux = 0;
		for (var j = 1; j <= i; ++j) {
			if($('input[id=ass-'+j+']')[0].checked) {
				ass[aux] = $('label[for=ass-'+j+']').text();
				++aux;
			}
		};
		send = {'id' : vota};
	    send['ass']= ass;
	    $.ajax({
	      url: '/votacions/assistents/ajax',
	      type: "post",
	      //var arr = new Array();
	      data: send,
	      success: function(data){
	      	$(location).attr('href', '/votacions/'+vota);
      	  }
        });
	};

	function preguntes(){
		for(var j = 1; j <= i; j++) {
			arr[j] = [$('input[id=preg-'+j+']').val(),$('input[id=resposta-'+j+']').val(),$('input[id=obligatoria-'+j+']')[0].checked];
	      };
	    send = {'id' : vota};
	    send['arr']= arr;
		$.ajax({
	      url: '/preguntes/ajax',
	      type: "post",
	      //var arr = new Array();
	      data: send,
	      success: function(data){
	      	preAssistents();
	      	$('.borde-azul').css("display","none");
	      	$('.borde-naranja').css("display","inherit");
	      	$('#tab2').removeClass('current active'); 
	        $('#tab3').addClass('current active');
	        $('.warning').css("display","none");
	        $('#pas').html('Pas 3 de 3');
	        $('#next').attr('value',"Guardar | Sortir");
	        $('#next').attr('onclick',"assistents()");
      	  }
        });
	}

	function novaPregunta(elem){
		$(elem).parent().css("display","none");
		++i;
		$("#preguntes").prepend("<div class='row'><div class='column-form large-2 margin-t-s' style='width:100%''><label for='data'>Pregunta</label><input id='preg-" + i +"' type='text'></div><div style='float: right; margin-top: -82px; margin-right: 7px;'><a href='#' class='ver-mas-enlace' onClick='novaPregunta(this)'>Afegir més</a></div></div><div class='row'><div class='column-form large-2 margin-t-s'><label for='data'>Resposta tancada</label><input id='resposta-" + i +"' type='text' placeholder='Resposta A, Resposta B, Resposta C'></div><div class='column-form med-2 margin-t-n' style= 'margin-top: 31px; padding-left: 25px;'><input type='checkbox' id='obligatoria-" + i + "'><label for='aviso' class='aviso'>Resposta obligatòria</label></div>");
	};
	function votacio(){
	  	$('input[id=name]').removeClass('error');
	  	$('input[id=dataIni]').removeClass('error');
	  	$('input[id=dataFin]').removeClass('error');
	  	$('#esd').removeClass('error');
	  	//$('#esd').children('dt').children('a').children('span').text()

	  	$("#nameError").css("display","none");
	  	$("#dataIniError").css("display","none");
	  	$("#dataFinError").css("display","none");
	  	$("#esdError").css("display","none");          
	    $.ajax({
	      url: '/votacions/ajax',
	      type: "post",
	      data: {'name':$('input[id=name]').val(),'dataIni':$('input[id=dataIni]').val(),'dataFin':$('input[id=dataFin]').val(),'esd':$('#esd').children('dt').children('a').text()},
	      success: function(data){
	        if(data=="falta name") {$('input[id=name]').addClass('error');$("#nameError").css("display","inherit");}
	        else if(data=="falta dataIni") {$('input[id=dataIni]').addClass('error');$("#dataIniError").css("display","inherit");}
	        else if(data=="falta dataFin") {$('input[id=dataFin]').addClass('error');$("#dataFinError").css("display","inherit");}
	        else if(data=="falta esd") {$('#esd').addClass('error');$("#esdError").css("display","inherit");}
	        else {
	        	values = data.split(',');
	        	vota = parseInt(values[0]);
	        	esd = parseInt(values[1]);
	        	$('.borde-verde').css("display","none");
	        	$('.borde-azul').css("display","inherit");
	        	$('#tab1').removeClass('current active'); 
	        	$('#tab2').addClass('current active');
	        	$('.warning').css("display","inherit");
	        	$('#pas').html('Pas 2 de 3');
	        	$('#next').attr('onclick',"preguntes()");
	        }
      	  }
        });
	};

	function preAssistents(){
		$.ajax({
	      url: '/votacions/preassistents/ajax',
	      type: "get",
	      data: {'id':esd},
	      success: function(data){
	      	values = data.split(',');
	      	i = values.length;
	      	if(i == 1 && values[0] == "") {
	      		i = 0;
	      		$("#listAss").append("<div id='dataIniError' class='errores' style='margin-bottom: 12px;'>Actualment no hi ha cap assistent per al esdeveniment de la votació creada.</div>");
	      	}
	      	else {
	      		for (item = 1; item <= values.length; item++) { 
	    			$("#listAss").append("<input type='checkbox' id='ass-" + item +"'><label for='ass-" + item +"' class='aviso' style='width:32%;'>" + values[item-1] + "</label>");
				}
			}
	      }        
        });
	};

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
			<fieldset class="borde-verde">
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
						<div id="dataIniError" class="errores" style="display:none">La data no es valida</div>
					</div>
				</div>
				<div class="row">		
					<div class="column-form large-2 margin-t-s">	
						<label for="esd">Nom del esdeveniment</label>
						<dl class="dropdown" id="esd">
						    <dt><a href="#"><span>Selecciona</span></a></dt>
						    <dd>
						        <ul style="display: none; overflow: auto; height:110px;">
						            @foreach($ini as $esd)
						            <li><a href="#">{{$esd->titol}}</a></li>
						            @endforeach
						        </ul>
						    </dd>
						</dl>
						<div id="esdError" class="errores" style="display:none">Selecciona un esdeveniment per aquesta votació</div>
					</div>
					<div class="column-form med-2 margin-t-n">
						<label for="data">Data hora fin</label>
						<input id="dataFin" type="text" placeholder="AAAA-MM-DD HH:MM:SS">
						<div id="dataFinError" class="errores" style="display:none">La data no es valida</div>
					</div>
				</div>
			</fieldset>
			<fieldset class="borde-azul" style="display:none">
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
			<fieldset class="borde-naranja" style="display:none">
				<h3>DADES ASSISTENTS</h3>
				<div id="listAss"></div>
				
			</fieldset>
			
			<div class="warning" style="display:none">
				<h4>important !</h4>
				<p id="warning">Les diferents respostes tancades s'han de separar entre elles per una coma i un espai</p>
				<p id="warning">Si no s'indica una resposta tancada, s'establirà què la resposta és oberta.</p>
			</div>
			<div class="relative">
				<div class="left">
					<input class="btn btn-naranja" type="button" value="Guardar | Continuar" id="next" onClick="votacio()">
				</div>
				<div class="right">
					<a href="#" class="btn-steps right" id="pas">Pas 1 de 3</a>
				</div>
			</div>
		</div>
	</div>			
</form>

@stop