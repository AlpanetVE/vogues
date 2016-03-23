<?php include_once 'modales/m_cropper.php';?>
<div class="modal fade bs-example-modal-lg modal-reg-prod" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="reg-prod">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " >
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span id="title-modal-prod"
						class="marL15">Agregar Productos</span>
				</h3>
			</div>
			<!--<img class="hidden" src="" id="foto-usuario" name="foto-usuario"></img>-->
			<form action="paginas/producto/fcn/f_producto.php" data-method="crearProducto" id="reg-prod-form" class="form-producto reg-prod-form" method="post"  >			
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp" data-title="Informaci&oacute;n del Proveedor" data-step="1"  >
						<div class="form-group">
							<div class="row">
								<div class="col-xs-5">
									 <div class="col-xs-12">
									 	<span><i class="fa fa-user"></i> <label>Proveedor</label></span>
									 </div>
									 <div class="col-xs-12">
						                 <select class="form-select" id="proveedor" name="proveedor">
											<option value="" disabled selected>Seleccione un Proveedor</option>
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
					            <div class="col-xs-6">
					            	<div class="col-xs-12">
										<span><i class="fa fa-list"></i> <label for="codigo">Categoria</label></span>
									</div>
									<div class="col-xs-12">
						                <select class="form-select" id="categoria" name="categoria">
											<option value="" disabled selected>Seleccione una Categoria</option>
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
										<input type="text" placeholder="Ingresa codigo del producto..." name="codigo[]" class="form-input" >
									</div>
									<div class="col-xs-12">
										<span><i class="fa fa-money"></i> Precio</span>
									</div>
									<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input" >
										<input type="text" placeholder="Ingresa precio..." name="precio[]" class="form-input" >
									</div>
				            	</div>
				            	<div class="col-xs-6">
				            		<div class="col-xs-12">
									<span><i class="fa fa-book"></i> Descripci&oacute;n</span>
									</div>						
									<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
										<textarea rows="4" cols="" placeholder="Descripci&oacute;n" name="descripcion[]" 
											class="form-textarea"></textarea>
									</div>									
				            	</div>
				            	<!------BTN PLUSS-------->
									<div class="col-xs-1">
										<br>
										<button type="button" class="btn btn-default addButton t12"><i class="fa fa-plus"></i></button>
									</div>
								<!------------------------>
				            </div>
						</div>
			            <!-------------------------------------------------------------------------------->
			            
			            
						<!-- The option field template containing an option field and a Remove button -->
					    <div class="form-group hide prod-container-detail" id="optionTemplate">					    	
					    	<div class="row">
				            	<div class="col-xs-5">
				            		<div class="col-xs-12">
										<span><i class="fa fa-lock"></i> Codigo</span>
									</div>
									<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input" >
										<input type="text" placeholder="Ingresa codigo del producto..." name="codigo[]" class="form-input" >
									</div>
									<div class="col-xs-12">
										<span><i class="fa fa-money"></i> Precio</span>
									</div>
									<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input" >
										<input type="text" placeholder="Ingresa precio..." name="precio[]" class="form-input" >
									</div>
				            	</div>
				            	<div class="col-xs-6">
				            		<div class="col-xs-12">
									<span><i class="fa fa-book"></i> Descripci&oacute;n</span>
									</div>						
									<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
										<textarea rows="4" cols="" placeholder="Descripci&oacute;n" name="descripcion[]" 
											class="form-textarea"></textarea>
									</div>									
				            	</div>
				            	<!------BTN REMOV-------->
				            		<br>
									<div class="col-xs-1 pad-left0">
							            <button type="button" class="btn btn-default removeButton t12"><i class="fa fa-minus"></i></button>
							        </div>
								<!------------------------>	
				            </div>					    	
					    </div>
						<!---------------------------------------------------------------------------------------->
					</section>
				</div>
				<div class="modal-footer">
				<button id="reg-prod-submit" type="button" class="btn btn-primary2 btn-reg-prod-submit">Guardar</button>
								
				</div>
			</form>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->