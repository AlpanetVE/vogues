<?php
	require '../../../config/core.php';
	include '../../../clases/inventario.php';
	switch($_POST["metodo"]){
		case "buscar":
			buscar();
			break;	
		case "crearCategoria":
			crearCategoria();
			break;	
		case "updateCategoria":
			updateCategoria();
			break;	
		case "eliminarCategoria":
		eliminarCategoria();
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
		
		$categoria=new inventario();
		
		$orden='id desc';
		$pagina=$_POST["pagina"];
		$nombre=isset($_POST['nombre'])?$_POST['nombre']:null;
		$status=isset($_POST['filtrostatus'])?$_POST['filtrostatus']:null;
		$result=$categoria->getCategorias2(null,$nombre,$status);
		foreach($result as $r=>$fila){
				$cantidad=$categoria->getProductosDisponibles('count(id) as total',$fila['id']);
				?>
				<tr>
                    <td> <a href="#mod" class="admin-edit-categ" data-toggle="modal" data-target="#edit-categoria" data-nombre-cate="<?php echo $fila['nombre']; ?>" data-categoria_id="<?php echo $fila['id']; ?>" ><?php echo $fila["nombre"]; ?> </a></td>
                    <td><?php echo  $cantidad?> </td>
                    <td><a href="producto.php?producto=<?php echo $fila['id']; ?>"  ><i class="fa fa-eye"  ></i> Ver </a></td>
                     <td ><a href="#mod" class="admin-add-categoria"  data-toggle='modal' data-target='#reg-prod'  data-categoria_id="<?php echo $fila['id']; ?>" ><i class="fa fa-plus"  ></i> Agregar </a></td>
                <?php if($cantidad<=0 && $fila['status']=='0') {
                	  ?>
                    <td ><a href="#mod" class="admin-elim-categ"  data-toggle="modal" data-target="#eliminar-categoria"  data-status_categoria="<?php echo $fila['status']; ?>" data-categoria_id="<?php echo $fila['id']; ?>" ><i style="font-size: larger;" class="fa fa-remove"></i></a></td>
                  <?php } else { ?>
                  <td ><p href="" class="admin-elim-disabled"  data-status_categoria="<?php echo $fila['status']; ?>" data-categoria_id="<?php echo $fila['id']; ?>" ><i style="font-size: larger;" class="fa fa-remove"></i></p></td>
                  <?php } ?>
                  <td><?php 
				  switch ($fila['status']) {
						case '0': echo '<a class="admin-reg-prov" href="publicar.php?categ='.$fila['id'].'"  data-tipo="1" ><button class="btn2 btn-default t16 ">Publicar</button></a>';break;
						case '1': echo '<span> Activa</span>';break;
						case '2': echo '<span> Pausada</span>';break;
						case '3': echo '<span> Finalizada</span>';break;
				  } ?>				  
                </tr>
                <?php
				  
		}
	}
	
	function crearCategoria(){
		$categoria=new inventario();
		$validado=	true;
		$nombre= filter_input ( INPUT_POST, "categ_nombre" );
		//$res=$categoria->crearCategoria($nombre);
		if($categoria->valueExist("productos_categrias", $nombre, "nombre")){
			$fields ["categ_nombre"] = "Seleccione otro nombre";	 
		$validado=false;
		}
		
		if($validado) {
			$res=$categoria->crearCategoria($nombre);
			 
				echo json_encode ( array (
						"result" => "OK" 
				) );
		 
	}else{
		echo json_encode ( array (		
					"result" => "error",		
					"fields" => $fields 		
			) );		
			exit ();
	}
}

	function updateCategoria(){
		$categoria=new inventario();
		$nombre= filter_input ( INPUT_POST, "upd_categ_nombre" );
		$id= filter_input ( INPUT_POST, "id" );
		if($categoria->valueExist("productos_categrias", $nombre, "nombre")){
			$fields ["upd_categ_nombre"] = "Seleccione otro nombre";	 
		$validado=false;
		}
		
		if($validado) {
			$res=$categoria->actualizarCategoria($nombre, $id);;
			 
				echo json_encode ( array (
						"result" => "OK" 
				) );
		 
	}else{
		echo json_encode ( array (		
					"result" => "error",		
					"fields" => $fields 		
			) );		
			exit ();
	}
		
		
	}

	function eliminarCategoria(){
		$categoria=new inventario();
		$id= filter_input ( INPUT_POST, "id" );
		$res=$categoria->eliminarCategoria($id);
		if($res){
			echo json_encode (array ("result"=>"ok"));
			
		}
	}


?>