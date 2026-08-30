<?php
class DownloadAntrianController extends MyAuthController
{
  public $layout = '//layouts/mainNeonSidebar';

  public function actionIndex()
  {

    $this->render('index', array());
  }
}
