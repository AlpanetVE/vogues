<?php include "clases/proveedor.php"; 
	include "clases/producto_p.php"; 
	
	$productos_id=isset($_GET["producto"])?$_GET["producto"]:"";
	$proveedores_id=isset($_GET["proveedor"])?$_GET["proveedor"]:"";
	
?>
<div class="pad20 marL10 contenedor row">
            <div class="marB15">
                <h4>
                    Panel administrativo de Articulos
                </h4>
                <hr>
	                	<div class="text-right col-xs-4 col-xs-offset-8 marT5">
		                   <a class="admin-reg-prod" href="#" data-toggle='modal' data-target='#reg-prod' data-rol-type='select'  data-tipo='1' >
								<button class="btn2 btn-default t16 " style="">Agregar Mercanc&iacute;a</button>
							</a>
						</div>
	               
	              
            </div>
            <div class="col-xs-12"> 
	            <div class="tabbable tabs-up">
	                <ul class="nav nav-tabs">
	                    <li class="active">
	                        <a href="#tab-shop-activo" data-toggle="tab" data-status="1" class="tab-shop" style="outline: inherit;">Disponible</a>
	                    </li>
	                    <li>
	                        <a href="#tab-shop-garantia" data-toggle="tab" data-status="2" class="tab-shop" style="outline: inherit;">Garantia</a>
	                    </li>
	                    <li>
	                        <a href="#tab-shop-facturado" data-toggle="tab" data-status="3" class="tab-shop" style="outline: inherit;">Facturado</a>
	                    </li>
	                </ul>
	            </div>
            </div>
            <div class="col-xs-12 filter-header">
            	<div class="col-xs-3">
            		<div class="input-group">
						<span class="input-group-btn">
							<button class="btn-header btn-default-header" style="border: #ccc 1px solid; border-right:transparent;">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</span> 
		<input style="margin-left: -10px; border: #ccc 1px solid; border-left:1px solid #FFF;  " class="form-control-header " placeholder="Buscar" id="txtBusqueda" type="text">						 
					</div>
            	</div>
            	<div class="col-xs-3 col-xs-offset-4">
					<select class="form-select form-control search-submit" id="filter_categoria">
						<option value="" >Categoria</option>
						<?php
						$proveedores_obj = new proveedor();
						$categorias=$proveedores_obj->getAllDatos ("productos_categorias");
						foreach ($categorias as $categoria ) :
							?>
						<option value="<?php echo $categoria["id"].'" '; if($productos_id==$categoria["id"]){ echo 'selected'; } ?> ><?php echo $categoria["nombre"]; ?></option>
						<?php endforeach;?>
					</select>
	    		</div>
	            <div class="col-xs-2">
					<select class="form-select form-control search-submit" id="filter_proveedor">
						<option value="" >Proveedor</option>
						<?php												
						$proveedores=$proveedores_obj->getProveedores();
						foreach ($proveedores as $proveedor ) :
							?>
						<option value="<?php echo $proveedor["id"].'" '; if($proveedores_id==$proveedor["id"]){ echo 'selected'; } ?>><?php echo $proveedor["nombre"]; ?></option>
						<?php endforeach;?>
					</select>
	    		</div>    
            </div>
            
            <div class="tab-content">
                <div class="tab-pane active" id="tab-shop-activo" data-status="1">
                        <table class="table text-center table-hover">
                            <tr style="background: #D8DFEA">
                            	<th colspan="1" class="text-center">
                                    Categoria
                                </th>
                                <th class="text-center">
                                    Descripcion
                                </th>
                                <th class="text-center">
                                    Codigo
                                </th>
                                <th class="text-center">
                                    Costo
                                </th>
                                <th colspan="1" class="text-center">
                                    Proveedor
                                </th>
                                <th colspan="1" class="text-center">
                                   Estatus
                                </th>
                            </tr>
                            <tbody id="ajaxContainer">
                            </tbody>
                        </table>
                    
                    <div id="paginacion" name="paginacion" class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' data-paginaActual='1' >
                    	
					</div>
					
                </div>
                <div class="tab-pane" id="tab-shop-garantia" data-status="2">                    
                        <table class="table text-center table-hover">
                            <tr style="background: #D8DFEA">
                            	<th colspan="1" class="text-center">
                                    Categoria
                                </th>
                                <th class="text-center">
                                    Descripcion
                                </th>
                                <th class="text-center">
                                    Codigo
                                </th>
                                <th class="text-center">
                                    Costo
                                </th>
                                <th colspan="1" class="text-center">
                                    Proveedor
                                </th>
                                <th colspan="1" class="text-center">
                                    Cod. Venta
                                </th>
                                <th colspan="1" class="text-center">
                                    Motivo
                                </th>
                                <th colspan="1" class="text-center">
                                    Acci&oacute;n
                                </th>
                            </tr>
                            <tbody id="ajaxContainer">                                
                            </tbody>
                        </table>
                   
                    <div id="paginacion" name="paginacion" class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' data-paginaActual='1'>
                    
                    </div> 	
                </div>
                <div class="tab-pane" id="tab-shop-facturado" data-status="3">
                        <table class="table text-center table-hover">
                            <tr style="background: #D8DFEA">
                            	<th colspan="1" class="text-center">
                                    Categoria
                                </th>
                                <th class="text-center">
                                    Descripcion
                                </th>
                                <th class="text-center">
                                    Codigo
                                </th>
                                <th class="text-center">
                                    Costo
                                </th>
                                <th colspan="1" class="text-center">
                                    Proveedor
                                </th>
                                <th colspan="1" class="text-center">
                                    Cod. Venta
                                </th>
                                <th colspan="1" class="text-center">
                                    Acci&oacute;n
                                </th>
                            </tr>
                            <tbody id="ajaxContainer">
                            </tbody>
                        </table>                   
                    <div id="paginacion" name="paginacion" class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' data-paginaActual='1'>
					</div>
                </div>
            </div>
        </div>