<?php
Yii::import('billingKasir.models.*');
Yii::import('billingKasir.controllers.RinciantagihanpasienVController');
class RinciantagihanpasienVRDController extends RinciantagihanpasienVController
{
  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new RDInfokunjunganrdV('search');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['RDInfokunjunganrdV'])) {
      $model->attributes = $_GET['RDInfokunjunganrdV'];
      $model->statusBayar = $_GET['RDInfokunjunganrdV']['statusBayar'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['RDInfokunjunganrdV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDInfokunjunganrdV']['tgl_akhir']);
      $model->pegawai_id = $_GET['RDInfokunjunganrdV']['pegawai_id'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->prefix_pendaftaran = $_GET['RDInfokunjunganrdV']['prefix_pendaftaran'];
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial('rawatJalan.views.rinciantagihanpasienV._tableRinciantagihan', array('model' => $model));
    } else {
      $this->render('rawatJalan.views.rinciantagihanpasienV.index', array(
        'model' => $model,
      ));
    }
  }
}
