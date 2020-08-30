<?php

    $pdf = new PDF_HTML('P','mm','A4');

    global $wpdb;

    $emp = $wpdb->get_row("
            SELECT *
            FROM ".TABLA_EMPLEADOS." as emp
            WHERE emp.id_empleado = ".$_POST["ingreso_id_empleado"]." 
    ");

    $consulta = 0;

    $consulta = $wpdb->get_results("
          SELECT *
          FROM ".TABLA_JORNADA_DIARIA." as diario
          LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = diario.id_empleado
          LEFT JOIN ".TABLA_ESTADO." as estado ON estado.id_estado = diario.estatus
          WHERE YEAR(diario.fecha) = ".$_POST["ingreso_fecha_anual"]."
          ORDER BY diario.fecha DESC
    ");
    
    
    $retencion_total = 0;
    $ingreso_bruto_total = 0;
    $ingreso_neto_total = 0;
    $ingreso_pagos_total = 0;

    $i = 1;  
    $contar_hora = 0;  
    $contar_minutos = 0;

    $horas_calculo = array();

    //*****************Comienzo del PDF *********************************

    global $pdf;
    $title_line_height = 10;
    $content_line_height = 8;

    $pdf->AddPage();
    $pdf->SetFont( 'Arial', '', 12 );
    
    $pdf->Line(60, 14, 150, 14);

    $pdf->Line(10, 26, 190, 26);
    $pdf->Line(10, 32, 190, 32);

    $pdf->Cell(180,4,utf8_decode('Massive Annual Earnings Report'),0,1,'C');
    $pdf->Cell(60,4,'',0,1,'C');
    $pdf->Cell(60,4,'',0,1,'C');

    // $emp_sql_nombre = $emp->nombres.' '.$emp->apellidos;
    // $pdf->Cell(20,4,utf8_decode('Nombre'),0,0,'C');
    // $pdf->Cell(60,4,utf8_decode($emp_sql_nombre),0,1,'C');

    // $pdf->Cell(22,4,utf8_decode('Dirección'),0,0,'C');
    // $pdf->Cell(60,4,utf8_decode($emp->direccion),0,1,'C');

    // $pdf->Cell(15,4,utf8_decode('Email'),0,0,'C');
    // $pdf->Cell(76,4,utf8_decode($emp->email),0,1,'C');

    // $pdf->Cell(20,4,utf8_decode('Teléfono'),0,0,'C');
    // $pdf->Cell(70,4,utf8_decode($emp->telefono),0,1,'C');

    $pdf->Cell(60,4,'',0,1,'C');
    
    $pdf->Cell(20,6,utf8_decode('#'),0,0,'C');    
    $pdf->Cell(40,6,utf8_decode('Names'),0,0,'C');    
    $pdf->Cell(40,6,utf8_decode('Date'),0,0,'C');    
    $pdf->Cell(40,6,utf8_decode('Hours'),0,0,'C');    
    $pdf->Cell(40,6,utf8_decode('Income'),0,1,'C');    
    $pdf->Cell(60,2,'',0,1,'C');

    // calculos 
    
    foreach ($consulta as $key => $value):

        $emp_nombres = $value->nombres.' '.$value->apellidos;
        $ingreso_bruto_total += $value->total;

        $pdf->Cell(20,6,utf8_decode($i++),0,0,'C');    
        $pdf->Cell(40,6,utf8_decode($emp_nombres),0,0,'C');    
        $pdf->Cell(40,6,utf8_decode($value->fecha),0,0,'C');    
        $pdf->Cell(40,6,utf8_decode($value->horas),0,0,'C');    
        $pdf->Cell(40,6,'$'.utf8_decode($value->total),0,1,'C');  

    endforeach;    
        
        $linea_total = 30 + (6 * $i);

        $pdf->Line(10, $linea_total, 190, $linea_total);

        $pdf->Cell(60,4,'',0,1,'C');

        $pdf->Cell(20,4,'',0,0,'C');    
        $pdf->Cell(40,4,'',0,0,'C');    
        $pdf->Cell(40,4,'',0,0,'C');    
        $pdf->Cell(40,4,'Total',0,0,'C');    
        $pdf->Cell(40,4,'$'.utf8_decode($ingreso_bruto_total),0,1,'C');  
    
        $pdf->Output('I','fpdf_tutorial.pdf');
    exit;

?>