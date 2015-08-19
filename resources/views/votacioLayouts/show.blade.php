@extends('layouts.masterCOFB')
 
@section('titulo') {{$vota->titol}} @stop

@section('menu')
<h1>Esdeveniments</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li class="selected"><a href="#">Llistat d'esdeveniments</a></li>
    <li><a href="#">Crear nou esdeveniment</a></li>
</ul>
@stop



@section('contenido')
	<div class="paso">
		@if($vota->ass==0 && $vota->preguntes->count()==0)
		<div class="user-menu"><a onclick="verificar({{$vota->id}})" class="cierre" style="float:right;"></a></div>
		@endif
		<?php 
			$now = time();
			$diff =  strtotime($vota->dataHoraIni) - $now;
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = ceil(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			$diff2 =  strtotime($vota->dataHoraFin) - $now;
			$years2 = floor($diff / (365*60*60*24));
			$months2 = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days2 = ceil(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		?>
		@if($diff>0 || $diff2<0) <h5 class="dos">{{$vota->titol}}</h5>
		@elseif ($diff2 <= (60*60*24*5)) <h5 class="uno">{{$vota->titol}}</h5>
		@else <h5 class="tres">{{$vota->titol}}</h5>
		@endif
			<div style="float:left;">			
			<p><b>Esdeveniment:</b>   {{$vota->esd->titol}}
			<p><b>Data i hora inici:</b>   {{$vota->dataHoraIni}}@if($diff>0)   <i>(falten: {{$months}} mesos i {{$days}} dies)@endif</i></p>
			<p><b>Data i hora fin:</b>   {{$vota->dataHoraIni}}@if($diff2>0 && $diff<0)   <i>(falten: {{$months}} mesos i {{$days}} dies)@endif</i></p>
			<p><b>Nombre de participants:</b>   {{$vota->ass}}</p>
			</div>
	</div>


	<a href="#"><h5 id="primer" class="titulo-estrella has-sub" style= "background: url('../img/iconos/arrow-left.png') no-repeat 98% center;" >Preguntes</h5></a>
	<div id="primerIN" style="display:none;">
	@foreach($vota->preguntes as $preg)
		<div class="column-cajas" style="width:100%;">	
			<div class="caja-gris" style="border-radius: 14px;">
				<p style="padding-right: 110px;"><span class="titulo-listado">{{$preg->titol}}</span></p>
				<div style="float: right; margin-right: -7px; margin-top: -25px;">
					<a href="/votacions/{{$vota->id}}/preguntes/{{$preg->id}}/respostes" class="ver-mas-enlace">Veure respostes</a>
				</div>
				<ul class="lista-enlaces">
					@if($preg->opcions != "")
					<li><a>Resposta tancada:</a>
						<ul>
							@foreach (explode(', ', $preg->opcions) as $op)
          						<li><a>{{$op}}</a></li>
      						@endforeach
						</ul>
					</li>
					@endif
					@if($preg->obligatoria)
					<li><a>Obligatoria</a></li>
					@endif
				</ul>
			</div>
		</div>
	@endforeach
	</div>
	<a href="#"><h5 id="segon" class="titulo-estrella has-sub" style= "background: url('../img/iconos/arrow-left.png') no-repeat 98% center;">Participants</h5></a>
	<iframe id="segonIN" src="/votacions/{{$vota->id}}/assistents" scrolling="no" seamless="seamless" style="border: none; width: 100%; display:none;" onload='javascript:resizeIframe(this);'></iframe>







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

function verificar(id) {
		confirmar=confirm("Si acceptes, s'esborrarà la votació. Estàs segur?"); 
		if (confirmar) {
			$.ajax({
	      		url: '/votacions/'+id,
	      		type: "delete",
	      		success: function(data){
	      			window.location.replace("/votacions");
	      	  }
        	});
		}
	};
	




</script>

@stop 