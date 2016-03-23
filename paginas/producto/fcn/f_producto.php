<?php
	require '../../../config/core.php';
	include '../../../clases/producto_p.php';
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
		$orden='id desc';
		$pagina=$_POST['pagina'];
		$status=$_POST['status'];
		$categoria=$_POST['categoria'];
		$proveedor=$_POST['proveedor'];
		$busqueda=$_POST['busqueda'];
		$producto=new producto();		
		//TRAEMOS LOS DATOS QUE USAREMOS
		$campos='productos.codigo, descripcion, precio_compra, productos_categorias.nombre, productos.id, proveedores.nombre as proveedor, proveedores.id as prov_id';
		$result=$producto->getProductos($campos, $orden,$pagina, $status, $categoria, $proveedor, $busqueda);
		foreach($result as $r=>$fila){
				?>
			<tr>
				<td><?php echo $fila['nombre']; ?></td>
				<td><?php echo $fila['descripcion']; ?></td>
				<td><?php echo $fila['codigo']; ?></td>				
				<td><?php echo $fila['precio_compra']; ?></td>
				<td><a class="admin-ver-prov" data-toggle="modal" data-target="#ver-prov"  data-proveedor_id="<?php echo $fila['prov_id']; ?>" ><i class="fa fa-eye"  ></i> <?php echo $fila['proveedor']; ?></a></td>
                <td title="Editar informacion del Producto" ><a href="#mod" class="admin-edit-prod" data-toggle="modal" data-target="#edit-prod" data-producto_id="<?php echo $fila['id']; ?>" ><i class="fa fa-user"></i>  Editar  </a></td>
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
?>