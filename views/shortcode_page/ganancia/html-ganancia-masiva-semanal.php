<?php 

global $wpdb;
global $guardado_empleado; 

$value = $wpdb->get_row("
  SELECT *
  FROM ".TABLA_EMPLEADOS." as empleado
  WHERE empleado.id_empleado = ".$_GET["semanal"]."
");

?>

<br>

<div class="container">

  <div class="col-md-10">

   <h5>Ganancia  Masiva Semanal</h5>

   <hr>

 </div>

 <div class="row">

  <div class="col-md-12 mb-5">

  <a href="<?php echo get_site_url(); ?>/reporte-ganancia" class="btn btn-outline-info"><i class="fa fa-list"></i> Volver a la lista</a>

  </div>

</div>

<div class="row">
  <div class="container">
    <ul class="nav nav-tabs">
      <li class="active mr-3"><a data-toggle="tab" href="#busqueda" class="btn btn-success">Busqueda</a></li>
      <li><a data-toggle="tab" href="#reporte" class="btn btn-primary">Reporte</a></li>
    </ul>
    <div class="tab-content">
      <div id="busqueda" class="tab-pane in active mt-3">
        
      <form action="" class="box-new-user" method="POST" enctype="multipart/form-data">

        <div class="row mb-4">


        <div class="col-md">
          
            <div class="form-group">

              <label for="">Fecha Inicial</label>

              <input type="date" name="ingreso_fecha_inicial" class="form-control" required>

            </div>

        </div>

        <div class="col-md">
          
            <div class="form-group">

              <label for="">Fecha Final</label>

              <input type="date" name="ingreso_fecha_final" class="form-control" required>

            </div>

        </div>

        <div class="col-md d-flex justify-content-center align-items-center">
          
            <div class="form-group mb-0 mt-3">

              <button class="btn btn-success btn-block" name="ingresos_buscar"><i class="fa fa-search"></i> Buscar</button>

            </div>

        </div>

        </div> 

        </form>

      </div>

      <div id="reporte" class="tab-pane fade mt-3">
        
      <form action="" class="box-new-user" method="POST" enctype="multipart/form-data">

        <div class="row mb-4">


          <div class="col-md">
            
            <div class="form-group">

                <label for="">Fecha Inicial</label>

                <input type="date" name="ingreso_fecha_inicial" class="form-control" required>

            </div>

          </div>

          <div class="col-md">
            
            <div class="form-group">

                <label for="">Fecha Final</label>

                <input type="date" name="ingreso_fecha_final" class="form-control" required>

            </div>

          </div>

          <div class="col-md d-flex justify-content-center align-items-center">
            
            <div class="form-group mb-0 mt-3">

                <button class="btn btn-primary btn-block" name="pdf_reporte_semanal_ganancia_masiva" formtarget="_blank"><i class="fa fa-file mr-2"></i>Generar PDF</button>

            </div>

          </div>

        </div> 

        </form>
      </div>
    </div>
    
  </div>
</div>

 



<div class="row mt-5">

<div class="col-md-12">

<table class="table box-new-user" id="tabla-empleados">

  <thead>

    <tr>

      <th scope="col">#</th>

      <th scope="col">Nombres</th>

      <th scope="col">Fecha</th>

      <th scope="col">Horas</th>

      <th scope="col">Ingreso</th>


    </tr>

  </thead>

  <tbody>

    <?php 

    $consulta = 0;
    
    $retencion_total = 0;
    $ingreso_bruto_total = 0;
    $ingreso_neto_total = 0;
    $ingreso_pagos_total = 0;


    $i = 1;  
    $contar_hora = 0;  
    $contar_minutos = 0;

    $horas_calculo = array();

    if(isset($_POST["ingresos_buscar"])){

        $consulta = $wpdb->get_results("
          SELECT *
          FROM ".TABLA_JORNADA_DIARIA." as diario
          LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = diario.id_empleado
          LEFT JOIN ".TABLA_ESTADO." as estado ON estado.id_estado = diario.estatus
          WHERE diario.fecha BETWEEN '".$_POST["ingreso_fecha_inicial"]."' AND '".$_POST["ingreso_fecha_final"]."'
          ORDER BY diario.fecha DESC

      ");

    
    foreach ($consulta as $key => $value):

      $ingreso_bruto_total += $value->total;

    ?>

    <tr>

      <td scope="row"><?php echo $i++;?></td>

      <td><?php echo $value->nombres.' '.$value->apellidos; ?></td>

      <td><?php echo $value->fecha; ?></td>

      <td><?php echo $value->horas; ?></td>

      <td>$<?php echo $value->total; ?></td>
      

    </tr>

    <?php

    endforeach;

    }

    ?>

  </tbody>
  <tfoot>
    <th></th>
    <th></th>
    <th></th>
    <th>Total</th>
    <th>$<?php echo $ingreso_bruto_total; ?></th>
  </tfoot>

</table>
  
</div>

</div>

</div>

<br><br>


<?php 

  

function dateFormat($date)
{

  if(strlen($date) <= 2){

    $date1 = '00'.$date;
    $muestra = date_create($date1);
    $result = date_format($muestra, 'H:i:s');

  }else{

    $date1 = str_replace(":", "", $date);
    $muestra = date_create($date1);
    $result = date_format($muestra, 'H:i:s');

  }

  return $result;

}





 ?>