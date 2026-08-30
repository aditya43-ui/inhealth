<?php

class RiwayatSusunanKeluargaController extends MyAuthController
{
  public $layout = '//layouts/iframe';

  /**
   * menampilkan susunan keluarga pegawai
   * @return rows table
   */
  public function actionSusunanKeluarga($pegawai = null)
  {
    if (isset($_GET['pegawai_id'])) {
      $pegawai = $_GET['pegawai_id'];
    }
    $model = new KPSusunankelM;
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPSusunankelM'])) {
      $model->attributes = $_GET['KPSusunankelM'];
      $pegawai = $_GET['KPSusunankelM']['pegawai_id'];
    }
    $this->render('_rowRiwayatSusunanKeluarga', array('model' => $model, 'pegawai' => $pegawai));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $modDelete = KPSusunankelM::model()->deleteByPk($id);
      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('_rowRiwayatSusunanKeluarga'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
}
