<?php



function gn_database(){

    global $wpdb;

    global $gn_dbversion;

    $gn_dbversion = '0.1';

    $charset_collate = $wpdb->get_charset_collate();


    $sql_documentos = "CREATE TABLE " . TABLA_DOCUMENTOS . " (

        id_documento bigint(20) NOT NULL AUTO_INCREMENT,

        id_empleado int(20) NOT NULL,

        id_documentos int(20) NOT NULL,

        nombre_documento varchar(255) NOT NULL,

        link_documento longtext NOT NULL,

        PRIMARY KEY (id_documento)

    )$charset_collate;";

    

    $sql_empleados = "CREATE TABLE" . TABLA_EMPLEADOS ."(

        id_empleado bigint(20) NOT NULL AUTO_INCREMENT,

        foto longtext NOT NULL,

        id_foto int(20) NOT NULL,

        nombres longtext NOT NULL,

        apellidos longtext NOT NULL,

        direccion longtext NOT NULL,

        cod_postal varchar(255) NOT NULL,

        email varchar(255) NOT NULL,

        fecha_nac date NOT NULL,

        nro_empleado varchar(255) NOT NULL,

        nro_seguro_social varchar(255) NOT NULL,

        fecha_comienzo date NOT NULL,

        nro_ruta varchar(255) NOT NULL,

        nro_cuenta varchar(255) NOT NULL,

        nro_licencia_motor varchar(255) NOT NULL,

        nro_licencia_electricista varchar(255) NOT NULL,

        nro_telefono varchar(255) NOT NULL,

        modificado date NOT NULL,



        modificado_por int(20) NO NULL,

        PRIMARY KEY (id_empleado)

	) $charset_collate;";



    $table_name = TABLA_EMPLEADOS; 



    $sql = "CREATE TABLE $table_name (

        id_empleado mediumint(9) NOT NULL AUTO_INCREMENT,

        foto longtext NOT NULL,

        id_foto int(20) NOT NULL,

        nombres longtext NOT NULL,

        apellidos longtext NOT NULL,

        direccion longtext NOT NULL,

        cod_postal varchar(255) NOT NULL,

        email varchar(255) NOT NULL,

        fecha_nac date NOT NULL,

        nro_empleado varchar(255) NOT NULL,

        nro_seguro_social varchar(255) NOT NULL,

        fecha_comienzo date NOT NULL,

        nro_ruta varchar(255) NOT NULL,

        nro_cuenta varchar(255) NOT NULL,

        nro_licencia_motor varchar(255) NOT NULL,

        nro_licencia_electricista varchar(255) NOT NULL,

        nro_telefono varchar(255) NOT NULL,

        modificado date NOT NULL,

        modificado_por int(20) NOT NULL,

        PRIMARY KEY  (id_empleado)

      ) $charset_collate;";

    



    $sql_salario = "CREATE TABLE " . TABLA_SALARIO . " (

        id_salario_fecha bigint(20) NOT NULL AUTO_INCREMENT,

        id_empleado int(20) NOT NULL,

        fecha_inicial varchar(255) NOT NULL,

        fecha_final varchar(255) NOT NULL,

        salario varchar(255) NOT NULL,

        estatus int(20) NOT NULL,

        PRIMARY KEY (id_salario_fecha)

    )$charset_collate;";


    $sql_estados = "CREATE TABLE " . TABLA_ESTADO . " (

        id_estado bigint(20) NOT NULL,

        nombre varchar(255) NOT NULL,

        PRIMARY KEY (id_estado)

    )$charset_collate;";


    $sql_hora_extra = "CREATE TABLE " . TABLA_HORA_EXTRA . " (

        id_hora_extra bigint(20) NOT NULL AUTO_INCREMENT,

        id_empleado int(20) NOT NULL,

        salario_hora_extra varchar(255) NOT NULL,

        fecha varchar(255) NOT NULL,

        estatus int(20) NOT NULL,

        PRIMARY KEY (id_hora_extra)

    )$charset_collate;";


    $sql_gestion_hora = "CREATE TABLE " . TABLA_GESTION_HORA . " (

        id_gestion_hora bigint(20) NOT NULL AUTO_INCREMENT,

        id_empleado int(20) NOT NULL,

        hora_suma varchar(255) NOT NULL,

        hora_resta varchar(255) NOT NULL,

        fecha_desde varchar(255) NOT NULL,

        fecha_hasta varchar(255) NOT NULL,

        estatus int(20) NOT NULL,

        PRIMARY KEY (id_gestion_hora)

    )$charset_collate;";


    $sql_gestion_hora = "CREATE TABLE " . TABLA_DESCANSO . " (

        id_gestion_descanso bigint(20) NOT NULL AUTO_INCREMENT,

        id_empleado int(20) NOT NULL,

        lunes varchar(255) NOT NULL,

        martes varchar(255) NOT NULL,

        miercoles varchar(255) NOT NULL,

        jueves varchar(255) NOT NULL,

        viernes varchar(255) NOT NULL,

        sabado varchar(255) NOT NULL,

        domingo varchar(255) NOT NULL,

        estatus int(20) NOT NULL,

        PRIMARY KEY (id_gestion_descanso)

    )$charset_collate;";



    $sql_jornada_diaria = "CREATE TABLE " . TABLA_JORNADA_DIARIA . " (

        id_jornada_diaria bigint(20) NOT NULL AUTO_INCREMENT,

        id_empleado int(20) NOT NULL,

        fecha varchar(255) NOT NULL,

        hora_entrada varchar(255) NOT NULL,

        hora_salida varchar(255) NOT NULL,

        hora_descanso_entrada varchar(255) NOT NULL,

        hora_descanso_salida varchar(255) NOT NULL,

        hora_descanso_entrada_second varchar(255) NOT NULL,

        hora_descanso_salida_second varchar(255) NOT NULL,

        horas varchar(255) NOT NULL,

        total_sin_retencion varchar(255) NOT NULL,

        total varchar(255) NOT NULL,

        descanso varchar(255) NOT NULL,

        total_sin_descanso varchar(255) NOT NULL,

        salario_jornada varchar(255) NOT NULL,

        salario_jornada_normal varchar(255) NOT NULL,

        hora_suma varchar(255) NOT NULL,

        hora_resta varchar(255) NOT NULL,

        estatus int(20) NOT NULL,

        PRIMARY KEY (id_jornada_diaria)

    )$charset_collate;";


    $sql_gestion_bono_navidad = "CREATE TABLE " . TABLA_BONO_NAVIDAD . " (

        id_bono_navidad bigint(20) NOT NULL AUTO_INCREMENT,

        id_empleado int(20) NOT NULL,

        total varchar(255) NOT NULL,

        fecha varchar(255) NOT NULL,

        estatus int(20) NOT NULL,

        PRIMARY KEY (id_bono_navidad)

    )$charset_collate;";

    $sql_gestion_comision = "CREATE TABLE " . TABLA_COMISION . " (

        id_comision bigint(20) NOT NULL AUTO_INCREMENT,

        id_empleado int(20) NOT NULL,

        total varchar(255) NOT NULL,

        fecha varchar(255) NOT NULL,

        estatus int(20) NOT NULL,

        PRIMARY KEY (id_comision)

    )$charset_collate;";


    $sql_gestion_pago = "CREATE TABLE " . TABLA_PAGO . " (

        id_gestion_pago bigint(20) NOT NULL AUTO_INCREMENT,

        id_empleado int(20) NOT NULL,

        fecha varchar(255) NOT NULL,

        recibo varchar(255) NOT NULL,

        comision varchar(255) NOT NULL,

        bonoNavidad varchar(255) NOT NULL,

        horaExtra varchar(255) NOT NULL,

        totalJornada varchar(255) NOT NULL,

        totalGeneral varchar(255) NOT NULL,

        estatus int(20) NOT NULL,

        PRIMARY KEY (id_gestion_pago)

    )$charset_collate;";


    $sql_gestion_pago_registrado = "CREATE TABLE " . TABLA_PAGO_REGISTRADO . " (

        id_gestion_pago_registrado bigint(20) NOT NULL AUTO_INCREMENT,

        id_gestion_pago int(20) NOT NULL,

        id_empleado int(20) NOT NULL,

        id_jornada int(20) NOT NULL,

        fecha varchar(255) NOT NULL,

        recibo varchar(255) NOT NULL,

        estatus int(20) NOT NULL,

        PRIMARY KEY (id_gestion_pago_registrado)

    )$charset_collate;";



    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );


    dbDelta($sql_empleados);

    dbDelta($sql_documentos);

    dbDelta( $sql );

    dbDelta( $sql_salario );

    dbDelta( $sql_estados );

    dbDelta( $sql_hora_extra );

    dbDelta( $sql_gestion_hora );

    dbDelta( $sql_gestion_hora );

    dbDelta( $sql_jornada_diaria );

    dbDelta( $sql_gestion_bono_navidad );

    dbDelta( $sql_gestion_comision );

    dbDelta( $sql_gestion_pago );

    dbDelta( $sql_gestion_pago_registrado );



    add_option('gn_dbversion', $gn_dbversion);



}



add_action('init', 'gn_database');











