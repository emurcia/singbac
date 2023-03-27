<?php 
ini_set('session.save_handler', 'files');
/***********esto es para cerrar sesion cuando se cierren todas las ventanas de la web**************/
//si es necesario cambiar la config. del php.ini desde tu script
ini_set("session.use_only_cookies","1");
ini_set("session.use_trans_sid","0");
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");

 $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
 $estado= $_SESSION['bandera_empresa'];
 $id_usuario=$_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
 $acceso =$_SESSION['nivel_silo'];
 $nom_sistema=$_SESSION['nom_sistema'];
 $id_imagen = $_GET['id_imagen']; //  CODIGO DEL SILO
 $_SESSION['id_silo']=$id_imagen;
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
 

//$id_sil="SILO-000".$id_empresa; 
$tabla="SELECT *  FROM tab_silo WHERE id_silo='$id_imagen' and id_empresa='$id_empresa'";
$select = mysql_query($tabla,$con);
while($row = mysql_fetch_array($select))
{
	$nombre_silo=$row['nom_silo'];
	$cantidad_silo=$row['cap_silo'];
}

if($_SESSION['permiso_silo']!='ok'){
	echo "<script language='javascript'>";
	echo "document.location.href='../index.php';";
	echo "</script>";
}
date_default_timezone_set("America/El_Salvador");
	
?>

<!DOCTYPE html> 
<html> 
<head > 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<script src="http://code.jquery.com/jquery.js"></script> 
<script src="../js/bootstrap.min.js"></script>
<script src="../higthcharts/highcharts.js"></script>
<script src="../higthcharts/modules/exporting.js"></script>
<script src="../higthcharts/modules/drilldown.js"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="../images/favicon.ico" rel="icon">
<link rel="stylesheet" type="text/css" href="../css/estilo.css">
</head> 


<script  languaje="javascript" type="text/javascript" >
 
function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }

</script>
 <script type="text/javascript">
       $(document).ready(function() {
	  
		   $('#id_cliente2').change(function() {//inicio1
			 $.post('mostrar.php', {id_cliente_busca:document.formulario.id_cliente2.value}, 
			 function(result) {
				$('#feedback').html(result).show();	
			 }); 									 
		  });//fin1
		 		  
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
<br><br>


<style>
.h1{
	text-align:center;
	font-size:10px;
}
</style>

  <div class="container-fluid">
  <div class="row" >
     <div class="col-md-12">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>Silo <?php echo $nombre_silo;?>, Capacidad <?PHP echo $cantidad_silo; ?></strong></div> 
           <!-- PANEL 1 ---><br>
           
          <div class="row"><!--- INICIO ROW----->                    
          <div class="col-md-6">
         	<div class="contendor">
			<div id="consulta" style="overflow:scroll;height:auto;width:auto; overflow-y: hidden;">
			<h1>Distribución de Lotes por Cliente / Empresa</h1>
			<table width="100%">
			<thead>
				<tr>
                	<th>NUM</th>
					<th>EMPRESA / CLIENTE</th>
					<th>LOTES </th>
    				<th>CANTIDAD (KG)</th>
					<th>%</th>
					<th>TOTAL</th>
                    <th>DISPONIBLE</th>
				</tr>
			</thead>
			<tbody>
            
            
			<?php
		
			$query = "SELECT a.id_cliente, COUNT(a.id_lote) as suma, SUM(a.cant_producto) as sumalote, b.nom_cliente from tab_lote as a, tab_cliente as b WHERE a.bandera=0 and a.id_cliente=b.id_cliente and a.id_silo='".$id_imagen."' GROUP BY a.id_cliente"; 
			$result = mysql_query($query,$con);
			$c=0;
			$a=0;
			$total=0;
			$total_lote=0;
			$contador=0;
			while($row = mysql_fetch_array($result))
			{
				$codigo[$c]=$row["id_cliente"];
				$categoria[$c] = $row["nom_cliente"];
				$datos[$c] = $row["suma"];  
				$total = $total + $row["suma"];
				$datos2[$c]=$row["sumalote"];
				$total_lote=$total_lote+$row["sumalote"];
				$c++;
			}
			
			
			for ($j=0;$j<=$c-1;$j++)
			{
				$a++;
				$nom_categoria=$categoria[$j];
				$sql="SELECT * FROM tab_cliente WHERE nom_cliente='$nom_categoria'";
				$result_dos = mysql_query($sql,$con);
		
					while($row_dos = mysql_fetch_array($result_dos))
					{
					$nombre_empresa=$row_dos['nom_cliente'];
			
				echo "<tr><td width='60px' ><a data-toggle='modal' data-id='$nombre_empresa' class='btn blue'>$a</a>";
		
				echo "</td><td align='justify'>".$row_dos['nom_cliente'];
				}
				echo "</td><td>".$datos[$j];
				echo "</td><td>".$datos2[$j];
				echo "</td><td>".number_format((($datos2[$j]/$cantidad_silo)*100), 1, ',', '')."%";
				$por[$j]= round( ($datos[$j]/$total)*100, 1);
				if ($j==0) 
				{
					echo "</td><td rowspan=".$c.">".$total. "<br>".$total_lote."(kg)"."</td>";
					echo "<td rowspan=".$c.">".number_format(((($cantidad_silo-$total_lote)/$cantidad_silo)*100),1,',','')."%"."<br>".($cantidad_silo-$total_lote)."(kg)"."</td></tr>";
				}
			}
			?>
			</tbody>
			</table>
		</div>
		<script type="text/javascript">
		$(function () {
			var colors = Highcharts.getOptions().colors,
			categories = [<?php for($y=0;$y<=$c-1;$y++) { echo "'".$categoria[$y]."',";}?>],
			name1 = 'Lotes',
			data1 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos[$x] ?>,
					color: colors[<?php echo $x?>],                   
					}, 
					<?php }?>];
			
					
			var chart = $('#grafica').highcharts({
				 chart: {
        			type: 'column'
        		},
					title: {
					text: 'Distribución de Lotes por Clientes'
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
					color: 'white'
				}],
				exporting: {
					enabled: true
				}
			})
			.highcharts(); 
		});
		</script>
		<div id="grafica"></div>
	</div><!-- DESPACHO -->
   </div>
<form name="formulario" method="post" action="f_maqueta.php">
  <input type="hidden" value="0" name="bandera"/>
        
          <div class="col-md-5">
              <div class="form-group">
              <br> <br>
               <label for="moneda_servicio">CLIENTE</label>
                         <?php
						 $tabla=mysql_query("SELECT a.id_cliente, COUNT(a.id_lote) as suma, b.nom_cliente from tab_lote as a, tab_cliente as b WHERE a.bandera=0 and a.id_cliente=b.id_cliente and a.id_silo='".$id_imagen."' GROUP BY a.id_cliente");
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
         	  <div id="feedback"></div>
          
          </div><!--- FIN ROW----->
          
</form>            
           <br>
            <br>
     <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         				<div  id='container3'></div> <!-- DIFERENCIA ENTRE ALMACENAMIENTO Y DESPACHO -->
          </div>
          <div class="col-md-4">
         				<div  id='container1'></div> <!-- ALMACENAMIENTO -->
          </div>
          <div class="col-md-4">
         				<div  id='container2'></div><!-- DESPACHO -->
          </div>
          </div><!--- FIN ROW----->
           <br>
          <br>
           
			
                                
<script>
//GRAFICA PARA LOS SILOS ALMACENAMIENTO DE GRANOS BASICOS
		
Highcharts.chart('container1', {	
    chart: {
        type: 'column',
		
    },
    title: {
        text: 'ALMACENAMIENTO DE GRANOS BASICOS '
    },
    subtitle: {
        text: 'Indicadores de Almacenamiento de Granos Básicos'
    },
    xAxis: {
categories: [<?php
$tabla="SELECT *  FROM tab_silo WHERE id_silo='$id_imagen' and id_empresa='$id_empresa'";
$select = mysql_query($tabla,$con);
while($row = mysql_fetch_array($select))
{

	?>
	'<?PHP echo $row["nom_silo"];?>',
	<?PHP }?>
]
    },
    yAxis: {
		 allowDecimals: false,
        min: 0,
        title: {
            text: 'Kilogramos'
        }
    },
	
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
         name: 'Capacidad',
		 data: [<?php
		
$tabla="SELECT *  FROM tab_silo WHERE id_empresa='$id_empresa' and id_silo='$id_imagen' group by id_silo";
$select = mysql_query($tabla,$con);
while($row = mysql_fetch_array($select))
{
	?>
	<?PHP echo $row['cap_silo'];?>,
	<?PHP
	
}
?>]
    }, {		
		name: 'Bruto',
        data: [<?PHP
		
$tabla1="select a.id_silo, b.id_silo, sum(b.peso_bruto) as peso_bruto FROM tab_silo as a, tab_almacenaje as b WHERE a.id_silo=b.id_silo and a.id_silo='$id_imagen' GROUP by a.id_silo ";
$select1 = mysql_query($tabla1,$con);
while($row1 = mysql_fetch_array($select1))
{
	?>
	<?PHP 
	echo $row1['peso_bruto']; ?>,
	<?PHP
}
?>]
    }, {		
		name: 'Tara',
        data: [<?PHP
		
$tabla1="select a.id_silo, b.id_silo, sum(b.peso_tara) as peso_tara FROM tab_silo as a, tab_almacenaje as b WHERE a.id_silo=b.id_silo and a.id_silo='$id_imagen' GROUP by a.id_silo ";
$select1 = mysql_query($tabla1,$con);
while($row1 = mysql_fetch_array($select1))
{
	?>
	<?PHP 
	echo $row1['peso_tara']; ?>,
	<?PHP
}
?>]
    }, {		
		name: 'Neto',
        data: [<?php
$tabla="select a.id_silo, b.id_silo, (sum(b.peso_bruto)-sum(b.peso_tara)) as peso_neto FROM tab_silo as a, tab_almacenaje as b WHERE  a.id_silo='$id_imagen' and a.id_silo=b.id_silo GROUP by a.id_silo";
$select = mysql_query($tabla,$con);
while($row = mysql_fetch_array($select))
{
	?>
	<?PHP echo $row['peso_neto']; ?>,
	<?PHP
}
?>],
		  color: '#fa5858'
    }, {		
		name: 'Peso sin Humedad',
        data: [<?PHP
		
$tabla1="select a.id_silo, b.id_silo, round(sum(b.neto_sin_humedad),2) as neto_sin_humedad FROM tab_silo as a, tab_almacenaje as b WHERE a.id_silo=b.id_silo and a.id_silo='$id_imagen' GROUP by a.id_silo ";
$select1 = mysql_query($tabla1,$con);
while($row1 = mysql_fetch_array($select1))
{
	?>
	<?PHP 
	echo $row1['neto_sin_humedad']; ?>,
	<?PHP
}
?>]
    },]
		
});
</script>

<script>
// Grafica de salida de granos
Highcharts.chart('container2', {	
    chart: {
        type: 'column'
    },
    title: {
        text: 'DESPACHO DE GRANOS BASICOS '
    },
    subtitle: {
        text: 'Indicadores de Salida de Granos Básicos'
    },
    xAxis: {
categories: [<?php
$tabla="SELECT *  FROM tab_silo WHERE id_silo='$id_imagen' and id_empresa='$id_empresa'";
$select = mysql_query($tabla,$con);
while($row = mysql_fetch_array($select))
{
//$id_silo_busca=$row["id_silo"];
	?>
	'<?PHP echo $row["nom_silo"];?>',
	<?PHP }?>
]
    },
    yAxis: {
        title: {
            text: 'Kilogramos'
        }
    },
	
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
         name: 'Capacidad',
		 data: [<?php
		
$tabla="SELECT *  FROM tab_silo WHERE id_empresa='$id_empresa' and id_silo='$id_imagen' group by id_silo";
$select = mysql_query($tabla,$con);
while($row = mysql_fetch_array($select))
{
	?>
	<?PHP echo $row['cap_silo'];?>,
	<?PHP
	
}
?>]
    }, {		
		name: 'Bruto',
        data: [<?PHP
		
$tabla1="select a.id_silo, b.id_silo, sum(b.peso_bruto) as peso_bruto FROM tab_silo as a, tab_salida as b WHERE a.id_silo=b.id_silo and a.id_silo='$id_imagen' GROUP by a.id_silo ";
$select1 = mysql_query($tabla1,$con);
while($row1 = mysql_fetch_array($select1))
{
	?>
	<?PHP 
	echo $row1['peso_bruto']; ?>,
	<?PHP
}
?>]
    }, {		
		name: 'Tara',
        data: [<?PHP
		
$tabla1="select a.id_silo, b.id_silo, sum(b.peso_tara) as peso_tara FROM tab_silo as a, tab_salida as b WHERE a.id_silo=b.id_silo and a.id_silo='$id_imagen' GROUP by a.id_silo ";
$select1 = mysql_query($tabla1,$con);
while($row1 = mysql_fetch_array($select1))
{
	?>
	<?PHP 
	echo $row1['peso_tara']; ?>,
	<?PHP
}
?>]
    }, {		
		name: ' Neto',
        data: [<?php
$tabla="select a.id_silo, b.id_silo, (sum(b.peso_bruto)-sum(b.peso_tara)) as peso_neto FROM tab_silo as a, tab_salida as b WHERE a.id_silo=b.id_silo and a.id_silo='$id_imagen' GROUP by a.id_silo";
$select = mysql_query($tabla,$con);
while($row = mysql_fetch_array($select))
{
	?>
	<?PHP echo $row['peso_neto']; ?>,
	<?PHP
}
?>],
		  color: '#fa5858'
    }, {		
		name: 'Peso sin Humedad',
        data: [<?PHP
		
$tabla1="select a.id_silo, b.id_silo, round(sum(b.peso_sin_humedad),2) as neto_sin_humedad FROM tab_silo as a, tab_salida as b WHERE a.id_silo=b.id_silo and a.id_silo='$id_imagen' GROUP by a.id_silo ";
$select1 = mysql_query($tabla1,$con);
while($row1 = mysql_fetch_array($select1))
{
	?>
	<?PHP 
	echo $row1['neto_sin_humedad']; ?>,
	<?PHP
}
?>]
    },]
		
});
</script>


<script>
//GRAFICA COMPARATIVA DE ALMACENAJE Y SALIDA DE GRANOS BASICOS
		
Highcharts.chart('container3', {	
    chart: {
        type: 'column'
    },
    title: {
        text: 'COMPARATIVO DE ALMACENAMIENTO Y DESPACHO DE GRANOS BASICOS '
    },subtitle: {
        text: 'Expresado en Cantidad Neta'
    },
    
    xAxis: {
categories: [<?php
//$id_sil="SILO-000".$id_empresa; 
$tabla="SELECT *  FROM tab_silo WHERE id_silo='$id_imagen' and id_empresa='$id_empresa'";
$select = mysql_query($tabla,$con);
while($row = mysql_fetch_array($select))
{

	?>
	'<?PHP echo $row["nom_silo"];?>',
	<?PHP }?>
]
    },
    yAxis: {
        title: {
            text: 'Kilogramos'
        }
    },
	
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
         name: 'Capacidad',
		 data: [<?php
		
$tabla="SELECT *  FROM tab_silo WHERE id_empresa='$id_empresa' and id_silo='$id_imagen' group by id_silo";
$select = mysql_query($tabla,$con);
while($row = mysql_fetch_array($select))
{
	?>
	<?PHP echo $row['cap_silo'];?>,
	<?PHP
	
}
?>]
    }, {		
		name: 'Almacenamiento',
        data: [<?PHP
		
$tabla1="select a.id_silo, b.id_silo, (sum(b.peso_bruto)-sum(b.peso_tara)) as peso_almacen FROM tab_silo as a, tab_almacenaje as b WHERE a.id_silo=b.id_silo and a.id_silo='$id_imagen' GROUP by a.id_silo ";
$select1 = mysql_query($tabla1,$con);
while($row1 = mysql_fetch_array($select1))
{
	$almacenamiento=$row1['peso_almacen'];
	?>
	<?PHP 
	echo $row1['peso_almacen']; ?>,
	<?PHP
}
?>]
    }, {		
		name: 'Despacho',
        data: [<?PHP
		
$tabla1="select a.id_silo, b.id_silo, (sum(b.peso_bruto)-sum(b.peso_tara)) as peso_salida FROM tab_silo as a, tab_salida as b WHERE a.id_silo=b.id_silo and a.id_silo='$id_imagen' GROUP by a.id_silo ";
$select1 = mysql_query($tabla1,$con);
while($row1 = mysql_fetch_array($select1))
{
	$despacho=$row1['peso_salida'];
	?>
	<?PHP 
	echo $row1['peso_salida']; ?>,
	<?PHP
}
?>]
    },{		
		name: 'Bodega',
        data: [<?PHP
		echo $bodega=$almacenamiento-$despacho;
		

?>]
    },
	{		
		name: 'Espacio para almacenamiento',
        data: [<?PHP
		
$tabla1="select a.id_silo, b.id_silo, a.cap_silo as capacidad_silo, sum(b.peso_bruto)- sum(b.peso_tara) as almacen FROM tab_silo as a, tab_almacenaje as b WHERE a.id_silo='$id_imagen' AND a.id_silo=b.id_silo ";
$select1 = mysql_query($tabla1,$con);
while($row1 = mysql_fetch_array($select1))
{
	$resta=$row1['capacidad_silo']-$row1['almacen'];
}
$tabla1="select a.id_silo, b.id_silo, a.cap_silo as capacidad_silo, sum(b.peso_bruto)- sum(b.peso_tara) as salida FROM tab_silo as a, tab_salida as b WHERE a.id_silo='$id_imagen' AND a.id_silo=b.id_silo ";
$select1 = mysql_query($tabla1,$con);
while($row1 = mysql_fetch_array($select1))
{
	$salida=$row1['salida'];
}
$disponible=$resta+$salida;
	?>
	<?PHP echo  $disponible;?>,
]
    },]
		
});
</script>
</div>
	
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
<?PHP mysql_close();  ?>
