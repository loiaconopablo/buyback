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
	 * 
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

	// Comentado 16-06-2015
	// $("#in-observation-purchase").on('click', function() {

	// 	console.log($(this).parents('.modal').children('#purchase-comment').value);
	// 	// $.ajax({
	// 	// 	url: Yii.app.createUrl('purchase/purchase/setinobservation', {'id': $('#purchase-id').val()}),
	// 	// 	type: 'POST',
	// 	// 	//data: {comment: $('#purchase-comment')},
	// 	// 	dataType: 'json',
	// 	// 	success: function(data) {
	// 	// 		$.fn.yiiGridView.update('owner-purchase-grid');
	// 	// 		$('#modal-purchase').modal('hide');
	// 	// 	},
	// 	// 	error: function() {
	// 	// 		//console.log('error');
	// 	// 	}
	// 	// });
	// });

});

function refreshGrid () {
	$('.grid-view').each(function() {
		$.fn.yiiGridView.update($(this).attr('id'));
	})
}

function resetDateFilter() {
	$.removeCookie("from");
	$.removeCookie("to");
	location.reload();
}

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
}


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
}


function arrayDiff(a1, a2) {
	return a1.filter(function(i) {return a2.indexOf(i) < 0;});
}


/**
 * Devuelve los elementos deseleccionados de la columna de checbocks
 * de Grid
 * @return {[type]} [description]
 */
function getUncheckeds() {
    var unch = [];
    $('[name^=purchase_selected]').not(':checked,[name$=all]').each(function(){unch.push($(this).val());});
    return unch.toString();
}
