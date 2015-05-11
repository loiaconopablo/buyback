<?php
/* @var $this AuthassignmentController */
/* @var $model Authassignment */
?>

<?php
$this->breadcrumbs=array(
	'Authassignments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Authassignment', 'url'=>array('admin')),
);
?>

<!--<h1>Create Authassignment</h1>-->
<?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>
<?php $this->renderPartial('_form', array('model'=>$model,'data'=>$data)); ?>