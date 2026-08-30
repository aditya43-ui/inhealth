<?php

class RiwayatJabatanController extends MyAuthController
{
  public $layout = '//layouts/iframe';

  public function actionIndex($pegawai = null)
  {
    if (isset($_GET['pegawai_id'])) {
      $pegawai = $_GET['pegawai_id'];
    }
    $format = new MyFormatter;
    $model = new KPPegawaijabatanR;
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPPegawaijabatanR'])) {
      $model->attributes = $_GET['KPPegawaijabatanR'];
      $model->tglditetapkanjabatan = $format->formatDateTimeForDb($_GET['KPPegawaijabatanR']['tglditetapkanjabatan']);
      $pegawai = $_GET['KPPegawaijabatanR']['pegawai_id'];
    }
    $this->render('_rowRiwayatJabatan', array('model' => $model, 'pegawai' => $pegawai, 'format' => $format));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $modDelete = PegawaijabatanR::model()->deleteByPk($id);
      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('_rowRiwayatJabatan'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
}
