<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Manage'),
);

$this->menu = array(
    //array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'icon' => 'list', 'url'=>array('index')),
    //array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'icon' => 'plus-sign', 'url' => array('/headquarter/admin/admin')),
);

?>

<!--<h2><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2));?></h2>-->


<?php $this->widget(
    'bootstrap.widgets.TbGridView',
    array(
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'id' => 'dispatch_notes_grid',
    'dataProvider' => $model->expecting(),
    'filter' => $model,
    'rowCssClassExpression' => '
        ( DispatchNote::getRowClass($data->status) )
    ',
    'template' => "{items}\n{pager}",
    'columns' => array(
        array(
            'name' => 'dispatch_note_number',
            'header' => Yii::t('app', 'Nº Nota'),
            //'value' => '$data->dispatch_note_number . " - " . $data->status',
            'htmlOptions' => array('class' => 'nro-Nota de Envío-weight text-right'),
        ),
        array(
            'name' => 'source_id',
            'value' => '$data->point_of_sale->name',
            'header' => Yii::t('app', 'Origen'),
            'filter' => CHtml::listData($model->getExpecting(), 'point_of_sale.id', 'point_of_sale.name'),
        ),
        array(
            'header' => 'Items',
            'value' => 'count($data->purchases)',
            'htmlOptions' => array(
                'style' => 'text-align:center',
            ),
        ),
        array(
            'type' => 'raw',
            'header' => Yii::t('app', 'Comentario'),
            'filter' => CHtml::activeTextField($model, 'comment'),
            'value' => function ($data) {
                return '<a rel="popover" title="Nota de envío Nº ' . $data->dispatch_note_number . '" data-content="' . $data->comment . '">' . $data->comment . '</a>';
            },
            'htmlOptions' => array(
                'title' => $model->comment,
            ),
        ),
        array(
            'name' => 'created_at',
            'value' => 'date("d-m-Y", strtotime($data->created_at))',
            'htmlOptions' => array('style' => 'text-align: center'),
        ),
        array(
            'name' => 'user_create_id',
            'value' => '$data->user->username',
            'filter' => CHtml::listData($model->getExpecting(), 'user.id', 'user.username'),
        ),
        array(
            'class' => 'TbButtonColumn',
            'template' => '{view-dispatch-receiving}{view-dispatch}',
            'buttons' => array(
                'view-dispatch-receiving' => array(
                    'visible' => 'DispatchNote::availableToReception($data->status)',
                    'label' => 'ver',
                    'url' => 'Yii::app()->createUrl("/dispatchnote/dispatchnote/view", array("id"=>$data->id, "receiving" => true))',
                    'options' => array(
                        //'data-toggle' => 'modal',
                        //'data-target'=>'#modal-dispatch-note-receiving',
                        //'target' => '_blank',
                        'class' => 'btn btn-small',
                        'title' => 'ver y/o recibir o cancelar Nota de envío',
                    ),
                ),
                'view-dispatch' => array(
                    'visible' => '!DispatchNote::availableToReception($data->status)',
                    'label' => 'ver',
                    'url' => 'Yii::app()->createUrl("/dispatchnote/dispatchnote/view", array("id"=>$data->id))',
                    'options' => array(
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-dispatch-note',
                        'class' => 'btn btn-small',
                        'title' => 'ver Nota de envío',
                    ),
                ),
            ),
        ),
    ),
    )
);?>

<?php $this->renderPartial(
    '_search',
    array(
    'model' => $model,
    )
);?>

<?php $this->created_at_filter = true;?>

<!-- MODAL PARA VER Y RECIBIR O RECHAZAR PURCHASES O EL Nota de Envío COMPLETO -->
<!-- Por ahora no va a ser modal, es muy comoplejo y trae conflictos -->
<!--
<div id="modal-dispatch-note-receiving" class="modal hide fade" style="">
    <div class="modal-body"></div>
    <div class="modal-footer">
	    <a href="#" data-dismiss="modal" class="btn"><?php echo Yii::t('app', 'Close');?></a>
	    <a href="#" id="receiving_in_headquarter_dispatch" class="btn btn-primary"><?php echo Yii::t('app', 'Received');?></a>
    </div>
</div>
-->

<!-- MODAL SOLO PARA VER LO QUE TODAVIA NO ENVIARON -->
<div id="modal-dispatch-note" class="modal hide fade" style="">
    <div class="modal-body"></div>
    <div class="modal-footer">
	    <a href="#" data-dismiss="modal" class="btn"><?php echo Yii::t('app', 'Close');?></a>
    </div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/dispatch_note.js"></script>
