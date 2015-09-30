<div class="form">

    <?php
    $form = $this->beginWidget(
            'bootstrap.widgets.TbActiveForm', array(
        'id' => 'sellingcode-form',
        'enableAjaxValidation' => false
    ));
    ?>

    <p class="note">
        <?php echo Yii::t('app', 'Campos con'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'son requeridos'); ?>.
    </p>

    <?php echo $form->errorSummary($model); ?>

    <div>
        <?php echo $form->labelEx($model, 'brand'); ?>
        <?php echo $form->textField($model, 'brand', array('maxlength' => 255)); ?>
        <?php echo $form->error($model, 'brand'); ?>
    </div><!-- row -->
    <div>
        <?php echo $form->labelEx($model, 'model'); ?>
        <?php echo $form->textField($model, 'model', array('maxlength' => 255)); ?>
        <?php echo $form->error($model, 'model'); ?>
    </div><!-- row -->
    <div>
        <?php echo $form->labelEx($model, 'movistar_a'); ?>
        <?php echo $form->textField($model, 'movistar_a', array('maxlength' => 50)); ?>
        <?php echo $form->error($model, 'movitar_a'); ?>
    </div><!-- row -->
    <div>
        <?php echo $form->labelEx($model, 'personal_a'); ?>
        <?php echo $form->textField($model, 'personal_a', array('maxlength' => 50)); ?>
        <?php echo $form->error($model, 'personal_a'); ?>
    </div><!-- row -->
    <div>
        <?php echo $form->labelEx($model, 'claro_a'); ?>
        <?php echo $form->textField($model, 'claro_a', array('maxlength' => 50)); ?>
        <?php echo $form->error($model, 'claro_a'); ?>
    </div><!-- row -->
    <div>
        <?php echo $form->labelEx($model, 'libre_a'); ?>
        <?php echo $form->textField($model, 'libre_a', array('maxlength' => 50)); ?>
        <?php echo $form->error($model, 'libre_a'); ?>
    </div><!-- row -->
    <div>
        <?php echo $form->labelEx($model, 'movistar_b'); ?>
        <?php echo $form->textField($model, 'movistar_b', array('maxlength' => 50)); ?>
        <?php echo $form->error($model, 'movitar_b'); ?>
    </div><!-- row -->
    <div>
        <?php echo $form->labelEx($model, 'personal_b'); ?>
        <?php echo $form->textField($model, 'personal_b', array('maxlength' => 50)); ?>
        <?php echo $form->error($model, 'personal_b'); ?>
    </div><!-- row -->
    <div>
        <?php echo $form->labelEx($model, 'claro_b'); ?>
        <?php echo $form->textField($model, 'claro_b', array('maxlength' => 50)); ?>
        <?php echo $form->error($model, 'claro_b'); ?>
    </div><!-- row -->
    <div>
        <?php echo $form->labelEx($model, 'libre_b'); ?>
        <?php echo $form->textField($model, 'libre_b', array('maxlength' => 50)); ?>
        <?php echo $form->error($model, 'libre_b'); ?>
    </div><!-- row -->
    <div>
        <?php echo $form->labelEx($model, 'bad_refurbish'); ?>
        <?php echo $form->textField($model, 'bad_refurbish', array('maxlength' => 50)); ?>
        <?php echo $form->error($model, 'bad_refurbish'); ?>
    </div><!-- row -->
    <div>
        <?php echo $form->labelEx($model, 'bad_irreparable'); ?>
        <?php echo $form->textField($model, 'bad_irreparable', array('maxlength' => 50)); ?>
        <?php echo $form->error($model, 'bad_irreparable'); ?>
    </div><!-- row -->


    <?php
    echo TbHtml::submitButton(Yii::t('app', 'Guardar'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY));
    $this->endWidget();
    ?>
</div><!-- form -->