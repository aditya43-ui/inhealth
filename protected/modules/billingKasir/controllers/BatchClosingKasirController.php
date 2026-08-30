<?php

class BatchClosingKasirController extends MyAuthController
{
  public function actionTransfer()
  {
    $model = new BKInformasiclosingkasirV('searchBatchClosingKasir');
    $format = new CustomFormat();
    $model->unsetAttributes();
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    if (isset($_GET['BKInformasiclosingkasirV'])) { //jika klik tombol cari
      $model->attributes = $_GET['BKInformasiclosingkasirV'];
      $model->tgl_awal = $format->formatDateMediumForDB($_GET['BKInformasiclosingkasirV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateMediumForDB($_GET['BKInformasiclosingkasirV']['tgl_akhir']);
    }

    if (isset($_POST['BKInformasiclosingkasirV'])) { //jika klik tombol simpan
      $model->tgl_awal = $format->formatDateMediumForDB($_POST['BKInformasiclosingkasirV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateMediumForDB($_POST['BKInformasiclosingkasirV']['tgl_akhir']);
      $modBatchs = $model->searchBatchClosingKasir()->getData();
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $sukses = 0;
        $gagal = 0;
        $flash_msg = array();
        foreach ($modBatchs as $i => $batch) {
          $modClosingRemote = new BKClosingkasirTRemote();
          $modClosingRemote->attributes = $batch->attributes;
          $modClosingRemote->closingkasir_id = NULL; //serial
          $modClosingRemote->profilrs_id = isset($batch->profilrs_id) ? $batch->profilrs_id : Yii::app()->user->getState('profilrs_id');

          if ($modClosingRemote->validate()) {
            $modClosingRemote->save();
            $modClosingUpdate = ClosingkasirT::model()->findByPk($batch->closingkasir_id);
            $modClosingUpdate->batch_sent = true;
            if ($modClosingUpdate->save()) {
              $sukses++;
              $flash_msg['type'] = ($gagal > 0) ? 'warning' : 'success';
              $flash_msg['msg'] = $sukses . " data berhasil disimpan" . (($gagal > 0) ? ", " . $gagal . " data gagal disimpan !" : "");
            } else {
              $gagal++;
              $flash_msg['type'] = 'error';
              $flash_msg['msg'] = "Gagal update status batch_sent di closingkasir_t !";
            }
          } else {
            $gagal++;
            $flash_msg['type'] = 'error';
            $flash_msg['msg'] = "Data batch gagal disimpan";
          }
        }
        $transaction->commit();
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('transfer', 'flash_msg' => $flash_msg));
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $transaction->rollback();
      }
    }
    $this->render('informasi', array('model' => $model, 'format' => $format));
  }
}
