<div class="form">

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
    'id' => 'priecelist-form',
    'enableAjaxValidation' => false,
    )
);
?>

	<p class="note">
    <?php echo Yii::t('app', 'Campos con'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'son requeridos'); ?>.
	</p>

    <?php echo $form->errorSummary($model); ?>
    <div>
        <?php echo $form->labelEx($model, 'company_id'); ?>
        <?php echo $form->dropDownList($model, 'company_id', GxHtml::listDataEx(Company::model()->findAll()), array('size' => TbHtml::INPUT_SIZE_XXLARGE, 'empty' => Yii::t('app', 'Seleccionar').'...')); ?>
        <?php echo $form->error($model, 'company_id'); ?>
    </div><!-- row -->

	<div>
        <?php echo $form->labelEx($model, 'brand'); ?>
        <?php echo $form->textField($model, 'brand', array('maxlength' => 255)); ?>
        <?php echo $form->error($model, 'brand'); ?>
	</div><!-- row -->
	<div>
        <?php echo $form->labelEx($model, 'model'); ?>
        <?php echo $form->textField($model, 'model', array('maxlength' => 255)); ?>
        <?php echo $form->error($model, 'model'); ?>
	</div><!-- row -->
	<div>
        <?php echo $form->labelEx($model, 'locked_price'); ?>
        <?php echo $form->textField($model, 'locked_price', array('prepend' => '$', 'append' => '.00', 'class' => 'price')); ?>
        <?php echo $form->error($model, 'locked_price'); ?>
	</div><!-- row -->
	<div>
        <?php echo $form->labelEx($model, 'unlocked_price'); ?>
        <?php echo $form->textField($model, 'unlocked_price', array('prepend' => '$', 'append' => '.00', 'class' => 'price')); ?>
        <?php echo $form->error($model, 'unlocked_price'); ?>
	</div><!-- row -->
	<div>
        <?php echo $form->labelEx($model, 'broken_price'); ?>
        <?php echo $form->textField($model, 'broken_price', array('prepend' => '$', 'append' => '.00', 'class' => 'price')); ?>
        <?php echo $form->error($model, 'broken_price'); ?>
	</div><!-- row -->
							

<?php
echo TbHtml::submitButton(Yii::t('app', 'Guardar'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY));
$this->endWidget(); ?>
</div><!-- form -->