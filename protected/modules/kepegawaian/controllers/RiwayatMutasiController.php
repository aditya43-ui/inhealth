<?php

class RiwayatMutasiController extends MyAuthController
{
  public $layout = '//layouts/iframe';

  public function actionIndex($pegawai = null)
  {
    if (isset($_GET['pegawai_id'])) {
      $pegawai = $_GET['pegawai_id'];
    }
    $format = new MyFormatter;
    $model = new KPPegmutasiR;
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPPegmutasiR'])) {
      $model->attributes = $_GET['KPPegmutasiR'];
      $model->tglsk = $format->formatDateTimeForDb($_GET['KPPegmutasiR']['tglsk']);
      $pegawai = $_GET['KPPegmutasiR']['pegawai_id'];
    }
    $this->render('_rowRiwayatMutasi', array('model' => $model, 'pegawai' => $pegawai, 'format' => $format));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $modDelete = PegmutasiR::model()->deleteByPk($id);
      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('_rowRiwayatMutasi'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
}
