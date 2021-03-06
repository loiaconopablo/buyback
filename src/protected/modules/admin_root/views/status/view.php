<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu=array(
    array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'icon' => 'list', 'url'=>array('admin')),
    array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'icon'=>'plus-sign', 'url'=>array('create')),
    array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'icon' => 'pencil', 'url'=>array('update', 'id' => $model->id)),
    array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'icon' => 'remove', 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm'=>Yii::t('app', 'Realmente desea eliminar este item?'))),
);
?>

<!--<h2><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h2>-->

<?php $this->widget(
    'bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
    'id',
    'name',
    'created_at',
    'updated_at',
    'user_log',
    ),
    )
); ?>

<h2><?php echo GxHtml::encode($model->getRelationLabel('purchase_status')); ?></h2>
<?php
    echo GxHtml::openTag('ul');
foreach($model->purchase_status as $relatedModel) {
    echo GxHtml::openTag('li');
    echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('purchaseStatus/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
    echo GxHtml::closeTag('li');
}
    echo GxHtml::closeTag('ul');
?>