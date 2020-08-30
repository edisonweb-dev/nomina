<?php 

global $wpdb;

global $guardado_empleado; 

?>

<br>

<div class="container">

 <div class="row mb-4">

  <div class="col-md-12">


  </div>

</div> 

<div class="row">

<div class="col-md-12">

<table class="table box-new-user" id="tabla-empleados">

  <thead>

    <tr>

      <th scope="col">#</th>

      <th scope="col">Names</th>

      <th scope="col">Date</th>

      <th scope="col">Actions</th>
     

    </tr>

  </thead>

  <tbody>

    <?php 

    $empleados = $wpdb->get_results("
        SELECT *
        FROM ".TABLA_EMPLEADOS." as empleados
      ");

    $i = 1;

    foreach ($empleados as $key => $value):

      

    ?>

    <tr>

      <td scope="row"><?php echo $i++; ?></td>

      <td><?php echo $value->nombres." ".$value->apellidos;  ?></td>

      <td><?php echo date('Y-m-d'); ?></td>

      <td>

        <a href="<?php echo get_site_url(); ?>/retencion?semanal=<?php echo $value->id_empleado; ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i>Weekly</a>

        <a href="<?php echo get_site_url(); ?>/retencion?mensual=<?php echo $value->id_empleado; ?>" class="btn btn-xs btn-success"><i class="fa fa-edit"></i>Monthly</a>

        <a href="<?php echo get_site_url(); ?>/retencion?anual=<?php echo $value->id_empleado; ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i>Yearly</a>

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