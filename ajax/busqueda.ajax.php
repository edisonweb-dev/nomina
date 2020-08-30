<?php 

global $wpdb;

if(isset($_POST["eliminar_empleado"])){

	$wpdb->delete( TABLA_EMPLEADOS, 
      array( 'id_empleado' => $_POST['id_empleado']) );

}else if(isset($_POST["eliminar_salario"])){

	$data = [
		"fecha_inicial" => 0,
		"fecha_final" 	=> 0,
		"salario" 			=> 0,
		"estatus" 			=> 0
	];

	$wpdb->update(
		TABLA_SALARIO, 
		$data,
		array( 'id_empleado' => $_POST["id_empleado_salario"] )
	);

}else if(isset($_POST["eliminar_overtime"])){

	$data = [
		"id_empleado" => 0,
		"salario_hora_extra" => 0,
		"fecha"       => 0,
		"estatus" 		=> 0
	];
	
	$wpdb->update(
		TABLA_HORA_EXTRA, 
		$data,
		array( 'id_empleado' => $_POST["id_empleado"] )
	);


}else if(isset($_POST["eliminar_jornada"])){

	$wpdb->delete( TABLA_JORNADA_DIARIA, 
    array( 'id_jornada_diaria' => $_POST['id_jornada']) );

}else if(isset($_POST["eliminar_comision"])){

	$wpdb->delete( TABLA_COMISION, 
    array( 'id_comision' => $_POST['id_comision']) );

}else if(isset($_POST["eliminar_bonoNavidad"])){

	$wpdb->delete( TABLA_BONO_NAVIDAD, 
    array( 'id_bono_navidad' => $_POST['id_bono_navidad']) );

}else if(isset($_POST["eliminar_usuarios"])){

	$wpdb->delete( TABLA_USUARIOS, 
    array( 'ID' => $_POST['id_usuario_form']) );

}else if( isset($_POST["busqueda_salario"])){

	$empleado_salario = $wpdb->get_row( " 
				SELECT * 
				FROM ".TABLA_SALARIO." as salario
				WHERE salario.id_empleado = ".$_POST["id_empleado_salario"]."
	");

	echo json_encode($empleado_salario);

}else if( isset($_POST["busqueda_overtime"]) ){

	$empleado_overtime = $wpdb->get_row( " 
				SELECT * 
				FROM ".TABLA_HORA_EXTRA." as horaextra
				LEFT JOIN ".TABLA_EMPLEADOS." as empleado ON empleado.id_empleado = horaextra.id_empleado
				WHERE horaextra.id_empleado = ".$_POST["id_empleado_salario"]."
	");

	echo json_encode($empleado_overtime);


}


	



 ?>