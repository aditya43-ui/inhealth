<?php

class FormulirStokOpnameBahanMakananController extends MyAuthController
{
  public $path_view = 'gizi.views.formulirStokOpnameBahanMakanan.';

  public function actionIndex($formuliropnamegizi_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Formulir Stok Opname Bahan Makanan";
    $format = new MyFormatter();
    //        $modMakanan = new GFInformasistokobatalkesV('search'); //RND-6228
    $modMakanan = new GZStokbahanmakananT('search'); //RND-6228
    $model = new FormuliropnamegiziR;
    $model->tglformulir = $format->formatDateTimeId(date('Y-m-d H:i:s'));
    $model->totalvolume = 0;
    $modDetail = array();

    $modMakanan->bahanmakanan_id = "0";
    if (!empty($formuliropnamegizi_id)) {
      $model = FormuliropnamegiziR::model()->findByPk($formuliropnamegizi_id);
      if (!empty($model)) {
        $modDetail = FormuliropnamegizidetR::model()->findAllByAttributes(array('formuliropnamegizi_id' => $model->formuliropnamegizi_id));
        $modMakanan->bahanmakanan_id = CHtml::listData($modDetail, 'bahanmakanan_id', 'bahanmakanan_id');
      }
    }

    if (isset($_POST['FormuliropnamegiziR'])) {
      $model->attributes = $_POST['FormuliropnamegiziR'];
      $modMakanan->unsetAttributes();
      $model->noformulir = MyGenerator::noFormulirOpnameGizi();
      $model->create_time = date('Y-m-d H:i:s');
      $model->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $model->tglformulir = $format->formatDateTimeForDb($model->tglformulir);

      if ($model->validate()) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $hasil = 0;
          if ($model->save()) {
            foreach ($_POST['FormuliropnamegizidetR'] as $data) {
              if (isset($data['cekList'])) {
                if ($data['cekList']) {
                  $modDetail = new FormuliropnamegizidetR();
                  $modDetail->bahanmakanan_id = $data['bahanmakanan_id'];
                  $modDetail->formuliropnamegizi_id = $model->formuliropnamegizi_id;
                  $modDetail->volume_stok = $data['volume_stok'];
                  if ($modDetail->save()) {
                    $hasil++;
                  }
                }
              }
            }
          }

          if ($hasil > 0) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data Berhasil Disimpan ");
            $this->redirect(array('index', 'formuliropnamegizi_id' => $model->formuliropnamegizi_id, 'sukses' => 1));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data Gagal Disimpan ");
          }
        } catch (Exception $ex) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
        }
      }
    }


    if (isset($_GET['GZStokbahanmakananT'])) {
      $modMakanan->unsetAttributes();
      $modMakanan->attributes = $_GET['GZStokbahanmakananT'];
      $modMakanan->jenisbahanmakanan = $_GET['GZStokbahanmakananT']['jenisbahanmakanan'];
      $modMakanan->namabahanmakanan = $_GET['GZStokbahanmakananT']['namabahanmakanan'];
      $modMakanan->golbahanmakanan_id = $_GET['GZStokbahanmakananT']['golbahanmakanan_id'];
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modObat' => $modMakanan,
      'format' => $format,
    ));
  }

  public function actionPrint($formuliropnamegizi_id)
  {
    $format = new MyFormatter();
    $model = FormuliropnamegiziR::model()->findByPK($formuliropnamegizi_id);
    $modDetails = FormuliropnamegizidetR::model()->findAllByAttributes(array('formuliropnamegizi_id' => $formuliropnamegizi_id));

    $judulLaporan = 'Data Formulir Opname Bahan Makanan';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;

    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render($this->path_view . 'print', array(
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'caraPrint' => $caraPrint,
      'modDetails' => $modDetails,
      'format' => $format
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
