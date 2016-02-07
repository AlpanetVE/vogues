<?php
/*****************CLASE ENCARGADA DE TRATAR LAS BUSQUEDAS*********************/
/**
 * @property string palabra;
 * @property string orden;
 * @property int clasificados_id;
 * @property int pagina;
 * @property int codicion;
 */
include_once 'bd.php';
include_once 'clasificados.php';
class busqueda{
	private $palabra;
	private $orden;
	private $clasificados_id;
	private $pagina;
	private $condicion;
	private $estados_id;
	public $listado;
/*************Constructor*******/	
	public function busqueda($parametros){
		$this->palabra=$parametros["palabra"];
		$this->orden=array_key_exists("orden", $parametros)?$parametros["orden"]:"id desc";
		$this->clasificados_id=$parametros["clasificados_id"];
		$this->pagina=array_key_exists("pagina", $parametros)?$parametros["pagina"]:NULL;
		$this->condiciones_publicaciones_id=array_key_exists("condicion_publicaciones_id", $parametros)?$parametros["condiciones_publicaciones_id"]:NULL;
		$this->estados_id=array_key_exists("estados_id", $parametros)?$parametros["estados_id"]:NULL;
		$this->listado=$this->getPublicaciones();
	}
/************M&eacute;todos***********/
	public function getPublicaciones(){
		$bd=new bd();
		$condicion="where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null) ";
		$operador="and";
		if($this->palabra!=""){
			$condicion.="$operador titulo like '%{$this->palabra}%'";
			$operador=" and ";
		}
		if($this->clasificados_id!=""){
			$criterio="I" . $this->clasificados_id . "F";
			$condicion .=$operador . " clasificados_id in (select id from clasificados where ruta like '%$criterio%')";
			$operador=" and ";			
		}
		if($this->palabra!=""){
			$criterio=explode(" ",$this->palabra);
			$criterio2="(";
			$criterio3="(";
			foreach ($criterio as $c=>$valor) {
				$criterio2.="nombre like '%$valor%' or apellido like '%$valor%' or ";
				$criterio3.="razon_social like '%$valor%' or ";
			}
			$criterio2=substr($criterio2,0,strlen($criterio2)-4) . ")";
			$criterio3=substr($criterio3,0,strlen($criterio3)-4) . ")";			
			$consultaUsua=" union (select usuarios_id as id,identificacion,'U' as tipo,CONCAT(nombre,' ',apellido) as nombre from usuarios_naturales where $criterio2)
				 union (select usuarios_id as id,razon_social,'U' as tipo,razon_social as nombre from usuarios_juridicos where $criterio3)";
		}else{
			$consultaUsua="";
		}		
		if($condicion=="where ")
		$condicion="";
		$limite = ($this->pagina - 1) * 5;
		$consulta="(select id,usuarios_id,'P' as tipo,titulo as nombre from publicaciones $condicion order by {$this->orden}) $consultaUsua";
		$publicaciones=$bd->query($consulta);
		return $publicaciones;
	}
	public function getUsuarios(){
		$bd=new bd();
		if($this->palabra!=""){
			$criterio=explode(" ",$_POST["palabra"]);
			$criterio2="(";
			$criterio3="(";
			foreach ($criterio as $c=>$valor) {
				$criterio2.="nombre like '%$valor%' or apellido like '%$valor%' or ";
				$criterio3.="razon_social like '%$valor%' or ";
			}
			$criterio2=substr($criterio2,0,strlen($criterio2)-4) . ")";
			$criterio3=substr($criterio3,0,strlen($criterio3)-4) . ")";			
			$consulta="(select usuarios_id as id,'U' as tipo from usuarios_naturales where $criterio2)
				 union (select usuarios_id as id,'U' as tipo from usuarios_juridicos where $criterio3";
			$usuarios=$bd->query($consulta);
			return $usuarios;
		}else{
			return false;
		}
	}	
	public function getEstados(){
  		$bd=new bd();
		 $est=$bd->doFullSelect("estados");
		 $lista=array();
		 $i=1;
		 foreach($est as $e=>$valor){
		 		$lista[$i]["id"]=$valor["id"];
			  	$lista[$i]["nombre"]=$valor["nombre"];				
				$lista[$i]["totaP"]=0;
				$i++;
		 }		  
		 $anterior="";
		 foreach($this->listado as $l=>$valor){
		 		if($valor["tipo"]=="P"){
		  			if($valor["usuarios_id"]!=$anterior){
		  				$anterior=$valor["usuarios_id"];
						$r=$bd->doSingleSelect("usuarios","id={$valor["usuarios_id"]}");
						$actual=$r["estados_id"];
					}
		  		}else{
		  			if($valor["id"]!=$anterior){
		  				$anterior=$valor["id"];
						$r=$bd->doSingleSelect("usuarios","id={$valor["id"]}");
						$actual=$r["estados_id"];
					}
		  		}
				$lista[$actual]["totaP"]++;
		 }  
		 return $lista;
	}
	public function getRuta(){
		$devolver="";
		if($this->clasificados_id!=""){
			$clasificado=new clasificados($this->clasificados_id);
			$devolver .=$clasificado->getAdressWithLinks($this->palabra);
		}
		if($this->palabra!="")
		$devolver .="'$this->palabra'";
		return $devolver;
	}
	public function getPaginas(){
		
	}
	public function getCategorias(){
  		$bd=new bd();
		if($this->clasificados_id==""){
		 	$cla=$bd->doFullSelect("clasificados","clasificados_id<=4 and clasificados_id is not null order by nombre");
		}else{
			$cla=$bd->doFullSelect("clasificados","clasificados_id=$this->clasificados_id order by nombre");
		}
		 $lista=array();	 
		 foreach($cla as $c=>$valor){
		 		$i=$valor["id"];
		 		$lista[$i]["id"]=$valor["id"];
			  	$lista[$i]["nombre"]=$valor["nombre"];
				$criterio="I" . $valor["id"] . "F";
				$condicion="where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null)";
				if($this->palabra!="")
				$condicion .=" and titulo like '%{$this->palabra}%'";
				$consulta="select count(id) as totaC from publicaciones $condicion and clasificados_id in (select id from clasificados where 
							ruta like '%$criterio%')";
				$r=$bd->query($consulta);
				$row=$r->fetch();
				$lista[$i]["totaC"]=$row["totaC"];
		 }		  
		 return $lista;
	}
	public function getCondiciones(){
		$bd=new bd();
		$condicion="where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null)";
		$operador="and";
		if($this->palabra!=""){
			$condicion.=" $operador titulo like '%{$this->palabra}%'";
			$operador=" and ";			
		}
		if($this->clasificados_id!=""){
			$criterio="I" . $this->clasificados_id . "F";
			$condicion .=$operador . " clasificados_id in (select id from clasificados where ruta like '%$criterio%')"; //ojo
			$operador=" and ";
		}
		$consulta="select (select count(id) from publicaciones $condicion and condiciones_publicaciones_id=1) as tota1,
    				(select count(id) from publicaciones $condicion and condiciones_publicaciones_id=2) as tota2,
    				(select count(id) from publicaciones $condicion and condiciones_publicaciones_id=3) as tota3";
		$r=$bd->query($consulta);
		if($r){
			return $r->fetch();
		}else{
			return false;
		}
	}
	public function getParametros(){
		$devolver="";
		$devolver.="palabra={$this->palabra}<br>";
		$devolver.="pagina={$this->pagina}<br>";
		$devolver.="esatdos_id={$this->estados_id}<br>";
		return $devolver;
	}
}
?> 