<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model) => array('view', 'id' => GxActiveRecord::extractPkValue($model, true)),
    Yii::t('app', 'Modificar'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Listar') . ' ' . $model->label(2), 'icon'=>'list', 'url'=>array('admin')),
    array('label' => Yii::t('app', 'Crear') . ' ' . $model->label(), 'icon'=>'plus-sign', 'url'=>array('create')),
    array('label' => Yii::t('app', 'Ver') . ' ' . $model->label(), 'icon' => 'eye-open', 'url'=>array('view', 'id' => GxActiveRecord::extractPkValue($model, true))),
);
?>

<!--<h2><?php echo Yii::t('app', 'Update') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h2>-->

<?php
$this->renderPartial(
    '_form-update', array(
        'model' => $model,
        'Authassignment_model' => $Authassignment_model,
        'roles' => $roles,
        )
);
?>