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
            'name' => 'brand',
        ),

        array(
            'name' => 'model',
        ),
        array(
            'name' => 'purchase_price',
            'header' => Yii::t('app', 'Precio'),
            'value' => '"$ " . $data->purchase_price',
            'htmlOptions' => array('class' => 'text-right span2'),
        ),
        array(
            'name' => 'created_at',
            'header' => Yii::t('app', 'Fecha'),
            'filter' => false,
            'value' => 'date("d-m-Y", strtotime($data->created_at))',
            'htmlOptions' => array('class' => 'text-center span2'),
        ),
        //'user',
        array(
            'name' => 'user_create_id',
            'value' => '$data->user->username',
            'htmlOptions' => array('class' => 'text-left span2'),
            'filter' => CHtml::listData(Helper::getUniqueInDataprovider($model->admin(), 't.user_create_id'), 'user_create_id', 'user'),
        ),
        array(
            'name' => 'point_of_sale_id',
            'value' => '$data->point_of_sale->name',
            'filter' => CHtml::listData(Helper::getUniqueInDataprovider($model->admin(), 't.point_of_sale_id'), 'point_of_sale_id', 'point_of_sale'),
        ),

        array(
            'class' => 'TbButtonColumn',
            'template' => '{view-purchase}{view-purchase-owner}',
            'htmlOptions' => array('class' => 'text-center span1'),
            'buttons' => array
            (
                'view-purchase' => array
                (
                    'visible' => '!Yii::app()->user->checkAccess("admin")',
                    'label' => 'ver',
                    'url' => 'Yii::app()->createUrl("/purchase/purchase/view", array("id"=>$data->id))',
                    'options' => array(
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-purchase',
                        'class' => 'btn btn-small',
                        'title' => 'ver compra',
                    ),
                ),
                'view-purchase-owner' => array
                (
                    'visible' => 'Yii::app()->user->checkAccess("admin")',
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
    ),
    )
);?>

<?php echo TbHtml::submitButton(Yii::t('app', 'Confeccionar Nota de envío'), array('class' => 'checks-submit btn-warning', 'data-checkcolumn' => 'purchase_selected'));?>

<?php $this->endWidget();?>

<?php //$this->advanced_search = true; ?>
<?php $this->created_at_filter = true; ?>
<?php $this->recived_at_filter = true; ?>
<?php $this->purchase_references = $model->adminReferences();?>


<div id="modal-purchase" class="modal hide fade" style="">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo Yii::t('app', 'Compra');?></h4>
      </div>
    <div class="modal-body"></div>
    <div class="modal-footer">
	    <a href="#" data-dismiss="modal" class="btn"><?php echo Yii::t('app', 'Cerrar');?></a>
	    <!--<a href="#" id="send_dispatch" class="btn btn-primary"><?php echo Yii::t('app', 'In transit');?></a>-->
    </div>
</div>
