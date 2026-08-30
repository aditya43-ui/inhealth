<?php
class InformasiPemesananAmbulansController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public function actionIndex()
  {
    $model = new AMInformasipesanambulansV;
    $format = new MyFormatter;
    $model->tgl_awal  = date('Y-m-d');
    $model->tgl_akhir  = date('Y-m-d');
    if (isset($_GET['AMInformasipesanambulansV'])) {
      $model->unsetAttributes();
      $model->attributes = $_GET['AMInformasipesanambulansV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AMInformasipesanambulansV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AMInformasipesanambulansV']['tgl_akhir']);
    }
    $this->pageTitle = Yii::app()->name . " - Pemesanan Ambulans";
    $this->render('index', array('model' => $model, 'format' => $format));
  }

  public function actionDelete()
  {
    if (Yii::app()->request->isPostRequest) {

      $trans = Yii::app()->db->beginTransaction();
      $data = array('sukses' => 0);

      $ok = true;
      $ok = $ok && AMPesanambulansT::model()->deleteAllByAttributes(array('pesanambulans_t' => $_POST['id']));

      if ($ok) {
        $trans->commit();
        $data['sukses'] = 1;
      } else {
        $trans->rollback();
        $data['sukses'] = 0;
      }

      echo CJSON::encode($data);
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
}
