<?php

$this->breadcrumbs = array(
    Seller::label(2),
    Yii::t('app', 'Inicio'),
);

$this->menu = array(
    array('label'=>Yii::t('app', 'Crear') . ' ' . Seller::label(), 'icon'=>'plus-sign', 'url' => array('create')),
    array('label'=>Yii::t('app', 'Administrar') . ' ' . Seller::label(2), 'icon'=>'th-list', 'url' => array('admin')),
);
?>

<!--<h2><?php echo GxHtml::encode(Seller::label(2)); ?></h2>-->

<?php $this->widget(
    'bootstrap.widgets.TbListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    )
); 