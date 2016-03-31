<?php
	require '../../../config/core.php';
	include_once "../../../clases/ventas.php";
	include_once "../../../clases/publicaciones.php";
	include_once "../../../clases/bd.php";
	include_once "../../../clases/usuarios.php";	
	switch($_POST["metodo"]){
		case "guardarPago":
			guardaPago();
			break;
		case "ordenar":
			ordena();
			break;
		case "actualizarDatosF";
			actualizaDatosF();
			break;
		case "actualizarDatosE";
			actualizaDatosE();
			break;			
	}
	function guardaPago(){
		$compra=new ventas($_POST["id"]);
		$publicacion = new publicaciones($compra->publicaciones_id);
		$arrfecha = explode("-", $_POST["p_fecha_pago"]);
        $fecha = $arrfecha[2] . "-" . $arrfecha[1] . "-" . $arrfecha[0];
		$p_banco=isset($_POST["p_banco"])?$_POST["p_banco"]:null;
		$result=$compra->setPagos($_POST["p_referencia"], $_POST["p_monto"], $fecha , $_POST["p_forma_pago"], $p_banco,$_POST["id"]);	
		
		//var_dump($compra->publicaciones_id).var_dump($publicacion->usuarios_id).var_dump($_POST["id"]).
		$publicacion->setNotificacion($compra->publicaciones_id,5,$publicacion->usuarios_id);
		echo $result;
	}	
	function ordena(){
		$compras=new ventas();
		if($_POST["origen"]==1){
			$listaCompras=$compras->listarPorUsuario(2,1,$_POST["orden"]); //Compras sin concretar
		}else{
			$listaCompras=$compras->listarPorUsuario(4,1,$_POST["orden"]); //Compras concretadas
		}
	    if($listaCompras):
			foreach ($listaCompras as $l => $valor):
				$usua=new usuario($valor["vendedor"]);
				$compra=new ventas($valor["id"]);
				$publi=new publicaciones($valor["publicaciones_id"]);
				$statusPago=$compra->getStatusPago();
				switch($statusPago){
					case "Pago pendiente":
						$claseColor="amarillo-apdp";
						break;
					case "Pago incompleto":
						$claseColor="naranja-apdp";
						break;
					case "Pago verificado":
						$claseColor="verde-apdp";
						break;
					case "Pago rechazado":
						$claseColor="rojo-apdp";
						break;	
					default:
						$claseColor="";
						break;											
				}
				$maximo=is_null($valor["maximo"])?$valor["cantidad"]:$valor["maximo"];
				if($maximo<$valor["cantidad"]){
					$statusEnvio="Envio en camino";
					$claseColor2="naranja-apdp";
				}else{
					$statusEnvio="Envio pendiente";
					$claseColor2="rojo-apdp";
				}
			?>
			<div id="compra<?php echo $valor["id"];?>" class="general" data-titulo="<?php echo $usua->a_email . $usua->a_seudonimo;?>">
				<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 vin-blue t14  '>
					 <span id='#' class="negro t14"><?php echo $usua->getNombre();?></span>
					<br>
					<span class=''><a href="<?php echo $usua->a_seudonimo;?>"><?php echo $usua->a_seudonimo;?></a></span>
					<br>
					<span class=" grisC t12"><?php echo $usua->a_email;?>&nbsp;</span><i class="fa fa-files-o t10 point" onClick="copyPortaPapeles('<?php echo $usua->a_email;?>');"></i>
					<br>
					<span class="t12"><?php echo $usua->u_telefono;?></span>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-1 col-lg-1  '>
						<div class='marco-foto-publicaciones  point ' style='width: 65px; height: 65px;' > 
						<a href="publicacion-<?php echo $publi->id;?>"><img src='<?php echo $publi->getFotoPrincipal();?>' width='100%' height='100%;' 
							style='border: 1px solid #ccc;' class='img img-responsive center-block imagen' data-id='#'> </div>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 vin-blue t14  '>
					<div style="margin-left: 3%;">
					<span class='detalle.php'> <a href='publicacion-<?php echo $compra->publicaciones_id;?>'> <span id='#'><?php echo $valor["titulo"];?></span></a></span>
					<br>
					<span class='red t14' id='#'>Bs <?php echo number_format($valor["monto"],2,',','.');?> </span>  <span class='t12 opacity' id='#'> x <?php echo $valor["cantidad"];?> und</span>
					</div>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 vin-blue t14  '>					
					<div class="t12 pad5 " style="background: #FAFAFA">	
					 <span><a class="vinculopagos point" data-toggle="modal" data-target="#pagos-ven" id="pago<?php echo $valor["id"];?>" name="pago<?php echo $valor["id"];?>"><i class="fa fa-credit-card <?php echo $claseColor;?>"></i> <span><?php echo $statusPago;?></span></a></span> 
					<br>
					 <span ><a class="vinculoenvios point" id="envio<?php echo $valor["id"];?>" name="envio<?php echo $valor["id"];?>" data-maximo="<?php echo $maximo;?>"> <i class="fa fa-truck <?php echo $claseColor2;?>"></i> <span><?php echo $statusEnvio;?></span></a></span> 
					<br>
					 <span ></span><i class="fa fa-clock-o"></i> <span><?php echo $compra->getTiempoCompra();?> en espera</span>
					<br>
					 <span><i class="fa fa-exclamation-triangle"></i> Reclamo abierto</span>
					</div>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 text-right  t12 '>
					<div class='btn-group '>
						<a href="detalle-ventas.php?id=<?php echo $valor["id"];?>"<button class="btn2 btn-default marB5">Ver detalle</button></a>
						<button class="btn2 btn-default marB5 vinculopagos2" data-toggle="modal" data-target="#informar-pago" id="pago<?php echo $valor["id"];?>" name="pago<?php echo $valor["id"];?>" data-id="<?php echo $valor["id"];?>">Informar pago</button> 
					</div>
				</div>							
				<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10'>
					<center><hr class=' center-block'></center>
				</div>
			</div>
			<?php
			endforeach;
		endif;		
	}
	
	function actualizaDatosF(){
		$bd=new bd();
		if($_POST["id"]>-1){
			$valores=array("nombre"=>$_POST["p_nombre"],"direccion"=>$_POST["p_direccion"],"documento"=>$_POST["p_documento"]);
			var_dump($result=$bd->doUpdate("datos_facturacion",$valores,"id={$_POST["id"]}"));
		}else{
			if(!isset($_SESSION))
			session_start();
			$valores=array("documento"=>$_POST["p_documento"],"nombre"=>$_POST["p_nombre"],"direccion"=>$_POST["p_direccion"],"usuarios_id"=>$_SESSION["id"]);
			$result1=$bd->doInsert("datos_facturacion",$valores);
			if($result1){
				$nuevoId=$bd->lastInsertId();
				$valores=array("compras_id"=>$_POST["compras_id"],"datos_facturacion_id"=>$nuevoId);
				$result2=$bd->doInsert("compras_datos_facturacion",$valores);
			}
		}
	}
	
	function actualizaDatosE(){
		$bd=new bd();
		if($_POST["id"]>-1){
			$valores=array("nombre"=>$_POST["p_nombre_envios"],"direccion"=>$_POST["p_direccion_envios"],"agencias_id"=>$_POST["p_agencia_envios"]);
			$result=$bd->doUpdate("datos_envios",$valores,"id={$_POST["id"]}");		
		}else{
			if(!isset($_SESSION))
			session_start();
			$valores=array("documento"=>$_POST["p_documento_envios"],"nombre"=>$_POST["p_nombre_envios"],"direccion"=>$_POST["p_direccion_envios"],"agencias_id"=>$_POST["p_agencia_envios"],"usuarios_id"=>$_SESSION["id"]);
			$result1=$bd->doInsert("datos_envios",$valores);
			if($result1){
				$nuevoId=$bd->lastInsertId();
				$valores=array("compras_id"=>$_POST["compras_id"],"datos_envios_id"=>$nuevoId);
				$result2=$bd->doInsert("compras_datos_envios",$valores);
			}
		}	
	}	
?>