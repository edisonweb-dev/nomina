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

<a href="<?php echo get_site_url(); ?>/gestion-jornada-diaria" class="btn btn-outline-info"><i class="fa fa-list"></i> Go Back</a>

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

  Registered sucessfully

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

  Error editing

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

 <h5>Report Work Day</h5>

 <hr>

 </div>

</div>

<div class="container">

<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Employed</label>

 <select class="form-control" name="id_empleado">
 		<?php foreach ($obtener_empleado as $value) { ?>
 			<option value="<?php echo $value->id_empleado?>"> <?php echo $value->nombres.' '.$value->apellidos ?> </option>
 		<?php } ?>
 </select>

 </div>

 </div>

</div>	


<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Date Begin</label>

 <input type="date" name="fecha_inicial" class="form-control">

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Date End</label>

 <input type="date" class="form-control" name="fecha_final" value="" >

 </div>

 </div>

</div>



<div class="row">

 <div class="col-md-3">

 <div class="form-group">

    <button class="btn btn-success btn-block" name="pdf_reporte_semanal" formtarget="_blank"><i class="fa fa-file"></i> Generate PDF</button>

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

