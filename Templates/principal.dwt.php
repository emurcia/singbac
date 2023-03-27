<!--header-->
<?php

session_start();

if(!isset($_SESSION["usersesion"])){
	header ("Location:../index.php");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<!--<meta charset="UTF-8">-->
<!-- TemplateBeginEditable name="doctitle" -->
<title>Inicio</title>
<!-- TemplateEndEditable -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <link rel="Shortcut Icon" type="image/x-icon" href="../php/assets/icons/logo.ico" />
    <script src="js/sweet-alert.min.js"></script>
    <link rel="stylesheet" href="css/sweet-alert.css">
    <link rel="stylesheet" href="css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/jquery.dataTables.min.css">
    
    <!--	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">-->
	<link rel="stylesheet" href="css/estilos.css">
	<!-- Buttons DataTables -->
	<link rel="stylesheet" href="css/buttons.bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
     <link rel="stylesheet" href="../php/css/jquery.timepicker.css">
  <!--   <script src="js/lenguajeusuario.js"></script>-->
    <!-- TemplateBeginEditable name="head" -->
    <!-- TemplateEndEditable -->
</head>
<body>
    <div class="navbar-lateral full-reset">
        <div class="visible-xs font-movile-menu mobile-menu-button"></div>
        <div class="full-reset container-menu-movile custom-scroll-containers">
            <div class="logo full-reset all-tittles">
                <i class="visible-xs zmdi zmdi-close pull-left mobile-menu-button" style="line-height: 55px; cursor: pointer; padding: 0 10px; margin-left: 7px;"></i> 
                Sistema de inventario
            </div>
            <div class="full-reset" style="background-color:#2B3D51; padding: 10px 0; color:#fff;">
                <figure>
                    <img src="assets/img/logo.png" alt="Biblioteca" width="140" height="127" class="img-responsive center-box">
            </figure>
                <p class="text-center" style="padding-top: 15px;">Sistema de inventario aserradero</p>
            </div>
         <!--Menu-->
<div class="full-reset nav-lateral-list-menu">
                <ul class="list-unstyled">
                    <li><a href="princ.php"><i class="zmdi zmdi-home zmdi-hc-fw"></i>&nbsp;&nbsp; Principal</a></li>
                    <li>
                        <div class="dropdown-menu-button"><i class="zmdi zmdi-case zmdi-hc-fw"></i>&nbsp;&nbsp; Administración <i class="zmdi zmdi-chevron-down pull-right zmdi-hc-fw"></i></div>
                 <ul class="list-unstyled">
                 
                     <li><a href="admin_empresa.php"><i class="zmdi zmdi-balance zmdi-hc-fw zmdi-hc-fw"></i>&nbsp;&nbsp; Adminitrar datos Empresa</a></li>
                     <li><a href="/SINGBAC/forms/f_cliente.php"><i class="zmdi zmdi-face zmdi-hc-fw"></i>&nbsp;&nbsp; Administrar usuario</a></li>
                     <li><a href="admin_provee.php"><i class="zmdi zmdi-truck zmdi-hc-fw"></i>&nbsp;&nbsp; Administrar Proveedor</a></li>
                     <li><a href="admin_encargado.php"><i class="zmdi zmdi-account zmdi-hc-fw"></i>&nbsp;&nbsp;  Administrar empleado</a></li>    		
                     <li><a href="admin_maquinaria.php"><i class="zmdi zmdi-balance zmdi-hc-fw zmdi-hc-fw"></i>&nbsp;&nbsp; Adminitrar Maquinaria</a></li>
                     <li><a href="admin_pagos.php"><i class="zmdi zmdi-balance zmdi-hc-fw zmdi-hc-fw"></i>&nbsp;&nbsp; Adminitrar Pagos</a></li>
                     <li><a href="admin_trozas_malas.php"><i class="zmdi zmdi-truck zmdi-hc-fw"></i>&nbsp;&nbsp; Producto dañado</a></li>   
                     <li><a href="admin_edit_troza.php"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>&nbsp;&nbsp; Editar envío</a></li>    
                                           
                 </ul>
                    </li>
                    <li>
                        <div class="dropdown-menu-button"><i class="zmdi zmdi-assignment-o zmdi-hc-fw"></i>&nbsp;&nbsp; Gestión de productos <i class="zmdi zmdi-chevron-down pull-right zmdi-hc-fw"></i></div>
                        <ul class="list-unstyled">
                    <li><a href="admin_inventario.php"><i class="zmdi zmdi-book"></i>&nbsp;&nbsp; Ingreso de productos</a></li>
<!--                <li><a href="admin_especie.php"><i class="zmdi zmdi-bookmark-outline zmdi-hc-fw"></i>&nbsp;&nbsp; Administrar especie de troza</a></li>-->
        
                        </ul>
                    </li>
                    <li>
                        <div class="dropdown-menu-button"><i class="zmdi zmdi-apps"></i>&nbsp;&nbsp; Gestión aserradero  <i class="zmdi zmdi-chevron-down pull-right zmdi-hc-fw"></i></div>
                        <ul class="list-unstyled">
                            <li><a href="admin_aserradero_inv.php"><i class="zmdi zmdi-bookmark-outline zmdi-hc-fw"></i>&nbsp;&nbsp; Ingreso inventario</a></li>
                    <li><a href="admin_produccion_aserradero.php"><i class="zmdi zmdi-bookmark-outline zmdi-hc-fw"></i>&nbsp;&nbsp; Producto aserradero</a></li>
                     <li><a href="admin_incidencias_aserradero.php"><i class="zmdi zmdi-book zmdi-hc-fw"></i>&nbsp;&nbsp; Incidencias  aserradero</a></li>
                             
                        </ul>
                    </li>
                    <li>
                        <div class="dropdown-menu-button"><i class="zmdi zmdi-brightness-5"></i>&nbsp;&nbsp; Gestión carpintería <i class="zmdi zmdi-chevron-down pull-right zmdi-hc-fw"></i></div>
                        <ul class="list-unstyled">
                        <li><a href="admin_inv_carpinteria.php"><i class="zmdi zmdi-bookmark-outline zmdi-hc-fw"></i>&nbsp;&nbsp; Ingreso inventario</a></li>
                            <li><a href="admin_produccion_carpinteria.php"><i class="zmdi zmdi-case-download"></i>&nbsp;&nbsp; Poducto carpintería</a></li>
                            <li><a href="admin_incidencias_carpinteria.php"><i class="zmdi zmdi-book zmdi-hc-fw"></i>&nbsp;&nbsp; Incidencias  carpintería</a></li>
                            
                        </ul>
                    </li>
                    <li>
                        <div class="dropdown-menu-button"><i class="zmdi zmdi-brightness-5"></i>&nbsp;&nbsp; Gestión poste <i class="zmdi zmdi-chevron-down pull-right zmdi-hc-fw"></i></div>
                        <ul class="list-unstyled">
                        <li><a href="admin_inv_poste.php"><i class="zmdi zmdi-bookmark-outline zmdi-hc-fw"></i>&nbsp;&nbsp; Ingreso inventario</a></li>
                            <li><a href="admin_produccion_poste.php"><i class="zmdi zmdi-case-download"></i>&nbsp;&nbsp; Poducto poste</a></li>
                            <li><a href="admin_incidencias_poste.php"><i class="zmdi zmdi-book zmdi-hc-fw"></i>&nbsp;&nbsp; Incidencias  poste</a></li>
                          
                            
                        </ul>
                    </li>
                    <li>
                        <div class="dropdown-menu-button"><i class="zmdi zmdi-brightness-5"></i>&nbsp;&nbsp; Gestión horno <i class="zmdi zmdi-chevron-down pull-right zmdi-hc-fw"></i></div>
                        <ul class="list-unstyled">
                            <li><a href="admin_ingreso_horno.php"><i class="zmdi zmdi-case-download"></i>&nbsp;&nbsp; Ingreso a horno</a></li>
                            <li><a href="admin_salida_horno.php"><i class="zmdi zmdi-book zmdi-hc-fw"></i>&nbsp;&nbsp; Salida  de horno</a></li>
                          
                     
                            
                        </ul>
                    </li>
                    <li>
                        <div class="dropdown-menu-button"><i class="zmdi zmdi-brightness-5"></i>&nbsp;&nbsp; Gestión corte basto <i class="zmdi zmdi-chevron-down pull-right zmdi-hc-fw"></i></div>
                        <ul class="list-unstyled">
                            <li><a href="admin_produccion_poste.php"><i class="zmdi zmdi-case-download"></i>&nbsp;&nbsp; Poducto corte basto</a></li>
                            <li><a href="admin_incidencias_poste.php"><i class="zmdi zmdi-book zmdi-hc-fw"></i>&nbsp;&nbsp; Incidencias  corte basto</a></li>
                          
                            
                        </ul>
                    </li>
                    <li>
                        <div class="dropdown-menu-button"><i class="zmdi zmdi-mail-send"></i>&nbsp;&nbsp; Gestión de envíos  <i class="zmdi zmdi-chevron-down pull-right zmdi-hc-fw"></i></div>
                        <ul class="list-unstyled">
                            <li><a href="admin_envio_aserradero.php"><i class="zmdi zmdi-case-download"></i>&nbsp;&nbsp; Envío de aserradero</a></li>
                            <li><a href="admin_envio_patio_aserradero.php"><i class="zmdi zmdi-case-download"></i>&nbsp;&nbsp; Envío de patio aserradero</a></li>
                            <li><a href="admin_envio_carpinteria.php"><i class="zmdi zmdi-case-download"></i>&nbsp;&nbsp; Envío de carpinteria</a></li>
                           <li><a href="admin_envio_patio_carpinteria.php"><i class="zmdi zmdi-case-download"></i>&nbsp;&nbsp; Envío de patio carpinteria</a></li>
                            <li><a href="admin_envio_horno.php"><i class="zmdi zmdi-case-download"></i>&nbsp;&nbsp; Envío de hornos</a></li>
                          
                        </ul>
                    </li>
                    <li>
                        <div class="dropdown-menu-button"><i class="zmdi zmdi-mail-send"></i>&nbsp;&nbsp; Recepción de envíos  <i class="zmdi zmdi-chevron-down pull-right zmdi-hc-fw"></i></div>
                        <ul class="list-unstyled">
                              <li><a href="admin_recepcion_envio_patio_aserradero.php"><i class="zmdi zmdi-bookmark-outline zmdi-hc-fw"></i>&nbsp;&nbsp; Recepción patio aserradero </a></li>
                               <li><a href="admin_recepcion_envio_horno.php"><i class="zmdi zmdi-bookmark-outline zmdi-hc-fw"></i>&nbsp;&nbsp; Recepción horno</a></li>
                                <li><a href="admin_recepcion_envio_carpinteria.php"><i class="zmdi zmdi-bookmark-outline zmdi-hc-fw"></i>&nbsp;&nbsp; Recepción carpintería</a></li>
                                <li><a href="admin_recepcion_envio_patio_carpinteria.php"><i class="zmdi zmdi-bookmark-outline zmdi-hc-fw"></i>&nbsp;&nbsp; Recepción patio carpintería</a></li>
                                <li><a href="admin_recepcion_envio_sinai.php"><i class="zmdi zmdi-bookmark-outline zmdi-hc-fw"></i>&nbsp;&nbsp; Recepción sinai</a></li>
                                 <li><a href="admin_recepcion_envio_impregnacion.php"><i class="zmdi zmdi-bookmark-outline zmdi-hc-fw"></i>&nbsp;&nbsp; Recepción impregnación</a></li>
                                <li><a href="admin_recepcion_envio_corte.php"><i class="zmdi zmdi-bookmark-outline zmdi-hc-fw"></i>&nbsp;&nbsp; Recepción corte basto</a></li>
                                 <li><a href="admin_recepcion_envio_poste.php"><i class="zmdi zmdi-bookmark-outline zmdi-hc-fw"></i>&nbsp;&nbsp; Recepción poste</a></li>
                                <li><a href="admin_recepcion_envio_tarima.php"><i class="zmdi zmdi-bookmark-outline zmdi-hc-fw"></i>&nbsp;&nbsp; Recepción tarima</a></li>
                        </ul>
                    </li>
                    
                    <!--<li>
                        <div class="dropdown-menu-button"><i class="zmdi zmdi-account-add zmdi-hc-fw"></i>&nbsp;&nbsp; Usuarios <i class="zmdi zmdi-chevron-down pull-right zmdi-hc-fw"></i></div>
                        <ul class="list-unstyled">
                            <li><a href="admin_usuario.php"><i class="zmdi zmdi-face zmdi-hc-fw"></i>&nbsp;&nbsp; Administrar usuario</a></li>
                        </ul>
                    </li>-->
                    <li>
                        <a href="admin_reporte.php"><i class="zmdi zmdi-file-text zmdi-hc-2x"></i>&nbsp;&nbsp; Reportes</a>
                    </li>
                    <li><a href="configsetting.php"><i class="zmdi zmdi-wrench zmdi-hc-fw"></i>&nbsp;&nbsp; Configuraciones avanzadas</a></li>
                </ul>
            </div>
            
        </div>
    </div>
    <div class="content-page-container full-reset custom-scroll-containers">
        <nav class="navbar-user-top full-reset">
            <ul class="list-unstyled full-reset">
                <figure>
                   <img src="assets/img/user01.png" alt="user-picture" class="img-responsive img-circle center-box">                
                </figure>
                <li style="color:#fff; cursor:default;">
                    <span class="all-tittles"><?php echo $_SESSION["nom_usu"]; ?></span>
                </li>
                <li  class="tooltips-general exit-system-button" data-href="logout.php" data-placement="bottom" title="Salir del sistema">
                    <i class="zmdi zmdi-power"></i>
                </li>
               <!-- <li  class="tooltips-general search-book-button" data-href="searchbook.html" data-placement="bottom" title="Buscar libro">
                    <i class="zmdi zmdi-search"></i>
                </li>-->
                <li  class="tooltips-general btn-help" data-placement="bottom" title="Ayuda">
                    <i class="zmdi zmdi-help-outline zmdi-hc-fw"></i>
                </li>
                <li class="mobile-menu-button visible-xs" style="float: left !important;">
                    <i class="zmdi zmdi-menu"></i>
                </li>
            </ul>
        </nav>
        
        
        <!--Cuerpo-->
      <div class="container">
            <div class="page-header">
              <h1 class="all-tittles">Sistema de inventario:  <small><!-- TemplateBeginEditable name="EditRegion3" -->Inicio<!-- TemplateEndEditable --></small></h1>
            </div>
        </div>
      <!-- TemplateBeginEditable name="EditRegion4" -->
      <h1>Contenidos</h1>
      <!-- TemplateEndEditable -->
      <!--finhtml-->
      
     <!--/////////////////////////////////////// Codigo del boton de ayuda /////////////////////////////////////////////////////-->
     <!--   <div class="modal fade" tabindex="-1" role="dialog" id="ModalHelp">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center all-tittles">ayuda del sistema</h4>
                </div>
                <div class="modal-body">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore dignissimos qui molestias ipsum officiis unde aliquid consequatur, accusamus delectus asperiores sunt. Quibusdam veniam ipsa accusamus error. Animi mollitia corporis iusto.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="zmdi zmdi-thumb-up"></i> &nbsp; De acuerdo</button>
                </div>
            </div>
          </div>
        </div>-->
        <footer class="footer full-reset">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <h4 class="all-tittles">Datos de la empresa</h4>
                        <p>
                           <?php 
						   
						    echo $_SESSION["nom_empresa"].'<br>';
							echo $_SESSION["dir_empresa"].'<br>';
							echo $_SESSION["tel_empresa"];
						   
						   ?>
                        </p>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <h4 class="all-tittles">Desarrollador</h4>
                        <ul class="list-unstyled">
                            <li><i class="zmdi zmdi-check zmdi-hc-fw"></i>&nbsp; copyright <i class="zmdi zmdi-facebook zmdi-hc-fw footer-social"></i><i class="zmdi zmdi-twitter zmdi-hc-fw footer-social"></i></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-copyright full-reset all-tittles">© 2017 </div>
        </footer>
    </div>
    
<script src="../php/js/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-3.1.1.min.js"><\/script>')</script>
<script src="js/modernizr.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="js/main.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
     <!--botones DataTables-->	
<script src="js/dataTables.buttons.min.js"></script>
<script src="js/buttons.bootstrap.min.js"></script>
	<!--Libreria para exportar Excel-->
<script src="js/jszip.min.js"></script>
	<!--Librerias para exportar PDF-->
<script src="js/pdfmake.min.js"></script>
<script src="js/vfs_fonts.js"></script>
	<!--Librerias para botones de exportación-->
<script src="js/buttons.html5.min.js"></script>
    <!--Librerias para pasar a español-->
<script src="js/pasar_espanol.js"></script>

<script src="../php/js/jquery.timepicker.min.js"></script>
	<!-- TemplateBeginEditable name="Codigo Script" -->Codigo Script<!-- TemplateEndEditable -->
</body>
</html>