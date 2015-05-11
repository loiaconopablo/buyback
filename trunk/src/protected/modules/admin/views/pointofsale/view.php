<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu = array(
	array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'icon' => 'list', 'url' => array('admin')),
	array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'icon' => 'plus-sign', 'url' => array('create')),
	array('label' => Yii::t('app', 'Update') . ' ' . $model->label(), 'icon' => 'pencil', 'url' => array('update', 'id' => $model->id)),
	//array('label' => Yii::t('app', 'Delete') . ' ' . $model->label(), 'icon' => 'remove', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);
?>

<!--<h2><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model));?></h2>-->

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		array(
			'name' => 'company',
			'type' => 'raw',
			'value' => $model->company !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->company)), array('company/view', 'id' => GxActiveRecord::extractPkValue($model->company, true))) : null,
		),
		'is_headquarter:boolean',
		array(
			'name' => 'headquarter',
			'type' => 'raw',
			'value' => $model->headquarter !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->headquarter)), array('pointOfSale/view', 'id' => GxActiveRecord::extractPkValue($model->headquarter, true))) : null,
		),
		'name',
		'address',
		'province',
		'locality',
		'phone',
		array(
			'label' => 'mail',
			'type' => 'raw',
			'value' => CHtml::mailto($model->mail, $model->mail),
		),
		null,
		'reference_name',
		'reference_phone',
		array(
			'label' => 'reference_mail',
			'type' => 'raw',
			'value' => CHtml::mailto($model->reference_mail, $model->reference_mail),
		),
		null,
		'created_at',
		'updated_at',
		'user_log',
	),
));?>