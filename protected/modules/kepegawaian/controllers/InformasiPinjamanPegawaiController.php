<?php
class InformasiPinjamanPegawaiController extends MyAuthController
{
  public $layout = '//layouts/column1';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pinjaman Pegawai";
    $format = new MyFormatter();
    $model = new KPInformasipinjamanpegawaiV;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->tgl_awal_jatuhtempo = date('Y-m-d');
    $model->tgl_akhir_jatuhtempo = date('Y-m-d');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPInformasipinjamanpegawaiV'])) {
      $model->attributes = $_GET['KPInformasipinjamanpegawaiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KPInformasipinjamanpegawaiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KPInformasipinjamanpegawaiV']['tgl_akhir']);
      $model->tgl_awal_jatuhtempo = $format->formatDateTimeForDb($_GET['KPInformasipinjamanpegawaiV']['tgl_awal_jatuhtempo']);
      $model->tgl_akhir_jatuhtempo = $format->formatDateTimeForDb($_GET['KPInformasipinjamanpegawaiV']['tgl_akhir_jatuhtempo']);
      $model->ceklis = isset($_GET['KPInformasipinjamanpegawaiV']['ceklis']) ? $_GET['KPInformasipinjamanpegawaiV']['ceklis'] : 0;
      $model->ceklistglpinjam = isset($_GET['KPInformasipinjamanpegawaiV']['ceklistglpinjam']) ? $_GET['KPInformasipinjamanpegawaiV']['ceklistglpinjam'] : 0;
    }

    $this->render('index', array(
      'model' => $model,
    ));
  }

  public function actionDetailPinjaman()
  {
    $this->layout = '//layouts/iframe';
    $pinjamanpeg_id = $_GET['pinjamanpeg_id'];
    $model = KPPinjamanPegT::model()->findByPk($pinjamanpeg_id);
    $pegawai_id = $model->pegawai_id;
    $modPegawai = KPPegawaiM::model()->findByPk($pegawai_id);
    $format = new MyFormatter();
    $modPinjamDetail = KPPinjamPegDetT::model()->findAllByAttributes(array('pinjamanpeg_id' => $model->pinjamanpeg_id), array('order' => 'angsuranke'));

    $this->render('detailPinjaman', array(
      'model' => $model,
      'modPegawai' => $modPegawai,
      'format' => $format,
      'modPinjamDetail' => $modPinjamDetail,
    ));
  }

  public function actionPrint()
  {

    $pinjamanpeg_id = $_GET['pinjamanpeg_id'];
    $model = KPPinjamanPegT::model()->findByPk($pinjamanpeg_id);
    $pegawai_id = $model->pegawai_id;
    $modPegawai = KPPegawaiM::model()->findByPk($pegawai_id);

    $judulLaporan = 'Data Pinjaman Pegawai';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('PrintPinjaman', array('model' => $model, 'modPegawai' => $modPegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('PrintPinjaman', array('model' => $model, 'modPegawai' => $modPegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('PrintPinjaman', array('model' => $model, 'modPegawai' => $modPegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionLaporan()
  {
    $format = new MyFormatter();
    $model = new KPInformasipinjamanpegawaiV;
    $model->tglpinjampeg = date('Y-m-d');
    $model->tgljatuhtempo = date('Y-m-d');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPInformasipinjamanpegawaiV'])) {
      $model->attributes = $_GET['KPInformasipinjamanpegawaiV'];
      $model->tglpinjampeg = $format->formatDateTimeForDb($_GET['KPInformasipinjamanpegawaiV']['tglpinjampeg']);
      $model->tgljatuhtempo = $format->formatDateTimeForDb($_GET['KPInformasipinjamanpegawaiV']['tgljatuhtempo']);
      $model->ceklis = isset($_GET['KPInformasipinjamanpegawaiV']['ceklis']) ? $_GET['KPInformasipinjamanpegawaiV']['ceklis'] : 0;
      $model->ceklistglpinjam = isset($_GET['KPInformasipinjamanpegawaiV']['ceklistglpinjam']) ? $_GET['KPInformasipinjamanpegawaiV']['ceklistglpinjam'] : 0;
    }

    $this->render('laporan', array(
      'model' => $model,
    ));
  }

  public function actionAutocompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 10;
      $models = PegawaiM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . '' . $model->nama_pegawai . '' . $model->gelarbelakang->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->gelardepan . '' . $model->nama_pegawai . '' . $model->gelarbelakang->gelarbelakang_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionPrintLaporan()
  {
    $model = new KPInformasipinjamanpegawaiV('searchPrint');
    $format = new MyFormatter();
    if (isset($_REQUEST['KPInformasipinjamanpegawaiV'])) {
      $model->attributes = $_REQUEST['KPInformasipinjamanpegawaiV'];
      $model->tglpinjampeg = $format->formatDateTimeForDb($_REQUEST['KPInformasipinjamanpegawaiV']['tglpinjampeg']);
      $model->tgljatuhtempo = $format->formatDateTimeForDb($_REQUEST['KPInformasipinjamanpegawaiV']['tgljatuhtempo']);
      $model->ceklis = isset($_REQUEST['KPInformasipinjamanpegawaiV']['ceklis']) ? $_REQUEST['KPInformasipinjamanpegawaiV']['ceklis'] : 0;
      $model->ceklistglpinjam = isset($_REQUEST['KPInformasipinjamanpegawaiV']['ceklistglpinjam']) ? $_REQUEST['KPInformasipinjamanpegawaiV']['ceklistglpinjam'] : 0;
    }

    $judulLaporan = 'Laporan Pinjaman Pegawai';
    $caraPrint = $_REQUEST['caraPrint'];
    $periode = $format->formatDateTimeForUser($model->tglpinjampeg) . ' s/d ' . $format->formatDateTimeForUser($model->tglpinjampeg);

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('PrintLaporan', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'periode' => $periode));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('PrintLaporan', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'periode' => $periode));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); // Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('PrintLaporan', array('model' => $model, 'judulLaporan' => $judulLaporan, 'periode' => $periode, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
