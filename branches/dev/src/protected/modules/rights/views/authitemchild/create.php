<?php
/* @var $this AuthitemchildController */
/* @var $model Authitemchild */
?>

<?php
$this->breadcrumbs=array(
    'Authitemchilds'=>array('index'),
    'Create',
);

$this->menu=array(
    array('label'=>'List Authitemchild', 'url'=>array('index')),
    array('label'=>'Manage Authitemchild', 'url'=>array('admin')),
);
?>

<?php if(Yii::app()->user->hasFlash('error')) :?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php 
endif; ?>
<?php $this->renderPartial('_form', array('model'=>$model,'data'=>$data)); ?>