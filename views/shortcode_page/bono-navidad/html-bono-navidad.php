<?php 

global $wpdb;

global $guardado_empleado; 

?>

<br>

<div class="container">

 <div class="row mb-4">

  <div class="col-md-12">

    <a href="<?php echo get_site_url(); ?>/bono-navidad?registrar-bono-navidad" class="btn btn-outline-info"><i class="fa fa-user-plus"></i> Registrar</a>

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
        SELECT *, navidad.total as totalNavidad 
        FROM ".TABLA_BONO_NAVIDAD." as navidad
        LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = navidad.id_empleado
        LEFT JOIN ".TABLA_ESTADO." as estado ON estado.id_estado = navidad.estatus
        ORDER BY navidad.id_bono_navidad DESC
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

      <td><?php echo $value->totalNavidad; ?></td>

      <td><?php echo $value->fecha; ?></td>

      <td><?php echo $estado; ?></td>

      <td>
      
        <a href="<?php echo get_site_url(); ?>/bono-navidad?editar-bono-navidad=<?php echo $value->id_bono_navidad; ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
        <input type="hidden" name="bono_navidad">
        <input type="hidden" name="id_bono_navidad" value="<?php echo $value->id_bono_navidad; ?>">
        <button type="submit" class="btn btn-xs btn-danger eliminando_bonoNavidad" name="eliminar_bono_navidad" data-id="<?php echo $value->id_bono_navidad; ?>"><i class="fa fa-times-circle"></i></button>

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