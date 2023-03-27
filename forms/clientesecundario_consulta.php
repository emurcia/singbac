<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../assets/stylesheet/caja_buscar.css">
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery-1.4.4.min.js"></script>
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link href="../images/favicon.ico" rel="icon">
<script  languaje="javascript" type="text/javascript" >
	 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones').dataTable( {
    	"sPaginationType": "full_numbers",
		"sScrollX": "100%"
	 });
    }); 
</script>
<?php 
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");


  $id_nivel = mysql_real_escape_string($_POST['id_nivel_busca']);
  if(($id_nivel !="" and $id_nivel!="0"))//entra cuando ocurre el change de municipio
  {
     $sql = "SELECT a.* FROM tab_cliente as a, tab_detalle_cliente as b WHERE b.id_cliente_principal='".$id_nivel."' and a.id_cliente IN(SELECT b.id_cliente_secundario FROM tab_detalle_cliente as b WHERE  b.id_cliente_principal='".$id_nivel."') and a.tipo_cliente='2' GROUP BY a.id_cliente";
$result = mysql_query($sql, $con);
echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";

	echo"<thead>                     
          <tr>            
            <th width='20%'><div align='center'>ACCIONES</div></th>

            <th width='30%'><div align='left'><a href='#' title='Ordenar por Codigo'>CODIGO</a></div></th>
            <th width='50%'><div align='left'><a href='#' title='Odenar por Opciones'>EMPRESA PRINCIPAL</a></div></th>
           
           									
        </tr>
        </thead>
        <tbody>";

		if ($result> 0){	
		    $correlativo = 1;
			$contar2++;
		while ($row = mysql_fetch_array($result)) 
		{
			 $opcion=utf8_encode($row["nom_cliente"]);
		
		if($row['nivel_menu']=="1"){
			$nivel_menu="OPCION PRINCIPAL";
			}else {
			$nivel_menu="OPCION SECUNDARIA";
				}
											
		echo"<tr>
		<td width='4%' align='center'><a data-toggle='modal' data-target='#ventana4' onClick='eliminar(\"".$row['id_cliente']."\");' style='cursor:pointer' title='Eliminar registro'><img src='../images/trash-icon.png' width='28px' height='28px'></a></td>
   
         
          <td width='auto' align='left'> $row[id_cliente]</td>
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

