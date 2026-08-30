<?php

/**
 *       - controller ini untuk extends ke controller pemeriksaan rujukan keluar
 *       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *       @website	<piindonesia.co.id>
 */

class PemeriksaanRujukanKeluarController extends MyAuthController
{
  public $path_view = 'radiologi.views.pemeriksaanRujukanKeluar.';

  /**
   * - digunakan untuk mengakses menu pemeriksaan rujukan keluar
   * 
   */
  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Pemeriksaan Rujukan Keluar";
    $model = new ROinforujukankeluar_v;
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');

    if (isset($_GET['ROinforujukankeluar_v'])) {
      $model->tgl_awal = isset($_GET['ROinforujukankeluar_v']['tgl_awal']) ? MyFormatter::formatDateTimeForDb($_GET['ROinforujukankeluar_v']['tgl_awal']) : null;
      $model->tgl_akhir = isset($_GET['ROinforujukankeluar_v']['tgl_akhir']) ? MyFormatter::formatDateTimeForDb($_GET['ROinforujukankeluar_v']['tgl_akhir']) : null;
      $model->no_rekam_medik = isset($_GET['ROinforujukankeluar_v']['no_rekam_medik']) ? $_GET['ROinforujukankeluar_v']['no_rekam_medik'] : null;
      $model->no_pendaftaran = isset($_GET['ROinforujukankeluar_v']['no_pendaftaran']) ? $_GET['ROinforujukankeluar_v']['no_pendaftaran'] : null;
      $model->nama_pasien = isset($_GET['ROinforujukankeluar_v']['nama_pasien']) ? $_GET['ROinforujukankeluar_v']['nama_pasien'] : null;
      $model->nama_pegawai = isset($_GET['ROinforujukankeluar_v']['nama_pegawai']) ? $_GET['ROinforujukankeluar_v']['nama_pegawai'] : null;
      $model->labklinikrujukan_id = isset($_GET['ROinforujukankeluar_v']['labklinikrujukan_id']) ? $_GET['ROinforujukankeluar_v']['labklinikrujukan_id'] : null;
    }

    $this->render($this->path_view . 'informasi', array('model' => $model));
  }
}
