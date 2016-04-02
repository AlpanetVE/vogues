	var input1 = $('#p_fecha').pickadate({editable: false, container: '#date-picker',
  	monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
  	weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mier', 'Jue', 'Vie', 'Sab'],
  	today: 'Hoy',
  	clear: 'Limpiar',
  	close: 'Cerrar',
  	format: 'dd-mm-yyyy',
  	formatSubmit: 'd-m-y'});
	var picker1 = input1.pickadate('picker');
	picker1.set('min', false);
	picker1.set('max', true);
	//Fecha desde
	$('#p_fecha').off('click focus');
	$('#p_fecha').on('click', function(e) {
  		if (picker1.get('open')) { 
    		picker1.close();
  		}else {
    		picker1.open();
  		}
	  e.stopPropagation();    
	});
