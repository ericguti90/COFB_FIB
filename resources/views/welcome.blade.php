<!doctype html>
<html lang="en">
<head>
    <head>
    <meta charset="UTF-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="js/splash.js" type="text/javascript"></script>
    <title>Collegi de Farmacèutics de Barcelona</title>
    <link rel="stylesheet" href="css/fs_splash.css"/>
    <!--[if lt IE 9]>
          <script src="js/html5.js" type="text/javascript"></script>
          <script src="js/css3-mediaqueries_src.js" type="text/javascript"></script>
          <script src="js/varios-ie8.js"></script>
          <link rel="stylesheet" href="css/fs_ie8.css" />
        <![endif]-->
</head>
<body class="splash">
    @if (Auth::check())
    Usuario Actual: {{ Auth::user()->username }}. {!! Html::link('logout','Desconectar') !!}
    <hr/>
  @endif
    <div id="wrapper">
        <!--Cabecera-->
        <header id="banner" role="banner">
            <!--Contenedor Header: Logo -->
            <div id="heading">
                <div class="logo-container">
                    <a class="logo" href="#">
                        <img src="img/logo.jpg" alt="Collegui de Farmacéutics de Barcelona" border="0"/>
                    </a>
                </div>
                <div class="titulo-superior">
                    Destaquem
                </div>
            </div>
            <!--Fin Contenedor Header: Logo -->
            <!-- Navegacion -->
            <nav class="" id="navigation">
        <ul>
          <li class="selected"><a href="#"></a></li> 
          <li><a href="#"></a></li>
          <li><a href="#"></a></li>
          <li><a href="#"></a></li>
         </ul>
      </nav>
            <!-- Fin Navegacion -->
        </header>
        <!--Fin de Cabecera-->
      <!--Contenedor General-->
      <div id="content" class="contenedor">
        <!-- 2 columns layout -->
        <div id="main-content" class="columns-2" role="main">
        <div class="portlet-layout">
            <!-- First column 70% -->
            <div id="column-1" class="aui-w70 portlet-column portlet-column-first yui3-dd-drop col-izquierda">
              <div id="layout-column_column-1" class="portlet-dropzone portlet-column-content portlet-column-content-first">
                <!-- 1..n Portlets in column 1 -->
                <!-- Portlet box -->
                  <section class="portlet" id="portlet_$portlet_id">
                  <header class="portlet-topper">
                    <h2 class="portlet-title titulo-pagina">
                    <!-- Portlet title and icon -->
                    </h2>
                    <menu class="portlet-topper-toolbar" id="portlet-topper-toolbar_$portlet_id" type="toolbar">
                    <!-- Portlet header action icons -->
                    </menu>
                  </header>         
                  <!--Columna de contenido Izquierda-->
                  <div class="portlet-content">
                    <div class="img-splash">
                        <img src="img/splash-1.jpg" border="0" alt="Guia de dispensació del SCS" />
                    </div>
                    <div class="img-splash">
                        <img src="img/splash-2.jpg" border="0" alt="Guia de dispensació del SCS" />
                    </div>
                    <div class="img-splash">
                        <img src="img/splash-3.jpg" border="0" alt="Guia de dispensació del SCS" />
                    </div>
                  </div>
                                <!--Fin Columna de contenido Izquierda-->   
                            </section>
                        </div>                      
                    </div>                  
                    <!--Fin First Column 70%-->
                    <!--Second Column 30%-->
            <div id="column-1" class="aui-w30 portlet-column portlet-column-first yui3-dd-drop col-derecha">
              <div id="layout-column_column-1" class="portlet-dropzone portlet-column-content portlet-column-content-first">
                <!-- 1..n Portlets in column 2 -->
                  <!-- Portlet box -->
                  <section class="portlet" id="portlet_$portlet_id">
                    <header class="portlet-topper">
                      <h1 class="portlet-title">
                      <!-- Portlet title and icon -->
                      </h1>
                      <menu class="portlet-topper-toolbar" id="portlet-topper-toolbar_$portlet_id" type="toolbar">
                      <!-- Portlet header action icons -->
                      </menu>
                    </header>         
                    <!--Columna de Contenido Derecha-->
                    <div class="portlet-content" style="display:none;" id="splash">

    <!-- <progress id="progressbar" value="0" max="100">100%</progress> -->
    <p>Cargando <span id="progressnum" class="verde"></span>%</p>
    <div id="progressbar">
        <div id="indicator" style="width: 100%;"></div>
    </div>
                                    </div>
                                    <!--Fin Columna de Contenido Derecha-->
                                </section>
                        </div>
                    </div>
                    <!--Fin Columna de contenido derecha-->
                </div>
            </div>
            <!-- Fin 2 columns layout -->   
        </div>          
        <!--Fin de Contenedor General-->
        <!--Pie de Página-->
      <footer id="footer" role="contentinfo">

      </footer>
        <!--Fin de Pie de Página-->
    </div>
    

<div style="background-color: #FAFAFA; padding: 0 150px;  width: 746px; margin:-105px auto;border-radius: 10px;" id="login">
    <div id="layout-column_column-1" class="portlet-dropzone portlet-column-content portlet-column-content-first">
    <!-- 1..n Portlets in column 1 -->
    <!-- Portlet box -->
        <section class="portlet" id="portlet_$portlet_id">
              
      <!--Columna de contenido Izquierda-->
            <div class="portlet-content">               
                <form action="" id="form-activ-collegial">
                    <div id="fieldsets">
                        <!--Actual-->
                        <div class="actual">
                            <fieldset class="borde-azul">
                                <h3>Iniciar sessió</h3>
                                <div class="row">
                                    <div class="column-form med-2"> 
                                        <label for="tel-1">Usuari</label>
                                        <input id="tel-1" type="text" class="inputText" name="username">
                                    </div>
                                    <div class="column-form med-2"> 
                                        <label for="tel-2" style="margin-top:.8em">Contrasenya</label>
                                        <input name="password" id="tel-2" type="password" class="inputText">
                                    </div>
                                    <!--<input type="hidden" name="_token" value="{{ csrf_token() }}"/>-->
                                </div>
                                <div class="left">
                                    <button type="button" class="btn btn-naranja" id="next">Iniciar sessió</button>
                                </div>                  
                            </fieldset>     
                        </div>
                    </div>
                </form>                 
            </div>
            <!--Fin Columna de contenido Izquierda-->   
        </section>
    </div>                      
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
  $('#next').click(function(){            
    $.ajax({
      url: 'login',
      type: "post",
      data: {'username':$('input[name=username]').val(),'password':$('input[name=password]').val()},
      success: function(data){
        if(data=="success") {
          $('#login').fadeOut(600);
          setTimeout(function(){
            $('#splash').fadeIn(600);
            start();
          }, 500);
          

        }
        else {
          window.location.reload("/login");
        }
      }
    }); 
    $('.next').unbind(); //unbind. to stop multiple form submit.     
  }); 
});
/*
$(document).ready(function(){
  $('.btn').click(function(){            
    alert($('input[name=username]').val());

     
    }); 
  }); */

</script>
</body>
</html>