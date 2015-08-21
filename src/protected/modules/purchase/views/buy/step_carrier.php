<?php
$priceList = new PriceList;
?>

<div class="span12">

    <?php
    $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm', array(
        'id' => 'purchase-form',
        'enableAjaxValidation' => false,
        'action' => array('/purchase/buy/carrier'),
        'clientOptions' => array(
        // 'validateOnSubmit' => true,
        // 'validateOnChange' => false,
        // 'afterValidate' => 'js:formSend',
        // 'validationUrl' => array('/purchase/buy/carrier'),
        ),
        )
    );
?>

    <?php if (!Yii::app()->user->checkAccess('personal')) : ?>

		<div>
			<div class="alert alert-block alert-info bold">
            <?php echo Yii::t('app', $form->labelEx($model, 'carrier_id'));?>
            <?php echo $form->dropDownList($model, 'carrier_id', CHtml::listData(Carrier::model()->findAll(), 'id', 'name'), array('empty' => Yii::t('app', 'Operador') . '...'));?>
			</div>
            <?php if ($model->hasErrors('carrier_id')) : ?>
				<div class="alert alert-block alert-error">
				  <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo $form->error($model, 'carrier_id');?>
				</div>
        <?php endif; ?>
		</div>
    <?php else: ?>
    <?php echo $form->hiddenField($model, 'carrier_id', array('value' => 1));?>

		<div>
			<div class="alert alert-block alert-info bold">
				<?php echo Yii::t('app', 'Only Personal devices are acceptable');?>
			</div>
		</div>
    <?php 
endif;?>

	<div class="alert alert-success">
    <?php
    echo TbHtml::submitButton(Yii::t('app', 'Siguiente'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE));
    $this->endWidget();
?>

    <?php echo TbHtml::link(Yii::t('app','Volver'), array('questionary'), array('class' => 'btn btn-large pull-right'));?>
	</div>
</div>