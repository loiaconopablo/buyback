<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Manage'),
);

$this->menu = array(
    //array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'icon' => 'list', 'url'=>array('index')),
    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'icon' => 'plus-sign', 'url' => array('/headquarter/admin/admin')),
);

?>

<!--<h2><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2));?></h2>-->


<?php $this->widget(
    'bootstrap.widgets.TbGridView',
    array(
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'id' => 'dispatch_notes_grid',
    'dataProvider' => $model->historyOwn(),
    'filter' => $model,
    'template' => "{items}\n{pager}",
    'columns' => array(
        array(
            'name' => 'dispatch_note_number',
            'header' => Yii::t('app', 'Nº Nota'),
            'htmlOptions' => array('class' => 'nro-Nota de Envío-weight text-right'),
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
            'header' => Yii::t('app', 'Comment'),
            'filter' => CHtml::activeTextField($model, 'comment'),
            'value' => function ($data) {
                return '<a rel="popover" title="Nota de envío Nº ' . $data->dispatch_note_number . '" data-content="' . $data->comment . '">' . $data->comment . '</a>';
            },
            'htmlOptions' => array(
                'title' => $model->comment,
            ),
        ),
        // array(
        // 	'name' => 'destination',
        // 	'header' => Yii::t('app', 'Destino'),
        // ),
        array(
            'name' => 'created_at',
            'value' => 'date("d-m-Y", strtotime($data->created_at))',
            'htmlOptions' => array('style' => 'text-align: center'),
        ),
        array(
            'name' => 'user_create_id',
            'value' => '$data->user->username',
            'filter' => CHtml::listData($model->getOwnHistory(), 'user.id', 'user.username'),
        ),
        array(
            'class' => 'TbButtonColumn',
            'template' => '{view-dispatch}',
            'buttons' => array
            (
                'view-dispatch' => array
                (
                    'label' => 'ver',
                    'url' => 'Yii::app()->createUrl("/dispatchnote/dispatchnote/view", array("id"=>$data->id))',
                    'options' => array(
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-dispatch-note',
                        'class' => 'btn btn-small',
                        'title' => 'ver y/o despachar Nota de Envío',
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

<?php $this->date_filter = true;?>

<div id="modal-dispatch-note" class="modal hide fade" style="">
	<div class="modal-body"></div>
	<div class="modal-footer">
	    <a href="#" data-dismiss="modal" class="btn"><?php echo Yii::t('app', 'Close');?></a>
	</div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/dispatch_note.js"></script>
