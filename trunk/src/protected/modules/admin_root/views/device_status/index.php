<?php

$this->breadcrumbs = array(
	DeviceStatus::label(2),
	Yii::t('app', 'Index'),
);

$this->menu = array(
	array('label'=>Yii::t('app', 'Create') . ' ' . DeviceStatus::label(), 'icon'=>'plus-sign', 'url' => array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . DeviceStatus::label(2), 'icon'=>'th-list', 'url' => array('admin')),
);
?>

<!--<h><?php echo GxHtml::encode(DeviceStatus::label(2)); ?></h2>-->

<?php $this->widget('bootstrap.widgets.TbListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 