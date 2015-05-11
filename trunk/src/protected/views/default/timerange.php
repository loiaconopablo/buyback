<?php //echo TbHtml::stackedTabs( array(array('label' => Yii::t('app', 'Filtrar entre fechas'), 'icon' => 'filter', 'url' => '#', 'active' => true))); ?>

<?php
	$in = false;
	if (isset(Yii::app()->request->cookies['from']) || isset(Yii::app()->request->cookies['to'])) {
		$in = true;
	}
?>
<div class="accordion" id="accordion2">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
        <i class="icon-filter"></i> <?php echo Yii::t('app', 'Filtrar entre fechas'); ?>
      </a>
    </div>
    <div id="collapseOne" class="accordion-body collapse <?php echo $in ? 'in' : null ?>">
      <div class="accordion-inner">
        <?php $form=$this->beginWidget('CActiveForm', array()); ?>

		
					
					<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'name' => 'from',
						'value' => isset(Yii::app()->request->cookies['from']) ? Yii::app()->request->cookies['from']->value : null,
						'htmlOptions' => array(
							'class' => 'block',
							'placeholder' => 'desde',
						),
						'options' => array(
							'showButtonPanel' => true,
							'changeYear' => true,
							'dateFormat' => 'dd/mm/yy',
							'onSelect'=> new CJavaScriptExpression("function(dateSelected){ $.cookie('from', dateSelected); }"),
							),
						));
					; ?>
		
					<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'name' => 'to',
						'value' => isset(Yii::app()->request->cookies['to']->value) ? Yii::app()->request->cookies['to']->value : null,
						'htmlOptions' => array(
							'class' => 'block',
							'placeholder' => 'hasta',
						),
						'options' => array(
							'showButtonPanel' => true,
							'changeYear' => true,
							'dateFormat' => 'dd/mm/yy',
							'onSelect'=> new CJavaScriptExpression("function(dateSelected){ $.cookie('to', dateSelected); }"),
							),
						));
					; ?>
	

			<?php echo TbHtml::button(Yii::t('app', 'Filtrar'), array('block' => true, 'onClick' => 'javascript: refreshGrid();')); ?>
			<?php echo TbHtml::button(Yii::t('app', 'Reiniciar filtro'), array('block' => true, 'onClick' => 'javascript: resetDateFilter();')); ?>

			<?php $this->endWidget(); ?>
      </div>
    </div>
  </div>
</div>