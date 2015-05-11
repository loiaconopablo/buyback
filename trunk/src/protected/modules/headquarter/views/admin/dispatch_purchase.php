<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Buy'), 'icon' => 'plus-sign', 'url' => array('/retail/purchase/imei')),
	array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'icon' => 'list', 'url' => array('index')),
);

?>

<!--<h2><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2));?></h2>-->

<?php $form = $this->beginWidget('CActiveForm', array(
	//'action' => Yii::app()->createUrl('/retail/dispatchnote/create'),
	//'enableAjaxValidation'=>true,
));?>

<h3>Nota de Envío</h3>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type' => TbHtml::GRID_TYPE_BORDERED,
	'dataProvider' => $dataProvider,
	//'filter' => $model,
	'template' => "{items}\n{pager}",
	'columns' => array(
		//'id',
		//'company_id',
		//'point_of_sale_id',
		//'headquarter_id',
		array(
			'header' => 'html',
			'id' => 'dispatch_selected',
			'class' => 'CCheckBoxColumn',
			'selectableRows' => '50',
			'selectableRows' => 2,
			'value' => '$data->id',
			'headerTemplate' => '<label>{item}<span></span></label>',
		),
		'contract_number',
		'brand',
		'model',
		'imei',
		'user',

		// array(
		// 	'class' => 'TbButtonColumn',
		// 	'template' => '{view}',
		// ),
	),
));?>

	<div>
	<?php echo $form->labelEx($dispatch_note_model, 'comment');?>
	<?php echo $form->textArea($dispatch_note_model, 'comment', array('class' => 'span12', 'style' => 'height:200px'));?>
	<?php echo $form->error($dispatch_note_model, 'comment');?>
	</div><!-- row -->

<?php echo TbHtml::submitButton(Yii::t('app', 'Save'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE));?>

<?php $this->endWidget();?>
