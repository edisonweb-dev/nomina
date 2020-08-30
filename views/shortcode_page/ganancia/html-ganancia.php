<?php 

global $wpdb;

global $guardado_empleado; 

?>

<br>

<div class="container">

 <div class="row mb-4">

  <div class="col-md-12">
    
    <a href="<?php echo get_site_url(); ?>/reporte-ganancia?masiva_semanal" class="btn btn-outline-info"><i class="fa fa-user-plus"></i> Reporte Grupal Semanal</a>

    <a href="<?php echo get_site_url(); ?>/reporte-ganancia?masiva_mensual" class="btn btn-outline-info"><i class="fa fa-user-plus"></i> Reporte Grupal Mensual</a>
    
    <a href="<?php echo get_site_url(); ?>/reporte-ganancia?masiva_anual" class="btn btn-outline-info"><i class="fa fa-user-plus"></i> Reporte Grupal Anual</a>
  
  </div>

</div> 

<div class="row">

<div class="col-md-12">

<table class="table box-new-user" id="tabla-empleados">

  <thead>

    <tr>

      <th scope="col">#</th>

      <th scope="col">Nombres</th>

      <th scope="col">Fecha</th>

      <th scope="col">Acciones</th>
     

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

        <a href="<?php echo get_site_url(); ?>/reporte-ganancia?semanal=<?php echo $value->id_empleado; ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i>Semanal</a>

        <a href="<?php echo get_site_url(); ?>/reporte-ganancia?mensual=<?php echo $value->id_empleado; ?>" class="btn btn-xs btn-success"><i class="fa fa-edit"></i>Mensual</a>

        <a href="<?php echo get_site_url(); ?>/reporte-ganancia?anual=<?php echo $value->id_empleado; ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i>Anual</a>

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