	var input1 = $('#p_fecha_pago').pickadate({editable: false, container: '#date-picker2',
  	monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
  	weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mier', 'Jue', 'Vie', 'Sab'],
  	today: 'Hoy',
  	clear: 'Limpiar',
  	close: 'Cerrar',
  	format: 'yyyy-mm-dd',
  	formatSubmit: 'y-m-d'});
	var picker1 = input1.pickadate('picker');
	picker1.set('min', false);
	picker1.set('max', true);
	//Fecha desde
	$('#p_fecha_pago').off('click focus');
	$('#p_fecha_pago').on('click', function(e) {		
  		if (picker1.get('open')) { 
    		picker1.close();
  		}else {
    		picker1.open();
  		}
	  e.stopPropagation();
	});