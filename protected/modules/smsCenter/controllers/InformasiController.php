<?php

class InformasiController extends MyAuthController
{
  public $layout = '//layouts/main';
  public function actionInbox()
  {
    $model = new Inbox('search');
    $model->unsetAttributes();
    if (isset($_GET['Inbox']))
      $model->attributes = $_GET['Inbox'];

    $this->render('inbox', array(
      'model' => $model,
    ));
  }

  public function actionOutbox()
  {
    $model = new Outbox('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['Outbox']))
      $model->attributes = $_GET['Outbox'];

    $this->render('outbox', array(
      'model' => $model,
    ));
  }

  public function actionSentitems()
  {
    $model = new Sentitems('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['Sentitems']))
      $model->attributes = $_GET['Sentitems'];

    $this->render('sentitems', array(
      'model' => $model,
    ));
  }

  public function actionDeleteSms()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = array();
      $data['result'] = '';
      if (isset($_POST['delete'])) {
        foreach ($_POST['delete']['id'] as $i => $id) {
          if (isset($_POST['delete']['cekList'][$i])) {
            $delete = Outbox::model()->deleteAllByAttributes(array('ID' => $id));
            if ($delete)
              $data['result'] = 'success';
          }
        }
      }
      echo CJSON::encode($data);
    }
  }
}
