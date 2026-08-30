<?php

class InformasiPembayaranGajiController extends MyAuthController
{
  protected $succesSave = true;
  protected $pesan = "succes";

  public function actionIndex()
  {
    $model = new KUInformasipembayarangajiV('search');
    $model->unsetAttributes();  // clear any default values
    $format = new MyFormatter();
    $model->periodegaji = date('d M Y');

    if (isset($_GET['KUInformasipembayarangajiV'])) {
      $model->attributes = $_GET['KUInformasipembayarangajiV'];
      $model->periodegaji = $format->formatDateTimeForDb($_GET['KUInformasipembayarangajiV']['periodegaji']);
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
    $modDetail = new KUInformasipembayarangajiV();

    $this->render('detail', array(
      'modDetail' => $modDetail,
      'format' => $format,
      'id' => $id,
    ));
  }

  public function actionBatalPembayaran($id = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPengeluaran = KUPengeluaranumumT::model()->findByPk($id);
    $modBatalBayar = new KUBatalkeluarumumT();
    $sukses = 0;

    if (isset($_POST['KUBatalkeluarumumT'])) {
      $modBatalBayar->attributes = $_POST['KUBatalkeluarumumT'];
      $modBatalBayar->tglbatalkeluar = $format->formatDateTimeForDb($modBatalBayar->tglbatalkeluar);
      $modBatalBayar->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modBatalBayar->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modBatalBayar->create_loginpemakai_id = Yii::app()->user->id;
      $modBatalBayar->create_time = date('Y-m-d H:i:s');
      $modBatalBayar->pengeluaranumum_id = $modPengeluaran->pengeluaranumum_id;

      if ($modBatalBayar->validate()) {
        $modBatalBayar->save();
        $this->succesSave = true;
        $attributes = array(
          'batalkeluarumum_id' => $modBatalBayar->batalkeluarumum_id,
        );
        KUPengeluaranumumT::model()->updateByPk($modPengeluaran->pengeluaranumum_id, $attributes);
        $sukses = $this->succesSave;
        $modBatalBayar->isNewRecord = false;
      } else {
        $this->succesSave = false;
        $this->pesan = $modBatalBayar->getErrors();
        $sukses = $this->succesSave;
      }
    }

    $this->render('_formBatalBayar', array(
      'modBatalBayar' => $modBatalBayar,
      'format' => $format,
      'id' => $id,
      'sukses' => $sukses
    ));
  }
}
