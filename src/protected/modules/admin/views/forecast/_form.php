<?php
/* @var $this ForecastController */
/* @var $model Forecast */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'forecast-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <?php echo $form->errorSummary($model); ?>

    <table class="table">
        <thead>
            <th><?php echo $form->labelEx($model, 'month'); ?></th>
            <th><?php echo $form->labelEx($model, 'year'); ?></th>
            <th><?php echo $form->labelEx($model, 'quantity'); ?></th>
        </thead>
        </tbody>
            <tr>
                <td><?php echo $form->dropDownList($model, 'month', CHtml::listData(DateHelper::getMonths(), 'month_number', 'month_name')); ?></td>
                <td><?php echo $form->dropDownList($model, 'year', CHtml::listData(DateHelper::getYears(), 'year', 'year')); ?></td>
                <td><?php echo $form->numberField($model,'quantity',array('span'=>6,'maxlength'=>20)); ?></td>
            </tr>
        </tbody>
    </table>
            
        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
            'block' => true,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->