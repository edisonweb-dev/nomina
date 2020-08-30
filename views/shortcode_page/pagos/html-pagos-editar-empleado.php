<?php

global $wpdb;
global $guardado_empleado;

$value = $wpdb->get_row("
      SELECT *
      FROM ". TABLA_PAGO . " as pagos
      LEFT JOIN ".TABLA_EMPLEADOS." as empleados ON empleados.id_empleado = pagos.id_empleado
      WHERE pagos.id_gestion_pago = " .$_GET['editar-pagos']. " 
  ");

?>

<div class="container-fluid">

<div class="row">

<div class="col-md-12">

<a href="<?php echo get_site_url(); ?>/pagos" class="btn btn-outline-info"><i class="fa fa-list"></i> Go Back</a>

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

  Error Editing

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

 <h5>Modify Pay</h5>

 <hr>

 </div>

</div>

<div class="container">

<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Employed</label>


 <select name="pagos_nombres" class="form-control" readonly>
    
  <option value="<?php echo $value->id_empleado ?>" selected><?php echo $value->nombres." ".$value->apellidos; ?></option>
 </select>

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Date</label>

 <input type="date" class="form-control" name="pago_fecha" value="<?php echo $value->fecha ?>" >

 </div>

 </div>

</div>


<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Total</label>

 <input type="text" class="form-control" name="pagos_total" value="<?php echo $value->monto ?>">

 </div>

 </div>

  <div class="col-md-6">

 <div class="form-group">

 <label for="">Receipt</label>

 <input type="number" class="form-control" name="pago_recibo" value="<?php echo $value->recibo ?>"> 
 

 </div>

 </div>

 

</div>




<div class="row">

 <div class="col-md-3">

 <div class="form-group">

    <input type="hidden" name="id_pagos" value="<?php echo $value->id_gestion_pago ?>">
    <input type="hidden" name="pagos" value="1">
    <button class="btn btn-success btn-block" name="editar_pagos"><i class="fa fa-save"></i> Modify</button>

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

