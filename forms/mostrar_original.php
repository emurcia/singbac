<?php 
ini_set('session.save_handler', 'files');
/***********esto es para cerrar sesion cuando se cierren todas las ventanas de la web**************/
//si es necesario cambiar la config. del php.ini desde tu script
ini_set("session.use_only_cookies","1");
ini_set("session.use_trans_sid","0");
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
 $id_silo2 = $_SESSION['id_silo'];
 $id_cliente2 = mysql_real_escape_string($_POST['id_cliente_busca']);
 
$loginSQL=mysql_query("select id_cliente from tab_cliente  where nom_cliente='$id_cliente2'",$con);
$fila_usu = mysql_fetch_array($loginSQL, MYSQL_ASSOC);
$id_cliente3= $fila_usu['id_cliente'];

 ?>
<link rel="stylesheet" type="text/css" href="../css/estilo.css">
 <div class="row"><!--- INICIO ROW----->                    
          <div class="col-md-12">	
         	<div class="contendor" >
			<div id="consulta" style="overflow:scroll;height:auto;width:auto; overflow-y: hidden;" >
			<table width="100%">
			<thead>
				<tr>
                	<th>NUM</th>
					<th>LOTE</th>
					<th>CANTIDAD ASIGNADA</th>
                    <th>CANTIDAD OCUPADA</th>
                    <th>CANTIDAD DISPONIBLE</th>
					<th>%</th>
					<th>TOTAL</th>
				</tr>
			</thead>
			<tbody>
            
            
			<?php
		
			$query = "SELECT * from tab_lote WHERE bandera= 0 and id_cliente='$id_cliente3' and id_silo='$id_silo2'"; 
			$result = mysql_query($query,$con);
			$c=0;
			$a=0;
			$total=0;
			$m=0;
			$contador=0;
			
			while($row = mysql_fetch_array($result))
			{
				$codigo[$c]=$row["id_lote"];
				$categoria[$c] = $row["num_lote"];
				$datos[$c] = $row["cant_producto"];  
				$total = $total + $row["cant_producto"];
				$c++;
			}
					
			for ($j=0;$j<=$c-1;$j++)
			{
				$m++;
				$a++;

				$lote=$codigo[$j];
				echo "<tr><td width='60px'>$a";
				echo "</td><td align='justify'>".$categoria[$j];
				echo "</td><td>".$datos[$j];
				$sql="SELECT round(sum(neto_sin_humedad),2) as sin_humedad FROM tab_almacenaje WHERE id_lote='$lote'";
				$result_dos = mysql_query($sql,$con);
				while($row2 = mysql_fetch_array($result_dos))
					{
						$humedad=$row2['sin_humedad'];
						$disponible=$datos[$j]-$row2['sin_humedad'];
						echo "</td><td>".$humedad;
						echo "</td><td>".$disponible;
						
					}
	
			    $datos2[$j] = $humedad;
				$datos3[$j] = $disponible; 
				echo "</td><td>".number_format((($datos[$j]/$total)*100), 1, ',', '')."%";
				$por[$j]= round( ($datos[$j]/$total)*100, 1);
				if ($j==0) 
				{
					echo "</td><td rowspan=".$c.">".$total."</td></tr>";
				}
			}
			?>
			</tbody>
			</table>
		</div>
		<script type="text/javascript">
		
			
		
		$(function () {
		
			categories = [<?php for($y=0;$y<=$c-1;$y++) { echo "'".$categoria[$y]."',";}?>],
			name1 = 'Asignado',
			data1 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos[$x] ?>,
			                  
					}, 
					<?php }?>];
					
					name2 = 'Ocupado',
					data2 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos2[$x] ?>,
				                
					}, 
					<?php }?>];
					
					name3 = 'Disponible',
					data3 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos3[$x] ?>,
				                  
					}, 
					<?php }?>];
							
			
					
			var chart = $('#grafica2').highcharts({
				 chart: {
        			type: 'column'
        		},
					title: {
					text: 'Detalle de Lotes'
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
				 //   color: 'blue'
				},{
					name: name2,
					data: data2,
					//color: 'white'
				
				},{
					name: name3,
					data: data3,
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
		<div id="grafica2"></div>
	</div><!-- DESPACHO -->
   </div>