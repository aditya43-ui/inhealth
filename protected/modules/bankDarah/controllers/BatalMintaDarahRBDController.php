<?php

/**
 * Transaksi Pembatalan Permintaan Darah 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class BatalMintaDarahRBDController extends MyAuthController
{
  public $path_view = 'bankDarah.views.informasiPermintaanDarah';

  /**
   * Load tampilan batal minta darah dan melakukan transaksi batal permintaan 
   * @param type $permintaandarah_id
   */
  public function actionIndex($permintaandarah_id)
  {
    $this->layout = '//layouts/iframe';
    $model = PermintaandarahT::model()->findByPk($permintaandarah_id);
    $modelBatal = new BatalmintadarahR();
    $modelBatal->tglpembatalan = "d M Y H:i:s";
    if (isset($_POST['BatalmintadarahR'])) {
      $modelBatal->attributes = $_POST['BatalmintadarahR'];
      $modelBatal->permintaandarah_id = $permintaandarah_id;
      $modelBatal->alasanpembatalan = $modelBatal->alasanpembatalan;
      $modelBatal->tglpembatalan = MyFormatter::formatDateTimeForDb($modelBatal->tglpembatalan);
      $modelBatal->create_time = date('Y-m-d H:i:s');
      $modelBatal->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
      $modelBatal->pegawai_id = Yii::app()->user->getState('pegawai_id');
      $modelBatal->create_ruangan = Yii::app()->user->getState('ruangan_id');

      if ($modelBatal->save()) {
        // menambahkan status batal pada tabel permintaan darah
        $model->isbatal = 1;
        $model->save();
      }
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    }

    $this->render($this->path_view . '/_batalPermintaan', array(
      'model' => $model,
      'modelBatal' => $modelBatal
    ));
  }
}
