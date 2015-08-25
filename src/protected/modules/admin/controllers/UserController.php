<?php

Yii::import('rights.models.*');

class UserController extends Controller {

    public function actionView($id) {
        $this->render(
                'view', array(
            'model' => User::model()->findByPk($id),
                )
        );
    }

    public function actionCreate() {
        $model = new User;

        if (isset($_POST['User'])) {
            $model->setAttributes($_POST['User']);
            if ($model->validate()) {
                $model->resetPassword();
                $model->save();
                if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                    Yii::app()->end();
                } else {

                    if ($this->saveAuthassigment($model, $_POST['Authassignment']['itemname'])) {
                        $this->redirect(array('view', 'id' => $model->id));
                    }
                }
            }
        }

        $Authitem = new Authitem;

        $roles = $Authitem->getRoles();

        $Authassignment_model = new Authassignment;

        $this->render('create', array('model' => $model, 'Authassignment_model' => $Authassignment_model, 'roles' => $roles));
    }

    public function actionUpdate($id) {
        $model = User::model()->findByPk($id);

        if (isset($_POST['User'])) {
            if (isset($_POST['submit'])) {
                $model->setAttributes($_POST['User']);

                if (empty($model->password)) {
                    if ($model->save(true, array('company_id', 'username', 'mail', 'point_of_sale_id', 'employee_identification'))) {
                        if ($this->saveAuthassigment($model, $_POST['Authassignment']['itemname'])) {
                            $this->redirect(array('view', 'id' => $model->id));
                        }
                    }
                } else {
                    if ($model->save()) {
                        $this->redirect(array('view', 'id' => $model->id));
                    }
                }
            } elseif (isset($_POST['resetPass'])) {
                if ($model->validate()) {
                    $model->resetPassword();
                    $model->save();
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
        }

        $Authitem = new Authitem;

        $roles = $Authitem->getRoles();

        $Authassignment_model = new Authassignment;

        if ($Authassignment_item = $Authassignment_model->findByAttributes(array('userid' => $model->id))) {
            $Authassignment_model->itemname = $Authassignment_item->itemname;
        }

        $this->render('update', array('model' => $model, 'Authassignment_model' => $Authassignment_model, 'roles' => $roles));
    }

    public function actionDelete($id) {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            User::model()->findByPk($id)->delete();

            if ($authassigmen_item = Authassignment::model()->findByAttributes(array('userid' => $id))) {
                $authassigmen_item->delete();
            }

            if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
                $this->redirect(array('admin'));
            }
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    public function actionIndex() {
        $this->redirect(array('admin'));
    }

    public function actionAdmin() {
        $model = new User('search');
        $model->unsetAttributes();

        if (isset($_GET['User'])) {
            $model->setAttributes($_GET['User']);
        }

        $this->render(
                'admin', array(
            'model' => $model,
                )
        );
    }

    public function saveAuthassigment($user, $itemname) {
        $model = new Authassignment;

        if ($authassigmen_item = $model->findByAttributes(array('userid' => $user->id))) {
            $authassigmen_item->delete();
        }

        $model->itemname = $itemname;
        $model->userid = $user->id;

        if ($model->validate()) {
            /* operacion para guardar las relaciones */
            try {
                $auth = Yii::app()->authManager;
                $auth->assign($model->itemname, $model->userid, $model->bizrule, $model->data);

                return true;
            } catch (CDbException $e) {
                Yii::app()->user->setFlash('error', $e->getMessage());
                return false;
            }
        }
    }

}
