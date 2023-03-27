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
$nom_cliente=$_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");

$nomSQL=mysql_query("SELECT id_cliente from tab_cliente where nom_cliente='$nom_cliente'",$con);
$fila_nom = mysql_fetch_array($nomSQL, MYSQL_ASSOC);
$cod_usuario_cliente=$fila_nom['id_cliente']; 


 $id_cliente2 = mysql_real_escape_string($_POST['id_cliente_busca']);
 $id_lote2 = mysql_real_escape_string($_POST['id_lote_busca']);
 $fecha_inicio_buscar = parseDateMysql($_POST['fecha_inicio11']);
 $fecha_fin_buscar = parseDateMysql($_POST['fecha_fin11']);
 
if($cod_usuario_cliente!=''){
	
		if($id_cliente2=="0" AND $id_lote2=="0"){
		$where = "a.id_cliente=b.id_cliente AND b.id_cliente=decl.id_cliente_secundario AND a.id_almacenaje=rec.id_almacenaje AND decl.id_cliente_principal='$cod_usuario_cliente' and a.id_lote=c.id_lote and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and a.peso_bruto!='0'  and a.bandera='2' AND a.id_empresa='$id_empresa'";
		
		}else{
			if($id_cliente2!="0" AND $id_lote2=="0"){
			$where = "a.id_cliente=b.id_cliente AND b.id_cliente=decl.id_cliente_secundario AND a.id_almacenaje=rec.id_almacenaje and a.id_lote=c.id_lote and a.id_cliente='$id_cliente2' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and a.peso_bruto!='0'  and a.bandera='2' AND a.id_empresa='$id_empresa' GROUP BY a.hora_entrada";
			}else{
				$where = "a.id_cliente=b.id_cliente AND b.id_cliente=decl.id_cliente_secundario AND a.id_almacenaje=rec.id_almacenaje and a.id_lote=c.id_lote and a.id_cliente='$id_cliente2' and a.id_lote='$id_lote2' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and a.peso_bruto!='0'  and a.bandera='2' AND a.id_empresa='$id_empresa' GROUP BY a.hora_entrada";
				  }
		}
}else{//inicia otra condicion
	if($id_cliente2=="0" AND $id_lote2=="0"){
$where1 = "a.id_cliente=b.id_cliente  and a.id_lote=c.id_lote and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and a.peso_bruto!='0'  and a.bandera='2' AND a.id_empresa='$id_empresa' GROUP BY a.hora_entrada";
}else{
	if($id_cliente2!="0" AND $id_lote2=="0"){
	$where1 = "a.id_cliente=b.id_cliente and a.id_lote=c.id_lote and a.id_cliente='$id_cliente2' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and a.peso_bruto!='0'  and a.bandera='2' AND a.id_empresa='$id_empresa' GROUP BY a.hora_entrada";
	}else{
		$where1 = "a.id_cliente=b.id_cliente and a.id_lote=c.id_lote and a.id_cliente='$id_cliente2' and a.id_lote='$id_lote2' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and a.peso_bruto!='0'  and a.bandera='2' AND a.id_empresa='$id_empresa' GROUP BY a.hora_entrada";
	      }
}
		} 


 ?>
<script>
function excel(){
window.open('../reporteexcel/excel_calidad_entrada.php?id='+document.formulario.id_cliente.value+'&id2='+document.formulario.fec_inicio.value+'&id3='+document.formulario.fec_fin.value+'&id4='+document.formulario.id_lote2.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');	
}

function excel2(){
window.open('../reporteexcel/otro_excel_calidad_entrada.php?id='+document.formulario.id_cliente.value+'&id2='+document.formulario.fec_inicio.value+'&id3='+document.formulario.fec_fin.value+'&id4='+document.formulario.id_lote2.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');	
}

function reporte(){
window.open('../reportes/Rp_entrada_calidad.php?id='+document.formulario.id_cliente.value+'&id2='+document.formulario.fec_inicio.value+'&id3='+document.formulario.fec_fin.value+'&id4='+document.formulario.id_lote2.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');	

}

function reporte2(){
window.open('../reportes/Rp_entrada_calidad2.php?id='+document.formulario.id_cliente.value+'&id2='+document.formulario.fec_inicio.value+'&id3='+document.formulario.fec_fin.value+'&id4='+document.formulario.id_lote2.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');	

}

</script>

 <div class="container-fluid">
  <div class="row" >
      <div class="col-md-12">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>ENTRADA DE PRODUCTOS - CONTROL DE CALIDAD</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 				<div>


                
<?php
if($cod_usuario_cliente==""){
//$cli="CLI-000".$id_empresa;
$sql=mysql_query("SELECT a.*, b.*, c.* FROM tab_almacenaje as a, tab_cliente as b, tab_lote as c WHERE $where1",$con); //
}else{
	// b.id_cliente=decl.id_cliente_secundario where  and decl.id_empresa='$id_empresa'
	
	
	
$sql=mysql_query("SELECT a.*, b.*, c.* FROM tab_almacenaje as a, tab_cliente as b, tab_lote as c,  tab_detalle_cliente as decl, tab_indicadoresrecepcion as rec WHERE $where",$con); //
  }

$result = ($sql);
  echo"<div class='table'><table width='100%' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class=' display' id='tblInstituciones' >";
  
                        echo"<thead>                     
                              	<tr>            
                                <th width='100px'><div align='left'><a href='#' title='Ordenar por Número'>NUMERO</a></th>
                                <th width='350px'><div align='left'><a href='#' title='Ordenar por Cliente'>CLIENTE</a></div></th>
								<th width='350px'><div align='left'><a href='#' title='Ordenar por Producto'>PRODUCTO</a></div></th>
                                <th width='350px'><div align='left'><a href='#' title='Ordenar por Nombre'>SUBPRODUCTO</a></div></th>
           						<th width='250px'><div align='left'><a href='#' title='Ordenar por Lote'>NUMERO DE LOTE</a></div></th>                    
								<th width='250px'><div align='left'><a href='#' title='Odenar por Fecha entrada'>FECHA ENTRADA </a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Hora entrada'>HORA ENTRADA </a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Fecha salida'>FECHA SALIDA </a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Hora salida'>HORA SALIDA </a></div></th>
								      
                            </tr>
                            </thead>
                            <tbody>";
                    		if ($result > 0){	
                                $correlativo1 = 1;
                                $contar4=0;
							while ($row = mysql_fetch_assoc($result)) 
                            {	
							$contar4++;
							$id_lote1=$row['id_lote'];
							//$id_producto1=$row['id_producto'];
							//$id_subproducto1=$row['id_subproducto'];
							$fecha_entrada1=parseDatePhp($row['fecha_entrada']);	
							$hora_entrada1=$row['hora_entrada'];
							$fecha_salida1=parseDatePhp($row['fecha_salida']);	
							$hora_salida1=$row['hora_salida'];													
							
							$lote=mysql_query("SELECT * FROM tab_lote WHERE id_lote='$id_lote1' and id_empresa='$id_empresa'");
						  	while($row_lote = mysql_fetch_array($lote)){
							  $num_lote1=$row_lote['num_lote'];
							  $id_lote2=$row_lote['id_lote'];
						//	$nom_producto1=$row_producto['nom_producto'];
							 
						//	$id_cliente=$row['id_cliente'];
							$id_producto1=$row_lote['id_producto'];
							$id_subproducto1=$row_lote['id_subproducto'];
							
							
						$producto=mysql_query("SELECT * FROM tab_producto WHERE id_producto='$id_producto1' and id_empresa='$id_empresa'");
						  while($row_producto = mysql_fetch_array($producto)){
							$nom_producto1=$row_producto['nom_producto'];	
							
								$subproducto=mysql_query("SELECT * FROM tab_subproducto WHERE id_subproducto='$id_subproducto1' and id_empresa='$id_empresa'");
								 while($row_subproducto = mysql_fetch_array($subproducto)){
								$nom_subproducto1=$row_subproducto['nom_subproducto'];								
									
										
                            echo"<tr>
							 <td width='100px' align='center'>$contar4</td>	   
                             <td width='290px' align='left'> $row[nom_cliente] </td>
                              <td width='300px' align='left'> $nom_producto1</td>							 
                              <td width='310px' align='left'> $nom_subproducto1 </td>
                              <td width='290px' align='left'> $num_lote1 </td>							  
                              <td width='290px' align='left'> $fecha_entrada1</td>
                              <td width='290px' align='left'> $hora_entrada1 </td>	
							  <td width='290px' align='left'> $fecha_salida1</td>
                              <td width='250px' align='left'> $hora_salida1 </td>							  
							  
                            </tr>";
                        
                            }
						  }
							}
							}
                            $correlativo++;		
                    
                            echo"</tbody>
                        </table>
						
                        ";
					                   
                    }
                    
                    
                    
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
<?php if($contar4!=0){ 
if($_SESSION['cod_usuario_cliente']!=""){?>

 <table border="0" align="center">
 <td width="100"><button name="btn_reporte" onclick="reporte2()" value="Imprimir" class="btn btn-info btn-lg pull-right" > Imprimir </button></td>
 <td width="20">&nbsp;</td>
 <td width="100"><button name="btn_excel" onclick="excel2()" value="Exportar" class="btn btn-info btn-lg pull-right" > Exportar</button></td>
              	    </tr>
           	      </table>            
<?php }else { ?>
<table border="0" align="center">
 <td width="100"><button name="btn_reporte" onclick="reporte2()" value="Imprimir" class="btn btn-info btn-lg pull-right" > Imprimir otros indicadores </button></td>
 <td width="20">&nbsp;</td>
  <td width="100"><button name="btn_reporte1" onclick="reporte()" value="Imprimir" class="btn btn-info btn-lg pull-right" > Imprimir </button></td>
 <td width="20">&nbsp;</td>
 <td width="100"><button name="btn_excel1" onclick="excel()" value="Exportar" class="btn btn-info btn-lg pull-right" > Exportar</button></td>
 <td width="20">&nbsp;</td>
 <td width="100"><button name="btn_excel" onclick="excel2()" value="Exportar" class="btn btn-info btn-lg pull-right" > Exportar otros indicadores</button></td>
              	    </tr>
           	      </table>
                  
<?php }?>
<?php }?>
</div>
</div>

