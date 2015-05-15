<div class="form">

<?php $form = $this->beginWidget(
    'GxActiveForm', array(
    'id' => 'seller-form',
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
    <?php echo $form->textField($model, 'name', array('maxlength' => 255)); ?>
    <?php echo $form->error($model, 'name'); ?>
		</div><!-- row -->
					<div>
    <?php echo $form->labelEx($model, 'dni'); ?>
    <?php echo $form->textField($model, 'dni'); ?>
    <?php echo $form->error($model, 'dni'); ?>
		</div><!-- row -->
							
		<label><?php echo GxHtml::encode($model->getRelationLabel('purchase')); ?></label>
    <?php echo $form->checkBoxList($model, 'purchase', GxHtml::encodeEx(GxHtml::listDataEx(Purchase::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo TbHtml::submitButton(Yii::t('app', 'Save'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY));
$this->endWidget();
?>
</div><!-- form -->