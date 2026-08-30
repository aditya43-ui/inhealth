<?php

class RiwayatPengalamanKerjaController extends MyAuthController
{
  public $layout = '//layouts/iframe';

  public function actionPengalamanKerja($pegawai = null)
  {
    if (isset($_GET['pegawai_id'])) {
      $pegawai = $_GET['pegawai_id'];
    }
    $model = new KPPengalamankerjaR;
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPPengalamankerjaR'])) {
      $model->attributes = $_GET['KPPengalamankerjaR'];
      $pegawai = $_GET['KPPengalamankerjaR']['pegawai_id'];
    }
    $this->render('_rowRiwayatPengalamanKerja', array('model' => $model, 'pegawai' => $pegawai));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $modDelete = PengalamankerjaR::model()->deleteByPk($id);
      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('_rowRiwayatPengalamanKerja'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
}
