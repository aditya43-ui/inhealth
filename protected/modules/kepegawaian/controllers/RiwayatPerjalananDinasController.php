<?php

class RiwayatPerjalananDinasController extends MyAuthController
{
  public $layout = '//layouts/iframe';

  public function actionIndex($pegawai = null)
  {
    if (isset($_GET['pegawai_id'])) {
      $pegawai = $_GET['pegawai_id'];
    }
    $format = new MyFormatter;
    $model = new KPPerjalanandinasR;
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPPerjalanandinasR'])) {
      $model->attributes = $_GET['KPPerjalanandinasR'];
      $model->tglmulaidinas = $format->formatDateTimeForDb($_GET['KPPerjalanandinasR']['tglmulaidinas']);
      $model->sampaidengan = $format->formatDateTimeForDb($_GET['KPPerjalanandinasR']['sampaidengan']);
      $pegawai = $_GET['KPPerjalanandinasR']['pegawai_id'];
    }
    $this->render('_rowRiwayatPerjalananDinas', array('model' => $model, 'pegawai' => $pegawai, 'format' => $format));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $modDelete = PerjalanandinasR::model()->deleteByPk($id);
      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('_rowRiwayatPerjalananDinas'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
}
