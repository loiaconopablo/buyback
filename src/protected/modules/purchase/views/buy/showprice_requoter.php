<div class="well text-center">
	<h3><?php echo Yii::t('app', 'Precio de compra'); ?></h3><h1> $ <?php echo CHtml::textField('price', $price, array('pattern' => '[0-9.]+', 'style' => 'font-size: 30px; height: 45px;')); ?></h1>
</div>