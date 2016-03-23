<?php
class producto extends bd {
	/* * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Attributes ---============ *
	 * * * * * * * * * * * * * * * * * * * * * * */
	protected $p_table = "productos";
	private $id;
	private $p_codigo;
	private $p_descripcion;
	private $p_precio_compra;
	private $p_proveedores_id;
	private $p_productos_categorias_id;
	private $p_status;
	
	private $temp_codigo;
	private $temp_descripcion;
	private $temp_precio_compra;
	
	
	/* * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Contructor ---============ *
	 * * * * * * * * * * * * * * * * * * * * * * */
	public function producto($id = NULL) {
		parent::__construct();
		if ($id != NULL) {
			$this->buscarProducto ( $id );
		}
	}
	/* * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Methods ---=========== *
	 * * * * * * * * * * * * * * * * * * * * */
	public function buscarProducto($id) {
		// hace consulta y setea valores
		if(!empty($id)){
			$this->id = $id;
			$this->getdatosProducto();
		} 
	}
	public function crearProducto() {
		$count=count($this->temp_codigo);
		for($i=0;$i<$count;$i++){
			$this->datosProducto($this->temp_codigo[$i], $this->temp_precio_compra[$i], $this->temp_descripcion[$i]);
			$this->doInsert ( $this->p_table,$this->serializarDatos ("p_"));
		}
	}
	public function getProductos($campos = null, $order= null, $pagina= null, $status= null, $categoria= null, $proveedor= null, $busqueda= null){
		$campos=is_null($campos)?"*":$campos;
		$consulta="select $campos FROM
				productos_categorias
				Inner Join productos ON productos.productos_categorias_id = productos_categorias.id
				Inner Join proveedores ON productos.proveedores_id = proveedores.id WHERE 1";
		
		
		if(!empty($status)){
			$consulta.=" and productos.status =  '$status' ";
		}
		if(!empty($categoria)){
			$consulta.=" and productos.productos_categorias_id =  '$categoria' ";
		}
		if(!empty($proveedor)){
			$consulta.=" and productos.proveedores_id =  '$proveedor' ";
		}
		if(!empty($busqueda)){
			$consulta.=" and (productos.codigo =  '%$busqueda%' or  productos.descripcion like  '%$busqueda%') ";
		}
		
		if(!empty($orden)){
			$consulta.=" order by $orden";
		}
		if(!empty($pagina)){
			$inicio=($pagina - 1) * 25;
			$consulta.=" limit 25 OFFSET $inicio";		
		}
		
		
        $result=$this->query($consulta);
		return $result;
	}
	public function modificarProducto($listaValores_producto){
		$result=$this->doUpdate($this->p_table,$listaValores_producto,"id=$this->id");		
		return $result;
	}
	
	/* * * * * * * * * * * * * * * * * * *
	 * =========--- Getters ---========= *
	 * * * * * * * * * * * * * * * * * * */
	public function getdatosProducto(){
		$result = $this->doSingleSelect($this->p_table,"id = {$this->id}");
		if($result){
			$this->datosRelacionProducto($result['proveedores_id'], $result['productos_categorias_id']);
			$this->datosProducto($result['codigo'], $result['precio_compra'], $result['descripcion']);
			$this->id = $result["id"];
		}else{
			return false;
		}
	}	
	/* * * * * * * * * * * * * * * * * * *
	 * =========--- Setters ---========= *
	 * * * * * * * * * * * * * * * * * * */
	public function datosRelacionProducto($proveedor, $categoria) {
		$this->defaultClass();
		$this->p_proveedores_id = $proveedor;
		$this->p_productos_categorias_id = $categoria;
	}
	public function datosProducto($codigo, $precio_compra, $descripcion, $status='1') {
		$this->p_codigo = $codigo;
		$this->p_precio_compra = $precio_compra;
		$this->p_descripcion = $descripcion;
		$this->p_status = $status;		
	}
	public function datosTempProducto($codigo, $precio_compra, $descripcion) {
		$this->temp_codigo = $codigo;
		$this->temp_precio_compra = $precio_compra;
		$this->temp_descripcion = $descripcion;
	}
	/* * * * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Private Methods ---=========== *
	 * * * * * * * * * * * * * * * * * * * * * * * * */
	 public function __get($property) {
		if (property_exists ( $this, $property )) {
			return $this->$property;
		}
	}
	 public function __set($property, $value) {
		if (property_exists ( $this, $property )) {
			$this->$property = $value;
		}
	}
	private function defaultClass() {
		foreach ( get_class_vars ( get_class ( $this ) ) as $name => $default ) {
			$this->$name = $default;
		}
	}
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