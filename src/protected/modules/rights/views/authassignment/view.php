<?php
/* @var $this AuthassignmentController */
/* @var $model Authassignment */
?>

<?php
$this->breadcrumbs=array(
    'Authassignments'=>array('index')
);

$this->menu=array(
    array('label'=>'Manage Authassignment', 'url'=>array('admin')),
    array('label'=>'Create Authassignment', 'url'=>array('create')),
    
);
?>


<?php $this->widget(
    'zii.widgets.CDetailView', array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
    'itemname',
    'userid',
    ),
    )
); ?>