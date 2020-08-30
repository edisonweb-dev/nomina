<?php

global $wpdb;
global $guardado_empleado;

$value = $wpdb->get_row("
      SELECT *, navidad.total as totalNavidad 
      FROM ".TABLA_BONO_NAVIDAD." as navidad
      LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = navidad.id_empleado
      LEFT JOIN ".TABLA_ESTADO." as estado ON estado.id_estado = navidad.estatus
      WHERE navidad.id_bono_navidad = " .$_GET['editar-bono-navidad']. " 
      
  ");

?>

<div class="container-fluid">

<div class="row">

<div class="col-md-12">

<a href="<?php echo get_site_url(); ?>/bono-navidad" class="btn btn-outline-info"><i class="fa fa-list"></i> Volver</a>

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

 <h5>Modificar Bono Navidad</h5>

 <hr>

 </div>

</div>

<div class="container">

<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Empleado</label>


 <select name="bonoNavidad_nombres" class="form-control" readonly>
    
  <option value="<?php echo $value->id_empleado ?>" selected><?php echo $value->nombres." ".$value->apellidos; ?></option>
 </select>

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Fecha</label>

 <input type="date" class="form-control" name="bonoNavidad_fecha" value="<?php echo $value->fecha ?>" >

 </div>

 </div>

</div>


<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Total</label>

 <input type="text" class="form-control" name="bonoNavidad_total" value="<?php echo $value->total ?>">

 </div>

 </div>

  <div class="col-md-6">

 <div class="form-group">

 <label for="">Estatus</label>

 <select class="form-control" name="bonoNavidad_estatus">

    <?php if($value->estatus){ ?>
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

    <input type="hidden" name="id_bono_navidad" value="<?php echo $value->id_bono_navidad ?>">
    <input type="hidden" name="bono_navidad">
    <button class="btn btn-success btn-block" name="editar_bono_navidad"><i class="fa fa-save"></i> Modificar</button>

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

