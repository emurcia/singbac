<?PHP
ini_set('session.save_handler', 'files');
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");

 $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
 $estado= $_SESSION['bandera_empresa'];
 $_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
 $acceso =$_SESSION['nivel_silo'];
 $nom_sistema=$_SESSION['nom_sistema'];

if($_SESSION['permiso_silo']!='ok'){
	echo "<script language='javascript'>";
	echo "document.location.href='../index.php';";
	echo "</script>";
}
 
date_default_timezone_set("America/El_Salvador");
$ano=date('Y');
$fecha=date('d').'/'.date('m').'/'.date('Y');
$hora=date("H:i:s");
?>

<!DOCTYPE html> 
<html> 
<head > 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="../css/datepicker.css">
<script src="http://code.jquery.com/jquery.js"></script> 
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-datepicker.js"></script> 
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link href="../images/favicon.ico" rel="icon">

</head> 
<script>
$(function (){
	$('.datepicker').datepicker({
		format: 'dd-mm-yyyy', viewMode: 0  //0: dias, 1: meses, 2:años
	})
				.on('changeDate', function(ev){
					
					$('.datepicker').datepicker('hide');
				});
});

</script>

<script>
 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones').dataTable( {
    		"sPaginationType": "full_numbers"
	 });
});

</script>

<script type="text/javascript">
function cancelar(){
	document.formulario.btnguardar.disabled=false;
	}
	

function consultar(){
			document.formulario.fecha_inicio11.value=document.formulario.fec_inicio.value;
			document.formulario.fecha_fin11.value=document.formulario.fec_fin.value;			
			document.formulario.seleccion.value=document.formulario.id_cliente2.value;
			document.formulario.id_lote_buscar.value=document.formulario.id_lote2.value;			
			document.formulario.bandera.value='ok';
			document.formulario.submit();
		
}// fin guardar

function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }
 
  function reporte(){
	 window.open('../reportes/Rp_despacho_lote.php?id='+document.formulario.reporte.value+'&id2='+document.formulario.fec1.value+'&id3='+document.formulario.fec2.value+'&id4='+document.formulario.lot.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
}
</script>

<script type="text/javascript">
       $(document).ready(function() {
	  
		   $('#id_cliente2').change(function() {//inicio1
			 $.post('lote_select.php', {id_cliente_busca:document.formulario.id_cliente2.value}, 
			 function(result) {
				$('#feedback').html(result).show();	
			 }); 									 
		  });//fin1
		 		  
       });
  </script>
<?php
	$bandera = $_POST['bandera'];
    echo "<script language='javascript'>";
    if($bandera=="oki")
    {//inicio if bandera ok
	   //$stringEjecucion = mysql_query ("insert into t_bitacora(id_usu,entradaBitacora,horaBitacora,diaBitacora) values ('$id_empleado','0',CURTIME(),CURDATE());",$conexion);			
 	   session_unset();
	   session_destroy();     
       echo "document.location.href='../index.php';";
     }//Fin if bandera ok
	 echo "</script>";
?>
 		
 

<body class="container" <?PHP if($guarda == 2) echo "onload='datos()';"; ?> > 


<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->

<nav class="navbar navbar-inverse navbar-fixed-top"  role="navigation">
  <!-- El logotipo y el icono que despliega el menú se agrupan
       para mostrarlos mejor en los dispositivos móviles -->
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse"
            data-target=".navbar-ex1-collapse">
      <span class="sr-only">Desplegar navegación</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
  </div>

 
    <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
   
   <!-- menu -->
     <ul id="menu-bar">
     <?PHP
      $indicadorul = 0;
      $indicadorli = 1;
     // $consulta = mysql_query("SELECT * FROM tab_menu",$con);
	 $consulta = mysql_query("SELECT a.opcion_menu, a.url_menu, a.acceso_menu, a.nivel_menu FROM tab_menu as a, tab_detalle_menu as b, t_empresa as c WHERE a.id_menu=b.id_menu and b.id_nivel='".$acceso."' and b.id_empresa='$id_empresa' and c.estado='$estado' GROUP by a.id_menu ",$con);
      while($fila = mysql_fetch_array($consulta)){
          if((($fila['acceso_menu']==0) || ($fila['acceso_menu']==$acceso)) && (!empty($acceso))){
              if(($fila['nivel_menu']==2) && ($indicadorul==0)){  echo "<ul class='dropdown-menu'>"; $indicadorul=1; }
              if(($fila['nivel_menu']==1) && ($indicadorul==1)){  echo "</ul>"; $indicadorul=0; }
              
              if(($fila['nivel_menu']==1) && ($indicadorli == 0)){echo "</li>";$indicadorli=1;}
               
              if($fila['id_menu']==1)//Menu de inicio(index.php) debe de ir sin 'forms/'
                  echo "<li><div align='left'><a  href='../".utf8_encode($fila['url_menu'])."'>".utf8_encode($fila['opcion_menu'])."</div></a></li>";
              else{
                  if($fila['nivel_menu']==2)
                      echo "<li><a href='".utf8_encode($fila['url_menu'])."'><div align='left'>".utf8_encode($fila['opcion_menu'])."</div></a></li>";
                  else{
                      echo "<li><a href='".utf8_encode($fila['url_menu'])."'><div align='left'>".utf8_encode($fila['opcion_menu'])."</div></a>";
                      $indicadorli = 0;
                  }			  
              }
          }
      }
	  
	  
      echo "</li>";
		  
     ?>

       

      <li><a><?PHP echo $_SESSION['nombre_usuario_silo']; ?></a></li>
      <li><a onClick="salirr()"><button type="button" class="btn btn-danger btn-xs">Cerrar Sesión</button></a></li>
          
</ul>
    </div>
    
</nav>

<!-----fin menu ---->
<!-----fin menu ---->
<!-----fin menu ---->
<!-----fin menu ---->




<!--   INICIO CUERPO   -->
<!--   INICIO CUERPO   -->
<!--   INICIO CUERPO   -->
<!--   INICIO CUERPO   -->
<br><br><br><br>

  <div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>DESPACHO DE GRANOS BASICOS POR LOTE</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
          		<form action="f_rep_despacho_lote.php" class="formusu" method="post" name="formulario" role="form">  
        <input name="bandera" value="0" type="hidden" />     
	       <input type="hidden"  name="busca">
	       <input type="hidden"  name="seleccion">   
	       <input type="hidden"  name="id_lote_buscar">                    
            <input type="hidden" name="fecha_inicio11">
            <input type="hidden" name="fecha_fin11">  
 			<input type="hidden"  name="reporte" value="<?PHP echo $_POST['id_cliente2']; ?>">
            <input type="hidden"  name="fec1" value="<?PHP echo $_POST['fec_inicio']; ?>">           
            <input type="hidden"  name="fec2" value="<?PHP echo $_POST['fec_fin']; ?>"> 
            <input type="hidden"  name="lot" value="<?PHP echo $_POST['id_lote2']; ?>">                        
             <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label>NOMBRE CLIENTE</label>
              <?php
                	$tabla=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente!='CLI-000' and id_empresa='$id_empresa'",$con); //
				?>
                      <select name="id_cliente2" class="form-control input-lg" size="1" id="id_cliente2">
                            <option value="TODOS">SELECCIONE CLIENTE</option>
							 <?php 
								while($valor=mysql_fetch_array($tabla)){
									
									$codigo_usu= $valor['id_cliente'];
									$nombre_usu= $valor['nom_cliente'];
									echo "<option value='$codigo_usu'>";
									echo ($nombre_usu);
									echo"</option>";  
                                    
                                  
								}	
							?>
                          </select>
                              
                  </div>
              </div>
           
				 <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">LOTE</label>
                <div id="feedback"><select name="id_lote2" id="id_lote2" style="width:100%; border: 1px solid #ddd; height: 46px; outline: 0; border-radius: 4px;"><option value="">SELECCIONE LOTE</option></select></div>
                  </div>
              </div>      
            </div> <!-- fin -->
                <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label>FECHA NICIO</label>
                <input type="text" class="form-control input-lg datepicker" id="fec_inicio" placeholder="Fecha" name="fec_inicio" value="<?PHP echo $fecha; ?>" readonly style="background:#FFF;">
              </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label>FECHA FIN</label>
                <input type="text" class="form-control input-lg datepicker" id="fec_fin" placeholder="Fecha" name="fec_fin" value="<?PHP echo $fecha; ?>" readonly style="background:#FFF;">
              </div>
              </div>
            </div><!--- FIN ROW-----> 
 
 <br />
 
			   <table width="220" border="0" align="right">
                  
                  
				   	    <tr>

              	      <td><input type="submit" name="btnguardar" onclick="consultar()" value="Consultar" class="btn btn-info btn-lg pull-right" > </button></td>
              	    </tr>
           	      </table> 
              
		</form>	
</div>

</div></div>


</div>
<!-- Inicia paginacion para mostrar los usuarios -->

  <div class="container-fluid">
  <div class="row" >
      <div class="col-md-12">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>DESPACHO DE GRANOS BASICOS POR LOTE</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 				<div>


                
<?php
						
 if($bandera=="ok" )
   {//
 $seleccion1=$_POST['seleccion'];
 $lote_busca=$_POST['id_lote_buscar'];  
 $fecha_inicio_buscar = parseDateMysql($_POST['fecha_inicio11']);
 $fecha_fin_buscar = parseDateMysql($_POST['fecha_fin11']);
 
 $sql = "SELECT a.*, b.*, c.* FROM tab_salida as a, tab_cliente as b, tab_lote as c WHERE a.id_cliente=b.id_cliente and a.id_lote=c.id_lote and a.id_cliente='$seleccion1' and a.id_lote='$lote_busca' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and a.id_empresa='$id_empresa'";		  
//		  }
		            
						 $result = mysql_query($sql);
                       echo"<div class='responsive' style='overflow:scroll;height:auto;width:auto;'><table width='98%' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>            
                                
                                <th width='2%'><div align='left'><a href='#' title='Ordenar por Número'>NUMERO</a></th>
                                <th width='50%'><div align='left'><a href='#' title='Ordenar por Cliente'>CLIENTE</a></div></th>
								<th width='40%'><div align='left'><a href='#' title='Ordenar por Producto'>PRODUCTO</a></div></th>
                                <th width='25%'><div align='left'><a href='#' title='Ordenar por Nombre'>SUBPRODUCTO</a></div></th>
                               <th width='25%'><div align='left'><a href='#' title='Ordenar por Peso'>PESO BRUTO</a></div></th>
								<th width='auto'><div align='left'><a href='#' title='Odenar por Fecha entrada'>FECHA ENTRADA </a></div></th>
								<th width='auto'><div align='left'><a href='#' title='Odenar por Hora entrada'>HORA ENTRADA </a></div></th>
								<th width='auto'><div align='left'><a href='#' title='Odenar por Fecha salida'>FECHA SALIDA </a></div></th>
								<th width='auto'><div align='left'><a href='#' title='Odenar por Hora salida'>HORA SALIDA </a></div></th>
								      
                            </tr>
                            </thead>
                            <tbody>";
                    		if ($result > 0){	
                                $correlativo1 = 1;
                                $contar4=0;
							while ($row = mysql_fetch_assoc($result)) 
                            {	
							$contar4++;
							$id_producto1=$row['id_producto'];
							$id_subproducto1=$row['id_subproducto'];
							$fecha_entrada1=parseDatePhp($row['fecha_entrada']);	
							$hora_entrada1=$row['hora_entrada'];
							$fecha_salida1=parseDatePhp($row['fecha_salida']);	
							$hora_salida1=$row['hora_salida'];
							$peso_bruto1=$row['peso_bruto'];
							$peso_tara1=$row['peso_tara'];
							$peso_neto1=$peso_bruto1-$peso_tara1;																							
							
							$tabla2="SELECT *  FROM tab_producto where id_producto='$id_producto1' and id_empresa='$id_empresa'";
							$select2 = mysql_query($tabla2,$con);
							while($row2 = mysql_fetch_array($select2))
							{
								$nom_producto1=$row2['nom_producto'];
							}
							$tabla3="SELECT *  FROM tab_subproducto where id_subproducto='$id_subproducto1' and id_empresa='$id_empresa'";
							$select3 = mysql_query($tabla3,$con);
							while($row3 = mysql_fetch_array($select3))
							{
								$nom_subproducto1=$row3['nom_subproducto'];
							}							
									
										
                            echo"<tr>
							
                            
                            <td width='0%' align='center'>$contar4</td>	   
                             <td width='auto' align='left'> $row[nom_cliente] </td>
                              <td width='auto' align='left'> $nom_producto1</td>							 
                              <td width='auto' align='left'> $nom_subproducto1 </td>
							  <td width='auto' align='left'> $peso_neto1 </td>
                              <td width='auto' align='left'> $fecha_entrada1</td>
                              <td width='auto' align='left'> $hora_entrada1 </td>	
							  <td width='auto' align='left'> $fecha_salida1</td>
                              <td width='auto' align='left'> $hora_salida1 </td>							  
							  
                            </tr>";
                        
                            }
							
                            $correlativo++;		
                    
                            echo"</tbody>
                        </table>
						
                        ";
					                   
                    }
                    
                    
                    
                        ?>
    <!--Fin si se ha seleccionado administrador-->

					<?php

					echo "Total de Registros" ." ".$contar4;
					 }//fin bandera ok
					 
					 
					?>
  
</div>
</div>
</div>
</div>
</div>
</div>
</div>  
<?php if($contar4!=0){ ?>
 <table border="0" align="center">
 <tr>
 <td><button name="btn_reporte" onclick="reporte()" value="Imprimir" class="btn btn-info btn-lg pull-right" > Imprimir </button></td>
              	    </tr>
           	      </table>            
<?php }?>

</div>
</div>
              
                

<br>
<br>
<br>
<!--  INICIO FOOTER   -->
<div class="navbar navbar-inverse navbar-fixed-bottom" >
   <div class="container">
      <p align="center" class="navbar-text">
         Diseñado y Desarrollado Por <a href="http://www.ie-networks.com/">Ie Networks</a> © 2017.
      </p>
   </div>
</div>
<!-- FIN FOOTER  -->

</body>
</html>

<?PHP
  mysql_close();
?>