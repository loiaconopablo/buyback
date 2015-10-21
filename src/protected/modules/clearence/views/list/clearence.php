<?php $this->renderPartial('_clearence_grid', array('model' => $model, 'data_provider' => $model->search())); ?>

<?php //$this->dispatchnote_references = $model->pendingToPaymentReference();?>

<?php $this->created_at_filter = true;?>

<?php //$this->renderPartial('_modal_pending_view'); ?>