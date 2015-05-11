$(document).ready(function(){

	$('#StepBrandModelForm_brand').on('change', function() {

		//$('#StepBrandModelForm_model').prop('disabled', 'disabled');

		var brand = $(this).find(":selected").val();

		$.ajax({
			url: Yii.app.createUrl('retail/purchase/getmodels', {'brand': brand}),
			type: 'POST',
			dataType: 'json',
			success: function(data) {
				$('#StepBrandModelForm_model option').each(function() {
					if ($(this).val()) {
						$(this).remove();
					}
				});

				jQuery.each(data, function(key, val) {
					var o = new Option(val.model);
					o.value = val.model;
					$('#StepBrandModelForm_model').append(o);
				});
			},
			error: function() {
				//console.log('error');
			}
		});
	});
});

function formSend(form, data, hasError)
{
	if (!jQuery.isEmptyObject(data)) {
		$.ajax({
			url: Yii.app.createUrl('/default/message', { 'type': 'alert-error' }),
			type: 'POST',
			data: data,
			dataType: 'html',
			success: function(data) {
				$('#messages-wrapper').append(data);
			}
		});
	} else {
		window.location = $(form).attr('action');
	}
}
