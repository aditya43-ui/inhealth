<?php

class DaftarPenerimaanUmumController extends MyAuthController
{
  public function actionIndex()
  {
    $modPenerimaan = new BKPenerimaanUmumT;
    $format = new MyFormatter();
    $modPenerimaan->tgl_awal = date('d M Y');
    $modPenerimaan->tgl_akhir = date('d M Y');

    if (isset($_GET['BKPenerimaanUmumT'])) {
      $modPenerimaan->attributes = $_GET['BKPenerimaanUmumT'];
      $modPenerimaan->tgl_awal = $format->formatDateTimeForDb($_GET['BKPenerimaanUmumT']['tgl_awal']);
      $modPenerimaan->tgl_akhir = $format->formatDateTimeForDb($_GET['BKPenerimaanUmumT']['tgl_akhir']);
    }

    $this->render('index', array('modPenerimaan' => $modPenerimaan));
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
