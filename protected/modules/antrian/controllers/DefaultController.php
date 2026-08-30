<?php

class DefaultController extends Controller
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Dashboard Antrian";
    $this->layout = '//layouts/mainNeonSidebar';
    $this->render('index');
  }
}
