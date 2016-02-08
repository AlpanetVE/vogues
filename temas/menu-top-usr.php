<?php if(!isset($_SESSION)){
    session_start();	
}else{
	$usr = new usuario($_SESSION["id"]);	
	$cant_compras = $usr->getCantRespuestas();
	$cant_ventas = $usr -> getCantNotificacionPregunta();
	$visto=0;
}
?>
<nav class="navbar menu-cabecera navbar-inverse navbar-static-top" role="navigation ">
	<div class="container">
		<div class="navbar-header ">
			<button type="button" class=" navbar-toggle collapsed"
				data-toggle="collapse" data-target="#menuP">
				<span class="sr-only">Mostrar / Ocultar</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a href="index.php" class="navbar-brand"> <img style=""
				class=" marT5 marB5 marL5" src="galeria/img/logos/logo-header.png"
				width="200px;" height="50px">
			</a>
		</div>
		<div class="collapse navbar-collapse " id="menuP">
			<div	class="navbar-form navbar-left  marT15 mar-buscador "> 
<!--	            <form> --> 
				<div class="input-group">
					<input id="txtBuscar" name="txtBuscar"
						style="margin-left: -10px; border-left: trasparent;width:300px;" name="c"
						type="text" class="form-control-header2 buscador" placeholder="Buscar" >
						<span class="input-group-btn"> 
						<button class="btn-header2 btn-default-header2 buscadorBoton"
							style="width: 50px;" id="btnBuscar" name="btnBuscar">
							<span class="glyphicon glyphicon-search"></span>
					</button>
				</span> 
				</div>
		</div>
			<ul class="nav navbar-nav navbar-right t16">
				<li class="marT10 hidden-xs hidden-sm">
					<!-- <div class="borderS  point eti-blanco "
						style=" height: 40px; width: 40px;">
							<a href="perfil.php?id=<?php echo $_SESSION["id"];?>" > <img id="fotoperfilm" src="<?php echo $_SESSION["fotoperfil"];?>" id=""
							class="img img-responsive center-block"
							style="max-height: 96%; cursor: pointer;background:white;" data-container="body" data-toggle="popover" data-placement="bottom" 
							data-content="Actualiza tu foto de perfil">
						</a> 	
					</div>-->
				</li>
				<li>&nbsp;&nbsp;
				<li>
				<li class="dropdown"><a href="#" class="dropdown-toggle marT10"
					data-toggle="dropdown" role="button" aria-expanded="false"
					style=""> <?php echo strtoupper($_SESSION["seudonimo"]);?> </a>
					<ul class="dropdown-menu blanco" role="menu">
						<li><a href="resumen.php">Mi Cuenta</a></li>
						<li><a href="salir.php">Salir</a></li>
					</ul></li>
				<li>
					
				</li>
				<!-- Se agrega la opcion en el caso de que sea admin -->
				<?php if ($_SESSION["id_rol"] <=2 ) { ?> 
				<li><a href="publicar.php" data-toggle="" data-target="" class="marT10">Publicar</a></li>
  			<?php  } ?>
				<!--  Fin de la condicion-->
				<?php if ($_SESSION["id_rol"] == 1 ) { ?>
					<li><a href="admin-usr.php" data-toggle="" data-target="" class="marT10">
						<i class="fa fa-user"></i> </a></li>
				
					<?php  } ?>
				<li>
				
				</li>
<?php 
$alertas = $cant_compras[0]["cant"] + $cant_ventas[0]["cant"];
if($alertas==0 or $visto==1){ 
?>
				<li id="notificacion"  class="dropdown"><a href="#" data-toggle="dropdown" role="button" class="dropdown-toggle marT10" aria-expanded="false"
					style=""><i class="fa fa-bell"></i>  </a>
					<ul class="dropdown-menu blanco" role="menu">
						<li><a href="preguntas.php?tipo=1">Ver Preguntas</a></li>
						<li><a href="preguntas.php?tipo=2;">Ver Respuestas</a></li>
					</ul>
				</li>
						
<?php }else{						
?>
				<li id="notificacion" data-id="<?php echo $_SESSION["id"];?>" class="dropdown"><a href="#" data-toggle="dropdown" role="button" class="dropdown-toggle marT10" onclick="<?php echo $visto=1; ?>" aria-expanded="false"
					style=""><span id="alerta" class="badge blanco" style="background: red; position: absolute; top: -2px; left: -1px;"><?php echo $alertas; ?></span><i class="fa fa-bell"></i>  </a>
					<ul class="dropdown-menu blanco" role="menu">
						<li><a href="preguntas.php?tipo=1">Te han preguntado <?php if($cant_ventas[0]["cant"]!=0 ){?>(<?php echo $cant_ventas[0]["cant"];?>)<?php }?></a></li>
						<li><a href="preguntas.php?tipo=2;">Te han Respondido <?php if($cant_compras[0]["cant"]!=0 ){?> (<?php echo $cant_compras[0]["cant"];?>)<?php }?></a></li>
					</ul>
				</li>							
<?php }?>
				
					
					<?php if ($_SESSION["id_rol"] == 3 ) { ?>
						 	
					<li><a href="favoritos.php" data-toggle="" data-target="" class="marT10"><i
						class="fa fa-heart"></i> </a></li>	
					 <li><a href="#" data-toggle="modal" data-target="#contacto" class="marT10"><i
						class="fa fa-envelope"></i> </a></li>
						<?php } ?>
						
						
				<li class="hidden"><a href="#" data-toggle="modal" data-target="#ayuda" class="marT10"><i
						class="fa fa-question-circle"></i> </a></li>
			</ul>
		</div>
	</div>
</nav>
