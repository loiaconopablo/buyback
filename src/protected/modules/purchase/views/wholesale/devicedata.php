<div class="span12">
	<?php 
    $form = $this->beginWidget(
        'GxActiveForm', array(
        'id' => 'purchase-form',
        'enableAjaxValidation' => false,
             'clientOptions'=>array(

             )
        )
    );
    ?>
    <div>
    	<div class="alert alert-block alert-info">
  			<?php echo TbHtml::labelTb($model->imei, array('color' => TbHtml::LABEL_COLOR_INFO, 'style' => 'font-size:23px; padding:15px')); ?>
    	</div>
        <?php if($model->hasErrors('imei')) : ?>
        <div class="alert alert-block alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo $form->error($model, 'imei'); ?>
        </div>
        <?php endif; ?>
    </div>

    <div>
        <div class="alert alert-block alert-info">
            <?php echo Yii::t('app', $form->labelEx($model, 'brand')); ?>
            <?php echo $form->dropDownList($model, 'brand', CHtml::listData(PriceList::model()->getBrands(), 'brand', 'brand'), array('empty'=>'Marca...', 'class' => 'brand_select')); ?>
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
            <?php echo $form->dropDownList($model, 'model', CHtml::listData(PriceList::model()->getModels($model->brand), 'model', 'model'), array('empty'=>'Modelo...', 'class' => 'model_select')); ?>
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

    <?php echo TbHtml::submitButton(Yii::t('app', 'COMPRAR EQUIPO'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'block' => true)); ?>

    <?php $this->endWidget(); ?>
</div>