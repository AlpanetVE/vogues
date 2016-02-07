<script>
$(document).ready(function(){

$('#recientes').slick({
  arrows: true,
  dots: true,
  infinite: false,
  speed: 300,
  slidesToShow: 5,
  slidesToScroll: 5,
  adaptiveHeight: true,
  responsive: [
    {
      breakpoint: 1600,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true,
        arrows: false
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        arrows:false
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        dots: false
      }
    }
  ]
});

	});	
function buscaDerecha(){
	var elDiv=$("#listaPublicaciones");
	var laPagina=elDiv.data("pagina");
	laPagina++;
	$.ajax({
		url:"fcn/f_index.php",
		data:{metodo:"buscarPublicaciones",pagina:laPagina},
		type:"POST",
		dataType:"html",
		success: function(data){
			elDiv.html(data);
			elDiv.data("pagina",laPagina);
		}
	});
}
function buscaIzquierda(){
	var elDiv=$("#listaPublicaciones");
	var laPagina=elDiv.data("pagina");
	laPagina--;
	$.ajax({
		url:"fcn/f_index.php",
		data:{metodo:"buscarPublicaciones",pagina:laPagina},
		type:"POST",
		dataType:"html",
		success: function(data){
			elDiv.html(data);
			elDiv.data("pagina",laPagina);
		}
	});
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
    <div class="row contenedor sombra-div " >

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-2">
      <p class="text-left mar20 " style="border-right: 1px solid #ccc;">
        <span class="negro t26 ">Ultimas <br> p&uacute;blicaciones</span>
        <br><br>
        <span class="">echale un vistazo a las publicaciones m&aacute;s recientes.</span>
        <br><br> 
        <span class="vin-blue t18 " style="text-decoration:underline;"><a href="listado.php">Ver m&aacute;s...</a></span>
         <br>
        <br>
        <br>
        <br>
      </p>
    </div>
    
<div id="recientes" class="hover-publicaciones " style="width:80%; z-index: 1; float: left;" >

    <!--desde aqui -->
<?php
$bd=new bd();
$consulta="select * from publicaciones where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) order by id desc limit 25";
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

		?>
    	<div id="<?php echo $i; ?>" class='col-xs-12 col-sm-12 col-md-6 col-lg-2' >

	    			<div class='text-center mar10 publicaciones1' style='relative;width:70%;' id='<?php echo $publicacion->id; ?> '>
				    	<br>
				    	<div class='marco-foto-conf  point center-block sombra-div3 ' style='height:120px; width: 120px;'  >
						<img src='<?php echo $publicacion->getFotoPrincipal(); ?> '  class=' img-responsive center-block img-apdp'>
						</div>
						<br>
						<span class='negro t16'><?php echo $publicacion->tituloFormateado(15); ?> </span>
						<br>
						<span class='red t14'><b><?php echo $publicacion->getMonto(); ?> </b></span>
						<br>
						<span class='t12 grisC'><?php echo ($usua->getEstado()) ?> </span> &nbsp;&nbsp; <span class='t12 grisC'><i class='fa fa-clock-o'></i><?php echo $publicacion->getTiempoPublicacion(); ?> </span>
						<br>
						<br>
					</div>

		</div>
		<?php

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

<!--
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
 
    <!-- Desde aqui 
    <?php
//	$result=$bd->query("select count(*) as tota,usuarios_id from publicaciones where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) group by usuarios_id order by tota desc limit 5");
	$result=$bd->query("select count(*) as tota,favoritos_id from usuarios_favoritos  group by favoritos_id order by tota desc limit 5");	
	$i=0;
    foreach($result as $r):
    	$i++;
		$usua=new usuario($r["favoritos_id"]);
		$nombre=$usua->getNombre(1);
		?>
	    	<div class='col-xs-12 col-sm-12 col-md-6 col-lg-2'>
	    			<div class='text-center mar10 vendedores' style='relative;width:70%;'  id='<?php echo $usua->id;?>'>
				    	<br>
				    	<div class='marco-foto-conf  point center-block sombra-div3 ' style='height:120px; width: 120px;'  >
					<span class=' badge2 sombra-div2'STYLE='position:absolute; top:6%; left:8%;  '><?php echo $i;?></span> 
						<img src='<?php echo $foto->buscarFotoUsuario($usua->id);?>' class=' img-responsive center-block img-apdp'>
						</div>
						<br>
						<span class='blue-vin t12'><?php echo $usua->a_seudonimo; ?></span>
						<br>
						<?php
						if(is_null($usua->j_rif)):
							?>
						<span class='grisO t12'><?php echo $nombre;?></span>
						<br>
						<?php
						else:
							$cate=$bd->doSingleSelect("categorias_juridicos","id=$usua->j_categorias_juridicos_id");
							?>
							<span class='grisO t12'><?php echo $cate["nombre"];?></span>
							<br>														
						<?php
						endif;
						?>
						<span class='t12 grisC'><?php echo ($usua->getEstado());?></span> &nbsp;&nbsp; <i class='fa fa-thumbs-o-up'></i> <span class='t12 grisC'><?php echo $r["tota"]; ?></span>
						<br>
						<br>
					</div>
			</div>
			<?php
	endforeach;
   ?>
   </div></div>
   <!-- Hasta aqui -->
   
   
   
   
   
   <br><br> 
      <br><br> 
         
   
  
  