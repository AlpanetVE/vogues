<!DOCTYPE html>
<html lang="es">
<?php
include 'fcn/varlogin.php';
include ("fcn/incluir-css-js.php");
?>
<body>
<?php
include ("temas/header.php");
?>
<div class="container">
	<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
		<?php include("temas/menu-left-usr.php"); ?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
		<?php include("paginas/resumen/p_resumen.php"); ?>
	</div>
</div>
<?php
include ("temas/footer.php");
?>

</body>
</html>