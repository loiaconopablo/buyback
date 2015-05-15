<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Buy'), 'icon' => 'plus-sign', 'url' => array('/retail/purchase/imei')),
    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'icon' => 'list', 'url' => array('index')),
);
?>

<!--<h2><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model));?></h2>-->

<?php $this->widget(
    'bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'contract_number',
        'brand',
        'model',
        'imei',
        'carrier',
        array(
            'label' => 'Precio de compra',
            'value' => "$ " . $model->purchase_price,
        ),
        'company',
        'point_of_sale',
        'headquarter',
        'user',
        'seller',
        'created_at',
    ),
    )
);?>

<?php echo TbHtml::linkButton(Yii::t('app', 'Imprimir contrato'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'block' => true, 'url' => array('/retail/purchase/generatecontract', 'purchase_id' => $model->id), 'target' => '_blank'));?>