<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Crear'),
);

$this->menu = array(
    array('label'=>Yii::t('app', 'Listar') . ' ' . $model->label(2), 'icon' => 'list', 'url' => array('index')),
    array('label'=>Yii::t('app', 'Administrar') . ' ' . $model->label(2), 'icon' => 'th-list', 'url' => array('admin')),
);
?>

<!--<h2><?php echo Yii::t('app', 'Create') . ' ' . GxHtml::encode($model->label()); ?></h2>-->

<?php
$this->renderPartial(
    '_form', array(
        'model' => $model,
        'buttons' => 'create')
);
?>