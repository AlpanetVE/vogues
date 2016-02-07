<?php
include_once 'bd.php';
class email {
	/*protected $table = "usuarios_amigos";
	protected $table_fav = "usuarios_favoritos";
	private $fecha;
	private $usuarios_id;
	private $amigos_id;
	private $result;
	*/
 
	
	function __construct(){
      
    } 
	
	function sendEmail($destinatario,$link){
		//$to = "cdodesarrollo4@gmail.com";
$subject = "Recuperar Password";
		$txt = '<html>
		     <head>
		        <title>Restablece tu contrase&ntilde;a</title>
		     </head>
		     <body>
		       <p>Hemos recibido una petición para restablecer la contrase&ntilde;a de tu cuenta.</p>
		       <p>Si hiciste esta petición, haz clic en el siguiente enlace, si no hiciste esta petición puedes ignorar este correo.</p>
		       <p>
		         <strong>Enlace para restablecer tu contrase&ntilde;a</strong><br>
		         <a href="'.$link.'"> Restablecer contrase&ntilde;a </a>
		       </p>
		     </body>
		    </html>';
		$headers = "Content-type: text/html; charset=UTF-8."."From: vogues@example.com" . "\r\n" .
		"CC: somebodyelse@example.com";
		
		mail($destinatario,$subject,$txt,$headers);
	}
	
}
