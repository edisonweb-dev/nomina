<?php



if ( ! defined( 'ABSPATH' ) ) exit; 



global $wpdb;

global $guardado_empleado;

/* Guardar datos del empleado */



if(isset($_POST['guardar_nuevo_empleado'])){



$explode = explode(" ", get_upload_file_url_id_file());



$data = [

    "id_empleado" => 0,

    'foto'       => $explode[0],

    'id_foto'    => $explode[1],

    'nombres'    => $_POST['nombres'],

    'apellidos'  => $_POST['apellidos'],

    'direccion'  => $_POST['direccion'],

    'cod_postal' => $_POST['cod_postal'],

    'email'      => $_POST['email'],

    'fecha_nac'  => $_POST['fecha_nac'],

    'nro_empleado' => $_POST['nro_empleado'],

    'nro_seguro_social' => $_POST['nro_seguro_social'],

    'fecha_comienzo' => $_POST['fecha_comienzo'],

    'nro_ruta' => $_POST['nro_ruta'],

    'nro_cuenta' => $_POST['nro_cuenta'],

    'nro_licencia_motor' => $_POST['nro_licencia_motor'],

    'nro_licencia_electricista' => $_POST['nro_licencia_electricista'],

    'nro_telefono' => $_POST['nro_telefono'],

    'modificado' => date("Y-m-d"),

    'modificado_por' => get_current_user_id(),

    'salario' => $_POST['nro_salario']

];



    $guardar = $wpdb->insert(
        TABLA_EMPLEADOS,
        $data
    );

    $id_empleado = $wpdb->insert_id;   
    

$guardado_empleado = 0;

if($guardar){


$data2 = [

    'id_empleado'   => $id_empleado,

    'fecha_inicial' => 0,

    'fecha_final'   => 0,

    'salario'       => $_POST['nro_salario'],

    'estatus'       => 0
];    
$wpdb->insert(TABLA_SALARIO, $data2);



$data3 = [
    'id_hora_extra' => 0,
    'id_empleado'   => $id_empleado,
    'salario_hora_extra' =>  $_POST['nro_salario'],
    'estatus'       => 0
];
$wpdb->insert(TABLA_HORA_EXTRA, $data3);

$data4 = [
    'id_gestion_hora' => 0,
    'id_empleado'     => $id_empleado,
    'hora_suma'       => 0,
    'hora_resta'      => 0,
    'estatus'         => 0       
];
$wpdb->insert(TABLA_GESTION_HORA, $data4);


$data5 = [
    'id_jornada_diaria' => 0,
    'id_empleado'     => $id_empleado,
    'fecha'           => date('Y-m-d'),
    'hora_entrada'    => 0,
    'hora_salida'     => 0,
    'hora_descanso'   => 0,
    'estatus'         => 0       
];
$wpdb->insert(TABLA_JORNADA_DIARIA, $data5);


$guardado_empleado = 1;

}else{

$guardado_empleado = 2;

}



}



if(isset($_POST['actualizar_empleado'])){

    


    $explode = array();

    if ($_FILES['foto']['name'] != null) {
        $explode = explode(" ", get_upload_file_url_id_file());
        wp_delete_attachment($_POST['id_foto_actual'], true); 
    }else{
        $explode[0] = $_POST['url_foto_actual'];
        $explode[1] = $_POST['id_foto_actual'];
    }



    $data = [

        'foto'       => $explode[0],

        'id_foto'    => $explode[1],

        'nombres'    => $_POST['nombres'],

        'apellidos'  => $_POST['apellidos'],

        'direccion'  => $_POST['direccion'],

        'cod_postal' => $_POST['cod_postal'],

        'email'      => $_POST['email'],

        'fecha_nac'  => $_POST['fecha_nac'],

        'nro_empleado' => $_POST['nro_empleado'],

        'nro_seguro_social' => $_POST['nro_seguro_social'],

        'fecha_comienzo' => $_POST['fecha_comienzo'],

        'nro_ruta' => $_POST['nro_ruta'],

        'nro_cuenta' => $_POST['nro_cuenta'],

        'nro_licencia_motor' => $_POST['nro_licencia_motor'],

        'nro_licencia_electricista' => $_POST['nro_licencia_electricista'],

        'nro_telefono' => $_POST['nro_telefono'],

        'modificado' => date("Y-m-d"),

        'modificado_por' => get_current_user_id()

    ];

    

    $guardar = $wpdb->update(
                TABLA_EMPLEADOS, 
                $data,
                array( 'id_empleado' => $_POST["id_empleadoD"] )
            );

    

    $guardado_empleado = 0;

    if($guardar){

    

    $guardado_empleado = 1;

    }else{

    $guardado_empleado = 2;

    }

    

}





if(isset($_POST['envio_subir_documentos'])){

 $explode = explode(" ", get_upload_file_url_id_file());
                    
$data = [

    'id_empleado'      => $_POST['id_empleado'],

    'id_documentos'    => $explode[1],

    'nombre_documento' => $_POST['nombre_documento'],

    'link_documento'   => $explode[0]

];

$guardar = $wpdb->insert(TABLA_DOCUMENTOS, $data);

                
       
        

    

    if($guardar){

    $guardado_empleado = 1;

    }else{

    $guardado_empleado = 2;

    }
    // var_dump($guardar);
    // var_dump($guardado_empleado);
    

}









if(isset($_POST['eliminar_documento'])){



    include_once(ABSPATH . 'wp-includes/post.php');



    $borrar = wp_delete_attachment($_POST['eliminar_documento'], true); 



    $guardado_empleado = 0;

    if($borrar){



    $wpdb->delete( TABLA_DOCUMENTOS, array( 'id_documento' => $_POST['eliminar_documento_id']) );



    $guardado_empleado = 1;

    }else{

    $guardado_empleado = 2;

    }

    

}




if(isset($_POST['envio_actualizar_salario'])){


    $data = [
        'salario'    => $_POST['costo_hora']
    ];

    $wpdb->update(
        TABLA_EMPLEADOS,
        $data,
        array( 'id_empleado' => $_POST["id_empleado"] )
    );

}


if(isset($_POST['eliminar_empleados'])){

    $guardar = $wpdb->delete( TABLA_EMPLEADOS, 
      array( 'id_empleado' => $_POST['id_empleados']) );

    $guardado_empleado = 0;

    if($guardar){

        $guardado_empleado = 1;

    }else{

        $guardado_empleado = 2;

    }

}







function subirArchivos($files){
    
    // require_once(ABSPATH . 'wp-includes/pluggable.php');
    // require_once ABSPATH . "wp-admin" . '/includes/image.php';
    // require_once ABSPATH . "wp-admin" . '/includes/file.php';
    // require_once ABSPATH . "wp-admin" . '/includes/media.php';


    // $i=0;
    // foreach ($files as $file => $array) {
        // $attachment_id = media_handle_upload($file, 0);
        // echo $attachment_id;
    // }
    
    // $attachment_url = wp_get_attachment_url( $attachment_id );
    // return  $attachment_url;


}




function my_handle_attachment($file_handler,$post_id,$set_thu=false) {
    // check to make sure its a successful upload
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
    
    require_once(ABSPATH . 'wp-includes/pluggable.php');
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
  
    $attach_id = media_handle_upload( $file_handler, $post_id );
    if ( is_numeric( $attach_id ) ) {
      update_post_meta( $post_id, '_my_file_upload', $attach_id );
    }
    $attachment_url = wp_get_attachment_url( $attach_id );
    
    $data = array(
        0 => $attachment_url, 
        1 => $attach_id 
    );

    return $data;
}

