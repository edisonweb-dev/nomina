
<?php 
  
  global $wpdb;
  global $guardado_empleado;


  $empleado = $wpdb->get_row("
      SELECT * 
      FROM ".TABLA_EMPLEADOS." as empleado 
      WHERE empleado.id_empleado = ".$_POST["id_empleado"]."
  ");

  $dt = new DateTime($_POST["fecha_inicial"]);
  $dt2 = new DateTime($_POST["fecha_final"]);

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
      WHERE empleado.id_empleado = ".$_POST['id_empleado']."   
  ");
  
  $horaContar = 0;
  $totalGeneral = 0;
  $retencion = 0;
  foreach ($busqueda as $key => $value):
    $horaContar += $value->horas;
    $totalGeneral += $value->total;
    $retencion += $value->retencion;
  endforeach;
  

  $obtener = $wpdb->get_results("
      SELECT *
      FROM ".TABLA_JORNADA_DIARIA." as jornada_diaria
      LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = jornada_diaria.id_empleado
      LEFT JOIN ".TABLA_SALARIO." as salario ON salario.fecha_final = '".$_POST["fecha_final"]."'
      WHERE jornada_diaria.fecha BETWEEN '".$_POST["fecha_inicial"]."' AND '".$_POST["fecha_final"]."'
      AND empleado.id_empleado = ".$_POST['id_empleado']."  
      ORDER BY jornada_diaria.fecha ASC 
  ");


  if($obtener){


 ?>


<style>
    /* .border-0{
        border:0!important;
    }
    .border-left{
        border-left:2px solid black !important;
    }
     .border-right{
        border-right:2px solid black !important;
    }
     .border-top{
        border-top:2px solid black !important;
    }
    .border-bottom-3{
        border-bottom:3px solid black !important;
    }
     .border-top-2{
        border-top:2px solid black !important;
    }
    .border-top-3{
        border-top:3px solid black !important;
    }
    .bg-gray{
        background:#dedede;
        font-weight:bold;
    }
    .border-bold{
        border:3px solid black !important;
    }
    .border-top-0{
        border-top:0 !important;
    }
    .bold{
       font-weight:bold; 
    } */

    .table-container{
      overflow-x:auto;
    }
    .table-v1{
      max-width: 800px;
    }
</style>

<div class="row">
<div class="col-md-12">

<div class="table-container">
<table class="table-v1 table table-hover">

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
    	<th class="border-0" ><?php echo $empleado->id_empleado; ?></th>
    	<th class="border-0" ><?php echo $empleado->nro_empleado; ?></th>
    	<th class="border-0"  colspan="2">1</th>
    	<th class="border-0" >1</th>
    </tr>
    <tr>
    	<th class="border-0" colspan="14">Teléfono de mi compañia</th>
    </tr>
    <tr>
    	<th class="border-0" colspan="8"></th>
    	<th class="border-0" colspan="3">Nombre del Empleado</th>
    	<th class="border-0" colspan="3"><?php echo $empleado->nombres.' '.$empleado->apellidos ?></th>
    </tr>
    <tr>
    	<th class="border-0" colspan="2">Pay Period:</th>
    	<th class="border-0" colspan="3"> <?php echo $dt->format('Y M d').' to '.$dt2->format('Y M d'); ?></th>
    	<th class="border-0" colspan="3"></th>
    	<th class="border-0" colspan="3">Direccion Empleado</th>
    	<th class="border-0" colspan="3"><?php echo $empleado->direccion ?></th>
    </tr>
    <tr>
    	<th class="border-0" colspan="2">Pay Date:</th>
    	<th class="border-0" colspan="3"> <?php echo Date("F d, Y") ?></th>
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
		</tr>
	
<?php 
	
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

  foreach ($obtener as $key => $value):
    $i++;

    if(!empty($value->salario)){
      $salarioDeJornada = $value->salario;
    }else{
      $salarioDeJornada = $value->salario_jornada;
    }

   array_push($total_diario_sql, $value->total);
   array_push($fecha_sql, $value->fecha);
   
   $fechaN = explode("-", $value->fecha);
   array_push($fechaN_sql, $fechaN);
   
   $horaJornada += $value->horas;
   $descansoJornada += decimalHours($value->descanso);
   $totalContar += $value->total;
   
   $nuevaFecha = date("Y/m/d", strtotime($diaName[$i]));
   

   array_push($sql_dameDia, dame_el_dia($value->fecha));

   array_push($descanso_entrada_sql, am_pm($value->hora_descanso_entrada));
   array_push($descanso_salida_sql, am_pm($value->hora_descanso_salida));

   array_push($descanso_entrada_second_sql, am_pm($value->hora_descanso_entrada_second));
   array_push($descanso_salida_second_sql, am_pm($value->hora_descanso_salida_second));

   array_push($hora_entrada_sql, am_pm($value->hora_entrada));
   array_push($hora_salida_sql, am_pm($value->hora_salida));

   array_push($horas_sql, $value->horas);
   array_push($salario_jornada_sql, $salarioDeJornada);
   
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
  
  // var_dump($fecha_sql);
  // echo "<br/>";
  // echo $i;
  // echo "<br/>";
  $dias_busqueda = dame_el_dia($fecha_sql[$i-1]);
  $cantidad_dia = dia_numero($dias_busqueda);
  
  $nuevafechaSuma = strtotime ( '-'.$cantidad_dia.' day' , strtotime ( $fecha_sql[$i-1] ) );
  $nuevafechaSuma = date ( 'Y-m-j' , $nuevafechaSuma );
  // var_dump($nuevafechaSuma);
  

	foreach ($diasReporte as $key => $value):
	   
    $resultSearch = in_array($value, $sql_dameDia);

    $fecha_dia_jornada = strtotime ( '+'.$o.' day' , strtotime ( $nuevafechaSuma ) );
    $fecha_dia_jornada = date ( 'Y-m-j' , $fecha_dia_jornada );
    $dia_fecha = explode("-", $fecha_dia_jornada);

    $o++;

    if ($resultSearch) {

      
  ?>

    <tr>
      <td>Hourly  </td>
      <td><?php echo $value ?></td>
      <td><?php echo $dia_fecha[2]; ?></td>
      <td></td>
      <td></td>
      <td><?php echo $descanso_entrada_sql[$z]; ?></td>
      <td><?php echo $descanso_salida_sql[$z]; ?></td>
      <td><?php echo $descanso_entrada_second_sql[$z]; ?></td>
      <td><?php echo $descanso_salida_second_sql[$z]; ?></td>
      <td><?php echo $hora_entrada_sql[$z]; ?></td>
      <td><?php echo $hora_salida_sql[$z]; ?></td>

      <td><?php echo $horas_sql[$z]; ?></td>
      <td>$<?php echo number_format($salario_jornada_sql[$z],2); ?></td>
      <td>$<?php echo number_format($total_diario_sql[$z], 2); ?></td>
    </tr>

  <?php

    $z++;

  }else{
      
 ?>
    <tr>
      <td>Hourly</td>
      <td><?php echo $value ?></td>
      <td><?php echo $dia_fecha[2]; ?></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td><?php echo "0.00"; ?></td>
      <td><?php echo "$0.00" ?></td>
      <td><?php echo "$0.00"; ?></td>
    </tr>
    
 <?php 

  }

 	endforeach;	

 ?>

<tr>
  <td colspan="10"></td>
  <td colspan="3">Total Current Amount:</td>
  <td>$<?php echo $totalContar; ?></td>
 </tr>

 <tr class="bg-gray border-bold">
  <td>Total Hours</td>
  <td><?php echo $horaJornada; ?></td>
  <td>T AMT</td>
  <td>$<?php echo $totalContar; ?></td>
  <td colspan="2">Total YTD Hours</td>
  <td colspan="4"><?php echo $horaContar; ?></td>
  <td colspan="3">Total YTD Amount:</td>
  <td>$<?php echo $totalGeneral; ?></td>
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
  <td colspan="9"></td>
 </tr>

 <tr>
  <td  class="border-0">Medicare</td>
  <td  class="border-0"></td>
  <td  class="border-0"></td>
  <td  class="border-0"></td>
  <td  class="border-0"></td>
  <td colspan="9"></td>
 </tr>

 <tr>
  <td  class="border-0">Federal</td>
  <td  class="border-0"></td>
  <td  class="border-0"></td>
  <td  class="border-0"></td>
  <td  class="border-0"></td>
  <td colspan="9"></td>
 </tr>

 <tr>
  <td  class="border-0">PR State</td>
  <td  class="border-bottom-3 border-top-0"></td>
  <td  class="border-bottom-3 border-top-0"></td>
  <td  class="border-bottom-3 border-top-0">$<?php echo round($PRstate,2); ?></td>
  <td  class="border-bottom-3 border-top-0">$<?php echo round($retencion,2); ?></td>
  <td colspan="9"></td>
 </tr>

 <tr>
  <td  class="border-0"></td>
  <td  class="border-bottom-3 bold">Total Taxes</td>
  <td  class="border-bottom-3 bold"></td>
  <td  class="border-bottom-3 bold">$<?php echo round($PRstate,2); ?></td>
  <td  class="border-bottom-3 bold">$<?php echo round($retencion,2); ?></td>
  <td colspan="9"></td>
 </tr>

 <tr>
  <td  class="border-0 bold ">Direct Deposists</td>
  <td  class="border-0 bold">ABA No.</td>
  <td  class="border-0 bold">Acc No</td>
  <td  class="border-0"></td>
  <td  class="border-0 bold">Amount</td>
  <td  class="border-0" colspan="9"></td>
 </tr>

 <tr>
  <td  class="border-0"></td>
  <td  class="border-bottom-3 border-top-0"><?php echo $empleado->nro_ruta ?></td>
  <td  class="border-bottom-3 border-top-0"><?php echo $cuenta_bancaria ?></td>
  <td  class="border-bottom-3 border-top-0"></td>
  <td  class="border-bottom-3 border-top-0">$<?php echo round($DDAmount,2); ?></td>
  <td colspan="9"></td>
 </tr>

 <tr>
  <td  class="border-0"></td>
  <td  class="border-bottom-3 border-top-0 bold" colspan="2">Total Direct Deposit</td>
  <td  class="border-bottom-3 border-top-0 bold"></td>
  <td  class="border-bottom-3 border-top-0 bold">$<?php echo round($DDAmount,2) ?></td>
  <td colspan="9"></td>
 </tr>

 <tr>
  <td  class="border-bottom-3 border-top-3 bold">Net Pay</td>
  <td  class="border-bottom-3 border-top-3"></td>
  <td  class="border-bottom-3 border-top-3"></td>
  <td  class="border-bottom-3 border-top-3"></td>
  <td  class="border-bottom-3 border-top-3 bold">$<?php echo round($DDAmount,2); ?></td>
  <td colspan="9"></td>
 </tr>

</tbody>
</table>
</div>
</div>
</div> 

<?php 

}else{

  echo '<div class="container">

<div class="row">

<div class="col-md-12">

<div class="alert alert-danger" role="alert">

  No hay registro

</div>

</div>

</div>

</div>';

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


 

?>