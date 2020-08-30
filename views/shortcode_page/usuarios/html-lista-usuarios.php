<?php 

global $wpdb;

global $guardado_empleado; 

?>

<div class="container-fluid">

<div class="row">

<div class="col-md-12">

<a href="<?php echo get_site_url(); ?>/usuarios-sistema?registrar-usuarios" class="btn btn-outline-info"><i class="fa fa-user-plus"></i> Register</a>

</div>

</div>

</div>

<br>

<div class="container">

<div class="row">

<div class="col-md-12">

<table class="table box-new-user" id="tabla-empleados">

  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Names</th>
      <th scope="col">Email</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>

  <tbody>

    <?php 

    //$empleados = $wpdb->get_results("SELECT * FROM " . TABLA_USUARIOS . "");
    $empleados = get_users( [ 'role__in' => [ 'secretary', 'admin' ] ] );
    $i = 1;
    foreach ($empleados as $key => $value):

    ?>

    <tr>

      <td scope="row"><?php echo $value->ID; ?></td>

      <td><?php echo $value->user_login; ?></td>

      <td><?php echo $value->user_email; ?></td>

      <td>
      
        <a href="<?php echo get_site_url(); ?>/usuarios-sistema?editar-usuarios=<?php echo $value->ID; ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> </a>
        <input type="hidden" name="actualizar_usuarios">
        <input type="hidden" name="id_usuario_form" value="<?php echo $value->ID; ?>">
        <button type="submit" class="btn btn-xs btn-danger eliminando_usuarios" name="eliminar_nuevo_usuarios" data-id="<?php echo $value->ID; ?>"><i class="fa fa-times-circle"></i></button>

      </td>

    </tr>

    <?php

    endforeach;

    ?>

  </tbody>

</table>

</div>
</div>
</div>

<br><br>