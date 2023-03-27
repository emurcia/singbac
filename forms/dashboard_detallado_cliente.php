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
  $id_silo2 = $_SESSION['id_silo'];
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
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.js"></script>
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
       function ver(){

		     $.post('mostrar.php', {id_cliente_busca:document.consulta.id_cliente2.value}, 
			 function(result) {
				$('#feedback').html(result).show();	
		  });//fin1
		 		  
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

<?PHP include("menu.php"); ?>

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
                     <!-- PANEL 1 --->
           
          <div class="row"><!--- INICIO ROW----->                    
          <div class="col-md-12">
         	<div class="contendor">
			<div id="consulta" style="overflow:scroll; height:auto; width:auto; overflow-y: hidden;">
			<h1>Distribución de Lotes</h1>
			<table width="98%">
			<thead>
				<tr>
                	<th>NUMERO</th>
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
					echo "<tr><td width='5%'>$a";
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
		// FUNCION PARA PONERLE COLOR AL GRAFICO
		var pieColors = (function () {
   		var colors = [],
        base = Highcharts.getOptions().colors[4],
        i;
	
			for (i = 0; i < 10; i += 1) {
				// Start out with a darkened base color (negative brighten), and end
				// up with a much brighter color
				colors.push(Highcharts.Color(base).brighten((i - 1) / 7).get());
			}
			return colors;
		}());

	// GENERAR LA GRAFICA
		$(function () {
							
			var chart = $('#grafica').highcharts({
				chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
				},
				title: {
					text: 'Distribución del Silo en Lotes',
					 color: '#FF00FF',
                	 fontWeight: 'bold'
				},
				
				tooltip: {
       				pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>',
											
   				},
				
				plotOptions: {
					
					pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					point: {
            		 events: {
                	click: function(){
		
             		document.consulta.id_cliente2.value=this.name;
					$('#mostrar_lotes').modal('show');
					
                		}
            			}
        			},
					colors: pieColors,
					
					dataLabels: {
					enabled: true,
					distance: 25,
					}

    }
},

			
				series: [{
       			name: 'Distribución',
				colorByPoint: true,
        		data: [
						<?PHP
						$query = "SELECT a.id_cliente, COUNT(a.id_lote) as suma, SUM(a.cant_producto) as sumalote, b.nom_cliente from tab_lote as a, tab_cliente as b WHERE a.bandera=0 and a.id_cliente=b.id_cliente and a.id_silo='".$id_imagen."' GROUP BY a.id_cliente"; 
						$result = mysql_query($query,$con);
						while($row = mysql_fetch_array($result)){
					 	?>	
				
						['<?PHP echo $row["nom_cliente"]; ?>', <?PHP echo $row["suma"]; ?>],
						
						<?PHP } ?>
					  ]		
       		    	}],
								
					
			
				exporting: {
					enabled: true
				}
			})
			.highcharts(); 
		});

		</script>
		<div id="grafica"></div> <!--MUESTRA LA GRAFICA DE PASTEL -->
	</div>
    </div>
    </div>
	<br>
    <br>
    
    
    <!--- SILO EN PRODUCTOS 1 -->
    <div class="row"><!--- INICIO ROW-----> 
      <div class="col-md-12">                   
           	<div class="contendor">
  
	<div id="consulta" style="overflow:scroll; height:auto; width:auto; overflow-y: hidden;">
    <h1>Distribución del Silo en productos</h1>
			<table width="98%">
			<thead>
                <tr>
                	<th>NUM</th>
					<th>LOTE</th>
   					<th>PRODUCTO</th>
   					<th>CAPACIDAD</th>                    
                    <th>CANTIDAD ALMACENADA</th>
                    <th>CANTIDAD DESPACHADA</th>
                    <th>CANTIDAD DISPONIBLE</th>
                    <th>DISTRIBUCION</th>
				</tr>
                </thead>
			<tbody>
            
            
			<?php
		
			$query = "SELECT * from tab_lote WHERE id_silo='".$id_imagen."' and bandera!='1'"; 
			$result = mysql_query($query,$con);
			$c=0;
			$a=0;
			$total=0;
			$m=0;
			$contador=0;
			$suma_disponible_porcen=0.00;
			
			while($row = mysql_fetch_array($result))
			{
				$codigo[$c]=$row["id_lote"];
				$categoria[$c] = $row["num_lote"]; // nombre de la categoria del gráfico
				$producto[$c] = $row["cant_producto"];   // almacena el espacio del lote
				$total = $total + $row["cant_producto"];
				$c++;
			}
					
			for ($j=0;$j<=$c-1;$j++)
			{
				$m++;
				$a++;
				$lote=$codigo[$j];
				$sql_entrada="SELECT sum(peso_bruto) as peso_brutoe, sum(peso_tara) as peso_tarae,round(sum(neto_sin_humedad),2) as sin_humedad_entrada FROM tab_almacenaje WHERE id_silo='".$id_imagen."' and id_lote='$lote' and bandera='2'";
				$result_entrada = mysql_query($sql_entrada,$con);
				while($row_entrada = mysql_fetch_array($result_entrada))
					{
					$humedad_entrada=$row_entrada['sin_humedad_entrada'];
					$peso_neto_entradae=$row_entrada['peso_brutoe']-$row_entrada['peso_tarae'];
					$suma_capacidad=$suma_capacidad+$producto[$j];
					$suma_sin_humedad_entrada=$suma_sin_humedad_entrada+$humedad_entrada;
					$suma_neto=$suma_neto+$peso_neto_entradae;
					}
				
				$sql="SELECT sum(peso_bruto) as peso_brutos, sum(peso_tara) as peso_taras, round(sum(peso_sin_humedad),2) as sin_humedad FROM tab_salida WHERE id_silo='".$id_imagen."' and id_lote='$lote'";
				$result_dos = mysql_query($sql,$con);
				while($row2 = mysql_fetch_array($result_dos))
					{
						$humedad_salida=$row2['sin_humedad'];
						$peso_neto_salidas=$row2['peso_brutos']-$row2['peso_taras'];
						$suma_sin_humedad_salida=$suma_sin_humedad_salida+$humedad_salida;
						$suma_netos=$suma_netos+$peso_neto_salidas;
						
					}
					
				$sql_producto="SELECT a.*, b.* FROM tab_producto as a, tab_lote as b WHERE b.id_producto=a.id_producto AND b.id_lote='$lote'";
				$result_producto = mysql_query($sql_producto,$con);
				while($row_producto = mysql_fetch_array($result_producto))
					{
					$nom_producto = $row_producto["nom_producto"]; // nombre de la categoria del gráfico
					}
					
				$sql_silo="SELECT a.*, b.* FROM tab_silo as a, tab_lote as b WHERE b.id_silo=a.id_silo AND b.id_lote='$lote'";
				$result_silo = mysql_query($sql_silo,$con);
				while($row_silo = mysql_fetch_array($result_silo))
					{
					$nom_silo = $row_silo["nom_silo"]; // nombre de la categoria del gráfico
					}	
					
				$disponibilidad_neto=$peso_neto_entradae-$peso_neto_salidas;
				$disponibilidad_humedad=$humedad_entrada-$humedad_salida;
						
				$disponible_almacen=$humedad_entrada-$humedad_salida;
				$suma_disponible=$suma_disponible+$disponible_almacen;
			    $suma_disponible_neto=$suma_disponible_neto+$disponibilidad_neto; 
				$disponible_porcen=number_format((($producto[$j]/$total)*100), 1, ',', '');
				$suma_disponible_porcen=$suma_disponible_porcen+$disponible_porcen;
			
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
				echo "</td><td align='justify'>".$nom_producto;	
				//echo "</td><td align='justify'>".$nom_silo;					
				echo "</td><td>".$producto[$j];
				//echo "</td><td>".$peso_neto_entradae;				
				echo "</td><td>".$humedad_entrada2;
				echo "</td><td>".$peso_neto_salidas;
				//echo "</td><td>".$humedad_salida2;
			//	echo "</td><td>".$disponibilidad_neto;
				echo "</td><td>".$disponibilidad_humedad;				
				echo "</td><td>".$disponible_porcen."%";
				
				}
				echo "<tr><td colspan='3'> TOTALES";
				echo "</td><td>".$suma_capacidad;
				//echo "</td><td>".$suma_neto;				
				echo "</td><td>".$suma_sin_humedad_entrada;
			//	echo "</td><td>".$suma_sin_humedad_salida;
				echo "</td><td>".$suma_sin_humedad_salida;
			//	echo "</td><td>".$suma_disponible_neto;				
				echo "</td><td>".$suma_disponible."</td>
				
				</tr>";
			?>
			</tbody>
			</table>
		</div>
        </div>
        </div>
        </div>
    <!-- FIN SILO EN PRODUCTOS 1 -->
    
    
        <br>
        <br>
    
     <div class="row" align="center"><!--- INICIO ROW----->
        <div class="col-md-3">
         
          </div>
          <div class="col-md-6">
         	<div  id='container1'></div> <!-- COMPARATIVO DE ALMACENAMIENTO Y DESPACHO DE GRANOS -->
          </div>
           <div class="col-md-2">
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
		name: 'Almacenamiento',
        data: [<?PHP echo $suma_sin_humedad_entrada ?>]
    }, {		
		name: 'Despacho',
        data: [<?PHP echo $suma_sin_humedad_salida ?>]
    }, {		
		name: 'Disponibilidad',
        data: [<?php echo $suma_disponible; ?>]
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


<!-- INICIA ELIMINAR REGISTRO -->
<div class="modal fade" id="mostrar_lotes" >
<form name="consulta" >
        <div class="modal-dialog" style="height: 70vh;
    width: 70vw;">
          <div class="modal-content">                        
            <div class="modal-header">
              <input type="text"  id="id_cliente2" readonly onClick="ver()" name="id_cliente2" class="form-control input-lg"  autocomplete="off" style="background:#FFF;">
            </div>            
          <div id="feedback" class="modal-body" > </div>
		<br>
		<div class="modal-footer">
         	<button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	    </div>
    </div>
    <div>               
    </form>
</div>
<?PHP mysql_close();  ?>
