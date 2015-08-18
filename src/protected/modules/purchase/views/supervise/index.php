<div class="span12">
	
    <?php 
    $form = $this->beginWidget(
        'GxActiveForm', array(
        'id' => 'imei-check-form',
        'htmlOptions' => array('class' => 'form-inline'),
        'action' => array(Yii::app()->createUrl('purchase/supervise/checkdevise')),
        'enableAjaxValidation' => true,
             'clientOptions'=>array(
                'validateOnSubmit'=>true,
                'validateOnChange' => true,
                'validationUrl' => array('/purchase/supervise/imeivalidation'),
                'afterValidate'=>'js:formSend'
             )
        )
    );
    ?>

	<div>
		<div class="alert alert-block alert-info">
        <?php echo $form->numberField($model, 'imei_checked', array('class' => 'input-text-big', 'value' => $model->imei)); ?>

        <?php echo TbHtml::submitButton(Yii::t('app', 'Chequear IMEI'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_SMALL)); ?>
		</div>
        <?php echo $form->error($model, 'imei'); ?>
	</div><!-- row -->

    <?php $this->endWidget(); ?>

</div>

