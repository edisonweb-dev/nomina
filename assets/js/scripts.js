(function($) {
    $(document).ready(function() {

        $('#tabla-empleados').DataTable( {
            /*dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            language:{
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },*/
           responsive: true
        } );


        $("#cambiar_fecha_hasta").change(function(){
            if($(this).val() == 1){
                $("#date_hasta").hide(500);
            }
            if($(this).val() == 0){
                $("#date_hasta").show(500);
            }
        });

        $("#nuevo_registro").click( function(){

            $("#registrar_mostrar").toggle();

        });

        
        $("#fecha_jornada").change( function(){

            let ruta = $("#ruta_registrar").attr("href");
            let fecha = this.value;

            $("#ruta_registrar").attr("href",ruta+fecha);

        });

        if ($('#validarTelefono').length) {

            let validarTelefono = document.querySelector("#validarTelefono");

            validarTelefono.addEventListener("keyup", function(event){
                let cantidad = this.value;

                if(event.keyCode == 8){

                }else{

                    if( cantidad.length == 3 ){
                        this.value = this.value + "-";
                    }      
    
                    if( cantidad.length == 7  ){
                        this.value = this.value + "-";
                    }   
                    
                }

                if( cantidad.length >= 12 ){
                    this.value = this.value.slice(0,12); 
                }
    
            });

        }


        if ($('#seguroSocial').length) {

            let validarSeguroSocial = document.querySelector("#seguroSocial");

            validarSeguroSocial.addEventListener("keyup", function(event){
                let cantidad = this.value;

                if(event.keyCode == 8){

                }else{

                    if( cantidad.length == 3 ){
                        this.value = this.value + "-";
                    }      
    
                    if( cantidad.length == 6  ){
                        this.value = this.value + "-";
                    }   
                    
                }

                if( cantidad.length >= 11 ){
                    this.value = this.value.slice(0,11); 
                }

            });

        }

    } );
})(jQuery);