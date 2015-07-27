<?php 
    $priceList = new PriceList;
    ?>

<div class="span12">
	
    <?php 
    $form = $this->beginWidget(
        'GxActiveForm', array(
        'id' => 'purchase-form',
        'action' => array('/purchase/buy/brandmodel'),
        'enableAjaxValidation' => true,
             'clientOptions'=>array(
                'validateOnSubmit'=>true,
                'validateOnChange' => false,
                'validationUrl' => array('/purchase/buy/imei'),
                'afterValidate'=>'js:formSend'
             )
        )
    );
    ?>

	<div>
		<div class="alert alert-block alert-info">
    <?php echo $form->labelEx($model, 'IMEI'); ?>
    <?php echo $form->numberField($model, 'imei', array('class' => 'no-spin input-text-big')); ?>
		</div>
    <?php echo $form->error($model, 'imei'); ?>
	</div><!-- row -->

	<div class="alert alert-success">
    <?php
    echo TbHtml::submitButton(Yii::t('app', 'Next'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE));
    $this->endWidget();
    ?>
		
    <?php echo TbHtml::link(Yii::t('app','Back'), array('/retail'), array('class' => 'btn btn-large pull-right')); ?>
	</div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/retail.js"></script>
