<?php
include_once 'bd.php';
class email {
	/*protected $table = "usuarios_amigos";
	protected $table_fav = "usuarios_favoritos";
	private $fecha;
	private $usuarios_id;
	private $amigos_id;*/
	private $subject='vogueseshop.com';
	private $headers;
		
	
	function __construct(){
      
    }
	function sendEmail($destinatario,$txt){
		$headers = 'From: Vogues Eshop <no-responder@vogueseshop.com> '  . "\r\n" . 'Reply-To: '  . "no-responder@vogueseshop.com" . "\r\n" . 'X-Mailer: PHP/' . phpversion ();
		$headers .= "MIME-Version: 1.0\r\n";		
		$headers .= "Content-type: text/html; charset=UTF-8.";
			
		mail($destinatario,$this->subject,$txt,$headers);
	}
	function Header($version='1'){
				
		$txt = ' <!DOCTYPE html>
      <html lang="es"><body>
		<div style=" padding 20px; text-align:left; margin: 20px;">
		<div style="width:500px;background:#fff; color:#666; padding:20px; margin-left:30px; margin-right:30px;">
		<div style="text-align:left; padding-bottom:10px; border-bottom: 1px solid #CCC;"><img src="http://vogueseshop.com/galeria/img/logos/logo-header2.png"></div>
		<br> ';		
		return $txt;
	}	
	function Footer($version='1'){
				
		$txt = ' <br></div><div style="font-size: 12px; text-align:left; margin-left:10px; color:#999;  margin-top:5px;">
			Vistete a la moda con la mejor tecnologia </div></div></div></body></html> ';
		
		return $txt;
	}	
	
	
	function sendRecuperarPass($destinatario,$link){
		$txt = "<!DOCTYPE html>
      <html lang='es'>
		<body>			
		<div style=' padding 20px; text-align:left; margin: 20px;'>
		
		
		
		<div style='width:500px;background:#fff; color:#666; padding:20px; margin-left:30px; margin-right:30px;'>
		
		<div style='text-align:left; padding-bottom:10px; border-bottom: 1px solid #CCC;'><img src='http://vogueseshop.com/galeria/img/logos/logo-header2.png' ></div>
		<br>
		
		<div style='text-align:left; margin-left:10px; 	font-size: 18px; '>
			<p><b>Hola,</b></p>
	 		<p>Hemos recibido una petici&oacute;n para restablecer la contrase&ntilde;a de tu cuenta.</p>
			<p>Si hiciste esta petici&oacute;n, haz clic en el boton, si no hiciste esta petici&oacute;n puedes ignorar este correo.</p>
		</div>
		
		<br>		
		
		<div style='text-align:left; padding-bottom:10px; border-bottom: 1px solid #ccc;' >
		<a href=".$link." style='text-decoration:none;'>
		<button style='background:#36A7E1;
		 text-align:center;  color:#FFF; padding:10px; margin:10px; border: 1px solid #1e8dc6; cursor: pointer; font-size: 18px;'>Restablecer Contrase&ntilde;a</button>
		</a>
		<br>
		</div>
		
		<div style='font-size: 12px; text-align:left; margin-left:10px; color:#999;  margin-top:5px;'>
		Vistete a la moda con la mejor tecnologia 
		</div>
		
		</div>
		
		</div>	
		
					
		</body>
		</html>
		";	 

		$this->sendEmail($destinatario,$txt);
	}
	function sendRespuesta($destinatario,$link){
		 
			$link_detalle=array_key_exists("detalle", $link)?$link["detalle"]:'';
			$link_respuesta=array_key_exists("respuesta", $link)?$link["respuesta"]:'';
			
			$txt = " <div style='text-align:left; margin-left:10px; 	font-size: 18px; '>
		               <p><b>Te han respondido!</b></p>
		               <p>Te respondieron una pregunta sobre la siguiente publicaci&oacute;n</p>
		                <a href='$link_detalle' style='text-decoration:none;'><p>$link_detalle</p><a>
		            </div>
		            <br>		
		            <div style='text-align:left; padding-bottom:10px; border-bottom: 1px solid #ccc;cursor: pointer;' >
		               <a href='$link_respuesta' style='text-decoration:none;cursor: pointer;'>
		               <button style='background:#36A7E1;
		                  text-align:center;  color:#FFF; padding:10px; margin:10px; border: 1px solid #1e8dc6; cursor: pointer; font-size: 18px;'>Ver Respuesta</button>
		               </a> 		               
		               ";
		
			$txt=$this->Header().$txt.$this->Footer();
	 
			$this->sendEmail($destinatario,$txt);
			 
		 		
	}
	
	
}