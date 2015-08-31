<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Manage'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Buy'), 'icon' => 'plus-sign', 'url' => array('/retail/purchase')),
    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'icon' => 'list', 'url' => array('index')),
);

?>

<!--<h2><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2));?></h2>-->

<?php $this->renderPartial(
    'application.views.purchase._purchase_grid_comment_form',
    array(
        'dataProvider' => $dataProvider,
        'comment_model' => $dispatch_note_model,
        'page_title' => Yii::t('app', 'Nota de envío'),
    )
);?>
