<?php include_once 'modales/m_cropper.php';?>
<div class="modal fade bs-example-modal-lg modal-edit-producto" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="edit-prod">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " >
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span id="title-modal-prod"
						class="marL15">Actualizar Producto</span>
				</h3>
			</div>
			<!--<img class="hidden" src="" id="foto-usuario" name="foto-usuario"></img>-->
			<form action="paginas/producto/fcn/f_producto.php" data-method="update" id="edit-prod-form" class="form-producto edit-prod-form" method="post"  >			
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp" data-step="1"  >
						<div class="form-group">
							<div class="row">
								<div class="col-xs-5">
									 <div class="col-xs-12">
									 	<span><i class="fa fa-user"></i> <label>Proveedor</label></span>
									 </div>
									 <div class="col-xs-12">
						                 <select class="form-select" id="proveedor" name="proveedor">
											<option value="" selected>Seleccione un Proveedor</option>
											<?php
												$proveedores_obj = new proveedor();
												$proveedores=$proveedores_obj->getProveedores();
												foreach ($proveedores as $proveedor ) :
													?>
												<option value="<?php echo $proveedor["id"]; ?>"><?php echo $proveedor["nombre"]; ?></option>
											<?php endforeach;?>
										</select>
									</div>
					            </div>         
					            <div class="col-xs-7">
					            	<div class="col-xs-12">
										<span><i class="fa fa-list"></i> <label for="codigo">Producto</label></span>
									</div>
									<div class="col-xs-12">
						                <select class="form-select" id="categoria" name="categoria">
											<option value="" selected>Seleccione un Producto</option>
											<?php
												$categorias=$proveedores_obj->getAllDatos ("productos_categorias");
												foreach ($categorias as $categoria ) :
													?>
												<option value="<?php echo $categoria["id"]; ?>"><?php echo $categoria["nombre"]; ?></option>
											<?php endforeach;?>
										</select>
									</div>					  
					            </div>
				            </div>
			           </div>
			            <!-------------------------------------------------------------------------------->			            
			            <div class="form-group prod-container-detail">
			            	<div class="row">
				            	<div class="col-xs-5">
				            		<div class="col-xs-12">
										<span><i class="fa fa-lock"></i> Codigo</span>
									</div>
									<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input" >
										<input type="text" placeholder="Ingresa codigo del producto..." id="codigo" name="codigo" class="form-input" >
									</div>
									<div class="col-xs-12">
										<span><i class="fa fa-money"></i> Precio</span>
									</div>
									<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input" >
										<input type="text" placeholder="Ingresa precio..." id="precio" name="precio" class="form-input" >
									</div>
				            	</div>
				            	<div class="col-xs-7">
				            		<div class="col-xs-12">
									<span><i class="fa fa-book"></i> Descripci&oacute;n</span>
									</div>						
									<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
										<textarea rows="4" cols="" placeholder="Descripci&oacute;n" id="descripcion" name="descripcion" 
											class="form-textarea"></textarea>
									</div>									
				            	</div>
				            </div>
						</div>
			            <!-------------------------------------------------------------------------------->						
					</section>				
				</div>
				<div class="modal-footer">
				<button id="edit-prod-submit" type="button" class="btn btn-primary2 btn-edit-prod-submit">Modificar</button>
								
				</div>
			</form>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->