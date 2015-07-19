$(document).ready(function() {
	// Esto sirve para refrescar el contenido del modal
	// cuando se cierra y se abre uno distinto
	// De otra manera siempre muestra el contenido del primer link cargado
	$('body').on('hidden.bs.modal', '.modal', function () {
		console.log(this);
	  $(this).removeData();
	});

	/**
	 * Submit de los formularios con columna de checks  Grid
	 */
	$('.checks-submit').on('click', function(ev) {

		setCheckedItems();
		
		if ($.trim($.cookie('checkedItems')).length <= 0) {
			ev.preventDefault();
			return;
		}

	});

	// Activa los tooltips de las tablas
	$('table').tooltip({'selector':'[rel=tooltip]'});

	/**
	 * Anula una compra generando su respectiva NOTA DE CREDITO y asociandola
	 */
	 $('#cancel_purchase').live('click', function(ev) {
	 	if (!confirm('Cancelar compra emitiendo un comprobante negativo?')) {
	 		return;
	 	}

	 	$.ajax({
			url: Yii.app.createUrl('purchase/buy/cancel', {'id': $('#purchase_id').val()}),
			type: 'POST',
			dataType: 'json',
			success: function(data) {
				if (data.status == 0) {
					alert(data.errors);
				}
				var win = window.open(Yii.app.createUrl('purchase/contract/generatecancellationcontract', {'id': data.purchase_id}), '_blank');
				$.fn.yiiGridView.update('owner-purchase-grid');
				$('#modal-purchase').modal('hide');

			},
			error: function() {
				//console.log('error');
			}
		});
	 });

	 /** Filtra por status purchase */
	 $('input[name*=status_search]').on('click', function() {

	 	var checked_purchase_statuses = new Array();

	 	$('input[name*=status_search]:checked').each(function() {
	 		checked_purchase_statuses.push($(this).val());
	 	});

	 	$.cookie('checkedPurchaseStatuses', checked_purchase_statuses, { path: '/' });

	 	refreshGrid();
	 });

	 // Actualiza las consulta antes de ir al actin export
	 $('.export_to_excel').on('click', function() {
	 	$('.grid-view').each(function() {
			$.fn.yiiGridView.update($(this).attr('id'));
		})
	 });

	 // Evita que los links deshabilitados funcionen
	 $('.disabled a').on('click', function(ev) {
	 	ev.preventDefault();
	 });

});


/**
 * DATE FILTER FUNCTIONS
 * @return {[type]} [description]
 */
function refreshGrid () {
	$('.grid-view').each(function() {
		$.fn.yiiGridView.update($(this).attr('id'));
	})
};

function resetDateFilter(prefix) {
	$.removeCookie(prefix + "from");
	$.removeCookie(prefix + "to");
	location.reload();
};

/**
 * Guarda en una cookie los checkbox seleccionados en un Grid
 * Para mantenerlos aunque se pagine
 */
function setCheckedItems() {
	// Si la cookie no esta creada la crea vacia
	if ($.cookie('checkedItems') == undefined) {
		$.cookie('checkedItems', '', { path: '/' });
	}

	// convierte los ids separados por coma en la cookie en un array
	var oldCheckedItems = $.cookie('checkedItems').split(',');

	// Trae los nuevos ids seleccionados
	var newCheckedItems = $.fn.yiiGridView.getChecked("selectableGrid","purchase_selected");

	var checkedItems = oldCheckedItems.concat(newCheckedItems);

	// Se liminan los duplicados
	checkedItems = uniq(checkedItems);

	// Se les restan los que se deseleccionaron
	checkedItems = arrayDiff(checkedItems, getUncheckeds());
	
	$.cookie('checkedItems', checkedItems, { path: '/' });
};


/**
 * Recibe un array y devuelve otro sin los datos duplicados del recibido
 * @param  Array a array original
 * @return Array   Array sin items duplicados
 */
function uniq(a) {
    var prims = {"boolean":{}, "number":{}, "string":{}}, objs = [];

    return a.filter(function(item) {
        var type = typeof item;
        if(type in prims)
            return prims[type].hasOwnProperty(item) ? false : (prims[type][item] = true);
        else
            return objs.indexOf(item) >= 0 ? false : objs.push(item);
    });
};


function arrayDiff(a1, a2) {
	return a1.filter(function(i) {return a2.indexOf(i) < 0;});
};


/**
 * Devuelve los elementos deseleccionados de la columna de checbocks
 * de Grid
 * @return {[type]} [description]
 */
function getUncheckeds() {
    var unch = [];
    $('[name^=purchase_selected]').not(':checked,[name$=all]').each(function(){unch.push($(this).val());});
    return unch.toString();
};