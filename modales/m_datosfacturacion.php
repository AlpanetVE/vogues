<div class="modal fade bs-example-modal-lg modal-conf" data-type="correo"  tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="datos-facturacion">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title ">
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span
						id="" class="marL15">Datos de Facturaci&oacute;n</span>
				</h3>
			</div>
			<form id="frm-datos-fac" action="" method="post"
				class="form-inline" data-id="<?php if(!empty($datosFac)) echo $datosFac["id"];else echo "-1"; ?>" data-compras_id="<?php echo $venta->getAtributo("id");?>">
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp">
						<div class="row">							
							<div
								class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="text" class="form-input " value="<?php echo $datosFac["documento"];?>"
									id="p_documento" name="p_documento"
									placeholder=" Ingresa el documento de la persona o empresa"
									oncontextmenu="return false" />
							</div>
							<div
								class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="text" class="form-input " value="<?php echo $datosFac["nombre"];?>"
									id="p_nombre" name="p_nombre"
									placeholder=" Ingresa el nombre o razon social"
									oncontextmenu="return false" />
							</div>
							<div
								class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="text" class="form-input " value="<?php echo $datosFac["direccion"];?>"
									id="p_direccion" name="p_direccion"
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