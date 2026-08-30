<?php

class InformasiStokBarangController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'gudangUmum.views.informasiStokBarang.';

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Stok Barang Umum";
    $disabled = true;
    $model = new GUInformasistokbarangV('search');
    $model->ceklisminimal = false;

    $model->unsetAttributes();  // clear any default values
    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GUDANG_UMUM) {
      $disabled = false;
    }
    if (isset($_GET['GUInformasistokbarangV'])) {
      $model->attributes = $_GET['GUInformasistokbarangV'];
      $model->ceklisminimal = $_GET['GUInformasistokbarangV']['ceklisminimal'];
    }
    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'disabled' => $disabled,
    ));
  }

  /*
      public function actionIndexKartu()
      {
      $model = new InventarisasiruanganT();
      $model->unsetAttributes();  // clear any default values
      // $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      if(isset($_GET['InventarisasiruanganT'])){
      $model->attributes=$_GET['InventarisasiruanganT'];
      }
      $this->render($this->path_view.'indexKartu',array(
      'model'=>$model,
      ));
      }
     */

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(GURuanganM::getRuanganStokBarangs($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        //  if (count((array)$models)>1){
        // echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
        //  }elseif(count((array)$models)==0){
        //echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
        //  }
        //echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new GUInformasistokbarangV;
    $model->unsetAttributes();  // clear any default values
    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GUDANG_UMUM) {
      $disabled = false;
    }
    if (isset($_GET['GUInformasistokbarangV'])) {
      $model->attributes = $_GET['GUInformasistokbarangV'];
    }
    $judulLaporan = ' Informasi Stok barang';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      // //$mpdf->useOddEven = 2;  
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionRincian($id, $ruangan_id)
  {
    $this->layout = '//layouts/iframe';
    $model = InventarisasiruanganT::model()->findAllByAttributes(array('barang_id' => $id, 'ruangan_id' => $ruangan_id));
    $judulLaporan = 'RINCIAN STOK BARANG';

    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;

    if (!empty($caraPrint)) {
      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        //                $this->render($this->path_view . 'rincian', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'barang_id'=>$id, 'ruangan_id'=>$ruangan_id,));
      }
    }

    $this->render($this->path_view . 'rincian', array(
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'barang_id' => $id,
      'ruangan_id' => $ruangan_id,
      'caraPrint' => $caraPrint
    ));
  }
}
