<div class="span12">
	
    <?php 
    $form = $this->beginWidget(
        'GxActiveForm', array(
        'id' => 'imei-check-form',
        'htmlOptions' => array('class' => 'form-inline'),
        'enableAjaxValidation' => false,
        )
    );
    ?>

	<div>
		<div class="alert alert-block alert-info">
            <?php echo $form->numberField($model, 'imei_checked', array('class' => 'input-text-big', 'value' => $model->imei)); ?>

            <?php echo TbHtml::submitButton(Yii::t('app', 'Chequear IMEI'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_SMALL)); ?>
		</div>
        
        <?php if($model->hasErrors('imei_checked')) : ?>
            <div class="alert alert-block alert-error">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $form->error($model, 'imei_checked'); ?>
            </div>
        <?php endif; ?>
	</div><!-- row -->

    <?php $this->endWidget(); ?>

</div>

