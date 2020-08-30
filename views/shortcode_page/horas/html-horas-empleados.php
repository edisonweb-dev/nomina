<?php 

global $wpdb;

global $guardado_empleado; 

?>

<br>

<div class="container">

<div class="row">

<div class="col-md-12">

<table class="table box-new-user" id="tabla-empleados">

  <thead>

    <tr>

      <th scope="col">#</th>

      <th scope="col">Nombres</th>

      <th scope="col">Fecha Inicial</th>

      <th scope="col">Fecha Final</th>
      
      <th scope="col">Sumar hora</th>

      <th scope="col">Restar hora</th>

      <th scope="col">Estado</th>

      <th scope="col">Acciones</th>
     

    </tr>

  </thead>

  <tbody>

    <?php 

    $empleados = $wpdb->get_results("
        SELECT * 
          FROM ".TABLA_EMPLEADOS." as empleado
          LEFT JOIN ".TABLA_GESTION_HORA." as hora ON hora.id_empleado = empleado.id_empleado
          LEFT JOIN ".TABLA_ESTADO." as estado ON estado.id_estado = hora.estatus
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

      <td><?php echo $value->fecha_desde; ?></td>

      <td><?php echo $value->fecha_hasta; ?></td>

      <td><?php echo $value->hora_suma; ?></td>

      <td><?php echo $value->hora_resta; ?></td>
      
      <td><?php echo $estado; ?></td>

      <td>

      
      <form action="" method="post">
      <a href="<?php echo get_site_url(); ?>/gestion-horas?editar-gestion-hora=<?php echo $value->id_empleado; ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
        <input type="hidden" name="actualizar_gestion_hora_eliminar">
        <input type="hidden" name="id_empleado" value="<?php echo $value->id_empleado; ?>">
        <button type="submit" class="btn btn-xs btn-danger eliminar_en_lista" name="actualizar_gestion_hora"><i class="fa fa-times-circle"></i></button>
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