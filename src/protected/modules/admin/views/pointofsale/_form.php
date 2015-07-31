<div class="form">

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
    'id' => 'point-of-sale-form',
    'enableAjaxValidation' => false,
    )
);
?>

	<p class="note">
    <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

    <?php echo $form->errorSummary($model); ?>

		<div>
    <?php echo $form->labelEx($model, 'company_id'); ?>
    <?php echo $form->dropDownList($model, 'company_id', GxHtml::listDataEx(Company::model()->findAll()), array('size' => TbHtml::INPUT_SIZE_XXLARGE, 'empty' => Yii::t('app', 'Select').'...')); ?>
    <?php echo $form->error($model, 'company_id'); ?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'is_headquarter'); ?>
    <?php echo $form->checkBox($model, 'is_headquarter'); ?>
    <?php echo $form->error($model, 'is_headquarter'); ?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'headquarter_id'); ?>
    <?php echo $form->dropDownList($model, 'headquarter_id', GxHtml::listDataEx($model->company_id ? Company::model()->findByPk($model->company_id)->getHeadquarters() : array()), array('size' => TbHtml::INPUT_SIZE_XXLARGE, 'empty' => Yii::t('app', 'Select').'...')); ?>
    <?php echo $form->error($model, 'headquarter_id'); ?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'name'); ?>
    <?php echo $form->textField($model, 'name', array('maxlength' => 255, 'size' => TbHtml::INPUT_SIZE_XXLARGE)); ?>
    <?php echo $form->error($model, 'name'); ?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'address'); ?>
    <?php echo $form->textField($model, 'address', array('maxlength' => 255, 'size' => TbHtml::INPUT_SIZE_XXLARGE)); ?>
    <?php echo $form->error($model, 'address'); ?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'province'); ?>
    <?php echo $form->dropDownList($model, 'province', GxHtml::listDataEx(Province::model()->findAllAttributes(null, true), 'name', 'name'), array('span' => 5)); ?>
    <?php echo $form->error($model, 'province'); ?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'locality'); ?>
    <?php echo $form->textField($model, 'locality', array('maxlength' => 255, 'size' => TbHtml::INPUT_SIZE_XXLARGE)); ?>
    <?php echo $form->error($model, 'locality'); ?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'phone'); ?>
    <?php echo $form->textField($model, 'phone', array('maxlength' => 255, 'pattern' => '[0-9- +]+')); ?>
    <?php echo $form->error($model, 'phone'); ?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'mail'); ?>
    <?php echo $form->emailField($model, 'mail', array('maxlength' => 255, 'size' => TbHtml::INPUT_SIZE_XXLARGE)); ?>
    <?php echo $form->error($model, 'mail'); ?>
		</div><!-- row -->

		<h4><?php echo Yii::t('app', 'Attendant Data'); ?></h4>
		<!-- ACA PONER UN TITULO PARA SEPARAR -->
		<div>
    <?php echo $form->labelEx($model, 'reference_name'); ?>
    <?php echo $form->textField($model, 'reference_name', array('maxlength' => 255, 'size' => TbHtml::INPUT_SIZE_XXLARGE)); ?>
    <?php echo $form->error($model, 'reference_name'); ?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'reference_phone'); ?>
    <?php echo $form->textField($model, 'reference_phone', array('maxlength' => 255, 'pattern' => '[0-9- +]+')); ?>
    <?php echo $form->error($model, 'reference_phone'); ?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'reference_mail'); ?>
    <?php echo $form->emailField($model, 'reference_mail', array('maxlength' => 255, 'size' => TbHtml::INPUT_SIZE_XXLARGE)); ?>
    <?php echo $form->error($model, 'reference_mail'); ?>
		</div><!-- row -->
						
<?php
echo TbHtml::submitButton(Yii::t('app', 'Guardar'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY));
$this->endWidget();
?>
</div><!-- form -->
