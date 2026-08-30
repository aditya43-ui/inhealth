<?php

class InformasiInspeksiController extends Controller
{
  public $path_view = 'sterilisasi.views.informasiInspeksi.';

  public function actionDetail()
  {
    $this->render('detail');
  }

  public function actionIndex()
  {
    $model = new InspeksiinstrumenT('search');
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    $format = new MyFormatter();

    if (isset($_GET['InspeksiinstrumenT'])) {
      $model->attributes = $_GET['InspeksiinstrumenT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['InspeksiinstrumenT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['InspeksiinstrumenT']['tgl_akhir']);
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'format' => $format
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
