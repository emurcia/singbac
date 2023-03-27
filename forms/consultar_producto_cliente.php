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
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");
$id_cliente2 = mysql_real_escape_string($_POST['id_cliente_busca']);
$cod_producto2 = mysql_real_escape_string($_POST['id_producto_busca']);
$fecha_inicio_buscar = parseDateMysql($_POST['fecha_inicio11']);
$fecha_fin_buscar = parseDateMysql($_POST['fecha_fin11']);

if($cod_producto2=="0"){
$where = "a.id_cliente=b.id_cliente AND a.id_producto=p.id_producto AND a.id_subproducto = sp.id_subproducto AND a.id_cliente='$id_cliente2' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_salida <= '$fecha_fin_buscar')";
}else{
$where = "a.id_cliente=b.id_cliente AND a.id_producto=p.id_producto AND a.id_subproducto = sp.id_subproducto AND a.id_cliente='$id_cliente2' and a.id_producto='$cod_producto2' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_salida <= '$fecha_fin_buscar')";
}
 ?>
<script>
  function reporte(){
 window.open('../reportes/Rp_bascula_cliente_producto.php?id='+document.formulario.id_cliente2.value+'&id2='+document.formulario.fec_inicio.value+'&id3='+document.formulario.fec_fin.value+'&id4='+document.formulario.id_producto.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
}

</script>

             
 <div class="container-fluid">
  <div class="row" >
      <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>SERVICIO DE BASCULA POR CLIENTES</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 	               
<?PHP
$sql = "SELECT a.*, b.nom_cliente, p.nom_producto, sp.nom_subproducto FROM tab_bascula as a, tab_cliente as b, tab_producto as p, tab_subproducto as sp WHERE $where";		  
 $result = mysql_query($sql);
  echo"<div class='table'><table width='100%' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class=' display' id='tblInstituciones' >";
                    
                        echo"<thead >                     
                              <tr style='overflow:scroll;height:auto;width:auto;'>            
                                <th width='100px'><div align='left'><a href='#' title='Ordenar por Número'>NUMERO</a></th>
                                <th width='250px><div align='left'><a href='#' title='Ordenar por Cliente'>CLIENTE</a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Ordenar por Producto'>PRODUCTO</a></div></th>
                                <th width='250px'><div align='left'><a href='#' title='Ordenar por Nombre'>SUBPRODUCTO</a></div></th>
                               
								<th width='150px'><div align='left'><a href='#' title='Ordenar por Fecha entrada'>FECHA ENTRADA </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Hora entrada'>HORA ENTRADA </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Fecha salida'>FECHA SALIDA </a></div></th>
								<th width='175px'><div align='left'><a href='#' title='Odenar por Hora salida'>HORA SALIDA </a></div></th>
								      
                            </tr>
                            </thead>
                            <tbody>";
                    		if ($result > 0){	
                                $correlativo1 = 1;
                                $contar4=0;
							while ($row = mysql_fetch_assoc($result)) 
                            {	
							$contar4++;
				
							$fecha_entrada1=parseDatePhp($row['fecha_entrada']);	
							$fecha_salida1=parseDatePhp($row['fecha_salida']);	
						    echo"<tr>
						
                              <td width='100px' align='center'>$contar4</td>	   
                              <td width='290px' align='left'> $row[nom_cliente] </td>
                              <td width='290px' align='left'> $row[nom_producto]</td>							 
                              <td width='295px' align='left'> $row[nom_subproducto] </td>
                              <td width='155px' align='left'> $fecha_entrada1</td>
                              <td width='155px' align='left'> $row[hora_entrada] </td>	
							  <td width='155px' align='left'> $fecha_salida1</td>
                              <td width='155px' align='left'> $row[hora_salida] </td>							  
							  
                            </tr>";
                        
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
<?php if($contar4!=0){ ?>
 <table border="0" align="center">
 <tr>
 <td><button name="btn_reporte" onclick="reporte()" value="Imprimir" class="btn btn-info btn-lg pull-right" > Imprimir </button></td>
              	    </tr>
           	      </table>            
<?php }?>
</div>
</div>
</div>
</div>                

  
    </div>
    <div>               
  </div>       
 