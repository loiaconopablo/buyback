<?php 
    $priceList = new PriceList;
    ?>

<div class="span12">
	
    <?php 
    $form = $this->beginWidget(
        'GxActiveForm', array(
        'id' => 'purchase-form',
        'enableAjaxValidation' => false,
        )
    );
    ?>

	<div>
		<div class="alert alert-block alert-info">
            <?php echo $form->labelEx($model, 'IMEI'); ?>
            <?php echo $form->numberField($model, 'imei', array('class' => 'no-spin input-text-big')); ?>
		</div>

        <?php if($model->hasErrors('imei')) : ?>
            <div class="alert alert-block alert-error">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $form->error($model, 'imei'); ?>
            </div>
        <?php endif; ?>
	</div><!-- row -->

	<div class="alert alert-success">
    <?php
    echo TbHtml::submitButton(Yii::t('app', 'Siguiente'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE));
    $this->endWidget();
    ?>
	</div>
</div>

