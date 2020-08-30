<?php 

if ( ! defined( 'ABSPATH' ) ) exit; 

global $wpdb;

global $guardado_empleado;


if(isset($_POST['actualizar_salario_temporal_registro'])){

	$data = [
			"fecha_inicial" => $_POST["salario_fechai"],
			"fecha_final" 	=> $_POST["salario_fechaf"],
			"salario" 			=> $_POST["salario_salariof"],
			"estatus" 			=> $_POST["salario_estatus"]
	];

	$guardar = $wpdb->update(
          TABLA_SALARIO, 
          $data,
          array( 'id_empleado' => $_POST["id_empleado"] )
      );

  $guardado_empleado = 0;

  if($guardar){

    $guardado_empleado = 1;  

    include_once(ABSPATH . 'wp-includes/pluggable.php');
    
    $url_actual = home_url()."/gestion-salario/?editar-salario=".$_POST["id_empleado"]."&guardar=1"; 

    wp_redirect( $url_actual );

    exit;

  }else{

	  $guardado_empleado = 2;

  }

}else if(isset($_POST['eliminar_usuarios_salario'])){
  

    $data = [
      "fecha_inicial" => 0,
      "fecha_final" 	=> 0,
      "salario" 			=> 0,
      "estatus" 			=> 0
    ];

  $guardar = $wpdb->update(
        TABLA_SALARIO, 
        $data,
        array( 'id_empleado' => $_POST["id_empleado_salario"] )
    );

  $guardado_empleado = 0;

  if($guardar){

    $guardado_empleado = 1;

  }else{

    $guardado_empleado = 2;

  }

}








?>