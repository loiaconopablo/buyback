<?php

class AuthController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions() 
    {
        return array(

        );
    }

    /**
     * Displays the login page
     */
    public function actionLogin() 
    {

        $model = new LoginForm;

        $this->layout = false;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        $data['showNewpassword'] = 0;
        $data['successNewpassword'] = 0;
        // collect user input data

        if (isset($_POST['LoginForm'])) {

            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $this->redirect(Home::getRoleHome());
            }

        }

        // display the login form
        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($baseUrl . '/css/bgh.css');
        $this->render('login', array('model' => $model, 'data' => $data));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() 
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionChangepassword($id) 
    {
        //die(Yii::app()->user->id . ' - ' . $id);
        if (Yii::app()->user->id != $id) {
            $this->redirect(array('logout'));
        }

        $this->layout = false;

        $model = new User;

        $model = User::model()->findByAttributes(array('id' => $id));
        $model->setScenario('changePwd');

        if (isset($_POST['User'])) {

            $model->attributes = $_POST['User'];
            $valid = $model->validate();

            if ($valid) {
                $model->password = $model->hashPassword($model->new_password);

                if ($model->save()) {
                    Yii::app()->user->setFlash('success', 'Su password fue actualizado con exito!');

                    $this->redirect(Home::getRoleHome());
                } else {
                    Yii::app()->user->setFlash('success', 'Su password no pudo ser actualizado');
                    //$this->redirect(array('changepassword','id'=>$id));
                }
            }
        }

        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($baseUrl . '/css/bgh.css');

        $this->render('changepassword', array('model' => $model));
    }

}