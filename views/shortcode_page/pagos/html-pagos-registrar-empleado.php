<?php

global $wpdb;
global $guardado_empleado;

$obtener_empleado = $wpdb->get_row("
  SELECT * 
  FROM ".TABLA_EMPLEADOS." as empleado 
  WHERE empleado.id_empleado  = ".$_GET["registrar-pagos"]."
");

?>

<div class="container-fluid">

<div class="row">

<div class="col-md-12">

<a href="<?php echo get_site_url(); ?>/pagos" class="btn btn-outline-info"><i class="fa fa-list"></i> Go Back</a>

</div>

</div>

</div>

<br>

<?php 

if($guardado_empleado == 1):

?>

<div class="container">

<div class="row">

<div class="col-md-12">

<div class="alert alert-success" role="alert">

  Registered Successfully

</div>

</div>

</div>

</div>

<?php 

elseif($guardado_empleado == 2):

?>

<div class="container">

<div class="row">

<div class="col-md-12">

<div class="alert alert-danger" role="alert">

  Error Editing

</div>

</div>

</div>

</div>

<?php 

else:

endif;

?>

<br>

<div class="container">

<div class="row">

<div class="col-md-12">

<form action="" class="box-new-user" method="POST" enctype="multipart/form-data">

<div class="container">

<div class="row">

 <div class="col-md-12">

 <h5>Register Pay</h5>

 <hr>

 </div>

</div>

<div class="container">

<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Employed</label>

  <input type="text" class="form-control" name="pagos_nombres" value="<?php echo $obtener_empleado->nombres.' '.$obtener_empleado->apellidos ?>" readonly>

 </div>

 </div>

 

</div>


<div class="row">

 <div class="col-md-6">

 <div class="form-group">

    <label for="">Date Begin</label>

    <input type="date" class="form-control" name="pago_fechaInicial" required>

 </div>

 </div>

  <div class="col-md-6">

 <div class="form-group">

    <label for="">Date End</label>

    <input type="date" class="form-control" name="pago_fechaFinal" required>

 </div>

 </div>

 

</div>








  

</div>






<div class="row d-flex justify-content-around">

 <div class="col-md-3">

  <div class="form-group">

    <input type="hidden" name="pagos" vale="1">
    <button class="btn btn-info btn-block" name="listar_pagos"><i class="fa fa-save"></i> Search</button>

</form>

  </div>

 </div>

 

</div>





</div>



</div>

</div><!-- Fin Row -->

</div>

</div>

<br>

<!--  SALARIO    -->

<?php 

  if(isset($_POST['listar_pagos'])){

    $obtener_recibo_pago = $wpdb->get_row("
        SELECT MAX(pago.recibo) as recibo 
        FROM ".TABLA_PAGO." as pago 
        ORDER BY pago.id_gestion_pago DESC
      ");

    $obtener_retencion = $wpdb->get_row("
      SELECT SUM(jornada.retencion) as retenciones 
      FROM ".TABLA_JORNADA_DIARIA." as jornada
      WHERE jornada.id_empleado = ".$_GET["registrar-pagos"]."
      AND jornada.fecha BETWEEN '".$_POST["pago_fechaInicial"]."'
      AND '".$_POST["pago_fechaFinal"]."'
    ");
    
    $obtener_salario_extra = $wpdb->get_row("
          SELECT extra.salario_hora_extra as salario_extra 
          FROM ".TABLA_HORA_EXTRA." as extra 
          WHERE extra.id_empleado = ".$_GET["registrar-pagos"]."
      ");

    $obtener_listado_pago = $wpdb->get_results("
      SELECT *, 
        jornada.total_sin_retencion as jornadaTotal,
        jornada.fecha as fechaJornada

      FROM ".TABLA_JORNADA_DIARIA." as jornada
      LEFT JOIN ".TABLA_EMPLEADOS." as empleado 
        ON empleado.id_empleado = jornada.id_empleado
      LEFT JOIN ".TABLA_GESTION_HORA." as hora 
        ON hora.id_empleado = jornada.id_empleado AND hora.fecha_desde = jornada.fecha
        
      WHERE jornada.id_empleado = ".$_GET["registrar-pagos"]."
      AND jornada.fecha BETWEEN '".$_POST["pago_fechaInicial"]."'
      AND '".$_POST["pago_fechaFinal"]."'
      ORDER BY jornada.fecha DESC

    ");

?>

<div class="container-fluid mt-5">

<div class="row">

<div class="col-md-12">

<table class="table box-new-user" id="tabla-empleados">
    
  <thead>

    <tr>

      <th scope="col">#</th>

      <th scope="col">Names</th>

      <th scope="col">Dates</th>

      <th scope="col">Commision</th>

      <th scope="col">Bonus Christmas</th>

      <th scope="col">Total Work Day</th>

    </tr>

  </thead>

  <tbody>

  <?php 
    $i = 1;
    $total_comision = 0;
    $total_bonoNavidad = 0;
    $hora_suma = 0;
    $total_general = 0;
    $boton = "";

    foreach($obtener_listado_pago as $value ){

      $obtener_pago_registrado = $wpdb->get_row("
            SELECT pagor.id_jornada 
            FROM ".TABLA_PAGO_REGISTRADO." as pagor 
            WHERE pagor.id_jornada = ".$value->id_jornada_diaria."
      ");
      
      if($obtener_pago_registrado){
        $boton = "disabled";
      ?>

        <tr>

          <td scope="row" colspan="7">
            <div class="alert alert-danger text-center" role="alert">

              There is no pending day to pay on the date <?php echo $_POST["pago_fechaInicial"]; ?> To <?php echo $_POST["pago_fechaFinal"]; ?>

            </div>
          </td>

        </tr>

        <?php break; ?>

      <?php

      }else{
       
      if(!empty($value->comision)){
        $total_comision += $value->comision;
      }  

      if(!empty($value->bono)){
        $total_bonoNavidad += $value->bono;
      }
      
      if(!empty($value->jornadaTotal)){
        // $hora_suma += ( ($value->hora_suma - $value->hora_resta )* $value->salario_jornada );
        $total_general += $value->jornadaTotal;
      }
      
       
      
      
  ?>
    <tr>

      <td scope="row"><?php echo $i++; ?></td>

      <td><?php echo $value->nombres." ".$value->apellidos;  ?></td>

      <td><?php echo $value->fechaJornada ?></td>

      <td>$<?php echo $value->comision; ?></td>

      <td>$<?php echo $value->bono; ?></td>

      <td>$<?php echo bcdiv($value->jornadaTotal, 1, 2); ?></td>

    </tr>
    
  <?php 
      }//fin if
    }// fin foreach
  ?>    
    

  </tbody>
  
  <tfoot>
    <tr>
      <td></td>
      <td></td>
      <td><?php echo "Totales:"; ?></td>
      <td>$<?php echo $total_comision ?></td>
      <td>$<?php echo $total_bonoNavidad ?></td>
      <!-- <td>$<?php //echo $hora_suma ?></td> -->
      <td>$<?php echo $total_general ?></td>
    </tr>
  </tfoot>

  </table>

</table>

</div>

</div>

<div class="row mt-4 d-flex justify-content-around">

<div class="col-md-3">

    <div class="form-group">

        <button class="btn btn-info btn-block" name="ver_pago" data-toggle="modal" data-target="#informacionPago"><i class="fa fa-file"></i> See Pay</button>

    </div>

  </div>

  <div class="col-md-3">

    <div class="form-group">

      <form action="" class="" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="pagos" vale="1">
        <input type="hidden" name="registrar_pagos">
        <input type="hidden" name="pago_idEmpleado" value="<?php echo $_GET["registrar-pagos"] ?>">
        <input type="hidden" name="pago_fechaInicialR" value="<?php echo $_POST["pago_fechaInicial"] ?>">
        <input type="hidden" name="pago_fechaFinalR" value="<?php echo $_POST["pago_fechaFinal"] ?>">
        <button class="btn btn-success btn-block" name="registrar_pagos" <?php echo $boton; ?>><i class="fa fa-save"></i> Register</button>

      </form>  

    </div>

  </div>

  </div>

</div>

</div>

<?php 
  }
?>


<div class="modal fade" id="informacionPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <img class="img-fluid" src="<?php echo get_template_directory_uri() ?>/img/logo_fuentes.png">
        
      </div>
      <div class="modal-body px-4">
        <h5 class="text-center" >Information Pay</h5>
        <h6>Employed: <strong><?php echo $value->nombres." ".$value->apellidos;  ?></strong></h6>

        <h6>Date Pay: <?php echo date("Y-m-d") ?> </h6>
        <h6>Receipt: <?php echo number_pad( ($obtener_recibo_pago->recibo +1), 8 ); ?> </h6>

        <div class="table-responsive">
        <table class="table table-borderless table-hover">
          <thead>
            <tr>
              <td> <strong>Income</strong> </td>
              <td> <strong>Total</strong> </td>
            </tr>
          </thead>
          <tbody>

            <tr>
              <td>Commision</td>
              <td>$<?php echo $total_comision ;?></td>
            </tr>

            <tr>
              <td>Bonus Christmas</td>
              <td>$<?php echo $total_bonoNavidad ;?></td>
            </tr>

            <tr>
              <td>Total work day</td>
              <td>$<?php echo bcdiv($total_general, 1, 2); ?></td>
            </tr>

            <tr>
              <td>Retention</td>
              <td>- $<?php echo bcdiv($obtener_retencion->retenciones, 1, 2) ?></td>
            </tr>

            <tr>
              <td> <strong> Total General </strong></td>
              <?php
                  $total_general_suma = ($total_comision + $total_bonoNavidad + $total_general) - $obtener_retencion->retenciones;
              ?>
              <td> <strong> $<?php echo bcdiv($total_general_suma, 1, 2)  ;?> </strong></td>
            </tr>

          </tbody>

        </table>
        </div>

        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<?php 



?>