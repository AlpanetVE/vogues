// Plugin de editor HTML
$(document).ready(function(){
	var pagos="";
	var sw=0;
	$("#compras").css("display","block");
	$("#pagos-ven #titulo").text("Pagos");
//	switch($('body').data("tipo")){
//		case 1:
//			$("#uno1").addClass("active");
//			break;
//		case 2:
//			$("#uno2").addClass("active");
//			break;
//		case "":
			$("#dos3").addClass("active");
//			break;
//	}
 	$(".pesta-compras").click(function(){
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
		$(".pesta-compras").removeClass("active");
		$(this).addClass("active");
	});
	$(document).on("click",".vinculoenvios",function(){
		var id=$(this).attr("id").substr(5);
		$("#envios-ven").modal('show');
		$.ajax({
			url : "paginas/compra/fcn/f_envios.php",
			data : {id:id},
			type : "POST",
			dataType : "html",
			success : function(data){
				$("#btn-agregar-guia").addClass("hidden");
//				$("#btn-guardar2").addClass("hidden");
//				$("#btn-guardar-guia").removeClass("hidden");
				$("#ajaxcontainer3").html(data);
				actual=id;
			}
		});
	});	
	$("#lista-pagos").on("click",".boton-status",function(){
		//fa fa-clock-o naranja-apdp
		//fa fa-thumbs-o-up verde-apdp
		//fa fa-remove rojo-apdp
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
			id=$("#lista-pagos").data("id");
			$.ajax({
				url:"paginas/venta/fcn/f_ventas.php",
				data:{metodo:"actualizarPagos",pagos:pagos,id:id},
				type:"POST",
				dataType:"html",
				success:function(data){
					loadingAjax(false);
					document.location.reload();
				}
			});
		}
	});	
	$("#btn-add-guia").click(function(){
		$("#frm-envios").slideDown();
		$("#btn-agregar-guia").addClass("hidden");
		$("#btn-guardar2").addClass("hidden");
		$("#btn-guardar-guia").removeClass("hidden");
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
							if($("#p_agencia").val()=='0'){
								return false;
							}else{
								return true;
							}
						}
					}
					}
				},
				p_numero:{validators:{
					digits:{},
					notEmpty:{}}},							
				p_direccion:{validators:{
					stringLength : {min: 10,max : 1024}}}
				}
		}).on('success.form.fv',function(e){
			e.preventDefault();
			var form = $(e.target);
			form=$("#frm-reg-envios").serialize() + "&metodo=guardarEnvio&id=" + $("#lista-pagos").data("id");
			$.ajax({
				url : "paginas/venta/fcn/f_ventas.php",
				data : form,
				type : "POST",
				dataType : "html",
				success : function(data){
					console.log(data);
					var nuevaFila="<div class='tabla-detalle2 row text-center'><div class='col-xs-12 col-sm-2 col-md-2 col-lg-2 ' >" + $("#p_fecha").val() + "</div>";
					nuevaFila+="<div class='col-xs-12 col-sm-2 col-md-2 col-lg-2 ' >" + $("#p_cantidad").val() + "</div>";
					nuevaFila+="<div class='col-xs-12 col-sm-2 col-md-2 col-lg-2'>" + $("#p_agencia option:selected").html() + "</div>";
					nuevaFila+="<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>" + $("#p_numero").val() + "</div>";
					nuevaFila+="<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3 '> ver</div></div>";
//					var nuevaFila='<tr><td align="center">' + $("#p_fecha").val() + '</td><td align="center">' + $("#p_cantidad").val();
//					nuevaFila+='</td><td align="center">' + $("#p_agencia option:selected").html() + '</td><td align="center">' + $("#p_numero").val() + '</td><td align="center">ver</td></tr>';					
					$("#p_cantidad").val("");
					$("#p_direccion").val("");
					$("#p_numero").val("");
					$("#p_fecha").val("");
					$("#p_monto").val("");
					$("#p_agencia").val("0");
					$("#envios-ven").modal("hide");
					$("#frm-envios").slideUp();
					$("#tabla-envios").append(nuevaFila);
				}
			});

		});		
	});	
	$(document).on("click","#ver-preguntas",function(e){
		var pub=$("#lista-pagos").data("pub");
        redirect_ids = [["id_pub",pub]]; // Declaracion de array con los id y los nombres que se recibiran via POST en el destino
	    redirect("preguntas/ventas", redirect_ids);
	});	
	$(document).on("click",".vinculopagos",function(){		
		var id=$(this).attr("id").substr(4);
		$("button#btn-informar").data("id",id);
		var pagina="paginas/compra/fcn/f_pagos.php";
		$("#btn-guardar").addClass("hidden");
		
//		if($(this).data("target")==="#pagos-ven2"){
//			var pagina="paginas/venta/fcn/f_pagos2.php";
//			var elDiv=$("#ajaxcontainer2");
//		}else{
//			var pagina="paginas/venta/fcn/f_pagos.php";
//			var elDiv=$("#ajaxcontainer");
//		}
				
		var elDiv=$("#ajaxcontainer");
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
	$(document).on("click",".vinculopagos2",function(e){
		e.preventDefault();
		var id=$(this).data("id");
		$("#frm-informar-pago").data("id",id);
		$("#frm-informar-pago").formValidation({
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
				p_forma_pago:{validators:{				
					notEmpty:{},
					callback:{
						message:'Seleccione una forma de pago de la lista',
						callback:function(){
							if($("#p_forma_pago").val()=='0'){
								return false;
							}else{
								return true;
							}
						}
				}}},
				p_monto:{validators:{
					digits:{},
					greaterThan:{
						value:1,
						message:"El monto del pago debe ser minímo 1"						
					},
					notEmpty:{}}},
				p_banco:{validators:{
					callback:{
						message:"Seleccione un banco de la lista",
						callback:function(){
							if($("#p_forma_pago option:selected").text()=="Efectivo"){
								return true;
							}else if($("#p_banco").val()=='0'){
								return false;
							}else{
								return true;
							}
						}
				}}},
				p_referencia:{validators:{
					digits:{},
					callback:{
						message:"Introduzaca un valor",
						callback:function(){
							if($("#p_forma_pago option:selected").text()=="Efectivo"){
								return true;
							}else if($("#p_referencia").val()=="" || $("#p_referencia").val()<1){
								return false;
							}else{
								return true;
							}
						}
					}
				}}}
		}).on('success.form.fv',function(e){
			e.preventDefault();
			//var form=$("#frm-informar-pago").serialize() + "&metodo=guardarPago&id=" + id;
			var form=$("#frm-informar-pago").serialize() + "&metodo=guardarPago&id=" + $("#frm-informar-pago").data("id");
			$.ajax({
				url:"paginas/compra/fcn/f_compras.php",
				data:form,
				type:"POST",
				dataType:"html",
				success:function(data){
					console.log(data);
					var nuevaFila="<div class='row tabla-detalle2'><div class='col-xs-12 col-sm-2'>" + $("#informar-pago #p_fecha_pago").val() + "</div>";
					nuevaFila+="<div class='col-xs-12 col-sm-2'>" + $("#informar-pago #p_forma_pago option:selected").text() + "</div>";
					nuevaFila+="<div class='col-xs-12 col-sm-2'>" + $("#informar-pago #p_banco option:selected").text() + "</div>";
					nuevaFila+="<div class='col-xs-12 col-sm-2'>" + $("#informar-pago #p_monto").val() + "</div>";
					nuevaFila+="<div class='col-xs-12 col-sm-2'>" + $("#informar-pago #p_referencia").val() + "</div>";
					nuevaFila+="<div class='col-xs-12 col-sm-2'><div class='btn-group '>";
					nuevaFila+="<button type='button' class='btn btn-default btn-xs boton-status'><i class='fa fa-clock-o naranja-apdp'></i><span>Pendiente</button>";
					nuevaFila+="</div></div></div>";
					
//					var nuevafila="<tr><td align='center'>" + $("#informar-pago #p_fecha_pago").val() + "</td>";
//					nuevafila+="<td align='center'>" + $("#informar-pago #p_forma_pago option:selected").text() + "</td>";
//					nuevafila+="<td align='center'>" + $("#informar-pago #p_banco option:selected").text() + "</td>";
//					nuevafila+="<td align='center'>" + $("#informar-pago #p_monto").val() + "</td>";
//					nuevafila+="<td align='center'>" + $("#informar-pago #p_referencia").val() + "</td>";
//					nuevafila+="<td align='center'><br class='hidden-md hidden-lg hidden-sm'><div class='btn-group '>";
//					nuevafila+="<button type='button' class='btn btn-default btn-xs boton-status'>";
//					nuevafila+="<i class='fa fa-clock-o naranja-apdp'></i><span>Pendiente</button>";
//					nuevafila+="</div><br></td></tr>";
					
					
					$("#lista-pagos section").append(nuevaFila);
					$("#informar-pago #p_monto").val("");
					$("#informar-pago #p_referencia").val(0);
					$("#informar-pago #p_forma_pago").val(0);
					$("#informar-pago #p_banco").val(0);
					if(!$("#informar-pago div#d_banco").hasClass("hidden"))
					$("#informar-pago div#d_banco").addClass("hidden");
					$("#informar-pago").modal('hide');
//					document.location.reload();
				}
			});	
			$("#frm-informar-pago").resetForm();
		});		
	});	
	$("a#guardar-comentario").click(function(){
		var id=$(this).data("id");
		var nota=$("#txt-comentario").val();
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:"guardarComentario",id:id,nota:nota},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
				swal({
					title:"Exito",
					text: "Se guardo el comentario sin problemas",
					imageUrl: "galeria/img-site/logos/bill-ok.png",
					showConfirmButton: true
				});				
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
			url:"paginas/compra/fcn/f_compras.php",
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
	$("#informar-pago").on("change","#p_forma_pago",function(){
		if($(this).val()=="0" || $(this).val()=="2"){
			if(!$("#informar-pago div#d_banco").hasClass("hidden"))
			$("#informar-pago div#d_banco").addClass("hidden");
		}else{
			if($("#informar-pago div#d_banco").hasClass("hidden"))
			$("#informar-pago div#d_banco").removeClass("hidden");
		}
	});
	$("#frm-datos-fac").formValidation({
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
			p_documento:{validators:{
				digits:{},				
				notEmpty:{}}},
			p_nombre:{validators:{
				notEmpty:{},
				stringLen:{min:10,max:100}
			}}},
			p_direccion:{validators:{
				notEmpty:{},
				stringLen:{min:6,max:240}}}
	}).on('success.form.fv',function(e){
		e.preventDefault();
		var id=$("#frm-datos-fac").data("id");
		var form=$("#frm-datos-fac").serialize() + "&metodo=actualizarDatosF&id=" + id + "&compras_id=" + $("#frm-datos-fac").data("compras_id");
		$.ajax({
			url:"paginas/compra/fcn/f_compras.php",
			data:form,
			type:"POST",
			dataType:"html",
			success:function(data){
				$("span#facturacion1").text($("input#p_identificacion").val());
				$("span#facturacion2").text($("input#p_nombre").val());
				$("span#facturacion3").text($("input#p_direccion").val());			
				$("#datos-facturacion").modal("hide");
			}
		});
	});

	$("#frm-datos-env").formValidation({
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
			p_documento_envios:{validators:{
				digits:{},				
				notEmpty:{}}},
			p_nombre_envios:{validators:{
				notEmpty:{},
				stringLen:{min:10,max:100}
			}}},
			p_direccion_envios:{validators:{
				notEmpty:{},
				stringLen:{min:6,max:240}}}
	}).on('success.form.fv',function(e){
		e.preventDefault();
		var id=$("#frm-datos-env").data("id");
		var form=$("#frm-datos-env").serialize() + "&metodo=actualizarDatosE&id=" + id + "&compras_id=" + $("#frm-datos-env").data("compras_id");
		$.ajax({
			url:"paginas/compra/fcn/f_compras.php",
			data:form,
			type:"POST",
			dataType:"html",
			success:function(data){
				$("span#envio1").text($("input#p_nombre_envios").val());
				$("span#envio2").text($("input#p_documento_envios").val());
				$("span#envio3").text($("#p_agencia_envios option:selected").text());				
				$("span#envio4").text($("input#p_direccion_envios").val());				
				$("#datos-envios").modal("hide");				
			}
		});
	});
	
	var input1 = $('#p_fecha_pago').pickadate({editable: false, container: '#date-picker2',
  	monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
  	weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mier', 'Jue', 'Vie', 'Sab'],
  	today: 'Hoy',
  	clear: 'Limpiar',
  	close: 'Cerrar',
  	format: 'yyyy-mm-dd',
  	formatSubmit: 'y-m-d'});
	var picker1 = input1.pickadate('picker');
	picker1.set('min', false);
	picker1.set('max', true);
	//Fecha desde
	$('#p_fecha_pago').off('click focus');
	$('#p_fecha_pago').on('click', function(e) {		
  		if (picker1.get('open')) { 
    		picker1.close();
  		}else {
    		picker1.open();
  		}
	  e.stopPropagation();
	});
});