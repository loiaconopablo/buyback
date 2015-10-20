<div class="well">
    <h4><?php echo Yii::t('app', 'Liquidación N°'); ?> <?php echo $model[0]->clearence_id;?></h4>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbGridView',
    array(
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'id' => 'selectableGrid',
    'dataProvider' => $dataProvider,
    'filter' => $model,
    'ajaxUpdate'=>true,
    'template' => "{items}\n{pager}",
    'columns' => array(
        array(
            'name' => 'contract_number',
            'filter' => false,
            'htmlOptions' => array(
                'class' => 'text-center span2',
            ),
        ),
        array(
            'name' => 'brand',
            'filter' => false,
        ),

        array(
            'name' => 'model',
            'filter' => false,
        ),
        array(
            'name' => 'purchase_price',
            'header' => Yii::t('app', '$ Compra'),
            'value' => '"$ " . $data->purchase_price',
            'htmlOptions' => array('class' => 'text-right span2'),
            'filter' => false,
        ),
        array(
            'name' => 'paid_price',
            'header' => Yii::t('app', '$ Liquidación'),
            'value' => '"$ " . $data->paid_price',
            'htmlOptions' => array('class' => 'text-right span2'),
            'filter' => false,
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
            'filter' => false,
        ),

        array(
            'class' => 'TbButtonColumn',
            'template' => '{view-purchase-owner}',
            'htmlOptions' => array('class' => 'text-center span1'),
            'buttons' => array
            (
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

</br>

<div class="span span12 nospace">
<?php echo TbHtml::linkButton(Yii::t('app', 'Generar excel'), array('url' => '#', 'class' => 'btn-success', 'block' => true));?>
</div>

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
