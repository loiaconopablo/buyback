<!-- Modal -->
<div id="searchModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Búsqueda avanzada</h3>
  </div>
  <?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )
); ?>
  <div class="modal-body">
    <p>
    	<p><?php echo Yii::t('app', 'La búsqueda acepta los operadores de compracion (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) delante de cada campo para especificarla.'); ?>
</p>
		<div>
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id', array('maxlength' => 10)); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'point_of_sale_id'); ?>
        <?php echo $form->dropDownList($model, 'point_of_sale_id', GxHtml::listDataEx(PointOfSale::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'company_id'); ?>
        <?php echo $form->dropDownList($model, 'company_id', GxHtml::listDataEx(Company::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'username'); ?>
        <?php echo $form->textField($model, 'username', array('maxlength' => 255)); ?>
				</div>
			
																								<div>
        <?php echo $form->label($model, 'mail'); ?>
        <?php echo $form->textField($model, 'mail', array('maxlength' => 255)); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'employee_identification'); ?>
        <?php echo $form->textField($model, 'employee_identification', array('maxlength' => 20)); ?>
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