<?php 

global $wpdb;

global $guardado_empleado; 

?>

<div class="container-fluid">

<div class="row">

<div class="col-md-12">

<a href="<?php echo get_site_url(); ?>/gestion-empleados?registrar-nuevo-empleado" class="btn btn-outline-info"><i class="fa fa-user-plus"></i> Register</a>

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

      <th scope="col">Last Name</th>

      <th scope="col">Phone</th>

      <th scope="col">Actions</th>

     

    </tr>

  </thead>

  <tbody>

    <?php 

    $empleados = $wpdb->get_results("SELECT * FROM " . TABLA_EMPLEADOS . "");

    foreach ($empleados as $key => $value):

    ?>

    <tr>

      <td scope="row"><?php echo $value->id_empleado; ?></td>

      <td><?php echo $value->nombres; ?></td>

      <td><?php echo $value->apellidos; ?></td>
      
      <td><?php echo $value->nro_telefono; ?></td>

      <td>

      
        <a href="<?php echo get_site_url(); ?>/gestion-empleados?gestionar-empleado=<?php echo $value->id_empleado; ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> </a>
        
        <input type="hidden" name="id_empleados" value="<?php echo $value->id_empleado; ?>">
        <button type="submit" class="btn btn-xs btn-danger eliminando_empleado" name="eliminar_empleados" data-id="<?php echo $value->id_empleado; ?>"><i class="fa fa-times-circle"></i></button>
      

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