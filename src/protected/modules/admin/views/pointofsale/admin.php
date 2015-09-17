<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Manage'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Listar') . ' ' . $model->label(2), 'icon' => 'list', 'url' => array('index')),
    array('label' => Yii::t('app', 'Crear') . ' ' . $model->label(), 'icon' => 'plus-sign', 'url' => array('create')),
    array('label' => Yii::t('app', 'Alta Masiva'), 'icon' => 'file', 'url' => array('multicreate')),
);
?>

<!--<h2><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h2>-->



<?php
$data_provider = $model->search();
$this->widget(
        'bootstrap.widgets.TbGridView', array(
    'type' => TbHtml::GRID_TYPE_BORDERED,
//    'dataProvider' => $model->search(),
    'dataProvider' => $data_provider,
    'filter' => $model,
    'template' => "{items}\n{pager}",
    'columns' => array(
        'name',
        array(
            'name' => 'headquarter_id',
            'value' => 'GxHtml::valueEx($data->headquarter)',
            'filter' => GxHtml::listDataEx(PointOfSale::model()->findAllAttributes(null, true)),
        ),
        array(
            'name' => 'company_id',
            'value' => 'GxHtml::valueEx($data->company)',
            'filter' => GxHtml::listDataEx(Company::model()->findAllAttributes(null, true)),
        ),
        'reference_phone',
        // array(
        // 	'name' => 'user_update_id',
        // 	'value' => 'GxHtml::valueEx($data->user_log)',
        // 	'filter' => GxHtml::listDataEx(User::model()->getListData()),
        // ),
        /*
          'province',
          'locality',
          'phone',
          'mail',
          'created_at',
          'updated_at',
          'user_update_id',
         */
        array(
            'class' => 'TbButtonColumn',
            'template' => '{view}{update}{delete}',
            'buttons' => array(
                'delete' => array(
                    'visible' => '!$data->is_owner || Yii::app()->user->checkAccess("superuser")',
                ),
            ),
        ),
    ),
        )
);
?>


<?php
$this->renderPartial(
        '_search', array(
    'model' => $model,
        )
);
?>