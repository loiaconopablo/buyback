<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main.view'); ?>

<!-- CONTENT begin -->
<div class="span9">
    <?php echo $content; ?>
</div>
<!-- CONTENT end -->

<!-- SIDEBAR begin -->
<div class="span3">
    <!-- ACTIONS MENU begin -->
    <?php array_unshift($this->menu, array('label' => 'ACCIONES', 'icon' => 'th-large', 'url' => '#', 'active' => true)); ?>
    <?php echo TbHtml::stackedTabs($this->menu); ?>
    <!-- ACTIONS MENU end -->

    <!-- CREATED_AT begin -->
    <?php if (Yii::app()->controller->created_at_filter) : ?>
        <?php $this->renderPartial('application.views.default.timerange', array('prefix' => 'created_at', 'title' => 'Filtrar x fecha de creación')); ?>
    <?php endif; ?>
    <!-- CREATED_AT end -->

    <!-- RECIVED_AT begin -->
    <?php if (Yii::app()->controller->recived_at_filter) : ?>
        <?php $this->renderPartial('application.views.default.timerange', array('prefix' => 'recived_at', 'title' => 'Filtrar x fecha de estado')); ?>
    <?php endif; ?>
    <!-- RECIVED_AT end -->

    <!-- PURCHASE REFERENCE begin -->
    <?php if (Yii::app()->controller->purchase_references) : ?>
        <?php Yii::app()->controller->widget('PurchaseReferences'); ?>
    <?php endif; ?>
    <!-- PURCHASE REFERENCE end -->

    <!-- ADVANCED SEARCH begin -->
    <?php if (Yii::app()->controller->advanced_search) : ?>
        <?php 
            echo TbHtml::button(
                Yii::t('app', 'Advanced Search'),
                array(
                    'style' => TbHtml::BUTTON_COLOR_PRIMARY,
                    'data-toggle' => 'modal',
                    'data-target' => '#searchModal',
                    'block' => true,
                )
            );
        ?>
    <?php endif; ?>
    <!-- ADVANCED SEARCH end -->

    <!-- DISPATCHNOTE REFERENCES begin -->
    <?php if (Yii::app()->controller->id == 'dispatchnote') : ?>
        <?php echo TbHtml::stackedTabs(Dispatchnote::references()); ?>
    <?php endif; ?>
    <!-- DISPATCHNOTE REFERENCES begin -->
</div>
<!-- SIDEBAR end -->

<?php $this->endContent(); ?>
