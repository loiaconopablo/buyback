<?php
/* @var $this AuthitemController */
/* @var $model Authitem */


$this->breadcrumbs=array(
    'Authitems'=>array('index'),
    'Manage',
);

$this->menu=array(
    array('label'=>'Create Authitem', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript(
    'search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#authitem-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
"
);
?>

<?php
    $types = array(
        array('id' => 0, 'name' => 'Operation'),
        array('id' => 1, 'name' => 'Task'),
        array('id' => 2, 'name' => 'Role'),
    );
?>

<!--<h1>Manage Authitems</h1>-->


<?php $this->widget(
    'bootstrap.widgets.TbGridView', array(
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'id'=>'authitem-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'name',
        array( 'name'=>'type', 'header'=>'Type', 'value'=>'Helper::getStringTypeAuthitem($data->type)', 'filter' => CHtml::listData($types, 'id', 'name')),
        'description',
        'bizrule',
        'data',
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{view}{delete}',
        ),
    ),
    )
); ?>