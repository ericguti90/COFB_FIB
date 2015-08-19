@extends('layouts.masterCOFB')

@section('titulo') Nou assistent @stop

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
	var i = 1;
	function assistents(id, continuar){
		var arr = {};
		var vota = {}
		for(var j = 1; j <= i; j++) {
			arr[j] = $('input[id=ass-'+j+']').val();
	      };
	    send = {'id' : id};
	    send['arr']= arr;
	    i = 1;
	    for(var j = 1; j <= {{$count}}; j++) {
	    	if($('input[id=vota-'+j+']')[0].checked) {
	    		++i;
	    		vota[i] = $('label[for=vota-'+j+']').text();
	    	}
	    };
	    send['vota'] = vota;
		$.ajax({
	      url: '/assistents/ajax',
	      type: "post",
	      //var arr = new Array();
	      data: send,
	      success: function(data){
	      	if(continuar) window.location.reload();
	      	else window.location.replace("/esdeveniments/{{$id}}");
      	  }
        });
	}


	function nouAssistent(elem){
		$(elem).parent().css("display","none");
		++i;
	  	$("#assistents").prepend("<div class='row'><div class='column-form large-2 margin-t-s'><input type='text' id='ass-"+ i +"' style='margin-left: 55px;'></div><div style='float: right; margin-top: 6px; margin-right: 57px;'><a href='#' class='ver-mas-enlace' onClick='nouAssistent(this)'>Afegir més</a></div></div>");
	};
</script>
<form action="" id="form-activ-collegial">
	<fieldset class="borde-amarillo">
		<h3>DADES ASSISTENTS</h3>
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
	<fieldset class="borde-naranja">
		<h3>AFEGIR A VOTACIONS</h3>
		<div id="votacions">
			<div class="row">
			<?php $aux = 1;?>
			@foreach($vota as $item)
				<div class="column-form med-2">
					<input type='checkbox' id='vota-{{$aux}}'>
					<label for='vota-{{$aux}}' class='aviso' style='width:32%;'>{{$item->titol}}</label>
					<?php ++$aux;?>
				</div>
			@endforeach
			</div>
		</div>
	</fieldset>
	<div class="relative">
		<div class="left">
			<input class="btn btn-naranja" type="button" value="Guardar | Continuar" id="next" onClick="assistents({{$id}},1)">
		</div>
	</div>
	<div class="relative">
		<div class="right">
			<input class="btn btn-naranja" type="button" value="Guardar | Sortir" id="next" onClick="assistents({{$id}},0)">
		</div>
	</div>

</form>

@stop