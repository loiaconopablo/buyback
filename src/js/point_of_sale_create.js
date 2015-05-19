$(document).ready(function(){
	// if ($('#PointOfSale_is_headquarter').is(':checked')) {
	// 		$('#PointOfSale_headquarter_id').parent().fadeOut();
	// }

	// $('#PointOfSale_is_headquarter').on('change', function() {
	// 	if ($('#PointOfSale_is_headquarter').is(':checked')) {
	// 		$('#PointOfSale_headquarter_id').parent().fadeOut();
	// 	} else {
	// 		$('#PointOfSale_headquarter_id').parent().fadeIn();
	// 	}
	// });

	$('#PointOfSale_company_id').on('change', function() {
		var company_id = $(this).val();

		$.ajax({
			url: Yii.app.createUrl('admin/pointofsale/headquarters', {'company_id': company_id}),
			type: 'POST',
			dataType: 'json',
			success: function(data) {
				$('#PointOfSale_headquarter_id').html('');
				jQuery.each(data, function(key, val) {
					var o = new Option(val.name, val.id);
					$('#PointOfSale_headquarter_id').append(o);
				});
			},
			error: function() {
				//console.log('error');
			}
		});
	});
});