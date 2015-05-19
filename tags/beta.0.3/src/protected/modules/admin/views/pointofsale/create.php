<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Create'),
);

$this->menu = array(
    array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'icon' => 'list', 'url' => array('admin')),
);
?>

<!--<h2><?php echo Yii::t('app', 'Create') . ' ' . GxHtml::encode($model->label()); ?></h2>-->

<?php
$this->renderPartial(
    '_form', array(
        'model' => $model,
        'buttons' => 'create')
);
?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/point_of_sale_create.js"></script>