<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu = array(
		array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'icon' => 'list', 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'icon'=>'plus-sign', 'url'=>array('create')),
	);


?>

<!--<h2><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h2>-->


<?php echo TbHtml::button(Yii::t('app', 'Advanced Search'), array(
    'style' => TbHtml::BUTTON_COLOR_PRIMARY,
    'data-toggle' => 'modal',
    'data-target' => '#searchModal',
)); ?>

<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
<br/>
<br/>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type' => TbHtml::GRID_TYPE_BORDERED,
   'dataProvider' => $model->search(),
   'filter' => $model,
   'template' => "{items}",
   'columns' => array(
		'id',
		'slug',
		'name',
		'created_at',
		'updated_at',
		'user_update_id',
		array(
			'class' => 'TbButtonColumn',
		),
	),
)); ?>