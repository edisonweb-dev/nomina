<?php 

global $wpdb;

global $guardado_empleado; 

?>

<br>

<div class="container">

 <div class="row mb-4">

  <div class="col-md-12">

    <!-- <a href="<?php //echo get_site_url(); ?>/gestion-jornada-diaria?registrar-nueva-jornada" class="btn btn-outline-info"><i class="fa fa-user-plus"></i> Registrar</a> -->

  </div>

</div> 

<div class="row">

<div class="col-md-12">

<table class="table box-new-user" id="tabla-empleados">

  <thead>

    <tr>

      <th scope="col">#</th>

      <th scope="col">Names</th>

      <th scope="col">Phone</th>

      <th scope="col">Salary</th>

      <th scope="col">Total Hours</th>

      <th scope="col">Commission</th>

      <th scope="col">Bonus</th>

      <th scope="col">Actions</th>

    </tr>

  </thead>

  <tbody>

    <?php 

    $empleados = $wpdb->get_results(" 
            SELECT *, SUM(jornada.horas) as totalHour, SUM(jornada.comision) as commission, SUM(jornada.bono) as bonus
            FROM ".TABLA_EMPLEADOS." as empleado 
            LEFT JOIN ".TABLA_JORNADA_DIARIA." as jornada ON jornada.id_empleado = empleado.id_empleado          
          ");

    $i = 1;
    foreach ($empleados as $key => $value):

    ?>

    <tr>

      <td scope="row"><?php echo $i++; ?></td>

      <td><?php echo $value->nombres." ".$value->apellidos;  ?></td>

      <td><?php echo $value->nro_telefono; ?></td>

      <td>$<?php echo $value->salario; ?></td>

      <td><?php echo bcdiv($value->totalHour, 1, 2); ?></td>

      <td>$<?php echo bcdiv($value->commission, 1, 2); ?></td>

      <td>$<?php echo bcdiv($value->bonus, 1, 2); ?></td>

      <td>
        
        <a href="<?php echo get_site_url(); ?>/gestion-jornada-diaria?listado-jornada-diaria=<?php echo $value->id_empleado; ?>" class="btn btn-xs btn-info"><i class="fa fa-list"></i></a>

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