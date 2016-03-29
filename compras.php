<?php require "config/core.php";
if(isset($_GET["tipo2"])){
	if($_GET["tipo2"]==1){   
		$clase1="";
		$clase2="hidden";
	}else{
		$clase1="hidden";
		$clase2="";
	}
	$tipo2=$_GET["tipo2"];
}else{
	$clase1="";
	$clase2="hidden";	
	$tipo2="";
}
include_once "fcn/varlogin.php";
?>
<!DOCTYPE html>
<html lang="es">
<?php include "fcn/incluir-css-js.php";?>
<!-- include adicional (editor) debe ir antes del body -->
<link rel="stylesheet" href="js/htmledit/ui/trumbowyg.css">
<link rel="stylesheet" href="js/cropit/cropit.css">
<link rel="stylesheet" href="css/default.css">
<link rel="stylesheet" type="text/css" href="css/default.date.css">
<script type="text/javascript" src="js/htmledit/trumbowyg.min.js"></script>
<script type="text/javascript" src="js/htmledit/langs/es.min.js"></script>
<!--<script "text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.3/legacy.js"></script>-->
<script type="text/javascript" src="js/picker.min.js"></script>
<body data-tipo='<?php echo $tipo2;?>'>
<?php include "temas/header.php";?>
<div class="container">	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 ">
			<?php include "temas/menu-left-usr.php";?>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 ">
			<div class="marL20">
			<div  id="segundo" name="segundo">
				<?php include "paginas/compra/p_compras.php";?>
			</div>
		</div>
		</div>
	</div>
</div>
<div class="modal-backdrop fade in cargador" style="display:none"></div>
<script type="text/javascript" src="js/compras.js"></script>
<script type="text/javascript" src="js/autoNumeric/autoNumeric-min.js"></script>
</body>
</html>