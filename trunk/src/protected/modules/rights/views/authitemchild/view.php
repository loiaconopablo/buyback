<?php
/* @var $this AuthitemchildController */
/* @var $model Authitemchild */
?>

<?php
$this->breadcrumbs=array(
	'Authitemchilds'=>array('index')
);

$this->menu=array(
	array('label'=>'List Authitemchild', 'url'=>array('index')),
	array('label'=>'Create Authitemchild', 'url'=>array('create')),
	
);
?>

<h1>View Authitemchild</h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'parent',
		'child',
	),
)); ?>