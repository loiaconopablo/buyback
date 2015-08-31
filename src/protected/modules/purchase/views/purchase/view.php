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

<?php if (Yii::app()->user->point_of_sale_id == $model->point_of_sale_id): ?>
    <?php echo TbHtml::linkButton(Yii::t('app', 'Imprimir contrato'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'block' => true, 'url' => array('/purchase/contract/generate', 'purchase_id' => $model->id), 'target' => '_blank'));?>
<?php endif; ?>