<?php 
	include_once "../../../clases/usuarios.php";
	switch($_POST["metodo"]){
		case "buscar": 
			buscar();			
			break; 
	}
	 function buscar(){
		$usuarios=new usuario();
		
		$condicion=' (usuarios_accesos.status_usuarios_id IS NULL  OR
usuarios_accesos.status_usuarios_id <>  "3") ';
		$orden='';
		$pagina=$_POST["pagina"];
		$result=$usuarios->getUsuarios($condicion, $orden ,$pagina);
		
		foreach($result as $r=>$valor){
					 
						
				?>
				<tr>
                    <td><?php echo $valor["seudonimo"]; ?></td>
                    <td><?php echo $valor["nombre"]; ?></td>
                    <td><?php echo $valor["apellido"]; ?></td>
                    <td><?php echo $valor["rol"]; ?></td>
                    
                   
                        <td><a href="#mod" class="update_user show-select-rol" data-toggle="modal" data-target="#usr-update-info" data-rol-type="select" data-tipo="1" data-method="actualizar" data-usuarios_id="<?php echo $valor['id']; ?>"  ><i class="fa fa-lock" ></i> Modificar</a></td>
                        <td><a href="#del" class="select-usr-delete " data-toggle="modal" data-target='#msj-eliminar' data-status='3'  data-usuarios_id="<?php echo $valor['id']; ?>"   >
                        		<i class="fa fa-remove"></i> Eliminar
                        	</a> 
                        </td>
                    
                </tr>
                <?php
		}
	}
?>