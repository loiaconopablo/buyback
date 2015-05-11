<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'icon' => 'list', 'url' => array('index')),
	array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'icon' => 'plus-sign', 'url' => array('create')),
);

?>

<!--<h2><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2));?></h2>-->



<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type' => TbHtml::GRID_TYPE_BORDERED,
	'dataProvider' => $model->search(),
	'filter' => $model,
	'template' => "{items}\n{pager}",
	'columns' => array(
		'name',
		array(
			'name' => 'headquarter',
			'value' => 'GxHtml::valueEx($data->headquarter)',
			'filter' => GxHtml::listDataEx(PointOfSale::model()->findAllAttributes(null, true)),
		),
		array(
			'name' => 'company',
			'value' => 'GxHtml::valueEx($data->company)',
			'filter' => GxHtml::listDataEx(Company::model()->findAllAttributes(null, true)),
		),
		'reference_phone',
		// array(
		// 	'name' => 'user_update_id',
		// 	'value' => 'GxHtml::valueEx($data->user_log)',
		// 	'filter' => GxHtml::listDataEx(User::model()->getListData()),
		// ),
		/*
		'province',
		'locality',
		'phone',
		'mail',
		'created_at',
		'updated_at',
		'user_update_id',
		 */
		array(
			'class' => 'TbButtonColumn',
			'template' => '{view}{update}{delete}',
			'buttons' => array(
				'delete' => array(
					'visible' => '!$data->is_owner || Yii::app()->user->checkAccess("superuser")',
				),
			),
		),
	),
));?>
<?php echo TbHtml::button(Yii::t('app', 'Advanced Search'), array(
	'style' => TbHtml::BUTTON_COLOR_PRIMARY,
	'data-toggle' => 'modal',
	'data-target' => '#searchModal',
));?>

<?php $this->renderPartial('_search', array(
	'model' => $model,
));?>