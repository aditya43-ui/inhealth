<?php

class KonfigemailKController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  //public $layout='//layouts/column2';

  /**
   * @return array action filters
   */
  public function filters()
  {
    return array(
      'accessControl', // perform access control for CRUD operations
    );
  }

  /**
   * Specifies the access control rules.
   * This method is used by the 'accessControl' filter.
   * @return array access control rules
   */
  public function accessRules()
  {
    return array(
      array(
        'allow',  // allow all users to perform 'index' and 'view' actions
        'actions' => array('index', 'view'),
        'users' => array('*'),
      ),
      array(
        'allow', // allow authenticated user to perform 'create' and 'update' actions
        'actions' => array('create', 'update'),
        'users' => array('@'),
      ),
      array(
        'allow', // allow admin user to perform 'admin' and 'delete' actions
        'actions' => array('admin', 'delete'),
        'users' => array('admin'),
      ),
      array(
        'deny',  // deny all users
        'users' => array('*'),
      ),
    );
  }

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
    $model = KonfigemailK::model()->findByPk(Params::getDefaultProfilRS());

    if (!empty($model)) {
      $this->redirect(array('update', 'modul_id' => Yii::app()->user->getState('modul_id')));
    }

    $model = new KonfigemailK;
    $model->konfigemail_send_type = Params::KONFIG_EMAIL_TIPE_KIRIM_SMTP;
    $model->konfigemail_oauth_type = Params::KONFIG_EMAIL_OAUTH;
    // Uncomment the following line if AJAX validation is needed		

    if (isset($_POST['KonfigemailK'])) {
      $ok = true;
      $trans = Yii::app()->db->beginTransaction();
      try {

        $model->attributes = $_POST['KonfigemailK'];
        $model->profilrs_id = Params::getDefaultProfilRS();
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $ok = $ok && $model->save();

        if ($ok) {
          Yii::app()->user->setFlash('success', "Data Has Been Saved.");
          $trans->commit();
          $this->redirect(array('update'));
        } else {
          Yii::app()->user->setFlash('error', "Some Data failed to be saved. ");
          $trans->rollback();
        }
      } catch (Exception $exc) {

        Yii::app()->user->setFlash('error', "Some Data failed to be saved. <br/>" . $exc->getMessage() . " ");
        $trans->rollback();
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
  public function actionUpdate()
  {
    $model = KonfigemailK::model()->findByPk(Params::getDefaultProfilRS());

    if (empty($model)) {
      $this->redirect(array('create', 'modul_id' => Yii::app()->user->getState('modul_id')));
    }
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['KonfigemailK'])) {
      $ok = true;
      $trans = Yii::app()->db->beginTransaction();
      try {

        $model->attributes = $_POST['KonfigemailK'];
        $model->update_time = date('Y-m-d H:i:s');
        $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $ok = $ok && $model->save();

        if ($ok) {
          Yii::app()->user->setFlash('success', "Data Has Been Saved.");
          $trans->commit();
          $this->redirect(array('update'));
        } else {
          Yii::app()->user->setFlash('error', "Some Data failed to be saved.");
          $trans->rollback();
        }
      } catch (Exception $exc) {

        Yii::app()->user->setFlash('error', "Some Data failed to be saved.");
        $trans->rollback();
      }
    }

    $this->render('update', array(
      'model' => $model,
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
    $model = KonfigemailK::model()->findByPk(Params::getDefaultProfilRS());

    if (!empty($model)) {
      $this->redirect(array('update', 'modul_id' => Yii::app()->user->getState('modul_id')));
    } else {
      $this->redirect(array('create', 'modul_id' => Yii::app()->user->getState('modul_id')));
    }

    $dataProvider = new CActiveDataProvider('KonfigemailK');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = KonfigemailK::model()->findByPk(Params::getDefaultProfilRS());

    if (!empty($model)) {
      $this->redirect(array('update', 'modul_id' => Yii::app()->user->getState('modul_id')));
    } else {
      $this->redirect(array('create', 'modul_id' => Yii::app()->user->getState('modul_id')));
    }

    $model = new KonfigemailK('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KonfigemailK']))
      $model->attributes = $_GET['KonfigemailK'];

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
    $model = KonfigemailK::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'konfigemail-k-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
}
