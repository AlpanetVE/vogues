<?php
class inventario extends bd {
	/* * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Attributes ---============ *
	 * * * * * * * * * * * * * * * * * * * * * * */
	protected $p_table = "productos";
	private $id = 0;
	private $p_codigo;
	private $p_descripcion;
	private $p_precio_compra;
	private $p_proveedores_id;
	private $p_productos_categorias_id;
	private $p_compras_publicaciones_id;
	private $p_status;

	protected $c_table = "productos_categorias";
	private $c_id = 0;
	private $c_codigo;
	private $c_nombre;
	private $c_stock;
	
	/* * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Contructor ---============ *
	 * * * * * * * * * * * * * * * * * * * * * * */
	public function inventario($id = NULL) {
		parent::__construct();
		if ($id != NULL) {
			
		}
	}
	/* * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Methods ---=========== *
	 * * * * * * * * * * * * * * * * * * * * */
	

	public function buscarProducto($id){
		// hace consulta y setea valores
		
		if(!empty($id)){
			$this->id = $id;
			$this->getDatosProductos();
		} 
	}
	
	/* * * * * * * * * * * * * * * * * * *
	 * =========--- Getters ---========= *
	 * * * * * * * * * * * * * * * * * * */
	 
	 public function getCategorias(){
	 	$result=$this->doFullSelect($this->c_table);
	 	if($result){ 
		return $result;
		}
		else {
		return false;
		}
	 }
	 
	public function getDatosProductos(){
		$result = $this->doSingleSelect($this->p_table,"id = {$this->id}");
		if($result){
			$this->datosProductos($result["codigo"], $result["descripcion"], $result["precio_compra"], $result["proveedores_id"], $result["productos_categorias_id"], $result["compras_publicaciones_id"], $result["status"]);			
			$this->id = $result["id"];
		}else{
			return false;
		}
	}	
	
	
	
	/* * * * * * * * * * * * * * * * * * *
	 * =========--- Setters ---========= *
	 * * * * * * * * * * * * * * * * * * */
	 public function datosProductos($codigo,$descripcion, $precio_compra,$proveedor_id, $producto_categoria_id, $compra_publicacion_id,$status ){
	 	$this->p_codigo=$codigo;
		$this->p_descripcion=$descripcion;
		$this->p_precio_compra=$precio_compra;
		$this->p_proveedores_id=$proveedor_id;
		$this->p_productos_categorias_id=$producto_categoria_id;
		$this->p_compras_publicaciones_id=$compra_publicacion_id;
		$this->p_status=$status;
	 	
	 }
	 
	
	/* * * * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Private Methods ---=========== *
	 * * * * * * * * * * * * * * * * * * * * * * * * */
	private function serializarDatos($prefix = "u_", $foreign_table = false) {
		$reflection = new ReflectionObject ( $this );
		$properties = $reflection->getProperties ( ReflectionProperty::IS_PRIVATE );
		foreach ( $properties as $property ) {
			$name = $property->getName ();
			if (substr ( $name, 0, 2 ) == $prefix || $name == "id") {
				if ($name == "id") {
					if ($foreign_table != false) {
						if (is_array ( $foreign_table )) {
							foreach ( $foreign_table as $f_table ) {
								$params ["{$f_table}_id"] = $this->$name;
							}
						} else {
							$params ["{$foreign_table}_id"] = $this->$name;
						}
					} else {
						$params ["id"] = $this->$name;
					}
				} else {
					$params [substr ( $name, strpos ( $name, "_" ) + 1 )] = $this->$name;
				}
			}
		}
		// var_dump ( $params );
		return $params;
	}
	
}