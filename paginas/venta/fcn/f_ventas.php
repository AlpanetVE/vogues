<?php
include_once "../../../clases/usuarios.php";
include_once "../../../clases/publicaciones.php";
include_once "../../../clases/bd.php";
switch($_POST["metodo"]){
	case "buscarPublicaciones":
		buscaPublicaciones();
		break;
	case "actualizar":
		actualiza();
		break;
	case "cambiarStatus":
		cambiaStatus();
		break;
	case "actualizarPub":
		actualizaPub();
		break;
	case "republicar":
		republica();
		break;
	case "busquedaCaliente":
		buscarCaliente();		
}
function buscaPublicaciones(){
		session_start();
	    $usua2=new usuario($_SESSION["id"]);
		if(isset($_POST["pagina"]))
			$pagina=$_POST["pagina"];
		else
			$pagina=1;		
		
		if(isset($_POST["order"]))
			$order=$_POST["order"];
		else
			$order='id desc';
		
		if(isset($_POST["tipo"]))
			$tipo=$_POST["tipo"];
		else
			$tipo='1';
		
		$hijos2=$usua2->getPublicaciones($tipo,$pagina, NULL, $order);		
		$contador=0;
		$des=$tipo==1?"":"disabled";		 
		foreach ($hijos2 as $key => $valor) {
			$contador++;
			$publicacion=new publicaciones($valor["id"]);
			switch($tipo){
				case 1:
					$boton1="<li onclick='javascript:modificarOpciones($publicacion->id,2,1)'><a class='pausar opciones'  id='' href='' data-toggle='modal' value='pausar'>Pausar</a></li>";
					$boton2="<li onclick='javascript:modificarOpciones($publicacion->id,3,1)'><a class='finalizar opciones' id='' href='' data-toggle='modal' value='finalizar'>Finalizar</a></li>";
					break;
				case 2:
					$boton1="<li onclick='javascript:modificarOpciones($publicacion->id,1,2)'><a class='pausar opciones'  id='' href='' data-toggle='modal' value='reactivar'>Reactivar</a></li>";
					$boton2="<li onclick='javascript:modificarOpciones($publicacion->id,3,2)'><a class='pausar opciones'  id='' href='' data-toggle='modal' value='reactivar'>Finalizar</a></li>";
					break;
				case 3:
					$boton1="<li onclick='javascript:republicarPublicacion($publicacion->id)'><a class='pausar opciones'  id='' href='' data-toggle='modal' data-target='#info-publicacion' value='republicar'>Republicar</a></li>";			
					$boton2="<li onclick='javascript:eliminarPublicacion($publicacion->id)'><a class='pausar opciones'  id='' href='' data-toggle='modal' value='eliminar'>Eliminar</a></li>";
					break;
			}			
			$cadena="<span id='general" . $valor["id"] . "' name='general" . $valor["id"] . "' class='general' data-titulo={$valor["titulo"]}>
			<div class='col-xs-12 col-sm-12 col-md-1 col-lg-1  '>			
					<div class='marco-foto-publicaciones  point ' style='width: 65px; height: 65px;' > <img src='" . $publicacion->getFotoPrincipal() . "' width='100%' height='100%;' 
					style='border: 1px solid #ccc;' class='img img-responsive center-block imagen' data-id='" . $valor["id"] . "'> </div>				
			</div>
			<div class='col-xs-12 col-sm-12 col-md-6 col-lg-6 vin-blue t14  '>
				<span class='detalle.php'> <a href='detalle.php?id={$valor["id"]}'><span id='titulo" . $valor["id"] . "'>" .  ($valor["titulo"]) . "</span> </a>
				<br>
				<span class='opacity'># $publicacion->id</span>
			</div>
			<div class='col-xs-12 col-sm-12 col-md-2 col-lg-2  text-left '>
				<span class='red t14' id='monto" . $valor["id"] . "'>" . $publicacion->getMonto(1) . " </span>
				<span class='t12 opacity' id='stock" . $valor["id"] . "'> x " . $publicacion->stock . " und</span>
				<br>
				<span> " . $publicacion->getVisitas() . " Visitas</span>
				<span class='opacity hidden'> / </span>
				<span class=' blue-vin hidden'> 30 ventas </span>
			</div>
			<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 text-center t12 '>
				<div class='btn-group pull-right marR10'>					
					<button id='b" . $publicacion->id . "' type='button' class='btn2 btn-warning boton' data-toggle='modal' data-target='#info-publicacion' onclick='javascript:pasavalores($publicacion->id)'
					data-id='$publicacion->id' data-titulo='" .  ($publicacion->titulo) . "' data-stock='$publicacion->stock'  data-monto='" . number_format($publicacion->monto,2,',','.') . "' data-id='b" . $publicacion->id . "' data-listado='{$tipo}' $des>
						Modificar
					</button>
					<textarea  class='hidden' id='descripcion_" . $publicacion->id . "'>
								$publicacion->descripcion
					</textarea >
					<button id='btnReactivar" . $publicacion->id . "' type='button' class='btn2 btn-warning hidden' data-toggle='modal' onclick='javascript:modificarOpciones(" . $publicacion->id . ",1,1)'>
						Reactivar
					</button> 
					<button id='btnPausar" . $publicacion->id . "' type='button' class='btn2 btn-warning hidden' data-toggle='modal' onclick='javascript:modificarOpciones(" . $publicacion->id . ",2,2)'>
						Pausar
					</button>						
					<button id='btnFinalizar" . $publicacion->id . "' type='button' class='btn2 btn-warning hidden' data-toggle='modal' onclick='javascript:modificarOpciones(" . $publicacion->id . ",3,3)'>
						Finalizar
					</button>					
					<button id='btnOpciones" . $publicacion->id . "' type='button' class='btn2 btn-warning dropdown-toggle  ' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' >
						<span class='glyphicon glyphicon-cog '></span>
						<span class='caret'></span>
					</button>
					<ul  class='  dropdown-menu'  id='opciones'>			
							$boton1						
							$boton2						
					</ul>
					<div id='menPau" . $publicacion->id . "' class='alert alert-success t10 hidden' style='padding:3px;margin-bottom:0px; margin-top:3px;' role='alert'>
						Publicacion pausada
					</div>
					<div id='menAct" . $publicacion->id . "' class='  alert alert-success t10 hidden' style='padding:3px;margin-bottom:0px; margin-top:3px;' role='alert'>
						Publicacion activa
					</div>
					<div id='menFin" . $publicacion->id . "' class='  alert alert-success t10 hidden' style='padding:3px;margin-bottom:0px; margin-top:3px;' role='alert'>
						Publicacion finalizada
					</div>
					<div id='menRep" . $publicacion->id . "' class='  alert alert-success t10 hidden' style='padding:3px;margin-bottom:0px; margin-top:3px;' role='alert'>
						Republicada
					</div>
				</div>
			</div>
			<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10'>
				<center><hr class=' center-block'></center>
			</div>
		</span>";
			echo $cadena;
		}
		echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10'>
			<nav class='text-center'>
			  <ul class='pagination'>";
								$ac=$usua2->getCantidadPub($tipo);
								$totalPaginas=floor($ac/25);
								$restantes=$ac-($totalPaginas*25);
								if($restantes>0){
									$totalPaginas++;
								}
								echo"</div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' id='paginas' name='paginas' data-metodo='buscarPublicaciones' data-tipo='" . $tipo . "' data-id='" . $usua2->id . "' > <center><nav><ul class='pagination'>";
								$contador=0;
								if($pagina<=10){
									$inicio=1;
								}else{
									$inicio=floor($pagina/10);
									if($pagina % 10!=0){
										$inicio=($inicio*10)+1;
									}else{
										$inicio=($inicio*10)-9;
									}									
								}
								 								 
								for($i=$inicio;$i<=$totalPaginas;$i++){
									$contador++;
									if($i==$pagina){ 
										echo "<li class='active' style='cursor:pointer'><a class='botonPagina' data-pagina='" . $i ."'>$i</a></li>";
									}else{
										echo "<li class='' style='cursor:pointer'><a class='botonPagina' data-pagina='" . $i ."'>$i</a></li>";
									}
									if($contador==10){
										break;
									}
								}
				 if($totalPaginas>0){
				 echo "<li>
				      <a href='#' aria-label='Next'>
				        <span aria-hidden='true'>&raquo;</span>
				      </a>
				    </li>
			  </ul>
			</nav>
			</div>	";
		   }
		   if($contador==0){
			?>
			<script>
				$("#noresultados").removeClass("hidden");
				$("#publicaciones").addClass("hidden");
			</script>		  	
			<?php
			}else{
			?>
			<script>
			$("#noresultados").addClass("hidden");
			$("#publicaciones").removeClass("hidden");
			</script>
			<?php		  						
		}
}
function actualiza(){
	$bd=new bd();
	$publi=new publicaciones($_POST["id"]);
	$monto=$_POST["monto"];
	$publi->setMonto($monto);
	$bd->doUpdate("publicaciones", array("titulo"=> ($_POST["titulo"]),"stock"=>$_POST["stock"],"monto"=>$monto), "id={$_POST["id"]}");
}
function cambiaStatus(){
	$publi=new publicaciones($_POST["id"]);
	$publi->setStatus($_POST["tipo"],$_POST["anterior"]);
}
function instancia(){
	$publi=new publicaciones($_POST["id"]);
}
function actualizaPub(){
	$publi=new publicaciones($_POST["id"]);	
	$listaValores=array(
			"titulo"=>$_POST["txtTitulo"],
			"descripcion"=>$_POST["editor"],
			"stock"=>$_POST["txtCantidad"],
			"dias_garantia"=>isset($_POST["chkGarantia"])?$_POST["cmbGarantia"]:NULL,
			"dafactura"=>isset($_POST["chkEntregaFactura"])?'S':'N',
			"estienda"=>isset($_POST["chkEresTienda"])?'S':'N',
			"condiciones_publicaciones_id"=>$_POST["cmbCondicion"],
			"monto"=>$_POST["monto"],
			"vencimientos_publicaciones_id"=>2);
			
			
	$monto = $_POST["monto"];
	$fecha=time();
	for ($i=0; $i < 6 ; $i++) {
		if(isset($_POST["foto-".$i])){
			$fotos[] = $_POST["foto-".$i];
		}
	} 	
	$listaValores["dias_garantia"]=str_replace("gn", "&ntilde;", $listaValores["dias_garantia"]);
	$listaValores["titulo"]= ($listaValores["titulo"]);
	$publi->actualizarPublicacion($listaValores,$monto,$fotos);
	echo "OK";
}
function republica(){
	$publi=new publicaciones($_POST["id"]);	
	$listaValores=array(
			"titulo"=>$_POST["titulo"],
			"monto"=>$_POST["monto"],
			"stock"=>$_POST["stock"]);
	$resultado=$publi->volveraPublicar($listaValores);			
	echo $resultado;
}
function buscarCaliente(){
	$bd=new bd();
	$result=$bd->query("select * from publicaciones where usuarios_id={$_POST["usuarios_id"]} and titulo like '%{$_POST["palabra"]}%' and id in (
	select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)");
	$devolver="";
	foreach ($result as $key => $valor) {
		$devolver.="<a href=detalle.php?id='" . $valor["id"] . "'>" . $valor["titulo"] . "</a><br>";
	}
	echo $devolver;
}

?>