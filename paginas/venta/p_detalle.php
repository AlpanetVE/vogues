<div class="contenedor" style="margin-top: 25px">
			<div class="row mar20">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pad20 marB10" style="background: #f5f5f5;  border: solid 1px #ccc;">		
						<div class=" t22 ">
							<i class="fa fa-shopping-cart"></i>  Detalle de la <?php echo $operacion;?> <span class="opacity"># <?php echo $_GET["id"];?></span>
							<span class="pull-right t14"><a href="javascript:history.back();">Volver a mis <?php echo $operacion;?>s</a></span>
						</div>
						
					</div>
					<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 pad20 marB10" style="background: #f5f5f5;  border: solid 1px #ccc;">						
						<a href="detalle.php?id=<?php echo $publicacion->id;?>"><img src="<?php echo $publicacion->getFotoPrincipal();?>" class="center-block" width="200px" height="200px" style="border: solid 1px #ccc"  /></a>
						<br>
						<br>
						<a href="detalle.php?id=<?php echo $publicacion->id;?>"><?php echo $publicacion->titulo;?></a>
						<br>
						<span class="red"><?php echo $publicacion->getMonto();?></span> x <span class="grisO"><?php echo $venta->getAtributo("cantidad");?> und</span>
						<br>
						<b>Total: </b><span class="red"><?php $totalGeneral=$publicacion->monto * $venta->getAtributo("cantidad"); echo number_format($totalGeneral,2,',','.');?></span>
						<br>
						<span class="grisC">Fecha de compra: <?php echo date("d-m-Y",strtotime($venta->getAtributo("fecha")));?></span>
						<br>
						<br>
						<span> <b><?php echo $operacion=="compra"?"Vendedor":"Comprador";?></b></span>
						<br>
						<span><?php echo $comprador->a_seudonimo;?></span>
						<br>
						<span><?php echo $comprador->getNombre();?></span>
						<br>
						<span class="grisC" id="span_email" name="span_email"><?php echo $comprador->a_email;?></span> &nbsp;<i class="fa fa-files-o t10 point" onClick="copyPortaPapeles('<?php echo $comprador->a_email;?>');"></i>
						<br>
						<?php echo $comprador->u_telefono;?>
						<br>
						<br>
						<span><i class="fa fa-comment grisC"></i> &nbsp; <a id="ver-preguntas" name="ver-preguntas" class="point"> Ver Preguntas de la venta</a></span>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 ">
						<div class="mar10" id="lista-pagos" data-id="<?php echo $_GET["id"];?>" data-pub="<?php echo $publicacion->id;?>">
							<?php
							$statusPago=$venta->getStatusPago();
							switch($statusPago){
								case "Pago pendiente":
									$claseColor="naranja-apdp";
									break;
								case "Pago rechazado":
									$claseColor="rojo-apdp";
									break;
								case "Pago verificado":
									$claseColor="verde-apdp";
									break;
								case "Pago incompleto":
									$claseColor="verde-apdp";
									break;
							}
							$statusEnvio=$venta->getStatusEnvio();
							switch($statusEnvio){
								case "Envio pendiente":
									$claseColor2="rojo-apdp";
									break;
								case "Envio en camino":
									$claseColor2="naranja-apdp";
									break;
								case "Enviado":
									$claseColor2="verde-apdp";
									break;
							}
							?>
							<div class="t18 negro marB10 marL5">Pagos <span class="pull-right t16 marR5"><i class="fa fa-credit-card <?php echo $claseColor;?>"></i> <?php echo $statusPago;?></span></div>
							
								<div class="row tabla-detalle" >
									<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 " >
										<b>Fecha</b>
										</div>
										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 " >
										<b>Forma de pago</b>
										</div>
										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 " >
										<b>Banco</b>
										</div>
										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 " >
										<b>Monto</b>
										</div>
										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 " >
										<b>Referencia</b>
										</div>	
										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 " >
										<b>Status</b>
										</div>
								</div>
								<section>
									<?php
									$listaPagos=$venta->getPagos();
									$ac=0;
									if($listaPagos):
										foreach ($listaPagos as $l => $valor) :	
											switch($valor["status_pago"]){
												case "1":
													$titulo1="Pendiente";
													$titulo2="Verificar";
													$titulo3="Rechazar";
													$texto1="Pendiente";
													$clases1="fa fa-clock-o naranja-apdp";
													$texto2="Verificado";
													$clases2="fa fa-thumbs-o-up verde-apdp";
													$texto3="Rechazado";
													$clases3="fa fa-remove rojo-apdp";					
													break;					
												case "2":
													$titulo1="Verificado";
													$titulo2="Pendiente";
													$titulo3="Rechazar";	
													$texto1="Verificado";			
													$clases1="fa fa-thumbs-o-up verde-apdp";
													$texto2="Pendiente";
													$clases2="fa fa-clock-o naranja-apdp";
													$texto3="Rechazado";
													$clases3="fa fa-remove rojo-apdp";
													$ac+=$valor["monto"];									
													break;
												case "3":
													$titulo1="Rechazar";
													$titulo2="Pendiente";
													$titulo3="Verificar";					
													$texto1="Rechazado";
													$clases1="fa fa-remove rojo-apdp";
													$texto2="Pendiente";
													$clases2="fa fa-clock-o naranja-apdp";
													$texto3="Verificado";
													$clases3="fa fa-thumbs-o-up verde-apdp";				
													break;
											}
									?>
									<div class="row tabla-detalle2">
										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 " >
										<?php echo date("d-m-Y",strtotime($valor["fecha"]));?>
										</div>
										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 " >
										<?php if($valor["fp"]!="Seleccione")echo $valor["fp"];?>
										</div>
										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 " >
										<?php if($valor["siglas"]!="Seleccione") echo $valor["siglas"];?>																	
										</div>
										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 " >
										<?php echo number_format($valor["monto"],2,',','.');?>
										</div>
										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 " >
										<?php echo $valor["referencia"];?>
										</div>
										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 " >
											<br class="hidden-md hidden-lg hidden-sm">
                    						<div class="btn-group ">
							  					<button type="button" class="btn btn-default btn-xs boton-status" data-indice="1" data-texto="<?php echo $texto1;?>" data-id="<?php echo $valor["id"];?>">
							  						<i class="<?php echo $clases1;?>" id="iconoa<?php echo $valor["id"];?>"></i>							  						
							  						<span id="primero<?php echo $valor["id"];?>" name="primero<?php echo $valor["id"];?>"><?php echo $texto1;?></span>
							  					</button>
							  					<?php
							  					if($operacion=="venta"):
													?>							  					
							  					<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    					<span class="caret"></span>
							    					<span class="sr-only">Toggle Dropdown</span>
							  					</button>
							  					<ul class="dropdown-menu" >
							    						<li class="boton-status" data-indice="2" data-texto="<?php echo $texto2;?>" data-id="<?php echo $valor["id"];?>"><a class="point"><i class="<?php echo $clases2;?>" id="iconob<?php echo $valor["id"];?>"></i> <span id="segundo<?php echo $valor["id"];?>" name="segundo<?php echo $valor["id"];?>"><?php echo $titulo2;?></span></a></li>
							    						<li class="boton-status" data-indice="3" data-texto="<?php echo $texto3;?>" data-id="<?php echo $valor["id"];?>"><a class="point"><i class="<?php echo $clases3;?>" id="iconoc<?php echo $valor["id"];?>"></i> <span id="tercero<?php echo $valor["id"];?>" name="tercero<?php echo $valor["id"];?>"><?php echo $titulo3;?></a></li>
							  					</ul>
							  					<?php
												endif;
												?>
											</div>
											<br>
										</div>
									</div>
									<?php
									endforeach;
								endif;
								?>
								</section>
								<br>
								<div style="background: #FAFAFA;" class="pad10">
								<table class="marL10 tam-detalle-ventas grisO "  >
									<tr>
										<td><b>Monto Total de la venta</b></td>
										<td>Bs.</td>
										<td align="right"><?php echo number_format($totalGeneral,2,',','.');?></td>								
									</tr>
									<tr>
										<td><b>Descuento</b></td>
										<td>Bs</td>
										<td align="right"><?php $descuento=$venta->getAtributo("descuento");echo number_format($descuento,2,',','.');?></td>
									</tr>
									<tr>
										<td style="border-bottom: 1px solid #ccc; padding-bottom: 5px;"><b>Monto Total Cancelado</b></td>
										<td style="border-bottom: 1px solid #ccc; padding-bottom: 5px;">Bs</td>
										<td style="border-bottom: 1px solid #ccc; padding-bottom: 5px;" align="right"><?php echo number_format($ac,2,',','.');?></td>								
									</tr>
									<tr>
										<td style=" padding-top: 5px;"><b>Monto Restante Para Cancelar</b></td>
										<td style=" padding-top: 5px;">Bs</td>
										<td style=" padding-top: 5px;" align="right">
											<?php
												$restante=$totalGeneral - $descuento - $ac;
												if($restante<=0){
													echo "PAGADO";
												}else{
													echo number_format($restante,2);
												}
											?>
										</td>
									</tr>									
								</table>
								</div>	
								<br>
								<div class="text-right marR10">								
								<?php
								if($operacion=="compra"):
									?>								
										<a class="point"><button class="btn btn-default vinculopagos2" id="pago<?php echo $venta->getAtributo("id");?>" data-toggle="modal" data-target="#informar-pago" data-id="<?php echo $venta->getAtributo("id");?>">Informar Pago</button></a>
									<?php
								else:
									?>
										<a class="point"><button class="btn btn-primary2" id="btn-guardar" name="btn-guardar">Guardar</button></a>
										<?php
								endif;
								?>
								</div>																	
								<br>
								<hr>
								<br>
								<br>
								<div class="t18 negro marB10 marL5">Envios <span class="pull-right t16 marR5"><i class="fa fa-truck <?php echo $claseColor2;?>"></i> <?php echo $statusEnvio;?></span></div>
								<div class="tabla-detalle row text-center" id="tabla-envios" name="tabla-envios">
								
										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 " >
										<b>Fecha</b>
										</div>
										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 " >
										<b>Cantidad</b>
										</div>
										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 " >
										<b>Agencia</b>
										</div>
										<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 " >
										<b>N. de guia</b>
										</div>
										<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 " >
										<b>Ver detalle</b>
										</div>		
								</div>	
									
									<?php
										$listaEnvios=$venta->getEnvios();
										if($listaEnvios):
											foreach($listaEnvios as $l=>$valor):
												?>
												<div class="tabla-detalle2 row text-center" id="tabla-envios" name="tabla-envios">
													<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 " >
													<?php echo date("d-m-Y",strtotime($valor["fecha"]));?>
													</div>
													<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 " >
													<?php echo $valor["cantidad"];?>
													</div>
													<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 " >
													<?php echo $valor["nombre"];?>
													</div>
													<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 " >
													<?php echo $valor["nro_guia"];?>
													</div>
													<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 " >
													<a class="point">ver</a>
													</div>
												</div>
											<?php
											endforeach;
										endif;
										?>				
								
								<br>
								<?php
								if($statusPago=="Pago verificado"):
									?>
										<div class="text-right marR10"> <a class="point" data-toggle="modal" data-target="#envios-ven"><button class="btn btn-primary2" id="btn-add-guia" name="btn-add-guia">Agregar Envio</button></a></div>
								<?php endif; ?>
								<br>
								<hr>
								<br>
								<div class="t18 negro marB10 marL5">Datos de facturaci&oacute;n</div>
								<div class="pad10" style="background: #FAFAFA;">			
								<b>Cedula / Rif / Pasaporte :</b> <span id="facturacion1" name="facturacion1"><?php echo $datosFac["documento"];?></span>
								<br>
								<b>Nombre / Razon Social :</b> <span id="facturacion2" name="facturacion2"><?php echo $datosFac["nombre"];?></span>
								<br>
								<b>Direcci&oacute;n fiscal :</b> <span id="facturacion3" name="facturacion3"><?php echo $datosFac["direccion"];?></span>
								<br>
								</div>
								<?php if($operacion=="compra"):
								?>
								<div class="text-right marT5 marR10" ><a class="point" data-toggle="modal" data-target="#datos-facturacion">Cambiar datos de facturaci&oacute;n</a></div>
								<?php endif;?>
								<br>
								<hr>
								<br>
								<div class="t18 negro marB10 marL5">Datos de envio</div>
								<div class="pad10" style="background: #FAFAFA;">	
								<b> Quien retira :</b> <span id="envio1" name="envio1"><?php echo $datosEnv["nombre"];?></span>
								<br>
								<b>Cedula:</b> <span id="envio2" name="envio2"><?php echo $datosEnv["documento"];?></span>
								<br>			
								<b>Agencia de Envio :</b> <span id="envio3" name="envio3"><?php echo $datosEnv["agencia"];?></span> <span class="opacity">(Sugerencia)</span>
								<br>
								<b>Direcci&oacute;n :</b> <span id="envio4" name="envio4"><?php echo $datosEnv["direccion"];?></span>	<span class="opacity">(Sugerencia)</span>						
								</div>
								<?php if($operacion=="compra"):
								?>
								<div class="text-right marT5 marR10" ><a class="point" data-toggle="modal" data-target="#datos-envios">Cambiar datos de envio</a></div>
								<?php endif;?>
								<br>
								
								<?php
								if($operacion=="venta"):
									?>
								<div class="t18 negro marB5 marL5">Comentario</div>
								<div class="pad10"><input class="form-input" id="txt-comentario" name="txt-comentario" value="<?php echo $venta->getAtributo("nota");?>" style="outline: 0"></div>
								<div class="text-right marR10" ><a class="point" id="guardar-comentario" name="guardar-comentario" data-id="<?php echo $venta->getAtributo("id");?>">Guardar</a></div>
								<?php
								endif;
								?>
							</div>
					</div>
			</div>
			
		</div>
		
				
      

		