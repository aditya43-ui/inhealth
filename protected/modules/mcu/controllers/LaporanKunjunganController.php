<?php
class LaporanKunjunganController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view_mcu = 'mcu.views.laporanKunjungan.';

  public function actionIndex()
  {
    $model = new MCLaporankunjunganmcuV('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');

    if (isset($_GET['MCLaporankunjunganmcuV'])) {
      $model->attributes = $_GET['MCLaporankunjunganmcuV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['MCLaporankunjunganmcuV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['MCLaporankunjunganmcuV']['tgl_akhir']);
    }

    $modDokter = new MCDokterV('searchDokterDialog');
    $modDokter->unsetAttributes();
    if (isset($_GET['MCDokterV'])) {
      $modDokter->attributes = $_GET['MCDokterV'];
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial($this->path_view_mcu . '_table', array('model' => $model), true);
    } else {
      $this->render($this->path_view_mcu . 'admin', array(
        'model' => $model,
        'modDokter' => $modDokter
      ));
    }
  }

  public function actionPrint()
  {
    $model = new MCLaporankunjunganmcuV('search');
    $judulLaporan = 'Laporan Kunjungan Pasien';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Kunjungan Pasien';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_REQUEST['MCLaporankunjunganmcuV'])) {
      $model->attributes = $_REQUEST['MCLaporankunjunganmcuV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['MCLaporankunjunganmcuV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['MCLaporankunjunganmcuV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view_mcu . '_print';

    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionFrameGrafik()
  {
    $this->layout = '//layouts/iframe';
    $model = new MCLaporankunjunganmcuV('searchGrafik');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');

    //Data Grafik
    $data['title'] = 'Grafik Info Kunjungan';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_GET['MCLaporankunjunganmcuV'])) {
      $model->attributes = $_GET['MCLaporankunjunganmcuV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['MCLaporankunjunganmcuV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['MCLaporankunjunganmcuV']['tgl_akhir']);
    }

    $this->render($this->path_view_mcu . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionAutocompleteDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $nomorindukpegawai = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
      $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nomorindukpegawai)', strtolower($nomorindukpegawai), true);
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
      $criteria->limit = 5;
      $models = MCDokterV::model()->findAll($criteria);
      if (count((array)$models) > 0) {
        foreach ($models as $i => $model) {
          $returnVal[$i] = $model->attributes;
          if (!empty($nomorindukpegawai)) {
            $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai;
          } else {
            $returnVal[$i]['label'] = $model->nama_pegawai;
          }
          $returnVal[$i]['value'] = $model->pegawai_id;
          //					$returnVal[$i]['jabatan_nama'] = !empty($model->jabatan_id) ? $model->jabatan->jabatan_nama : "";
          //					$returnVal[$i]['gelarbelakang_nama'] = !empty($model->gelarbelakang_id) ? $model->gelarbelakang_nama : "";
        }
      }
      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }
}
