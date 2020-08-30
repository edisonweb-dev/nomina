<?php

global $wpdb;
global $guardado_empleado;

$obtener_empleado = $wpdb->get_row("
      SELECT * 
      FROM ".TABLA_EMPLEADOS." as empleado
      LEFT JOIN ".TABLA_GESTION_HORA." as hora ON hora.id_empleado = empleado.id_empleado
      LEFT JOIN ".TABLA_ESTADO." as estado ON estado.id_estado = hora.estatus
      WHERE empleado.id_empleado = " .$_GET['editar-gestion-hora']. "");

?>

<div class="container-fluid">

<div class="row">

<div class="col-md-12">

<a href="<?php echo get_site_url(); ?>/gestion-descanso" class="btn btn-outline-info"><i class="fa fa-list"></i> Volver a la lista</a>

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

  Registrado exitosamente

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

  Error al editar

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

 <h5>Modificar Gestion Horas</h5>

 <hr>

 </div>

</div>

<div class="container">

<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Empleado</label>

 <input type="text" class="form-control" name="horaExtra_nombres" value="<?php echo $obtener_empleado->nombres.' '.$obtener_empleado->apellidos; ?>" readonly>

 </div>

 </div>

</div>


<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Sumar hora</label>

 <input type="text" class="form-control" name="gestionHora_suma" value="<?php echo $obtener_empleado->hora_suma; ?>">

 </div>

 </div>


 <div class="col-md-6">

 <div class="form-group">

 <label for="">Restar hora</label>

 <input type="text" class="form-control" name="gestionHora_resta" value="<?php echo $obtener_empleado->hora_resta; ?>">

 </div>

 </div>

</div>



<div class="row">

  <div class="col-md-6">

 <div class="form-group">

 <label for="">Estatus</label>

 <select class="form-control" name="gestionHora_estatus">

    <?php if($obtener_empleado->estatus){ ?>
      <option value="1">Activo</option>
      <option value="0">Inactivo</option>
    <?php  }else{ ?>
      <option value="0">Inactivo</option>
      <option value="1">Activo</option>
    <?php } ?>
 </select>

 </div>

 </div>

</div>




<div class="row">

 <div class="col-md-3">

 <div class="form-group">

    <input type="hidden" name="id_empleado" value="<?php echo $obtener_empleado->id_empleado ?>">
    <button class="btn btn-success btn-block" name="actualizar_gestion_hora"><i class="fa fa-save"></i> Modificar</button>

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

