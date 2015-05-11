<?php
$priceList = new PriceList;
?>

<div class="span12">

	<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'purchase-form',
	'enableAjaxValidation' => true,
	'action' => array('/retail/purchase/seller'),
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => false,
		'afterValidate' => 'js:formSend',
		'validationUrl' => array('/retail/purchase/carrier'),
	),
));
?>

	<?php if (!Yii::app()->user->checkAccess('personal')): ?>
		<div>
			<div class="alert alert-block alert-info bold">
				<?php echo $form->checkBoxControlGroup($model, 'unlocked');?>
			</div>
		</div>

		<div>
			<div class="alert alert-block alert-info bold">
			<?php echo Yii::t('app', $form->labelEx($model, 'carrier'));?>
			<?php echo $form->dropDownList($model, 'carrier', CHtml::listData(Carrier::model()->findAll(), 'id', 'name'), array('empty' => Yii::t('app', 'Carrier|Carriers', 1) . '...'));?>
			</div>
			<?php if ($model->hasErrors('carrier')): ?>
				<div class="alert alert-block alert-error">
				  <button type="button" class="close" data-dismiss="alert">&times;</button>
				  <?php echo $form->error($model, 'carrier');?>
				</div>
		    <?php endif;?>
		</div>
	<?php else: ?>
		<?php echo $form->hiddenField($model, 'unlocked', array('value' => 0));?>
		<?php echo $form->hiddenField($model, 'carrier', array('value' => 1));?>

		<div>
			<div class="alert alert-block alert-info bold">
				<?php echo Yii::t('app', 'SOLO SE ACEPTAN EQUIPOS DE PERSONAL');?>
			</div>
		</div>
	<?php endif;?>

	<div class="alert alert-success">
		<?php
echo TbHtml::submitButton(Yii::t('app', 'Next'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE));
$this->endWidget();
?>

		<?php echo TbHtml::link('volver', array('questionary'), array('class' => 'btn btn-large pull-right'));?>
	</div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/retail.js"></script>