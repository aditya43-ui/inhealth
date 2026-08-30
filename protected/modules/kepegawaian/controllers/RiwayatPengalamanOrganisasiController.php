<?php

class RiwayatPengalamanOrganisasiController extends MyAuthController
{
  public $layout = '//layouts/iframe';

  public function actionPengalamanOrganisasi($pegawai = null)
  {
    if (isset($_GET['pegawai_id'])) {
      $pegawai = $_GET['pegawai_id'];
    }
    $model = new KPPengorganisasiR;
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPPengorganisasiR'])) {
      $model->attributes = $_GET['KPPengorganisasiR'];
      $pegawai = $_GET['KPPengorganisasiR']['pegawai_id'];
    }
    $this->render('_rowRiwayatPengalamanOrganisasi', array('model' => $model, 'pegawai' => $pegawai));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $modDelete = PengorganisasiR::model()->deleteByPk($id);
      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('_rowRiwayatPengalamanOrganisasi'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
}
