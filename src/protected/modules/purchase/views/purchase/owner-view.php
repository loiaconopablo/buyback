
<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
    'data' => $model,
    'attributes' => array(
        'contract_number',
        array(
            'label' => 'CAE',
            'value' => $model->cae,
        ),
        'imei',
        'brand',
        'model',
        'carrier',
        array(
            'label' => 'Precio de compra',
            'value' => "$ " . $model->purchase_price,
        ),
        'company',
        'point_of_sale',
        'user',
        array(
            'label' => Yii::t('app', 'Cliente'),
            'value' => $model->seller,
        ),
        array(
            'name' => 'created_at',
            'value' => date("d-m-Y  .  h:i", strtotime($model->created_at)),
        ),
    ),
    )
);?>
<!-- IMPRIMIR CONTRATO -->
<?php echo TbHtml::linkButton(Yii::t('app', 'Imprimir contrato'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'block' => true, 'url' => array('/purchase/contract/generate', 'purchase_id' => $model->id), 'target' => '_blank'));?>
<!-- ANULAR COMPRA -->
<?php if (($model->current_status_id != Status::CANCELLED) && ($model->current_status_id != Status::CANCELLATION)): ?>
    <?php 
        echo TbHtml::linkButton(Yii::t('app', 'Anular compra'),
            array(
             'color' => TbHtml::BUTTON_COLOR_DANGER, 
             'size' => TbHtml::BUTTON_SIZE_LARGE, 
             'block' => true, 
             'id' => 'cancel_purchase',
            )
        );
    ?>
<?php endif; ?>
<!-- VER ANULACION SI YA ESTA ANULADA -->
<?php if ($model->current_status_id == Status::CANCELLED): ?>
    <?php 
        echo TbHtml::linkButton(Yii::t('app', 'Ver anulación'),
            array(
             'color' => TbHtml::BUTTON_COLOR_WARNING, 
             'size' => TbHtml::BUTTON_SIZE_LARGE, 
             'block' => true, 
             'target' => '_blank',
             'url' => $this->createUrl('/purchase/contract/generatecancellationcontract', array('purchase_id' => $model->associate_purchase->id)),
            )
        );
    ?>
<?php endif; ?>
<!-- IMPRIMIR ANULACION -->
<?php if ($model->current_status_id == Status::CANCELLATION): ?>
    <?php 
        echo TbHtml::linkButton(Yii::t('app', 'Imprimir anulación'),
            array(
             'color' => TbHtml::BUTTON_COLOR_INFO, 
             'size' => TbHtml::BUTTON_SIZE_LARGE, 
             'block' => true, 
             'target' => '_blank',
             'url' => $this->createUrl('/purchase/contract/generatecancellationcontract', array('purchase_id' => $model->id)),
            )
        );
    ?>
<?php endif; ?>


<?php foreach ($model->purchase_statuses as $status) : ?>
	<div class="well <?php echo $status->status->constant_name; ?>">
        
    <?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
    'data' => $status,
    'attributes' => array(
    'status',
    array(
        'label' => Yii::t('app', 'Fecha'),
        'value' => date("d-m-Y  .  h:i", strtotime($model->created_at)),
        ),
    'user',
    'point_of_sale',
    'dispatch_note',
    'comment',
    ),
    )
);?>
	</div>
<?php endforeach; ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array('id' => 'purchase_form')); ?>
    <?php echo CHtml::hiddenField('purchase_id', $model->id, array('id' => 'purchase_id')); ?>
<?php $this->endWidget();?>