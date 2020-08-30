<?php 

global $wpdb;

global $guardado_empleado; 

?>

<br>

<div class="container">

<div class="col-md-12 mb-3">
  <a href="<?php echo get_site_url(); ?>/gestion-salario" class="btn btn-primary">Salary</a>
  <a href="<?php echo get_site_url(); ?>/gestion-horas-extra" class="btn btn-secondary">Overtime</a>
</div>

<div class="row">

<div class="col-md-12">

<table class="table box-new-user" id="tabla-empleados">

  <thead>

    <tr>

      <th scope="col">#</th>

      <th scope="col">Names</th>

      <th scope="col">Date begin</th>

      <th scope="col">Date end</th>

      <th scope="col">Salary</th>

      <th scope="col">Status</th>

      <th scope="col">Actions</th>

     

    </tr>

  </thead>

  <tbody>

    <?php 

    $empleados = $wpdb->get_results("
        SELECT *, salario.salario as salarioF 
        FROM ".TABLA_EMPLEADOS." as empleado
        LEFT JOIN ".TABLA_SALARIO." as salario ON salario.id_empleado = empleado.id_empleado
        LEFT JOIN ".TABLA_ESTADO." as estado ON estado.id_estado = salario.estatus
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

      <td><?php echo $value->fecha_inicial; ?></td>

      <td><?php echo $value->fecha_final; ?></td>

      <td>$<?php echo $value->salarioF; ?></td>

      <td><?php echo $estado; ?></td>

      <td>
      
        <a href="<?php echo get_site_url(); ?>/gestion-salario?editar-salario=<?php echo $value->id_empleado; ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
        <input type="hidden" name="actualizar_salario_temporal">
        <input type="hidden" name="id_empleado_salario" value="<?php echo $value->id_empleado; ?>">
        <button type="submit" class="btn btn-xs btn-danger eliminando_salario" name="eliminar_usuarios_salario" data-id="<?php echo $value->id_empleado; ?>"><i class="fa fa-times-circle"></i></button>
      
        

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