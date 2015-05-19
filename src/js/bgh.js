// A esto lo reemplaza el código de abajo
// @commented 2015-05-15
// $("a[data-toggle=modal]").on('click', function(ev) {
//     ev.preventDefault();
//     var target = $(this).attr("href");

//     // load the url and show modal on success
//     $(".modal-body").load(target, function() { 
//          $("#modal-purchase").modal("show"); 
//     });
// });

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

	$('table').tooltip({'selector':'[rel=tooltip]'});

	$("#in-observation-purchase").on('click', function() {

		console.log($(this).parents('.modal').children('#purchase-comment').value);
		// $.ajax({
		// 	url: Yii.app.createUrl('purchase/purchase/setinobservation', {'id': $('#purchase-id').val()}),
		// 	type: 'POST',
		// 	//data: {comment: $('#purchase-comment')},
		// 	dataType: 'json',
		// 	success: function(data) {
		// 		$.fn.yiiGridView.update('owner-purchase-grid');
		// 		$('#modal-purchase').modal('hide');
		// 	},
		// 	error: function() {
		// 		//console.log('error');
		// 	}
		// });
	});

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