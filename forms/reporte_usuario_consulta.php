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
<script>
	 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones').dataTable( {
    		"sPaginationType": "full_numbers"
			
	 });


    
});
</script>
<?php 
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");


  $id_nivel = mysql_real_escape_string($_POST['id_nivel_busca']);
  $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
  $sql_cliente=mysql_query("SELECT * FROM tab_cliente WHERE  nom_cliente='".$id_nivel."'  and id_empresa='$id_empresa' GROUP BY nom_cliente", $con);
  while ($row2 = mysql_fetch_array($sql_cliente)) 
		{
			$id_cliente=$row2["id_cliente"];
		}
  
 
  if(($id_nivel !="" and $id_nivel!="0"))//entra cuando ocurre el change de municipio
  {
     $sql=mysql_query("SELECT * FROM tab_reporte_cliente WHERE  id_cliente='".$id_cliente."' and numero_reporte!='0' and id_empresa='$id_empresa'", $con);
//$result = $sql;
   echo"<div id='feedback2' class='responsive' ><table width='auto' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";

	echo"<thead>                     
          <tr>            
            <th width='8%'><div align='center'>ACCIONES</div></th>

            <th width='auto'><div align='left'><a href='#' title='Ordenar por Codigo'>CODIGO</a></div></th>
            <th width='auto'><div align='left'><a href='#' title='Odenar por Opciones'>OPCIONES DEL MENU</a></div></th>
            		
           									
        </tr>
        </thead>
        <tbody>";

		if ($sql> 0){	
		    $correlativo = 1;
			$contar2++;
		while ($row = mysql_fetch_array($sql)) 
		{
			 $opcion=utf8_encode($row["nom_reporte"]);
		

											
		echo"<tr>
		<td width='4%' align='center'><a data-toggle='modal' data-target='#ventana4' onClick='eliminar(\"".$row['id_reporte']."\");' style='cursor:pointer' title='Eliminar registro'><img src='../images/trash-icon.png' width='28px' height='28px'></a></td>
   
         
          <td width='auto' align='left'> $row[id_reporte]</td>
		  <td width='auto' align='left'> $opcion </td>
 	  
		  
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
 
  }
?>

