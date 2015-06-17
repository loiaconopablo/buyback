<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Manage'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Buy'), 'icon' => 'plus-sign', 'url' => array('/retail/purchase/imei')),
);

?>

<!--<h2><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2));?></h2>-->

<?php $form = $this->beginWidget(
    'CActiveForm',
    array(
    'action' => Yii::app()->createUrl('/retail/admin/dispatchpurchases'),
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
            'checked' => 'Helper::checkedInGrid($data->id)',
            //'selectableRows' => '50',
            'selectableRows' => 2,
            'value' => '$data->id',
            'headerTemplate' => '<label>{item}<span></span></label>',
            'htmlOptions' => array('style' => 'width: 20px', 'class' => 'chandran'),
        ),
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
            'header' => Yii::t('app', 'Fecha'),
            'value' => 'date("d-m-Y", strtotime($data->created_at))',
            'htmlOptions' => array('style' => 'text-align: center'),
        ),
        //'user',
        array(
            'name' => 'user_create_id',
            'value' => '$data->user->username',
            'filter' => CHtml::listData($model->getRetailAdminPurchases(), 'user.id', 'user.username'),
        ),
        array(
            'name' => 'point_of_sale_id',
            'value' => '$data->point_of_sale->name',
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
    ),
    )
);?>

<?php echo TbHtml::submitButton(Yii::t('app', 'Confeccionar Nota de Envío'), array('class' => 'checks-submit btn-warning', 'data-checkcolumn' => 'purchase_selected'));?>

<?php $this->endWidget();?>

<?php //$this->advanced_search = true; ?>
<?php $this->date_filter = true;?>

<?php $this->renderPartial(
    '_search',
    array(
    'model' => $model,
    )
);?>

<div id="modal-purchase" class="modal hide fade" style="">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo Yii::t('app', 'Purchase');?></h4>
      </div>
    <div class="modal-body"></div>
    <div class="modal-footer">
	    <a href="#" data-dismiss="modal" class="btn"><?php echo Yii::t('app', 'Close');?></a>
	    <!--<a href="#" id="send_dispatch" class="btn btn-primary"><?php echo Yii::t('app', 'In transit');?></a>-->
    </div>
</div>
