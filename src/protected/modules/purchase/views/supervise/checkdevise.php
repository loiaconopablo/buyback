<div class="span12">
	<?php 
    $form = $this->beginWidget(
        'GxActiveForm', array(
        'id' => 'purchase-form',
        'action' => array(Yii::app()->createUrl('purchase/supervise/showreport')),
        'enableAjaxValidation' => true,
             'clientOptions'=>array(
                'validateOnSubmit'=>true,
                'validateOnChange' => true,
                'validationUrl' => array('/purchase/supervise/checkdevisevalidation'),
                'afterValidate'=>'js:formSend'
             )
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
            <?php echo Yii::t('app', $form->labelEx($model, 'brand')); ?>
            <?php echo $form->dropDownList($model, 'brand', CHtml::listData(PriceList::model()->findAll(), 'brand', 'brand'), array('empty'=>'Marca...', 'class' => 'brand_select')); ?>
        </div>
        <?php if($model->hasErrors('brand')) : ?>
        <div class="alert alert-block alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo $form->error($model, 'brand'); ?>
        </div>
        <?php endif; ?>
    </div>

    <div>
        <div class="alert alert-block alert-info">
            <?php echo Yii::t('app', $form->labelEx($model, 'model')); ?>
            <?php echo $form->dropDownList($model, 'model', CHtml::listData(PriceList::model()->findAllByAttributes(array('brand' => $model->brand)), 'model', 'model'), array('empty'=>'Modelo...', 'class' => 'model_select')); ?>
        </div>
        <?php if($model->hasErrors('model')) : ?>
            <div class="alert alert-block alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $form->error($model, 'model'); ?>
            </div>
        <?php endif; ?>
    </div>

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

    <div class="alert alert-block alert-info">
    <?php echo TbHtml::checkBoxList('questionary', array(true), array(
        Yii::t('app', 'El equipo NO TIENE su batería o su tapa trasera') => Yii::t('app', 'El equipo NO TIENE su batería o su tapa trasera'),
        Yii::t('app', 'El equipo NO ENCIENDE o NO PUEDE realizar una llamada') => Yii::t('app', 'El equipo NO ENCIENDE y puede realizar una llamada'),
        Yii::t('app', 'El equipo NO TIENE su visor o display en buen estado (está estallado o rajado)') => Yii::t('app', 'El equipo NO TIENE su visor o display en buen estado (no estallado ni rajado)'),
        Yii::t('app', 'El equipo TIENE rastros de haber sido mojado') => Yii::t('app', 'El equipo TIENE rastros de haber sido mojado'),
    )); ?>
    </div>

    <div class="alert alert-block alert-info">
        <?php echo $form->labelEx($model, 'peoplesoft_order'); ?>
        <?php echo $form->textField($model, 'peoplesoft_order', array('class' => 'span1', 'pattern' => '[0-9]{7}', 'maxlength' => 7)); ?>
        <?php echo $form->error($model, 'peoplesoft_order'); ?>
    </div>

    <div class="alert alert-block alert-warning form-inline">
    	<label class="checkbox">
    		<?php echo $form->checkBox($model, 'to_refurbish', array('disabled' => $model->blacklist, 'checked' => !$model->blacklist)); ?>
    		<?php echo $model->getAttributeLabel('to_refurbish'); ?>
    	</label>
        <?php echo $form->error($model, 'to_refurbish'); ?>
    </div>

    <?php echo TbHtml::submitButton(Yii::t('app', 'Generar reporte técnico'), array('color' => TbHtml::BUTTON_COLOR_WARNING, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'block' => true)); ?>

    <?php $this->endWidget(); ?>
</div>