<?php

/**
 * Digunakan untuk mengakses laporan bank darah
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class LaporanController extends MyAuthController
{

  public function actionLaporanSensusHarian()
  {
    $model = new BDLaporansensuslabV('search');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $jenis = CHtml::listData(JenispemeriksaanlabM::model()->findAll('jenispemeriksaanlab_aktif = true'), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_id');
    $model->jenispemeriksaanlab_id = $jenis;
    $kunjungan = LookupM::getItems('kunjungan');
    $model->kunjungan = $kunjungan;
    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
    if (isset($_GET['filter'])) {
      $model->pilihan = $_GET['filter'];
    } else {
      $model->pilihan = null;
    }
    if (isset($_GET['BDLaporansensuslabV'])) {
      $model->attributes = $_GET['BDLaporansensuslabV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporansensuslabV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporansensuslabV']['tgl_akhir']);
    }

    $this->render('sensus/index', array(
      'model' => $model,
    ));
  }

  public function actionPrintLaporanSensusHarian()
  {
    $model = new BDLaporansensuslabV('search');
    $judulLaporan = 'Laporan Sensus Harian Laboratorium';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Sensus Harian';
    $data['type'] = $_REQUEST['type'];
    $model->pilihan = $_GET['filter'];
    if (isset($_REQUEST['BDLaporansensuslabV'])) {
      $model->attributes = $_REQUEST['BDLaporansensuslabV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporansensuslabV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporansensuslabV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'sensus/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikSensusHarian()
  {
    $this->layout = '//layouts/iframe';
    $model = new BDLaporansensuslabV('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');
    $model->pilihan = $_GET['filter'];
    //Data Grafik
    $data['title'] = 'Grafik Laporan Sensus Harian';
    $data['type'] = $_GET['type'];

    if (isset($_GET['BDLaporansensuslabV'])) {
      $model->attributes = $_GET['BDLaporansensuslabV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporansensuslabV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporansensuslabV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanKunjungan()
  {
    $model = new BDLaporanpasienpenunjangV('search');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->kunjungan = LookupM::getItems('kunjungan');
    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
    if (isset($_GET['BDLaporanpasienpenunjangV'])) {
      $model->attributes = $_GET['BDLaporanpasienpenunjangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpasienpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpasienpenunjangV']['tgl_akhir']);
    }

    $this->render('kunjungan/index', array(
      'model' => $model,
    ));
  }

  public function actionPrintLaporanKunjungan()
  {
    $model = new BDLaporanpasienpenunjangV('search');
    $judulLaporan = 'Laporan Kunjungan Laboratorium';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Laboratorium';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BDLaporanpasienpenunjangV'])) {
      $model->attributes = $_REQUEST['BDLaporanpasienpenunjangV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporanpasienpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporanpasienpenunjangV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'kunjungan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikKunjungan()
  {
    $this->layout = '//layouts/iframe';
    $model = new BDLaporanpasienpenunjangV('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien';
    $data['type'] = $_GET['type'];

    if (isset($_GET['BDLaporanpasienpenunjangV'])) {
      $model->attributes = $_GET['BDLaporanpasienpenunjangV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpasienpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpasienpenunjangV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporan10BesarPenyakit()
  {
    $model = new BDLaporan10besarpenyakit('searchTable');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->jumlahTampil = 10;
    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);

    if (isset($_GET['BDLaporan10besarpenyakit'])) {
      $model->attributes = $_GET['BDLaporan10besarpenyakit'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporan10besarpenyakit']['tgl_akhir']);
    }

    $this->render('10Besar/index', array(
      'model' => $model,
    ));
  }

  public function actionPrintLaporan10BesarPenyakit()
  {
    $model = new BDLaporan10besarpenyakit('search');
    $judulLaporan = 'Laporan 10 Besar Penyakit Pasien Laboratorium';

    //Data Grafik
    $data['title'] = 'Grafik Laporan 10 Besar Penyakit Pasien Laboratorium';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BDLaporan10besarpenyakit'])) {
      $model->attributes = $_REQUEST['BDLaporan10besarpenyakit'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporan10besarpenyakit']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '10Besar/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafik10BesarPenyakit()
  {
    $this->layout = '//layouts/iframe';
    $model = new BDLaporan10besarpenyakit('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan 10 Besar Penyakit Laboratorium';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BDLaporan10besarpenyakit'])) {
      $model->attributes = $_GET['BDLaporan10besarpenyakit'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporan10besarpenyakit']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanPemakaiObatAlkes()
  {
    $model = new BDLaporanpemakaiobatalkesV;
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $jenisObat = CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif = true'), 'jenisobatalkes_id', 'jenisobatalkes_id');
    $model->jenisobatalkes_id = $jenisObat;
    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
    if (isset($_GET['BDLaporanpemakaiobatalkesV'])) {
      $model->attributes = $_GET['BDLaporanpemakaiobatalkesV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpemakaiobatalkesV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpemakaiobatalkesV']['tgl_akhir']);
    }
    $this->render('pemakaiObatAlkes/index', array('model' => $model));
  }

  public function actionPrintLaporanPemakaiObatAlkes()
  {
    $model = new BDLaporanpemakaiobatalkesV('search');
    $judulLaporan = 'Laporan Info Pemakai Obat Alkes Laboratorium';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Pemakai Obat Alkes Laboratorium';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BDLaporanpemakaiobatalkesV'])) {
      $model->attributes = $_REQUEST['BDLaporanpemakaiobatalkesV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporanpemakaiobatalkesV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporanpemakaiobatalkesV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pemakaiObatAlkes/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }


  public function actionFrameGrafikLaporanPemakaiObatAlkes()
  {
    $this->layout = '//layouts/iframe';
    $model = new BDLaporanpemakaiobatalkesV('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pemakai Obat Alkes Laboratorium';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BDLaporanpemakaiobatalkesV'])) {
      $model->attributes = $_GET['BDLaporanpemakaiobatalkesV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpemakaiobatalkesV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpemakaiobatalkesV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanJasaInstalasi()
  {
    $model = new BDLaporanjasainstalasiV('search');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $format = new MyFormatter();
    $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $tindakan = array('LUNAS', 'BELUM LUNAS');
    $model->tindakansudahbayar_id = $tindakan;
    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
    if (isset($_GET['BDLaporanjasainstalasiV'])) {
      $model->attributes = $_GET['BDLaporanjasainstalasiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanjasainstalasiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanjasainstalasiV']['tgl_akhir']);
    }

    $this->render('jasaInstalasi/index', array(
      'model' => $model
    ));
  }

  public function actionPrintLaporanJasaInstalasi()
  {
    $model = new BDLaporanjasainstalasiV('search');
    $judulLaporan = 'Laporan Jasa Instalasi Laboratorium';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jasa Instalasi';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BDLaporanjasainstalasiV'])) {
      $model->attributes = $_REQUEST['BDLaporanjasainstalasiV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporanjasainstalasiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporanjasainstalasiV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'jasaInstalasi/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanJasaInstalasi()
  {
    $this->layout = '//layouts/iframe';
    $model = new BDLaporanjasainstalasiV('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jasa Instalasi';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BDLaporanjasainstalasiV'])) {
      $model->attributes = $_GET['BDLaporanjasainstalasiV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanjasainstalasiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanjasainstalasiV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanBiayaPelayanan()
  {
    $model = new BDLaporanbiayapelayananV('search');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE'), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
    $model->kelaspelayanan_id = $kelas;
    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
    if (isset($_GET['BDLaporanbiayapelayananV'])) {
      $model->attributes = $_GET['BDLaporanbiayapelayananV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanbiayapelayananV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanbiayapelayananV']['tgl_akhir']);
    }

    $this->render('biayaPelayanan/index', array(
      'model' => $model
    ));
  }

  public function actionPrintLaporanBiayaPelayanan()
  {
    $model = new BDLaporanbiayapelayananV('search');
    $judulLaporan = 'Laporan Biaya Pelayanan Laboratorium';
    $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE'), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
    $model->kelaspelayanan_id = $kelas;
    //Data Grafik        
    $data['title'] = 'Grafik Laporan Biaya Pelayanan Laboratorium';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BDLaporanbiayapelayananV'])) {
      $model->attributes = $_REQUEST['BDLaporanbiayapelayananV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporanbiayapelayananV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporanbiayapelayananV']['tgl_akhir']);
    }
    // echo "<pre>"; print_r($model->attributes); exit();

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'biayaPelayanan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanBiayaPelayanan()
  {
    $this->layout = '//layouts/iframe';
    $model = new BDLaporanbiayapelayananV('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Biaya Pelayanan Laboratorium';
    $data['type'] = $_GET['type'];

    if (isset($_GET['BDLaporanbiayapelayananV'])) {
      $model->attributes = $_GET['BDLaporanbiayapelayananV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanbiayapelayananV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanbiayapelayananV']['tgl_akhir']);
    }
    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  /**
   * ini digantikan oleh : bankDarah/Laporan/LaporanPendapatan
   */
  public function actionLaporanPendapatanRuangan()
  {
    $model = new BDLaporanpendapatanruanganV('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');
    $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
    $model->kelaspelayanan_id = $kelas;
    if (isset($_GET['BDLaporanpendapatanruanganV'])) {
      $model->attributes = $_GET['BDLaporanpendapatanruanganV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpendapatanruanganV']['tgl_akhir']);
    }

    $this->render('pendapatanRuangan/index', array(
      'model' => $model, 'filter' => $filter
    ));
  }

  public function actionPrintLaporanPendapatanRuangan()
  {
    $model = new BDLaporanpendapatanruanganV('search');
    $judulLaporan = 'Laporan Grafik Pendapatan Ruangan Laboratorium';

    //Data Grafik        
    $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BDLaporanpendapatanruanganV'])) {
      $model->attributes = $_REQUEST['BDLaporanpendapatanruanganV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporanpendapatanruanganV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pendapatanRuangan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanPendapatanRuangan()
  {
    $this->layout = '//layouts/iframe';
    $model = new BDLaporanpendapatanruanganV('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BDLaporanpendapatanruanganV'])) {
      $model->attributes = $_GET['BDLaporanpendapatanruanganV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpendapatanruanganV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * Digunakan untuk mengakses menu laporan buku register modul bank darah
   * @author Andyka Putra <andykaputra@.com>
   * RSST-1573
   */
  public function actionLaporanBukuRegister()
  {
    $model = new BDLaporanregisterpermintaandarahV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['BDLaporanregisterpermintaandarahV'])) {
      $model->attributes = $_GET['BDLaporanregisterpermintaandarahV'];
      $model->jns_periode = $_GET['BDLaporanregisterpermintaandarahV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanregisterpermintaandarahV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanregisterpermintaandarahV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BDLaporanregisterpermintaandarahV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BDLaporanregisterpermintaandarahV']['bln_akhir']);
      $model->thn_awal = $_GET['BDLaporanregisterpermintaandarahV']['thn_awal'];
      $model->thn_akhir = $_GET['BDLaporanregisterpermintaandarahV']['thn_akhir'];
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

    $this->render('bukuRegister/index', array(
      'model' => $model,
    ));
  }

  /**
   * Fungsi cetak laporan buku register modul bank darah
   * @author Andyka Putra <andykaputra@.com>
   * RSST-1573
   */
  public function actionPrintLaporanBukuRegister()
  {
    $model = new BDLaporanregisterpermintaandarahV('search');
    $judulLaporan = 'Laporan Buku Register Permintaan Darah';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Buku Register Permintaan Darah';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BDLaporanregisterpermintaandarahV'])) {
      $model->attributes = $_REQUEST['BDLaporanregisterpermintaandarahV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporanregisterpermintaandarahV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporanregisterpermintaandarahV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'bukuRegister/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * Fungsi menampilkan grafik pada laporan buku register modul bank darah
   * @author Andyka Putra <andykaputra@.com>
   * RSST-1573
   */
  public function actionFrameGrafikBukuRegister()
  {
    $this->layout = '//layouts/iframe';
    $model = new BDLaporanregisterpermintaandarahV('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Buku Register Permintaan Darah';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BDLaporanregisterpermintaandarahV'])) {
      $model->attributes = $_GET['BDLaporanregisterpermintaandarahV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanregisterpermintaandarahV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanregisterpermintaandarahV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanCaraMasukPasien()
  {
    $model = new BDLaporancaramasukpenunjangV('search');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $asalrujukan = CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'), 'asalrujukan_id', 'asalrujukan_id');
    $model->asalrujukan_id = $asalrujukan;
    $ruanganasal = CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_id');
    $model->ruanganasal_id = $ruanganasal;
    $model->pilihan = 'instalasi';
    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
    if (isset($_GET['BDLaporancaramasukpenunjangV'])) {
      $model->attributes = $_GET['BDLaporancaramasukpenunjangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporancaramasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporancaramasukpenunjangV']['tgl_akhir']);
      $model->asalrujukan_id = $_GET['BDLaporancaramasukpenunjangV']['asalrujukan_id'];
    }

    $this->render('caraMasuk/index', array(
      'model' => $model
    ));
  }

  public function actionPrintLaporanCaraMasukPasien()
  {
    $model = new BDLaporancaramasukpenunjangV('search');
    $judulLaporan = 'Laporan Cara Masuk Pasien Laboratorium';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
    $data['type'] = $_REQUEST['type'];

    if (isset($_REQUEST['BDLaporancaramasukpenunjangV'])) {
      $model->attributes = $_REQUEST['BDLaporancaramasukpenunjangV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporancaramasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporancaramasukpenunjangV']['tgl_akhir']);
      $model->asalrujukan_id = $_GET['BDLaporancaramasukpenunjangV']['asalrujukan_id'];
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'caraMasuk/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanCaraMasukPasien()
  {
    $this->layout = '//layouts/iframe';
    $model = new BDLaporancaramasukpenunjangV('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BDLaporancaramasukpenunjangV'])) {
      $model->attributes = $_GET['BDLaporancaramasukpenunjangV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporancaramasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporancaramasukpenunjangV']['tgl_akhir']);
      $model->asalrujukan_id = $_GET['BDLaporancaramasukpenunjangV']['asalrujukan_id'];
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanPemeriksaanPenunjang()
  {
    $judulLaporan = 'Laporan <b>Pemeriksaan Laboratorium</b>';
    $model = new BDLaporanpemeriksaanpenunjangV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['BDLaporanpemeriksaanpenunjangV'])) {
      $model->attributes = $_GET['BDLaporanpemeriksaanpenunjangV'];
      $model->jns_periode = $_GET['BDLaporanpemeriksaanpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaanpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaanpenunjangV']['tgl_akhir']);
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

    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
    $model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
    $model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));
    $this->render('pemeriksaanPenunjang/adminPemeriksaanPenunjang', array(
      'model' => $model,
      'judulLaporan' => $judulLaporan,
    ));
  }

  public function actionPrintLaporanPemeriksaanPenunjang()
  {
    $model = new BDLaporanpemeriksaanpenunjangV('search');
    $judulLaporan = 'Laporan Pemeriksaan Laboratorium';
    //        $model->tgl_awal = $_REQUEST['BDLaporanpemeriksaanpenunjangV']['tgl_awal'];
    //        $model->tgl_akhir = $_REQUEST['BDLaporanpemeriksaanpenunjangV']['tgl_akhir'];
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    //Data Grafik
    $data['title'] = 'Grafik Laporan Pemeriksaan Penunjang';
    if (isset($_REQUEST['type'])) {
      $data['type'] = $_REQUEST['type'];
    } else {
      $data['type'] = null;
    }
    if (isset($_REQUEST['BDLaporanpemeriksaanpenunjangV'])) {
      $model->attributes = $_REQUEST['BDLaporanpemeriksaanpenunjangV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['BDLaporanpemeriksaanpenunjangV']['jns_periode'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['BDLaporanpemeriksaanpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporanpemeriksaanpenunjangV']['tgl_akhir']);
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
    $model->tgl_awal = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_awal))));
    $model->tgl_akhir = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_akhir))));
    $model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
    $model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pemeriksaanPenunjang/_printPemeriksaanPenunjang';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikPemeriksaanPenunjang()
  {
    $this->layout = '//layouts/iframe';
    $model = new BDLaporanpemeriksaanpenunjangV('search');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    //Data Grafik
    $data['title'] = 'Grafik Laporan Pemeriksaan Penunjang';
    if (isset($_REQUEST['type'])) {
      $data['type'] = $_REQUEST['type'];
    } else {
      $data['type'] = null;
    }
    if (isset($_GET['BDLaporanpemeriksaanpenunjangV'])) {
      $model->attributes = $_GET['BDLaporanpemeriksaanpenunjangV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['BDLaporanpemeriksaanpenunjangV']['jns_periode'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['BDLaporanpemeriksaanpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporanpemeriksaanpenunjangV']['tgl_akhir']);
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

  public function actionLaporanPemeriksaanRujukan()
  {
    //        $model = new BDLaporanpemeriksaanrujukanV('search');
    //        $modelRS = new BDLaporanpemeriksaanrujukanrsV('search');
    //        $format = new MyFormatter();
    //        $model->jns_periode = "hari";
    //        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    //        $model->tgl_akhir = date('Y-m-d');
    //        $model->bln_awal = date('Y-m', strtotime('first day of january'));
    //        $model->bln_akhir = date('Y-m');
    //        $model->thn_awal = date('Y');
    //        $model->thn_akhir = date('Y');
    //        if (isset($_GET['BDLaporanpemeriksaanrujukanV'])) {
    //            $model->attributes = $_GET['BDLaporanpemeriksaanrujukanV'];
    //            $model->jns_periode = $_GET['BDLaporanpemeriksaanrujukanV']['jns_periode'];
    //            $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaanrujukanV']['tgl_awal']);
    //            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaanrujukanV']['tgl_akhir']);
    //            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
    //            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
    //            switch($model->jns_periode){
    //                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
    //                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
    //                default : null;
    //            }
    //            $model->tgl_awal = $model->tgl_awal." 00:00:00";
    //            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
    ////            $model->no_pendaftaran = $_GET['BDLaporanpemeriksaanrujukanV']['no_pendaftaran'];
    //            
    //            $modelRS->attributes = $_GET['BDLaporanpemeriksaanrujukanV'];
    //            $modelRS->jns_periode = $_GET['BDLaporanpemeriksaanrujukanV']['jns_periode'];
    //            $modelRS->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaanrujukanV']['tgl_awal']);
    //            $modelRS->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaanrujukanV']['tgl_akhir']);
    //            $bln_akhir = $modelRS->bln_akhir."-".date("t",strtotime($modelRS->bln_akhir));
    //            $thn_akhir = $modelRS->thn_akhir."-".date("m-t",strtotime($modelRS->thn_akhir."-12"));
    //            switch($modelRS->jns_periode){
    //                case 'bulan' : $modelRS->tgl_awal = $modelRS->bln_awal."-01"; $modelRS->tgl_akhir = $bln_akhir; break;
    //                case 'tahun' : $modelRS->tgl_awal = $modelRS->thn_awal."-01-01"; $modelRS->tgl_akhir = $thn_akhir; break;
    //                default : null;
    //            }
    //            $modelRS->tgl_awal = $modelRS->tgl_awal." 00:00:00";
    //            $modelRS->tgl_akhir = $modelRS->tgl_akhir." 23:59:59";            
    ////            $modelRS->no_pendaftaran = $_GET['BDLaporanpemeriksaanrujukanV']['no_pendaftaran'];            
    //        }
    //        $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
    //        $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
    //        $model->bln_awal = $format->formatMonthForUser(date('Y-m',(strtotime($model->bln_awal))));
    //        $model->bln_akhir = $format->formatMonthForUser(date('Y-m',(strtotime($model->bln_akhir))));
    $this->render('pemeriksaanRujukan/adminPemeriksaanRujukan', array(
      //            'model' => $model,
      //            'modelRS'=>$modelRS,
    ));
  }

  public function actionLaporanPemeriksaanRujukanLuar()
  {
    $model = new BDLaporanpemeriksaanrujukanV('search');
    $modelRS = new BDLaporanpemeriksaanrujukanrsV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
    $model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
    $model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));
    if (isset($_GET['BDLaporanpemeriksaanrujukanV'])) {
      $model->attributes = $_GET['BDLaporanpemeriksaanrujukanV'];
      $model->jns_periode = $_GET['BDLaporanpemeriksaanrujukanV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaanrujukanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaanrujukanV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BDLaporanpemeriksaanrujukanV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BDLaporanpemeriksaanrujukanV']['bln_akhir']);
      $model->thn_awal = $_GET['BDLaporanpemeriksaanrujukanV']['thn_awal'];
      $model->thn_akhir = $_GET['BDLaporanpemeriksaanrujukanV']['thn_akhir'];
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
      //            $model->tgl_awal = $model->tgl_awal." 00:00:00";
      //            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";    
    }

    $this->layout = "//layouts/iframe";
    $this->render('pemeriksaanRujukan/_tablePemeriksaanRujukanLuar', array(
      'model' => $model,
      'modelRS' => $modelRS,
    ));
  }

  public function actionLaporanPemeriksaanRujukanRS()
  {
    $modelRS = new BDLaporanpemeriksaanrujukanrsV('search');
    $format = new MyFormatter();
    $modelRS->jns_periode = "hari";
    $modelRS->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $modelRS->tgl_akhir = date('Y-m-d');
    $modelRS->bln_awal = date('Y-m', strtotime('first day of january'));
    $modelRS->bln_akhir = date('Y-m');
    $modelRS->thn_awal = date('Y');
    $modelRS->thn_akhir = date('Y');
    if (isset($_GET['BDLaporanpemeriksaanrujukanrsV'])) {
      $modelRS->attributes = $_GET['BDLaporanpemeriksaanrujukanrsV'];
      $modelRS->jns_periode = $_GET['BDLaporanpemeriksaanrujukanrsV']['jns_periode'];
      $modelRS->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaanrujukanrsV']['tgl_awal']);
      $modelRS->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaanrujukanrsV']['tgl_akhir']);
      $modelRS->bln_awal = $format->formatMonthForDb($_GET['BDLaporanpemeriksaanrujukanrsV']['bln_awal']);
      $modelRS->bln_akhir = $format->formatMonthForDb($_GET['BDLaporanpemeriksaanrujukanrsV']['bln_akhir']);
      $modelRS->thn_awal = $_GET['BDLaporanpemeriksaanrujukanrsV']['thn_awal'];
      $modelRS->thn_akhir = $_GET['BDLaporanpemeriksaanrujukanrsV']['thn_akhir'];
      $bln_akhir = $modelRS->bln_akhir . "-" . date("t", strtotime($modelRS->bln_akhir));
      $thn_akhir = $modelRS->thn_akhir . "-" . date("m-t", strtotime($modelRS->thn_akhir . "-12"));
      switch ($modelRS->jns_periode) {
        case 'bulan':
          $modelRS->tgl_awal = $modelRS->bln_awal . "-01";
          $modelRS->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $modelRS->tgl_awal = $modelRS->thn_awal . "-01-01";
          $modelRS->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $modelRS->tgl_awal = $modelRS->tgl_awal . " 00:00:00";
      $modelRS->tgl_akhir = $modelRS->tgl_akhir . " 23:59:59";
    }
    $modelRS->tgl_awal = $format->formatDateTimeForUser($modelRS->tgl_awal);
    $modelRS->tgl_akhir = $format->formatDateTimeForUser($modelRS->tgl_akhir);
    $modelRS->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($modelRS->bln_awal))));
    $modelRS->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($modelRS->bln_akhir))));
    $this->layout = "//layouts/iframe";
    $this->render('pemeriksaanRujukan/_tablePemeriksaanRujukanRS', array(
      'modelRS' => $modelRS
    ));
  }

  public function actionPrintLaporanPemeriksaanRujukanLuar()
  {
    //        $model = BDLaporanpemeriksaanrujukanV::model()->findAll();
    $model = new BDLaporanpemeriksaanrujukanV('search');
    $modelRS = new BDLaporanpemeriksaanrujukanrsV('search');
    $judulLaporan = 'Laporan Pemeriksaan Rujukan Pasien Luar';
    $data['title'] = 'Grafik Laporan Pemeriksaan Rujukan Pasien Luar';
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['type'])) {
      $data['type'] = $_GET['type'];
    } else {
      $data['type'] = null;
    }
    if (isset($_REQUEST['BDLaporanpemeriksaanrujukanV'])) {
      $model->attributes = $_REQUEST['BDLaporanpemeriksaanrujukanV'];
      $model->jns_periode = $_GET['BDLaporanpemeriksaanrujukanV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaanrujukanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaanrujukanV']['tgl_akhir']);
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
      //                $model->tgl_awal = $model->tgl_awal." 00:00:00";
      //                $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
    }
    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
    $model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
    $model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));
    $tab = 'luar';
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pemeriksaanRujukan/_printPemeriksaanRujukan';

    $this->printFunctionRujukan($model, $modelRS, $data, $caraPrint, $judulLaporan, $target, $tab);
  }

  public function actionPrintLaporanPemeriksaanRujukanRS()
  {
    $modelRS = new BDLaporanpemeriksaanrujukanrsV('search');
    $format = new MyFormatter();
    $judulLaporan = 'Laporan Pemeriksaan Rujukan Pasien RS';
    $data['title'] = 'Grafik Laporan Pemeriksaan Rujukan Pasien RS';
    $modelRS->jns_periode = "hari";
    $modelRS->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $modelRS->tgl_akhir = date('Y-m-d');
    $modelRS->bln_awal = date('Y-m', strtotime('first day of january'));
    $modelRS->bln_akhir = date('Y-m');
    $modelRS->thn_awal = date('Y');
    $modelRS->thn_akhir = date('Y');
    if (isset($_GET['type'])) {
      $data['type'] = $_GET['type'];
    } else {
      $data['type'] = null;
    }
    if (isset($_GET['BDLaporanpemeriksaanrujukanrsV'])) {
      $modelRS->attributes = $_GET['BDLaporanpemeriksaanrujukanrsV'];
      $modelRS->jns_periode = $_GET['BDLaporanpemeriksaanrujukanrsV']['jns_periode'];
      $modelRS->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaanrujukanrsV']['tgl_awal']);
      $modelRS->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaanrujukanrsV']['tgl_akhir']);
      $modelRS->bln_awal = $format->formatMonthForDb($_GET['BDLaporanpemeriksaanrujukanrsV']['bln_awal']);
      $modelRS->bln_akhir = $format->formatMonthForDb($_GET['BDLaporanpemeriksaanrujukanrsV']['bln_akhir']);
      $modelRS->thn_awal = $_GET['BDLaporanpemeriksaanrujukanrsV']['thn_awal'];
      $modelRS->thn_akhir = $_GET['BDLaporanpemeriksaanrujukanrsV']['thn_akhir'];
      $bln_akhir = $modelRS->bln_akhir . "-" . date("t", strtotime($modelRS->bln_akhir));
      $thn_akhir = $modelRS->thn_akhir . "-" . date("m-t", strtotime($modelRS->thn_akhir . "-12"));
      switch ($modelRS->jns_periode) {
        case 'bulan':
          $modelRS->tgl_awal = $modelRS->bln_awal . "-01";
          $modelRS->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $modelRS->tgl_awal = $modelRS->thn_awal . "-01-01";
          $modelRS->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $modelRS->tgl_awal = $modelRS->tgl_awal . " 00:00:00";
      $modelRS->tgl_akhir = $modelRS->tgl_akhir . " 23:59:59";
    }
    $modelRS->tgl_awal = $format->formatDateTimeForUser($modelRS->tgl_awal);
    $modelRS->tgl_akhir = $format->formatDateTimeForUser($modelRS->tgl_akhir);
    $modelRS->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($modelRS->bln_awal))));
    $modelRS->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($modelRS->bln_akhir))));
    $tab = 'rs';
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pemeriksaanRujukan/_printPemeriksaanRujukanRS';

    $this->printFunctionRujukanRS($model = null, $modelRS, $data, $caraPrint, $judulLaporan, $target, $tab);
  }


  public function actionPrintLaporanPemeriksaanRujukan()
  {
    //        $model = BDLaporanpemeriksaanrujukanV::model()->findAll();
    $model = new BDLaporanpemeriksaanrujukanV('search');
    $modelRS = new BDLaporanpemeriksaanrujukanrsV('search');
    if ($_GET['filter_tab'] == "luar") {

      $judulLaporan = 'Laporan Pemeriksaan Rujukan Pasien Luar';
      $data['title'] = 'Grafik Laporan Pemeriksaan Rujukan Pasien Luar';
    } else if ($_GET['filter_tab'] == "rs") {

      $judulLaporan = 'Laporan Pemeriksaan Rujukan Pasien RSJK';
      $data['title'] = 'Grafik Laporan Pemeriksaan Rujukan Pasien RSJK';
    }
    if (isset($_GET['type'])) {
      $data['type'] = $_GET['type'];
    } else {
      $data['type'] = null;
    }
    if (isset($_REQUEST['BDLaporanpemeriksaanrujukanV'])) {
      $model->attributes = $_REQUEST['BDLaporanpemeriksaanrujukanV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporanpemeriksaanrujukanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporanpemeriksaanrujukanV']['tgl_akhir']);
      //                $model->no_pendaftaran = $_REQUEST['BDLaporanpemeriksaanrujukanV']['no_pendaftaran'];

      $modelRS->attributes = $_REQUEST['BDLaporanpemeriksaanrujukanV'];
      $format = new MyFormatter();
      $modelRS->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporanpemeriksaanrujukanV']['tgl_awal']);
      $modelRS->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporanpemeriksaanrujukanV']['tgl_akhir']);
      //                $modelRS->no_pendaftaran =$_REQUEST['BDLaporanpemeriksaanrujukanV']['no_pendaftaran'];
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pemeriksaanRujukan/_printPemeriksaanRujukan';

    $this->printFunctionRujukan($model, $modelRS, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikPemeriksaanRujukan()
  {
    $this->layout = '//layouts/iframe';
    $model = new BDLaporanpemeriksaanrujukanV('search');
    $modelRS = new BDLaporanpemeriksaanrujukanrsV('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');
    //Data Grafik
    $data['title'] = 'Grafik Laporan Pemeriksaan Rujukan';
    if (isset($_GET['type'])) {
      $data['type'] = $_GET['type'];
    } else {
      $data['type'] = null;
    }

    if (isset($_GET['BDLaporanpemeriksaanrujukanV'])) {
      $model->attributes = $_GET['BDLaporanpemeriksaanrujukanV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaanrujukanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaanrujukanV']['tgl_akhir']);
    }

    if (isset($_GET['BDLaporanpemeriksaanrujukanrsV'])) {
      $modelRS->attributes = $_GET['BDLaporanpemeriksaanrujukanrsV'];
      $format = new MyFormatter();
      $modelRS->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaanrujukanrsV']['tgl_awal']);
      $modelRS->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaanrujukanrsV']['tgl_akhir']);
    }
    if ($_GET['id'] == "1r=bankDarah/laporan/LaporanPemeriksaanRujukanLuar") {
      $model = $model;
    } else if ($_GET['id'] == "1r=bankDarah/laporan/LaporanPemeriksaanRujukanRS") {
      $model = $modelRS;
    }
    $this->render('_grafik', array(
      //        $this->render('pemeriksaanRujukan/_grafik', array(
      'model' => $model,
      //            'modelRS'=>$modelRS,
      'data' => $data,
    ));
  }


  public function actionLaporanPemeriksaanCaraBayar()
  {
    $model = new BDLaporanpemeriksaangroupV('search');
    $modelPerusahaan = new BDLaporanpemeriksaanp3V('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['BDLaporanpemeriksaangroupV'])) {
      $model->attributes = $_GET['BDLaporanpemeriksaangroupV'];
      $model->jns_periode = $_GET['BDLaporanpemeriksaangroupV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaangroupV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaangroupV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BDLaporanpemeriksaangroupV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BDLaporanpemeriksaangroupV']['bln_akhir']);
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

    $this->render('pemeriksaanCaraBayar/adminPemeriksaanCaraBayar', array(
      'model' => $model,
      'modelPerusahaan' => $modelPerusahaan,
    ));
  }

  public function actionPrintLaporanPemeriksaanCaraBayar()
  {
    $model = new BDLaporanpemeriksaangroupV('search');
    $modelPerusahaan = new BDLaporanpemeriksaanp3V('search');
    $judulLaporan = 'Laporan Pemeriksaan Jenis Penjamin';
    //        echo "<pre>";
    //        print_r($_GET);exit;
    if ($_GET['filter_tab'] == "pemeriksaan") {
      $judulLaporan = 'LAPORAN PEMERIKSAAN CARA BAYAR';
      $data['title'] = 'Grafik Laporan Pemeriksaan Jenis Penjamin';
    } else if ($_GET['filter_tab'] == "rincian") {
      $judulLaporan = 'LAPORAN PEMERIKSAAN KONTRAK P3';
      $data['title'] = 'Grafik Laporan Pemeriksaan Kontrak P3';
    }

    if (isset($_GET['type'])) {
      $data['type'] = $_GET['type'];
    } else {
      $data['type'] = null;
    }
    if (isset($_REQUEST['BDLaporanpemeriksaangroupV'])) {
      $model->attributes = $_REQUEST['BDLaporanpemeriksaangroupV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporanpemeriksaangroupV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporanpemeriksaangroupV']['tgl_akhir']);
      //            $model->carabayar_id = $_REQUEST['BDLaporanpemeriksaangroupV']['carabayar_id'];

      $modelPerusahaan->attributes = $_REQUEST['BDLaporanpemeriksaangroupV'];
      $format = new MyFormatter();
      $modelPerusahaan->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporanpemeriksaangroupV']['tgl_awal']);
      $modelPerusahaan->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporanpemeriksaangroupV']['tgl_akhir']);
      //            $modelPerusahaan->carabayar_id = $_REQUEST['BDLaporanpemeriksaangroupV']['carabayar_id'];
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pemeriksaanCaraBayar/_printPemeriksaanCaraBayar';
    $this->printFunctionCaraBayar($model, $modelPerusahaan, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikPemeriksaanCaraBayar()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = new BDLaporanpemeriksaangroupV('search');
    $modelPerusahaan = new BDLaporanpemeriksaanp3V('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');
    //Data Grafik
    if ($_GET['filter_tab'] == "pemeriksaan") {

      $data['title'] = 'Grafik Laporan Pemeriksaan Group BK';
      if (isset($_GET['BDLaporanpemeriksaangroupV'])) {
        $model->attributes = $_GET['BDLaporanpemeriksaangroupV'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaangroupV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaangroupV']['tgl_akhir']);
      }
    } else if ($_GET['filter_tab'] == "rincian") {

      $data['title'] = 'Grafik Laporan Pemeriksaan Kontrak P3';
      if (isset($_GET['BDLaporanpemeriksaangroupV'])) {
        $modelPerusahaan->attributes = $_GET['BDLaporanpemeriksaangroupV'];
        $modelPerusahaan->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaangroupV']['tgl_awal']);
        $modelPerusahaan->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpemeriksaangroupV']['tgl_akhir']);
      }
    }
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;

    $this->render('pemeriksaanCaraBayar/_grafik', array(
      'model' => $model,
      'modelPerusahaan' => $modelPerusahaan,
      'data' => $data,
    ));
  }

  public function actionLaporanPembayaranPemeriksaan()
  {
    $model = new BDLaporanpembayaranpenunjangV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['BDLaporanpembayaranpenunjangV'])) {
      $model->attributes = $_GET['BDLaporanpembayaranpenunjangV'];
      $model->jns_periode = $_GET['BDLaporanpembayaranpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpembayaranpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpembayaranpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BDLaporanpembayaranpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BDLaporanpembayaranpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['BDLaporanpembayaranpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['BDLaporanpembayaranpenunjangV']['thn_akhir'];
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
      if (isset($_GET['BDLaporanpembayaranpenunjangV']['no_pendaftaran'])) {
        $model->no_pendaftaran = $_GET['BDLaporanpembayaranpenunjangV']['no_pendaftaran'];
      }
    }
    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
    $model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
    $model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));
    $this->render('pembayaranPemeriksaan/adminPembayaranPemeriksaan', array(
      'model' => $model,
    ));
  }

  public function actionPrintLaporanPembayaranPemeriksaan()
  {
    $model = new BDLaporanpembayaranpenunjangV('search');
    $format = new MyFormatter();
    $judulLaporan = 'Laporan Pembayaran Pemeriksaan';
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    //Data Grafik
    $data['title'] = 'Grafik Laporan Pembayaran Pemeriksaan';
    if (isset($_REQUEST['type'])) {
      $data['type'] = $_REQUEST['type'];
    } else {
      $data['type'] = null;
    }
    if (isset($_REQUEST['BDLaporanpembayaranpenunjangV'])) {
      $model->attributes = $_REQUEST['BDLaporanpembayaranpenunjangV'];
      $model->jns_periode = $_GET['BDLaporanpembayaranpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpembayaranpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpembayaranpenunjangV']['tgl_akhir']);
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
      if (isset($_GET['BDLaporanpembayaranpenunjangV']['no_pendaftaran'])) {
        $model->no_pendaftaran = $_GET['BDLaporanpembayaranpenunjangV']['no_pendaftaran'];
      }
    }

    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
    $model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
    $model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pembayaranPemeriksaan/_printPembayaranPemeriksaan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * update nilai grafik garis dan speedo dari request ajax
   */
  public function actionUpdateGrafik()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $model = new BDLaporanpembayaranpenunjangV();
      $format = new MyFormatter();
      if (isset($_POST['BDLaporanpembayaranpenunjangV'])) {
        $model->attributes = $_POST['BDLaporanpembayaranpenunjangV'];
        $model->tgl_awal = $format->formatDateTimeForDb($_POST['BDLaporanpembayaranpenunjangV']['tgl_awal']) . " 00:00:00";
        $model->tgl_akhir = $format->formatDateTimeForDb($_POST['BDLaporanpembayaranpenunjangV']['tgl_akhir']) . " 23:59:59";
      }
      $index_garis = array();
      $result_garis = array();
      $periodeGrafik = $format->formatDateTimeId(date('Y-m-d', (strtotime($model->tgl_awal)))) . " s.d " . $format->formatDateTimeId(date('Y-m-d', (strtotime($model->tgl_akhir))));
      $return['title'] = "Grafik Laporan Jenis Pemeriksaan Radiologi <br> Periode: " . $periodeGrafik;

      $dataProviderGaris = $model->searchGrafik();
      $dataProviderSpeedo = $model->searchGrafik();
      $hasilGaris = $dataProviderGaris->getData();
      foreach ($hasilGaris as $i => $v) {
        if (strlen($v['data']) > 2) {
          $index_garis[] = $format->formatDateTimeForUser($v['data']);
        } else {
          $index_garis[] = $format->getMonthUser((int)$v['data']) . " " . $v['data_2'];
        }
        $result_garis[] = array($i + 1, (int)$v['jumlah']);
      }
      $return['garis']['result'] = $result_garis;
      $return['garis']['index'] = $index_garis;
      $return['speedo']['result'] = (int)$dataProviderSpeedo->getTotalItemCount();

      echo json_encode($return);
      Yii::app()->end();
    }
  }

  public function actionFrameGrafikPembayaranPemeriksaan()
  {
    $this->layout = '//layouts/iframe';
    $model = new BDLaporanpembayaranpenunjangV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    //Data Grafik
    $data['title'] = 'Grafik Laporan Pembayaran Pemeriksaan';
    if (isset($_GET['type'])) {
      $data['type'] = $_GET['type'];
    } else {
      $data['type'] = null;
    }

    if (isset($_GET['BDLaporanpembayaranpenunjangV'])) {
      $model->attributes = $_GET['BDLaporanpembayaranpenunjangV'];
      $model->jns_periode = $_GET['BDLaporanpembayaranpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpembayaranpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpembayaranpenunjangV']['tgl_akhir']);
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
      if (isset($_GET['BDLaporanpembayaranpenunjangV']['no_pendaftaran'])) {
        $model->no_pendaftaran = $_GET['BDLaporanpembayaranpenunjangV']['no_pendaftaran'];
      }
    }
    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
    $model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
    $model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));
    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

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

  /*
     * Laporan Pasien DBD
     */

  public function actionLaporanPasienDBD()
  {
    $model = new BDLaporanpasienpenunjangV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['BDLaporanpasienpenunjangV'])) {
      $model->attributes = $_GET['BDLaporanpasienpenunjangV'];
      $model->jns_periode = $_REQUEST['BDLaporanpasienpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporanpasienpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporanpasienpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['BDLaporanpasienpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['BDLaporanpasienpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['BDLaporanpasienpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['BDLaporanpasienpenunjangV']['thn_akhir'];
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
    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
    $model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
    $model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));
    $this->render('pasienDBD/index', array(
      'model' => $model,
    ));
  }

  public function actionPrintLaporanPasienDBD()
  {
    $model = new BDLaporanpasienpenunjangV('search');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Pasien DBD';
    $format = new MyFormatter();
    //Data Grafik
    $data['title'] = 'Grafik Laporan Pasien DBD';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['BDLaporanpasienpenunjangV'])) {
      $model->attributes = $_GET['BDLaporanpasienpenunjangV'];
      $model->jns_periode = $_GET['BDLaporanpasienpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpasienpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpasienpenunjangV']['tgl_akhir']);
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
    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
    $model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
    $model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pasienDBD/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikPasienDBD()
  {
    $this->layout = '//layouts/iframe';
    $model = new BDLaporanpasienpenunjangV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    //Data Grafik
    $data['title'] = 'Grafik Laporan Pasien DBD';
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;

    if (isset($_GET['BDLaporanpasienpenunjangV'])) {
      $model->attributes = $_GET['BDLaporanpasienpenunjangV'];
      $model->jns_periode = $_REQUEST['BDLaporanpasienpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporanpasienpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporanpasienpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['BDLaporanpasienpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['BDLaporanpasienpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['BDLaporanpasienpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['BDLaporanpasienpenunjangV']['thn_akhir'];
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

  /*
     * end Laporan Pasien DBD
     */

  public function actionLaporanPendapatan()
  {
    $model = new BDLaporanpendapatanruanganV('search');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
    $model->kelaspelayanan_id = $kelas;
    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
    if (isset($_GET['BDLaporanpendapatanruanganV'])) {
      $model->attributes = $_GET['BDLaporanpendapatanruanganV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpendapatanruanganV']['tgl_akhir']);
    }

    $this->render('pendapatan/index', array(
      'model' => $model
    ));
  }

  public function actionLaporanPendapatanRS()
  {
    $model = new BDLaporanpendapatanruanganV('search');
    $format = new MyFormatter();
    $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
    $model->kelaspelayanan_id = $kelas;

    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['BDLaporanpendapatanruanganV'])) {
      $model->attributes = $_GET['BDLaporanpendapatanruanganV'];
      $model->jns_periode = $_GET['BDLaporanpendapatanruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpendapatanruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BDLaporanpendapatanruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BDLaporanpendapatanruanganV']['bln_akhir']);
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
    $this->layout = "//layouts/iframe";
    $this->render('pendapatan/_tableRS', array(
      'model' => $model
    ));
  }

  public function actionLaporanPendapatanRSLuar()
  {
    $model = new BDLaporanpendapatanruanganV('search');
    $format = new MyFormatter();
    $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
    $model->kelaspelayanan_id = $kelas;
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['BDLaporanpendapatanruanganV'])) {
      $model->attributes = $_GET['BDLaporanpendapatanruanganV'];
      $model->jns_periode = $_GET['BDLaporanpendapatanruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpendapatanruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BDLaporanpendapatanruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BDLaporanpendapatanruanganV']['bln_akhir']);
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
    $this->layout = "//layouts/iframe";
    $this->render('pendapatan/_tableRSLuar', array(
      'model' => $model
    ));
  }

  public function actionPrintLaporanPendapatanRS()
  {
    $model = new BDLaporanpendapatanruanganV('search');
    $judulLaporan = 'Laporan Pendapatan Ruangan Laboratorium dari RS';

    //Data Grafik        
    $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
    if (isset($_REQUEST['type'])) {
      $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    }
    if (isset($_REQUEST['BDLaporanpendapatanruanganV'])) {
      $model->attributes = $_REQUEST['BDLaporanpendapatanruanganV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporanpendapatanruanganV']['tgl_akhir']);
    }
    $tab = 'rs';
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pendapatan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab);
  }

  public function actionPrintLaporanPendapatanRSLuar()
  {
    $model = new BDLaporanpendapatanruanganV('search');
    $judulLaporan = 'Laporan Pendapatan Ruangan Laboratorium dari Luar RS';

    //Data Grafik        
    $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
    if (isset($_REQUEST['type'])) {
      $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    }
    if (isset($_REQUEST['BDLaporanpendapatanruanganV'])) {
      $model->attributes = $_REQUEST['BDLaporanpendapatanruanganV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporanpendapatanruanganV']['tgl_akhir']);
    }
    $tab = 'luar';
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pendapatan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab);
  }

  public function actionPrintLaporanPendapatan()
  {
    $model = new BDLaporanpendapatanruanganV('search');
    if ($_GET['filter_tab'] == "rs") {
      $judulLaporan = 'Laporan Pendapatan Ruangan Laboratorium dari RS';
    } else if ($_GET['filter_tab'] == "luar") {
      $judulLaporan = 'Laporan Pendapatan Ruangan Laboratorium dari Luar RS';
    } else {
      $judulLaporan = 'Laporan Pendapatan Ruangan Laboratorium';
    }

    //Data Grafik        
    $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
    if (isset($_REQUEST['BDLaporanpendapatanruanganV'])) {
      $model->attributes = $_REQUEST['BDLaporanpendapatanruanganV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporanpendapatanruanganV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pendapatan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanPendapatan()
  {
    $this->layout = '//layouts/iframe';
    $model = new BDLaporanpendapatanruanganV('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
    if (isset($_GET['BDLaporanpendapatanruanganV'])) {
      $model->attributes = $_GET['BDLaporanpendapatanruanganV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpendapatanruanganV']['tgl_akhir']);
    }

    $this->render('pendapatan/_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * Fungsi print 
   * @author Andyka Putra <andykaputra@.com>
   * 
   * @param type $model
   * @param type $data
   * @param type $caraPrint
   * @param type $judulLaporan
   * @param type $target
   * @param type $tab
   * @param type $variabel
   */
  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab = 'rs', $variabel = array())
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows3';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $kertas = Params::getUkuranKertas();
      $mpdf = new MyPDF60('', $kertas['F4']);
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait

      $mpdf->SetHTMLFooter($this->renderPartial('application.views.headerReport.footerLaporanBukuRegister', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 10), true));

      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI, '', '', '', '', 20, 50, 20, 20, 20, 20);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  protected function printFunctionRujukan($model, $modelRS, $data, $caraPrint, $judulLaporan, $target, $tab = null)
  {
    $format = new MyFormatter();
    $periode = $this->parserTanggalRujukan($model->tgl_awal) . ' s/d ' . $this->parserTanggalRujukan($model->tgl_akhir);

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'modelRS' => $modelRS, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'modelRS' => $modelRS, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'modelRS' => $modelRS, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab), true));
      $mpdf->Output();
    }
  }

  protected function printFunctionRujukanRS($model, $modelRS, $data, $caraPrint, $judulLaporan, $target, $tab = null)
  {
    $format = new MyFormatter();
    $periode = $periode = $format->formatDateTimeId($modelRS->tgl_awal) . ' s/d ' . $format->formatDateTimeId($modelRS->tgl_akhir);
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $modelRS, 'modelRS' => $modelRS, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $modelRS, 'modelRS' => $modelRS, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'modelRS' => $modelRS, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab), true));
      $mpdf->Output();
    }
  }

  protected function printFunctionCaraBayar($model, $modelPerusahaan, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $periode = $format->formatDateTimeId($model->tgl_awal) . ' s/d ' . $format->formatDateTimeId($model->tgl_akhir);

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'modelPerusahaan' => $modelPerusahaan, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'modelPerusahaan' => $modelPerusahaan, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'modelPerusahaan' => $modelPerusahaan, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  protected function parserTanggalRujukan($tgl)
  {
    $tgl = explode(' ', $tgl);
    $result = array();
    foreach ($tgl as $row) {
      if (!empty($row)) {
        $result[] = $row;
      }
    }
    return $result[0] . ' ' . $result[1] . ' ' . $result[2];
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
          $penjamindata = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
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
              $selects[] = $value;
              $i++;
            }
            echo CHtml::checkBoxList('' . $namaModel . "[penjamin_id]", $selects, $penjamin);
          } else {
            echo '<label>Data Tidak Ditemukan</label>';
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * Autocomplete Jenis Pemeriksaan Lab
   * @throws CHttpException
   */
  public function actionAutocompleteJenisPemeriksaanLab()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $jenispemeriksaanlab_nama = isset($_GET['term']) ? $_GET['term'] : '';
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(jenispemeriksaanlab_nama)', strtolower($jenispemeriksaanlab_nama), true);
      $criteria->limit = 5;
      $models = BDJenisPemeriksaanLabM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->jenispemeriksaanlab_nama;
        $returnVal[$i]['value'] = $model->jenispemeriksaanlab_id;
      }


      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * Autocomplete Pemeriksaan Lab
   * @throws CHttpException
   */
  public function actionAutocompletePemeriksaanLab()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $pemeriksaanlab_nama = isset($_GET['term']) ? $_GET['term'] : '';
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(pemeriksaanlab_nama)', strtolower($pemeriksaanlab_nama), true);
      $criteria->limit = 5;
      $models = BDPemeriksaanlabM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->pemeriksaanlab_nama;
        $returnVal[$i]['value'] = $model->pemeriksaanlab_id;
      }


      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
         * Digunakan untuk laporan seleksi donor
         * @author Andyka Putra <andykaputra@.com>
         */
        public function actionLaporanSeleksiDonor() {
            
          $criteria = new CDbCriteria();
          $model = new BDLapseleksidonordarahV('search');
          $format = new MyFormatter();
          $model->jns_periode = "hari";
          $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
          $model->tgl_akhir = date('Y-m-d');
          $model->bln_awal = date('Y-m', strtotime('first day of january'));
          $model->bln_akhir = date('Y-m');
          $model->thn_awal = date('Y');
          $model->thn_akhir = date('Y');
          if (isset($_GET['BDLapseleksidonordarahV'])) {
              $model->attributes = $_GET['BDLapseleksidonordarahV'];
              $model->jns_periode = $_GET['BDLapseleksidonordarahV']['jns_periode'];
              $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLapseleksidonordarahV']['tgl_awal']);
              $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLapseleksidonordarahV']['tgl_akhir']);
              $model->bln_awal = $format->formatMonthForDb($_GET['BDLapseleksidonordarahV']['bln_awal']);
              $model->bln_akhir = $format->formatMonthForDb($_GET['BDLapseleksidonordarahV']['bln_akhir']);
              $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
              $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
              $model->status = $_GET['BDLapseleksidonordarahV']['status'];
              
              switch($model->jns_periode){
                  case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                  case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                  default : null;
              }
              
          }
          
          $criteria->addBetweenCondition('DATE(waktu_pendaftaran)', $model->tgl_awal, $model->tgl_akhir);
          $modShow2  = BDLapseleksidonordarahV::model()->findAll($criteria);
          
          //Grouping
          $criteria->group  = 'DATE(waktu_pendaftaran), ruangan_rekruitmen_id';
          $criteria->select = 'DATE(waktu_pendaftaran) as waktu_pendaftaran, ruangan_rekruitmen_id';
          $criteria->order  = 'DATE(waktu_pendaftaran) ASC';
          $criteria->limit  = 10;
          $criteria->offset = !empty($_GET['page']) ? ((9 * ($_GET['page'] - 1) ) + ($_GET['page'] - 1)) : 0;
          
          //Cari Data
          $modShow  = BDLapseleksidonordarahV::model()->findAll($criteria);
          $count    = BDLapseleksidonordarahV::model()->count($criteria);
          $pages    = new CPagination($count);
          
          // results per page
          $pages->pageSize=10;
          $pages->applyLimit($criteria);
          
          $b = array();
          foreach ($modShow2 as $hasil){
              
              $tglpendaftaran = date('Y-m-d', strtotime($hasil->waktu_pendaftaran));
              $ruangan_rekruitmen_id = $hasil->ruangan_rekruitmen_id;
              $tglsekarang = 'sekarang';
              
              //Umur
              $tanggal_lahir  = new DateTime($hasil->tgllahir);
              $tanggal_daftar = new DateTime($tglpendaftaran);
              $y = $tanggal_daftar->diff($tanggal_lahir)->y;
                      
              //Jumlah keseluruhan
              if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['jumlah'])){
                  $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['jumlah']+1;    
              }else{
                  $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['jumlah'] = 1;
              }

              //Kurang < 18
              if ($y < 18){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['umur<18'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['umur<18']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['umur<18'] = 1;
                  }
              }

              //18 - 24
              if ($y >= 18 && $y <=24){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['18sampai24'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['18sampai24']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['18sampai24'] = 1;
                  }
              }

              //25 - 44
              if ($y >= 25 && $y <=44){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['25sampai44'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['25sampai44']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['25sampai44'] = 1;
                  }
              }

              //45 - 59
              if ($y >= 45 && $y <=59){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['45sampai59'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['45sampai59']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['45sampai59'] = 1;
                  }
              }

              //Lebih dari 61
              if ($y >61){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['lebih61'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['lebih61']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['lebih61'] = 1;
                  }
              }
              
              //Berdasarkan Jenis Kelamin
              $laki = Params::JENIS_KELAMIN_LAKI_LAKI;
              $perempuan = Params::JENIS_KELAMIN_PEREMPUAN;
              $batallaki = 'batallaki';
              $batalperempuan = 'batalperempuan';
              $isbatal = 'batal';
              $lolos = 'lolos';
              
              if($hasil->jenis_kelamin == Params::JENIS_KELAMIN_LAKI_LAKI){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->jenis_kelamin == Params::JENIS_KELAMIN_PEREMPUAN){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['jumlah'] =1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['lebih61'] = 1;
                      }
                  }
              }
              
              //Berdasarkan yang gagal seleksi dan yang lolos seleksi
              if($hasil->status_pendonor == 'DITOLAK'){
                  
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['jumlah'] =1;
                  }

                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['umur<18'] = 1;
                      }
                  }

                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['18sampai24'] = 1;
                      }
                  }

                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['25sampai44'] = 1;
                      }
                  }

                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['45sampai59'] = 1;
                      }
                  }

                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['lebih61'] = 1;
                      }
                  }
                 
              } 
              elseif($hasil->status_pendonor == 'DITERIMA'){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['jumlah'] =1;
                  }

                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['umur<18'] = 1;
                      }
                  }

                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['18sampai24'] = 1;
                      }
                  }

                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['25sampai44'] = 1;
                      }
                  }

                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['45sampai59'] = 1;
                      }
                  }

                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['lebih61'] = 1;
                      }
                  }
                  
              }                
              
              //Berdasarkan Jenis kelamin yang gagal seleksi aja
              if($hasil->status_pendonor == 'DITOLAK'){
                  if($hasil->jenis_kelamin == Params::JENIS_KELAMIN_PEREMPUAN){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['jumlah'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['jumlah']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['jumlah'] =1;
                      }

                      //Kurang < 18
                      if ($y < 18){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['umur<18'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['umur<18']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['umur<18'] = 1;
                          }
                      }

                      //18 - 24
                      if ($y >= 18 && $y <=24){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['18sampai24'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['18sampai24']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['18sampai24'] = 1;
                          }
                      }

                      //25 - 44
                      if ($y >= 25 && $y <=44){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['25sampai44'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['25sampai44']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['25sampai44'] = 1;
                          }
                      }

                      //45 - 59
                      if ($y >= 45 && $y <=59){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['45sampai59'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['45sampai59']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['45sampai59'] = 1;
                          }
                      }

                      //Lebih dari 61
                      if ($y >61){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['lebih61'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['lebih61']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['lebih61'] = 1;
                          }
                      }
                  }
                  if($hasil->jenis_kelamin == Params::JENIS_KELAMIN_LAKI_LAKI){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['jumlah'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['jumlah']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['jumlah'] =1;
                      }

                      //Kurang < 18
                      if ($y < 18){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['umur<18'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['umur<18']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['umur<18'] = 1;
                          }
                      }

                      //18 - 24
                      if ($y >= 18 && $y <=24){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['18sampai24'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['18sampai24']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['18sampai24'] = 1;
                          }
                      }

                      //25 - 44
                      if ($y >= 25 && $y <=44){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['25sampai44'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['25sampai44']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['25sampai44'] = 1;
                          }
                      }

                      //45 - 59
                      if ($y >= 45 && $y <=59){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['45sampai59'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['45sampai59']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['45sampai59'] = 1;
                          }
                      }

                      //Lebih dari 61
                      if ($y >61){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['lebih61'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['lebih61']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['lebih61'] = 1;
                          }
                      }
                  }
              } 
                 
              //Berdasarkan Donor Ke
              $satu = 1;
              $lebihdarisatu = !1;
              if($hasil->donor_itd_ke == 1){
                  
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['jumlah']+1;        
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['lebih61'] = 1;
                      }
                  }
              }
              if($hasil->donor_itd_ke > 1){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['jumlah'] =1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['lebih61'] = 1;
                      }
                  }
              }
              
              //Berdasarkan Jenis Donor
              $skrl = 'Sukarela';
              $al   = 'Autologus';
              $pggt = 'Pengganti';
              if($hasil->jenisdonor == 'Sukarela'){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['lebih61'] = 1;
                      }
                  }
              }
              if($hasil->jenisdonor == 'Autologus'){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['lebih61'] = 1;
                      }
                  }
              }
              if($hasil->jenisdonor == 'Pengganti'){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['lebih61'] = 1;
                      }
                  }
              }
              
              //Berdasarkan Penyebab Batal
              $HBrendah  = 'hbrendah';
              $BBrendah  = 'bbrendah'; 
              $medishb17 = 'medishb17'; 
              $tdrendah  = 'tdrendah'; 
              $tktinggi  = 'tkrendah'; 
              $bblebih   = 'bblebih';
              $medisvaksin = 'medisvaksin'; 
              $perilakuberesiko = 'perilakuberesiko'; 
              $riwayat = 'riwayat'; 
              $lain2 = 'lain2';
              
              if($hasil->hb_rendah == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->bb_rendah == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->medis_hb_17 == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->medis_td_rendah == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->medis_tk_tinggi == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->medis_bb_lebih == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->medis_vaksin == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->perilakuberesiko == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->riwberpergian == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->lain_lain == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['lebih61'] = 1;
                      }
                  }

              }
          }
          $this->render('seleksidonor/admin', array(
              'model' => $model,
              'modShow'=>$modShow,
              'b'=>$b,
              'pages'=>$pages,
          ));
      }
      
      /**
       * Frame grafik laporan seleksi
       * @author Andyka Putra <andykaputra@.com>
       */
      public function actionFrameGrafikSeleksiDonor() {
          $this->layout = '//layouts/iframe';

          $model = new BDLapseleksidonordarahV('searchGrafik');
          $format = new MyFormatter();
          $model->jns_periode = "hari";
          $model->tgl_awal = date('Y-m-d');
          $model->tgl_akhir = date('Y-m-d');
          $model->bln_awal = date('Y-m');
          $model->bln_akhir = date('Y-m');
          $model->thn_awal = date('Y');
          $model->thn_akhir = date('Y');
          
          //Data Grafik
          $data['title'] = 'Grafik Laporan Seleksi Donor';
          $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
          
          if (isset($_GET['BDLapseleksidonordarahV'])) {
              $model->attributes = $_GET['BDLapseleksidonordarahV'];
              $model->jns_periode = $_GET['BDLapseleksidonordarahV']['jns_periode'];
              $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLapseleksidonordarahV']['tgl_awal']);
              $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLapseleksidonordarahV']['tgl_akhir']);
              $model->bln_awal = $format->formatMonthForDb($_GET['BDLapseleksidonordarahV']['bln_awal']);
              $model->bln_akhir = $format->formatMonthForDb($_GET['BDLapseleksidonordarahV']['bln_akhir']);
              $model->thn_awal = $_GET['BDLapseleksidonordarahV']['thn_awal'];
              $model->thn_akhir = $_GET['BDLapseleksidonordarahV']['thn_akhir'];
              $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
              $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
              
              switch($model->jns_periode){
                  case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                  case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                  default : null;
              }
              $model->tgl_awal = $model->tgl_awal;
              $model->tgl_akhir = $model->tgl_akhir;
              $model->status = $_GET['BDLapseleksidonordarahV']['status'];
          }
          
          $this->render('_grafik', array(
              'model' => $model,
              'data' => $data,
          ));
      }
      
      /**
       * Print laporan seleksi 
       * @author Andyka Putra <andykaputra@.com>
       */
      public function actionPrintSeleksiDonor() {
          $criteria = new CDbCriteria();
          $model = new BDLapseleksidonordarahV('searchPrint');
          $format = new MyFormatter();
          $model->jns_periode = "hari";
          $model->tgl_awal = date('Y-m-d');
          $model->tgl_akhir = date('Y-m-d');
          $model->bln_awal = date('Y-m');
          $model->bln_akhir = date('Y-m');
          $model->thn_awal = date('Y');
          $model->thn_akhir = date('Y');
          $judulLaporan = 'Laporan Seleksi Donor';

          //Data Grafik
          $data['title'] = 'Grafik Laporan Seleksi Donor';
          $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
          if (isset($_REQUEST['BDLapseleksidonordarahV'])) {
              $model->attributes = $_REQUEST['BDLapseleksidonordarahV'];
              $model->jns_periode = $_GET['BDLapseleksidonordarahV']['jns_periode'];
              $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLapseleksidonordarahV']['tgl_awal']);
              $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLapseleksidonordarahV']['tgl_akhir']);
              $model->bln_awal = $format->formatMonthForDb($_GET['BDLapseleksidonordarahV']['bln_awal']);
              $model->bln_akhir = $format->formatMonthForDb($_GET['BDLapseleksidonordarahV']['bln_akhir']);
              $model->thn_awal = $_GET['BDLapseleksidonordarahV']['thn_awal'];
              $model->thn_akhir = $_GET['BDLapseleksidonordarahV']['thn_akhir'];
              $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
              $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
              switch($model->jns_periode){
                  case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                  case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                  default : null;
              }
              $model->tgl_awal = $model->tgl_awal;
              $model->tgl_akhir = $model->tgl_akhir;
              $model->status = $_GET['BDLapseleksidonordarahV']['status'];
          }
      
          $criteria->addBetweenCondition('DATE(waktu_pendaftaran)', $model->tgl_awal, $model->tgl_akhir);
          $modShow2  = BDLapseleksidonordarahV::model()->findAll($criteria);
          
          //Grouping
          $criteria->group  = 'DATE(waktu_pendaftaran), ruangan_rekruitmen_id';
          $criteria->select = 'DATE(waktu_pendaftaran) as waktu_pendaftaran, ruangan_rekruitmen_id';
          $criteria->order  = 'DATE(waktu_pendaftaran) ASC';

          //Cari Data
          $modShow  = BDLapseleksidonordarahV::model()->findAll($criteria);
          $b = array();
          foreach ($modShow2 as $hasil){
              
              $tglpendaftaran = date('Y-m-d', strtotime($hasil->waktu_pendaftaran));
              $ruangan_rekruitmen_id = $hasil->ruangan_rekruitmen_id;
              $tglsekarang = 'sekarang';
              
              //Umur
              $tanggal_lahir  = new DateTime($hasil->tgllahir);
              $tanggal_daftar = new DateTime($tglpendaftaran);
              $y = $tanggal_daftar->diff($tanggal_lahir)->y;
                      
              //Jumlah keseluruhan
              if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['jumlah'])){
                  $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['jumlah']+1;    
              }else{
                  $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['jumlah'] = 1;
              }

              //Kurang < 18
              if ($y < 18){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['umur<18'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['umur<18']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['umur<18'] = 1;
                  }
              }

              //18 - 24
              if ($y >= 18 && $y <=24){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['18sampai24'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['18sampai24']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['18sampai24'] = 1;
                  }
              }

              //25 - 44
              if ($y >= 25 && $y <=44){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['25sampai44'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['25sampai44']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['25sampai44'] = 1;
                  }
              }

              //45 - 59
              if ($y >= 45 && $y <=59){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['45sampai59'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['45sampai59']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['45sampai59'] = 1;
                  }
              }

              //Lebih dari 61
              if ($y >61){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['lebih61'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['lebih61']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tglsekarang"]['lebih61'] = 1;
                  }
              }
              
              //Berdasarkan Jenis Kelamin
              $laki = Params::JENIS_KELAMIN_LAKI_LAKI;
              $perempuan = Params::JENIS_KELAMIN_PEREMPUAN;
              $batallaki = 'batallaki';
              $batalperempuan = 'batalperempuan';
              $isbatal = 'batal';
              $lolos = 'lolos';
              
              if($hasil->jenis_kelamin == Params::JENIS_KELAMIN_LAKI_LAKI){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$laki"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->jenis_kelamin == Params::JENIS_KELAMIN_PEREMPUAN){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['jumlah'] =1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perempuan"]['lebih61'] = 1;
                      }
                  }
              }
              
              //Berdasarkan yang gagal seleksi dan yang lolos seleksi
              if($hasil->status_pendonor == 'DITOLAK'){
                  
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['jumlah'] =1;
                  }

                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['umur<18'] = 1;
                      }
                  }

                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['18sampai24'] = 1;
                      }
                  }

                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['25sampai44'] = 1;
                      }
                  }

                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['45sampai59'] = 1;
                      }
                  }

                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$isbatal"]['lebih61'] = 1;
                      }
                  }
                 
              } 
              elseif($hasil->status_pendonor == 'DITERIMA'){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['jumlah'] =1;
                  }

                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['umur<18'] = 1;
                      }
                  }

                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['18sampai24'] = 1;
                      }
                  }

                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['25sampai44'] = 1;
                      }
                  }

                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['45sampai59'] = 1;
                      }
                  }

                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lolos"]['lebih61'] = 1;
                      }
                  }
                  
              }                
              
              //Berdasarkan Jenis kelamin yang gagal seleksi aja
              if($hasil->status_pendonor == 'DITOLAK'){
                  if($hasil->jenis_kelamin == Params::JENIS_KELAMIN_PEREMPUAN){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['jumlah'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['jumlah']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['jumlah'] =1;
                      }

                      //Kurang < 18
                      if ($y < 18){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['umur<18'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['umur<18']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['umur<18'] = 1;
                          }
                      }

                      //18 - 24
                      if ($y >= 18 && $y <=24){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['18sampai24'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['18sampai24']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['18sampai24'] = 1;
                          }
                      }

                      //25 - 44
                      if ($y >= 25 && $y <=44){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['25sampai44'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['25sampai44']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['25sampai44'] = 1;
                          }
                      }

                      //45 - 59
                      if ($y >= 45 && $y <=59){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['45sampai59'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['45sampai59']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['45sampai59'] = 1;
                          }
                      }

                      //Lebih dari 61
                      if ($y >61){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['lebih61'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['lebih61']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batalperempuan"]['lebih61'] = 1;
                          }
                      }
                  }
                  if($hasil->jenis_kelamin == Params::JENIS_KELAMIN_LAKI_LAKI){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['jumlah'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['jumlah']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['jumlah'] =1;
                      }

                      //Kurang < 18
                      if ($y < 18){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['umur<18'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['umur<18']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['umur<18'] = 1;
                          }
                      }

                      //18 - 24
                      if ($y >= 18 && $y <=24){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['18sampai24'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['18sampai24']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['18sampai24'] = 1;
                          }
                      }

                      //25 - 44
                      if ($y >= 25 && $y <=44){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['25sampai44'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['25sampai44']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['25sampai44'] = 1;
                          }
                      }

                      //45 - 59
                      if ($y >= 45 && $y <=59){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['45sampai59'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['45sampai59']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['45sampai59'] = 1;
                          }
                      }

                      //Lebih dari 61
                      if ($y >61){
                          if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['lebih61'])){
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['lebih61']+1;    
                          }else{
                              $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$batallaki"]['lebih61'] = 1;
                          }
                      }
                  }
              } 
                 
              //Berdasarkan Donor Ke
              $satu = 1;
              $lebihdarisatu = !1;
              if($hasil->donor_itd_ke == 1){
                  
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['jumlah']+1;        
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$satu"]['lebih61'] = 1;
                      }
                  }
              }
              if($hasil->donor_itd_ke > 1){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['jumlah'] =1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lebihdarisatu"]['lebih61'] = 1;
                      }
                  }
              }
              
              //Berdasarkan Jenis Donor
              $skrl = 'Sukarela';
              $al   = 'Autologus';
              $pggt = 'Pengganti';
              if($hasil->jenisdonor == 'Sukarela'){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$skrl"]['lebih61'] = 1;
                      }
                  }
              }
              if($hasil->jenisdonor == 'Autologus'){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$al"]['lebih61'] = 1;
                      }
                  }
              }
              if($hasil->jenisdonor == 'Pengganti'){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$pggt"]['lebih61'] = 1;
                      }
                  }
              }
              
              //Berdasarkan Penyebab Batal
              $HBrendah  = 'hbrendah';
              $BBrendah  = 'bbrendah'; 
              $medishb17 = 'medishb17'; 
              $tdrendah  = 'tdrendah'; 
              $tktinggi  = 'tkrendah'; 
              $bblebih   = 'bblebih';
              $medisvaksin = 'medisvaksin'; 
              $perilakuberesiko = 'perilakuberesiko'; 
              $riwayat = 'riwayat'; 
              $lain2 = 'lain2';
              
              if($hasil->hb_rendah == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$HBrendah"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->bb_rendah == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$BBrendah"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->medis_hb_17 == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medishb17"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->medis_td_rendah == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tdrendah"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->medis_tk_tinggi == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$tktinggi"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->medis_bb_lebih == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$bblebih"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->medis_vaksin == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$medisvaksin"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->perilakuberesiko == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$perilakuberesiko"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->riwberpergian == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$riwayat"]['lebih61'] = 1;
                      }
                  }

              }
              if($hasil->lain_lain == true){
                  if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['jumlah'])){
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['jumlah'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['jumlah']+1;    
                  }else{
                      $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['jumlah'] = 1;
                  }
                  
                  //Kurang < 18
                  if ($y < 18){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['umur<18'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['umur<18'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['umur<18']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['umur<18'] = 1;
                      }
                  }
                  
                  //18 - 24
                  if ($y >= 18 && $y <=24){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['18sampai24'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['18sampai24'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['18sampai24']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['18sampai24'] = 1;
                      }
                  }
                  
                  //25 - 44
                  if ($y >= 25 && $y <=44){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['25sampai44'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['25sampai44'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['25sampai44']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['25sampai44'] = 1;
                      }
                  }
                  
                  //45 - 59
                  if ($y >= 45 && $y <=59){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['45sampai59'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['45sampai59'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['45sampai59']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['45sampai59'] = 1;
                      }
                  }
                  
                  //Lebih dari 61
                  if ($y >61){
                      if (isset($b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['lebih61'])){
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['lebih61'] = $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['lebih61']+1;    
                      }else{
                          $b["$tglpendaftaran"]['det'][$ruangan_rekruitmen_id]['ruangan']["$lain2"]['lebih61'] = 1;
                      }
                  }

              }
          }

          $caraPrint = $_REQUEST['caraPrint'];
          $target = 'seleksidonor/_print';

          $arr = array('modShow'=>$modShow, 'b'=>$b);

          $this->printFunctionLandscape($model, $data, $caraPrint, $judulLaporan, $target, '',$arr);
      }

  

  /**
   * -Digunakan untuk laporan penyadapan darah
   * @author  Andyka <andykaputra@.com>
   * @website	   <.com>
   */
  public function actionLaporanPenyadapanDarah()
  {

    $criteria = new CDbCriteria();
    $model = new BDLappenyadapandarahV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['BDLappenyadapandarahV'])) {
      $model->attributes = $_GET['BDLappenyadapandarahV'];
      $model->jns_periode = $_GET['BDLappenyadapandarahV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLappenyadapandarahV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLappenyadapandarahV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BDLappenyadapandarahV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BDLappenyadapandarahV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      $model->is_batalpenyadapan = isset($_GET['BDLappenyadapandarahV']['is_batalpenyadapan']) ? $_GET['BDLappenyadapandarahV']['is_batalpenyadapan'] : null;
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
    }

    $criteria->addBetweenCondition('DATE(tglmulaiobservasi)', $model->tgl_awal, $model->tgl_akhir);
    $modShow2  = BDLappenyadapandarahV::model()->findAll($criteria);

    //Grouping
    $criteria->group  = 'DATE(waktu_pendaftaran), ruangan_nama';
    $criteria->select = 'DATE(waktu_pendaftaran) as waktu_pendaftaran, ruangan_nama';
    $criteria->order  = 'DATE(waktu_pendaftaran) ASC';
    $criteria->limit  = 10;
    $criteria->offset = !empty($_GET['page']) ? $_GET['page'] + 8 : 0;

    //Cari Data
    $modShow  = BDLappenyadapandarahV::model()->findAll($criteria);
    $count    = BDLappenyadapandarahV::model()->count($criteria);
    $pages    = new CPagination($count);

    // results per page
    $pages->pageSize = 10;
    $pages->applyLimit($criteria);

    $b = array();
    foreach ($modShow2 as $hasil) {

      $tglpendaftaran = date('Y-m-d', strtotime($hasil->waktu_pendaftaran));
      $tglsekarang = 'sekarang';

      //Umur
      $tanggal_lahir  = new DateTime($hasil->tgllahir);
      $tanggal_daftar = new DateTime($tglpendaftaran);
      $y = $tanggal_daftar->diff($tanggal_lahir)->y;

      //Jumlah keseluruhan
      if (isset($b["$tglpendaftaran"]['det']["$tglsekarang"]['jumlah'])) {
        $b["$tglpendaftaran"]['det']["$tglsekarang"]['jumlah'] = $b["$tglpendaftaran"]['det']["$tglsekarang"]['jumlah'] + 1;
      } else {
        $b["$tglpendaftaran"]['det']["$tglsekarang"]['jumlah'] = 1;
      }

      //Kurang < 18
      if ($y < 18) {
        if (isset($b["$tglpendaftaran"]['det']["$tglsekarang"]['umur<18'])) {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['umur<18'] = $b["$tglpendaftaran"]['det']["$tglsekarang"]['umur<18'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['umur<18'] = 1;
        }
      }

      //18 - 24
      if ($y >= 18 && $y <= 24) {
        if (isset($b["$tglpendaftaran"]['det']["$tglsekarang"]['18sampai24'])) {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$tglsekarang"]['18sampai24'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['18sampai24'] = 1;
        }
      }

      //25 - 44
      if ($y >= 25 && $y <= 44) {
        if (isset($b["$tglpendaftaran"]['det']["$tglsekarang"]['25sampai44'])) {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$tglsekarang"]['25sampai44'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['25sampai44'] = 1;
        }
      }

      //45 - 59
      if ($y >= 45 && $y <= 59) {
        if (isset($b["$tglpendaftaran"]['det']["$tglsekarang"]['45sampai59'])) {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$tglsekarang"]['45sampai59'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['45sampai59'] = 1;
        }
      }

      //Lebih dari 61
      if ($y > 61) {
        if (isset($b["$tglpendaftaran"]['det']["$tglsekarang"]['lebih61'])) {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['lebih61'] = $b["$tglpendaftaran"]['det']["$tglsekarang"]['lebih61'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['lebih61'] = 1;
        }
      }

      //Berdasarkan Jenis Kelamin
      $laki           = Params::JENIS_KELAMIN_LAKI_LAKI;
      $perempuan      = Params::JENIS_KELAMIN_PEREMPUAN;

      if ($hasil->jenis_kelamin == Params::JENIS_KELAMIN_LAKI_LAKI) {
        if (isset($b["$tglpendaftaran"]['det']["$laki"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$laki"]['jumlah'] = $b["$tglpendaftaran"]['det']["$laki"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$laki"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$laki"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$laki"]['umur<18'] = $b["$tglpendaftaran"]['det']["$laki"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$laki"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$laki"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$laki"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$laki"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$laki"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$laki"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$laki"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$laki"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$laki"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$laki"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$laki"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$laki"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$laki"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$laki"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$laki"]['lebih61'] = $b["$tglpendaftaran"]['det']["$laki"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$laki"]['lebih61'] = 1;
          }
        }
      }
      if ($hasil->jenis_kelamin == Params::JENIS_KELAMIN_PEREMPUAN) {
        if (isset($b["$tglpendaftaran"]['det']["$perempuan"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$perempuan"]['jumlah'] = $b["$tglpendaftaran"]['det']["$perempuan"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$perempuan"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$perempuan"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$perempuan"]['umur<18'] = $b["$tglpendaftaran"]['det']["$perempuan"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$perempuan"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$perempuan"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$perempuan"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$perempuan"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$perempuan"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$perempuan"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$perempuan"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$perempuan"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$perempuan"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$perempuan"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$perempuan"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$perempuan"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$perempuan"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$perempuan"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$perempuan"]['lebih61'] = $b["$tglpendaftaran"]['det']["$perempuan"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$perempuan"]['lebih61'] = 1;
          }
        }
      }

      //Berdasarkan Donor Ke
      $satu = 1;
      $lebihdarisatu = !1;
      if ($hasil->donasi_ke == 1) {
        if (isset($b["$tglpendaftaran"]['det']["$satu"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$satu"]['jumlah'] = $b["$tglpendaftaran"]['det']["$satu"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$satu"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$satu"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$satu"]['umur<18'] = $b["$tglpendaftaran"]['det']["$satu"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$satu"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$satu"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$satu"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$satu"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$satu"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$satu"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$satu"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$satu"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$satu"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$satu"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$satu"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$satu"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$satu"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$satu"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$satu"]['lebih61'] = $b["$tglpendaftaran"]['det']["$satu"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$satu"]['lebih61'] = 1;
          }
        }
      }
      if ($hasil->donasi_ke != 1) {
        if (isset($b["$tglpendaftaran"]['det']["$lebihdarisatu"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['jumlah'] = $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$lebihdarisatu"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['umur<18'] = $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$lebihdarisatu"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$lebihdarisatu"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$lebihdarisatu"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$lebihdarisatu"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['lebih61'] = $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['lebih61'] = 1;
          }
        }
      }

      //Berdasarkan Jenis Donor
      $skrl = 'Sukarela';
      $al   = 'Autologus';
      $pggt = 'Pengganti';
      if ($hasil->jenisdonor == 'Sukarela') {
        if (isset($b["$tglpendaftaran"]['det']["$skrl"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$skrl"]['jumlah'] = $b["$tglpendaftaran"]['det']["$skrl"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$skrl"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$skrl"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$skrl"]['umur<18'] = $b["$tglpendaftaran"]['det']["$skrl"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$skrl"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$skrl"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$skrl"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$skrl"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$skrl"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$skrl"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$skrl"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$skrl"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$skrl"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$skrl"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$skrl"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$skrl"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$skrl"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$skrl"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$skrl"]['lebih61'] = $b["$tglpendaftaran"]['det']["$skrl"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$skrl"]['lebih61'] = 1;
          }
        }
      }
      if ($hasil->jenisdonor == 'Autologus') {
        if (isset($b["$tglpendaftaran"]['det']["$al"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$al"]['jumlah'] = $b["$tglpendaftaran"]['det']["$al"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$al"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$al"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$al"]['umur<18'] = $b["$tglpendaftaran"]['det']["$al"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$al"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$al"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$al"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$al"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$al"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$al"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$al"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$al"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$al"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$al"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$al"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$al"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$al"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$al"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$al"]['lebih61'] = $b["$tglpendaftaran"]['det']["$al"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$al"]['lebih61'] = 1;
          }
        }
      }
      if ($hasil->jenisdonor == 'Pengganti') {
        if (isset($b["$tglpendaftaran"]['det']["$pggt"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$pggt"]['jumlah'] = $b["$tglpendaftaran"]['det']["$pggt"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$pggt"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$pggt"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$pggt"]['umur<18'] = $b["$tglpendaftaran"]['det']["$pggt"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$pggt"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$pggt"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$pggt"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$pggt"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$pggt"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$pggt"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$pggt"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$pggt"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$pggt"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$pggt"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$pggt"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$pggt"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$pggt"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$pggt"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$pggt"]['lebih61'] = $b["$tglpendaftaran"]['det']["$pggt"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$pggt"]['lebih61'] = 1;
          }
        }
      }

      //Berdasarkan Golongan Darah
      $goldarahA = 'A';
      $goldarahB = 'B';
      $goldarahO = 'O';
      $goldarahAB = 'AB';
      if ($hasil->gol_darah == 'A') {
        if (isset($b["$tglpendaftaran"]['det']["$goldarahA"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$goldarahA"]['jumlah'] = $b["$tglpendaftaran"]['det']["$goldarahA"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$goldarahA"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahA"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['umur<18'] = $b["$tglpendaftaran"]['det']["$goldarahA"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahA"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$goldarahA"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahA"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$goldarahA"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahA"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$goldarahA"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahA"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['lebih61'] = $b["$tglpendaftaran"]['det']["$goldarahA"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['lebih61'] = 1;
          }
        }
      }
      if ($hasil->gol_darah == 'B') {
        if (isset($b["$tglpendaftaran"]['det']["$goldarahB"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$goldarahB"]['jumlah'] = $b["$tglpendaftaran"]['det']["$goldarahB"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$goldarahB"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahB"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['umur<18'] = $b["$tglpendaftaran"]['det']["$goldarahB"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahB"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$goldarahB"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahB"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$goldarahB"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahB"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$goldarahB"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahB"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['lebih61'] = $b["$tglpendaftaran"]['det']["$goldarahB"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['lebih61'] = 1;
          }
        }
      }
      if ($hasil->gol_darah == 'O') {
        if (isset($b["$tglpendaftaran"]['det']["$goldarahO"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$goldarahO"]['jumlah'] = $b["$tglpendaftaran"]['det']["$goldarahO"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$goldarahO"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahO"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['umur<18'] = $b["$tglpendaftaran"]['det']["$goldarahO"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahO"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$goldarahO"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahO"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$goldarahO"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahO"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$goldarahO"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahO"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['lebih61'] = $b["$tglpendaftaran"]['det']["$goldarahO"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['lebih61'] = 1;
          }
        }
      }
      if ($hasil->gol_darah == 'AB') {
        if (isset($b["$tglpendaftaran"]['det']["$goldarahAB"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$goldarahAB"]['jumlah'] = $b["$tglpendaftaran"]['det']["$goldarahAB"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$goldarahAB"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahAB"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['umur<18'] = $b["$tglpendaftaran"]['det']["$goldarahAB"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahO"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$goldarahAB"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahAB"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$goldarahAB"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahAB"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$goldarahAB"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahAB"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['lebih61'] = $b["$tglpendaftaran"]['det']["$goldarahAB"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['lebih61'] = 1;
          }
        }
      }

      //Berdasarkan Rhesus
      $Positif = 'Positif';
      $Negatif = 'Negatif';
      if ($hasil->rhesus == 'Positif' || $hasil->rhesus == 'POSITIF') {
        if (isset($b["$tglpendaftaran"]['det']["$Positif"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$Positif"]['jumlah'] = $b["$tglpendaftaran"]['det']["$Positif"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$Positif"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$Positif"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$Positif"]['umur<18'] = $b["$tglpendaftaran"]['det']["$Positif"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Positif"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$Positif"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$Positif"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$Positif"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Positif"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$Positif"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$Positif"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$Positif"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Positif"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$Positif"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$Positif"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$Positif"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Positif"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$Positif"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$Positif"]['lebih61'] = $b["$tglpendaftaran"]['det']["$Positif"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Positif"]['lebih61'] = 1;
          }
        }
      }
      if ($hasil->rhesus == 'Negatif' || $hasil->rhesus == 'NEGATIF') {
        if (isset($b["$tglpendaftaran"]['det']["$Negatif"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$Negatif"]['jumlah'] = $b["$tglpendaftaran"]['det']["$Negatif"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$Negatif"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$Negatif"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$Negatif"]['umur<18'] = $b["$tglpendaftaran"]['det']["$Negatif"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Negatif"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$Negatif"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$Negatif"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$Negatif"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Negatif"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$Negatif"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$Negatif"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$Negatif"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Negatif"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$Negatif"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$Negatif"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$Negatif"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Negatif"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$Negatif"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$Negatif"]['lebih61'] = $b["$tglpendaftaran"]['det']["$Negatif"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Negatif"]['lebih61'] = 1;
          }
        }
      }

      //Berdasarkan Jenis Kantong
      $SG  = 'Single'; //1
      $DBL = 'Double'; //2
      $TR  = 'Triple'; //3
      $QR  = 'Quadruple'; //4
      $cariKantong = KantongdarahT::model()->findByAttributes(array('daftarpendonor_id' => $hasil->daftardonasi_id));
      if (!empty($cariKantong)) {
        if ($cariKantong->jeniskantongdarah_id == 1) {
          if (isset($b["$tglpendaftaran"]['det']["$SG"]['jumlah'])) {
            $b["$tglpendaftaran"]['det']["$SG"]['jumlah'] = $b["$tglpendaftaran"]['det']["$SG"]['jumlah'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$SG"]['jumlah'] = 1;
          }

          //Kurang < 18
          if ($y < 18) {
            if (isset($b["$tglpendaftaran"]['det']["$SG"]['umur<18'])) {
              $b["$tglpendaftaran"]['det']["$SG"]['umur<18'] = $b["$tglpendaftaran"]['det']["$SG"]['umur<18'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$SG"]['umur<18'] = 1;
            }
          }

          //18 - 24
          if ($y >= 18 && $y <= 24) {
            if (isset($b["$tglpendaftaran"]['det']["$SG"]['18sampai24'])) {
              $b["$tglpendaftaran"]['det']["$SG"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$SG"]['18sampai24'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$SG"]['18sampai24'] = 1;
            }
          }

          //25 - 44
          if ($y >= 25 && $y <= 44) {
            if (isset($b["$tglpendaftaran"]['det']["$SG"]['25sampai44'])) {
              $b["$tglpendaftaran"]['det']["$SG"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$SG"]['25sampai44'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$SG"]['25sampai44'] = 1;
            }
          }

          //45 - 59
          if ($y >= 45 && $y <= 59) {
            if (isset($b["$tglpendaftaran"]['det']["$SG"]['45sampai59'])) {
              $b["$tglpendaftaran"]['det']["$SG"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$SG"]['45sampai59'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$SG"]['45sampai59'] = 1;
            }
          }

          //Lebih dari 61
          if ($y > 61) {
            if (isset($b["$tglpendaftaran"]['det']["$SG"]['lebih61'])) {
              $b["$tglpendaftaran"]['det']["$SG"]['lebih61'] = $b["$tglpendaftaran"]['det']["$SG"]['lebih61'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$SG"]['lebih61'] = 1;
            }
          }
        }
        if ($cariKantong->jeniskantongdarah_id == 2) {
          if (isset($b["$tglpendaftaran"]['det']["$DBL"]['jumlah'])) {
            $b["$tglpendaftaran"]['det']["$DBL"]['jumlah'] = $b["$tglpendaftaran"]['det']["$DBL"]['jumlah'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$DBL"]['jumlah'] = 1;
          }

          //Kurang < 18
          if ($y < 18) {
            if (isset($b["$tglpendaftaran"]['det']["$DBL"]['umur<18'])) {
              $b["$tglpendaftaran"]['det']["$DBL"]['umur<18'] = $b["$tglpendaftaran"]['det']["$DBL"]['umur<18'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$DBL"]['umur<18'] = 1;
            }
          }

          //18 - 24
          if ($y >= 18 && $y <= 24) {
            if (isset($b["$tglpendaftaran"]['det']["$DBL"]['18sampai24'])) {
              $b["$tglpendaftaran"]['det']["$DBL"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$DBL"]['18sampai24'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$DBL"]['18sampai24'] = 1;
            }
          }

          //25 - 44
          if ($y >= 25 && $y <= 44) {
            if (isset($b["$tglpendaftaran"]['det']["$DBL"]['25sampai44'])) {
              $b["$tglpendaftaran"]['det']["$DBL"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$DBL"]['25sampai44'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$DBL"]['25sampai44'] = 1;
            }
          }

          //45 - 59
          if ($y >= 45 && $y <= 59) {
            if (isset($b["$tglpendaftaran"]['det']["$DBL"]['45sampai59'])) {
              $b["$tglpendaftaran"]['det']["$DBL"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$DBL"]['45sampai59'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$DBL"]['45sampai59'] = 1;
            }
          }

          //Lebih dari 61
          if ($y > 61) {
            if (isset($b["$tglpendaftaran"]['det']["$DBL"]['lebih61'])) {
              $b["$tglpendaftaran"]['det']["$DBL"]['lebih61'] = $b["$tglpendaftaran"]['det']["$DBL"]['lebih61'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$DBL"]['lebih61'] = 1;
            }
          }
        }
        if ($cariKantong->jeniskantongdarah_id == 3) {
          if (isset($b["$tglpendaftaran"]['det']["$TR"]['jumlah'])) {
            $b["$tglpendaftaran"]['det']["$TR"]['jumlah'] = $b["$tglpendaftaran"]['det']["$TR"]['jumlah'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$TR"]['jumlah'] = 1;
          }

          //Kurang < 18
          if ($y < 18) {
            if (isset($b["$tglpendaftaran"]['det']["$TR"]['umur<18'])) {
              $b["$tglpendaftaran"]['det']["$TR"]['umur<18'] = $b["$tglpendaftaran"]['det']["$TR"]['umur<18'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$TR"]['umur<18'] = 1;
            }
          }

          //18 - 24
          if ($y >= 18 && $y <= 24) {
            if (isset($b["$tglpendaftaran"]['det']["$TR"]['18sampai24'])) {
              $b["$tglpendaftaran"]['det']["$TR"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$TR"]['18sampai24'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$TR"]['18sampai24'] = 1;
            }
          }

          //25 - 44
          if ($y >= 25 && $y <= 44) {
            if (isset($b["$tglpendaftaran"]['det']["$TR"]['25sampai44'])) {
              $b["$tglpendaftaran"]['det']["$TR"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$TR"]['25sampai44'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$TR"]['25sampai44'] = 1;
            }
          }

          //45 - 59
          if ($y >= 45 && $y <= 59) {
            if (isset($b["$tglpendaftaran"]['det']["$TR"]['45sampai59'])) {
              $b["$tglpendaftaran"]['det']["$TR"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$TR"]['45sampai59'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$TR"]['45sampai59'] = 1;
            }
          }

          //Lebih dari 61
          if ($y > 61) {
            if (isset($b["$tglpendaftaran"]['det']["$TR"]['lebih61'])) {
              $b["$tglpendaftaran"]['det']["$TR"]['lebih61'] = $b["$tglpendaftaran"]['det']["$TR"]['lebih61'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$TR"]['lebih61'] = 1;
            }
          }
        }
        if ($cariKantong->jeniskantongdarah_id == 4) {
          if (isset($b["$tglpendaftaran"]['det']["$QR"]['jumlah'])) {
            $b["$tglpendaftaran"]['det']["$QR"]['jumlah'] = $b["$tglpendaftaran"]['det']["$QR"]['jumlah'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$QR"]['jumlah'] = 1;
          }

          //Kurang < 18
          if ($y < 18) {
            if (isset($b["$tglpendaftaran"]['det']["$QR"]['umur<18'])) {
              $b["$tglpendaftaran"]['det']["$QR"]['umur<18'] = $b["$tglpendaftaran"]['det']["$QR"]['umur<18'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$QR"]['umur<18'] = 1;
            }
          }

          //18 - 24
          if ($y >= 18 && $y <= 24) {
            if (isset($b["$tglpendaftaran"]['det']["$QR"]['18sampai24'])) {
              $b["$tglpendaftaran"]['det']["$QR"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$QR"]['18sampai24'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$QR"]['18sampai24'] = 1;
            }
          }

          //25 - 44
          if ($y >= 25 && $y <= 44) {
            if (isset($b["$tglpendaftaran"]['det']["$QR"]['25sampai44'])) {
              $b["$tglpendaftaran"]['det']["$QR"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$QR"]['25sampai44'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$QR"]['25sampai44'] = 1;
            }
          }

          //45 - 59
          if ($y >= 45 && $y <= 59) {
            if (isset($b["$tglpendaftaran"]['det']["$QR"]['45sampai59'])) {
              $b["$tglpendaftaran"]['det']["$QR"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$QR"]['45sampai59'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$QR"]['45sampai59'] = 1;
            }
          }

          //Lebih dari 61
          if ($y > 61) {
            if (isset($b["$tglpendaftaran"]['det']["$QR"]['lebih61'])) {
              $b["$tglpendaftaran"]['det']["$QR"]['lebih61'] = $b["$tglpendaftaran"]['det']["$QR"]['lebih61'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$QR"]['lebih61'] = 1;
            }
          }
        }
      }
      //Berdasarkan Gagal Sadap
      $alasanbatal = $hasil->alasanbatal_penyadapan;
      $carikata1 = 'REAKSI DONOR';
      $carikata2 = 'Vena Kecil';

      if (strpos($alasanbatal, 'REAKSI DONOR') !== false) {
        if (isset($b["$tglpendaftaran"]['det']["$carikata1"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$carikata1"]['jumlah'] = $b["$tglpendaftaran"]['det']["$carikata1"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$carikata1"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata1"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$carikata1"]['umur<18'] = $b["$tglpendaftaran"]['det']["$carikata1"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata1"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata1"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$carikata1"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$carikata1"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata1"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata1"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$carikata1"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$carikata1"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata1"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata1"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$carikata1"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$carikata1"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata1"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata1"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$carikata1"]['lebih61'] = $b["$tglpendaftaran"]['det']["$carikata1"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata1"]['lebih61'] = 1;
          }
        }
      }

      if (strpos($alasanbatal, 'Vena Kecil') !== false) {
        if (isset($b["$tglpendaftaran"]['det']["$carikata2"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$carikata2"]['jumlah'] = $b["$tglpendaftaran"]['det']["$carikata2"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$carikata2"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata2"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$carikata2"]['umur<18'] = $b["$tglpendaftaran"]['det']["$carikata2"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata2"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata2"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$carikata2"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$carikata2"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata2"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata2"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$carikata2"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$carikata2"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata2"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata2"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$carikata2"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$carikata2"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata2"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata2"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$carikata2"]['lebih61'] = $b["$tglpendaftaran"]['det']["$carikata2"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata2"]['lebih61'] = 1;
          }
        }
      }

      //Berdasarkan Sukses Sadap
      $lolos = 'lolos';

      if ($hasil->is_batalpenyadapan == false) {
        if (isset($b["$tglpendaftaran"]['det']["$lolos"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$lolos"]['jumlah'] = $b["$tglpendaftaran"]['det']["$lolos"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$lolos"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$lolos"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$lolos"]['umur<18'] = $b["$tglpendaftaran"]['det']["$lolos"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lolos"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$lolos"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$lolos"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$lolos"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lolos"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$lolos"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$lolos"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$lolos"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lolos"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$lolos"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$lolos"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$lolos"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lolos"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$lolos"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$lolos"]['lebih61'] = $b["$tglpendaftaran"]['det']["$lolos"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lolos"]['lebih61'] = 1;
          }
        }
      }
    }

    $this->render('penyadapandarah/admin', array(
      'model' => $model,
      'modShow' => $modShow,
      'b' => $b,
      'pages' => $pages
    ));
  }

  public function actionFrameGrafikPenyadapanDarah()
  {
    $this->layout = '//layouts/iframe';

    $model = new BDLappenyadapandarahV('searchGrafik');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Penyadapan Darah';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['BDLappenyadapandarahV'])) {
      $model->attributes = $_GET['BDLappenyadapandarahV'];
      $model->jns_periode = $_GET['BDLappenyadapandarahV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLappenyadapandarahV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLappenyadapandarahV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BDLappenyadapandarahV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BDLappenyadapandarahV']['bln_akhir']);
      $model->thn_awal = $_GET['BDLappenyadapandarahV']['thn_awal'];
      $model->thn_akhir = $_GET['BDLappenyadapandarahV']['thn_akhir'];
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
      $model->is_batalpenyadapan = isset($_GET['BDLappenyadapandarahV']['is_batalpenyadapan']) ? $_GET['BDLappenyadapandarahV']['is_batalpenyadapan'] : null;
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionPrintPenyadapanDarah()
  {
    $criteria = new CDbCriteria();
    $model = new BDLappenyadapandarahV('searchPrint');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Penyadapan Darah';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Penyadapan Darah';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['BDLappenyadapandarahV'])) {
      $model->attributes = $_REQUEST['BDLappenyadapandarahV'];
      $model->jns_periode = $_GET['BDLappenyadapandarahV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLappenyadapandarahV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLappenyadapandarahV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BDLappenyadapandarahV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BDLappenyadapandarahV']['bln_akhir']);
      $model->thn_awal = $_GET['BDLappenyadapandarahV']['thn_awal'];
      $model->thn_akhir = $_GET['BDLappenyadapandarahV']['thn_akhir'];
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
      $model->is_batalpenyadapan = isset($_GET['BDLappenyadapandarahV']['is_batalpenyadapan']) ? $_GET['BDLappenyadapandarahV']['is_batalpenyadapan'] : null;
    }

    $criteria->addBetweenCondition('DATE(tglmulaiobservasi)', $model->tgl_awal, $model->tgl_akhir);
    $modShow2  = BDLappenyadapandarahV::model()->findAll($criteria);

    //Grouping
    $criteria->group  = 'DATE(waktu_pendaftaran), ruangan_nama';
    $criteria->select = 'DATE(waktu_pendaftaran) as waktu_pendaftaran, ruangan_nama';
    $criteria->order  = 'DATE(waktu_pendaftaran) ASC';

    //Cari Data
    $modShow  = BDLappenyadapandarahV::model()->findAll($criteria);
    $b = array();
    foreach ($modShow2 as $hasil) {

      $tglpendaftaran = date('Y-m-d', strtotime($hasil->waktu_pendaftaran));
      $tglsekarang = 'sekarang';

      //Umur
      $tanggal_lahir  = new DateTime($hasil->tgllahir);
      $tanggal_daftar = new DateTime($tglpendaftaran);
      $y = $tanggal_daftar->diff($tanggal_lahir)->y;

      //Jumlah keseluruhan
      if (isset($b["$tglpendaftaran"]['det']["$tglsekarang"]['jumlah'])) {
        $b["$tglpendaftaran"]['det']["$tglsekarang"]['jumlah'] = $b["$tglpendaftaran"]['det']["$tglsekarang"]['jumlah'] + 1;
      } else {
        $b["$tglpendaftaran"]['det']["$tglsekarang"]['jumlah'] = 1;
      }

      //Kurang < 18
      if ($y < 18) {
        if (isset($b["$tglpendaftaran"]['det']["$tglsekarang"]['umur<18'])) {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['umur<18'] = $b["$tglpendaftaran"]['det']["$tglsekarang"]['umur<18'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['umur<18'] = 1;
        }
      }

      //18 - 24
      if ($y >= 18 && $y <= 24) {
        if (isset($b["$tglpendaftaran"]['det']["$tglsekarang"]['18sampai24'])) {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$tglsekarang"]['18sampai24'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['18sampai24'] = 1;
        }
      }

      //25 - 44
      if ($y >= 25 && $y <= 44) {
        if (isset($b["$tglpendaftaran"]['det']["$tglsekarang"]['25sampai44'])) {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$tglsekarang"]['25sampai44'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['25sampai44'] = 1;
        }
      }

      //45 - 59
      if ($y >= 45 && $y <= 59) {
        if (isset($b["$tglpendaftaran"]['det']["$tglsekarang"]['45sampai59'])) {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$tglsekarang"]['45sampai59'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['45sampai59'] = 1;
        }
      }

      //Lebih dari 61
      if ($y > 61) {
        if (isset($b["$tglpendaftaran"]['det']["$tglsekarang"]['lebih61'])) {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['lebih61'] = $b["$tglpendaftaran"]['det']["$tglsekarang"]['lebih61'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$tglsekarang"]['lebih61'] = 1;
        }
      }

      //Berdasarkan Jenis Kelamin
      $laki           = Params::JENIS_KELAMIN_LAKI_LAKI;
      $perempuan      = Params::JENIS_KELAMIN_PEREMPUAN;

      if ($hasil->jenis_kelamin == Params::JENIS_KELAMIN_LAKI_LAKI) {
        if (isset($b["$tglpendaftaran"]['det']["$laki"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$laki"]['jumlah'] = $b["$tglpendaftaran"]['det']["$laki"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$laki"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$laki"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$laki"]['umur<18'] = $b["$tglpendaftaran"]['det']["$laki"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$laki"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$laki"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$laki"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$laki"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$laki"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$laki"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$laki"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$laki"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$laki"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$laki"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$laki"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$laki"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$laki"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$laki"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$laki"]['lebih61'] = $b["$tglpendaftaran"]['det']["$laki"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$laki"]['lebih61'] = 1;
          }
        }
      }
      if ($hasil->jenis_kelamin == Params::JENIS_KELAMIN_PEREMPUAN) {
        if (isset($b["$tglpendaftaran"]['det']["$perempuan"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$perempuan"]['jumlah'] = $b["$tglpendaftaran"]['det']["$perempuan"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$perempuan"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$perempuan"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$perempuan"]['umur<18'] = $b["$tglpendaftaran"]['det']["$perempuan"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$perempuan"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$perempuan"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$perempuan"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$perempuan"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$perempuan"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$perempuan"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$perempuan"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$perempuan"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$perempuan"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$perempuan"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$perempuan"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$perempuan"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$perempuan"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$perempuan"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$perempuan"]['lebih61'] = $b["$tglpendaftaran"]['det']["$perempuan"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$perempuan"]['lebih61'] = 1;
          }
        }
      }

      //Berdasarkan Donor Ke
      $satu = 1;
      $lebihdarisatu = !1;
      if ($hasil->donasi_ke == 1) {
        if (isset($b["$tglpendaftaran"]['det']["$satu"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$satu"]['jumlah'] = $b["$tglpendaftaran"]['det']["$satu"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$satu"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$satu"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$satu"]['umur<18'] = $b["$tglpendaftaran"]['det']["$satu"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$satu"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$satu"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$satu"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$satu"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$satu"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$satu"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$satu"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$satu"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$satu"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$satu"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$satu"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$satu"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$satu"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$satu"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$satu"]['lebih61'] = $b["$tglpendaftaran"]['det']["$satu"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$satu"]['lebih61'] = 1;
          }
        }
      }
      if ($hasil->donasi_ke != 1) {
        if (isset($b["$tglpendaftaran"]['det']["$lebihdarisatu"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['jumlah'] = $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$lebihdarisatu"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['umur<18'] = $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$lebihdarisatu"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$lebihdarisatu"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$lebihdarisatu"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$lebihdarisatu"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['lebih61'] = $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['lebih61'] = 1;
          }
        }
      }

      //Berdasarkan Jenis Donor
      $skrl = 'Sukarela';
      $al   = 'Autologus';
      $pggt = 'Pengganti';
      if ($hasil->jenisdonor == 'Sukarela') {
        if (isset($b["$tglpendaftaran"]['det']["$skrl"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$skrl"]['jumlah'] = $b["$tglpendaftaran"]['det']["$skrl"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$skrl"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$skrl"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$skrl"]['umur<18'] = $b["$tglpendaftaran"]['det']["$skrl"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$skrl"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$skrl"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$skrl"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$skrl"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$skrl"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$skrl"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$skrl"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$skrl"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$skrl"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$skrl"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$skrl"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$skrl"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$skrl"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$skrl"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$skrl"]['lebih61'] = $b["$tglpendaftaran"]['det']["$skrl"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$skrl"]['lebih61'] = 1;
          }
        }
      }
      if ($hasil->jenisdonor == 'Autologus') {
        if (isset($b["$tglpendaftaran"]['det']["$al"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$al"]['jumlah'] = $b["$tglpendaftaran"]['det']["$al"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$al"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$al"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$al"]['umur<18'] = $b["$tglpendaftaran"]['det']["$al"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$al"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$al"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$al"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$al"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$al"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$al"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$al"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$al"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$al"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$al"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$al"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$al"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$al"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$al"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$al"]['lebih61'] = $b["$tglpendaftaran"]['det']["$al"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$al"]['lebih61'] = 1;
          }
        }
      }
      if ($hasil->jenisdonor == 'Pengganti') {
        if (isset($b["$tglpendaftaran"]['det']["$pggt"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$pggt"]['jumlah'] = $b["$tglpendaftaran"]['det']["$pggt"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$pggt"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$pggt"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$pggt"]['umur<18'] = $b["$tglpendaftaran"]['det']["$pggt"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$pggt"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$pggt"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$pggt"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$pggt"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$pggt"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$pggt"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$pggt"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$pggt"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$pggt"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$pggt"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$pggt"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$pggt"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$pggt"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$pggt"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$pggt"]['lebih61'] = $b["$tglpendaftaran"]['det']["$pggt"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$pggt"]['lebih61'] = 1;
          }
        }
      }

      //Berdasarkan Golongan Darah
      $goldarahA = 'A';
      $goldarahB = 'B';
      $goldarahO = 'O';
      $goldarahAB = 'AB';
      if ($hasil->gol_darah == 'A') {
        if (isset($b["$tglpendaftaran"]['det']["$goldarahA"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$goldarahA"]['jumlah'] = $b["$tglpendaftaran"]['det']["$goldarahA"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$goldarahA"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahA"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['umur<18'] = $b["$tglpendaftaran"]['det']["$goldarahA"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahA"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$goldarahA"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahA"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$goldarahA"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahA"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$goldarahA"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahA"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['lebih61'] = $b["$tglpendaftaran"]['det']["$goldarahA"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahA"]['lebih61'] = 1;
          }
        }
      }
      if ($hasil->gol_darah == 'B') {
        if (isset($b["$tglpendaftaran"]['det']["$goldarahB"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$goldarahB"]['jumlah'] = $b["$tglpendaftaran"]['det']["$goldarahB"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$goldarahB"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahB"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['umur<18'] = $b["$tglpendaftaran"]['det']["$goldarahB"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahB"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$goldarahB"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahB"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$goldarahB"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahB"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$goldarahB"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahB"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['lebih61'] = $b["$tglpendaftaran"]['det']["$goldarahB"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahB"]['lebih61'] = 1;
          }
        }
      }
      if ($hasil->gol_darah == 'O') {
        if (isset($b["$tglpendaftaran"]['det']["$goldarahO"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$goldarahO"]['jumlah'] = $b["$tglpendaftaran"]['det']["$goldarahO"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$goldarahO"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahO"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['umur<18'] = $b["$tglpendaftaran"]['det']["$goldarahO"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahO"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$goldarahO"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahO"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$goldarahO"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahO"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$goldarahO"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahO"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['lebih61'] = $b["$tglpendaftaran"]['det']["$goldarahO"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahO"]['lebih61'] = 1;
          }
        }
      }
      if ($hasil->gol_darah == 'AB') {
        if (isset($b["$tglpendaftaran"]['det']["$goldarahAB"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$goldarahAB"]['jumlah'] = $b["$tglpendaftaran"]['det']["$goldarahAB"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$goldarahAB"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahAB"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['umur<18'] = $b["$tglpendaftaran"]['det']["$goldarahAB"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahO"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$goldarahAB"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahAB"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$goldarahAB"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahAB"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$goldarahAB"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$goldarahAB"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['lebih61'] = $b["$tglpendaftaran"]['det']["$goldarahAB"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$goldarahAB"]['lebih61'] = 1;
          }
        }
      }

      //Berdasarkan Rhesus
      $Positif = 'Positif';
      $Negatif = 'Negatif';
      if ($hasil->rhesus == 'Positif' || $hasil->rhesus == 'POSITIF') {
        if (isset($b["$tglpendaftaran"]['det']["$Positif"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$Positif"]['jumlah'] = $b["$tglpendaftaran"]['det']["$Positif"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$Positif"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$Positif"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$Positif"]['umur<18'] = $b["$tglpendaftaran"]['det']["$Positif"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Positif"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$Positif"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$Positif"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$Positif"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Positif"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$Positif"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$Positif"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$Positif"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Positif"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$Positif"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$Positif"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$Positif"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Positif"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$Positif"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$Positif"]['lebih61'] = $b["$tglpendaftaran"]['det']["$Positif"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Positif"]['lebih61'] = 1;
          }
        }
      }
      if ($hasil->rhesus == 'Negatif' || $hasil->rhesus == 'NEGATIF') {
        if (isset($b["$tglpendaftaran"]['det']["$Negatif"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$Negatif"]['jumlah'] = $b["$tglpendaftaran"]['det']["$Negatif"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$Negatif"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$Negatif"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$Negatif"]['umur<18'] = $b["$tglpendaftaran"]['det']["$Negatif"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Negatif"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$Negatif"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$Negatif"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$Negatif"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Negatif"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$Negatif"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$Negatif"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$Negatif"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Negatif"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$Negatif"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$Negatif"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$Negatif"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Negatif"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$Negatif"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$Negatif"]['lebih61'] = $b["$tglpendaftaran"]['det']["$Negatif"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$Negatif"]['lebih61'] = 1;
          }
        }
      }

      //Berdasarkan Jenis Kantong
      $SG  = 'Single'; //1
      $DBL = 'Double'; //2
      $TR  = 'Triple'; //3
      $QR  = 'Quadruple'; //4
      $cariKantong = KantongdarahT::model()->findByAttributes(array('daftarpendonor_id' => $hasil->daftardonasi_id));
      if (!empty($cariKantong)) {
        if ($cariKantong->jeniskantongdarah_id == 1) {
          if (isset($b["$tglpendaftaran"]['det']["$SG"]['jumlah'])) {
            $b["$tglpendaftaran"]['det']["$SG"]['jumlah'] = $b["$tglpendaftaran"]['det']["$SG"]['jumlah'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$SG"]['jumlah'] = 1;
          }

          //Kurang < 18
          if ($y < 18) {
            if (isset($b["$tglpendaftaran"]['det']["$SG"]['umur<18'])) {
              $b["$tglpendaftaran"]['det']["$SG"]['umur<18'] = $b["$tglpendaftaran"]['det']["$SG"]['umur<18'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$SG"]['umur<18'] = 1;
            }
          }

          //18 - 24
          if ($y >= 18 && $y <= 24) {
            if (isset($b["$tglpendaftaran"]['det']["$SG"]['18sampai24'])) {
              $b["$tglpendaftaran"]['det']["$SG"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$SG"]['18sampai24'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$SG"]['18sampai24'] = 1;
            }
          }

          //25 - 44
          if ($y >= 25 && $y <= 44) {
            if (isset($b["$tglpendaftaran"]['det']["$SG"]['25sampai44'])) {
              $b["$tglpendaftaran"]['det']["$SG"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$SG"]['25sampai44'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$SG"]['25sampai44'] = 1;
            }
          }

          //45 - 59
          if ($y >= 45 && $y <= 59) {
            if (isset($b["$tglpendaftaran"]['det']["$SG"]['45sampai59'])) {
              $b["$tglpendaftaran"]['det']["$SG"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$SG"]['45sampai59'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$SG"]['45sampai59'] = 1;
            }
          }

          //Lebih dari 61
          if ($y > 61) {
            if (isset($b["$tglpendaftaran"]['det']["$SG"]['lebih61'])) {
              $b["$tglpendaftaran"]['det']["$SG"]['lebih61'] = $b["$tglpendaftaran"]['det']["$SG"]['lebih61'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$SG"]['lebih61'] = 1;
            }
          }
        }
        if ($cariKantong->jeniskantongdarah_id == 2) {
          if (isset($b["$tglpendaftaran"]['det']["$DBL"]['jumlah'])) {
            $b["$tglpendaftaran"]['det']["$DBL"]['jumlah'] = $b["$tglpendaftaran"]['det']["$DBL"]['jumlah'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$DBL"]['jumlah'] = 1;
          }

          //Kurang < 18
          if ($y < 18) {
            if (isset($b["$tglpendaftaran"]['det']["$DBL"]['umur<18'])) {
              $b["$tglpendaftaran"]['det']["$DBL"]['umur<18'] = $b["$tglpendaftaran"]['det']["$DBL"]['umur<18'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$DBL"]['umur<18'] = 1;
            }
          }

          //18 - 24
          if ($y >= 18 && $y <= 24) {
            if (isset($b["$tglpendaftaran"]['det']["$DBL"]['18sampai24'])) {
              $b["$tglpendaftaran"]['det']["$DBL"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$DBL"]['18sampai24'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$DBL"]['18sampai24'] = 1;
            }
          }

          //25 - 44
          if ($y >= 25 && $y <= 44) {
            if (isset($b["$tglpendaftaran"]['det']["$DBL"]['25sampai44'])) {
              $b["$tglpendaftaran"]['det']["$DBL"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$DBL"]['25sampai44'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$DBL"]['25sampai44'] = 1;
            }
          }

          //45 - 59
          if ($y >= 45 && $y <= 59) {
            if (isset($b["$tglpendaftaran"]['det']["$DBL"]['45sampai59'])) {
              $b["$tglpendaftaran"]['det']["$DBL"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$DBL"]['45sampai59'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$DBL"]['45sampai59'] = 1;
            }
          }

          //Lebih dari 61
          if ($y > 61) {
            if (isset($b["$tglpendaftaran"]['det']["$DBL"]['lebih61'])) {
              $b["$tglpendaftaran"]['det']["$DBL"]['lebih61'] = $b["$tglpendaftaran"]['det']["$DBL"]['lebih61'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$DBL"]['lebih61'] = 1;
            }
          }
        }
        if ($cariKantong->jeniskantongdarah_id == 3) {
          if (isset($b["$tglpendaftaran"]['det']["$TR"]['jumlah'])) {
            $b["$tglpendaftaran"]['det']["$TR"]['jumlah'] = $b["$tglpendaftaran"]['det']["$TR"]['jumlah'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$TR"]['jumlah'] = 1;
          }

          //Kurang < 18
          if ($y < 18) {
            if (isset($b["$tglpendaftaran"]['det']["$TR"]['umur<18'])) {
              $b["$tglpendaftaran"]['det']["$TR"]['umur<18'] = $b["$tglpendaftaran"]['det']["$TR"]['umur<18'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$TR"]['umur<18'] = 1;
            }
          }

          //18 - 24
          if ($y >= 18 && $y <= 24) {
            if (isset($b["$tglpendaftaran"]['det']["$TR"]['18sampai24'])) {
              $b["$tglpendaftaran"]['det']["$TR"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$TR"]['18sampai24'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$TR"]['18sampai24'] = 1;
            }
          }

          //25 - 44
          if ($y >= 25 && $y <= 44) {
            if (isset($b["$tglpendaftaran"]['det']["$TR"]['25sampai44'])) {
              $b["$tglpendaftaran"]['det']["$TR"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$TR"]['25sampai44'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$TR"]['25sampai44'] = 1;
            }
          }

          //45 - 59
          if ($y >= 45 && $y <= 59) {
            if (isset($b["$tglpendaftaran"]['det']["$TR"]['45sampai59'])) {
              $b["$tglpendaftaran"]['det']["$TR"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$TR"]['45sampai59'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$TR"]['45sampai59'] = 1;
            }
          }

          //Lebih dari 61
          if ($y > 61) {
            if (isset($b["$tglpendaftaran"]['det']["$TR"]['lebih61'])) {
              $b["$tglpendaftaran"]['det']["$TR"]['lebih61'] = $b["$tglpendaftaran"]['det']["$TR"]['lebih61'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$TR"]['lebih61'] = 1;
            }
          }
        }
        if ($cariKantong->jeniskantongdarah_id == 4) {
          if (isset($b["$tglpendaftaran"]['det']["$QR"]['jumlah'])) {
            $b["$tglpendaftaran"]['det']["$QR"]['jumlah'] = $b["$tglpendaftaran"]['det']["$QR"]['jumlah'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$QR"]['jumlah'] = 1;
          }

          //Kurang < 18
          if ($y < 18) {
            if (isset($b["$tglpendaftaran"]['det']["$QR"]['umur<18'])) {
              $b["$tglpendaftaran"]['det']["$QR"]['umur<18'] = $b["$tglpendaftaran"]['det']["$QR"]['umur<18'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$QR"]['umur<18'] = 1;
            }
          }

          //18 - 24
          if ($y >= 18 && $y <= 24) {
            if (isset($b["$tglpendaftaran"]['det']["$QR"]['18sampai24'])) {
              $b["$tglpendaftaran"]['det']["$QR"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$QR"]['18sampai24'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$QR"]['18sampai24'] = 1;
            }
          }

          //25 - 44
          if ($y >= 25 && $y <= 44) {
            if (isset($b["$tglpendaftaran"]['det']["$QR"]['25sampai44'])) {
              $b["$tglpendaftaran"]['det']["$QR"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$QR"]['25sampai44'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$QR"]['25sampai44'] = 1;
            }
          }

          //45 - 59
          if ($y >= 45 && $y <= 59) {
            if (isset($b["$tglpendaftaran"]['det']["$QR"]['45sampai59'])) {
              $b["$tglpendaftaran"]['det']["$QR"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$QR"]['45sampai59'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$QR"]['45sampai59'] = 1;
            }
          }

          //Lebih dari 61
          if ($y > 61) {
            if (isset($b["$tglpendaftaran"]['det']["$QR"]['lebih61'])) {
              $b["$tglpendaftaran"]['det']["$QR"]['lebih61'] = $b["$tglpendaftaran"]['det']["$QR"]['lebih61'] + 1;
            } else {
              $b["$tglpendaftaran"]['det']["$QR"]['lebih61'] = 1;
            }
          }
        }
      }
      //Berdasarkan Gagal Sadap
      $alasanbatal = $hasil->alasanbatal_penyadapan;
      $carikata1 = 'REAKSI DONOR';
      $carikata2 = 'Vena Kecil';

      if (strpos($alasanbatal, 'REAKSI DONOR') !== false) {
        if (isset($b["$tglpendaftaran"]['det']["$carikata1"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$carikata1"]['jumlah'] = $b["$tglpendaftaran"]['det']["$carikata1"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$carikata1"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata1"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$carikata1"]['umur<18'] = $b["$tglpendaftaran"]['det']["$carikata1"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata1"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata1"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$carikata1"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$carikata1"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata1"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata1"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$carikata1"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$carikata1"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata1"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata1"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$carikata1"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$carikata1"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata1"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata1"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$carikata1"]['lebih61'] = $b["$tglpendaftaran"]['det']["$carikata1"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata1"]['lebih61'] = 1;
          }
        }
      }

      if (strpos($alasanbatal, 'Vena Kecil') !== false) {
        if (isset($b["$tglpendaftaran"]['det']["$carikata2"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$carikata2"]['jumlah'] = $b["$tglpendaftaran"]['det']["$carikata2"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$carikata2"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata2"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$carikata2"]['umur<18'] = $b["$tglpendaftaran"]['det']["$carikata2"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata2"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata2"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$carikata2"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$carikata2"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata2"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata2"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$carikata2"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$carikata2"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata2"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata2"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$carikata2"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$carikata2"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata2"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$carikata2"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$carikata2"]['lebih61'] = $b["$tglpendaftaran"]['det']["$carikata2"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$carikata2"]['lebih61'] = 1;
          }
        }
      }

      //Berdasarkan Sukses Sadap
      $lolos = 'lolos';

      if ($hasil->is_batalpenyadapan == false) {
        if (isset($b["$tglpendaftaran"]['det']["$lolos"]['jumlah'])) {
          $b["$tglpendaftaran"]['det']["$lolos"]['jumlah'] = $b["$tglpendaftaran"]['det']["$lolos"]['jumlah'] + 1;
        } else {
          $b["$tglpendaftaran"]['det']["$lolos"]['jumlah'] = 1;
        }

        //Kurang < 18
        if ($y < 18) {
          if (isset($b["$tglpendaftaran"]['det']["$lolos"]['umur<18'])) {
            $b["$tglpendaftaran"]['det']["$lolos"]['umur<18'] = $b["$tglpendaftaran"]['det']["$lolos"]['umur<18'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lolos"]['umur<18'] = 1;
          }
        }

        //18 - 24
        if ($y >= 18 && $y <= 24) {
          if (isset($b["$tglpendaftaran"]['det']["$lolos"]['18sampai24'])) {
            $b["$tglpendaftaran"]['det']["$lolos"]['18sampai24'] = $b["$tglpendaftaran"]['det']["$lolos"]['18sampai24'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lolos"]['18sampai24'] = 1;
          }
        }

        //25 - 44
        if ($y >= 25 && $y <= 44) {
          if (isset($b["$tglpendaftaran"]['det']["$lolos"]['25sampai44'])) {
            $b["$tglpendaftaran"]['det']["$lolos"]['25sampai44'] = $b["$tglpendaftaran"]['det']["$lolos"]['25sampai44'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lolos"]['25sampai44'] = 1;
          }
        }

        //45 - 59
        if ($y >= 45 && $y <= 59) {
          if (isset($b["$tglpendaftaran"]['det']["$lolos"]['45sampai59'])) {
            $b["$tglpendaftaran"]['det']["$lolos"]['45sampai59'] = $b["$tglpendaftaran"]['det']["$lolos"]['45sampai59'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lolos"]['45sampai59'] = 1;
          }
        }

        //Lebih dari 61
        if ($y > 61) {
          if (isset($b["$tglpendaftaran"]['det']["$lolos"]['lebih61'])) {
            $b["$tglpendaftaran"]['det']["$lolos"]['lebih61'] = $b["$tglpendaftaran"]['det']["$lolos"]['lebih61'] + 1;
          } else {
            $b["$tglpendaftaran"]['det']["$lolos"]['lebih61'] = 1;
          }
        }
      }
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'penyadapandarah/_print';

    $arr = array('modShow' => $modShow, 'b' => $b);

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, '', $arr);
  }

    /**
     * Fungsi print 
     * @author Andyka Putra <andykaputra@.com>
     * 
     * @param type $model
     * @param type $data
     * @param type $caraPrint
     * @param type $judulLaporan
     * @param type $target
     * @param type $tab
     * @param type $variabel
     */
    protected function printFunctionLandscape($model,$data, $caraPrint, $judulLaporan, $target, $tab='rs',$variabel=array()){
      $format = new MyFormatter();
      $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
      if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
          $this->layout = '//layouts/printWindows3';
          $this->render($target, array('model' => $model,'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' =>$tab, 'variabel'=>$variabel));    
      } else if ($caraPrint == 'EXCEL') {
          $this->layout = '//layouts/printExcel';
          $this->render($target, array('model' => $model,'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' =>$tab, 'variabel'=>$variabel));    
      } else if ($_REQUEST['caraPrint'] == 'PDF') {
          $kertas = Params::getUkuranKertas();
          $mpdf = new MyPDF60('', $kertas['F4']);
          $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
          
          $mpdf->SetHTMLFooter($this->renderPartial('application.views.headerReport.footerLaporanBukuRegister', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 10), true));

          $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
          $mpdf->WriteHTML($stylesheet, 1);
          $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
          $mpdf->WriteHTML($stylesheet, 1);
          $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI_LANDSCAPE, '', '', '', '', 15, 15, 15, 30, 15, 15);
          $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' =>$tab, 'variabel'=>$variabel), true));
          $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
      }
    }

    /**
     * Load halaman Laporan Permenkes
     * @author Aida Rahmawati <aidarahmawati@.com>
     */
    public function actionLaporanPermenkes(){
      $model = new LaporanpermenkesbankdarahV();
      $this->render('laporanPermenkes/index', array(
          'model' => $model,
      ));
    } 
    
        /**
         * Digunakan untuk laporan daftar pendonor
         */
        public function actionLaporanDaftarPendonor() {
            
          $criteria = new CDbCriteria();
          $model = new BDLappenyadapandarahV();
          $format = new MyFormatter();
          $model->jns_periode = "hari";
          $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
          $model->tgl_akhir = date('Y-m-d');
          $model->bln_awal = date('Y-m', strtotime('first day of january'));
          $model->bln_akhir = date('Y-m');
          $model->thn_awal = date('Y');
          $model->thn_akhir = date('Y');
          if (isset($_GET['BDLappenyadapandarahV'])) {
              $model->attributes = $_GET['BDLappenyadapandarahV'];
              $model->jns_periode = $_GET['BDLappenyadapandarahV']['jns_periode'];
              $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLappenyadapandarahV']['tgl_awal']);
              $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLappenyadapandarahV']['tgl_akhir']);
              $model->bln_awal = $format->formatMonthForDb($_GET['BDLappenyadapandarahV']['bln_awal']);
              $model->bln_akhir = $format->formatMonthForDb($_GET['BDLappenyadapandarahV']['bln_akhir']);
              $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
              $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
              switch($model->jns_periode){
                  case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                  case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                  default : null;
              }
          }
          
          $criteria->addBetweenCondition('DATE(waktu_observasi)', $model->tgl_awal, $model->tgl_akhir);
          $criteria->select = 'pendonor_id';
          $criteria->addCondition('waktu_observasi is not null');
          $criteria->addCondition('donasi_ke != 0');
          $criteria->group = 'pendonor_id';
          $criteria->limit  = 10;
          $criteria->offset = !empty($_GET['page']) ? $_GET['page']+8 : 0;
          
          //Cari Data
          $modShow  = BDLappenyadapandarahV::model()->findAll($criteria);
          $count    = BDLappenyadapandarahV::model()->count($criteria);
          $pages    = new CPagination($count);
          
          // results per page
          $pages->pageSize=10;
          $pages->applyLimit($criteria);
                      
          $this->render('daftarpendonor/admin', array(
              'model' => $model,
              'modShow'=>$modShow,
              'pages' => $pages
          ));
        }
              
    public function actionPrintDaftarPendonor() {
      $criteria = new CDbCriteria();
      $model = new BDLappenyadapandarahV('searchPrint');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $judulLaporan = 'Laporan Daftar Pendonor';

      //Data Grafik
      $data['title'] = 'Grafik Laporan Daftar Pendonor';
      $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
      if (isset($_REQUEST['BDLappenyadapandarahV'])) {
          $model->attributes = $_REQUEST['BDLappenyadapandarahV'];
          $model->jns_periode = $_GET['BDLappenyadapandarahV']['jns_periode'];
          $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLappenyadapandarahV']['tgl_awal']);
          $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLappenyadapandarahV']['tgl_akhir']);
          $model->bln_awal = $format->formatMonthForDb($_GET['BDLappenyadapandarahV']['bln_awal']);
          $model->bln_akhir = $format->formatMonthForDb($_GET['BDLappenyadapandarahV']['bln_akhir']);
          $model->thn_awal = $_GET['BDLappenyadapandarahV']['thn_awal'];
          $model->thn_akhir = $_GET['BDLappenyadapandarahV']['thn_akhir'];
          $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
          $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
          switch($model->jns_periode){
              case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
              case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
              default : null;
          }
          $model->tgl_awal = $model->tgl_awal;
          $model->tgl_akhir = $model->tgl_akhir;
      }
      
          $criteria->addBetweenCondition('DATE(waktu_observasi)', $model->tgl_awal, $model->tgl_akhir);
          $criteria->select = 'pendonor_id';
          $criteria->addCondition('waktu_observasi is not null');
          $criteria->addCondition('donasi_ke != 0');
          $criteria->group = 'pendonor_id';
          
          //Cari Data
          $modShow  = BDLappenyadapandarahV::model()->findAll($criteria);
      
      $caraPrint = $_REQUEST['caraPrint'];
      $target = 'daftarpendonor/_print';
      
      $arr = array('modShow'=>$modShow);
      
      $this->printFunctionLandscape($model, $data, $caraPrint, $judulLaporan, $target, '',$arr);
    }
}
