<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class StepCarrierForm extends CFormModel
{
	public $unlocked;
	public $carrier;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('unlocked', 'boolean'),
			array('carrier', 'validateCarrier'),
		);
	}

	public function validateCarrier($attribute,$params)
	{
		if (!$this->unlocked) {
			if (!$this->carrier) {
				$this->addError($attribute, 'Si el equipo no esta liberado debe indicar a que operador pertenece.');
			}
		}
	}
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'unlocked' => 'Liberado',
			'carrier' => Yii::t('app', 'Carrier|Carriers', 1),
		);
	}
}