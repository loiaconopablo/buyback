<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu=array(
    array('label'=>Yii::t('app', 'Listar') . ' ' . $model->label(2), 'icon' => 'list', 'url'=>array('index')),
    array('label'=>Yii::t('app', 'Crear') . ' ' . $model->label(), 'icon'=>'plus-sign', 'url'=>array('create')),
    array('label'=>Yii::t('app', 'Modificar') . ' ' . $model->label(), 'icon' => 'pencil', 'url'=>array('update', 'id' => $model->id)),
    array('label'=>Yii::t('app', 'Eliminar') . ' ' . $model->label(), 'icon' => 'remove', 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>Yii::t('app', 'Administrar') . ' ' . $model->label(2), 'icon' => 'th-list', 'url'=>array('admin')),
);
?>

<!--<h2><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h2>-->

<?php $this->widget(
    'bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
    'id',
    'name',
    'dni',
    'created_at',
    'updated_at',
    'user_update_id',
    ),
    )
); ?>

<h2><?php echo GxHtml::encode($model->getRelationLabel('purchase')); ?></h2>
<?php
    echo GxHtml::openTag('ul');
foreach($model->purchase as $relatedModel) {
    echo GxHtml::openTag('li');
    echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('purchase/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
    echo GxHtml::closeTag('li');
}
    echo GxHtml::closeTag('ul');
?>