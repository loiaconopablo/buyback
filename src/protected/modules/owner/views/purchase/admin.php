<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Manage'),
);

$this->menu = array(
    // array('label' => Yii::t('app', 'Buy'), 'icon' => 'plus-sign', 'url' => array('/retail/purchase/imei')),
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
            'htmlOptions' => array('style' => 'width: 20px', 'class' => 'chandran'),
        ),
        array(
            'name' => 'contract_number',
            'headerHtmlOptions' => array(
                //'title' => Yii::t('app', 'Order by contract number'),
            ),
            'htmlOptions' => array(
                'class' => 'text-right',
            ),
        ),
        array(
            'name' => 'brand',
            'headerHtmlOptions' => array(
                //'title' => Yii::t('app', 'Order by brand'),
            ),
        ),

        array(
            'name' => 'model',
            'headerHtmlOptions' => array(
                //'title' => Yii::t('app', 'Order by model'),
            ),
        ),
        array(
            'name' => 'purchase_price',
            'header' => Yii::t('app', 'Precio'),
            'headerHtmlOptions' => array(
                'title' => Yii::t('app', 'Order by price'),
            ),
            'value' => '"$ " . $data->purchase_price',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
        array(
            'name' => 'created_at',
            'header' => Yii::t('app', 'Fecha'),
            'value' => 'date("d-m-Y", strtotime($data->created_at))',
            'htmlOptions' => array('style' => 'text-align: center'),
        ),
        //'user',
        array(
            'name' => 'user_create_id',
            'value' => '$data->user->username',
            'header' => Yii::t('app', 'Usuario'),
            'filter' => CHtml::listData($model->getRetailAdminPurchases(), 'user.id', 'user.username'),
        ),
        array(
            'name' => 'point_of_sale_id',
            'value' => '$data->point_of_sale->name',
            'header' => Yii::t('app', 'Point of sale'),
            'filter' => CHtml::listData($model->getRetailAdminPurchases(), 'point_of_sale.id', 'point_of_sale.name'),
        ),

        array(
            'class' => 'TbButtonColumn',
            'template' => '{view-purchase}',
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
    ),
    )
);?>

<?php echo TbHtml::submitButton(Yii::t('app', 'Confeccionar Nota de envío'), array('class' => 'checks-submit btn-warning', 'data-checkcolumn' => 'purchase_selected'));?>

<?php $this->endWidget();?>

<?php //$this->advanced_search = true; ?>
<?php $this->created_at_filter = true;?>
<?php $this->purchase_references = $model->adminReferences();?>

<?php $this->renderPartial(
    '_search',
    array(
    'model' => $model,
    )
);?>

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
