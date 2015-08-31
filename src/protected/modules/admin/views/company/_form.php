<div class="form">

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
    'id' => 'company-form',
    'enableAjaxValidation' => false,
    )
);
?>

	<p class="note">
    <?php echo Yii::t('app', 'Campos con');?> <span class="required">*</span> <?php echo Yii::t('app', 'son requeridos');?>.
	</p>

    <?php echo $form->errorSummary($model);?>

		<div>
    <?php echo $form->labelEx($model, 'company_code');?>
    <?php echo $form->textField($model, 'company_code', array('maxlength' => 100, 'size' => TbHtml::INPUT_SIZE_SMALL, 'pattern' => '[a-zA-Z0-9]+'));?>
    <?php echo $form->error($model, 'company_code');?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'name');?>
    <?php echo $form->textField($model, 'name', array('maxlength' => 255, 'size' => TbHtml::INPUT_SIZE_XXLARGE));?>
    <?php echo $form->error($model, 'name');?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'social_reason');?>
    <?php echo $form->textField($model, 'social_reason', array('maxlength' => 255, 'size' => TbHtml::INPUT_SIZE_XXLARGE));?>
    <?php echo $form->error($model, 'social_reason');?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'cuit');?>
    <?php echo $form->textField($model, 'cuit', array('maxlength' => 11));?>
    <?php echo $form->error($model, 'cuit');?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'address');?>
    <?php echo $form->textField($model, 'address', array('maxlength' => 255, 'size' => TbHtml::INPUT_SIZE_XXLARGE));?>
    <?php echo $form->error($model, 'address');?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'province');?>
    <?php echo $form->dropDownList($model, 'province', GxHtml::listDataEx(Province::model()->findAllAttributes(null, true), 'name', 'name'), array('span' => 5));?>
    <?php echo $form->error($model, 'province');?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'locality');?>
    <?php echo $form->textField($model, 'locality', array('maxlength' => 255, 'size' => TbHtml::INPUT_SIZE_XXLARGE));?>
    <?php echo $form->error($model, 'locality');?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'phone');?>
    <?php echo $form->textField($model, 'phone', array('maxlength' => 255, 'pattern' => '[0-9- +]+'));?>
    <?php echo $form->error($model, 'phone');?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'mail');?>
    <?php echo $form->emailField($model, 'mail', array('maxlength' => 255, 'size' => TbHtml::INPUT_SIZE_XXLARGE));?>
    <?php echo $form->error($model, 'mail');?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'percent_fee');?>
    <?php echo $form->numberField($model, 'percent_fee', array('append' => '%', 'size' => TbHtml::INPUT_SIZE_MINI, 'step' => 'any'));?>
    <?php echo $form->error($model, 'percent_fee');?>
		</div><!-- row -->


		<!-- ACA PONER UN TITULO PARA SEPARAR -->
		<h4><?php echo Yii::t('app', 'Datos de referencia');?></h4>
		<div>
    <?php echo $form->labelEx($model, 'reference_name');?>
    <?php echo $form->textField($model, 'reference_name', array('maxlength' => 255, 'size' => TbHtml::INPUT_SIZE_XXLARGE));?>
    <?php echo $form->error($model, 'reference_name');?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'reference_phone');?>
    <?php echo $form->textField($model, 'reference_phone', array('maxlength' => 255, 'pattern' => '[0-9- +]+'));?>
    <?php echo $form->error($model, 'reference_phone');?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'reference_mail');?>
    <?php echo $form->emailField($model, 'reference_mail', array('maxlength' => 255, 'size' => TbHtml::INPUT_SIZE_XXLARGE));?>
    <?php echo $form->error($model, 'reference_mail');?>
		</div><!-- row -->

<?php
echo TbHtml::submitButton(Yii::t('app', 'Guardar'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY));
$this->endWidget();
?>
</div><!-- form -->