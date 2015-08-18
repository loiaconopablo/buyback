<?php

$this->menu = array(
    array('label' => Yii::t('app', 'Listar') . ' ' . $model->label(2), 'icon' => 'list', 'url' => array('admin')),
    array('label' => Yii::t('app', 'Crear') . ' ' . $model->label(), 'icon' => 'plus-sign', 'url' => array('create')),
);

?>

<!--<h2><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2));?></h2>-->



<?php $this->widget(
    'bootstrap.widgets.TbGridView', array(
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template' => "{items}\n{pager}",
    'columns' => array(
        array(
            'name' => 'month',
            'value' => 'DateHelper::getMonthName($data->month)',
        ),
        'year',
        'quantity',
        array(
            'class' => 'TbButtonColumn',
            'template' => '{update}{delete}',
        ),
    ),
    )
);?>