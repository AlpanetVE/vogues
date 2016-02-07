<script>
function buscaDerecha(){
	var elDiv=$("#listaPublicaciones");
	var laPagina=elDiv.data("pagina");
	laPagina++;
	//for(x=laPagina-1;x<=(laPagina-1)*5;x++){
	$.ajax({
		url:"fcn/f_index.php",
		data:{metodo:"buscarPublicaciones",pagina:laPagina},
		type:"POST",
		dataType:"html",
		success: function(data){
			//elD.delay(10000)iv.hide('swing');
			elDiv.html(data);
			elDiv.show("swing");
			//elDiv.toggle("fast","easeOutQuad",function(){
				//elDiv.html(data);
				//elDiv.show( "slide",{direction:'down'});
				//elDiv.toggle("easeinSine");
			//});
			elDiv.data("pagina",laPagina);
		}
	});
	//}
}
function buscaIzquierda(){
	var elDiv=$("#listaPublicaciones");
	var laPagina=elDiv.data("pagina");
	laPagina--;
	/*for(x=((laPagina-1)*5)+4;x>=(laPagina)*5;x--){
		if(laPagina==0)
		break;*/
	$.ajax({
		url:"fcn/f_index.php",
		data:{metodo:"buscarPublicaciones",pagina:laPagina},
		type:"POST",
		dataType:"html",
		success: function(data){
			//elDiv.html(data);
			/*elDiv.hide('slide',function(){
				elDiv.html(data);
				elDiv.toggle('slide');
			});*/
			elDiv.html(data);
			elDiv.show("swing");
			elDiv.data("pagina",laPagina);
		}
	});
	//}
}
function verDetalle(elId){
	window.open("detalle.php?id=" + elId,"_self");
}
</script>
<?php
include_once "clases/publicaciones.php";
include_once "clases/usuarios.php";
include_once "clases/bd.php";
include_once "clases/fotos.php";
$foto=new fotos();
?>
  
   <div class="ancho85 center-block">
   	  <?php include_once "fcn/f_categorias.php"; ?>
   </div>

<br>
<br>

<!--Ultimas publicaciones --------------------------------------------------------------------------------------------------------------- -->

   <div  class="ancho85  center-block" >
    <div class="row contenedor sombra-div hover-publicaciones" >

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-2">
      <p class="text-left mar20 " style="border-right: 1px solid #ccc;">
        <span class="negro t26 ">Ultimas <br> p&uacute;blicaciones</span>
        <br><br>
        <span class="">echale un vistazo a las publicaciones m&aacute;s recientes.</span>
        <br><br>
        <span class="vin-blue t18" style="text-decoration:underline;"><a href="listado.php">Ver m&aacute;s...</a></span>
         <br>
        <br>
        <br>
        <br>
      </p>
    </div>
    <div id="listaPublicaciones" data-pagina="1">
    <!--desde aqui -->
    <?php
    $bd=new bd();
	$consulta="select * from publicaciones where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) order by id desc limit 5";
	$result=$bd->query($consulta);
	$resultTotal=$bd->query("select count(*) as tota from publicaciones where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)");
	foreach ($resultTotal as $r => $valor) {
		$total=$valor["tota"];
	}
	$i=0;
    foreach($result as $r){
    	$i++;
    	$publicacion=new publicaciones($r["id"]);
		$usua=new usuario($publicacion->usuarios_id);
//		$izquierda=($i==1)?" <i class='fa fa-caret-left t30 point izquierda'style='position:absolute; top:37%; left:-2%; ' id='izquierda' onClick='javascript:buscaIzquierda();'></i>":"";
		$izquierda="";
		if($total<=5){
			$derecha="";
		}else{
			$derecha=($i==5)?" <i class='fa fa-caret-right t30 point derecha'style='position:absolute; float:right; top:37%; right:15%; ' id='derecha' onClick='javascript:buscaDerecha();'></i>":"";
		}
    	$cadena="
	    	<div class='col-xs-12 col-sm-12 col-md-6 col-lg-2'>
	    	$izquierda
	    			<div class='text-center mar10 publicaciones1' style='relative;width:70%;' id='$publicacion->id '>
				    	<br>
				    	<div class='marco-foto-conf  point center-block sombra-div3 ' style='height:120px; width: 120px;'  >
						<img src='" . $publicacion->getFotoPrincipal() . "'  class=' img-responsive center-block img-apdp'>
						</div>
						<br>
						<span class='negro t16'>" . $publicacion->tituloFormateado(15) . "</span>
						<br>
						<span class='red t14'><b>" . $publicacion->getMonto() . "</b></span>
						<br>
						<span class='t12 grisC'>" . ($usua->getEstado()) . "</span> &nbsp;&nbsp; <span class='t12 grisC'><i class='fa fa-clock-o'></i>" . $publicacion->getTiempoPublicacion() . "</span>
						<br>
						<br>
					</div>
					$derecha
			</div>
		";
		echo $cadena;
		if($i==5){
			break;
		}
	}
?>
   </div>
    
    <!-- Hasta aqui -->
    </div>
  </div>




<!-- 5 mas visitadas --------------------------------------------------------------------------------------------------------------- -->


   <div  class="ancho85  center-block hidden">
    <div class="row contenedor sombra-div hover-publicaciones ">

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-2">
      <p class="text-left mar20" style="border-right: 1px solid #ccc;">
        <span class="negro t26 ">Top 5 <br> M&aacute;s Visitados</span>
        <br><br>
        <span>Echale un vistazo a las publicaciones m&aacute;s populares.</span>
        <br><br>
        <span class="vin-blue t18" style="text-decoration:underline;"><a href="#">Ver m&aacute;s...</a></span>
        <br>
        <br>
      
      </p>
    </div>
 
    <!-- Desde aqui -->
    <?php
    /*    VISITAS REVISAR
//    $consulta="select visitas_publicaciones_id from publicaciones where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1)";
    $consulta2="select * from visitas_publicaciones order by numero desc";
	$result=$bd->query($consulta2);
	$i=0;
    foreach($result as $r){
//    	echo $publicacion->id . "<br>";
        $i++;
    	$resultado=$bd->doSingleSelect("publicaciones","visitas_publicaciones_id={$r['id']}");
		$publicacion=new publicaciones($resultado["id"]);
		$usua=new usuario($publicacion->usuarios_id);
    	$cadena="
	    	<div class='col-xs-12 col-sm-12 col-md-6 col-lg-2'>
	    			<div class='text-center mar10 publicaciones2' style='relative;width:70%;'  id='$publicacion->id'>
				    	<br>
				    	<div class='marco-foto-conf  point center-block sombra-div3 ' style='height:120px; width: 120px;'  >
					<span class=' badge2 sombra-div2'STYLE='position:absolute; top:6%; left:8%;  '>$i</span> 
						<img src='" . $publicacion->getFotoPrincipal() . "' width='100%;' height='100%;' class=' img-responsive center-block'>
						</div>
						<br>
						<span class='negro t16'>" . $publicacion->tituloFormateado() . "</span>
						<br>
						<span class='red t14'><b>" . $publicacion->getMonto() . "</b></span>
						<br>
						<span class='t12 grisC '>" . $usua->getEstado() . "</span> / <span class='t10 grisC'> 3500 <i class='fa fa-eye'></i> </span>
						<br>
						<br>
					</div>
			</div>
		";
		echo $cadena;
		if($i==5){
			break;
		}
	}
*/
   ?>
   </div></div>
   <!-- Hasta aqui -->
   <br><br> 
   
   <!-- 5 vendedores --------------------------------------------------------------------------------------------------------------- -->


   <div  class="ancho85  center-block">
    <div class="row contenedor sombra-div hover-vendedores ">

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-2">
      <p class="text-left mar20" style="border-right: 1px solid #ccc;">
        <span class="negro t26 ">Top 5 <br> Vendedores</span>
        <br><br>
        <span>Echale un vistazo a los vendedores m&aacute;s destacados.</span>
        <br><br>
        <span class="vin-blue t18" style="text-decoration:underline; visibility: hidden;"><a href="#">Ver m&aacute;s...</a></span>
        <br>
        <br>
        <br>
      
      </p>
    </div>
 
    <!-- Desde aqui -->
    <?php
//	$result=$bd->query("select count(*) as tota,usuarios_id from publicaciones where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) group by usuarios_id order by tota desc limit 5");
	$result=$bd->query("select count(*) as tota,favoritos_id from usuarios_favoritos  group by favoritos_id order by tota desc limit 5");	
	$i=0;
    foreach($result as $r){
    	$i++;
		$usua=new usuario($r["favoritos_id"]);
		$nombre=$usua->getNombre(1);
    	$cadena="
	    	<div class='col-xs-12 col-sm-12 col-md-6 col-lg-2'>
	    			<div class='text-center mar10 vendedores' style='relative;width:70%;'  id='$usua->id'>
				    	<br>
				    	<div class='marco-foto-conf  point center-block sombra-div3 ' style='height:120px; width: 120px;'  >
					<span class=' badge2 sombra-div2'STYLE='position:absolute; top:6%; left:8%;  '>$i</span> 
						<img src='" . $foto->buscarFotoUsuario($usua->id) . "' class=' img-responsive center-block img-apdp'>
						</div>
						<br>
						<span class='blue-vin t16'>" . $usua->a_seudonimo . $usua->j_categorias_juridicos_id . "</span>
						<br>
						<span class='grisO t14'>" . $nombre . "</span>
						<br>
						<span class='t12 grisC'>" . ($usua->getEstado()) . "</span> &nbsp;&nbsp; <i class='fa fa-thumbs-o-up'></i> <span class='t12 grisC'> {$r["tota"]}  </span>
						<br>
						<br>
					</div>
			</div>
		";
		echo $cadena;
		if($i==5){
			break;
		}	
	}
   ?>
   </div></div>
   <!-- Hasta aqui -->
   <br><br> 
      <br><br> 
         
   
  
  