<?php
/* @var $this ForecastController */
/* @var $model Forecast */
?>

<?php

$this->menu=array(
	array('label'=>'Administrar Forecast', 'url'=>array('admin')),
	array('label'=>'Crear Forecast', 'url'=>array('create')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>