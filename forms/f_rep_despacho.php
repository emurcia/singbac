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
 $nom_cliente=$_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
 $estado= $_SESSION['bandera_empresa'];
 $id_usuario=$_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
 $acceso =$_SESSION['nivel_silo'];
 $nom_sistema=$_SESSION['nom_sistema'];
  
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

// EXTRAER EL CODIGO DEL CLIENTE
$nomSQL=mysql_query("select id_cliente from tab_cliente where nom_cliente='$nom_cliente'",$con);
$fila_nom = mysql_fetch_array($nomSQL, MYSQL_ASSOC);
$cod_usuario_cliente=$fila_nom['id_cliente']; 
 
date_default_timezone_set("America/El_Salvador");
$ano=date('Y');
$fecha=date('d').'/'.date('m').'/'.date('Y');
$hora=date("H:i:s");
?>

<!DOCTYPE html> 
<html> 
<head> 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-datepicker.js"></script> 
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<script src="../assets/javascript/chosen.jquery.js"></script>
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css"> 

<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="../css/datepicker.css">
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
			"sScrollX":"100%"
	 });
});

</script>

<script type="text/javascript">
function consultar(){
			document.formulario.fecha_inicio11.value=document.formulario.fec_inicio.value;
			document.formulario.fecha_fin11.value=document.formulario.fec_fin.value;			
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
	 window.open('../reportes/Rp_despacho_granos.php?id='+document.formulario.reporte.value+'&id2='+document.formulario.fec1.value+'&id3='+document.formulario.fec2.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
}
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
           <div class="panel-heading"><strong>DESPACHO DE GRANOS BASICOS</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
          		<form action="f_rep_despacho.php" class="formusu" method="post" name="formulario" role="form">  
        <input name="bandera" value="0" type="hidden" />     
	       <input type="hidden"  name="busca">
	       <input type="hidden"  name="seleccion">           
            <input type="hidden" name="fecha_inicio11">
            <input type="hidden" name="fecha_fin11">  
 			<input type="hidden"  name="reporte" value="<?PHP echo $_POST['id_cliente']; ?>">
            <input type="hidden"  name="fec1" value="<?PHP echo $_POST['fec_inicio']; ?>">           
            <input type="hidden"  name="fec2" value="<?PHP echo $_POST['fec_fin']; ?>">            
             <div class="row"><!--- INICIO ROW----->
              <div class="col-md-12">
              <div class="form-group">
               <label>NOMBRE CLIENTE</label>
              <?php
                	if($cod_usuario_cliente==""){
			  	$cli="CLI-000".$id_empresa;
                $tabla=mysql_query("SELECT id_cliente, nom_cliente FROM tab_cliente WHERE id_cliente!='$cli' and id_empresa='$id_empresa' ",$con); //
			  }else{
					$tabla=mysql_query("SELECT cl.id_cliente, cl.nom_cliente FROM tab_cliente as cl join tab_detalle_cliente as decl on cl.id_cliente=decl.id_cliente_secundario where decl.id_cliente_principal='$cod_usuario_cliente' and decl.id_empresa='$id_empresa' ",$con); //
			  }

				?>
                      <select name="id_cliente" class="form-control input-lg chosen" size="1" id="id_cliente">
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
            </div><!--- FIN ROW----->          
            
                <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label>FECHA INICIO</label>
                <input type="text" class="form-control input-lg datepicker" id="fec_inicio" placeholder="Fecha" name="fec_inicio" value="<?PHP echo $fecha;?>" readonly style="background:#FFF;">
              </div>
              </div>
      
              <div class="col-md-6">
              <div class="form-group">
               <label>FECHA FIN</label>
                <input type="text" class="form-control input-lg datepicker" id="fec_fin" placeholder="Fecha" name="fec_fin" value="<?PHP echo $fecha;?>" readonly style="background:#FFF;">
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
</div></div>
<!-- Inicia paginacion para mostrar los usuarios -->

  <div class="container-fluid">
  <div class="row" >
      <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>DESPACHO DE GRANOS BASICOS</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 				<div>


                
<?php
						
 if($bandera=="ok" )
   {//
 $seleccion1=$_POST['seleccion']; 
 $fecha_inicio_buscar = parseDateMysql($_POST['fecha_inicio11']);
 $fecha_fin_buscar = parseDateMysql($_POST['fecha_fin11']);

 $sql = "SELECT a.*, b.* FROM tab_salida as a, tab_cliente as b WHERE a.id_cliente=b.id_cliente and a.id_cliente='$seleccion1' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and a.peso_tara!=0  and a.bandera=2 and a.id_empresa='$id_empresa'";		  
//		  }
		            
						 $result = mysql_query($sql);
                       echo"<div class='responsive' style='overflow:scroll;height:auto;width:auto;'><table width='auto' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>            
                                <th width='0%'>&nbsp;</th>
                                <th width='2%'><div align='left'><a href='#' title='Ordenar por Número'>NUMERO</a></th>
                                <th width='35%'><div align='left'><a href='#' title='Ordenar por Cliente'>CLIENTE</a></div></th>
								<th width='auto'><div align='left'><a href='#' title='Ordenar por Producto'>PRODUCTO</a></div></th>
                                <th width='25%'><div align='left'><a href='#' title='Ordenar por Nombre'>SUBPRODUCTO</a></div></th>
                               
								<th width='auto'><div align='left'><a href='#' title='Odenar por Fecha entrada'>FECHA ENTRADA </a></div></th>
								
								<th width='auto'><div align='left'><a href='#' title='Odenar por Fecha salida'>FECHA SALIDA </a></div></th>
								
								<th width='auto'><div align='left'><a href='#' title='Odenar por Hora Bruto'>BRUTO (KG) </a></div></th>      
								<th width='auto'><div align='left'><a href='#' title='Odenar por Hora Tara'>TARA (KG) </a></div></th>
								<th width='auto'><div align='left'><a href='#' title='Odenar por Hora salida'>NETO (KG)</a></div></th>
                            </tr>
                            </thead>
                            <tbody>";
                    		if ($result > 0){	
                                $correlativo1 = 1;
                                $contar4=0;
							while ($row = mysql_fetch_assoc($result)) 
                            {	
							$contar4++;
							$id_lote1=$row['id_lote'];
							//$id_producto1=$row['id_producto'];
							//$id_subproducto1=$row['id_subproducto'];
							$fecha_entrada1=parseDatePhp($row['fecha_entrada']);	
							$hora_entrada1=$row['hora_entrada'];
							$fecha_salida1=parseDatePhp($row['fecha_salida']);	
							$hora_salida1=$row['hora_salida'];	
							$peso_bruto1=$row['peso_bruto'];
							$peso_tara1=$row['peso_tara'];
							$peso_neto1=$peso_bruto1-$peso_tara1;												
							
							$lote=mysql_query("SELECT * FROM tab_lote WHERE id_lote='$id_lote1' and id_empresa='$id_empresa'");
						  	while($row_lote = mysql_fetch_array($lote)){
							  $num_lote1=$row_lote['num_lote'];
							  $id_lote2=$row_lote['id_lote'];
						//	$nom_producto1=$row_producto['nom_producto'];
							 
						//	$id_cliente=$row['id_cliente'];
							$id_producto1=$row_lote['id_producto'];
							$id_subproducto1=$row_lote['id_subproducto'];
							
							
						$producto=mysql_query("SELECT * FROM tab_producto WHERE id_producto='$id_producto1' and id_empresa='$id_empresa'");
						  while($row_producto = mysql_fetch_array($producto)){
							$nom_producto1=$row_producto['nom_producto'];	
							
								$subproducto=mysql_query("SELECT * FROM tab_subproducto WHERE id_subproducto='$id_subproducto1' and id_empresa='$id_empresa'");
								 while($row_subproducto = mysql_fetch_array($subproducto)){
								$nom_subproducto1=$row_subproducto['nom_subproducto'];		
										
                            echo"<tr>
							
                            <td width='0%' align='center'></td>
                            <td width='0%' align='center'>$contar4</td>	   
                             <td width='auto' align='left'> $row[nom_cliente] </td>
                              <td width='auto' align='left'> $nom_producto1</td>							 
                              <td width='auto' align='left'> $nom_subproducto1 </td>
                              <td width='auto' align='left'> $fecha_entrada1</td>
							  <td width='auto' align='left'> $fecha_salida1</td>
                              <td width='auto' align='left'> $peso_bruto1 </td>	
                              <td width='auto' align='left'> $peso_tara1 </td>	
                              <td width='auto' align='left'> $peso_neto1 </td>							  						  						  							  
							  
                            </tr>";
                        
                            }
						  }
						}
							
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
<?PHP include("footer.php"); ?>
<!-- FIN FOOTER  -->

</body>
</html>

<?PHP
  mysql_close();
?>