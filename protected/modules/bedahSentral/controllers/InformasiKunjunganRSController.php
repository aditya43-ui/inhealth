<?php

class InformasiKunjunganRSController extends MyAuthController
{
  public function actionIndex()
  {
    //        RND-6303
    //        PQPLogRoute::logMemory("memory used after action call");
    //        try {
    //            Yii::beginProfile('Execution time');
    //            Yii::log('Begin logging data');
    //            PQPLogRoute::logMemory($this, "the site controller");
    //            $arr = array('Name' => 'Ryan', 'Last' => 'Campbell');
    //            Yii::log(CVarDumper::dumpAsString($arr));
    //            PQPLogRoute::logMemory($arr, "Normal array");
    //            $models = BSInfokunjunganrjrdriV::model()->findAll();
    //            PQPLogRoute::logMemory($models, "Users array");
    //
    //            Yii::endProfile('Execution time');
    //            throw new Exception('Unable to write to log!');
    //        }
    //        catch(Exception $e) {
    //            Yii::log($e, CLogger::LEVEL_ERROR);
    //        }
    $this->pageTitle = Yii::app()->name . " - Kunjungan Rumah Sakity";
    $format = new MyFormatter();
    $model = new BSInfokunjunganrjrdriV;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['BSInfokunjunganrjrdriV'])) {
      $model->attributes = $_GET['BSInfokunjunganrjrdriV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSInfokunjunganrjrdriV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSInfokunjunganrjrdriV']['tgl_akhir']);
    }
    $this->render('index', array('model' => $model, 'format' => $format));
  }
}
