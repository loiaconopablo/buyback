<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Listar') . ' ' . $model->label(2), 'icon' => 'list', 'url' => array('admin')),
    array('label' => Yii::t('app', 'Crear') . ' ' . $model->label(), 'icon' => 'plus-sign', 'url' => array('create')),
    array('label' => Yii::t('app', 'Modificar') . ' ' . $model->label(), 'icon' => 'pencil', 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('app', 'Eliminar') . ' ' . $model->label(), 'icon' => 'remove', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('app', 'Realmente desea eliminar este item?'))),
);
?>

<?php

$this->widget(
        'bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'brand',
        'model',
        'movistar_a',
        'personal_a',
        'claro_a',
        'libre_a',
        'movistar_b',
        'personal_b',
        'claro_b',
        'libre_b',
        'bad_refurbish',
        'bad_irreparable',
)));
?>