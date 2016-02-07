<?php
	$usr = new usuario($_SESSION["id"]);										
	$usr_publicaciones = $usr -> getAllPublicaciones(1);	
	$cant_preg_usr = $usr -> getCantPreguntasActivas();
?>

<div class="contenedor">
	<div class="row marL20 marR20 ">
			<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10   "><!-- inicio titulo   -->	
				<h4 class="  t20 negro pad10" ><span class="marL10">Preguntas sobre tus Ventas</span> (<span id="cantP" class="t20"><?php echo $cant_preg_usr[0]["cant"] ?></span>)</h4>
				<center>
					<hr class='anchoC'>
				</center>
			</div><!-- Fin titulo -->
			
		</div>
	
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin: 30px; margin-top: 10px;">
	 
	  	
<?php
$cont = 1;	
$p_cant=1;
if($usr_publicaciones != null ){ 
foreach ($usr_publicaciones as $up => $valor) {
		$id_pub = $valor["id"];
		$pub = new publicaciones($id_pub);
		$p_preguntas = $pub ->getPreguntasActivas($id_pub); 
		if($p_preguntas != null ){ 
?>
	<div class="panel panel-default" style="display:block"  id="panel<?php echo $id_pub; ?>">
	<!-- data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $id_pub;?>" aria-expanded="true" aria-controls="collapse<?php echo $id_pub; ?> " -->			
	<div class="panel-heading" role="tab" id="heading<?php echo $id_pub;?>" role="button" >
      <h4 class="panel-title"> 
      		  	 <a href="detalle.php?id=<?php echo $id_pub ?>" >							 
					<img href="detalle.php?id=<?php echo $id_pub; ?>" src= "<?php echo $pub->getFotoPrincipal($id_pub);  ?>"
					  style="width:60px;height:60px; border: 1px solid #CCC; background: #FFF; padding: 5px;" 
				  </a>
				<a href="detalle.php?id=<?php echo $id_pub ?>" >							
					<span class="marL10" href="detalle.php?id=<?php echo $id_pub ?>" data-id="<?php echo $id_pub; ?>"> <?php echo $valor["titulo"]; ?>  </span> 
        		</a>
        <span class="red t14 marL10"><b> <?php $valor["monto"] ?> </b></span> <span class="opacity t12"><?php echo "x ".$valor["stock"]. " Und"; ?></span>
      </h4>
    </div>
		<div id="collapse<?php echo $id_pub;?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?php echo $id_pub;?>">
			 <div class="panel-body">
			

<?php $cant_preguntas;
$cant_pregunta[$p_cant] = sizeof($p_preguntas);
$pos_pre = 0;
foreach ($p_preguntas as $pp => $valor2) {
		$id_pregunta = $valor2["id"]; 
		$id_usr = $valor2["usr_id"];
		if($pos_pre < $cant_pregunta[$p_cant]-1){
			$nextid = $p_preguntas[$pos_pre+1]["id"];	
		}else{
			$nextid = $p_preguntas[0]["id"];
		}
		
		?>
					<div id="<?php echo $id_pregunta; ?>">
		     	 		<br>
		      					<p class="t14 marL20 marR20 bor <?php if($cont!=1){ $cont++;?>borBD<?php }?>" id="eti-p<?php echo $id_pregunta;?>"  >
										<i class="fa fa-comment blueO-apdp " style="border-bottom: #ccc 1px dashed;" ></i> 
										<span class="marL5 point toggleResponder"  data-id="<?php echo $id_pregunta; ?>">
											<?php echo $valor2["pregunta"]; ?></span>
										<br>
										<br>
								</p>
										<div class="activo" id="responder<?php echo $id_pregunta;?>" name="responder" <?php if($cont==1){ $cont++;?> style="display:block" <?php }else ?>style=" display:none">
										<textarea id="txtRespuesta<?php echo $id_pregunta;?>" name="txtRespuesta<?php echo $id_pregunta;?>" class="form-textarea respuesta" data-id="<?php echo $id_pregunta;?>"></textarea>
										<br>
										<div class="text-right"><a href="#"><i id="eliminar<?php echo $id_pregunta;?>" class="fa fa-trash-o marL5 red eliminar" data-id="<?php echo $id_pregunta; ?>"></i></a><button id="limpiar" class="btn2 btn-default marL10 limpiar" data-id="<?php echo $id_pregunta;?>">Limpiar</button>
											<button id='btnResponder' name='btnResponder'  class="btn2 btn-primary marL10 btnResponder" data-cant="<?php echo $cant_pregunta[$p_cant]; ?>" data-id="<?php echo $id_pregunta; ?>" 
											data-primero="<?php echo $p_preguntas[0]["id"]; ?>" data-pub_id="<?php echo $id_pub; ?>" data-activar="<?php echo $nextid; ?>" data-id_poster="<?php echo $_SESSION["id"]; ?>" data-usr_id="<?php echo $id_usr; ?>" >Responder</button>
										</div>
										</div>		      
	   					<br>
	   				</div>
<?php				
$pos_pre++;
}$p_cant++;
?>
 			</div>
		</div>
	</div>
	<br>
<?php		
	}
}
}else{
		include_once("fcn/f_no_find.php");
		}
    
 ?>  
       
  
  	</div>


</div>

