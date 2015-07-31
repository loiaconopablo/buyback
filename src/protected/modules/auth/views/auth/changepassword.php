<?php /* @var $this Controller */?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="language" content="en">

  <!-- blueprint CSS framework -->
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl;?>/css/screen.css" media="screen, projection">
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl;?>/css/print.css" media="print">
  <!--[if lt IE 8]>
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl;?>/css/ie.css" media="screen, projection">
  <![endif]-->

  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl;?>/css/main.css">
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl;?>/css/form.css">

  <title><?php echo CHtml::encode($this->pageTitle);?></title>
    <?php Yii::app()->bootstrap->register();?>
</head>

<body>

<div class="container" id="login-container">

<?php $form = $this->beginWidget(
    'GxActiveForm', array(
    'id' => 'change-password-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('autocomplete' => 'off', 'class' => 'well'),
    )
);
?>
    <?php echo $form->textField($model, 'username', array('style' => 'display:none'));?>
    <?php //echo $form->hiddenField($model, 'is_password_validated', array('value' => 1));?>
  <div class=""> <?php echo $form->labelEx($model, 'old_password');?> <?php echo $form->passwordField($model, 'old_password');?> <?php echo $form->error($model, 'old_password');?> </div>

  <div class=""> <?php echo $form->labelEx($model, 'new_password');?> <?php echo $form->passwordField($model, 'new_password');?> <?php echo $form->error($model, 'new_password');?> </div>

  <div class=""> <?php echo $form->labelEx($model, 'repeat_password');?> <?php echo $form->passwordField($model, 'repeat_password');?> <?php echo $form->error($model, 'repeat_password');?> </div>

  <div class=" submit">
    <?php //$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Change password')); ?>
    <?php echo TbHtml::formActions(
    array(
    TbHtml::submitButton(Yii::t('app', 'Guardar'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'block' => true)),

    )
);
?>
  </div>
    <?php $this->endWidget();?>
</div>

</body>
</html>
