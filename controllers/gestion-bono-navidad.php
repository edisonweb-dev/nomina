<?php 

if ( ! defined( 'ABSPATH' ) ) exit; 

global $wpdb;

global $guardado_empleado;


if(isset($_POST['registrar_bono_navidad'])){

	$data = [
			"id_bono_navidad" => 0,
      "id_empleado"   => $_POST["bonoNavidad_nombres"],
      "total"         => $_POST["bonoNavidad_total"],
      "fecha"         => $_POST["bonoNavidad_fecha"],
			"estatus" 		  => $_POST["bonoNavidad_estatus"]
	];

	$guardar = $wpdb->insert(
      TABLA_BONO_NAVIDAD, 
      $data
  );

  $guardado_empleado = 0;

  if($guardar){

    $guardado_empleado = 1;

  }else{

	  $guardado_empleado = 2;

  }

}else if(isset($_POST['editar_bono_navidad'])){
  
  $data = [
      "id_empleado"   => $_POST["bonoNavidad_nombres"],
      "total"         => $_POST["bonoNavidad_total"],
      "fecha"         => $_POST["bonoNavidad_fecha"],
      "estatus"       => $_POST["bonoNavidad_estatus"]
  ];


  $guardar = $wpdb->update(
          TABLA_BONO_NAVIDAD, 
          $data,
          array( 'id_bono_navidad' => $_POST["id_bono_navidad"] )
      );

  $guardado_empleado = 0;

  if($guardar){

    $guardado_empleado = 1;

  }else{

    $guardado_empleado = 2;

  }

}else if(isset($_POST['eliminar_bono_navidad'])){

  $guardar = $wpdb->delete( TABLA_BONO_NAVIDAD, 
      array( 'id_bono_navidad' => $_POST['id_bono_navidad']) );

  $guardado_empleado = 0;

  if($guardar){

    $guardado_empleado = 1;

  }else{

    $guardado_empleado = 2;

  }  


}









?> 