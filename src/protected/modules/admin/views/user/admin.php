<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Administrar'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Listar') . ' ' . $model->label(2), 'icon' => 'list', 'url' => array('index')),
    array('label' => Yii::t('app', 'Crear') . ' ' . $model->label(), 'icon' => 'plus-sign', 'url' => array('create')),
);

?>

<!--<h2><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2));?></h2>-->



<?php $this->widget(
    'bootstrap.widgets.TbGridView', array(
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'dataProvider' => $model->admin(),
    'filter' => $model,
    'template' => "{items}\n{pager}",
    'columns' => array(
        array(
            'name' => 'id',
            'value' => '$data->id',
            'headerHtmlOptions' => array('width' => '10'),
        ),
        'username',
        array(
            'name' => 'point_of_sale_id',
            'value' => 'GxHtml::valueEx($data->point_of_sale)',
            'filter' => GxHtml::listDataEx(PointOfSale::model()->findAllAttributes(null, true)),
        ),
        array(
            'name' => 'company_id',
            'value' => 'GxHtml::valueEx($data->company)',
            'filter' => GxHtml::listDataEx(Company::model()->findAllAttributes(null, true)),
        ),
        /*'password',*/
        'mail',
        // array(
        // 	'name'=>'user_update_id',
        // 	'value'=>'GxHtml::valueEx($data->user_log)',
        // 	'filter'=>GxHtml::listDataEx(User::model()->getListData()),
        // ),
        /*
        'employee_identification',
        'created_at',
        'updated_at',
        'last_login',
        'user_update_id',
        'is_password_validated',
        */
        array(
            'class' => 'TbButtonColumn',
        ),
    ),
    )
);?>

<?php echo TbHtml::button(
    Yii::t('app', 'Busqueda avanzada'), array(
    'style' => TbHtml::BUTTON_COLOR_PRIMARY,
    'data-toggle' => 'modal',
    'data-target' => '#searchModal',
    )
);?>

<?php $this->renderPartial(
    '_search', array(
    'model' => $model,
    )
);?>