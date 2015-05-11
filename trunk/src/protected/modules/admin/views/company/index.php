<?php

$this->breadcrumbs = array(
	Company::label(2),
);

$this->menu = array(
	array('label'=>Yii::t('app', 'Create') . ' ' . Company::label(), 'icon'=>'plus-sign', 'url' => array('create')),
	array('label'=>Yii::t('app', 'Administrar') . ' ' . Company::label(2), 'icon'=>'th-list', 'url' => array('admin')),
);
?>

<!--<h2><?php echo GxHtml::encode(Company::label(2)); ?></h2>-->

<?php $this->widget('bootstrap.widgets.TbListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 