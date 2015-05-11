<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model) => array('view', 'id' => GxActiveRecord::extractPkValue($model, true)),
	Yii::t('app', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'icon'=>'list', 'url'=>array('admin')),
	array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'icon'=>'plus-sign', 'url'=>array('create')),
	array('label' => Yii::t('app', 'View') . ' ' . $model->label(), 'icon' => 'eye-open', 'url'=>array('view', 'id' => GxActiveRecord::extractPkValue($model, true))),
);
?>

<!--<h2><?php echo Yii::t('app', 'Update') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h2>-->

<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'Authassignment_model' => $Authassignment_model,
		'roles' => $roles,
		));
?>