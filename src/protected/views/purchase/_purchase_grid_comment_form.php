<?php $form = $this->beginWidget(
    'CActiveForm', array(
    //'action' => Yii::app()->createUrl('/retail/dispatchnote/create'),
    //'enableAjaxValidation'=>true,
    )
);?>

<h3><?php echo $page_title;?></h3>


<?php $this->widget(
    'bootstrap.widgets.TbGridView', array(
    'id' => 'selectableGrid',
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'dataProvider' => $dataProvider,
    'ajaxUpdate'=>true,
    'beforeAjaxUpdate'=>'function(){setCheckedItems()}',
    'template' => "{items}\n{pager}",
    'columns' => array(
        array(
            'header' => 'html',
            'id' => 'purchase_selected',
            'class' => 'CCheckBoxColumn',
            'checked' => 'Helper::checkedInGrid($data->id)',
            'selectableRows' => '50',
            'selectableRows' => 2,
            'value' => '$data->id',
            'headerTemplate' => '<label>{item}<span></span></label>',
            'htmlOptions' => array('style' => 'width: 20px', 'class' => 'chandran'),
        ),
        array(
            'name' => 'contract_number',
            'htmlOptions' => array(
                'class' => 'text-right',
            ),
        ),
        'brand',
        'model',
        'imei',
        'user',

        // array(
        // 	'class' => 'TbButtonColumn',
        // 	'template' => '{view}',
        // ),
    ),
        )
);?>

	<div>
    <?php echo $form->labelEx($comment_model, 'comment');?>
    <?php echo $form->textArea($comment_model, 'comment', array('class' => 'span12', 'style' => 'height:200px'));?>
    <?php if ($comment_model->hasErrors('comment')) : ?>
			<div class="alert alert-block alert-error">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $form->error($comment_model, 'comment');?>
			</div>
        <?php 
endif;?>
	</div><!-- row -->

<?php echo TbHtml::submitButton(Yii::t('app', 'Save'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'class' => 'checks-submit', 'data-checkcolumn' => 'purchase_selected'));?>

<?php $this->endWidget();?>
