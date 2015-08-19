@extends('layouts.masterCOFB')
 
@section('titulo') {{$esd->titol}} @stop

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
	function verificar(id) {
		confirmar=confirm("Si acceptes, s'esborrarà l'esdeveniment. Estàs segur?"); 
		if (confirmar) {
			$.ajax({
	      		url: '/esdeveniments/'+id,
	      		type: "delete",
	      		success: function(data){
	      			window.location.replace("/esdeveniments");
	      	  }
        	});
		}
	};
	</script>
	<div class="paso">
		@if($esd->num==0  && $esd->votacions->count()==0)
		<div class="user-menu"><a onclick="verificar({{$esd->id}})" class="cierre" style="float:right;"></a></div>
		@endif
		<?php 
			$now = time();
			$diff =  strtotime($esd->dataHora) - $now;
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		?>
		@if($diff<0) <h5 class="dos">{{$esd->titol}}</h5>
		@elseif ($diff <= (60*60*24*5)) <h5 class="uno">{{$esd->titol}}</h5>
		@else <h5 class="tres">{{$esd->titol}}</h5>
		@endif
			
			<div style="float:left;">			
			<p><b>Data i hora:</b>   {{$esd->dataHora}}@if($diff>0)   <i>(falten: {{$months}} mesos i {{$days}} dies)@endif</i></p>
			<p><b>Lloc:</b>   {{$esd->lloc}}</p>
			@if($esd->inscripcioOberta == 1)
			<p><b>Inscripció oberta:</b>   Sí</p>
			@else
			<p><b>Inscripció oberta:</b>   No</p>
			@endif
			@if($esd->presencial == 1)
			<p><b>Presencial:</b>   Sí</p>
			<p><b>Número d'assistents:</b>   {{$esd->num}}</p>
			@else
			<p><b>Presencial:</b>   No</p>
			<p><b>Nombre de participants:</b>   {{$esd->num}}</p>
			@endif
			
			</div>
	</div>


	<a href="#"><h5 id="primer" class="titulo-estrella has-sub" style= "background: url('../img/iconos/arrow-left.png') no-repeat 98% center;" >Votacions</h5></a>
	<div id="primerIN" style="display:none;">
		<ul>
	@foreach($esd->votacions as $item)
	<div class="paso" style="height:128px;">
		<?php 
			$now = time();
			$ini = strtotime($item->dataHoraIni);
			$fin = strtotime($item->dataHoraFin);
			$diff =  strtotime($item->dataHoraIni) - $now;
			$diff2 = strtotime($item->dataHoraFin) - $now;
		?>
		@if($diff2<0 || $diff>0) <h5 class="dos">{{$item->titol}}</h5>
		@elseif ($diff2 <= (60*60*24*1)) <h5 class="uno">{{$item->titol}}</h5>
		@else <h5 class="tres">{{$item->titol}}</h5>
		@endif
			<div style="float:left;">
				<p><b>Data i hora inici:</b>   {{$item->dataHoraIni}}</p>
				<p><b>Data i hora fin:</b>    {{$item->dataHoraFin}}</p>	
			</div>
			<div style="margin-top:-8px; float: right;"><a class="btn btn-naranja ver_mas" href="/votacions/{{$item->id}}">VEURE MÉS</a></div>
	</div>
@endforeach
</ul>
	</div>
	<a href="#"><h5 id="segon" class="titulo-estrella has-sub" style= "background: url('../img/iconos/arrow-left.png') no-repeat 98% center;">Assistents</h5></a>
	<iframe id="segonIN" src="/esdeveniments/{{$esd->id}}/assistents" scrolling="no" seamless="seamless" style="border: none; width: 100%; display:none;" onload='javascript:resizeIframe(this);'></iframe>







<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script language="javascript" type="text/javascript">
  function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
  }
</script>
<script type="text/javascript">

$('#primer').click(function()
{
  // do my image switching logic here.
//alert($(this).css);
	if (!$(this).hasClass("active")) {
	    $(this).addClass("active");
  		$(this).css("background-Image", "url('../img/iconos/arrow-down-a.png')");
  		$('#primerIN').slideDown('normal',fakeCombo());
  	} else {
  		$('.titulo-estrella').removeClass("active");
  		$(this).css("background-Image", "url('../img/iconos/arrow-left.png')");
  		$('#primerIN').slideUp('normal',fakeCombo());
  	}

});
$('#segon').click(function()
{
  // do my image switching logic here.
//alert($(this).css);
	if (!$(this).hasClass("active")) {
	    $(this).addClass("active");
  		$(this).css("background-Image", "url('../img/iconos/arrow-down-a.png')");
  		$('#segonIN').slideDown('normal',fakeCombo());
  	} else {
  		$('.titulo-estrella').removeClass("active");
  		$(this).css("background-Image", "url('../img/iconos/arrow-left.png')");
  		$('#segonIN').slideUp('normal',fakeCombo());
  	}

});


	




</script>

@stop 