<?php

global $wpdb;
global $guardado_empleado;

$obtener_empleado = $wpdb->get_row("
      SELECT * 
      FROM ".TABLA_EMPLEADOS." as empleado
      LEFT JOIN ".TABLA_JORNADA_DIARIA." as jornada ON jornada.id_empleado = empleado.id_empleado
      LEFT JOIN ".TABLA_ESTADO." as estado ON estado.id_estado = jornada.estatus
      WHERE jornada.id_jornada_diaria = " .$_GET['editar-jornada-diaria']. " 
      
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

  Registered Successfully

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

 <h5>Modify work day</h5>

 <hr>

 </div>

</div>

<div class="container">

<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Employed</label>

 <input type="text" class="form-control" name="horaExtra_nombres" value="<?php echo $obtener_empleado->nombres.' '.$obtener_empleado->apellidos; ?>" readonly>

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Date</label>

 <input type="date" class="form-control" name="gestionJornada_fecha" value="<?php echo $obtener_empleado->fecha; ?>" >

 </div>

 </div>

</div>


<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Hour In</label>

 <input type="time" class="form-control" name="gestionJornada_hora_entrada" value="<?php echo $obtener_empleado->hora_entrada; ?>">

 </div>

 </div>


 <div class="col-md-6">

 <div class="form-group">

 <label for="">Hour Out</label>

 <input type="time" class="form-control" name="gestionJornada_hora_salida" value="<?php echo $obtener_empleado->hora_salida; ?>">

 </div>

 </div>

</div>




<div class="row">


  <div class="col-md-6">

 <div class="form-group">

 <label for="">First Break In</label>

 <input type="time" class="form-control" name="gestionJornada_hora_descanso_entrada" value="<?php echo $obtener_empleado->hora_descanso_entrada; ?>">

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">First Break Out</label>

 <input type="time" class="form-control" name="gestionJornada_hora_descanso_salida" value="<?php echo $obtener_empleado->hora_descanso_salida; ?>">

 </div>

 </div>

  

</div>


<div class="row">

  <div class="col-md-6">

 <div class="form-group">

 <label for="">Second Break In</label>

 <input type="time" class="form-control" name="gestionJornada_hora_descanso_entrada2" value="<?php echo $obtener_empleado->hora_descanso_entrada_second; ?>">

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Second Break Out</label>

 <input type="time" class="form-control" name="gestionJornada_hora_descanso_salida2" value="<?php echo $obtener_empleado->hora_descanso_salida_second; ?>">

 </div>

 </div>
 
 </div>


 <div class="row">


  <div class="col-md-6">

 <div class="form-group">

 <label for="">Add Hours</label>

 <input type="number" step="0.01" class="form-control" name="gestionJornada_sumar_hora" value="<?php echo $obtener_empleado->hora_suma; ?>" pattern="^[0-9]+(\\.[0-9]{2})?$">

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Subtract Hours</label>

 <input type="number" step="0.01" class="form-control" name="gestionJornada_restar_hora" value="<?php echo $obtener_empleado->hora_resta; ?>" pattern="^[0-9]+(\\.[0-9]{2})?$">

 </div>

 </div>


</div>


<div class="row">


  <div class="col-md-6">

  <div class="form-group">

    <label for="">Commision</label> <small><span class="text-danger">No required</span></small>

    <input type="number" step="0.01" class="form-control" name="gestionJornada_comision" value="<?php echo $obtener_empleado->comision; ?>" pattern="^[0-9]+(\\.[0-9]{2})?$">

  </div>

 </div>

 <div class="col-md-6">

  <div class="form-group">

    <label for="">Bonus</label> <small><span class="text-danger">No required</span></small>

    <input type="number" step="0.01" class="form-control" name="gestionJornada_bono" value="<?php echo $obtener_empleado->bono; ?>" pattern="^[0-9]+(\\.[0-9]{2})?$">

  </div>

 </div>


</div>


<div class="row">

  <div class="col-md-6">

 <div class="form-group">

 <label for="">Status</label>

 <select class="form-control" name="gestionJornada_estatus">

    <?php if($obtener_empleado->estatus){ ?>
      <option value="1">Active</option>
      <option value="0">Inactive</option>
    <?php  }else{ ?>
      <option value="0">Inactive</option>
      <option value="1">Active</option>
    <?php } ?>
 </select>

 </div>

 </div>

</div>




<div class="row">

 <div class="col-md-3">

 <div class="form-group">
    <input type="hidden" name="id_empleado" value="<?php echo $obtener_empleado->id_empleado ?>">
    <input type="hidden" name="jornada_diaria"> 
    <input type="hidden" name="id_jornada_empleado" value="<?php echo $obtener_empleado->id_jornada_diaria ?>">
    
    <button class="btn btn-success btn-block" name="actualizar_jornada_diaria"><i class="fa fa-save"></i> Modify</button>

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

