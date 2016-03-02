<?php 
function busca(){ 
		
		$categoria=isset($_POST["categoria"])?$_POST["categoria"]:"";
		$condicion=isset($_POST["condicion"])?$_POST["condicion"]:"";
		$estado=isset($_POST["estado"])?$_POST["estado"]:"";
		$orden=isset($_POST["orden"])?$_POST["orden"]:"";
		$palabra=isset($_POST["palabra"])?$_POST["palabra"]:"";
		$ver_tiendas=isset($_POST["ver_tiendas"])?$_POST["ver_tiendas"]:"0";
		$pagina=isset($_POST["pagina"])?$_POST["pagina"]:"1";
		
		
		$categoria=$valores=array("palabra"=>$palabra,
				"ver_tiendas"=>$ver_tiendas,
				"pagina"=>$pagina,
				"orden"=>$orden,
				"estados_id"=>$estado,
				"clasificados_id"=>$categoria);
		
		$busqueda=new busqueda($valores);
		
		$result=$busqueda->getPublicaciones();
		  
		foreach($result as $r=>$valor){
			if($valor["tipo"]=="P"):
				$publi=new publicaciones($valor["id"]);
				/*$usua=new usuario($publi->usuarios_id);*/
				$miTitulo=$publi->titulo;
				$miTitulo=str_ireplace($palabra, "<span style='background:#ccc'><b>" . strtoupper($palabra) . "</b></span>", $miTitulo);				
				?>

					<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'>
				    	<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
				    		<div style='position:absolute; left:40px; top:10px; ' class='f-condicion'> </div>			 
				    		<img src='<?php echo $publi->getFotoPrincipal();?>' class='img img-responsive center-block img-apdp imagen' style='width:100%;height:100%;'
				    		data-id='<?php echo $publi->id;?>'>				
						</div>
					</div>
					<div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'><p class='t16 marL10 marT5'>
				    	<span class=' t15'><a class='negro' href='detalle.php?id=<?php echo $publi->id;?>' class='grisO'><b> <?php echo $miTitulo;?></b></a></span>
						<?php /* <br><span class=' vin-blue t14'><a href='perfil.php?id=<?php echo $usua->id;?>' class=''><b> <?php echo $usua->a_seudonimo;?></b></a></span> */ ?>
					<?php /*	<br><span class='t14 grisO '><?php echo $usua->getNombre();?></span><br> */ ?>
						<span class='t12 grisO' style="display: block;"><i class='glyphicon glyphicon-time t14  opacity'></i><?php echo $publi->getTiempoPublicacion();?></span>
						<span class='t11 grisO'> <span> <i class='fa fa-eye negro opacity'></i></span><span class='marL5'><?php echo $publi->getVisitas();?> Visitas</span><i class='fa fa-heart negro marL5 opacity'>
						</i><span class=' point h-under marL5'><?php echo $publi->getFavoritos();?> Me gusta</span><i class='fa fa-share-alt negro marL15 opacity hidden'></i> <span class=' point h-under marL5 hidden'> <?php echo $publi->getCompartidos(3);?> Veces compartido</span> </span>
						<br>
						<br>
						<br>
						</p>
				    </div>
				    <div class=' col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right'>
				    	<div class='marR20'><span class='red t20'><b> <?php echo $publi->getMonto();?></b></span >
							<?php /* <br><span class=' t12'> <?php echo ($usua->getEstado());?> </span><br> */?>
							<span style="display: block;" class='vin-blue t16'><a href='detalle.php?id=<?php echo $publi->id;?>' style='text-decoration:underline;'>Ver Mas</a></span >
						</div>
					</div>
					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-10'><hr class='marR10'><br></div><?php			
			endif;
		}
	}