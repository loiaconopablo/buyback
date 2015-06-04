<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span9">
    <?php echo $content; ?>
</div>
<div class="span3">
    <?php array_unshift($this->menu, array('label' => 'ACCIONES', 'icon' => 'th-large', 'url' => '#', 'active' => true)); ?>
    <?php echo TbHtml::stackedTabs($this->menu); ?>

    <?php if (Yii::app()->controller->date_filter) :
?>
    <?php $this->renderPartial('application.views.default.timerange'); ?>
    <?php
endif; ?>

    <?php if (Yii::app()->controller->purchase_references) :
    ?>
        <?php Yii::app()->controller->widget('PurchaseReferences'); ?>
        <?php
endif; ?>

    <?php if (Yii::app()->controller->advanced_search) :
?>
    <?php echo TbHtml::button(
    Yii::t('app', 'Advanced Search'),
    array(
            'style' => TbHtml::BUTTON_COLOR_PRIMARY,
            'data-toggle' => 'modal',
            'data-target' => '#searchModal',
            'block' => true,
        )
); ?>
    <?php
endif;?>
    <?php //if (Yii::app()->controller->module->id == 'headquarter' && Yii::app()->controller->id == 'dispatchnote' ) : ?>
    <?php if (Yii::app()->controller->id == 'dispatchnote') :
?>
    <?php echo TbHtml::stackedTabs(Dispatchnote::references()); ?>
    <?php
endif;?>
</div>
<?php $this->endContent(); ?>
