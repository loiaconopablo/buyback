<?php
$this->breadcrumbs = array(
    $sellingcode_model->label(2) => array('index'),
    Yii::t('app', 'Importar Lista de códigos'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Crear') . ' ' . $sellingcode_model->label(), 'icon' => 'plus-sign', 'url' => array('create')),
    array('label' => Yii::t('app', 'Listar') . ' ' . $sellingcode_model->label(2), 'icon' => 'list', 'url' => array('admin')),
    array('label' => Yii::t('app', 'Importar') . ' ' . $sellingcode_model->label(2), 'icon' => 'file', 'url' => array('upload')),
    array('label' => Yii::t('app', 'Eliminar') . ' ' . $sellingcode_model->label(2), 'icon' => 'remove', 'url' => array('truncate'), 'linkOptions' => array('onClick'=>'return confirm("¿Desea eliminar todos los registros?");' )));
?>

<div class="span12">
    <?php
    $form = $this->beginWidget(
            'GxActiveForm', array(
        'id' => 'fileupload-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data')
    ));
    ?>

    <div>
        <?php echo $form->fileField($model, 'file'); ?>

        <?php if ($model->hasErrors('file')) : ?>
            <div class="alert alert-block alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $form->error($model, 'file'); ?>
            </div>
        <?php endif; ?>

    </div><!-- row -->

    <?php
    echo TbHtml::submitButton(Yii::t('app', Yii::t('app', 'Importar Lista de códigos')), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'block' => 'true'));
    $this->endWidget();
    ?>
</div>

