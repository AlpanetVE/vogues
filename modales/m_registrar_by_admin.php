<?php include_once 'clases/bd.php';?>
<?php include 'modales/m_cropper.php';?>
<div class="modal fade bs-example-modal-lg modal-conf-user" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="usr-reg-admin">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " >
					<img src="galeria/img/logos/mascota.png" width="50" height="51"><span id="usr-reg-title-admin"
						class="marL15">Registrar Tienda</span>
				</h3>
			</div>
			<!--<img class="hidden" src="" id="foto-usuario" name="foto-usuario"></img>-->
			<form id="usr-reg-form-admin" action="fcn/f_usuarios.php" method="post" class="form-inline" data-method="admin_reg_user" >
			 <input type="hidden" id="type_admin" name="type_admin"/>
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp" data-title="Informaci&oacute;presarial" data-step="1" data-type="e"  >
						<div class="row">
							<div class="col-xs-12 ">
								<span class="marL10"><i class="fa fa-list-alt"></i>
									Identificaci&oacute;n</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3 input" >
								<select class=" form-select" id="e_tipo_admin" name="e_tipo_admin">
									<option>V</option>
									<option>E</option>
									<option>P</option>
									<option>J</option>
									<option>G</option>
									<option>C</option>
								</select>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-9 col-lg-9 input" >
								<input autofocus type="text"
									placeholder="Ingresa el numero de documento..." name="e_rif_admin"
									class="form-input " id="e_rif_admin">
							</div>
							<div class="col-xs-12">
								<span class="marL10"><i class="fa fa-industry"></i> Nombre de la Tienda</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 input">
								<input type="text" placeholder="Ingresa la razon social..." name="e_razonsocial_admin"
									class=" form-input " id="e_razonsocial_admin">
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 input">
								<select 
									class=" form-select " id="e_categoria_admin" name="e_categoria_admin">
									<option value="" disabled selected>Area de la empresa</option>
									<?php								
							$estados = new bd ();
							foreach ( $estados->getDatosBase ( "categorias_juridicos" ) as $area ) :
									?>
								<option value="<?php echo $area["id"]; ?>"><?php echo $area["nombre"]; ?></option>
								<?php endforeach;?>
									</select>
							</div>
							
							
							
							<div class="col-xs-12">
								<span class="marL10"><i class="fa fa-phone"></i> Telefono</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="text"
									placeholder="Ingrese un numero de telefono..." name="e_telefono_admin"
									class=" form-input" id="e_telefono_admin">
							</div>
							<div class="col-xs-12">
								<span class="marL10"><i class="fa fa-map-marker"></i>
									Sambil</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input" >
								<select disabled="disabled" class="error-select form-select " id="e_estado_admin" >									 
								<?php
								$sede_obj = new bd ();
								$id_sede	=$usua->u_id_sede;
								$row	=	array('indice' => 'id','value' => $id_sede);
								$sedes=		$sede_obj->getAllDatos ( "sedes", $row);
								foreach ($sedes as $sede ) :
									?>
								<option value="<?php echo $sede["id"]; ?>"><?php echo $sede["nombre"]; ?></option>
								<?php endforeach;?> 
								</select>
								 <input type="hidden" value="<?php echo $sedes[0]['id']; ?>" name="id_sede"  		/>
								 <input type="hidden" value="<?php echo $sedes[0]['estados_id']; ?>" name="e_estado_admin" />
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								 
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<textarea rows="4" cols="" placeholder=" Direccion del Local" id="e_direccion_admin" name="e_direccion_admin"
									class="form-textarea"></textarea>
							</div>
						</div>
					</section>				
					<section class="form-apdp" style="display: none" data-title="Informaci&oacute;n de acceso"
						data-step="2" >
						<div class="row">

							<div class="col-xs-12 ">
								<span class="marL10"><i class="fa fa-male"></i> Seudonimo</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input class=" form-input " id="seudonimo_admin" name="seudonimo_admin"
									placeholder=" Ingresa un nombre con el que se identificara en el sitio..." />
							</div>
							<div class="col-xs-12 ">
								<span class="marL10"><i class="fa fa-envelope"></i> Correo</span>
							</div>
							<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="email" class="form-input noseleccionable" id="email_admin" name="email_admin"
									placeholder=" Ingresa correo electronico..." oncontextmenu="return false"/>
							</div>
							
							
								<div class="col-xs-12  ">
									<span class="marL10 title-container-password "><i class="fa fa-lock"></i> Contrase&ntilde;a</span>
								</div>
								<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input ">
									<input type="password" class="form-input noseleccionable" id="password_admin" name="password_admin"
										placeholder=" Ingresa contrase&ntilde;a..." oncontextmenu="return false"/>
								</div>
								<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input ">
									<input type="password" class="form-input noseleccionable" id="password_val_admin" name="password_val_admin"
										placeholder=" Repite la contrase&ntilde;a..." oncontextmenu="return false"/>
								</div>
											 
							
							<input type="hidden" name="ingresoUsuario_admin" value="0" />							
							<input type="hidden" name="id_rol_admin" value="2" />
							 
							
						</div>
					</section>
				</div>
				<div class="modal-footer">
				<button id="usr-reg-submit-admin" type="button" class="btn btn-primary2">Continuar</button>	
								
				</div>
			</form>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->