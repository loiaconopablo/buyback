$("a[data-toggle=modal]").on('click', function(ev) {
    ev.preventDefault();
    var target = $(this).attr("href");

    // load the url and show modal on success
    $(".modal-body").load(target, function() { 
         $("#modal-purchase").modal("show"); 
    });
});

$(document).ready(function() {

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