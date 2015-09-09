<div class="span12">
    <div><?php echo Yii::app()->session['report_messages']; ?></div>
	<?php 
    $form = $this->beginWidget(
        'GxActiveForm', array(
        'id' => 'purchase-form',
        'enableAjaxValidation' => false,
        )
    );
    ?>
     <?php echo CHtml::hiddenField('form_sent', 'form_sent', array('id' => 'form_sent')); ?>
    <div>
    	<div class="alert alert-block alert-info">
    		<?php if ($model->blacklist): ?>
    			<?php echo TbHtml::labelTb($model->imei_checked . ' - ' . Yii::t('app', 'IMEI en BANDA NEGATIVA') , array('color' => TbHtml::LABEL_COLOR_INVERSE, 'style' => 'font-size:23px; padding:15px')); ?>
    		<?php else: ?>
    			<?php echo TbHtml::labelTb(Yii::t('app', 'IMEI') . ': ' . $model->imei_checked, array('color' => TbHtml::LABEL_COLOR_INFO, 'style' => 'font-size:23px; padding:15px')); ?>
    		<?php endif; ?>
    	</div>
    </div>

    <div>
        <div class="alert alert-block alert-info">
            <?php echo TbHtml::labelTb(Yii::t('app', 'Marca') . ': ' . $model->brand_checked, array('color' => TbHtml::LABEL_COLOR_INFO, 'style' => 'font-size:23px; padding:15px')); ?>
        </div>
    </div>

    <div>
        <div class="alert alert-block alert-info">
            <?php echo TbHtml::labelTb(Yii::t('app', 'Modelo') . ': ' . $model->model_checked, array('color' => TbHtml::LABEL_COLOR_INFO, 'style' => 'font-size:23px; padding:15px')); ?>
        </div>
    </div>

    <div>
        <div class="alert alert-block alert-info">
            <?php echo TbHtml::labelTb(Yii::t('app', 'Operador') . ': ' . $model->carrier_checked, array('color' => TbHtml::LABEL_COLOR_INFO, 'style' => 'font-size:23px; padding:15px')); ?>
        </div>
    </div>

    <div>
        <div class="alert alert-block alert-info">
            <?php echo TbHtml::labelTb(Yii::t('app', 'Nº PeopleSoft') . ': ' . $model->peoplesoft_order, array('color' => TbHtml::LABEL_COLOR_INFO, 'style' => 'font-size:23px; padding:15px')); ?>
        </div>
    </div>

    <div>
        <div class="alert alert-block alert-info">
            <?php if ($model->to_refurbish): ?>
                <?php echo TbHtml::labelTb(Yii::t('app', 'Aprobado para refabricación') , array('color' => TbHtml::LABEL_COLOR_SUCCESS, 'style' => 'font-size:23px; padding:15px')); ?>
            <?php else: ?>
                <?php echo TbHtml::labelTb(Yii::t('app', 'No aprobado para refabricación'), array('color' => TbHtml::LABEL_COLOR_INVERSE, 'style' => 'font-size:23px; padding:15px')); ?>
            <?php endif; ?>
        </div>
    </div>

    <?php echo TbHtml::submitButton(Yii::t('app', 'GUARDAR'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'block' => true)); ?>

    <?php $this->endWidget(); ?>
</div>