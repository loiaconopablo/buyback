
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

<?php foreach ($model->purchase_statuses as $status) :
?>
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
    'dispatch_note_id',
    'comment',
    ),
    )
);?>
	</div>
<?php
endforeach;?>

<!--
<?php echo CHtml::hiddenField('purchase-id', $model->id);?>
<?php echo CHtml::label(Yii::t('app', 'Comentario'), 'purchase-comment');?>
<?php echo CHtml::textarea('comment', null, array('id' => 'purchase-comment', 'class' => 'purchase-comment', 'style' => 'width:100%; height: 70px'));?>
-->
