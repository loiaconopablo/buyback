<?php 
class WebUser extends CWebUser
{
    /**
     * Overrides a Yii method that is used for roles in controllers (accessRules).
     *
     * @param  string $operation Name of the operation required (here, a role).
     * @param  mixed  $params    (opt) Parameters for this operation, usually the object to access.
     * @return bool Permission granted?
     */
        
    public function getUsername()
    {
        return $this->getState("username");
    }
    public function getIspasswordvalidated()
    {
        return $this->getState("ispasswordvalidated");
    }
    
}
