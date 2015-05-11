<?php /* @var $this Controller */?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<?php Yii::app()->bootstrap->register();?>

	<title><?php echo CHtml::encode($this->pageTitle);?></title>

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl;?>/css/bgh.css">
</head>

<body>

<div class="container">
	<header class="row-fluid">
		<div class="span12">
			<h1>
				<?php if (Yii::app()->user->checkAccess('personal')): ?>
					<img id="logo" src="<?php echo Yii::app()->baseUrl;?>/images/personal_logo.png">
				<?php else: ?>
					<img id="logo" src="<?php echo Yii::app()->baseUrl;?>/images/bgh_logo.png">
				<?php endif;?>
				<img id="logo" src="<?php echo Yii::app()->baseUrl;?>/images/buyback_logo.png"></h1>
			<?php
echo TbHtml::buttonDropdown(Yii::app()->user->name,
	Home::userMenu(),
	array('class' => 'user-menu-item')
);
?>

			<div id="mainmenu">
				<?php
//$menu = array();
$this->widget('bootstrap.widgets.TbNav', array(
	'type' => TbHtml::NAV_TYPE_TABS,
	'items' => $this->main_menu,
));
?>
			</div><!-- mainmenu -->

			<?php if (strlen($this->submenu_title)): ?>
				<div class="submenu">
					<?php $this->widget('bootstrap.widgets.TbNavbar', array(
	'brandLabel' => $this->submenu_title,
	'brandUrl' => '#',
	'display' => null, // default is static to top
	'items' => array(
		array(
			'class' => 'bootstrap.widgets.TbNav',
			'items' => $this->submenu,
		),
	),
));?>
				</div>
			<?php endif;?>
		</div>
	</header><!-- header -->

<!-- 	<div class="row-fluid">
		<div class="span12">
			<?php
$this->widget('bootstrap.widgets.TbBreadcrumb', array(
	'links' => $this->breadcrumbs,
));
?>
		</div>
	</div> -->

	<div id="messages-wrapper"></div>
	<div class="row-fluid">
		<?php echo $content;?>
	</div>

	<footer class="container">
		<div class="">
			Copyright &copy; <?php echo date('Y');?> by BGH BuyBack. Todos los derechos reservados.
		</div>
	</footer><!-- footer -->


</div><!-- page -->

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/js/bgh.js"></script>
</body>
</html>
