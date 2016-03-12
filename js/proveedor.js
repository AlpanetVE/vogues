$(document ).ready(function() {
	/**********AGREGAR PROVEEDOR********/
		/**CHECK TITULAR**/
	$("#diff_titular").change(function() {
	   $(".diff-titular-field").toggle("fast");
	   if ($(this).is(':checked')) {
	   		 $(".diff-titular-field input, .diff-titular-field select").prop("disabled",false);
	   }else{
	   		$(".diff-titular-field input, .diff-titular-field select").prop("disabled",true);
	   }
	});
	
		/**BANCOS DINAMICOS**/
	// The maximum number of options
    var MAX_OPTIONS = 15;
    $('#reg-prov-form')
        // Add button click handler
        .on('click', '.addButton', function() {
            var $template = $('#optionTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .insertBefore($template),
                $optionA   = $clone.find('[name="prov_banco[]"]');
                $optionB  = $clone.find('[name="prov_tipo_banco[]"]');
                $optionC  = $clone.find('[name="prov_nro_cuenta[]"]');
                 
            // Add new field
            $('#reg-prov-form').formValidation('addField', $optionA);
            $('#reg-prov-form').formValidation('addField', $optionB);
            $('#reg-prov-form').formValidation('addField', $optionC);
        })

        // Remove button click handler
        .on('click', '.removeButton', function() {
            var $row    = $(this).parents('.form-group'),
                $optionA  = $row.find('[name="prov_banco[]"]');
				$optionB  = $row.find('[name="prov_tipo_banco[]"]');
                $optionC  = $row.find('[name="prov_nro_cuenta[]"]');
            // Remove element containing the option
            $row.remove();

            // Remove field
            $('#reg-prov-form').formValidation('removeField', $optionA);
            $('#reg-prov-form').formValidation('removeField', $optionB);
            $('#reg-prov-form').formValidation('removeField', $optionC);
        })

        // Called after adding new field
        .on('added.field.fv', function(e, data) {
            // data.field   --> The field name
            // data.element --> The new field element
            // data.options --> The new field options

            if (data.field === 'prov_nro_cuenta[]') {
                if ($('#reg-prov-form').find(':visible[name="prov_nro_cuenta[]"]').length >= MAX_OPTIONS) {
                    $('#reg-prov-form').find('.addButton').attr('disabled', 'disabled');
                }
            }
        })

        // Called after removing the field
        .on('removed.field.fv', function(e, data) {
           if (data.field === 'prov_nro_cuenta[]') {
                if ($('#reg-prov-form').find(':visible[name="prov_nro_cuenta[]"]').length < MAX_OPTIONS) {
                    $('#reg-prov-form').find('.addButton').removeAttr('disabled');
                }
            }
        });
        
        /**FIN BANCOS DINAMICOS**/
       
	$(".admin-reg-prov").click(function(){
		$("#reg-prov-submit").data("step",1).html('Continuar');
		$(".diff-titular-field").hide();		
		$("section[data-step=2]").fadeOut( "fast", function() {  
					$("section[data-step=1]").fadeIn("fast");
				});
	});
	$("#reg-prov-submit").click(function(){
		var step, section;
		step = $(this).data("step");
		switch(step){
		case 1:
			if(validarFormReg(step)){
				step++;
				$("#reg-prov-submit").data("step",step);
				$("section[data-step=1]").fadeOut( "slow", function() {
					$("section[data-step='"+step+"']").fadeIn("slow");
					$("#reg-prov-submit").html('Guardar');
				});
			}
			break;
		case 2:
			$("#reg-prov-form").data('formValidation').validate();			
			break;
		}
	});
	function validarFormReg(step){
		var fv = $('#reg-prov-form').data('formValidation'), // FormValidation instance 
		
		$container = $('#reg-prov-form').find('section[data-step="' + step +'"]');
		
        // Validate the container
        fv.validateContainer($container);
        var isValidStep = fv.isValidContainer($container);
        if (isValidStep === false || isValidStep === null) {
            // Do not jump to the next step
            return false;
        }        
        return true;
	}	
	$('#reg-prov-form').formValidation({
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
			prov_documento: {validators : {
				notEmpty:{},	
				digits:{},
				stringLength : { max :  10},
				blank: {}}},
			prov_nombre : {validators : {
				notEmpty : {},
				stringLength : {min : 5, max : 512}}},
			prov_email : {validators : {
				notEmpty : {},
				emailAddress : {},
				blank: {}}},
			prov_documento_titular: {validators : {
				notEmpty:{},	
				digits:{},
				stringLength : { max :  10},
				blank: {}}},
			prov_nombre_titular : {validators : {
				notEmpty : {},
				stringLength : {min : 5, max : 512}}},
			prov_email_titular : {validators : {
				notEmpty : {},
				emailAddress : {},
				blank: {}}},
			prov_telefono : {validators : {
				notEmpty : {},
				phone : {country:'VE'}}},			
			prov_direccion : {validators : {
				notEmpty : {},
				stringLength : {min: 10,max : 1024}}},
            'prov_nro_cuenta[]': {
                validators: {
                	notEmpty: {},
                	integer: {},                   
                    stringLength: {
                        max: 20,
                        min: 20,
                        message: 'Numero de cuenta debe ser exactamente 20 Numeros'
                    }
                }
            },
            'prov_banco[]': {
                validators: {
                	notEmpty: {}
                }
            },
            'prov_tipo_banco[]': {
                validators: {
                	notEmpty: {}
                }
            }
		}
	}).on('success.form.fv', function(e) {
		e.preventDefault();		
		$("#optionTemplate input, #optionTemplate select").prop("disabled",true); //desactivamos inputs para evitar el envio
		var form = $(e.target);
		var fv = form.data('formValidation');
		var method = "&metodo="+$(this).data("method");		
		$.ajax({
			url: form.attr('action'), // la URL para la petición
            data: form.serialize() + method , // la información a enviar
            type: 'POST', // especifica si será una petición POST o GET
            dataType: 'json', // el tipo de información que se espera de respuesta		           
            success: function (data) {
	           	if (data.result === 'error') {
	            	for (var field in data.fields) {
	        			fv
	                    // Show the custom message
	                    .updateMessage(field, 'blank', data.fields[field])
	                    // Set the field as invalid
	                    .updateStatus(field, 'INVALID', 'blank');
	            	}
	            }else{ //si registramos usuarios por backend            			
            		swal({
						title: "Registro de Proveedor",
						text: "&iexcl;Proveedor Creado Exitosamente!",
						imageUrl: "galeria/img-site/logos/bill-ok.png",
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
       $("#optionTemplate input, #optionTemplate select").prop("disabled",false); //habilitamos  inputs      
    });	
	/********************FUNCIONES REALIZADAS PARA OPTIMIZAR EL LISTADO**************/
	function paginar(pagina, container, status){
		var total=$(container+" #paginacion").data("total"); 
		loadingAjax(true);
		$.ajax({
			url:"paginas/proveedor/fcn/f_proveedor.php",
			data:{metodo:"buscar",pagina:pagina,total:total,orden:" ",status:status},
			type:"POST",
			dataType:"html",
			success:function(data){
				$(container+" #ajaxContainer").html(data);
				$(container+" #paginacion li").removeClass("active");
				$(container+" #paginacion").find('[data-pagina=' + pagina + ']').parent().addClass("active");
				$(container+" #inicio").text(((pagina-1)*25)+1);
				if(total<pagina*25){
					$(container+" #final").text(total + " de ");
				}else{
					$(container+" #final").text(pagina*25 + " de ");
				}
				$(container+" html,body").animate({
    				scrollTop: 0
				}, 200);
				if(pagina % 10 == 1){
					$(container+" #paginacion #anterior1").addClass("hidden");
				}else{
					$(container+" #paginacion #anterior1").removeClass("hidden");
				}
				$(container+" #paginacion").data("paginaactual",pagina);
				if(pagina*25>=total || pagina % 10==0){
					$(container+" #paginacion #siguiente1").addClass("hidden");
				}else{
					$(container+" #paginacion #siguiente1").removeClass("hidden");
				}
				loadingAjax(false);
			}
		});
	}	
	/****FUNCION PARA ARMAR LOS LISTADOS USUARIOS ACTIVOS E INACTIVOS**/
	paginar(1, '#lista-prov-active');
	
});