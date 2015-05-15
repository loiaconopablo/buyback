<!-- Modal -->
<div id="searchModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo Yii::t('app', 'Advanced Search'); ?></h3>
  </div>
    <?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    )
); ?>
  <div class="modal-body">
    <p>
    	<p><?php echo Yii::t('app', 'You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.'); ?></p>

															<div>
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id', array('maxlength' => 10)); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'company_id'); ?>
        <?php echo $form->dropDownList($model, 'company_id', GxHtml::listDataEx(Company::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'is_headquarter'); ?>
        <?php echo $form->dropDownList($model, 'is_headquarter', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'headquarter_id'); ?>
        <?php echo $form->dropDownList($model, 'headquarter_id', GxHtml::listDataEx(PointOfSale::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
				</div>
			
															<div>
        <?php echo $form->label($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('maxlength' => 255)); ?>
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
			
								
								
								
		
		
    </p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo Yii::t('app', 'Cancel'); ?></button>
    <?php echo TbHtml::submitButton(Yii::t('app', 'Search'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
  </div>
    <?php $this->endWidget(); ?>
</div>