<?php
class InformasiPelatihanController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

  /**
   * Informasi Rencana Pelatihan
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Rencana Pelatihan";
    $model = new KPRencanadiklatT();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['KPRencanadiklatT'])) {
      $model->attributes = $_GET['KPRencanadiklatT'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KPRencanadiklatT']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KPRencanadiklatT']['tgl_akhir']);
    }

    $this->render('index', array('model' => $model));
  }

  public function actionDetail($id)
  {
    $this->layout = '//layouts/iframe';

    $model = KPRencanadiklatT::model()->findByPk($id);
    $modBiaya = KPBiayapelatihanT::model()->findByAttributes(array(
      'rencanadiklat_id' => $id,
    ));
    $modDetail = KPRencanadiklatdetT::model()->findAllByAttributes(array(
      'rencanadiklat_id' => $id,
    ));

    $this->render('detail', array(
      'model' => $model,
      'modBiaya' => $modBiaya,
      'modDetail' => $modDetail,
    ));
  }

  /**
   * Informasi Realisasi Pelatihan
   */
  public function actionRealisasi()
  {
    $this->pageTitle = Yii::app()->name . " - Realisasi Pelatihan";
    $model = new KPRealisasidiklatT();
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['KPRealisasidiklatT'])) {
      $model->attributes = $_GET['KPRealisasidiklatT'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KPRealisasidiklatT']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KPRealisasidiklatT']['tgl_akhir']);
    }

    $this->render('realisasi', array('model' => $model));
  }

  public function actionDetailRealisasi($id)
  {
    $details = array();
    $modPrograms = array();
    $format = new MyFormatter();

    $model = RealisasidiklatT::model()->findByPk($id);
    $modDetail = PegawaidiklatT::model()->findAllByAttributes(array(
      'realisasidiklat_id' => $id
    ));
    $modBiaya = RealisasibiayapelT::model()->findByAttributes(array(
      'realisasidiklat_id' => $id
    ));


    $judulLaporan = 'Realisasi Pelatihan Pegawai';
    $deskripsi = $model->norealisasi;
    //if($caraPrint=='PRINT') {
    $this->layout = '//layouts/iframe';
    $this->render('kepegawaian.views.realisasiPelatihanT.Print', array(
      'model' => $model,
      'modBiaya' => $modBiaya,
      'format' => $format,
      'modDetail' => $modDetail,
      'deskripsi' => $deskripsi,
      'judulLaporan' => $judulLaporan,
      'caraPrint' => '',
    ));
    //}
  }

  public function actionBatalRencana()
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $id = $_POST['id'];

    $ok = 1;
    $msg = "Rencana pelatihan sudah dibatalkan";

    if (!RencanadiklatT::model()->updateByPk($id, array(
      'status_rencana' => Params::STATUS_RENCANA_DIKLAT_BATAL,
    ))) {
      $ok = 0;
      $msg = "Tidak dapat membatalkan rencana pelatihan";
    } else {
      // status tambahan
    }

    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
  }


  public function actionPrintNota($id)
  {
    $this->layout = '//layouts/iframe';

    $model = KPRencanadiklatT::model()->findByPk($id);
    $modBiaya = KPBiayapelatihanT::model()->findByAttributes(array(
      'rencanadiklat_id' => $id,
    ));
    $modDetail = KPRencanadiklatdetT::model()->findAllByAttributes(array(
      'rencanadiklat_id' => $id,
    ));

    $this->render('printNota', array(
      'model' => $model,
      'modBiaya' => $modBiaya,
      'modDetail' => $modDetail,
    ));
  }
}
