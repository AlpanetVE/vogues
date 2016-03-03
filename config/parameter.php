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
    		
    		define("COMPANY", $json_params['company']); 
			define("COMPANY_NAME", $json_params['company_name']); 
			define("COMPANY_NAME_MAY", $json_params['company_name_may']); 
			define("RIF", $json_params['rif']); 
			define("WEBPAGE", $json_params['webpage']);  
			define("DIRECCION", $json_params['direccion']);
			define("SLOGAN", $json_params['slogan']);  
			define("EMAIL", $json_params['email']);
			##DEFINIMOS EL DOMINIO
			define("DOMAIN_ROOT", $domain_root);  
    
	
?>
