<?php

class InformasiStokOpnameGiziController extends Controller
{
  public $defaultAction = 'index';
  public $path_view = 'gizi.views.informasiStokOpnameGizi.';

  public function actionDetail()
  {
    $this->render('detail');
  }

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Stok Opname Bahan Makanan";
    $model = new InformasistokopnamegiziV;
    $format = new MyFormatter();
    $model->tgl_awal  = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['InformasistokopnamegiziV'])) {
      $model->attributes = $_GET['InformasistokopnamegiziV'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['InformasistokopnamegiziV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['InformasistokopnamegiziV']['tgl_akhir']);
    }
    $this->render($this->path_view . 'index', array('format' => $format, 'model' => $model));
  }

  public function actionPrint()
  {
    $this->render('print');
  }


  /**
   * menampilkan link untuk print detail stock opname
   * @return type
   */
  public function getUrlPrint()
  {
    return $this->createUrl("stokOpnameBahanMakanan/print");
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
