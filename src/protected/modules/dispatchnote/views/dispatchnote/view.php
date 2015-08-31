<div class="well">
	<h4><?php echo Yii::t('app', 'Nota de envío N°'); ?> <?php echo $dispatch_note->dispatch_note_number;?></h4>
</div>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array('id' => 'dispatch_form')); ?>
    <?php echo CHtml::hiddenField('dispatch_note_id', $dispatch_note->id, array('id' => 'dispatch_note_id')); ?>
<?php $this->endWidget();?>

<h4><?php echo Yii::t('app', 'Origen'); ?></h4>
<?php 
    $this->widget(
        'bootstrap.widgets.TbDetailView', array(
            'data' => $dispatch_note,
            'attributes' => array(
                array(
                    'label' => Yii::t('app', 'Empresa'),
                    'value' => $dispatch_note->point_of_sale->company->name,
                ),
                array(
                    'label' => Yii::t('app', 'Punto de venta'),
                    'value' => $dispatch_note->point_of_sale->name,
                ),
                array(
                    'label' => Yii::t('app', 'Provincia'),
                    'value' => $dispatch_note->point_of_sale->province,
                ),
                array(
                    'label' => Yii::t('app', 'Localidad'),
                    'value' => $dispatch_note->point_of_sale->locality,
                ),
                array(
                    'label' => Yii::t('app', 'Dirección'),
                    'value' => $dispatch_note->point_of_sale->address,
                ),
            ),
        )
    );
?>

<h4><?php echo Yii::t('app', 'Destino'); ?></h4>
<?php 
    $this->widget(
        'bootstrap.widgets.TbDetailView', array(
        'data' => $dispatch_note->destination,
            'attributes' => array(
                array(
                    'label' => Yii::t('app', 'Punto de venta'),
                    'value' => $dispatch_note->destination->name,
                ),
                array(
                    'label' => Yii::t('app', 'Provincia'),
                    'value' => $dispatch_note->destination->province,
                ),
                array(
                    'label' => Yii::t('app', 'Localidad'),
                    'value' => $dispatch_note->destination->locality,
                ),
                array(
                    'label' => Yii::t('app', 'Dirección'),
                    'value' => $dispatch_note->destination->address,
                ),
            ),
        )
    );
?>

<h4><?php echo Yii::t('app', 'Detalle'); ?></h4>
<?php 
    $this->widget(
        'bootstrap.widgets.TbGridView', array(
            'type' => TbHtml::GRID_TYPE_BORDERED,
            'dataProvider' => $dispatch_note->purchasesDataProvider(),
            'template' => "{items}\n{pager}",
            'columns' => array(
                array(
                    'header' => Yii::t('app', 'N° Contrato'),
                    'name' => 'contract_number',
                ),
                array(
                    'header' => Yii::t('app', 'Marca'),
                    'name' => 'brand',
                ),
                array(
                    'header' => Yii::t('app', 'Modelo'),
                    'name' => 'model',
                ),
                array(
                    'header' => Yii::t('app', 'IMEI'),
                    'name' => 'imei',
                ),
                array(
                    'header' => Yii::t('app', 'Usuario'),
                    'name' => 'user',
                ),
            ),
        )
    );
?>

<?php if (strlen(trim($dispatch_note->comment))) : ?>
	<div class="well">
    <?php echo $dispatch_note->comment; ?>
	</div>
<?php endif; ?>

<?php if ($dispatch_note->status != DispatchNote::CANCELLED) : ?>
    <?php echo TbHtml::linkButton(Yii::t('app', 'Imprimir Nota de Envío'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'block' => true, 'url' => array('generatepdf', 'id' => $dispatch_note->id), 'target' => '_blank'));?>
<?php endif; ?>