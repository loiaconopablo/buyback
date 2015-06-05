<?php
class AutoLogBehavior extends CActiveRecordBehavior
{
 
    /**
    * The field that stores the creation time
    */
    // $created = 'created_at';
    /**
    * The field that stores the modification time
    */
    //public $modified = 'updated_at';
 
 
    public function beforeValidate($on)
    {

        if ($this->Owner->isNewRecord) {
            // Guarda el timestamp de la fecha de creacion
            if ($this->Owner->hasAttribute($this->Owner->created_log_field)) {
                $this->Owner->{$this->Owner->created_log_field} = new CDbExpression('NOW()');
            }
            // Guarda el id del usuario de creacion
            if ($this->Owner->hasAttribute('user_create_id')) {
                $this->Owner->user_create_id = Yii::app()->user->id;
            }
        } else {
            if ($this->Owner->hasAttribute($this->Owner->updated_log_field)) {
                $this->Owner->{$this->Owner->updated_log_field} = new CDbExpression('NOW()');
            }

        }

        if ($this->Owner->hasAttribute($this->Owner->user_update_log_field)) {
            $this->Owner->{$this->Owner->user_update_log_field} = Yii::app()->user->id;
        }
             
        return true;
    }
}
