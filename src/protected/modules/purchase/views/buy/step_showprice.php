<div class="span12 well">

	<?php if (Yii::app()->user->checkAccess('personal')) : ?>
	    <?php if ($personal_select == 1) : ?>
		<div class="well text-center">
			<h3>Gifcard</h3>
			<span class="badge badge-success"><h1> <?php echo Yii::t('app', '$') . $model->purchase_price;?></h1></span>
		</div>
	    <?php endif; ?>

    	<?php if ($personal_select == 2) : ?>
			<div class="well text-center">
				<h3><?php echo Yii::t('app', 'Double pack'); ?> 500</h3>
				<span class="badge badge-success"><h1>5000 SMS + Internet</h1></span>
			</div>
    	<?php endif; ?>

    	<?php if ($personal_select == 3) : ?>
		<div class="well text-center">
			<h3>Puntos Personal</h3>
			<span class="badge badge-success"><h1>1000 pts.</h1></span>
		</div>
    	<?php endif; ?>
    <?php else: ?>
		<div class="well text-center">
			<h3><?php echo Yii::t('app', 'Precio de compra'); ?></h3><span class="badge badge-success"><h1> <?php echo Yii::t('app', '$') . $model->purchase_price;?></h1></span>
		</div>
    <?php endif; ?>

    <?php echo TbHtml::linkButton(Yii::t('app', 'Imprimir contrato'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'block' => true, 'url' => array('/purchase/contract/generate', 'purchase_id' => $model->id), 'target' => '_blank'));?>

	</br>
	</br>
	</br>
    <?php echo TbHtml::linkButton(Yii::t('app', 'COTIZAR OTRO EQUIPO'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'block' => true, 'url' => array('/purchase/buy')));?>
</div>
