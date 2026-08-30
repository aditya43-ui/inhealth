<?php

class FormulirStockOpnameObatAlkesController extends MyAuthController
{
  public $path_view = 'gudangFarmasi.views.formulirStockOpnameObatAlkes.';

  public function actionIndex($formuliropname_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Formulir Opname Obat Alkes";
    $format = new MyFormatter();
    //        $modObat = new GFInformasistokobatalkesV('search'); //RND-6228
    $modObat = new GFObatalkesfarmasiV('search'); //RND-6228
    $model = new GFFormuliropnameR;
    $model->tglformulir = $format->formatDateTimeId(date('Y-m-d H:i:s'));
    $model->totalharga = 0;
    $model->totalvolume = 0;
    $modDetail = array();

    if (!empty($formuliropname_id)) {
      $model = GFFormuliropnameR::model()->findByPk($formuliropname_id);
      if ($model == true) {
        $modDetail = GFFormstokopnameR::model()->findAllByAttributes(array('formuliropname_id' => $model->formuliropname_id));
        $modObat->obatalkes_id = CHtml::listData($modDetail, 'obatalkes_id', 'obatalkes_id');
      }
    }

    if (isset($_POST['GFFormstokopnameR'])) {

      // var_dump($_POST);
      // exit('asasas');die;
      // $model->attributes = $_POST['GFFormuliropnameR'];

      $totalvolume = 0;
      $totalharga = 0;
      foreach ($_POST['GFFormstokopnameR'] as $data) {
        if (isset($data['cekList'])) {
         
          if ($data['cekList']) {
            $totalvolume += StokobatalkesT::getJumlahStok($data['obatalkes_id']);
            $perunit = ObatalkesM::model()->findByAttributes(array('obatalkes_id' => $data['obatalkes_id']))->harganetto * StokobatalkesT::getJumlahStok($data['obatalkes_id']);
            $totalharga += $perunit;
      }}}
      

      $model->attributes = new GFFormuliropnameR();
      $modObat->unsetAttributes();
      $model->noformulir = MyGenerator::noFormulirOpname();
      $model->totalvolume = $totalvolume;
      $model->totalharga = $totalharga;
      $model->create_time = date('Y-m-d H:i:s');
      $model->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $model->tglformulir = $format->formatDateTimeForDb($model->tglformulir);

      if ($model->validate()) {
        
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $hasil = 0;
          if ($model->save()) {
            foreach ($_POST['GFFormstokopnameR'] as $data) {
              if (isset($data['cekList'])) {
                if ($data['cekList']) {
                  $modDetail = new FormstokopnameR();
                  $modDetail->obatalkes_id = $data['obatalkes_id'];
                  $modDetail->formuliropname_id = $model->formuliropname_id;
                  $modDetail->rakobat_id = !empty($data['rakobat_id']) ? $data['rakobat_id'] : null;
                  $modDetail->penyimpananobat_id = !empty($data['penyimpananobat_id']) ? $data['penyimpananobat_id'] : null;
                  $modDetail->volume_stok = StokobatalkesT::getJumlahStok($data['obatalkes_id']);
                  
                  if ($modDetail->save()) {
                    $hasil++;
                  }
                  // var_dump($modDetail->attributes);
                }
              }
            }
          }

          if ($hasil > 0) {
            // var_dump("OK"); die;
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data Berhasil Disimpan ");
            $this->redirect(array('index', 'formuliropname_id' => $model->formuliropname_id, 'sukses' => 1));
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

    $modObat->init = false;
    if (isset($_GET['GFObatalkesfarmasiV'])) {
      $modObat->unsetAttributes();
      $modObat->attributes = $_GET['GFObatalkesfarmasiV'];
      $modObat->obatalkes_nama = !empty($_GET['GFObatalkesfarmasiV']['obatalkes_nama']) ? $_GET['GFObatalkesfarmasiV']['obatalkes_nama'] : null;
      $modObat->rakobat_id = !empty($_GET['GFObatalkesfarmasiV']['rakobat_id']) ? $_GET['GFObatalkesfarmasiV']['rakobat_id'] : null;
      $modObat->init = true;
    }
    // var_dump('1');die;
    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modObat' => $modObat,
      'format' => $format,
    ));
  }

  protected function sortPilih($data)
  {
    $result = array();
    foreach ($data as $i => $row) {
      if (isset($row['cekList'])) {
        $result[] = $row['obatalkes_id'];
      }
    }
    return $result;
  }

  public function actionPrint($formuliropname_id)
  {
    $format = new MyFormatter();
    $model = GFFormuliropnameR::model()->findByPK($formuliropname_id);
    $modDetails = GFFormstokopnameR::model()->findAllByAttributes(array('formuliropname_id' => $formuliropname_id));

    $judulLaporan = 'Data Formulir Obat Alkes Opname';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;

    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render($this->path_view . 'Print', array(
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'caraPrint' => $caraPrint,
      'modDetails' => $modDetails,
      'format' => $format
    ));
  }
  /**
   * untuk set ulang tanggal berdasarkan tanggal sistem
   */
  public function actionSetTanggalSistem()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $returnVal['tanggal'] = MyFormatter::formatDateTimeId(date("Y-m-d H:i:s"));
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
