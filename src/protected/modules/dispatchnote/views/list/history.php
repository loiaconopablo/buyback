<?php

$this->menu = array(
    //array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'icon' => 'list', 'url'=>array('index')),
    //array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'icon' => 'plus-sign', 'url' => array('/headquarter/admin/admin')),
);

?>

<?php $this->renderPartial('_grid_history', array('model' => $model, 'data_provider' => $model->history())); ?>

<?php $this->dispatchnote_references = $model->historyReference();?>

<?php $this->created_at_filter = true;?>

<?php $this->renderPartial('_modal_history_view'); ?>

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/dispatch_note.js"></script>
