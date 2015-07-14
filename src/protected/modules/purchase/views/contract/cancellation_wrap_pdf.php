<?php $this->renderPartial('cancellation_pdf', array('model' => $model, 'footer' => 'Original para BGH'));?>
<?php $this->renderPartial('cancellation_pdf', array('model' => $model, 'footer' => 'Duplicado para la Sucursal'));?>
<?php $this->renderPartial('cancellation_pdf', array('model' => $model, 'footer' => 'Triplicado para el Cliente'));