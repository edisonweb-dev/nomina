<?php 

if ( ! defined( 'ABSPATH' ) ) exit; 

global $wpdb;
global $guardado_empleado;


if(isset($_POST['actualizar_jornada_diaria'])){

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



  if($sql_cantidad_horas->totalHoras > 40){
    $salario_verificado = $sql_cantidad_horas->salario_hora_extra;
  }else if(!empty($obtener_salario)){
    $salario_verificado = $obtener_salario->salario;
  }else{
    $salario_verificado = $value->salario;
  }


  /// *********** Funcion para calcular las horas *************/  
  $salida_hora = dateFormat($value->hora_salida);
  $entrada_hora = dateFormat($value->hora_entrada);

  $horas = restar_tiempo($entrada_hora,$salida_hora);
  
  $total_sin_descanso = $salario_verificado * decimalHours($horas);
  /// *********** Fin Funcion para calcular las horas *************/
  

  /// *********** Funcion para calcular las Descanso1 *************/  
  $entrada_descanso1 = dateFormat($value->hora_descanso_entrada);
  $salida_descanso1 = dateFormat($value->hora_descanso_salida);
  
  $descanso1 = restar_tiempo($entrada_descanso1,$salida_descanso1);
  /// *********** Fin Funcion para calcular las Descanso1 *************/


  /// *********** Funcion para calcular las Descanso2 *************/  
  $entrada_descanso2 = dateFormat($value->hora_descanso_entrada_second);
  $salida_descanso2 = dateFormat($value->hora_descanso_salida_second);

  $descanso2 = restar_tiempo($entrada_descanso2,$salida_descanso2);
  /// *********** Fin Funcion para calcular las Descanso2 *************/  

  
  $descanso_suma =  restar_tiempo($descanso1,$descanso2);
  $times =  restar_tiempo($horas,$descanso_suma);

  $total_horas_DB = decimalHours($times);

  
  /*=====================================================
    =           FIN Calculo horas y total salario            =
  =====================================================*/
  

  /*=========================================
  =            Calculo horas extras            =
  =========================================*/
      
  if($sql_cantidad_horas->totalHoras > 40){

    $total_salario = $salario_verificado * $total_horas_DB;

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


  if($suma_total >= 500 ){

    $suma_retencion = $suma_total - 500;
    $retencion_10_porciento = ($suma_retencion * 10) / 100;

    $retencion_cal2 = $suma_retencion - $retencion_10_porciento;
    $retencion_cal3 = 500 - $total;
    $retencion = $retencion_cal3 + $retencion_cal2;

  }else{
    $retencion = 0;
  }
  /*=========================================
  =            Fin Retencion            =
  =========================================*/
  $data2 = [
      "horas" => $total_horas_DB,
      "total" => round($total_salario, 2),
      "retencion" => round($retencion_cal2,2),
      "descanso" => $descanso_suma,
      "total_sin_descanso" => round($total_sin_descanso, 2),
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





}else if(isset($_POST['registrar_jornada_diaria'])){

   
  
  /*=================================
      consulta registro jornada                               
  =================================*/
  $busqueda_registro = $wpdb->get_row("
    SELECT *
    FROM ".TABLA_JORNADA_DIARIA." as jornada_diaria
    WHERE jornada_diaria.id_empleado = ".$_POST["horaExtra_nombres"]." 
    AND jornada_diaria.fecha = '".$_POST["gestionJornada_fecha"]."'
  ");

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
    "estatus"       => $_POST["gestionJornada_estatus"]
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

  if($sql_cantidad_horas->totalHoras > 40){

    $salario_verificado = $sql_cantidad_horas->salario_hora_extra;

  }else if(!empty($obtener_salario)){

    $salario_verificado = $obtener_salario->salario;

  }else{

    $salario_verificado = $value->salario;

  }

  
  /// *********** Funcion para calcular las horas *************/  
  $salida_hora = dateFormat($value->hora_salida);
  $entrada_hora = dateFormat($value->hora_entrada);

  if(!empty($salida_hora) || !empty($entrada_hora)){
    $horas = restar_tiempo($entrada_hora,$salida_hora);
  }else{
    $horas = 0;
  }
  
  $total_sin_descanso = $salario_verificado * decimalHours($horas);
  /// *********** Fin Funcion para calcular las horas *************/
  

  /// *********** Funcion para calcular las Descanso1 *************/ 
  if(!empty($value->hora_descanso_entrada)){
    $entrada_descanso1 = dateFormat($value->hora_descanso_entrada);
  }else{
    $entrada_descanso1 = 0;
  } 

  if(!empty($value->hora_descanso_entrada)){
    $salida_descanso1 = dateFormat($value->hora_descanso_salida);
  }else{
    $salida_descanso1 = 0;
  }

  if(!empty($entrada_descanso1) || !empty($salida_descanso1)){
    /// *********** Fin Funcion para calcular las Descanso1 *************/
    $descanso1 = restar_tiempo($entrada_descanso1,$salida_descanso1);
  }
  
  
  


  /// *********** Funcion para calcular las Descanso2 *************/  
  if(!empty($value->hora_descanso_entrada_second)){
    $entrada_descanso2 = dateFormat($value->hora_descanso_entrada_second);
  }else{
    $entrada_descanso2 = 0;
  }

  if(!empty($value->hora_descanso_salida_second)){
    $salida_descanso2 = dateFormat($value->hora_descanso_salida_second);
  }else{
    $salida_descanso2 = 0;
  }
  
  
  if(!empty($entrada_descanso2) || !empty($salida_descanso2)){
    $descanso2 = restar_tiempo($entrada_descanso2,$salida_descanso2);
  }else{
    $descanso2 = 0;
  }
  
  /// *********** Fin Funcion para calcular las Descanso2 *************/  
  if(!empty($descanso1) || !empty($descanso2)){
    $descanso_suma =  restar_tiempo($descanso1,$descanso2);
  }else{
    $descanso_suma = 0;
  }

  if(!empty($horas) || !empty($descanso_suma)){
    $times =  restar_tiempo($horas,$descanso_suma);
  }else{
    $times = 0;
  }
  
  
  

  $total_horas_DB = decimalHours($times);

  $total_salario = $salario_verificado * $total_horas_DB;
  $total = $total_salario;
  /*=====================================================
    =        FIN Calculo horas y total salario            =
  =====================================================*/

  /*=========================================
    =            Calculo horas extras            =
  =========================================*/
  if($sql_cantidad_horas->totalHoras >= 40){

    $total_salario = $salario_verificado * $total_horas_DB;

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


  if($suma_total >= 500 ){

    $suma_retencion = $suma_total - 500;
    $retencion_10_porciento = ($suma_retencion * 10) / 100;

    $retencion_cal2 = $suma_retencion - $retencion_10_porciento;
    $retencion_cal3 = 500 - $total;
    $retencion = $retencion_cal3 + $retencion_cal2;

  }else{
    $retencion = 0;
  }
  /*=========================================
  =            Fin Retencion            =
  =========================================*/

  $data2 = [
    "horas" => $total_horas_DB,
    "total" => round($total_salario, 2),
    "retencion" => round($retencion_cal2,2),
    "descanso" => $descanso_suma,
    "total_sin_descanso" => round($total_sin_descanso, 2),
    "salario_jornada" => $salario_verificado
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
    $separar[1]=explode(':',$hora1);
    $separar[2]=explode(':',$hora2);

    $total_minutos_trasncurridos[1] = ($separar[1][0]*60)+$separar[1][1];
    $total_minutos_trasncurridos[2] = ($separar[2][0]*60)+$separar[2][1];

    $total_minutos_trasncurridos = $total_minutos_trasncurridos[1]-$total_minutos_trasncurridos[2];

    if($total_minutos_trasncurridos<=59){
      return($total_minutos_trasncurridos);
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
    	$redondear = round($minutos, 2);
      $resultado = $hms[0] + $redondear;
    }
    
    return $resultado; 
}



function dateFormat($date = 0)
{
  if(!empty($date)){
  
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
    
  }else{
    return 0;
  }
    

}



function suma_fecha($date_1 , $date_2)
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
 
    $interval = ($datetime1 + $datetime2);
 
    return $interval;
 
}


function restar_tiempo($entrada, $salida){
  
  $entrada2 = new DateTime($entrada);
  $salida2 = new DateTime($salida);

  $diferencia = $entrada2->diff($salida2);

  // echo $diferencia->format("%H:%i"); 
  
  $horas = $diferencia->format("%H:%i");

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






?> 