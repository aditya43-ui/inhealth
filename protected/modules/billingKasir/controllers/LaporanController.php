<?php

class LaporanController extends MyAuthController
{
  public $path_view = 'billingKasir.views.laporan.';

  public function actionLaporanPenerimaanKasir()
  {
    $this->pageTitle = Yii::app()->name . " - Penerimaan Kasir";
    $model = new BKLaporanpenerimaankasirV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = CHtml::listData(RuangankasirV::model()->findAll(), 'ruangan_id', 'ruangan_id');
    $filter = null;
    if (isset($_GET['BKLaporanpenerimaankasirV'])) {
      $model->attributes = $_GET['BKLaporanpenerimaankasirV'];
      $model->jns_periode = $_REQUEST['BKLaporanpenerimaankasirV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanpenerimaankasirV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanpenerimaankasirV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporanpenerimaankasirV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporanpenerimaankasirV']['bln_akhir']);
      $model->thn_awal = $_GET['BKLaporanpenerimaankasirV']['thn_awal'];
      $model->thn_akhir = $_GET['BKLaporanpenerimaankasirV']['thn_akhir'];
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
      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }

    $this->render('penerimaanKasir/index', array(
      'model' => $model, 'filter' => $filter, 'format' => $format
    ));
  }

  public function actionPrintLaporanPenerimaanKasir()
  {
    $model = new BKLaporanpenerimaankasirV('search');
    $judulLaporan = 'Laporan Penerimaan Kasir';
    $format = new MyFormatter();

    //Data Grafik
    $data['title'] = 'Grafik Laporan Penerimaan Kasir';
    $data['type'] = $_REQUEST['type'];
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['BKLaporanpenerimaankasirV'])) {
      $model->attributes = $_REQUEST['BKLaporanpenerimaankasirV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BKLaporanpenerimaankasirV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BKLaporanpenerimaankasirV']['tgl_akhir']);

      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'penerimaanKasir/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanPenerimaanKasir()
  {
    $this->layout = '//layouts/iframe';
    $model = new BKLaporanpenerimaankasirV('searchGrafik');
    $format = new MyFormatter();
    //Data Grafik
    $data['title'] = 'Grafik Laporan Penerimaan Kasir';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BKLaporanpenerimaankasirV'])) {
      $model->attributes = $_GET['BKLaporanpenerimaankasirV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanpenerimaankasirV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanpenerimaankasirV']['tgl_akhir']);

      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporansetoranharian()
  {
    $model = new BKLaporansetoranharianV('search');
    $format = new MyFormatter();

    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    //$model->ruangan_id = CHtml::listData(RuangankasirV::model()->findAll(), 'ruangan_id', 'ruangan_id');
    $filter = null;
    if (isset($_GET['BKLaporansetoranharianV'])) {
      $model->attributes = $_GET['BKLaporansetoranharianV'];
      //$model->ruangankasir_id = $_GET['BKLaporansetoranharianV']['ruangankasir_id'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporansetoranharianV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporansetoranharianV']['tgl_akhir']);
    }

    $this->render('setoranHarian/index', array(
      'model' => $model, 'filter' => $filter, 'format' => $format,
    ));
  }

  public function actionPrintLaporanSetoranHarian()
  {
    $model = new BKLaporansetoranharianV('search');
    $judulLaporan = 'Laporan Setoran Harian';
    $format = new MyFormatter();
    //Data Grafik
    $data['title'] = 'Grafik Laporan Penerimaan Kasir';
    $data['type'] = $_REQUEST['type'];
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['BKLaporansetoranharianV'])) {
      $model->attributes = $_REQUEST['BKLaporansetoranharianV'];

      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BKLaporansetoranharianV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BKLaporansetoranharianV']['tgl_akhir']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'setoranHarian/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanSetoranHarian()
  {
    $this->layout = '//layouts/iframe';
    $model = new BKLaporansetoranharianV('search');
    $format = new MyFormatter();
    //Data Grafik
    $data['title'] = 'Grafik Laporan Setoran Harian';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BKLaporansetoranharianV'])) {
      $model->attributes = $_GET['BKLaporansetoranharianV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BKLaporansetoranharianV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BKLaporansetoranharianV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  //Laporanretur->mulai

  public function actionLaporanRetur()
  {
    $this->pageTitle = Yii::app()->name . " - Retur";
    $model = new BKLaporanreturpelayananV('search');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->ruangan_id = CHtml::listData(RuangankasirV::model()->findAll(), 'ruangan_id', 'ruangan_id');
    $filter = null;
    if (isset($_GET['BKLaporanreturpelayananV'])) {
      $model->attributes = $_GET['BKLaporanreturpelayananV'];
      $model->jns_periode = $_GET['BKLaporanreturpelayananV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanreturpelayananV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanreturpelayananV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporanreturpelayananV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporanreturpelayananV']['bln_akhir']);
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

    $this->render('retur/index', array(
      'model' => $model, 'filter' => $filter
    ));
  }

  public function actionPrintLaporanRetur()
  {
    $model = new BKLaporanreturpelayananV('search');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Retur Pelayanan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Retur Pelayanan';
    $data['type'] = $_REQUEST['type'];
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['BKLaporanreturpelayananV'])) {
      $model->attributes = $_REQUEST['BKLaporanreturpelayananV'];
      $model->jns_periode = $_GET['BKLaporanreturpelayananV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanreturpelayananV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanreturpelayananV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporanreturpelayananV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporanreturpelayananV']['bln_akhir']);
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
    $target = 'retur/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }


  public function actionFrameGrafikLaporanRetur()
  {
    $this->layout = '//layouts/iframe';
    $model = new BKLaporanreturpelayananV('search');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    //Data Grafik
    $data['title'] = 'Grafik Laporan Pembebasan Tarif';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BKLaporanreturpelayananV'])) {
      $model->attributes = $_GET['BKLaporanreturpelayananV'];
      $model->jns_periode = $_GET['BKLaporanreturpelayananV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanreturpelayananV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanreturpelayananV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporanreturpelayananV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporanreturpelayananV']['bln_akhir']);
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

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  //endlaporanretur

  //Batas========
  public function actionLaporanPembebasanTarif()
  {
    $model = new BKLaporanpembebasantarifV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = CHtml::listData(RuangankasirV::model()->findAll(), 'ruangan_id', 'ruangan_id');
    $filter = null;
    if (isset($_GET['BKLaporanpembebasantarifV'])) {
      $model->attributes = $_GET['BKLaporanpembebasantarifV'];
      $model->jns_periode = $_REQUEST['BKLaporanpembebasantarifV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanpembebasantarifV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanpembebasantarifV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporanpembebasantarifV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporanpembebasantarifV']['bln_akhir']);
      $model->thn_awal = $_GET['BKLaporanpembebasantarifV']['thn_awal'];
      $model->thn_akhir = $_GET['BKLaporanpembebasantarifV']['thn_akhir'];
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

    $this->render('pembebasanTarif/index', array(
      'model' => $model, 'filter' => $filter
    ));
  }

  public function actionPrintLaporanPembebasanTarif()
  {
    $model = new BKLaporanpembebasantarifV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Pembebasan Tarif';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pembebasan Tarif';
    $data['type'] = $_REQUEST['type'];
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['BKLaporanpembebasantarifV'])) {
      $model->attributes = $_REQUEST['BKLaporanpembebasantarifV'];
      $model->jns_periode = $_REQUEST['BKLaporanpembebasantarifV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanpembebasantarifV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanpembebasantarifV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporanpembebasantarifV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporanpembebasantarifV']['bln_akhir']);
      $model->thn_awal = $_GET['BKLaporanpembebasantarifV']['thn_awal'];
      $model->thn_akhir = $_GET['BKLaporanpembebasantarifV']['thn_akhir'];
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
    $target = 'pembebasanTarif/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }


  public function actionFrameGrafikLaporanPembebasanTarif()
  {
    $this->layout = '//layouts/iframe';
    $model = new BKLaporanpembebasantarifV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    //Data Grafik
    $data['title'] = 'Grafik Laporan Pembebasan Tarif';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BKLaporanpembebasantarifV'])) {
      $model->attributes = $_GET['BKLaporanpembebasantarifV'];
      $model->jns_periode = $_REQUEST['BKLaporanpembebasantarifV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanpembebasantarifV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanpembebasantarifV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporanpembebasantarifV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporanpembebasantarifV']['bln_akhir']);
      $model->thn_awal = $_GET['BKLaporanpembebasantarifV']['thn_awal'];
      $model->thn_akhir = $_GET['BKLaporanpembebasantarifV']['thn_akhir'];
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

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanPembayaranPelayanan()
  {
    $this->pageTitle = Yii::app()->name . " - Pembayaran Pelayanan";
    $model = new BKLaporanpembayaranpelayananV('search');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y 23:59:59');
    $model->ruangan_id = CHtml::listData(RuangankasirV::model()->findAll(), 'ruangan_id', 'ruangan_id');
    $model->penjamin_id =  CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = true'), 'penjamin_id', 'penjamin_id');
    $filter = null;
    if (isset($_GET['BKLaporanpembayaranpelayananV'])) {
      $model->attributes = $_GET['BKLaporanpembayaranpelayananV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanpembayaranpelayananV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanpembayaranpelayananV']['tgl_akhir']);
    }

    $this->render('pembayaranPelayanan/index', array(
      'model' => $model, 'filter' => $filter
    ));
  }

  public function actionPrintlaporanPembayaranPelayanan()
  {
    $model = new BKLaporanpembayaranpelayananV('searchPrint');
    $judulLaporan = 'Laporan Pembayaran Pelayanan';

    $lp = LoginpemakaiK::model()->findByPK(Yii::app()->user->id);

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pembayaran Pelayanan';
    $data['type'] = $_REQUEST['type'];
    $data['nama_pegawai'] = empty($lp->pegawai_id) ? "-" : $lp->pegawai->nama_pegawai;
    $model->ruangan_id = CHtml::listData(RuangankasirV::model()->findAll(), 'ruangan_id', 'ruangan_id');
    $model->penjamin_id =  CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = true'), 'penjamin_id', 'penjamin_id');
    if (isset($_REQUEST['BKLaporanpembayaranpelayananV'])) {
      $model->attributes = $_REQUEST['BKLaporanpembayaranpelayananV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BKLaporanpembayaranpelayananV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BKLaporanpembayaranpelayananV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pembayaranPelayanan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafiklaporanPembayaranPelayanan()
  {
    $this->layout = '//layouts/iframe';
    $model = new BKLaporanpembayaranpelayananV('search');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pembayaran Pelayanan';
    $data['type'] = $_GET['type'];
    $model->ruangan_id = CHtml::listData(RuangankasirV::model()->findAll(), 'ruangan_id', 'ruangan_id');
    $model->penjamin_id =  CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = true'), 'penjamin_id', 'penjamin_id');
    if (isset($_GET['BKLaporanpembayaranpelayananV'])) {
      $model->attributes = $_GET['BKLaporanpembayaranpelayananV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanpembayaranpelayananV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanpembayaranpelayananV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if (empty($model->tgl_awal)) {
      $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    }
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
      $mpdf->SetHTMLFooter('{PAGENO}');
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  protected function parserTanggal($tgl)
  {
    $tgl = explode(' ', $tgl);
    $result = array();
    foreach ($tgl as $row) {
      if (!empty($row)) {
        $result[] = $row;
      }
    }
    return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($result[0], 'yyyy-MM-dd'), 'medium', null) . ' ' . $result[1];
  }

  public function actionLaporanKunjunganPasien()
  {
    $this->pageTitle = Yii::app()->name . " - Kunjungan Rumah Sakit";
    $model = new BKLaporankunjunganPasien('searchGrafik');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['BKLaporankunjunganPasien'])) {
      $model->attributes = $_GET['BKLaporankunjunganPasien'];
      $model->jns_periode = $_GET['BKLaporankunjunganPasien']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporankunjunganPasien']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporankunjunganPasien']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporankunjunganPasien']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporankunjunganPasien']['bln_akhir']);
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

    $this->render('kunjunganPasien/adminKunjunganPasien', array(
      'model' => $model,
    ));
  }

  public function actionPrintLaporanKunjunganPasien()
  {
    $model = new BKLaporankunjunganPasien('search');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pembayaran Pelayanan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['BKLaporankunjunganPasien'])) {
      $model->attributes = $_REQUEST['BKLaporankunjunganPasien'];
      $model->jns_periode = $_GET['BKLaporankunjunganPasien']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporankunjunganPasien']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporankunjunganPasien']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporankunjunganPasien']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporankunjunganPasien']['bln_akhir']);
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
    $target = 'kunjunganPasien/_printKunjunganPasien';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikKunjunganPasien()
  {
    $this->layout = '//layouts/iframe';

    $model = new BKLaporankunjunganPasien('search');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Rumah Sakit';
    $data['type'] = $_GET['type'];

    if (isset($_GET['BKLaporankunjunganPasien'])) {
      $model->attributes = $_GET['BKLaporankunjunganPasien'];
      $model->jns_periode = $_GET['BKLaporankunjunganPasien']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporankunjunganPasien']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporankunjunganPasien']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporankunjunganPasien']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporankunjunganPasien']['bln_akhir']);
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
    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanPasienSudahBayar()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Sudah Bayar";
    $model = new BKPembayaranpelayananT('searchPasienSudahBayar');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['BKPembayaranpelayananT'])) {
      $model->attributes = $_GET['BKPembayaranpelayananT'];
      $model->no_pendaftaran = $_GET['BKPembayaranpelayananT']['no_pendaftaran'];
      $model->no_rekam_medik = $_GET['BKPembayaranpelayananT']['no_rekam_medik'];
      $model->nama_pasien = $_GET['BKPembayaranpelayananT']['nama_pasien'];
      //  $model->nama_bin = $_GET['BKPembayaranpelayananT']['nama_bin'];

      $model->jns_periode = $_GET['BKPembayaranpelayananT']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKPembayaranpelayananT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKPembayaranpelayananT']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKPembayaranpelayananT']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKPembayaranpelayananT']['bln_akhir']);
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
    if(Yii::app()->request->isAjaxRequest) {
      if(isset($_GET['ajax'])) {
        if($_GET['ajax'] == 'semua_pencarianpasien_grid' || $_GET['ajax'] == 'penjamin_pencarianpasien_grid' || $_GET['ajax'] == 'umum_pencarianpasien_grid') {
            $this->renderPartial('pasienSudahBayar/table/_tableAll', ['model' => $model]);
            $this->renderPartial('pasienSudahBayar/table/_tablePenjamin', ['model' => $model]);
            $this->renderPartial('pasienSudahBayar/table/_tableUmum', ['model' => $model]);
            Yii::app()->end();
        }
      }
    }
    $this->render('pasienSudahBayar/adminPasienSudahBayar', array('model' => $model, 'format' => $format));
  }

  public function actionLaporanPasienSudahPulang()
  {
    $model = new BKRekapitulasipasienpulangV('searchPasienSudahPulang');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');
    if (isset($_GET['BKRekapitulasipasienpulangV'])) {
      $format = new MyFormatter();
      $model->attributes = $_GET['BKRekapitulasipasienpulangV'];
      $model->no_pendaftaran = $_GET['BKRekapitulasipasienpulangV']['no_pendaftaran'];
      $model->no_rekam_medik = $_GET['BKRekapitulasipasienpulangV']['no_rekam_medik'];
      $model->nama_pasien = $_GET['BKPasiensudaBKRekapitulasipasienpulangVhpulang']['nama_pasien'];
      $model->nama_bin = $_GET['BKRekapitulasipasienpulangV']['nama_bin'];

      if (!empty($_GET['BKRekapitulasipasienpulangV']['tgl_awal'])) {
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKRekapitulasipasienpulangV']['tgl_awal']);
      }
      if (!empty($_GET['BKRekapitulasipasienpulangV']['tgl_awal'])) {
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKRekapitulasipasienpulangV']['tgl_akhir']);
      }
    }
    $this->render('pasienSudahPulang/adminPasienSudahPulang', array('model' => $model));
  }


  public function actionLaporanReturold()
  {
    $model = new BKLaporanreturpelayananV('searchPrint');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');
    if (isset($_GET['BKLaporanreturpelayananV'])) {
      $format = new MyFormatter();
      $model->attributes = $_GET['BKLaporanreturpelayananV'];

      if (!empty($_GET['BKLaporanreturpelayananV']['tgl_awal'])) {
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanreturpelayananV']['tgl_awal']);
      }
      if (!empty($_GET['BKLaporanreturpelayananV']['tgl_awal'])) {
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanreturpelayananV']['tgl_akhir']);
      }
    }
    $this->render('retur/adminretur', array('model' => $model));
  }

  public function actionPrint()
  {
    $model = new BKPembayaranpelayananT('searchPasienSudahBayar');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $data = array();
    if (isset($_GET['BKPembayaranpelayananT'])) {
      if ($_GET['filter_tab'] == 'all') {
        $data['judulLaporan'] = "<h3>Laporan Pasien Sudah Bayar - Semua</h3>";
        $judullaporan = 'Laoran Pasien Sudah Bayar - Semua';
        $data['filter'] = "all";
      } else if ($_GET['filter_tab'] == 'p3') {
        $data['judulLaporan'] = "<h3>Laporan Pasien Sudah Bayar - P3</h3>";
        $judullaporan = 'Laoran Pasien Sudah Bayar - P3';
        $data['filter'] = "p3";
      } else if ($_GET['filter_tab'] == 'umum') {
        $data['judulLaporan'] = "<h3>Laporan Pasien Sudah Bayar - Umum</h3>";
        $judullaporan = 'Laoran Pasien Sudah Bayar - Umum';
        $data['filter'] = "umum";
      }
      $data['caraPrint'] = $_REQUEST['caraPrint'];
      $model->attributes = $_GET['BKPembayaranpelayananT'];
      $model->no_pendaftaran = $_GET['BKPembayaranpelayananT']['no_pendaftaran'];
      $model->no_rekam_medik = $_GET['BKPembayaranpelayananT']['no_rekam_medik'];
      $model->nama_pasien = $_GET['BKPembayaranpelayananT']['nama_pasien'];
      //  $model->nama_bin = $_GET['BKPembayaranpelayananT']['nama_bin'];

      $model->jns_periode = $_GET['BKPembayaranpelayananT']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKPembayaranpelayananT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKPembayaranpelayananT']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKPembayaranpelayananT']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKPembayaranpelayananT']['bln_akhir']);
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
    if ($_REQUEST['caraPrint'] == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('pasienSudahBayar/print', array('model' => $model, 'data' => $data));
    } else if ($_REQUEST['caraPrint'] == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('pasienSudahBayar/print', array('model' => $model, 'data' => $data));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('pasienSudahBayar/print', array('model' => $model, 'data' => $data), true));
      $mpdf->Output($judullaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  public function actionPrintRetur()
  {
    $format = new MyFormatter();
    $model = new BKLaporanreturpelayananV('searchPrint');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');
    $data = array();

    if (isset($_GET['BKLaporanreturpelayananV'])) {
      if ($_GET['filter_tab'] == 'all') {
        $data['judulLaporan'] = "Laporan Semua";
        $data['filter'] = "all";
      }
      $data['caraPrint'] = $_REQUEST['caraPrint'];
      $model->attributes = $_GET['BKLaporanreturpelayananV'];
      if (!empty($_GET['BKLaporanreturpelayananV']['tgl_awal'])) {
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanreturpelayananV']['tgl_awal']);
      }
      if (!empty($_GET['BKLaporanreturpelayananV']['tgl_awal'])) {
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanreturpelayananV']['tgl_akhir']);
      }
    }
    if ($_REQUEST['caraPrint'] == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('retur/printretur', array('model' => $model, 'data' => $data));
    } else if ($_REQUEST['caraPrint'] == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('retur/printretur', array('model' => $model, 'data' => $data));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('retur/printretur', array('model' => $model, 'data' => $data), true));
      $mpdf->Output();
    }
  }

  public function actionLaporanKeseluruhan()
  {
    $this->pageTitle = Yii::app()->name . " - Keseluruhan";
    $model = new BKLaporanKeseluruhan('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');

    if (isset($_GET['BKLaporanKeseluruhan'])) {
      $model->attributes = $_GET['BKLaporanKeseluruhan'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanKeseluruhan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanKeseluruhan']['tgl_akhir']);
    }

    $this->render('keseluruhan/adminKeseluruhan', array(
      'model' => $model,
    ));
  }

  public function actionprintLaporanKeseluruhan()
  {
    $model = new BKLaporanKeseluruhan('search');
    $model->tgl_awal = date('d M Y') . ' 00:00:00';
    $model->tgl_akhir = date('d M Y H:i:s');
    $data = array();
    $data['judulLaporan'] = 'Laporan Keseluruhan';

    if (isset($_REQUEST['BKLaporanKeseluruhan'])) {
      $model->attributes = $_GET['BKLaporanKeseluruhan'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanKeseluruhan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanKeseluruhan']['tgl_akhir']);
    }

    $data['periode'] = 'Periode : ' . date("d-m-Y", strtotime($model->tgl_awal)) . ' s/d ' . date("d-m-Y", strtotime($model->tgl_akhir));
    if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML(
        $this->renderPartial(
          'keseluruhan/printLaporan',
          array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data
          ),
          true
        )
      );
      $mpdf->Output();
    } else {
      $this->layout = '//layouts/printWindows';
      $this->render('keseluruhan/printLaporan', array(
        'model' => $model,
        'caraPrint' => $_REQUEST['caraPrint'],
        'data' => $data
      ));
    }
  }

  public function actionRincianTagihan($id)
  {
    $this->layout = '//layouts/iframe';
    $data['judulLaporan'] = 'Rincian Tagihan Pasien';
    $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
    $modRincian = BKRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'ruangan_id'));
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    $this->render('keseluruhan/rincian', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data));
  }

  public function actionPrintRincianTagihan($id)
  {
    $data['judulLaporan'] = 'Rincian Tagihan Pasien';
    $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
    $modRincian = BKRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'ruangan_id'));
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    $uangmuka = BayaruangmukaT::model()->findAllByAttributes(
      array('pendaftaran_id' => $id)
    );
    $uang_cicilan = 0;
    foreach ($uangmuka as $val) {
      $uang_cicilan += $val->jumlahuangmuka;
    }
    $data['uang_cicilan'] = $uang_cicilan;

    if ($_REQUEST['caraPrint'] == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render(
        'keseluruhan/rincian',
        array(
          'modPendaftaran' => $modPendaftaran,
          'modRincian' => $modRincian,
          'data' => $data,
          'caraPrint' => $_REQUEST['caraPrint']
        )
      );
    } else if ($_REQUEST['caraPrint'] == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render(
        'keseluruhan/rincian',
        array(
          'modPendaftaran' => $modPendaftaran,
          'modRincian' => $modRincian,
          'data' => $data,
          'caraPrint' => $_REQUEST['caraPrint']
        )
      );
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($style, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML(
        $this->renderPartial(
          'keseluruhan/rincian',
          array(
            'modPendaftaran' => $modPendaftaran,
            'modRincian' => $modRincian,
            'data' => $data,
            'caraPrint' => $_REQUEST['caraPrint']
          )
        ),
        true
      );
      $mpdf->Output();
    }
  }

  public function actionPrintDetailLaporanKeseluruhan()
  {
    $modRincian = BKRinciantagihanpasienV::model()->findAll(
      array('order' => 'pendaftaran_id,ruangan_id')
    );
    $data['judulLaporan'] = 'Rincian Tagihan Pasien';
    $data['periode'] = 'Periode : xxx';

    $row = array();
    foreach ($modRincian as $i => $val) {
      $pendaftaran_id = $val['pendaftaran_id'];
      $row[$pendaftaran_id]['nama'] = $val['nama_pasien'];
      $row[$pendaftaran_id]['no_rm'] = $val['no_rekam_medik'];
      $row[$pendaftaran_id]['no_pendaftaran'] = $val['no_pendaftaran'];
      $row[$pendaftaran_id]['ruangan'][$i]['nama'] = $val['ruangan_nama'];
      $row[$pendaftaran_id]['ruangan'][$i]['id'] = $val['ruangan_id'];
      $row[$pendaftaran_id]['ruangan'][$i]['tindakan'] = $val['daftartindakan_nama'];
      $row[$pendaftaran_id]['ruangan'][$i]['qty'] = $val['qty_tindakan'];
      $row[$pendaftaran_id]['ruangan'][$i]['tarif_tindakan'] = $val['tarif_satuan'];
      $row[$pendaftaran_id]['ruangan'][$i]['total_tarif'] = ($val['qty_tindakan'] * $val['tarif_satuan']);
    }

    if ($_REQUEST['caraPrint'] == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render(
        'keseluruhan/printDetailKeseluruhan',
        array(
          'row' => $row,
          'data' => $data,
          'caraPrint' => $_REQUEST['caraPrint']
        )
      );
    } else if ($_REQUEST['caraPrint'] == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render(
        'keseluruhan/printDetailKeseluruhan',
        array(
          'row' => $row,
          'data' => $data,
          'caraPrint' => $_REQUEST['caraPrint']
        )
      );
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 25, 15, 15);
      $mpdf->WriteHTML(
        $this->renderPartial(
          'keseluruhan/printDetailKeseluruhan',
          array(
            'row' => $row,
            'data' => $data,
            'caraPrint' => $_REQUEST['caraPrint']
          ), true
        )
      );
      $mpdf->Output();
    }
  }


  // ============ Laporan Keseluruhan Belum Bayar ============= //


  public function actionLaporanKeseluruhanBelumBayar()
  {
    $this->pageTitle = Yii::app()->name . " - Keseluruhan Belum Bayar";
    $model = new BKLaporanKeseluruhan('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');

    if (isset($_GET['BKLaporanKeseluruhan'])) {
      $model->attributes = $_GET['BKLaporanKeseluruhan'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanKeseluruhan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanKeseluruhan']['tgl_akhir']);
    }

    $this->render('keseluruhanBelumBayar/adminKeseluruhan', array(
      'model' => $model,
    ));
  }

  public function actionprintLaporanKeseluruhanBelumBayar()
  {
    $model = new BKLaporanKeseluruhan('search');
    $model->tgl_awal = date('d M Y') . ' 00:00:00';
    $model->tgl_akhir = date('d M Y H:i:s');
    $data = array();
    $data['judulLaporan'] = 'Laporan Keseluruhan Belum Bayar';

    if (isset($_REQUEST['BKLaporanKeseluruhan'])) {
      $model->attributes = $_GET['BKLaporanKeseluruhan'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanKeseluruhan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanKeseluruhan']['tgl_akhir']);
    }

    $data['periode'] = 'Periode : ' . date("d-m-Y", strtotime($model->tgl_awal)) . ' s/d ' . date("d-m-Y", strtotime($model->tgl_akhir));
    if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML(
        $this->renderPartial(
          'keseluruhanBelumBayar/printLaporan',
          array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data
          ),
          true
        )
      );
      $mpdf->Output();
    } else {
      $this->layout = '//layouts/printWindows';
      $this->render('keseluruhanBelumBayar/printLaporan', array(
        'model' => $model,
        'caraPrint' => $_REQUEST['caraPrint'],
        'data' => $data
      ));
    }
  }

  public function actionRincianTagihanBelumBayar($id)
  {
    $this->layout = '//layouts/iframe';
    $data['judulLaporan'] = 'Rincian Tagihan Pasien Belum bayar';
    $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
    $modRincian = BKRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'ruangan_id','condition'=>'tindakansudahbayar_id is null'));
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    $this->render('keseluruhanBelumBayar/rincian', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data));
  }

  public function actionPrintRincianTagihanBelumBayar($id)
  {
    $data['judulLaporan'] = 'Rincian Tagihan Pasien Belum Bayar';
    $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
    $modRincian = BKRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('condition'=>'tindakansudahbayar_id is null', 'order' => 'ruangan_id'));
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    $uangmuka = BayaruangmukaT::model()->findAllByAttributes(
      array('pendaftaran_id' => $id)
    );
    $uang_cicilan = 0;
    foreach ($uangmuka as $val) {
      $uang_cicilan += $val->jumlahuangmuka;
    }
    $data['uang_cicilan'] = $uang_cicilan;

    if ($_REQUEST['caraPrint'] == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render(
        'keseluruhanBelumBayar/rincian',
        array(
          'modPendaftaran' => $modPendaftaran,
          'modRincian' => $modRincian,
          'data' => $data,
          'caraPrint' => $_REQUEST['caraPrint']
        )
      );
    } else if ($_REQUEST['caraPrint'] == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render(
        'keseluruhanBelumBayar/rincian',
        array(
          'modPendaftaran' => $modPendaftaran,
          'modRincian' => $modRincian,
          'data' => $data,
          'caraPrint' => $_REQUEST['caraPrint']
        )
      );
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($style, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML(
        $this->renderPartial(
          'keseluruhanBelumBayar/rincian',
          array(
            'modPendaftaran' => $modPendaftaran,
            'modRincian' => $modRincian,
            'data' => $data,
            'caraPrint' => $_REQUEST['caraPrint']
          )
        ),
        true
      );
      $mpdf->Output();
    }
  }

  public function actionPrintDetailLaporanKeseluruhanBelumBayar()
  {
    $modRincian = BKRinciantagihanpasienV::model()->findAll(
      array('condition' => 'tindakansudahbayar_id is null', 'order' => 'pendaftaran_id,ruangan_id')
    );
    $data['judulLaporan'] = 'Rincian Tagihan Pasien Belum Bayar';
    $data['periode'] = 'Periode : xxx';

    $row = array();
    foreach ($modRincian as $i => $val) {
      $pendaftaran_id = $val['pendaftaran_id'];
      $row[$pendaftaran_id]['nama'] = $val['nama_pasien'];
      $row[$pendaftaran_id]['no_rm'] = $val['no_rekam_medik'];
      $row[$pendaftaran_id]['no_pendaftaran'] = $val['no_pendaftaran'];
      $row[$pendaftaran_id]['ruangan'][$i]['nama'] = $val['ruangan_nama'];
      $row[$pendaftaran_id]['ruangan'][$i]['id'] = $val['ruangan_id'];
      $row[$pendaftaran_id]['ruangan'][$i]['tindakan'] = $val['daftartindakan_nama'];
      $row[$pendaftaran_id]['ruangan'][$i]['qty'] = $val['qty_tindakan'];
      $row[$pendaftaran_id]['ruangan'][$i]['tarif_tindakan'] = $val['tarif_satuan'];
      $row[$pendaftaran_id]['ruangan'][$i]['total_tarif'] = ($val['qty_tindakan'] * $val['tarif_satuan']);
    }

    if ($_REQUEST['caraPrint'] == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render(
        'keseluruhan/printDetailKeseluruhan',
        array(
          'row' => $row,
          'data' => $data,
          'caraPrint' => $_REQUEST['caraPrint']
        )
      );
    } else if ($_REQUEST['caraPrint'] == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render(
        'keseluruhan/printDetailKeseluruhan',
        array(
          'row' => $row,
          'data' => $data,
          'caraPrint' => $_REQUEST['caraPrint']
        )
      );
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 25, 15, 15);
      $mpdf->WriteHTML(
        $this->renderPartial(
          'keseluruhan/printDetailKeseluruhan',
          array(
            'row' => $row,
            'data' => $data,
            'caraPrint' => $_REQUEST['caraPrint']
          ), true
        )
      );
      $mpdf->Output();
    }
  }

  // ============ End Laporan Keseluruhan Belum Bayar ========= //

  public function actionLaporanCaraBayar()
  {
    $this->pageTitle = Yii::app()->name . " - Jenis Penjamin";
    $model = new BKLaporanCaraBayar('search');
    $model->unsetAttributes();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    if (isset($_GET['BKLaporanCaraBayar'])) {
      $model->attributes = $_GET['BKLaporanCaraBayar'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanCaraBayar']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanCaraBayar']['tgl_akhir']);
    }

    if (!isset($_REQUEST['caraPrint'])) {
      $this->render($this->path_view . 'caraBayar/adminCaraBayar', array(
        'model' => $model,
      ));
    } else {
      $data = array();
      $rqCaraBayar = array();
      $target = "";

      $data['periode'] = 'Periode : ' . date("d-m-Y", strtotime($model->tgl_awal)) . ' s/d ' . date("d-m-Y", strtotime($model->tgl_akhir));

      if ($_GET['BKLaporanCaraBayar']['pilihan_tab'] == 'rekap') {
        $data['judulLaporan'] = '<h3>Laporan Jenis Penjamin - Rekap P3</h3>';
        $target = $this->path_view . 'caraBayar/_printRekapCaraBayarP3';
      } else if ($_GET['BKLaporanCaraBayar']['pilihan_tab'] == 'umum') {
        $data['judulLaporan'] = '<h3>Laporan Jenis Penjamin - Data Pasien Umum</h3>';
        $target = $this->path_view . 'caraBayar/_printTableCaraBayarUmum';
      } else if ($_GET['BKLaporanCaraBayar']['pilihan_tab'] == 'rekapUmum') {
        $data['judulLaporan'] = '<h3>Laporan Jenis Penjamin - Rekap Umum</h3>';
        $target = $this->path_view . 'caraBayar/_printRekapCaraBayarUmum';
      } else if ($_GET['BKLaporanCaraBayar']['pilihan_tab'] == 'bpjs') {
        $data['judulLaporan'] = '<h3>Laporan Jenis Penjamin - Data Pasien BPJS</h3>';
        $target = $this->path_view . 'caraBayar/_printTableCaraBayarBpjs';
      } else if ($_GET['BKLaporanCaraBayar']['pilihan_tab'] == 'rekapBpjs') {
        $data['judulLaporan'] = '<h3>Laporan Jenis Penjamin - Rekap BPJS</h3>';
        $target = $this->path_view . 'caraBayar/_printRekapCaraBayarBpjs';
      } else {
        $data['judulLaporan'] = '<h3>Laporan Jenis Penjamin - Data Pasien P3</h3>';
        $target = $this->path_view . 'caraBayar/_printTableCaraBayarP3';
      }

      if ($_REQUEST['caraPrint'] == 'PDF') {
        $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        //$mpdf->useOddEven = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);

        $rqCaraBayar = array(
          'model' => $model,
          'caraPrint' => $_REQUEST['caraPrint'],
          'data' => $data
        );

        $mpdf->WriteHTML($this->renderPartial($target, $rqCaraBayar, true));

        $mpdf->Output();
      } else {
        $this->layout = '//layouts/printWindows';

        $this->render($target, array(
          'model' => $model,
          'caraPrint' => $_REQUEST['caraPrint'],
          'data' => $data
        ));
      }
    }
  }


  public function actionLaporanFarmasi()
  {
    $this->pageTitle = Yii::app()->name . " - Farmasi";
    $model = new BKObatalkesPasienT();
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['BKObatalkesPasienT'])) {
      $model->attributes = $_GET['BKObatalkesPasienT'];
      $model->no_pendaftaran = $_GET['BKObatalkesPasienT']['no_pendaftaran'];
      $model->no_rekam_medik = $_GET['BKObatalkesPasienT']['no_rekam_medik'];
      $model->jns_periode = $_GET['BKObatalkesPasienT']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKObatalkesPasienT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKObatalkesPasienT']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKObatalkesPasienT']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKObatalkesPasienT']['bln_akhir']);
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

    $data = array();
    if (!isset($_REQUEST['caraPrint'])) {

      $this->render('farmasi/adminFarmasi', array(
        'model' => $model, 'format' => $format,
      ));
    } else {
      $this->layout = '//layouts/printWindows';
      $data['periode'] = 'Periode : ' . $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
      $criteria = new CDbCriteria;
      $criteria->with = array('pasien', 'pendaftaran', 'penjualanresep');
      $criteria->addBetweenCondition('tglpelayanan', $model->tgl_awal, $model->tgl_akhir);
      $criteria->compare('pendaftaran.no_pendaftaran', $model->no_pendaftaran);
      $criteria->compare('pasien.no_rekam_medik', $model->no_rekam_medik);
      $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($model->nama_pasien), true);
      if (!empty($model->penjamin_id)) {
        if (is_array($model->penjamin_id)) {
          $criteria->addInCondition('pendaftaran.penjamin_id', $model->penjamin_id);
        } else {
          $criteria->addCondition("pendaftaran.penjamin_id = " . $model->penjamin_id);
        }
      }
      $criteria->addCondition('t.penjualanresep_id IS NOT NULL');
      $criteria->order = 'no_rekam_medik, t.penjualanresep_id';
      $record = BKObatalkesPasienT::model()->findAll($criteria);

      $row = array();
      $temp_penjualanresep_id = '';
      $idx = 0;
      foreach ($record as $i => $val) {
        $penjualanresep_id = $val->penjualanresep_id;
        $no_rekam_medik = $val->pasien->no_rekam_medik;
        $row[$no_rekam_medik]['no_rekam_medik'] = $val->pasien->no_rekam_medik;
        $row[$no_rekam_medik]['nama_pasien'] = $val->pasien->nama_pasien;
        $row[$no_rekam_medik]['data_pendaftaran'][$penjualanresep_id]['no_pendaftaran'] = (isset($val->pendaftaran_id) ? $val->pendaftaran->no_pendaftaran : "-");
        $row[$no_rekam_medik]['data_pendaftaran'][$penjualanresep_id]['tgl_pendaftaran'] = (isset($val->pendaftaran_id) ? $val->pendaftaran->tgl_pendaftaran : "-");
        $row[$no_rekam_medik]['data_pendaftaran'][$penjualanresep_id]['value'][$idx]['no_transaksi'] = $val->obatalkespasien_id;
        $row[$no_rekam_medik]['data_pendaftaran'][$penjualanresep_id]['value'][$idx]['tgl_transaksi'] = $val->tglpelayanan;
        $row[$no_rekam_medik]['data_pendaftaran'][$penjualanresep_id]['value'][$idx]['item'] = $val->obatalkes->obatalkes_nama;
        if ($_REQUEST['caraPrint'] == "EXCEL") {
          $row[$no_rekam_medik]['data_pendaftaran'][$penjualanresep_id]['value'][$idx]['apotik'] = $val->hargasatuan_oa;
          $row[$no_rekam_medik]['data_pendaftaran'][$penjualanresep_id]['value'][$idx]['qty'] = $val->qty_oa;
          $row[$no_rekam_medik]['data_pendaftaran'][$penjualanresep_id]['value'][$idx]['pasien'] = $val->hargasatuan_oa;
          $row[$no_rekam_medik]['data_pendaftaran'][$penjualanresep_id]['value'][$idx]['sub_total'] = $val->hargajual_oa;
          $row[$no_rekam_medik]['data_pendaftaran'][$penjualanresep_id]['value'][$idx]['penanggung'] = $val->subsidiasuransi;
        } else {
          $row[$no_rekam_medik]['data_pendaftaran'][$penjualanresep_id]['value'][$idx]['apotik'] = MyFormatter::formatNumberForPrint($val->hargasatuan_oa);
          $row[$no_rekam_medik]['data_pendaftaran'][$penjualanresep_id]['value'][$idx]['qty'] = $val->qty_oa;
          $row[$no_rekam_medik]['data_pendaftaran'][$penjualanresep_id]['value'][$idx]['pasien'] = MyFormatter::formatNumberForPrint($val->hargasatuan_oa);
          $row[$no_rekam_medik]['data_pendaftaran'][$penjualanresep_id]['value'][$idx]['sub_total'] = MyFormatter::formatNumberForPrint($val->hargajual_oa);
          $row[$no_rekam_medik]['data_pendaftaran'][$penjualanresep_id]['value'][$idx]['penanggung'] = MyFormatter::formatNumberForPrint($val->subsidiasuransi);
        }

        $idx++;
        $temp_penjualanresep_id = $penjualanresep_id;
      }

      if ($_REQUEST['caraPrint'] == 'PDF') {
        $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        //$mpdf->useOddEven = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);

        if ($_GET['BKObatalkesPasienT']['filter_tab'] == 'trans') {
          $data['judulLaporan'] = '<h3>Laporan Farmasi - Transaksi Farmasi</h3>';
          $mpdf->WriteHTML(
            $this->render(
              'farmasi/_printLaporanTrans',
              array(
                'model' => $model,
                'caraPrint' => $_REQUEST['caraPrint'],
                'data' => $data,
                'record' => $row
              ),
              true
            )
          );
        } else {
          $data['judulLaporan'] = '<h3>Laporan Farmasi - Rekap/Kelompok</h3>';
          $mpdf->WriteHTML(
            $this->render(
              'farmasi/_printRekapTrans',
              array(
                'model' => $model,
                'caraPrint' => $_REQUEST['caraPrint'],
                'data' => $data
              ),
              true
            )
          );
        }
        $mpdf->Output($data['judulLaporan'] . '_' . date('Y-m-d') . '.pdf', 'I');
      } else {
        //per_reg
        if ($_GET['BKObatalkesPasienT']['filter_tab'] == 'trans') {
          $data['judulLaporan'] = '<h3>Laporan Farmasi - Transaksi Farmasi</h3>';
          $this->render('farmasi/_printLaporanTrans', array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data,
            'record' => $row
          ));
        } else if ($_GET['BKObatalkesPasienT']['filter_tab'] == 'rekap') {
          $data['judulLaporan'] = '<h3>Laporan Farmasi - Rekap/Kelompok</h3>';
          $this->render('farmasi/_printRekapTrans', array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data
          ));
        } else if ($_GET['BKObatalkesPasienT']['filter_tab'] == 'per_reg') {

          $data['judulLaporan'] = 'Rekap Transaksi';
          $data['nama_pasien'] = 'Rekap Transaksi';
          $data['noreg'] = 'Rekap Transaksi';
          $data['no_rm'] = 'Rekap Transaksi';
          $data['alamat'] = 'Rekap Transaksi';
          $data['perusahaan'] = 'Rekap Transaksi';

          $criteria = new CDbCriteria;
          $criteria->with = array('pasien', 'pendaftaran', 'penjualanresep', 'obatalkes');
          $criteria->compare('pendaftaran.no_pendaftaran', $model->no_pendaftaran);
          $criteria->compare('pasien.no_rekam_medik', $model->no_rekam_medik);
          $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($model->nama_pasien), true);
          if (!empty($model->penjamin_id)) {
            if (is_array($model->penjamin_id)) {
              $criteria->addInCondition('pendaftaran.penjamin_id', $model->penjamin_id);
            } else {
              $criteria->addCondition("pendaftaran.penjamin_id = " . $model->penjamin_id);
            }
          }
          $criteria->addCondition('t.penjualanresep_id IS NOT NULL');
          $criteria->order = 'no_rekam_medik';
          $record = BKObatalkesPasienT::model()->findAll($criteria);
          $row = array();
          $idx = 0;
          foreach ($record as $i => $val) {
            $obat = $val->oa;
            $row[$obat]['kelompok'] = ($val->oa == 'OA' ? 'ALKES' : 'OBAT');
            $row[$obat]['no_rekam_medik'] = $val->pasien->no_rekam_medik;
            $row[$obat]['nama_pasien'] = $val->pasien->nama_pasien;
            $row[$obat]['data_transaksi'][$idx]['tgl_transaksi'] = $val->tglpelayanan;
            $row[$obat]['data_transaksi'][$idx]['noresep'] = $val->penjualanresep->noresep;
            $row[$obat]['data_transaksi'][$idx]['no_transaksi'] = $val->obatalkespasien_id;
            $row[$obat]['data_transaksi'][$idx]['nama_item'] = $val->obatalkes->obatalkes_nama;
            $row[$obat]['data_transaksi'][$idx]['qty'] = $val->qty_oa;
            $row[$obat]['data_transaksi'][$idx]['total'] = ($val->qty_oa * $val->hargasatuan_oa);
            if ($_REQUEST['caraPrint'] == "EXCEL") {
              $row[$obat]['data_transaksi'][$idx]['harga'] = $format->formatNumberForUser($val->hargasatuan_oa);
              //                            $row[$obat]['data_transaksi'][$idx]['total'] = $format->formatNumberForUser($val->qty_oa * $val->hargasatuan_oa);
            } else {
              $row[$obat]['data_transaksi'][$idx]['harga'] = $format->formatNumberForPrint($val->hargasatuan_oa);
              //                            $row[$obat]['data_transaksi'][$idx]['total'] = $format->formatNumberForPrint($val->qty_oa * $val->hargasatuan_oa);
            }
            $idx++;
          }
          $data['judulLaporan'] = '<h3>Laporan Farmasi - Rekap/Kelompok</h3>';
          $this->render('farmasi/_tablePerRegistrasi', array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data,
            'row' => $row
          ));
        }
      }
    }
  }

  public function actionDetailTransaksiFarmasi($id)
  {
    $format = new MyFormatter();
    $criteria = new CDbCriteria;
    $id = (isset($_REQUEST['id_pendaftaran']) ? $_REQUEST['id_pendaftaran'] : $id);
    $criteria->with = array('pasien', 'pendaftaran', 'penjualanresep', 'obatalkes');
    if (!empty($id)) {
      $criteria->addCondition("pendaftaran.pendaftaran_id = " . $id);
    }
    $criteria->addCondition('t.penjualanresep_id IS NOT NULL');
    $criteria->order = 'no_rekam_medik, no_pendaftaran, pendaftaran.penjamin_id';
    $record = BKObatalkesPasienT::model()->findAll($criteria);
    //        $data['periode'] = 'Periode : ' . $format->formatDateTimeForUser($_GET['BKObatalkesPasienT']['tgl_awal']) . ' s/d ' . $format->formatDateTimeForUser($_GET['BKObatalkesPasienT']['tgl_akhir']);
    $row = array();
    $data = array();
    $idx = 0;

    foreach ($record as $i => $val) {
      $obat = $val->oa;
      $row[$obat]['kelompok'] = ($val->oa == 'OA' ? 'ALKES' : 'OBAT');
      $row[$obat]['no_rekam_medik'] = $val->pasien->no_rekam_medik;
      $row[$obat]['nama_pasien'] = $val->pasien->nama_pasien;
      $row[$obat]['data_transaksi'][$idx]['no_transaksi'] = $val->obatalkespasien_id;
      $row[$obat]['data_transaksi'][$idx]['tgl_transaksi'] = $val->tglpelayanan;
      $row[$obat]['data_transaksi'][$idx]['noresep'] = $val->penjualanresep->noresep;
      $row[$obat]['data_transaksi'][$idx]['nama_item'] = $val->obatalkes->obatalkes_nama;
      $row[$obat]['data_transaksi'][$idx]['qty'] = $val->qty_oa;
      $row[$obat]['data_transaksi'][$idx]['total'] = ($val->qty_oa * $val->hargasatuan_oa);
      if (isset($_REQUEST['caraPrint']) && $_REQUEST['caraPrint'] == "EXCEL") {
        $row[$obat]['data_transaksi'][$idx]['harga'] = $format->formatNumberForUser($val->hargasatuan_oa);
      } else {
        $row[$obat]['data_transaksi'][$idx]['harga'] = $format->formatNumberForPrint($val->hargasatuan_oa);
      }
      $idx++;
    }

    $id = (isset($id) ? $id : 0);
    $this->layout = '//layouts/iframe';
    $model = new BKLaporanFarmasi();
    $model->pendaftaran_id = $id;

    $attributes = array('pendaftaran_id' => $id);
    $record = BKLaporanFarmasi::model()->findByAttributes($attributes);
    $data['judulLaporan'] = 'Rincian Biaya Transaksi';
    $data['nama_pasien'] = (isset($record->nama_pasien) ? $record->nama_pasien : "");
    $data['pendaftaran_id'] = $id;
    $data['no_pendaftaran'] = (isset($record->no_pendaftaran) ? $record->no_pendaftaran : "");
    $data['no_rm'] = (isset($record->no_rekam_medik) ? $record->no_rekam_medik : "");
    $data['alamat'] = (isset($record->alamat_pasien) ? $record->alamat_pasien : "");
    $data['perusahaan'] = '-';

    if (isset($_GET['BKObatalkesPasienT'])) {
      $model->attributes = $_GET['BKObatalkesPasienT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKObatalkesPasienT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKObatalkesPasienT']['tgl_akhir']);
      $model->no_pendaftaran = $_GET['BKObatalkesPasienT']['no_pendaftaran'];
    }
    $data['periode'] = 'Periode : ' . $model->tgl_awal . ' s/d ' .   $model->tgl_akhir;

    if (!isset($_REQUEST['caraPrint'])) {
      $this->render('farmasi/_tableDetailTransaksi', array(
        'model' => $model,
        'row' => $row,
        'data' => $data,
      ));
    } else {
      $this->layout = '//layouts/printWindows';
      if ($_REQUEST['caraPrint'] == 'PDF') {
        $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        //$mpdf->useOddEven = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
        $mpdf->WriteHTML(
          $this->renderPartial(
            'farmasi/_printDetailTransaksi',
            array(
              'model' => $model,
              'row' => $row,
              'data' => $data,
              'caraPrint' => $_REQUEST['caraPrint']
            ),
            true
          )
        );
        $mpdf->Output();
      }

      $this->render('farmasi/_printDetailTransaksi', array(
        'model' => $model,
        'row' => $row,
        'data' => $data,
        'caraPrint' => $_REQUEST['caraPrint']
      ));
    }
  }

  //untuk laporan Laboratorium
  public function actionLaporanLaboratorium()
  {
    $this->pageTitle = Yii::app()->name . " - Laboratorium";
    $model = new BKLaporanpendapatanpenunjangV('searchTable');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['BKLaporanpendapatanpenunjangV'])) {
      $model->attributes = $_GET['BKLaporanpendapatanpenunjangV'];
      $model->asal = isset($_GET['BKLaporanpendapatanpenunjangV']['asal']) ? $_GET['BKLaporanpendapatanpenunjangV']['asal'] : 'null';
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanpendapatanpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanpendapatanpenunjangV']['tgl_akhir']);

      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }

    $this->render('laboratoirum/adminLaboratorium', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionDetailTransaksiLab($id)
  {
    $this->layout = '//layouts/iframe';
    $model = new BKLaporanpendapatanpenunjangV('searchTable');
    $model->tgl_awal = date('d M Y H:i:s', strtotime('2012-01-01'));
    $model->tgl_akhir = date('d M Y H:i:s');
    $model->pendaftaran_id = $id;

    $data = array();
    $data['pendaftaran_id'] = $id;
    $this->render('laboratoirum/_detailTrans', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionPrintLaporanLab()
  {
    $this->layout = '//layouts/printWindows';
    $model = new BKLaporanpendapatanpenunjangV('searchTable');
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    if (isset($_GET['BKLaporanpendapatanpenunjangV'])) {
      $model->attributes = $_GET['BKLaporanpendapatanpenunjangV'];
      $model->asal = isset($_GET['BKLaporanpendapatanpenunjangV']['asal']) ? $_GET['BKLaporanpendapatanpenunjangV']['asal'] : 'null';
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanpendapatanpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanpendapatanpenunjangV']['tgl_akhir']);
    }

    $data = array();
    $data['periode'] = 'Periode : ' . date("d M Y", strtotime($model->tgl_awal)) . ' sampai dengan ' . date("d M Y", strtotime($model->tgl_akhir));

    $row = array();
    $record = $model->printLapTransaksi();
    //        if($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'trans')
    //        {
    //            foreach($record as $i=>$val){
    //                $no_rekam_medik = $val->no_rekam_medik;
    //                $no_pendaftaran = $val->no_pendaftaran;
    //                $row[$no_rekam_medik]['no_rm'] = $val->no_rekam_medik;
    //                $row[$no_rekam_medik]['nama'] = $val->nama_pasien;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['no_reg'] = $val->no_pendaftaran;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['tgl_reg'] = $val->tgl_pendaftaran;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['no_trans'] = $val->tindakanpelayanan_id;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['tgl_trans'] = $val->tgl_tindakan;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['nama_item'] = $val->daftartindakan_nama;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['qty'] = $val->qty_tindakan;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['tarif'] = $val->tarif_satuan;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['sub_total'] = ($val->qty_tindakan * $val->tarif_satuan);
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['tanggungan_p3'] = 0;
    //            }
    //        }

    //        echo "<pre>";
    //        print_r($_REQUEST['BKLaporanpendapatanpenunjangV']);exit;

    if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);

      if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'trans') {
        $data['judulLaporan'] = '<h3>Laporan Laboratorium - Transaksi Laboratorium</h3>';
        $mpdf->WriteHTML(
          $this->renderPartial(
            'laboratoirum/_printLaporanTrans',
            array(
              'model' => $model,
              'caraPrint' => $_REQUEST['caraPrint'],
              'data' => $data,
              'row' => $row
            ),
            true
          )
        );
      } else if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'rekap') {
        $data['judulLaporan'] = '<h3>Laporan Laboratorium - Rekap Laboratorium</h3>';
        $mpdf->WriteHTML(
          $this->renderPartial(
            'laboratoirum/_printRekapTrans',
            array(
              'model' => $model,
              'caraPrint' => $_REQUEST['caraPrint'],
              'data' => $data
            ),
            true
          )
        );
      } else if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'per_reg') {
        $data['judulLaporan'] = '<h3>Laporan Laboratorium - Per Registrasi</h3>';
        $this->render(
          'laboratoirum/_printPerRegistrasi',
          array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data
          )
        );
      }
      $mpdf->Output();
    } else {
      if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'trans') {
        $data['judulLaporan'] = '<h3>Laporan Laboratorium - Transaksi Laboratorium</h3>';
        $this->render(
          'laboratoirum/_printLaporanTrans',
          array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data,
            'row' => $row
          )
        );
      } else if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'rekap') {
        $data['judulLaporan'] = '<h3>Laporan Laboratorium - Rekap Laboratorium</h3>';
        $this->render(
          'laboratoirum/_printRekapTrans',
          array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data
          )
        );
      } else if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'per_reg') {
        $data['judulLaporan'] = '<h3>Laporan Laboratorium - Per Registrasi</h3>';
        $this->render(
          'laboratoirum/_printPerRegistrasi',
          array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data
          )
        );
      }
    }
  }

  public function actionPrintDetailTransLab()
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter();
    $model = new BKLaporanLaboratorium;
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    if (isset($_GET['BKLaporanLaboratorium'])) {
      $model->attributes = $_GET['BKLaporanLaboratorium'];
      $model->pendaftaran_id = $_REQUEST['id_pendaftaran'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanLaboratorium']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanLaboratorium']['tgl_akhir']);
    }

    $data = array();
    $data['judulLaporan'] = 'Detail Transaksi';
    $data['periode'] = 'Periode : ' . date("d M Y", strtotime($model->tgl_awal)) . ' sampai dengan ' . date("d M Y", strtotime($model->tgl_akhir));
    $data['pendaftaran_id'] = $_REQUEST['id_pendaftaran'];

    $pendaftaran_id = isset($_REQUEST['id_pendaftaran']) ? $_REQUEST['id_pendaftaran'] : null;
    $criteria = new CDbCriteria();
    $criteria->group = 'no_rekam_medik,nama_pasien,no_pendaftaran,tgl_pendaftaran,tindakanpelayanan_id,tgl_tindakan,daftartindakan_kode,daftartindakan_nama';
    $criteria->select = $criteria->group . ', sum(tarif_satuan) as tarif_satuan, sum(qty_tindakan) as qty_tindakan';
    $criteria->order = 'tgl_tindakan,daftartindakan_nama';
    if (!empty($pendaftaran_id)) {
      $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
    }
    $record = BKLaporanLaboratorium::model()->findAll($criteria);
    $row = array();
    foreach ($record as $x => $val) {
      $no_rekam_medik = $val->no_rekam_medik;
      $row[$no_rekam_medik]['no_rekam_medik'] = $val->no_rekam_medik;
      $row[$no_rekam_medik]['nama'] = $val->nama_pasien;
      $row[$no_rekam_medik]['noreg'] = $val->no_pendaftaran;
      $row[$no_rekam_medik]['tgl_reg'] = $val->tgl_pendaftaran;
      $row[$no_rekam_medik]['transaksi'][$x]['no_transaksi'] = $val->tindakanpelayanan_id;
      $row[$no_rekam_medik]['transaksi'][$x]['tgl_transaksi'] = $val->tgl_tindakan;
      $row[$no_rekam_medik]['transaksi'][$x]['kode'] = $val->daftartindakan_kode;
      $row[$no_rekam_medik]['transaksi'][$x]['items'] = $val->daftartindakan_nama;
      $row[$no_rekam_medik]['transaksi'][$x]['tarif_pasien'] = $val->tarif_satuan;
      $row[$no_rekam_medik]['transaksi'][$x]['penanggung'] = 0;
      $row[$no_rekam_medik]['transaksi'][$x]['tarif_lab'] = $val->tarif_satuan;
      $row[$no_rekam_medik]['transaksi'][$x]['adm'] = 0;
      $row[$no_rekam_medik]['transaksi'][$x]['total'] = $val->tarif_satuan * $val->qty_tindakan;
    }

    if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML(
        $this->renderPartial('laboratoirum/_printDetailTrans', array(
          'model' => $model,
          'data' => $data,
          'caraPrint' => $_REQUEST['caraPrint'],
          'row' => $row,
        ), true)
      );
      $mpdf->Output();
    } else {
      $this->render('laboratoirum/_printDetailTrans', array(
        'model' => $model,
        'data' => $data,
        'caraPrint' => $_REQUEST['caraPrint'],
        'row' => $row,
      ));
    }
  }

  //untuk laporan Radiologi
  public function actionLaporanRadiologi()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Radiologi";
    $model = new BKLaporanpendapatanpenunjangV('searchTableRadiologi');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['BKLaporanpendapatanpenunjangV'])) {
      $model->attributes = $_GET['BKLaporanpendapatanpenunjangV'];
      $model->asal = isset($_GET['BKLaporanpendapatanpenunjangV']['asal']) ? $_GET['BKLaporanpendapatanpenunjangV']['asal'] : 'null';
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanpendapatanpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanpendapatanpenunjangV']['tgl_akhir']);

      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }

    $this->render('radiologi/adminRadiologi', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanRad()
  {
    $this->layout = '//layouts/printWindows';
    $model = new BKLaporanpendapatanpenunjangV('searchTableRadiologi');
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    if (isset($_GET['BKLaporanpendapatanpenunjangV'])) {
      $model->attributes = $_GET['BKLaporanpendapatanpenunjangV'];
      $model->asal = isset($_GET['BKLaporanpendapatanpenunjangV']['asal']) ? $_GET['BKLaporanpendapatanpenunjangV']['asal'] : 'null';
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanpendapatanpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanpendapatanpenunjangV']['tgl_akhir']);
    }

    $data = array();
    $data['periode'] = 'Periode : ' . date("d M Y", strtotime($model->tgl_awal)) . ' sampai dengan ' . date("d M Y", strtotime($model->tgl_akhir));

    $row = array();
    $record = $model->printLapTransaksiRadiologi();
    //        if($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'trans')
    //        {
    //            foreach($record as $i=>$val){
    //                $no_rekam_medik = $val->no_rekam_medik;
    //                $no_pendaftaran = $val->no_pendaftaran;
    //                $row[$no_rekam_medik]['no_rm'] = $val->no_rekam_medik;
    //                $row[$no_rekam_medik]['nama'] = $val->nama_pasien;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['no_reg'] = $val->no_pendaftaran;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['tgl_reg'] = $val->tgl_pendaftaran;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['no_trans'] = $val->tindakanpelayanan_id;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['tgl_trans'] = $val->tgl_tindakan;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['nama_item'] = $val->daftartindakan_nama;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['qty'] = $val->qty_tindakan;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['tarif'] = $val->tarif_satuan;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['sub_total'] = ($val->qty_tindakan * $val->tarif_satuan);
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['tanggungan_p3'] = 0;
    //            }
    //        }

    //        echo "<pre>";
    //        print_r($_REQUEST['BKLaporanpendapatanpenunjangV']);exit;

    if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);

      if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'trans') {
        $data['judulLaporan'] = '<h3>Laporan Radiologi - Transaksi Radiologi</h3>';
        $mpdf->WriteHTML(
          $this->renderPartial(
            'radiologi/_printLaporanTrans',
            array(
              'model' => $model,
              'caraPrint' => $_REQUEST['caraPrint'],
              'data' => $data,
              'row' => $row
            ),
            true
          )
        );
      } else if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'rekap') {
        $data['judulLaporan'] = '<h3>Laporan Radiologi - Rekap Radiologi</h3>';
        $mpdf->WriteHTML(
          $this->renderPartial(
            'radiologi/_printRekapTrans',
            array(
              'model' => $model,
              'caraPrint' => $_REQUEST['caraPrint'],
              'data' => $data
            ),
            true
          )
        );
      } else if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'per_reg') {
        $data['judulLaporan'] = '<h3>Laporan Radiologi - Per Registrasi</h3>';
        $this->render(
          'radiologi/_printPerRegistrasi',
          array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data
          )
        );
      }
      $mpdf->Output();
    } else {
      if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'trans') {
        $data['judulLaporan'] = '<h3>Laporan Radiologi - Transaksi Radiologi</h3>';
        $this->render(
          'radiologi/_printLaporanTrans',
          array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data,
            'row' => $row
          )
        );
      } else if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'rekap') {
        $data['judulLaporan'] = '<h3>Laporan Radiologi - Rekap Radiologi</h3>';
        $this->render(
          'radiologi/_printRekapTrans',
          array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data
          )
        );
      } else if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'per_reg') {
        $data['judulLaporan'] = '<h3>Laporan Radiologi - Per Registrasi</h3>';
        $this->render(
          'radiologi/_printPerRegistrasi',
          array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data
          )
        );
      }
    }
  }

  public function actionDetailTransaksiRad($id)
  {
    $this->layout = '//layouts/iframe';
    $model = new BKLaporanpendapatanpenunjangV('searchTableRadiologi');
    $model->tgl_awal = date('d M Y H:i:s', strtotime('2012-01-01'));
    $model->tgl_akhir = date('d M Y H:i:s');
    $model->pendaftaran_id = $id;

    $data = array();
    $data['pendaftaran_id'] = $id;
    $this->render('radiologi/_detailTrans', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionPrintDetailTransRad()
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter();
    $model = new BKLaporanRadiologi;
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    if (isset($_GET['BKLaporanRadiologi'])) {
      $model->attributes = $_GET['BKLaporanRadiologi'];
      $model->pendaftaran_id = $_REQUEST['id_pendaftaran'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanRadiologi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanRadiologi']['tgl_akhir']);
    }

    $data = array();
    $data['judulLaporan'] = 'Detail Transaksi';
    $data['periode'] = 'Periode : ' . date("d M Y", strtotime($model->tgl_awal)) . ' sampai dengan ' . date("d M Y", strtotime($model->tgl_akhir));
    $data['pendaftaran_id'] = $_REQUEST['id_pendaftaran'];

    $pendaftaran_id = isset($_REQUEST['id_pendaftaran']) ? $_REQUEST['id_pendaftaran'] : null;
    $criteria = new CDbCriteria();
    $criteria->group = 'no_rekam_medik,nama_pasien,no_pendaftaran,tgl_pendaftaran,tindakanpelayanan_id,tgl_tindakan,daftartindakan_kode,daftartindakan_nama';
    $criteria->select = $criteria->group . ', sum(tarif_satuan) as tarif_satuan, sum(qty_tindakan) as qty_tindakan';
    $criteria->order = 'tgl_tindakan,daftartindakan_nama';
    if (!empty($pendaftaran_id)) {
      $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
    }
    $record = BKLaporanRadiologi::model()->findAll($criteria);
    $row = array();
    foreach ($record as $x => $val) {
      $no_rekam_medik = $val->no_rekam_medik;
      $row[$no_rekam_medik]['no_rekam_medik'] = $val->no_rekam_medik;
      $row[$no_rekam_medik]['nama'] = $val->nama_pasien;
      $row[$no_rekam_medik]['noreg'] = $val->no_pendaftaran;
      $row[$no_rekam_medik]['tgl_reg'] = $val->tgl_pendaftaran;
      $row[$no_rekam_medik]['transaksi'][$x]['no_transaksi'] = $val->tindakanpelayanan_id;
      $row[$no_rekam_medik]['transaksi'][$x]['tgl_transaksi'] = $val->tgl_tindakan;
      $row[$no_rekam_medik]['transaksi'][$x]['kode'] = $val->daftartindakan_kode;
      $row[$no_rekam_medik]['transaksi'][$x]['items'] = $val->daftartindakan_nama;
      $row[$no_rekam_medik]['transaksi'][$x]['tarif_pasien'] = $val->tarif_satuan;
      $row[$no_rekam_medik]['transaksi'][$x]['penanggung'] = 0;
      $row[$no_rekam_medik]['transaksi'][$x]['tarif_lab'] = $val->tarif_satuan;
      $row[$no_rekam_medik]['transaksi'][$x]['adm'] = 0;
      $row[$no_rekam_medik]['transaksi'][$x]['total'] = $val->tarif_satuan * $val->qty_tindakan;
    }

    if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML(
        $this->renderPartial('radiologi/_printDetailTrans', array(
          'model' => $model,
          'data' => $data,
          'caraPrint' => $_REQUEST['caraPrint'],
          'row' => $row,
        ), true)
      );
      $mpdf->Output();
    } else {
      $this->render('radiologi/_printDetailTrans', array(
        'model' => $model,
        'data' => $data,
        'caraPrint' => $_REQUEST['caraPrint'],
        'row' => $row,
      ));
    }
  }

  //untuk laporan Hemodialisa
  public function actionLaporanHemodialisa()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Hemodialisa";
    $model = new BKLaporanpendapatanpenunjangV('searchTableHemodialisa');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['BKLaporanpendapatanpenunjangV'])) {
      $model->attributes = $_GET['BKLaporanpendapatanpenunjangV'];
      $model->asal = isset($_GET['BKLaporanpendapatanpenunjangV']['asal']) ? $_GET['BKLaporanpendapatanpenunjangV']['asal'] : 'null';
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanpendapatanpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanpendapatanpenunjangV']['tgl_akhir']);

      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }

    $this->render('hemodialisa/adminHemodialisa', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanHd()
  {
    $this->layout = '//layouts/printWindows';
    $model = new BKLaporanpendapatanpenunjangV('searchTableHemodialisa');
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    if (isset($_GET['BKLaporanpendapatanpenunjangV'])) {
      $model->attributes = $_GET['BKLaporanpendapatanpenunjangV'];
      $model->asal = isset($_GET['BKLaporanpendapatanpenunjangV']['asal']) ? $_GET['BKLaporanpendapatanpenunjangV']['asal'] : 'null';
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanpendapatanpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanpendapatanpenunjangV']['tgl_akhir']);
    }

    $data = array();
    $data['periode'] = 'Periode : ' . date("d M Y", strtotime($model->tgl_awal)) . ' sampai dengan ' . date("d M Y", strtotime($model->tgl_akhir));

    $row = array();
    $record = $model->printLapTransaksiHemodialisa();
    //        if($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'trans')
    //        {
    //            foreach($record as $i=>$val){
    //                $no_rekam_medik = $val->no_rekam_medik;
    //                $no_pendaftaran = $val->no_pendaftaran;
    //                $row[$no_rekam_medik]['no_rm'] = $val->no_rekam_medik;
    //                $row[$no_rekam_medik]['nama'] = $val->nama_pasien;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['no_reg'] = $val->no_pendaftaran;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['tgl_reg'] = $val->tgl_pendaftaran;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['no_trans'] = $val->tindakanpelayanan_id;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['tgl_trans'] = $val->tgl_tindakan;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['nama_item'] = $val->daftartindakan_nama;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['qty'] = $val->qty_tindakan;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['tarif'] = $val->tarif_satuan;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['sub_total'] = ($val->qty_tindakan * $val->tarif_satuan);
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['tanggungan_p3'] = 0;
    //            }
    //        }

    //        echo "<pre>";
    //        print_r($_REQUEST['BKLaporanpendapatanpenunjangV']);exit;

    if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);

      if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'trans') {
        $data['judulLaporan'] = '<h3>Laporan Hemodialisa - Transaksi Hemodialisa</h3>';
        $mpdf->WriteHTML(
          $this->renderPartial(
            'hemodialisa/_printLaporanTrans',
            array(
              'model' => $model,
              'caraPrint' => $_REQUEST['caraPrint'],
              'data' => $data,
              'row' => $row
            ),
            true
          )
        );
      } else if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'rekap') {
        $data['judulLaporan'] = '<h3>Laporan Hemodialisa - Rekap Hemodialisa</h3>';
        $mpdf->WriteHTML(
          $this->renderPartial(
            'hemodialisa/_printRekapTrans',
            array(
              'model' => $model,
              'caraPrint' => $_REQUEST['caraPrint'],
              'data' => $data
            ),
            true
          )
        );
      } else if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'per_reg') {
        $data['judulLaporan'] = '<h3>Laporan Hemodialisa - Per Registrasi</h3>';
        $this->render(
          'hemodialisa/_printPerRegistrasi',
          array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data
          )
        );
      }
      $mpdf->Output();
    } else {
      if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'trans') {
        $data['judulLaporan'] = '<h3>Laporan Hemodialisa - Transaksi Hemodialisa</h3>';
        $this->render(
          'hemodialisa/_printLaporanTrans',
          array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data,
            'row' => $row
          )
        );
      } else if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'rekap') {
        $data['judulLaporan'] = '<h3>Laporan Hemodialisa - Rekap Hemodialisa</h3>';
        $this->render(
          'hemodialisa/_printRekapTrans',
          array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data
          )
        );
      } else if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'per_reg') {
        $data['judulLaporan'] = '<h3>Laporan Hemodialisa - Per Registrasi</h3>';
        $this->render(
          'hemodialisa/_printPerRegistrasi',
          array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data
          )
        );
      }
    }
  }

  public function actionDetailTransaksiHd($id)
  {
    $this->layout = '//layouts/iframe';
    $model = new BKLaporanpendapatanpenunjangV('searchTableHemodialisa');
    $model->tgl_awal = date('d M Y H:i:s', strtotime('2012-01-01'));
    $model->tgl_akhir = date('d M Y H:i:s');
    $model->pendaftaran_id = $id;

    $data = array();
    $data['pendaftaran_id'] = $id;
    $this->render('hemodialisa/_detailTrans', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionPrintDetailTransHd()
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter();
    $model = new BKLaporanHemodialisa;
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    if (isset($_GET['BKLaporanHemodialisa'])) {
      $model->attributes = $_GET['BKLaporanHemodialisa'];
      $model->pendaftaran_id = $_REQUEST['id_pendaftaran'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanHemodialisa']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanHemodialisa']['tgl_akhir']);
    }

    $data = array();
    $data['judulLaporan'] = 'Detail Transaksi';
    $data['periode'] = 'Periode : ' . date("d M Y", strtotime($model->tgl_awal)) . ' sampai dengan ' . date("d M Y", strtotime($model->tgl_akhir));
    $data['pendaftaran_id'] = $_REQUEST['id_pendaftaran'];

    $pendaftaran_id = isset($_REQUEST['id_pendaftaran']) ? $_REQUEST['id_pendaftaran'] : null;
    $criteria = new CDbCriteria();
    $criteria->group = 'no_rekam_medik,nama_pasien,no_pendaftaran,tgl_pendaftaran,tindakanpelayanan_id,tgl_tindakan,daftartindakan_kode,daftartindakan_nama';
    $criteria->select = $criteria->group . ', sum(tarif_satuan) as tarif_satuan, sum(qty_tindakan) as qty_tindakan';
    $criteria->order = 'tgl_tindakan,daftartindakan_nama';
    if (!empty($pendaftaran_id)) {
      $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
    }
    $record = BKLaporanHemodialisa::model()->findAll($criteria);
    $row = array();
    foreach ($record as $x => $val) {
      $no_rekam_medik = $val->no_rekam_medik;
      $row[$no_rekam_medik]['no_rekam_medik'] = $val->no_rekam_medik;
      $row[$no_rekam_medik]['nama'] = $val->nama_pasien;
      $row[$no_rekam_medik]['noreg'] = $val->no_pendaftaran;
      $row[$no_rekam_medik]['tgl_reg'] = $val->tgl_pendaftaran;
      $row[$no_rekam_medik]['transaksi'][$x]['no_transaksi'] = $val->tindakanpelayanan_id;
      $row[$no_rekam_medik]['transaksi'][$x]['tgl_transaksi'] = $val->tgl_tindakan;
      $row[$no_rekam_medik]['transaksi'][$x]['kode'] = $val->daftartindakan_kode;
      $row[$no_rekam_medik]['transaksi'][$x]['items'] = $val->daftartindakan_nama;
      $row[$no_rekam_medik]['transaksi'][$x]['tarif_pasien'] = $val->tarif_satuan;
      $row[$no_rekam_medik]['transaksi'][$x]['penanggung'] = 0;
      $row[$no_rekam_medik]['transaksi'][$x]['tarif_lab'] = $val->tarif_satuan;
      $row[$no_rekam_medik]['transaksi'][$x]['adm'] = 0;
      $row[$no_rekam_medik]['transaksi'][$x]['total'] = $val->tarif_satuan * $val->qty_tindakan;
    }

    if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML(
        $this->renderPartial('hemodialisa/_printDetailTrans', array(
          'model' => $model,
          'data' => $data,
          'caraPrint' => $_REQUEST['caraPrint'],
          'row' => $row,
        ), true)
      );
      $mpdf->Output();
    } else {
      $this->render('hemodialisa/_printDetailTrans', array(
        'model' => $model,
        'data' => $data,
        'caraPrint' => $_REQUEST['caraPrint'],
        'row' => $row,
      ));
    }
  }

  //untuk laporan MCU
  public function actionLaporanMcu()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Medical Check Up";
    $model = new BKLaporanpendapatanpenunjangV('searchTableMcu');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['BKLaporanpendapatanpenunjangV'])) {
      $model->attributes = $_GET['BKLaporanpendapatanpenunjangV'];
      $model->asal = isset($_GET['BKLaporanpendapatanpenunjangV']['asal']) ? $_GET['BKLaporanpendapatanpenunjangV']['asal'] : 'null';
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanpendapatanpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanpendapatanpenunjangV']['tgl_akhir']);

      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }

    $this->render('mcu/adminMcu', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanMcu()
  {
    $this->layout = '//layouts/printWindows';
    $model = new BKLaporanpendapatanpenunjangV('searchTableMcu');
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    if (isset($_GET['BKLaporanpendapatanpenunjangV'])) {
      $model->attributes = $_GET['BKLaporanpendapatanpenunjangV'];
      $model->asal = isset($_GET['BKLaporanpendapatanpenunjangV']['asal']) ? $_GET['BKLaporanpendapatanpenunjangV']['asal'] : 'null';
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanpendapatanpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanpendapatanpenunjangV']['tgl_akhir']);
    }

    $data = array();
    $data['periode'] = 'Periode : ' . date("d M Y", strtotime($model->tgl_awal)) . ' sampai dengan ' . date("d M Y", strtotime($model->tgl_akhir));

    $row = array();
    $record = $model->printLapTransaksiMcu();
    //        if($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'trans')
    //        {
    //            foreach($record as $i=>$val){
    //                $no_rekam_medik = $val->no_rekam_medik;
    //                $no_pendaftaran = $val->no_pendaftaran;
    //                $row[$no_rekam_medik]['no_rm'] = $val->no_rekam_medik;
    //                $row[$no_rekam_medik]['nama'] = $val->nama_pasien;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['no_reg'] = $val->no_pendaftaran;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['tgl_reg'] = $val->tgl_pendaftaran;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['no_trans'] = $val->tindakanpelayanan_id;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['tgl_trans'] = $val->tgl_tindakan;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['nama_item'] = $val->daftartindakan_nama;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['qty'] = $val->qty_tindakan;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['tarif'] = $val->tarif_satuan;
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['sub_total'] = ($val->qty_tindakan * $val->tarif_satuan);
    //                $row[$no_rekam_medik]['data_transaksi'][$no_pendaftaran]['value'][$i]['tanggungan_p3'] = 0;
    //            }
    //        }

    //        echo "<pre>";
    //        print_r($_REQUEST['BKLaporanpendapatanpenunjangV']);exit;

    if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);

      if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'trans') {
        $data['judulLaporan'] = '<h3>Laporan MCU - Transaksi MCU</h3>';
        $mpdf->WriteHTML(
          $this->renderPartial(
            'mcu/_printLaporanTrans',
            array(
              'model' => $model,
              'caraPrint' => $_REQUEST['caraPrint'],
              'data' => $data,
              'row' => $row
            ),
            true
          )
        );
      } else if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'rekap') {
        $data['judulLaporan'] = '<h3>Laporan MCU - Rekap MCU</h3>';
        $mpdf->WriteHTML(
          $this->renderPartial(
            'mcu/_printRekapTrans',
            array(
              'model' => $model,
              'caraPrint' => $_REQUEST['caraPrint'],
              'data' => $data
            ),
            true
          )
        );
      } else if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'per_reg') {
        $data['judulLaporan'] = '<h3>Laporan MCU - Per Registrasi</h3>';
        $this->render(
          'mcu/_printPerRegistrasi',
          array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data
          )
        );
      }
      $mpdf->Output();
    } else {
      if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'trans') {
        $data['judulLaporan'] = '<h3>Laporan MCU - Transaksi MCU</h3>';
        $this->render(
          'mcu/_printLaporanTrans',
          array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data,
            'row' => $row
          )
        );
      } else if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'rekap') {
        $data['judulLaporan'] = '<h3>Laporan MCU - Rekap MCU</h3>';
        $this->render(
          'mcu/_printRekapTrans',
          array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data
          )
        );
      } else if ($_GET['BKLaporanpendapatanpenunjangV']['filter_tab'] == 'per_reg') {
        $data['judulLaporan'] = '<h3>Laporan MCU - Per Registrasi</h3>';
        $this->render(
          'mcu/_printPerRegistrasi',
          array(
            'model' => $model,
            'caraPrint' => $_REQUEST['caraPrint'],
            'data' => $data
          )
        );
      }
    }
  }

  public function actionDetailTransaksiMcu($id)
  {
    $this->layout = '//layouts/iframe';
    $model = new BKLaporanpendapatanpenunjangV('searchTableMcu');
    $model->tgl_awal = date('d M Y H:i:s', strtotime('2012-01-01'));
    $model->tgl_akhir = date('d M Y H:i:s');
    $model->pendaftaran_id = $id;

    $data = array();
    $data['pendaftaran_id'] = $id;
    $this->render('mcu/_detailTrans', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionPrintDetailTransMcu()
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter();
    $model = new BKLaporanMcu;
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    if (isset($_GET['BKLaporanMcu'])) {
      $model->attributes = $_GET['BKLaporanMcu'];
      $model->pendaftaran_id = $_REQUEST['id_pendaftaran'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanMcu']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanMcu']['tgl_akhir']);
    }

    $data = array();
    $data['judulLaporan'] = 'Detail Transaksi';
    $data['periode'] = 'Periode : ' . date("d M Y", strtotime($model->tgl_awal)) . ' sampai dengan ' . date("d M Y", strtotime($model->tgl_akhir));
    $data['pendaftaran_id'] = $_REQUEST['id_pendaftaran'];

    $pendaftaran_id = isset($_REQUEST['id_pendaftaran']) ? $_REQUEST['id_pendaftaran'] : null;
    $criteria = new CDbCriteria();
    $criteria->group = 'no_rekam_medik,nama_pasien,no_pendaftaran,tgl_pendaftaran,tindakanpelayanan_id,tgl_tindakan,daftartindakan_kode,daftartindakan_nama';
    $criteria->select = $criteria->group . ', sum(tarif_satuan) as tarif_satuan, sum(qty_tindakan) as qty_tindakan';
    $criteria->order = 'tgl_tindakan,daftartindakan_nama';
    if (!empty($pendaftaran_id)) {
      $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
    }
    $record = BKLaporanMcu::model()->findAll($criteria);
    $row = array();
    foreach ($record as $x => $val) {
      $no_rekam_medik = $val->no_rekam_medik;
      $row[$no_rekam_medik]['no_rekam_medik'] = $val->no_rekam_medik;
      $row[$no_rekam_medik]['nama'] = $val->nama_pasien;
      $row[$no_rekam_medik]['noreg'] = $val->no_pendaftaran;
      $row[$no_rekam_medik]['tgl_reg'] = $val->tgl_pendaftaran;
      $row[$no_rekam_medik]['transaksi'][$x]['no_transaksi'] = $val->tindakanpelayanan_id;
      $row[$no_rekam_medik]['transaksi'][$x]['tgl_transaksi'] = $val->tgl_tindakan;
      $row[$no_rekam_medik]['transaksi'][$x]['kode'] = $val->daftartindakan_kode;
      $row[$no_rekam_medik]['transaksi'][$x]['items'] = $val->daftartindakan_nama;
      $row[$no_rekam_medik]['transaksi'][$x]['tarif_pasien'] = $val->tarif_satuan;
      $row[$no_rekam_medik]['transaksi'][$x]['penanggung'] = 0;
      $row[$no_rekam_medik]['transaksi'][$x]['tarif_lab'] = $val->tarif_satuan;
      $row[$no_rekam_medik]['transaksi'][$x]['adm'] = 0;
      $row[$no_rekam_medik]['transaksi'][$x]['total'] = $val->tarif_satuan * $val->qty_tindakan;
    }

    if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML(
        $this->renderPartial('mcu/_printDetailTrans', array(
          'model' => $model,
          'data' => $data,
          'caraPrint' => $_REQUEST['caraPrint'],
          'row' => $row,
        ), true)
      );
      $mpdf->Output();
    } else {
      $this->render('mcu/_printDetailTrans', array(
        'model' => $model,
        'data' => $data,
        'caraPrint' => $_REQUEST['caraPrint'],
        'row' => $row,
      ));
    }
  }



  public function actionLaporanClosingKasir()
  {
    $this->pageTitle = Yii::app()->name . " - Closing Kasir";
    $model = new BKLaporanclosingkasirV('searchInformasi');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');


    if (isset($_GET['BKLaporanclosingkasirV'])) {
      $model->attributes = $_GET['BKLaporanclosingkasirV'];
      $model->jns_periode = $_GET['BKLaporanclosingkasirV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanclosingkasirV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanclosingkasirV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporanclosingkasirV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporanclosingkasirV']['bln_akhir']);
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

      //$model->ruanganKasir = $_GET['BKLaporanclosingkasirV']['create_ruangan'];
    }
    // $model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd'),'medium',null);
    // $model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhir, 'yyyy-MM-dd'),'medium',null);

    $this->render('closingKasir/index', array('model' => $model));
  }

  public function actionPrintLaporanClosingKasir()
  {
    $model = new BKLaporanclosingkasirV('searchPrint');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Closing Kasir';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Closing Kasir';
    $data['type'] = $_REQUEST['type'];
    $pegCreated = LoginpemakaiK::model()->findByPK(Yii::app()->user->getState('loginpemakai_id'));
    $data['nama_pegawai'] = (!empty($pegCreated->pegawai_id)) ? $pegCreated->pegawai->nama_pegawai : Yii::app()->user->getState('nama_pemakai');
    if (isset($_REQUEST['BKLaporanclosingkasirV'])) {
      $model->attributes = $_REQUEST['BKLaporanclosingkasirV'];
      $model->jns_periode = $_GET['BKLaporanclosingkasirV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanclosingkasirV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanclosingkasirV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporanclosingkasirV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporanclosingkasirV']['bln_akhir']);
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
      if (!empty($model->pegawai_id)) {
        $judulLaporan .= '<br>';
        $judulLaporan .= PegawaiM::model()->findByPk($model->pegawai_id)->namaLengkap;
      }
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'closingKasir/print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanClosingKasir()
  {
    $this->layout = '//layouts/iframe';
    $model = new BKLaporanclosingkasirV('searchGrafik');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    //Data Grafik
    $data['title'] = 'Grafik Laporan Closing Kasir';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BKLaporanclosingkasirV'])) {
      $model->attributes = $_GET['BKLaporanclosingkasirV'];
      $model->jns_periode = $_GET['BKLaporanclosingkasirV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanclosingkasirV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanclosingkasirV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporanclosingkasirV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporanclosingkasirV']['bln_akhir']);
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
      if (!empty($model->pegawai_id)) {
        $data['title'] .= '<br>';
        $data['title'] .= PegawaiM::model()->findByPk($model->pegawai_id)->namaLengkap;
      }
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  /**
   * actionLaporanJasaDokter
   */
  public function actionLaporanJasaDokter()
  {
    //            if(!Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $format = new MyFormatter();
    $model = new BKLaporanpembayaranjasadokterV('searchLaporan');
    $model->unsetAttributes();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    if (isset($_GET['BKLaporanpembayaranjasadokterV'])) {
      $model->attributes = $_GET['BKLaporanpembayaranjasadokterV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanpembayaranjasadokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanpembayaranjasadokterV']['tgl_akhir']);
    }

    $this->render('jasaDokter/index', array(
      'model' => $model,
    ));
  }
  public function actionPrintLaporanJasaDokter()
  {
    $format = new MyFormatter();
    $model = new BKLaporanpembayaranjasadokterV('searchLaporan');
    $judulLaporan = 'Laporan Jasa Dokter';
    //Data Grafik
    $data['title'] = 'Grafik Laporan Jasa Dokter';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['BKLaporanpembayaranjasadokterV'])) {
      $model->attributes = $_REQUEST['BKLaporanpembayaranjasadokterV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BKLaporanpembayaranjasadokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BKLaporanpembayaranjasadokterV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'jasaDokter/Print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /*
* BillingKasir->LaporanRekapTransaksi
*/

  public function actionLaporanRekapTransaksi()
  {
    $this->pageTitle = Yii::app()->name . " - Rekapitulasi Transaksi";
    $model = new BKLaporanrekaptransaksiV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $modDaftarTindakan = DaftartindakanM::model()->findAll();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
    if (isset($_GET['BKLaporanrekaptransaksiV'])) {
      $model->attributes = $_GET['BKLaporanrekaptransaksiV'];
      $model->instalasi = isset($_GET['BKLaporanrekaptransaksiV']['instalasi']) ? ($_GET['BKLaporanrekaptransaksiV']['instalasi']) : "null";
      $model->jns_periode = $_REQUEST['BKLaporanrekaptransaksiV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanrekaptransaksiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanrekaptransaksiV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporanrekaptransaksiV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporanrekaptransaksiV']['bln_akhir']);
      $model->thn_awal = $_GET['BKLaporanrekaptransaksiV']['thn_awal'];
      $model->thn_akhir = $_GET['BKLaporanrekaptransaksiV']['thn_akhir'];
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

    $this->render('rekapTransaksiBedah/index', array(
      'model' => $model,
      'filter' => $filter
    ));
  }

  public function actionPrintLaporanRekapTransaksi()
  {
    $model = new BKLaporanrekaptransaksiV('searchPrintOpt');
    $judulLaporan = 'Laporan Rekap Transaksi Pasien';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Rekap Transaksi Pasien';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BKLaporanrekaptransaksiV'])) {
      $model->attributes = $_REQUEST['BKLaporanrekaptransaksiV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BKLaporanrekaptransaksiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BKLaporanrekaptransaksiV']['tgl_akhir']);
      $model->instalasi = $_GET['BKLaporanrekaptransaksiV']['instalasi'];
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'rekapTransaksiBedah/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanRekapTransaksi()
  {
    $this->layout = '//layouts/iframe';
    $model = new BKLaporanrekaptransaksiV('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Rekap Transaksi Pasien';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BKLaporanrekaptransaksiV'])) {
      $model->attributes = $_GET['BKLaporanrekaptransaksiV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanrekaptransaksiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanrekaptransaksiV']['tgl_akhir']);
      $model->instalasi = $_GET['BKLaporanrekaptransaksiV']['instalasi'];
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  /** end LaporanRekapTransaksi **/

  /*
* BillingKasir->LaporanRekapPendapatan
*/

  public function actionLaporanRekapPendapatan()
  {
    $this->pageTitle = Yii::app()->name . " - Rekapitulasi Pendapatan";
    $format = new MyFormatter();
    $model = new BKLaporanrekappendapatanV('search');

    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $filter = isset($_GET['filter']) ? $_GET['filter'] : null;

    if (isset($_GET['BKLaporanrekappendapatanV'])) {
      $model->attributes = $_GET['BKLaporanrekappendapatanV'];
      $model->jns_periode = $_GET['BKLaporanrekappendapatanV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanrekappendapatanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanrekappendapatanV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporanrekappendapatanV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporanrekappendapatanV']['bln_akhir']);
      $model->thn_awal = $_GET['BKLaporanrekappendapatanV']['thn_awal'];
      $model->thn_akhir = $_GET['BKLaporanrekappendapatanV']['thn_akhir'];
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
      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
      $model->ruangan_id = isset($_GET['BKLaporanrekappendapatanV']['ruangan_id']) ? $_GET['BKLaporanrekappendapatanV']['ruangan_id'] : null;
      $model->instalasi_id = isset($_GET['BKLaporanrekappendapatanV']['instalasi_id']) ? $_GET['BKLaporanrekappendapatanV']['instalasi_id'] : null;
    }

    $this->render('rekapPendapatan/index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanRekapPendapatan()
  {
    $model = new BKLaporanrekappendapatanV('search');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Rekap Pendapatan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Rekap Pendapatan';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BKLaporanrekappendapatanV'])) {
      $model->attributes = $_REQUEST['BKLaporanrekappendapatanV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['BKLaporanrekappendapatanV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanrekappendapatanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanrekappendapatanV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporanrekappendapatanV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporanrekappendapatanV']['bln_akhir']);
      $model->thn_awal = $_GET['BKLaporanrekappendapatanV']['thn_awal'];
      $model->thn_akhir = $_GET['BKLaporanrekappendapatanV']['thn_akhir'];
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
      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
      $model->ruangan_id = isset($_GET['BKLaporanrekappendapatanV']['ruangan_id']) ? $_GET['BKLaporanrekappendapatanV']['ruangan_id'] : null;
      $model->instalasi_id = isset($_GET['BKLaporanrekappendapatanV']['instalasi_id']) ? $_GET['BKLaporanrekappendapatanV']['instalasi_id'] : null;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'rekapPendapatan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanRekapPendapatan()
  {
    $this->layout = '//layouts/iframe';
    $model = new BKLaporanrekappendapatanV('search');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Rekap Pendapatan';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BKLaporanrekappendapatanV'])) {
      $model->attributes = $_GET['BKLaporanrekappendapatanV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['BKLaporanrekappendapatanV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanrekappendapatanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanrekappendapatanV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporanrekappendapatanV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporanrekappendapatanV']['bln_akhir']);
      $model->thn_awal = $_GET['BKLaporanrekappendapatanV']['thn_awal'];
      $model->thn_akhir = $_GET['BKLaporanrekappendapatanV']['thn_akhir'];
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
      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
      $model->ruangan_id = isset($_GET['BKLaporanrekappendapatanV']['ruangan_id']) ? $_GET['BKLaporanrekappendapatanV']['ruangan_id'] : null;
      $model->instalasi_id = isset($_GET['BKLaporanrekappendapatanV']['instalasi_id']) ? $_GET['BKLaporanrekappendapatanV']['instalasi_id'] : null;
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /*
* end BillingKasir->LaporanRekapPendapatan
*/

  /*
* BillingKasir->LaporanRekapPiutang
*/
  public function actionLaporanRekapPiutang()
  {
    $this->pageTitle = Yii::app()->name . " - Rekapitulasi Piutang";
    $model = new BKLaporanrekappendapatanV('searchPiutang');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['BKLaporanrekappendapatanV'])) {
      $model->attributes = $_GET['BKLaporanrekappendapatanV'];
      $model->jns_periode = $_REQUEST['BKLaporanrekappendapatanV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanrekappendapatanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanrekappendapatanV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporanrekappendapatanV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporanrekappendapatanV']['bln_akhir']);
      $model->thn_awal = $_GET['BKLaporanrekappendapatanV']['thn_awal'];
      $model->thn_akhir = $_GET['BKLaporanrekappendapatanV']['thn_akhir'];
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
      $model->ruangan_id = isset($_GET['BKLaporanrekappendapatanV']['ruangan_id']) ? $_GET['BKLaporanrekappendapatanV']['ruangan_id'] : null;
      $model->instalasi_id = isset($_GET['BKLaporanrekappendapatanV']['instalasi_id']) ? $_GET['BKLaporanrekappendapatanV']['instalasi_id'] : null;
    }

    $this->render('piutangPenjamin/index', array(
      'model' => $model,
    ));
  }

  public function actionPrintPasienPulang()
  {
    $format = new MyFormatter();
    $model = new BKRekapitulasipasienpulangV('searchPasienSudahPulang');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');
    $data = array();

    if (isset($_GET['BKRekapitulasipasienpulangV'])) {
      if ($_GET['filter_tab'] == 'all') {
        $data['judulLaporan'] = "Laporan Pasien Pulang";
        $data['filter'] = "all";
      } else if ($_GET['filter_tab'] == 'p3') {
        $data['judulLaporan'] = "Laporan Pasien Pulang P3";
        $data['filter'] = "p3";
      } else if ($_GET['filter_tab'] == 'umum') {
        $data['judulLaporan'] = "Laporan Pasien Pulang Umum";
        $data['filter'] = "umum";
      }
      $data['caraPrint'] = $_REQUEST['caraPrint'];
      $model->attributes = $_GET['BKRekapitulasipasienpulangV'];
      if (!empty($_GET['BKRekapitulasipasienpulangV']['tgl_awal'])) {
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKRekapitulasipasienpulangV']['tgl_awal']);
      }
      if (!empty($_GET['BKRekapitulasipasienpulangV']['tgl_awal'])) {
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKRekapitulasipasienpulangV']['tgl_akhir']);
      }
    }
    if ($_REQUEST['caraPrint'] == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('pasienSudahPulang/print', array('model' => $model, 'data' => $data));
    } else if ($_REQUEST['caraPrint'] == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('pasienSudahPulang/print', array('model' => $model, 'data' => $data));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('pasienSudahPulang/print', array('model' => $model, 'data' => $data), true));
      $mpdf->Output();
    }
  }

  public function actionPrintLaporanRekapPiutang()
  {
    $model = new BKLaporanrekappendapatanV('searchPrintPiutang');
    if ($_GET['filter_tab'] == "penjamin") {
      $penjamin = "Penjamin";
    } else {
      $penjamin = strtoupper($_GET['filter_tab']);
    }
    $judulLaporan = 'Laporan Rekap Piutang ' . $penjamin . '';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Rekap Piutang Penjamin ';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BKLaporanrekappendapatanV'])) {
      $model->attributes = $_REQUEST['BKLaporanrekappendapatanV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BKLaporanrekappendapatanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BKLaporanrekappendapatanV']['tgl_akhir']);
      $model->ruangan_id = isset($_GET['BKLaporanrekappendapatanV']['ruangan_id']) ? $_GET['BKLaporanrekappendapatanV']['ruangan_id'] : null;
      $model->instalasi_id = isset($_GET['BKLaporanrekappendapatanV']['instalasi_id']) ? $_GET['BKLaporanrekappendapatanV']['instalasi_id'] : null;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'piutangPenjamin/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanRekapPiutang()
  {
    $this->layout = '//layouts/iframe';
    $model = new BKLaporanrekappendapatanV('searchPiutang');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Rekap Piutang Penjamin';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BKLaporanrekappendapatanV'])) {
      $model->attributes = $_GET['BKLaporanrekappendapatanV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanrekappendapatanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanrekappendapatanV']['tgl_akhir']);
      $model->ruangan_id = isset($_GET['BKLaporanrekappendapatanV']['ruangan_id']) ? $_GET['BKLaporanrekappendapatanV']['ruangan_id'] : null;
      $model->instalasi_id = isset($_GET['BKLaporanrekappendapatanV']['instalasi_id']) ? $_GET['BKLaporanrekappendapatanV']['instalasi_id'] : null;
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  /*
* end BillingKasir->LaporanRekapPiutang
*/

  /*
* BillingKasir/Laporan/LaporanKinerja - Kinerja
*/

  public function actionLaporanKinerja()
  {
    $this->pageTitle = Yii::app()->name . " - Kinerja";
    $format = new MyFormatter();
    $model = new BKLaporankinerjapenunjangV();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
    $tgl_awal = '';
    $tgl_akhir = '';
    if (isset($_GET['BKLaporankinerjapenunjangV'])) {
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporankinerjapenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporankinerjapenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporankinerjapenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporankinerjapenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['BKLaporankinerjapenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['BKLaporankinerjapenunjangV']['thn_akhir'];
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

      $tgl_awal = $model->tgl_awal;
      $tgl_akhir = $model->tgl_akhir;
    }

    $this->render('kinerja/index', array(
      'model' => $model,
      'filter' => $filter,
      'format' => $format,
      'tgl_awal' => $tgl_awal, 'tgl_akhir' => $tgl_akhir,
      'kelaspelayanan_id' => $model->kelaspelayanan_id
    ));
  }

  public function actionPrintLaporanKinerja()
  {
    $model = new BKLaporankinerjapenunjangV;
    $kelas_id = isset($_REQUEST['BKLaporankinerjapenunjangV']['kelaspelayanan_id']) ? $_REQUEST['BKLaporankinerjapenunjangV']['kelaspelayanan_id'] : null;
    $ruangan_id = isset($_REQUEST['BKLaporankinerjapenunjangV']['ruanganpenunj_id']) ? $_REQUEST['BKLaporankinerjapenunjangV']['ruanganpenunj_id'] : null;
    $kelas = KelaspelayananM::model()->findByPk($kelas_id);
    $ruangan = RuanganM::model()->findByPk($ruangan_id);
    $kelasNama = isset($kelas->kelaspelayanan_nama) ? $kelas->kelaspelayanan_nama : null;
    $status = '';
    if (empty($kelas_id) && empty($ruangan_id)) {
      if ($_REQUEST['filter_tab'] == "kelas") {
        $status = 'Per Kelas - All';
      } else if ($_REQUEST['filter_tab'] == "bangsal") {
        $status = 'Per Ruangan - All';
      } else {
        $status = '';
      }
    } else if (empty($kelas_id) && !empty($ruangan_id)) {
      $status = "Per Ruangan - " . $ruangan->ruangan_nama;
    } else if (!empty($kelas_id) && empty($ruangan_id)) {
      $status = "Per Kelas - " . $kelas->kelaspelayanan_nama;
    }
    $judulLaporan = 'Laporan Kinerja ' . $status;

    if ($_REQUEST['caraPrint'] == 'GRAFIK') {
      $model = new BKLaporankinerjapenunjangV;

      if (isset($_REQUEST['BKLaporankinerjapenunjangV'])) {
        $model->attributes = $_REQUEST['BKLaporankinerjapenunjangV'];
        $format = new MyFormatter();
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BKLaporankinerjapenunjangV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BKLaporankinerjapenunjangV']['tgl_akhir']);
      }
    } else {
      if (isset($_REQUEST['BKLaporankinerjapenunjangV'])) {
        $model->attributes = $_REQUEST['BKLaporankinerjapenunjangV'];
        $format = new MyFormatter();
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BKLaporankinerjapenunjangV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BKLaporankinerjapenunjangV']['tgl_akhir']);
      }
    }

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kinerja Per Kelas';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'kinerja/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanKinerja()
  {
    $this->layout = '//layouts/iframe';
    $model = new BKLaporankinerjapenunjangV('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kinerja Per Kelas';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BKLaporankinerjapenunjangV'])) {
      $model->attributes = $_GET['BKLaporankinerjapenunjangV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporankinerjapenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporankinerjapenunjangV']['tgl_akhir']);
    }

    $this->render('kinerja/_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  /*
* end BillingKasir/Laporan/LaporanKinerja - Kinerja
*/

  // -- GANTI PERIODE LAPORAN -- //

  public function actionGantiPeriode()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $namaPeriode = $_POST['namaPeriode'];
      $month = date('m');
      $year = date('Y');
      $jumHari = cal_days_in_month(CAL_GREGORIAN, $month, $year);

      $bulan =  date("Y-m-d", mktime(0, 0, 0, $month, $jumHari, $year));


      $lastmonth = mktime(0, 0, 0, date("m") - 1, date("d"),   date("Y"));
      $nextyear  = mktime(0, 0, 0, date("m"),   date("d"),   date("Y") + 1);

      if ($namaPeriode == "hari") {
        $awal = MyFormatter::formatDateTimeForUser(date('Y-m-d 00:00:00'));
        $akhir = MyFormatter::formatDateTimeForUser(date('Y-m-d 23:59:59'));
      } else if ($namaPeriode == "bulan") {
        $awal = MyFormatter::formatDateTimeForUser(date('Y-m-01 00:00:00'));
        $akhir = MyFormatter::formatDateTimeForUser(date('' . $bulan . ' 23:59:59'));
      } else if ($namaPeriode == "tahun") {
        $awal = MyFormatter::formatDateTimeForUser(date('Y-01-01 00:00:00'));
        $akhir = MyFormatter::formatDateTimeForUser(date('Y-12-01 23:59:59'));
      } else {
        $awal = MyFormatter::formatDateTimeForUser(date('Y-m-d 00:00:00'));
        $akhir = MyFormatter::formatDateTimeForUser(date('Y-m-d 23:59:59'));
      }

      $data['periodeawal']  = $awal;
      $data['periodeakhir'] = $akhir;
      $data['namaPeriode'] = $namaPeriode;

      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }
  // -- END GANTI PERIODE LAPORAN -- //


  public function actionGetPenjaminPasienForCheckBox($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];

      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          //                    $penjamin = PenjaminpasienM::model()->findAll();
          echo '<label>Data Tidak Ditemukan</label>';
        } else {
          $criteria = new CDbCriteria();
          $criteria->addCondition('carabayar_id = ' . $carabayar_id);
          $criteria->addCondition('penjamin_aktif is true');
          $criteria->order = 'penjamin_nama ASC';
          $penjamindata = PenjaminpasienM::model()->findAll($criteria);
          $penjamin = CHtml::listData($penjamindata, 'penjamin_id', 'penjamin_nama');
          echo CHtml::hiddenField('' . $namaModel . '[penjamin_id]');
          echo "<div style='margin-left:0px;'>" . CHtml::checkBox('checkAllCaraBayar', true, array(
            'onkeypress' => "return $(this).focusNextInputField(event)",
            'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked'
          )) . " Pilih Semua";
          echo "</div><br/>";
          $i = 0;
          if (count((array)$penjamin) > 0) {
            foreach ($penjamin as $value => $name) {
              echo '<label class="checkbox">';
              echo CHtml::checkBox('' . $namaModel . '[penjamin_id][]', true, array('value' => $value));
              echo '<label for="' . $namaModel . '_penjamin_id_' . $i . '">' . $name . '</label></label>';

              $i++;
            }
          } else {
            echo '<label>Data Tidak Ditemukan</label>';
          }
        }
      }
    }
    Yii::app()->end();
  }


  /**
   * @category		controllers
   * @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * @website		<piindonesia.co.id>
   * @wiki			<https://piiproject.atlassian.net/wiki/display/MDO>
   * - laporan biaya pelayanan awal
   */
  public function actionBiayaPelayanan()
  {
    $this->pageTitle = Yii::app()->name . " - Biaya Pelayanan";
    $model = new BKLaporanbiayapelayanan('search');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['BKLaporanbiayapelayanan'])) {
      $model->attributes = $_GET['BKLaporanbiayapelayanan'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanbiayapelayanan']['tgl_akhir']);
    }

    $this->render('biayaPelayanan/index', array(
      'model' => $model
    ));
  }

  public function actionPrintBiayaPelayanan()
  {
    $model = new BKLaporanbiayapelayanan('search');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    $judulLaporan = 'Laporan Biaya Pelayanan';
    //Data Grafik
    $data['title'] = 'Grafik Laporan Biaya Pelayanan';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BKLaporanbiayapelayanan'])) {
      $model->attributes = $_REQUEST['BKLaporanbiayapelayanan'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanbiayapelayanan']['tgl_akhir']);
    }
    // echo "<pre>"; print_r($model->attributes); exit();

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'biayaPelayanan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikBiayaPelayanan()
  {
    $this->layout = '//layouts/iframe';
    $model = new BKLaporanbiayapelayanan('search');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Biaya Pelayanan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['BKLaporanbiayapelayanan'])) {
      $model->attributes = $_GET['BKLaporanbiayapelayanan'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanbiayapelayanan']['tgl_akhir']);
    }
    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * - laporan biaya pelayanan akhir
   */

  public function actionGetPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];

      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
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
