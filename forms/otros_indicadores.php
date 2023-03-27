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
$id_agencia_recibe = mysql_real_escape_string($_POST['id_cuentas_busca']);
$_SESSION['cod_almacenaje']=$id_agencia_recibe;
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
              <label>TEMPERATURA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="temperaturag"  name="temperaturag"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" maxlength="5" >
              <span class="input-group-addon">%</span>
                  </div>
      		</div>
          </div>
         
            <div class="col-md-4">
         <div class="form-group">
              <label>HUMEDAD</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="humedadg"  name="humedadg" value="" autocomplete="off" onkeypress="mascara(this, '##.##')" maxlength="5" >
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>RETENCION EN MALLA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="retenciong"  name="retenciong" value="" autocomplete="off" onkeypress="mascara(this, '##.##')" maxlength="5" >
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->
 
            <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>GRANO ROTO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_rotog"  name="grano_rotog" value="" autocomplete="off" onkeypress="mascara(this, '##.##')" maxlength="5" >
              <span class="input-group-addon">%</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>GRANO DAÑADO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_dañadog"  name="grano_dañadog"  value="" autocomplete="off" onkeypress="mascara(this, '#.##')" maxlength="4" >
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>IMPUREZA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="impurezag"  name="impurezag" value="" autocomplete="off" onkeypress="mascara(this, '#.##')" maxlength="4" >
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->

                <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>GRANO CHICO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_chicog"  name="grano_chicog"  value="" autocomplete="off" onkeypress="mascara(this, '#.##')" maxlength="4" >
              <span class="input-group-addon">%</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>GRANO BOLA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_bolag"  name="grano_bolag"  value="" autocomplete="off" onkeypress="mascara(this, '#.##')" maxlength="4" >
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>STRESS CRACK</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="stress_crackg"  name="stress_crackg"  value="" autocomplete="off" onkeypress="mascara(this, '#.##')" maxlength="4">
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->

                 <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>GERMINACION</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="germinaciong"  name="germinaciong"  value="" autocomplete="off">
              <span class="input-group-addon">%</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>PESO 100 GRANOS </label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso100granosg"  name="peso100granosg"  value="" autocomplete="off" >
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>LONGITUD 20 GRANOS </label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="longitud20granosg"  name="longitud20granosg"  value="" autocomplete="off" onkeypress="mascara(this, '##.##')" maxlength="5">
              <span class="input-group-addon">cm</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->
          <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>DENSIDAD</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg" id="densidadg"  name="densidadg"  value="" autocomplete="off" style="text-transform:uppercase;" >
               <span class="input-group-addon">°</span>
         </div>
      	 </div>
         </div>
         <div class="col-md-4">
         <div class="form-group">
              <label>OTRAS VARIEDADES</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg" id="otrasvariedadesg"  name="otrasvariedadesg" value="" autocomplete="off" style="text-transform:uppercase;" >
                    <span class="input-group-addon">%</span>        
         </div>
      	 </div>
         </div>
          <div class="col-md-4">
         <div class="form-group">
              <label>PIEDRAS</label>
              <input type="text" class="form-control input-lg" id="piedrasg"  name="piegrasg" value="" autocomplete="off" style="text-transform:uppercase;" >
              
         </div>
      	 </div>
         </div>  
         
                <div class="row"><!--- INICIO ROW----->
         <div class="col-md-12">
         <div class="form-group">
              <label>ELABORADO POR:</label>
              <input type="text" class="form-control input-lg" id="elaboradoporg"  name="elaboradoporg"  value="" autocomplete="off" style="text-transform:uppercase;" >
              
         </div>
      	 </div>
         </div>  
         
         <div class="row"><!--- INICIO ROW----->
         <div class="col-md-8">
          <div class="checkbox">
              <label>
                <input type="checkbox" value="" onclick="activar_textos()"> Autorización
              </label>
            </div>
            </div> 
            <div class="col-md-2"> 
<button type="button" disabled id="btnguardar_act"  name="btnguardar_act" class="btn btn-primary glyphicon glyphicon-saved center pull-right" data-toggle="modal" data-target="#actualizar" value="Guardar">  Guardar</button>
 </div> 
            <div class="col-md-2"> 
          <button type="button" id="btn_cerrar" name="btn_cerrar" class="btn btn-danger glyphicon glyphicon-remove center pull-right" data-dismiss="modal">  Cerrar</button>               

    		</div>
          
          </div>               
</div>
</div>
</div>
</div>


