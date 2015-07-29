<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Manage'),
);

$this->menu = array(
  //  array('label' => Yii::t('app', 'Buy'), 'icon' => 'plus-sign', 'url' => array('/retail/purchase/imei')),
);

?>


<?php $this->widget(
    'bootstrap.widgets.TbGridView',
    array(
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'id' => 'owner-purchase-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'rowCssClassExpression' => '
        ( Status::model()->findByAttributes(array("id" => $data->current_status_id))->constant_name )
    ',
    'template' => "{items}\n{pager}",
    'columns' => array(
        array(
            'name' => 'contract_number',
            'headerHtmlOptions' => array(
                'title' => 'Ordenar por Nº de Contrato',
            ),
            'htmlOptions' => array(
                'class' => 'text-right',
            ),
        ),
        array(
            'name' => 'imei',
            'header' => Yii::t('app', 'IMEI'),
            'headerHtmlOptions' => array(
                'title' => 'Ordenar por IMEI',
            ),
            'htmlOptions' => array(
                'class' => 'text-right',
            ),
        ),
        array(
            'name' => 'brand',
            'headerHtmlOptions' => array(
                'title' => 'Ordenar por Marca',
            ),
        ),

        array(
            'name' => 'model',
            'headerHtmlOptions' => array(
                'title' => 'Ordenar por Modelo',
            ),
        ),
        array(
            'name' => 'purchase_price',
            'header' => 'Precio',
            'headerHtmlOptions' => array(
                'title' => 'Ordenar por Precio',
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
			'filter' => CHtml::listData(Helper::getUniqueInDataprovider($model->search(), 't.point_of_sale_id'), 'point_of_sale_id', 'point_of_sale'),
        ),
         array(
            'name' => 'company_id',
            'value' => '$data->company',
            'header' => Yii::t('app', 'Empresa'),
			'filter' => CHtml::listData(Helper::getUniqueInDataprovider($model->search(), 't.company_id'), 'company_id', 'company'),
        ),
         //'user',
        array(
            'name' => 'user_create_id',
            'header' => 'Comprado por...',
            'value' => '$data->user',
			'filter' => CHtml::listData(Helper::getUniqueInDataprovider($model->search(), 't.user_create_id'), 'user_create_id', 'user'),
        ),


        /**
         * BOTON VER INICIO
         */
        array(
            'class' => 'TbButtonColumn',
            'template' => '{view-purchase}',
            'header' => 'Ver',
            'headerHtmlOptions' => array(
            	'style' => 'text-align: center',
            ),
            'buttons' => array
            (
                'view-purchase' => array
                (
                    'label' => 'ver',
                    'url' => 'Yii::app()->createUrl("/purchase/purchase/ownerview", array("id"=>$data->id))',
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


<?php echo TbHtml::linkButton(Yii::t('app', 'Exportar a Excel'), array('class' => 'export_to_excel' ,'color' => TbHtml::BUTTON_COLOR_SUCCESS, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'url' => array('export')));?>


<?php //$this->advanced_search = true; ?>
<?php $this->created_at_filter = true; ?>
<?php $this->recived_at_filter = true; ?>
<?php $this->purchase_references = $model->searchReferences();?>

<div id="modal-purchase" class="modal hide fade" style="">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo Yii::t('app', 'Compra');?></h4>
      </div>
    <div class="modal-body"></div>
    <div class="modal-footer">
	    <a href="#" data-dismiss="modal" class="btn"><?php echo Yii::t('app', 'Close');?></a>
	    <!--<a href="#" id="in-observation-purchase" class="btn btn-warning"><?php echo Yii::t('app', 'En observación');?></a>-->
    </div>
</div>
