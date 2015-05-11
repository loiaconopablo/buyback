<?php
/* @var $this AuthitemController */
/* @var $model Authitem */


$this->breadcrumbs=array(
	'Authassignment'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Assign Role', 'url'=>array('create')),
);

?>

<!--<h1>Manage Authitems</h1>-->


<?php $this->widget('bootstrap.widgets.TbGridView', array(
			'type' => TbHtml::GRID_TYPE_BORDERED,
			'id'=>'authitem-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'columns'=>array(
				array(
				'name'=>'user',
				'value'=>'GxHtml::valueEx($data->user)',
				//'filter'=>GxHtml::listDataEx(User::model()->findAllAttributes(null, true)),
				),
				'itemname',
				'bizrule',
				'data',
				array(
				    'class'=>'TbButtonColumn',
				    'template'=>'{view}{delete}',
				    'buttons'=>array
				    (
				    	'view' => array
				        (
				            'icon' => 'eye-open',
				            //'imageUrl'=>Yii::app()->request->baseUrl.'/images/email.png',
				            'url'=>'Yii::app()->createUrl("rights/authassignment/view", array("itemname"=>$data->itemname,"userid"=>$data->userid))',
				        ),
				        'delete' => array
				        (
				            'icon' => 'trash',
				            //'imageUrl'=>Yii::app()->request->baseUrl.'/images/email.png',
				            'url'=>'Yii::app()->createUrl("rights/authassignment/delete", array("itemname"=>$data->itemname,"userid"=>$data->userid))',
				        ),
				    ),
				),
		),
)); ?>