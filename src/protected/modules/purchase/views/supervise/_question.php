<div class="form-inline">
    <?php echo Yii::t('app', $question->question); ?>
</div>
<div>
    <?php echo TbHtml::inlineRadioButtonList('question['. $question->id .']', '', array(
        '1' => Yii::t('app', 'Si'),
        '0' => Yii::t('app', 'No'),
    )); ?>
</div>