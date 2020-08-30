<?php 

global $wpdb;
global $guardado_empleado;

$obtener = $wpdb->get_row("SELECT * FROM " . TABLA_USUARIOS . " where ID = " .$_GET['editar-usuarios']. "");


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

 <h5>Modify User</h5>

 <hr>

 </div>

</div>

<div class="container">

<div class="row">

 <div class="col-md-6">

  <div class="form-group">

    <label for="">Name User</label>

    <input type="text" class="form-control" name="usuario_nombreUsuario" value="<?php echo $obtener->user_login ?>"> 

  </div>

 </div>

 <div class="col-md-6">

  <div class="form-group">

    <label for="">Email</label>

    <input type="email" class="form-control" name="usuario_correo" value="<?php echo $obtener->user_email ?>"> 

  </div>

 </div>

</div>

<div class="row">

 <div class="col-md-6">

  <div class="form-group">

    <label for="" class="mr-2">Password</label> <small> <span class="text-danger">No required</span> </small>
    <input type="password" class="form-control" name="usuario_clave"> 

  </div>

 </div>

 <div class="col-md-6">

  <div class="form-group">
    <?php 
      //obtener usuario con el id asi obtener el rol
      $user_info = get_userdata($obtener->ID);
    ?>

    <label for="">Roles</label>

    <select name="usuario_rol" id="adduser-role" class="form-control">
      <option value="<?php echo implode(', ', $user_info->roles);  ?>" selected="selected"><?php echo implode(', ', $user_info->roles)  ?></option>
      <option value="admin">Administrator General</option>
      <option value="secretary">secretary</option>
			<?php //wp_dropdown_roles( get_option( 'default_role' ) ); ?>
		</select>

  </div>

 </div>

</div>







<div class="row">

 <div class="col-md-6">

 <div class="form-group">
  <input type="hidden" name="actualizar_usuarios">
  <input type="hidden" name="id_usuario_form" value="<?php echo $obtener->ID ?>">
  <button class="btn btn-success btn-block" name="editar_nuevo_usuarios"><i class="fa fa-save"></i> Modify</button>

</div>

 </div>

</div>



</div>

</form>

</div>

</div>

</div>

<br><br>