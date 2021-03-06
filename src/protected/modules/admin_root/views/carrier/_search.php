<!-- Modal -->
<div id="searchModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Advanced Search</h3>
  </div>
  <?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )
); ?>
  <div class="modal-body">
    <p>
    	<p>You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.</p>

															<div>
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id', array('maxlength' => 10)); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('maxlength' => 20)); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description'); ?>
				</div>
			
								
								
								
		
		
    </p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <?php echo TbHtml::submitButton(Yii::t('app', 'Search'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
  </div>
    <?php $this->endWidget(); ?>
</div>