<?php
	##lEER JSON PARA CAPTURAR CONFIGURACION
	$domain_root='http://'.$_SERVER ['SERVER_NAME'].'/';

	if($_SERVER ['SERVER_NAME']=='localhost'){
		$datos_params = file_get_contents($domain_root.'vogues/config/parameter.json');
	}
	else {
		$datos_params = file_get_contents($domain_root.'config/parameter.json');
	}
	$json_params = json_decode($datos_params, true);

	##DEFINIMOS VARIABLES
	foreach($json_params as $campo=>$valor){
		define($campo, $valor);
	}
	
	##DEFINIMOS DIRECTORIOS Y CONEXION
	$server_root = '';
	$cwd = getcwd();
	$arrDirectoryHierarchy = explode(DIRECTORY_SEPARATOR, $cwd);
	for($i=0, $limit=count($arrDirectoryHierarchy); $i<$limit; $i++){
		if($arrDirectoryHierarchy[$i]=='vogues' || $arrDirectoryHierarchy[$i]=='public_html'){
			$server_root.= $arrDirectoryHierarchy[$i].DIRECTORY_SEPARATOR;
			break;
		} else{
			$server_root.= $arrDirectoryHierarchy[$i].DIRECTORY_SEPARATOR;
		}
	}
	
	define("SERVER_ROOT", $server_root);
	define("DOMAIN_ROOT", $domain_root);
	define("DB_NAME", 'vogues');
	define("DB_USER", 'root');
	define("DB_PASS", '');
	
?>