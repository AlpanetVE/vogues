<?php 
if (!isset ( $_GET ["token"] )) {
	header ( "Location: index.php" );
}
		include "fcn/incluir-css-js.php";
		include 'clases/usuarios.php';
		
		$token = $_GET['token'];
		$idusuario = $_GET['idusuario'];
		
		$user=new usuario();
		$result=$user->comprobarToken($token);
		
		if($result){
			 if( $result['id_usuario'] == $idusuario ){ ?>
			 	
			 
		
		
<!DOCTYPE html>
<html lang="es">		
	<body class="body-index">	
<div class="container center-container login-admin" style="width:500px; padding:30px; margin-top: 10%">
<form id="restablecer-password" data-user="<?php echo $idusuario ?>" name="restablecer-password" action="fcn/f_usuarios.php" method="POST">
					<ul >
				 			<div class="center" style=""> 
				 				<img class="img-responsive" src="galeria/img/logos/logo-login.png" />
				 				</div>
						
							<li style="padding: 10px;">
							<div class="form-group">
							<input type="password" placeholder=" Ingrese Nueva Contrase&#241;a" name="rec_clave" class="form-input"
								id="rec_clave">
								</div></li>
							<li style="padding: 10px;"><div class="form-group"><input type="password"
								placeholder="Confirme Contrase&#241;a" name="rec_clave2" class="form-input" id="rec_clave2"></div>
								</li> 
							<li style="padding: 10px; margin-top: -20px"><button id="rec-clave-submit" type="submit" 
									class="btn2 btn-primary2 btn-group-justified">Guardar</button>
									<br>
 									</li>
							<li class="divider"></li>
					 
					 
					</ul>
			</form>
     
</div>
 </body> 
 <script type="text/javascript" src="js/restablecer.js"></script>
</html>
<?php 
}else {
	header ( "Location: index.php" );}
		}
 else {
 	header ( "Location: index.php" );
 } 