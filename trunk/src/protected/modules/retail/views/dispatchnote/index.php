<?php

$this->breadcrumbs = array(
	DispatchNote::label(2),
	Yii::t('app', 'Index'),
);

$this->menu = array(
	array('label'=>Yii::t('app', 'Create') . ' ' . DispatchNote::label(), 'icon'=>'plus-sign', 'url' => array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . DispatchNote::label(2), 'icon'=>'th-list', 'url' => array('admin')),
);
?>

<!--<h2><?php echo GxHtml::encode(DispatchNote::label(2)); ?></h2>-->

<?php $this->widget('bootstrap.widgets.TbListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 