$(document ).ready(function() {
	

	
$("#update_usr-reg-submit").click(function(){ 
		$("#usr-update-form").data('formValidation').validate();
});


/**************MODIFICAR USUARIO*************/
$('#usr-update-form').formValidation({
		locale: 'es_ES',
		framework : 'bootstrap',
		icon : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		},
		addOns: { i18n: {} },
		err: { container: 'tooltip' },
		fields : {
			update_seudonimo : {validators : {
				notEmpty : {},
				stringLength : {max : 64},
				regexp: {regexp: /^[a-zA-Z0-9_.-]*$/i},
				blank: {}}},
			update_email : {validators : {
				notEmpty : {},
				emailAddress : {},
				blank: {}}},
			email_val : {validators : {
				identical: {field: 'email'}}},
			update_password : {validators : {
				notEmpty : {},
				stringLength : {min:6,max : 64}}},
			update_password_val : {validators : {
				identical: {field: 'update_password'}}}
		}
	}).on('success.form.fv', function(e) {
	 
		e.preventDefault();			
		var form = $(e.target);
		var fv = form.data('formValidation'); 
		var method = "&method="+$(this).data("method");
		 
		var usuarios_id = "&update_usuarios_id="+$(this).data("usuarios_id");
		 
		$.ajax({
			url: form.attr('action'), // la URL para la petición
            data: form.serialize() + method + usuarios_id, // la información a enviar
            type: 'POST', // especifica si será una petición POST o GET
            dataType: 'json', // el tipo de información que se espera de respuesta		           
            success: function (data) {
            	// código a ejecutar si la petición es satisfactoria;	
            	// console.log(data);
	            if (data.result === 'error') {
	            	$("#usr-reg-skip").hide();
            		$("#usr-reg-foto").hide();
            		$("section").hide();
            		keys = Object.keys(data.fields);
            		if(jQuery.inArray("e_rif",keys) !== -1 || jQuery.inArray("p_identificacion",keys) !== -1){
            			$("#usr-reg-submit").data("step",1);	
            			$("section[data-type='"+$("#type").val()+"']").show();
            		}else if(jQuery.inArray("seudonimo",keys) !== -1 || jQuery.inArray("email",keys)!== -1){
            			$("#usr-reg-submit").data("step",2);	
            			$("section[data-step='2']").show();
            		}
	            	for (var field in data.fields) { 
	        			fv
	                    // Show the custom message
	                    .updateMessage(field, 'blank', data.fields[field])
	                    // Set the field as invalid
	                    .updateStatus(field, 'INVALID', 'blank');
	            	}
	            }else{  
	            	
	            	swal({
							title: "Usuario Actualizado", 
							text: "&iexcl;Usuario Actualizado Exitosamente!",
							imageUrl: "galeria/img/logos/bill-ok.png",
							timer: 2000, 
							showConfirmButton: true
							}, function(){
								location.reload();
							});	
		        						
                 }             
          	},// código a ejecutar si la petición falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });          
    });	
    
    
	$("body").on('click', '.show-select-rol', function(e) {
		$("#id_rol_hidden").prop("disabled",true);  //desactivamos el hidden publico
		
		$( "#id_rol_select" ).closest("div").removeClass("hidden");  //mostramos el div y select de roles
		$( "#id_rol_select" ).closest("div").prev().removeClass("hidden");  //mostramos el div del titulo
		$( "#id_rol_select" ).prop("disabled",false);				//activamos el select
		$( "#ingresoUsuario" ).val("0");	//cambiamos la bandera para no iniciar session con nuevo usuario 
	});
	
	$("body").on('click', '.btn-container-password', function(e) {		
		var disable=$("#usr-update-info #update_password").prop("disabled");  
		if(disable){
			show_update_password();
		 	$(this).data("status","1");		
		}else{
			hide_update_password();
		 	$(this).data("status","0");	
		}		
	});	 
	 
	
	$("body").on('click', '.update_user', function(e) {   
		hide_update_password();
        $("section[data-step='2']").show();	  
        $('#usr-update-form').data("usuarios_id",$(this).data("usuarios_id"));	//usuario que modificare 
		$('#usr-update-info').data("usuarios_id",$(this).data("usuarios_id"));		//para auto-cargar la data del formulario	 
	});
	
	/* ============================----- Actualizar info social -----=========================*/	 
	$('.modal-update-user').on('show.bs.modal', function (e) { 
		 
		var usuarios_id= $(this).data("usuarios_id");
		usuarios_id = parseInt(usuarios_id);
		  
		if(usuarios_id>0){  
			$.ajax({
				url: "fcn/f_usuarios.php", // la URL para la petici&oacute;n
	            data: {method:"get", id:usuarios_id}, // la informaci&oacute;n a enviar
	            type: 'POST', // especifica si ser&aacute; una petici&oacute;n POST o GET
	            dataType: 'json', // el tipo de informaci&oacute;n que se espera de respuesta
	            success: function (data) {
	            	// c&oacute;digo a ejecutar si la petici&oacute;n es satisfactoria; 
	            	if (data.result === 'OK') { 
				            	$('.modal-update-user #update_seudonimo').val(data.campos.a_seudonimo);
				            	$('.modal-update-user #update_email').val(data.campos.a_email);
				            	$('.modal-update-user #update_id_rol_select').val(data.campos.a_id_rol);	 
		            }
	          	},// c&oacute;digo a ejecutar si la petici&oacute;n falla;
	            error: function (xhr, status) {
	            	SweetError(status);
	            }
	        });
	    }
	});	
	
	
	/*---======= FORM PARA ELIMINAR USUARIOS ========---*/
    $("body").on('click', '.select-usr-delete', function(e) {
    	//guardamos el ID del usuario que borraremos logicamente   
    	$('#usr-act-form-delete').data("usuarios_id",$(this).data("usuarios_id"));
    	 
    });
    
    
   /********************ELIMINAR USUARIO **********************/
	$('#usr-act-form-delete').formValidation({ 
	
	}).on('success.form.fv', function(e) {   
		e.preventDefault();
		var form = $(e.target); 
		var method = "&method="+$(this).data("method");  
		var status = "&status_usuarios_id=3";
		var usuario = "&usuarios_id="+$(this).data("usuarios_id");
		$.ajax({
			url: form.attr('action'), // la URL para la petición
            data: method + status + usuario, // la información a enviar
            type: 'POST', // especifica si será una petición POST o GET
            dataType: 'json', // el tipo de información que se espera de respuesta
            success: function (data) {
            	if (data.result === 'error'){
	            	SweetError("Borrar Usuario");
	            	$('#msj-eliminar').modal('hide');
	            }else{
	            	location.reload();
                } 
            	
          	},// código a ejecutar si la petición falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });
    });
     
    $(document).on("click",".botonPagina",function(e){
		e.preventDefault();
		var pagina=$(this).data("pagina");
		var actual=$(this);
		paginar(pagina,actual);
	});
	/********************FUNCIONES REALIZADAS PARA OPTIMIZAR EL LISTADO**************/
	function paginar(pagina,actual){
		var total=$("#paginacion").data("total"); 
		loadingAjax(true);
		$.ajax({
			url:"paginas/adminusr/fcn/f_adminusr.php",
			data:{metodo:"buscar",pagina:pagina,total:total,orden:" "},
			type:"POST",
			dataType:"html",
			success:function(data){
				$("#paginacion li").removeClass("active");
				$('#paginacion').find('[data-pagina=' + pagina + ']').parent().addClass("active");
				$("#ajaxContainer").html(data);
				$("#inicio").text(((pagina-1)*25)+1);
				if(total<pagina*25){		
					$("#final").text(total + " de ");
				}else{
					$("#final").text(pagina*25 + " de ");
				}
				$('html,body').animate({
    				scrollTop: 0
				}, 200);
				if(pagina % 10 == 1){
					$("#paginacion #anterior1").addClass("hidden");
				}else{
					$("#paginacion #anterior1").removeClass("hidden");
				}			
				$("#principal #paginacion").data("paginaactual",pagina);
				if(pagina*25>=total || pagina % 10==0){
					$("#paginacion #siguiente1").addClass("hidden");
				}else{
					$("#paginacion #siguiente1").removeClass("hidden");
				}
				loadingAjax(false);
			}
		});
	}
	/**FUNCIONES PARA CAMBIAR DATOS DE USUARIOS**/
	function show_update_password(){
		$('.password_container .input').removeClass('hidden');
		$(".password_container .input").fadeIn("slow"); 			
		$("#usr-update-info #update_password, #update_password_val").prop("disabled",false);
	}
	function hide_update_password(){
		$(".password_container .input").fadeOut("slow", function() {
		   $('.password_container .input').addClass('hidden');
		});	 
		$("#usr-update-info #update_password, #update_password_val").prop("disabled",true);
	}
	
	
});
 
