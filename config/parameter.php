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
	
	##DEFINIMOS EL DOMINIO
	define("DOMAIN_ROOT", $domain_root);   
     
?>