<div class="form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'device-status-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

				<div>
		<?php echo $form->labelEx($model,'slug'); ?>
		<?php echo $form->textField($model, 'slug', array('maxlength' => 20)); ?>
		<?php echo $form->error($model,'slug'); ?>
		</div><!-- row -->
					<div>
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 40)); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->
							
		<label><?php echo GxHtml::encode($model->getRelationLabel('contract')); ?></label>
		<?php echo $form->checkBoxList($model, 'contract', GxHtml::encodeEx(GxHtml::listDataEx(Contract::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo TbHtml::submitButton(Yii::t('app', 'Save'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY));
$this->endWidget();
?>
</div><!-- form -->