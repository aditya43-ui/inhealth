<?php

class UserController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    $model = new User;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['User'])) {
      $model->attributes = $_POST['User'];
      $model->password = $model->new_password;
      $model->setScenario('insert');
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->user_id));
      }
    }

    $this->render('create', array(
      'model' => $model,
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['User'])) {

      $model->attributes = $_POST['User'];
      $model->old_password = $_POST['User']['old_password'];
      // if a new password has been entered
      if (!empty($model->new_password) || !empty($model->new_password_repeat) || !empty($model->old_password)) {
        // set scenario 'changePassword' in order 
        // for the compare validator to be called
        $model->setScenario('changePassword');
      } else {
        $model->setScenario('update');
      }


      if ($model->validate()) {

        if ($model->new_password !== '' && $model->old_password !== '') {

          if ($model->password == $model->encrypt($model->old_password)) {
            $model->password = $model->encrypt($model->new_password);
          } else {
            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Password yang Anda inputkan tidak sesuai dengan database.');
            $this->redirect(array('update', 'id' => $model->user_id));
          }
        }
        // the validation has already been done, skipping it with save(false):
        if ($model->update()) {
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('admin', 'id' => $model->user_id));
        }
      }
    }

    $this->render('update', array(
      'model' => $model,
      'postState' => $postState,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('User');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new User('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['User']))
      $model->attributes = $_GET['User'];

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = User::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
}
