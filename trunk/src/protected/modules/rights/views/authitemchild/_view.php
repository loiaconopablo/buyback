<?php
/* @var $this AuthitemchildController */
/* @var $data Authitemchild */
?>

<div class="view">

    	

	<b><?php echo CHtml::encode($data->getAttributeLabel('parent')); ?>:</b>
    <?php echo CHtml::encode($data->parent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('child')); ?>:</b>
    <?php echo CHtml::encode($data->child); ?>
	<br />

	


</div>