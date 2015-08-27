<?php

Yii::import('application.models._base.BaseUser');
Yii::import('application.modules.rights.models.Authassignment');

class User extends BaseUser {

    public $old_password;
    public $new_password;
    public $repeat_password;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getArrayOfAllowedUSersIdToAdmin() {
        $criteria = new CDbCriteria;
        $criteria->select = 't.userid'; // select fields which you want in output
        $criteria->addNotInCondition('itemname', array('superuser'));

        $users = Authassignment::model()->findAll($criteria);

        $ids = array();

        foreach ($users as $user) {
            $ids[] = $user->userid;
        }

        return $ids;
    }

    public function relations() {
        return array(
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'point_of_sale' => array(self::BELONGS_TO, 'PointOfSale', 'point_of_sale_id'),
            'dispatch_note' => array(self::HAS_MANY, 'DispatchNote', 'user_create_id'),
            'purchase' => array(self::HAS_MANY, 'Purchase', 'user_id'),
            /* Log relations */
            'carrier_log' => array(self::HAS_MANY, 'Carrier', 'user_update_id'),
            'company_log' => array(self::HAS_MANY, 'Company', 'user_update_id'),
            'contract_log' => array(self::HAS_MANY, 'Contract', 'user_update_id'),
            'device_status_log' => array(self::HAS_MANY, 'DeviceStatus', 'user_update_id'),
            'distpatch_note_log' => array(self::HAS_MANY, 'DispatchNote', 'user_update_id'),
            'point_of_sale_log' => array(self::HAS_MANY, 'PointOfSale', 'user_update_id'),
            'price_list_log' => array(self::HAS_MANY, 'PriceList', 'user_update_id'),
            'purchase_log' => array(self::HAS_MANY, 'Purchase', 'user_update_id'),
            'purchase_status_log' => array(self::HAS_MANY, 'PurchaseStatus', 'user_update_id'),
            'seller_log' => array(self::HAS_MANY, 'Seller', 'user_update_id'),
            'status_log' => array(self::HAS_MANY, 'Status', 'user_update_id'),
            'authassignment' => array(self::HAS_MANY, 'Authassignment', 'userid'),
            'user_log' => array(self::BELONGS_TO, 'User', 'user_update_id'),
        );
    }

    public function rules() {
        return CMap::mergeArray(
                        parent::rules(), array(
                    array('username', 'unique'),
                    array('username', 'length', 'min' => 8),
                    array('company_id, point_of_sale_id', 'validarCompayAndPointOfSale'),
                    array('mail', 'email'),
                    array('mail', 'required'),
                    array('password', 'required', 'on' => 'update'),
                    array('old_password, new_password, repeat_password', 'required', 'on' => 'changePwd'),
                    array('old_password', 'findPasswords', 'on' => 'changePwd'),
                    array('repeat_password', 'compare', 'compareAttribute' => 'new_password', 'on' => 'changePwd'),
                    array('repeat_password', 'length', 'min' => 10, 'max' => 100, 'on' => 'changePwd'),
                    array('repeat_password', 'match', 'pattern' => '/\d/', 'message' => Yii::t('app', 'Contraseña debe contener al menos un digito'), 'on' => 'changePwd'),
                    array('repeat_password', 'match', 'pattern' => '/\W/', 'message' => Yii::t('app', 'Contraseña debe contener al menos un caracter especial'), 'on' => 'changePwd'),
                    array('repeat_password', 'match', 'pattern' => '/(?=.*[a-z])/', 'message' => Yii::t('app', 'Contraseña debe contener al menos una letra minúscula'), 'on' => 'changePwd'),
                    array('repeat_password', 'match', 'pattern' => '/(?=.*[A-Z])/', 'message' => Yii::t('app', 'Contraseña debe contener al menos una letra mayúscula'), 'on' => 'changePwd'),
        ));
    }

    public function validarCompayAndPointOfSale($attribute, $params) {
        if (!$this->$attribute) {
            $this->addError($attribute, 'Error en la seleccion de la compañia o punto de venta');
        }
        //die(var_dump($this->$attribute));
    }

    protected function beforeSave() {

//        if (!$this->isNewRecord){
//            if (!empty($this->password)) {
//                if (!isset($this->new_password)) {
//                    //si no viene de changepassword
//                    $this->password = $this->hashPassword($this->password_generated);
//                } else {
//                    // viene de changepassword
//                    $this->is_password_validated = 1;
//                }
//            }
//        }
        if (!$this->is_password_validated){
            //todavia tiene contraseña autogenerada
            $this->password = $this->hashPassword($this->password_generated);
            if(isset($this->new_password)){
                $this->password = $this->hashPassword($this->new_password);
                $this->is_password_validated = 1;
            }
        }
        $this->username = strtolower($this->username);
        return parent::beforeSave();
    }

    public function resetPassword() {
        // genera password random
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $randomPass = '';
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, strlen($alphabet) - 1);
            $randomPass .= $alphabet[$n];
        }
        $this->password_generated = $randomPass;
        $this->is_password_validated = 0;
        $this->password = $this->hashPassword($this->password_generated);
    }

    /**
     * ADMIN DataProvider
     */
    public function admin() {

        if (!Yii::app()->user->checkAccess('admin')) {
            return false;
        }
        $criteria = $this->search()->getCriteria();

        if (!Yii::app()->user->checkAccess('superuser')) {
            $criteria->addInCondition('id', self::getArrayOfAllowedUSersIdToAdmin());
        }


        return new CActiveDataProvider(
                $this, array(
            'criteria' => $criteria,
                )
        );
    }

    public function findPasswords($attribute, $params) {
        $user = User::model()->findByPk(Yii::app()->user->id);
        //if ($user->password != md5($this->old_password))
        if (!($this->validateOldPassword($this->old_password, $user->password))) {
            $this->addError($attribute, Yii::t('app', 'La contraseña anterior es incorrecta.'));
        }
    }

    public function validateOldPassword($password_old, $password) {
        return CPasswordHelper::verifyPassword($password_old, $password);
    }

    public function validatePassword($password) {
        return CPasswordHelper::verifyPassword($password, $this->password);
    }

    public function hashPassword($password) {
        return CPasswordHelper::hashPassword($password);
    }

    public function getListData() {
        $criteria = new CDbCriteria;
        if (Yii::app()->user->checkAccess('admin')) {
            $criteria->addInCondition('id', self::getArrayOfAllowedUSersIdToAdmin());
        }
        return $this->findAll($criteria, true);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Usuario|Usuarios', $n);
    }

    public function attributeLabels() {
        return CMap::mergeArray(
                        parent::attributeLabels(), array(
                    'user_update_id' => Yii::t('app', 'Usuario|Usuaios', 1),
                    'company_id' => Yii::t('app', 'Empresa'),
                    'point_of_sale_id' => Yii::t('app', 'Cabecera'),
                    'username' => Yii::t('app', 'Usuario'),
                    'password' => Yii::t('app', 'Contraseña'),
                    'last_login' => Yii::t('app', 'Último login'),
                    'employee_identification' => Yii::t('app', 'Código de empleado'),
                    'password_generated' => Yii::t('app', 'Contraseña autogenerada'),
                    'old_password' => Yii::t('app', 'Contraseña actual'),
                    'new_password' => Yii::t('app', 'Nueva contraseña'),
                    'repeat_password' => Yii::t('app', 'Repetir contraseña'),
                    'is_password_validated' => Yii::t('app', 'Contraseña validada'),
        ));
    }

}
