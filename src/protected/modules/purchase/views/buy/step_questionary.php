<div class="span12">

    <div class="alert alert-block alert-warning">
      <strong><?php echo Yii::t('app', 'El titular del equipo tiene el DNI'); ?></strong>
    </div>
    <div class="alert alert-block alert-warning">
      <strong><?php echo Yii::t('app', 'El equipo tiene su batería y su tapa trasera'); ?></strong>
    </div>
    <div class="alert alert-block alert-warning">
      <strong><?php echo Yii::t('app', 'El equipo enciende y puede realizar una llamada'); ?></strong>
    </div>
    <div class="alert alert-block alert-warning">
      <strong><?php echo Yii::t('app', 'El equipo tiene su visor o display en buen estado (no estallado ni rajado)'); ?>.</strong>
    </div>
    <div class="alert alert-block alert-warning">
      <strong><?php echo Yii::t('app', 'El equipo no tiene rastros de haber sido mojado'); ?>.</strong>
    </div>
	
    <?php 
    $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm', array(
            'id' => 'purchase-form',
            'enableAjaxValidation' => false,
        )
    );
    ?>
    <?php foreach($model->attributes as $attribute => $value): ?>
		<div class="alert alert-block alert-info bold form-inline">
            <label class="checkbox" style="font-weight: bold">
                <?php echo $form->checkBox($model, $attribute); ?>
                <?php echo $model->getAttributeLabel($attribute); ?>
            </label>
		</div>

        <?php if($model->hasErrors($attribute)) : ?>
			<div class="alert alert-block alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $form->error($model, $attribute); ?>
			</div>
        <?php endif; ?>
    <?php endforeach; ?>

	<div class="alert alert-success">

    <?php
    echo TbHtml::submitButton(Yii::t('app', 'Siguiente'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE));
    $this->endWidget();
    ?>

    <?php echo TbHtml::link(Yii::t('app','Volver'), array('brandmodel'), array('class' => 'btn btn-large pull-right')); ?>
	</div>
</div>




