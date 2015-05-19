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
    	<p><?php echo Yii::t('app', 'You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.'); ?>
</p>

			
				<div>
        <?php echo $form->label($model, 'contract_number'); ?>
        <?php echo $form->textField($model, 'contract_number', array('maxlength' => 20)); ?>
				</div>

				<div>
        <?php echo $form->label($model, 'user'); ?>
        <?php echo $form->textField($model, 'user', array('maxlength' => 10)); ?>
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
        <?php echo $form->label($model, 'purchase_price'); ?>
        <?php echo $form->textField($model, 'purchase_price'); ?>
				</div>
		
			
				<div>
        <?php echo $form->label($model, 'carrier'); ?>
        <?php echo $form->textField($model, 'carrier', array('maxlength' => 10)); ?>
				</div>
			
			
				<div>
        <?php echo $form->label($model, 'imei'); ?>
        <?php echo $form->textField($model, 'imei'); ?>
				</div>

				<div>
        <?php echo $form->label($model, 'created_at'); ?>
        <?php echo $form->textField($model, 'created_at'); ?>
				</div>
		
    </p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo Yii::t('app', 'Cancel'); ?>
</button>
    <?php echo TbHtml::submitButton(Yii::t('app', 'Search'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
  </div>
    <?php $this->endWidget(); ?>
</div>