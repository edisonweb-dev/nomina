<?php 

global $wpdb;

global $guardado_empleado; 

?>

<br>

<div class="container">

<div class="row">

<div class="col-md-12 mb-3">
  <a href="<?php echo get_site_url(); ?>/gestion-salario" class="btn btn-secondary mr-2">Salary</a>
  <a href="<?php echo get_site_url(); ?>/gestion-horas-extra" class="btn btn-primary">Overtime</a>
</div>

</div>

<div class="row">

<div class="col-md-12">

<table class="table box-new-user" id="tabla-empleados">

  <thead>

    <tr>

      <th scope="col">#</th>

      <th scope="col">Names</th>

      <th scope="col">Extra Hour</th>

      <th scope="col">Status</th>

      <th scope="col">Actions</th>
     

    </tr>

  </thead>

  <tbody>

    <?php 

    $empleados = $wpdb->get_results("
        SELECT *, empleado.id_empleado as idEmpleado 
          FROM ".TABLA_EMPLEADOS." as empleado
          LEFT JOIN ".TABLA_HORA_EXTRA." as horaE ON horaE.id_empleado = empleado.id_empleado
          LEFT JOIN ".TABLA_ESTADO." as estado ON estado.id_estado = horaE.estatus
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

      <td>$<?php echo $value->salario_hora_extra; ?></td>

      <td><?php echo $estado; ?></td>

      <td>

        <a href="<?php echo get_site_url(); ?>/gestion-horas-extras?editar-hora=<?php echo $value->idEmpleado; ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
        <input type="hidden" name="actualizar_hora_extra">
        <input type="hidden" name="id_empleado" value="<?php echo $value->idEmpleado; ?>">
        <button type="submit" class="btn btn-xs btn-danger eliminando_overtime" name="actualizar_hora_extra_eliminar" data-id="<?php echo $value->idEmpleado; ?>"><i class="fa fa-times-circle"></i></button>

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