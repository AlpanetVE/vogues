<?php
	require '../../../config/core.php';
	include '../../../clases/proveedor.php';
	switch($_POST["metodo"]){
		case "buscar":
			buscar();
			break;
		case "crearProveedor":
			crearProveedor();
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
		
		$proveedor=new proveedor();
		$orden='id desc';
		$pagina=$_POST["pagina"];
		$result=$proveedor->getProveedores(null, $orden ,$pagina);
		foreach($result as $r=>$fila){

				?>
				<tr>
                    <td><?php echo $fila["documento"]; ?></td>
                    <td><?php echo $fila["nombre"]; ?></td>
                    <td><?php echo $fila["telefono"]; ?></td>
                    <td><?php echo $fila["email"]; ?></td>        
                   
                    <td><a href="#mod" class="update_user show-select-rol" data-toggle="modal" data-target="#usr-update-info" data-rol-type="select" data-tipo="1" data-method="actualizar" data-usuarios_id="<?php echo $fila['id']; ?>"  ><i class="fa fa-lock" ></i> Modificar</a></td>
                   <!-- <td><a href="#del" class="select-usr-delete " data-toggle="modal" data-target='#msj-eliminar' data-status='3'  data-usuarios_id="<?php echo $fila['id']; ?>"   >
                    		<i class="fa fa-remove"></i> Eliminar
                    	</a> 
              		</td>-->
                    
                </tr>
                <?php
		}
	}

	function crearProveedor() {
		$proveedor = new proveedor();
		$documento = filter_input ( INPUT_POST, "prov_documento" );
		$nombre = filter_input ( INPUT_POST, "prov_nombre" );
		$telefono = filter_input ( INPUT_POST, "prov_telefono" );
		$email = filter_input ( INPUT_POST, "prov_email" );
		$direccion = filter_input ( INPUT_POST, "prov_direccion" );
		$usuario->datosProveedor($documento, $nombre, $telefono, $email, $direccion);
		//$usuario->datosBanco ( $seudonimo, $email, $password ,0, $id_rol, $status_usuarios_id); 
		$usuario->crearProveedor();	
					
		echo json_encode ( array (
					"result" => "ok" 
			) );
		 
	}
?>