<?php include_once 'modales/m_cropper.php';?>
<div class="modal fade bs-example-modal-lg modal-reg-prov" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="edit-categoria">
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
			<form action="paginas/mercancia/fcn/f_categorias.php" data-method="updateCategoria" id="update-categoria-form" class="form-proveedor reg-prov-form" method="post"  >			
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp" data-title="Informaci&oacute;n del Producto"  >
					<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
							<span class="marL10">Nombre</span>
								<input type="text"
									placeholder="Ingrese nombre de la categoria..." name="upd_categ_nombre"
									class=" form-input" id="upd_categ_nombre">
							</div>
					
				</div>
				<div class="modal-footer">
				<button id="modif-categoria-submit" type="submit" class="btn btn-primary2">Confirmar</button>
								
				</div>
			</form>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->