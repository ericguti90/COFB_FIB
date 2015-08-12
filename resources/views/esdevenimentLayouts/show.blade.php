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

	<a href="#"><h5 id="primer" class="titulo-estrella has-sub" style= "background: url('../img/iconos/arrow-left.png') no-repeat 98% center;" >Votacions</h5></a>
	<div id="primerIN" style="display:none;">
		@foreach($esd->votacions as $item)
		{{$item}}
		@endforeach
		@if($esd->votacions->lastPage()>1)
			<section class="pag-revistas clearfix">
				<h3 class="left">Mostrar</h3>
				
				<ul class="paginador-results numerico right">
					<li style="display: inline-block;"><a href="/esdeveniments/{{$esd->id}}?page=1">Primera</a></li>
					@for($i=1;$i<=$esd->votacions->lastPage();++$i)
					<li style="display: inline-block;"><a href="/esdeveniments/{{$esd->id}}?page={{$i}}">{{$i}}</a></li>
					@endfor
					<li style="display: inline-block;"><a href="/esdeveniments/{{$esd->id}}?page={{$esd->votacions->lastPage()}}">última</a></li>
				</ul>
			</section>
		@endif
	</div>
	<a href="#"><h5 id="segon" class="titulo-estrella has-sub" style= "background: url('../img/iconos/arrow-left.png') no-repeat 98% center;">Assistents</h5></a>
	<div id="segonIN" style="display:none;">
		@foreach($esd->assistents as $item)
		{{$item}}
		@endforeach
		@if($esd->assistents->lastPage()>1)
			<section class="pag-revistas clearfix">
				<h3 class="left">Mostrar</h3>
				
				<ul class="paginador-results numerico right">
					<li style="display: inline-block;"><a href="/esdeveniments/{{$esd->id}}?page=1">Primera</a></li>
					@for($i=1;$i<=$esd->assistents->lastPage();++$i)
					<li style="display: inline-block;"><a href="/esdeveniments/{{$esd->id}}?page={{$i}}">{{$i}}</a></li>
					@endfor
					<li style="display: inline-block;"><a href="/esdeveniments/{{$esd->id}}?page={{$esd->assistents->lastPage()}}">última</a></li>
				</ul>
			</section>
		@endif
	</div>







<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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