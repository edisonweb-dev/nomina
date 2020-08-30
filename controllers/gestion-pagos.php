<?php 

if ( ! defined( 'ABSPATH' ) ) exit; 

global $wpdb;

global $guardado_empleado;


if(isset($_POST['registrar_pagos'])){


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
          WHERE extra.id_empleado = ".$_POST["pago_idEmpleado"]."
      ");

  $obtener_listado_pago = $wpdb->get_results("
    SELECT *, 
      jornada.total_sin_retencion as jornadaTotal

    FROM ".TABLA_JORNADA_DIARIA." as jornada
    LEFT JOIN ".TABLA_EMPLEADOS." as empleado 
      ON empleado.id_empleado = jornada.id_empleado
    LEFT JOIN ".TABLA_GESTION_HORA." as hora 
      ON hora.id_empleado = jornada.id_empleado AND hora.fecha_desde = jornada.fecha
    WHERE jornada.id_empleado  = ".$_POST["pago_idEmpleado"]."
    AND jornada.fecha BETWEEN '".$_POST["pago_fechaInicialR"]."'
    AND '".$_POST["pago_fechaFinalR"]."'
  ");

  $i = 1;
  $total_comision = 0;
  $total_bonoNavidad = 0;
  $hora_suma = 0;
  $total_jornada = 0;
  // $id_jornada_registrado = array();


  foreach($obtener_listado_pago as $value ){

    if(!empty($value->comision)) {
      $total_comision += $value->comision;
    } 

    if(!empty($value->bono)){
      $total_bonoNavidad += $value->bono;
    }
    
    if(!empty($value->jornadaTotal)){

      // $hora_suma += ( ($value->hora_suma - $value->hora_resta )* $value->salario_jornada );
      $total_jornada += $value->jornadaTotal;

    }
    
    


    // array_push( $id_jornada_registrado, $obtener_listado_pago->id_jornada_diaria );
  }

  $total_general = ($total_comision + $total_bonoNavidad + $total_jornada) - $obtener_retencion->retenciones;

  $numero_recibo = number_pad( ($obtener_recibo_pago->recibo +1), 8 );

	$data = [
			"id_gestion_pago"   => 0,
      "id_empleado"       => $_POST["pago_idEmpleado"],
      "fecha"             => date("Y"),
      "recibo"            => $numero_recibo,
      "comision"          =>$total_comision,
      "bonoNavidad"       =>$total_bonoNavidad,
      "horaExtra"         =>0,
      "totalJornada"      =>$total_jornada,
      "totalGeneral"      =>$total_general,
			"estatus" 		      =>0
	];

	$guardar = $wpdb->insert(
      TABLA_PAGO, 
      $data
  );

  $id_gestion_pago = $wpdb->insert_id;  

  foreach($obtener_listado_pago as $value ){

    $data2 = [
      "id_gestion_pago_registrado"  => 0,
      "id_gestion_pago"             => $id_gestion_pago,
      "id_empleado"                 => $_POST["pago_idEmpleado"],
      "id_jornada"                  => $value->id_jornada_diaria,
      "fecha"                       => date("Y-m-d"),
      "recibo"                      => $numero_recibo,
      "estatus"                     => 1
    ];
    
    $guardar_registro = $wpdb->insert(
      TABLA_PAGO_REGISTRADO, 
      $data2
    );
    
  }


  $guardado_empleado = 0;

  if($guardar){
    
    $guardado_empleado = 1;
    enviarEmail($data);

  }else{

	  $guardado_empleado = 2;

  }

}else if(isset($_POST['editar_pagos'])){
  
  $data = [
    "id_empleado"   => $_POST["pagos_nombres"],
    "fecha"         => $_POST["pago_fecha"],
    "recibo"        => $_POST["pago_recibo"],
    "monto"         => $_POST["pagos_total"],
    "estatus" 		  => 0
  ];


  $guardar = $wpdb->update(
          TABLA_PAGO, 
          $data,
          array( 'id_gestion_pago' => $_POST["id_pagos"] )
      );

  $guardado_empleado = 0;

  if($guardar){

    $guardado_empleado = 1;
    enviarEmail($data);

  }else{

    $guardado_empleado = 2;

  }

}else if(isset($_POST['eliminar_pagos'])){

  $guardar = $wpdb->delete( TABLA_PAGO, 
      array( 'id_gestion_pago' => $_POST['id_pagos']) );

  $guardado_empleado = 0;

  if($guardar){

    $guardado_empleado = 1;

  }else{

    $guardado_empleado = 2;

  }

}




function enviarEmail($data){

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

  $empleado = $wpdb->get_row("
      SELECT * 
      FROM ".TABLA_EMPLEADOS." as empleado 
      WHERE empleado.id_empleado = ".$data["id_empleado"]."
  ");

  $phpmailer->setFrom("zudzero9000@gmail.com", 'wordpress');
  
  $email = $empleado->email;
  //  IMPORTANTES
  $phpmailer->addAddress($email);
  // $phpmailer->addAddress("alexanderr677@gmail.com");

  // Add cc or bcc
  // $phpmailer->addCC();
  // $phpmailer->addBCC();

  // Set email format to HTML
  $phpmailer->isHTML(true);

  // Email subject
  $phpmailer->Subject = 'Pay Work Weekly';

  $mailContent = '';

  $mailContent .= '<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">

    <div style="position:relative; margin:auto; width:600px; background:white; padding:20px;">

    <center>					
			<img style="" src="'.get_template_directory_uri().'/img/logo_fuentes.png">
		</center>
  
     <h3 style="font-weight:100; color:#999; text-align: center;">Pay Work Weekly</h3>
  
     <hr style="border:1px solid #ccc; width:80%">
  
     <div style="padding: 0 40px;">
  
     <h4 style="font-weight:100; color:#999; padding:0 20px">Payment has been made to <strong>'.$empleado->nombres.' '.$empleado->apellidos.'</strong></h4>

     <h4 style="font-weight:100; color:#999; padding:0 20px">Date Pay: $'.$data["fecha"].' </h4>

     <h4 style="font-weight:100; color:#999; padding:0 20px">Receipt: $'.$data["recibo"].' </h4>
     <br>

     <h4 style="font-weight:100; color:#999; padding:0 20px">Commision: $'.$data["comision"].'</h4>

     <h4 style="font-weight:100; color:#999; padding:0 20px">Bonus Christmas: $'.$data["bonoNavidad"].'</h4>

     

     <h4 style="font-weight:100; color:#999; padding:0 20px">Total work: $'.$data["totalJornada"].'</h4>

     <h4 style="font-weight:100; color:#999; padding:0 20px">Total general: $'.$data["totalGeneral"].'</h4>

     <br>
    </div>
  
     <hr style="border:1px solid #ccc; width:80%">
     <center>		
      <h5 style="font-weight:100; color:#999">If you did not sign up for this account, you can ignore this email and the account will be deleted.</h5>
     </center>
    </div>
  
   ';

  $phpmailer->Body = $mailContent;

  if(!$phpmailer->send()){
      //echo 'Message could not be sent.';
      //echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
  }else{
      //echo 'Message has been sent';
  }


}//Fin enviarEmail





function number_pad($number,$n) {
  return str_pad((int) $number,$n,"0",STR_PAD_LEFT);
}


?> 