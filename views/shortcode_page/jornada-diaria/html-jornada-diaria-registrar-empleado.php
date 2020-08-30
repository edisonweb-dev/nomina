<?php

global $wpdb;
global $guardado_empleado;
global $id_empleado_mostrar;


$obtener_empleado = $wpdb->get_row("
      SELECT * 
      FROM ".TABLA_EMPLEADOS." as empleado 
      WHERE empleado.id_empleado = ".$_GET["registrar-nueva-jornada"]."
  ");

$obtener_empleados = $wpdb->get_results("
    SELECT * 
    FROM ".TABLA_EMPLEADOS." as empleado 
");  

?>

<div class="container-fluid">

<div class="row">

<div class="col-md-12">

<a href="<?php echo get_site_url(); ?>/gestion-jornada-diaria" class="btn btn-outline-info mr-3"><i class="fa fa-list"></i> Home</a>
<a href="<?php echo get_site_url(); ?>/gestion-jornada-diaria?listado-jornada-diaria=<?php echo $obtener_empleado->id_empleado; ?>" class="btn btn-xs btn-info"><i class="fa fa-list"></i> Back to List</a>

</div>

</div>

</div>

<br>

<?php 

if($guardado_empleado == 1):

?>

<div class="container">

<div class="row">

<div class="col-md-12">

<div class="alert alert-success" role="alert">

  Registered Sucessfully

</div>

</div>

</div>

</div>

<?php 

elseif($guardado_empleado == 2):

?>



<div class="container">

<div class="row">

<div class="col-md-12">

<div class="alert alert-danger" role="alert">

  Duplicate registration the date is already registered

</div>

</div>

</div>

</div>

<?php 

else:

endif;

?>

<br>

<div class="container">

<div class="row">

<div class="col-md-12">

<form action="" class="box-new-user" method="POST" enctype="multipart/form-data">

<div class="container">

<div class="row">

 <div class="col-md-12">

 <h5>Register work day</h5>

 <hr>

 </div>

</div>

<div class="container">

<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Employed</label>

  <select name="horaExtra_nombres" id="" class="form-control">
    <option value="<?php echo $obtener_empleado->id_empleado; ?>"><?php echo $obtener_empleado->nombres." ".$obtener_empleado->apellidos; ?></option>
    <?php 
      foreach($obtener_empleados as $value){ 
        if($obtener_empleado->id_empleado != $value->id_empleado ){
          echo '<option value="'.$value->id_empleado.'">'.$value->nombres." ".$value->apellidos.'</option>';
        }
      } 
    ?>
    

  </select>
 

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Date</label>

  <?php 

    if(!empty($_GET["fecha"])){
      $fecha = $_GET["fecha"];
    }else{
      $fecha = date("Y-m-d");
    }

  ?>

 <input type="date" class="form-control" name="gestionJornada_fecha" value="<?php echo $fecha ?>" >

 </div>

 </div>

</div>


<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Hour Entry</label>

 <input type="time" class="form-control" name="gestionJornada_hora_entrada" value="">

 </div>

 </div>


 <div class="col-md-6">

 <div class="form-group">

 <label for="">Hour Out</label>

 <input type="time" class="form-control" name="gestionJornada_hora_salida" value="">

 </div>

 </div>

</div>



<div class="row">


  <div class="col-md-6">

 <div class="form-group">

 <label for="">First Break In</label>

 <input type="time" class="form-control" name="gestionJornada_hora_descanso_entrada" value="">

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">First Break Out</label>

 <input type="time" class="form-control" name="gestionJornada_hora_descanso_salida" value="">

 </div>

 </div>

  

</div>


<div class="row">


  <div class="col-md-6">

 <div class="form-group">

 <label for="">Second Break In</label>

 <input type="time" class="form-control" name="gestionJornada_hora_descanso_entrada2" value="">

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Second Break Out</label>

 <input type="time" class="form-control" name="gestionJornada_hora_descanso_salida2" value="">

 </div>

 </div>

  

</div>

<div class="row">


  <div class="col-md-6">

 <div class="form-group">

 <label for="">Add Hours</label>

 <input type="number" step="0.01" class="form-control" name="gestionJornada_sumar_hora" value="" pattern="^[0-9]+(\\.[0-9]{2})?$">

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Subtract Hours</label>

 <input type="number" step="0.01" class="form-control" name="gestionJornada_restar_hora" value="" pattern="^[0-9]+(\\.[0-9]{2})?$">

 </div>

 </div>


</div>


<div class="row">


  <div class="col-md-6">

  <div class="form-group">

    <label for="">Commision</label> <small><span class="text-danger">No required</span></small>

    <input type="number" step="0.01" class="form-control" name="gestionJornada_comision" value="" pattern="^[0-9]+(\\.[0-9]{2})?$">

  </div>

 </div>

 <div class="col-md-6">

  <div class="form-group">

    <label for="">Bonus</label> <small><span class="text-danger">No required</span></small>

    <input type="number" step="0.01" class="form-control" name="gestionJornada_bono" value="" pattern="^[0-9]+(\\.[0-9]{2})?$">

  </div>

 </div>


</div>



<div class="row">

 <div class="col-md-3">

 <div class="form-group">
    <input type="hidden" name="jornada_diaria">
    <input type="hidden" name="id_jornada_empleado" value="0">
    
    <button class="btn btn-success btn-block" name="registrar_jornada_diaria"><i class="fa fa-save"></i> Save</button>

</div>

 </div>

</div>





</div>

</form>

</div>

</div><!-- Fin Row -->

</div>

</div>

<br>

<!--  SALARIO    -->

