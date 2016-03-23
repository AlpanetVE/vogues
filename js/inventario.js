$(document ).ready(function() {
	 
	paginar(1, '#lista-prov-active');
	
	/****************Agregar Categoria**************/
	
	$('#reg-categoria-form').formValidation({
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
			categ_nombre : {validators : {
				notEmpty : {},
				stringLength : {min : 5, max : 512}}}
		
		}
	}).on('success.form.fv', function(e) {
		e.preventDefault();		
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
	            }else{
	            	if(data.result==='ok'){     			
            		swal({
						title: "Registro de Categoria",
						text: "&iexcl;Categoria Creada Exitosamente!",
						imageUrl: "galeria/img-site/logos/bill-ok.png",
						timer: 2000, 
						showConfirmButton: true
						}, function(){
							location.reload();
					});
					}	
            	}
          	},// código a ejecutar si la petición falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });
           
    });
	
  /******************************Fin agregar Categoria********************************/
 
  /**********************Modificar Categoria*********************/
 $("body").on('click', '.admin-edit-categ', function(e) {
	//	btnModalProveedor('#edit-prov-form');
		$('#update-categoria-form').data("categoria_id",$(this).data("categoria_id"));	
		      $('#upd_categ_nombre').val($(this).data("nombre-cate"));  
		//usuario que modificare      
	});
	
 $('#update-categoria-form').formValidation({
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
			upd_categ_nombre : {validators : {
				notEmpty : {},
				stringLength : {min : 5, max : 512}}}
		
		}
	}).on('success.form.fv', function(e) {
		e.preventDefault();		
		var form = $(e.target);
		var fv = form.data('formValidation');
		var method = "&metodo="+$(this).data("method");	
		var id= "&id="+$(this).data("categoria_id");	
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
	            }else{
	            	if(data.result==='ok'){     			
            		swal({
						title: "Modificacion de Categoria",
						text: "&iexcl;Categoria Modificada Exitosamente!",
						imageUrl: "galeria/img-site/logos/bill-ok.png",
						timer: 2000, 
						showConfirmButton: true
						}, function(){
							location.reload();
					});
					}	
            	}
          	},// código a ejecutar si la petición falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });
           
    });
 
/***** Eliminar Categoria *****/

 $("body").on('click', '.admin-elim-categ', function(e) {
		$('#delete-categoria-form').data("categoria_id",$(this).data("categoria_id"));	 
		
	});
 
 $('#delete-categoria-form').formValidation({
		
	}).on('success.form.fv', function(e) {
		e.preventDefault();		
		var form = $(e.target);
		var fv = form.data('formValidation');
		var method = "&metodo="+$(this).data("method");	
		var id= "&id="+$(this).data("categoria_id");	
		$.ajax({
			url: form.attr('action'), // la URL para la petición
            data: method + id, // la información a enviar
            type: 'POST', // especifica si será una petición POST o GET
            dataType: 'json', // el tipo de información que se espera de respuesta		           
            success: function (data) {
	           	if(data.result==='ok'){     			
            		swal({
						title: "Eliminado de Categoria",
						text: "&iexcl;Categoria Eliminada",
						imageUrl: "galeria/img-site/logos/bill-ok.png",
						timer: 2000, 
						showConfirmButton: true
						}, function(){
							location.reload();
					});
					}	
            	else{
            		SweetError("Error al eliminar");
            	}
          	},// código a ejecutar si la petición falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });
           
    });

 
 
/******** Fin eliminar Categoria  */


/********** Buscador **********/

$(document).on('keyup',"#txtBusquedaCateg",function(e){
	var nombre=$(this).val();
		paginar(1, '#lista-prov-active',0,nombre);
       //paginar(1, '#lista-prov-active',0);
	});	
/*-------Filtro Select ------------*/

$(document).on('change',"#filtrostatus",function(e){
		paginar(1, '#lista-prov-active',0);
	});	


 /*******************************MOSTRAR DETALLE PROVEEDOR******************************/	
 
  
	/********************FUNCIONES REALIZADAS PARA OPTIMIZAR EL LISTADO**************/
	function paginar(pagina, container, status, nombre){
		var total=$(container+" #paginacion").data("total"); 
		//loadingAjax(true);
		
		filtrostatus=$("#filtrostatus").val();
		nombre=$("#txtBusquedaCateg").val();
		//alert(filtro+'ey');
		
		/*if(nombre==''){
			nombre=null;
		}*/
		
		
		$.ajax({
			url:"paginas/inventario/fcn/f_categorias.php",
			data:{metodo:"buscar",pagina:pagina,total:total,orden:" ",status:status,nombre:nombre,filtrostatus:filtrostatus},
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
				//loadingAjax(false);
			}
		});
	}	
	
	$(document).on('click',".admin-add-categoria",function(e){
		var categoria=$(this).data("categoria_id");		
		$('#reg-prod-form').find('#categoria').val(categoria).prop("disabled",true);
	});

});