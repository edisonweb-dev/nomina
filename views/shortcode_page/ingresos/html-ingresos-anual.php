<?php 

global $wpdb;
global $guardado_empleado; 

$empleados_sql = $wpdb->get_results("
  SELECT *
  FROM ".TABLA_EMPLEADOS." as empleado
");

$val = $wpdb->get_row("
  SELECT *
  FROM ".TABLA_EMPLEADOS." as empleado
  WHERE empleado.id_empleado = ".$_GET["anual"]."
");

?>

<br>

<div class="container">

  <div class="col-md-10">

   <h5>Income Yearly</h5>

   <hr>

 </div>

 <div class="row">

  <div class="col-md-12 mb-5">

  <a href="<?php echo get_site_url(); ?>/ingresos" class="btn btn-outline-info"><i class="fa fa-list"></i> Go Back</a>

  </div>

</div>

 

<form action="" class="box-new-user" method="POST" enctype="multipart/form-data">

 <div class="row mb-4">

  <div class="col-md-4">
    
     <div class="form-group">

      <label for="">Employed</label>

      <select name="ingreso_id_empleado" class="form-control" >
        <!-- <option value="<?php //echo $val->id_empleado ?>"><?php //echo $val->nombres.' '.$val->apellidos ?></option> -->
        <?php
          foreach($empleados_sql as $value){

            if(isset($_POST["ingreso_id_empleado"])){
              
              if($value->id_empleado == $_POST["ingreso_id_empleado"]){
                echo '<option value="'.$value->id_empleado.'" selected>'.$value->nombres.' '.$value->apellidos.'</option>';
              }else{
                echo '<option value="'.$value->id_empleado.'">'.$value->nombres.' '.$value->apellidos.'</option>';
              }

            }else{

              if($value->id_empleado == $val->id_empleado){
                echo '<option value="'.$value->id_empleado.'" selected>'.$value->nombres.' '.$value->apellidos.'</option>';
              }else{
                echo '<option value="'.$value->id_empleado.'">'.$value->nombres.' '.$value->apellidos.'</option>';
              }

            }

            
          }

          
        ?>
      </select>

     </div>

  </div>


  <div class="col-md-4">
    
     <div class="form-group">

        <label for="">Date</label>

        <?php
          $cont = date('Y');
        ?>
        <select id="sel1" name="ingreso_fecha_anual" class="form-control" required>
          <?php 

          while ($cont >= 1990) { 

            if($cont == $_POST["ingreso_fecha_anual"]){
              echo  '<option value="'.$cont.'" selected>'.$cont.'</option>';
            }else{
              echo  '<option value="'.$cont.'">'.$cont.'</option>';
            }

           $cont = ($cont-1); 
          } 

          ?>
        </select>

     </div>

  </div>

  <div class="col-md d-flex justify-content-center align-items-center">
    
     <div class="form-group mb-0 mt-3">

        <button class="btn btn-success btn-block" name="ingresos_buscar"><i class="fa fa-search"></i> Search</button>

     </div>

  </div>

</div> 

</form>

<div class="row mt-5">

<div class="col-md-12">

<table class="table box-new-user" id="tabla-empleados">

  <thead>

    <tr>

      <th scope="col">#</th>

      <th scope="col">Names</th>

      <th scope="col">Date</th>

      <th scope="col">Hours Work</th>

      <th scope="col">Commission</th>

      <th scope="col">Bonus</th>

      <th scope="col">Income Gross</th>

      <th scope="col">Retention</th>

      <th scope="col">Income Net</th>

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

    $comision_total = 0;
    $bono_total = 0;

    $horas_calculo = array();

    if(isset($_POST["ingresos_buscar"])){

        $consulta = $wpdb->get_results("
          SELECT *
          FROM ".TABLA_JORNADA_DIARIA." as diario
          LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = diario.id_empleado
          LEFT JOIN ".TABLA_ESTADO." as estado ON estado.id_estado = diario.estatus
          WHERE YEAR(diario.fecha) = ".$_POST["ingreso_fecha_anual"]."
          AND diario.id_empleado = ".$_POST["ingreso_id_empleado"]."
          ORDER BY diario.fecha DESC
      ");

    
    foreach ($consulta as $key => $value):


      $retencion_total += $value->retencion;
      $ingreso_bruto_total += $value->total_sin_retencion;
      $ingreso_neto_total += $value->total_sin_retencion - $value->retencion;
      $ingreso_pagos_total += $value->total_sin_retencion;

      $hora1 = explode(':', $value->horas);
      $contar_hora += $hora1[0];
      $contar_minutos += $hora1[1];
      
      if(!empty($value->comision)){
        $comision_total += $value->comision;
      }

      if(!empty($value->bono)){
        $bono_total += $value->bono;
      }
      

    ?>

    <tr>

      <td scope="row"><?php echo $i++;?></td>

      <td><?php echo $value->nombres.' '.$value->apellidos; ?></td>

      <td><?php echo $value->fecha; ?></td>

      <td><?php echo bcdiv($value->horas, 1, 2); ?></td>

      <td>$<?php echo bcdiv($value->comision, 1, 2); ?></td>

      <td>$<?php echo bcdiv($value->bono, 1, 2); ?></td>

      <td>$<?php echo bcdiv($value->total_sin_retencion, 1, 2); ?></td>

      <td>$<?php echo bcdiv($value->retencion, 1, 2); ?></td>

      <td>$<?php echo bcdiv( ($value->total_sin_retencion - $value->retencion) , 1, 2); ?></td>
      

    </tr>

    <?php

    endforeach;

    }
    

    $minutos_totales = $contar_minutos / 60;

    ?>

  </tbody>
  <tfoot>
    <th></th>
    <th></th>
    <th>Total</th>
    <th>Hrs: <?php echo bcdiv($contar_hora, 1, 2); ?></th>

    <th>Co: <?php echo bcdiv($comision_total, 1, 2); ?></th>
    <th>Bo: <?php echo bcdiv($bono_total, 1, 2); ?></th>

    <th>IB: $<?php echo bcdiv($ingreso_bruto_total, 1, 2); ?></th>
    <th>Ret: $<?php echo bcdiv($retencion_total, 1, 2); ?></th>
    <th>IN: $<?php echo bcdiv($ingreso_neto_total, 1, 2); ?></th>
    
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