<?php

class RiwayatDiklatController extends MyAuthController
{
  public $layout = '//layouts/iframe';

  public function actionIndex($pegawai = null)
  {
    if (isset($_GET['pegawai_id'])) {
      $pegawai = $_GET['pegawai_id'];
    }
    $format = new MyFormatter;
    $model = new KPPegawaidiklatT;
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPPegawaidiklatT'])) {
      $model->attributes = $_GET['KPPegawaidiklatT'];
      $model->pegawaidiklat_tahun = $format->formatDateTimeForDb($_GET['KPPegawaidiklatT']['pegawaidiklat_tahun']);
      $pegawai = $_GET['KPPegawaidiklatT']['pegawai_id'];
    }
    $this->render('_rowRiwayatDiklat', array('model' => $model, 'pegawai' => $pegawai, 'format' => $format));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      $model = PegawaidiklatT::model()->findByPk($id);
      if(!empty($model->sertifikat)){
        if(file_exists(Params::pathDokumenRealisasiPelatihanDirectory() . $model->sertifikat)){
          unlink(Params::pathDokumenRealisasiPelatihanDirectory() . $model->sertifikat);
        }
      }

      KPRencanadiklatT::model()->updateByPk($model->rencanadiklat_id, array('status_rencana'=>Params::STATUS_RENCANA_DIKLAT_RENCANA));
      
      // we only allow deletion via POST request
      $modDelete = PegawaidiklatT::model()->deleteByPk($id);
      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('_rowRiwayatDiklat'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
}
