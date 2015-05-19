<?php

class AuthassignmentController extends Controller
{
    public $layout='//layouts/column2';
    
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
        'accessControl', // perform access control for CRUD operations
        'postOnly + delete', // we only allow deletion via POST request
        );
    }
    
    
    public function actionIndex()
    {
        $this->forward('admin');
    }

    public function actionCreate()
    {
        $model=new Authassignment;
    
        if(isset($_POST['Authassignment'])) {
            $model->attributes=$_POST['Authassignment'];
            if($model->validate()) {
                /* operacion para guardar las relaciones */
                try{
                    $auth = Yii::app()->authManager;
                    $auth->assign($model->itemname, $model->userid, $model->bizrule, $model->data);
                    $this->redirect(array('view','itemname'=>$model->itemname, 'userid'=>$model->userid));
                }catch(CDbException $e){
                    Yii::app()->user->setFlash('error', $e->getMessage());
                }
            }
        }
        
        $data['authitems'] = Helper::list_authitems_by_type(Authitem::ROLE);
        $data['users'] = Helper::list_users();
        

        $this->render(
            'create', array(
            'model'=>$model,
            'data'=>$data
            )
        );
    }


    public function actionView($itemname, $userid)
    {
        $model=$this->loadModel($itemname, $userid);
        $this->render('view', array('model'=>$model));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Authassignment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Authassignment'])) {
            $model->attributes=$_GET['Authassignment'];
        }

        $this->render(
            'admin', array(
            'model'=>$model,
            )
        );
    }

    /**
    * Deletes a particular model.
    * If deletion is successful, the browser will be redirected to the 'admin' page.
    * @param integer $id the ID of the model to be deleted
    */
    public function actionDelete($itemname, $userid)
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($itemname, $userid)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function loadModel($itemname, $userid)
    {
        $model=Authassignment::model()->findByPk(array('itemname'=>$itemname, 'userid'=>$userid));
        if($model==null) {
            throw new CHttpException(404, 'The requested page does not exist.'); 
        }
        return $model;
    }


    public function saveModel($model)
    {
        try
        {
            $model->save();
        }
        catch(Exception $e)
        {
            $this->showError($e);
        }
    }


    
    function showError(Exception $e)
    {
        // Error: 1022 SQLSTATE: 23000 (ER_DUP_KEY)
        if($e->getCode()==23000) {
            $message = "This operation is not permitted due to an existing foreign key reference.";
        }
        else
        {
            $message = "Invalid operation.";
        }
        throw new CHttpException($e->getCode(), $message);
    }
    
}