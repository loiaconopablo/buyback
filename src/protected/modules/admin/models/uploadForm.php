<?php
class uploadForm extends CFormModel
{
    public $file;
    public $company_id;
    // ... other attributes
 
    public function rules()
    {
        return array(
        	array('company_id', 'required'),
            array('file', 'file', 'types'=>'xlsx, xls', 'wrongType' => Yii::t('app', 'Invalid file type')),
        );
    }
}
