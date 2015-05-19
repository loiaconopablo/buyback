<?php 
    $priceList = new PriceList;
    ?>

<div class="span12">
	
    <?php 
    $form = $this->beginWidget(
        'GxActiveForm', array(
        'id' => 'purchase-form',
        'action' => array('/retail/purchase/brandmodel'),
        'enableAjaxValidation' => false,
             // 'clientOptions'=>array(
        //             'validateOnSubmit'=>true,
        //             'validateOnChange' => true,
        //             'validationUrl' => array('/retail/purchase/brandmodel'),
        //             'afterValidate'=>'js:formSend'
        //         )
        )
    );
    ?>

	<div>
		<div class="alert alert-block alert-info">
    <?php echo Yii::t('app', $form->labelEx($model, 'brand')); ?>
    <?php echo $form->dropDownList($model, 'brand', CHtml::listData($priceList->getBrandsList(), 'brand', 'brand'), array('empty'=>'Marca...')); ?>
		</div>
    <?php if($model->hasErrors('brand')) : ?>
			<div class="alert alert-block alert-error">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $form->error($model, 'brand'); ?>
			</div>
        <?php 
endif; ?>
	</div>

	<div>
		<div class="alert alert-block alert-info">
    <?php echo Yii::t('app', $form->labelEx($model, 'model')); ?>
    <?php echo $form->dropDownList($model, 'model', CHtml::listData($priceList->getModelsByBrand($model->brand), 'model', 'model'), array('empty'=>'Modelo...')); ?>
		</div>
    <?php if($model->hasErrors('model')) : ?>
			<div class="alert alert-block alert-error">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $form->error($model, 'model'); ?>
			</div>
        <?php 
endif; ?>
	</div>

	<div class="alert alert-success">
    <?php
    echo TbHtml::submitButton(Yii::t('app', 'Next'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE));
    $this->endWidget();
    ?>

    <?php echo TbHtml::link('volver', array('imei'), array('class' => 'btn btn-large pull-right')); ?>
	</div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/retail.js"></script>
