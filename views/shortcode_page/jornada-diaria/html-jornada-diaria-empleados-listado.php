<?php 

global $wpdb;

global $guardado_empleado; 

$empleado = $wpdb->get_row("SELECT * FROM " . TABLA_EMPLEADOS . " where id_empleado = " .$_GET["listado-jornada-diaria"]. "");

//var_dump($empleado);

?>

<br>

<div class="container">

 <div class="row mb-4">

  <div class="col-md-12">
  
  <a href="#" id="nuevo_registro" class="btn btn-xs btn-info mr-2"><i class="fa fa-user-plus"></i> Register New Working Day</a>

  <a href="<?php echo get_site_url(); ?>/gestion-jornada-diaria" class="btn btn-outline-info"><i class="fa fa-list"></i> Go Back</a>

  </div>

</div> 

<div class="row">
    <div class="col-md-12">
        <h4>Work Day Employed: <i><?php echo $empleado->nombres." ".$empleado->apellidos;  ?></i></h4>  
    </div>
</div>

<div id="registrar_mostrar" style="display:none">

  <div class="container">

  <div class="row">

  <div class="col-md-12">

  <form action="" class="box-new-user" method="POST" enctype="multipart/form-data">

    <div class="container">

      <div class="row">

        <div class="col-md-12">

          <h5>Register Work Day</h5>

          <hr>

        </div>

      </div>

    <div class="container">

      <div class="row">

        <div class="col-md-6">

          <div class="form-group">

            <label for="">Employed</label>

              <input type="text" class="form-control" name="horaExtra_name" value="<?php echo $empleado->nombres." ".$empleado->apellidos; ?>" readonly>
              <input type="hidden" class="form-control" name="horaExtra_nombres" value="<?php echo $empleado->id_empleado; ?>">

          </div>

        </div>

        <div class="col-md-6">

          <div class="form-group">

            <label for="">Date</label>

            <input id="fecha_jornada" type="date" class="form-control" name="gestionJornada_fecha" value="<?php echo date("Y-m-d") ?>" >

          </div>

        </div>

        <div class="col-md-6">

          <div class="form-group">

            <a id="ruta_registrar" href="<?php echo get_site_url(); ?>/gestion-jornada-diaria?registrar-nueva-jornada=<?php echo $_GET["listado-jornada-diaria"] ?>&fecha=" class="btn btn-xs btn-info mr-2"><i class="fa fa-user-plus"></i> Save</a>

          </div>

        </div>

      </div>

    </div>

    </div>


  </div>
  </div>
  </div>
</div>



<div class="row">

<div class="col-md-12">

<table class="table box-new-user" id="tabla-empleados">

  <thead>

    <tr>

      <th scope="col">#</th>

      <!--<th scope="col">Nombres</th>-->

      <th scope="col">Date</th>

      <th scope="col">Hour In</th>

      <th scope="col">Hour Out</th>

      <th scope="col">First Break In</th>

      <th scope="col">First Break Out</th>

      <th scope="col">Second Break In</th>

      <th scope="col">Second Break Out</th>
      
      <th scope="col">Add Hours</th>

      <th scope="col">Subtract Hours</th>

      <th scope="col">Status</th>

      <th scope="col">Actions</th>
     

    </tr>

  </thead>

  <tbody>

    <?php 
    
    $empleados = $wpdb->get_results("
        SELECT * 
          FROM ".TABLA_JORNADA_DIARIA." as jornada
          LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = jornada.id_empleado 
          LEFT JOIN ".TABLA_ESTADO." as estado ON estado.id_estado = jornada.estatus
          WHERE jornada.id_empleado = ".$_GET["listado-jornada-diaria"]."
          ORDER BY jornada.fecha DESC
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

      <!--<td></td>-->

      <td><?php echo $value->fecha; ?></td>

      <td><?php echo $value->hora_entrada; ?></td>

      <td><?php echo $value->hora_salida; ?></td>

      <td><?php echo $value->hora_descanso_entrada; ?></td>

      <td><?php echo $value->hora_descanso_salida; ?></td>

      <td><?php echo $value->hora_descanso_entrada_second; ?></td>

      <td><?php echo $value->hora_descanso_salida_second; ?></td>
      
      <td><?php echo $value->hora_suma; ?></td>

      <td><?php echo $value->hora_resta; ?></td>
      
      <td><?php echo $estado; ?></td>

      <td class="accion">

        <a href="<?php echo get_site_url(); ?>/gestion-jornada-diaria?editar-jornada-diaria=<?php echo $value->id_jornada_diaria; ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
        <input type="hidden" name="jornada_diaria">
        <input type="hidden" name="id_jornada" value="<?php echo $value->id_jornada_diaria; ?>">
        <button type="submit" class="btn btn-xs btn-danger eliminando_jornada" name="jornada_diaria_eliminar" data-id="<?php echo $value->id_jornada_diaria; ?>"><i class="fa fa-times-circle"></i></button>

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