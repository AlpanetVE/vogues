<!DOCTYPE html>
<html lang="es">
	<?php	
	include "fcn/incluir-css-js.php";
	?>
	<body >
		<?php include "temas/header.php";
		?>		
		<div style="margin-top: -40px;margin-bottom:25px;"><?php include('paginas/index/apdp-principal.php'); ?></div>
		
			<div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
					<?php 
					include "paginas/index/p_index.php";
					?>
					<br>
				</div>		
		</div>		
		<?php
		include "temas/footer.php";
		include "modales/m_registrar.php";
		include "modales/m_emp_per.php";
		include "modales/m_edit_info_personal_n.php";
		include "modales/m_edit_info_personal_j.php";
		?>
		<div class="modal-backdrop fade in cargador" style="display:none"></div>
		</body>
	
</html>