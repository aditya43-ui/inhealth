<?php
class InformasiMcuKaryawanController extends MyAuthController
{
  public $layout = '//layouts/column1';
  protected $path_view = "kepegawaian.views.informasiMcuKaryawan.";
  
  public function actionIndex()
  {
    $model = new InformasimcukaryawanV();
    $format = new MyFormatter();
    $model->periodemcu = date('Y');

    if (isset($_GET['InformasimcukaryawanV'])) {
      $model->attributes = $_GET['InformasimcukaryawanV'];
    }

    $this->render($this->path_view . 'index', array('model' => $model));
  }


}
