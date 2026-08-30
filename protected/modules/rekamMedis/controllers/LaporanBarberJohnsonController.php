<?php

class LaporanBarberJohnsonController extends Controller
{
  public function actionIndex()
  {
    $model = new Rl12Indikatorpelayananrumahsakit;
    // $model->tgl_awal = date('Y-01-01');
    // $model->tgl_akhir = date('Y-12-31');
    $model->tahun = 2018;

    if (isset($_GET['Rl12Indikatorpelayananrumahsakit'])) {
      $model->attributes = $_GET['Rl12Indikatorpelayananrumahsakit'];
      $model->tahun = $_GET['Rl12Indikatorpelayananrumahsakit']['tahun'];
      // $model->tgl_awal = MyFormatter::formatDateTimeForDB($model->tgl_awal);
      // $model->tgl_akhir = MyFormatter::formatDateTimeForDB($model->tgl_akhir);
    }

    $model->tgl_awal = $model->tahun . "-01-01";
    $model->tgl_akhir = $model->tahun . "-12-31";

    $result = $model->hitungPeriodeIndikator();

    $this->render('index', array(
      'model' => $model,
      'result' => $result,
    ));
  }

  public function actionPrint()
  {
    $this->render('print');
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
