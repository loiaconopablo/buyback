<?php

$this->breadcrumbs = array(
    $PriceList_model->label(2) => array('index'),
    Yii::t('app', 'Importar'),
);

$this->menu=array(
    array('label'=>Yii::t('app', 'Listar') . ' ' . $PriceList_model->label(2), 'icon' => 'list', 'url'=>array('index')),
    array('label'=>Yii::t('app', 'Crear') . ' ' . $PriceList_model->label(), 'icon'=>'plus-sign', 'url'=>array('create')),
    array('label'=>Yii::t('app', 'Administrar') . ' ' . $PriceList_model->label(2), 'icon' => 'th-list', 'url'=>array('admin')),
);
?>

<div class="span12 text-center">
    <?php
    $form = $this->beginWidget(
        'GxActiveForm',
        array(
            'id' => 'upload-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        )
    );
    ?>
    
    <div>
        <div>
            <?php echo $form->labelEx($model, 'company_id'); ?>
            <?php echo $form->dropDownList($model, 'company_id', GxHtml::listDataEx(Company::model()->findAll()), array('size' => TbHtml::INPUT_SIZE_XXLARGE, 'empty' => Yii::t('app', 'Seleccionar').'...')); ?>
        </div><!-- row -->
        <?php if($model->hasErrors('company_id')) : ?>
            <div class="alert alert-block alert-error">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $form->error($model, 'company_id'); ?>
            </div>
        <?php endif; ?>

        <?php echo $form->fileField($model, 'file'); ?>

        <?php if($model->hasErrors('file')) : ?>
            <div class="alert alert-block alert-error">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $form->error($model, 'file'); ?>
            </div>
        <?php endif; ?>
    
    </div><!-- row -->

    <?php
    echo TbHtml::submitButton(Yii::t('app', Yii::t('app', 'Importar')), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'block' => 'true'));
    $this->endWidget();
    ?>
</div>