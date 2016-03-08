// Plugin de editor HTML

$(document).ready(function(){
		$('head').append('<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />');
		/* BUSQUEDA CALIENTE NO UTILIZADA EN ESTE MOMENTO
		 * 	usuarios_id=$("#busqueda").data("usuario");
		 
		if($(this).val()==""){
			$("#busqueda").html("");
			$("#busqueda").addClass("hidden");
		}else{
			palabra=$(this).val();
			$.ajax({
				url:"paginas/venta/fcn/f_ventas.php",
				data:{metodo:"busquedaCaliente",usuarios_id:usuarios_id,palabra:palabra},
				type:"POST",
				dataType:"html",
				success:function(data){
					console.log(data);
					$("#busqueda").html(data);
					$("#busqueda").removeClass("hidden");
				},
				error:function(xhr,status){
					console.log(status);
				}
			});
		}*/
	$('#editor').trumbowyg({
		lang : 'es'
	});
	$("#monto").autoNumeric({aSep: '.', aDec: ','});
	$("#ven-form-mod").formValidation({
		locale: 'es_ES',
		excluded: ':hidden',
		framework : 'bootstrap',
		icon : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		},
		addOns: { i18n: {} },
		err: { container: 'tooltip' },
		fields:{
			titulo:{validators:{
				notEmpty:{},
				stringLength:{min:10,max:60}}},
			stock:{validators:{
				notEmpty:{},
				between:{min:1,max:300}}},
			monto:{validators:{
				notEmpty:{},
				numeric:{thousandsSeparator: '.', decimalSeparator: ','}}}
		}
	}).on('success.form.fv',function(e){
		e.preventDefault();
		id=$("#btn-social-act").data("id");
		metodo=$("#btn-social-act").data("metodo");
		monto=$("#monto").val();
		monto=monto.replace(/\./g,"");
		monto=monto.replace(",",".");
		titulo=$("#titulo").val();
		stock=$("#stock").val();
		if(metodo=="actualizar"){
			mensaje="Se actualizo correctamente.";
		}else{
			mensaje="Tu publicacion ya esta disponible en nuestros listados.";
		}
		loadingAjax(true);
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:metodo,id:id,monto:monto,titulo:titulo,stock:stock},
			type:"POST",
			dataType:"html",
			success:function(data){
				loadingAjax(false);
           		swal({
					title: "Exito", 
					text: mensaje,
					imageUrl: "galeria/img-site/logos/bill-ok.png",
					timer: 2000, 
					showConfirmButton: true
					}, function(){
						$("#info-publicacion").modal('hide');
						document.location.reload();
					});
			}
		});
	});	
	
	
	/*
	 * Controlas la pesta&oacute;as de mis publicaciones (activas, pausadas, inactivas)
	*/
	
	$(".pesta").click(function(){
		switch($(this).attr("id")){
			case "irActivas":				    
			    $("#irPausadas").removeClass("active");
			    $("#irFinalizadas").removeClass("active");
			    $(this).addClass("active");
			    var tipo=1;
				break;
			case "irPausadas":	
			    $("#irActivas").removeClass("active");			
			    $(this).addClass("active");
			    $("#irFinalizadas").removeClass("active");
			   
			    var tipo=2;				
				break;
			case "irFinalizadas":
			    $("#irPausadas").removeClass("active");
			    $("#irActivas").removeClass("active");
			    $(this).addClass("active");
			    
			    var tipo=3;
				break;
		}	
		var order= "id "+$("#filtro").val(); 
		var pagina=1;
		loadingAjax(true);
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:"buscarPublicaciones",tipo:tipo,pagina:pagina,order:order},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
				$("#publicaciones").html(data);
				loadingAjax(false);
			}
		});
	});
	$("#filtro").change(function(){	 
		var tipo;
		if($("#irActivas").hasClass('active')){
			tipo=1; 
		}else if($("#irPausadas").hasClass('active')){
			tipo=2;
		}else if($("#irFinalizadas").hasClass('active')){
			tipo=3;
		}  
		var order= "id "+$("#filtro").val();
		var pagina=1;
		loadingAjax(true);
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:"buscarPublicaciones",tipo:tipo,order:order,pagina:pagina},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
				$("#publicaciones").html(data);
				loadingAjax(false);
			}
		});
	});
	$("#verMas").click(function(e){
		montoFormateado=$("#monto").val();
	//	montoFormateado=montoFormateado.replace(".",",");
		$("#txtTitulo").attr("value",$("#titulo").val());
		$("#txtCantidad").attr("value",$("#stock").val());
		$("#txtPrecio").attr("value",parseInt(montoFormateado));
		$("#editor").html($("#btn-social-act").data("descripcion"));
		$("#info-publicacion").modal('hide');
		var cantidad=$("#stock").val();
		var precio=$("#monto").val();
		var precio=montoFormateado;
		var titulo=$("#titulo").val();
		var descripcion=$("#descripcion_"+id).val();
		$.ajax({
			url:"paginas/venta/fcn/f_edit_publicaciones.php",
			data:{id:id,cantidad:cantidad,precio:precio,titulo:titulo,descripcion:descripcion},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
				$("#primero").html(data);
				$("#btn-social-act").data("dismiss","modal");
				$('#editor').trumbowyg({
					lang : 'es'
				});
				$("#txtPrecio").autoNumeric({aSep: '.', aDec: ','});
				//Validator del formulario
				$("#pub-form-reg").formValidation({
					locale: 'es_ES',
					excluded: ':hidden',
					framework : 'bootstrap',
					icon : {
						valid : 'glyphicon glyphicon-ok',
						invalid : 'glyphicon glyphicon-remove',
						validating : 'glyphicon glyphicon-refresh'
					},
					addOns: { i18n: {} },
					err: { container: 'tooltip' },
					fields:{
						txtTitulo:{validators:{
							notEmpty:{},
							stringLength:{min:10,max:60}}},
						txtCantidad:{validators:{
							notEmpty:{},
							between:{min:1,max:300}}},
						txtPrecio:{validators:{
							notEmpty:{},
							numeric:{thousandsSeparator: '.', decimalSeparator: ','}}}
						}
				}).on('success.form.fv',function(e){
					e.preventDefault();
	                var fotos = "";
					$('.foto').each(function(index) {
						if($(this).children("img").attr("src") !== undefined){							
							fotos = "&foto-"+index+"="+$(this).children("img").attr("src")+fotos;
						}
					});
					monto=$("#txtPrecio").val();
					monto=monto.replace(/\./g,"");
					monto=monto.replace(",",".");
//					form = $("#pub-form-reg").serialize() + "&id=" + id +"&fecha=" + $("#txtFecha").val()+"&monto="+$("#txtPrecio").autoNumeric("get")+"&metodo=actualizarPub"+fotos;
					form = $("#pub-form-reg").serialize() + "&id=" + id + "&monto=" + monto + "&metodo=actualizarPub"+fotos;
					$.ajax({
						url:"paginas/venta/fcn/f_ventas.php",
						data:form,
						type:"POST",
						dataType:"html",
						success:function(data){
							//location.href="ventas.php";
//							alert("kdkdkdk");
	            		swal({
							title: "Exito", 
							text: "Se actualizo correctamente.",
							imageUrl: "galeria/img-site/logos/bill-ok.png",
							timer: 2000, 
							showConfirmButton: true
							}, function(){
								window.open("detalle.php?id=" + id,"_self");
							});							
						}						
					});
		        }).on('prevalidate.form.fv',function(e){				
					if($("#1").attr("src") === undefined){
						$("#fotoprincipal").val("false");
						$(".foto").first().tooltip("show");
						return false;
					}else{
						$("#fotoprincipal").val("true");
						$(".foto").first().tooltip("destroy");
					}
				});
				//Final del validator
				$("#txtPrecio").keydown(function(){
					$('#pub-form-reg').formValidation('revalidateField', 'txtPrecio');
				});	
				var contador=0;
				$('.foto').each(function(){
					if($(this).children("img").attr("src")!="" && $(this).children("img").attr("src")!=undefined){
						contador++;
						$(this).children("img").attr("id",contador);
						if(contador>1){
							$(this).children("i").removeClass("hidden");
						}
					}
				});	
			}
		});
	});
	//Inicia el cropit
	$("#primero").on("click", ".foto", function(e) {
		if($(e.target).is('i')){   //Significa que va a eliminar una foto
			var index = $(this);
			$(this).children("img").removeAttr('src');
			$(this).children("img").removeAttr("id");
            $(this).children("i").addClass('hidden');
            $(this).css("background","");
			$('.foto').each(function(i, obj){
				if($(this).children("img").attr("src") === undefined && $(this).next().children("img").attr("src") !== undefined){
					$(this).children("img").attr("src",$(this).next().children("img").attr("src"));
					$(this).css("background","transparent");
					$(this).children("img").attr("id",i+1);
					$(this).next().children("img").removeAttr("src");
					$(this).next().children("img").removeAttr("id");
		            $(this).next().children("i").addClass('hidden');
		            $(this).next().css("background","");
		            $(this).addClass("subir-img");
				}
			});
      }else{  //Significa que va a buscar una foto
        	var numero = $(this).children("img").attr("id");
			if(numero !== undefined){
				$("#save-foto").data("nro",numero);
			}
			$('.cropit-image-input').click();
        }		
	});
	/*
	 * Captura el cambio del input
	 */
	$(document).on("change", ".cropit-image-input", function() {
		var file = this.files[0];
		var imageType = "image";
		if (file.type.substring(0,5) == imageType) {
			var reader = new FileReader();
			reader.onload = function(e) {
				// Create a new image.
				var img = new Image();
				// Set the img src property using the data URL.
				img.src = reader.result;
				// Add the image to the page.
				$(".cropit-image-input").val("");
				$('#cropper').modal("show");
				$('#usr-reg-title').html("Edita la foto de tu producto");
			};
			reader.readAsDataURL(file);			
		} else {
			SweetError("Archivo no soportado.");
		}		
	});	
	/*
	 * Revalidar el campo txtPrecio para que funcione con el validador.
	 */
	$("#cambiar-foto").click(function(){
		$("#cropper").modal("hide");
		$('.cropit-image-input').click();
	});
	$("#primero").on('change','#txtPrecio',function(){
		$('#pub-form-reg').formValidation('revalidateField', 'txtPrecio');
	});
	$("#monto").keydown(function(){		
		$('#ven-form-mod').formValidation('revalidateField', 'monto');
	});	
	//Finaliza el cropit
	$("#primero").on("click", "#chkGarantia", function() {
		if ($("#chkGarantia").attr("value") == 0 || $("#chkGarantia").attr("value")==undefined) {
			$("#chkGarantia").attr("value", 1);
			$("#cmbGarantia").css("display", "block");
			$("#cmbGarantia").focus();
		} else {
			$("#chkGarantia").attr("value", 0);
			$("#cmbGarantia").css("display", "none");
		}
	});
	$("#publicaciones").on("click",".imagen",function(){
		window.open("detalle.php?id=" + $(this).data("id"),"_self");
	});		
	$(document).on("click",".botonPagina",function(){
		var orden=$("#filter").val();
		var pagina=$(this).data("pagina");
		var palabra=$("#txtBusqueda").val();
		var metodo=$("#paginas").data("metodo");
		var id=$("#paginas").data("id");
		var tipo=$("#paginas").data("tipo");
		var order= "id "+$("#filtro").val();
		$(".pagination li").removeClass("active");
		$(this).parent().addClass("active");
		loadingAjax(true);
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:metodo,orden:orden,palabra:palabra,pagina:pagina,id:id,tipo:tipo,order:order},
			type:"POST",
			dataType:"html",
			success:function(data){
				$("#publicaciones").html(data);
				loadingAjax(false);
			},
			error:function(xhr,status){
				loadingAjax(false);
			}
		});
	});
	$("#ventas").css("display","block");
	$("#uno1").addClass("active");
	});