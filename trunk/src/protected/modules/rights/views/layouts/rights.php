<?php $this->beginContent('//layouts/column2'); ?>
<?php
	$this->submenu_title = Yii::t('app', 'Roles', 2);
	$this->submenu = array(
		//array('label'=>Yii::t('app', 'Asignación de roles'), 'url'=>array('/rights/authassignment/admin'), 'active' =>  Yii::app()->controller->id=='authassignment'),
		array('label'=>Yii::t('app', 'Asignación de R(oles)T(areas)O(peraciones)'), 'url'=>array('/rights/authitemchild/admin'), 'active' =>  Yii::app()->controller->id=='authitemchild'),
		array('label'=>Yii::t('app', 'CRUD RTO'), 'url'=>array('/rights/authitem/admin'), 'active' =>  Yii::app()->controller->id=='authitem'),
	);
?>
<?php echo $content; ?>
<?php $this->endContent(); ?>