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
    		<?php if ($model->blacklist): ?>
    			<?php echo TbHtml::labelTb($model->imei_checked . ' - ' . Yii::t('app', 'IMEI en BANDA NEGATIVA') , array('color' => TbHtml::LABEL_COLOR_INVERSE, 'style' => 'font-size:23px; padding:15px')); ?>
    		<?php else: ?>
    			<?php echo TbHtml::labelTb($model->imei_checked, array('color' => TbHtml::LABEL_COLOR_INFO, 'style' => 'font-size:23px; padding:15px')); ?>
    		<?php endif; ?>
    	</div>
    </div>

    <div>
        <div class="alert alert-block alert-info">
            <?php echo Yii::t('app', $form->labelEx($model, 'brand_checked')); ?>
            <?php echo $form->dropDownList($model, 'brand_checked', CHtml::listData(PriceList::model()->getBrands(), 'brand', 'brand'), array('empty'=>'Marca...', 'class' => 'brand_select')); ?>
        </div>
        <?php if($model->hasErrors('brand_checked')) : ?>
        <div class="alert alert-block alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo $form->error($model, 'brand_checked'); ?>
        </div>
        <?php endif; ?>
    </div>

    <div>
        <div class="alert alert-block alert-info">
            <?php echo Yii::t('app', $form->labelEx($model, 'model_checked')); ?>
            <?php echo $form->dropDownList($model, 'model_checked', CHtml::listData(PriceList::model()->findAllByAttributes(array('brand' => $model->brand)), 'model', 'model'), array('empty'=>'Modelo...', 'class' => 'model_select')); ?>
        </div>

        <?php if($model->hasErrors('model_checked')) : ?>
            <div class="alert alert-block alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $form->error($model, 'model_checked'); ?>
            </div>
        <?php endif; ?>
    </div>

    <div>
		<div class="alert alert-block alert-info bold">
        	<?php echo Yii::t('app', $form->labelEx($model, 'carrier_id_checked'));?>
        	<?php echo $form->dropDownList($model, 'carrier_id_checked', CHtml::listData(Carrier::model()->findAll(), 'id', 'name'), array('empty' => Yii::t('app', 'Operador') . '...'));?>
		</div>

        <?php if ($model->hasErrors('carrier_id_checked')) : ?>
			<div class="alert alert-block alert-error">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $form->error($model, 'carrier_id_checked');?>
			</div>
    	<?php endif; ?>
	</div>

    
    <?php foreach ($questions as $question): ?>
        <div class="alert alert-block alert-info">
            <?php $this->renderPartial('_question', array('question' => $question)); ?>
        </div>
    <?php endforeach; ?>

    <?php if (!$model->blacklist): ?>
    <div class="alert alert-block alert-warning">
        <div class="form-inline">
            <?php echo $model->getAttributeLabel('to_refurbish'); ?>
        </div>
        <div class="form-inline">
            <?php echo $form->radioButtonList($model, 'to_refurbish', array(
                '1' => Yii::t('app', 'Si'),
                '0' => Yii::t('app', 'No'),
            )); ?>
        </div>
    </div>

    <?php if($model->hasErrors('to_refurbish')) : ?>
        <div class="alert alert-block alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo $form->error($model, 'to_refurbish'); ?>
        </div>
    <?php endif; ?>
    <?php endif; ?>
    

    <?php echo TbHtml::submitButton(Yii::t('app', 'Generar reporte técnico'), array('color' => TbHtml::BUTTON_COLOR_WARNING, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'block' => true)); ?>

    <?php $this->endWidget(); ?>
</div>