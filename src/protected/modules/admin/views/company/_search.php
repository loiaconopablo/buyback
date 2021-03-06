<!-- Modal -->
<div id="searchModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo Yii::t('app', 'Busqueda avanzada'); ?></h3>
  </div>
    <?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    )
); ?>
  <div class="modal-body">
    <p>
    	<p><?php echo Yii::t('app', 'La búsqueda acepta los operadores de compracion (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) delante de cada campo para especificarla.'); ?></p>

															<div>
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id', array('maxlength' => 10)); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('maxlength' => 255)); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'social_reason'); ?>
        <?php echo $form->textField($model, 'social_reason', array('maxlength' => 255)); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'cuit'); ?>
        <?php echo $form->textField($model, 'cuit'); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'address'); ?>
        <?php echo $form->textField($model, 'address', array('maxlength' => 255)); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'province'); ?>
        <?php echo $form->textField($model, 'province', array('maxlength' => 255)); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'locality'); ?>
        <?php echo $form->textField($model, 'locality', array('maxlength' => 255)); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'phone'); ?>
        <?php echo $form->textField($model, 'phone', array('maxlength' => 255)); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'mail'); ?>
        <?php echo $form->textField($model, 'mail', array('maxlength' => 255)); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'percent_fee'); ?>
        <?php echo $form->textField($model, 'percent_fee'); ?>
				</div>
			
								
								
								
		
		
    </p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo Yii::t('app', 'Cancel'); ?></button>
    <?php echo TbHtml::submitButton(Yii::t('app', 'Buscar'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
  </div>
    <?php $this->endWidget(); ?>
</div>