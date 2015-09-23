<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Administrar'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Crear') . ' ' . $model->label(), 'icon' => 'plus-sign', 'url' => array('create')),
    array('label' => Yii::t('app', 'Listar') . ' ' . $model->label(2), 'icon' => 'list', 'url' => array('admin')),
    array('label' => Yii::t('app', 'Importar') . ' ' . $model->label(2), 'icon' => 'file', 'url' => array('upload')),
    array('label' => Yii::t('app', 'Eliminar') . ' ' . $model->label(2), 'icon' => 'remove', 'url' => array('truncate')));

?>
<?php

$this->widget(
        'bootstrap.widgets.TbGridView', array(
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template' => "{items}\n{pager}",
    'columns' => array(
        'brand',
        'model',
        'movistar_a',
        'personal_a',
        'claro_a',
        'libre_a',
        'movistar_b',
        'personal_b',
        'claro_b',
        'libre_b',
        'bad_refurbish',
        'bad_irreparable',
        array(
            'class' => 'TbButtonColumn',
        ),
    ),
        )
);
?>

<?php

echo TbHtml::button(
        Yii::t('app', 'Busqueda avanzada'), array(
    'style' => TbHtml::BUTTON_COLOR_PRIMARY,
    'data-toggle' => 'modal',
    'data-target' => '#searchModal'
));
?>

<?php

$this->renderPartial(
    '_search', array(
    'model' => $model,
        )
);
?>
