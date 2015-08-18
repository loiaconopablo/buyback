<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu=array(
    array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'icon' => 'list', 'url'=>array('admin')),
    array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'icon'=>'plus-sign', 'url'=>array('create')),
    array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'icon' => 'pencil', 'url'=>array('update', 'id' => $model->id)),
    //array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'icon' => 'remove', 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm'=>'Are you sure you want to delete this item?')),
    //array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'icon' => 'th-list', 'url'=>array('admin')),
);
?>

<!--<h2><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h2>-->

<?php $this->widget(
    'bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
    'id',
    'company_code',
    'name',
    'social_reason',
    'cuit',
    'address',
    'province',
    'locality',
    'phone',
    array(
    'label'=>'mail',
    'type' => 'raw',
    'value'=>CHtml::mailto($model->mail, $model->mail),
    ),
    'percent_fee',
    null,
    'reference_name',
    'reference_phone',
    array(
    'label'=> Yii::t('app', 'Mail'),
    'type' => 'raw',
    'value'=>CHtml::mailto($model->reference_mail, $model->reference_mail),
    ),
    null,
    'created_at',
    'updated_at',
    array(
            'name' => 'user_update_id',
            'type' => 'raw',
            'value' => $model->user_log !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->user_log)), array('user/view', 'id' => GxActiveRecord::extractPkValue($model->user_log, true))) : null,
            ),
    ),
    )
); ?>