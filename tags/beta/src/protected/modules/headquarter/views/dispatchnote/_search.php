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
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id', array('maxlength' => 10)); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'company_id'); ?>
        <?php echo $form->textField($model, 'company_id', array('maxlength' => 10)); ?>
				</div>
			
			
															<div>
        <?php echo $form->label($model, 'user'); ?>
        <?php echo $form->textField($model, 'user', array('maxlength' => 10)); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'comment'); ?>
        <?php echo $form->textArea($model, 'comment'); ?>
				</div>
			
								
								
																			<div>
        <?php echo $form->label($model, 'sent_at'); ?>
        <?php echo $form->textField($model, 'sent_at'); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'finished_at'); ?>
        <?php echo $form->textField($model, 'finished_at'); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'destination_id'); ?>
        <?php echo $form->textField($model, 'destination_id', array('maxlength' => 10)); ?>
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