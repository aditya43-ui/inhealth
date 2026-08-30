<?php

class InformasiPenerimaanUmumController extends MyAuthController
{
  public $path_view = 'keuangan.views.informasiPenerimaanUmum.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Penerimaan Kas / Umum";
    $modPenerimaan = new KUPenerimaanUmumT;
    $format = new MyFormatter();
    $modPenerimaan->tgl_awal = date('d M Y');
    $modPenerimaan->tgl_akhir = date('d M Y');

    if (isset($_GET['KUPenerimaanUmumT'])) {
      $modPenerimaan->attributes = $_GET['KUPenerimaanUmumT'];
      $modPenerimaan->tgl_awal = $format->formatDateTimeForDb($_GET['KUPenerimaanUmumT']['tgl_awal']);
      $modPenerimaan->tgl_akhir = $format->formatDateTimeForDb($_GET['KUPenerimaanUmumT']['tgl_akhir']);
      $modPenerimaan->jenispenerimaan_nama = isset($_GET['KUPenerimaanUmumT']['jenispenerimaan_nama']) ? $_GET['KUPenerimaanUmumT']['jenispenerimaan_nama'] : null;
      // $modPenerimaan->pegawai_id = isset($_GET['KUPenerimaanUmumT']['pegawai_id']) ? $_GET['KUPenerimaanUmumT']['pegawai_id'] : null;
      // $modPenerimaan->shift_id = isset($_GET['KUPenerimaanUmumT']['shift_id'][1]) ? $_GET['KUPenerimaanUmumT']['shift_id'][1] : null;
      // var_dump($_GET['KUPenerimaanUmumT']);die;
    }

    $this->render($this->path_view . 'index', array('modPenerimaan' => $modPenerimaan));
  }

  public function actionDetailPenerimaanUmum($penerimaanumum_id)
  {
    if (isset($_GET['caraPrint'])) {
      $this->layout = '//layouts/printWindows';
    } else {
      $this->layout = '//layouts/iframe';
    }
    $modPenerimaan = KUPenerimaanUmumT::model()->findByPk($penerimaanumum_id);
    $modTanda = KUTandabuktibayarT::model()->findByPk($modPenerimaan->tandabuktibayar_id);
    if (!count((array)$modPenerimaan) > 0) {
      echo "<h4>Data penerimaan umum tidak ditemukan!!</h4>";
      exit;
    }
    $modUraianTerimaUmum = UraianpenumumT::model()->findAllByAttributes(array('penerimaanumum_id' => $penerimaanumum_id));
    $this->render($this->path_view . 'detailPenerimaan', array(
      'modUraianTerimaUmum' => $modUraianTerimaUmum,
      'modPenerimaan' => $modPenerimaan,
      'modTanda' => $modTanda
    ));
  }

  // Uncomment the following methods and override them if needed
  /*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
