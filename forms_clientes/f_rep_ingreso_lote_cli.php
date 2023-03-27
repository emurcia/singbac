<?PHP
ini_set('session.save_handler', 'files');
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");

  $_SESSION['permiso_silo'];// = ok
 $nombre_usuario=$_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
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
 
$datos=mysql_query("SELECT * FROM tab_cliente WHERE nom_cliente='$nombre_usuario'",$con);
$array = mysql_fetch_assoc($datos);
{
	 
	 $cod_cliente=$array['id_cliente'];
	 $nom_cliente=$array['nom_cliente'];
	 $direccion_cliente=$array['dir_cliente'];
	 $telefono_cliente=$array['tel_cliente'];
	 $reponsable_cliente=$array['nom_responsable']." ".$array['ape_responsable'];
	 $direccion_responsable=$array['dir_responsable'];
	 $tel_responsable=$array['tel_resposable'];
	// $fecha_creado=parseDatePhp($array['fecha_usuario']);	 	 
	 
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
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<script src="../assets/javascript/chosen.jquery.js"></script>
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
        $(document).ready(function(){
			$(".chosen").chosen({width: "100%", height:"100%"}); 
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
	 window.open('../reportes/Rp_ingreso_lote.php?id='+document.formulario.reporte.value+'&id2='+document.formulario.fec1.value+'&id3='+document.formulario.fec2.value+'&id4='+document.formulario.lot.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
}
</script>

<?php
	$bandera = $_POST['bandera'];
    echo "<script language='javascript'>";
    if($bandera=="oki")
    {//inicio if bandera ok
	   echo "document.location.href='sesion_destruida.php';";
     }//Fin if bandera ok
	 echo "</script>";
?>
 		
 

<body class="container" <?PHP if($guarda == 2) echo "onload='datos()';"; ?> > 


<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->



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
           <div class="panel-heading"><strong>RECEPCION DE GRANOS BASICOS POR LOTE</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
          		<form action="f_rep_ingreso_lote_cli.php" class="formusu" method="post" name="formulario" role="form">  
        <input name="bandera" value="0" type="hidden" />     
	       <input type="hidden"  name="busca">
	       <input type="hidden"  name="seleccion">   
	       <input type="hidden"  name="id_lote_buscar">                    
            <input type="hidden" name="fecha_inicio11">
            <input type="hidden" name="fecha_fin11">  
            <input type="hidden"  name="id_cliente2" value="<?PHP echo $cod_cliente; ?>">
 			<input type="hidden"  name="reporte" value="<?PHP echo $cod_cliente; ?>">
            <input type="hidden"  name="fec1" value="<?PHP echo $_POST['fec_inicio']; ?>">           
            <input type="hidden"  name="fec2" value="<?PHP echo $_POST['fec_fin']; ?>"> 
            <input type="hidden"  name="lot" value="<?PHP echo $_POST['id_lote2']; ?>">                        
             <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label>NOMBRE CLIENTE</label>
             <input type="text" class="form-control input-lg" id="nom_cliente" placeholder="CLIENTE" name="nom_cliente" value="<?PHP echo $nom_cliente;?>" readonly style="background:#FFF;"> 
                  </div>
              </div>
           
				 <div class="col-md-6">
               <div class="form-group">
               <label for="moneda_servicio">LOTE</label>
                  <?php
						// $id_cli="CLI-000".$id_empresa;
						$tabla=mysql_query("SELECT * FROM tab_detalle_servicio WHERE id_cliente = '".$cod_cliente."' and id_empresa='".$id_empresa."' and bandera='0' group by id_lote;",$con);
						 //      $tabla=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente!='CLI-000'");
						  ?>
                      <select name="id_lote2" class="form-control input-lg chosen" size="1" id="id_lote2">
                           		 <?php 
								while($valor=mysql_fetch_array( $tabla)){
									$codigo_cliente= $valor['id_lote'];
									$nombre_cliente= $valor["num_lote"];
									echo "<option value='$codigo_cliente'>";
									echo ("$nombre_cliente");
									echo"</option>";
								}	
							?>
                          </select>
                  </div>
              </div>      
            </div> <!-- fin -->
                <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label>FECHA INICIO</label>
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
</div>
</div>

<!-- Inicia paginacion para mostrar los usuarios -->

  <div class="container-fluid">
  <div class="row" >
      <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>RECEPCION DE GRANOS BASICOS POR LOTE</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 				<div>


                
<?php
						
 if($bandera=="ok" )
   {//
 $seleccion1=$_POST['seleccion'];
 $lote_busca=$_POST['id_lote_buscar'];  
 $fecha_inicio_buscar = parseDateMysql($_POST['fecha_inicio11']);
 $fecha_fin_buscar = parseDateMysql($_POST['fecha_fin11']);
 
 $sql = "SELECT a.*, b.*, c.* FROM tab_almacenaje as a, tab_cliente as b, tab_lote as c WHERE a.id_cliente=b.id_cliente and a.id_lote=c.id_lote and a.id_cliente='$seleccion1' and a.id_lote='$lote_busca' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and a.id_empresa='$id_empresa'";		  
//		  }
		            
						 $result = mysql_query($sql);
                       echo"<div class='table'><table width='100%' style='table-layout:fixed' align='center' cellpadding='0' cellspacing='0' class=' display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>            
                                <th width='130px'><div align='left'><a href='#' title='Ordenar por Número'>NUMERO</a></th>
                                <th width='250px'><div align='left'><a href='#' title='Ordenar por Cliente'>CLIENTE</a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Ordenar por Producto'>PRODUCTO</a></div></th>
                                <th width='250px'><div align='left'><a href='#' title='Ordenar por Nombre'>SUBPRODUCTO</a></div></th>
								<th width='170px'><div align='left'><a href='#' title='Ordenar por Peso'>PESO NETO</a></div></th>
                               
								<th width='170px'><div align='left'><a href='#' title='Odenar por Fecha entrada'>FECHA ENTRADA </a></div></th>
								<th width='160px'><div align='left'><a href='#' title='Odenar por Hora entrada'>HORA ENTRADA </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Fecha salida'>FECHA SALIDA </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Hora salida'>HORA SALIDA </a></div></th>
								      
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
						      <td width='120px' align='center'>$contar4</td>	   
                              <td width='235px' align='left'> $row[nom_cliente] </td>
                              <td width='235px' align='left'> $nom_producto1</td>							 
                              <td width='235px' align='left'> $nom_subproducto1 </td>
							  <td width='170px' align='left'> $peso_neto1 </td>
                              <td width='170px' align='left'> $fecha_entrada1</td>
                              <td width='170px' align='left'> $hora_entrada1 </td>	
							  <td width='170px' align='left'> $fecha_salida1</td>
                              <td width='170px' align='left'> $hora_salida1 </td>							  
							  
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
</div>
              
                

<br>
<br>
<br>
<!--  INICIO FOOTER   -->
<div class="navbar navbar-inverse navbar-fixed-bottom" >
    <div class="container">
      <p style="text-align:center; color:#FFF; font-style:oblique;">
         Diseñado y Desarrollado Por <a style="color:#FFF; font-weight:bold" href="http://www.ie-networks.com/" target="_blank">Ie Networks</a> © 2017
      </p>
   </div>
</div>
<!-- FIN FOOTER  -->

</body>
</html>

<?PHP
  mysql_close();
?>