<div class="span12">
	<div class="well text-center span4 personal-option personal-selection">
		<h3>Gifcard</h3><?php echo TbHtml::button('$ ' . $price, array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'block' => true, 'onclick' => 'javascript: selectButton(1, this);'));?>
	</div>
	<div class="well text-center span4 personal-option">
		<h3><?php echo Yii::t('app', 'Double pack'); ?> 5000</h3><?php echo TbHtml::button('5000 SMS + Internet', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'disabled' => true, 'block' => true, 'onclick' => 'javascript: selectButton(2, this);'));?>
	</div>
	<div class="well text-center span4 personal-option">
		<h3>Puntos Personal</h3><?php echo TbHtml::button('1000 pts.', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'disabled' => true, 'block' => true, 'onclick' => 'javascript: selectButton(3, this);'));?></span>
	</div>
</div>