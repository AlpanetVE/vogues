<?php include_once 'modales/m_cropper.php';?>
<div class="modal fade bs-example-modal-lg modal-edit-proveedor" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="edit-prov">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " >
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span id="title-modal-prov"
						class="marL15">Actualizar Proveedor</span>
				</h3>
			</div>
			<!--<img class="hidden" src="" id="foto-usuario" name="foto-usuario"></img>-->
			<form action="paginas/proveedor/fcn/f_proveedor.php" data-method="update" id="edit-prov-form" class="form-proveedor edit-prov-form" method="post"  >			
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp" >
							<div class="col-xs-12 ">
								<div class="marL10"><i class="fa fa-list-alt"></i>
									Identificaci&oacute;n</div>
							</div>
							<div  class="col-xs-12 col-sm-12 col-md-3 col-lg-3 input" >
								<select class="form-select" id="prov_tipo" name="prov_tipo">
									<option>V</option>
									<option>E</option>
									<option>P</option>
									<option>J</option>
									<option>G</option>
									<option>C</option>
								</select>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-9 col-lg-9 input" >
								<input type="text"
									placeholder="Ingresa el numero de documento..." name="prov_documento"
									class="form-input" id="prov_documento">
							</div>
							<div class="col-xs-12">
								<span class="marL10"><i class="fa fa-user"></i> Nombre </span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input" >
								<input type="text" placeholder="Ingresa tu nombre..." name="prov_nombre"
									class=" form-input " id="prov_nombre">
							</div>
							<div class="col-xs-12">
								<span class="marL10"><i class="fa fa-phone"></i> Telefono</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="text"
									placeholder="Ingrese un numero de telefono..." name="prov_telefono"
									class=" form-input" id="prov_telefono">
							</div>
							<div class="col-xs-12 ">
								<span class="marL10"><i class="fa fa-envelope"></i> Correo</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="email" class="form-input noseleccionable" id="prov_email" name="prov_email"
									placeholder=" Ingresa correo electronico..." oncontextmenu="return false"/>
							</div>
							<div class="col-xs-12 ">
								<div class="marL10"><i class="fa fa-map-marker"></i>
									Direcci&oacute;n</div>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<textarea rows="4" cols="" placeholder=" Direccion del Proveedor" id="prov_direccion" name="prov_direccion"
									class="form-textarea"></textarea>
							</div>
						 
						
					</section>					
				</div>
				<div class="modal-footer">
				<button id="edit-prov-submit" type="button" class="btn btn-primary2 btn-edit-prov-submit">Guardar</button>
								
				</div>
			</form>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->