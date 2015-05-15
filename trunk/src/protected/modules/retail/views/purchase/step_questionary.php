<?php 
    $priceList = new PriceList;
    ?>


<div class="span12">

<div class="alert alert-block alert-warning">
  <strong>El titular del equipo tiene el DNI</strong>
</div>
<div class="alert alert-block alert-warning">
  <strong>El equipo tiene su batería y su tapa trasera</strong>
</div>
<div class="alert alert-block alert-warning">
  <strong>El equipo enciende y puede realizar una llamada</strong>
</div>
<div class="alert alert-block alert-warning">
  <strong>El equipo tiene su visor o display en buen estado (no estallado ni rajado).</strong>
</div>
<div class="alert alert-block alert-warning">
  <strong>El equipo no tiene rastros de haber sido mojado.</strong>
</div>
	
    <?php 
    $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm', array(
        'id' => 'purchase-form',
        'enableAjaxValidation' => false,
        'action' => array('/retail/purchase/questionary'),
        )
    );
    ?>
    <?php foreach($model->attributes as $attribute => $value): ?>
			<div class="alert alert-block alert-info bold">
    <?php echo $form->checkBox($model, $attribute); ?>
    <?php echo $form->labelEx($model, $attribute, array('style' => 'display: inline; font-weight:bold')); ?>
			</div>
    <?php if($model->hasErrors($attribute)) : ?>
			<div class="alert alert-block alert-error">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $form->error($model, $attribute); ?>
			</div>
        <?php 
endif; ?>
    <?php 
endforeach; ?>

	<div class="alert alert-success">

    <?php
    echo TbHtml::submitButton(Yii::t('app', 'Next'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE));
    $this->endWidget();
    ?>

    <?php echo TbHtml::link('volver', array('brandmodel'), array('class' => 'btn btn-large pull-right')); ?>
	</div>
</div>



<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/retail.js"></script>
