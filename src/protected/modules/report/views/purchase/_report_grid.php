<?php count($data_provider->getData()); ?>
<?php $this->widget(
    'bootstrap.widgets.TbGridView',
    array(
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'id' => 'owner-purchase-grid',
    'dataProvider' => $data_provider,
    'filter' => $model,
    'rowCssClassExpression' => '
        ( Status::model()->findByAttributes(array("id" => $data->current_status_id))->constant_name )
    ',
    'template' => "{items}\n{pager}",
    'columns' => array(
        array(
            'name' => 'contract_number',
            'headerHtmlOptions' => array(
                //'title' => 'Ordenar por Nº de Contrato',
            ),
            'htmlOptions' => array(
                'class' => 'text-right',
            ),
        ),
        array(
            'name' => 'imei',
            'header' => Yii::t('app', 'IMEI'),
            'headerHtmlOptions' => array(
                //'title' => 'Ordenar por IMEI',
            ),
            'htmlOptions' => array(
                'class' => 'text-right',
            ),
        ),
        array(
            'name' => 'brand',
            'headerHtmlOptions' => array(
                //'title' => 'Ordenar por Marca',
            ),
        ),

        array(
            'name' => 'model',
            'headerHtmlOptions' => array(
               // 'title' => 'Ordenar por Modelo',
            ),
        ),
        array(
            'name' => 'purchase_price',
            'header' => Yii::t('app', 'Precio'),
            'headerHtmlOptions' => array(
               // 'title' => 'Ordenar por Precio',
            ),
            'value' => '"$ " . $data->purchase_price',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
        array(
            'name' => 'created_at',
            'header' => Yii::t('app', 'Fecha compra'),
            'value' => 'date("d-m-Y  .  h:i", strtotime($data->created_at))',
            'filter' => false,
            'htmlOptions' => array('style' => 'text-align: center'),
        ),
         array(
         	'name' => 'point_of_sale_id',
         	'value' => '$data->point_of_sale',
         	'header' => Yii::t('app', 'Comprado en...'),
			'filter' => CHtml::listData(Helper::getUniqueInDataprovider($data_provider, 't.point_of_sale_id'), 'point_of_sale_id', 'point_of_sale'),
        ),
         array(
            'name' => 'company_id',
            'value' => '$data->company',
            'header' => Yii::t('app', 'Empresa'),
			'filter' => CHtml::listData(Helper::getUniqueInDataprovider($data_provider, 't.company_id'), 'company_id', 'company'),
        ),
         //'user',
        array(
            'name' => 'user_create_id',
            'header' => Yii::t('app', 'Comprado por...'),
            'value' => '$data->user',
			'filter' => CHtml::listData(Helper::getUniqueInDataprovider($data_provider, 't.user_create_id'), 'user_create_id', 'user'),
        ),


        /**
         * BOTON VER INICIO
         */
        array(
            'class' => 'TbButtonColumn',
            'template' => '{view-purchase-admin}{view-purchase-company_admin}',
            'header' => 'Ver',
            'headerHtmlOptions' => array(
            	'style' => 'text-align: center',
            ),
            'buttons' => array
            (
                'view-purchase-admin' => array
                (
                    'label' => 'ver',
                    'visible' => 'Yii::app()->user->checkAccess("admin")',
                    'url' => 'Yii::app()->createUrl("/purchase/purchase/ownerview", array("id"=>$data->id))',
                    'options' => array(
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-purchase',
                        'class' => 'btn btn-small',
                        'title' => 'ver compra',
                    ),
                ),
                'view-purchase-company_admin' => array
                (
                    'label' => 'ver',
                    'visible' => 'Yii::app()->user->checkAccess("company_admin")',
                    'url' => 'Yii::app()->createUrl("/purchase/purchase/view", array("id"=>$data->id))',
                    'options' => array(
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-purchase',
                        'class' => 'btn btn-small',
                        'title' => 'ver compra',
                    ),
                ),
            ),
        ),
        /**
         * BOTON VER END
         */



        array(
        	'name' => 'last_dispatch_note_id',
        	'header' => Yii::t('app', 'Nota'),
        	'value' => '$data->last_dispatch_note',
			'filter' => CHtml::listData(Helper::getUniqueInDataprovider($model->search(), 't.last_dispatch_note_id'), 'last_dispatch_note_id', 'last_dispatch_note.dispatch_note_number'),
        ),
         array(
            'header' => Yii::t('app', 'F. recepción'),
            'value' => '$data->getLastRecivedDate()',
            'filter' => false,
            'htmlOptions' => array('style' => 'text-align: center'),
        ),
        
         array(
            'name' => 'last_location_id',
            'value' => '$data->last_location',
            'header' => Yii::t('app', 'Última ubicación'),
			'filter' => CHtml::listData(Helper::getUniqueInDataprovider($model->search(), 't.last_location_id'), 'last_location_id', 'last_location'),
        ),
        
    ),
    )
);?>