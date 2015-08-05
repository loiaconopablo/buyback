<?php /* @var $this Controller */?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

    <?php Yii::app()->bootstrap->register();?>

	<title><?php echo CHtml::encode($this->pageTitle);?></title>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl;?>/css/bgh.css">
</head>

<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart","bar"]});
</script>

<body>

<!-- CONTAINER begin -->
<div class="container">
    <header class="row-fluid">
        <div class="span12">
            <h1>
                <!-- LOGO EMPRESA begin -->
                <?php if (Yii::app()->user->checkAccess('personal')) : ?>
                    <img id="logo" src="<?php echo Yii::app()->baseUrl;?>/images/personal_logo.png">
                <?php else: ?>
                    <img id="logo" src="<?php echo Yii::app()->baseUrl;?>/images/bgh_logo.png">
                <?php endif;?>
                <!-- LOGO EMPRESA end -->

                <!-- LOGO BUYBACK -->
                <img id="logo" src="<?php echo Yii::app()->baseUrl;?>/images/buyback_logo.png"></h1>

                <!-- USERMENU begin -->
                <?php
                    // MENU DE USUARIO
                    echo TbHtml::buttonDropdown(
                        Yii::app()->user->name,
                        Home::userMenu(),
                        array('class' => 'user-menu-item')
                    );
                ?>
                <!-- USERMENU end -->

                <!-- MAINMENU begin -->
                <div id="mainmenu">
                <?php
                    // MENU PRINCIPAL
                    $this->widget(
                        'bootstrap.widgets.TbNav', array(
                        'type' => TbHtml::NAV_TYPE_TABS,
                        'items' => $this->main_menu,
                        )
                    );
                ?>
                </div>
                <!-- MAINMENU end -->

                <!-- SUBMENU begin -->
                <?php if (strlen($this->submenu_title)) : ?>
                    <div class="submenu">
                    <?php 
                        $this->widget(
                            'bootstrap.widgets.TbNavbar', array(
                                'brandLabel' => $this->submenu_title,
                                'brandUrl' => '#',
                                'display' => null, // default is static to top
                                'items' => array(
                                    array(
                                        'class' => 'bootstrap.widgets.TbNav',
                                        'items' => $this->submenu,
                                    ),
                                ),
                            )
                        );
                    ?>
                    </div>
                <?php endif;?>
                <!-- SUBMENU end -->
        </div>
    </header><!-- header -->

    <div id="messages-wrapper">
        <?php foreach(Yii::app()->user->getFlashes() as $type => $message): ?>
            <?php $this->renderPartial('application.views.default.message', array('message' => $message, 'type' => 'alert-' . $type));?>
        <?php endforeach; ?>
    </div>

    <!-- CONTENT begin -->
    <div class="row-fluid">
    <?php echo $content;?>
    </div>
    <!-- CONTENT end -->

    <!-- FOOTER begin -->
    <footer class="container">
        <div class="">
            Copyright &copy; <?php echo date('Y'); ?> by BGH BuyBack. <?php echo Yii::t('app', 'All rights reserved'); ?>.
        </div>
    </footer>
    <!-- FOOTER end -->

</div>
<!-- CONTAINER end -->

<!-- SCRIPTS begin -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/js/bgh.js"></script>
<!-- SCRIPTS end -->

</body>
</html>
