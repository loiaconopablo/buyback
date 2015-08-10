<?php count($data_provider->data); ?>
<?php $this->widget(
    'bootstrap.widgets.TbGridView',
    array(
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'id' => 'dispatch_notes_grid',
    'dataProvider' => $data_provider,
    'filter' => $model,
    'rowCssClassExpression' => '
        ( $data->getStatusName() )
    ',
    'template' => "{items}\n{pager}",
    'columns' => array(
        array(
            'name' => 'dispatch_note_number',
            'header' => Yii::t('app', 'Nº Nota'),
            'htmlOptions' => array('class' => 'span1 text-right'),
        ),
        array(
            'header' => 'Items',
            'value' => 'count(PurchaseStatus::model()->findAllByAttributes(array("dispatch_note_id" => $data->id, "status_id" => Status::PENDING_TO_SEND)))',
            'htmlOptions' => array(
                'class' => 'span1 text-right',
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
            'htmlOptions' => array('class' => 'text-center span2'),
            'filter' => false,
        ),
        array(
            'name' => 'user_create_id',
            'value' => '$data->user->username',
            'htmlOptions' => array('class' => 'span1'),
            'filter' => CHtml::listData(Helper::getUniqueInDataprovider($data_provider, 't.user_create_id'), 'user_create_id', 'user'),
        ),
        array(
            'class' => 'TbButtonColumn',
            'template' => '{view-dispatch-receiving}{view-dispatch}',
            'htmlOptions' => array('class' => 'text-center span1'),
            'buttons' => array(
                'view-dispatch-receiving' => array(
                    'visible' => 'DispatchNote::availableToReception($data)',
                    'label' => 'ver',
                    'url' => 'Yii::app()->createUrl("/dispatchnote/dispatchnote/receiving", array("id"=>$data->id, "receiving" => true))',
                    'options' => array(
                        'class' => 'btn btn-small',
                        'title' => 'ver y/o recibir o cancelar Nota de envío',
                    ),
                ),
                'view-dispatch' => array(
                    'visible' => '!DispatchNote::availableToReception($data)',
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