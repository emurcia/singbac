<?PHP
ini_set('session.save_handler', 'files');
/***********esto es para cerrar sesion cuando se cierren todas las ventanas de la web**************/
//si es necesario cambiar la config. del php.ini desde tu script
ini_set("session.use_only_cookies","1");
ini_set("session.use_trans_sid","0");
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");

  $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
 $estado= $_SESSION['bandera_empresa'];
 $id_usuario=$_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
 $acceso =$_SESSION['nivel_silo'];
 $nom_sistema=$_SESSION['nom_sistema'];
 
 $peso_tara_url=$_GET['peso_bruto'];
 
 // Verificación de sesiones
 if ($_SESSION['token_ss'] != NULL) //solo si hay session activa
{
$loginSQL=mysql_query("select token from t_usuarios  where id_usuario='$id_usuario'",$con);
$fila_usu = mysql_fetch_array($loginSQL, MYSQL_ASSOC);
$fila_usu['token'];
if( $fila_usu['token'] != $_SESSION['token_ss'] )
{
	echo "<script language='javascript'>";
	echo "document.location.href='destruir_sesion.php';";
	echo "</script>";
}
} // fin de verificar sesion

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
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-datepicker.js"></script> 
<script src="../assets/javascript/chosen.jquery.js"></script>
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="../css/datepicker.css">
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link rel="stylesheet" type="text/css" href="../assets/stylesheet/chosen.css">
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
    		"sPaginationType": "full_numbers", 
			 "autoWidth": "false",
			"sScrollX":"100%"
			
	 });
});

</script>

<script type="text/javascript">
function consultar(){
			document.formulario.seleccion.value=document.formulario.id_cliente.value;
			document.formulario.bandera.value='ok';
			document.formulario.submit();
		
}// fin guardar

function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }
 
  function reporte(){
	 window.open('../reportes/Rp_agricultor.php?id='+document.formulario.reporte.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
}

function reporte_excel(){
	document.location.href='../reporteexcel/excel_agricultord.php?id1='+document.formulario.reporte.value;
			
}// fin reporte

function excel_canastas(){
	document.location.href='../reporteexcel/excel_canastas.php?id1='+document.formulario.reporte.value;
			
}// fin reporte
</script>
<script>
        $(document).ready(function(){
			$(".chosen").chosen({width: "100%", height:"100%"}); 
       });
</script>

<?php // cierre de sesion por medio del boton
	 $bandera = $_POST['bandera'];
    echo "<script language='javascript'>";
    if($bandera=="oki")
    {//inicio if bandera ok
       echo "document.location.href='sesion_destruida.php';";
	}//Fin if bandera ok
	 echo "</script>";
?> 		
 

<body class="container" > 


<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->

<?PHP include("menu.php"); ?>

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
           <div class="panel-heading"><strong>CONSULTA DE AGRICULTORES</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
          		<form action="f_rep_agricultor.php" class="formusu" method="post" name="formulario" role="form">  
        <input name="bandera" value="0" type="hidden" />     
	       <input type="hidden"  name="busca">
	       <input type="hidden"  name="seleccion">           
           <input type="hidden"  name="reporte" value="<?PHP echo $_POST['id_cliente']; ?>">
                      
             <div class="row"><!--- INICIO ROW----->
              <div class="col-md-12">
              <div class="form-group">
               <label>NOMBRE CLIENTE</label>
              <?php
              $cli="CLI-000".$id_empresa;
               if($id_usuario!='USU-0351'){
			 	
                $tabla= mysql_query("SELECT zona FROM `tab_agricultor` WHERE id_usuario_ingreso='$id_usuario' GROUP BY zona");
                   }else{
                 $tabla= mysql_query("SELECT zona FROM `tab_agricultor` GROUP BY zona");
                 }
			  		
                	//$tabla=mysql_query("SELECT zona FROM tab_agricultor WHERE id_empresa='$id_empresa' GROUP BY zona ",$con); //
				?>
                      <select name="id_cliente" class="form-control input-lg chosen" size="1" id="id_cliente">
                            <option value="TODOS">TODOS</option>
							 <?php 
								while($valor=mysql_fetch_array($tabla)){
									
									$codigo_usu= $valor['zona'];
									$nombre_usu= $valor['zona'];
									echo "<option value='$codigo_usu'>";
									echo ($nombre_usu);
									echo"</option>";  
                                    
                                  
								}	
							?>
                          </select>
                              
                  </div>
              </div>
            </div><!--- FIN ROW----->          
            
               
 <br />
 
			   <table width="220" border="0" align="right">
			   	    <tr>

              	      <td><button type="submit" name="btnguardar" onclick="consultar()" value="Consultar" class="btn btn-info btn-lg pull-right" > Consultar </button></td>
              	    </tr>
           	      </table> 
              
		</form>	
</div>
</div></div>
</div></div>



<!-- Inicia paginacion para mostrar los usuarios -->

  <div class="container-fluid">
  <div class="row" >
      <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>CONSULTA DE AGRICULTORES</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
   
<?php
if($bandera=="ok" )
   {//

 $cli="CLI-000".$id_empresa;
 $seleccion1=$_POST['seleccion']; 
               if($id_usuario!='USU-0351'){
               		if($seleccion1=="TODOS"){
 				$where1="id_empresa='$id_empresa' AND id_usuario_ingreso='$id_usuario' AND eliminado='0'";
 			}else{
	 			$where1="zona='$seleccion1' AND id_usuario_ingreso='$id_usuario' AND eliminado='0' AND id_empresa='$id_empresa' ";
	 		}
             //   $sql= "SELECT * FROM `tab_agricultor` WHERE zona='$seleccion1' AND id_usuario_ingreso='$id_usuario'";
                   }else{
                   	if($seleccion1=="TODOS"){
 				$where1="id_empresa='$id_empresa' AND eliminado='0'";
 			}else{
	 			$where1="zona='$seleccion1' AND id_empresa='$id_empresa' AND eliminado='0'";
	 		}
                   
             //    $sql= mysql_query("SELECT zona FROM `tab_agricultor` GROUP BY zona");
                 }
   
 /*
 if($seleccion1=="TODOS"){
 $where1="id_empresa='$id_empresa'";
 }else{
	 $where1="zona='$seleccion1' and id_empresa='$id_empresa'";
	 }
	*/ 
 $sql="SELECT * FROM tab_agricultor where $where1";
		            
$result = mysql_query($sql);
echo"<div class='responsive'><table width='100%' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones'>";
                           echo"<thead>                     
                              <tr> 
							
							  <th width='200px'><div align='left'><a href='#' title='Ordenar por Numero'>NUMERO</a></div></th> 
							    <th width='200px'><div align='left'><a href='#' title='Ordenar por Dui'>DUI</a></div></th>
                                <th width='250px'><div align='left'><a href='#' title='Odenar por Nombre'>NOMBRE</a></div></th>
                              <th width='250px'><div align='left'><a href='#' title='Odenar por Apellido'>APELLIDO</a></div></th>
                                                                <th width='250px'><div align='left'><a href='#' title='Odenar por Zona'>ZONA</a></div></th>
                                                                <th width='250px'><div align='left'><a href='#' title='Odenar por Oficio'>PROFESION / OFICIO</a></div></th>
                                                                <th width='250px'><div align='left'><a href='#' title='Odenar por Propiedad'>PROPIEDAD</a></div></th>                                                                
								<th width='250px'><div align='left'><a href='#' title='Odenar por Teléfono'>TELEFONO</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Creado por'>CREADO POR</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Fecha Creado'>FECHA CREADO</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Hora Creado'>HORA CREADO</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Creado por'>MODIFICADO POR</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Fecha Creado'>FECHA  MODIFICACION</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Hora Creado'>HORA MODIFICACION</a></div></th>
								      
                            </tr>
                            </thead>
           
                            <tbody>";
                    		if ($result > 0){	
                                $contar4=0;
							while ($row = mysql_fetch_assoc($result)) 
                            {	
							$contar4++;
							
							// $nivel_busca=$row['id_nivel'];
							 $usuario_busca=$row['id_usuario_ingreso'];
							 $usuario_modifica=$row['id_usuario_modifica'];							 
							 $fecha_imprime=parseDatePhp($row[fecha_ingreso]);
							 $fecha_imprime_modif=parseDatePhp($row[fecha_modifica]);
													 
							 $sql_usuario = "SELECT * FROM t_usuarios WHERE id_usuario='$usuario_busca' and id_empresa='$id_empresa'";
								$result_us = mysql_query($sql_usuario,$con);
								if ($result_us > 0){	
                               		while ($row_usuario = mysql_fetch_assoc($result_us)){
									 $nombre_usuario=$row_usuario['nombre_usuario'];
									}
								}
								
								 $sql_usuario = "SELECT * FROM t_usuarios WHERE id_usuario='$usuario_modifica' and id_empresa='$id_empresa'";
								$result_us = mysql_query($sql_usuario,$con);
								if ($result_us > 0){	
                               		while ($row_usuario = mysql_fetch_assoc($result_us)){
									 $nombre_usuario_modif=$row_usuario['nombre_usuario'];
									}
								}	
											
						
						echo"<tr>
		  						<td width='auto' align='center'>$contar4</td>						
		 						<td width='auto' align='left'> $row[dui_agricultor] </td>
                              <td width='auto' align='left'> $row[nom_agricultor] </td>
                               <td width='auto' align='left'> $row[ape_agricultor] </td>
                               <td width='auto' align='left'> $row[zona] </td>
                               <td width='auto' align='left'> $row[oficio] </td> 
                               <td width='auto' align='left'> $row[propiedad] </td>                               
                              <td width='auto' align='left'> $row[tel_agricultor] </td>			  						  
							  <td width='auto' align='left'> $nombre_usuario</td>	
							  <td width='auto' align='left'> $fecha_imprime </td>						  
							  <td width='auto' align='left'> $row[hora_ingreso] </td>
							  <td width='auto' align='left'> $nombre_usuario_modif</td>	
							  <td width='auto' align='left'> $fecha_imprime_modif </td>						  
							  <td width='auto' align='left'> $row[hora_modifica] </td>
			</tr>";
			//$contar4++;
	                         }
                            $correlativo++;	
						 echo"</tbody>
                        </table> ";
					                   
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
<?php if($contar4!=0){ ?>
 <table border="0" align="center">
 <tr>
 <td width="100"><button name="btn_reporte" onclick="reporte()" value="Imprimir" class="btn btn-info btn-lg pull-right" > Imprimir </button></td>
 <td width="20">&nbsp;</td>
 <td width="100"><button name="btn_reporte" onclick="reporte_excel()" value="Exportar" class="btn btn-info btn-lg pull-right" > Exportar</button></td>
 <td width="20">&nbsp;</td>
 <td width="100"><button name="btn_reporte" onclick="excel_canastas()" value="Canastas" class="btn btn-info btn-lg pull-right" > Exportar2</button></td>
              	    </tr>
           	      </table>  >            
<?php }?>

</div>
</div>
</div>
</div>             
                

<br>
<br>
<br>
<!--  INICIO FOOTER   -->
<?PHP include("footer.php"); ?>
<!-- FIN FOOTER  -->

</body>
</html>

<?PHP
  mysql_close();
?>