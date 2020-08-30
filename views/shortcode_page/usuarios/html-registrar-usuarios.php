<?php 

global $guardado_empleado; 

?>

<div class="container-fluid">

<div class="row">

<div class="col-md-12">

<a href="<?php echo get_site_url(); ?>/usuarios-sistema" class="btn btn-outline-info"><i class="fa fa-list"></i> Go Back</a>

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

  Error Register

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

 <h5>Register New</h5>

 <hr>

 </div>

</div>

<div class="container">

<div class="row">

 <div class="col-md-6">

  <div class="form-group">

    <label for="">Name user</label>

    <input type="text" class="form-control" name="usuario_nombreUsuario"> 

  </div>

 </div>

 <div class="col-md-6">

  <div class="form-group">

    <label for="">Email</label>

    <input type="email" class="form-control" name="usuario_correo"> 

  </div>

 </div>

</div>

<div class="row">

 <div class="col-md-6">

  <div class="form-group">

    <label for="">Password</label>
    <input type="password" class="form-control" name="usuario_clave"> 

  </div>

 </div>

 <div class="col-md-6">

  <div class="form-group">

    <label for="">Roles</label>

    <select name="usuario_rol" id="adduser-role" class="form-control">
      <option value="admin">Administrator General</option>
      <option value="secretary">Secretary</option>
      
			<?php //wp_dropdown_roles( get_option( 'default_role' ) ); ?>
		</select>

  </div>

 </div>

</div>







<div class="row">

 <div class="col-md-6">

 <div class="form-group">
  <input type="hidden" name="actualizar_usuarios">
  <button class="btn btn-success btn-block" name="guardar_nuevo_usuarios"><i class="fa fa-save"></i> Save</button>

</div>

 </div>

</div>



</div>

</form>

</div>

</div>

</div>

<br><br>