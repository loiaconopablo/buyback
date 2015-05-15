<div class="form">

<?php $form = $this->beginWidget(
    'GxActiveForm', array(
    'id' => 'status-form',
    'enableAjaxValidation' => false,
    )
);
?>

	<p class="note">
    <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

    <?php echo $form->errorSummary($model); ?>


		<div>
    <?php echo $form->labelEx($model, 'id'); ?>
    <?php echo $form->textField($model, 'id', array('maxlength' => 2)); ?>
    <?php echo $form->error($model, 'id'); ?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'name'); ?>
    <?php echo $form->textField($model, 'name', array('maxlength' => 20)); ?>
    <?php echo $form->error($model, 'name'); ?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'constant_name'); ?>
    <?php echo $form->textField($model, 'constant_name', array('maxlength' => 20)); ?>
    <?php echo $form->error($model, 'constant_name'); ?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'description'); ?>
    <?php echo $form->textArea($model, 'description'); ?>
    <?php echo $form->error($model, 'description'); ?>
		</div><!-- row -->
							
		<label><?php echo GxHtml::encode($model->getRelationLabel('purchase_status')); ?></label>
    <?php echo $form->checkBoxList($model, 'purchase_status', GxHtml::encodeEx(GxHtml::listDataEx(PurchaseStatus::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo TbHtml::submitButton(Yii::t('app', 'Save'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY));
$this->endWidget();
?>
</div><!-- form -->