<!-- Modal -->
<div id="searchModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel"><?php echo Yii::t('app', 'Busqueda avanzada'); ?></h3>
    </div>
    <?php
    $form = $this->beginWidget(
            'bootstrap.widgets.TbActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
            )
    );
    ?>
    <div class="modal-body">
        <p>
        <p><?php echo Yii::t('app', 'La búsqueda acepta los operadores de compracion (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) delante de cada campo para especificarla.'); ?>
        </p>

        <div>
<?php echo $form->label($model, 'id'); ?>
<?php echo $form->textField($model, 'id', array('maxlength' => 10)); ?>
        </div>

        <div>
<?php echo $form->label($model, 'brand'); ?>
<?php echo $form->textField($model, 'brand', array('maxlength' => 255)); ?>
        </div>

        <div>
<?php echo $form->label($model, 'model'); ?>
<?php echo $form->textField($model, 'model', array('maxlength' => 255)); ?>
        </div>

        <div>
<?php echo $form->label($model, 'movistar_a'); ?>
<?php echo $form->textField($model, 'movistar_a'); ?>
        </div>

        <div>
<?php echo $form->label($model, 'personal_a'); ?>
<?php echo $form->textField($model, 'personal_a'); ?>
        </div>

        <div>
<?php echo $form->label($model, 'claro_a'); ?>
<?php echo $form->textField($model, 'claro_a'); ?>
        </div>
        
        <div>
<?php echo $form->label($model, 'libre_a'); ?>
<?php echo $form->textField($model, 'libre_a'); ?>
        </div>
        <div>
<?php echo $form->label($model, 'movistar_b'); ?>
<?php echo $form->textField($model, 'movistar_b'); ?>
        </div>

        <div>
<?php echo $form->label($model, 'personal_b'); ?>
<?php echo $form->textField($model, 'personal_b'); ?>
        </div>

        <div>
<?php echo $form->label($model, 'claro_b'); ?>
<?php echo $form->textField($model, 'claro_b'); ?>
        </div>
        
        <div>
<?php echo $form->label($model, 'libre_b'); ?>
<?php echo $form->textField($model, 'libre_b'); ?>
        </div>
        
        <div>
<?php echo $form->label($model, 'bad_refurbish'); ?>
<?php echo $form->textField($model, 'bad_refurbish'); ?>
        </div>
        
        <div>
<?php echo $form->label($model, 'bad_irreparable'); ?>
<?php echo $form->textField($model, 'bad_irreparable'); ?>
        </div>






        </p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo Yii::t('app', 'Cancelar'); ?>
        </button>
    <?php echo TbHtml::submitButton(Yii::t('app', 'Buscar'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
    </div>
<?php $this->endWidget(); ?>
</div>