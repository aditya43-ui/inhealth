<?php
//copy dari ambulans/InformasiPemakaianAmbulans
class InformasiPemakaianMobilController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pemakaian Mobil Jenazah";
    $model = new PJInformasipemakaianambulansV;
    $format = new MyFormatter;
    $model->tgl_awal  = date('Y-m-d');
    $model->tgl_akhir  = date('Y-m-d');
    if (isset($_GET['PJInformasipemakaianambulansV'])) {
      $model->unsetAttributes();
      $model->attributes = $_GET['PJInformasipemakaianambulansV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJInformasipemakaianambulansV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJInformasipemakaianambulansV']['tgl_akhir']);
    }
    $this->render('index', array('model' => $model, 'format' => $format));
  }

  public function actionView($pemakaianambulans_id)
  {
    $this->layout = '//layouts/iframe';
    $model = PJInformasipemakaianambulansV::model()->findByAttributes(array('pemakaianambulans_id' => $pemakaianambulans_id));
    $format = new MyFormatter;
    $this->render('view', array('model' => $model, 'format' => $format));
  }

  public function actionBatalPakai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $result = array();
      $status = 'gagal';
      $pemakaian_id = isset($_POST['pemakaian_id']) ? $_POST['pemakaian_id'] : null;
      $pemesanan_id = isset($_POST['pemesanan_id']) ? $_POST['pemesanan_id'] : null;
      $modPemakaiAmbulans = PemakaianambulansT::model()->findByPk($pemakaian_id);
      $modPemesananambulans = PesanambulansT::model()->findByAttributes(array('pemakaianambulans_id' => $pemakaian_id));

      if (!empty($pemesanan_id)) {
        $updatePemakaian = PemakaianambulansT::model()->updateByPk($pemakaian_id, array('pesanambulans_t' => null));
        $updatePemesanan = PesanambulansT::model()->updateByPk($pemesanan_id, array('pemakaianambulans_id' => null));
        if ($updatePemakaian && $updatePemesanan) {
          $deletePemakaian = PemakaianambulansT::model()->deleteByPk($pemakaian_id);
          $status = 'berhasil';
        } else {
          $status = 'gagal';
        }
      } else {
        $deletePemakaian = PemakaianambulansT::model()->deleteByPk($pemakaian_id);
        $status = 'berhasil';
      }

      $result['status'] = $status;
      echo CJSON::encode($result);
    }
    Yii::app()->end();
  }

  public function actionPrintDetail($pemakaianambulans_id)
  {
    $this->layout = '//layouts/printWindows';
    $model = PJInformasipemakaianambulansV::model()->findByAttributes(array('pemakaianambulans_id' => $pemakaianambulans_id));
    $format = new MyFormatter;

    $judul_print = 'Detail Pemakaian Mobil Jenazah';
    $this->render('print', array(
      'format' => $format,
      'model' => $model,
      'judul_print' => $judul_print,
    ));
  }
}
