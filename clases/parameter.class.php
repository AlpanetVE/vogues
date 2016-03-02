<?php  
class Parameter {
    /**
     * Funcion constructora que define las constantes en la aplicacion
     */
    function __construct(){
    		##lEER JSON PARA CAPTURAR CONFIGURACION
    		
    		##GUARDAMOS EN VARIABLE
            $res_array;
            
			##DEFINIMOS VARIABLES
            for($i=0, $cant=count($res_array); $i<$cant; $i++){
                    define($res_array[$i]['parameter_key'], $res_array[$i]['parameter_value']);
            }
			
			##DEFINIMOS EL DOMINIO

    }
	
}
