<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class StepQuestionaryForm extends CFormModel
{
    public $questionary;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
        // username and password are required
        array('questionary', 'boolean'),
        array('questionary', 'validateQuestionary'),
        );
    }

    public function validateQuestionary($attribute,$params)
    {
        if (!$this->$attribute) {
            $this->addError($attribute, 'No cumple con todos los requisitos.');
        }
    }


    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
        'questionary' => '¿El titular y el equípo cumplen con todos los requisitos enumerados?',
        );
    }
}
