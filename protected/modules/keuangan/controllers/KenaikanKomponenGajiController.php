<?php

class KenaikanKomponenGajiController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $updateKomponen = true;

  public function actionIndex()
  {
    $model = KUPenggajiankompT::model()->findAll();
    if (isset($_POST['KUPenggajiankompT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model = $_POST['KUPenggajiankompT'];
        foreach ($model as $i => $detail) {
          $update = PenggajiankompT::model()->updateByPk($detail['penggajiankomp_id'], array('jumlah' => $detail['total']));
          if ($update) {
            $this->updateKomponen &= true;
          } else {
            $this->updateKomponen &= false;
          }
        }
        if ($this->updateKomponen) {
          $transaction->commit();
          $this->redirect(array('index', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Kenaikan Komponen Gaji gagal disimpan !");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Kenaikan Komponen Gaji gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }
    $this->render('index', array(
      'model' => $model
    ));
  }
}
