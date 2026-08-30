<?php

class KenaikanKomponenGajiController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $updateKomponen = true;
  public $path_view = 'penggajian.views.kenaikanKomponenGaji.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Kenaikan Komponen Gaji";
    $model = GJPenggajiankompT::model()->findAll();
    if (isset($_POST['GJPenggajiankompT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model = $_POST['GJPenggajiankompT'];
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
    $this->render($this->path_view . 'index', array(
      'model' => $model
    ));
  }
}
