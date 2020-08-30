<?php

global $wpdb;
global $guardado_empleado;

$empleados = $wpdb->get_results("
      SELECT *
      FROM " . TABLA_EMPLEADOS . " AS empleado");

$obtener_empleado = $wpdb->get_row("
      SELECT *, empleado.salario as salarioEmpleado
      FROM ".TABLA_EMPLEADOS." as empleado
      LEFT JOIN ".TABLA_HORA_EXTRA." as horaE ON horaE.id_empleado = empleado.id_empleado
      LEFT JOIN ".TABLA_ESTADO." as estado ON estado.id_estado = horaE.estatus
      WHERE empleado.id_empleado = " .$_GET['editar-hora']. "");

?>

<div class="container-fluid">

<div class="row">

<div class="col-md-12">

<a href="<?php echo get_site_url(); ?>/gestion-horas-extras" class="btn btn-outline-info"><i class="fa fa-list"></i> Go Back</a>

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

  Error while editing

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

 <h5>Modify overtime</h5>

 <hr>

 </div>

</div>

<div class="container">

<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Employed</label>

 <!-- <input type="text" class="form-control" name="horaExtra_nombres" value="<?php //echo $obtener_empleado->nombres.' '.$obtener_empleado->apellidos; ?>" readonly> -->
 <!-- <input type="hidden" name="id_empleado" value="<?php //echo $obtener_empleado->id_empleado ?>"> -->

 <select name="id_empleado" id="" class="form-control busqueda_overtime">
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

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Extra Hour</label>

  <select class="form-control hora_extra" name="horaExtra_salario">
    <?php 
      if(!empty($obtener_empleado->salario_hora_extra)){
        if($obtener_empleado->salario_hora_extra == ($obtener_empleado->salarioEmpleado * 2)){
          echo '<option value="'.($obtener_empleado->salarioEmpleado * 2).'">Double</option>';
          echo '<option value="'.( ($obtener_empleado->salarioEmpleado / 2) + $obtener_empleado->salarioEmpleado ).'">time and a half</option>';
        }else{
          echo '<option value="'.( ($obtener_empleado->salarioEmpleado / 2) + $obtener_empleado->salarioEmpleado ).'">time and a half</option>';
          echo '<option value="'.($obtener_empleado->salarioEmpleado * 2).'" >Double</option>';
        }
    ?>
    <?php  
      }else{
    ?>
      <option value="<?php echo ( ($obtener_empleado->salarioEmpleado / 2) + $obtener_empleado->salarioEmpleado ); ?>">time and a half</option>

      <option value="<?php echo ($obtener_empleado->salarioEmpleado * 2); ?>">Double</option>
    <?php } ?>
  </select>
 

 </div>

 </div>

</div>


<div class="row">

  <div class="col-md-6">

  <div class="form-group">

    <label for="">Date</label>

    <input type="date" class="form-control date" name="horaExtra_fecha" value="<?php echo $obtener_empleado->fecha; ?>">

  </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Status</label>

 <select class="form-control status" name="horaExtra_estatus">

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
    <input type="hidden" name="actualizar_hora_extra">
    
    <button class="btn btn-success btn-block" name="actualizar_hora_extra_editar"><i class="fa fa-save"></i> Modify</button>

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

