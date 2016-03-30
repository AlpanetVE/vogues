<?php
	$bd = new bd();
	$bancos=$bd->doFullSelect("bancos");
	$fp=$bd->doFullSelect("formas_pagos"); 
?>
<div class="modal fade bs-example-modal-lg modal-conf" data-type="comprar-info"  tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="informar-pago">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title ">
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span
						id="" class="marL15">Datos del pago</span>
				</h3>
			</div>			
			<div class="modal-body">
	
	<form id="frm-informar-pago" name="frm-informar-pago">	
		<br>
		<div class="row  tam-modal-formulario ">
			<div>
				<div class="col-xs-12">
					<span class="grisO">Fecha del pago</span>
				</div>
				
				<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 " >
					<input id="p_fecha_pago" name="p_fecha_pago" type="text" class="form-input marB10" value="<?php echo date("d-m-Y");?>"/>
					<div id="date-picker2"> </div>
				</div>
				<div class="col-xs-12">
					<span class="grisO">Forma de pago</span>
				</div>
				
				<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 " >			
					<select placeholder="Seleccione forma de pago" class=" form-input" id="p_forma_pago" name="p_forma_pago">
						<option value='0'>Seleccione</option>
						<?php
						foreach ($fp as $f => $valor):
							?>
						<option value="<?php echo $valor["id"];?>"><?php echo $valor["nombre"];?></option>
						<?php
						endforeach;
						?>
					</select>
				</div>
				<div class="col-xs-12">
					<span class="grisO">Monto</span>
				</div>
				
				<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 " >
					<input type="text" placeholder="Monto del pago" class=" form-input" id="p_monto" name="p_monto">
				</div>
				<div id="d_banco" class="hidden">			
					<span class="grisO">Banco</span>				
					<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 " >						
						<select placeholder="Seleccione banco" class=" form-input" id="p_banco" name="p_banco">
						<?php
						foreach ($bancos as $b => $valor):
							?>
						<option value="<?php echo $valor["id"];?>"><?php echo $valor["siglas"];?></option>
						<?php
						endforeach;
						?>
						</select>									
					</div>
					<div class="col-xs-12">
					<span class="grisO">Referencia</span>
				</div>
					
					<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 " >
						<input type="text" placeholder="" class=" form-input" id="p_referencia" name="p_referencia">
					</div>
				</div>	
			</div>						
		</div>  
		<div class="modal-footer">
			<hr>
			<br>
			<button type="submit" class="btn btn-primary2">Informar</button>
		</div>
	</form>

				</div>
		<!-- /.modal-content -->
			</div>
	<!-- /.modal-dialog -->
	</div>
<!-- /.modal -->
</div>