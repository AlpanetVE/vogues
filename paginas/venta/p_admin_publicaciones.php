<?php
include_once "clases/publicaciones.php";
if(isset($_GET["tipo"])){
	$tipo=$_GET["tipo"];
}else{
	$tipo=1;
}
switch($tipo){
	case 1:
		$clasesP1="active pesta";
		$clasesP2="pesta";
		$clasesP3="pesta";
		break;
	case 2:
		$clasesP1="pesta";
		$clasesP2="active pesta";
		$clasesP3="pesta";
		?>
		<script>
		loadingAjax(true);
		tipo=2;
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:"buscarPublicaciones",tipo:tipo},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
				$("#publicaciones").html(data);
				loadingAjax(false);
			}
		});	
		</script>
		<?php		
		break;
	case 3:
		$clasesP1="pesta";
		$clasesP2="pesta";
		$clasesP3="active pesta";
		?>
		<script>
		loadingAjax(true);
		tipo=3;
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:"buscarPublicaciones",tipo:tipo},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
				$("#publicaciones").html(data);
				loadingAjax(false);
			}
		});	
		</script>
		<?php				 		
		break;
}
?>
<script type="text/javascript">
    var id;
	function pasavalores(b){
		 id = $("#b" + b).data('id');
 		 $('#titulo').val($("#b" + b).data('titulo'));
 		 $('#monto').val($("#b" + b).data('monto'));
 		 $('#stock').val($("#b" + b).data('stock'));
 		 $("#btn-social-act").data("id",$("#b" + b).data('id'));
 		 $("#btn-social-act").data("descripcion",$("#b" + b).data('descripcion'));
 		 $("#btn-social-act").data("metodo","actualizar");
 		 $("#tituloVentana").html("Editar Publicaci&oacute;n");
         $("#masDetalles").css("display","block");
         $("#comando").text("Actualizar");         
	}
	function republicarPublicacion(elId){
        id = $("#b" + elId).data('id');
 		$('#titulo').val($("#b" + elId).data('titulo'));
 		$('#monto').val($("#b" + elId).data('monto'));
 		$('#stock').val($("#b" + elId).data('stock'));
 		$("#btn-social-act").data("id",$("#b" + elId).data('id'));
 		$("#btn-social-act").data("metodo","republicar");
        $("#tituloVentana").html("Republicar");
        $("#masDetalles").css("display","none");
        $("#comando").text("Guardar");
        eliminarPublicacion(elId);
	}	
	function modificarOpciones(elId,tipo,origen){
		if(tipo!=origen){
			$("#btnOpciones" + elId).addClass("hidden");
			$("#b" + elId).addClass("hidden");
		}else{
			$("#btnOpciones" + elId).removeClass("hidden");
			$("#b" + elId).removeClass("hidden");			
		}
		if(origen==1){
			if(origen!=tipo){
				$("#btnReactivar" + elId).removeClass("hidden");
			}else{
				$("#btnReactivar" + elId).addClass("hidden");
				$("#menPau" + elId).addClass("hidden");
				$("#menFin" + elId).addClass("hidden");
				$("#menAct" + elId).addClass("hidden");
			}	
			if(tipo==2){
				if(origen!=tipo){
					$("#menPau" + elId).removeClass("hidden");
				}else{
					$("#menPau" + elId).addClass("hidden");
					$("#menFin" + elId).addClass("hidden");
					$("#menAct" + elId).addClass("hidden");
				}
			}else if(tipo==3){
				if(origen!=tipo){
					$("#menFin" + elId).removeClass("hidden");
				}else{
					$("#menPau" + elId).addClass("hidden");
					$("#menFin" + elId).addClass("hidden");
					$("#menAct" + elId).addClass("hidden");
				}
			}
		}else if(origen==2){
			if(origen!=tipo){
				$("#btnPausar" + elId).removeClass("hidden");
			}else{
				$("#btnPausar" + elId).addClass("hidden");
			}
			if(tipo==1){
				if(origen!=tipo){
					$("#menAct" + elId).removeClass("hidden");
				}else{
					$("#menPau" + elId).addClass("hidden");
					$("#menFin" + elId).addClass("hidden");
					$("#menAct" + elId).addClass("hidden");
				}
			}else if(tipo==2){
				if(origen!=tipo){
					$("#menAct" + elId).removeClass("hidden");
				}else{
					$("#menPau" + elId).addClass("hidden");
					$("#menFin" + elId).addClass("hidden");
					$("#menAct" + elId).addClass("hidden");
				}				
			}else if(tipo==3){
				if(origen!=tipo){
					$("#menFin" + elId).removeClass("hidden");
				}else{
					$("#menPau" + elId).addClass("hidden");
					$("#menFin" + elId).addClass("hidden");
					$("#menAct" + elId).addClass("hidden");
				}
			}
		}else if(origen==3){
			if(origen!=tipo){
				$("#btnFinalizar" + elId).removeClass("hidden");
			}else{
				$("#btnFinalizar" + elId).addClass("hidden");
			}
			if(tipo==1){
				if(origen!=tipo){
					$("#menRep" + elId).removeClass("hidden");
					$("#menEli" + elId).removeClass("hidden");
				}else{
					$("#menPau" + elId).addClass("hidden");
					$("#menFin" + elId).addClass("hidden");
					$("#menAct" + elId).addClass("hidden");
				}
			}
			if(tipo==3){
				if(origen!=tipo){
					$("#menRep" + elId).removeClass("hidden");
					$("#menEli" + elId).removeClass("hidden");
				}else{
					$("#menPau" + elId).addClass("hidden");
					$("#menFin" + elId).addClass("hidden");
					$("#menAct" + elId).addClass("hidden");
					$("#menRep" + elId).addClass("hidden");
					$("#menEli" + elId).addClass("hidden");
				}
			}
		}
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:"cambiarStatus",id:elId,tipo:tipo,anterior:origen},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
			}
		});
	}
	function eliminarPublicacion(elId){
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:"cambiarStatus",id:elId,tipo:4,anterior:3},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
				$.ajax({
					url:"paginas/venta/fcn/f_ventas.php",
					data:{metodo:"buscarPublicaciones",tipo:3},
					type:"POST",
					dataType:"html",
					success:function(data){
						console.log(data);
						$("#publicaciones").html(data);
					}
				});					
			}
		});		
	}
</script>
<div class="row" id="principal">
	<!-- inicion del row principal  -->

	<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 maB10  " >
		<!-- inicio contenido  -->

		<div class=" contenedor">
			<!-- inicio contenido conte1-1 -->

			<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10   ">
				<!-- inicio titulo y p  -->

				<h4 class=" marL20 marR20 t20 negro" style="padding:10px;"><span class="marL10">Mis publicaciones</span></h4>
				<center>
					<hr class='ancho95'>
				</center>
				<br>

				<ul class="nav nav-tabs marL30 marR30 t14 " >
					<li role="presentation" class="<?php echo $clasesP1;?>" id="irActivas">
						<a href="#"  class="grisO">Activas</a>
					</li>
					<li role="presentation" class="<?php echo $clasesP2;?>" id="irPausadas">
						<a href="#" class="grisO">Pausadas</a>
					</li>
					<li role="presentation" class="<?php echo $clasesP3;?>" id="irFinalizadas">
						<a href="#" class="grisO">Finalizadas</a>					
					</li>
				</ul>

			</div>

			<div class='col-sm-12 col-md-5 col-lg-4 marB10 '>

				<form action="" method="GET"
				class="navbar-form navbar-left  marT15 marL30 " role="search">
				<div class="input-group" style="">
					<span class="input-group-btn">
						<button class="btn-header btn-default-header" style="border: #ccc 1px solid; border-right:transparent;"
							>
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</span> <input style="margin-left: -10px; border: #ccc 1px solid; border-left:1px solid #FFF;  "
						 type="text" class="form-control-header " placeholder="Buscar" id="txtBusqueda" name="txtBusqueda">						 
				</div>
				<div id="busqueda" name="busqueda" class="hidden  pad10  " style="   width: 308px; background: #FAFAFA;" data-usuario='<?php echo $_SESSION["id"]; ?>'>Publicaciones:</div>
			</form>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 marB10 marT15" >
				<div class=" btn-group marL30 hidden ">
					<button type="button" class="btn btn-default">
						Filtrar
					</button>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="#">Mas ventas</a>
						</li>
						<li>
							<a href="#">Menos ventas </a>
						</li>

					</ul>
				</div>

			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10">

				<div class="marL30 marR20" style="background: #F2F2F2;">

					<table width="100%" class="alto50" border="0" cellspacing="0" cellpadding="0" >
						<tr>
							<!--<td  width="5%"  align="right" valign="top">
							<div class="  marT10 hidden-xs hidden-sm"  style="  transform:  rotate(0deg); width: 18px; height:18px; border: 0px; margin-right:4px;   ">
								<INPUT  TYPE=CHECKBOX  style=" width:100% ; height:100%;" class="">
							</div></td>
							<td  width="5%"  align="left">
							<div class="hidden-xs hidden-sm" style="margin-left:15px;">
								<button type="button" class="btn2 btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
									<span class="glyphicon glyphicon-cog "></span><span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li>
										<a href="" data-toggle="modal">Pausar</a>
									</li>
									<li>
										<a href="" data-toggle="modal">Finalizar </a>
									</li>
									<li>
										<a href="" data-toggle="modal">Republicar</a>
									</li>

								</ul>
							</div></td>-->
							<td  width="75%"  align="right">
								<span class="marR10">Publicaciones </span>
								<span id="inicio-list" name="inicio-list"> 1</span>
								<span id="final-list" name="final-list"><?php if($total>=25){ echo "25"; }else{ echo $total;}?>  de </span> 
								<span id="total-list" name="total-list"><b><?php echo $total;?></b></span> 
							</td>
							<td   width="15%"  align="right" height="40px;" >
							<select id="filtro" class="form-control  input-sm " style="width:auto; margin-right:20px;">
								<option value="desc" >Mas Recientes</option>
								<option value="asc" >Menos Recientes </option>
							</select></td>
						</tr>
					</table>

				</div>

			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10"></div>

			<div class='row  marB10 marT10 marL50 marR30'>
				<!--<div class='hidden-xs hidden-sm  col-md-1 col-lg-1 t12  ' >
					<div class=' marR10 pull-right'  style='  width: 18px; height:18px; border: 0px;   '>
						<INPUT TYPE=CHECKBOX  style=' width:100% ; height:100%;  '>
					</div>
				</div>-->

				<!-- INICIO de detalle del listado de publicaciones -->
			<div id="noresultados" name="noresultados" class="container center-block col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden">	
			<br>
			<br>
			<div class='alert alert-warning2  text-center' role='alert'  >                                        	
	              	<span class="t16  "><i class="fa fa-info-circle"></i> No se encontraron publicaciones favoritas.</span>
	         </div>
	         <br>  
	        </div>				
			<div id="publicaciones">
				<?php
				$hijos=$usua->getPublicaciones($tipo);
				
				$contador=0;
				foreach ($hijos as $key => $valor) {
					$contador++;
				$publicacion=new publicaciones($valor["id"]);
				$cadena="<span id='general" . $valor["id"] . "' name='general" . $valor["id"] . "' class='general' data-titulo='{$valor["titulo"]}'>
				<div class='col-xs-12 col-sm-12 col-md-1 col-lg-1  '>
						<div class='marco-foto-publicaciones  point ' style='width: 65px; height: 65px;' > 
						<img src='" . $publicacion->getFotoPrincipal() . "' width='100%' height='100%;' 
						style='border: 1px solid #ccc;' class='img img-responsive center-block imagen' data-id='" . $valor["id"] . "'> </div>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-6 col-lg-6 vin-blue t14  '>
					<span class='detalle.php'> <a href='detalle.php?id={$valor["id"]}'> <span id='titulo" . $valor["id"] . "'>{$valor["titulo"]}</span></a></span>
					<br>
					<span class='opacity'># $publicacion->id</span>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-2 col-lg-2  text-left '>
					<span class='red t14' id='monto" . $valor["id"] . "'>" . $publicacion->getMonto(1) . " </span>
					<br>
					<span class='t12 opacity' id='stock" . $valor["id"] . "'> x  " . $publicacion->stock . " und</span>
					<br>
					<span> " . $publicacion->getVisitas() . " Visitas</span>
					<span class='opacity hidden'> / </span>
					<span class=' blue-vin hidden'> 30 ventas </span>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 text-center t12 '>
					<div class='btn-group pull-right marR10'>				
						<button id='b" . $publicacion->id . "' type='button' class='btn2 btn-warning boton' data-toggle='modal' data-target='#info-publicacion' onclick='javascript:pasavalores($publicacion->id)'
						data-id='$publicacion->id' data-titulo='$publicacion->titulo' data-stock='$publicacion->stock' data-monto='" . number_format($publicacion->monto,2,',','.') . "' data-id='b" . $publicacion->id . "' data-descripcion='" . $publicacion->descripcion . "' data-listado='1' >
							Modificar
						</button>
						<button id='btnReactivar" . $publicacion->id . "' type='button' class='btn2 btn-warning hidden' data-toggle='modal' onclick='javascript:modificarOpciones(" . $publicacion->id . ",1,1)'>
							Reactivar
						</button>
						<button id='btnPausar" . $publicacion->id . "' type='button' class='btn2 btn-warning hidden' data-toggle='modal' onclick='javascript:modificarOpciones(" . $publicacion->id . ",2,2)'>
							Pausar
						</button>						
						<button id='btnFinalizar" . $publicacion->id . "' type='button' class='btn2 btn-warning hidden' data-toggle='modal' onclick='javascript:modificarOpciones(" . $publicacion->id . ",3,3)'>
							Finalizar
						</button>
						<button id='btnOpciones" . $publicacion->id . "' type='button' class='btn2 btn-warning dropdown-toggle  ' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' >
							<span class='glyphicon glyphicon-cog '></span>
							<span class='caret'></span>
						</button>
						<ul  class='  dropdown-menu'>
							<li onclick='javascript:modificarOpciones($publicacion->id,2,1)'>
								<a class='pausar opciones'  id='' href='' data-toggle='modal' value='pausar'>Pausar</a>
							</li>
							<li onclick='javascript:modificarOpciones($publicacion->id,3,1)'>
								<a class='finalizar opciones' id='' href='' data-toggle='modal' value='finalizar'>Finalizar</a>
							</li>
						</ul>
						<div id='menPau" . $publicacion->id . "' class='alert alert-success t10 hidden' style='padding:3px;margin-bottom:0px; margin-top:3px;' role='alert'>
							Publicacion pausada
						</div>
						<div id='menAct" . $publicacion->id . "' class='  alert alert-success t10 hidden' style='padding:3px;margin-bottom:0px; margin-top:3px;' role='alert'>
							Publicacion activa
						</div>
						<div id='menFin" . $publicacion->id . "' class='  alert alert-success t10 hidden' style='padding:3px;margin-bottom:0px; margin-top:3px;' role='alert'>
							Publicacion finalizada
						</div>
						<div id='menRep" . $publicacion->id . "' class='  alert alert-success t10 hidden' style='padding:3px;margin-bottom:0px; margin-top:3px;' role='alert'>
							Republicada
						</div>
						<div id='menEli" . $publicacion->id . "' class='  alert alert-success t10 hidden' style='padding:3px;margin-bottom:0px; margin-top:3px;' role='alert'>
							Eliminar
						</div>
					</div></div>		
				<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10'>
					<center><hr class=' center-block'></center></div>
				</span>";
				echo $cadena;
				}
				echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10'>
				<nav class='text-center'>
				  <ul class='pagination'>";
				  
				$totalPaginas=floor($contador/25);
				$restantes=$contador-($totalPaginas*25);
				if($restantes>0){
					$totalPaginas++;
				}
				if($totalPaginas>0){
				echo "<li>
				      <a href='#' aria-label='Previous'>
				        <span aria-hidden='true'>&laquo;</span>
				      </a>
				    </li>";
				}
				for($i=1;$i<=$totalPaginas;$i++){
				  	echo "<li><a href='#'>$i</a></li>";
				 }
				 if($totalPaginas>0){
				 echo "<li>
				      <a href='#' aria-label='Next'>
				        <span aria-hidden='true'>&raquo;</span>
				      </a>
				    </li>
				  </ul>
				</nav>
				</div>";
				}
				if($contador==0){
					?>
					<script>
			  		$("#noresultados").removeClass("hidden");
			  		$("#publicaciones").addClass("hidden");
			  		</script>		  	
				<?php
				}else{
					?>
					<script>
			  		$("#noresultados").addClass("hidden");
			  		$("#publicaciones").removeClass("hidden");
			  		</script>
			  		<?php		  						
				}
				?>
				</div>
				<!-- FIN del detalle del listado -->

			</div>

		</div>
		<!-- fin contenido conte1-1 -->

	</div >
	<!-- fin de contenido -->

</div>
<!-- fin de row principal  -->

