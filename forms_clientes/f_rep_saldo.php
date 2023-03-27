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
			//document.formulario.id_lote_buscar.value=document.formulario.id_lote2.value;			
			document.formulario.bandera.value='ok';
			document.formulario.submit();
		
}// fin guardar

function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }
 
  function reporte(){
	 window.open('../reportes/Rp_saldo_lote.php?id='+document.formulario.reporte.value+'&id2='+document.formulario.fec1.value+'&id3='+document.formulario.fec2.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
}
</script>
<script>
        $(document).ready(function(){
			$(".chosen").chosen({width: "100%", height:"100%"}); 
       });
</script> 
<?php
	$bandera = $_POST['bandera'];
    echo "<script language='javascript'>";
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
           <div class="panel-heading"><strong>SALDO POR LOTE</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           <form action="f_rep_saldo.php" method="post" name="formulario" role="form">  
           <input name="bandera" value="0" type="hidden" />     
	       <input type="hidden"  name="busca">
	       <input type="hidden"  name="seleccion">   
	        <input type="hidden" name="fecha_inicio11">
            <input type="hidden" name="fecha_fin11">  
 			<input type="hidden"  name="reporte" value="<?PHP echo $_POST['id_cliente2']; ?>">
            <input type="hidden"  name="fec1" value="<?PHP echo $_POST['fec_inicio']; ?>">           
            <input type="hidden"  name="fec2" value="<?PHP echo $_POST['fec_fin']; ?>"> 
                    
             <div class="row"><!--- INICIO ROW----->
              <div class="col-md-12">
              <div class="form-group">
               <label>NOMBRE CLIENTE</label>
              <?php
			  $cli="CLI-000".$id_empresa;
                	$tabla=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente!='$cli' and id_empresa='$id_empresa'",$con); //
				?>
                      <select name="id_cliente2" class="form-control input-lg chosen" size="1" id="id_cliente2">
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
         	      <td><button type="button" name="btnguardar" onclick="consultar()" value="Consultar" class="btn btn-info btn-lg pull-right" > Consultar </button></td>
              	    </tr>
           	      </table> 
              
		</form>	
</div>
</div>
</div>
</div>
</div>

<!-- Inicia paginacion para mostrar los usuarios -->

  <div class="container-fluid">
  <div class="row" >
      <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>DESPACHO DE GRANOS BASICOS POR LOTE</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 				
         
<?php
						
 if($bandera=="ok" )
   {//
 $seleccion1=$_POST['seleccion'];
// $lote_busca=$_POST['id_lote_buscar'];  
 $fecha_inicio_buscar = parseDateMysql($_POST['fecha_inicio11']);
 $fecha_fin_buscar = parseDateMysql($_POST['fecha_fin11']);
$lot="LOT-0000000".$id_empresa;
$sql = "SELECT  (a.peso_bruto-a.peso_tara) as neto_almacenaje, l.num_lote, (s.peso_bruto-s.peso_tara) as neto_salida, c.nom_cliente, t.placa_vehiculo, k.fecha, k.hora FROM tab_kardex as k 
JOIN tab_almacenaje as a 
ON a.id_almacenaje=k.id_almacenaje
JOIN tab_salida AS s
ON s.id_salida=k.id_salida
JOIN tab_lote AS l
ON (a.id_lote=l.id_lote OR s.id_lote=l.id_lote)
JOIN tab_cliente AS c
on (a.id_cliente=c.id_cliente OR s.id_cliente=c.id_cliente)
JOIN tab_transportista AS t
ON (t.id_transportista=a.id_almacenaje OR t.id_transportista=s.id_transportista)
WHERE l.id_lote!='$lot' AND (k.fecha>='$fecha_inicio_buscar' AND k.fecha<='$fecha_fin_buscar') AND c.id_cliente='$seleccion1' AND k.id_empresa=$id_empresa
ORDER BY l.num_lote ASC, k.fecha ASC, k.hora ASC";
 
					 $result = mysql_query($sql,$con);
                       echo"<div class='responsive' style='overflow:scroll;height:auto;width:auto;'><table width='98%' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>            
                                
                                <th width='50px'><div align='left'><a href='#' title='Ordenar por Número'>NUMERO</a></th>
                                <th width='100px'><div align='left'><a href='#' title='Ordenar por Lote'>LOTE</a></div></th>
								<th width='350px'><div align='left'><a href='#' title='Ordenar por Cliente'>CLIENTE / EMPRESA</a></div></th>
                                <th width='150px'><div align='left'><a href='#' title='Ordenar por Placa'>PLACA</a></div></th>
                               	<th width='200px'><div align='left'><a href='#' title='Odenar por Entrada'>ENTRADA (KG) </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Salida'> SALIDA (KG) </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Fecha '>FECHA </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Hora '>HORA </a></div></th>
								      
                            </tr>
                            </thead>
                            <tbody>";
                    		if ($result > 0){	
                                $correlativo1 = 1;
                                $contar4=0;
							while ($row = mysql_fetch_assoc($result)) 
                            {	
							$contar4++;
							$fecha2=parseDatePhp($row['fecha']);
										
                            echo"<tr>
							
                          
                            <td width='auto' align='center'>$contar4</td>	   
                             <td width='auto' align='left'> $row[num_lote] </td>
                              <td width='auto' align='left'> $row[nom_cliente] </td>							 
                             <td width='auto' align='left'> $row[placa_vehiculo] </td>
                             <td width='auto' align='left'> $row[neto_almacenaje] </td>
                              <td width='auto' align='left'> $row[neto_salida] </td>	
							  <td width='auto' align='left'> $fecha2 </td>
                              <td width='auto' align='left'> $row[hora] </td>							  
							  
                            </tr>";
                        
                            }
							
                            $correlativo++;		
                    
                            echo"</tbody> </table>";
					                   
                    }
                   ?>
    <!--Fin si se ha seleccionado administrador-->

					<?php

					echo "Total de Registros" ." ".$contar4;
					

					 }//fin bandera ok
					 
					 
					?>
  
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
</div>
              
                

<br>
<br>
<br>
<!--  INICIO FOOTER   -->
<?PHP include("footer.php"); ?>
<!-- FIN FOOTER  -->

</body>
</html>
<?PHP mysql_close($con); ?>