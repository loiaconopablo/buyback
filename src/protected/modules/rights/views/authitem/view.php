<?php
/* @var $this AuthitemController */
/* @var $model Authitem */
?>

<?php
$this->breadcrumbs=array(
    'Authitems'=>array('index'),
    $model->name,
);

$this->menu=array(
    array('label'=>'Create Authitem', 'url'=>array('create')),
    //array('label'=>'Update Authitem', 'url'=>array('update', 'id'=>$model->name)),
    array('label'=>'Delete Authitem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->name),'confirm'=>Yii::t('app', 'Realmente desea eliminar este item?'))),
    array('label'=>'Manage Authitem', 'url'=>array('admin')),
);
?>

<h1>View Authitem #<?php echo $model->name; ?></h1>

<?php $this->widget(
    'zii.widgets.CDetailView', array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
    'name',
    'type',
    'description',
    'bizrule',
    'data',
    ),
    )
); ?>