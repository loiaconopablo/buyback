<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu=array(
    array('label'=>Yii::t('app', 'Listar') . ' ' . $model->label(2), 'icon' => 'list', 'url'=>array('admin')),
    array('label'=>Yii::t('app', 'Crear') . ' ' . $model->label(), 'icon'=>'plus-sign', 'url'=>array('create')),
    array('label'=>Yii::t('app', 'Modificar') . ' ' . $model->label(), 'icon' => 'pencil', 'url'=>array('update', 'id' => $model->id)),
    array('label'=>Yii::t('app', 'Eliminar') . ' ' . $model->label(), 'icon' => 'remove', 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm'=>Yii::t('app', 'Realmente desea eliminar este item?'))),
);
?>

<!--<h2><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h2>-->

<?php $this->widget(
    'bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
    'id',
    'company',
    'brand',
    'model',
    'locked_price',
    'unlocked_price',
    'broken_price',
    'created_at',
    'updated_at',
    'user_log',
    ),
    )
); ?>