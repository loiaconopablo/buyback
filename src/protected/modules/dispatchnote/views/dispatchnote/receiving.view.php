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

<div class="well">
    <h4>Nota de envío Nº <?php echo $dispatch_note->dispatch_note_number;?></h4>
</div>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array('id' => 'dispatch_form'));?>
<?php echo CHtml::hiddenField('dispatch_note_id', $dispatch_note->id, array('id' => 'dispatch_note_id'));?>
<?php $this->endWidget();?>

<?php 
    $this->widget(
        'bootstrap.widgets.TbDetailView', array(
        'data' => $dispatch_note->company,
        'attributes' => array(
            array(
                'label' => Yii::t('app', 'Source'),
                'value' => $dispatch_note->company->name . ' - ' . $dispatch_note->point_of_sale->name,
            ),
            array(
                'label' => Yii::t('app', 'Destination'),
                'value' => $dispatch_note->destination->name,
            ),
        ),
        )
);?>

<h4>Detalle</h4>

<!-- ITEMS TABLE  -->
<?php $form = $this->beginWidget('CActiveForm', array('id' => 'receiving_form'));?>

<?php 
    $this->widget(
        'bootstrap.widgets.TbGridView', array(
        'type' => TbHtml::GRID_TYPE_BORDERED,
        'dataProvider' => $dispatch_note->purchasesDataProvider(),
        'template' => "{items}",
        'columns' => array(
            array(
                //'header'=>'html',
                'id' => 'dispatch_selected',
                'class' => 'CCheckBoxColumn',
                'checked' => '$data->current_status_id == Status::SENT',
                'disabled' => '$data->current_status_id != Status::SENT && $data->current_status_id != Status::PENDING_TO_BE_RECEIVED',
                'selectableRows' => '50',
                'selectableRows' => 2,
                'value' => '$data->id',
                //'headerTemplate'=>'<label>{item}<span></span></label>',
            ),
            array(
                'header' => Yii::t('app', 'Nº Contrato'),
                'value' => '$data->contract_number',
            ),
            array(
                'header' => Yii::t('app', 'Marca'),
                'value' => '$data->brand',
            ),
            array(
                'header' => Yii::t('app', 'Modelo'),
                'value' => '$data->model',
            ),
            array(
                'header' => Yii::t('app', 'IMEI'),
                'value' => '$data->imei',
            ),
            array(
                'header' => Yii::t('app', 'Usuario'),
                'value' => '$data->user',
            ),

            array(
                'class' => 'TbButtonColumn',
                'template' => '{cancelled}{received}',
                'buttons' => array
                (
                    'cancelled' => array(
                        'visible' => '$data->current_status_id == Status::CANCELLED',
                        'label' => 'anulado',
                        'options' => array(
                            'class' => 'label label-important',
                        ),
                    ),
                    'received' => array(
                        'visible' => '$data->current_status_id == Status::RECEIVED',
                        'label' => 'recibido',
                        'options' => array(
                            'class' => 'label label-success',
                        ),
                    ),
                ),
            ),
        ),
    )
);?>

<!-- ITEMS TABLE end -->

<?php if (strlen(trim($dispatch_note->comment))) : ?>
    <div class="well">
    <?php echo $dispatch_note->comment;?>
    </div>
<?php endif; ?>

<div class="alert alert-success">
    <?php
    echo TbHtml::submitButton(Yii::t('app', 'Recibir Nota de Envío'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'class' => 'checks-submit', 'data-checkcolumn' => 'dispatch_selected'));
    $this->endWidget();
?>

    <?php echo TbHtml::linkButton('Volver', array('class' => 'btn btn-large pull-right', 'url' => array('/headquarter/dispatchnote/expecting')));?>
</div>
</br>
</br>
</br>
<?php echo TbHtml::linkButton(Yii::t('app', 'Imprimir Nota de Envío'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'block' => true, 'url' => array('generatepdf', 'id' => $dispatch_note->id), 'target' => '_blank'));?>
