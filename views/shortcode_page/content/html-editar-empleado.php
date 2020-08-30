<?php

global $wpdb;
global $guardado_empleado;

$obtener_empleado = $wpdb->get_row("SELECT * FROM " . TABLA_EMPLEADOS . " where id_empleado = " .$_GET['gestionar-empleado']. "");

?>

<div class="container-fluid">

<div class="row">

<div class="col-md-12">

<a href="<?php echo get_site_url(); ?>/gestion-empleados" class="btn btn-outline-info"><i class="fa fa-list"></i> Go Back</a>

</div>

</div>

</div>

<br>

<?php 

if($guardado_empleado == 1):

?>

<div class="container">

<div class="row">

<div class="col-md-12">

<div class="alert alert-success" role="alert">

  Registered successfully

</div>

</div>

</div>

</div>

<?php 

elseif($guardado_empleado == 2):

?>

<div class="container">

<div class="row">

<div class="col-md-12">

<div class="alert alert-danger" role="alert">

  Registration Error

</div>

</div>

</div>

</div>

<?php 

else:

endif;

?>

<br>

<div class="container">

<div class="row">

<div class="col-md-12">

    <p class="text-right foto-abosolute">

    <img src="<?php echo $obtener_empleado->foto; ?>" alt="" class="foto-empleado-perfil"> 

    </p>

<form action="" class="box-new-user" method="POST" enctype="multipart/form-data">

<?php

$data = [

'fecha_desde' =>  '2019-08-11'

];

//echo "Mes: " . obtener_meses($data) . " Dia: " . obtener_dias($data) ;

?>

<div class="container">

<div class="row">

 <div class="col-md-12">

 <h5>Modify Personal Data</h5>

 <hr>

 </div>

</div>

<div class="container">

<div class="row">

 <div class="col-md-6">   

 <div class="form-group">

 <label for="">Photo</label>



  <input type="file" class="form-control" id="customFileLang" name="foto" lang="es" data-browse="Seleccione">

  <input type="hidden" name="url_foto_actual" value="<?php echo $obtener_empleado->foto; ?>">
  <input type="hidden" name="id_foto_actual" value="<?php echo $obtener_empleado->id_foto; ?>">

</div>

 </div>

</div>



<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Names</label>

 <input type="text" class="form-control" name="nombres" value="<?php echo $obtener_empleado->nombres; ?>" placeholder="Names">

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Last Name</label>

 <input type="text" class="form-control" name="apellidos" value="<?php echo $obtener_empleado->apellidos; ?>" placeholder="Surnames">

 </div>

 </div>

</div>



<div class="row">

 <div class="col-md-9">

 <div class="form-group">

 <label for="">Address</label>

 <input type="text" class="form-control" name="direccion" value="<?php echo $obtener_empleado->direccion; ?>" placeholder="Address">

 </div>

 </div>

 <div class="col-md-3">

 <div class="form-group">

 <label for="">Code Postal</label>

 <input type="text" class="form-control" name="cod_postal" value="<?php echo $obtener_empleado->cod_postal; ?>" placeholder="Code Postal">

 </div>

 </div>

</div>



<div class="row">

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Email</label>

 <input type="email" class="form-control" name="email" value="<?php echo $obtener_empleado->email; ?>" placeholder="Email">

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Date of Birth</label>

 <input type="date" class="form-control" name="fecha_nac" value="<?php echo $obtener_empleado->fecha_nac; ?>" placeholder="Date of Birth">

 </div>

 </div>

</div>



<div class="row">

 <div class="col-md-4">

 <div class="form-group">

 <label for="">Employed Number</label>

 <input type="text" class="form-control" name="nro_empleado" value="<?php echo $obtener_empleado->nro_empleado; ?>" placeholder="Employed Number">

 </div>

 </div>

 <div class="col-md-4">

 <div class="form-group">

 <label for="">Social Security Number</label>

 <input type="text" class="form-control" name="nro_seguro_social" value="<?php echo $obtener_empleado->nro_seguro_social; ?>" placeholder="772 99 9999" title="Use The Format 772 99 9999" id="seguroSocial">

 </div>

 </div>

 <div class="col-md-4">

 <div class="form-group">

 <label for="">Work Start Date</label>

 <input type="date" class="form-control" name="fecha_comienzo" value="<?php echo $obtener_empleado->fecha_comienzo; ?>" placeholder="Work Start Date">

 </div>

 </div>

</div>



<div class="row">

 <div class="col-md-4">

 <div class="form-group">

 <label for="">Route Number</label>

 <input type="text" class="form-control" name="nro_ruta" value="<?php echo $obtener_empleado->nro_ruta; ?>" placeholder="Route Number">

 </div>

 </div>

 <div class="col-md-8">

 <div class="form-group">

 <label for="">Account Bank Number</label>

 <input type="text" class="form-control" name="nro_cuenta" value="<?php echo $obtener_empleado->nro_cuenta; ?>" placeholder="Account Bank Number">

 </div>

 </div>

</div>



<div class="row">

 <div class="col-md-4">

 <div class="form-group">

 <label for="">Driver License Number</label>

 <input type="text" class="form-control" name="nro_licencia_motor" value="<?php echo $obtener_empleado->nro_licencia_motor; ?>" placeholder="Engine license number">

 </div>

 </div>

 <div class="col-md-4">

 <div class="form-group">

 <label for="">Electrician License Number</label>

 <input type="text" class="form-control" name="nro_licencia_electricista" value="<?php echo $obtener_empleado->nro_licencia_electricista; ?>" placeholder="Electrician License Number">

 </div>

 </div>

 <div class="col-md-4">

 <div class="form-group">

 <label for="">Phone Number</label>

 <input type="text" class="form-control" name="nro_telefono" value="<?php echo $obtener_empleado->nro_telefono; ?>" pattern="^[0-9]{3}[-][0-9]{3}[-][0-9]{4}$" title="Utiliza el formato 000-000-0000" placeholder="000-000-0000" id="validarTelefono">

 </div>

 </div>

</div>



<div class="row">

 <div class="col-md-6">

 <div class="form-group">
    <input type="hidden" name="id_empleadoD" value="<?php echo $obtener_empleado->id_empleado; ?>">
    <button class="btn btn-success btn-block" name="actualizar_empleado"><i class="fa fa-save"></i> Modify</button>

</div>

 </div>

</div>



</div>

</form>

</div>

</div><!-- Fin Row -->

</div>

</div>

<br>

<!--  SALARIO    -->

<div class="container">

<div class="row">

<div class="col-md-12">



<form action="" class="box-new-user" method="POST" enctype="multipart/form-data">

<?php

$data = [

'fecha_desde' =>  '2019-08-11'

];

//echo "Mes: " . obtener_meses($data) . " Dia: " . obtener_dias($data) ;

?>

<div class="container">

<div class="row">

 <div class="col-md-12">

 <h5>Modify Salary</h5>

 <hr>

 </div>

</div>

</div>





<div class="container">



<div class="row">

<div class="col-md-12">

<h6>Current Employed Salary</h6>

<div class="alert alert-primary" role="alert">

  The current value of the employee's time: $ <?php echo $obtener_empleado->salario; ?>

</div>

</div>

</div>





<div class="row">

 
 <div class="col-md-4">

   <div class="form-group">

   <label for="">Hour value</label>

   <input type="number" step="0.01" class="form-control" name="costo_hora" value="<?php echo $obtener_empleado->salario; ?>" pattern="^[0-9]+(\\.[0-9]{2})?$" placeholder="Hour Value">

   </div>

 </div>

</div>



<div class="row">

 <div class="col-md-6">

 <div class="form-group">
  <input type="hidden" name="id_empleado" value="<?php echo $obtener_empleado->id_empleado; ?>">
  <button class="btn btn-success btn-block" name="envio_actualizar_salario"><i class="fa fa-save"></i> Update salary</button>

</div>

 </div>

</div>





</div>

</form>



</div>

</div>

</div>

<br>

<!-- Documentos-->

<div class="container">

<div class="row">

<div class="col-md-12">



<form action="" class="box-new-user" method="POST" enctype="multipart/form-data" id="subirDocumentos">

<?php

$data = [

'fecha_desde' =>  '2019-08-11'

];

//echo "Mes: " . obtener_meses($data) . " Dia: " . obtener_dias($data) ;

?>



<div class="container">

<div class="row">

<div class="col-md-12">

<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2"><i class="fa fa-file"></i> Documents</button>

</div>

 </div>

</div>



<div class="row">

<div class="col">

<div class="collapse multi-collapse" id="multiCollapseExample2">

<br><br>



<div class="container">

<div class="row">

<div class="col-md-6">

 <div class="form-group">

 <label for="">File Name</label>

 <input type="hidden" name="id_empleado" value="<?php echo $obtener_empleado->id_empleado; ?>">

 <input type="text" class="form-control" name="nombre_documento">

 <small>Name to Identify</small>

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

 <label for="">Upload the Documents:</label>

 <input type="hidden" name="id_empleado" value="<?php echo $obtener_empleado->id_empleado; ?>">

 <input type="file" class="form-control" name="documento_empleado">

 <small>Here it is established from when the salary begins to be paid</small>

 </div>

 </div>

 <div class="col-md-6">

 <div class="form-group">

<button class="btn btn-success btn-block" type="submit" name="envio_subir_documentos"><i class="fa fa-file"></i> Upload documents</button>

</div>

</div>

</div>



<div class="row">

<?php

  $obtener_documentos = $wpdb->get_results("SELECT * FROM " . TABLA_DOCUMENTOS . " where id_empleado = " .$_GET['gestionar-empleado']. "");



  if(!$obtener_documentos):

?>

 <div class="col-md-12">

    <div class="alert alert-warning" role="alert">

      No documents uploaded

    </div>

 </div>

<?php

else:

foreach ($obtener_documentos as $key => $documento):   

?>



<div class="col-md-4 py-2">

        <div class="card text-center">

          <p class="pt-3"><i class="fa fa-file" style="font-size:48px;"></i></p>

          <div class="card-body">

            <h5 class="card-title"><a href="<?php echo $documento->link_documento; ?>" target="_blank"><?php echo $documento->nombre_documento; ?></a></h5>

            <p class="card-text">

            <div class="container">

              <div class="row">

                <div class="col-md-6">

                <a href="<?php echo $documento->link_documento; ?>"  target="_blank" class="btn btn-success btn-block text-white"><i class="fa fa-download"></i></a>

                </div>

                <div class="col-md-6">

                <form action="" method="POST">

                <input type="hidden" name="eliminar_documento_id" value="<?php echo $documento->id_documento; ?>">

                <input type="hidden" name="eliminar_documento" value="<?php echo $documento->id_documentos; ?>">

                <button type="submit" class="btn btn-danger btn-block">X</button>

                </form>

                </div>

              </div>

            </div>



            </p>

          </div>

        </div>

        



</div>



<?php 

endforeach;

endif; 

?>

</div>

</div>

    </div>

  </div>

</div>



 



</form>



</div>

</div>

</div>

<br><br>







