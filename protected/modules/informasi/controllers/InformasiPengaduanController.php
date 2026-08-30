<?php

/**
 * digunakan untuk informasi pengaduan
 * @author rusdiyanto <rusdiyanto@.com>
 * @package application.modules.informasi
 * @subpackage controllers 
 */
class InformasiPengaduanController extends MyAuthController
{
  public $path_view = 'informasi.views.informasiPengaduan.';
  /**
   * digunakan untuk select data 
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Informasi Pengaduan Pelayanan";
    $model = new LaporanrekappengaduanV();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $format = new MyFormatter();
    $model->unsetAttributes();
    if (isset($_GET['LaporanrekappengaduanV'])) {
      $model->attributes = $_GET['LaporanrekappengaduanV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['LaporanrekappengaduanV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['LaporanrekappengaduanV']['tgl_akhir']);
      $model->nama_pasien = $_GET['LaporanrekappengaduanV']['nama_pasien'];
      $model->lookup = isset($_GET['LaporanrekappengaduanV']['lookup']) ? $_GET['LaporanrekappengaduanV']['lookup'] : " ";
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'format' => $format
    ));
  }

  /**
   * fungsi untuk delete kepuasan pasien
   */
  public function actionBatal()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $result = array();
      $status = 'gagal';
      $kepuasanpasien_id = isset($_POST['id']) ? $_POST['id'] : null;

      $modKepuasanpasien = KepuasanpasienT::model()->findByPk($kepuasanpasien_id);

      if (!empty($modKepuasanpasien)) {
        if ($modKepuasanpasien->delete()) {
          $status = 'berhasil';
        }
      }
      $result['status'] = $status;
      echo CJSON::encode($result);
    }
    Yii::app()->end();
  }
  /**
   * digunakan untuk detail informasi
   * @param integer $id
   */
  public function actionDetail($id)
  {
    $this->layout = '//layouts/iframe';
    if (isset($id)) {
      $model = INKepuasanpasienT::model()->findByPk($id);
      if (!empty($model->pasien_id)) {
        $pasien = PasienM::model()->findByPk($model->pasien_id);
        $model->nama_pasien = $pasien->nama_pasien;
        $model->no_rekam_medik = $pasien->no_rekam_medik;
        $modid = LayanansurveiM::model()->findByPk($model->layanansurvei_id);
        $model->instalasi_id = $modid->instalasi_id;
        $model->ruangan_id = $modid->ruangan_id;
      }
    } else {
      $model = new INKepuasanpasienT();
    }
    $this->render($this->path_view . 'detail/index', array(
      'model' => $model,
    ));
  }
}
