<?php //echo TbHtml::stackedTabs( array(array('label' => Yii::t('app', 'Filtrar entre fechas'), 'icon' => 'filter', 'url' => '#', 'active' => true))); ?>

<?php
    $in = false;
if (isset(Yii::app()->request->cookies[$prefix . 'from']) || isset(Yii::app()->request->cookies[$prefix . 'to'])) {
    $in = true;
}
?>
<div class="accordion" id="accordion<?php echo $prefix ?>">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $prefix ?>" href="#collapseOne<?php echo $prefix ?>">
        <i class="icon-filter"></i> <?php echo $title; ?>
      </a>
    </div>
    <div id="collapseOne<?php echo $prefix ?>" class="accordion-body collapse <?php echo $in ? 'in' : null ?>">
      <div class="accordion-inner">
        <?php $form=$this->beginWidget('CActiveForm', array()); ?>

		
					
        <?php $this->widget(
    'zii.widgets.jui.CJuiDatePicker', array(
        'name' => $prefix . 'from',
        'value' => isset(Yii::app()->request->cookies[$prefix . 'from']) ? Yii::app()->request->cookies[$prefix . 'from']->value : null,
        'htmlOptions' => array(
        'class' => 'block',
        'placeholder' => Yii::t('app', 'desde'),
        ),
        'options' => array(
        'showButtonPanel' => true,
        'changeYear' => true,
        'dateFormat' => 'dd/mm/yy',
        'onSelect'=> new CJavaScriptExpression("function(dateSelected){ $.cookie('" . $prefix . "from', dateSelected); }"),
        ),
                        )
);
                    ; ?>
		
        <?php $this->widget(
        'zii.widgets.jui.CJuiDatePicker', array(
        'name' => $prefix . 'to',
        'value' => isset(Yii::app()->request->cookies[$prefix . 'to']->value) ? Yii::app()->request->cookies[$prefix . 'to']->value : null,
        'htmlOptions' => array(
        'class' => 'block',
        'placeholder' => Yii::t('app', 'hasta'),
        ),
        'options' => array(
        'showButtonPanel' => true,
        'changeYear' => true,
        'dateFormat' => 'dd/mm/yy',
        'onSelect'=> new CJavaScriptExpression("function(dateSelected){ $.cookie('" . $prefix . "to', dateSelected); }"),
        ),
                        )
);
                    ; ?>
	

    <?php echo TbHtml::button(Yii::t('app', 'Filtrar'), array('block' => true, 'onClick' => 'javascript: refreshGrid();')); ?>
    <?php echo TbHtml::button(Yii::t('app', 'Reiniciar filtro'), array('block' => true, 'onClick' => 'javascript: resetDateFilter("' . $prefix . '");')); ?>

    <?php $this->endWidget(); ?>
      </div>
    </div>
  </div>
</div>
