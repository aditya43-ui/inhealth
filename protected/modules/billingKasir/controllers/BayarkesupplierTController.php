<?php

class BayarkesupplierTController extends MyAuthController
{
  public $init = '';
  public $modul = '';
  public function actionIndex()
  {
    $model = new InformasibayarkesupplierV('search');
    $model->tgl_awal = date('Y-m-d', strtotime('-7 days'));
    $model->tgl_akhir = date('Y-m-d');
    $modFaktur = new BKFakturPembelianT;
    $format = new MyFormatter();

    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_FINANCE || Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_BENDAHARA) {
      $this->init = 'KU';
      $this->modul = '/keuangan/';
    }

    if (isset($_GET['InformasibayarkesupplierV'])) {
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['InformasibayarkesupplierV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['InformasibayarkesupplierV']['tgl_akhir']);
      $model->nokaskeluar = $_GET['InformasibayarkesupplierV']['nokaskeluar'];
      $model->nofaktur = $_GET['InformasibayarkesupplierV']['nofaktur'];
      $model->statusBayar = isset($_GET['InformasibayarkesupplierV']['statusBayar']) ? $_GET['InformasibayarkesupplierV']['statusBayar'] : null;
      $model->statusBatal = isset($_GET['InformasibayarkesupplierV']['statusBatal']) ? $_GET['InformasibayarkesupplierV']['statusBatal'] : null;
      $model->petugaskeuangan = isset($_GET['InformasibayarkesupplierV']['petugaskeuangan']) ? $_GET['InformasibayarkesupplierV']['petugaskeuangan'] : null;
      $model->supplier_id = isset($_GET['InformasibayarkesupplierV']['supplier_id']) ? $_GET['InformasibayarkesupplierV']['supplier_id'] : null;
      $model->supplier_jenis = isset($_GET['InformasibayarkesupplierV']['supplier_jenis']) ? $_GET['InformasibayarkesupplierV']['supplier_jenis'] : null;
    }


    $this->render('index', array(
      'model' => $model,
      'modFaktur' => $modFaktur,
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
