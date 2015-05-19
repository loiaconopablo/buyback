$(document).ready(function(){

	if ($('#User_company_id').val() != '') {
			$('#User_point_of_sale_id').parent().fadeIn();
	}

	$('#User_company_id').on('change', function() {

		if ($('#User_company_id').val() != '') {
			$('#User_point_of_sale_id').parent().fadeIn();
		} else {
			$('#User_point_of_sale_id').parent().fadeOut();
		}

		var company_id = $(this).val();

		$.ajax({
			url: Yii.app.createUrl('admin/pointofsale/pointsofsale', {'company_id': company_id}),
			type: 'POST',
			dataType: 'json',
			success: function(data) {
				$('#User_point_of_sale_id').html('');
				jQuery.each(data, function(key, val) {
					var o = new Option(val.name, val.id);
					$('#User_point_of_sale_id').append(o);
				});
			},
			error: function() {
				//console.log('error');
			}
		});
	});

	$('#Authassignment_itemname').on('change', function() {
		console.log($('#Authassignment_itemname').val());
		if ($('#Authassignment_itemname').val() != '') {
			$('.dependent').fadeIn();
		} else {
			$('.dependent').fadeOut();
		}
	});
});