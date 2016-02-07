$( document ).ready(function() {	
	/* ============================----- Modal Registrar -----=========================*/
	var pagina=1;
	$('#usr-reg-form').formValidation({
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
			p_identificacion: {validators : {
				notEmpty:{},
				digits:{},	
				stringLength : { max : 10 },
				blank: {}}},
			p_nombre : {validators : {
				notEmpty : {},
				stringLength : {max : 512},
				regexp: {regexp: /^[\u00F1a-z\s]+$/i}}},
			p_apellido : {validators : {
				notEmpty : {},
				stringLength : {max : 512},
				regexp: {regexp: /^[\u00F1a-z\s]+$/i}}},
			p_telefono : {validators : {
				notEmpty : {},
				phone : {country:'VE'}}},
			p_estado : {validators : {
				notEmpty : {}}},
			p_direccion : {validators : {
				notEmpty : {},
				stringLength : {min: 10,max : 1024}}},
			e_rif: {validators : {
				notEmpty:{},	
				digits:{},
				stringLength : { max :  10},
				blank: {}}},
			e_razonsocial : {validators : {
				notEmpty : {},
				stringLength : {min : 5, max : 512}}},
			e_categoria : {validators : {
				notEmpty : {}}},
			e_telefono : {validators : {
				notEmpty : {},
				phone : {country:'VE'}}},
			e_estado : {validators : {
				notEmpty : {}}},
			e_direccion : {validators : {
				notEmpty : {},
				stringLength : {min: 10,max : 1024}}},			
			seudonimo : {validators : {
				notEmpty : {},
				stringLength : {max : 64},
				regexp: {regexp: /^[a-zA-Z0-9_.-]*$/i},
				blank: {}}},
			email : {validators : {
				notEmpty : {},
				emailAddress : {},
				blank: {}}},
			email_val : {validators : {
				identical: {field: 'email'}}},
			password : {validators : {
				notEmpty : {},
				stringLength : {min:6,max : 64}}},
			password_val : {validators : {
				identical: {field: 'password'}}}
		}
	}).on('success.form.fv', function(e) {
		e.preventDefault();				
		var form = $(e.target);
		var fv = form.data('formValidation'); 
		var foto = "&foto="+$("#foto-usuario").attr("src");	
		var method = "&method=new"; 		
		$.ajax({
			url: form.attr('action'), // la URL para la petici처n
            data: form.serialize() + foto + method, // la informaci처n a enviar
            type: 'POST', // especifica si ser�&iexcl; una petici처n POST o GET
            dataType: 'json', // el tipo de informaci처n que se espera de respuesta		           
            success: function (data) {
            	// c처digo a ejecutar si la petici처n es satisfactoria;	
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
	            } else {
	            	swal({
						title: "Bienvenido", 
						text: "&iexcl;Compra y vende lo que quieras!",
						imageUrl: "galeria/img/logos/bill-ok.png",
						timer: 2000, 
						showConfirmButton: true
						}, function(){			
							location.reload();
						});
                }              
          	},// c처digo a ejecutar si la petici처n falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });          
    });	
	/* ============================----- Formulario de registro -----=========================*/
	/*Codigo que pide al usuario seleccionar si sera personal natural o juridica*/
	$('.alert-reg').click(function() {
		$("section").hide();
		$("#usr-reg-skip").hide();
		$("#usr-reg-foto").hide();
		$("#usr-reg-submit").data("step",1);		
		swal({
			title: "\u00A1Hola!",
			text: "Antes de continuar. Por favor selecciona.",
			imageUrl: "galeria/img/logos/bill-ok.png",
			showCancelButton: true,
			allowEscapeKey: false,
			allowOutsideClick: false,
			customClass: "sweet-alert-mod",
			confirmButtonColor: "#00C3EC",
			confirmButtonText: " Soy Persona",
			cancelButtonText: " Soy Empresa",
			closeOnConfirm: false,
			closeOnCancel: false },
			function(isConfirm){
				swal.close();
				$("#usr-reg").modal({
					  keyboard: false,
					  backdrop: "static"
					});
				$("#usr-reg").modal('show');
				if (isConfirm) {					
					$("#usr-reg-title").html($("section[data-type='p']").data("title"));
					$("#usr-reg-submit").data("type","p");
					$("section[data-type='p']").fadeIn();
					$("#type").val("p");
				} else {
					$("#usr-reg-title").html($("section[data-type='e']").data("title"));
					$("#usr-reg-submit").data("type","e");
					$("section[data-type='e']").fadeIn();
					$("#type").val("e");
				}
			}
		);
	});
	$("#usr-reg-submit").click(function(){
		var step, section;
		step = $("#usr-reg-submit").data("step");
		switch(step){
		case 1:
			if(validarForm(step)){
				step++;
				$("#usr-reg-submit").data("step",step);		
				$("section[data-type='"+$("#usr-reg-submit").data("type")+"']").fadeOut( "slow", function() {
					$("#usr-reg-title").html($("section[data-step='"+step+"']").data("title"));
					$("section[data-step='"+step+"']").fadeIn("slow");
				});
			}
			break;
		case 2:
			$("#usr-reg-form").data('formValidation').validate();
			break;
		}
	});

	function validarForm(step){
		var type;
		 var fv = $('#usr-reg-form').data('formValidation'), // FormValidation instance
        // The current step container
		type = $("#usr-reg-submit").data("type");
		if(step === 1){
			$container = $('#usr-reg-form').find('section[data-type="' + type +'"]');
		}else{
			$container = $('#usr-reg-form').find('section[data-step="' + step +'"]');
		}
        // Validate the container
        fv.validateContainer($container);	
        var isValidStep = fv.isValidContainer($container);
        if (isValidStep === false || isValidStep === null) {
            // Do not jump to the next step
            return false;
        }        
        return true;
	}
	
	/* ============================----- Modal Login -----=========================*/	
	
	$('#usr-log-form').formValidation({
		locale: 'es_ES',
		excluded: ':disabled',
		framework : 'bootstrap',
		icon : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		},
		addOns: { i18n: {} },
		err: { container: 'tooltip' },
		fields : {			
			log_usuario : {validators : {
				notEmpty : {},
				blank: {}}},
			log_password : {validators : {
				notEmpty : {},
				blank: {}}}
		}
	}).on('success.field.fv', function(e, data) {
        if (data.fv.getInvalidFields().length > 0) {    // There is invalid field
            data.fv.disableSubmitButtons(true);
        }
    }).on('err.form.fv', function(e,data) {
    	$(".dropdown-toggle").dropdown('toggle');
    }).on('success.form.fv', function(e) {
		e.preventDefault();
		
		var form = $(e.target);
		var fv = form.data('formValidation');
		var method = "&method=log";
		$.ajax({
			url: form.attr('action'), // la URL para la petici처n
            data: form.serialize() + method, // la informaci처n a enviar
            type: 'POST', // especifica si ser�&iexcl; una petici처n POST o GET
            dataType: 'json', // el tipo de informaci처n que se espera de respuesta            
            success: function (data) {
            	// c처digo a ejecutar si la petici처n es satisfactoria;
            	// c처digo a ejecutar si la petici처n es satisfactoria;
            	// console.log(data);
	            if (data.result === 'error'){
	            	for (var field in data.fields) {
	        			fv
	                    // Show the custom message
	                    .updateMessage(field, 'blank', data.fields[field])
	                    // Set the field as invalid
	                    .updateStatus(field, 'INVALID', 'blank');
	        			setTimeout(function(){
	        				$("#"+field).focus();	       			
	        			}, 10);
	            	}
	            	$(".dropdown-toggle").dropdown('toggle');
	            } else {
	            	swal({
						title: "Bienvenido", 
						text: "&iexcl;Compra y vende lo que quieras!",
						imageUrl: "galeria/img/logos/bill-ok.png",
						timer: 2000, 
						showConfirmButton: true
						}, function(){
							location.reload();
						});
                } 
          	},// c처digo a ejecutar si la petici처n falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });
	});
	$(".buscador").keydown(function(e){
		if(e.which==13){
			if($('#txtBuscar').val()!=""){
		        buscar=$('#txtBuscar').val();
				window.open("listado.php?palabra=" + buscar,"_self");
			}else{
				window.open("listado.php?palabra=TODOS","_self");
			}
		}
	});
	$(".buscadorBoton").click(function(e){
		if($('#txtBuscar').val()!=""){
		        buscar=$('#txtBuscar').val();
				window.open("listado.php?palabra=" + buscar,"_self");
			}else{
				window.open("listado.php?palabra=TODOS","_self");
			}
	});
	$("#usr-log-submit").prop("disabled",true);	
	$("#opcion1").click(function(){
		if($("#opcion1").hasClass('active-cat')){
			return false;
		}else{
			loadingAjax(true);
		    setTimeout(pararCarga,800);
			$("#productos").css("display","block");
			$("#vehiculos").css("display","none");
			$("#servicios").css("display","none");
			$("#inmuebles").css("display","none");
			$("#opcion1").addClass("active-cat");
			$("#opcion2").removeClass("active-cat");
			$("#opcion3").removeClass("active-cat");
			$("#opcion4").removeClass("active-cat");
		}		
	});
	$("#opcion2").click(function(){
		if($("#opcion2").hasClass('active-cat')){
			return false;
		}else{		
			loadingAjax(true);
		    setTimeout(pararCarga,800);		
			$("#productos").css("display","none");
			$("#vehiculos").css("display","block");
			$("#servicios").css("display","none");
			$("#inmuebles").css("display","none");
			$("#opcion1").removeClass("active-cat");
			$("#opcion2").addClass("active-cat");
			$("#opcion3").removeClass("active-cat");
			$("#opcion4").removeClass("active-cat");
		}		
	});
	$("#opcion3").click(function(){
		if($("#opcion3").hasClass('active-cat')){
			return false;
		}else{		
			loadingAjax(true);
		    setTimeout(pararCarga,800);		
			$("#productos").css("display","none");
			$("#vehiculos").css("display","none");
			$("#inmuebles").css("display","block");		
			$("#servicios").css("display","none");
			$("#opcion1").removeClass("active-cat");
			$("#opcion2").removeClass("active-cat");
			$("#opcion3").addClass("active-cat");
			$("#opcion4").removeClass("active-cat");
		}		
	});
	$("#opcion4").click(function(){
		if($("#opcion4").hasClass('active-cat')){
			return false;
		}else{		
			loadingAjax(true);
		    setTimeout(pararCarga,800);		
			$("#productos").css("display","none");
			$("#vehiculos").css("display","none");
			$("#inmuebles").css("display","none");		
			$("#servicios").css("display","block");
			$("#opcion1").removeClass("active-cat");
			$("#opcion2").removeClass("active-cat");
			$("#opcion3").removeClass("active-cat");
			$("#opcion4").addClass("active-cat");
		}		
	});
	$(".publicaciones1,.publicaciones2").click(function(e){
		window.open("detalle.php?id=" + $(this).attr("id"),"_self");
	});
	$(".vendedores").click(function(e){
		window.open("perfil.php?id=" + $(this).attr("id"),"_self");
	});	
	function pararCarga(){
		loadingAjax();
	}
	$(".izquierda").click(function(){
		var elDiv=$("#listaPublicaciones");
		var laPagina=elDiv.data("pagina");
		laPagina--;
		$.ajax({
			url:"fcn/f_index.php",
			data:{metodo:"buscarPublicaciones",pagina:laPagina},
			type:"POST",
			dataType:"html",
			success: function(data){
				console.log(data);
				elDiv.html(data);
				elDiv.data("pagina",laPagina);
			}
		});
	});
	
	
// Tooltip ------------------------------------
  $('[data-toggle="tooltip"]').tooltip();
//---------------------------------------------

	
	function buscaDerecha(){
		alert("laPagina");
		var elDiv=$("#listaPublicaciones");
		var elInicio=$("#inicio");
		var laPagina=$("#inicio").data("pagina");
		laPagina++;
		$.ajax({
			url:"fcn/f_index.php",
			data:{metodo:"buscarPublicaciones",pagina:laPagina},
			type:"POST",
			dataType:"html",
			success: function(data){
				console.log(data);
				elDiv.html(data);
				elInicio.data("pagina",laPagina);
			}
		});
	}
	$("#enviar-email").formValidation({
		locale: 'es_ES',
		excluded: ':disabled',
		framework : 'bootstrap',
		icon : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		},
		addOns: { i18n: {} },
		err: { container: 'tooltip' },
		fields : {			
			nombre : {validators : {
				notEmpty : {},
				stringLength : {max : 512},
				regexp: {regexp: /^[\u00F1a-z\s]+$/i}}},
			email : {validators : {
				notEmpty : {},
				emailAddress : {}}},			
			mensaje : {validators : {
				notEmpty:{}}				
			}
		}
	}).on('success.field.fv', function(e) {		
		e.preventDefault();
		email=$("#email").val();
		nombre=$("#nombre").val();
		mensaje=$("#mensaje").val();
		method="send-email";
		$.ajax({
			url:"fcn/f_usuarios.php",
			data:{'method':method,'nombre':nombre,'email':email,'mensaje':mensaje},
			type:"POST",
			dataType:"html",
			success:function(data){
				alert(data);
				console.log(data);
			},
			error:function(xhr,status){
				SweetError(status);
			}
		});
	});
	
	$(document).on('keyup',"#txtBusqueda",function(e){
		if($(this).val()!=""){
			var valor=$(this).val().toUpperCase();
			var c=0;
			$(".general").each(function(i){
				if($(this).data("titulo").toUpperCase().indexOf(valor)==-1) {
					$(this).css("display","none");
				}else{
					c++;
					$(this).css("display","block");
				}
			});
			if(c==0){
				$("#noresultados").removeClass("hidden");
				$("#publicaciones").addClass("hidden");
			}else{
				$("#noresultados").addClass("hidden");
				$("#publicaciones").removeClass("hidden");				
			}
		}else{		
			if($(".general").length>0){
				$("#noresultados").addClass("hidden");
				$("#publicaciones").removeClass("hidden");
				$(".general").css("display","block");				
			}else{
				$("#noresultados").removeClass("hidden");
				$("#publicaciones").addClass("hidden");				
			}
		}
	});
	
});