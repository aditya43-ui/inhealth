<?php

class RiwayatCutiController extends MyAuthController
{
  public $layout = '//layouts/iframe';

  public function actionIndex($pegawai = null)
  {
    if (isset($_GET['pegawai_id'])) {
      $pegawai = $_GET['pegawai_id'];
    }
    $format = new MyFormatter;
    $model = new KPPegawaicutiT;
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPPegawaicutiT'])) {
      $model->attributes = $_GET['KPPegawaicutiT'];
      $model->tglmulaicuti = $format->formatDateTimeForDb($_GET['KPPegawaicutiT']['tglmulaicuti']);
      $model->tglakhircuti = $format->formatDateTimeForDb($_GET['KPPegawaicutiT']['tglakhircuti']);
      $pegawai = $_GET['KPPegawaicutiT']['pegawai_id'];
    }
    $this->render('_rowRiwayatCuti', array('model' => $model, 'pegawai' => $pegawai, 'format' => $format));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $modDelete = PegawaicutiT::model()->deleteByPk($id);
      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('_rowRiwayatCuti'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
}
