$(document ).ready(function() {
/**PRODUCTOS DINAMICOS**/
	
	if($('#tab-shop-facturado').length != 0) {
		paginar(1,$('#tab-shop-activo'),1,true);
		paginar(1,$('#tab-shop-garantia'),2,true);
		paginar(1,$('#tab-shop-facturado'),3,true);		
	}
	initFormValidation('#reg-prod-form');
	/**FUNCTION FOR DINAMICAL BANK**/
	// The maximum number of options
	function initFormValidation(formContainer){
	var	$form=$(formContainer);
    var MAX_OPTIONS = 15;
        
    $form.find('#optionTemplate').find("input, select, textarea").prop("disabled",true);
    $form
        // Add button click handler
        .on('click', '.addButton', function() {
            var $template = $form.find('#optionTemplate');           
             $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .addClass('aditionalOpt')                 
                                .insertBefore($template);
                                
                $clone.find("input, select, textarea").prop("disabled",false);
                var $optionA   = $clone.find('[name="codigo[]"]');
                $optionB  = $clone.find('[name="precio[]"]');
                $optionC  = $clone.find('[name="descripcion[]"]');
                
            // Add new field
            $form.formValidation('addField', $optionA);
            $form.formValidation('addField', $optionB);
            $form.formValidation('addField', $optionC);
        })

        // Remove button click handler
        .on('click', '.removeButton', function() {
            var $row      = $(this).parents('.form-group'),
                $optionA  = $row.find('[name="codigo[]"]');
				$optionB  = $row.find('[name="precio[]"]');
                $optionC  = $row.find('[name="descripcion[]"]');
            // Remove element containing the option
            $row.remove();
            // Remove field
            $form.formValidation('removeField', $optionA);
            $form.formValidation('removeField', $optionB);
            $form.formValidation('removeField', $optionC);
        })

        // Called after adding new field
        .on('added.field.fv', function(e, data) {
            // data.field   --> The field name
            // data.element --> The new field element
            // data.options --> The new field options

            if (data.field === 'prod_nro_cuenta[]') {
                if ($form.find(':visible[name="codigo[]"]').length >= MAX_OPTIONS) {
                    $form.find('.addButton').attr('disabled', 'disabled');
                }
            }
        })

        // Called after removing the field
        .on('removed.field.fv', function(e, data) {
           if (data.field === 'prod_nro_cuenta[]') {
                if ($form.find(':visible[name="codigo[]"]').length < MAX_OPTIONS) {
                    $form.find('.addButton').removeAttr('disabled');
                }
            }
        });
        
     }
     /**FIN BANCOS DINAMICOS**/
    
	/******************AGREGAR PRODUCTO*******************/
	$(".btn-reg-prod-submit").click(function(){
		var $container    = $(this).parents('.form-producto');
		$container.data('formValidation').validate();
	});
	$('#reg-prod-form').formValidation({
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
			'precio[]': {validators : {
				notEmpty:{},	
				digits:{},
				stringLength : { max :  10},
				blank: {}}},
            'codigo[]': {
                validators: {
                	notEmpty: {}
                }
            },
            'descripcion[]': {
                validators: {
                	notEmpty: {}
                }
            },
            proveedor: {
                validators: {
                	notEmpty: {}
                }
            },
            categoria: {
                validators: {
                	notEmpty: {}
                }
            }
		}
	}).on('success.form.fv', function(e) {
		e.preventDefault();
		var form = $(e.target);
		var fv = form.data('formValidation');
		var method = "&metodo="+$(this).data("method");
		$(this).find('#categoria').prop("disabled",false); //line for inventarios.js
		console.log($(this).find('#categoria'));
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
						title: "Registro de Productos",
						text: "&iexcl;Exito!",
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
           
    });
  /******************************FIN AGREGAR PRODUCTO*********************************/  
  
	/**********************MODIFICAR PROVEEDORES INFO*********************/
	$("body").on('click', '.admin-edit-prod', function(e) { 
		$('#edit-prod-form').data("producto_id",$(this).data("producto_id"));
	});	
 	$('.modal-edit-producto').on('show.bs.modal', function (e) {
		$container=$('#edit-prod-form');
		var producto_id= $('#edit-prod-form').data("producto_id"),
		producto_id = parseInt(producto_id);
		if(producto_id>0){
			$.ajax({
				url:"paginas/producto/fcn/f_producto.php", // la URL para la petici&oacute;n
	            data: {metodo:"getProducto", id:producto_id}, // la informaci&oacute;n a enviar
	            type: 'POST', // especifica si ser&aacute; una petici&oacute;n POST o GET
	            dataType: 'json', // el tipo de informaci&oacute;n que se espera de respuesta
	            success: function (data) {
	            	// c&oacute;digo a ejecutar si la petici&oacute;n es satisfactoria;
	            	if (data.result === 'OK') { 
	            				$container.find('#proveedor').val(data.campos.p_proveedores_id);
				            	$container.find('#categoria').val(data.campos.p_productos_categorias_id);
				            	$container.find('#codigo').val(data.campos.p_codigo);
				            	$container.find('#precio').val(data.campos.p_precio_compra);
				            	$container.find('#descripcion').val(data.campos.p_descripcion);
		            }
	          	},// c&oacute;digo a ejecutar si la petici&oacute;n falla;
	            error: function (xhr, status) {
	            	SweetError(status);
	            }
	        });
	    }
	});
	$(".btn-edit-prod-submit").click(function(){
		var $container    = $(this).parents('.form-producto');
		$container.data('formValidation').validate();
	});
 $('#edit-prod-form').formValidation({
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
			precio: {validators : {
				notEmpty:{},	
				digits:{},
				stringLength : { max :  10},
				blank: {}}},
            codigo: {
                validators: {
                	notEmpty: {}
                }
            },
            descripcion: {
                validators: {
                	notEmpty: {}
                }
            },
            proveedor: {
                validators: {
                	notEmpty: {}
                }
            },
            categoria: {
                validators: {
                	notEmpty: {}
                }
            }
		}
	}).on('success.form.fv', function(e) {
		e.preventDefault();	
		var form = $(e.target);
		var fv = form.data('formValidation');
		var method = "&metodo="+$(this).data("method");
		var id = "&id="+$(this).data("producto_id");
		$.ajax({
			url: form.attr('action'), // la URL para la petición
            data: form.serialize() + method + id, // la información a enviar
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
						title: "Edici&oacute;n de Producto",
						text: "&iexcl;Producto Modificado Exitosamente!",
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
    });
    
    function getContainer () {
      var obj;
      if($('#tab-shop-activo').hasClass('active'))
      	obj=$('#tab-shop-activo');
      if($('#tab-shop-garantia').hasClass('active'))
      	obj=$('#tab-shop-garantia');
      if($('#tab-shop-facturado').hasClass('active'))
      	obj=$('#tab-shop-facturado');
      return obj;
    }
   /* $(document).on("click","#search-clear",function(e){
    	$(this).closest('form').get(0).reset();
    	$("#search-producto").submit();
    });*/
    $(document).on("change",".search-submit",function(e){
    	var $container= getContainer();
        var status= $container.data('status');
		paginar(1, $container, status,true);
    });
    $(document).on('keyup',"#txtBusqueda",function(e){
		var $container= getContainer();
        var status= $container.data('status');
		paginar(1, $container, status,true);
	});	
   /*$(document).on("submit","#search-producto",function(e){
    	e.preventDefault();
    	
	});*/
    $(document).on("click",".botonPagina",function(e){
		e.preventDefault();
		var pagina=$(this).data("pagina");		
		var $container= getContainer();
        var status= $container.data('status');		
		paginar(pagina, $container, status,false);
	});
	function actualizarPaginador($container){
        var method = 'metodo=paginar';
        var status= $container.data('status');
        var cantidad='&total_row='+$container.find('#cantidad_total_row').val();
		$.ajax({
			url:"paginas/producto/fcn/f_producto.php",
			data:method+cantidad ,
			type:"POST",
			dataType:"html",
			success:function(data){
				$container.find(" #paginacion").remove();
				$container.append(data);
			}
		});
	}
	function selectPagina($container, pagina){
		$container.find(" #paginacion li").removeClass("active");
		$container.find(" #paginacion").find('[data-pagina=' + pagina + ']').parent().addClass("active");
		$container.find(" #inicio").text(((pagina-1)*25)+1);
		if(total<pagina*25){
			$container.find(" #final").text(total + " de ");
		}else{
			$container.find(" #final").text(pagina*25 + " de ");
		}
		$container.find(" html,body").animate({
			scrollTop: 0
		}, 200);
		if(pagina % 10 == 1){
			$container.find(" #paginacion #anterior1").addClass("hidden");
		}else{
			$container.find(" #paginacion #anterior1").removeClass("hidden");
		}
		$container.find(" #paginacion").data("paginaactual",pagina);
		if(pagina*25>=total || pagina % 10==0){
			$container.find(" #paginacion #siguiente1").addClass("hidden");
		}else{
			$container.find(" #paginacion #siguiente1").removeClass("hidden");
		}
	}	
	$(document).on("click",".navegador",function(e){
		e.preventDefault();
		var $container= getContainer();
        var status= $container.data('status');
		var pagina=$("#paginacion").data("paginaactual");
		switch($(this).data("funcion")){
			case "anterior1":
				var actual=pagina - 1;
				pagina--;
				paginar(pagina,$container,status,false);
				break;
			case "siguiente1":
				var actual=pagina + 1;
				pagina++;
				paginar(pagina,$container,status,false);
				break;
		}
	});
  /********************FUNCIONES REALIZADAS PARA OPTIMIZAR EL LISTADO**************/
	function paginar(pagina, $container, status, flag){
		var categoria=$("#filter_categoria").val();
		var proveedor=$("#filter_proveedor").val();
		var busqueda=$("#txtBusqueda").val();
		loadingAjax(true);
		$.ajax({
			url:"paginas/producto/fcn/f_producto.php",
			data:{metodo:"buscar",pagina:pagina,status:status,categoria:categoria,proveedor:proveedor,busqueda:busqueda},
			type:"POST",
			dataType:"html",
			success:function(data){
				$container.find(" #ajaxContainer").html(data);				
				if(flag){
					actualizarPaginador($container);
				}else{
					selectPagina($container,pagina);
				}		
				loadingAjax(false);
				
				
			}
		});
	}
	
});