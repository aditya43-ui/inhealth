<?php

/**
 * Halaman untuk Informasi Permintaan Darah PMI
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class InformasiPermintaanDarahPMIController extends MyAuthController
{

  public $path_view = 'bankDarah.views.informasiPermintaanDarahPMI.';

  /**
   * Load Data Permintaan Darah ke PMI 
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Permintaan Darah Ke Pmi";
    $model = new BDPermintaandarahpmiT('searchInformasi');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['BDPermintaandarahpmiT'])) {
      $model->attributes = $_GET['BDPermintaandarahpmiT'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BDPermintaandarahpmiT']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BDPermintaandarahpmiT']['tgl_akhir']);
      $model->no_permintaan = $_GET['BDPermintaandarahpmiT']['no_permintaan'];
      $model->status = $_GET['BDPermintaandarahpmiT']['status'];
      $model->nama_pegawai = $_GET['BDPermintaandarahpmiT']['nama_pegawai'];
    }

    $this->render($this->path_view . '/index', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = PermintaandarahpmiT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Mengubah status permintaan darah menjadi "Batal Permintaan"
   */
  public function actionRemoveTemporary()
  {
    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = PermintaandarahpmiT::model()->updateByPk($id, array('isbatal' => 1));
      if ($update) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
          ));
          Yii::app()->user->setFlash('error', '<strong>Berhasil!</strong> Permintaan Darah Berhasil Dibatalkan.');
          exit;
        }
      }
    } else {
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
        ));
        exit;
      }
    }
  }

  /**
   * Melihat detail penerimaan darah
   * @param type $permintaandarahpmi_id
   */
  public function actionDetail($permintaandarahpmi_id)
  {
    $this->layout = '//layouts/iframe';
    $model = BDPermintaandarahpmiT::model()->findByAttributes(array('permintaandarahpmi_id' => $permintaandarahpmi_id));
    $model->tgl_permintaan = MyFormatter::formatDateTimeForUser($model->tgl_permintaan);
    if (!empty($model->instalasi_id)) {
      $instalasi = InstalasiM::model()->findByPk($model->instalasi_id);
      $model->instalasi_nama = $instalasi->instalasi_nama;
    } else {
      $model->instalasi_nama = '-';
    }
    if (!empty($model->ruangan_id)) {
      $ruangan = RuanganM::model()->findByPk($model->ruangan_id);
      $model->ruangan_nama = $ruangan->ruangan_nama;
    } else {
      $model->ruangan_nama = '-';
    }
    if (!empty($model->petugas_id)) {
      $petugas = PegawaiM::model()->findByPk($model->petugas_id);
      $model->petugas_nama = $petugas->nama_pegawai;
    } else {
      $model->petugas_nama = '-';
    }

    $modPenerimaan = BDPenerimaandarahpmiT::model()->findByAttributes(array('permintaandarahpmi_id' => $permintaandarahpmi_id));
    $modPenerimaan->tgl_penerimaan = MyFormatter::formatDateTimeForUser($modPenerimaan->tgl_penerimaan);
    if (!empty($modPenerimaan->petugas_penerima_id)) {
      $petugas_penerima = PegawaiM::model()->findByPk($modPenerimaan->petugas_penerima_id);
      $modPenerimaan->petugas_penerima_nama = $petugas_penerima->nama_pegawai;
    } else {
      $modPenerimaan->petugas_penerima_nama = '-';
    }
    if (!empty($modPenerimaan->petugas_mengetahui_id)) {
      $petugas_mengetahui = PegawaiM::model()->findByPk($modPenerimaan->petugas_mengetahui_id);
      $modPenerimaan->petugas_mengetahui_nama = $petugas_mengetahui->nama_pegawai;
    } else {
      $modPenerimaan->petugas_mengetahui_nama = '-';
    }
    $modPenerimaanDetail = BDPenerimaandarahpmidetT::model()->findAllByAttributes(array('penerimaandarahpmi_id' => $modPenerimaan->penerimaandarahpmi_id));
    $this->render($this->path_view . '/_detail', array(
      'model' => $model,
      'modPenerimaan' => $modPenerimaan,
      'modPenerimaanDetail' => $modPenerimaanDetail,
    ));
  }
}
