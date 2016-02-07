<?php
include_once "../../../clases/bd.php";
include_once "../../../clases/usuarios.php";
include_once "../../../clases/publicaciones.php";

switch($_POST["metodo"]){
	case "guardarRespuesta":
		guardarRespuesta();
		break;
	case "guardarPregunta":
		guardarPregunta();
		break;
	case "enviarRespuesta":
		sendRespuesta();
		break;
	case "enviarPregunta":
		sendPregunta();
		break;
	case "eliminarPregunta":
		eliminarPregunta();
		break;
}

function guardarRespuesta()
{
	$publicacion = new publicaciones($_POST["pub_id"]);
	$inse = $publicacion->setPreguntas($_POST["respuesta"],$_POST["id"]);	
	$not = $publicacion->setNotificacion($_POST["pub_id"],$_POST["tipo"],$_POST["usr"],$inse);
}	

function guardarPregunta()
{
	$publicacion = new publicaciones($_POST["pub_id"]);
	$inse = $publicacion->setPreguntas($_POST["respuesta"]);	

	$not = $publicacion->setNotificacion($_POST["pub_id"],$_POST["tipo"],$_POST["usr"],$inse);

}	

function sendPregunta(){
		$cli = new usuario($_POST["usr_id"]);
		$poster = new usuario($_POST["id_poster"]);
		$publicacion = new publicaciones($_POST["pub_id"]);
		ini_set("sendmail_from",$poster->a_email);
		$email_to = "" . $cli-> a_email . "";

		$email_subject = "Apreciodepana.com "." -  ".$poster-> n_nombre." ".$poster->n_apellido." tiene una pregunta!";
		$email_message = "Sobre la publicacion:  ".$publicacion -> titulo." \n\n ".$_POST['pregunta'];	
	
		$headers = 'From: Apreciodepana.com ' . "\r\n" . 'Reply-To: '  . "no-reply@apreciodepana.com" . "\r\n" . 'X-Mailer: PHP/' . phpversion ();
		mail ( $email_to, $email_subject, $email_message, $headers );
		echo json_encode(array("correo a enviar"=>$cli-> a_email, "correo from"=>$poster->a_email,"header"=>$headers,"subject"=>$email_subject,"message"=>$email_message));			
		//echo json_encode(array("estado"=>"OK"));
}


function sendRespuesta(){
		$cli = new usuario($_POST["usr_id"]);
		$poster = new usuario($_POST["id_poster"]);
		$publicacion = new publicaciones($_POST["pub_id"]);
		ini_set("sendmail_from",$poster->a_email);
		$email_to = "" . $cli-> a_email . "";

		$email_subject = "Apreciodepana.com "." -  ".$poster-> n_nombre." ".$poster->n_apellido." ha contestado tu pregunta!";
		$email_message = "Sobre la publicacion:  ".$publicacion -> titulo." \n\n ".$_POST['respuesta'];	
	
		$headers = 'From: Apreciodepana.com ' . "\r\n" . 'Reply-To: ' . "no-reply@apreciodepana.com" . "\r\n" . 'X-Mailer: PHP/' . phpversion ();
		mail ( $email_to, $email_subject, $email_message, $headers );
		//echo json_encode(array("estado"=>"OK"));
		echo json_encode(array("correo a enviar"=>$cli-> a_email, "correo from"=>$poster->a_email,"header"=>$headers,"subject"=>$email_subject,"message"=>$email_message));		
}


function eliminarPregunta(){
		$bd=new bd();
        $result=$bd->query("delete FROM preguntas_publicaciones WHERE id={$_POST["id"]}");		
}

?>