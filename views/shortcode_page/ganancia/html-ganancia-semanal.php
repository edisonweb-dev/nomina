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

   <h5>Ganancia Semanal</h5>

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

        <div class="col-md-4">
          
            <div class="form-group">

            <label for="">Empleado</label>

            <select name="ingreso_id_empleado" class="form-control" readonly>
              <option value="<?php echo $value->id_empleado ?>"><?php echo $value->nombres.' '.$value->apellidos ?></option>
            </select>

            </div>

        </div>


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

        <div class="col-md-4">
          
            <div class="form-group">

            <label for="">Empleado</label>

            <select name="ingreso_id_empleado" class="form-control" readonly>
              <option value="<?php echo $value->id_empleado ?>"><?php echo $value->nombres.' '.$value->apellidos ?></option>
            </select>

            </div>

        </div>


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

              <button class="btn btn-primary btn-block" name="pdf_reporte_semanal_ganancia" formtarget="_blank"><i class="fa fa-file mr-2"></i>Generar PDF</button>

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

      // enviarEmail();


        $consulta = $wpdb->get_results("
          SELECT *
          FROM ".TABLA_JORNADA_DIARIA." as diario
          LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = diario.id_empleado
          LEFT JOIN ".TABLA_ESTADO." as estado ON estado.id_estado = diario.estatus
          WHERE diario.fecha BETWEEN '".$_POST["ingreso_fecha_inicial"]."' AND '".$_POST["ingreso_fecha_final"]."'
          AND diario.id_empleado = ".$_POST["ingreso_id_empleado"]."
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


function enviarEmail(){

  global $wpdb;
  global $phpmailer;

  // (Re)create it, if it's gone missing
  if ( ! ( $phpmailer instanceof PHPMailer ) ) {
      require_once ABSPATH . WPINC . '/class-phpmailer.php';
      require_once ABSPATH . WPINC . '/class-smtp.php';
  }

  $phpmailer = new PHPMailer;

    // SMTP configuration
  $phpmailer->isMail();
  $phpmailer->Host = 'smtp.gmail.com';
  $phpmailer->SMTPAuth = true;
  $phpmailer->Username = "zudzero9000@gmail.com";
  $phpmailer->Password = 'logica2010';
  $phpmailer->SMTPSecure = 'tls';
  $phpmailer->Port = 587;

  $phpmailer->setFrom("zudzero9000@gmail.com", 'wordpress');
  
  //  IMPORTANTES
  $phpmailer->addAddress("ingedisonperdomo@gmail.com");
  // $phpmailer->addAddress("alexanderr677@gmail.com");

  // Add cc or bcc
  // $phpmailer->addCC();
  // $phpmailer->addBCC();

  // Set email format to HTML
  $phpmailer->isHTML(true);

  // Email subject
  $phpmailer->Subject = 'Jornada Diaria';


/*=======================================================
=            Comienza reporte jornada diaria            =
=======================================================*/
  $empleado = $wpdb->get_row("
      SELECT * 
      FROM ".TABLA_EMPLEADOS." as empleado 
      WHERE empleado.id_empleado = 1
  ");

  $dt = new DateTime("2019-09-10");
  $dt2 = new DateTime("2019-09-17");

  $cuenta_bancaria = substr($empleado->nro_cuenta,-4);

  $diaName = [];
  $dia = [];
  
  $fechaInicio=strtotime($dt->format('d-m-Y'));
  $fechaFin=strtotime($dt2->format('d-m-Y'));
  for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
      array_push($diaName,date("d-m-Y", $i));
      array_push($dia,date("d", $i));
  }


  $busqueda = $wpdb->get_results("
      SELECT * 
      FROM ".TABLA_JORNADA_DIARIA." as jornada_diaria
      LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = jornada_diaria.id_empleado
      WHERE empleado.id_empleado = 1  
  ");
  

  $horaContar = 0;
  $totalGeneral = 0;
  $retencion = 0;

  foreach ($busqueda as $key => $value){
    $horaContar += $value->horas;
    $totalGeneral += $value->total;
    $retencion += $value->retencion;
  }


  $mailContent = '';


  $mailContent .= '<table class="presupuesto" style="max-width:600;padding:10px;margin:0 auto;border-collapse:collapse;width:80%;">

  <thead>
    <tr>
      <th class="border-0" colspan="14">Personal Earning Statement</th>
    </tr>
    <tr>
      <th class="border-0"  colspan="9">Dirección de mi compañia</th>
      <th class="border-0" >Emp#</th>
      <th class="border-0" >EmpCode</th>
      <th class="border-0"  colspan="2">SSN</th>
      <th class="border-0" >Dept</th>
    </tr>
    <tr>
      <th class="border-0"  colspan="9">Dirección de mi compañia 2</th>
      <th class="border-0" >'.$empleado->id_empleado.'</th>
      <th class="border-0" >'.$empleado->nro_empleado.'</th>
      <th class="border-0"  colspan="2">1</th>
      <th class="border-0" >1</th>
    </tr>
    <tr>
      <th class="border-0" colspan="13">Teléfono de mi compañia</th>
    </tr>
    <tr>
      <th class="border-0" colspan="8"></th>
      <th class="border-0" colspan="3">Nombre del Empleado</th>
      <th class="border-0" colspan="3">'.$empleado->nombres.' '.$empleado->apellidos.'</th>
    </tr>
    <tr>
      <th class="border-0" colspan="2">Pay Period:</th>
      <th class="border-0" colspan="3">'.$dt->format('Y M d').' to '.$dt2->format('Y M d').'</th>
      <th class="border-0" colspan="3"></th>
      <th class="border-0" colspan="3">Direccion Empleado</th>
      <th class="border-0" colspan="3">'.$empleado->direccion.'</th>
    </tr>
    <tr>
      <th class="border-0" colspan="2">Pay Date:</th>
      <th class="border-0" colspan="3">'.Date("F d, Y").'</th>
      <th class="border-0">Voucher No.</th>
      <th class="border-0"></th>
      <th class="border-0"></th>
      <th class="border-0" colspan="3">Direccion Empleado 2</th>
      <th class="border-0" colspan="3"></th>
    </tr>
   </thead>
  <tbody>
    <tr>
      <td class="border-0"></td>
      <td class="border-0"></td>
      <td class="border-0"></td>
      <td class="border-left border-right border-top" colspan="2">Pos or Neg Time</td>
      <td class="border-right border-top" colspan="2">First Break</td>
      <td class="border-right border-top" colspan="2">Second Break</td>
      <td class="border-right border-top" colspan="2">Work time</td>
      <td class="border-0"></td>
      <td class="border-0"></td>
      <td class="border-0"></td>
    </tr>

    <tr >
      <td class="border-bottom-3 border-top" >Earnings</td>
      <td class="border-bottom-3 border-top">Days</td>
      <td class="border-bottom-3 border-top">Date</td>
      <td class="border-bottom-3 border-top">Pos time</td>
      <td class="border-bottom-3 border-top">Neg time</td>
      <td class="border-bottom-3 border-top">In</td>
      <td class="border-bottom-3 border-top">Out</td>
      <td class="border-bottom-3 border-top">In</td>
      <td class="border-bottom-3 border-top">Out</td>
      <td class="border-bottom-3 border-top">In</td>
      <td class="border-bottom-3 border-top">Out</td>
      <td class="border-bottom-3 border-top">Hours</td>
      <td class="border-bottom-3 border-top">Rate</td>
      <td class="border-bottom-3 border-top">Amount</td>
    </tr>';

  $i=0;

  $totalContar = 0;
  $horaJornada = 0;
  $PRstate = 0;
  $descansoJornada = 0;
  $salarioDeJornada = 0;

  $sql_dameDia = [];
  $fecha_sql = [];
  $fechaN_sql = [];

  $descanso_entrada_sql = [];
  $descanso_salida_sql = [];

  $descanso_entrada_second_sql = [];
  $descanso_salida_second_sql = [];

  $horas_sql = [];
  $salario_jornada_sql = [];

  $hora_entrada_sql = [];
  $hora_salida_sql = [];
  $total_diario_sql = [];

  $obtener = $wpdb->get_results("
      SELECT *
      FROM ".TABLA_JORNADA_DIARIA." as jornada_diaria
      LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = jornada_diaria.id_empleado
      WHERE jornada_diaria.fecha BETWEEN '2019-09-10' AND '2019-09-25'
      AND empleado.id_empleado = 1
  ");

  foreach ($obtener as $key => $value):

   $i++; 
   array_push($total_diario_sql, $value->total);
   array_push($fecha_sql, $value->fecha);
   
   $fechaN = explode("-", $value->fecha);
   array_push($fechaN_sql, $fechaN);
   
   $horaJornada += $value->horas;
   $descansoJornada += decimalHours($value->descanso);
   $totalContar += $value->total;
   
   $nuevaFecha = date("Y/m/d", strtotime($diaName[$i]));
   $salarioDeJornada = $value->salario_jornada;

   array_push($sql_dameDia, dame_el_dia($value->fecha));

   array_push($descanso_entrada_sql, am_pm($value->hora_descanso_entrada));
   array_push($descanso_salida_sql, am_pm($value->hora_descanso_salida));

   array_push($descanso_entrada_second_sql, am_pm($value->hora_descanso_entrada_second));
   array_push($descanso_salida_second_sql, am_pm($value->hora_descanso_salida_second));

   array_push($hora_entrada_sql, am_pm($value->hora_entrada));
   array_push($hora_salida_sql, am_pm($value->hora_salida));

   array_push($horas_sql, $value->horas);
   array_push($salario_jornada_sql, $value->salario_jornada);
   
  endforeach; 


  $PRstate = ($totalContar * 10) / 100;
  $DDAmount = $totalContar - $PRstate;


  $diasReporte = array(
    "Sunday"    => "Sunday",
    "Monday"    => "Monday",
    "Tuesday"   => "Tuesday",
    "Wednesday" => "Wednesday",
    "Thursday"  => "Thursday",
    "Friday"    => "Friday",
    "Saturday"  => "Saturday"
  );

  $o = 0;
  $z = 0;
  
  $dias_busqueda = dame_el_dia($fecha_sql[$i-1]);
  $cantidad_dia = dia_numero($dias_busqueda);

  $nuevafechaSuma = strtotime ( '-'.$cantidad_dia.' day' , strtotime ( $fecha_sql[$i-1] ) );
  $nuevafechaSuma = date ( 'Y-m-j' , $nuevafechaSuma );

    foreach ($diasReporte as $key => $value):

      $resultSearch = in_array($value, $sql_dameDia);

      $fecha_dia_jornada = strtotime ( '+'.$o.' day' , strtotime ( $nuevafechaSuma ) );
      $fecha_dia_jornada = date ( 'Y-m-j' , $fecha_dia_jornada );
      $dia_fecha = explode("-", $fecha_dia_jornada);

      $o++;

      if ($resultSearch) {

      $mailContent .= '<tr>
        <td>Hourly  </td>
        <td>'.$value.'</td>
        <td>'.$dia_fecha[2].'</td>
        <td></td>
        <td></td>
        <td>'.$descanso_entrada_sql[$z].'</td>
        <td>'.$descanso_salida_sql[$z].'</td>
        <td>'.$descanso_entrada_second_sql[$z].'</td>
        <td>'.$descanso_salida_second_sql[$z].'</td>
        <td>'.$hora_entrada_sql[$z].'</td>
        <td>'.$hora_salida_sql[$z].'</td>

        <td>'.$horas_sql[$z].'</td>
        <td>$'.number_format($salario_jornada_sql[$z],2).'</td>
        <td>$'.number_format($total_diario_sql[$z], 2).'</td>
      </tr>';
    

    $z++;

    }else{


  $mailContent .= '<tr>
      <td>Hourly</td>
      <td>'.$value.'</td>
      <td>'.$dia_fecha[2].'</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>0.00</td>
      <td>$'.number_format($salarioDeJornada,2).'</td>
      <td>$0.00</td>
    </tr>';

  }

  endforeach; 

$mailContent .= '<tr>
  <td colspan="10"></td>
  <td colspan="3">Total Current Amount:</td>
  <td>$'.$totalContar.'</td>
 </tr>

 <tr class="bg-gray border-bold">
  <td>Total Hours</td>
  <td>'.$horaJornada.'</td>
  <td>T AMT</td>
  <td>$'.$totalContar.'</td>
  <td colspan="2">Total YTD Hours</td>
  <td colspan="4">'.$horaContar.'</td>
  <td colspan="3">Total YTD Amount:</td>
  <td>$'.$totalGeneral.'</td>
 </tr>

 <tr class="border-bottom-3 bold">
  <td>Taxes</td>
  <td>Exemptions</td>
  <td>Addtl</td>
  <td>Amount</td>
  <td>YTD</td>
  <td colspan="9"></td>
 </tr>

  
 <tr>
  <td  class="border-0">Social Sec.</td>
  <td  class="border-0"></td>
  <td  class="border-0"></td>
  <td  class="border-0"></td>
  <td  class="border-0"></td>
 </tr>

 <tr>
  <td  class="border-0">Medicare</td>
  <td  class="border-0"></td>
  <td  class="border-0"></td>
  <td  class="border-0"></td>
  <td  class="border-0"></td>
 </tr>

 <tr>
  <td  class="border-0">Federal</td>
  <td  class="border-0"></td>
  <td  class="border-0"></td>
  <td  class="border-0"></td>
  <td  class="border-0"></td>
 </tr>

 <tr>
  <td  class="border-0">PR State</td>
  <td  class="border-bottom-3 border-top-0"></td>
  <td  class="border-bottom-3 border-top-0"></td>
  <td  class="border-bottom-3 border-top-0">$'.$PRstate.'</td>
  <td  class="border-bottom-3 border-top-0">$'.$retencion.'</td>
 </tr>

 <tr>
  <td  class="border-0"></td>
  <td  class="border-bottom-3 bold">Total Taxes</td>
  <td  class="border-bottom-3 bold"></td>
  <td  class="border-bottom-3 bold">$'.$PRstate.'</td>
  <td  class="border-bottom-3 bold">$'.$retencion.'</td>
 </tr>

 <tr>
  <td  class="border-0 bold ">Direct Deposists</td>
  <td  class="border-0 bold">ABA No.</td>
  <td  class="border-0 bold">Acc No</td>
  <td  class="border-0"></td>
  <td  class="border-0 bold">Amount</td>
  <td  class="border-0" colspan="8"></td>
 </tr>

 <tr>
  <td  class="border-0"></td>
  <td  class="border-bottom-3 border-top-0">'.$empleado->nro_ruta.'</td>
  <td  class="border-bottom-3 border-top-0">'.$cuenta_bancaria.'</td>
  <td  class="border-bottom-3 border-top-0"></td>
  <td  class="border-bottom-3 border-top-0">$'.$DDAmount.'</td>
 </tr>

 <tr>
  <td  class="border-0"></td>
  <td  class="border-bottom-3 border-top-0 bold" colspan="2">Total Direct Deposit</td>
  <td  class="border-bottom-3 border-top-0 bold"></td>
  <td  class="border-bottom-3 border-top-0 bold">$'.$DDAmount.'</td>
 </tr>

 <tr>
  <td  class="border-bottom-3 border-top-3 bold">Net Pay</td>
  <td  class="border-bottom-3 border-top-3"></td>
  <td  class="border-bottom-3 border-top-3"></td>
  <td  class="border-bottom-3 border-top-3"></td>
  <td  class="border-bottom-3 border-top-3 bold">$'.$DDAmount.'</td>
 </tr>

</tbody>
</table>
</div>';



  $phpmailer->Body = $mailContent;

  if(!$phpmailer->send()){
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
  }else{
      echo 'Message has been sent';
  }


}// fin de la funcion email




function calcular_tiempo_trasnc($hora1,$hora2){
    $separar[1]=explode(':',$hora1);
    $separar[2]=explode(':',$hora2);

    $total_minutos_trasncurridos[1] = ($separar[1][0]*60)+$separar[1][1];
    $total_minutos_trasncurridos[2] = ($separar[2][0]*60)+$separar[2][1];
    $total_minutos_trasncurridos = $total_minutos_trasncurridos[1]-$total_minutos_trasncurridos[2];
    if($total_minutos_trasncurridos<=59) return($total_minutos_trasncurridos);
    elseif($total_minutos_trasncurridos>59){
    $HORA_TRANSCURRIDA = round($total_minutos_trasncurridos/60);
    if($HORA_TRANSCURRIDA<=9) $HORA_TRANSCURRIDA='0'.$HORA_TRANSCURRIDA;
    $MINUITOS_TRANSCURRIDOS = $total_minutos_trasncurridos%60;
    if($MINUITOS_TRANSCURRIDOS<=9) $MINUITOS_TRANSCURRIDOS='0'.$MINUITOS_TRANSCURRIDOS;
    return ($HORA_TRANSCURRIDA.':'.$MINUITOS_TRANSCURRIDOS);

    } 
}




function decimalHours($time)
{   
    $hms = explode(":", $time);    

    if( strlen($time) <= 2 ){
      $resultado = ($hms[0] / 100); 
    }else{
      
      $minutos = $hms[1] / 60;
      $redondear = round($minutos, 2);
      $resultado = $hms[0] + $redondear;

    }
    
    return $resultado; 
}




function dame_el_dia($fecha)
{
  $array_dias['Sunday']   = "Sunday";
  $array_dias['Monday']   = "Monday";
  $array_dias['Tuesday']  = "Tuesday";
  $array_dias['Wednesday'] = "Wednesday";
  $array_dias['Thursday'] = "Thursday";
  $array_dias['Friday']   = "Friday";
  $array_dias['Saturday'] = "Saturday";
  return $array_dias[date('l', strtotime($fecha))];
}



function am_pm($time){

  if(empty($time)){
    return '';
  }else if($time <= 11){
    return $time.' AM';
  }else{
    return $time.' PM';
  }

}

function dia_numero($dia){

  switch ($dia) {
    case 'Saturday':
      return 6;
      break;

    case 'Friday':
      return 5;
      break;  

    case 'Thursday':
      return 4;
      break;    

    case 'Wednesday':
      return 3;
      break;  

    case 'Tuesday':
      return 2;
      break;      

    case 'Monday':
      return 1;
      break;  

    
    default:
      return 0;
      break;
  }


}

 ?>