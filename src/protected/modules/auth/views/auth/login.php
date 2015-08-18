<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bgh.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php Yii::app()->bootstrap->register(); ?>
</head>

<body class="body-login">
<?php echo CHtml::image(Yii::app()->request->baseUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'buyback_login_logo.png', 'buyback logo', array('id' => 'buyback-login-logo')); ?>
<?php echo CHtml::image(Yii::app()->request->baseUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'bgh_login_logo.png', 'bgh logo', array('id' => 'bgh-login-logo')); ?>
<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
?>

<?php  
if($data['showNewpassword']) {   
          Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_INFO, Yii::t('app', 'Bienvenido!. Debe cambiar la contraseña.'));
}
if($data['successNewpassword']) {
    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_INFO, Yii::t('app', 'Su contraseña fue cambiado con exito.'));
}
    ?>

<div class="container" id="login-container">
    <?php $form=$this->beginWidget(
    'GxActiveForm', array(
    'id'=>'login-form',
    'htmlOptions'=>array('class'=>'well'),
    'enableClientValidation'=>true,
    'clientOptions'=>array(
    'validateOnSubmit'=>true,
    ),
    )
); ?>|
		<div class="">
    <?php // echo $form->labelEx($model,'usuario'); ?>
    <?php echo $form->textField($model, 'username', array('class'=>'input-block-level', 'placeholder'=> Yii::t('app', 'Nombre de usuario'))); ?>
    <?php echo $form->error($model, 'username'); ?>
		</div>

		<div class="">
    <?php // echo $form->labelEx($model,'contraseña'); ?>
    <?php echo $form->passwordField($model, 'password', array('class'=>'input-block-level', 'placeholder'=>Yii::t('app', 'Contraseña'))); ?>
    <?php echo $form->error($model, 'password'); ?>
		</div>

    <?php if($data['showNewpassword']) : ?>
		<div class="">
    <?php echo $form->labelEx($model, 'newpassword'); ?>
    <?php echo $form->passwordField($model, 'newpassword'); ?>
    <?php echo $form->error($model, 'newpassword'); ?>
		</div>
    <?php 
endif; ?>

		<div class="rememberMe form-inline">
    <?php echo $form->checkBox($model, 'rememberMe'); ?>
    <?php echo $form->label($model, 'rememberMe'); ?>
    <?php echo $form->error($model, 'rememberMe'); ?>
		</div>

		<div class=" buttons">
    <?php echo TbHtml::button(Yii::t('app', 'Entrar'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'block' => true, 'type' => 'submit')); ?>
		</div>

    <?php $this->endWidget(); ?>
	</div><!-- form -->
</div>

</body>
</html>
