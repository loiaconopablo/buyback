<div class="span12">
	
    <?php 
    $form = $this->beginWidget(
        'GxActiveForm', array(
        'id' => 'imei-check-form',
        'htmlOptions' => array('class' => 'form-inline'),
        'enableAjaxValidation' => false,
             'clientOptions'=>array(

             )
        )
    );
    ?>

	<div>
        <?php if($model->hasErrors('imei')) : ?>
            <div class="alert alert-block alert-error">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $form->error($model, 'imei'); ?>
            </div>
        <?php endif; ?>
		<div class="alert alert-block alert-info">
            <?php echo $form->numberField($model, 'imei', array('class' => 'input-text-big', 'value' => $model->imei)); ?>

            <?php echo TbHtml::submitButton(Yii::t('app', 'Chequear IMEI'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_SMALL)); ?>
		</div>
	</div><!-- row -->

    <?php $this->endWidget(); ?>

</div>

