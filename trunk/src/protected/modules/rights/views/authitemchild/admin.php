<?php
/* @var $this AuthitemController */
/* @var $model Authitem */


$this->breadcrumbs=array(
	'Authitemchilds'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Authitemchild', 'url'=>array('create')),
);

?>

<!--<h1>Manage Authitems</h1>-->


<?php $this->widget('bootstrap.widgets.TbGridView', array(
			'type' => TbHtml::GRID_TYPE_BORDERED,
			'id'=>'authitem-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'columns'=>array(
				'parent',
				'child',
				array(
				    'class'=>'TbButtonColumn',
				    'template'=>'{view}{delete}',
				    'buttons'=>array
				    (
				    	'view' => array
				        (
				            'icon' => 'eye-open',
				            //'imageUrl'=>Yii::app()->request->baseUrl.'/images/email.png',
				            'url'=>'Yii::app()->createUrl("rights/authitemchild/view", array("parent"=>$data->parent,"child"=>$data->child))',
				        ),
				        'delete' => array
				        (
				            'icon' => 'trash',
				            //'imageUrl'=>Yii::app()->request->baseUrl.'/images/email.png',
				            'url'=>'Yii::app()->createUrl("rights/authitemchild/delete", array("parent"=>$data->parent,"child"=>$data->child))',
				        ),
				    ),
				),
		),
)); ?>