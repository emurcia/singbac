<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css"> 
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<script>
 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones').dataTable( {
    		"sPaginationType": "full_numbers",
			"sScrollX":"true"

	 });
});

</script>
<?php 
ini_set('session.save_handler', 'files');
/***********esto es para cerrar sesion cuando se cierren todas las ventanas de la web**************/
//si es necesario cambiar la config. del php.ini desde tu script
ini_set("session.use_only_cookies","1");
ini_set("session.use_trans_sid","0");
@session_start();
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");

 $fec_inicio = parseDateMysql(($_POST['fec_inicio_busca']));
 $fec_fin = parseDateMysql(($_POST['fec_fin_busca']));
   $fec_inicio1 = (mysql_real_escape_string($_POST['fec_inicio_busca']));
  $fec_fin1 = (mysql_real_escape_string($_POST['fec_fin_busca']));
// $id_prestamo = mysql_real_escape_string($_POST['id_prestamo_buscar']);

$loginSQL=mysql_query("SELECT SUM(peso_bruto) as peso_bruto, SUM(peso_tara) AS peso_tara, SUM(neto_sin_humedad) AS neto_sin_humedad  FROM tab_almacenaje WHERE (fecha_entrada>='$fec_inicio' AND fecha_entrada<='$fec_fin')",$con);
$fila_usu = mysql_fetch_array($loginSQL);
$peso_netoimprime=number_format($fila_usu['peso_bruto'],2);
$peso_taraimprime=number_format($fila_usu['peso_tara'],2);
$peso_brutoimprime1=number_format(($fila_usu['peso_bruto']-$fila_usu['peso_tara']),2);
$peso_sin_humedad=number_format($fila_usu['neto_sin_humedad'],2);

$consul=mysql_query("SELECT SUM(peso_bruto) AS peso_bruto2, SUM(peso_tara) AS peso_tara2, SUM(peso_sin_humedad) AS neto_sin_humedad2  FROM tab_salida WHERE (fecha_entrada>='$fec_inicio' AND fecha_entrada<='$fec_fin')",$con);
$fila_consul= mysql_fetch_array($consul);
$peso_netoimprime2=number_format($fila_consul['peso_bruto2'],2);
$peso_taraimprime2=number_format($fila_consul['peso_tara2'],2);
$peso_brutoimprime2=number_format(($fila_consul['peso_bruto2']-$fila_consul['peso_tara2']),2);
$peso_sin_humedad2=number_format($fila_consul['neto_sin_humedad2'],2);


?>          


<script>
function reporte(){
window.open('../reportes/Rp_ingresoegreso.php?id='+document.formulario.fec_inicio.value+'&id2='+document.formulario.fec_fin.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');	

}

</script>

 <div class="container-fluid">
  <div class="row" >
      <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading" align="center"><strong>INGRESO - EGRESOS DE GRANOS</strong></div> <!-- PANEL 1 --->
           
           <div class="panel-body" >
 				<div>
               
<?php
  echo"<div class='table'><table width='100%' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class=' display' id='tblInstituciones' >";
  
                        echo"<thead>                     
                              	<tr>            
                                <th width='150px'><div align='left'><a href='#' title='Ordenar por Fecha'>FECHA INICIO</a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Ordenar por Pago'>FECHA FIN</a></div></th>
                                <th width='150px'><div align='left'><a href='#' title='Ordenar por Capital'>INGRESO PESO BRUTO</a></div></th>
           						<th width='150px'><div align='left'><a href='#' title='Ordenar por Interes'>INGRESO PESO TARA</a></div></th>                
								<th width='150px'><div align='left'><a href='#' title='Odenar por Saldo'>INGRESO PESO NETO </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Ordenar por Capital'>INGRESO PESO SIN HUMEDAD</a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Ordenar por Mora'>EGRESO PESO BRUTO</a></div></th>                    	<th width='150px'><div align='left'><a href='#' title='Ordenar por Otros'>EGRESO PESO TARA</a></div></th>                    
								
								<th width='250px'><div align='left'><a href='#' title='Odenar por Usuario'>EGRESO PESO NETO </a></div></th>
								
           						
								<th width='150px'><div align='left'><a href='#' title='Odenar por Saldo'>EGRESO PESO SIN HUMEDAD</a></div></th>
								
								
								      
                            </tr>
                            </thead>
                            <tbody>";
                    		
														
                            echo"<tr>
							 <td width='auto' align='center'>$fec_inicio1</td>	
							 <td width='auto' align='center'>$fec_fin1</td>   
                             <td width='auto' align='left'> $peso_netoimprime </td>
                              <td width='auto' align='left'> $peso_taraimprime</td>
							  <td width='auto' align='left'> $peso_brutoimprime1</td>
							  <td width='auto' align='left'> $peso_sin_humedad</td>
							  <td width='auto' align='left'> $peso_netoimprime2 </td>
                              <td width='auto' align='left'> $peso_taraimprime2</td>
							  <td width='auto' align='left'> $peso_brutoimprime2</td>
							  <td width='auto' align='left'> $peso_sin_humedad2</td>	
							
                              
                            </tr>";
                        
                         
							
							
                            $correlativo++;		
                    
                            echo"</tbody>
                        </table>
						
                        ";
					                   
                  
                    
                    
                    
                        ?>
    <!--Fin si se ha seleccionado administrador-->

					<?php

					echo "Total de Registros" ." ".$contar4;

					 
					 
					?>
  
</div>
</div>
</div>
</div>
</div>
</div>
</div>  
<?php if($fec_inicio1!=0){ ?>
 <table border="0" align="center">
 <td width="100"><button name="btn_reporte" onclick="reporte()" value="Imprimir" class="btn btn-info btn-lg pull-right" > Imprimir </button></td>
              	    </tr>
           	      </table>            
<?php }?>

</div>
</div>

