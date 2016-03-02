<?php  
class Parameter {
    /**
     * Funcion constructora que define las constantes en la aplicacion
     */
    function __construct(){
    		##lEER JSON PARA CAPTURAR CONFIGURACION
    		$parameters['SUBJECT']		='vogueseshop.com';
			$parameters['COMPANY']		='Vogues Company';
			$parameters['COMPANY_NAME']	='Vogue\'s eShop';
			$parameters['RIF']			='J-402930810';
			$parameters['DIRECTION']	='San Cristóbal, Táchira,Venezuela.';
			$parameters['SLOGAN']		='Vistete a la moda con la mejor tecnologia';
			$parameters['DOMAIN_ROOT']	='http://'.$_SERVER ['SERVER_NAME'].'/';
    		##GUARDAMOS EN VARIABLE
            
            
			##DEFINIMOS VARIABLES
			foreach ($parameters as $key => $valor) { 
                    define($key, $valor);
            }
			
			##DEFINIMOS EL DOMINIO

    }
	
}
