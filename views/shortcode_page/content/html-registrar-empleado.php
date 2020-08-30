<?php 

global $guardado_empleado; 

?>

<div class="container-fluid">

<div class="row">

<div class="col-md-12">

<a href="<?php echo get_site_url(); ?>/gestion-empleados" class="btn btn-outline-info"><i class="fa fa-list"></i> Go Back</a>

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

  Registration Error

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

<?php

$data = [

'fecha_desde' =>  '2019-08-11'

];

//echo "Mes: " . obtener_meses($data) . " Dia: " . obtener_dias($data) ;

?>

<div class="container">

<div class="row">

 <div class="col-md-12">

 <h5>New Register</h5>

 <hr>

 </div>

</div>

<div class="container">

<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Photo</label>

  <input type="file" class="form-control" id="customFileLang" name="foto" lang="es" data-browse="Seleccione">

</div>

 </div>

</div>



<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Names</label>

 <input type="text" class="form-control" name="Names" placeholder="Names">

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Last Name</label>

 <input type="text" class="form-control" name="Surnames" placeholder="Surnames">

 </div>

 </div>

</div>



<div class="row">

 <div class="col-md-9">

 <div class="form-group">

 <label for="">Address</label>

 <input type="text" class="form-control" name="direccion" placeholder="Address">

 </div>

 </div>

 <div class="col-md-3">

 <div class="form-group">

 <label for="">Code Postal</label>

 <input type="text" class="form-control" name="cod_postal" placeholder="Code Postal">

 </div>

 </div>

</div>



<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Email</label>

 <input type="email" class="form-control" name="email" placeholder="Email">

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Date of birth</label>

 <input type="date" class="form-control" name="fecha_nac" placeholder="date of birth">

 </div>

 </div>

</div>



<div class="row">

 <div class="col-md-4">

 <div class="form-group">

 <label for="">Number Employed</label>

 <input type="text" class="form-control" name="nro_empleado" placeholder="Number Employed">

 </div>

 </div>

 <div class="col-md-4">

 <div class="form-group">

 <label for="">Social Security Numbers</label>

 <input type="text" class="form-control" name="nro_seguro_social" placeholder="772 99 9999"  title="Use the format 772 99 9999" id="seguroSocial">
 <!-- pattern="^[1-7]{3}-?[1-9]{2}-?[1-9]{4}$" -->

 </div>

 </div>

 <div class="col-md-4">

 <div class="form-group">

 <label for="">Work Start Date</label>

 <input type="date" class="form-control" name="fecha_comienzo" placeholder="Work Start Date">

 </div>

 </div>

</div>



<div class="row">

 <div class="col-md-4">

 <div class="form-group">

 <label for="">Route Number</label>

 <input type="text" class="form-control" name="nro_ruta" placeholder="Route Number">

 </div>

 </div>

 <div class="col-md-8">

 <div class="form-group">

 <label for="">Bank Account Number</label>

 <input type="text" class="form-control" name="nro_cuenta" placeholder="Bank account Number">

 </div>

 </div>

</div>



<div class="row">

 <div class="col-md-4">

 <div class="form-group">

 <label for="">Driver License Number</label>

 <input type="text" class="form-control" name="nro_licencia_motor">

 </div>

 </div>

 <div class="col-md-4">

 <div class="form-group">

 <label for="">Electrician License Number</label>

 <input type="text" class="form-control" name="nro_licencia_electricista" placeholder="Electrician License Number">

 </div>

 </div>

 <div class="col-md-4">

 <div class="form-group">

 <label for="">Phone Number</label>

 <input type="text" class="form-control" name="nro_telefono" placeholder="000-000-0000" pattern="^[0-9]{3}[-][0-9]{3}[-][0-9]{4}$" title="Use the format 000-000-0000" id="validarTelefono" >

 </div>

 </div>

</div>


<div class="row">

 <div class="col-md-4">

 <div class="form-group">

 <label for="">Salary | Hours</label>

 <input type="number"  step="0.01" class="form-control" name="nro_salario" placeholder="0.00" id="numerico" pattern="^[0-9]+(\\.[0-9]{2})?$" >

 </div>

 </div>

 </div>



<div class="row">

 <div class="col-md-6">

 <div class="form-group">

<button class="btn btn-success btn-block" name="guardar_nuevo_empleado"><i class="fa fa-save"></i> Save</button>

</div>

 </div>

</div>



</div>

</form>

</div>

</div>

</div>

<br><br>