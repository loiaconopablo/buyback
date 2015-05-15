<?php

class AuthitemchildController extends Controller
{
    
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
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
        $model=new Authitemchild;
    
        if(isset($_POST['Authitemchild'])) {
            $model->attributes=$_POST['Authitemchild'];
            if($model->validate()) {
                /* operacion normal para guardar datos de un modelo de clave compuesta*/
                //$this->saveModel($model);
                //$this->redirect(array('view','parent'=>$model->parent, 'child'=>$model->child));
                
                /* operacion para guardar las relaciones */
                try {
                    $auth = Yii::app()->authManager;
                    $auth->addItemChild($model->parent, $model->child);
                    $this->redirect(
                        array (
                        'view',
                        'parent' => $model->parent,
                        'child' => $model->child 
                        ) 
                    );
                } catch ( CDbException $e ) {
                    Yii::app()->user->setFlash('error', $e->getMessage());
                }
            }
        }
        
        $data['authitems'] = Helper::list_authitems();
        

        $this->render(
            'create', array(
            'model'=>$model,
            'data'=>$data
            )
        );
    }

    // public function actionUpdate($id)
    // {
    // 	$this->forward('view', array('id' => $id));
    // }

    /**
    * Deletes a particular model.
    * If deletion is successful, the browser will be redirected to the 'admin' page.
    * @param integer $id the ID of the model to be deleted
    */
    public function actionDelete($parent, $child)
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($parent, $child)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }


    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Authitemchild('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Authitemchild'])) {
            $model->attributes=$_GET['Authitemchild'];
        }

        $this->render(
            'admin', array(
            'model'=>$model,
            )
        );
    }

    public function actionView($parent, $child)
    {
        $model=$this->loadModel($parent, $child);
        $this->render('view', array('model'=>$model));
    }

    public function loadModel($parent, $child)
    {
        $model=Authitemchild::model()->findByPk(array('parent'=>$parent, 'child'=>$child));
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