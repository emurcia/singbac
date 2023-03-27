<script type="text/javascript" src="../assets/javascript/jquery.maskedinput.min.js" ></script>
<script>
 $(document).ready(function(){
            $.mask.definitions['~']='[7260]';
            $(".tel_agencia").mask("~999-9999", {placeholder: "_"});
            
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
$id_agencia_recibe = mysql_real_escape_string($_POST['id_agricultor_busca']);
$loginSQL=mysql_query("SELECT * FROM tab_agricultor where dui_agricultor='$id_agencia_recibe' AND id_empresa='$id_empresa'",$con);
$fila_usu = mysql_fetch_array($loginSQL, MYSQL_ASSOC);
$id_agencia_mostrar=$fila_usu['dui_agricultor'];
$nom_agencia_mostrar=$fila_usu['nom_agricultor'];
$ape_agencia_mostrar=$fila_usu['ape_agricultor'];
$tel_agencia_mostrar=$fila_usu['tel_agricultor'];
$resp_agencia_mostrar=$fila_usu['tel_agricultor'];
$dir_agencia_mostrar=$fila_usu['direccion'];
	
?>


 <!--------- INICIA MODAL ACTUALIZAR USUARIOS ------>
     
  <div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>ACTUALIZAR DATOS</strong> <button type="button" class='close' data-dismiss="modal" aria-hidden="true">&times;</button></div> <!-- PANEL 1 --->
           <div class="panel-body" >

           <div class="row"><!--- INICIO ROW----->
            
          <div class="col-md-12">
          <div class="form-group">
          		<label>DUI:</label>
               <input type="text"  class="form-control input-lg" value="<?PHP echo $id_agencia_mostrar; ?>" id="dui_agricultor_act" name="dui_agricultor_act" style="background:#FFF" readonly="readonly" /> 
            </div>
          </div>
          
          </div><!--- FIN ROW-----> 
           
           <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
             <label>NOMBRE:</label>
               <input type="text" class="form-control input-lg" id="nom_agricultor_act" name="nom_agricultor_act" value="<?PHP echo $nom_agencia_mostrar; ?>" placeholder="NOMBRE" style="text-transform:uppercase" autocomplete="off" required/>  
          </div>
          </div>
          </div><!--- FIN ROW----->
             <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
             <label>APELLIDOS:</label>
               <input type="text" class="form-control input-lg" id="ape_agricultor_act" name="ape_agricultor_act" value="<?PHP echo $ape_agencia_mostrar; ?>" placeholder="DIRECCION" style="text-transform:uppercase" autocomplete="off" required/>  
          </div>
          </div>
          </div><!--- FIN ROW----->
             <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
             <label>TELEFONO:</label>
               <input type="text" class="form-control input-lg tel_agencia" id="tel_agricultor_act" name="tel_agricultor_act" value="<?PHP echo $tel_agencia_mostrar; ?>" placeholder="TELEFONO" style="text-transform:uppercase" autocomplete="off" required/>  
          </div>
          </div>
          </div><!--- FIN ROW----->
             <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
             <label>DIRECCION:</label>
               <input type="text" class="form-control input-lg" id="dir_agricultor_act" name="dir_agricultor_act" value="<?PHP echo $dir_agencia_mostrar; ?>" placeholder="DIRECCION" style="text-transform:uppercase" autocomplete="off" required/>  
          </div>
          </div>
          </div><!--- FIN ROW----->
           <div class="row"><!--- INICIO ROW----->
          <div class="col-md-3">
          <div class="form-group">
             <label>NIÑOS:</label>
               <input type="text" class="form-control input-lg" id="nino_agricultor_act" name="nino_agricultor_act" placeholder="NIÑOS" autocomplete="off" required/>  
          </div>
          </div>
          <div class="col-md-3">
          <div class="form-group">
             <label>ADULTOS:</label>
               <input type="text" class="form-control input-lg" id="adul_agricultor_act" name="adul_agricultor_act" placeholder="ADULTOS" autocomplete="off" required/>  
          </div>
          </div>
          <div class="col-md-3">
          <div class="form-group">
             <label>+ 60 AÑOS:</label>
               <input type="text" class="form-control input-lg" id="adulmayor_agricultor_act" name="adulmayor_agricultor_act" placeholder="+ 60 AÑOS" autocomplete="off" required/>  
          </div>
          </div>
           <div class="col-md-3">
          <div class="form-group">
             <label>VIVERES?:</label>
               <input type="text" class="form-control input-lg" id="viveres_agricultor_act" name="viveres_agricultor_act" placeholder="VIVERES" value="SI" autocomplete="off" required/>  
          </div>
          </div>
          </div><!--- FIN ROW----->
            
          <div class="checkbox">
              <label>
                <input type="checkbox" value="" onclick="activar_textos()"> Autorización
              </label>
          </div>
                
          <button type="button" disabled id="btnguardar_act"  name="btnguardar_act" onclick="guardar_act()" class="btn btn-primary glyphicon glyphicon-saved center pull-right" value="Guardar">  Guardar</button>
</div>
</div>
</div>
</div>
