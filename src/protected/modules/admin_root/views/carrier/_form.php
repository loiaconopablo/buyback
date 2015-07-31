<div class="form">

<?php $form = $this->beginWidget(
    'GxActiveForm', array(
    'id' => 'carrier-form',
    'enableAjaxValidation' => false,
    )
);
?>

	<p class="note">
    <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

    <?php echo $form->errorSummary($model); ?>

				<div>
    <?php echo $form->labelEx($model, 'name'); ?>
    <?php echo $form->textField($model, 'name', array('maxlength' => 20)); ?>
    <?php echo $form->error($model, 'name'); ?>
		</div><!-- row -->
					<div>
    <?php echo $form->labelEx($model, 'description'); ?>
    <?php echo $form->textArea($model, 'description'); ?>
    <?php echo $form->error($model, 'description'); ?>
		</div><!-- row -->
							

<?php
echo TbHtml::submitButton(Yii::t('app', 'Guardar'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY));
$this->endWidget();
?>
</div><!-- form -->