<?php

$this->menu = array(
    //array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'icon' => 'list', 'url'=>array('index')),
    //array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'icon' => 'plus-sign', 'url' => array('/headquarter/admin/admin')),
);

?>

<?php $this->renderPartial('_grid', array('model' => $model, 'data_provider' => $model->pending())); ?>

<?php $this->dispatchnote_references = $model->pendingReferences();?>

<?php $this->created_at_filter = true;?>

<?php $this->renderPartial('_modal_pending_view'); ?>

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/dispatch_note.js"></script>
