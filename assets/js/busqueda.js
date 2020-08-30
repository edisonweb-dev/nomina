(function( $ ) {

	$(document).ready( function(){

	$(".eliminando_empleado").on("click", function(event){
		event.preventDefault();

		const id_empleado = this.dataset.id;

		let data = {
			action: 'ajax_busqueda',
			id_empleado: id_empleado,
			eliminar_empleado: 1
		};

		
		Swal.fire({
			title: 'Estás seguro?',
			text: "¡No podrás revertir esto!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sí, bórralo!'
		}).then((result) => {
			
			if (result.value) {

				$.ajax({
					url : busqueda_vars.ajaxurl,
					type: 'post',
					data: data,
					beforeSend: function(){
						
					},
					success: function(resultado){
						 
						 Swal.fire(
							'Eliminado!',
							'Su registro ha sido eliminado.',
							'success'
						).then( () =>{
							location.reload();
						});
					},
					error: function (jqXHR, exception) {
						var msg = '';
						if (jqXHR.status === 0) {
								msg = 'Not connect.\n Verify Network.';
						} else if (jqXHR.status == 404) {
								msg = 'Requested page not found. [404]';
						} else if (jqXHR.status == 500) {
								msg = 'Internal Server Error [500].';
						} else if (exception === 'parsererror') {
								msg = 'Requested JSON parse failed.';
						} else if (exception === 'timeout') {
								msg = 'Time out error.';
						} else if (exception === 'abort') {
								msg = 'Ajax request aborted.';
						} else {
								msg = 'Uncaught Error.\n' + jqXHR.responseText;
						}
						console.log(msg);
					}
					
		
				});// fin del ajax

				
			}

		});//fin then



		

		

	});// fin eliminar empleados

	$(".eliminando_salario").on("click", function(event){
		event.preventDefault();

		const id_empleado_salario = this.dataset.id;

		let data = {
			action: 'ajax_busqueda',
			id_empleado_salario: id_empleado_salario,
			eliminar_salario: 1
		};

		
		Swal.fire({
			title: 'Estás seguro?',
			text: "¡No podrás revertir esto!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sí, bórralo!'
		}).then((result) => {
			
			if (result.value) {

				$.ajax({
					url : busqueda_vars.ajaxurl,
					type: 'post',
					data: data,
					beforeSend: function(){
						
					},
					success: function(resultado){
						 
						 Swal.fire(
							'Eliminado!',
							'Su registro ha sido eliminado.',
							'success'
						).then( () =>{
							location.reload();
						});
					},
					error: function (jqXHR, exception) {
						var msg = '';
						if (jqXHR.status === 0) {
								msg = 'Not connect.\n Verify Network.';
						} else if (jqXHR.status == 404) {
								msg = 'Requested page not found. [404]';
						} else if (jqXHR.status == 500) {
								msg = 'Internal Server Error [500].';
						} else if (exception === 'parsererror') {
								msg = 'Requested JSON parse failed.';
						} else if (exception === 'timeout') {
								msg = 'Time out error.';
						} else if (exception === 'abort') {
								msg = 'Ajax request aborted.';
						} else {
								msg = 'Uncaught Error.\n' + jqXHR.responseText;
						}
						console.log(msg);
					}
					
		
				});// fin del ajax

				
			}

		});//fin then



		

		

	});// fin eliminar salarios	

	$(".eliminando_overtime").on("click", function(event){
		event.preventDefault();

		const id_empleado_overtime = this.dataset.id;

		let data = {
			action: 'ajax_busqueda',
			id_empleado: id_empleado_overtime,
			eliminar_overtime: 1
		};

		
		Swal.fire({
			title: 'Estás seguro?',
			text: "¡No podrás revertir esto!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sí, bórralo!'
		}).then((result) => {
			
			if (result.value) {

				$.ajax({
					url : busqueda_vars.ajaxurl,
					type: 'post',
					data: data,
					beforeSend: function(){
						
					},
					success: function(resultado){
						 
						 Swal.fire(
							'Eliminado!',
							'Su registro ha sido eliminado.',
							'success'
						).then( () =>{
							location.reload();
						});
					},
					error: function (jqXHR, exception) {
						var msg = '';
						if (jqXHR.status === 0) {
								msg = 'Not connect.\n Verify Network.';
						} else if (jqXHR.status == 404) {
								msg = 'Requested page not found. [404]';
						} else if (jqXHR.status == 500) {
								msg = 'Internal Server Error [500].';
						} else if (exception === 'parsererror') {
								msg = 'Requested JSON parse failed.';
						} else if (exception === 'timeout') {
								msg = 'Time out error.';
						} else if (exception === 'abort') {
								msg = 'Ajax request aborted.';
						} else {
								msg = 'Uncaught Error.\n' + jqXHR.responseText;
						}
						console.log(msg);
					}
					
		
				});// fin del ajax

				
			}

		});//fin then



		

		

	});// fin eliminar overtime
	

	$('#tabla-empleados tbody').on('click', 'button.eliminando_jornada', function (event) {
		event.preventDefault();

		const id_jornada = this.dataset.id;

		let data = {
			action: 'ajax_busqueda',
			id_jornada: id_jornada,
			eliminar_jornada: 1
		};

		
		Swal.fire({
			title: 'Estás seguro?',
			text: "¡No podrás revertir esto!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sí, bórralo!'
		}).then((result) => {
			
			if (result.value) {

				$.ajax({
					url : busqueda_vars.ajaxurl,
					type: 'post',
					data: data,
					beforeSend: function(){
						
					},
					success: function(resultado){
						 
						 Swal.fire(
							'Eliminado!',
							'Su registro ha sido eliminado.',
							'success'
						).then( () =>{
							location.reload();
						});
					},
					error: function (jqXHR, exception) {
						var msg = '';
						if (jqXHR.status === 0) {
								msg = 'Not connect.\n Verify Network.';
						} else if (jqXHR.status == 404) {
								msg = 'Requested page not found. [404]';
						} else if (jqXHR.status == 500) {
								msg = 'Internal Server Error [500].';
						} else if (exception === 'parsererror') {
								msg = 'Requested JSON parse failed.';
						} else if (exception === 'timeout') {
								msg = 'Time out error.';
						} else if (exception === 'abort') {
								msg = 'Ajax request aborted.';
						} else {
								msg = 'Uncaught Error.\n' + jqXHR.responseText;
						}
						console.log(msg);
					}
					
		
				});// fin del ajax

				
			}

		});//fin then



		

		

	});// fin eliminar jornada diaria


	$(".eliminando_comision").on("click", function(event){
		event.preventDefault();

		const id_comision = this.dataset.id;

		let data = {
			action: 'ajax_busqueda',
			id_comision: id_comision,
			eliminar_comision: 1
		};

		
		Swal.fire({
			title: 'Estás seguro?',
			text: "¡No podrás revertir esto!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sí, bórralo!'
		}).then((result) => {
			
			if (result.value) {

				$.ajax({
					url : busqueda_vars.ajaxurl,
					type: 'post',
					data: data,
					beforeSend: function(){
						
					},
					success: function(resultado){
						 
						 Swal.fire(
							'Eliminado!',
							'Su registro ha sido eliminado.',
							'success'
						).then( () =>{
							location.reload();
						});
					},
					error: function (jqXHR, exception) {
						var msg = '';
						if (jqXHR.status === 0) {
								msg = 'Not connect.\n Verify Network.';
						} else if (jqXHR.status == 404) {
								msg = 'Requested page not found. [404]';
						} else if (jqXHR.status == 500) {
								msg = 'Internal Server Error [500].';
						} else if (exception === 'parsererror') {
								msg = 'Requested JSON parse failed.';
						} else if (exception === 'timeout') {
								msg = 'Time out error.';
						} else if (exception === 'abort') {
								msg = 'Ajax request aborted.';
						} else {
								msg = 'Uncaught Error.\n' + jqXHR.responseText;
						}
						console.log(msg);
					}
					
		
				});// fin del ajax

				
			}

		});//fin then



		

		

	});// fin eliminar jornada diaria
		

	$(".eliminando_bonoNavidad").on("click", function(event){
		event.preventDefault();

		const id_bono_navidad = this.dataset.id;

		let data = {
			action: 'ajax_busqueda',
			id_bono_navidad: id_bono_navidad,
			eliminar_bonoNavidad: 1
		};

		
		Swal.fire({
			title: 'Estás seguro?',
			text: "¡No podrás revertir esto!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sí, bórralo!'
		}).then((result) => {
			
			if (result.value) {

				$.ajax({
					url : busqueda_vars.ajaxurl,
					type: 'post',
					data: data,
					beforeSend: function(){
						
					},
					success: function(resultado){
						 
						 Swal.fire(
							'Eliminado!',
							'Su registro ha sido eliminado.',
							'success'
						).then( () =>{
							location.reload();
						});
					},
					error: function (jqXHR, exception) {
						var msg = '';
						if (jqXHR.status === 0) {
								msg = 'Not connect.\n Verify Network.';
						} else if (jqXHR.status == 404) {
								msg = 'Requested page not found. [404]';
						} else if (jqXHR.status == 500) {
								msg = 'Internal Server Error [500].';
						} else if (exception === 'parsererror') {
								msg = 'Requested JSON parse failed.';
						} else if (exception === 'timeout') {
								msg = 'Time out error.';
						} else if (exception === 'abort') {
								msg = 'Ajax request aborted.';
						} else {
								msg = 'Uncaught Error.\n' + jqXHR.responseText;
						}
						console.log(msg);
					}
					
		
				});// fin del ajax

				
			}

		});//fin then



		

		

	});// fin eliminar jornada diaria	

	$(".eliminando_usuarios").on("click", function(event){
		event.preventDefault();

		const id_usuario_form = this.dataset.id;

		let data = {
			action: 'ajax_busqueda',
			id_usuario_form: id_usuario_form,
			eliminar_usuarios: 1
		};

		
		Swal.fire({
			title: 'Estás seguro?',
			text: "¡No podrás revertir esto!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sí, bórralo!'
		}).then((result) => {
			
			if (result.value) {

				$.ajax({
					url : busqueda_vars.ajaxurl,
					type: 'post',
					data: data,
					beforeSend: function(){
						
					},
					success: function(resultado){
						 
						 Swal.fire(
							'Eliminado!',
							'Su registro ha sido eliminado.',
							'success'
						).then( () =>{
							location.reload();
						});
					},
					error: function (jqXHR, exception) {
						var msg = '';
						if (jqXHR.status === 0) {
								msg = 'Not connect.\n Verify Network.';
						} else if (jqXHR.status == 404) {
								msg = 'Requested page not found. [404]';
						} else if (jqXHR.status == 500) {
								msg = 'Internal Server Error [500].';
						} else if (exception === 'parsererror') {
								msg = 'Requested JSON parse failed.';
						} else if (exception === 'timeout') {
								msg = 'Time out error.';
						} else if (exception === 'abort') {
								msg = 'Ajax request aborted.';
						} else {
								msg = 'Uncaught Error.\n' + jqXHR.responseText;
						}
						console.log(msg);
					}
					
		
				});// fin del ajax

				
			}

		});//fin then



		

		

	});// fin eliminar jornada diaria		

	});//fin document.ready.funtion




	$(".busqueda_salarios").on("change", function(event){
		// event.preventDefault();
		
		console.log(this.value);
		let id_empleado_salario = this.value;
		
		let data = {
			action: 'ajax_busqueda',
			id_empleado_salario: id_empleado_salario,
			busqueda_salario: 1
		};


		$.ajax({
			url : busqueda_vars.ajaxurl,
			type: 'post',
			data: data,
			beforeSend: function(){
				
			},
			success: function(result){
				
				let resp = JSON.parse( result.slice(0, -1) );

				// console.log(resp.fecha_inicial);		 	

				$(".fecha_inicial").val(resp.fecha_inicial);
				$(".fecha_final").val(resp.fecha_final);
				$(".salario").val(resp.salario);
				$(".estatus").val(resp.estatus);
			
			},
			error: function (jqXHR, exception) {
				var msg = '';
				if (jqXHR.status === 0) {
						msg = 'Not connect.\n Verify Network.';
				} else if (jqXHR.status == 404) {
						msg = 'Requested page not found. [404]';
				} else if (jqXHR.status == 500) {
						msg = 'Internal Server Error [500].';
				} else if (exception === 'parsererror') {
						msg = 'Requested JSON parse failed.';
				} else if (exception === 'timeout') {
						msg = 'Time out error.';
				} else if (exception === 'abort') {
						msg = 'Ajax request aborted.';
				} else {
						msg = 'Uncaught Error.\n' + jqXHR.responseText;
				}
				console.log(msg);
			}

		})	
			
		
	});



	$(".busqueda_overtime").on("change", function(event){
		// event.preventDefault();
		
		console.log(this.value);
		let id_empleado_salario = this.value;
		let palabra_double = "Double";
		let palabra_medio = "Time and a half";

		let double = 0;		
		let medio = 0;

		palabra = "Double";
					

		let data = {
			action: 'ajax_busqueda',
			id_empleado_salario: id_empleado_salario,
			busqueda_overtime: 1
		};


		$.ajax({
			url : busqueda_vars.ajaxurl,
			type: 'post',
			data: data,
			beforeSend: function(){
				
			},
			success: function(result){
				
				let resp = JSON.parse( result.slice(0, -1) );
				// console.log(resp);		 	

				double = (Number(resp.salario) * 2);
				medio = (Number(resp.salario)  / 2) + Number(resp.salario);
				

				$(".hora_extra").empty();
				
				if( (resp.salario * 2) == resp.salario_hora_extra ){
					
					$(".hora_extra").append('<option value='+double+'>'+palabra_double+'</option>');	
					$(".hora_extra").append('<option value='+medio+'>'+palabra_medio+'</option>');	

				}else{

					$(".hora_extra").append('<option value='+medio+'>'+palabra_medio+'</option>');	
					$(".hora_extra").append('<option value='+double+'>'+palabra_double+'</option>');	

				}

				
				

				$(".date").val(resp.fecha);
				$(".status").val(resp.estatus);
				
			
			},
			error: function (jqXHR, exception) {
				var msg = '';
				if (jqXHR.status === 0) {
						msg = 'Not connect.\n Verify Network.';
				} else if (jqXHR.status == 404) {
						msg = 'Requested page not found. [404]';
				} else if (jqXHR.status == 500) {
						msg = 'Internal Server Error [500].';
				} else if (exception === 'parsererror') {
						msg = 'Requested JSON parse failed.';
				} else if (exception === 'timeout') {
						msg = 'Time out error.';
				} else if (exception === 'abort') {
						msg = 'Ajax request aborted.';
				} else {
						msg = 'Uncaught Error.\n' + jqXHR.responseText;
				}
				console.log(msg);
			}

		})	
			
		
	});





})(jQuery);
