<?php

class InformasiPembayaranPesangonController extends MyAuthController
{
  protected $succesSave = true;
  protected $pesan = "succes";
  public $path_view = 'penggajian.views.informasiPembayaranPesangon.';
  public function actionIndex($linkHalaman = null)
  {
    $model = new GJInformasipembayaranpesangonV('search');
    $model->unsetAttributes();  // clear any default values
    $format = new MyFormatter();

    $model->periodegaji = date('Y-m', strtotime('-1 month'));

    // $model->periodegaji = date('d M Y');

    if (isset($_GET['GJInformasipembayaranpesangonV'])) {
      $model->attributes = $_GET['GJInformasipembayaranpesangonV'];
      $model->periodegaji = MyFormatter::formatMonthForDB($model->periodegaji);
    }
    /*
        if ($bulan == 12) {
            $bulan = 1;
            $tahun++;
        } else {
            $bulan++;
        }
         * 
         */



    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'format' => $format,
      'linkHalaman' => $linkHalaman
    ));
  }

  public function actionDetail($id = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modDetail = new GJInformasipembayaranpesangonV();

    $this->render($this->path_view . 'detail', array(
      'modDetail' => $modDetail,
      'format' => $format,
      'id' => $id,
    ));
  }

  public function actionBatalPembayaran($id = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPengeluaran = GJPengeluaranumumT::model()->findByPk($id);
    $modBatalBayar = new GJBatalkeluarumumT();
    $sukses = 0;
    $modBatalBayar->tglbatalkeluar = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));

    if (isset($_POST['GJBatalkeluarumumT'])) {
      $modBatalBayar->attributes = $_POST['GJBatalkeluarumumT'];
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
        PengeluaranumumT::model()->updateByPk($modPengeluaran->pengeluaranumum_id, $attributes);

        $gaji = PesangonpegT::model()->findAllByAttributes(array(
          'pengeluaranumum_id' => $modPengeluaran->pengeluaranumum_id,
        ));
        foreach ($gaji as $item) {
          $item->pengeluaranumum_id = null;
          $item->update(array('pengeluaranumum_id'));
        }

        $sukses = $this->succesSave;
        $modBatalBayar->isNewRecord = false;
      } else {
        $this->succesSave = false;
        $this->pesan = $modBatalBayar->getErrors();
        $sukses = $this->succesSave;
      }
    }

    $this->render($this->path_view . '_formBatalBayar', array(
      'modBatalBayar' => $modBatalBayar,
      'format' => $format,
      'id' => $id,
      'sukses' => $sukses
    ));
  }
}
