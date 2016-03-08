<?php
class proveedor extends bd {
	/* * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Attributes ---============ *
	 * * * * * * * * * * * * * * * * * * * * * * */
	protected $p_table = "proveedor";
	private $p_id = 0;
	private $p_documento;
	private $p_nombre;
	private $p_telefono;
	private $p_direccion;
	private $p_email;

	protected $b_table = "proveedor_bancos";
	private $b_id = 0;
	private $b_proveedor;
	private $b_banco;
	
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