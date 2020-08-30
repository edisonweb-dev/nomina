<?php

    $pdf = new PDF_HTML('L','mm','A4');

    global $pdf;
    $title_line_height = 10;
    $content_line_height = 8;

    $pdf->AddPage();
    $pdf->SetFont( 'Arial', '', 10 );
    // $pdf->Write(20, 'ver jornada semanal pdf');
    // $str = utf8_decode($str);

    global $wpdb;
    global $guardado_empleado;

    $empleado = $wpdb->get_row("
        SELECT * 
        FROM ".TABLA_EMPLEADOS." as empleado 
        WHERE empleado.id_empleado = ".$_POST["id_empleado"]."
    ");

    $dt = new DateTime($_POST["fecha_inicial"]);
		$dt2 = new DateTime($_POST["fecha_final"]);
		
		// Calculo de los dias de semana 
		$diaPrueba = dame_el_dia($_POST["fecha_inicial"]);
		$cantidadDia = dia_numero($diaPrueba);

		$dt->modify("-".$cantidadDia." day");

		$comienzo_de_semana = $dt->format("Y-m-d");

		$final_semana = new DateTime($comienzo_de_semana);
		$final_semana->modify("+6 day");
		$final_de_semana = $final_semana->format("Y-m-d");

		// Fin Calculo de los dias de semana 

    $cuenta_bancaria = substr($empleado->nro_cuenta,-4);

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
    // Texto centrado en una celda con cuadro 20*10 mm y salto de línea

        // La linea
        $pdf->Line(290, 50, 10, 50);
        $pdf->Line(290, 54, 10, 54);

        $pdf->Line(290, 82, 10, 82);
        $pdf->Line(290, 86, 10, 86);
        $pdf->Line(290, 90, 10, 90);

        $pdf->Line(110, 96, 10, 96);
        // $pdf->Line(110, 120, 10, 120);
        // $pdf->Line(110, 126, 10, 126);

        $pdf->Line(110, 132, 10, 132);
        $pdf->Line(110, 137, 10, 137);

        $pdf->Line(110, 152, 10, 152);
        $pdf->Line(110, 156, 10, 156);

        // $pdf->Line(110, 136, 10, 136);
        // $pdf->Line(110, 156, 10, 156);
        // $pdf->Line(110, 160, 10, 160);

        // $pdf->Line(110, 168, 10, 168);


        $pdf->Cell(50,4,'',0,1,'C');
        $pdf->Cell(50,4,utf8_decode('Personal Earning Statement'),0,1,'C');

        $pdf->Cell(46,4,utf8_decode('Address of Company'),0,0,'C');
        $pdf->Cell(50,4,utf8_decode(''),0,0,'C');
        $pdf->Cell(70,4,'',0,0,'C');
        $pdf->Cell(25,4,utf8_decode('Emp#'),0,0,'C');
        $pdf->Cell(25,4,utf8_decode('EmpCode'),0,0,'C');
        $pdf->Cell(30,4,utf8_decode('SSN'),0,0,'C');
        $pdf->Cell(20,4,utf8_decode('Dept'),0,1,'C');

        $emp_id = $empleado->id_empleado;
        $emp_num = $empleado->nro_empleado;

        $pdf->Cell(49,4,utf8_decode('Address of Company 2'),0,0,'C');
        $pdf->Cell(40,4,utf8_decode(''),0,0,'C');
        $pdf->Cell(76,4,'',0,0,'C');
        $pdf->Cell(25,4,utf8_decode($emp_id),0,0,'C');
        $pdf->Cell(25,4,utf8_decode($emp_num),0,0,'C');
        $pdf->Cell(30,4,utf8_decode('1'),0,0,'C');
        $pdf->Cell(20,4,utf8_decode('1'),0,1,'C');


        $pdf->Cell(45,4,utf8_decode('Phone Company'),0,0,'C');
        $pdf->Cell(50,4,utf8_decode(''),0,1,'C');

        $emp_nombre = $empleado->nombres.' '.$empleado->apellidos;

        $pdf->Cell(160,4,'',0,0,'C');
        $pdf->Cell(40,4,'Name Employed:',0,0,'C');
        $pdf->Cell(40,4,utf8_decode($emp_nombre),0,1,'C');

        $emp_pay_period = $dt->format('Y M d').' to '.$dt2->format('Y M d');
        $emp_direccion = $empleado->direccion;

        $pdf->Cell(24,4,utf8_decode('Pay Period:'),0,0,'C');
        $pdf->Cell(50,4,utf8_decode($emp_pay_period),0,0,'C');
        $pdf->Cell(92,4,'',0,0,'C');
        $pdf->Cell(30,4,utf8_decode('Address Employed:'),0,0,'C');
        $pdf->Cell(50,4,utf8_decode($emp_direccion),0,1,'C');

        $emp_pay_date = Date("F d, Y");

        $pdf->Cell(21,4,utf8_decode('Pay Date:'),0,0,'C');
        $pdf->Cell(40,4,utf8_decode($emp_pay_date),0,0,'C');

        $pdf->Cell(30,4,'',0,0,'C');
        $pdf->Cell(21,4,utf8_decode('Voucher No.'),0,0,'C');
        $pdf->Cell(25,4,utf8_decode(''),0,0,'C');

        $pdf->Cell(30,4,'',0,0,'C');
        $pdf->Cell(30,4,utf8_decode('Address Employed 2:'),0,0,'C');
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

        //** Calculos de los datos */
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
        $comision = 0;
        $bono = 0;

        foreach ($obtener as $key => $value):
          
          if(!empty($value->comision)){
            $comision += $value->comision;
          }  

          if(!empty($value->bono)){
            $bono += $value->bono;
          }

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
          "retencion"           => $retencion,
          "salario_jornada"     => $salarioDeJornada
        ];
    
        $wpdb->update(
          TABLA_JORNADA_DIARIA, 
          $data,
          array( 'id_jornada_diaria' => $value->id_jornada_diaria )
        );
        
        $i++;
        endforeach; 

        // Busqueda del total General de la cantidad hora retencion y total general	
        $busqueda = $wpdb->get_row("
          SELECT 
          
            SUM(jornada_diaria.horas) as horas, 
            SUM(jornada_diaria.total) as total, 
            SUM(jornada_diaria.retencion) as retencion,
            SUM(jornada_diaria.total_sin_retencion) as totalSinRetencion
            
          FROM ".TABLA_JORNADA_DIARIA." as jornada_diaria
          LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = jornada_diaria.id_empleado
          WHERE empleado.id_empleado = ".$_POST['id_empleado']."   
        ");
        
        $horaContar = $busqueda->horas;
        $totalGeneral = $busqueda->totalSinRetencion;
        $retencion = $busqueda->retencion;
        // FIN Busqueda del total General de la cantidad hora retencion y total general	


        $PRstate = $busqueda->retencion;
        $DDAmount = $totalContar - $PRstate_semanal;
        

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
        
        //** Calculos de los datos */
        foreach ($diasReporte as $key => $value):
	   
            $resultSearch = in_array($value, $sql_dameDia);
        
            $fecha_dia_jornada = strtotime ( '+'.$o.' day' , strtotime ( $nuevafechaSuma ) );
            $fecha_dia_jornada = date ( 'Y-m-j' , $fecha_dia_jornada );
            $dia_fecha = explode("-", $fecha_dia_jornada);
        
            $o++;
        
            if ($resultSearch) {

                // $emp_salario_jornada = "$".number_format($salario_jornada_sql[$z],2);
                // $emp_total_diario = "$".number_format($total_diario_sql[$z], 2);

                $emp_salario_jornada = "$".bcdiv($salario_jornada_sql[$z], 1, 2); 
                $emp_total_diario = "$".bcdiv($total_diario_sql[$z], 1, 2);

                // datos 
                $pdf->Cell(20,4,'Hourly',0,0,'C');
                $pdf->Cell(20,4,$value,0,0,'C');
                $pdf->Cell(20,4,$dia_fecha[2],0,0,'C');
                $pdf->Cell(20,4,'',0,0,'C');
                $pdf->Cell(20,4,'',0,0,'C');

                $pdf->Cell(20,4,$descanso_entrada_sql[$z],0,0,'C');
                $pdf->Cell(20,4,$descanso_salida_sql[$z],0,0,'C');

                $pdf->Cell(20,4,$descanso_entrada_second_sql[$z],0,0,'C');
                $pdf->Cell(20,4,$descanso_salida_second_sql[$z],0,0,'C');

                $pdf->Cell(20,4,$hora_entrada_sql[$z],0,0,'C');
                $pdf->Cell(20,4,$hora_salida_sql[$z],0,0,'C');

                $pdf->Cell(20,4, bcdiv($horas_sql[$z], 1, 2) ,0,0,'C');
                $pdf->Cell(20,4,$emp_salario_jornada,0,0,'C');
                $pdf->Cell(20,4,$emp_total_diario,0,1,'C');
                
                
                
                
                
                $z++;

            }else{    
                $pdf->Cell(20,4,'Hourly',0,0,'C');
                $pdf->Cell(20,4,$value,0,0,'C');
                $pdf->Cell(20,4,$dia_fecha[2],0,0,'C');
                $pdf->Cell(20,4,'',0,0,'C');
                $pdf->Cell(20,4,'',0,0,'C');

                $pdf->Cell(20,4,'',0,0,'C');
                $pdf->Cell(20,4,'',0,0,'C');

                $pdf->Cell(20,4,'',0,0,'C');
                $pdf->Cell(20,4,'',0,0,'C');

                $pdf->Cell(20,4,'',0,0,'C');
                $pdf->Cell(20,4,'',0,0,'C');

                $pdf->Cell(20,4,'0.00',0,0,'C');
                $pdf->Cell(20,4,'$0.00',0,0,'C');
                $pdf->Cell(20,4,'$0.00',0,1,'C');
            }
            
        // Fin datos 

        endforeach;	    


        $pdf->Cell(210,4,'',0,0,'C');
        $pdf->Cell(48,4,'Total Current Amount:',0,0,'C');
        // $pdf->Cell(20,4,'$'.$totalContar,0,1,'C');
        $pdf->Cell(20,4,'$'.bcdiv($totalContar, 1, 2),0,1,'C');


        $pdf->Cell(20,4,'Total Hours',0,0,'C');
        $pdf->Cell(20,4,bcdiv($horaJornada, 1, 2),0,0,'C');
        $pdf->Cell(20,4,'T AMT',0,0,'C');
        $pdf->Cell(40,4,bcdiv($totalContar, 1, 2),0,0,'C');

        $pdf->Cell(40,4,'Total YTD Hours',0,0,'C');
        $pdf->Cell(20,4,bcdiv($horaContar, 1, 2),0,0,'C');
        
        $pdf->Cell(47,4,'',0,0,'C');

        $pdf->Cell(50,4,'Total YTD Amount:',0,0,'C');
        $pdf->Cell(20,4,'$'.bcdiv($totalGeneral, 1, 2),0,1,'C');


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
        $pdf->Cell(20,6,'$'.bcdiv($PRstate_semanal, 1, 2),0,0,'C');
        $pdf->Cell(20,6,'$'.bcdiv($PRstate_semanal, 1, 2),0,1,'C');

        $pdf->Cell(20,6,'Commision',0,0,'C');
        $pdf->Cell(20,6,'',0,0,'C');
        $pdf->Cell(20,6,'',0,0,'C');
        $pdf->Cell(20,6,'$'.bcdiv($comision, 1, 2),0,0,'C');
        $pdf->Cell(20,6,'$'.bcdiv($comision, 1, 2),0,1,'C');

        $pdf->Cell(26,6,'Bonus christmas',0,0,'C');
        $pdf->Cell(20,6,'',0,0,'C');
        $pdf->Cell(14,6,'',0,0,'C');
        $pdf->Cell(20,6,'$'.bcdiv($bono, 1, 2),0,0,'C');
        $pdf->Cell(20,6,'$'.bcdiv($bono, 1, 2),0,1,'C');


        $pdf->Cell(20,6,'',0,0,'C');
        $pdf->Cell(20,6,'Total Taxes',0,0,'C');
        $pdf->Cell(20,6,'',0,0,'C');
        $pdf->Cell(20,6,'$'.bcdiv($PRstate, 1, 2),0,0,'C');
        $pdf->Cell(20,6,'$'.bcdiv($retencion, 1, 2),0,1,'C');


        $pdf->Cell(30,6,'Direct Deposists',0,0,'C');
        $pdf->Cell(20,6,'ABA No.',0,0,'C');
        $pdf->Cell(20,6,'Acc No.',0,0,'C');
        $pdf->Cell(10,6,'',0,0,'C');
        $pdf->Cell(20,6,'Amount',0,1,'C');

        $total_suma_comision = $DDAmount + $comision + $bono;

        $pdf->Cell(30,4,'',0,0,'C');
        $pdf->Cell(20,4,$empleado->nro_ruta,0,0,'C');
        $pdf->Cell(20,4,$cuenta_bancaria,0,0,'C');
        $pdf->Cell(10,4,'',0,0,'C');
        $pdf->Cell(20,4,'$'.bcdiv($total_suma_comision, 1, 2),0,1,'C');
        // $pdf->Cell(20,4,'$'.bcdiv($DDAmount, 1, 2),0,1,'C');


        $pdf->Cell(20,4,'',0,0,'C');
        $pdf->Cell(40,4,'Total Direct Deposit',0,0,'C');
        $pdf->Cell(20,4,'',0,0,'C');
        $pdf->Cell(20,4,'$'.bcdiv($total_suma_comision, 1, 2),0,1,'C');
        // $pdf->Cell(20,4,'$'.bcdiv($DDAmount, 1, 2),0,1,'C');


        $pdf->Cell(20,4,'Net Pay',0,0,'C');
        $pdf->Cell(20,4,'',0,0,'C');
        $pdf->Cell(20,4,'',0,0,'C');
        $pdf->Cell(20,4,'',0,0,'C');
        
        $pdf->Cell(20,4,'$'.bcdiv($total_suma_comision, 1, 2),0,1,'C');

        
        $pdf->Output('I','reporte-jornada.pdf');
        exit;



    }else{
        $pdf->SetFont( 'Arial', '', 32 );
        $pdf->Cell(50,4,'',0,1,'C');
        $pdf->Cell(50,4,'',0,1,'C');
        $pdf->Cell(50,4,'',0,1,'C');
        $pdf->Cell(50,4,'',0,1,'C');
        $pdf->Cell(120,4,'',0,0,'C');
        $pdf->Cell(50,4,utf8_decode('No hay Resultados'),0,1,'C');
        $pdf->Output('I','reporte-jornada.pdf');
        exit;
    
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
      $redondear = $minutos;
      // $redondear = round($minutos, 2);
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