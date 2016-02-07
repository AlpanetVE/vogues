	<ul id="accordion" class="accordion vin-listados show-menu-left" data-id_rol="<?php echo $_SESSION["id_rol"]; ?>">
		<li class="hidden resumen">
			<div class="link"  ><a href="resumen.php"><i class="fa fa-list-ul" ></i><b>Resumen</b></a></div>
			
		</li>
		<li class="hidden reputacion">
			<div class="link"  ><a href="#" class=""><i class="glyphicon glyphicon-thumbs-up hvr-icon"></i>Reputacion</a></div>
			
		</li>
		<li class="hidden admin-usuarios">
			<div class="link"><a href="admin-usr.php" class=""><i class="fa fa-user "></i>Administraci&oacute;n de Usuarios</a></div>			 
		</li>
		<li class="hidden venta">
			<div class="link"><i class="fa fa-tags   " ></i>Ventas<i class="fa fa-chevron-down"></i></div>
			<ul class="submenu submenu-active" id="ventas" name="ventas">
				<li  ><a href="ventas.php" class="" id="uno1"> Publicaciones</a></li>
				<li><a href="#" >Ventas</a></li>
				<li ><a href="preguntas.php?tipo=1">Preguntas</a></li>
                <li> <a href="#">Reclamos</a></li>
			</ul>
		</li>
		<li class="hidden compra">
			<div class="link"><i class="fa fa-shopping-cart"></i>Compras<i class="fa fa-chevron-down"></i></div>
			<ul class="submenu ">
				<li class="" ><a href="favoritos.php">Favoritos</a></li>
				<li class=""><a href="preguntas.php?tipo=2">Preguntas</a></li>
				<li class="" ><a href="#">Compras</a></li>
				
			</ul>
		</li>
		<li class="hidden factura">
			<div class="link " ><i class="fa fa-credit-card"></i>Facturaci&oacute;n<i class="fa fa-chevron-down"></i></div>
			<ul class="submenu ">
				<li ><a href="#">Cuentas por pagar</a></li>
				
				
			</ul>
		</li>
		<li class="hidden red">
			<div class="link"><i class="fa fa-share-alt"></i>Gesti&oacute;n de Redes<i class="fa fa-chevron-down"></i></div>
			<ul class="submenu ">
				<li><a href="redes.php?tipo=1">Vincular Red Social</a></li>
				<li><a href="redes.php?tipo=2">Publicaciones automatizadas</a></li>
				<li><a href="redes.php?tipo=3" >Campa&ntilde;as publicitarias</a></li>
			</ul>
		</li>
		<li class="hidden configurar">
			<div class="link"><i class="fa fa-cogs"></i>Configuraci&oacute;n<i class="fa fa-chevron-down"></i></div>
			<ul class="submenu submenu-active" id="configuracion" name="configuracion">
				<li><a href="configuracion.php" id="uno4">Datos Personales</a></li>
			</ul>
		</li>
		
		</ul>
 	
