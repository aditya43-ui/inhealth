<?php

class InformasiPembayaranKlaimPiutangController extends MyAuthController
{
  protected $succesSave = true;
  protected $pesan = "succes";

  public function actionIndex()
  {
    $model = new KUInformasiPembayaranKlaimPiutangV('search');
    $model->unsetAttributes();  // clear any default values
    $format = new MyFormatter();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');

    if (isset($_GET['KUInformasiPembayaranKlaimPiutangV'])) {
      $model->attributes = $_GET['KUInformasiPembayaranKlaimPiutangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInformasiPembayaranKlaimPiutangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInformasiPembayaranKlaimPiutangV']['tgl_akhir']);
    }

    $this->render('index', array(
      'model' => $model,
      'format' => $format
    ));
  }

  public function actionDetail($id = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modDetail = new KUPembayarklaimdetailT();

    $this->render('detail', array(
      'modDetail' => $modDetail,
      'format' => $format,
      'id' => $id,
    ));
  }

  public function actionBatalPembayaran($id = null)
  {
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      KUPembayaranklaimT::model()->deleteByPk($id);
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
          'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
        ));
        exit;
      }

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
}
