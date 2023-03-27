<?php 
ini_set('session.save_handler', 'files');
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
  // Verificación de sesiones
 if ($_SESSION['token_ss'] != NULL) //solo si hay session activa
{
$loginSQL=mysql_query("select token, nombre_usuario from t_usuarios  where id_usuario='$id_usuario'",$con);
$fila_usu = mysql_fetch_array($loginSQL, MYSQL_ASSOC);
$fila_usu['token'];
$nombre_usuario=$fila_usu['nombre_usuario'];
if( $fila_usu['token'] != $_SESSION['token_ss'] )
{
	echo "<script language='javascript'>";
	echo "document.location.href='destruir_sesion.php';";
	echo "</script>";
}
} // fin de verificar sesion 

// OBTENER LOS DATOS DE LA EMPRESA / CLIENTE A TRAVES DEL USUARIO LOGUEADO

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
	 $fecha_creado=parseDatePhp($array['fecha_usuario']);	 	 
	 
}

if($_SESSION['permiso_silo']!='ok'){
	echo "<script language='javascript'>";
	echo "document.location.href='../index.php';";
	echo "</script>";
}
	
?>

<!DOCTYPE html> 
<html> 
<head > 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=Width-device, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<script src="http://code.jquery.com/jquery.js"></script> 
<script src="../js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../assets/stylesheet/caja_buscar.css">
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery-1.4.4.min.js"></script>
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link href="../images/favicon.ico" rel="icon">

<script src="../higthcharts/highcharts.js"></script>
<script src="../higthcharts/modules/exporting.js"></script>
<script src="../higthcharts/modules/drilldown.js"></script>
<link rel="stylesheet" type="text/css" href="../css/estilo.css">

</head> 


<script  languaje="javascript" type="text/javascript" >
 
function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }

function consultaDetalle(str1)
  {
	window.open("dashboard_detallado.php?id_imagen="+str1+"","DETALLE DE IMAGEN","fullscreen","scrollbars=NO,Top=30,Left=100,Resizable=NO,Titlebar=NO,Location=NO");
  }
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
<body class="container"> 


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



<form name="formulario" method="post" action="dashboard.php">
  <input type="hidden" value="0" name="bandera"/>
</form>

<div class="container-fluid">
<div class="row" >
<div class="panel panel-primary">
      <div class="panel-heading"><strong> "<?PHP echo $nom_sistema; ?>"</strong></div> 
           <!-- PANEL 1 ---><br>
                   
          <div class="row"><!--- INICIO ROW GRAFICA POR SILO----->  
          <div class="col-md-1">
          </div>                  
          <div class="col-md-10" align="center">INFORMACION GENERAL
          <br>
            <br>
         	<div class="contendor"> 
			<div id="consulta" style="overflow:scroll;height:auto;width:auto; overflow-y: hidden;" align="center">
			<table>
			<thead>
				<tr>
                	<th>NUM</th>
					<th>SILO</th>
   					<th>CAPACIDAD</th>
   					<th>ALMACEN</th>                    
					<th>DESPACHO</th>                    
                    <th>DISPONIBILIDAD</th>
                    <th>DISTRIBUCION (%)</th>                    
				</tr>
                </thead>
			<tbody>
            
            
			<?php
			$id_sil="SILO-000".$id_empresa;
			$query = "SELECT * from tab_silo WHERE id_silo!='$id_sil' and bandera=0 and id_empresa='$id_empresa' ORDER BY nom_silo asc"; 
			$result = mysql_query($query,$con);
			$c=0;
			$a=0;
			$total=0;
			$m=0;
			$contador=0;
		
			while($row = mysql_fetch_array($result))
			{
				$codigo[$c]=$row["id_silo"];
				$categoria[$c] = $row["nom_silo"]; // nombre de la categoria del gráfico
				$producto[$c] = $row["cap_silo"];   // almacena el espacio del lote
				$total = $total + $row["cap_silo"];
				$c++;
			}
					
			for ($j=0;$j<=$c-1;$j++)
			{
				$m++;
				$a++;
				$silo=$codigo[$j];
				$sql_entrada="SELECT round(sum(a.neto_sin_humedad),2) as sin_humedad_entrada FROM tab_almacenaje as a, tab_lote as l WHERE l.bandera=0 and l.id_lote=a.id_lote and a.id_silo='$silo'";
				$result_entrada = mysql_query($sql_entrada,$con);
				while($row_entrada = mysql_fetch_array($result_entrada))
					{
					$humedad_entrada=$row_entrada['sin_humedad_entrada'];
					$suma_capacidad=$suma_capacidad+$producto[$j];
					$suma_sin_humedad_entrada=$suma_sin_humedad_entrada+$humedad_entrada;
					}
				
				$sql="SELECT round(sum(a.peso_sin_humedad),2) as sin_humedad FROM tab_salida as a, tab_lote as l WHERE l.bandera=0 and l.id_lote=a.id_lote and a.id_silo='$silo'";
				$result_dos = mysql_query($sql,$con);
				while($row2 = mysql_fetch_array($result_dos))
					{
						$humedad_salida=$row2['sin_humedad'];
						$suma_sin_humedad_salida=$suma_sin_humedad_salida+$humedad_salida;
					}
					
				
					
				$sql_silo="SELECT a.*, b.* FROM tab_silo as a, tab_lote as b WHERE b.bandera=0 and b.id_silo=a.id_silo AND b.id_lote='$lote'";
				$result_silo = mysql_query($sql_silo,$con);
				while($row_silo = mysql_fetch_array($result_silo))
					{
					$nom_silo = $row_silo["nom_silo"]; // nombre de la categoria del gráfico
					}		
//				$disponible_almacen=$producto[$j]-$humedad_entrada+$humedad_salida;
				$disponible_almacen=$humedad_entrada-$humedad_salida;
				$suma_disponible=$suma_disponible+$disponible_almacen;
			     
				$disponible_porcen=number_format((($producto[$j]/$total)*100), 2, ',', '');
				
				$suma_porcentaje="100,00";
				
				if($humedad_entrada==""){
					$humedad_entrada2=0.00;
					}else{
					$humedad_entrada2=$humedad_entrada;
					}
					
				if($humedad_salida==""){
					$humedad_salida2=0.00;
					}else{
					$humedad_salida2=$humedad_salida;
					}
				$datos2[$j] = $humedad_entrada2; // DATOS SIN HUMEDAD ENTRADA	
				$datos3[$j] = $humedad_salida2; // DATOS SIN HUMEDAD SALIDA	
				$datos4[$j] = $disponible_almacen; // ESPACIO DISPONIBLE								
				echo "<tr><td>$a";
				echo "</td><td align='justify'>".$categoria[$j];

				
				echo "</td><td>".$producto[$j];			
				echo "</td><td>".$humedad_entrada2;
				echo "</td><td>".$humedad_salida2;
				echo "</td><td>".$disponible_almacen;
				echo "</td><td>".$disponible_porcen."%";
				}
				echo "<tr><td colspan='2'> TOTALES";
				echo "</td><td>".$suma_capacidad;
				echo "</td><td>".$suma_sin_humedad_entrada;
				echo "</td><td>".$suma_sin_humedad_salida;
				echo "</td><td>".$suma_disponible;
				echo "</td><td>".$suma_porcentaje."%"."</td></tr>";				
			?>
			</tbody>
			</table>
		</div>
		<script type="text/javascript">
		$(function () {
			var colors = Highcharts.getOptions().colors,
			categories = [<?php for($y=0;$y<=$c-1;$y++) { echo "'".$categoria[$y]."',";}?>],
			name1 = 'Capacidad',
			data1 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $producto[$x] ?>,
             		}, 
					<?php }?>];
					
					name2 = 'Almacen',
					data2 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos2[$x] ?>,
             		}, 
					<?php }?>];
					
					name3 = 'Salida',
					data3 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos3[$x] ?>,
					}, 
					<?php }?>];
					
					name4 = 'Disponibilidad',
					data4 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos4[$x] ?>,
					}, 
					<?php }?>];
							
			
					
			var chart = $('#grafica2').highcharts({
				 chart: {
        			type: 'column'
        		},
					title: {
					text: 'Detalle de silos'
				},
				
	
				xAxis: {
					categories: categories
				},
				
				yAxis: {
						title: {
						text: null
					}
				},
			
				
				series: [{
					name: name1,
					data: data1,
					//color: 'white'
				},{
					name: name2,
					data: data2,
					//color: 'white'
				
				},{
					name: name3,
					data: data3,
					//color: 'white'
				},{
					name: name4,
					data: data4,
					//color: 'white'
				}
				],
				exporting: {
					enabled: true
				}
			})
			.highcharts(); 
		});
		</script>
        <br>
        <br>
		<div id="grafica2"></div>
	</div><!-- DESPACHO -->
   </div>
   </div>
    
   
   <br>   
   </div>
</div>
</div>
</body>
<br><br><br><br>
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->

<!--  INICIO FOOTER   -->

<?PHP include("footer.php");  ?>

<!-- FIN FOOTER  -->

</body> 
</html>
<?PHP
mysql_close();
?>
