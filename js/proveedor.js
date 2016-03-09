$(document ).ready(function() {
	
	/********************REGISTRAR PROVEEDOR**************/
	$('.reg-prov-form').formValidation({
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
			prov_telefono : {validators : {
				notEmpty : {},
				phone : {country:'VE'}}},
			prov_email : {validators : {
				notEmpty : {},
				emailAddress : {},
				blank: {}}},
			prov_direccion : {validators : {
				notEmpty : {},
				stringLength : {min: 10,max : 1024}}}	
					
		}
	}).on('success.form.fv', function(e) {
		e.preventDefault();				
		var form = $(e.target);
		var fv = form.data('formValidation');
		var method = "&method="+$(this).data("method");
		
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