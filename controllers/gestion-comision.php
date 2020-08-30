<?php 

if ( ! defined( 'ABSPATH' ) ) exit; 

global $wpdb;

global $guardado_empleado;


if(isset($_POST['registrar_comision'])){

	$data = [
			"id_comision"   => 0,
      "id_empleado"   => $_POST["comision_nombres"],
      "total"         => $_POST["comision_total"],
      "fecha"         => $_POST["comision_fecha"],
			"estatus" 		  => $_POST["comision_estatus"]
	];

	$guardar = $wpdb->insert(
      TABLA_COMISION, 
      $data
  );

  $guardado_empleado = 0;

  if($guardar){

    $guardado_empleado = 1;

  }else{

	  $guardado_empleado = 2;

  }

}else if(isset($_POST['editar_comision'])){
  
  $data = [
      "id_empleado"   => $_POST["comision_nombres"],
      "total"         => $_POST["comision_total"],
      "fecha"         => $_POST["comision_fecha"],
      "estatus"       => $_POST["comision_estatus"]
  ];


  $guardar = $wpdb->update(
          TABLA_COMISION, 
          $data,
          array( 'id_comision' => $_POST["id_comision"] )
      );

  $guardado_empleado = 0;

  if($guardar){

    $guardado_empleado = 1;

  }else{

    $guardado_empleado = 2;

  }

}else if(isset($_POST['eliminar_comision'])){

  $guardar = $wpdb->delete( TABLA_COMISION, 
      array( 'id_comision' => $_POST['id_comision']) );

  $guardado_empleado = 0;

  if($guardar){

    $guardado_empleado = 1;

  }else{

    $guardado_empleado = 2;

  }

}









?> 