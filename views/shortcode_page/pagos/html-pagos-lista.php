<?php 

global $wpdb;

global $guardado_empleado; 

?>

<br>

<div class="container">

 <div class="row mb-4">

  <div class="col-md-12">

    <a href="<?php echo get_site_url(); ?>/pagos" class="btn btn-outline-info"><i class="fa fa-user-plus"></i> Go Back</a>

    <a href="<?php echo get_site_url(); ?>/pagos?registrar-pagos=<?php echo $_GET["lista-pagos"]; ?>"  class="btn btn-success"><i class="fa fa-edit"></i> Register</a>

  </div>

</div> 

<div class="row">

<div class="col-md-12">

<table class="table box-new-user" id="tabla-empleados">

  <thead>

    <tr>

      <th scope="col">#</th>

      <th scope="col">Names</th>

      <th scope="col">Commision</th>

      <th scope="col">Bonus christmas</th>

      <th scope="col">Hours Extra</th>

      <th scope="col">Total Work Day</th>

      <th scope="col">Total General</th>

      <th scope="col">Receipt</th>
     

    </tr>

  </thead>

  <tbody>

    <?php 

    $empleados = $wpdb->get_results("
      SELECT *
      FROM ". TABLA_PAGO . " as pago
      LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = pago.id_empleado
      WHERE pago.id_empleado = ".$_GET["lista-pagos"]."
    ");

    $i = 1;
    foreach ($empleados as $key => $value):

    ?>

    <tr>

      <td scope="row"><?php echo $i++; ?></td>

      <td><?php echo $value->nombres." ".$value->apellidos;  ?></td>

      <td> <?php echo $value->comision ?> </td>
      <td> <?php echo $value->bonoNavidad ?> </td>
      <td> <?php echo $value->horaExtra ?> </td>
      <td> <?php echo $value->totalJornada ?> </td>
      <td> <?php echo $value->totalGeneral ?> </td>

      <td>

        <?php echo $value->recibo ?>

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