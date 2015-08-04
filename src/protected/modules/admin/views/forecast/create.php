<?php
/* @var $this ForecastController */
/* @var $model Forecast */
?>

<?php

$this->menu=array(
	array('label'=>'Listar Forecast', 'url'=>array('index')),
	array('label'=>'Administrar Forecast', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>