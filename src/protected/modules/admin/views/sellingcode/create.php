<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Crear'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Crear') . ' ' . $model->label(), 'icon' => 'plus-sign', 'url' => array('create')),
    array('label' => Yii::t('app', 'Listar') . ' ' . $model->label(2), 'icon' => 'list', 'url' => array('admin')),
    array('label' => Yii::t('app', 'Importar') . ' ' . $model->label(2), 'icon' => 'file', 'url' => array('upload')),
    array('label' => Yii::t('app', 'Eliminar') . ' ' . $model->label(2), 'icon' => 'remove', 'url' => array('truncate'), 'linkOptions' => array('onClick'=>'return confirm("¿Desea eliminar todos los registros?");' )));
?>

<?php

$this->renderPartial(
        '_form', array(
    'model' => $model,
    'buttons' => 'create'));
?>