<?php 

global $wpdb;

global $guardado_empleado; 

?>

<br>

<div class="container">

 <div class="row mb-4">

  <div class="col-md-12">

    <a href="<?php echo get_site_url(); ?>/comision?registrar-comision" class="btn btn-outline-info"><i class="fa fa-user-plus"></i> Registrar</a>

  </div>

</div> 

<div class="row">

<div class="col-md-12">

<table class="table box-new-user" id="tabla-empleados">

  <thead>

    <tr>

      <th scope="col">#</th>

      <th scope="col">Nombres</th>

      <th scope="col">Total</th>

      <th scope="col">Fecha</th>

      <th scope="col">Estado</th>

      <th scope="col">Acciones</th>
     

    </tr>

  </thead>

  <tbody>

    <?php 

    $empleados = $wpdb->get_results("
        SELECT *, comision.total as totalComision
        FROM ".TABLA_COMISION." as comision
        LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = comision.id_empleado
        LEFT JOIN ".TABLA_ESTADO." as estado ON estado.id_estado = comision.estatus
        ORDER BY comision.id_comision DESC
      ");

    $i = 1;
    foreach ($empleados as $key => $value):

      if($value->id_estado == 0){
        $estado = '<span class="btn btn-warning btn-sm btn-block">'.$value->nombre.'</span>';
      }else if($value->id_estado == 1){
        $estado = '<span class="btn btn-success btn-sm btn-block">'.$value->nombre.'</span>';
      }

    ?>

    <tr>

      <td scope="row"><?php echo $i++; ?></td>

      <td><?php echo $value->nombres." ".$value->apellidos;  ?></td>

      <td><?php echo $value->totalComision; ?></td>

      <td><?php echo $value->fecha; ?></td>

      <td><?php echo $estado; ?></td>

      <td>
      
        <a href="<?php echo get_site_url(); ?>/comision?editar-comision=<?php echo $value->id_comision; ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
        <input type="hidden" name="comision">
        <input type="hidden" name="id_comision" value="<?php echo $value->id_comision; ?>">
        <button type="submit" class="btn btn-xs btn-danger eliminando_comision" name="eliminar_comision" data-id="<?php echo $value->id_comision; ?>"><i class="fa fa-times-circle"></i></button>
      
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