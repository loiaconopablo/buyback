<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Administrar'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Crear') . ' ' . $model->label(), 'icon' => 'plus-sign', 'url' => array('create')),
    array('label' => Yii::t('app', 'Listar') . ' ' . $model->label(2), 'icon' => 'list', 'url' => array('index')),
    array('label' => Yii::t('app', 'Importar') . ' ' . $model->label(2), 'icon' => 'file', 'url' => array('upload')),
    array('label' => Yii::t('app', 'Eliminar todo') . ' ' . $model->label(2), 'icon' => 'remove', 'url' => array('truncate')),
);

?>

<!--<h2><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2));?></h2>-->



<?php $this->widget(
    'bootstrap.widgets.TbGridView',
    array(
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template' => "{items}\n{pager}",
    'columns' => array(
        'brand',
        'model',
        array(
            'name' => 'locked_price',
            'value' => '$data->locked_price',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
        array(
            'name' => 'unlocked_price',
            'value' => '$data->unlocked_price',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
        array(
            'name' => 'broken_price',
            'value' => '$data->broken_price',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
        array(
            'name' => 'company_id',
            'value' => '$data->company',
            'header' => Yii::t('app', 'Empresa'),
            'filter' => CHtml::listData(Helper::getUniqueInDataprovider($model->search(), 't.company_id'), 'company_id', 'company'),
        ),
        //          array(
        //  'name'=>'user_update_id',
        //  'value'=>'GxHtml::valueEx($data->user_log)',
        //  'filter'=>GxHtml::listDataEx(User::model()->getListData()),
        // ),
        /*
        'created_at',
        'updated_at',
        'user_update_id',
        */
        array(
            'class' => 'TbButtonColumn',
        ),
    ),
    )
);?>

<?php echo TbHtml::button(
    Yii::t('app', 'Busqueda avanzada'),
    array(
    'style' => TbHtml::BUTTON_COLOR_PRIMARY,
    'data-toggle' => 'modal',
    'data-target' => '#searchModal',
    )
);?>

<?php $this->renderPartial(
    '_search',
    array(
    'model' => $model,
    )
);?>
