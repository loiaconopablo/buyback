<div class="form">

	<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => false,
    )
);?>

	<p class="note">
    <?php echo Yii::t('app', 'Fields with');?> <span class="required">*</span> <?php echo Yii::t('app', 'are required');?>.
	</p>

    <?php echo $form->errorSummary($model);?>

		<div>
    <?php echo CHtml::label(Yii::t('app', 'Permisos'), 'User_itemname');?>
    <?php echo $form->dropDownList($Authassignment_model, 'itemname', GxHtml::listDataEx($roles, 'role', 'name'), array('empty' => 'Sin permisos'));?>
    <?php echo $form->error($Authassignment_model, 'itemname');?>
		</div><!-- row -->
</div>
<div class="dependent hide">
		<div>
    <?php echo $form->labelEx($model, 'company_id');?>
    <?php echo $form->dropDownList($model, 'company_id', GxHtml::listDataEx(Company::model()->findAllAttributes(null, true)), array('empty' => 'Sin empresa'));?>
    <?php echo $form->error($model, 'company_id');?>
		</div><!-- row -->
		<div style="display: none;">
    <?php echo CHtml::label(Yii::t('app', 'Punto de venta'), 'User_point_of_sale_id');?>
    <?php echo $form->dropDownList($model, 'point_of_sale_id', GxHtml::listDataEx(PointOfSale::model()->findAllAttributes(null, true)));?>
    <?php echo $form->error($model, 'point_of_sale_id');?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'username');?>
    <?php echo $form->textField($model, 'username', array('maxlength' => 255, 'autocomplete' => 'off'));?>
    <?php echo $form->error($model, 'username');?>
		</div><!-- row -->
					<div>
    <?php echo $form->labelEx($model, 'password');?>
    <?php
    if ($model->isNewRecord) {
        echo $form->passwordField($model, 'password', array('maxlength' => 64));
    } else {
        echo $form->passwordField($model, 'password', array('maxlength' => 64, 'value' => ''));
    }
?>

    <?php echo $form->error($model, 'password');?>
		</div><!-- row -->
					<div>
    <?php echo $form->labelEx($model, 'mail');?>
    <?php echo $form->emailField($model, 'mail', array('maxlength' => 255));?>
    <?php echo $form->error($model, 'mail');?>
		</div><!-- row -->
		<div>
    <?php echo $form->labelEx($model, 'employee_identification');?>
    <?php echo $form->textField($model, 'employee_identification', array('maxlength' => 20));?>
    <?php echo $form->error($model, 'employee_identification');?>
		</div><!-- row -->


<?php
echo TbHtml::submitButton(Yii::t('app', 'Save'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY));
$this->endWidget();
?>
</div><!-- form -->

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/user_form.js"></script>