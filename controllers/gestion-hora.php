<?php 

if ( ! defined( 'ABSPATH' ) ) exit; 

global $wpdb;

global $guardado_empleado;


if(isset($_POST['actualizar_gestion_hora_editar'])){

	$data = [
			"hora_suma"     => $_POST["gestionHora_suma"],
      "hora_resta"    => $_POST["gestionHora_resta"],
      "fecha_desde"   => $_POST["gestionHora_fecha_inicial"],
      "fecha_hasta"   => $_POST["gestionHora_fecha_final"],
			"estatus" 		  => $_POST["gestionHora_estatus"]
	];

	$guardar = $wpdb->update(
          TABLA_GESTION_HORA, 
          $data,
          array( 'id_empleado' => $_POST["id_empleado"] )
      );

  $guardado_empleado = 0;

  if($guardar){

    $guardado_empleado = 1;

  }else{

	  $guardado_empleado = 2;

  }

}else if(isset($_POST['actualizar_gestion_hora_eliminar'])){

  $data = [
      "hora_suma"     => 0,
      "hora_resta"    => 0,
      "fecha_desde"   => 0,
      "fecha_hasta"   => 0,
      "estatus" 		  => 0
  ];

  $guardar = $wpdb->update(
          TABLA_GESTION_HORA, 
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









?> 