<?php
class uploadForm extends CFormModel
{
    public $file;
    // ... other attributes
 
    public function rules()
    {
        return array(
            array('file', 'file', 'types'=>'xlsx, xls', 'wrongType' => Yii::t('app', 'Invalid file type')),
        );
    }
}
