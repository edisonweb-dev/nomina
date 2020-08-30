<?php

global $wpdb;
global $guardado_empleado;

$empleados = $wpdb->get_results("
      SELECT *
      FROM " . TABLA_EMPLEADOS . " AS empleado");


$obtener_empleado = $wpdb->get_row("
      SELECT *, salario.salario as salarioF  
      FROM " . TABLA_EMPLEADOS . " AS empleado
      LEFT JOIN ".TABLA_SALARIO." as salario ON salario.id_empleado = empleado.id_empleado
      LEFT JOIN ".TABLA_ESTADO." as estado ON estado.id_estado = salario.estatus
      WHERE empleado.id_empleado = " .$_GET['editar-salario']. "");

?>

<div class="container-fluid">

<div class="row">

<div class="col-md-12">

<a href="<?php echo get_site_url(); ?>/gestion-salario" class="btn btn-outline-info"><i class="fa fa-list"></i> Volver</a>

</div>

</div>

</div>

<br>

<?php 

if($_GET["guardar"] == 1):

?>

<div class="container">

<div class="row">

<div class="col-md-12">

<div class="alert alert-success" role="alert">

  Register Successfully

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

  Error Edit

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

 <h5>Modify Salary</h5>

 <hr>

 </div>

</div>

<div class="container">

<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Employed</label>

 <!-- <input type="text" class="form-control" name="salario_nombres" value="<?php //echo $obtener_empleado->nombres; ?>" > -->
 <!-- <input type="hidden" name="id_empleado" value="<?php //echo $obtener_empleado->id_empleado ?>"> -->

 <select name="id_empleado" id="" class="form-control busqueda_salarios">
  <option value="<?php echo $obtener_empleado->id_empleado ?>"> <?php echo $obtener_empleado->nombres." ".$obtener_empleado->apellidos ?> </option>
  <?php
    foreach($empleados as $value){
      if($obtener_empleado->id_empleado != $value->id_empleado){
        echo '<option value="'.$value->id_empleado.'">'.$value->nombres.' '.$value->apellidos.'</option>';
      }
    }
  ?>
  
 </select>

 </div>

 </div>

</div>



<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Date begin</label>

 <input type="date" class="form-control fecha_inicial" name="salario_fechai" value="<?php echo $obtener_empleado->fecha_inicial; ?>">

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Date end</label>

 <input type="date" class="form-control fecha_final" name="salario_fechaf" value="<?php echo $obtener_empleado->fecha_final; ?>">

 </div>

 </div>

</div>



<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Salary</label>

 <input type="text" class="form-control salario" name="salario_salariof" value="<?php echo $obtener_empleado->salarioF; ?>">

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Status</label>

 <select class="form-control estatus" name="salario_estatus">

    <?php if($obtener_empleado->id_estado){ ?>
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
    <input type="hidden" name="actualizar_salario_temporal_registro"> 
    
    <button class="btn btn-success btn-block" name="actualizar_salario_temporal"><i class="fa fa-save"></i> Save</button>

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

