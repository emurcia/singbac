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
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<title><?PHP echo $nom_sistema; ?></title> 
 
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="../css/datepicker.css">
<script src="https://code.jquery.com/jquery.js"></script> 
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-datepicker.js"></script> 

<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 

<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<!--script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script-->
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
    		"sPaginationType": "full_numbers",
			  "sScrollX": "true"
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
	 window.open('../reportes/Rp_salida_calidad.php?id='+document.formulario.reporte.value+'&id2='+document.formulario.fec1.value+'&id3='+document.formulario.fec2.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
}
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
           <div class="panel-heading"><strong>REPORTE DE SALIDA DE PRODUCTOS - CONTROL DE CALIDAD</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
          		<form action="f_rep_calidad.php" class="formusu" method="post" name="formulario" role="form">  
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
                	$tabla=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente!='CLI-000' and id_empresa='$id_empresa' ",$con); //
				?>
                      <select name="id_cliente" class="form-control input-lg" size="1" id="id_cliente">
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
              <div class="col-md-12">
              <div class="form-group">
               <label>FECHA NICIO</label>
                <input type="text" class="form-control input-lg datepicker" id="fec_inicio" placeholder="Fecha" name="fec_inicio" value="<?PHP echo $fecha; ?>" readonly style="background:#FFF;">
              </div>
              </div>
            </div><!--- FIN ROW-----> 
            
             <div class="row"><!--- INICIO ROW----->
              <div class="col-md-12">
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
           <div class="panel-heading"><strong>SALIDA DE PRODUCTOS - CONTROL DE CALIDAD</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 				<div>


                
<?php
						
 if($bandera=="ok" )
   {//
 $seleccion1=$_POST['seleccion']; 
 $fecha_inicio_buscar = parseDateMysql($_POST['fecha_inicio11']);
 $fecha_fin_buscar = parseDateMysql($_POST['fecha_fin11']);

 $sql = "SELECT a.*, b.* FROM tab_salida as a, tab_cliente as b WHERE a.id_cliente=b.id_cliente and a.id_cliente='$seleccion1' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and a.peso_bruto!=0  and a.bandera=2 and a.id_empresa='$id_empresa'";		  
//		  }
		            
						 $result = mysql_query($sql);
                       echo"<div class='responsive' style='overflow:scroll;height:auto;width:auto;'><table width='96%' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>            
                                <th width='0%'>&nbsp;</th>
                                <th width='2%'><div align='left'><a href='#' title='Ordenar por Número'>NUMERO</a></th>
                                <th width='45%'><div align='left'><a href='#' title='Ordenar por Cliente'>CLIENTE</a></div></th>
								<th width='35%'><div align='left'><a href='#' title='Ordenar por Producto'>PRODUCTO</a></div></th>
                                <th width='35%'><div align='left'><a href='#' title='Ordenar por Nombre'>SUBPRODUCTO</a></div></th>
           						<th width='auto'><div align='left'><a href='#' title='Ordenar por Lote'>NUMERO DE LOTE</a></div></th>                    
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
							$id_lote1=$row['id_lote'];
							//$id_producto1=$row['id_producto'];
							//$id_subproducto1=$row['id_subproducto'];
							$fecha_entrada1=parseDatePhp($row['fecha_entrada']);	
							$hora_entrada1=$row['hora_entrada'];
							$fecha_salida1=parseDatePhp($row['fecha_salida']);	
							$hora_salida1=$row['hora_salida'];													
							
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
                              <td width='auto' align='left'> $num_lote1 </td>							  
                              <td width='auto' align='left'> $fecha_entrada1</td>
                              <td width='auto' align='left'> $hora_entrada1 </td>	
							  <td width='auto' align='left'> $fecha_salida1</td>
                              <td width='auto' align='left'> $hora_salida1 </td>							  
							  
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
 <td width="100"><button name="btn_reporte" onclick="reporte()" value="Imprimir" class="btn btn-info btn-lg pull-right" > Imprimir </button></td>
 <td width="20">&nbsp;</td>
 <td width="100"><button name="btn_reporte" onclick="reporte_excel()" value="Exportar" class="btn btn-info btn-lg pull-right" > Exportar</button></td>
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