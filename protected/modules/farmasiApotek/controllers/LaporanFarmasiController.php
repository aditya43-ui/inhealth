<?php

class LaporanFarmasiController extends MyAuthController
{
  //untuk range tanggal default
  public $tgl_awal = "d M Y";
  public $tgl_akhir = "d M Y";

  public function actionLaporanJasaServices()
  {
    $model = new FALaporanpejulanresepdokterV();
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if (isset($_GET['FALaporanpejulanresepdokterV'])) {
      $model->attributes = $_GET['FALaporanpejulanresepdokterV'];
      $model->jns_periode = $_GET['FALaporanpejulanresepdokterV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpejulanresepdokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpejulanresepdokterV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['FALaporanpejulanresepdokterV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['FALaporanpejulanresepdokterV']['bln_akhir']);
      $model->thn_awal = $_GET['FALaporanpejulanresepdokterV']['thn_awal'];
      $model->thn_akhir = $_GET['FALaporanpejulanresepdokterV']['thn_akhir'];
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
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }
    $grafik = $model->searchFrameGrafikJasaServices();
    $this->render('jasaServices/admin', array('model' => $model, 'grafik' => $grafik));
  }

  public function actionPrintLaporanJasaServices()
  {
    $model = new FALaporanpejulanresepdokterV();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    $judulLaporan = 'Laporan Jasa Services';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Jasa Services';
    $data['type'] = $_REQUEST['type'];
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['FALaporanpejulanresepdokterV'])) {
      $model->attributes = $_REQUEST['FALaporanpejulanresepdokterV'];
      $model->jns_periode = $_GET['FALaporanpejulanresepdokterV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpejulanresepdokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpejulanresepdokterV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['FALaporanpejulanresepdokterV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['FALaporanpejulanresepdokterV']['bln_akhir']);
      $model->thn_awal = $_GET['FALaporanpejulanresepdokterV']['thn_awal'];
      $model->thn_akhir = $_GET['FALaporanpejulanresepdokterV']['thn_akhir'];
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
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == "PRINTRINCIAN") {
      $caraPrint = 'PRINT';
      $data['rincian'] = true;
    }
    $target = 'jasaServices/_print';
    $grafik = $model->searchFrameGrafikJasaServices();

    $this->newPrintFunction($model, $data, $caraPrint, $judulLaporan, $target, $grafik);
  }

  public function actionFrameGrafikLaporanJasaServices()
  {
    $this->layout = '//layouts/iframe';
    $model = new FALaporanpejulanresepdokterV(); //FAPenjualanResepT
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    $data['title'] = 'Grafik Laporan Jasa Services';
    $data['type'] = $_GET['type'];
    $nilai = 1;
    if (isset($_GET['FAPenjualanResepT'])) {
      $model->attributes = $_GET['FALaporanpejulanresepdokterV'];
      $model->jns_periode = $_GET['FALaporanpejulanresepdokterV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpejulanresepdokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpejulanresepdokterV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['FALaporanpejulanresepdokterV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['FALaporanpejulanresepdokterV']['bln_akhir']);
      $model->thn_awal = $_GET['FALaporanpejulanresepdokterV']['thn_awal'];
      $model->thn_akhir = $_GET['FALaporanpejulanresepdokterV']['thn_akhir'];
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
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }
    $grafik = $model->searchFrameGrafikJasaServices();
    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data, 'nilai' => $nilai, 'grafik' => $grafik
    ));
  }

  public function actionLaporanPendapatanTransaksi()
  {
    $format = new MyFormatter();
    $model = new FALaporanpendapatanfarmasiV('searchTablePendapatanTransaksi');
    $model->unsetAttributes();
    $model->tgl_awal = $format->formatDateTimeForDb(date($this->tgl_awal));
    $model->tgl_akhir = $format->formatDateTimeForDb(date($this->tgl_akhir));

    if (isset($_GET['FALaporanpendapatanfarmasiV'])) {
      $model->attributes = $_GET['FALaporanpendapatanfarmasiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir']);
    }
    $this->render('pendapatanTransaksi/admin', array('model' => $model));
  }

  public function actionPrintLaporanPendapatanTransaksi()
  {
    $model = new FALaporanpendapatanfarmasiV();
    $judulLaporan = 'Laporan Pendapatan Farmasi Apotek';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Pendapatan Farmasi Apotek';
    $data['type'] = $_REQUEST['type'];
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['FALaporanpendapatanfarmasiV'])) {
      $model->attributes = $_REQUEST['FALaporanpendapatanfarmasiV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == "PRINTRINCIAN") {
      $caraPrint = 'PRINT';
      $data['rincian'] = true;
    }
    $target = 'pendapatanTransaksi/print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanPendapatanTransaksi()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = new FALaporanpendapatanfarmasiV();
    $model->tgl_awal = MyFormatter::formatDateTimeForDb(date($this->tgl_awal));
    $model->tgl_akhir = MyFormatter::formatDateTimeForDb(date($this->tgl_akhir));

    $data['title'] = 'Grafik Laporan Pendapatan Transaksi Farmasi Apotek';
    $data['type'] = $_GET['type'];

    if (isset($_GET['FALaporanpendapatanfarmasiV'])) {
      $model->attributes = $_GET['FALaporanpendapatanfarmasiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir']);
    }
    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data
    ));
  }

  public function actionLaporanPendapatanObatAlkes()
  {

    $model = new FALaporanpendapatanfarmasiV('searchTablePendapatanObatAlkes');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');


    if (isset($_GET['FALaporanpendapatanfarmasiV'])) {
      $model->attributes = $_GET['FALaporanpendapatanfarmasiV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['FALaporanpendapatanfarmasiV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['FALaporanpendapatanfarmasiV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['FALaporanpendapatanfarmasiV']['bln_akhir']);
      $model->thn_awal = $_GET['FALaporanpendapatanfarmasiV']['thn_awal'];
      $model->thn_akhir = $_GET['FALaporanpendapatanfarmasiV']['thn_akhir'];
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
    $this->render('pendapatanObatAlkes/admin', array('model' => $model));
  }

  public function actionPrintLaporanPendapatanObatAlkes()
  {
    $model = new FALaporanpendapatanfarmasiV();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    // $judulLaporan = 'Laporan Pendapatan Farmasi Apotek<h3> Jenis : ';
    $judulLaporan = 'Laporan Pendapatan Obat Alkes ';
    //$data['title'] = 'Grafik Laporan Pendapatan Farmasi Apotek <h3> Jenis : ';
    $data['title'] = 'Grafik Laporan Pendapatan Obat Alkes : ';
    //foreach($_REQUEST['FALaporanpendapatanfarmasiV']['jenisobatalkes_id'] AS $jenis){
    //  $judulLaporan .= JenisobatalkesM::model()->findByPk($jenis)->jenisobatalkes_nama.', ';
    // $data['title'] .= JenisobatalkesM::model()->findByPk($jenis)->jenisobatalkes_nama.', ';
    //}
    //Data Grafik       
    $data['type'] = $_REQUEST['type'];
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['FALaporanpendapatanfarmasiV'])) {
      $model->attributes = $_REQUEST['FALaporanpendapatanfarmasiV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['FALaporanpendapatanfarmasiV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['FALaporanpendapatanfarmasiV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['FALaporanpendapatanfarmasiV']['bln_akhir']);
      $model->thn_awal = $_GET['FALaporanpendapatanfarmasiV']['thn_awal'];
      $model->thn_akhir = $_GET['FALaporanpendapatanfarmasiV']['thn_akhir'];
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
    if ($caraPrint == "PRINTRINCIAN") {
      $caraPrint = 'PRINT';
      $data['rincian'] = true;
    }
    $target = 'pendapatanObatAlkes/print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }


  public function actionFrameGrafikLaporanPendapatanObatAlkes()
  {
    $this->layout = '//layouts/iframe';
    $model = new FALaporanpendapatanfarmasiV();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kategori Obat dan Alkes';
    $data['type'] = $_GET['type'];
    if (isset($_GET['FALaporanpendapatanfarmasiV'])) {
      $model->attributes = $_GET['FALaporanpendapatanfarmasiV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['FALaporanpendapatanfarmasiV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['FALaporanpendapatanfarmasiV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['FALaporanpendapatanfarmasiV']['bln_akhir']);
      $model->thn_awal = $_GET['FALaporanpendapatanfarmasiV']['thn_awal'];
      $model->thn_akhir = $_GET['FALaporanpendapatanfarmasiV']['thn_akhir'];
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

  public function actionHutangTitipanApotek()
  {
    //            if(!Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $format = new MyFormatter();
    $model = new FAHutangtitipanapotikV('searchLaporan');
    $model->unsetAttributes();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    if (isset($_GET['FAHutangtitipanapotikV'])) {
      $model->attributes = $_GET['FAHutangtitipanapotikV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FAHutangtitipanapotikV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FAHutangtitipanapotikV']['tgl_akhir']);
    }
    //            if(!empty($_GET['FAHutangtitipanapotikV']['tgl_awal']))
    //            {
    //                $model->tgl_awal = $format->formatDateTimeForDb($_GET['FAHutangtitipanapotikV']['tgl_awal']);
    //            }
    //            if(!empty($_GET['FAHutangtitipanapotikV']['tgl_awal']))
    //            {
    //                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FAHutangtitipanapotikV']['tgl_akhir']);
    //            }

    $this->render('hutangTitipanApotek/index', array(
      'model' => $model,
    ));
  }

  public function actionPrintHutangTitipanApotik()
  {
    //        $model = new FAHutangtitipanapotikV();
    //        $judulLaporan = 'Laporan Hutang Titipan Apotik';
    //
    //        //Data Grafik       
    //        $data['title'] = 'Grafik Laporan Hutang Titipan Apotik';
    //        $data['type'] = $_REQUEST['type'];
    //        $data['nama_pegawai']=LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai->nama_pegawai;
    //        if (isset($_REQUEST['FAHutangtitipanapotikV'])) {
    //           $model->attributes = $_REQUEST['FAHutangtitipanapotikV'];
    //            $format = new MyFormatter();
    //            $model->tgl_awal = $format->formatDateTimeForDb($_GET['FAHutangtitipanapotikV']['tgl_awal']);
    //            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FAHutangtitipanapotikV']['tgl_akhir']);
    //        }
    //       
    //        
    //        $caraPrint = $_REQUEST['caraPrint'];
    //        if ($caraPrint == "PRINTRINCIAN"){
    //            $caraPrint = 'PRINT';
    //            $data['rincian']= true;
    //        }
    //        $target = 'hutangTitipanApotek/Print';
    //        
    //        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);


    $format = new MyFormatter();
    $model = new FAHutangtitipanapotikV('searchLaporan');
    $judulLaporan = 'Laporan Hutang Titipan Apotik';
    //Data Grafik
    $data['title'] = 'Grafik Laporan Hutang Titipan Apotik';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['FAHutangtitipanapotikV'])) {
      $model->attributes = $_REQUEST['FAHutangtitipanapotikV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['FAHutangtitipanapotikV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['FAHutangtitipanapotikV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'hutangTitipanApotek/Print';

    $this->newPrintFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionLaporanPendapatanTotalFarmasi()
  {
    $format = new MyFormatter();
    $model = new FALaporanpendapatanfarmasiV('searchTableTotalPendapatanFarmasi');
    $model->unsetAttributes();
    $model->tgl_awal = $format->formatDateTimeForDb(date($this->tgl_awal));
    $model->tgl_akhir = $format->formatDateTimeForDb(date($this->tgl_akhir));

    if (isset($_GET['FALaporanpendapatanfarmasiV'])) {
      $model->attributes = $_GET['FALaporanpendapatanfarmasiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir']);
    }

    if(Yii::app()->request->isAjaxRequest) {
      if(isset($_GET['ajax']) && $_GET['ajax'] == 'tableLaporan') {
        $this->renderPartial('totalPendapatanFarmasi/_table', array('model' => $model));
        Yii::app()->end();
      }
    }
    $this->render('totalPendapatanFarmasi/admin', array('model' => $model));
  }

  public function actionLaporanPendapatanTotalFarmasi_old()
  { //jangan di hapus
    $model = new FALaporanpendapatanfarmasiV('search');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');
    if (isset($_GET['FALaporanpendapatanfarmasiV'])) {
      $model->attributes = $_GET['FALaporanpendapatanfarmasiV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir']);
    }
    $models = $model->findAll($model->searchTableTotalPendapatan());
    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial(
        'farmasiApotek.laporanFarmasi.LaporanPendapatanTotalFarmasi_table',
        array(
          'model' => $model,
          'models' => $models,
        ),
        true
      );
    } else {
      $this->render('totalPendapatanFarmasi/admin', array(
        'model' => $model,
        'models' => $models,
        'filter' => $filter
      ));
    }
  }


  public function actionPrintLaporanPendapatanTotalFarmasi()
  {
    $model = new FALaporanpendapatanfarmasiV();
    $judulLaporan = 'Laporan Total Pendapatan Farmasi';
    $data['title'] = 'Grafik Laporan Pendapatan Farmasi Apotek';
    // foreach($_REQUEST['FALaporanpendapatanfarmasiV']['jenisobatalkes_id'] AS $jenis){
    //     $judulLaporan .= JenisobatalkesM::model()->findByPk($jenis)->jenisobatalkes_nama.', ';
    //     $data['title'] .= JenisobatalkesM::model()->findByPk($jenis)->jenisobatalkes_nama.', ';
    // }
    //Data Grafik       
    $data['type'] = $_REQUEST['type'];
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['FALaporanpendapatanfarmasiV'])) {
      $model->attributes = $_REQUEST['FALaporanpendapatanfarmasiV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == "PRINTRINCIAN") {
      $caraPrint = 'PRINT';
      $data['rincian'] = true;
    }
    $target = 'totalPendapatanFarmasi/print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionLaporanPemakaianKategoriObat()
  {
    $this->pageTitle = Yii::app()->name . " - Pemakaian Kategori Obat";
    $model = new FALaporanpenjualanobatV();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->tgl_awal = date("d M Y");
    $model->tgl_akhir = date("d M Y");

    //$kategori = CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>'obatalkes_kategori')),'lookup_value','lookup_name');

    //$model->obatalkes_kategori = $kategori;

    if (isset($_GET['FALaporanpenjualanobatV'])) {
      $model->attributes = $_GET['FALaporanpenjualanobatV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['FALaporanpenjualanobatV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpenjualanobatV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpenjualanobatV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['FALaporanpenjualanobatV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['FALaporanpenjualanobatV']['bln_akhir']);
      $model->thn_awal = $_GET['FALaporanpenjualanobatV']['thn_awal'];
      $model->thn_akhir = $_GET['FALaporanpenjualanobatV']['thn_akhir'];
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
    $this->render('pemakaianKategoriObat/admin', array('model' => $model));
  }

  public function actionPrintLaporanPemakaianKategoriObat()
  {
    $model = new FALaporanpenjualanobatV();
    $judulLaporan = 'Laporan Kategori Obat Alkes';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Kategori Obat Alkes';
    $data['type'] = $_REQUEST['type'];
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['FALaporanpenjualanobatV'])) {
      $model->attributes = $_REQUEST['FALaporanpenjualanobatV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['FALaporanpenjualanobatV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['FALaporanpenjualanobatV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == "PRINTRINCIAN") {
      $caraPrint = 'PRINT';
      $data['rincian'] = true;
    }
    $target = 'pemakaianKategoriObat/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanPemakaianKategoriObat()
  {
    $this->layout = '//layouts/iframe';
    $model = new FALaporanpenjualanobatV();
    $model->tgl_awal = date($this->tgl_awal);
    $model->tgl_akhir = date($this->tgl_akhir);

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kategori Obat dan Alkes';
    $data['type'] = $_GET['type'];
    if (isset($_GET['FALaporanpenjualanobatV'])) {
      $model->attributes = $_GET['FALaporanpenjualanobatV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpenjualanobatV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpenjualanobatV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanPenjualanObat()
  {
    $model = new FALaporanpenjualanobatV();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = true'), 'penjamin_id', 'penjamin_id');
    $ruangan = CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'), 'ruangan_nama', 'ruangan_nama');
    // $model->penjamin_id = $penjamin;
    // $model->ruanganasal_nama = $ruangan;                
    if (isset($_GET['FALaporanpenjualanobatV'])) {
      //$model->penjamin_id = $penjamin;
      //$model->ruanganasal_nama = $ruangan;
      $model->jenispenjualan = isset($_GET['FALaporanpenjualanobatV']['jenispenjualan']) ? $_GET['FALaporanpenjualanobatV']['jenispenjualan'] : null;
      $model->statusbayar = isset($_GET['FALaporanpenjualanobatV']['statusbayar']) ? $_GET['FALaporanpenjualanobatV']['statusbayar'] : null;
      $model->attributes = $_GET['FALaporanpenjualanobatV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['FALaporanpenjualanobatV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpenjualanobatV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpenjualanobatV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['FALaporanpenjualanobatV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['FALaporanpenjualanobatV']['bln_akhir']);
      $model->thn_awal = $_GET['FALaporanpenjualanobatV']['thn_awal'];
      $model->thn_akhir = $_GET['FALaporanpenjualanobatV']['thn_akhir'];
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
    $this->render('penjualanObat/admin', array('model' => $model));
  }

  public function actionPrintLaporanPenjualanObat()
  {
    $model = new FALaporanpenjualanobatV('search');
    $model->unsetAttributes();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = true'), 'penjamin_id', 'penjamin_id');
    $ruangan = CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'), 'ruangan_nama', 'ruangan_nama');
    // $model->penjamin_id = $penjamin;
    // $model->ruanganasal_nama = $ruangan;
    $judulLaporan = 'Laporan Penjualan Pasien Obat dan Alkes';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Penjualan Jenis Obat Alkes';
    $data['type'] = $_REQUEST['type'];
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['FALaporanpenjualanobatV'])) {
      $model->attributes = $_REQUEST['FALaporanpenjualanobatV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['FALaporanpenjualanobatV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['FALaporanpenjualanobatV']['tgl_akhir']);
      $model->jenispenjualan = isset($_GET['FALaporanpenjualanobatV']['jenispenjualan']) ? $_GET['FALaporanpenjualanobatV']['jenispenjualan'] : null;
      $model->statusbayar = isset($_GET['FALaporanpenjualanobatV']['statusbayar']) ? $_GET['FALaporanpenjualanobatV']['statusbayar'] : null;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == "PRINTRINCIAN") {
      $caraPrint = 'PRINT';
      $data['rincian'] = true;
    }
    $target = 'penjualanObat/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }


  public function actionFrameGrafikLaporanPenjualanObat()
  {
    $this->layout = '//layouts/iframe';
    $model = new FALaporanpenjualanobatV('searchGrafik');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $nilai = 2;
    //Data Grafik
    $data['title'] = 'Grafik Laporan Penjualan Pasien Obat dan Alkes';
    $data['type'] = $_GET['type'];
    if (isset($_GET['FALaporanpenjualanobatV'])) {
      $model->attributes = $_GET['FALaporanpenjualanobatV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpenjualanobatV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpenjualanobatV']['tgl_akhir']);
      $model->jenispenjualan = isset($_GET['FALaporanpenjualanobatV']['jenispenjualan']) ? $_GET['FALaporanpenjualanobatV']['jenispenjualan'] : null;
      $model->statusbayar = isset($_GET['FALaporanpenjualanobatV']['statusbayar']) ? $_GET['FALaporanpenjualanobatV']['statusbayar'] : null;
      // echo '<pre>'; print_r($_GET['FALaporanpenjualanobatV']);exit()];
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
      'nilai' => $nilai,
    ));
  }

  public function actionLaporanPenjualanJenisoa()
  {
    $this->pageTitle = Yii::app()->name . " - Penjualan Jenis Obat Alkes";
    $model = new FALaporanpenjualanjenisoaV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $jenis = CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif = true'), 'jenisobatalkes_id', 'jenisobatalkes_id');
    $model->jenisobatalkes_id = $jenis;
    if (isset($_GET['FALaporanpenjualanjenisoaV'])) {
      $model->attributes = $_GET['FALaporanpenjualanjenisoaV'];
      //$format = new MyFormatter();
      $model->jenisobatalkes_id = $jenis;
      $model->jns_periode = $_GET['FALaporanpenjualanjenisoaV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpenjualanjenisoaV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpenjualanjenisoaV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['FALaporanpenjualanjenisoaV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['FALaporanpenjualanjenisoaV']['bln_akhir']);
      $model->thn_awal = $_GET['FALaporanpenjualanjenisoaV']['thn_awal'];
      $model->thn_akhir = $_GET['FALaporanpenjualanjenisoaV']['thn_akhir'];
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
    $this->render('penjualanJenisoa/admin', array('model' => $model));
  }

  public function actionPrintLaporanPenjualanJenisoa()
  {
    $model = new FALaporanpenjualanjenisoaV('search');
    $judulLaporan = 'Laporan Penjualan Jenis Obat dan Alkes';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Penjualan Jenis Obat Alkes';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['FALaporanpenjualanjenisoaV'])) {
      $model->attributes = $_REQUEST['FALaporanpenjualanjenisoaV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['FALaporanpenjualanjenisoaV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['FALaporanpenjualanjenisoaV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == "PRINTRINCIAN") {
      $caraPrint = 'PRINT';
      $data['rincian'] = true;
    }
    $target = 'penjualanJenisoa/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }


  public function actionFrameGrafikLaporanPenjualanJenisoa()
  {
    $this->layout = '//layouts/iframe';
    $model = new FALaporanpenjualanjenisoaV('search');
    $model->tgl_awal = date($this->tgl_awal);
    $model->tgl_akhir = date($this->tgl_akhir);
    $nilai = 1;
    //Data Grafik
    $data['title'] = 'Grafik Laporan Penjualan Jenis Obat dan Alkes';
    $data['type'] = $_GET['type'];
    if (isset($_GET['FALaporanpenjualanjenisoaV'])) {
      $model->attributes = $_GET['FALaporanpenjualanjenisoaV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpenjualanjenisoaV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpenjualanjenisoaV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
      'nilai' => $nilai,
    ));
  }

  public function actionLaporanPenjualanLembarResep()
  {
    $model = new FALaporanlembarresepV();
    $model->unsetAttributes();
    $model->tgl_awal = date($this->tgl_awal);
    $model->tgl_akhir = date($this->tgl_akhir);
    $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = true'), 'penjamin_id', 'penjamin_id');
    $ruangan = CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'), 'ruangan_nama', 'ruangan_nama');
    $model->penjamin_id = $penjamin;
    $model->ruanganasal_nama = $ruangan;
    if (isset($_GET['FALaporanlembarresepV'])) {
      $model->attributes = $_GET['FALaporanlembarresepV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanlembarresepV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanlembarresepV']['tgl_akhir']);
    }
    $this->render('lembarResep/admin', array('model' => $model));
  }

  public function actionPrintLaporanPenjualanLembarResep()
  {
    $model = new FALaporanlembarresepV('search');
    $judulLaporan = 'Laporan Penjualan Lembar Resep';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Penjualan Lembar Resep';
    $data['type'] = $_REQUEST['type'];
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['FALaporanlembarresepV'])) {
      $model->attributes = $_REQUEST['FALaporanlembarresepV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['FALaporanlembarresepV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['FALaporanlembarresepV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == "PRINTRINCIAN") {
      $caraPrint = 'PRINT';
      $data['rincian'] = true;
    }
    $target = 'lembarResep/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }


  public function actionFrameGrafikLaporanPenjualanLembarResep()
  {
    $this->layout = '//layouts/iframe';
    $model = new FALaporanlembarresepV('search');
    $model->tgl_awal = date($this->tgl_awal);
    $model->tgl_akhir = date($this->tgl_akhir);

    //Data Grafik
    $data['title'] = 'Grafik Laporan Penjualan Lembar Resep';
    $data['type'] = $_GET['type'];
    if (isset($_GET['FALaporanlembarresepV'])) {
      $model->attributes = $_GET['FALaporanlembarresepV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanlembarresepV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanlembarresepV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  // Added Laporan Stok Obat Farmasi on March, 6 2013 //
  public function actionLaporanStockFarmasi()
  {
    $this->pageTitle = Yii::app()->name . " - Stok";
    $model = new FAInfostokobatalkesruanganV;
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $model->qtystok_in = '0';
    $model->qtystok_out = '0';
    if (isset($_GET['FAInfostokobatalkesruanganV'])) {
      $format = new MyFormatter;
      $model->attributes = $_GET['FAInfostokobatalkesruanganV'];
      // $model->tgl_awal = $format->formatDateTimeForDb($_GET['FAInfostokobatalkesruanganV']['tgl_awal']);
      // $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInfostokobatalkesruanganV']['tgl_akhir']);
      $model->lookup_name = isset($_GET['FAInfostokobatalkesruanganV']['lookup_name']) ? $_GET['FAInfostokobatalkesruanganV']['lookup_name'] : null;
      if (isset($_GET['FAInfostokobatalkesruanganV']['qtystok_in'])) {
        $model->qtystok_in = $_GET['FAInfostokobatalkesruanganV']['qtystok_in'];
      } else {
        $model->qtystok_in = null;
      }
      if (isset($_GET['FAInfostokobatalkesruanganV']['qtystok_out'])) {
        $model->qtystok_out  = $_GET['FAInfostokobatalkesruanganV']['qtystok_out'];
      } else {
        $model->qtystok_out = null;
      }
    }
    $this->render('stock/stock', array(
      'model' => $model,
    ));
  }

  public function actionPrintStock()
  {
    $model = new FAInfostokobatalkesruanganV;
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $judulLaporan = 'Laporan Stock Obat dan Alkes';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Stock Obat dan Alkes';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['FAInfostokobatalkesruanganV'])) {
      $format = new MyFormatter;
      $model->attributes = $_GET['FAInfostokobatalkesruanganV'];
      // $model->tgl_awal = $format->formatDateTimeForDb($_GET['FAInfostokobatalkesruanganV']['tgl_awal']);
      // $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInfostokobatalkesruanganV']['tgl_akhir']);
    }
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    $target = 'stock/printStock';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameStockFarmasi()
  {
    $this->layout = '//layouts/iframe';

    $model = new FAInfostokobatalkesruanganV('searchGrafik');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $model->qtystok_in = '0';
    $model->qtystok_out = '0';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Stock Obat dan Alkes';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_REQUEST['FAInfostokobatalkesruanganV'])) {
      $format = new MyFormatter;
      $model->attributes = $_GET['FAInfostokobatalkesruanganV'];
      // $model->tgl_awal = $format->formatDateTimeForDb($_GET['FAInfostokobatalkesruanganV']['tgl_awal']);
      // $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInfostokobatalkesruanganV']['tgl_akhir']);

      if (isset($_GET['FAInfostokobatalkesruanganV']['qtystok_in'])) {
        $model->qtystok_in = $_GET['FAInfostokobatalkesruanganV']['qtystok_in'];
      } else {
        $model->qtystok_in = null;
      }
      if (isset($_GET['FAInfostokobatalkesruanganV']['qtystok_out'])) {
        $model->qtystok_out  = $_GET['FAInfostokobatalkesruanganV']['qtystok_out'];
      } else {
        $model->qtystok_out = null;
      }
    }
    $searchdata = $model->searchGrafik();
    $this->render('stock/_grafik', array(
      'model' => $model,
      'data' => $data,
      'searchdata' => $searchdata,
    ));
  }

  // End Added Laporan Stok Obat Farmasi //


  // Added Laporan minimal Stok Obat Farmasi//
  public function actionLaporanMinimalStockFarmasi()
  {
    $model = new FAInformasistokobatalkesV;
    //                        $model->tgl_awal = date('d M Y');
    //                        $model->tgl_akhir = date('d M Y');
    //                        $model->qtystok_in = '0';
    //                        $model->qtystok_out = '0';
    if (isset($_GET['FAInformasistokobatalkesV'])) {
      $format = new MyFormatter;
      $model->attributes = $_GET['FAInformasistokobatalkesV'];
      // $model->tgl_awal = $format->formatDateTimeForDb($_GET['FAInfostokobatalkesruanganV']['tgl_awal']);
      // $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInfostokobatalkesruanganV']['tgl_akhir']);


    }
    $this->render('minimalStock/minimalStock', array(
      'model' => $model,
    ));
  }

  public function actionPrintMinimalStock()
  {
    $model = new FAInformasistokobatalkesV;
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $judulLaporan = 'Laporan Minimal Stock Obat dan Alkes';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Minimal Stock Obat dan Alkes';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['FAInformasistokobatalkesV'])) {
      $format = new MyFormatter;
      $model->attributes = $_GET['FAInformasistokobatalkesV'];
      // $model->tgl_awal = $format->formatDateTimeForDb($_GET['FAInfostokobatalkesruanganV']['tgl_awal']);
      // $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInfostokobatalkesruanganV']['tgl_akhir']);
    }
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    $target = 'minimalStock/printMinimalStock';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameMinimalStockFarmasi()
  {
    $this->layout = '//layouts/iframe';

    $model = new FAInformasistokobatalkesV('searchGrafikMinimalStock');
    //            $model->tgl_awal = date('d M Y');
    //			$model->tgl_akhir = date('d M Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Minimal Stock Obat dan Alkes';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_REQUEST['FAInformasistokobatalkesV'])) {
      $format = new MyFormatter;
      $model->attributes = $_GET['FAInformasistokobatalkesV'];
      // $model->tgl_awal = $format->formatDateTimeForDb($_GET['FAInfostokobatalkesruanganV']['tgl_awal']);
      // $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInfostokobatalkesruanganV']['tgl_akhir']);



    }
    $searchdata = $model->searchGrafikMinimalStock();
    $this->render('minimalStock/_grafik', array(
      'model' => $model,
      'data' => $data,
      'searchdata' => $searchdata,
    ));
  }

  // End Added Laporan minimal Stok Obat Farmasi //   

  /* laporan retur obat */
  public function actionLaporanReturObat()
  {
    $this->pageTitle = Yii::app()->name . " - Retur Obat";
    $model = new FALaporanreturobatV();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['FALaporanreturobatV'])) {
      $model->attributes = $_GET['FALaporanreturobatV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['FALaporanreturobatV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanreturobatV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanreturobatV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['FALaporanreturobatV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['FALaporanreturobatV']['bln_akhir']);
      $model->thn_awal = $_GET['FALaporanreturobatV']['thn_awal'];
      $model->thn_akhir = $_GET['FALaporanreturobatV']['thn_akhir'];
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

      if (isset($_GET['FALaporanreturobatV']['no_rekam_medik'])) {
        $model->no_rekam_medik = $_GET['FALaporanreturobatV']['no_rekam_medik'];
      }
      if (isset($_GET['FALaporanreturobatV']['nama_pasien'])) {
        $model->nama_pasien = trim($_GET['FALaporanreturobatV']['nama_pasien']);
      }
      if (isset($_GET['FALaporanreturobatV']['no_pendaftaran'])) {
        $model->no_pendaftaran = trim($_GET['FALaporanreturobatV']['no_pendaftaran']);
      }
    }
    $this->render('returObat/admin', array('model' => $model));
  }

  public function actionPrintLaporanReturObat()
  {
    $model = new FALaporanreturobatV();
    $judulLaporan = 'Laporan Retur Obat';
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    //Data Grafik       
    $data['title'] = 'Grafik Laporan Retur Obat';
    if (isset($_REQUEST['type'])) {
      $data['type'] = $_REQUEST['type'];
    } else {
      $data['type'] = null;
    }
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['FALaporanreturobatV'])) {
      $model->attributes = $_REQUEST['FALaporanreturobatV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['FALaporanreturobatV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['FALaporanreturobatV']['tgl_akhir']);
      if (isset($_GET['FALaporanreturobatV']['no_rekam_medik'])) {
        $model->no_rekam_medik = $_REQUEST['FALaporanreturobatV']['no_rekam_medik'];
      }
      if (isset($_GET['FALaporanreturobatV']['nama_pasien'])) {
        $model->nama_pasien = trim($_REQUEST['FALaporanreturobatV']['nama_pasien']);
      }
      if (isset($_GET['FALaporanreturobatV']['no_pendaftaran'])) {
        $model->no_pendaftaran = trim($_REQUEST['FALaporanreturobatV']['no_pendaftaran']);
      }
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'returObat/_printReturObat';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikReturObat()
  {
    $this->layout = '//layouts/iframe';
    $model = new FALaporanreturobatV();
    $model->tgl_awal = date('Y-m-d H:i:s');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    $data['title'] = 'Grafik Laporan Retur Obat';
    $data['type'] = $_GET['type'];
    $nilai = 1;
    if (isset($_GET['FALaporanreturobatV'])) {
      $model->attributes = $_GET['FALaporanreturobatV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanreturobatV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanreturobatV']['tgl_akhir']);
      if (isset($_GET['FALaporanreturobatV']['no_rekam_medik'])) {
        $model->no_rekam_medik = $_GET['FALaporanreturobatV']['no_rekam_medik'];
      }
      if (isset($_GET['FALaporanreturobatV']['nama_pasien'])) {
        $model->nama_pasien = trim($_GET['FALaporanreturobatV']['nama_pasien']);
      }
      if (isset($_GET['FALaporanreturobatV']['no_pendaftaran'])) {
        $model->no_pendaftaran = trim($_GET['FALaporanreturobatV']['no_pendaftaran']);
      }
    }
    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data, 'nilai' => $nilai
    ));
  }
  /* end laporan retur obat */

  /* laporan stock opname */
  public function actionLaporanStockOpname()
  {
    $this->pageTitle = Yii::app()->name . " - Stok Opname";
    $model = new FALaporanfarmasikopnameV();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->jenisobatalkes_id = 1;

    if (isset($_GET['FALaporanfarmasikopnameV'])) {
      $model->unsetAttributes();
      $model->attributes = $_GET['FALaporanfarmasikopnameV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['FALaporanfarmasikopnameV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanfarmasikopnameV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanfarmasikopnameV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['FALaporanfarmasikopnameV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['FALaporanfarmasikopnameV']['bln_akhir']);
      $model->thn_awal = $_GET['FALaporanfarmasikopnameV']['thn_awal'];
      $model->thn_akhir = $_GET['FALaporanfarmasikopnameV']['thn_akhir'];
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
      $model->jenisobatalkes_id = $_GET['FALaporanfarmasikopnameV']['jenisobatalkes_id'];
    }

    $this->render('stockOpname/admin', array(
      'model' => $model,
    ));
  }

  public function actionPrintLaporanStockOpname()
  {
    $model = new FALaporanfarmasikopnameV('search');
    $judulLaporan = 'Laporan Stock Opname';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Stock Opname';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_REQUEST['FALaporanfarmasikopnameV'])) {
      $model->attributes = $_REQUEST['FALaporanfarmasikopnameV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['FALaporanfarmasikopnameV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['FALaporanfarmasikopnameV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'stockOpname/_printStockOpname';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikStockOpname()
  {
    $this->layout = '//layouts/iframe';
    $model = new FALaporanfarmasikopnameV('search');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y 23:59:59');

    //Data Grafik
    $data['title'] = 'Grafik Stock Opname';
    $data['type'] = $_GET['type'];
    if (isset($_GET['FALaporanfarmasikopnameV'])) {
      $model->attributes = $_GET['FALaporanfarmasikopnameV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanfarmasikopnameV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanfarmasikopnameV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  /* end laporan stock opname */
  /* ============================= Keperluan function laporan ======================================== */
  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target, $grafik = null)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows2';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $footer = '<table width="100%"><tr>'
        . '<td style = "text-align:left;font-size:8px;"><i><b>Generated By Ehealthsys</b></i></td>'
        . '<td style = "text-align:right;font-size:8px;"><i><b>Print Count :</b></i></td>'
        . '</tr></table>';
      $mpdf->SetHtmlFooter($footer, 'E');
      $mpdf->SetHtmlFooter($footer, 'O');
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 20, 20, 15, 30, 20, 20);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('d-m-Y') . '.pdf', 'I');
    }
  }

  protected function newPrintFunction($model, $data, $caraPrint, $judulLaporan, $target, $grafik = null)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeId($model->tgl_awal) . ' s/d ' . $format->formatDateTimeId($model->tgl_akhir);

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows2';
      $this->render($target, array('grafik' => $grafik, 'model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $footer = '<table width="100%"><tr>'
        . '<td style = "text-align:left;font-size:8px;"><i><b>Generated By Ehealthsys</b></i></td>'
        . '<td style = "text-align:right;font-size:8px;"><i><b>Print Count :</b></i></td>'
        . '</tr></table>';
      $mpdf->SetHtmlFooter($footer, 'E');
      $mpdf->SetHtmlFooter($footer, 'O');
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('d-m-Y') . '.pdf', 'I');
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
  /**
   * actionLaporanJasaRacikan untuk laporan jasa racik
   */
  public function actionLaporanJasaRacikan()
  {
    $format = new MyFormatter();
    $model = new FAPenjualanResepT();
    // $model->unsetAttributes();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['FAPenjualanResepT'])) {
      $model->attributes = $_GET['FAPenjualanResepT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FAPenjualanResepT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FAPenjualanResepT']['tgl_akhir']);
    }
    $this->render('jasaRacikan/admin', array('model' => $model));
  }
  /**
   * actionLaporanJasaRacikan untuk laporan jasa racikan
   */
  public function actionPrintLaporanJasaRacikan()
  {
    $model = new FAPenjualanResepT();
    $judulLaporan = 'Laporan Jasa Racikan';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Jasa Services';
    $data['type'] = $_REQUEST['type'];
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['FAPenjualanResepT'])) {
      $model->attributes = $_REQUEST['FAPenjualanResepT'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FAPenjualanResepT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FAPenjualanResepT']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == "PRINTRINCIAN") {
      $caraPrint = 'PRINT';
      $data['rincian'] = true;
    }
    $target = 'jasaRacikan/_print';

    $this->newPrintFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }
  /**
   * actionLaporanJasaDokter untuk laporan jasa dokter resep
   */
  public function actionLaporanJasaDokter()
  {
    $format = new MyFormatter();
    $model = new FAPenjualanResepT('searchPrintJasaRacikan');
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    //   $model->ruangan_id = Yii::app()->user->getState('ruangan_id'); 

    if (isset($_GET['FAPenjualanResepT'])) {
      // $model->ruangan_id = Yii::app()->user->getState('ruangan_id'); 
      $model->attributes = $_GET['FAPenjualanResepT'];
      $model->jns_periode = $_GET['FAPenjualanResepT']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FAPenjualanResepT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FAPenjualanResepT']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['FAPenjualanResepT']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['FAPenjualanResepT']['bln_akhir']);
      $model->thn_awal = $_GET['FAPenjualanResepT']['thn_awal'];
      $model->thn_akhir = $_GET['FAPenjualanResepT']['thn_akhir'];
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
      $model->namaPegawai = $_GET['FAPenjualanResepT']['dokter'];
    }
    $this->render('jasaDokter/admin', array('model' => $model));
  }
  /**
   * actionPrintLaporanJasaDokter untuk laporan jasa dokter
   */
  public function actionPrintLaporanJasaDokter()
  {
    $format = new MyFormatter();
    $model = new FAPenjualanResepT();
    $judulLaporan = 'Laporan Jasa Dokter Resep';
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    // $model->ruangan_id = Yii::app()->user->getState('ruangan_id'); 

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Jasa Dokter Resep';
    $data['type'] = $_REQUEST['type'];
    $peg = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
    $data['nama_pegawai'] = !empty($peg->pegawai_id) ? $peg->pegawai->nama_pegawai : Yii::app()->user->getState('nama_pemakai');
    if (isset($_REQUEST['FAPenjualanResepT'])) {
      $model->attributes = $_REQUEST['FAPenjualanResepT'];
      //$model->ruangan_id = Yii::app()->user->getState('ruangan_id'); 
      $model->attributes = $_GET['FAPenjualanResepT'];
      $model->jns_periode = $_GET['FAPenjualanResepT']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FAPenjualanResepT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FAPenjualanResepT']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['FAPenjualanResepT']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['FAPenjualanResepT']['bln_akhir']);
      $model->thn_awal = $_GET['FAPenjualanResepT']['thn_awal'];
      $model->thn_akhir = $_GET['FAPenjualanResepT']['thn_akhir'];
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
      $model->namaPegawai = $_GET['FAPenjualanResepT']['dokter'];
    }

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == "PRINTRINCIAN") {
      $caraPrint = 'PRINT';
      $data['rincian'] = true;
    } else {
      $data['rincian'] = false;
    }
    $target = 'jasaDokter/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * untuk mencari pegawai pada laporan
   */

  public function actionListPegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      if (isset($_GET['term'])) {
        $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      }
      //$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
      $criteria->order = 'nama_pegawai';
      $models = PegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionGetRuanganAsalNamaForCheckBox($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = $_POST["$namaModel"]['instalasiasal_nama'];

      if ($encode) {
        echo CJSON::encode($ruangan);
      } else {
        if (empty($instalasi_id)) {
        } else {
          $criteria = new CDbCriteria();
          $criteria->with = 'instalasi';
          $criteria->compare('LOWER(instalasi.instalasi_nama)', strtolower($instalasi_id), true);
          $ruangan = RuanganM::model()->findAll($criteria);
        }
        $ruangan = CHtml::listData($ruangan, 'ruangan_nama', 'ruangan_nama');
        echo CHtml::hiddenField('' . $namaModel . '[ruanganasal_nama]');
        $i = 0;
        if (count((array)$ruangan) > 0) {
          foreach ($ruangan as $value => $name) {
            //                        echo '<label class="checkbox">';
            //                        echo CHtml::checkBox(''.$namaModel."[ruangan_id][]", true, array('value'=>$value));
            //                        echo '<label for="'.$namaModel.'_ruangan_id_'.$i.'">'.$name.'</label>';
            //                        echo '</label>';
            $selects[] = $value;
            $i++;
          }
          echo CHtml::checkBoxList('' . $namaModel . "[ruanganasal_nama]", $selects, $ruangan, array('template' => '<label class="checkbox">{input}{label}</label>', 'separator' => ''));
        } else {
          echo '<label>Data Tidak Ditemukan</label>';
        }
      }
    }
    Yii::app()->end();
  }

  public function actionNarkotikaPsikotropika()
  {
    $this->pageTitle = Yii::app()->name . " - Narkotika / Psikotropika";
    $model = new FALaporanpenjualanjenisoaV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    //$jenis = CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif = true AND jenisobatalkes_id IN ('.Params::JENISOBATALKES_ID_NARKOTIKA.','.Params::JENISOBATALKES_ID_PSIKOTROPIKA.') '), 'jenisobatalkes_id','jenisobatalkes_id');
    //$model->jenisobatalkes_id = $jenis;
    if (isset($_GET['FALaporanpenjualanjenisoaV'])) {
      $model->attributes = $_GET['FALaporanpenjualanjenisoaV'];
      // $model->jenisobatalkes_id = $jenis;
      $model->jns_periode = $_GET['FALaporanpenjualanjenisoaV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpenjualanjenisoaV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpenjualanjenisoaV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['FALaporanpenjualanjenisoaV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['FALaporanpenjualanjenisoaV']['bln_akhir']);
      $model->thn_awal = $_GET['FALaporanpenjualanjenisoaV']['thn_awal'];
      $model->thn_akhir = $_GET['FALaporanpenjualanjenisoaV']['thn_akhir'];
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
    $this->render('narkotikaPsikotropika/admin', array('model' => $model));
  }

  public function actionPrintNarkotikaPsikotropika()
  {
    $model = new FALaporanpenjualanjenisoaV('search');
    $judulLaporan = 'LAPORAN NARKOTIKA DAN PSIKOTROPIKA';

    //Data Grafik       
    $data['title'] = 'GRAFIK LAPORAN NARKOTIKA DAN PSIKOTROPIKA';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['FALaporanpenjualanjenisoaV'])) {
      $model->attributes = $_REQUEST['FALaporanpenjualanjenisoaV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['FALaporanpenjualanjenisoaV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['FALaporanpenjualanjenisoaV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == "PRINTRINCIAN") {
      $caraPrint = 'PRINT';
      $data['rincian'] = true;
    }
    $target = 'narkotikaPsikotropika/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }


  public function actionFrameGrafikNarkotikaPsikotropika()
  {
    $this->layout = '//layouts/iframe';
    $model = new FALaporanpenjualanjenisoaV('search');
    // $model->tgl_awal = date($this->tgl_awal);
    // $model->tgl_akhir = date($this->tgl_akhir);
    //$nilai = 1;
    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN NARKOTIKA DAN PSIKOTROPIKA';
    $data['type'] = $_GET['type'];
    if (isset($_REQUEST['FALaporanpenjualanjenisoaV'])) {
      $model->attributes = $_REQUEST['FALaporanpenjualanjenisoaV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['FALaporanpenjualanjenisoaV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['FALaporanpenjualanjenisoaV']['tgl_akhir']);
    }

    $this->render('narkotikaPsikotropika/_grafik', array(
      'model' => $model,
      'data' => $data,

    ));
  }
}
