<?php

global $wpdb;
global $guardado_empleado;


$obtener_empleado = $wpdb->get_results("
      SELECT * 
      FROM ".TABLA_EMPLEADOS." as empleado 
  ");

?>

<div class="container-fluid">

<div class="row">

<div class="col-md-12">

<a href="<?php echo get_site_url(); ?>/comision" class="btn btn-outline-info"><i class="fa fa-list"></i> Volver</a>

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

 <h5>Registrar Comisión</h5>

 <hr>

 </div>

</div>

<div class="container">

<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Empleado</label>

 <select name="comision_nombres" class="form-control">
    <?php foreach ($obtener_empleado as $key => $value) { ?>
        <option value="<?php echo $value->id_empleado ?>"><?php echo $value->nombres." ".$value->apellidos; ?></option>
    <?php } ?>

     
 </select>

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Fecha</label>

 <input type="date" class="form-control" name="comision_fecha" value="" >

 </div>

 </div>

</div>


<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Total</label>

 <input type="text" class="form-control" name="comision_total" value="">

 </div>

 </div>

  <div class="col-md-6">

 <div class="form-group">

 <label for="">Estatus</label>

 <select class="form-control" name="comision_estatus">

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








  

</div>






<div class="row">

 <div class="col-md-3">

 <div class="form-group">

    <input type="hidden" name="comision" vale="1">
    <button class="btn btn-success btn-block" name="registrar_comision"><i class="fa fa-save"></i> Registrar</button>

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

