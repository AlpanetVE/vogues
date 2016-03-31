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
	private $c_id;
	private $c_nombre;
	private $c_stock;
	private $c_status;
	
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
	 
	 public function getCategorias2($campos = null,$nombre=null,$status=null){
		$campos=is_null($campos)?"*":$campos;
		$consulta="select $campos FROM productos_categorias WHERE 1 ";
		if(!is_null($nombre)){
			$consulta.="AND nombre LIKE '%".$nombre."%'";
		}
		if(!empty($status) || $status=='0'){
			$consulta.="AND status='$status'";
		}
		//echo $consulta;
		$consulta.=" order by status asc, id desc";
        $result=$this->query($consulta);
		return $result;
	}
	 
	 public function getCategoriaById($id){
	 	$consulta="select * FROM productos_categorias WHERE id=$id";
		$result=$this->query($consulta)->fetch();
		return $result;
	 }
	 
	 public function setStatus($id,$status){
	 	$actualizar=array("status"=>$status);
	 	$this->doUpdate($this->c_table, $actualizar, "id=$id");
	 }
	 
	public function getCategPub($id){
	 	$consulta="SELECT publicaciones.id, productos_categorias_id FROM 
	 	publicaciones Inner Join productos_categorias ON 
	 	publicaciones.productos_categorias_id = productos_categorias.id
	 	WHERE publicaciones.id =  '$id'";
		$result=$this->query($consulta)->fetch();
		return $result["productos_categorias_id"];
	 	
	 }
	 
	 public function getProductosDisponibles($campos=null,$categoria){
	 	$campos=is_null($campos)?"*":$campos;
		$consulta="select $campos FROM productos where productos.productos_categorias_id=$categoria and status=1";
        $result=$this->query($consulta)->fetch();
		return $result['total']; 		
	 }
	 
	 public function crearCategoria($nombre){
	 	$result=$this->doInsert($this->c_table, array("nombre"=>$nombre));
		return $result;
	 }
	 
	 public function actualizarCategoria($nombre,$id){
	 	$result=$this->doUpdate($this->c_table, array("nombre"=>$nombre), "id=$id");
		return $result;
	 }
	 
	 public function eliminarCategoria($id){
	 	$consulta="DELETE FROM $this->c_table where id=$id";
		$result=$this->exec($consulta);
		return $result;
	 }
	 
	 public function hayProductosEnCategoria($idcategoria){
	 	$result=$this->valueExist($this->p_table, $idcategoria, "productos_categorias_id");
		return $result;
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