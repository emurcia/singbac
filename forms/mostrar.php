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
 <style>
 .th2 {
    background-color: #f2f2f2;
    color: #333;
  }
 .tr:nth-child(even) {background-color: #f2f2f2;}
 </style>
 <div class="row"><!--- INICIO ROW----->                    
          <div class="col-md-12">	
         	<div class="contendor" >
			<div id="consulta" style="overflow:scroll;height:auto;width:auto; overflow-y: hidden;" >
			<table width="100%">
			<thead>
				<tr class="th2">
                	<th>NUM</th>
					<th>LOTE</th>
                    <th>PRODUCTO</th>
                    <th>CANTIDAD ALMACENADA</th>
                    <th>CANTIDAD DESPACHADA</th>                    
                    <th>CANTIDAD DISPONIBLE</th>
					<th>DISPONIBLE (%)</th>
	
				</tr>
			</thead>
			<tbody>
            
            
<?php
			
			//$query = "SELECT * from tab_lote WHERE bandera= 0 and id_cliente='$id_cliente3' and id_silo='$id_silo2'"; 
			$query="SELECT b.nom_producto, a.* from tab_lote as a, tab_producto as b WHERE a.id_producto=b.id_producto AND a.bandera= 0 and a.id_cliente='$id_cliente3' and a.id_silo='$id_silo2' ";
			$result = mysql_query($query,$con);
			$c=0;
			$a=0;
			$m=0;
			$contador=0;
			$porcentaje=0.00;
			
			while($row = mysql_fetch_array($result))
			{
				$codigo[$c]=$row["id_lote"];
				$categoria[$c] = $row["num_lote"];
				$nom_producto[$c] = $row["nom_producto"];
				$c++;
			}
					
			for ($j=0;$j<=$c-1;$j++)
			{
				$m++;
				$a++;
      			$lote=$codigo[$j];
			    
				$sql="SELECT round(sum(neto_sin_humedad),2) as sin_humedad FROM tab_almacenaje WHERE id_lote='$lote'";
				$result_dos = mysql_query($sql,$con);
				while($row2 = mysql_fetch_array($result_dos))
					{
			    	$datos2[$j] = $row2['sin_humedad'];
					$totalentra=$totalentra+$datos2[$j];
					}
				
				$suma_salida="SELECT round(sum(peso_sin_humedad),2) as salida_sin_humedad FROM tab_salida WHERE id_lote='$lote'";
				$fila_suma_salida = mysql_query($suma_salida,$con);
				while($datos_salida = mysql_fetch_array($fila_suma_salida))
					{
						if($datos_salida['salida_sin_humedad']==""){
							$datos_salida['salida_sin_humedad']="0";
							}
					$datos3[$j] = $datos_salida['salida_sin_humedad']; 
					$totalsale=$totalsale+$datos3[$j];
					}
							
				//echo "</td><td>".($datos2[$j]-$datos3[$j]);
				$datos[$j] = ($datos2[$j]-$datos3[$j]);  
				$total = $total + ($datos2[$j]-$datos3[$j]);

			}
			for ($j=0;$j<=$c-1;$j++)
			{
			$b=$j+1;	
			echo "<tr class='tr'><td width='60px'>$b";
			echo "</td><td align='justify'>".$categoria[$j];
			echo "</td><td align='Justify'>".$nom_producto[$j];
			echo "</td><td>".$datos2[$j]; //CANTIDAD ALMACENADA
			echo "</td><td>".$datos3[$j]; // CANTIDAD DESPACHADA
			echo "</td><td>".$datos[$j]; // CANTIDAD DISPONIBLE
			
			echo "</td><td>".number_format(((($datos[$j])/$total)*100), 1, ',', '')."%"; // PORCENTAJE DISPONIBLE
			$porcentaje=$porcentaje+number_format(((($datos[$j])/$total)*100));
			}
					

			?>
            <tr class="th2">
                	<th colspan="2">TOTAL</th>
		            <th><?php echo $totalentra; ?></th>
                    <th><?php echo $totalsale; ?></th>                    
                    <th><?php echo $total; ?></th>
                    <th><?php echo number_format(($porcentaje), 1, ',', '')."%"; ?></th>

				</tr>
                
			</tbody>
			</table>
		</div>
		<script type="text/javascript">
		
			
		
		$(function () {
		
			categories = [<?php for($y=0;$y<=$c-1;$y++) { echo "'".$categoria[$y]."',";}?>],
			name1 = 'Almacenado',
			data1 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos2[$x] ?>,
			                  
					}, 
					<?php }?>];
					
					name2 = 'Despacho',
					data2 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos3[$x] ?>,
				                
					}, 
					<?php }?>];
					
					name3 = 'Disponible',
					data3 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos[$x] ?>,
				                  
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