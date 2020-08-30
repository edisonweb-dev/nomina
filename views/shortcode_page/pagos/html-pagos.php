<?php 

global $wpdb;

global $guardado_empleado; 

?>

<br>

<div class="container">

 <div class="row mb-4">

  <div class="col-md-12">

    <!-- <a href="<?php //echo get_site_url(); ?>/pagos?registrar-pagos" class="btn btn-outline-info"><i class="fa fa-user-plus"></i> Registrar Nuevo</a> -->

  </div>

</div> 

<div class="row">

<div class="col-md-12">

<table class="table box-new-user" id="tabla-empleados">

  <thead>

    <tr>

      <th scope="col">#</th>

      <th scope="col">Names</th>

      <th scope="col">Email</th>

      <th scope="col">Phone</th>

      <th scope="col">Actions</th>
     

    </tr>

  </thead>

  <tbody>

    <?php 

    $empleados = $wpdb->get_results("
      SELECT *
      FROM ". TABLA_EMPLEADOS . " 
    ");

    $i = 1;
    foreach ($empleados as $key => $value):

    ?>

    <tr>

      <td scope="row"><?php echo $i++; ?></td>

      <td><?php echo $value->nombres." ".$value->apellidos;  ?></td>

      <td><?php echo $value->email; ?></td>

      <td><?php echo $value->nro_telefono; ?></td>

      <td>

        <form action="" method="post">
          <a href="<?php echo get_site_url(); ?>/pagos?lista-pagos=<?php echo $value->id_empleado; ?>" class="btn btn-xs btn-info"><i class="fa fa-list"></i></a>
        </form>

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