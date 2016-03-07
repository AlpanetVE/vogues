<?php
require '../config/core.php';
class busqueda extends bd{
	private $palabra;
	private $orden;
	private $clasificados_id;
	private $pagina;
	private $condicion;
	private $estados_id;
	public $listado;
/*************Constructor*******/	
	public function busqueda($parametros){
		parent::__construct();
		$this->palabra=$parametros["palabra"];
		$this->orden=array_key_exists("orden", $parametros)?$parametros["orden"]:"id desc";
		$this->clasificados_id=$parametros["clasificados_id"];
		$this->pagina=array_key_exists("pagina", $parametros)?$parametros["pagina"]:NULL;
		$this->condiciones_publicaciones_id=array_key_exists("condicion_publicaciones_id", $parametros)?$parametros["condiciones_publicaciones_id"]:NULL;
		$this->estados_id=array_key_exists("estados_id", $parametros)?$parametros["estados_id"]:NULL;
		$this->listado=$this->getPublicaciones();
		
		 $consulta = "select * from notificaciones limit 1";
		$publicaciones=$this->query($consulta);
		
	}
/************M&eacute;todos***********/
	public function getPublicaciones(){
		 $consulta = "select * from notificaciones limit 1";
		$publicaciones=$this->query($consulta);
		 
		
		foreach ($publicaciones as $key => $value) {
	var_dump($value);
};
	}
	
}
class test extends bd{
	public function testt(){ 
			
			$consulta = "select * from notificaciones limit 1";
			
			$result =$this->query($consulta);
			return $result;	
	}
}

$test= new test();
$array_test=$test->testt();

foreach ($array_test as $key => $value) {
	var_dump($value);
};


$act_cla=isset($_GET["id_cla"])?$_GET["id_cla"]:"";
$palabra=isset($_GET["palabra"])?$_GET["palabra"]:"";
$valores=array("palabra"=>$palabra,
				"clasificados_id"=>$act_cla);
$busqueda=new busqueda($valores);
 
 
?>