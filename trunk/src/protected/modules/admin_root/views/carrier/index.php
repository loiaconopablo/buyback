<?php

$this->breadcrumbs = array(
	Carrier::label(2),
	Yii::t('app', 'Index'),
);

$this->menu = array(
	array('label'=>Yii::t('app', 'Create') . ' ' . Carrier::label(), 'icon'=>'plus-sign', 'url' => array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . Carrier::label(2), 'icon'=>'th-list', 'url' => array('admin')),
);
?>

<!--<h2><?php echo GxHtml::encode(Carrier::label(2)); ?></h2>-->

<?php $this->widget('bootstrap.widgets.TbListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 