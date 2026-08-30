<?php

class InfoPemakaianBahanMakanController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'gizi.views.infoPemakaianBahanMakan.';

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pemakaian Bahan Makanan";
    $format = new MyFormatter;
    $model  = new GZInformasipemakaianbhnmknV('search');
    $model->unsetAttributes();  // clear any default values

    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->ruanganpemakaibhnmkn = Yii::app()->user->getState('ruangan_id');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['GZInformasipemakaianbhnmknV'])) {
      $model->attributes = $_GET['GZInformasipemakaianbhnmknV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZInformasipemakaianbhnmknV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZInformasipemakaianbhnmknV']['tgl_akhir']);

      if ($model->ruanganpemakaibhnmkn == "") {
        $model->ruanganpemakaibhnmkn = Yii::app()->user->getState('ruangan_id');
      }
    }
    $this->render($this->path_view . 'index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionDetail($id)
  {
    $this->layout = '//layouts/iframe';
    $model = GZPemakaianbhnmknT::model()->findByPk($id);
    if (!empty($model)) {
      $modelDetail = GZPemakaianbhnmkndetT::model()->findAllByAttributes(array('pemakaianbhnmkn_id' => $id));
      $this->render($this->path_view . 'detailInformasi', array(
        'model' => $model,
        'modelDetail' => $modelDetail,
      ));
    }
  }

  /**
   * untuk print data pemakaian barang
   */
  public function actionPrint($pemakaianbhnmkn_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $model = GZPemakaianbhnmknT::model()->findByPk($pemakaianbhnmkn_id);
    $modelDetail = GZPemakaianbhnmkndetT::model()->findAllByAttributes(array('pemakaianbhnmkn_id' => $pemakaianbhnmkn_id));

    $judul_print = 'PEMAKAIAN BAHAN MAKANAN';
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
      'model' => $model,
      'modelDetail' => $modelDetail,
      'caraPrint' => $caraPrint
    ));
  }

  public function actionBatalPemakaianBahanMakanan($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;

      $det = GZPemakaianbhnmkndetT::model()->findAllByAttributes(array(
        'pemakaianbhnmkn_id' => $id,
      ));

      foreach ($det as $item) {


        StokbahanmakananT::model()->deleteAllByAttributes(array(
          'pemakaianhbnmkndet_id' => $item->pemakaianbhnmkndet_id,
        ));

        $stokPemakaian = StokbahanmakananT::model()->findAllByAttributes(array('bahanmakanan_id' => $item->bahanmakanan_id));
        $totalQty = 0;

        if (count((array)$stokPemakaian) > 0) {
          foreach ($stokPemakaian as $data) {
            $totalQty += $data->qty_current;
          }
        }
        BahanmakananM::model()->updateByPk($item->bahanmakanan_id, array(
          'jmlpersediaan' => $totalQty,
        ));
      }

      $deleteModelDetail = GZPemakaianbhnmkndetT::model()->deleteAllByAttributes(array('pemakaianbhnmkn_id' => $id));
      $deleteModel = GZPemakaianbhnmknT::model()->deleteByPk($id);
      if ($deleteModelDetail && $deleteModel) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
  }

  public function actionPrintInformasi($caraPrint)
  {
    $format = new MyFormatter;
    $model  = new GZInformasipemakaianbhnmknV('search');
    $model->unsetAttributes();  // clear any default values

    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->ruanganpemakaibhnmkn = Yii::app()->user->getState('ruangan_id');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['GZInformasipemakaianbhnmknV'])) {
      $model->attributes = $_GET['GZInformasipemakaianbhnmknV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZInformasipemakaianbhnmknV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZInformasipemakaianbhnmknV']['tgl_akhir']);

      if ($model->ruanganpemakaibhnmkn == "") {
        $model->ruanganpemakaibhnmkn = Yii::app()->user->getState('ruangan_id');
      }
    }

    $this->printFunction($model, $caraPrint, "Informasi Pemakaian Bahan Makanan", $this->path_view . "printInformasi");
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
