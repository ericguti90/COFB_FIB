<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <script src="/js/jquery-1.10.2.min.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/varios.js"></script>
    <title>Collegi de Farmacèutics de Barcelona</title>
    <link rel="stylesheet" href="/css/fs_main.css" />
    <link rel="stylesheet" href="/css/fs_responsive.css" />
    <link rel="stylesheet" href="/css/slidebars.css" />
    <!--[if lt IE 9]>
          <script src="js/html5.js" type="text/javascript"></script>
          <script src="js/css3-mediaqueries_src.js" type="text/javascript"></script>
          <script src="js/varios-ie8.js"></script>
          <link rel="stylesheet" href="css/fs_ie8.css" />
        <![endif]-->
        <?php
header('Content-Type: text/html; charset=UTF-8'); 
?>
</head>
<body style="background:none;">
<ul>
	@foreach($ass as $item)
	<div class="paso" style="height: 143px;">
		@if ($item->ass->delegat) <h5 class="uno">{{$item->ass->usuari}}</h5>
		@elseif (!$item->ass->assistit) <h5 class="dos">{{$item->ass->usuari}}</h5>
		@else <h5 class="tres">{{$item->ass->usuari}}</h5>
		@endif
			<div style="float:left;">			
			<p><b>Assistit:</b>   @if($item->ass->assistit) Sí @else No @endif</p>
			@if($item->ass->assistit)<p><b>Data i hora:</b>  {{$item->ass->dataHora}}</p>@endif
			<p><b>Delegat:</b>   @if($item->ass->delegat) Sí @else No @endif</p>
			
			</div>
			<div style="padding-top: 12px; float: right;"><a class="btn btn-naranja ver_mas" href="/votacions/{{$ass->id}}/assistents/{{$item->ass->id}}" target="_parent" style="width: 152px; background-position: 124px 5px;">VEURE RESPOSTES</a></div>
	</div>
	@endforeach
</ul>
		@if($ass->lastPage()>1)
			<section class="pag-revistas clearfix">
				<h3 class="left">Mostrar</h3>
				
				<ul class="paginador-results numerico right">
					<li style="display: inline-block;"><a href="/votacions/{{$ass->id}}/assistents?page=1">Primera</a></li>
					@for($i=1;$i<=$ass->lastPage();++$i)
					<li style="display: inline-block;"><a href="/votacions/{{$ass->id}}/assistents?page={{$i}}">{{$i}}</a></li>
					@endfor
					<li style="display: inline-block;"><a href="/votacions/{{$ass->id}}/assistents?page={{$ass->lastPage()}}">última</a></li>
				</ul>
			</section>
		@endif

</body>