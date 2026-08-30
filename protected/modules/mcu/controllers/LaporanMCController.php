<?php

Yii::import('rawatJalan.controllers.LaporanController');
Yii::import('rawatJalan.models.*');
Yii::import('rawatJalan.views.laporan');
/**
 * digunakan untuk laporan mcu
 * menghapus print function karena sudah tersedia dalam extendnya
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package         application.modules.mcu
 * @subpackage      controllers
 * 
 */
class LaporanMCController extends LaporanController
{

  public $path_view_mcu = 'mcu.views.laporanMC.';
  public $path_view_mcuperusahaan = 'mcu.views.laporanMcuPerusahaan.';

  // Laporan Penjamin Pasien 
  public function actionLaporanPenjaminPasien()
  {
    $this->pageTitle = Yii::app()->name . " - Penjamin Pasien";
    $model = new RJInfokunjunganrjV('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');

    if (isset($_GET['RJInfokunjunganrjV'])) {
      $model->attributes = $_GET['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial($this->path_view_mcu . 'penjaminPasien._table', array('model' => $model), true);
    } else {
      $this->render($this->path_view_mcu . 'penjaminPasien/admin', array(
        'model' => $model,
      ));
    }
  }
  /**
   * cetak laporan penjamin pasien
   */
  public function actionPrintLaporanPenjaminPasien()
  {
    $model = new RJInfokunjunganrjV('search');
    $judulLaporan = 'Laporan Penjamin Pasien';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Penjamin Pasien';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_REQUEST['RJInfokunjunganrjV'])) {
      $model->attributes = $_REQUEST['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view_mcu . '/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }
  /**
   * mencetak grafik penjamin pasien
   */
  public function actionFrameGrafikPenjaminPasien()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJInfokunjunganrjV('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');

    //Data Grafik
    $data['title'] = 'Grafik Penjamin Pasien';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_GET['RJInfokunjunganrjV'])) {
      $model->attributes = $_GET['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
    }

    $this->render($this->path_view_mcu . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * end Laporan Penjamin Pasien
   * Laporan MCU Perusahaan
   */
  public function actionLaporanMcuPerusahaan()
  {
    $model = new RJInfokunjunganrjV('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $model->carabayar_id = Params::CARABAYAR_ID_PERUSAHAAN;

    if (isset($_GET['RJInfokunjunganrjV'])) {
      $model->attributes = $_GET['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial($this->path_view_mcu . '_table', array('model' => $model), true);
    } else {
      $this->render($this->path_view_mcuperusahaan . 'admin', array(
        'model' => $model,
      ));
    }
  }
  /**
   * digunakan untuk cetak laporan perusahaan
   */
  public function actionPrintLaporanMcuPerusahaan()
  {
    $model = new RJInfokunjunganrjV('search');
    $judulLaporan = 'Laporan Medical Check Up Perusahaan';
    $model->carabayar_id = Params::CARABAYAR_ID_PERUSAHAAN;

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Medical Check Up Perusahaan';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_REQUEST['RJInfokunjunganrjV'])) {
      $model->attributes = $_REQUEST['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view_mcuperusahaan . '/_print';
    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }
  /**
   * menampilkan grafik perusahaan
   */
  public function actionFrameGrafikMcuPerusahaan()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJInfokunjunganrjV('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $model->carabayar_id = Params::CARABAYAR_ID_PERUSAHAAN;

    //Data Grafik
    $data['title'] = 'Grafik Medical Check Up Perusahaan';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_GET['RJInfokunjunganrjV'])) {
      $model->attributes = $_GET['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
    }

    $this->render($this->path_view_mcuperusahaan . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * end Laporan MCU Perusahaan
   * Laporan Peserta MCU Perusahaan
   */
  public function actionLaporanPesertaMcuPerusahaan()
  {
    $model = new RJInfokunjunganrjV('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $model->carabayar_id = Params::CARABAYAR_ID_PERUSAHAAN;

    if (isset($_GET['RJInfokunjunganrjV'])) {
      $model->attributes = $_GET['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial($this->path_view_mcu . 'pesertaMcuPerusahaan._table', array('model' => $model), true);
    } else {
      $this->render($this->path_view_mcu . 'pesertaMcuPerusahaan/admin', array(
        'model' => $model,
      ));
    }
  }
  /**
   * digunakan untuk cetak laporan mcu perusahaan
   */
  public function actionPrintLaporanPesertaMcuPerusahaan()
  {
    $model = new RJInfokunjunganrjV('search');
    $judulLaporan = 'Laporan Peserta Medical Check Up Perusahaan';
    $model->carabayar_id = Params::CARABAYAR_ID_PERUSAHAAN;

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Peserta Medical Check Up Perusahaan';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_REQUEST['RJInfokunjunganrjV'])) {
      $model->attributes = $_REQUEST['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view_mcu . 'pesertaMcuPerusahaan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }
  /**
   * digunakan untuk menampilkan grafik
   */
  public function actionFrameGrafikPesertaMcuPerusahaan()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJInfokunjunganrjV('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $model->carabayar_id = Params::CARABAYAR_ID_PERUSAHAAN;

    //Data Grafik
    $data['title'] = 'Grafik Peserta Medical Check Up Perusahaan';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_GET['RJInfokunjunganrjV'])) {
      $model->attributes = $_GET['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
    }

    $this->render($this->path_view_mcu . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * end Laporan Peserta MCU Perusahaan
   * Laporan Peserta MCU Perorangan
   */
  public function actionLaporanPesertaMcuPerorangan()
  {
    $this->pageTitle = Yii::app()->name . " - Peserta Medical Check Up Perorangan";
    $model = new RJInfokunjunganrjV('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');

    if (isset($_GET['RJInfokunjunganrjV'])) {
      $model->attributes = $_GET['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial($this->path_view_mcu . 'pesertaMcuPerorangan._table', array('model' => $model), true);
    } else {
      $this->render($this->path_view_mcu . 'pesertaMcuPerorangan/admin', array(
        'model' => $model,
      ));
    }
  }
  /**
   * digunakan untuk cetak laporan peserta mcu
   */
  public function actionPrintLaporanPesertaMcuPerorangan()
  {
    $model = new RJInfokunjunganrjV('search');
    $judulLaporan = 'Laporan Peserta Medical Check Up Perorangan';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Peserta Medical Check Up Perusahaan';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_REQUEST['RJInfokunjunganrjV'])) {
      $model->attributes = $_REQUEST['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view_mcu . 'pesertaMcuPerorangan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * digunakan untuk menampilkan grafik peserta mcu
   */
  public function actionFrameGrafikPesertaMcuPerorangan()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJInfokunjunganrjV('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Peserta Medical Check Up Perusahaan';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_GET['RJInfokunjunganrjV'])) {
      $model->attributes = $_GET['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
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

  /**
   * digunakan untuk menampilkan data laporan ke penunjang
   */
  public function actionLaporanKepenunjangMCU()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Masuk Penunjang";
    $model = new MCLaporankepenunjangmcuV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');

    $kepenunjang = CHtml::listData(RuanganpenunjangV::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_id');
    $model->ruanganpenunj_id = $kepenunjang;
    if (isset($_GET['MCLaporankepenunjangmcuV'])) {
      $model->attributes = $_GET['MCLaporankepenunjangmcuV'];
      //$model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['MCLaporankepenunjangmcuV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['MCLaporankepenunjangmcuV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['MCLaporankepenunjangmcuV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['MCLaporankepenunjangmcuV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['MCLaporankepenunjangmcuV']['bln_akhir']);
      $model->thn_awal = $_GET['MCLaporankepenunjangmcuV']['thn_awal'];
      $model->thn_akhir = $_GET['MCLaporankepenunjangmcuV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial($this->path_view . 'kepenunjang._tableKepenunjang', array('model' => $model), true);
    } else {
      $this->render($this->path_view_mcu . 'kepenunjang/adminKepenunjang', array(
        'model' => $model,
      ));
    }
  }

  /**
   * digunakan untuk cetak laporan ke penunjang
   */
  public function actionPrintLaporanKepenunjangMCU()
  {
    $model = new MCLaporankepenunjangmcuV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
    $judulLaporan = 'Laporan Kepenunjang Medical Checkup';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kepenunjang';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['MCLaporankepenunjangmcuV'])) {
      $model->attributes = $_REQUEST['MCLaporankepenunjangmcuV'];
      $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['MCLaporankepenunjangmcuV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['MCLaporankepenunjangmcuV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['MCLaporankepenunjangmcuV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['MCLaporankepenunjangmcuV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['MCLaporankepenunjangmcuV']['bln_akhir']);
      $model->thn_awal = $_GET['MCLaporankepenunjangmcuV']['thn_awal'];
      $model->thn_akhir = $_GET['MCLaporankepenunjangmcuV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view_mcu . 'kepenunjang/_printKepenunjang';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * digunakan unyuk menampilkan grafik laporan penunjang
   */
  public function actionFrameGrafikLaporanKepenunjangMCU()
  {
    $this->layout = '//layouts/iframe';
    $model = new MCLaporankepenunjangmcuV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kepenunjang';
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
    if (isset($_GET['MCLaporankepenunjangmcuV'])) {
      $model->attributes = $_GET['MCLaporankepenunjangmcuV'];
      $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['MCLaporankepenunjangmcuV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['MCLaporankepenunjangmcuV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['MCLaporankepenunjangmcuV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['MCLaporankepenunjangmcuV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['MCLaporankepenunjangmcuV']['bln_akhir']);
      $model->thn_awal = $_GET['MCLaporankepenunjangmcuV']['thn_awal'];
      $model->thn_akhir = $_GET['MCLaporankepenunjangmcuV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->path_view_mcu . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * digunakan untuk menampilkan data laporan sesnsus harian
   */
  public function actionLaporanSensusHarianMC()
  {
    $this->pageTitle = Yii::app()->name . " - Sensus Harian";
    $model = new MCLaporansensusharian('search');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    $format = new MyFormatter();
    if (!empty($_GET['MCLaporansensusharian'])) {
      $model->attributes = $_GET['MCLaporansensusharian'];

      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['MCLaporansensusharian']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['MCLaporansensusharian']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['MCLaporansensusharian']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['MCLaporansensusharian']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['MCLaporansensusharian']['bln_akhir']);
      $model->thn_awal = $_GET['MCLaporansensusharian']['thn_awal'];
      $model->thn_akhir = $_GET['MCLaporansensusharian']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial($this->path_view_mcu . 'sensus._table', array('model' => $model), true);
    } else {
      $this->render($this->path_view_mcu . 'sensus/adminSensus', array(
        'model' => $model,
      ));
    }
  }

  /**
   * digunakan untuk print laporan sensus harian
   */
  public function actionPrintLaporanSensusHarianMC()
  {

    $model = new MCLaporansensusharian('search');
    $ruanganId = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = $ruanganId;
    $format = new MyFormatter();
    $ruanganNama = RuanganM::model()->findByPk($ruanganId);
    $judulLaporan = 'Laporan Sensus Harian  <br/> ' . $ruanganNama->ruangan_nama . '';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Sensus Harian';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;

    if (isset($_REQUEST['MCLaporansensusharian'])) {
      $model->attributes = $_REQUEST['MCLaporansensusharian'];

      $model->ruangan_id = $ruanganId;
      $model->jns_periode = $_REQUEST['MCLaporansensusharian']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['MCLaporansensusharian']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['MCLaporansensusharian']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['MCLaporansensusharian']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['MCLaporansensusharian']['bln_akhir']);
      $model->thn_awal = $_GET['MCLaporansensusharian']['thn_awal'];
      $model->thn_akhir = $_GET['MCLaporansensusharian']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view_mcu . 'sensus/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * digunakan untuk menampilkan grafik sesus harian 
   */
  public function actionFrameGrafikSensusHarianMC()
  {
    $this->layout = '//layouts/iframe';
    $model = new MCLaporansensusharian('search');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $format = new MyFormatter();

    //Data Grafik
    $data['title'] = 'Grafik Laporan Sensus Harian';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;

    if (isset($_GET['MCLaporansensusharian'])) {

      $model->attributes = $_GET['MCLaporansensusharian'];
      $model->pilihanx = $_GET['MCLaporansensusharian']['pilihanx'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['MCLaporansensusharian']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['MCLaporansensusharian']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['MCLaporansensusharian']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['MCLaporansensusharian']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['MCLaporansensusharian']['bln_akhir']);
      $model->thn_awal = $_GET['MCLaporansensusharian']['thn_awal'];
      $model->thn_akhir = $_GET['MCLaporansensusharian']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->path_view_mcu . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
}
