<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {
	private $_id;
	public function authenticate() {
		
		
		$record = User::model()->findByAttributes ( array (
				'username' => $this->username 
		) );
		
		if ($record === null)
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		else if(!$record->validatePassword($this->password))
		//else if ($record->password !== md5 ( $this->password ))
		//else if ($record->password !==  $this->password )
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		else {
			
						
			$this->_id = $record->id;
			$this->setState ('username', $record->username );
			$this->setState ('company_id', $record->company_id );
			$this->setState ('point_of_sale_id', $record->point_of_sale_id );
			$this->setState ('employee_identification', $record->employee_identification );
			
			
			$company = Company::model()->findByPk($record->company_id);

			$this->setState ('company_name', $company->name);

			$this->setState ( 'ispasswordvalidated', $record->is_password_validated );

			$point_of_sale = PointOfSale::model()->findByPk($record->point_of_sale_id);

			$this->setState ('is_headquarter', $point_of_sale->is_headquarter);

			$this->setState ('headquarter_id', $point_of_sale->headquarter_id);

			$this->setState ('point_of_sale_name', $point_of_sale->name);
				
			$this->errorCode = self::ERROR_NONE;
			
			
		}
		return ! $this->errorCode;
	}
	public function getId() {
		return $this->_id;
	}
}