<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/varios.js"></script>
    <title>Collegi de Farmacèutics de Barcelona</title>
    <link rel="stylesheet" href="css/fs_main.css" />
    <link rel="stylesheet" href="css/fs_responsive.css" />
    <link rel="stylesheet" href="css/slidebars.css" />
    <!--[if lt IE 9]>
          <script src="js/html5.js" type="text/javascript"></script>
          <script src="js/css3-mediaqueries_src.js" type="text/javascript"></script>
          <script src="js/varios-ie8.js"></script>
          <link rel="stylesheet" href="css/fs_ie8.css" />
        <![endif]-->
</head>
<body class="">
    <div id="wrapper">
        <!--Cabecera-->
        <header id="banner" role="banner">
            <!--Contenedor Header: Logo -->
            <div id="heading" class="contenedor-header">
                <a class="logo left" href="#">
                    <img src="img/logo.jpg" alt="Collegui de Farmacéutics de Barcelona" width="171" height="36"/>
                </a>
            </div>
            <!--Fin Contenedor Header: Logo -->
            <!-- Navegacion -->
            <nav class="menu-principal" id="navigation">
                <!-- Menu Superior -->
                <ul class="menu">
                    <li class="item m-mobilef sub"><button type="button" id="menu-inferior" class=""><img src="img/iconos/menu.png" alt="search"></button></li>
                    <li class="submenu">
                        <ul>
                            <li class="item m-mobilet sub"><button type="button" id="menu-lateral" class=""><span>Menú Activitat de l´Oficina</span><img src="img/iconos/menu.png" alt="search"></button></li>
                            <li class="item m-mobilet item2"><a href="#">Esdeveniments</a></li>
                            <li class="item m-mobilet item2"><a href="#">Votacions</a></li>
                            <li class="item m-mobilet no-border item2"><a href="#">Usuaris</a></li>
                        </ul>
                    </li>
                    <li class="item home"><a id="inici" href="#" class=""><span class="menu_tab">Marcar com pàgina d'inici</span></a></li>
                </ul>
                <!-- Fin Menu Superior -->
                <!--Menu Desplegable Oculto-->
                <div class="menu-desplegable sb-slidebar sb-left">
                    <div class="menu_container">
                        <a id="menu-inferior-mobile" class="boton-mobile-derecha"><span>Menú principal</span></a>                   
                        <h1>Activitat de l’Oficina</h1> <!-- Titulo de la home seleccionada -->
                        <ul>
                            <li class="only_mobile"><span>Activitat de l’Oficina</span></li> <!-- Titulo de la home seleccionada -->
                            <li>
                                <a href="#"><span class="tit_actual">Actualitat dia a dia</span><span class="tit_anterior">Activitat de l’Oficina</span></a>
                                <div class="subnivel">
                                    <ul>
                                        <li class="only_mobile"><span>Actualitat dia a dia</span></li>
                                        <li><a href="#">Guía de dispensació del SCS</a></li>
                                        <li><a href="#">Formules magistrals i preparats oficinals</a></li>
                                        <li><a href="#">Accés SIFARE (recepta electrònica)</a></li>
                                        <li><a href="#">Ortopèdia</a></li>
                                        <li><a href="#">Serveis concentrats</a></li>
                                        <li><a href="#">Informació al pacient</a></li>
                                        <li>
                                            <a href="#"><span class="tit_actual">Actualitat</span><span class="tit_anterior">Actualitat dia a dia</span></a>
                                            <div class="subnivel">
                                                <ul>
                                                <li class="only_mobile"><span>Actualitat</span></li>
                                                    <li><a href="#">Alertes de medicaments</a></li>
                                                    <li>
                                                        <a href="#"><span class="tit_actual">Comunicats del Collegi</span><span class="tit_anterior">Actualitat</span></a>
                                                        <div class="subnivel">
                                                            <ul>
                                                                <li class="only_mobile"><span>Comunicats del Collegi</span></li>
                                                                <li><a href="#">Últims comunicats</a></li>
                                                                <li><a href="#">Facturació (inclou de receptes)</a></li>
                                                                <li>
                                                                    <a href="#"><span class="tit_actual">Comptabilitat</span><span class="tit_anterior">Comunicats del Collegi</span></a>
                                                                    <div class="subnivel">
                                                                        <ul>
                                                                            <li class="only_mobile"><span>Comptabilitat</span></li>
                                                                            <li><a href="#">Otra</a></li>
                                                                            <li class="selected"><a href="#">Otra</a></li> <!-- Ejemplo de seleccionado -->
                                                                            <li><a href="#">Otra</a></li>
                                                                        </ul>   
                                                                    </div>
                                                                </li>
                                                                <li><a href="#">Legislació</a></li>
                                                                <li><a href="#">Preus</a></li>
                                                                <li><a href="#">Campanyes</a></li>
                                                                <li><a href="#">Serveis complementaris</a></li>
                                                                <li><a href="#">Medicaments d’abús</a></li>
                                                                <li><a href="#">Avisos SIFARE</a></li>
                                                            </ul>
                                                        </div>
                                                    </li>   
                                                    <li><a href="#">Representació dels Collegiats</a></li>
                                                    <li><a href="#">Subscripció a l’Actualitat de l’Oficina de Farmàcia</a></li>    
                                                </ul>
                                            </div>
                                        </li>   
                                    </ul>
                                </div>
                            </li>
                            <li><a href="#">Guía de dispensació del SCS</a></li>
                            <li><a href="#">Actualitat espordica</a></li>
                            <li class="selected"><a href="#">Documentació i altres</a></li> <!-- Ejemplo de seleccionado -->
                            <li><a href="#">Assegurances</a></li>
                        </ul>
                    </div>
                </div>
                <!--Fin Menu Desplegable Oculto-->              
            </nav>
            <!-- Fin Navegacion -->
            <div class="usuario">
                <div>
                    <p><span>Eric Gutiérrez Llopis</span></p>
                    <div class="user-menu">
                        <a href="#" class="mail">Mail</a>
                        <a href="#" class="calendario">Calendario</a>
                        <a href="#" class="fichero">Fichero</a>
                        <a href="#" class="configuracion">Configuracion</a>
                        <a href="#" class="cierre">Cierre</a>
                    </div>
                </div>
            </div>
            <div class="buscador">
                <form action="">
                    <input type="text" id="ip-search">
                </form>
            </div>
            <div class="pagina_inici">
                <div>
                    <p>Marcar <b>Activitat de l’Oficina</b> como página de inicio</p>
                    <input class="btn btn-verde right" type="submit" value="ENTRAR">
                </div>
            </div>
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
                        @yield('titulo', 'Titulo por defecto')
                        <div class="prederecha"><div class="derecha"></div></div>
                    </h2>
                    <menu class="portlet-topper-toolbar" id="portlet-topper-toolbar_$portlet_id" type="toolbar">
                    <!-- Portlet header action icons -->
                    </menu>
                  </header>         
                  <!--Columna de contenido Izquierda-->
                  <div class="portlet-content">
                        @yield('contenido') 
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
                    <div class="portlet-content">
                    <!--Columna de Contenido Derecha-->
                        <!--Caja de Accesos directos-->
                                        <section class="accesos-directos">
                                            <h6>Accesos Directos</h6>
                                            <ul class="lista-accesos-directos">
                                                <li class="item-accesos-directos"><a href="">Actualitat dia a dia</a></li>
                                                <li class="item-accesos-directos"><a href="">Assegurances</a></li>
                                                <li class="item-accesos-directos"><a href="">Centre de documentació</a></li>
                                                <li class="item-accesos-directos"><a href="">Medicaments</a></li>
                                                <li class="item-accesos-directos"><a href="">Legislació</a></li>
                                                <li class="item-accesos-directos"><a href="">Actualitat dels laboratoris</a></li>
                                            </ul>
                                        </section>
                                        <!--Fin Caja de Accesos directos-->
                                        <!--Banners-->
                                        <section class="banners">
                                            <a href="#" class="enl-banner"><img src="img/banners/b1.jpg" alt="Banner1" class="banner"></a>
                                            <a href="#" class="enl-banner"><img src="img/banners/b2.jpg" alt="Banner2" class="banner"></a>
                                            <a href="#" class="enl-banner"><img src="img/banners/b3.jpg" alt="Banner3" class="banner"></a>
                                        </section>
                                        <!--Fin Banners-->
                                    <!--Fin Columna de Contenido Derecha-->
                                    </div>
                                </section>
                        </div>
                    </div>
                    <!--Fin Columna de contenido derecha-->
                </div>
            </div>
            <!-- Fin 2 columns layout -->   
        </div>  
      <!--Fin Columna de contenido derecha-->
                </div>
            </div>
            <!-- Fin 2 columns layout -->   
        </div>          
        <!--Fin de Contenedor General-->
        <!--Pie de Página-->
        <footer id="footer" role="contentinfo">
            <div class="contenedor-footer">
                <div class="direccion">
                    <p>2015 COFB. Girona 64 -66. 08009 Barcelona. <span class="tel">Tel +34 93 244 07 10</span></p>
                </div>
                <div class="footer_menu_container">
                    <ul class="footer-menu">
                        <li><a href="#">Contacte</a></li>
                        <li><a href="#">Ajuda</a></li>
                        <li><a href="#">Avis Legal</a></li>
                        <li><a href="#">Farmaceuticonline.com</a></li>
                        <li><a href="#">cofb.org</a></li>
                    </ul>
                </div>
            </div>
        </footer>
        <!--Fin de Pie de Página-->
    </div>
</body>
</html>