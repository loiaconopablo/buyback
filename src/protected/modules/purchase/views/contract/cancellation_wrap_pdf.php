<?php $seller = $model->getSeller(); ?>
<?php $this->renderPartial('cancellation_pdf', array('model' => $model, 'seller' => $seller, 'footer' => 'Original para BGH'));?>
<?php $this->renderPartial('cancellation_pdf', array('model' => $model, 'seller' => $seller, 'footer' => 'Duplicado para la Sucursal'));?>
<?php $this->renderPartial('cancellation_pdf', array('model' => $model, 'seller' => $seller, 'footer' => 'Triplicado para el Cliente'));