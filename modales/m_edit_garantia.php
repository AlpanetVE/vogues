<?php include_once 'modales/m_cropper.php';?>
<div class="modal fade bs-example-modal-lg modal-edit-status-garantia" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="edit-status-garantia">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " >
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span id="title-modal-prov"
						class="marL15">Datos del Producto</span>
				</h3>
			</div>
			<!--<img class="hidden" src="" id="foto-usuario" name="foto-usuario"></img>-->
			<form action="paginas/producto/fcn/f_producto.php" data-method="modificarStatus" data-status='2'  class="edit-statusxgarantia-form" id="edit-statusxgarantia-form" method="post"  >			
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp" >
						<span class="marL10">Motivo</span>
					<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
						
							<input type="text"
								placeholder="Ingrese detalle sobre el articulo..." name="motivo"
								class=" form-input" id="motivo">
					</div>
				</div>
				<div class="modal-footer">
				<button id="edit-statusxproducto-form" type="submit" class="btn btn-primary2">Aceptar</button>
								
				</div>
			</form>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->