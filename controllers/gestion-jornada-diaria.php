<?php 

if ( ! defined( 'ABSPATH' ) ) exit; 

global $wpdb;
global $guardado_empleado;
global $id_empleado_mostrar;


if(isset($_POST['actualizar_jornada_diaria'])){

  $busqueda_registro = $wpdb->get_row("
    SELECT *
    FROM ".TABLA_JORNADA_DIARIA." as jornada_diaria
    WHERE jornada_diaria.id_empleado = ".$_POST["id_empleado"]." 
    AND jornada_diaria.fecha = '".$_POST["gestionJornada_fecha"]."'
    AND jornada_diaria.id_jornada_diaria != ".$_POST["id_jornada_empleado"]."
  ");

  if($busqueda_registro){

    $guardado_empleado = 0;
    $guardado_empleado = 2;

  }else{

	$data = [
      "fecha"                  => $_POST["gestionJornada_fecha"],
			"hora_entrada"           => $_POST["gestionJornada_hora_entrada"],
      "hora_salida"            => $_POST["gestionJornada_hora_salida"],
      "hora_descanso_entrada"  => $_POST["gestionJornada_hora_descanso_entrada"],
      "hora_descanso_salida"    => $_POST["gestionJornada_hora_descanso_salida"],
      "hora_descanso_entrada_second" => $_POST["gestionJornada_hora_descanso_entrada2"],
      "hora_descanso_salida_second"  => $_POST["gestionJornada_hora_descanso_salida2"],
      "horas" => 0,
      "total" => 0,
      "hora_suma"   => $_POST["gestionJornada_sumar_hora"],
      "hora_resta"  => $_POST["gestionJornada_restar_hora"],
      "comision"    => $_POST["gestionJornada_comision"],
      "bono"        => $_POST["gestionJornada_bono"],
			"estatus" => $_POST["gestionJornada_estatus"]
	];

	$guardar = $wpdb->update(
      TABLA_JORNADA_DIARIA, 
      $data,
      array( 
        'id_jornada_diaria' => $_POST["id_jornada_empleado"]
      )
  );

  /*=====================================================
    =            Calculo horas y total salario            =
  =====================================================*/
  $value = $wpdb->get_row("
      SELECT *, jornada_diaria.fecha as fechaJornada 
      FROM ".TABLA_JORNADA_DIARIA." as jornada_diaria
      LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = jornada_diaria.id_empleado
      WHERE jornada_diaria.id_jornada_diaria = ".$_POST["id_jornada_empleado"]."   
  ");


  $obtener_salario = $wpdb->get_row("
    SELECT * 
    FROM ".TABLA_SALARIO." as salario
    where salario.id_empleado = ".$value->id_empleado." 
    AND '".$_POST["gestionJornada_fecha"]."' BETWEEN salario.fecha_inicial AND salario.fecha_final
  ");

  $diaPrueba = dame_el_dia($_POST['gestionJornada_fecha']);
  $cantidadDia = dia_numero($diaPrueba);

  $dt = new DateTime($_POST['gestionJornada_fecha']);
  $dt->format("Y-m-d");
  $dt->modify("-".$cantidadDia." day");

  $comienzo_de_semana = $dt->format("Y-m-d");
  $final_de_semana = $_POST['gestionJornada_fecha'];


  $sql_cantidad_horas = $wpdb->get_row("
    SELECT SUM(diaria.horas) as totalHoras, extra.salario_hora_extra as salario_hora_extra
    FROM ".TABLA_JORNADA_DIARIA." as diaria
    LEFT JOIN ".TABLA_HORA_EXTRA." as extra ON extra.id_empleado = diaria.id_empleado
    WHERE diaria.id_empleado = ".$value->id_empleado."
    AND diaria.fecha BETWEEN '".$comienzo_de_semana."' AND  '".$final_de_semana."'
  ");

  // aqui obtengo el salario de hora extra si hora es mayor 40
  // if($sql_cantidad_horas->totalHoras > 40 && !empty($sql_cantidad_horas->salario_hora_extra)){

  //   $salario_verificado = $sql_cantidad_horas->salario_hora_extra;
  //   $salario = $value->salario;

  // }else if(!empty($obtener_salario)){

  //   $salario_verificado = $obtener_salario->salario;

  // }else{

  //   $salario_verificado = $value->salario;

  // }

  $salario_verificado = $value->salario;
  $salario = $value->salario;


  /// *********** Funcion para calcular las horas *************/  
  $horas = restar_tiempo($value->hora_entrada,$value->hora_salida);
  
  $total_sin_descanso = $salario_verificado * decimalHours($horas);
  /// *********** Fin Funcion para calcular las horas *************/
  

  /// *********** Funcion para calcular las Descanso1 *************/  
  $descanso1 = restar_tiempo($value->hora_descanso_entrada,$value->hora_descanso_salida);
  /// *********** Fin Funcion para calcular las Descanso1 *************/


  /// *********** Funcion para calcular las Descanso2 *************/  
  $descanso2 = restar_tiempo($value->hora_descanso_entrada_second,$value->hora_descanso_salida_second);
  /// *********** Fin Funcion para calcular las Descanso2 *************/  
  $total_descanso = [ $descanso1, $descanso2 ];
  $descanso_suma = sumarHoras($total_descanso);
  // $descanso_suma = calcular_tiempo_trasnc($descanso1,$descanso2);
  
  $times =  restar_tiempo($horas,$descanso_suma);

  /*=================================================
               Sumar o Restar Tiempo           
  ===================================================*/
  if(!empty($_POST["gestionJornada_restar_hora"])){
    
    
    $restar = numeroDecimalAHoras($_POST["gestionJornada_restar_hora"]);
    $times = restar_tiempo($times,$restar);
    
  }

  if(!empty($_POST["gestionJornada_sumar_hora"])){

    $suma = numeroDecimalAHoras($_POST["gestionJornada_sumar_hora"]);

    $horasDb = [$times,$suma];
    $times = sumarHoras($horasDb);

  }

  $total_horas_DB = decimalHours($times);

  /*=====================================================
    =           FIN Calculo horas y total salario            =
  =====================================================*/
  

  /*=======================================================
  =            Calculo horas extras OVERTIME           =
  =========================================================*/
  if($sql_cantidad_horas->totalHoras > 40){

    // if( strlen($sql_cantidad_horas->totalHoras) > 2 ){

    //   $cantidad_horas = decimalHours($sql_cantidad_horas->totalHoras);

    // }else{

    //   $cantidad_horas = $sql_cantidad_horas->totalHoras;

    // }

    // $total_salario = $salario_verificado * $total_horas_DB;
    // $total = $total_salario;

    $total_salario = $salario_verificado * $total_horas_DB;
    $total = $total_salario;    


  }else if( ($sql_cantidad_horas->totalHoras + $total_horas_DB) > 40 ){

    // if( strlen($sql_cantidad_horas->totalHoras) > 2 ){

    //   $cantidad_horas = decimalHours($sql_cantidad_horas->totalHoras);

    // }else{

    //   $cantidad_horas = $sql_cantidad_horas->totalHoras;

    // }

    // $calculo_hora_restante = ($sql_cantidad_horas->totalHoras + $total_horas_DB) - 40;

    // $total_salario_hora_extra = $salario_verificado * $calculo_hora_restante;
    // $total_salario_normal = $salario_verificado  * ($total_horas_DB - $calculo_hora_restante);

    // $total_salario = $total_salario_normal + $total_salario_hora_extra;
    // $total = $total_salario;

    $total_salario = $salario_verificado * $total_horas_DB;
    $total = $total_salario;

  }else{

    $total_salario = $salario_verificado * $total_horas_DB;
    $total = $total_salario;

  }    

  /*=========================================
  =            FIN Calculo horas extras            =
  =========================================*/

  /*=========================================
  =            Calculo Retencion            =
  =========================================*/
  $busqueda_retencion = $wpdb->get_row("
      SELECT SUM(jornada_diaria.total) as totalAnual
      FROM ".TABLA_JORNADA_DIARIA." as jornada_diaria
      WHERE jornada_diaria.id_empleado = ".$value->id_empleado."   
      AND jornada_diaria.fecha <= '".$value->fechaJornada."'
  ");

  $suma_total = $busqueda_retencion->totalAnual + $total;
  $suma_retencion = 0;
  $retencion_10_porciento = 0;
  $retencion_cal2 = 0;
  $retencion_cal3 = 0;

  if($busqueda_retencion->totalAnual >= 500){

    $retencion = ($total * 10) / 100;

  }else if($suma_total >= 500 ){

    $total_de_retencion = $suma_total - 500;
    $retencion = ($total_de_retencion * 10) / 100;

  }else{

    $retencion = 0;

  }

  $total_a_pagar = $total_salario - $retencion;
  /*=========================================
  =            Fin Retencion            =
  =========================================*/
  $data2 = [
      "horas" => $total_horas_DB,
      "total_sin_retencion" => $total_salario,
      "total" => $total_a_pagar,
      "retencion" => $retencion,
      "descanso" => $descanso_suma,
      "total_sin_descanso" => $total_sin_descanso,
      "salario_jornada" => $salario_verificado
    ];

  $editar = $wpdb->update(
      TABLA_JORNADA_DIARIA, 
      $data2,
      array( 
        'id_jornada_diaria' => $_POST["id_jornada_empleado"]
      )
  );


  $guardado_empleado = 0;

  if($guardar){

    $guardado_empleado = 1;

  }else{

	  $guardado_empleado = 2;

  }

  }//fin del registro duplicado



}else if(isset($_POST['registrar_jornada_diaria'])){

  /*=================================
      consulta registro jornada                               
  =================================*/
  $busqueda_registro = $wpdb->get_row("
    SELECT *
    FROM ".TABLA_JORNADA_DIARIA." as jornada_diaria
    LEFT JOIN ".TABLA_EMPLEADOS." as perfil ON perfil.id_empleado = jornada_diaria.id_empleado
    WHERE jornada_diaria.id_empleado = ".$_POST["horaExtra_nombres"]." 
    AND jornada_diaria.fecha = '".$_POST["gestionJornada_fecha"]."'
  ");

  $id_empleado_mostrar = $busqueda_registro->id_empleado;
  

  if($busqueda_registro){

    $guardado_empleado = 0;

  }else{
  

  $data = [
    "id_jornada_diaria" => 0,
    "id_empleado"   => $_POST["horaExtra_nombres"],
    "fecha"         => $_POST["gestionJornada_fecha"],
    "hora_entrada"  => $_POST["gestionJornada_hora_entrada"],
    "hora_salida"   => $_POST["gestionJornada_hora_salida"],
    "hora_descanso_entrada" => $_POST["gestionJornada_hora_descanso_entrada"],
    "hora_descanso_salida" => $_POST["gestionJornada_hora_descanso_salida"],
    "hora_descanso_entrada_second" => $_POST["gestionJornada_hora_descanso_entrada2"],
    "hora_descanso_salida_second"  => $_POST["gestionJornada_hora_descanso_salida2"],
    "horas"         => 0,
    "total"         => 0,
    "retencion"     =>0,
    "descanso"      => 0,
    "total_sin_descanso" => 0,
    "salario_jornada" => 0,
    "hora_suma"   => $_POST["gestionJornada_sumar_hora"],
    "hora_resta"  => $_POST["gestionJornada_restar_hora"],
    "comision"    => $_POST["gestionJornada_comision"],
    "bono"        => $_POST["gestionJornada_bono"],
    "estatus"       => 1
  ];

  $guardar = $wpdb->insert(
    TABLA_JORNADA_DIARIA,
    $data
  );

  $id_jornada = $wpdb->insert_id;


  /*=====================================================
    =       OBTENEMOS EL SALARIO DE ACUERDO A LA FECHA     =
  =====================================================*/
  $obtener_salario = $wpdb->get_row("
    SELECT * 
    FROM ".TABLA_SALARIO." as salario
    where salario.id_empleado = ".$_POST["horaExtra_nombres"]." 
    AND '".$_POST["gestionJornada_fecha"]."' BETWEEN salario.fecha_inicial AND salario.fecha_final
  ");

  /*=====================================================
  =   OBTENEMOS LOS VALORES DE LA JORNADA REGISTRADA       =
  =====================================================*/
  $value = $wpdb->get_row("
    SELECT *, jornada_diaria.fecha as fechaJornada 
    FROM ".TABLA_JORNADA_DIARIA." as jornada_diaria
    LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = jornada_diaria.id_empleado
    WHERE jornada_diaria.id_jornada_diaria = ".$id_jornada."   
  ");

  $diaPrueba = dame_el_dia($_POST['gestionJornada_fecha']);
  $cantidadDia = dia_numero($diaPrueba);

  $dt = new DateTime($_POST['gestionJornada_fecha']);
  $dt->format("Y-m-d");
  $dt->modify("-".$cantidadDia." day");

  $comienzo_de_semana = $dt->format("Y-m-d");
  $final_de_semana = $_POST['gestionJornada_fecha'];

  /*=====================================================
  =   OBTENEMOS LA CANTIDAD DE HORA TRABAJADAS       =
  =====================================================*/
  $sql_cantidad_horas = $wpdb->get_row("
        SELECT SUM(diaria.horas) as totalHoras, extra.salario_hora_extra as salario_hora_extra
        FROM ".TABLA_JORNADA_DIARIA." as diaria
        LEFT JOIN ".TABLA_HORA_EXTRA." as extra ON extra.id_empleado = diaria.id_empleado
        WHERE diaria.id_empleado = ".$_POST["horaExtra_nombres"]."
        AND diaria.fecha BETWEEN '".$comienzo_de_semana."' AND  '".$final_de_semana."'
  ");

  // if($sql_cantidad_horas->totalHoras > 40 && !empty($sql_cantidad_horas->salario_hora_extra)){

  //   $salario_verificado = $sql_cantidad_horas->salario_hora_extra;
  //   $salario = $value->salario;

  // }else if(!empty($obtener_salario)){

  //   $salario_verificado = $obtener_salario->salario;

  // }else{

  //   $salario_verificado = $value->salario;

  // }

  $salario_verificado = $value->salario;
  $salario = $value->salario;
  
  /// *********** Funcion para calcular las horas *************/  
  $horas = restar_tiempo($value->hora_entrada,$value->hora_salida);
  
  $total_sin_descanso = $salario_verificado * decimalHours($horas);
  /// *********** Fin Funcion para calcular las horas *************/
  

  /// *********** Funcion para calcular las Descanso1 *************/ 
  $descanso1 = restar_tiempo($value->hora_descanso_entrada,$value->hora_descanso_salida);

  /// *********** Funcion para calcular las Descanso2 *************/  
  $descanso2 = restar_tiempo($value->hora_descanso_entrada_second,$value->hora_descanso_salida_second);


  /// *********** Fin Funcion para calcular las Descanso2 *************/  
  $total_descanso = [ $descanso1, $descanso2 ];
  $descanso_suma = sumarHoras($total_descanso);
  // $descanso_suma = calcular_tiempo_trasnc($descanso1,$descanso2);
  
  $times =  restar_tiempo($horas,$descanso_suma);
  
   /*=================================================
               Sumar o Restar Tiempo           
   ===================================================*/
  if(!empty($_POST["gestionJornada_restar_hora"])){
     
    $restar = numeroDecimalAHoras($_POST["gestionJornada_restar_hora"]);
    $times = restar_tiempo($times,$restar);
    
  }

  if(!empty($_POST["gestionJornada_sumar_hora"])){

    $suma = numeroDecimalAHoras($_POST["gestionJornada_sumar_hora"]);
    $horasDb = [$times,$suma];
    $times = sumarHoras($horasDb);

  }

  $total_horas_DB = decimalHours($times);

  /*=====================================================
    =        FIN Calculo horas y total salario            =
  =====================================================*/

  /*=========================================
    =            Calculo horas extras            =
  =========================================*/
  if($sql_cantidad_horas->totalHoras >= 40 ){

    // if( strlen($sql_cantidad_horas->totalHoras) > 2 ){
    //   $cantidad_horas = decimalHours($sql_cantidad_horas->totalHoras);
    // }else{
    //   $cantidad_horas = $sql_cantidad_horas->totalHoras;
    // }

    // $total_salario = $salario_verificado * $total_horas_DB;
    // $total = $total_salario;

    $total_salario = $salario_verificado * $total_horas_DB;
    $total = $total_salario;
    
  }else if( ($sql_cantidad_horas->totalHoras + $total_horas_DB) > 40 ){

    // if( strlen($sql_cantidad_horas->totalHoras) > 2 ){

    //   $cantidad_horas = decimalHours($sql_cantidad_horas->totalHoras);

    // }else{

    //   $cantidad_horas = $sql_cantidad_horas->totalHoras;

    // }

    // $calculo_hora_restante = ($sql_cantidad_horas->totalHoras + $total_horas_DB) - 40;

    // $total_salario_hora_extra = $salario_verificado * $calculo_hora_restante;
    // $total_salario_normal = $salario_verificado  * ($total_horas_DB - $calculo_hora_restante);

    // $total_salario = $total_salario_normal + $total_salario_hora_extra;
    // $total = $total_salario;

    $total_salario = $salario_verificado * $total_horas_DB;
    $total = $total_salario;

  }else{

    $total_salario = $salario_verificado * $total_horas_DB;
    $total = $total_salario;

  }    
  /*=========================================
  =            FIN Calculo horas extras       =
  =========================================*/


  /*=========================================
  =            Calculo Retencion            =
  =========================================*/
  $busqueda_retencion = $wpdb->get_row("
      SELECT SUM(jornada_diaria.total) as totalAnual
      FROM ".TABLA_JORNADA_DIARIA." as jornada_diaria
      WHERE jornada_diaria.id_empleado = ".$value->id_empleado."   
      AND jornada_diaria.fecha <= '".$value->fechaJornada."'
  ");

  $suma_total = $busqueda_retencion->totalAnual + $total;
  $suma_retencion = 0;
  $retencion_10_porciento = 0;
  $retencion_cal2 = 0;
  $retencion_cal3 = 0;

  if($busqueda_retencion->totalAnual >= 500){

    $retencion = ($total * 10) / 100;

  }else if($suma_total >= 500 ){

    $total_de_retencion = $suma_total - 500;
    $retencion = ($total_de_retencion * 10) / 100;

  }else{

    $retencion = 0;

  }

  $total_a_pagar = $total_salario - $retencion;
  /*=========================================
  =            Fin Retencion            =
  =========================================*/

  $data2 = [
    "horas" => $total_horas_DB,
    "total_sin_retencion" => $total_salario,
    "total" => $total_a_pagar,
    "retencion" => $retencion,
    "descanso" => $descanso_suma,
    "total_sin_descanso" => $total_sin_descanso,
    "salario_jornada" => $salario_verificado,
    "salario_jornada_normal" => $salario
  ];  

  $editar = $wpdb->update(
      TABLA_JORNADA_DIARIA, 
      $data2,
      array( 
        'id_jornada_diaria' => $id_jornada
      )
  );


  $guardado_empleado = 0;

  }//fin del else busqueda registro

  if($guardar){

    $guardado_empleado = 1;

  }else{

    $guardado_empleado = 2;

  }

}else if(isset($_POST['jornada_diaria_eliminar'])){

  $guardar = $wpdb->delete( TABLA_JORNADA_DIARIA, 
      array( 'id_jornada_diaria' => $_POST['id_jornada']) );

  $guardado_empleado = 0;

  if($guardar){

    $guardado_empleado = 1;

  }else{

    $guardado_empleado = 2;

  }

}






/*=================================
=            FUNCIONES            =
=================================*/
function calcular_tiempo_trasnc($hora1,$hora2){
    $comparar_hora = strtotime( $hora1 );
    $comparar_hora2 = strtotime( $hora2 );
    
    if($comparar_hora > $comparar_hora2){
      $separar[1]=explode(':',$hora1);
      $separar[2]=explode(':',$hora2);
    }else{
      $separar[1]=explode(':',$hora2);
      $separar[2]=explode(':',$hora1);
    }
    

    $total_minutos_trasncurridos[1] = ($separar[1][0]*60)+$separar[1][1];
    $total_minutos_trasncurridos[2] = ($separar[2][0]*60)+$separar[2][1];

    $total_minutos_trasncurridos = $total_minutos_trasncurridos[1]-$total_minutos_trasncurridos[2];

    if($total_minutos_trasncurridos<=59){
      return('00:'.$total_minutos_trasncurridos);
    } 

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
    	$redondear = $minutos;
      $resultado = $hms[0] + $redondear;
    }
    
    return $resultado; 
}




function restar_tiempo($entrada, $salida){
  
  $entrada2 = new DateTime($entrada);
  $salida2 = new DateTime($salida);

  $diferencia = $entrada2->diff($salida2);

  // echo $diferencia->format("%H:%i"); 
  
  $horas = $diferencia->format("%H:%i:%s");

  return $horas;
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

function numero_tiempo($numero){
  if(strlen($numero) < 2){
    return '00:'.$numero;
  }else{
    return $numero;
  }
}

function sumarHoras($horas) {

  $total = 0;
  foreach($horas as $h) {
      $parts = explode(":", $h);
      $total += $parts[2] + $parts[1]*60 + $parts[0]*3600;        
  }   
  return gmdate("H:i:s", $total);

}


function numeroDecimalAHoras($numeroDecimal){
  
  $findme   = '.';
  $pos = strpos($numeroDecimal, $findme);

  if ($pos === false) {

    return $numeroDecimal.':00:00';

  }else{

    $hms = explode(".", $numeroDecimal);

    $horas = $hms[0];
    $minutos = $hms[1];
    
    if(strlen($minutos) < 2){
      $minutos = ($hms[1] * 60) / 10;
    }else{
      $minutos = ($hms[1] * 60) / 100;
    }

  }

  return $horas.':'.$minutos.':00';


}



?> 