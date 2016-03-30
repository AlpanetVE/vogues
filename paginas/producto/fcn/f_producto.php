<?php
	require '../../../config/core.php';
	include '../../../clases/producto_p.php';
	include '../../../clases/ventas.php';
	switch($_POST["metodo"]){
		case "buscar":
			buscar();
			break;
		case "crearProducto":
			crearProducto();
			break;
		case "getProducto":
			buscarProductos();
			break;
		case "update":
			modificarProducto();
			break;
		case "paginar":
			paginator();
			break;
		case "modificarStatus":
			modificarStatus();
			break;
		default :
			echo "error";
			break;
	}
	function buscar(){
	 	if (! isset ( $_SESSION )) {
			session_start ();
		}
		if(isset($_COOKIE["c_id"])){
			$id_user=$_COOKIE["c_id"];
		}else{
			$id_user=NULL;
		}
		$orden='productos.id desc';
		$pagina=$_POST['pagina'];
		$status=$_POST['status'];
		$categoria=$_POST['categoria'];
		$proveedor=$_POST['proveedor'];
		$busqueda=$_POST['busqueda'];
		$producto=new producto();		
		//TRAEMOS LOS DATOS QUE USAREMOS
		
		$campos='productos.compras_publicaciones_id,productos.codigo, descripcion, precio_compra, productos_categorias.nombre, productos.id, proveedores.nombre as proveedor, proveedores.id as prov_id';
		$result=$producto->getProductos($campos, $orden,$pagina, $status, $categoria, $proveedor, $busqueda);		
		switch($status){
				case 1:
					$boton0='<span>Disponible</span>';
					$boton1="<li><a class='pausar opciones pointer'    data-status='2'  id=''   data-toggle='modal' data-target='#edit-status-garantia' value='pausar'>Garantia</a></li>";
					$boton2="<li><a class='finalizar opciones pointer' data-status='3' id='' data-toggle='modal' data-target='#edit-status-facturado'  value='finalizar'>Facturado</a></li>";
					break;
				case 2:
					$boton0='<span>Garantia</span>';
					$boton1="<li><a class='pausar opciones pointer send-status'    data-status='1' id=''  data-toggle='modal' value='reactivar'>Disponible</a></li>";
					$boton2="";
					break;
				case 3:
					$boton0='<span>Facturado</span>';
					$boton1="<li><a class='pausar opciones pointer'    data-status='2' id=''  data-toggle='modal' data-target='#edit-status-garantia' value='reactivar'>Garantia</a></li>";
					$boton2="";
					break;
		}
		foreach($result as $r=>$fila){
				?>
			<tr>
				<td><?php echo $fila['nombre']; ?></td>
				<td><?php echo $fila['descripcion']; ?></td>
				<td><?php echo $fila['codigo']; ?></td>				
				<td><?php echo $fila['precio_compra']; ?></td>
				<td><a class="admin-ver-prov" data-toggle="modal" data-target="#ver-prov"  data-proveedor_id="<?php echo $fila['prov_id']; ?>" ><?php echo $fila['proveedor']; ?></a></td>
           		
           		<?php 
           			
				if($status=='2' || $status=='3'){
					echo '<td>';
					if(!empty($fila['compras_publicaciones_id'])){
						echo $fila['compras_publicaciones_id'];
					}else{
						echo '-';
					}						
					echo '</td>';
				}      
           		if($status=='2'){
					$campos='statusxproductos.motivo';
					$id_prod=$fila['id'];
					$historico=$producto->getHistorico($campos, 'id desc',null, $status, $id_prod);			 
						echo '<td>'.$historico["motivo"].'</td>';
				} ?>
           		<td><div data-producto_id="<?php echo $fila['id']; ?>" class="opciones-boton col-xs-12">
					<button id='btnOpciones'  type='button' class='btn2 btn-warning dropdown-toggle  ' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' >
						<?php echo $boton0;?>
						<span class='caret'></span>
					</button>
					<ul  class='  dropdown-menu'  id='opciones'>	
						<?php
							echo $boton1;
							echo $boton2;
						?>
					</ul>
					</div>
				</td>					
           </tr>
     <?php
		}
		
		 $result=$producto->getProductos('count(productos.id) as total', $orden,$pagina, $status, $categoria, $proveedor,$busqueda)->fetch();
			echo '<input type="hidden" value="'.$result['total'].'" id="cantidad_total_row" />';
	}
	function crearProducto() {
		$producto = new producto();
		$proveedor = filter_input ( INPUT_POST, "proveedor" );
		$categoria = filter_input ( INPUT_POST, "categoria" );
		
		$codigo = $_POST['codigo'];
		$precio = $_POST['precio'];
		$descripcion = $_POST['descripcion'];
		
		
		$producto->datosRelacionProducto($proveedor, $categoria);
		$producto->datosTempProducto($codigo, $precio, $descripcion);
		$producto->crearProducto();
		
		echo json_encode ( array (
					"result" => "ok"
			) );		 
	}
	 function buscarProductos($returnValores=null){
		if(!isset($_POST["id"])){
			if(!isset($_SESSION)){
				session_start();
			}
			$id=$_SESSION ["id"];
		}else{
			$id=$_POST ["id"];
		}
		$producto = new producto ($id);
		$reflection = new ReflectionObject ($producto);
		$properties = $reflection->getProperties ( ReflectionProperty::IS_PRIVATE );
		foreach ( $properties as $property ) {
			$name = $property->getName();
			if(isset($_POST ["id"])){
				$valores [$name] = $producto->$name;				
			}
		}
		
		if($returnValores){
			 return $valores;
		}else{
			echo json_encode ( array (
			"result" => "OK",
			"campos" => $valores) );
		}
	}
	 function modificarProducto() {
		$producto = new producto();
		
		$id = filter_input ( INPUT_POST, "id" );
		$proveedor = filter_input ( INPUT_POST, "proveedor" );
		$categoria = filter_input ( INPUT_POST, "categoria" );
		$codigo = filter_input ( INPUT_POST, "codigo" );
		$precio = filter_input ( INPUT_POST, "descripcion" );
		$descripcion = filter_input ( INPUT_POST, "precio" );		
			
		$listaValores_producto=array(
			"proveedores_id"=>$proveedor,
			"productos_categorias_id"=>$categoria,
			"codigo"=>$codigo,
			"precio_compra"=>$precio,
			"descripcion"=>$descripcion);
		
		$producto->id=$id;
		$producto->modificarProducto($listaValores_producto);
		 
		 echo json_encode ( array (
					"result" => "ok"
			) );
	 }
	 function paginator($total=null){
		if(empty($total))
			$total=$_POST['total_row'];
		
		$totalPaginas=ceil($total/25);		
		$oculto="";
		$activo="active";
		$paginador='<div id="paginacion" name="paginacion" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" data-paginaActual="1" data-total="'.$total.'">
					<center><nav><ul class="pagination">
											<li id="anterior2" name="anterior2" class="hidden"><a href="#" aria-label="Previous" class="navegador" data-funcion="anterior2"><i class="fa fa-angle-double-left"></i> </a>
											<li id="anterior1" name="anterior1" class="hidden"><a href="#" aria-label="Previous" class="navegador" data-funcion="anterior1"><i class="fa fa-angle-left"></i> </a>';									
									 										
											for($i=1;$i<=$totalPaginas;$i++):
											
												$paginador.='<li class="'.$activo.' '.$oculto.'"><a class="botonPagina" href="#" data-pagina="'.$i.'">'.$i.'</a></li>';
											
											$activo="";
											if($i==10)
											$oculto=" hidden";
											endfor;
										
											if($totalPaginas>1):
												$paginador.='<li id="siguiente1" name="siguiente1"><a href="#" aria-label="Next" class="navegador" data-funcion="siguiente1"><i class="fa fa-angle-right"></i> </a></li>';
											
											endif;
											 
											if($totalPaginas>10):
												$paginador.='<li id="siguiente2" name="siguiente2"><a href="#" aria-label="Next" class="navegador" data-funcion="siguiente2"><i class="fa fa-angle-double-right"></i> </a></li>';
											 
											endif;
									
										$paginador.='</ul></nav></center></div>';
								
		if(empty($_POST['total_row']))
			return $paginador;
		else			
			echo $paginador;
	}
	function modificarStatus()
	{
		$id = filter_input ( INPUT_POST, "id" );
		$producto = new producto($id);
		$motivo = isset($_POST["motivo"])?filter_input ( INPUT_POST, "motivo" ):'';
		$status = filter_input ( INPUT_POST, "status" );
		$fecha = date("Y-m-d H:i:s",time());
		$compras_publicaciones = filter_input ( INPUT_POST, "codigo_venta" );
		
		$listaValores_statusxproductos=array(
			"productos_id"=>$id,
			"fecha"=>$fecha,
			"status"=>$status,
			"motivo"=>$motivo
			);
		
		
		if($status=='3'){
			$ventas = new ventas($compras_publicaciones);
			$exist=$ventas->id;

			$ProductoxCategoria=$producto->VerificarPublicacion($ventas->publicaciones_id);
			
			if(!empty($exist) && $ProductoxCategoria){
				$result=$ventas->buscarCompraFacturar();
				if($result){
					$listaValores_producto=array("compras_publicaciones_id"=>$compras_publicaciones);
					$resut=$producto->modificarProducto($listaValores_producto);
					if($resut)
						$producto->modificarStatus($listaValores_statusxproductos);
				}else{
					echo json_encode ( array ("result" => "cod_no_valid") );die();
				}
			}else{
				echo json_encode ( array ("result" => "cod_no_valid") );die();
			}			
		}else{
			$producto->modificarStatus($listaValores_statusxproductos);
		}
		echo json_encode ( array (
					"result" => "ok"
			) );
			
		die();
		
	}

?>