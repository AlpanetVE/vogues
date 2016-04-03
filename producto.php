<?php require 'config/core.php'; ?>
<!DOCTYPE html>
<html lang="es">
<?php
include 'fcn/varlogin.php';
include ("fcn/incluir-css-js.php");
?>
<script type="text/javascript" src="js/producto.js"></script>
<script type="text/javascript" src="js/proveedor.js"></script>
<link href="css/producto.css" rel="stylesheet">
<link href="css/proveedor.css" rel="stylesheet">
<body>
<?php
include ("temas/header.php"); 
?> 
<div class="container-fluid pad-top70">
	<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 " id="menu-left-user">
		<?php include("temas/menu-left-usr.php"); ?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 " id="container-producto-list">
		<?php include("paginas/producto/p_producto.php"); ?>
	</div> 	
</div>
<?php
include "temas/footer.php";
include "modales/m_registrar_producto.php";
include "modales/m_edit_producto.php";
include"modales/m_info_prov.php";
include"modales/m_edit_facturado.php";
include"modales/m_edit_garantia.php";
?>
</body>
</html>