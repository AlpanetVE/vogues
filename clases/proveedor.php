<?php
class proveedor extends bd {
	/* * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Attributes ---============ *
	 * * * * * * * * * * * * * * * * * * * * * * */
	protected $p_table = "proveedores";
	private $id = 0;
	private $p_documento;
	private $p_nombre;
	private $p_telefono;
	private $p_direccion;
	private $p_email;

	protected $b_table = "proveedores_bancos";
	private $b_proveedor;
	private $b_banco;
	private $b_nro_cuenta;
	
	/* * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Contructor ---============ *
	 * * * * * * * * * * * * * * * * * * * * * * */
	public function proveedor($id = NULL) {
		parent::__construct();
		if ($id != NULL) {
			
		}
	}
	/* * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Methods ---=========== *
	 * * * * * * * * * * * * * * * * * * * * */
	public function buscarUsuario($id) {
		// hace consulta y setea valores
		$this->id = $id;
		if(!$this->getdatosUsuarios()){	
			if(!$this->getdatosNatural()){
				$this->getdatosJuridico();
			}
			$this->getdatosAcceso();
			$this->getdatosStatus();
		}else{
			return false;
		}
	}
	public function crearProveedor($id) {
		$this->defaultClass();
		$result = $this->doInsert ( $this->p_table, $this->serializarDatos ( "p_" ) );
		$result = $this->doInsert ( $this->b_table, $this->serializarDatos ( "b_" ) );
	}
	public function getProveedores($campos = null){
		$campos=is_null($campos)?"*":$campos;
		$preguntas=array();
		$consulta="select $campos FROM proveedores WHERE 1";
        $result=$this->query($consulta);
		return $result;
	}
	
	/* * * * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Private Methods ---=========== *
	 * * * * * * * * * * * * * * * * * * * * * * * * */
	private function defaultClass() {
		foreach ( get_class_vars ( get_class ( $this ) ) as $name => $default ) {
			$this->$name = $default;
		}
	}
	private function serializarDatos($prefix = "p_", $foreign_table = false) {
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