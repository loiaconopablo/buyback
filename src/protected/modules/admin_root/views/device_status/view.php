<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu=array(
    array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'icon' => 'list', 'url'=>array('index')),
    array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'icon'=>'plus-sign', 'url'=>array('create')),
    array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'icon' => 'pencil', 'url'=>array('update', 'id' => $model->id)),
    array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'icon' => 'remove', 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm'=>Yii::t('app', 'Realmente desea eliminar este item?'))),
    array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'icon' => 'th-list', 'url'=>array('admin')),
);
?>

<!--<h2><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h2>-->

<?php $this->widget(
    'bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
    'id',
    'slug',
    'name',
    'created_at',
    'updated_at',
    'user_update_id',
    ),
    )
); ?>

<h2><?php echo GxHtml::encode($model->getRelationLabel('contract')); ?></h2>
<?php
    echo GxHtml::openTag('ul');
foreach($model->contract as $relatedModel) {
    echo GxHtml::openTag('li');
    echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('contract/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
    echo GxHtml::closeTag('li');
}
    echo GxHtml::closeTag('ul');
?>