<?php 
    $priceList = new PriceList;
    ?>


<div class="span12">

<div class="alert alert-block alert-warning">
  <strong><?php echo Yii::t('app', 'The device owner has to present DNI'); ?></strong>
</div>
<div class="alert alert-block alert-warning">
  <strong><?php echo Yii::t('app', 'The device has battery and back cover'); ?></strong>
</div>
<div class="alert alert-block alert-warning">
  <strong><?php echo Yii::t('app', 'The device starts and is able to call'); ?></strong>
</div>
<div class="alert alert-block alert-warning">
  <strong><?php echo Yii::t('app', 'The device has its screen in a good state (no broken)'); ?>.</strong>
</div>
<div class="alert alert-block alert-warning">
  <strong><?php echo Yii::t('app', 'The device doesnt look like it was wet'); ?>.</strong>
</div>
	
    <?php 
    $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm', array(
        'id' => 'purchase-form',
        'enableAjaxValidation' => false,
        'action' => array('/purchase/buy/questionary'),
        )
    );
    ?>
    <?php foreach($model->attributes as $attribute => $value): ?>
			<div class="alert alert-block alert-info bold">
    <?php echo $form->checkBox($model, $attribute); ?>
    <?php echo $form->labelEx($model, $attribute, array('style' => 'display: inline; font-weight:bold')); ?>
			</div>
    <?php if($model->hasErrors($attribute)) : ?>
			<div class="alert alert-block alert-error">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $form->error($model, $attribute); ?>
			</div>
        <?php 
endif; ?>
    <?php 
endforeach; ?>

	<div class="alert alert-success">

    <?php
    echo TbHtml::submitButton(Yii::t('app', 'Next'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE));
    $this->endWidget();
    ?>

    <?php echo TbHtml::link(Yii::t('app','Back'), array('brandmodel'), array('class' => 'btn btn-large pull-right')); ?>
	</div>
</div>



<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/retail.js"></script>
