<?php
Yii::import('rawatJalan.models.*');
class LaporanPesertaMcuPeroranganController extends MyAuthController
{
  public $path_view_mcu = 'mcu.views.laporanPesertaMcuPerorangan.';

  public function actionIndex()
  {
    $model = new RJInfokunjunganrjV('search');
    //        $model->tgl_awal = date('d M Y');
    //        $model->tgl_akhir = date('d M Y');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['RJInfokunjunganrjV'])) {
      $model->attributes = $_GET['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      //            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
      //            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);

      $model->jns_periode = $_GET['RJInfokunjunganrjV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJInfokunjunganrjV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJInfokunjunganrjV']['bln_akhir']);
      $model->thn_awal = $_GET['RJInfokunjunganrjV']['thn_awal'];
      $model->thn_akhir = $_GET['RJInfokunjunganrjV']['thn_akhir'];
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial($this->path_view_mcu . '_table', array('model' => $model), true);
    } else {
      $this->render($this->path_view_mcu . 'admin', array(
        'model' => $model,
      ));
    }
  }

  public function actionPrint()
  {
    $model = new RJInfokunjunganrjV('search');
    $judulLaporan = 'Laporan Peserta Medical Check Up Perorangan';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Peserta Medical Check Up Perusahaan';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_REQUEST['RJInfokunjunganrjV'])) {
      $model->attributes = $_REQUEST['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      //            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awal']);
      //            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhir']);
      $model->jns_periode = $_GET['RJInfokunjunganrjV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJInfokunjunganrjV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJInfokunjunganrjV']['bln_akhir']);
      $model->thn_awal = $_GET['RJInfokunjunganrjV']['thn_awal'];
      $model->thn_akhir = $_GET['RJInfokunjunganrjV']['thn_akhir'];
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

  public function actionFrameGrafikMcuPerorangan()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJInfokunjunganrjV('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Peserta Medical Check Up Perorangan';
    //$data['type'] = isset($_REQUEST['type'])?$_REQUEST['type']:null;
    $data['type'] = $_GET['type'];
    if (isset($_GET['RJInfokunjunganrjV'])) {
      $model->attributes = $_GET['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      //            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
      //            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
      $model->jns_periode = $_GET['RJInfokunjunganrjV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJInfokunjunganrjV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJInfokunjunganrjV']['bln_akhir']);
      $model->thn_awal = $_GET['RJInfokunjunganrjV']['thn_awal'];
      $model->thn_akhir = $_GET['RJInfokunjunganrjV']['thn_akhir'];
    }

    $this->render($this->path_view_mcu . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * set dropdown penjamin pasien dari carabayar_id
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
}
