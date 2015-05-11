<?php
// Comentado 05/05/2015
// $this->breadcrumbs = array(
// 	$model->label(2) => array('index'),
// 	GxHtml::valueEx($model),
// );

// $this->menu=array(
// 	array('label'=>Yii::t('app', 'Buy'), 'icon'=>'plus-sign', 'url'=>array('/retail/purchase/imei')),
// 		array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'icon' => 'list', 'url'=>array('index')),
// );
?>

<!--<h2><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model));?></h2>-->

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
		'contract_number',
		array(
			'label' => 'CAE',
			'value' => $model->cae,
		),
		'imei',
		'brand',
		'model',
		'carrier',
		array(
			'label' => 'Precio de compra',
			'value' => "$ " . $model->purchase_price,
		),
		'company',
		'point_of_sale',
		'user',
		array(
			'label' => Yii::t('app', 'Cliente'),
			'value' => $model->seller,
		),
		array(
			'name' => 'created_at',
			'value' => date("d / m / Y", strtotime($model->created_at)),
		),
	),
));?>

<?php foreach ($model->purchase_statuses as $status): ?>
	<div class="well">
	<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $status,
	'attributes' => array(
		array(
			'label' => Yii::t('app', 'Fecha'),
			'value' => date("d / m / Y", strtotime($model->created_at)),
		),
		'user',
		'status',
		'point_of_sale',
		'dispatch_note_id',
		'comment',
	),
));?>
	</div>
<?php endforeach;?>

<!--
<?php echo CHtml::hiddenField('purchase-id', $model->id);?>
<?php echo CHtml::label(Yii::t('app', 'Comentario'), 'purchase-comment');?>
<?php echo CHtml::textarea('comment', null, array('id' => 'purchase-comment', 'class' => 'purchase-comment', 'style' => 'width:100%; height: 70px'));?>
-->