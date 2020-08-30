<?php 
  
  global $wpdb;
  global $phpmailer;
  global $pdf;

  //***************  Configuracion de correo *****************/
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

  // Add cc or bcc
  // $phpmailer->addCC();
  // $phpmailer->addBCC();

  // Set email format to HTML
  $phpmailer->isHTML(true);

  // Email subject
  $phpmailer->Subject = 'Jornada Diaria';

  //***************  Fin configuracion de correo *****************/


  
  //***************  Busqueda de empleados *****************/
  $tablaEmpleado = $wpdb->get_results(" SELECT * FROM ".TABLA_EMPLEADOS." ");
  $correo = "";
  $data = [];
  $empleado = "";
  $la_fecha_fin = "";

  $diasReporte = array(
    "Sunday"    => "Sunday",
    "Monday"    => "Monday",
    "Tuesday"   => "Tuesday",
    "Wednesday" => "Wednesday",
    "Thursday"  => "Thursday",
    "Friday"    => "Friday",
    "Saturday"  => "Saturday"
  );
  

foreach ($tablaEmpleado as $value) {
      

      $correo = $value->email;
      $phpmailer->addAddress($correo);

      $mailContent = '';  
      

      /** obtenemos el empleado **/
      $empleado = $wpdb->get_row("
          SELECT * 
          FROM ".TABLA_EMPLEADOS." as empleado 
          WHERE empleado.id_empleado = ".$value->id_empleado."
      ");

      $cuenta_bancaria = substr($empleado->nro_cuenta,-4);
      /** Fin obtenemos el empleado **/


      
      /******* Obtenemos fecha *********/  
      $la_fecha_fin = date("Y-m-d");

      $dt = new DateTime($la_fecha_fin);
      $dt->modify("-6 day");

      $la_fecha_inicio = $dt->format('Y-m-d');
      /***** Fin obtenemos la fecha  *****/

      $pay1 = new DateTime($la_fecha_inicio);
      $pay2 = new DateTime($la_fecha_fin);
      

      /** obtenemos el contador total de horas **/
      $busqueda = $wpdb->get_results("
          SELECT * 
          FROM ".TABLA_JORNADA_DIARIA." as jornada_diaria
          LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = jornada_diaria.id_empleado
          WHERE empleado.id_empleado = ".$value->id_empleado."  
      ");
      

      $horaContar   = 0;
      $totalGeneral = 0;
      $retencion    = 0;

      foreach ($busqueda as $totalContado ){
        $horaContar   += $totalContado->horas;
        $totalGeneral += $totalContado->total;
        $retencion    += $totalContado->retencion;
      }
      /** Fin obtenemos el contador total de horas  **/


      $mailContent .= '';

      //***************  Busqueda del registro jornada *****************/
      $obtener = $wpdb->get_results("
        SELECT *
        FROM ".TABLA_JORNADA_DIARIA." as jornada_diaria
        LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = jornada_diaria.id_empleado
        WHERE jornada_diaria.fecha BETWEEN '".$la_fecha_inicio."' AND '".$la_fecha_fin."'
        AND empleado.id_empleado = ".$value->id_empleado."
        ORDER BY jornada_diaria.fecha ASC
      ");

      // $obtener = $wpdb->get_results("
      //   SELECT *
      //   FROM ".TABLA_JORNADA_DIARIA." as jornada_diaria
      //   LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = jornada_diaria.id_empleado
      //   WHERE jornada_diaria.fecha BETWEEN '2019-10-02' AND '2019-10-10'
      //   AND empleado.id_empleado = ".$value->id_empleado."
      //   ORDER BY jornada_diaria.fecha ASC
      // ");
      //***************  Fin Busqueda del registro jornada *****************/

    $i = 0;
    $fecha_sql = [];
    $sql_dameDia = [];
    $descanso_entrada_sql = [];
    $descanso_salida_sql = [];

    $descanso_entrada_second_sql = [];
    $descanso_salida_second_sql = [];

    $hora_entrada_sql = [];
    $hora_salida_sql = [];

    $horas_sql = [];
    $salario_jornada_sql = [];

    $total_diario_sql = [];

    $totalContar = 0;
    $horaJornada = 0;

    if($obtener){

      foreach ($obtener as $result):

        array_push($total_diario_sql, $result->total);
        
        array_push($fecha_sql, $result->fecha);
        array_push($sql_dameDia, dame_el_dia($result->fecha));

        array_push($descanso_entrada_sql, am_pm($result->hora_descanso_entrada));
        array_push($descanso_salida_sql, am_pm($result->hora_descanso_salida));

        array_push($descanso_entrada_second_sql, am_pm($result->hora_descanso_entrada_second));
        array_push($descanso_salida_second_sql, am_pm($result->hora_descanso_salida_second));

        array_push($hora_entrada_sql, am_pm($result->hora_entrada));
        array_push($hora_salida_sql, am_pm($result->hora_salida));

        array_push($horas_sql, $result->horas);
        array_push($salario_jornada_sql, $result->salario_jornada);


        $totalContar += $result->total;
        $horaJornada += $result->horas;

        $i++;
      endforeach;   
      
      
      $contador_i = $i - 1;

      //saturday
      $dias_busqueda = dame_el_dia($fecha_sql[ $contador_i ]);
      $cantidad_dia = dia_numero($dias_busqueda);

      

      $nuevafechaSuma = strtotime ( '-'.$cantidad_dia.' day' , strtotime ( $fecha_sql[ $contador_i ] ) );
      $nuevafechaSuma = date ( 'Y-m-j' , $nuevafechaSuma );

      //*********** Calculos ******************/

      $PRstate = ($totalContar * 10) / 100;
      $DDAmount = $totalContar - $PRstate;

    }else{

    }

    $o = 0;
    $z = 0;

    $dia_nombre = dame_el_dia($la_fecha_fin);
    $dia_cantidad = dia_numero($dia_nombre) + 1;
    

    $dia_reporte = new DateTime($la_fecha_fin);
    $dia_reporte->modify("-".$dia_cantidad." day");


    foreach ($diasReporte as $key => $value):
      

      $dia_reporte->modify("+1 day");
      $dia_numero = $dia_reporte->format("d");
      //valua si el dia existe arreglo
      $resultSearch = in_array($value, $sql_dameDia);

      $fecha_dia_jornada = strtotime ( '+'.$o.' day' , strtotime ( $nuevafechaSuma ) );
      $fecha_dia_jornada = date ( 'Y-m-j' , $fecha_dia_jornada );
      $dia_fecha = explode("-", $fecha_dia_jornada);

      $o++;

    endforeach;     
      
  /*=======================================================
  =            FIN reporte jornada diaria            =
  =======================================================*/
    
  /*=======================================================
    =            INICIO REPORTE PDF            =
  =======================================================*/   
  $pdf = new PDF_HTML('L','mm','A4');
  $title_line_height = 10;
  $content_line_height = 8;

  $pdf->AddPage();
  $pdf->SetFont( 'Arial', '', 11 );

  $pdf->Line(290, 50, 10, 50);
  $pdf->Line(290, 54, 10, 54);

  $pdf->Line(290, 82, 10, 82);
  $pdf->Line(290, 86, 10, 86);
  $pdf->Line(290, 90, 10, 90);

  $pdf->Line(110, 96, 10, 96);
  $pdf->Line(110, 120, 10, 120);
  $pdf->Line(110, 126, 10, 126);

  $pdf->Line(110, 136, 10, 136);
  $pdf->Line(110, 140, 10, 140);
  $pdf->Line(110, 144, 10, 144);

  $pdf->Cell(50,4,'',0,1,'C');
  $pdf->Cell(50,4,utf8_decode('Personal Earning Statement'),0,1,'C');
  $pdf->Image(get_template_directory_uri().'/img/logo_iso.png',65,14,-300);

  $pdf->Cell(46,4,utf8_decode('Dirección de mi compañia'),0,0,'C');
  $pdf->Cell(50,4,utf8_decode(''),0,0,'C');
  $pdf->Cell(70,4,'',0,0,'C');
  $pdf->Cell(25,4,utf8_decode('Emp#'),0,0,'C');
  $pdf->Cell(25,4,utf8_decode('EmpCode'),0,0,'C');
  $pdf->Cell(30,4,utf8_decode('SSN'),0,0,'C');
  $pdf->Cell(20,4,utf8_decode('Dept'),0,1,'C');

  $pdf->Cell(49,4,utf8_decode('Dirección de mi compañia 2'),0,0,'C');
  $pdf->Cell(40,4,utf8_decode(''),0,0,'C');
  $pdf->Cell(76,4,'',0,0,'C');
  $pdf->Cell(25,4,utf8_decode($empleado->id_empleado),0,0,'C');
  $pdf->Cell(25,4,utf8_decode($empleado->nro_empleado),0,0,'C');
  $pdf->Cell(30,4,utf8_decode('1'),0,0,'C');
  $pdf->Cell(20,4,utf8_decode('1'),0,1,'C');

  $pdf->Cell(45,4,utf8_decode('Teléfono de mi compañia'),0,0,'C');
  $pdf->Cell(50,4,'',0,1,'C');

  $emp_nombre = $empleado->nombres.' '.$empleado->apellidos;

  $pdf->Cell(130,4,'',0,0,'C');
  $pdf->Cell(40,4,'Nombre del Empleado:',0,0,'C');
  $pdf->Cell(10,4,'',0,0,'C');
  $pdf->Cell(60,4,utf8_decode($emp_nombre),0,1,'C');

  $emp_pay_period = $pay1->format('Y M d').' to '.$pay2->format('Y M d');
  $emp_direccion = $empleado->direccion;

  $numero_cuenta = $empleado->nro_cuenta;

  $pdf->Cell(24,4,utf8_decode('Pay Period:'),0,0,'C');
  $pdf->Cell(50,4,utf8_decode($emp_pay_period),0,0,'C');
  $pdf->Cell(62,4,'',0,0,'C');
  $pdf->Cell(30,4,utf8_decode('Dirección del empleado:'),0,0,'C');
  $pdf->Cell(10,4,'',0,0,'C');
  $pdf->Cell(70,4,utf8_decode($emp_direccion),0,1,'C');

  $emp_pay_date = Date("F d, Y");

  $pdf->Cell(21,4,utf8_decode('Pay Date:'),0,0,'C');
  $pdf->Cell(40,4,utf8_decode($emp_pay_date),0,0,'C');

  $pdf->Cell(30,4,'',0,0,'C');
  $pdf->Cell(21,4,utf8_decode('Voucher No.'),0,0,'C');
  $pdf->Cell(25,4,'',0,0,'C');
  $pdf->Cell(25,4,'',0,0,'C');

  $pdf->Cell(30,4,'',0,0,'C');
  $pdf->Cell(30,4,utf8_decode('Dirección del empleado 2:'),0,0,'C');
  $pdf->Cell(50,4,'',0,1,'C');

  $pdf->Cell(30,4,'',0,1,'C');
  
  $pdf->Cell(20,4,'',0,0,'C');
  $pdf->Cell(20,4,'',0,0,'C');
  $pdf->Cell(20,4,'',0,0,'C');

  $pdf->Cell(40,4,'Pos or Neg Time',1,0,'C');
  $pdf->Cell(40,4,'First Break',1,0,'C');
  $pdf->Cell(40,4,'Seconds Break',1,0,'C');
  $pdf->Cell(40,4,'Work Time',1,0,'C');

  $pdf->Cell(20,4,'',0,0,'C');
  $pdf->Cell(20,4,'',0,0,'C');
  $pdf->Cell(20,4,'',0,1,'C');

  $pdf->Cell(20,4,'Earnings',0,0,'C');
  $pdf->Cell(20,4,'Days',0,0,'C');
  $pdf->Cell(20,4,'Date',0,0,'C');
  $pdf->Cell(20,4,'Post Time',0,0,'C');
  $pdf->Cell(20,4,'Neg Time',0,0,'C');

  $pdf->Cell(20,4,'In',0,0,'C');
  $pdf->Cell(20,4,'Out',0,0,'C');

  $pdf->Cell(20,4,'In',0,0,'C');
  $pdf->Cell(20,4,'Out',0,0,'C');

  $pdf->Cell(20,4,'In',0,0,'C');
  $pdf->Cell(20,4,'Out',0,0,'C');

  $pdf->Cell(20,4,'Hours',0,0,'C');
  $pdf->Cell(20,4,'Rate',0,0,'C');
  $pdf->Cell(20,4,'Amount',0,1,'C');

  $z = 0;
  $o = 0;

  $dia_nombre_correo = dame_el_dia($la_fecha_fin);
  $dia_cantidad_correo = dia_numero($dia_nombre) + 1;
  

  $dia_reporte_correo = new DateTime($la_fecha_fin);
  $dia_reporte_correo->modify("-".$dia_cantidad_correo." day");

  $dia_correcto_correo = "";

  foreach ($diasReporte as $key => $value):

    $dia_reporte_correo->modify("+1 day");
    $dia_correcto_correo = $dia_reporte_correo->format("d");

    $fecha_dia_jornada = strtotime ( '+'.$o.' day' , strtotime ( $nuevafechaSuma ) );
    $fecha_dia_jornada = date ( 'Y-m-j' , $fecha_dia_jornada );
    $dia_fecha = explode("-", $fecha_dia_jornada);

    $emp_salario_jornada = "$".number_format($salario_jornada_sql[$z],2);
    $emp_total_diario = "$".number_format($total_diario_sql[$z], 2);

    // datos 
    $pdf->Cell(20,4,'Hourly',0,0,'C');
    $pdf->Cell(20,4,$value,0,0,'C');
    $pdf->Cell(20,4,$dia_correcto_correo,0,0,'C');
    $pdf->Cell(20,4,'',0,0,'C');
    $pdf->Cell(20,4,'',0,0,'C');

    $pdf->Cell(20,4,$descanso_entrada_sql[$z],0,0,'C');
    $pdf->Cell(20,4,$descanso_salida_sql[$z],0,0,'C');

    $pdf->Cell(20,4,$descanso_entrada_second_sql[$z],0,0,'C');
    $pdf->Cell(20,4,$descanso_salida_second_sql[$z],0,0,'C');

    $pdf->Cell(20,4,$hora_entrada_sql[$z],0,0,'C');
    $pdf->Cell(20,4,$hora_salida_sql[$z],0,0,'C');

    $pdf->Cell(20,4,$horas_sql[$z],0,0,'C');
    $pdf->Cell(20,4,$emp_salario_jornada,0,0,'C');
    $pdf->Cell(20,4,$emp_total_diario,0,1,'C');

    $o++;
    $z++;

  endforeach;	   

  $pdf->Cell(210,4,'',0,0,'C');
    $pdf->Cell(48,4,'Total Current Amount:',0,0,'C');
    $pdf->Cell(20,4,'$'.$totalContar,0,1,'C');


    $pdf->Cell(20,4,'Total Hours',0,0,'C');
    $pdf->Cell(20,4,$horaJornada,0,0,'C');
    $pdf->Cell(20,4,'T AMT',0,0,'C');
    $pdf->Cell(40,4,$totalContar,0,0,'C');

    $pdf->Cell(40,4,'Total YTD Hours',0,0,'C');
    $pdf->Cell(20,4,$horaContar,0,0,'C');
    
    $pdf->Cell(47,4,'',0,0,'C');

    $pdf->Cell(50,4,'Total YTD Amount:',0,0,'C');
    $pdf->Cell(20,4,'$'.$totalGeneral,0,1,'C');


    $pdf->Cell(20,6,'Taxes',0,0,'C');
    $pdf->Cell(20,6,'Exemptions',0,0,'C');
    $pdf->Cell(20,6,'Addtl',0,0,'C');
    $pdf->Cell(20,6,'Amount',0,0,'C');
    $pdf->Cell(20,6,'YTD',0,1,'C');

    $pdf->Cell(20,6,'Social Sec',0,0,'C');
    $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Cell(20,6,'',0,1,'C');

    $pdf->Cell(20,6,'Medicare',0,0,'C');
    $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Cell(20,6,'',0,1,'C');

    $pdf->Cell(20,6,'Federal',0,0,'C');
    $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Cell(20,6,'',0,1,'C');

    $pdf->Cell(20,6,'PR State',0,0,'C');
    $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Cell(20,6,'$'.round($PRstate,2),0,0,'C');
    $pdf->Cell(20,6,'$'.round($retencion,2),0,1,'C');


    $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Cell(20,6,'Total Taxes',0,0,'C');
    $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Cell(20,6,'$'.round($PRstate,2),0,0,'C');
    $pdf->Cell(20,6,'$'.round($retencion,2),0,1,'C');


    $pdf->Cell(30,6,'Direct Deposists',0,0,'C');
    $pdf->Cell(20,6,'ABA No.',0,0,'C');
    $pdf->Cell(20,6,'Acc No.',0,0,'C');
    $pdf->Cell(10,6,'',0,0,'C');
    $pdf->Cell(20,6,'Amount',0,1,'C');


    $pdf->Cell(30,4,'',0,0,'C');
    $pdf->Cell(20,4,$empleado->nro_ruta,0,0,'C');
    $pdf->Cell(20,4,$cuenta_bancaria,0,0,'C');
    $pdf->Cell(10,4,'',0,0,'C');
    $pdf->Cell(20,4,'$'.round($DDAmount,2),0,1,'C');

    $pdf->Cell(20,4,'',0,0,'C');
    $pdf->Cell(40,4,'Total Direct Deposit',0,0,'C');
    $pdf->Cell(20,4,'',0,0,'C');
    $pdf->Cell(20,4,'$'.round($DDAmount,2),0,1,'C');


    $pdf->Cell(20,4,'Net Pay',0,0,'C');
    $pdf->Cell(20,4,'',0,0,'C');
    $pdf->Cell(20,4,'',0,0,'C');
    $pdf->Cell(20,4,'',0,0,'C');
    $pdf->Cell(20,4,'$'.round($DDAmount,2),0,1,'C');

    
  /*=======================================================
    =            FIN REPORTE PDF            =
  =======================================================*/       
    $doc = $pdf->Output('S','jornada.pdf');
    $phpmailer->AddStringAttachment($doc,"jornada.pdf","base64","application/pdf"); 
    

    $mailContent .= '<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">

    <div style="position:relative; margin:auto; width:600px; background:white; padding:20px;">

    <center>					
			<img style="" src="'.get_template_directory_uri().'/img/logo_fuentes.png">
		</center>
  
     <h3 style="font-weight:100; color:#999; text-align: center;">Pago de la jornada Semanal</h3>
  
     <hr style="border:1px solid #ccc; width:80%">
  
     <div style="padding: 0 40px;">
  
     <h4 style="font-weight:100; color:#999; padding:0 20px">Nombre: '.$emp_nombre.'</h4>

     <h4 style="font-weight:100; color:#999; padding:0 20px">Dirección: '.$emp_direccion.'</h4>
  
     <h4 style="font-weight:100; color:#999; padding:0 20px">Numero Cuenta: '.$numero_cuenta.'</h4>
  
     <h4 style="font-weight:100; color:#999; padding:0 20px">Pay Period: '.$emp_pay_period.'</h4>
  
     <h4 style="font-weight:100; color:#999; padding:0 20px">Pay Date: '.$emp_pay_date.'</h4>
  
     <h4 style="font-weight:100; color:#999; padding:0 20px">Monto total: '.$totalContar.'</h4>
  
     <h4 style="font-weight:100; color:#999; padding:0 20px">Monto retenido: '.$retencion.'</h4>
  
     <h4 style="font-weight:100; color:#999; padding:0 20px">Horas totales: '.$totalContar.'</h4>
  
     <br>
    </div>
  
     <hr style="border:1px solid #ccc; width:80%">
  
     <h5 style="font-weight:100; color:#999">Si no se inscribió en esta cuenta, puede ignorar este correo electrónico y la cuenta se eliminará.</h5>
  
    </div>
  
   ';

    $phpmailer->Body = $mailContent;

    $phpmailer->send();

    $phpmailer->ClearAllRecipients();
    $phpmailer->clearAttachments();
    

    $doc = '';
    $pdf = '';
    
}

  // if(!$phpmailer->send()){
  //   echo 'Message could not be sent.';
  //   echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
  // }else{
  //     echo 'Message has been sent';
  // }



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