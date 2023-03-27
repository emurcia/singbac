<script  languaje="javascript" type="text/javascript" >
	 var BOTON = 0;	
    $(document).ready(function() {
    $('.soloNUMEROS').keypress(function(tecla) {
                //alert(tecla.charCode);
                if((tecla.charCode < 48 || tecla.charCode > 57) && tecla.keyCode !=08 && tecla.keyCode !=09 && tecla.keyCode !=127 && tecla.keyCode !=37 && tecla.keyCode !=39 && tecla.charCode !=32 && tecla.charCode !=46) return false;
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

$id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
$id_agencia_recibe_des = mysql_real_escape_string($_POST['id_cuentas_buscardespacho']);
$_SESSION['cod_despacho']=$id_agencia_recibe_des;
/*

$loginSQL=mysql_query("SELECT * FROM tab_almacenaje where id_almacenaje='ALMACEN-00024701' AND id_empresa='$id_empresa'",$con);
$fila_usu = mysql_fetch_array($loginSQL, MYSQL_ASSOC);
$peso_vol=$fila_usu['peso_vol'];
$humedad=$fila_usu['humedad'];
$temperatura=$fila_usu['temperatura'];
$grano_entero=$fila_usu['grano_entero'];
$grano_quebrado=$fila_usu['grano_quebrado'];
$dan_hongo=$fila_usu['dan_hongo'];
$impureza=$fila_usu['impureza'];
$grano_chico=$fila_usu['grano_chico'];
$grano_picado=$fila_usu['grano_picado'];
$plaga_viva=$fila_usu['plaga_viva'];
$plaga_muerta=$fila_usu['plaga_muerta'];
$stress_crack=$fila_usu['stress_crack'];
$olor=$fila_usu['olor'];
$vapor=$fila_usu['vapor'];
*/
	
?>


 <!--------- INICIA MODAL ACTUALIZAR USUARIOS ------>
     
  <div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>INGRESAR INDICADORES</strong> <button type="button" class='close' data-dismiss="modal" aria-hidden="true">&times;</button></div> <!-- PANEL 1 --->
           <div class="panel-body" >

          <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>HUMEDAD</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="humedadg"  name="humedadg"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="humedad_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="humedad_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>TEMPERATURA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="temperaturag"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="temperatura_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="temperatura_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>GRANO BOLA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="grano_bolag"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="grano_bola_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="grano_bola_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
          </div><!--- FIN ROW----->
          
         <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>GRANO CHICO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="grano_chicog"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="grano_chico_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="grano_chico_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>GRANOS ROTOS</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="grano_rotog"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="grano_roto_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="grano_roto_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>IMPUREZAS</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="impurezag"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="impureza_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="impureza_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
          </div><!--- FIN ROW----->
         <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>OTRAS VARIEDADES</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="otras_variedadesg"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="otras_variedades_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="otras_variedades_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>PIEDRAS</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="piedrasg"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="piedras_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="piedras_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>INFESTACIÓN</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="infestaciong"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="infestacion_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="infestacion_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
          </div><!--- FIN ROW----->
          <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>RETENCION MALLA 1/4</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="retencion_mallag"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="retencion_malla_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="retencion_malla_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>CALOR</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="calorg"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="calor_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="calor_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>INSECTO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="insectog"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="insecto_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="insecto_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
          </div><!--- FIN ROW----->
         <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>HONGO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="hongog"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="hongo_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="hongo_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>GERMINACIÓN</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="germinaciong"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="germinacion_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="germinacion_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>PESO 100 GRANOS</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="peso_100_granosg"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="peso_100_granos_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="peso_100_granos_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
          </div><!--- FIN ROW----->
         
         <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>LONGITUD 20 GRANOS</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="longitud_20_granosg"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="longitud_20_granos_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="longitud_20_granos_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>DENSIDAD</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="densidadg"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="densidad_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="densidad_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>AFLOTOXINAS</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="aflotoxinasg"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="aflotoxinas_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="aflotoxinas_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
          </div><!--- FIN ROW----->
           <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>FUMONISINAS</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="fumonisinasg"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="fumonisinas_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="fumonisinas_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>VOMITOXINAS (DON)</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="vomitoxinasg"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="vomitoxinas_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="vomitoxinas_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>STRESS CRACK</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="stress_crackg"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="stress_crack_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="stress_crack_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
          </div><!--- FIN ROW----->
               <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>FLOTADORES</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="flotadoresg"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="flotadores_rojog" value="1">
    	  </label></div></span>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-success"><input class="btn-danger" type="checkbox" name="flotadores_verdeg" value="1">
    	  </label></div></span>
              </div>
          </div>
          </div>
            <div class="col-md-8">
         <div class="form-group">
              <label>ELABORADO POR</label>
              <input type="text" class="form-control input-lg" id="elaboradoporg"  name="elaboradoporg"  autocomplete="off" style="text-transform:uppercase;" required>
          </div>
          </div>
          </div><!--- FIN ROW----->
         <div class="row"><!--- INICIO ROW----->
         <div class="col-md-12">
         <div class="form-group">
              <label>OBSERVACIONES</label>
              <textarea name="observacionesg" id="observacionesg" class="form-control input-lg" style="text-transform:uppercase;" rows="2" placeholder="OBSERVACIONES" autocomplete="off" ></textarea>
          </div>
          </div>
          </div><!--- FIN ROW----->
          
         <div class="row"><!--- INICIO ROW----->
         <div class="col-md-8">
          <div class="checkbox">
              <label>
                <input type="checkbox" name="activarbotondes" value="" onclick="activar_textosdespacho()"> Autorización
              </label>
            </div>
            </div> 
            <div class="col-md-2"> 
<button type="button" disabled id="btnguardar_despacho"  name="btnguardar_despacho" class="btn btn-primary glyphicon glyphicon-saved center pull-right" data-toggle="modal" data-target="#actualizardespacho" value="Guardar">  Guardar</button>
 </div> 
            <div class="col-md-2"> 
          <button type="button" id="btn_cerrar" name="btn_cerrar" class="btn btn-danger glyphicon glyphicon-remove center pull-right" data-dismiss="modal">  Cerrar</button>               

    		</div>
          
          </div>               
</div>
</div>
</div>
</div>


