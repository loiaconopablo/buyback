<?php if (Yii::app()->user->hasFlash('error')) : ?>

	<div class="alert alert-block alert-error">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo Yii::app()->user->getFlash('error');?>
	</div>

<?php 
      endif;?>

<div class="form">


    <?php if (Yii::app()->user->checkAccess('personal')) : ?>
		<div class="span12">
			<div class="well text-center span4 personal-option personal-selection">
				<h3>Gifcard</h3><?php echo TbHtml::button('$ ' . $price, array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'block' => true, 'onclick' => 'javascript: selectButton(1, this);'));?>
			</div>
			<div class="well text-center span4 personal-option">
				<h3>Pack Doble 5000</h3><?php echo TbHtml::button('5000 SMS + Internet', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'disabled' => true, 'block' => true, 'onclick' => 'javascript: selectButton(2, this);'));?>
			</div>
			<div class="well text-center span4 personal-option">
				<h3>Puntos Personal</h3><?php echo TbHtml::button('1000 pts.', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'disabled' => true, 'block' => true, 'onclick' => 'javascript: selectButton(3, this);'));?></span>
			</div>
		</div>
    <?php else: ?>
		<div class="well text-center">
			<h3>Precio de compra</h3><span class="badge badge-success"><h1> $ <?php echo $price;?></h1></span>
		</div>
    <?php 
endif;?>


<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
    'id' => 'seller-form',
    'enableAjaxValidation' => true,
    'action' => array('/purchase/buy/seller'),
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'afterValidate' => 'js:formSend',
        'validationUrl' => array('/purchase/buy/seller'),
    ),
    )
);
?>

    <?php echo CHtml::hiddenField('personal-select', 1);?>

	<h3>Datos del cliente</h3>

	<p class="note">
    <?php echo Yii::t('app', 'Fields with');?> <span class="required">*</span> <?php echo Yii::t('app', 'are required');?>.
	</p>

    <?php //echo $form->errorSummary($model); ?>

		<div>
			<div class="alert alert-block alert-info bold">
				<?php echo $form->labelEx($model, 'name');?>
				<?php echo $form->textField($model, 'name', array('maxlength' => 255, 'size' => TbHtml::INPUT_SIZE_XXLARGE));?>
			</div>
    <?php if ($model->hasErrors('name')) : ?>
				<div class="alert alert-block alert-error">
				  <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $form->error($model, 'name');?>
				</div>
        <?php 
endif;?>

		</div><!-- row -->
		<div>
			<div class="alert alert-block alert-info bold">
				<?php echo $form->labelEx($model, 'dni');?>
				<?php echo $form->textField($model, 'dni', array('pattern' => '[0-9]{8}'));?>
			</div>
    <?php if ($model->hasErrors('dni')) : ?>
				<div class="alert alert-block alert-error">
				  <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $form->error($model, 'dni');?>
				</div>
        <?php 
endif;?>
		</div><!-- row -->

		<div>
			<div class="alert alert-block alert-info bold">
				<?php echo $form->labelEx($model, 'address');?>
				<?php echo $form->textField($model, 'address', array('maxlength' => 255, 'size' => TbHtml::INPUT_SIZE_XXLARGE));?>
			</div>
    <?php if ($model->hasErrors('address')) : ?>
				<div class="alert alert-block alert-error">
				  <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $form->error($model, 'address');?>
				</div>
        <?php 
endif;?>
		</div>

	    <div>
	    	<div class="alert alert-block alert-info bold">
				<?php echo $form->labelEx($model, 'province');?>
				<?php echo $form->dropDownList($model, 'province', GxHtml::listDataEx(Province::model()->findAllAttributes(null, true), 'name', 'name'), array('span' => 5));?>
			</div>

    <?php if ($model->hasErrors('province')) : ?>
				<div class="alert alert-block alert-error">
				  <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $form->error($model, 'province');?>
				</div>
        <?php 
endif;?>
		</div>

		<div>
			<div class="alert alert-block alert-info bold">
				<?php echo $form->labelEx($model, 'locality');?>
				<?php echo $form->textField($model, 'locality', array('maxlength' => 255, 'size' => TbHtml::INPUT_SIZE_XXLARGE));?>
			</div>
    <?php if ($model->hasErrors('locality')) : ?>
				<div class="alert alert-block alert-error">
				  <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $form->error($model, 'locality');?>
				</div>
        <?php 
endif;?>
		</div>

		<div>
			<div class="alert alert-block alert-info bold">
				<?php echo $form->labelEx($model, 'phone');?>
				<?php echo $form->textField($model, 'phone', array('maxlength' => 255, 'pattern' => '[0-9-]+'));?>
			</div>
    <?php if ($model->hasErrors('phone')) : ?>
				<div class="alert alert-block alert-error">
				  <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $form->error($model, 'phone');?>
				</div>
        <?php 
endif;?>
		</div>

		<div>
			<div class="alert alert-block alert-info bold">
				<?php echo $form->labelEx($model, 'mail');?>
				<?php echo $form->emailField($model, 'mail', array('maxlength' => 255, 'size' => TbHtml::INPUT_SIZE_XXLARGE));?>
			</div>
    <?php if ($model->hasErrors('mail')) : ?>
				<div class="alert alert-block alert-error">
				  <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $form->error($model, 'mail');?>
				</div>
        <?php 
endif;?>
		</div>

		<div class="alert alert-success">
    <?php
    echo TbHtml::submitButton(Yii::t('app', 'Save'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE));
    $this->endWidget();
?>

    <?php echo TbHtml::link('volver', array('carrier'), array('class' => 'btn btn-large pull-right'));?>
		</div>
</div><!-- form -->

<script>
 function selectButton(selection, element)
 {
 	console.log('hola');
 	$("#personal-select").val(selection);
 	$('.personal-option').removeClass("personal-selection");
 	$(element).parent().addClass("personal-selection");
 }
</script>
