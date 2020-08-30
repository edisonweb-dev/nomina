<?php 

if ( ! defined( 'ABSPATH' ) ) exit; 

global $wpdb;

global $guardado_empleado;


if(isset($_POST['actualizar_hora_extra_editar'])){
  
	$data = [
			"id_empleado" => $_POST["id_empleado"],
			"salario_hora_extra" => $_POST["horaExtra_salario"],
			"fecha"       => $_POST["horaExtra_fecha"],
			"estatus" 		=> $_POST["horaExtra_estatus"]
	];

	$guardar = $wpdb->update(
      TABLA_HORA_EXTRA, 
      $data,
      array( 'id_empleado' => $_POST["id_empleado"] )
  );


  $cantidadDia = 0;
  $dt = new DateTime($_POST["horaExtra_fecha"]);
	// $dt2 = new DateTime($_POST["fecha_final"]);
  
  // Calculo de los dias de semana 
  $diaPrueba = dame_el_dia($_POST["horaExtra_fecha"]);
  $cantidadDia = dia_numero($diaPrueba);

  if(!empty($cantidadDia)){

    $dt->modify("-".$cantidadDia." day");

  }
  

  $comienzo_de_semana = $dt->format("Y-m-d");

  $final_semana = new DateTime($comienzo_de_semana);
  $final_semana->modify("+6 day");
  $final_de_semana = $final_semana->format("Y-m-d");    


  $diaName = [];
  $dia = [];

  $horaContar = 0;
  $totalGeneral = 0;
  $retencion = 0;
  
  $fechaInicio=strtotime($comienzo_de_semana);
  $fechaFin=strtotime($final_de_semana);
  for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
      array_push($diaName,date("d-m-Y", $i));
      array_push($dia,date("d", $i));
  }


  $obtener = $wpdb->get_results("
				SELECT *, 
					jornada_diaria.fecha as fechaJornada
        FROM ".TABLA_JORNADA_DIARIA." as jornada_diaria
        LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = jornada_diaria.id_empleado
				LEFT JOIN ".TABLA_SALARIO." as salario ON salario.fecha_final = '".$final_de_semana."'
				LEFT JOIN ".TABLA_HORA_EXTRA." as extra 
					ON extra.id_empleado = ".$_POST['id_empleado']."
          AND extra.fecha BETWEEN '".$comienzo_de_semana."' AND '".$final_de_semana."'
          AND extra.estatus = 1
        WHERE jornada_diaria.fecha BETWEEN '".$comienzo_de_semana."' AND '".$final_de_semana."'
        AND empleado.id_empleado = ".$_POST['id_empleado']."  
        ORDER BY jornada_diaria.fecha ASC 
    ");

  if($obtener){

    $i=0;

    $totalContar = 0;
    $horaJornada = 0;
    $PRstate = 0;
    $descansoJornada = 0;
    $salarioDeJornada = 0;
    $retencion_total = 0;

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
    $retencion_sql = [];
    $total_sql = 0;
    $salario_activo_40 = 0;

    $final_semana_retencion = new DateTime($comienzo_de_semana);
    $final_semana_retencion->modify("-1 day");
    $final_de_semana_retencion_sql = $final_semana_retencion->format("Y-m-d");

    $busqueda_retencion = $wpdb->get_row("
      SELECT SUM(jornada_diaria.total_sin_retencion) as totalAnual
      FROM ".TABLA_JORNADA_DIARIA." as jornada_diaria
      WHERE jornada_diaria.id_empleado = ".$_POST['id_empleado']."   
      AND jornada_diaria.fecha <= '".$final_de_semana_retencion_sql."'
    ");

    $suma_total = $busqueda_retencion->totalAnual;
    $suma_retencion = 0;
    $retencion_10_porciento = 0;
    $retencion_cal2 = 0;
    $retencion_cal3 = 0;
    $total_de_retencion = 0;

    $PRstate_semanal = 0;
    $retencion_activo = 0;

    foreach ($obtener as $key => $value):

      $estatus_retencion = 0;
      $horaJornada += $value->horas;

      if(empty($value->salario_hora_extra)){
        $salario_extra = $value->salario_jornada_normal;
      }else{
        $salario_extra = $value->salario_hora_extra;
      }

      if($horaJornada > 40 && empty($salario_activo_40) ){

        $cantidad_hora_extra = $horaJornada -40;
        $total_de_hora_extra = $cantidad_hora_extra * $salario_extra;

        $total_salario_normal = ($value->horas - $cantidad_hora_extra ) * $value->salario_jornada_normal;

        $total_sql = $total_salario_normal + $total_de_hora_extra;
        
        $salarioDeJornada = $salario_extra;
        $salario_activo_40 = 1;

      }else if( !empty($salario_activo_40) ){ 	

        $total_sql = $value->horas * $salario_extra;
        $salarioDeJornada = $salario_extra;

      }else{

        $total_sql = $value->total_sin_retencion;
        $salarioDeJornada = $value->salario_jornada;

      }	


      $descansoJornada += decimalHours($value->descanso);
        // $totalContar += $value->total_sin_retencion;
      if(!empty($total_sql)){
        $totalContar += $total_sql;
      }else{
        $total_sql = 0;
      }
      
      if(!empty($retencion)){
        $retencion_total += $retencion;
      }else{
        $retencion = 0;
      }

      $nuevaFecha = date("Y/m/d", strtotime($diaName[$i]));
				
      array_push($total_diario_sql, $total_sql);
      // array_push($total_diario_sql, $value->total_sin_retencion);
      array_push($fecha_sql, $diaName[$i]);
      $fechaN = explode("-", $value->fecha);
      array_push($fechaN_sql, $diaName[$i]);

      array_push($sql_dameDia, dame_el_dia($value->fechaJornada));

      array_push($descanso_entrada_sql, am_pm($value->hora_descanso_entrada));
      array_push($descanso_salida_sql, am_pm($value->hora_descanso_salida));

      array_push($descanso_entrada_second_sql, am_pm($value->hora_descanso_entrada_second));
      array_push($descanso_salida_second_sql, am_pm($value->hora_descanso_salida_second));

      array_push($hora_entrada_sql, am_pm($value->hora_entrada));
      array_push($hora_salida_sql, am_pm($value->hora_salida));

      array_push($horas_sql, $value->horas);
      array_push($salario_jornada_sql, $salarioDeJornada);

      array_push($retencion_sql, $retencion);

      if( $suma_total >= 500 && !empty($suma_total) && empty($estatus_retencion) ){

        $retencion = ($total_sql * 10) / 100;
        $estatus_retencion = 1;

      }else if( ($suma_total + $totalContar) >= 500 && !empty($retencion_activo) && empty($estatus_retencion)  ){   

        $retencion = ($total_sql * 10) / 100;
        $estatus_retencion = 1;

      }else if( ($suma_total + $totalContar) >= 500  && empty($retencion_activo) && empty($estatus_retencion) ) {
        
        $total_de_retencion = ($suma_total + $totalContar ) - 500;
        $retencion = ($total_de_retencion * 10) / 100;
        $retencion_activo = 1;

        $estatus_retencion = 1;
      
      }else if( $suma_total < 500 && empty($estatus_retencion) ){

        $retencion = 0;
        $estatus_retencion = 1;

      }

      $PRstate_semanal += $retencion;

      $data = [
        "total_sin_retencion" => $total_sql,
        "total"               => ($total_sql - $retencion), 
        "retencion"           => round($retencion, 2),
        "salario_jornada"     => $salarioDeJornada
      ];
  
      $wpdb->update(
        TABLA_JORNADA_DIARIA, 
        $data,
        array( 'id_jornada_diaria' => $value->id_jornada_diaria )
      );
      
      $i++;



    endforeach;   

  }//fin obtener

      

  

  $guardado_empleado = 0;

  if($guardar){
    
    $guardado_empleado = 1;
    include_once(ABSPATH . 'wp-includes/pluggable.php');
    
    $url_actual = home_url()."/gestion-horas-extras/?editar-hora=".$_POST["id_empleado"]."&guardar=1"; 
    

    wp_redirect( $url_actual );
    exit;


  }else{

	  $guardado_empleado = 2;

  }

}else if(isset($_POST['actualizar_hora_extra_eliminar'])){

  $data = [
    "id_empleado" => 0,
    "salario_hora_extra" => 0,
    "fecha"       => 0,
    "estatus" 		=> 0
  ];

  $guardar = $wpdb->update(
          TABLA_HORA_EXTRA, 
          $data,
          array( 'id_empleado' => $_POST["id_empleado"] )
      );

  $guardado_empleado = 0;

  if($guardar){

    $guardado_empleado = 1;

  }else{

    $guardado_empleado = 2;

  }


}




    
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