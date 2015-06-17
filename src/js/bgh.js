$(document).ready(function() {
	// Esto sirve para refrescar el contenido del modal
	// cuando se cierra y se abre uno distinto
	// De otra manera siempre muestra el contenido del primer link cargado
	$('body').on('hidden.bs.modal', '.modal', function () {
		console.log(this);
	  $(this).removeData();
	});

	$('.checks-submit').on('click', function(ev) {
		
		var checkcolumn = $(this).attr('data-checkcolumn');
		if (!$("input[name='" + checkcolumn + "[]']").is(':checked')) {
			ev.preventDefault();
			return;
		}

		var attr = $(this).attr('data-submit-action');

		// For some browsers, `attr` is undefined; for others,
		// `attr` is false.  Check for both.
		if (typeof attr !== typeof undefined && attr !== false) {
		    $(this).parents('form').attr('action', attr);
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

function setCheckedItems() {
	// Si la cookie no esta creada la crea vacia
	if ($.cookie('checkedItems') == undefined) {
		$.cookie('checkedItems', '', { path: '/' });
	}

	// convierte los ids separados por coma en la cookie en un array
	var oldCheckedItems = $.cookie('checkedItems').split(',');

	// Trae los nuevos ids seleccionados
	var newCheckedItems = $.fn.yiiGridView.getChecked("selectableGrid","purchase_selected");

	var checkedItems = oldCheckedItems.concat(newCheckedItems).unique();

	// Se les restan los que se deseleccionaron
	checkedItems = checkedItems.diff(getUncheckeds());
	
	$.cookie('checkedItems', checkedItems, { path: '/' });
}

/**
 * Exquende array para agregar el metodo "diff"
 * @param  Array a El array contra el que se compara el original
 * @return Array   La diferencia entre arrays
 */
Array.prototype.diff = function(a) {
    return this.filter(function(i) {return a.indexOf(i) < 0;});
};

/**
 * Devuelve los elementos deseleccionados de la columna de checbocks
 * de Grid
 * @return {[type]} [description]
 */
function getUncheckeds() {
    var unch = [];
    /*corrected typo: $('[name^=someChec]') => $('[name^=someChecks]') */
    $('[name^=purchase_selected]').not(':checked,[name$=all]').each(function(){unch.push($(this).val());});
    return unch.toString();
}

/**
 * Extiende Array.concat para concatenar sin duplicados
 * @return array
 */
Array.prototype.unique = function() {
    var a = this.concat();
    for(var i=0; i<a.length; ++i) {
        for(var j=i+1; j<a.length; ++j) {
            if(a[i] === a[j])
                a.splice(j--, 1);
        }
    }

    return a;
};