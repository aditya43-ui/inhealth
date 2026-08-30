<?php

class InformasiVisiteDokterController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Visite Dokter";
    $format = new MyFormatter();
    $model = new RIInformasivisitedokterV;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['RIInformasivisitedokterV'])) {
      $model->attributes = $_GET['RIInformasivisitedokterV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RIInformasivisitedokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RIInformasivisitedokterV']['tgl_akhir']);
    }
    $this->render('index', array('format' => $format, 'model' => $model));
  }

  /**
   * untuk menampilkan data dokter dari autocomplete
   * - nama_pegawai
   */
  public function actionAutocompleteDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nama_pegawai = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->order = 'nama_pegawai';
      $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
      $criteria->limit = 5;

      $models = RIDokterV::model()->findAll($criteria); //default
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->NamaLengkap;
        $returnVal[$i]['value'] = $model->NamaLengkap;
        $returnVal[$i]['pegawai_id'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
