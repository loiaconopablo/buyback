<?php $form = $this->beginWidget(
    'CActiveForm',
    array(
    //'action' => Yii::app()->createUrl('/purchase/purchase/dispatch'),
    //'enableAjaxValidation'=>true,
    )
);?>

<?php $this->widget(
    'bootstrap.widgets.TbGridView',
    array(
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'id' => 'selectableGrid',
    'dataProvider' => $model->clear($dispatchnote_id),
    'filter' => $model,
    'rowCssClassExpression' => '
        ( Status::model()->findByAttributes(array("id" => $data->current_status_id))->constant_name )
    ',
    'ajaxUpdate'=>true,
    'beforeAjaxUpdate'=>'function(){setCheckedItems()}',
    'template' => "{items}\n{pager}",
    'columns' => array(
        // array(
        //     'header' => 'html',
        //     'id' => 'purchase_selected',
        //     'class' => 'CCheckBoxColumn',
        //     'checked' => 'Helper::checkedInCookie($data->id, "checkedItems")',
        //     //'selectableRows' => '50',
        //     'selectableRows' => 2,
        //     'value' => '$data->id',
        //     'headerTemplate' => '<label>{item}<span></span></label>',
        //     'htmlOptions' => array('style' => 'width: 20px', 'class' => 'chandran text-center span1'),
        //     'headerHtmlOptions' => array('class' => 'text-center'),
        // ),
         array(
            'name' => 'last_dispatch_note_id',
            'header' => Yii::t('app', 'Nota'),
            'value' => '$data->last_dispatch_note',
            'filter' => false,
            'htmlOptions' => array('class' => 'text-right span1'),
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
            'header' => Yii::t('app', '$ Compra'),
            'value' => '"$ " . $data->purchase_price',
            'htmlOptions' => array('class' => 'text-right span2'),
        ),
        array(
            'name' => 'paid_price',
            'header' => Yii::t('app', '$ Liquidación'),
            'value' => '"$ " . $data->paid_price',
            'htmlOptions' => array('class' => 'text-right span2'),
        ),

        array(
            'header' => Yii::t('app', 'Comisión'),
            'value' => '"$ " . round($data->paid_price * ($data->company->percent_fee / 100), 2)',
            'filter' => false,
            'htmlOptions' => array('class' => 'text-right span2'),
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


 <div class="span span12 nospace">
    <table class="table table-bordered table-striped">
        <thead>
            <th><?php echo Yii::t('app', 'Total reintegro'); ?></th>
            <th><?php echo Yii::t('app', 'Comisiones'); ?></th>
            <th><?php echo Yii::t('app', 'Ajuste de comisión'); ?></th>
            <th><?php echo Yii::t('app', 'Total comisión'); ?></th>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: right">$ <?php echo $total_paid_price; ?></td>
                <td style="text-align: right">$ <?php echo $total_comision; ?></td>
                <td style="text-align: right">$ <?php echo $error_allowance; ?></td>
                <td style="text-align: right">$ <?php echo round($error_allowance + $total_comision, 2); ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php echo TbHtml::submitButton(Yii::t('app', 'GUARDAR LIQUIDACIÓN'), array('class' => 'btn-success', 'block' => true));?>


<?php $this->endWidget();?>

<?php //$this->purchase_references = $model->clearReferences($dispatchnote_id);?>


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
