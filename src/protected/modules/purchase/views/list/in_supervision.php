<?php

$this->menu = array(
    array('label' => Yii::t('app', 'Comprar'), 'icon' => 'plus-sign', 'url' => array('/purchase/buy/imei'), 'disabled' => !Yii::app()->user->checkAccess('retail')),
);

?>

<!--<h2><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2));?></h2>-->

<?php $form = $this->beginWidget(
    'CActiveForm',
    array(
    'action' => Yii::app()->createUrl('/purchase/purchase/dispatch'),
    //'enableAjaxValidation'=>true,
    )
);?>

<?php $this->widget(
    'bootstrap.widgets.TbGridView',
    array(
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'id' => 'selectableGrid',
    'dataProvider' => $model->admin(),
    'filter' => $model,
    'rowCssClassExpression' => '
        ( Status::model()->findByAttributes(array("id" => $data->current_status_id))->constant_name )
    ',
    'ajaxUpdate'=>true,
    'beforeAjaxUpdate'=>'function(){setCheckedItems()}',
    'template' => "{items}\n{pager}",
    'columns' => array(
        array(
            'header' => 'html',
            'id' => 'purchase_selected',
            'class' => 'CCheckBoxColumn',
            'checked' => 'Helper::checkedInCookie($data->id, "checkedItems")',
            //'selectableRows' => '50',
            'selectableRows' => 2,
            'value' => '$data->id',
            'headerTemplate' => '<label>{item}<span></span></label>',
            'htmlOptions' => array('style' => 'width: 20px', 'class' => 'chandran text-center span1'),
            'headerHtmlOptions' => array('class' => 'text-center'),
        ),
        array(
            'name' => 'contract_number',
            'htmlOptions' => array(
                'class' => 'text-center span2',
            ),
        ),
        array(
            'name' => 'imei',
            'htmlOptions' => array(
                'class' => 'text-center span2',
            ),
        ),
        array(
            'name' => 'brand',
        ),

        array(
            'name' => 'model',
        ),
        array(
            'name' => 'carrier_name',
        ),
        array(
            'name' => 'created_at',
            'header' => Yii::t('app', 'Fecha'),
            'filter' => false,
            'value' => 'date("d-m-Y", strtotime($data->created_at))',
            'htmlOptions' => array('class' => 'text-center span2'),
        ),
        
        array(
            'name' => 'point_of_sale_id',
            'value' => '$data->point_of_sale->name',
            'filter' => CHtml::listData(Helper::getUniqueInDataprovider($model->admin(), 't.point_of_sale_id'), 'point_of_sale_id', 'point_of_sale'),
        ),

        array(
            'name' => 'company_id',
            'value' => '$data->company->name',
            'htmlOptions' => array('class' => 'text-left span2'),
            'filter' => CHtml::listData(Helper::getUniqueInDataprovider($model->admin(), 't.company_id'), 'company_id', 'company'),
        ),

        array(
            'class' => 'TbButtonColumn',
            'template' => '{test}',
            'htmlOptions' => array('class' => 'text-center span2'),
            'buttons' => array
            (
                'test' => array
                (
                    'visible' => 'Yii::app()->user->checkAccess("technical_supervisor")',
                    'label' => Yii::t('app', 'Chequear'),
                    'url' => 'Yii::app()->createUrl("/purchase/supervise", array("id"=>$data->id))',
                    'options' => array(
                        'class' => 'btn btn-small btn-warning',
                        'title' => Yii::t('app', 'Chequear equipo'),
                    ),
                ),
            ),
        ),
    ),
    )
);?>

<?php $this->endWidget();?>

<?php //$this->advanced_search = true; ?>
<?php $this->created_at_filter = true; ?>
<?php $this->recived_at_filter = true; ?>
<?php $this->purchase_references = $model->adminReferences();?>