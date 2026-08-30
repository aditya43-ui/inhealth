<?php

class InfoPemakaianBarangController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'gudangUmum.views.infoPemakaianBarang.';

  /**
   * Melihat daftar data.
   */
  public function actionIndex($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pemakaian Barang";
    $format = new MyFormatter;
    $model  = new GUInformasipemakaianbarangV('search');
    $model->unsetAttributes();  // clear any default values
    $disabled = false;
    if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_GUDANG_UMUM) {
      $disabled = true;
    }
    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['GUInformasipemakaianbarangV'])) {
      $model->attributes = $_GET['GUInformasipemakaianbarangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUInformasipemakaianbarangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUInformasipemakaianbarangV']['tgl_akhir']);

      if ($model->ruangan_id == "") {
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      }
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(1432);

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'format' => $format,
      'disabled' => $disabled,
      'linkHalaman' => $linkHalaman
    ));
  }

  public function actionDetail($id)
  {
    $this->layout = '//layouts/iframe';
    $modPemakaianbarang = GUPemakaianbarangT::model()->findByPk($id);
    $judul_print = 'Detail Pemakaian Barang';
    if (!empty($modPemakaianbarang)) {
      $modDetailPemakaian = GUPemakaianbrgdetailT::model()->findAllByAttributes(array('pemakaianbarang_id' => $id));
      $this->render($this->path_view . 'detailInformasi', array(
        'modPemakaianbarang' => $modPemakaianbarang,
        'modDetailPemakaian' => $modDetailPemakaian,
        'judul_print' => $judul_print,
      ));
    }
  }

  /**
   * untuk print data pemakaian barang
   */
  public function actionPrint($pemakaianbarang_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPemakaianBarang = GUPemakaianbarangT::model()->findByPk($pemakaianbarang_id);
    $modPemakaianBarangDetail = GUPemakaianbrgdetailT::model()->findAllByAttributes(array('pemakaianbarang_id' => $pemakaianbarang_id));

    $judul_print = 'Detail Pemakaian Barang';
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
      'format' => $format,
      'judul_print' => $judul_print,
      'modPemakaianBarang' => $modPemakaianBarang,
      'modPemakaianBarangDetail' => $modPemakaianBarangDetail,
      'caraPrint' => $caraPrint
    ));
  }

  public function actionBatalPemakaianBarang($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $barangdetail = PemakaianbrgdetailT::model()->findAllByAttributes(array('pemakaianbarang_id' => $id));

      if (count((array)$barangdetail) > 0) {
        foreach ($barangdetail as $dataBrg) {
          InventarisasiruanganT::kembalikanStokBerdasarkanRuangan($dataBrg->jmlpakai, $dataBrg->barang_id, Yii::app()->user->getState('ruangan_id'));
        }
      }
      //                        exit();
      $deleteDetail = PemakaianbrgdetailT::model()->deleteAllByAttributes(array('pemakaianbarang_id' => $id));
      $deletePemakaianBarang = PemakaianbarangT::model()->deleteByPk($id);
      if ($deleteDetail && $deletePemakaianBarang) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
  }

  public function actionPrintInformasi($caraPrint)
  {
    $format = new MyFormatter;
    $model  = new GUInformasipemakaianbarangV('search');
    $model->unsetAttributes();  // clear any default values
    $disabled = false;
    if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_GUDANG_UMUM) {
      $disabled = true;
    }
    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['GUInformasipemakaianbarangV'])) {
      $model->attributes = $_GET['GUInformasipemakaianbarangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUInformasipemakaianbarangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUInformasipemakaianbarangV']['tgl_akhir']);

      if ($model->ruangan_id == "") {
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      }
    }

    $this->printFunction($model, $caraPrint, "Informasi Pemakaian Barang", $this->path_view . "printInformasi");
  }


  protected function printFunction($model, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {

      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    } else if ($caraPrint == "CSV") {
      CSV::konversiTabel($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true), $judulLaporan . '-' . date('Y/m/d') . '.csv');
    }
  }
}
