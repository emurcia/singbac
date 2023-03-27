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
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="../css/datepicker.css">
<script src="http://code.jquery.com/jquery.js"></script> 
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-datepicker.js"></script> 

<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 

<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
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
			document.formulario.bandera.value='ok';
			document.formulario.submit();
		
}// fin guardar

function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }
 
  function reporte(){
	 window.open('../reportes/Rp_diario.php?id2='+document.formulario.fec1.value+'&id3='+document.formulario.fec2.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
}
</script>


  
<?php
	$bandera = $_POST['bandera'];
    echo "<script language='javascript'>";
    if($bandera=="oki")
    {//inicio if bandera ok
	   //$stringEjecucion = mysql_query ("insert into t_bitacora(id_usu,entradaBitacora,horaBitacora,diaBitacora) values ('$id_empleado','0',CURTIME(),CURDATE());",$conexion);			
 	   session_unset();
	   session_destroy();     
       echo "document.location.href='../index.php';";
     }//Fin if bandera ok
	 echo "</script>";
?>
 		
 

<body class="container" <?PHP if($guarda == 2) echo "onload='datos()';"; ?> > 


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

  <div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>REPORTE DIARIO</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
          		<form action="f_rep_diario.php" class="formusu" method="post" name="formulario" role="form">  
        <input name="bandera" value="0" type="hidden" />     
	       <input type="hidden"  name="busca">
	       <input type="hidden"  name="seleccion">           
            <input type="hidden" name="fecha_inicio11">
            <input type="hidden" name="fecha_fin11">  
 			<input type="hidden"  name="reporte" value="<?PHP echo $_POST['id_cliente']; ?>">
            <input type="hidden"  name="fec1" value="<?PHP echo $_POST['fec_inicio']; ?>">           
            <input type="hidden"  name="fec2" value="<?PHP echo $_POST['fec_fin']; ?>">            
        
            
                <div class="row"><!--- INICIO ROW----->
              <div class="col-md-12">
              <div class="form-group">
               <label>FECHA NICIO</label>
                <input type="text" class="form-control input-lg datepicker" id="fec_inicio" placeholder="Fecha" name="fec_inicio" value="<?PHP echo $fecha;?>" readonly style="background:#FFF;">
              </div>
              </div>
            </div><!--- FIN ROW-----> 
            
             <div class="row"><!--- INICIO ROW----->
              <div class="col-md-12">
              <div class="form-group">
               <label>FECHA FIN</label>
                <input type="text" class="form-control input-lg datepicker" id="fec_fin" placeholder="Fecha" name="fec_fin" value="<?PHP echo $fecha;?>" readonly style="background:#FFF;">
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

</div></div>


</div>
<!-- Inicia paginacion para mostrar los usuarios -->

  <div class="container-fluid">
  <div class="row" >
      <div class="col-md-12">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>INGRESOS / SALIDA DE GRANOS BASICOS DIARIOS</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 				<div>


                
<?php
						
 if($bandera=="ok" )
   {//
// $seleccion1=$_POST['seleccion']; 
 $fecha_inicio_buscar = parseDateMysql($_POST['fecha_inicio11']);
 $fecha_fin_buscar = parseDateMysql($_POST['fecha_fin11']);

 $sql = "SELECT a.id_kardex, a.id_almacenaje as kardex_entra, a.id_salida as kardex_sal, a.fecha as kardex_fec, a.hora as kardex_hor, b.fecha_entrada as fecha_entrada, b.id_almacenaje as entrada, (b.peso_bruto - b.peso_tara) as p_neto_entrada, b.id_cliente as id_cliente_ent, b.id_silo as silo_entrada, b.id_lote as id_lote_ent, c.id_silo as silo_salida, c.fecha_entrada as fecha_salida, c.id_salida as salida, (c.peso_bruto - c.peso_tara) as p_neto_salida, c.id_cliente as id_cliente_sal, c.id_lote as id_lote_sal, d.nom_cliente as cliente_entra, e.num_lote as num_lote, f.placa_vehiculo FROM tab_kardex as a, tab_almacenaje as b, tab_salida as c, tab_cliente as d, tab_lote as e, tab_transportista as f WHERE a.id_almacenaje=b.id_almacenaje and a.id_salida=c.id_salida and (c.id_cliente=d.id_cliente or b.id_cliente=d.id_cliente) and (b.id_lote=e.id_lote or c.id_lote=e.id_lote) and (b.id_transportista=f.id_transportista or c.id_transportista= f.id_transportista) and (a.fecha>='$fecha_inicio_buscar' and a.fecha<='$fecha_fin_buscar') and d.nom_cliente!='' and e.num_lote!='' and f.placa_vehiculo!='' and a.id_empresa='$id_empresa' ORDER by num_lote";		 $result = mysql_query($sql,$con);
 
 
 
                       echo"<div class='responsive' style='overflow:scroll;height:auto;width:auto;'><table width='98%' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>            
                                <th width='0%'>&nbsp;</th>
                                <th width='2%'><div align='left'><a href='#' title='Ordenar por Número'>NUMERO</a></th>
                                <th width='15%'><div align='left'><a href='#' title='Ordenar por Lote'>LOTE</a></div></th>
								<th width='40%'><div align='left'><a href='#' title='Ordenar por Cliente'>CLIENTE / EMPRESA</a></div></th>
                                <th width='15%'><div align='left'><a href='#' title='Ordenar por Placa'>PLACA</a></div></th>
                               
								<th width='auto'><div align='left'><a href='#' title='Odenar por Entrada'>ENTRADA (KG) </a></div></th>
								<th width='auto'><div align='left'><a href='#' title='Odenar por Salida'> SALIDA (KG) </a></div></th>
								<th width='auto'><div align='left'><a href='#' title='Odenar por Fecha '>FECHA </a></div></th>
								<th width='auto'><div align='left'><a href='#' title='Odenar por Hora '>HORA </a></div></th>
								      
                            </tr>
                            </thead>
                            <tbody>";
                    		if ($result > 0){	
                                $correlativo1 = 1;
                                $contar44=0;
							while ($row = mysql_fetch_assoc($result)) 
                            {	
							$contar44++;
							$fecha2=parseDatePhp($row['kardex_fec']);
										
                            echo"<tr>
							
                            <td width='0%' align='center'></td>
                            <td width='0%' align='center'>$contar44</td>	   
                             <td width='auto' align='left'> $row[num_lote] </td>
                              <td width='auto' align='left'> $row[cliente_entra]</td>							 
                              <td width='auto' align='left'> $row[placa_vehiculo] </td>
                              <td width='auto' align='left'> $row[p_neto_entrada]</td>
                              <td width='auto' align='left'> $row[p_neto_salida] </td>	
							  <td width='auto' align='left'> $fecha2 </td>
                              <td width='auto' align='left'> $row[kardex_hor] </td>	
							  						  
							  
                            </tr>";
                        
                            }
							
                            $correlativo++;		
                    
							}
					                   
  $result3="SELECT x.*, y.* FROM tab_bascula as x, tab_cliente as y WHERE x.id_cliente=y.id_cliente and (x.fecha_entrada>= '$fecha_inicio_buscar' and x.fecha_entrada <= '$fecha_fin_buscar')";
 $result_bascula = mysql_query($result3,$con); 
               
                    
					if ($result_bascula > 0){	
                                $correlativo1 = 1;
                                $contar4=0;
							while ($row1 = mysql_fetch_assoc($result_bascula)) 
                            {	
													
							
							$contar4++;
							
							$id_transportista_con=$row1['id_transportista'];
							$id_cliente1=$row1['id_cliente'];
 
 							$transportista=mysql_query("SELECT * FROM tab_transportista WHERE id_transportista='$id_transportista_con'");
					  		while($row_trans = mysql_fetch_array($transportista)){
							$placa1=$row_trans['placa_vehiculo'];
  							}  
							$cliente=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente='$id_cliente1'");
					  		while($row_trans = mysql_fetch_array($cliente)){
							$nom_cliente1=$row_trans['nom_cliente'];
  							}  
							//$fecha2=parseDatePhp($row['kardex_fec']);
										
                            echo"<tr>
							
                            <td width='0%' align='center'></td>
                            <td width='0%' align='center'>$contar4</td>	   
                             <td width='auto' align='left'> BASCULA </td>
                              <td width='auto' align='left'> $nom_cliente1</td>							 
                              <td width='auto' align='left'> $placa1 </td>
                              <td width='auto' align='left'> $row1[peso_bruto]</td>
                              <td width='auto' align='left'> $row1[peso_tara] </td>	
							  <td width='auto' align='left'> $fecha2 </td>
                              <td width='auto' align='left'> $row1[hora_entrada] </td>	
							  						  
							  
                            </tr>";
                        
                            }
				                   
                    }
					  echo"</tbody>
                        </table>";
 
                    
                        ?>
 					<?php
					$total=	$contar4+$contar44;
					echo "Total de Transacciones" ." ".$total;
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
              
                

<br>
<br>
<br>
<!--  INICIO FOOTER   -->
<div class="navbar navbar-inverse navbar-fixed-bottom" >
   <div class="container">
      <p align="center" class="navbar-text">
         Diseñado y Desarrollado Por <a href="http://www.ie-networks.com/">Ie Networks</a> © 2017.
      </p>
   </div>
</div>
<!-- FIN FOOTER  -->

</body>
</html>

<?PHP
  mysql_close();
?>