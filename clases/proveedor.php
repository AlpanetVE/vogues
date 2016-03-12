<?php
class proveedor extends bd {
	/* * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Attributes ---============ *
	 * * * * * * * * * * * * * * * * * * * * * * */
	protected $p_table = "proveedores";
	private $id = 0;
	private $p_tipo;
	private $p_documento;
	private $p_nombre;
	private $p_telefono;
	private $p_email;
	private $p_direccion;
	
	protected $t_table = "proveedores_titulares";
	private $t_tipo;
	private $t_documento;
	private $t_nombre;
	private $t_email;	
	
	protected $b_table = "proveedores_bancos";
	private $b_bancos_id;
	private $b_tipos_cuentas_id;
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
	public function crearProveedor($bancos) {
		$result = $this->doInsert ( $this->p_table, $this->serializarDatos ( "p_" ) );	
		if ($result == true) {
			$this->id = $this->lastInsertId ();
			$result = $this->doInsert ( $this->t_table, $this->serializarDatos ( "t_", $this->p_table ) );
			
			$count=count($bancos['nro_cuentas']);			
			for($i=0;$i<$count;$i++){
				$this->datosBancos($bancos['tipos_bancos_id'][$i], $bancos['bancos_id'][$i], $bancos['nro_cuentas'][$i]);
				$this->doInsert ( $this->b_table, $this->serializarDatos ( "b_", $this->p_table ) );
			}			
			 
		}
		
	}
	public function getProveedores($campos = null){
		$campos=is_null($campos)?"*":$campos;
		$preguntas=array();
		$consulta="select $campos FROM proveedores WHERE 1";
        $result=$this->query($consulta);
		return $result;
	}
	/* * * * * * * * * * * * * * * * * * *
	 * =========--- Setters ---========= *
	 * * * * * * * * * * * * * * * * * * */
	public function datosProveedor($tipo, $documento, $nombre, $telefono, $email, $direccion) {
		$this->defaultClass();
		$this->p_tipo = $tipo;
		$this->p_documento = $documento;
		$this->p_nombre = $nombre;
		$this->p_telefono = $telefono;
		$this->p_email = $email;
		$this->p_direccion = $direccion;
	}
	public function datosTitular($tipo_titular, $documento_titular, $nombre_titular, $email_titular) {
		$this->t_tipo = $tipo_titular;
		$this->t_documento = $documento_titular;
		$this->t_nombre = $nombre_titular;
		$this->t_email = $email_titular;
	}
	public function datosBancos($tipos_bancos, $bancos, $nros_cuentas) {
		$this->b_tipos_cuentas_id = $tipos_bancos;
		$this->b_bancos_id = $bancos;
		$this->b_nro_cuenta = $nros_cuentas;
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
		 //var_dump ( $params );
		return $params;
	}
	
}