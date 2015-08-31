<?php

$this->breadcrumbs = array(
    PointOfSale::label(2),
);

$this->menu = array(
    array('label'=>Yii::t('app', 'Crear') . ' ' . PointOfSale::label(), 'icon'=>'plus-sign', 'url' => array('create')),
    array('label'=>Yii::t('app', 'Administrar') . ' ' . PointOfSale::label(2), 'icon'=>'th-list', 'url' => array('admin')),
);
?>

<!--<h1><?php echo GxHtml::encode(PointOfSale::label(2)); ?></h1>-->

<?php $this->widget(
    'bootstrap.widgets.TbListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    )
); 