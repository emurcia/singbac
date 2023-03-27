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
 <script type="text/javascript">
       $(document).ready(function() {
	  
		   $('#id_lote2').change(function() {//inicio1
			 $.post('mostrarporcliente.php', {id_cliente_busca:document.formulario.id_lote2.value}, 
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
<nav class="navbar navbar-inverse navbar-fixed-top"  role="navigation">
  <!-- El logotipo y el icono que despliega el menú se agrupan
       para mostrarlos mejor en los dispositivos móviles -->
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse"
            data-target=".navbar-ex1-collapse">
      <span class="sr-only">Desplegar navegación</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
  </div>

 
    <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
   
   <!-- menu -->
     <ul id="menu-bar">
     <?PHP
      $indicadorul = 0;
      $indicadorli = 1;
     // $consulta = mysql_query("SELECT * FROM tab_menu",$con);
	 $consulta = mysql_query("SELECT a.opcion_menu, a.url_menu, a.acceso_menu, a.nivel_menu FROM tab_menu as a, tab_detalle_menu as b, t_empresa as c WHERE a.id_menu=b.id_menu and b.id_nivel='".$acceso."' and b.id_empresa='$id_empresa' and c.estado='$estado' GROUP by a.id_menu ",$con);
      while($fila = mysql_fetch_array($consulta)){
          if((($fila['acceso_menu']==0) || ($fila['acceso_menu']==$acceso)) && (!empty($acceso))){
              if(($fila['nivel_menu']==2) && ($indicadorul==0)){  echo "<ul class='dropdown-menu'>"; $indicadorul=1; }
              if(($fila['nivel_menu']==1) && ($indicadorul==1)){  echo "</ul>"; $indicadorul=0; }
              
              if(($fila['nivel_menu']==1) && ($indicadorli == 0)){echo "</li>";$indicadorli=1;}
               
              if($fila['id_menu']==1)//Menu de inicio(index.php) debe de ir sin 'forms/'
                  echo "<li><div align='left'><a  href='../".utf8_encode($fila['url_menu'])."'>".utf8_encode($fila['opcion_menu'])."</div></a></li>";
              else{
                  if($fila['nivel_menu']==2)
                      echo "<li><a href='".utf8_encode($fila['url_menu'])."'><div align='left'>".utf8_encode($fila['opcion_menu'])."</div></a></li>";
                  else{
                      echo "<li><a href='".utf8_encode($fila['url_menu'])."'><div align='left'>".utf8_encode($fila['opcion_menu'])."</div></a>";
                      $indicadorli = 0;
                  }			  
              }
          }
      }
	  
	  
      echo "</li>";
		  
     ?>

       

      <li><a><?PHP echo $_SESSION['nombre_usuario_silo']; ?></a></li>
      <li><a onClick="salirr()"><button type="button" class="btn btn-danger btn-xs">Cerrar Sesión</button></a></li>
          
</ul>
    </div>
    
</nav>


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
      <div class="panel-heading"><strong>DATOS DEL CLIENTE "<?PHP echo $nom_cliente; ?>"</strong></div> 
           <!-- PANEL 1 ---><br>
                   
          <div class="row"><!--- INICIO ROW GRAFICA POR LOTE----->  
          <div class="col-md-1">
          </div>                  
          <div class="col-md-10" align="center">INFORMACION GENERAL
          <br>
          <table>
			<tbody>
            <?php
			$sql_silo="SELECT COUNT(a.id_silo) as numero_silos, b.id_silo FROM tab_silo as a, tab_lote as b WHERE b.id_silo=a.id_silo AND b.id_cliente='$cod_cliente' group by a.id_silo";
				$result_silo = mysql_query($sql_silo,$con);
				while($row_silo = mysql_fetch_array($result_silo))
					{
					$numsilos = $row_silo["numero_silos"]; // nombre de la categoria del gráfico
					}
							
			
				$sql_lot="SELECT COUNT(id_lote) as numero_lotes FROM tab_lote WHERE id_cliente='$cod_cliente' group by id_cliente";
				$result_lot = mysql_query($sql_lot,$con);
				while($row_lot = mysql_fetch_array($result_lot))
					{
					$numlotes = $row_lot["numero_lotes"]; // nombre de la categoria del gráfico
					}

				$sql_motorista="SELECT COUNT(id_transportista) as num_transportista FROM tab_transportista WHERE id_cliente='$cod_cliente'";
				$result_motorista = mysql_query($sql_motorista,$con);
				while($row_motorista = mysql_fetch_array($result_motorista))
					{
					$nummotorista = $row_motorista["num_transportista"]; // nombre de la categoria del gráfico
					}					
			
				echo "<tr><td align='justify'> CLIENTE / EMPRESA: </td><td colspan='5'>".$nom_cliente."</td></tr>";
				echo "<tr><td align='justify'> DIRECCION: </td><td colspan='5'>".$direccion_cliente."</td></tr>";
				echo "<tr><td align='justify'> TELEFONO: </td><td colspan='5'>".$telefono_cliente."</td></tr>";
				echo "<tr><td align='justify'> RESPONSABLE: </td><td colspan='5'>".$reponsable_cliente."</td></tr>";
				echo "<tr><td align='justify'> DIRECCION RESPONSABLE: </td><td colspan='5'>".$direccion_responsable."</td></tr>";
				echo "<tr><td align='justify'> TELEFONO RESPONSABLE: </td><td colspan='5'>".$tel_responsable."</td></tr>";	
				echo "<tr><td align='justify'> FECHA CREADO: </td><td colspan='5'>".$fecha_creado."</td></tr>";
				echo "<tr><td align='justify'> SILOS ASIGNADOS: </td><td colspan='5'>".$numsilos."</td></tr>";
				echo "<tr><td align='justify'> LOTES ASIGNADOS: </td><td colspan='5'>".$numlotes."</td></tr>";
				echo "<tr><td align='justify'> MOTORISTAS REGISTRADOS: </td><td colspan='5'>".$nummotorista."</td></tr>";																							
			?>
			</tbody>
			</table>
            <br>
         	<div class="contendor"> 
			<div id="consulta" style="overflow:scroll;height:auto;width:auto; overflow-y: hidden;" align="center">
			<table>
			<thead>
				<tr>
                	<th>NUM</th>
					<th>LOTE</th>
   					<th>PRODUCTO</th>
   					<th>SILO</th>                    
					<th>CAPACIDAD</th>                    
                    <th>ALMACEN</th>
                    <th>SALIDA</th>
                    <th>DISPONIBLE</th>
					<th>CAPACIDAD (%)</th>
				</tr>
                </thead>
			<tbody>
            
            
			<?php
		
			$query = "SELECT * from tab_lote WHERE id_cliente='$cod_cliente'"; 
			$result = mysql_query($query,$con);
			$c=0;
			$a=0;
			$total=0;
			$m=0;
			$contador=0;
			
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
				$sql_entrada="SELECT round(sum(neto_sin_humedad),2) as sin_humedad_entrada FROM tab_almacenaje WHERE id_lote='$lote' and bandera='2'";
				$result_entrada = mysql_query($sql_entrada,$con);
				while($row_entrada = mysql_fetch_array($result_entrada))
					{
					$humedad_entrada=$row_entrada['sin_humedad_entrada'];
					$suma_capacidad=$suma_capacidad+$producto[$j];
					$suma_sin_humedad_entrada=$suma_sin_humedad_entrada+$humedad_entrada;
					}
				
				$sql="SELECT round(sum(peso_sin_humedad),2) as sin_humedad FROM tab_salida WHERE id_lote='$lote' and bandera='2'";
				$result_dos = mysql_query($sql,$con);
				while($row2 = mysql_fetch_array($result_dos))
					{
						$humedad_salida=$row2['sin_humedad'];
						$suma_sin_humedad_salida=$suma_sin_humedad_salida+$humedad_salida;
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
				$disponible_almacen=$producto[$j]-$humedad_entrada+$humedad_salida;
				$suma_disponible=$suma_disponible+$disponible_almacen;
			     
				$disponible_porcen=number_format((($producto[$j]/$total)*100), 1, ',', '');
			
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
				echo "</td><td align='justify'>".$nom_silo;					
				echo "</td><td>".$producto[$j];			
				echo "</td><td>".$humedad_entrada2;
				echo "</td><td>".$humedad_salida2;
				echo "</td><td>".$disponible_almacen;
				echo "</td><td>".$disponible_porcen."%";
				}
				echo "<tr><td colspan='4'> TOTALES";
				echo "</td><td>".$suma_capacidad;
				echo "</td><td>".$suma_sin_humedad_entrada;
				echo "</td><td>".$suma_sin_humedad_salida;
				echo "</td><td>".$suma_disponible."</td></tr>";
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
		<div id="grafica2"></div>
	</div><!-- DESPACHO -->
   </div>
   </div>
   <br>
  <!-- INICIA GRAFICA CON DETALLE DE ALMACENAMIENTO  DE GRANOS BASICOS -->
         <div class="row"><!--- INICIO----->  
         <div class="col-md-1">
          </div>                  
          <div class="col-md-10" align="center"> ALMACENAMIENTO DE GRANOS BASICOS
         	<div class="contendor" >
			<div id="consulta" style="overflow:scroll;height:auto;width:auto; overflow-y: hidden;" align="center">
			<table>
			<thead>
				<tr>
                	<th>NUM</th>
					<th>LOTE</th>
   					<th>PRODUCTO</th>
   					<th>SILO</th>                    
					<th>CAPACIDAD</th>                    
                    <th>BRUTO</th>
                    <th>TARA</th>
                    <th>NETO</th>
                    <th>SIN HUMEDAD</th>
                    <th>CAPACIDAD (%)</th>
				</tr>
                </thead>
			<tbody>
            
            
			<?php
		
			$query = "SELECT * from tab_lote WHERE id_cliente='$cod_cliente'"; 
			$result = mysql_query($query,$con);
			$c=0;
			$a=0;
			$total=0;
			$m=0;
			$contador=0;
			
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
				$sql_entrada="SELECT round(sum(peso_bruto),2) as peso_bruto FROM tab_almacenaje WHERE id_lote='$lote' and bandera='2'";
				$result_entrada = mysql_query($sql_entrada,$con);
				while($row_entrada = mysql_fetch_array($result_entrada))
					{
					$peso_bruto1=$row_entrada['peso_bruto'];
					$suma_peso_bruto=$suma_peso_bruto+$peso_bruto1;
					}
				
				$sql_tara="SELECT round(sum(peso_tara),2) as peso_tara FROM tab_almacenaje WHERE id_lote='$lote' and bandera='2'";
				$result_tara = mysql_query($sql_tara,$con);
				while($row_tara = mysql_fetch_array($result_tara))
					{
						$peso_tara1=$row_tara['peso_tara'];
						$suma_peso_tara=$suma_peso_tara+$peso_tara1;
					}
					
				$sql_humedad="SELECT round(sum(neto_sin_humedad),2) as neto_sin_humedad FROM tab_almacenaje WHERE id_lote='$lote' and bandera='2'";
				$result_humedad = mysql_query($sql_humedad,$con);
				while($row_humedad = mysql_fetch_array($result_humedad))
					{
						$netohumedad=$row_humedad['neto_sin_humedad'];
						$suma_netohumedad=$suma_netohumedad+$netohumedad;
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
					
				if($peso_bruto1==""){
					$peso_bruto2=0.00;
					}else{
					$peso_bruto2=$peso_bruto1;
					}
						
				if($peso_tara1==""){
					$peso_tara2=0.00;
					}else{
					$peso_tara2=$peso_tara1;
					}
				if($netohumedad==""){
					$netohumedad2=0.00;
					}else{
					$netohumedad2=$netohumedad;
					}						
				$datos_bruto[$j] = $peso_bruto2; // DATOS PESO BRUTO	
				$datos_tara[$j] = $peso_tara2; // DATOS PESO TARA
				$datos_sin_humedad[$j] = $netohumedad2; // DATOS SIN HUMEDAD	
				$bruto_tara=$peso_bruto1-$peso_tara2;
				$suma_bruto_tara=$suma_bruto_tara+$bruto_tara;
				$datos_bruto_tara[$j] = $bruto_tara; // DATOS SIN HUMEDAD SALIDA	
			     
				$disponible_porcen=number_format((($producto[$j]/$total)*100), 1, ',', '');
				echo "<tr><td>$a";
				echo "</td><td align='justify'>".$categoria[$j];
				echo "</td><td align='justify'>".$nom_producto;	
				echo "</td><td align='justify'>".$nom_silo;					
				echo "</td><td>".$producto[$j];			
				echo "</td><td>".$peso_bruto2;
				echo "</td><td>".$peso_tara2;
				echo "</td><td>".$bruto_tara;
				echo "</td><td>".$netohumedad2;				
				echo "</td><td>".$disponible_porcen."%";
				}
				echo "<tr><td colspan='4'> TOTALES";
				echo "</td><td>".$suma_capacidad;
				echo "</td><td>".$suma_peso_bruto;
				echo "</td><td>".$suma_peso_tara;
				echo "</td><td>".$suma_bruto_tara;
				echo "</td><td>".$suma_netohumedad."</td></tr>";
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
					
					name2 = 'Bruto',
					data2 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos_bruto[$x] ?>,
             		}, 
					<?php }?>];
					
					name3 = 'Tara',
					data3 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos_tara[$x] ?>,
					}, 
					<?php }?>];
					
					name4 = 'Sin Humedad',
					data4 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos_sin_humedad[$x] ?>,
					}, 
					<?php }?>];
							
			
					
			var chart = $('#gentrada').highcharts({
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
		<div id="gentrada"></div>
	</div>
   </div>
   </div> <!-- FIN -->
   <br>
  <div class="row"><!--- INICIO----->  
         <div class="col-md-1">
          </div>                  
          <div class="col-md-10" align="center"> DESPACHO DE GRANOS BASICOS
         	<div class="contendor" >
			<div id="consulta" style="overflow:scroll;height:auto;width:auto; overflow-y: hidden;" align="center">
			<table>
			<thead>
				<tr>
                	<th>NUM</th>
					<th>LOTE</th>
   					<th>PRODUCTO</th>
   					<th>SILO</th>                    
					<th>CAPACIDAD</th>                    
                    <th>BRUTO</th>
                    <th>TARA</th>
                    <th>NETO</th>
                    <th>SIN HUMEDAD</th>
                    <th>CAPACIDAD (%)</th>
				</tr>
                </thead>
			<tbody>
            
            
			<?php
		
			$query = "SELECT * from tab_lote WHERE id_cliente='$cod_cliente'"; 
			$result = mysql_query($query,$con);
			$c=0;
			$a=0;
			$total=0;
			$m=0;
			$contador=0;
			
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
				$sql_entrada="SELECT round(sum(peso_bruto),2) as peso_bruto FROM tab_salida WHERE id_lote='$lote' and bandera='2'";
				$result_entrada = mysql_query($sql_entrada,$con);
				while($row_entrada = mysql_fetch_array($result_entrada))
					{
					$peso_bruto1s=$row_entrada['peso_bruto'];
					$suma_peso_brutos=$suma_peso_brutos+$peso_bruto1s;
					}
				
				$sql_tara="SELECT round(sum(peso_tara),2) as peso_tara FROM tab_salida WHERE id_lote='$lote' and bandera='2'";
				$result_tara = mysql_query($sql_tara,$con);
				while($row_tara = mysql_fetch_array($result_tara))
					{
						$peso_tara1s=$row_tara['peso_tara'];
						$suma_peso_taras=$suma_peso_taras+$peso_tara1s;
					}
					
				$sql_humedad="SELECT round(sum(peso_sin_humedad),2) as neto_sin_humedad FROM tab_salida WHERE id_lote='$lote' and bandera='2'";
				$result_humedad = mysql_query($sql_humedad,$con);
				while($row_humedad = mysql_fetch_array($result_humedad))
					{
						$netohumedads=$row_humedad['neto_sin_humedad'];
						$suma_netohumedads=$suma_netohumedads+$netohumedads;
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
					
				if($peso_bruto1s==""){
					$peso_bruto2s=0.00;
					}else{
					$peso_bruto2s=$peso_bruto1s;
					}
						
				if($peso_tara1s==""){
					$peso_tara2s=0.00;
					}else{
					$peso_tara2s=$peso_tara1s;
					}
				if($netohumedads==""){
					$netohumedad2s=0.00;
					}else{
					$netohumedad2s=$netohumedads;
					}						
				$datos_brutos[$j] = $peso_bruto2s; // DATOS PESO BRUTO	
				$datos_taras[$j] = $peso_tara2s; // DATOS PESO TARA
				$datos_sin_humedads[$j] = $netohumedad2s; // DATOS SIN HUMEDAD	
				$bruto_taras=$peso_bruto1s-$peso_tara2s;
				$suma_bruto_taras=$suma_bruto_taras+$bruto_taras;
				$datos_bruto_taras[$j] = $bruto_taras; // DATOS SIN HUMEDAD SALIDA	
			     
				$disponible_porcen=number_format((($producto[$j]/$total)*100), 1, ',', '');
				echo "<tr><td>$a";
				echo "</td><td align='justify'>".$categoria[$j];
				echo "</td><td align='justify'>".$nom_producto;	
				echo "</td><td align='justify'>".$nom_silo;					
				echo "</td><td>".$producto[$j];			
				echo "</td><td>".$peso_bruto2s;
				echo "</td><td>".$peso_tara2s;
				echo "</td><td>".$bruto_taras;
				echo "</td><td>".$netohumedad2s;				
				echo "</td><td>".$disponible_porcen."%";
				}
				echo "<tr><td colspan='4'> TOTALES";
				echo "</td><td>".$suma_capacidad;
				echo "</td><td>".$suma_peso_brutos;
				echo "</td><td>".$suma_peso_taras;
				echo "</td><td>".$suma_bruto_taras;
				echo "</td><td>".$suma_netohumedads."</td></tr>";
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
					
					name2 = 'Bruto',
					data2 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos_brutos[$x] ?>,
             		}, 
					<?php }?>];
					
					name3 = 'Tara',
					data3 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos_taras[$x] ?>,
					}, 
					<?php }?>];
					
					name4 = 'Sin Humedad',
					data4 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos_sin_humedads[$x] ?>,
					}, 
					<?php }?>];
							
			
					
			var chart = $('#gsalida').highcharts({
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
		<div id="gsalida"></div>
	</div>
   </div>
   </div> <!-- FIN -->
   <br>
   <br>
   <!-- GRAFICA POR SERVICIOS -->
     <div class="row"><!--- INICIO----->  
         <div class="col-md-1">
          </div>                  
          <div class="col-md-10" align="center"> SERVICIOS RECIBIDOS
        <div class="contendor">
		<div id="consulta" style="overflow:scroll;height:auto;width:auto; overflow-y: hidden;" align="center">
			<table>
			<thead>
				<tr>
                	<th colspan="5">ALMACENAJE</th>
   					<th colspan="5">DESPACHO</th>
   					<th colspan="5">BASCULA</th>                    
				</tr>
                <tr>
                	<th>REGISTROS</th>
   					<th>BRUTO</th>
   					<th>TARA</th>                    
   					<th>NETO</th>                                        
   					<th>SIN HUMEDAD</th> 
                    <th>REGISTROS</th>
   					<th>BRUTO</th>
   					<th>TARA</th>                    
   					<th>NETO</th>                                        
   					<th>SIN HUMEDAD</th> 
                    <th>REGISTROS</th>
   					<th>BRUTO</th>
   					<th>TARA</th>                    
   					<th>NETO</th>                                        
                              
				</tr>
                </thead>
			<tbody>
            
            
			<?php
			$c=0;
			$c1=0;
			$c2=0;
				$sql_servicio_entrada="SELECT COUNT(id_almacenaje) as suma_entrada, SUM(peso_bruto) AS peso_bruto_entrada, SUM(peso_tara) as peso_tara_entrada, SUM(neto_sin_humedad) as neto_humedad_entrada FROM tab_almacenaje WHERE id_cliente='$cod_cliente'";
				$result_servicio_entrada = mysql_query($sql_servicio_entrada,$con);
				while($row_servicio_entrada = mysql_fetch_array($result_servicio_entrada))
					{
					$operaciones_servicio_entrada=$row_servicio_entrada['suma_entrada'];
					$bruto_servicio_entrada=$row_servicio_entrada['peso_bruto_entrada'];
					$tara_servicio_entrada=$row_servicio_entrada['peso_tara_entrada'];
					$humedad_servicio_entrada=$row_servicio_entrada['neto_humedad_entrada'];										
					$datos_almacen[$c] = $operaciones_servicio_entrada; // DATOS PESO BRUTO
					$c++;
					}
					
					$sql_servicio_salida="SELECT COUNT(id_salida) as suma_salida, SUM(peso_bruto) AS peso_bruto_salida, SUM(peso_tara) as peso_tara_salida, SUM(peso_sin_humedad) as neto_humedad_salida FROM tab_salida WHERE id_cliente='$cod_cliente' and bandera='2'";
				$result_servicio_salida = mysql_query($sql_servicio_salida,$con);
				while($row_servicio_salida = mysql_fetch_array($result_servicio_salida))
					{
					$operaciones_servicio_salida=$row_servicio_salida['suma_salida'];
					$bruto_servicio_salida=$row_servicio_salida['peso_bruto_salida'];
					$tara_servicio_salida=$row_servicio_salida['peso_tara_salida'];
					$humedad_servicio_salida=$row_servicio_salida['neto_humedad_salida'];	
					$datos_salida[$c1] = $operaciones_servicio_salida; // DATOS PESO TARA									
					$c1++;
					}
					
					$sql_servicio_bascula="SELECT COUNT(id_bascula) as suma_bascula, SUM(peso_bruto) AS peso_bruto_bascula, SUM(peso_tara) as peso_tara_bascula FROM tab_bascula WHERE id_cliente='$cod_cliente'";
				$result_servicio_bascula = mysql_query($sql_servicio_bascula,$con);
				while($row_servicio_bascula = mysql_fetch_array($result_servicio_bascula))
					{
					$operaciones_servicio_bascula=$row_servicio_bascula['suma_bascula'];
					$bruto_servicio_bascula=$row_servicio_bascula['peso_bruto_bascula'];
					$tara_servicio_bascula=$row_servicio_bascula['peso_tara_bascula'];
					$datos_bascula[$c2] = $operaciones_servicio_bascula; // DATOS SIN HUMEDAD	
					$c2++;
					}
				
				
			for ($d=0;$d<=1;$d++)
			{
					
				$categoriass[$d]="SERVICIOS";
	
	$d++;
			}
							     
				echo "<tr><td>".$operaciones_servicio_entrada;
				echo "</td><td>".$bruto_servicio_entrada;
				echo "</td><td>".$tara_servicio_entrada;					
				echo "</td><td>".($bruto_servicio_entrada-$tara_servicio_entrada);					
				echo "</td><td>".number_format($humedad_servicio_entrada,2,',','');			
				
				echo "</td><td>".$operaciones_servicio_salida;
				echo "</td><td>".$bruto_servicio_salida;
				echo "</td><td>".$tara_servicio_salida;					
				echo "</td><td>".($bruto_servicio_salida-$tara_servicio_salida);					
				echo "</td><td>".number_format($humedad_servicio_salida,2,',','');
				
				echo "</td><td>".$operaciones_servicio_bascula;
				echo "</td><td>".$bruto_servicio_bascula;
				echo "</td><td>".$tara_servicio_bascula;					
				echo "</td><td>".($bruto_servicio_bascula-$tara_servicio_bascula);					
		
				echo "</td></tr>";
				
			?>
			</tbody>
			</table>
		</div>
		<script type="text/javascript">
		$(function () {
			var colors = Highcharts.getOptions().colors,
			categories = [<?php for($y=0;$y<=$c-1;$y++) { echo "'".$categoriass[$y]."',";}?>],
			name1 = 'ALMACENAMIENTO',
			data1 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos_almacen[$x] ?>,
             		}, 
					<?php }?>];
					
					name2 = 'DESPACHO',
					data2 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos_salida[$x] ?>,
             		}, 
					<?php }?>];
					
					name3 = 'BASCULA',
					data3 = [<?php for($x=0;$x<=$c-1;$x++){?>	
					{
					y: <?php echo $datos_bascula[$x] ?>,
					}, 
					<?php }?>];
											
			
					
			var chart = $('#gservicios').highcharts({
				 chart: {
        			type: 'column'
        		},
					title: {
					text: 'Detalle de servicios recibidos'
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
				}
				],
				exporting: {
					enabled: true
				}
			})
			.highcharts(); 
		});
		</script>
		<div id="gservicios"></div>
	</div>
   </div>
   </div> <!-- FIN -->
 <br><br>
 
  <!-- GRAFICA POR ENTRADA PRODUCTO -->
     <div class="row"><!--- INICIO----->  
         <div class="col-md-1">
          </div>                  
          <div class="col-md-10" align="center"> ENTRADA DE GRANOS BASICOS (EN KILOGRAMOS)
        <div class="contendor">
		<div id="consulta" style="overflow:scroll;height:auto;width:auto; overflow-y: hidden;" align="center">
			<table>
			<thead>
				<tr>

               		<th colspan="6"></th>
                    <th colspan="4">ALMACENAMIENTO</th>
   					<th colspan="2">ACUMULADO</th>
                   
				</tr>
                <tr>
                	<th>N°</th>
   					<th>FECHA</th>
   					<th>HORA</th>                    
   					<th>PROCEDENCIA</th>
                    <th>PLACA</th> 
   					<th>PILOTO</th>                                        
   					<th>BRUTO</th>                                        
   					<th>TARA</th> 
                    <th>NETO</th>
					<th>NETO SIN HUMEDAD</th>                    
   					<th>CON HUMEDAD</th>
                    <th>SIN HUMEDAD</th>
                             
				</tr>
                </thead>
			<tbody>
            
            
			<?php
			$c=0;
			$c1=0;
			$c2=0;
			$num=1;
			$suma_kardex_brutoe=0;
			$suma_kardex_tarae=0;
			$suma_kardex_netoe=0;
		
			
				$sql_kardex_entrada="SELECT a.id_kardex, a.id_almacenaje as kardex_entra, a.id_salida as kardex_sal, a.fecha, a.hora, b.id_almacenaje as entrada, b.hora_entrada as hentrada, b.peso_bruto as pbruto_entra, b.peso_tara as ptara_entra, b.id_cliente as id_cliente_ent, b.id_transportista as id_trans_entra, b.id_lote, b.neto_sin_humedad, d.id_cliente FROM tab_kardex as a, tab_almacenaje as b, tab_cliente as d WHERE a.id_almacenaje=b.id_almacenaje  and  b.id_cliente=d.id_cliente and d.id_cliente='$cod_cliente' and b.bandera='2' order by a.fecha ASC, a.hora ASC ";
		$result_kardex_entrada = mysql_query($sql_kardex_entrada,$con);
		while($row_kardex_entrada = mysql_fetch_array($result_kardex_entrada))
		{
						
								
				if($row_kardex_entrada['pbruto_sale']==0){
					$row_kardex_entrada['pbruto_sale']="";
					$row_kardex_entrada['ptara_sale']="";
					
					$id_trans=$row_kardex_entrada['id_trans_entra'];
						$trans=mysql_query("SELECT * FROM tab_transportista WHERE id_transportista='$id_trans'",$con);
						$array2 = mysql_fetch_assoc($trans);
						{
						 $transportita=$array2['nom_transportista']." ".$array2['ape_transportita'];
						 $placa=$array2['placa_vehiculo'];
						}
					}
					
					$lot=$row_kardex_entrada['id_lote'];
					$id_lote=mysql_query("SELECT * FROM tab_lote as a, tab_origen as b WHERE a.id_origen=b.id_origen and a.id_lote='$lot'",$con);
					$array3 = mysql_fetch_assoc($id_lote);
						{
						 $origen=$array3['nom_origen'];
						}
					
												
				if(($row_kardex_entrada['pbruto_entra']-$row_kardex_entrada['ptara_entra'])==0){
					$saldo="";
					$saldo_humedad="";
					}else{
					$saldo=	($row_kardex_entrada['pbruto_entra']-$row_kardex_entrada['ptara_entra']);
					$saldo_humedad=$row_kardex_entrada['neto_sin_humedad'];
					}	
					
					
					
				if($row_kardex_entrada['ptara_entra']==0){
					$row_kardex_entrada['ptara_entra']="";
					}					
				
				$suma_kardex_brutoe=$suma_kardex_brutoe+$row_kardex_entrada['pbruto_entra'];
				$suma_kardex_tarae=$suma_kardex_tarae+$row_kardex_entrada['ptara_entra'];
				$suma_kardex_netoe=$suma_kardex_netoe+$saldo;
				$suma_kardex_humedad=$saldo_karde_humedad+$row_kardex_entrada['neto_sin_humedad'];
															
					
				echo "<tr><td>".$num;
				echo "</td><td>".parseDatePhp($row_kardex_entrada['fecha']);
				echo "</td><td>".$row_kardex_entrada['hentrada'];				
				echo "</td><td>".$origen;
			//	echo "</td><td>".$row_kardex_entrada['id_lote'];
				echo "</td><td>".$placa;				
				echo "</td><td>".$transportita;						
				echo "</td><td>".$row_kardex_entrada['pbruto_entra'];
				echo "</td><td>".$row_kardex_entrada['ptara_entra'];
				echo "</td><td>".$saldo	;
				echo "</td><td>".$saldo_humedad;
				echo "</td><td>".($saldo_kardex=$saldo_kardex+$saldo);	
				echo "</td><td>".($saldo_karde_humedad=$saldo_karde_humedad+$saldo_humedad);					
				echo "</td></tr>";
				$num++;
		}
				echo "<tr><td colspan='6'> TOTALES";
				echo "</td><td>".$suma_kardex_brutoe;
				echo "</td><td>".$suma_kardex_tarae;
				echo "</td><td>".$suma_kardex_netoe;
				echo "</td><td>".$saldo_karde_humedad;	
											
				echo "</td></tr>";
			?>
			</tbody>
			</table>
		</div>
		</div>
   </div>
   </div> <!-- FIN -->  
 
 <br>
 <br>
   <!-- GRAFICA POR SALIDA PRODUCTO -->
     <div class="row"><!--- INICIO----->  
         <div class="col-md-1">
          </div>                  
          <div class="col-md-10" align="center"> SALIDA DE GRANOS BASICOS (EN KILOGRAMOS)
        <div class="contendor">
		<div id="consulta" style="overflow:scroll;height:auto;width:auto; overflow-y: hidden;" align="center">
			<table>
			<thead>
				<tr>

               		<th colspan="6"></th>
                    <th colspan="4">DESPACHO</th>
   					                   
				</tr>
                <tr>
                	<th>N°</th>
   					<th>FECHA</th>
   					<th>HORA</th>                    
   					<th>ORIGEN</th>
                    <th>PLACA</th> 
   					<th>PILOTO</th>                                        
   					<th>BRUTO</th>                                        
   					<th>TARA</th> 
                    <th>NETO</th>
				    <th>SALIDA</th>
                             
				</tr>
                </thead>
			<tbody>
            
            
			<?php
			$c=0;
			$c1=0;
			$c2=0;
			$num=1;
			$suma_kardex_brutoe=0;
			$suma_kardex_tarae=0;
			$suma_kardex_netoe=0;
		
			
				$sql_kardex_salida="SELECT a.id_kardex, a.id_salida as kardex_entra, a.id_salida as kardex_sal, a.fecha, a.hora, b.id_salida as entrada, b.hora_entrada as hentrada, b.peso_bruto as pbruto_entra, b.peso_tara as ptara_entra, b.id_cliente as id_cliente_ent, b.id_transportista as id_trans_entra, b.id_lote, b.peso_sin_humedad, d.id_cliente FROM tab_kardex as a, tab_salida as b, tab_cliente as d WHERE a.id_salida=b.id_salida  and  b.id_cliente=d.id_cliente and d.id_cliente='$cod_cliente' and b.bandera='2' order by a.fecha ASC, a.hora ASC ";
		$result_kardex_salida = mysql_query($sql_kardex_salida,$con);
		while($row_kardex_salida = mysql_fetch_array($result_kardex_salida))
		{
								
				if($row_kardex_salida['pbruto_sale']==0){
					$row_kardex_salida['pbruto_sale']="";
					$row_kardex_salida['ptara_sale']="";
					
					$id_trans=$row_kardex_salida['id_trans_entra'];
						$trans=mysql_query("SELECT * FROM tab_transportista WHERE id_transportista='$id_trans'",$con);
						$array2 = mysql_fetch_assoc($trans);
						{
						 $transportita=$array2['nom_transportista']." ".$array2['ape_transportita'];
						 $placa=$array2['placa_vehiculo'];
						}
					}
					
					$lot=$row_kardex_salida['id_lote'];
					$id_lote=mysql_query("SELECT * FROM tab_lote as a, tab_origen as b WHERE a.id_origen=b.id_origen and a.id_lote='$lot'",$con);
					$array3 = mysql_fetch_assoc($id_lote);
						{
						 $origen=$array3['nom_origen'];
						}
					
												
				if(($row_kardex_salida['pbruto_entra']-$row_kardex_salida['ptara_entra'])==0){
					$saldo="";
					$saldo_humedad="";
					}else{
					$saldo=	($row_kardex_salida['pbruto_entra']-$row_kardex_salida['ptara_entra']);
					$saldo_humedads=$row_kardex_salida['peso_sin_humedad'];
					}	
					
					
					
				if($row_kardex_salida['ptara_entra']==0){
					$row_kardex_salida['ptara_entra']="";
					$row_kardex_salida['pbruto_entra']="";
					}					
				
				$suma_kardex_brutos=$suma_kardex_brutos+$row_kardex_salida['pbruto_entra'];
				$suma_kardex_taras=$suma_kardex_taras+$row_kardex_salida['ptara_entra'];
				$suma_kardex_netos=$suma_kardex_netos+$saldo;
																		
					
				echo "<tr><td>".$num;
				echo "</td><td>".parseDatePhp($row_kardex_salida['fecha']);
				echo "</td><td>".$row_kardex_salida['hentrada'];				
				echo "</td><td>".$origen;
			//	echo "</td><td>".$row_kardex_entrada['id_lote'];
				echo "</td><td>".$placa;				
				echo "</td><td>".$transportita;						
				echo "</td><td>".$row_kardex_salida['pbruto_entra'];
				echo "</td><td>".$row_kardex_salida['ptara_entra'];
				echo "</td><td>".$saldo	;

				echo "</td><td>".($saldo_kardexs=$saldo_kardexs+$saldo);	
				
				echo "</td></tr>";
				$num++;
		}
				echo "<tr><td colspan='6'> TOTALES";
				echo "</td><td>".$suma_kardex_brutos;
				echo "</td><td>".$suma_kardex_taras;
				echo "</td><td>".$suma_kardex_netos;
				echo "</td></tr>";
			?>
			</tbody>
			</table>
		</div>
		</div>
   </div>
   </div> <!-- FIN -->  
 
 <br>
 <br>
 
 
    <!-- GRAFICA POR KARDEX -->
     <div class="row"><!--- INICIO----->  
         <div class="col-md-1">
          </div>                  
          <div class="col-md-10" align="center"> KARDEX
        <div class="contendor">
		<div id="consulta" style="overflow:scroll;height:auto;width:auto; overflow-y: hidden;" align="center">
			<table>
			<thead>
				<tr>

               		<th colspan="4"></th>
                    <th colspan="3">ALMACENAMIENTO</th>
   					<th colspan="3">DESPACHO</th>
    				<th rowspan="2">SALDO</th>
                   
				</tr>
                <tr>
                	<th>N°</th>
   					<th>FECHA</th>
   					<th>CONCEPTO</th>
   					<th>MOTORISTA</th>                                        
   					<th>BRUTO</th>                                        
   					<th>TARA</th> 
                    <th>NETO</th>
   					<th>BRUTO</th>
   					<th>TARA</th>                    
   					<th>NETO</th>                                        
   					
                                  
                              
				</tr>
                </thead>
			<tbody>
            
            
			<?php
			$c=0;
			$c1=0;
			$c2=0;
			$num=1;
			$suma_kardex_brutoe=0;
			$suma_kardex_tarae=0;
			$suma_kardex_netoe=0;
			$suma_kardex_brutos=0;
			$suma_kardex_taras=0;
			$suma_kardex_netos=0;
			
				$sql_kardex="SELECT a.id_kardex, a.id_almacenaje as kardex_entra, a.id_salida as kardex_sal, a.fecha, a.hora, b.id_almacenaje as entrada, b.peso_bruto as pbruto_entra, b.peso_tara as ptara_entra, b.id_cliente as id_cliente_ent, b.id_transportista as id_trans_entra, c.peso_bruto as pbruto_sale, c.peso_tara as ptara_sale, c.id_cliente as id_cliente_sal, c.id_transportista as id_trans_sale, d.id_cliente FROM tab_kardex as a, tab_almacenaje as b, tab_salida as c, tab_cliente as d WHERE a.id_almacenaje=b.id_almacenaje and a.id_salida=c.id_salida and (c.id_cliente=d.id_cliente or b.id_cliente=d.id_cliente) and (b.bandera='2' or c.bandera='2') and d.id_cliente='$cod_cliente' order by a.fecha ASC, a.hora ASC ";
		$result_kardex = mysql_query($sql_kardex,$con);
		while($row_kardex = mysql_fetch_array($result_kardex))
		{
				if($row_kardex['pbruto_entra']==0){
					$concepto="SALIDA";
					$row_kardex['pbruto_entra']="";
					$row_kardex['tara_entra']="";
					$id_trans=$row_kardex['id_trans_sale'];
						$trans=mysql_query("SELECT * FROM tab_transportista WHERE id_transportista='$id_trans'",$con);
						$array2 = mysql_fetch_assoc($trans);
						{
						 $transportita=$array2['nom_transportista']." ".$array2['ape_transportita'];
						}					
					}
				if($row_kardex['ptara_entra']==0){
					$row_kardex['ptara_entra']="";
					}					
								
				if($row_kardex['pbruto_sale']==0){
					$concepto="ENTRADA";
					$row_kardex['pbruto_sale']="";
					$row_kardex['ptara_sale']="";
					$id_trans=$row_kardex['id_trans_entra'];
						$trans=mysql_query("SELECT * FROM tab_transportista WHERE id_transportista='$id_trans'",$con);
						$array2 = mysql_fetch_assoc($trans);
						{
						 $transportita=$array2['nom_transportista']." ".$array2['ape_transportita'];
						}
					}
												
				if(($row_kardex['pbruto_entra']-$row_kardex['ptara_entra'])==0){
					$saldo="";
					}else{
					$saldo=	($row_kardex['pbruto_entra']-$row_kardex['ptara_entra']);
					}	
					if($row_kardex['pbruto_entra']==0){
					$concepto="SALIDA";
					$row_kardex['pbruto_entra']="";
					}
					
					
				if($row_kardex['ptara_entra']==0){
					$row_kardex['ptara_entra']="";
					}					
								
							
				if(($row_kardex['pbruto_sale']-$row_kardex['ptara_sale'])==0){
					$saldo_sale="";
					}else{
					$saldo_sale=	($row_kardex['pbruto_sale']-$row_kardex['ptara_sale']);
					}	
				$suma_kardex_brutoe=$suma_kardex_brutoe+$row_kardex['pbruto_entra'];
				$suma_kardex_tarae=$suma_kardex_tarae+$row_kardex['ptara_entra'];
				$suma_kardex_netoe=$suma_kardex_netoe+$saldo;
				$suma_kardex_brutos=$suma_kardex_brutos+$row_kardex['pbruto_sale'];
				$suma_kardex_taras=$suma_kardex_taras+$row_kardex['ptara_sale'];
				$suma_kardex_netos=$suma_kardex_netos+$saldo_sale;													
					
				echo "<tr><td>".$num;
				echo "</td><td>".parseDatePhp($row_kardex['fecha']);
				echo "</td><td>".$concepto;
				echo "</td><td>".$transportita;						
				echo "</td><td>".$row_kardex['pbruto_entra'];
				echo "</td><td>".$row_kardex['ptara_entra'];
				echo "</td><td>".$saldo	;
				echo "</td><td>".$row_kardex['pbruto_sale'];
				echo "</td><td>".$row_kardex['ptara_sale'];
				echo "</td><td>".$saldo_sale;
				echo "</td><td>".($saldo_kardex=$saldo_kardex+$saldo-$saldo_sale);	
				echo "</td></tr>";
				$num++;
		}
				echo "<tr><td colspan='4'> TOTALES";
				echo "</td><td>".$suma_kardex_brutoe;
				echo "</td><td>".$suma_kardex_tarae;
				echo "</td><td>".$suma_kardex_netoe;	
				echo "</td><td>".$suma_kardex_brutos;
				echo "</td><td>".$suma_kardex_taras;
				echo "</td><td>".$suma_kardex_netos;							
				echo "</td></tr>";
			?>
			</tbody>
			</table>
		</div>
		</div>
   </div>
   </div> <!-- FIN -->  
   
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
<div class="navbar navbar-inverse navbar-fixed-bottom">
   <div class="container">
      <p class="navbar-text">
         Diseñado y Desarrollado Por <a href="http://www.ie-networks.com/">Ie Networks</a> © 2017.
      </p>
   </div>
</div>
<!-- FIN FOOTER  -->

</body> 
</html>

