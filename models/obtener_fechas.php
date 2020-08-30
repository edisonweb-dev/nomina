<?php

if ( ! defined( 'ABSPATH' ) ) exit; 

function  obtener_anios($data){

    $fecha1 = new DateTime($data['fecha_desde']);
    $fecha2 = new DateTime(date("Y-m-d"));
    $resultado = $fecha1->diff($fecha2);
    return $resultado->format('%y');
    
}

function  obtener_meses($data){

    $fecha1 = new DateTime($data['fecha_desde']);
    $fecha2 = new DateTime(date("Y-m-d"));
    $resultado = $fecha1->diff($fecha2);
    return $resultado->format('%m');
    
}

function obtener_dias($data) {

    $fecha1 = new DateTime($data['fecha_desde']);
    $fecha2 = new DateTime(date("Y-m-d"));
    $resultado = $fecha1->diff($fecha2);
    return $resultado->format('%d');

}