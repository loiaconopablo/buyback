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
            'name' => 'company_id',
            'value' => '$data->company',
            'header' => Yii::t('app', 'Empresa'),
            'filter' => CHtml::listData(Helper::getUniqueInDataprovider($data_provider, 't.company_id'), 'company_id', 'company'),
        ),
        array(
            'header' => Yii::t('app', 'Items'),
            'value' => 'count(Purchase::model()->findAllByAttributes(array("last_dispatch_note_id" => $data->id)))',
            'htmlOptions' => array(
                'class' => 'span1 text-right',
            ),
        ),
        array(
            'header' => Yii::t('app', 'Aprobados'),
            'value' => 'count(Purchase::model()->findAllByAttributes(array("last_dispatch_note_id" => $data->id, "current_status_id" => Status::APPROVED)))',
            'htmlOptions' => array(
                'class' => 'span1 text-right',
            ),
        ),
        array(
            'header' => Yii::t('app', 'Recotizados'),
            'value' => 'count(Purchase::model()->findAllByAttributes(array("last_dispatch_note_id" => $data->id, "current_status_id" => Status::REQUOTED)))',
            'htmlOptions' => array(
                'class' => 'span1 text-right',
            ),
        ),
        array(
            'header' => Yii::t('app', 'Rechazados'),
            'value' => 'count(Purchase::model()->findAllByAttributes(array("last_dispatch_note_id" => $data->id, "current_status_id" => Status::REJECTED)))',
            'htmlOptions' => array(
                'class' => 'span1 text-right',
            ),
        ),
        array(
            'header' => Yii::t('app', 'Recibidas'),
            'value' => 'count(Purchase::model()->findAllByAttributes(array("last_dispatch_note_id" => $data->id, "current_status_id" => Status::RECEIVED)))',
            'htmlOptions' => array(
                'class' => 'span1 text-right',
            ),
        ),
        array(
            'header' => Yii::t('app', 'Pendientes'),
            'value' => 'count(Purchase::model()->findAllByAttributes(array("last_dispatch_note_id" => $data->id, "current_status_id" => Status::PENDING_TO_BE_RECEIVED)))',
            'htmlOptions' => array(
                'class' => 'span1 text-right',
            ),
        ),
        array(
            'header' => Yii::t('app', 'Canceladas'),
            'value' => 'count(Purchase::model()->findAllByAttributes(array("last_dispatch_note_id" => $data->id, "current_status_id" => Status::CANCELLED)))',
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
            'class' => 'TbButtonColumn',
            'template' => '{pay}',
            'htmlOptions' => array('class' => 'text-center span1'),
            'buttons' => array(
                'pay' => array(
                    'label' => Yii::t('app', 'Liquidar'),
                    'visible' => '$data->isOnlyCompany()',
                    'url' => 'Yii::app()->createUrl("/clearence/purchase/clear", array("id"=>$data->id))',
                    'options' => array(
                        'class' => 'btn btn-small',
                        'title' => Yii::t('app', 'Liquidar equipos de la nota de envío'),
                    ),
                ),
            ),
        ),
    ),
    )
);?>