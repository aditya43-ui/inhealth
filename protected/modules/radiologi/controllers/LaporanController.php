	<?php
  Yii::import('laboratorium.models.LBLaporanpemeriksaanpenunjangV'); //untuk LaporanPemeriksaanPenunjang
  class LaporanController extends MyAuthController
  {
    public $pathViewLab = 'laboratorium.views.laporan.';

    public function actionLaporanPemeriksaanPenunjang()
    {
      $this->pageTitle = Yii::app()->name . " - Pemeriksaan";
      $judulLaporan = 'Laporan Jenis <b>Pemeriksaan Radiologi</b>';
      $model = new LBLaporanpemeriksaanpenunjangV('searchTableLaporan');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d', strtotime("first day of this month"));
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      if (isset($_GET['LBLaporanpemeriksaanpenunjangV'])) {
        $model->attributes = $_GET['LBLaporanpemeriksaanpenunjangV'];
        $model->jns_periode = $_GET['LBLaporanpemeriksaanpenunjangV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanpenunjangV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanpenunjangV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanpenunjangV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanpenunjangV']['bln_akhir']);
        $model->thn_awal = $_GET['LBLaporanpemeriksaanpenunjangV']['thn_awal'];
        $model->thn_akhir = $_GET['LBLaporanpemeriksaanpenunjangV']['thn_akhir'];
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

      $this->render('pemeriksaanPenunjang/adminPemeriksaanPenunjang', array(
        'model' => $model,
        'judulLaporan' => $judulLaporan,
      ));
    }

    public function actionPrintLaporanPemeriksaanPenunjang()
    {
      $model = new LBLaporanpemeriksaanpenunjangV('searchPrintLaporan');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $judulLaporan = 'Laporan Jenis Pemeriksaan Radiologi';
      // 

      //Data Grafik
      $data['title'] = 'Grafik Laporan Jenis Pemeriksaan Radiologi';
      $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
      if (isset($_REQUEST['LBLaporanpemeriksaanpenunjangV'])) {
        $model->attributes = $_REQUEST['LBLaporanpemeriksaanpenunjangV'];
        $model->jns_periode = $_GET['LBLaporanpemeriksaanpenunjangV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanpenunjangV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanpenunjangV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanpenunjangV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanpenunjangV']['bln_akhir']);
        $model->thn_awal = $_GET['LBLaporanpemeriksaanpenunjangV']['thn_awal'];
        $model->thn_akhir = $_GET['LBLaporanpemeriksaanpenunjangV']['thn_akhir'];
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
      $target = 'pemeriksaanPenunjang/_printPemeriksaanPenunjang';

      $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    /**
     * update nilai grafik garis dan speedo dari request ajax
     */
    public function actionUpdateGrafik()
    {
      if (Yii::app()->request->isAjaxRequest) {
        $model = new LBLaporanpemeriksaanpenunjangV();
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_POST['LBLaporanpemeriksaanpenunjangV'])) {
          $model->attributes = $_POST['LBLaporanpemeriksaanpenunjangV'];
          $model->jns_periode = $_GET['LBLaporanpemeriksaanpenunjangV']['jns_periode'];
          $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanpenunjangV']['tgl_awal']);
          $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanpenunjangV']['tgl_akhir']);
          $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanpenunjangV']['bln_awal']);
          $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanpenunjangV']['bln_akhir']);
          $model->thn_awal = $_GET['LBLaporanpemeriksaanpenunjangV']['thn_awal'];
          $model->thn_akhir = $_GET['LBLaporanpemeriksaanpenunjangV']['thn_akhir'];
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

    public function actionFrameGrafikPemeriksaanPenunjang()
    {
      $this->layout = '//layouts/iframe';
      $model = new LBLaporanpemeriksaanpenunjangV('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m', strtotime('first day of january'));
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      //Data Grafik
      $data['title'] = 'Grafik Laporan Jenis Pemeriksaan Radiologi';
      if (isset($_GET['type'])) {
        $data['type'] = $_GET['type'];
      } else {
        $data['type'] = null;
      }

      if (isset($_GET['LBLaporanpemeriksaanpenunjangV'])) {
        $model->attributes = $_GET['LBLaporanpemeriksaanpenunjangV'];
        $model->jns_periode = $_GET['LBLaporanpemeriksaanpenunjangV']['jns_periode'];
        $model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['LBLaporanpemeriksaanpenunjangV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['LBLaporanpemeriksaanpenunjangV']['tgl_akhir']);
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

    public function actionLaporanSensusHarian()
    {
      $this->pageTitle = Yii::app()->name . " - Sensus Harian";
      $model = new ROLaporansensusradiologiV('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d', strtotime("first day of this month"));
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');

      $jenis = CHtml::listData(PemeriksaanradM::model()->findAll('pemeriksaanrad_aktif = true'), 'pemeriksaanrad_id', 'pemeriksaanrad_id');
      $model->pemeriksaanrad_id = $jenis;
      $kunjungan = LookupM::getItems('kunjungan');
      $model->kunjungan = $kunjungan;

      if (isset($_GET['filter'])) {
        $model->pilihan = $_GET['filter'];
      }
      if (isset($_GET['ROLaporansensusradiologiV'])) {
        $model->attributes = $_GET['ROLaporansensusradiologiV'];
        $model->jns_periode = $_GET['ROLaporansensusradiologiV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporansensusradiologiV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporansensusradiologiV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporansensusradiologiV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporansensusradiologiV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporansensusradiologiV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporansensusradiologiV']['thn_akhir'];
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

      $this->render('sensus/index', array(
        'model' => $model,
      ));
    }

    public function actionGetPemeriksaanRad()
    {
      if (Yii::app()->request->isAjaxRequest) {
        $criteria = new CDbCriteria();
        if (isset($_GET['term'])) {
          $criteria->compare('LOWER(jenispemeriksaanrad.pemeriksaanrad_jenis)', strtolower($_GET['term']), true);
        }
        $criteria->order = 'jenispemeriksaanrad.pemeriksaanrad_jenis';
        $criteria->with = 'jenispemeriksaanrad';
        if (isset($_GET['idPemeriksaan'])) {
          if (!empty($_GET['idPemeriksaan'])) {
            $criteria->addCondition("t.pemeriksaanrad_id = " . $_GET['idPemeriksaan']);
          }
        }
        $models = PemeriksaanradM::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]['label'] = $model->pemeriksaanrad_jenis . " " . $model->pemeriksaanrad_nama;
            $returnVal[$i]['value'] = $model->pemeriksaanrad_id;
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
        }

        echo CJSON::encode($returnVal);
      }
      Yii::app()->end();
    }

    public function actionPrintLaporanSensusHarian()
    {
      $model = new ROLaporansensusradiologiV('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $judulLaporan = 'Laporan Sensus Harian Radiologi';

      //Data Grafik
      $data['title'] = 'Grafik Laporan Sensus Harian';
      $data['type'] = $_REQUEST['type'];
      $model->pilihan = $_GET['filter'];
      if (isset($_REQUEST['ROLaporansensusradiologiV'])) {
        $model->attributes = $_REQUEST['ROLaporansensusradiologiV'];
        $model->jns_periode = $_GET['ROLaporansensusradiologiV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporansensusradiologiV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporansensusradiologiV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporansensusradiologiV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporansensusradiologiV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporansensusradiologiV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporansensusradiologiV']['thn_akhir'];
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
      $target = 'sensus/_print';

      $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikSensusHarian()
    {
      $this->layout = '//layouts/iframe';
      $model = new ROLaporansensusradiologiV('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $model->pilihan = $_GET['filter'];
      //Data Grafik
      $data['title'] = 'Grafik Laporan Sensus Harian';
      $data['type'] = $_GET['type'];

      if (isset($_GET['ROLaporansensusradiologiV'])) {
        $model->attributes = $_GET['ROLaporansensusradiologiV'];
        $model->jns_periode = $_GET['ROLaporansensusradiologiV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporansensusradiologiV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporansensusradiologiV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporansensusradiologiV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporansensusradiologiV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporansensusradiologiV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporansensusradiologiV']['thn_akhir'];
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

    public function actionLaporanKunjungan()
    {
      $this->pageTitle = Yii::app()->name . " - Kunjungan Pasien";
      $model = new ROLaporanpasienpenunjangV('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d', strtotime("first day of this month"));
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      // $model->kunjungan = LookupM::getItems('kunjungan');

      if (isset($_GET['ROLaporanpasienpenunjangV'])) {
        $model->attributes = $_GET['ROLaporanpasienpenunjangV'];
        $model->jns_periode = $_GET['ROLaporanpasienpenunjangV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanpasienpenunjangV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanpasienpenunjangV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanpasienpenunjangV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanpasienpenunjangV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanpasienpenunjangV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanpasienpenunjangV']['thn_akhir'];
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

      $this->render('kunjungan/index', array(
        'model' => $model,
      ));
    }

    public function actionPrintLaporanKunjungan()
    {
      $model = new ROLaporanpasienpenunjangV('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $judulLaporan = 'Laporan Kunjungan Radiologi';

      //Data Grafik
      $data['title'] = 'Grafik Laporan Kunjungan Radiologi';
      $data['type'] = $_REQUEST['type'];
      if (isset($_REQUEST['ROLaporanpasienpenunjangV'])) {
        $model->attributes = $_REQUEST['ROLaporanpasienpenunjangV'];
        $model->jns_periode = $_GET['ROLaporanpasienpenunjangV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanpasienpenunjangV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanpasienpenunjangV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanpasienpenunjangV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanpasienpenunjangV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanpasienpenunjangV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanpasienpenunjangV']['thn_akhir'];
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
      $target = 'kunjungan/_print';

      $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikKunjungan()
    {
      $this->layout = '//layouts/iframe';
      $model = new ROLaporanpasienpenunjangV('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');

      //Data Grafik
      $data['title'] = 'Grafik Laporan Sensus Harian';
      $data['type'] = $_GET['type'];

      if (isset($_GET['ROLaporanpasienpenunjangV'])) {
        $model->attributes = $_GET['ROLaporanpasienpenunjangV'];
        $model->jns_periode = $_GET['ROLaporanpasienpenunjangV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanpasienpenunjangV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanpasienpenunjangV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanpasienpenunjangV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanpasienpenunjangV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanpasienpenunjangV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanpasienpenunjangV']['thn_akhir'];
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

    public function actionLaporan10BesarPenyakit()
    {
      $this->pageTitle = Yii::app()->name . " - 10 Besar Penyakit";
      $model = new ROLaporan10besarpenyakit('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d', strtotime("first day of this month"));
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m', strtotime('first day of january'));
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $model->jumlahTampil = 10;
      //$model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
      //$model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);

      if (isset($_GET['ROLaporan10besarpenyakit'])) {

        $model->attributes = $_GET['ROLaporan10besarpenyakit'];
        $model->jns_periode = $_GET['ROLaporan10besarpenyakit']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporan10besarpenyakit']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporan10besarpenyakit']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporan10besarpenyakit']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporan10besarpenyakit']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporan10besarpenyakit']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporan10besarpenyakit']['thn_akhir'];
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

      $this->render('10Besar/index', array(
        'model' => $model,
      ));
    }

    public function actionPrintLaporan10BesarPenyakit()
    {
      $model = new ROLaporan10besarpenyakit('search');
      $judulLaporan = 'Laporan 10 Besar Penyakit Pasien Radiologi';

      //Data Grafik
      $data['title'] = 'Grafik Laporan 10 Besar Penyakit Pasien Radiologi';
      $data['type'] = $_REQUEST['type'];
      if (isset($_REQUEST['ROLaporan10besarpenyakit'])) {
        $model->attributes = $_REQUEST['ROLaporan10besarpenyakit'];
        $format = new MyFormatter();
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['ROLaporan10besarpenyakit']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['ROLaporan10besarpenyakit']['tgl_akhir']);
      }

      $caraPrint = $_REQUEST['caraPrint'];
      $target = '10Besar/_print';

      $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafik10BesarPenyakit()
    {
      $this->layout = '//layouts/iframe';
      $model = new ROLaporan10besarpenyakit('search');
      $model->tgl_awal = date('Y-m-d 00:00:00');
      $model->tgl_akhir = date('Y-m-d H:i:s');

      //Data Grafik
      $data['title'] = 'Grafik Laporan 10 Besar Penyakit Radiologi';
      $data['type'] = $_GET['type'];
      if (isset($_GET['ROLaporan10besarpenyakit'])) {
        $model->attributes = $_GET['ROLaporan10besarpenyakit'];
        $format = new MyFormatter();
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporan10besarpenyakit']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporan10besarpenyakit']['tgl_akhir']);
      }

      $this->render('_grafik', array(
        'model' => $model,
        'data' => $data,
      ));
    }

    public function actionLaporanPemakaiObatAlkes()
    {
      $this->pageTitle = Yii::app()->name . " - Pemakaian Obat Alkes Ruangan";
      $model = new ROLaporanpemakaiobatalkesruanganV;
      $format = new MyFormatter();
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d', strtotime("first day of this month"));
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $jenisObat = CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif = true'), 'jenisobatalkes_id', 'jenisobatalkes_id');
      $model->jenisobatalkes_id = $jenisObat;
      if (isset($_GET['ROLaporanpemakaiobatalkesruanganV'])) {
        $model->attributes = $_GET['ROLaporanpemakaiobatalkesruanganV'];
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jns_periode = $_GET['ROLaporanpemakaiobatalkesruanganV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanpemakaiobatalkesruanganV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanpemakaiobatalkesruanganV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanpemakaiobatalkesruanganV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanpemakaiobatalkesruanganV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanpemakaiobatalkesruanganV']['thn_akhir'];
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
      $this->render('pemakaiObatAlkes/index', array('model' => $model));
    }

    public function actionPrintLaporanPemakaiObatAlkes()
    {
      $model = new ROLaporanpemakaiobatalkesruanganV('search');
      $format = new MyFormatter();
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $judulLaporan = 'Laporan Info Pemakai Obat Alkes Radiologi';

      //Data Grafik       
      $data['title'] = 'Grafik Laporan Pemakai Obat Alkes Radiologi';
      $data['type'] = $_REQUEST['type'];
      if (isset($_REQUEST['ROLaporanpemakaiobatalkesruanganV'])) {
        $model->attributes = $_REQUEST['ROLaporanpemakaiobatalkesruanganV'];
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jns_periode = $_GET['ROLaporanpemakaiobatalkesruanganV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanpemakaiobatalkesruanganV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanpemakaiobatalkesruanganV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanpemakaiobatalkesruanganV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanpemakaiobatalkesruanganV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanpemakaiobatalkesruanganV']['thn_akhir'];
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

      $caraPrint = $_REQUEST['caraPrint'];
      $target = 'pemakaiObatAlkes/_print';

      $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }


    public function actionFrameGrafikLaporanPemakaiObatAlkes()
    {
      $this->layout = '//layouts/iframe';
      $model = new ROLaporanpemakaiobatalkesruanganV('search');
      $format = new MyFormatter();
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');

      //Data Grafik
      $data['title'] = 'Grafik Laporan Pemakai Obat Alkes Radiologi';
      $data['type'] = $_GET['type'];
      if (isset($_GET['ROLaporanpemakaiobatalkesruanganV'])) {
        $model->attributes = $_GET['ROLaporanpemakaiobatalkesruanganV'];
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jns_periode = $_GET['ROLaporanpemakaiobatalkesruanganV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanpemakaiobatalkesruanganV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanpemakaiobatalkesruanganV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanpemakaiobatalkesruanganV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanpemakaiobatalkesruanganV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanpemakaiobatalkesruanganV']['thn_akhir'];
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

      $this->render('_grafik', array(
        'model' => $model,
        'data' => $data,
      ));
    }

    public function actionLaporanJasaInstalasi()
    {
      $model = new ROLaporanjasainstalasi('searchTable');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d', strtotime("first day of this month"));
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      // $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
      // $model->penjamin_id = $penjamin;
      $tindakan = array('sudah', 'belum');
      $model->tindakansudahbayar_id = $tindakan;
      //  $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
      //$model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);



      if (isset($_GET['ROLaporanjasainstalasi'])) {
        $model->attributes = $_GET['ROLaporanjasainstalasi'];
        $model->jns_periode = $_GET['ROLaporanjasainstalasi']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanjasainstalasi']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanjasainstalasi']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanjasainstalasi']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanjasainstalasi']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanjasainstalasi']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanjasainstalasi']['thn_akhir'];
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

      $this->render('jasaInstalasi/index', array(
        'model' => $model
      ));
    }

    public function actionPrintLaporanJasaInstalasi()
    {
      $model = new ROLaporanjasainstalasi('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $judulLaporan = 'Laporan Jasa Instalasi Radiologi';

      //Data Grafik
      $data['title'] = 'Grafik Laporan Jasa Instalasi';
      $data['type'] = $_REQUEST['type'];
      if (isset($_REQUEST['ROLaporanjasainstalasi'])) {
        $model->attributes = $_REQUEST['ROLaporanjasainstalasi'];
        $model->jns_periode = $_GET['ROLaporanjasainstalasi']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanjasainstalasi']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanjasainstalasi']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanjasainstalasi']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanjasainstalasi']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanjasainstalasi']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanjasainstalasi']['thn_akhir'];
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

      $caraPrint = $_REQUEST['caraPrint'];
      $target = 'jasaInstalasi/_print';

      $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanJasaInstalasi()
    {
      $this->layout = '//layouts/iframe';
      $model = new ROLaporanjasainstalasi('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');

      //Data Grafik
      $data['title'] = 'Grafik Laporan Jasa Instalasi';
      $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
      if (isset($_GET['ROLaporanjasainstalasi'])) {
        $model->attributes = $_GET['ROLaporanjasainstalasi'];
        $model->jns_periode = $_GET['ROLaporanjasainstalasi']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanjasainstalasi']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanjasainstalasi']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanjasainstalasi']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanjasainstalasi']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanjasainstalasi']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanjasainstalasi']['thn_akhir'];
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

      $this->render('_grafik', array(
        'model' => $model,
        'data' => $data,
      ));
    }

    public function actionLaporanBiayaPelayanan()
    {
      $model = new ROLaporanbiayapelayanan('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d', strtotime("first day of this month"));
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');

      // $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE'),'penjamin_id', 'penjamin_id');
      //$model->penjamin_id = $penjamin;
      $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
      $model->kelaspelayanan_id = $kelas;
      // $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
      // $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
      if (isset($_GET['ROLaporanbiayapelayanan'])) {
        $model->attributes = $_GET['ROLaporanbiayapelayanan'];
        $model->jns_periode = $_GET['ROLaporanbiayapelayanan']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanbiayapelayanan']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanbiayapelayanan']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanbiayapelayanan']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanbiayapelayanan']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanbiayapelayanan']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanbiayapelayanan']['thn_akhir'];
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

      $this->render('biayaPelayanan/index', array(
        'model' => $model
      ));
    }

    public function actionPrintLaporanBiayaPelayanan()
    {
      $model = new ROLaporanbiayapelayanan('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $judulLaporan = 'Laporan Biaya Pelayanan';

      //Data Grafik        
      $data['title'] = 'Laporan Biaya Pelayanan';
      $data['type'] = $_REQUEST['type'];
      $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE'), 'penjamin_id', 'penjamin_id');
      $model->penjamin_id = $penjamin;
      $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
      $model->kelaspelayanan_id = $kelas;
      if (isset($_REQUEST['ROLaporanbiayapelayanan'])) {
        $model->attributes = $_REQUEST['ROLaporanbiayapelayanan'];
        $model->jns_periode = $_GET['ROLaporanbiayapelayanan']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanbiayapelayanan']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanbiayapelayanan']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanbiayapelayanan']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanbiayapelayanan']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanbiayapelayanan']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanbiayapelayanan']['thn_akhir'];
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
      $target = 'biayaPelayanan/_print';

      $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanBiayaPelayanan()
    {
      $this->layout = '//layouts/iframe';
      $model = new ROLaporanbiayapelayanan('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');

      //Data Grafik
      $data['title'] = 'Grafik Laporan Biaya Pelayanan Radiologi';
      $data['type'] = $_GET['type'];
      if (isset($_GET['ROLaporanbiayapelayanan'])) {
        $model->attributes = $_GET['ROLaporanbiayapelayanan'];
        $model->jns_periode = $_GET['ROLaporanbiayapelayanan']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanbiayapelayanan']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanbiayapelayanan']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanbiayapelayanan']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanbiayapelayanan']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanbiayapelayanan']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanbiayapelayanan']['thn_akhir'];
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

    public function actionLaporanPendapatanRuangan()
    {
      $model = new ROLaporanpendapatanruanganV('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d', strtotime("first day of this month"));
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');

      //  $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
      //$model->penjamin_id = $penjamin;
      $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
      $model->kelaspelayanan_id = $kelas;
      //$model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
      //$model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
      if (isset($_GET['ROLaporanpendapatanruanganV'])) {
        $model->attributes = $_GET['ROLaporanpendapatanruanganV'];
        $model->jns_periode = $_GET['ROLaporanpendapatanruanganV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanpendapatanruanganV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanpendapatanruanganV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanpendapatanruanganV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanpendapatanruanganV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanpendapatanruanganV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanpendapatanruanganV']['thn_akhir'];
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

      $this->render('pendapatanRuangan/index', array(
        'model' => $model
      ));
    }

    public function actionPrintLaporanPendapatanRuangan()
    {
      $model = new ROLaporanpendapatanruanganV('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $judulLaporan = 'Laporan Grafik Pendapatan Ruangan Radiologi';

      //Data Grafik        
      $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
      $data['type'] = $_REQUEST['type'];
      if (isset($_REQUEST['ROLaporanpendapatanruanganV'])) {
        $model->attributes = $_REQUEST['ROLaporanpendapatanruanganV'];
        $model->jns_periode = $_GET['ROLaporanpendapatanruanganV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanpendapatanruanganV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanpendapatanruanganV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanpendapatanruanganV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanpendapatanruanganV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanpendapatanruanganV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanpendapatanruanganV']['thn_akhir'];
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
      $target = 'pendapatanRuangan/_print';

      $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanPendapatanRuangan()
    {
      $this->layout = '//layouts/iframe';
      $model = new ROLaporanpendapatanruanganV('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');

      //Data Grafik
      $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
      $data['type'] = $_GET['type'];
      if (isset($_GET['ROLaporanpendapatanruanganV'])) {
        $model->attributes = $_GET['ROLaporanpendapatanruanganV'];
        $model->jns_periode = $_GET['ROLaporanpendapatanruanganV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanpendapatanruanganV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanpendapatanruanganV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanpendapatanruanganV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanpendapatanruanganV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanpendapatanruanganV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanpendapatanruanganV']['thn_akhir'];
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

    public function actionLaporanBukuRegister()
    {
      $this->pageTitle = Yii::app()->name . " - Buku Register";
      $model = new ROBukuregisterpenunjangV('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d', strtotime("first day of this month"));
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');

      if (isset($_GET['ROBukuregisterpenunjangV'])) {
        $model->attributes = $_GET['ROBukuregisterpenunjangV'];
        $model->jns_periode = $_GET['ROBukuregisterpenunjangV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROBukuregisterpenunjangV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROBukuregisterpenunjangV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROBukuregisterpenunjangV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROBukuregisterpenunjangV']['bln_akhir']);
        $model->thn_awal = $_GET['ROBukuregisterpenunjangV']['thn_awal'];
        $model->thn_akhir = $_GET['ROBukuregisterpenunjangV']['thn_akhir'];
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

    public function actionPrintLaporanBukuRegister()
    {
      $model = new ROBukuregisterpenunjangV('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $judulLaporan = 'Laporan Buku Register Pasien Radiologi';

      //Data Grafik
      $data['title'] = 'Grafik Laporan Buku Register Pasien Radiologi';
      $data['type'] = $_REQUEST['type'];
      if (isset($_REQUEST['ROBukuregisterpenunjangV'])) {
        $model->attributes = $_REQUEST['ROBukuregisterpenunjangV'];
        $model->jns_periode = $_GET['ROBukuregisterpenunjangV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROBukuregisterpenunjangV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROBukuregisterpenunjangV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROBukuregisterpenunjangV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROBukuregisterpenunjangV']['bln_akhir']);
        $model->thn_awal = $_GET['ROBukuregisterpenunjangV']['thn_awal'];
        $model->thn_akhir = $_GET['ROBukuregisterpenunjangV']['thn_akhir'];
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
      $target = 'bukuRegister/_print';

      $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikBukuRegister()
    {
      $this->layout = '//layouts/iframe';
      $model = new ROBukuregisterpenunjangV('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');

      //Data Grafik
      $data['title'] = 'Grafik Laporan Buku Register Pasien Radiologi';
      $data['type'] = $_GET['type'];
      if (isset($_GET['ROBukuregisterpenunjangV'])) {
        $model->attributes = $_GET['ROBukuregisterpenunjangV'];
        $model->jns_periode = $_GET['ROBukuregisterpenunjangV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROBukuregisterpenunjangV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROBukuregisterpenunjangV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROBukuregisterpenunjangV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROBukuregisterpenunjangV']['bln_akhir']);
        $model->thn_awal = $_GET['ROBukuregisterpenunjangV']['thn_awal'];
        $model->thn_akhir = $_GET['ROBukuregisterpenunjangV']['thn_akhir'];
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

    public function actionLaporanCaraMasukPasien()
    {
      $this->pageTitle = Yii::app()->name . " - Cara Masuk";
      $model = new ROLaporancaramasukpenunjangV('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d', strtotime("first day of this month"));
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      // $asalrujukan = CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'), 'asalrujukan_id', 'asalrujukan_id');
      // $model->asalrujukan_id = $asalrujukan;
      // $ruanganasal = CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_id');
      // $model->ruanganasal_id = $ruanganasal;

      if (isset($_GET['ROLaporancaramasukpenunjangV'])) {
        $model->attributes = $_GET['ROLaporancaramasukpenunjangV'];
        $model->jns_periode = $_GET['ROLaporancaramasukpenunjangV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporancaramasukpenunjangV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporancaramasukpenunjangV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporancaramasukpenunjangV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporancaramasukpenunjangV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporancaramasukpenunjangV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporancaramasukpenunjangV']['thn_akhir'];
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

      $this->render('caraMasuk/index', array(
        'model' => $model
      ));
    }

    public function actionPrintLaporanCaraMasukPasien()
    {
      $model = new ROLaporancaramasukpenunjangV('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $judulLaporan = 'Laporan Cara Masuk Pasien Radiologi';

      //Data Grafik
      $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
      $data['type'] = $_REQUEST['type'];
      if (isset($_REQUEST['ROLaporancaramasukpenunjangV'])) {
        $model->attributes = $_REQUEST['ROLaporancaramasukpenunjangV'];
        $model->jns_periode = $_GET['ROLaporancaramasukpenunjangV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporancaramasukpenunjangV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporancaramasukpenunjangV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporancaramasukpenunjangV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporancaramasukpenunjangV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporancaramasukpenunjangV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporancaramasukpenunjangV']['thn_akhir'];
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
      $target = 'caraMasuk/_print';

      $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanCaraMasukPasien()
    {
      $this->layout = '//layouts/iframe';
      $model = new ROLaporancaramasukpenunjangV('search');
      $format = new MyFormatter();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');

      //Data Grafik
      $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
      $data['type'] = $_GET['type'];
      if (isset($_GET['ROLaporancaramasukpenunjangV'])) {
        $model->attributes = $_GET['ROLaporancaramasukpenunjangV'];
        $model->jns_periode = $_GET['ROLaporancaramasukpenunjangV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporancaramasukpenunjangV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporancaramasukpenunjangV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporancaramasukpenunjangV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporancaramasukpenunjangV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporancaramasukpenunjangV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporancaramasukpenunjangV']['thn_akhir'];
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

    // AWAL LAPORAN PEMBAYARAN PEMERIKSAAN RADIOLOGI

    public function actionLaporanPembayaranPemeriksaanRAD()
    {
      $this->pageTitle = Yii::app()->name . " - Pembayaran Pemeriksaan Radiologi";
      $model = new ROLaporanrekaptransaksi();
      $format = new MyFormatter();
      $model->unsetAttributes();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d', strtotime("first day of this month"));
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $tindakan = array('sudah', 'belum');
      $model->tindakansudahbayar_id = $tindakan;
      if (isset($_GET['ROLaporanrekaptransaksi'])) {
        $model->attributes = $_GET['ROLaporanrekaptransaksi'];
        $model->jns_periode = $_GET['ROLaporanrekaptransaksi']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanrekaptransaksi']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanrekaptransaksi']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanrekaptransaksi']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanrekaptransaksi']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanrekaptransaksi']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanrekaptransaksi']['thn_akhir'];
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
        // $model->status = $_GET['ROLaporanrekaptransaksi']['status'];
      }
      $searchdata = $model->searchLapPembayaPeriksaRADGrafik();
      $this->render('pembayaranPemeriksaanRAD/admin', array(
        'model' => $model, 'format' => $format, 'searchdata' => $searchdata
      ));
    }

    public function actionPrintLaporanPembayaranPemeriksaanRAD()
    {

      $model = new ROLaporanrekaptransaksi;
      $format = new MyFormatter();
      $model->unsetAttributes();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $judulLaporan = 'Laporan Pembayaran Pemeriksaan Radiologi';

      //Data Grafik
      $data['title'] = 'Grafik Pembayaran Pemeriksaan Radiologi';
      $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
      if (isset($_REQUEST['ROLaporanrekaptransaksi'])) {
        $model->attributes = $_REQUEST['ROLaporanrekaptransaksi'];
        $model->jns_periode = $_REQUEST['ROLaporanrekaptransaksi']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['ROLaporanrekaptransaksi']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['ROLaporanrekaptransaksi']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['ROLaporanrekaptransaksi']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['ROLaporanrekaptransaksi']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanrekaptransaksi']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanrekaptransaksi']['thn_akhir'];
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
        // $model->status = $_GET['ROLaporanrekaptransaksi']['status'];
      }
      $caraPrint = $_REQUEST['caraPrint'];
      $target = 'pembayaranPemeriksaanRAD/_print';
      $searchdata = $model->searchLapPembayaPeriksaRADGrafik();
      $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $searchdata);
    }

    public function actionFrameLaporanPembayaranPemeriksaanRAD()
    {
      $this->layout = '//layouts/iframe';

      $model = new ROLaporanrekaptransaksi;
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
      $data['title'] = 'Grafik Pembayaran Pemeriksaan Radiologi';
      $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;

      if (isset($_REQUEST['ROLaporanrekaptransaksi'])) {
        $model->attributes = $_GET['ROLaporanrekaptransaksi'];
        $model->jns_periode = $_GET['ROLaporanrekaptransaksi']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanrekaptransaksi']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanrekaptransaksi']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanrekaptransaksi']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanrekaptransaksi']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanrekaptransaksi']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanrekaptransaksi']['thn_akhir'];
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
        //  $model->status = $_GET['ROLaporanrekaptransaksi']['status'];
      }
      //$searchdata = $model->searchLapPemeriksaanRujukRADGrafik();searchLapPembayaPeriksaRADGrafik
      $searchdata = $model->searchLapPembayaPeriksaRADGrafik();
      $this->render('_grafik', array(
        'model' => $model,
        'data' => $data,
        'searchdata' => $searchdata,
      ));
    }

    // AKHIR LAPORAN Pembayaran pemeriksaan radiologi


    // AWAL LAPORAN pemeriksaan rujukan radiologi

    public function actionLaporanPemeriksaanRujukanRAD()
    {
      $model = new ROLaporanPemeriksaanRujukanV();
      $format = new MyFormatter();
      $model->unsetAttributes();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d', strtotime("first day of this month"));
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      if (isset($_GET['ROLaporanPemeriksaanRujukanV'])) {
        $model->attributes = $_GET['ROLaporanPemeriksaanRujukanV'];
        $model->jns_periode = $_GET['ROLaporanPemeriksaanRujukanV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanPemeriksaanRujukanV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanPemeriksaanRujukanV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanPemeriksaanRujukanV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanPemeriksaanRujukanV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanPemeriksaanRujukanV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanPemeriksaanRujukanV']['thn_akhir'];
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
        $model->namaperujuk = isset($_GET['ROLaporanPemeriksaanRujukanV']['namaperujuk']) ? $_GET['ROLaporanPemeriksaanRujukanV']['namaperujuk'] : null;
      }
      $searchdata = $model->searchLapPemeriksaanRujukRADGrafik();
      $this->render('pemeriksaanRujukanRAD/admin', array(
        'model' => $model, 'format' => $format, 'searchdata' => $searchdata
      ));
    }

    public function actionPrintLaporanPemeriksaanRujukanRAD()
    {

      $model = new ROLaporanPemeriksaanRujukanV;
      $format = new MyFormatter();
      $model->unsetAttributes();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $judulLaporan = 'Laporan Pemeriksaan Rujukan Radiologi';

      //Data Grafik
      $data['title'] = 'Grafik Pemeriksaan Rujukan Radiologi';
      $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
      if (isset($_REQUEST['ROLaporanPemeriksaanRujukanV'])) {
        $model->attributes = $_REQUEST['ROLaporanPemeriksaanRujukanV'];
        $model->jns_periode = $_REQUEST['ROLaporanPemeriksaanRujukanV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['ROLaporanPemeriksaanRujukanV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['ROLaporanPemeriksaanRujukanV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['ROLaporanPemeriksaanRujukanV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['ROLaporanPemeriksaanRujukanV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanPemeriksaanRujukanV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanPemeriksaanRujukanV']['thn_akhir'];
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
        $model->namaperujuk = isset($_GET['ROLaporanPemeriksaanRujukanV']['namaperujuk']) ? $_GET['ROLaporanPemeriksaanRujukanV']['namaperujuk'] : null;
      }
      $caraPrint = $_REQUEST['caraPrint'];
      $target = 'pemeriksaanRujukanRAD/_print';
      $searchdata = $model->searchLapPemeriksaanRujukRADGrafik();
      $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $searchdata);
    }

    public function actionFrameLaporanPemeriksaanRujukanRAD()
    {
      $this->layout = '//layouts/iframe';

      $model = new ROLaporanPemeriksaanRujukanV;
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
      $data['title'] = 'Grafik Pemeriksaan Rujukan Radiologi';
      $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;

      if (isset($_REQUEST['ROLaporanPemeriksaanRujukanV'])) {
        $model->attributes = $_GET['ROLaporanPemeriksaanRujukanV'];
        $model->jns_periode = $_GET['ROLaporanPemeriksaanRujukanV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanPemeriksaanRujukanV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanPemeriksaanRujukanV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanPemeriksaanRujukanV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanPemeriksaanRujukanV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanPemeriksaanRujukanV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanPemeriksaanRujukanV']['thn_akhir'];
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
        $model->namaperujuk = isset($_GET['ROLaporanPemeriksaanRujukanV']['namaperujuk']) ? $_GET['ROLaporanPemeriksaanRujukanV']['namaperujuk'] : null;
      }
      $searchdata = $model->searchLapPemeriksaanRujukRADGrafik();
      $this->render('_grafik', array(
        'model' => $model,
        'data' => $data,
        'searchdata' => $searchdata,
      ));
    }

    // AKHIR LAPORAN pemeriksaan rujukan radiologi


    // AWAL LAPORAN Pemeriksaan Jenis Penjamin radiologi

    public function actionLaporanPemeriksaanCaraBayarRAD()
    {
      $this->pageTitle = Yii::app()->name . " - Pemeriksaan Jenis Penjamin";
      $model = new ROLaporanrekaptransaksi();
      $format = new MyFormatter();
      $model->unsetAttributes();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      if (isset($_GET['ROLaporanrekaptransaksi'])) {
        $model->attributes = $_GET['ROLaporanrekaptransaksi'];
        $model->jns_periode = $_GET['ROLaporanrekaptransaksi']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanrekaptransaksi']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanrekaptransaksi']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanrekaptransaksi']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanrekaptransaksi']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanrekaptransaksi']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanrekaptransaksi']['thn_akhir'];
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
      $searchdata = $model->searchLapPemeriksaanCaraByrRADGrafik();
      $this->render('pemeriksaanCaraBayarRAD/admin', array(
        'model' => $model, 'format' => $format, 'searchdata' => $searchdata
      ));
    }

    public function actionPrintLaporanPemeriksaanCaraBayarRAD()
    {

      $model = new ROLaporanrekaptransaksi;
      $format = new MyFormatter();
      $model->unsetAttributes();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $judulLaporan = 'Laporan Pemeriksaan Jenis Penjamin Radiologi';

      //Data Grafik
      $data['title'] = 'Grafik Pemeriksaan Jenis Penjamin Radiologi';
      $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
      if (isset($_REQUEST['ROLaporanrekaptransaksi'])) {
        $model->attributes = $_REQUEST['ROLaporanrekaptransaksi'];
        $model->jns_periode = $_REQUEST['ROLaporanrekaptransaksi']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['ROLaporanrekaptransaksi']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['ROLaporanrekaptransaksi']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['ROLaporanrekaptransaksi']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['ROLaporanrekaptransaksi']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanrekaptransaksi']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanrekaptransaksi']['thn_akhir'];
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
      $target = 'pemeriksaanCaraBayarRAD/_print';
      $searchdata = $model->searchLapPemeriksaanCaraByrRADGrafik();
      $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $searchdata);
    }

    public function actionFrameLaporanPemeriksaanCaraBayarRAD()
    {
      $this->layout = '//layouts/iframe';

      $model = new ROLaporanrekaptransaksi;
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
      $data['title'] = 'Grafik Pemeriksaan Jenis Penjamin Radiologi';
      $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;

      if (isset($_REQUEST['ROLaporanrekaptransaksi'])) {
        $model->attributes = $_GET['ROLaporanrekaptransaksi'];
        $model->jns_periode = $_GET['ROLaporanrekaptransaksi']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanrekaptransaksi']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanrekaptransaksi']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanrekaptransaksi']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanrekaptransaksi']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanrekaptransaksi']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanrekaptransaksi']['thn_akhir'];
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
      $searchdata = $model->searchLapPemeriksaanCaraByrRADGrafik();
      $this->render('_grafik', array(
        'model' => $model,
        'data' => $data,
        'searchdata' => $searchdata,
      ));
    }

    // AKHIR LAPORAN pemeriksaan cara bayar Radiologi

    protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target, $searchdata = null)
    {
      $format = new MyFormatter();
      $periode = $format->formatDateTimeForDb($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForDb($model->tgl_akhir);

      if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
        $this->layout = '//layouts/printWindows';
        $this->render($target, array('searchdata' => $searchdata, 'model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      } else if ($caraPrint == 'EXCEL') {
        $this->layout = '//layouts/printExcel';
        $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      } else if ($_REQUEST['caraPrint'] == 'PDF') {
        $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        //$mpdf->useOddEven = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
        $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
        $mpdf->Output($judulLaporan . "_" . date('Y-m-d') . '.pdf', 'I');
      }
    }

    //    protected function parserTanggal($tgl){
    //        return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($tgl, 'yyyy-MM-dd hh:mm:ss'));
    //    }

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


    public function actionPemeriksaanRujukanRS()
    {
      $this->pageTitle = Yii::app()->name . " - Pemeriksaan Rujukan";
      $model = new ROLappemeriksaanrujukanrsV('search');
      $format = new MyFormatter();
      $model->unsetAttributes();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $this->pathViewLab = 'radiologi.views.laporan.pemeriksaanRujukanRs.';

      if (isset($_GET['ROLappemeriksaanrujukanrsV'])) {
        $model->attributes = $_GET['ROLappemeriksaanrujukanrsV'];
        $model->jns_periode = $_GET['ROLappemeriksaanrujukanrsV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLappemeriksaanrujukanrsV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLappemeriksaanrujukanrsV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLappemeriksaanrujukanrsV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLappemeriksaanrujukanrsV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLappemeriksaanrujukanrsV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLappemeriksaanrujukanrsV']['thn_akhir'];
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

      $this->render($this->pathViewLab . 'index', array(
        'model' => $model,
      ));
    }

    public function actionPrintPemeriksaanRujukanRS()
    {
      $model = new ROLappemeriksaanrujukanrsV('search');
      $format = new MyFormatter();
      $model->unsetAttributes();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $judulLaporan = 'Laporan Pemeriksaan Rujukan RS';
      $this->pathViewLab = 'radiologi.views.laporan.pemeriksaanRujukanRs.';

      //Data Grafik
      $data['title'] = 'Grafik Laporan Pemeriksaan Rujukan RS';
      $data['type'] = $_REQUEST['type'];
      if (isset($_GET['ROLappemeriksaanrujukanrsV'])) {
        $model->attributes = $_GET['ROLappemeriksaanrujukanrsV'];
        $model->jns_periode = $_GET['ROLappemeriksaanrujukanrsV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLappemeriksaanrujukanrsV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLappemeriksaanrujukanrsV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLappemeriksaanrujukanrsV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLappemeriksaanrujukanrsV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLappemeriksaanrujukanrsV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLappemeriksaanrujukanrsV']['thn_akhir'];
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
      $target = $this->pathViewLab . '_print';

      $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikPemeriksaanRujukanRS()
    {
      $this->layout = '//layouts/iframe';
      $model = new ROLappemeriksaanrujukanrsV('search');
      $format = new MyFormatter();
      $model->unsetAttributes();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $this->pathViewLab = 'radiologi.views.laporan.pemeriksaanRujukanRs.';
      //Data Grafik
      $data['title'] = 'Grafik Laporan Pemeriksaan Rujukan RS';
      $data['type'] = $_GET['type'];
      if (isset($_GET['ROLappemeriksaanrujukanrsV'])) {
        $model->attributes = $_GET['ROLappemeriksaanrujukanrsV'];
        $model->jns_periode = $_GET['ROLappemeriksaanrujukanrsV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLappemeriksaanrujukanrsV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLappemeriksaanrujukanrsV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLappemeriksaanrujukanrsV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLappemeriksaanrujukanrsV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLappemeriksaanrujukanrsV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLappemeriksaanrujukanrsV']['thn_akhir'];
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

    public function actionPemeriksaanRujukanKeluar()
    {
      $this->pageTitle = Yii::app()->name . " - Pemeriksaan Rujukan Keluar";
      $model = new ROLaporanrujukankeluarV('search');
      $format = new MyFormatter();
      $model->unsetAttributes();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $this->pathViewLab = 'radiologi.views.laporan.pemeriksaanRujukanKeluar.';

      if (isset($_GET['ROLaporanrujukankeluarV'])) {
        $model->attributes = $_GET['ROLaporanrujukankeluarV'];
        $model->jns_periode = $_GET['ROLaporanrujukankeluarV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanrujukankeluarV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanrujukankeluarV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanrujukankeluarV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanrujukankeluarV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanrujukankeluarV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanrujukankeluarV']['thn_akhir'];
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

      $this->render($this->pathViewLab . 'index', array(
        'model' => $model,
      ));
    }

    public function actionPrintPemeriksaanRujukanKeluar()
    {
      $model = new ROLaporanrujukankeluarV('search');
      $format = new MyFormatter();
      $model->unsetAttributes();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $judulLaporan = 'Laporan Pemeriksaan Rujukan Keluar';
      $this->pathViewLab = 'radiologi.views.laporan.pemeriksaanRujukanKeluar.';

      //Data Grafik
      $data['title'] = 'Grafik Laporan Pemeriksaan Rujukan Keluar';
      $data['type'] = $_REQUEST['type'];
      if (isset($_GET['ROLaporanrujukankeluarV'])) {
        $model->attributes = $_GET['ROLaporanrujukankeluarV'];
        $model->jns_periode = $_GET['ROLaporanrujukankeluarV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanrujukankeluarV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanrujukankeluarV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanrujukankeluarV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanrujukankeluarV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanrujukankeluarV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanrujukankeluarV']['thn_akhir'];
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
      $target = $this->pathViewLab . '_print';

      $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikPemeriksaanRujukanKeluar()
    {
      $this->layout = '//layouts/iframe';
      $model = new ROLaporanrujukankeluarV('search');
      $format = new MyFormatter();
      $model->unsetAttributes();
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d');
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m');
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $this->pathViewLab = 'radiologi.views.laporan.pemeriksaanRujukanKeluar.';
      //Data Grafik
      $data['title'] = 'Grafik Laporan Pemeriksaan Rujukan Keluar';
      $data['type'] = $_GET['type'];
      if (isset($_GET['ROLaporanrujukankeluarV'])) {
        $model->attributes = $_GET['ROLaporanrujukankeluarV'];
        $model->jns_periode = $_GET['ROLaporanrujukankeluarV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanrujukankeluarV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanrujukankeluarV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanrujukankeluarV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanrujukankeluarV']['bln_akhir']);
        $model->thn_awal = $_GET['ROLaporanrujukankeluarV']['thn_awal'];
        $model->thn_akhir = $_GET['ROLaporanrujukankeluarV']['thn_akhir'];
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
     * ========================  Jasa Tindakan ===============================
     */
  public function actionLaporanJasaTindakan()
  {
    $this->pageTitle = Yii::app()->name . " - Tindakan Ruangan";
    $model = new ROLaporanjasatindakan('searchTable');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $filter = (isset($_GET['filter']) ? $_GET['filter'] : null);

    if (isset($_GET['ROLaporanjasatindakan'])) {
      $model->attributes = $_GET['ROLaporanjasatindakan'];
      $model->jns_periode = $_GET['ROLaporanjasatindakan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanjasatindakan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanjasatindakan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['ROLaporanjasatindakan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['ROLaporanjasatindakan']['bln_akhir']);
      $model->thn_awal = $_GET['ROLaporanjasatindakan']['thn_awal'];
      $model->thn_akhir = $_GET['ROLaporanjasatindakan']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime(''.$model->bln_akhir));
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

    $this->render($this->pathViewLab.'jasaTindakan/adminJasaTindakan', array(
      'model' => $model, 'filter' => $filter, 'format' => $format
    ));
  }

  public function actionPrintLaporanJasaTindakan()
  {
    $model = new ROLaporanjasatindakan('searchTable');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Grafik Tindakan Jasa Radiologi';
    $format = new MyFormatter();
    //Data Grafik        
    $data['title'] = 'Grafik Laporan Tindakan Ruangan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['ROLaporanjasatindakan'])) {
      $model->attributes = $_REQUEST['ROLaporanjasatindakan'];
      $model->jns_periode = $_REQUEST['ROLaporanjasatindakan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['ROLaporanjasatindakan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['ROLaporanjasatindakan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['ROLaporanjasatindakan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['ROLaporanjasatindakan']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime(''. $model->bln_akhir));
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
    $target = $this->pathViewLab.'jasaTindakan/_printJasaTindakan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanJasaTindakan()
  {
    $this->layout = '//layouts/iframe';
    $model = new ROLaporanjasatindakan('searchTable');
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Tindakan Jasa Radiologi';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_GET['ROLaporanjasatindakan'])) {
      $model->attributes = $_GET['ROLaporanjasatindakan'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanjasatindakan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ROLaporanjasatindakan']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /*
     * ======================== END Jasa TindakaRuangann ===========================
     */
  }
