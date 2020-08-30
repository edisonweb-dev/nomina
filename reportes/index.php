<?php 

if( isset($_POST['pdf_reporte_semanal'])){

    include('reporte-jornada-semanal.php');

//****************** Reportes Ganancias**************************/        
}else if(isset($_POST['pdf_reporte_semanal_ganancia'])){

    include('ganancias/reporte-ganancia-semanal.php');

}else if(isset($_POST['pdf_reporte_mensual_ganancia'])){

    include('ganancias/reporte-ganancia-mensual.php');

}else if(isset($_POST['pdf_reporte_anual_ganancia'])){

    include('ganancias/reporte-ganancia-anual.php');

}else if(isset($_POST['pdf_reporte_semanal_ganancia_masiva'])){

    include('ganancias/reporte-ganancia-semanal-masiva.php');

}else if(isset($_POST['pdf_reporte_mensual_ganancia_masiva'])){

    include('ganancias/reporte-ganancia-mensual-masiva.php');

}else if(isset($_POST['pdf_reporte_anual_ganancia_masiva'])){

    include('ganancias/reporte-ganancia-anual-masiva.php');    

//****************** Reportes Retencion**************************/        
}else if(isset($_POST['pdf_reporte_semanal_retencion'])){

    include('retencion/reporte-retencion-semanal.php');  
    
}else if(isset($_POST['pdf_reporte_mensual_retencion'])){
    
    include('retencion/reporte-retencion-mensual.php');  

}else if(isset($_POST['pdf_reporte_anual_retencion'])){
    
    include('retencion/reporte-retencion-anual.php');  

}








?>