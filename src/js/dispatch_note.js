$(document).ready(function() {
	// click on EN TRANSITO
	$("#send_dispatch").on('click', function() {
		$.ajax({
			url: Yii.app.createUrl('dispatchnote/dispatchnote/setassent', {'id': $('#dispatch_note_id').val()}),
			type: 'POST',
			dataType: 'json',
			success: function(data) {
				if (data.status == 0) {
					alert(data.errors);
				}

				$.fn.yiiGridView.update('dispatch_notes_grid');
				$('#modal-dispatch-note').modal('hide');
			},
			error: function() {
				//console.log('error');
			}
		});
	});

	$("#cancel_dispatch").on('click', function() {
		$.ajax({
			url: Yii.app.createUrl('dispatchnote/dispatchnote/cancel', {'id': $('#dispatch_note_id').val()}),
			type: 'POST',
			dataType: 'json',
			success: function(data) {
				if (data.status == 0) {
					alert(data.errors);
				}
				$.fn.yiiGridView.update('dispatch_notes_grid');
				$('#modal-dispatch-note').modal('hide');
			},
			error: function() {
				//console.log('error');
			}
		});
	});


	// click on RECIBIDO
	$("#receiving_in_headquarter_dispatch").on('click', function() {
		var frm = $("#receiving_form");

		console.log(frm);

		$.ajax({
			url: Yii.app.createUrl('dispatchnote/dispatchnote/setasreceivedinheadquarter', {'id': $('#dispatch_note_id').val()}),
			type: 'POST',
			dataType: 'json',
			data: frm.serializeArray(),
			success: function(data) {
				$.fn.yiiGridView.update('dispatch_notes_grid');
				$('#modal-dispatch-note').modal('hide');
			},
			error: function() {
				//console.log('error');
			}
		});
	});
});