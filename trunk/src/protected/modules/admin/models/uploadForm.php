<?php
class uploadForm extends CFormModel
{
    public $file;
    // ... other attributes
 
    public function rules()
    {
        return array(
            array('file', 'file', 'types'=>'xlsx, xls', 'wrongType' => 'El tipo de archivo no es valido'),
        );
    }
}