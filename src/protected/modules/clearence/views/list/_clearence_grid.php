<?php count($data_provider->data); ?>
<?php $this->widget(
    'bootstrap.widgets.TbGridView',
    array(
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'id' => 'dispatch_notes_grid',
    'dataProvider' => $data_provider,
    'filter' => $model,
    'template' => "{items}\n{pager}",
    'columns' => array(
        array(
            'name' => 'id',
            'header' => Yii::t('app', 'Nº Liquidación'),
            'htmlOptions' => array('class' => 'span1 text-right'),
        ),
        array(
            'header' => Yii::t('app', 'Items'),
            'value' => 'count(Purchase::model()->findAllByAttributes(array("clearence_id" => $data->id)))',
            'htmlOptions' => array(
                'class' => 'span1 text-right',
            ),
        ),
        
        array(
            'name' => 'total_paid',
            'header' => Yii::t('app', 'Reintegro'),
            'value' => '"$ " . $data->total_paid',
            'htmlOptions' => array('class' => 'text-right span2'),
        ),

        array(
            'name' => 'paid_comision',
            'header' => Yii::t('app', 'Comisión'),
            'value' => '"$ " . $data->paid_comision',
            'htmlOptions' => array('class' => 'text-right span2'),
        ),

        array(
            'name' => 'error_allowance',
            'header' => Yii::t('app', 'Ajuste'),
            'value' => '"$ " . $data->error_allowance',
            'htmlOptions' => array('class' => 'text-right span2'),
        ),

        array(
            'name' => 'total_comision',
            'header' => Yii::t('app', 'Total comisión'),
            'value' => '"$ " . $data->total_comision',
            'htmlOptions' => array('class' => 'text-right span2'),
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
            'template' => '{pay}',
            'htmlOptions' => array('class' => 'text-center span1'),
            'buttons' => array(
                'pay' => array(
                    'label' => Yii::t('app', 'Ver'),
                    'url' => 'Yii::app()->createUrl("/clearence/purchase/view", array("id"=>$data->id))',
                    'options' => array(
                        'class' => 'btn btn-small',
                        'title' => Yii::t('app', 'Ver liquidación'),
                    ),
                ),
            ),
        ),
    ),
    )
);?>