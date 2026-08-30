<?php

class DefaultController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Dashboard SMS Center";
    $this->layout = "//layouts/mainNeonSidebar";
    $data['awal'] = 1;
    $data['jumlah'] = 10;
    $id = null;
    //echo '<pre>'.print_r($_GET,1).'</pre>';
    //echo '<pre>'.print_r($_POST,1).'</pre>';
    if (isset($_POST['step'])) {
      $id = $_POST['step'];
      //echo $id; exit;
    }
    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $data = $this->renderPartial('_bawah', array('step' => $id, 'data' => $data));
        echo $data;
        Yii::app()->end();
      }
    }
    $this->render('index', array('step' => $id, 'data' => $data));
  }
}
