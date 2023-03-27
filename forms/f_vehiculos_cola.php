<?PHP
ini_set('session.save_handler', 'files');
/***********esto es para cerrar sesion cuando se cierren todas las ventanas de la web**************/
//si es necesario cambiar la config. del php.ini desde tu script
ini_set("session.use_only_cookies","1");
ini_set("session.use_trans_sid","0");
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");


  $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
 $estado= $_SESSION['bandera_empresa'];
$id_usuario= $_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
 $acceso =$_SESSION['nivel_silo'];
  $nom_sistema=$_SESSION['nom_sistema'];
  
 $peso_bruto_url= $_GET['peso_bruto'];
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


if($_SESSION['permiso_silo']!='ok'){
	echo "<script language='javascript'>";
	echo "document.location.href='../index.php';";
	echo "</script>";
}
 
 // verifica permiso de escritura
$tabla="SELECT *  FROM t_usuarios where id_usuario='$id_usuario' and id_empresa='$id_empresa'";
 $result = mysql_query($tabla);
$array = mysql_fetch_assoc($result);
{
	$nivel1=$array['id_nivel'];
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
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.js"></script> 
<script src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery-1.4.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link rel="stylesheet" type="text/css" href="../css/estilo.css">
<link href="../images/favicon.ico" rel="icon">
</head> 
 

<body class="container"> 


<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ----><!-----fin menu ---->
<!-----fin menu ---->
<!-----fin menu ---->




<!--   INICIO CUERPO   -->
<!--   INICIO CUERPO   -->
<!--   INICIO CUERPO   -->
<!--   INICIO CUERPO   --><br><br><br>
<style>
 .th2 {
    background-color: #f2f2f2;
    color: #333;
  }
 .tr:nth-child(even) {background-color: #f2f2f2;}
 </style>

<div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
<div class="panel panel-primary">
      <div class="panel-heading"><strong> INFORMACION GENERAL</strong></div> 
           <!-- PANEL 1 --->                   
          <div class="col-md-13"><!--- INICIO ROW GRAFICA POR SILO----->  
    
         
            	<div class="container-fluid"> 
                
 <div class="table" style="overflow:scroll;height:auto;width:auto; overflow-y: hidden;"><table width="98%" style="table-layout:fixed" align="center" cellpadding="5" cellspacing="0" class="display" >
                
			<thead>                     
                              <tr>   
     							<th width="40px"><div align="left">N.</div></th>
                                <th width="60px"><div align="left"><a title='Ordenar por Fecha'>SILO</a></div></th>
								<th width="100px"><div align="left"><a title='Odenar por Cliente'>ALMACENAMIENTO </a></div></th>	
								<th width="100px"><div align="left"><a title='Odenar por Placa'>DESPACHO </a></div></th>
								<th width="100px"><div align="left"><a title='Odenar por Motorista'>DISPONIBILIDAD </a></div></th>
																 </tr>
        </thead>
       
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
						
					// $humedad_entrada= number_format($row_entrada['sin_humedad_entrada'], 2, ".", ",");	
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
				echo "<tr class='tr'><td>$a";
				echo "</td><td width='auto' align='left'>".$categoria[$j];	
				echo "</td><td width='auto' align='left'>".number_format($humedad_entrada2, 2, ".", ",");
				echo "</td><td width='auto' align='left'>".number_format($humedad_salida2, 2, ".", ",");
				echo "</td><td width='auto' align='left'>".number_format($disponible_almacen, 2, ".", ",");
		
				}
				echo "<tr><td colspan='2'> TOTALES";
				echo "</td><td>".number_format($suma_sin_humedad_entrada, 2, ".", ",");
				echo "</td><td>".number_format($suma_sin_humedad_salida, 2, ".", ",");
				echo "</td><td>".number_format($suma_disponible, 2, ".", ",");
					
			?>
			</tbody>
			</table>
		</div>

	
	</div><!-- DESPACHO -->
   </div>
   </div>
    
  </div> 
    
   </div>
</div>
</div>
           
<div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
     
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>VEHICULO EN COLA</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           <div class="container-fluid">
  <div class="row" >
  
  
  
  
  
  <!-- ALMACENAMIENTO -->
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>MODULO ALMACENAMIENTO</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
   <div>
<?php
$id_almacen="ALMACEN-0000000".$id_empresa;
	 $sql = "SELECT * FROM tab_almacenaje WHERE id_almacenaje!='$id_almacen' and tipo_peso=1 and id_empresa='$id_empresa' order by fecha_entrada desc, hora_entrada desc ";
 	 $result = mysql_query($sql,$con);
	 echo"<div class='table' style='overflow:scroll;height:auto;width:auto; overflow-y: hidden;'><table width='98%' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class=' display' >";
                    
                        echo"<thead>                     
                              <tr>   
     							<th width='40px'><div align='left'>N.</div></th>
                                <th width='100px'><div align='left'><a title='Ordenar por Fecha'>FECHA</a></div></th>
                                <th width='80px'><div align='left'><a  title='Odenar por Hora'>HORA </a></div></th>
								<th width='250px'><div align='left'><a title='Odenar por Cliente'>CLIENTE </a></div></th>	
								<th width='150px'><div align='left'><a title='Odenar por Placa'>PLACA </a></div></th>
								<th width='250px'><div align='left'><a title='Odenar por Motorista'>MOTORISTA </a></div></th>
								<th width='200px'><div align='left'><a title='Odenar por Lote'>LOTE </a></div></th>
								<th width='200px'><div align='left'><a title='Odenar por Silo'>SILO </a></div></th>
								 </tr>
        </thead>
        <tbody>";
		
		if ($result> 0){	
		while ($row = mysql_fetch_array($result)) 
		{
			 $id_empresa_busca=$row['id_cliente'];
			 $id_lote_busca=$row['id_lote'];
			 $id_silo_busca=$row['id_silo'];
			 $id_motorista_busca=$row['id_transportista'];
			 $usuario_busca=$row['id_usuario2'];
			 $usuario_modifica=$row['id_usuario_modifica'];	
			 $fecha_imprime=parseDatePhp($row['fecha_entrada']);

			$tabla2="SELECT * FROM tab_cliente WHERE id_cliente='$id_empresa_busca' and id_empresa='$id_empresa'";
			$select2=mysql_query($tabla2,$con);
			while($row2=mysql_fetch_array($select2)) {
			$nom_empresa=$row2['nom_cliente'];
			}
				$tabla3="SELECT * FROM tab_lote WHERE id_lote='$id_lote_busca' and id_empresa='$id_empresa'";
				$select3=mysql_query($tabla3,$con);
				while($row3=mysql_fetch_array($select3)) {
				$num_lote=$row3['num_lote'];
				}
					$tabla4="SELECT * FROM tab_silo WHERE id_silo='$id_silo_busca' and id_empresa='$id_empresa'";
					$select4=mysql_query($tabla4,$con);
					while($row4=mysql_fetch_array($select4)) {
					$nom_silo=$row4['nom_silo'];
					}
						$tabla5="SELECT * FROM tab_transportista WHERE id_transportista='$id_motorista_busca' and id_empresa='$id_empresa'";
						$select5=mysql_query($tabla5,$con);
						while($row5=mysql_fetch_array($select5)) {
						$nom_transportista=$row5['nom_transportista']." ".$row5['ape_transportista'];
						$placa=$row5['placa_vehiculo'];
				
						}
		
		
											
		$cont=$contar+1;
		echo"<tr class='tr'>
			
		  <td width='auto' align='left'> $cont</td>
          <td width='auto' align='left'> $fecha_imprime</td>
		  <td width='auto' align='left'> $row[hora_entrada] </td>		  
		  <td width='auto' align='left'> $nom_empresa </td>
  		  <td width='auto' align='left'> $placa </td>	
 		  <td width='auto' align='left'> $nom_transportista </td>
		  <td width='auto' align='left'> $num_lote </td>
		  <td width='auto' align='left'> $nom_silo </td>
	
		</tr>";
		$contar++;
		}
			
		$correlativo++;		

		echo"</tbody>
	</table>
	";
}
	?>
    <!--Fin si se ha seleccionado administrador-->

<?php
//echo $correlativo;

echo "Total de Registros" ." ".$contar;
 
?>
  
</div>


           
          
</div>
</div>
</div>

</div>



<!-- DESPACHO -->

<div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>MODULO DESPACHO</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           

<div>
<?php
$id_salid="DESPACH-0000000".$id_empresa;
	 $sql = "SELECT * FROM tab_salida WHERE id_salida!='$id_salid' and bandera=1 and id_empresa='$id_empresa' order by fecha_entrada desc, hora_entrada desc ";
 	 $result = mysql_query($sql,$con);
	 echo"<div class='table' style='overflow:scroll;height:auto;width:auto; overflow-y: hidden;'><table width='98%' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class=' display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>   
     
                                
                                <th width='40px'><div align='left'>N.</div></th>
                                <th width='100px'><div align='left'><a title='Ordenar por Fecha'>FECHA</a></div></th>
                                <th width='80px'><div align='left'><a  title='Odenar por Hora'>HORA </a></div></th>
								<th width='250px'><div align='left'><a  title='Odenar por Cliente'>CLIENTE </a></div></th>	
								<th width='150px'><div align='left'><a  title='Odenar por Placa'>PLACA </a></div></th>
								<th width='200px'><div align='left'><a  title='Odenar por Motorista'>MOTORISTA </a></div></th>
								<th width='200px'><div align='left'><a  title='Odenar por Lote'>LOTE </a></div></th>
								<th width='200px'><div align='left'><a  title='Odenar por Silo'>SILO </a></div></th>
														 
	    </tr>
        </thead>
        <tbody>";
		
		if ($result> 0){	
		while ($row = mysql_fetch_array($result)) 
		{
			 $id_empresa_busca=$row['id_cliente'];
			 $id_lote_busca=$row['id_lote'];
			 $id_silo_busca=$row['id_silo'];
			 $id_motorista_busca=$row['id_transportista'];
			 $usuario_busca=$row['id_usuario2'];
			 $usuario_modifica=$row['id_usuario_modifica'];	
			 $fecha_imprime=parseDatePhp($row['fecha_entrada']);

			$tabla2="SELECT * FROM tab_cliente WHERE id_cliente='$id_empresa_busca' and id_empresa='$id_empresa'";
			$select2=mysql_query($tabla2,$con);
			while($row2=mysql_fetch_array($select2)) {
			$nom_empresa=$row2['nom_cliente'];
			}
				$tabla3="SELECT * FROM tab_lote WHERE id_lote='$id_lote_busca' and id_empresa='$id_empresa'";
				$select3=mysql_query($tabla3,$con);
				while($row3=mysql_fetch_array($select3)) {
				$num_lote=$row3['num_lote'];
				}
					$tabla4="SELECT * FROM tab_silo WHERE id_silo='$id_silo_busca' and id_empresa='$id_empresa'";
					$select4=mysql_query($tabla4,$con);
					while($row4=mysql_fetch_array($select4)) {
					$nom_silo=$row4['nom_silo'];
					}
						$tabla5="SELECT * FROM tab_transportista WHERE id_transportista='$id_motorista_busca' and id_empresa='$id_empresa'";
						$select5=mysql_query($tabla5,$con);
						while($row5=mysql_fetch_array($select5)) {
						$nom_transportista=$row5['nom_transportista']." ".$row5['ape_transportista'];
						$placa=$row5['placa_vehiculo'];
				
						}
		
		
											
		$cont2=$contar2+1;
		echo"<tr class='tr'>
			
		  <td width='auto' align='left'> $cont2</td>
          <td width='auto' align='left'> $fecha_imprime</td>
		  <td width='auto' align='left'> $row[hora_entrada] </td>		  
		  <td width='auto' align='left'> $nom_empresa </td>
  		  <td width='auto' align='left'> $placa </td>	
 		  <td width='auto' align='left'> $nom_transportista </td>
		  <td width='auto' align='left'> $num_lote </td>
		  <td width='auto' align='left'> $nom_silo </td>
		
		
		</tr>";
		$contar2++;
		}
			
	

		echo"</tbody>
	</table>
	";
}
	?>
    <!--Fin si se ha seleccionado administrador-->

<?php
//echo $correlativo;

echo "Total de Registros" ." ".$contar2;
 
?>
  
</div>


           
          
</div>
</div>
</div>

</div>
</div>

</div>
</div>
</div>
</div>
</div>
</div><br><br>
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->




<!--  INICIO FOOTER   -->
<!-- FIN FOOTER  -->




  <?php 
  mysql_close($con);
?>