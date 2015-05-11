<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Buy'), 'icon' => 'plus-sign', 'url' => array('/retail/purchase/imei')),
	array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'icon' => 'list', 'url' => array('index')),
);
?>

<div class="well">
	<h4>Nota de envío Nº <?php echo $dispatch_note->dispatch_note_number;?></h4>
</div>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array('id' => 'dispatch_form'));?>
<?php echo CHtml::hiddenField('dispatch_note_id', $dispatch_note->id, array('id' => 'dispatch_note_id'));?>
<?php $this->endWidget();?>

<h4>Origen</h4>
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $company_from,
	'attributes' => array(
		array(
			'label' => Yii::t('app', 'Company'),
			'value' => $company_from->name,
		),
		array(
			'label' => Yii::t('app', 'Point Of Sale'),
			'value' => $from->name,
		),
		array(
			'label' => Yii::t('app', 'Province'),
			'value' => $from->province,
		),
		array(
			'label' => Yii::t('app', 'Locality'),
			'value' => $from->locality,
		),
		array(
			'label' => Yii::t('app', 'Address'),
			'value' => $from->address,
		),
	),
));?>

<h4>Destino</h4>
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $to,
	'attributes' => array(
		array(
			'label' => Yii::t('app', 'Point Of Sale'),
			'value' => $to->name,
		),
		array(
			'label' => Yii::t('app', 'Province'),
			'value' => $to->province,
		),
		array(
			'label' => Yii::t('app', 'Locality'),
			'value' => $to->locality,
		),
		array(
			'label' => Yii::t('app', 'Address'),
			'value' => $to->address,
		),
	),
));?>

<h4>Detalle</h4>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type' => TbHtml::GRID_TYPE_BORDERED,
	'dataProvider' => $purchasesDataProvider,
	//'filter' => $model,
	'template' => "{items}",
	'columns' => array(
		//'id',
		//'company_id',
		//'point_of_sale_id',
		//'headquarter_id',
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

<?php if (strlen(trim($dispatch_note->comment))): ?>
	<div class="well">
		<?php echo $dispatch_note->comment;?>
	</div>
<?php endif;?>

<?php if ($dispatch_note->status != DispatchNote::CANCELLED): ?>
	<?php echo TbHtml::linkButton(Yii::t('app', 'Imprimir Nota de Envío'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'block' => true, 'url' => array('generatepdf', 'id' => $dispatch_note->id), 'target' => '_blank'));?>
<?php endif;?>