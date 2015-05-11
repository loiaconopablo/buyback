<?php

$this->breadcrumbs = array(
	$PriceList_model->label(2) => array('index'),
	Yii::t('app', 'Upload'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' ' . $PriceList_model->label(2), 'icon' => 'list', 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create') . ' ' . $PriceList_model->label(), 'icon'=>'plus-sign', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . $PriceList_model->label(2), 'icon' => 'th-list', 'url'=>array('admin')),
);
?>

<div class="span12 text-center">
  <?php
    $form = $this->beginWidget('GxActiveForm',
        array(
            'id' => 'upload-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        )
    );
  ?>
    
    <div>
    <?php echo $form->fileField($model, 'file'); ?>

    <?php if($model->hasErrors('file')): ?>
        <div class="alert alert-block alert-error">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <?php echo $form->error($model,'file'); ?>
        </div>
    <?php endif; ?>
    
    </div><!-- row -->

  <?php
  echo TbHtml::submitButton(Yii::t('app', Yii::t('app', 'Upload')), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'block' => 'true'));
  $this->endWidget();
  ?>
</div>