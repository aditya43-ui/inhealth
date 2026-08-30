<?php

class InfoPemanggilanMCUController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'mcu.views.infoPemanggilanMcu.';

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pemanggilan Mcu";
    $format = new MyFormatter();
    $model  = new MCPemanggilanmcuV('searchTabel');
    $model->unsetAttributes();
    $model->tgl_awal_kontrol = date('Y-m-d');
    $model->tgl_akhir_kontrol = date('Y-m-d');
    if (isset($_GET['MCPemanggilanmcuV'])) {
      $model->attributes = $_GET['MCPemanggilanmcuV'];
      $model->tgl_awal_kontrol = $format->formatDateTimeForDb($_GET['MCPemanggilanmcuV']['tgl_awal_kontrol']);
      $model->tgl_akhir_kontrol = $format->formatDateTimeForDb($_GET['MCPemanggilanmcuV']['tgl_akhir_kontrol']);
    }
    $this->render($this->path_view . 'index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionDetail($id)
  {
    $this->layout = '//layouts/frameDialog';
    /*$modHeader = new MCPemanggilanmcuV('getHeaderDetail');
		$modHeader->unsetAttributes();
		if(isset($_GET['MCPemanggilanmcuV'])){
		$modHeader->attributes=$_GET['MCPemanggilanmcuV'];
		$modHeader->pendaftaran_id = $id;
		}
		 * 
		 */
    $judulLaporan = 'Informasi Pemanggilan MCU';
    $deskripsi = 'Detail Informasi';
    $format = new MyFormatter;
    $modHeader = MCPemanggilanmcuV::model()->findAllBySql('SELECT pendaftaran_id, no_rekam_medik, nama_pasien, nopeserta, status_hubungan FROM pemanggilanmcu_v WHERE pendaftaran_id =' . $id . 'GROUP BY pendaftaran_id, no_rekam_medik, nama_pasien, nopeserta, status_hubungan ORDER BY pendaftaran_id');
    $modDetail = MCPemanggilanmcuV::model()->findAllByAttributes(array('pendaftaran_id' => $id));
    $this->render($this->path_view . 'detailInformasi', array(
      'modHeader' => $modHeader,
      'modDetail' => $modDetail,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'format' => $format,
    ));
  }

  /**
   * untuk print data pemakaian barang
   */
  public function actionPrint($pendaftaran_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modHeader = MCPemanggilanmcuV::model()->findAllBySql('SELECT pendaftaran_id, no_rekam_medik, nama_pasien, nopeserta, status_hubungan FROM pemanggilanmcu_v WHERE pendaftaran_id =' . $pendaftaran_id . 'GROUP BY pendaftaran_id, no_rekam_medik, nama_pasien, nopeserta, status_hubungan ORDER BY pendaftaran_id');
    $modDetail = MCPemanggilanmcuV::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $judul_print = 'Informasi Pemanggilan MCU';
    $deskripsi = 'Detail Informasi';
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
      'modHeader' => $modHeader,
      'modDetail' => $modDetail,
      'caraPrint' => $caraPrint,
      'deskripsi' => $deskripsi
    ));
  }

  public function actionBatalPemakaianBarang($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $deleteDetail = PemakaianbrgdetailT::model()->deleteAllByAttributes(array('pemakaianbarang_id' => $id));
      $deletePemakaianBarang = PemakaianbarangT::model()->deleteByPk($id);
      if ($deleteDetail && $deletePemakaianBarang) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
  }
}
