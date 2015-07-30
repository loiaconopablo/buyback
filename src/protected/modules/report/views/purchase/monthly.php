<?php


$this->menu = array(
  //  array('label' => Yii::t('app', 'Buy'), 'icon' => 'plus-sign', 'url' => array('/retail/purchase/imei')),
);

?>

<div class="span12">
	
    <?php 
    $form = $this->beginWidget(
        'GxActiveForm', array(
        'id' => 'monthly-form',
        'enableAjaxValidation' => false,
        )
    );
    ?>

	<div>
		<div class="alert alert-block alert-info">
            <?php echo Yii::t('app', $form->labelEx($model, 'month')); ?>
            <?php echo $form->dropDownList($model, 'month', CHtml::listData(DateHelper::getMonths(), 'month_number', 'month_name')); ?>

            <?php echo Yii::t('app', $form->labelEx($model, 'year')); ?>
            <?php echo $form->dropDownList($model, 'year', CHtml::listData($model->getYearsList(), 'year', 'year')); ?>

            <?php echo TbHtml::submitButton(Yii::t('app', 'Show report'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'block' => true)); ?>
		</div>
	</div>


    <?php $this->endWidget(); ?>

</div>