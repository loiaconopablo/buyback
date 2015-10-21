<?php $this->renderPartial('_dispatchnote_grid', array('model' => $model, 'data_provider' => $model->pendingToPayment())); ?>

<?php $this->dispatchnote_references = $model->pendingToPaymentReference();?>

<?php $this->created_at_filter = true;?>

<?php //$this->renderPartial('_modal_pending_view'); ?>

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/dispatch_note.js"></script>
