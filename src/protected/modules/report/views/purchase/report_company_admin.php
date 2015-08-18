<?php
$this->menu = array(
  //  array('label' => Yii::t('app', 'Buy'), 'icon' => 'plus-sign', 'url' => array('/retail/purchase/imei')),
);

?>


<?php $this->renderPartial('_report_grid', array('data_provider' => $model->company(), 'model' => $model)); ?>


<?php echo TbHtml::linkButton(Yii::t('app', 'Exportar a Excel'), array('class' => 'export_to_excel' ,'color' => TbHtml::BUTTON_COLOR_SUCCESS, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'url' => array('export')));?>


<?php //$this->advanced_search = true; ?>
<?php $this->created_at_filter = true; ?>
<?php $this->recived_at_filter = true; ?>
<?php $this->purchase_references = $model->companyReferences();?>

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
