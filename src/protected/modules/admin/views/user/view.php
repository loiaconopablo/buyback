<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Listar') . ' ' . $model->label(2), 'icon' => 'list', 'url' => array('admin')),
    array('label' => Yii::t('app', 'Crear') . ' ' . $model->label(), 'icon' => 'plus-sign', 'url' => array('create')),
    array('label' => Yii::t('app', 'Modificar') . ' ' . $model->label(), 'icon' => 'pencil', 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('app', 'Eliminar') . ' ' . $model->label(), 'icon' => 'remove', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);
?>

<!--<h2><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h2>-->

<?php
$this->widget(
        'bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        array(
            'name' => 'point_of_sale',
            'type' => 'raw',
            'value' => $model->point_of_sale !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->point_of_sale)), array('pointOfSale/view', 'id' => GxActiveRecord::extractPkValue($model->point_of_sale, true))) : null,
        ),
        array(
            'name' => 'company',
            'type' => 'raw',
            'value' => $model->company !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->company)), array('company/view', 'id' => GxActiveRecord::extractPkValue($model->company, true))) : null,
        ),
        'username',
        'password_generated',
        'mail',
        'employee_identification',
        'created_at',
        'updated_at',
        'last_login',
        'is_password_validated',
    ),
        )
);
?>