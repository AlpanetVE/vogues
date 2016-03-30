<?php
	include_once "clases/bd.php";
	$agencias=$bd->doFullSelect("agencias_envios");
?>
<div class="modal fade bs-example-modal-lg modal-conf" data-type="correo"  tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="datos-envios">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title ">
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span
						id="" class="marL15">Datos de Envios</span>
				</h3>
			</div>
			<form id="frm-datos-env" action="" method="post"	
				class="form-inline" data-id="<?php if(!empty($datosEnv)) echo $datosEnv["id"];else echo "-1"; ?>" data-compras_id="<?php echo $venta->getAtributo("id");?>">
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp">
						<div class="row">							
							<div
								class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="text" class="form-input " value="<?php echo $datosEnv["documento"];?>"
									id="p_documento_envios" name="p_documento_envios"
									placeholder=" Ingresa el documento de la persona o empresa"
									oncontextmenu="return false" />
							</div>
							<div
								class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="text" class="form-input " value="<?php echo $datosEnv["nombre"];?>"
									id="p_nombre_envios" name="p_nombre_envios"
									placeholder=" Ingresa el nombre o razon social"
									oncontextmenu="return false" />
							</div>
							<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
	        	               	<select class="form-select marB10" id="p_agencia_envios" name="p_agencia_envios">
									<?php
									foreach($agencias as $a=>$valor):
										?>
										<option value="<?php echo $valor["id"];?>" <?php if($valor["id"]==$datosEnv["agencias_id"]) echo "selected";?>><?php echo $valor["nombre"];?></option>
										<?php
									endforeach
									?>
								</select>
							</div>							
							<div
								class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="text" class="form-input " value="<?php echo $datosEnv["direccion"];?>"
									id="p_direccion_envios" name="p_direccion_envios"
									placeholder=" Ingresa la direcci&oacute;n"
									oncontextmenu="return false" />
							</div>							
						</div>
					</section>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary2" id="actualizar" name="actualizar">Actualizar</button>
					<button class="btn btn-primary2" data-dismiss="modal">Cerrar</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->