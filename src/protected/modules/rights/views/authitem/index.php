<?php
/* @var $this AuthitemController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
    'Authitems',
);

$this->menu=array(
    array('label'=>'Create Authitem','url'=>array('create')),
    array('label'=>'Manage Authitem','url'=>array('admin')),
);
?>

<h1>Authitems</h1>

<?php $this->widget(
    'bootstrap.widgets.TbListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    )
); ?>