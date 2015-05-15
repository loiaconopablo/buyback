<div class="span12">
	<?php echo TbHtml::alert(TbHtml::ALERT_COLOR_WARNING, Yii::t('app', 'Disculpe, la compra no puede realizarse por no cumplir con todos sus requisitos.')); ?>
    <?php echo TbHtml::linkButton(Yii::t('app', 'Start another purchase'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'block' => true, 'url' => array('/retail/purchase'))); ?>
</div>
