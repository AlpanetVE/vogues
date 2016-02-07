<div class=" pad10 eti-blanco borderS">
        <div class=" marB20 "> 
            <h4 class="pull-left"><i class="fa fa-user"></i> Panel administrativo de usuarios</h4> 
            
            <div class="pull-right">
            	<a class="btn_sin_cuenta alert-reg show-select-rol" href="#" data-toggle='modal' data-target='#usr-reg' data-rol-type='select'  data-tipo='1' >
            		<button class="btn2 btn-default t16" style="">Agregar Usuario</button>
            	</a>  
            	
            	<span id="tw_reg_button" data-tipo='1'></span>
            	<span id="actualizar2" data-tipo='1'></span> 
            	
            </div>
        </div>
        <table class="table table-striped text-center table-hover">
            <tr>
                <th class="text-center">Seudonimo</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Apellido</th>
                <th class="text-center">Rol</th>
                <th colspan="2" class="text-center">Acciones</th>       
            </tr>    
            <tbody id="ajaxContainer">
            <?php
            
 				$hijos=$usua->getUsuarios(' (usuarios_accesos.status_usuarios_id IS NULL  OR
usuarios_accesos.status_usuarios_id <>  "3") ');

				$total=$hijos->rowCount();  
				
				$totalPaginas=ceil($total/25);
				$contador=0; 
				foreach ($hijos as $fila) {
                ?>            
                <tr>
                    <td><?php echo $fila["seudonimo"]; ?></td>
                    <td><?php echo $fila["nombre"]; ?></td>
                    <td><?php echo $fila["apellido"]; ?></td>
                    <td><?php echo $fila["rol"]; ?></td> 
                        
                        <td><a href="#mod" class="update_user show-select-rol" data-toggle="modal" data-target="#usr-update-info" data-rol-type="select" data-tipo="1" data-method="actualizar" data-usuarios_id="<?php echo $fila['id']; ?>"  ><i class="fa fa-lock" ></i> Modificar</a></td>
                        <td><a href="#del" class="select-usr-delete " data-toggle="modal" data-target='#msj-eliminar' data-status='3'  data-usuarios_id="<?php echo $fila['id']; ?>"   >
                        		<i class="fa fa-remove"></i> Eliminar
                        	</a> 
                        </td>
                    
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <div id="paginacion" name="paginacion" class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' data-paginaActual='1' data-total="<?php echo $total;?>"><center><nav><ul class='pagination'>
					    	<!--
								<li><a href='listado.php' aria-label='Previous'><i class='fa fa-angle-double-left'></i></a></li>
								<li><a href='#' aria-label='Previous'><i class='fa fa-angle-left'></i></a></li>
								-->
									<li id="anterior2" name="anterior2" class="hidden"><a href='#' aria-label='Previous' class='navegador' data-funcion='anterior2'><i class='fa fa-angle-double-left'></i> </a>
									<li id="anterior1" name="anterior1" class="hidden"><a href='#' aria-label='Previous' class='navegador' data-funcion='anterior1'><i class='fa fa-angle-left'></i> </a>											
									<?php
									$oculto="";
									$activo="active";									
									for($i=1;$i<=$totalPaginas;$i++):
									?>
										<li class="<?php echo $activo; echo $oculto;?>"><a class="botonPagina" href='#' data-pagina="<?php echo $i;?>"><?php echo $i;?></a></li>
									<?php
									$activo="";
									if($i==10)
									$oculto=" hidden";
									endfor;
								?>
								<?php
									if($totalPaginas>1):
									?>								
										<li id="siguiente1" name="siguiente1"><a href='#' aria-label='Next' class='navegador' data-funcion='siguiente1'><i class='fa fa-angle-right'></i> </a>
									<?php
									endif;
									?>
								<?php
									if($totalPaginas>10):
										?>
										<li id="siguiente2" name="siguiente2"><a href='#' aria-label='Next' class='navegador' data-funcion='siguiente2'><i class='fa fa-angle-double-right'></i> </a>
									<?php
									endif;
								?>
								</li></ul>
						</nav></center></div>
    </div>