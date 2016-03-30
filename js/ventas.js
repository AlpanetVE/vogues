// Plugin de editor HTML

$(document).ready(function(){
	$(document).prop('title', $(".titulo").html());
	var pagos="";
	var actual=0;
	var total=0;	
	var swenvios=0;
	$('head').append('<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />');
	$('#editor').trumbowyg({
		lang : 'es'
	});	
	var tipo=$("#principal").data("tipo"); 
	$.ajax({
		url:"paginas/venta/fcn/f_ventas.php",
		data:{metodo:"buscarPublicaciones",tipo:tipo,pagina:1},
		type:"POST",
		dataType:"html",
		success:function(data){
			$("#publicaciones").html(data);
//				loadingAjax(false);
		}
	});
	$("#monto").autoNumeric({aSep: '.', aDec: ','});
	$("#btn-informar").addClass("hidden");
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
	 * Controlas la pestanas de mis publicaciones (activas, pausadas, inactivas)
	*/
	
	$(".pesta").click(function(){
		switch($(this).attr("id")){
			case "irActivas":				    
			    var tipo=1;
				break;
			case "irPausadas":
			    var tipo=2;				
				break;
			case "irFinalizadas":
			    var tipo=3;
				break;
		}
		$(this).parent().children("li").removeClass("active");
	    $(this).addClass("active");
		var pagina=1;
		loadingAjax(true);
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:"buscarPublicaciones",tipo:tipo,pagina:pagina},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
				$("#publicaciones").html(data);
				loadingAjax(false);
			}
		});
	});
	$(".pesta-ventas").click(function(){
		if($("#sin-concretar").hasClass("hidden")){
			$("#sin-concretar").removeClass("hidden");
			$("#concretadas").addClass("hidden");
			$("#paginacion").removeClass("hidden");
			$("#paginacion2").addClass("hidden");			
		}else{
			$("#sin-concretar").addClass("hidden");
			$("#concretadas").removeClass("hidden");
			$("#paginacion2").removeClass("hidden");
			$("#paginacion").addClass("hidden");
		}
		$(".pesta-ventas").removeClass("active");
		$(this).addClass("active");
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
		var fb = $("#fb").data("");
		var descripcion=$("#btn-social-act").data("descripcion");
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
					form = $("#pub-form-reg").serialize() + "&id=" + id + "&monto=" + monto + "&metodo=actualizarPub"+fotos+"&fb="+$("#fb").data("fb")+"&tt="+$("#tt").data("tt")+"&fp="+$("#fp").data("fp")+"&gr="+$("#gr").data("gr");
					loadingAjax(true);
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
								window.open("ventas/admin","_self");
							});
							loadingAjax(false);							
						}			
					});
		        }).on('prevalidate.form.fv',function(e){				
					if($(".foto").children("img#1").attr("src")===undefined){
						$("#fotoprincipal").val("false");
						$(".foto").first().tooltip("show");
						return false;
					}else{
						$("#fotoprincipal").val("true");
						$(".foto").first().tooltip("destroy");
					}
				}).on('err.field.fv', function(e, data) {
		            if (data.fv.getSubmitButton()) {
		                data.fv.disableSubmitButtons(false);
		            }
		            if($("#txtTitulo").val().length<10){
		        		$("#rs_acpt").css("visibility","hidden");
		        		$("#redes").hide();
		        		$("#i"+rs).hide("swing");
		        		}	        	
		        })
		        .on('success.field.fv', function(e, data) {
		            if (data.fv.getSubmitButton()) {
		                data.fv.disableSubmitButtons(false);
		            }
		        }).on('success.field.fv', function(e){
		        	if($("#txtTitulo").val().length>=10 && $("#txtTitulo").val().length<=60){
		        		$("#rs_acpt").css("visibility","visible");
		        		if($("#checkbox").is(":checked"))
							$("#redes").show();
		        	}
		        });;
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
	
	$("#primero").on('click','#checkbox',function(){
		if($("#checkbox").is(":checked")){
		$("#redes").show();
		}else{
		$("#redes").css("display","none");
		}
	});
	
	$("#primero").on('click','.btn-default-rs',function(e){
		e.preventDefault();
		var rs= $(this).data("rs");
		if($("#i"+rs).css("display")=="none"){
			$("#"+rs).attr("data-"+rs,"1");
			$("#i"+rs).show("swing");
		}else{
			$("#"+rs).attr("data-"+rs,"0");
			$("#i"+rs).hide("swing");
		}
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
	
/*	$('#primero').on('click',"#fp",function(){
		alert("ok");
				if(manager_tiene_fbp || gettin_fbp_add)
					return false;
				gettin_fbp_add=true;
				$.ajax({
					url: "fcn/f_manager/fb_get_pages.php",
					method: "GET",
					cache:false,
					dataType: "json"
				}).done(function(d){
					gettin_fbp_add=false;
					switch(d.e){
						case 0:
							var ll=d.p.length,arr=d.p,item=false,i=0,j=0,str=[];
							if(ll>0){
								for(;i<ll;i++){
									item=arr[i];
									str[j++]='<li><input type="radio" style="width: 20px; height: 20px;" value="'+item.i+'" name="fan-page" /><img src="'+item.p+'" style="width: 50px; height: 50px;" class="marL10" /><span class="marL10">'+item.n+'</span></li>';
								}
								$("ul#fan_page_list").html(str.join(''));
							}else{
								//no hay fan pages
							}
							break;
						case 1:
							//usuario no tiene cuenta de fb
							break;
						case 2:
							//usuario ya tiene un fan page
							break;
						case 3:
							//error del sdk
							break;
					}
				}).fail(function(a,b,d){
					gettin_fbp_add=false;
				});
				vincularfanpage();				
			});
	
	$('#primero').on('click',"#fb",function(){
				if(doing_fb_app || manager_tiene_fb)
					return false;
				else
					doing_fb_app=true;
			
				FB.login(function(response){
					if (response.status === 'connected') {
						$.ajax({
							url: "fcn/f_manager/fbjscb.php",
							method: "GET",
							data:{
								state:2,
							},
							cache:false,
							dataType: "json"
						}).done(function(d){
							doing_fb_app=false;
							switch(d.e){
								case 0:
									manager_tiene_fb={
										i : d.d,
										n : d.fn + " "+ d.ln,
										p : d.p
									};
									//updateFbButton();
									break;
								case 1:
									//cuenta no pertenece a nadie
									break;
								case 2:
									//cuenta no dio los permisos requeridos
									break;
								case 3:
									//error al insertar cuenta en la base de datos
									break;
								case 4:
									//error del sdk
									break;
								case 5:
									//El usuario ya tiene otra cuenta de fb vinculada
									break;
							}
						}).fail(function(a,b,d){
							doing_fb_app=false;
							//mostrar mensaje de error de conexi�n correspondiente
						});
					} else if (response.status === 'not_authorized') {
						//mostrar error de autorizaci�n
						doing_fb_app=false;
					} else {
						//mostrar error de conexi�n a fb
						doing_fb_app=false;
					}
				},{auth_type:'reauthenticate',scope:scopes});
				return false;
			});

	
	ap_twa_cb = function(d){
				clearInterval(twapt);
				switch(d.e){
					case 0:
						manager_tiene_tw = {
							i : d.d,
							n : d.n,
							p : d.i
						};
						//updateTwButton();
						break;
					case 1:
						//cuenta no pertenece a nadie
						break;
					case 2:
						//cuenta no dio los permisos requeridos
						break;
					case 3:
						//error al insertar cuenta en la base de datos
						break;
					case 4:
						//error del sdk
						break;	
				}
			};
	function vincularfanpage(){
		$("#fan-page").modal("show");
	}
	function checkTwapC(){
		if(twapt.closed){
			clearInterval(twapt);
		}
	}
	
	$("#primero").on("click", "#tt", function() {
		var left = (screen.width/2)-(500/2),top = (screen.height/2)-(500/2);
		twapc=window.open('//apreciodepana.com/fcn/f_manager/add_tw.php?state=2','','toolbar=no, location=no, directories=no, status=no, menubar=no, copyhistory=no, width=500, height=500, top='+top+', left='+left);
		twapt=setInterval(checkTwapC,500);
	});*/
	
	$("#publicaciones").on("click",".imagen",function(){
		window.open("publicacion-" + $(this).data("id"),"_self");
	});
	$(document).on("click",".botonPagina",function(){
		var orden=$("#filter").val();
		var pagina=$(this).data("pagina");
		var palabra=$("#txtBusqueda").val();
		var metodo=$("#paginas").data("metodo");
		var id=$("#paginas").data("id");
		var tipo=$("#paginas").data("tipo");
		$(".pagination li").removeClass("active");
		$(this).parent().addClass("active");
		loadingAjax(true);
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:metodo,orden:orden,palabra:palabra,pagina:pagina,id:id,tipo:tipo},
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
	$(document).on("click",".botonPaginaventas",function(){
		var pagina=$(this).data("pagina");
		var elemento=$(this);
		if($("#sin-concretar").hasClass("hidden")){
			var eldiv=$("#concretadas");
			var origen=3;
			var metodo="paginar2";
		}else{
			var eldiv=$("#sin-concretar");
			var origen=1;
			metodo="paginar1";
		}
		var orden=$("#filtro").val();		
		loadingAjax(true);
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:metodo,pagina:pagina,origen:origen,orden:orden},
			type:"POST",
			dataType:"html",
			success:function(data){
				if(origen==1){
					$('#paginacion').find('li').removeClass("active");
				}else{
					$('#paginacion2').find('li').removeClass("active");
				}
				elemento.parent().addClass("active");
				eldiv.html(data);
				loadingAjax(false);
			}
		});
	});
	$(document).on("click",".vinculopagos",function(){
		var id=$(this).attr("id").substr(4);
		if($(this).data("target")==="#pagos-ven2"){
			var pagina="paginas/venta/fcn/f_pagos2.php";
			var elDiv=$("#ajaxcontainer2");
		}else{
			var pagina="paginas/venta/fcn/f_pagos.php";
			var elDiv=$("#ajaxcontainer");
		}
		$.ajax({
			url : pagina,
			data : {id:id},
			type : "POST",
			dataType : "html",
			success : function(data){
				elDiv.html(data);
				actual=id;
			}
		});
	});
	$("#ventas").css("display","block");	
	switch($('body').data("tipo")){
		case 1:
			$("#uno1").addClass("active");
			break;
		case 2:
			$("#uno2").addClass("active");
			break;
//		case 3:
//			$("#uno3").addClass("active");
//			break;		
	}
	$("#ajaxcontainer").on("click",".boton-status",function(e){
		//fa fa-clock-o naranja-apdp
		//fa fa-thumbs-o-up verde-apdp
		//fa fa-remove rojo-apdp
		e.preventDefault();
		if($(this).data("indice")==1){
			return false;
		}
		var id=$(this).data("id");
		var anterior=$("#primero" + id).text();
		if(pagos!="")
		pagos+=",";		
		pagos+=id + " ";
		pagos+=$(this).data("texto");	
		$("#primero" + id).text($(this).data("texto"));
		$("#iconoa" + id).removeClass();
		$("#iconob" + id).removeClass();
		$("#iconoc" + id).removeClass();		
		if($(this).data("texto")=="Pendiente"){
			$("#iconoa" + id).addClass("fa fa-clock-o naranja-apdp");
			$("#iconob" + id).addClass("fa fa-thumbs-o-up verde-apdp");
			$("#iconoc" + id).addClass("fa fa-remove rojo-apdp");
			$("#segundo" + id).text("Verificar");
			$("#tercero" + id).text("Rechazar");			
			$(this).data("texto","Verificado");
			$(this).next().data("texto","Rechazado");
		}else if($(this).data("texto")=="Verificado"){
			$("#iconoa" + id).addClass("fa fa-thumbs-o-up verde-apdp");
			$("#iconob" + id).addClass("fa fa-clock-o naranja-apdp");
			$("#iconoc" + id).addClass("fa fa-remove rojo-apdp");						
			$("#segundo" + id).text("Pendiente");
			$("#tercero" + id).text("Rechazar");
			if($(this).data("indice")==2){			
				$(this).data("texto","Pendiente");
				$(this).next().data("texto","Rechazado");
			}else{
				$("#iconoa" + id).addClass("fa fa-clock-o naranja-apdp");				
				$(this).prev().data("texto","Pendiente");
				$(this).data("texto","Rechazado");				
			}
		}else if($(this).data("texto")=="Rechazado"){
			$("#iconoa" + id).addClass("fa fa-remove rojo-apdp");
			$("#iconob" + id).addClass("fa fa-clock-o naranja-apdp");
			$("#iconoc" + id).addClass("fa fa-thumbs-o-up verde-apdp");
			$("#segundo" + id).text("Pendiente");
			$("#tercero" + id).text("Verificado");		
			$(this).data("texto","Verificado");
			$(this).prev().data("texto","Pendiente");
		}
	});
	$("#btn-guardar").click(function(){
		if(pagos!=""){
			loadingAjax(true);
			$.ajax({
				url:"paginas/venta/fcn/f_ventas.php",
				data:{metodo:"actualizarPagos",pagos:pagos,id:actual},
				type:"POST",
				dataType:"html",
				success:function(data){
					loadingAjax(false);
					pagos="";
					console.log(data);					
					$("#pago" + actual + ">span").html(data);
					$("#pago" + actual + ">i").first().removeClass();
					switch(data){
						case "Pago verificado":
							$("#pago" + actual + ">i").first().addClass("fa fa-credit-card verde-apdp");
							break;
						case "Pago incompleto":			
							$("#pago" + actual + ">i").first().addClass("fa fa-credit-card naranja-apdp");
							break;
						case "Pago rechazado":		
							$("#pago" + actual + ">i").first().addClass("fa fa-credit-card rojo-apdp");						
							break;
						case "Pago pendiente":
							$("#pago" + actual + ">i").first().addClass("fa fa-credit-card amarillo-apdp");						
							break;							
					}
				}
			});
		}
	});
	$(document).on("click",".vinculoenvios",function(e){
		e.preventDefault();
		var id=$(this).attr("id").substr(5);
		var maximo=$(this).data("maximo");
		//var status=$(this).data("status");
		var status=$("#pago" + id + ">span").first().text();
		if(status!="Pago verificado"){			
			return false;
		}
		$("#envios-ven").modal('show');
		$.ajax({
			url : "paginas/venta/fcn/f_envios.php",
			data : {id:id},
			type : "POST",
			dataType : "html",
			success : function(data){
				$("#ajaxcontainer3").html(data);
				$("#p_cantidad").attr("max",maximo);
				actual=id;
				if(maximo<=0){
					$("#btn-agregar-guia").addClass("hidden");
				}else{
					$("#btn-agregar-guia").removeClass("hidden");
				}
				if(swenvios==0){
					vincularEnvios();
					swenvios=1;
				}
			}
		});
	});
	$("#envios-ven").on("hidden.bs.modal",function(){
		$("#btn-guardar-guia").addClass("hidden");
		$("#frm-envios").slideUp();
	});
	$(document).on("click",".vinculodescuento",function(){
		actual=$(this).attr("id").substr(4);
		total=$(this).data("monto");
		$("#frm-reg-desc").formValidation({
			locale: 'es_ES',
			excluded: ':hidden',
			framework : 'bootstrap',
			icon : {
				valid : 'glyphicon glyphicon-ok',
				invalid : 'glyphicon glyphicon-remove',
				validating : 'glyphicon glyphicon-refresh'
			},
			addOns: { i18n: {} },
			err: { container: 'tooltip',  },
			fields:{
				p_descuento:{validators:{
					notEmpty:{},
					between:{min:1,max:total}}}
			}
			}).on('success.form.fv',function(e){
					monto=$("#p_descuento").val();
					e.preventDefault();
					$.ajax({
						url:"paginas/venta/fcn/f_ventas.php",
						data:{metodo:"guardarDescuento",id:actual,monto:monto},
						type:"POST",
						dataType:"html",
						success:function(data){
							$("#pago" + actual + ">span").text(data);
							$("#pago" + actual + ">i").removeClass();
							switch(data){
								case "Pago pendiente":
									$("#pago" + actual + ">i").addClass("fa fa-credit-card amarillo-apdp");								
									break;
								case "Pago rechazado":
									$("#pago" + actual + ">i").addClass("fa fa-credit-card rojo-apdp");
									break;
								case "Pago verificado":
									$("#pago" + actual + ">i").addClass("fa fa-credit-card verde-apdp");
									break;
								case "Pago incompleto":
									$("#pago" + actual + ">i").addClass("fa fa-credit-card naranja-apdp");
									break;
							}						
						}
					});
					$("#descuento").modal('hide');
			});		
	});
	$(document).on("click",".vinculocomentario",function(){
		$("#p_comentario").val($(this).data("nota"));
		actual=$(this).attr("id").substr(5);
		$("#frm-reg-comentario").formValidation({
			locale: 'es_ES',
			excluded: ':hidden',
			framework : 'bootstrap',
			icon : {
				valid : 'glyphicon glyphicon-ok',
				invalid : 'glyphicon glyphicon-remove',
				validating : 'glyphicon glyphicon-refresh'
			},
			addOns: { i18n: {} },
			err: { container: 'tooltip'  },
			fields:{
				p_comentario:{validators:{
					notEmpty:{}}}
			}
			}).on('success.form.fv',function(e){
				e.preventDefault();
				var nota=$("#p_comentario").val();
				$.ajax({
					url:"paginas/venta/fcn/f_ventas.php",
					data:{metodo:"guardarComentario",id:actual,nota:nota},
					type:"POST",
					dataType:"html",
					success:function(data){
						console.log(data);
						$("#comen" + actual).data("nota",nota);
						$("#comentario").modal('hide');
					}
				});
		});
	});
	$("#btn-agregar-guia").click(function(e){
		e.preventDefault();
		$(this).addClass("hidden");
		$("#btn-guardar2").addClass("hidden");
		$("#btn-guardar-guia").removeClass("hidden");
		$("#frm-envios").slideDown();
	});
	function validacion(){
		swal({
			title: "Falta datos importantes",
			text: "Algunos de los valores necesarios estan vacios",
			imageUrl: "galeria/img-site/logos/bill-ok.png",
			showConfirmButton: true
			}, function(){		
				//document.location.href = 'detalle.php?id='+data.id;
			});
	}
	function vincularEnvios(){
			$("#frm-reg-envios").formValidation({
				locale: 'es_ES',
				excluded: ':hidden',
				framework : 'bootstrap',
				icon : {
					valid : 'glyphicon glyphicon-ok',
					invalid : 'glyphicon glyphicon-remove',
					validating : 'glyphicon glyphicon-refresh'
				},
				addOns: { i18n: {} },
				err: { container: 'tooltip',  },
				fields:{
					p_cantidad:{validators:{
						digits:{},
						notEmpty:{}}},
					p_agencia:{validators:{					
						callback:{
							message:"Seleccione una agencia de la lista",
							callback:function(value,validator,$field){
							if($("#p_agencia").val()=='0')
								return false;
							else
								return true;
							}
							}
						}
					},
					p_numero:{validators:{
						digits:{},							
						notEmpty:{}}},
					p_direccion:{validators:{
						notEmpty:{}}}
					}
			}).on('success.form.fv',function(e){
				e.preventDefault();
				var form = $(e.target);
				form=$("#frm-reg-envios").serialize() + "&metodo=guardarEnvio&id=" + actual;
				$.ajax({
					url : "paginas/venta/fcn/f_ventas.php",
					data : form,
					type : "POST",
					dataType : "html",
					success : function(data){
						console.log(data);
						$("#ajaxcontainer3").load("paginas/venta/fcn/f_envios.php",{id:actual});
						var faltante=$("#p_cantidad").attr("max") - $("#p_cantidad").val();
						$("#envio" + actual).data("maximo",faltante);
						if(faltante==0){
							$("#p_cantidad").attr("max",faltante);
							$("#p_cantidad").val("");
							$("#p_direccion").val("");
							$("#p_numero").val("");
							$("#p_fecha").val("");
							$("#p_monto").val("");
							$("#p_agencia").val("0");
							swal({
								title: "Envio cargado",
								text: "El comprador sera notificado.",
								imageUrl: "galeria/img-site/logos/bill-ok.png",
								showConfirmButton: true
							});
							$("#envios-ven").modal("hide");						
							$("#envio" + actual + ">span").first().text("Enviado");
							$("#envio" + actual + ">i").first().removeClass("rojo-apdp naranja-apdp");
							$("#envio" + actual + ">i").first().addClass("verde-apdp");
							$("#concretadas").append($("#venta" + actual));
							var t1=parseInt($("#titulo1").text());
							$("#titulo1").text(t1-1);
							var t2=parseInt($("#titulo2").text());
							$("#titulo2").text(t2+1);								
							return false;
						}
						$("#p_cantidad").attr("max",faltante);
						$("#p_cantidad").val("");
						$("#p_direccion").val("");
						$("#p_numero").val("");
						$("#p_fecha").val("");
						$("#p_monto").val("");
						$("#p_agencia").val("0");
						$("#btn-agregar-guia").removeClass("hidden");
						$("#btn-guardar2").removeClass("hidden");
						$("#btn-guardar-guia").addClass("hidden");
						$("#envio" + actual + ">span").first().text("En camino");
						$("#envio" + actual + ">i").first().removeClass("naranja-apdp rojo-apdp");
						$("#envio" + actual + ">i").first().addClass("naranja-apdp");							
					}
				});
				$("#frm-envios").slideUp();
	       });		
	}
	$(document).on("change","#filtro-pub",function(){
		var orden=$(this).val();
		var tipo=$("#principal").data("tipo");
		loadingAjax(true);
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:"buscarPublicaciones",tipo:tipo,orden:orden},
			type:"POST",
			dataType:"html",
			success:function(data){
				$("#publicaciones").html(data);
				loadingAjax(false);
			}
		});
	});
	$(document).on("change","#filtro",function(){
		if($("#sin-concretar").hasClass("hidden")){
			var eldiv=$("#concretadas");
			var origen=2;
		}else{
			var eldiv=$("#sin-concretar");
			var origen=1;
		}
		var orden=$(this).val();
		loadingAjax(true);
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:"ordenar",orden:orden,origen:origen},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);				
				eldiv.html(data);				
				if(origen==1){
					$('#paginacion').find('li').removeClass("active");
					$("#paginacion").find('li').first().next().addClass("active");				
				}else{
					$('#paginacion2').find('li').removeClass("active");
					$("#paginacion2").find('li').first().next().addClass("active");				
				}
				loadingAjax(false);
			}
		});
	});
	/*
	$("#principal").on("keyup","#txtBuscar",function(){
		if($(this).val()!=""){
			var c=0;
			var valor=$(this).val().toUpperCase();			
			$(".general").each(function(i){
				var titulo=$(this).data("titulo").toUpperCase();				
				if(titulo.indexOf(valor)==-1) {
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
	*/
});