<?php

class InformasiPembayaranKlaimMerchantController extends MyAuthController
{
  protected $succesSave = true;
  protected $pesan = "succes";

  public function actionIndex()
  {
    $model = new KUInformasipembayaranklaimmerchantV('search');
    $model->unsetAttributes();  // clear any default values
    $format = new MyFormatter();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');

    if (isset($_GET['KUInformasipembayaranklaimmerchantV'])) {
      $model->attributes = $_GET['KUInformasipembayaranklaimmerchantV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInformasipembayaranklaimmerchantV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInformasipembayaranklaimmerchantV']['tgl_akhir']);
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

  public function actionBatalPembayaran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = $_POST['id'];
      $modPembKlaimDetal = KUPembklaimdetalT::model()->findAllByAttributes(array('pembayarklaim_id' => $id));
      foreach ($modPembKlaimDetal as $i => $v) {
        $modPembayaranPelayanan = KUPembayaranpelayananT::model()->findAllByAttributes(array('pembklaimdetal_id' => $v->pembklaimdetal_id));
        if (!empty($modPembayaranPelayanan)) {
          $crit = new CDbCriteria();
          $crit->addCondition("pembklaimdetal_id = " . $v->pembklaimdetal_id);
          KUPembayaranpelayananT::model()->updateAll(array('pembklaimdetal_id' => null), $crit);
        }
      }
      KUPembayaranklaimT::model()->deleteByPk($id);
      $data['status'] = 'proses_form';
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
