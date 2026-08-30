<?php

/**
 * perbaikan format Laporan
 * BMB-295
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * @package         application.modules.gudangFarmasi
 * @subpackage      controllers
 * 
 */
class LaporanController extends MyAuthController
{
    public function actionIndex()
    {
        $this->render('index');
    }
    public $path_view_tips = "gudangFarmasi.views.tips.";
    public $path_view_gudang = "gudangFarmasi.views.laporan.";
    public function actionLaporanMutasiObatAlkes()
    {
        $this->pageTitle = Yii::app()->name . " - Mutasi Obat Alkes";
        $model = new GFMutasioaruanganT;
        $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['GFMutasioaruanganT'])) {
            $format = new MyFormatter;
            $model->attributes = $_GET['GFMutasioaruanganT'];
            $model->jns_periode = $_GET['GFMutasioaruanganT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFMutasioaruanganT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFMutasioaruanganT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFMutasioaruanganT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFMutasioaruanganT']['bln_akhir']);
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
            //            if($_GET['GFMutasioaruanganT']['ruanganasal_id']){
            //            $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
        }
        $this->render('mutasiObatAlkes/index', array(
            'model' => $model, 'format' => $format
        ));
    }
    public function actionPrintLaporanMutasiObatAlkes()
    {
        $model = new GFMutasioaruanganT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'LAPORAN MUTASI OBAT & ALKES';

        //Data Grafik
        $data['title'] = 'GRAFIK MUTASI OBAT & ALKES';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['GFMutasioaruanganT'])) {
            $model->attributes = $_REQUEST['GFMutasioaruanganT'];
            $model->jns_periode = $_GET['GFMutasioaruanganT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFMutasioaruanganT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFMutasioaruanganT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFMutasioaruanganT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFMutasioaruanganT']['bln_akhir']);
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

        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'mutasiObatAlkes/Print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
    /**
     * actionLaporanMutasiIntern laporan mutasi obat alkes
     */
    public function actionLaporanMutasiIntern()
    {
        $this->pageTitle = Yii::app()->name . " - Mutasi Obat Alkes Intern";
        $model = new GFMutasioaruanganT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['GFMutasioaruanganT'])) {
            $format = new MyFormatter;
            $model->attributes = $_GET['GFMutasioaruanganT'];
            $model->jns_periode = $_GET['GFMutasioaruanganT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFMutasioaruanganT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFMutasioaruanganT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFMutasioaruanganT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFMutasioaruanganT']['bln_akhir']);
            $model->thn_awal = $_GET['GFMutasioaruanganT']['thn_awal'];
            $model->thn_akhir = $_GET['GFMutasioaruanganT']['thn_akhir'];
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
        $this->render('mutasiIntern/index', array(
            'model' => $model, 'format' => $format
        ));
    }
    /**
     * actionLaporanMutasiIntern print laporan mutasi obat alkes
     */
    public function actionPrintLaporanMutasiIntern()
    {
        $model = new GFMutasioaruanganT('searchLaporanMutasiIntern');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'LAPORAN MUTASI OBAT ALKES';
        //Data Grafik
        $data['title'] = 'GRAFIK MUTASI OBAT ALKES';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['GFMutasioaruanganT'])) {
            $model->attributes = $_REQUEST['GFMutasioaruanganT'];
            $model->jns_periode = $_REQUEST['GFMutasioaruanganT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFMutasioaruanganT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFMutasioaruanganT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFMutasioaruanganT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFMutasioaruanganT']['bln_akhir']);
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

        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'mutasiIntern/Print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
    /**
     * actionPrintLaporanMutasiInternDetail print detail dari tombol di grid
     */
    public function actionLaporanMutasiInternDetail($id, $caraPrint)
    {
        $this->layout = '//layouts/iframe';
        $judulLaporan = 'LAPORAN MUTASI OBAT & ALKES DETAIL';
        $format = new MyFormatter();
        $modDetail = array();
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        if ($caraPrint == "PRINT")
            $this->layout = '//layouts/printWindows';
        if (isset($_REQUEST['GFMutasioaruanganT'])) {
            $criteria = new CdbCriteria();
            $tgl_awal =  $format->formatDateTimeForDb($_REQUEST['GFMutasioaruanganT']['tgl_awal']);
            $tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFMutasioaruanganT']['tgl_akhir']);
            $criteria->addBetweenCondition('tglmutasioa', $tgl_awal, $tgl_akhir);
            if (!empty($id)) {
                $criteria->addCondition("mutasioaruangan_id = " . $id);
            }
            $model = GFMutasioaruanganT::model()->find($criteria);
            $modDetail = GFMutasioadetailT::model()->findAllByAttributes(array('mutasioaruangan_id' => $id));
        }
        $ruanganAsal = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'))->ruangan_nama;
        $periode = date('d-m-Y H:i:s',  strtotime($tgl_awal)) . " s/d " . date('d-m-Y H:i:s',  strtotime($tgl_akhir));
        $this->render('mutasiIntern/PrintDetail', array('model' => $model, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'ruanganAsal' => $ruanganAsal, 'periode' => $periode, 'caraPrint' => $caraPrint));
    }
    public function actionFrameGrafikLaporanMutasiObatAlkes()
    {
        $this->layout = '//layouts/iframe';

        $model = new GFMutasioaruanganT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'GRAFIK LAPORAN MUTASI OBAT & ALKES';
        $data['type'] = $_GET['type'];

        if (isset($_GET['GFMutasioaruanganT'])) {
            $format = new MyFormatter();
            $model->attributes = $_GET['GFMutasioaruanganT'];
            $model->jns_periode = $_GET['GFMutasioaruanganT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFMutasioaruanganT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFMutasioaruanganT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFMutasioaruanganT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFMutasioaruanganT']['bln_akhir']);
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
            'format' => $format,
            'model' => $model,
            'data' => $data,
        ));
    }

    //    ====================================AWAL LAPORAN PENERIMAAN ITEMS
    //    diganti dengan : gudangFarmasi/Laporan/LaporanPenerimaanObatAlkes
    //    public function actionLaporanPenerimaanItems()
    //    {
    //        $model = new GFPenerimaanBarangT;
    //        $model->tgl_awal = date('Y-m-d 00:00:00');
    //        $model->tgl_akhir = date('Y-m-d 23:59:59');
    //        if (isset($_GET['GFPenerimaanBarangT'])) {
    //            $format = new MyFormatter;
    //            $model->attributes = $_GET['GFPenerimaanBarangT'];
    //            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFPenerimaanBarangT']['tgl_awal']);
    //            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFPenerimaanBarangT']['tgl_akhir']);
    //        }
    //        $this->render('penerimaanItems/index',array(
    //            'model'=>$model,
    //        ));
    //    }
    //    public function actionPrintLaporanPenerimaanItems() {
    //        $model = new GFPenerimaanBarangT;
    //        $judulLaporan = 'Laporan Penerimaan Items';
    //
    //        //Data Grafik
    //        $data['title'] = 'Grafik Laporan Penerimaan Items';
    //        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    //        if (isset($_REQUEST['GFPenerimaanBarangT'])) {
    //            $model->attributes = $_REQUEST['GFPenerimaanBarangT'];
    //            $format = new MyFormatter();
    //            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFPenerimaanBarangT']['tgl_awal']);
    //            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFPenerimaanBarangT']['tgl_akhir']);
    //        }
    //
    //        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    //        $target = 'penerimaanItems/Print';
    //
    //        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    //   }

    public function actionTabLaporanPenerimaanObatAlkes()
    {
        $this->render('penerimaanObatAlkes/tabulasi');
    }

    /**
     * actionLaporanPenerimaanObatAlkes untuk laporan penerimaan obat alkes
     */
    public function actionLaporanPenerimaanObatAlkes()
    {
        $this->pageTitle = Yii::app()->name . " - Penerimaan Obat";
        // $this->layout = '//layouts/iframe';
        $model = new GFPenerimaanBarangT('searchLaporanPenerimaanObatAlkes');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['GFPenerimaanBarangT'])) {
            $model->attributes = $_GET['GFPenerimaanBarangT'];
            $model->jns_periode = $_GET['GFPenerimaanBarangT']['jns_periode'];
            $model->jenisobatalkes_id = isset($_GET['GFPenerimaanBarangT']['jenisobatalkes_id']) ? $_GET['GFPenerimaanBarangT']['jenisobatalkes_id'] : null;
            $model->jnskelompok = isset($_GET['GFPenerimaanBarangT']['jnskelompok']) ? $_GET['GFPenerimaanBarangT']['jnskelompok'] : null;
            $model->obatalkes_kategori = isset($_GET['GFPenerimaanBarangT']['obatalkes_kategori']) ? $_GET['GFPenerimaanBarangT']['obatalkes_kategori'] : null;
            $model->obatalkes_golongan = isset($_GET['GFPenerimaanBarangT']['obatalkes_golongan']) ? $_GET['GFPenerimaanBarangT']['obatalkes_golongan'] : null;
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFPenerimaanBarangT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFPenerimaanBarangT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFPenerimaanBarangT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFPenerimaanBarangT']['bln_akhir']);
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
        $this->render('penerimaanObatAlkes/index', array(
            'model' => $model, 'format' => $format
        ));
    }
    /**
     * actionPrintLaporanPenerimaanObatAlkes untuk print laporan penerimaan obat alkes
     */
    public function actionPrintLaporanPenerimaanObatAlkes()
    {
        $model = new GFPenerimaanBarangT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'LAPORAN PENERIMAAN OBAT & ALKES';

        //Data Grafik
        $data['title'] = 'GRAFIK LAPORAN OBAT & ALKES';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['GFPenerimaanBarangT'])) {
            $model->attributes = $_REQUEST['GFPenerimaanBarangT'];
            $model->jns_periode = $_REQUEST['GFPenerimaanBarangT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFPenerimaanBarangT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFPenerimaanBarangT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFPenerimaanBarangT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFPenerimaanBarangT']['bln_akhir']);
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
            $model->jenisobatalkes_id = isset($_GET['GFPenerimaanBarangT']['jenisobatalkes_id']) ? $_GET['GFPenerimaanBarangT']['jenisobatalkes_id'] : null;
            $model->jnskelompok = isset($_GET['GFPenerimaanBarangT']['jnskelompok']) ? $_GET['GFPenerimaanBarangT']['jnskelompok'] : null;
            $model->obatalkes_kategori = isset($_GET['GFPenerimaanBarangT']['obatalkes_kategori']) ? $_GET['GFPenerimaanBarangT']['obatalkes_kategori'] : null;
            $model->obatalkes_golongan = isset($_GET['GFPenerimaanBarangT']['obatalkes_golongan']) ? $_GET['GFPenerimaanBarangT']['obatalkes_golongan'] : null;
        }

        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'penerimaanObatAlkes/Print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    /**
     * @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * - digunakan untuk mengenerate data ke dalam bemtuk grafik
     */
    public function actionFrameGrafikLaporanpenerimaanObatAlkes()
    {
        $this->layout = '//layouts/iframe';
        $model = new GFPenerimaanBarangT('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        //Data Grafik
        $data['title'] = 'GRAFIK LAPORAN PENERIMAAN OBAT & ALKES';
        $data['type'] = $_GET['type'];

        $grafik = null;

        if (isset($_GET['GFPenerimaanBarangT'])) {
            $model->attributes = $_GET['GFPenerimaanBarangT'];
            $format = new MyFormatter();
            $model->jns_periode = $_REQUEST['GFPenerimaanBarangT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFPenerimaanBarangT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFPenerimaanBarangT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFPenerimaanBarangT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFPenerimaanBarangT']['bln_akhir']);
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
            $model->jenisobatalkes_id = isset($_GET['GFPenerimaanBarangT']['jenisobatalkes_id']) ? $_GET['GFPenerimaanBarangT']['jenisobatalkes_id'] : null;
            $model->jnskelompok = isset($_GET['GFPenerimaanBarangT']['jnskelompok']) ? $_GET['GFPenerimaanBarangT']['jnskelompok'] : null;
            $model->obatalkes_kategori = isset($_GET['GFPenerimaanBarangT']['obatalkes_kategori']) ? $_GET['GFPenerimaanBarangT']['obatalkes_kategori'] : null;
            $model->obatalkes_golongan = isset($_GET['GFPenerimaanBarangT']['obatalkes_golongan']) ? $_GET['GFPenerimaanBarangT']['obatalkes_golongan'] : null;


            $data['title'] = 'GRAFIK LAPORAN PENERIMAAN OBAT & ALKES';
            $grafik = $model->frameGrafikPenerimaanBarangOa();
        }

        $this->render($this->path_view_gudang . 'pemakaianObat/_grafik', array(
            'model' => $model,
            'data' => $data,
            'grafik' => $grafik
        ));
    }

    public function actionLaporanPenerimaanObatAlkesSupplier()
    {


        $this->layout = '//layouts/iframe';
        $model = new GFPenerimaanBarangT('searchLaporanPenerimaanObatAlkes');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['GFPenerimaanBarangT'])) {
            $model->attributes = $_GET['GFPenerimaanBarangT'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFPenerimaanBarangT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFPenerimaanBarangT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFPenerimaanBarangT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFPenerimaanBarangT']['bln_akhir']);
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
        $this->render('penerimaanObatAlkes/indexSupplier', array(
            'model' => $model, 'format' => $format
        ));
    }
    public function actionPrintLaporanPenerimaanObatAlkesSupplier()
    {


        $this->layout = '//layouts/iframe';
        $model = new GFPenerimaanBarangT('searchLaporanPenerimaanObatAlkes');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'LAPORAN PENERIMAAN OBAT & ALKES OLEH SUPPLIER';

        if (isset($_GET['GFPenerimaanBarangT'])) {
            $model->attributes = $_GET['GFPenerimaanBarangT'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFPenerimaanBarangT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFPenerimaanBarangT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFPenerimaanBarangT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFPenerimaanBarangT']['bln_akhir']);
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

        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'penerimaanObatAlkes/PrintSupplier';
        $grafik = $model->searchGrafikOASupplier();

        $this->printFunction($model, null, $caraPrint, $judulLaporan, $target, $grafik);
    }

    /**
     * @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * - digunakan untuk menegenerate grafik penerimaan oa by supplier
     */
    public function actionFrameGrafikLapTerimaOABySupplier()
    {
        $this->layout = '//layouts/iframe';
        $model = new GFPenerimaanBarangT('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        //Data Grafik
        $data['title'] = 'GRAFIK LAPORAN PENERIMAAN OBAT & ALKES OLEH SUPPLIER';
        $data['type'] = $_GET['type'];

        $grafik = null;

        if (isset($_GET['GFPenerimaanBarangT'])) {
            $model->attributes = $_GET['GFPenerimaanBarangT'];
            $format = new MyFormatter();
            $model->jns_periode = $_REQUEST['GFPenerimaanBarangT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFPenerimaanBarangT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFPenerimaanBarangT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFPenerimaanBarangT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFPenerimaanBarangT']['bln_akhir']);
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
            $model->jenisobatalkes_id = isset($_GET['GFPenerimaanBarangT']['jenisobatalkes_id']) ? $_GET['GFPenerimaanBarangT']['jenisobatalkes_id'] : null;
            $model->jnskelompok = isset($_GET['GFPenerimaanBarangT']['jnskelompok']) ? $_GET['GFPenerimaanBarangT']['jnskelompok'] : null;
            $model->obatalkes_kategori = isset($_GET['GFPenerimaanBarangT']['obatalkes_kategori']) ? $_GET['GFPenerimaanBarangT']['obatalkes_kategori'] : null;
            $model->obatalkes_golongan = isset($_GET['GFPenerimaanBarangT']['obatalkes_golongan']) ? $_GET['GFPenerimaanBarangT']['obatalkes_golongan'] : null;


            $data['title'] = 'GRAFIK LAPORAN PENERIMAAN OBAT & ALKES OLEH SUPPLIER';
            $grafik = $model->searchGrafikOASupplier();
        }

        $this->render($this->path_view_gudang . 'pemakaianObat/_grafik', array(
            'model' => $model,
            'data' => $data,
            'grafik' => $grafik
        ));
    }

    /**
     * actionPrintLaporanPenerimaanObatAlkesByObat untuk print laporan penerimaan obat alkes group berdasarkan obat
     */
    public function actionPrintLaporanPenerimaanObatAlkesByObat()
    {
        $this->layout = '//layouts/iframe';
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $judulLaporan = 'Laporan Penerimaan Obat Alkes';
        $format = new MyFormatter();
        $modDetail = array();
        if ($caraPrint == "PRINT")
            $this->layout = '//layouts/printWindows';

        if (isset($_REQUEST['GFPenerimaanBarangT'])) {
            $criteria = new CdbCriteria();
            $supplierId = $_REQUEST['GFPenerimaanBarangT']['supplier_id'];
            $noTerima = $_REQUEST['GFPenerimaanBarangT']['noterima'];
            $tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFPenerimaanBarangT']['tgl_awal']);
            $tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFPenerimaanBarangT']['tgl_akhir']);
            $criteria->addBetweenCondition('tglterima', $tgl_awal, $tgl_akhir);
            $criteria2 = new CdbCriteria;
            $criteria2->join = 'JOIN penerimaanbarang_t pb ON pb.penerimaanbarang_id = t.penerimaanbarang_id
                            JOIN obatalkes_m oa ON oa.obatalkes_id = t.obatalkes_id
            ';
            $criteria2->group = 't.obatalkes_id, oa.obatalkes_nama, t.satuanbesar_id ,pb.supplier_id';
            $criteria2->select = 't.obatalkes_id, oa.obatalkes_nama, t.satuanbesar_id ,
                            SUM(t.jmlterima) AS jmlterima,
                            SUM(t.harganettoper*t.jmlterima) AS hargabelibruto,
                            SUM(t.harganettoper*t.persendiscount*t.jmlterima/100) AS mergediskon,
                            SUM(((t.harganettoper - (t.harganettoper*t.persendiscount*t.jmlterima/100))*(CASE WHEN t.persenppn > 0 THEN 10 ELSE 0 END)/100) *t.jmlterima) AS mergeppn,
                            SUM(t.harganettoper - (t.harganettoper*t.persendiscount/100) + ((t.harganettoper - (t.harganettoper*t.persendiscount/100))*(CASE WHEN t.persenppn > 0 THEN 10 ELSE 0 END)/100) * t.jmlterima) AS subtotalobat,
                            pb.supplier_id';
            $criteria2->order = 'oa.obatalkes_nama';
            $criteria2->addBetweenCondition('pb.tglterima', $tgl_awal, $tgl_akhir);
            if (empty($supplierId) && empty($noTerima)) { //jika supplier atau noterima tidak ditentukan
                $model = new GFPenerimaanBarangT;
            } else {
                if (!empty($supplierId)) {
                    $criteria->addCondition("supplier_id = " . $supplierId);
                }
                $criteria->compare('LOWER(noterima)', strtolower($noTerima), true);
                $model = GFPenerimaanBarangT::model()->find($criteria);
                if (!empty($supplierId)) {
                    $criteria->addCondition("pb.supplier_id = " . $supplierId);
                }
                $criteria2->compare('LOWER(pb.noterima)', strtolower($noTerima), true);
            }
            $modDetail = GFPenerimaanDetailT::model()->findAll($criteria2);
        }
        $ruanganAsal = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'))->ruangan_nama;
        $periode = date('d-m-Y H:i:s',  strtotime($tgl_awal)) . " s/d " . date('d-m-Y H:i:s',  strtotime($tgl_akhir));

        //Data Grafik
        $data['title'] = 'Grafik Laporan Penerimaan Items';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        $target = 'penerimaanObatAlkes/PrintByObat';
        $this->render($target, array('model' => $model, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'ruanganAsal' => $ruanganAsal, 'periode' => $periode, 'noTerima' => $noTerima, 'caraPrint' => $caraPrint));
    }
    /**
     * actionPrintLaporanPenerimaanObatAlkesByPenerimaan untuk print laporan penerimaan obat alkes group berdasarkan Penerimaan
     */
    public function actionPrintLaporanPenerimaanObatAlkesByPenerimaan()
    {
        $this->layout = '//layouts/iframe';
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $judulLaporan = 'Laporan Penerimaan Obat Alkes';
        $format = new MyFormatter();
        $models = array();
        if ($caraPrint == "PRINT")
            $this->layout = '//layouts/printWindows';

        if (isset($_REQUEST['GFPenerimaanBarangT'])) {
            $supplierId = $_REQUEST['GFPenerimaanBarangT']['supplier_id'];
            $noTerima = $_REQUEST['GFPenerimaanBarangT']['noterima'];
            $tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFPenerimaanBarangT']['tgl_awal']);
            $tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFPenerimaanBarangT']['tgl_akhir']);
            $criteria = new CdbCriteria();
            $criteria->addBetweenCondition('tglterima', $tgl_awal, $tgl_akhir);
            if (!empty($supplierId)) {
                $criteria->addCondition("supplier_id = " . $supplierId);
            }
            $criteria->compare('LOWER(noterima)', strtolower($noTerima), true);
            $criteria->order = 'supplier_id, tglterima ASC';
            $models = GFPenerimaanBarangT::model()->findAll($criteria);
        }
        $ruanganAsal = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'))->ruangan_nama;
        $periode = date('d-m-Y H:i:s',  strtotime($tgl_awal)) . " s/d " . date('d-m-Y H:i:s',  strtotime($tgl_akhir));

        //Data Grafik
        $data['title'] = 'Grafik Laporan Penerimaan Items';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        $target = 'penerimaanObatAlkes/PrintByPenerimaan';
        $this->render($target, array('models' => $models, 'judulLaporan' => $judulLaporan, 'ruanganAsal' => $ruanganAsal, 'periode' => $periode, 'noTerima' => $noTerima, 'caraPrint' => $caraPrint));
    }
    /**
     * actionPrintLaporanPenerimaanObatAlkesDetail untuk print laporan penerimaan obat alkes detail
     */
    public function actionPrintLaporanPenerimaanObatAlkesDetail($caraPrint = "")
    {
        $this->layout = '//layouts/iframe';
        $judulLaporan = 'Laporan Penerimaan Obat Alkes Detail';
        $format = new MyFormatter();
        $modDetail = array();
        if ($caraPrint == "PRINT")
            $this->layout = '//layouts/printWindows';

        if (isset($_REQUEST['GFPenerimaanBarangT'])) {
            $criteria = new CdbCriteria();
            $supplierId = (isset($_REQUEST['GFPenerimaanBarangT']['supplier_id']) ? $_REQUEST['GFPenerimaanBarangT']['supplier_id'] : "");
            $noTerima = (isset($_REQUEST['GFPenerimaanBarangT']['noterima']) ? $_REQUEST['GFPenerimaanBarangT']['noterima'] : "");
            $tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFPenerimaanBarangT']['tgl_awal']);
            $tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFPenerimaanBarangT']['tgl_akhir']);
            $criteria->addBetweenCondition('tglterima', $tgl_awal, $tgl_akhir);
            $criteria2 = new CdbCriteria;
            $criteria2->with = 'penerimaanbarang';
            $criteria2->addBetweenCondition('penerimaanbarang.tglterima', $tgl_awal, $tgl_akhir);
            $criteria2->order = "obatalkes_id ASC";
            if (empty($supplierId) && empty($noTerima)) { //jika supplier atau noterima tidak ditentukan
                $model = new GFPenerimaanBarangT;
            } else {
                if (!empty($supplierId)) {
                    $criteria->addCondition("supplier_id = " . $supplierId);
                }
                $criteria->compare('LOWER(noterima)', strtolower($noTerima), true);
                if (!empty($supplierId)) {
                    $criteria->addCondition("penerimaanbarang.supplier_id = " . $supplierId);
                }
                $criteria2->compare('LOWER(penerimaanbarang.noterima)', strtolower($noTerima), true);
                $model = GFPenerimaanBarangT::model()->find($criteria);
            }
            $modDetail = GFPenerimaanDetailT::model()->findAll($criteria2);
        }
        $ruanganAsal = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'))->ruangan_nama;
        $periode = date('d-m-Y H:i:s',  strtotime($tgl_awal)) . " s/d " . date('d-m-Y H:i:s',  strtotime($tgl_akhir));

        //Data Grafik
        $data['title'] = 'Grafik Laporan Penerimaan Items';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'penerimaanObatAlkes/PrintDetail';
        $this->render($target, array('model' => $model, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'ruanganAsal' => $ruanganAsal, 'periode' => $periode, 'caraPrint' => $caraPrint));
    }
    public function actionFrameGrafikLaporanPenerimaanItems()
    {
        $this->layout = '//layouts/iframe';

        $model = new GFPenerimaanBarangT;
        $model->tgl_awal = date('Y-m-d 00:00:00');
        $model->tgl_akhir = date('Y-m-d 23:59:59');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Penerimaan Items';
        $data['type'] = $_GET['type'];

        if (isset($_GET['GFPenerimaanBarangT'])) {
            $format = new MyFormatter();
            $model->attributes = $_GET['GFPenerimaanBarangT'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFPenerimaanBarangT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFPenerimaanBarangT']['tgl_akhir']);
        }

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    //    ====================AKHIR LAPORAN PENERIMAAN ITEMS

    public function actionLaporanPembelian()
    {
        $model = new GFFakturpembelianT('searchLaporan');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['GFFakturpembelianT'])) {
            $model->attributes = $_GET['GFFakturpembelianT'];
            $model->jns_periode = $_GET['GFFakturpembelianT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFFakturpembelianT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFFakturpembelianT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFFakturpembelianT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFFakturpembelianT']['bln_akhir']);
            $model->thn_awal = $_GET['GFFakturpembelianT']['thn_awal'];
            $model->thn_akhir = $_GET['GFFakturpembelianT']['thn_akhir'];
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
        $this->render('fakturPembelianT/index', array(
            'format' => $format,
            'model' => $model,
            'tgl_awal' => $model->tgl_awal,
            'tgl_akhir' => $model->tgl_akhir,
        ));
    }

    public function actionPrintLaporanPembelian()
    {
        $model = new GFFakturpembelianT();
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        $judulLaporan = "Laporan Faktur Pembelian";
        if ($_GET['filter_tab'] == "rekap") {
            $judulLaporan = 'Total Faktur Pembelian';
            $data['title'] = 'Grafik Total Faktur Pembelian';
            $model->tabPrint =  $_GET['filter_tab'];
        } else if ($_REQUEST['filter_tab'] == "detail") {
            $judulLaporan = 'Detail Faktur';
            $data['title'] = 'Grafik Detail Faktur';
            $model->tabPrint =  $_GET['filter_tab'];
        }

        //Data Grafik
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type']  : null);
        if (isset($_REQUEST['GFFakturpembelianT'])) {
            $model->attributes = $_REQUEST['GFFakturpembelianT'];
            $model->jns_periode = $_REQUEST['GFFakturpembelianT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFFakturpembelianT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFFakturpembelianT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFFakturpembelianT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFFakturpembelianT']['bln_akhir']);
            $model->thn_awal = $_GET['GFFakturpembelianT']['thn_awal'];
            $model->thn_akhir = $_GET['GFFakturpembelianT']['thn_akhir'];
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

        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'fakturPembelianT/Print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionPrintDetailFakturPembelian($idFaktur = null)
    {
        $idFaktur = $idFaktur;
        $model = new GFFakturpembelianT();
        $modFaktur = GFFakturpembelianT::model()->findByPk($idFaktur);
        $modFakturDetail = GFFakturDetailT::model()->findAllByAttributes(array('fakturpembelian_id' => $idFaktur));
        $modTerima = GFPenerimaanBarangT::model()->findByAttributes(array('fakturpembelian_id' => $idFaktur));
        $modDetail = GFPenerimaanDetailT::model()->findAllByAttributes(array('penerimaanbarang_id' => $modTerima->penerimaanbarang_id));

        $model->tgl_awal = date('Y-m-d 00:00:00');
        $model->tgl_akhir = date('Y-m-d 23:59:59');

        $judulLaporan = 'Detail Faktur';

        //Data Grafik
        $data['title'] = 'Grafik Detail Faktur';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['GFFakturpembelianT'])) {
            $model->attributes = $_REQUEST['GFFakturpembelianT'];
            $format = new MyFormatter();
            $model->jns_periode = $_REQUEST['GFFakturpembelianT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFFakturpembelianT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFFakturpembelianT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFFakturpembelianT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFFakturpembelianT']['bln_akhir']);
            $model->thn_awal = $_GET['GFFakturpembelianT']['thn_awal'];
            $model->thn_akhir = $_GET['GFFakturpembelianT']['thn_akhir'];
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

        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'fakturPembelianT/detailPrint';

        $format = new MyFormatter();
        $periode = $this->parserTanggal($model->tgl_awal) . ' s/d ' . $this->parserTanggal($model->tgl_akhir);

        $this->layout = '//layouts/printWindows';
        $this->render($target, array('model' => $model, 'idFaktur' => $idFaktur, 'tgl_awal' => $model->tgl_awal, 'modFaktur' => $modFaktur, 'tgl_akhir' => $model->tgl_akhir, 'modDetail' => $modDetail, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    }

    public function actionFrameGrafikLaporanPembelian()
    {
        $this->layout = '//layouts/iframe';

        $model = new GFFakturpembelianT();
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        $data['type'] = $_GET['type'];
        $judulLaporan = "Grafik Laporan Faktur Pembelia";
        if ($_GET['filter_tab'] == "rekap") {
            $data['title'] = 'Grafik Laporan Faktur Pembelian';
        } else if ($_REQUEST['filter_tab'] == "detail") {
            $data['title'] = 'Grafik Laporan Faktur Pembelian';
        }

        if (isset($_GET['GFFakturpembelianT'])) {
            $model->attributes = $_REQUEST['GFFakturpembelianT'];
            $model->jns_periode = $_REQUEST['GFFakturpembelianT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFFakturpembelianT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFFakturpembelianT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFFakturpembelianT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFFakturpembelianT']['bln_akhir']);
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

    public function actionLaporanStock()
    {
        $this->pageTitle = Yii::app()->name . " - Stok Obat Alkes";
        $model = new GFInfostokobatalkesruanganV;
        $model->unsetAttributes();
        //$model->qtystok_in = '0';
        // $model->qtystok_out = '0';
        if (isset($_GET['GFInfostokobatalkesruanganV'])) {
            $format = new MyFormatter;
            $model->attributes = $_GET['GFInfostokobatalkesruanganV'];
            $model->qtystok_in = isset($_GET['GFInfostokobatalkesruanganV']['qtystok_in']) ? $_GET['GFInfostokobatalkesruanganV']['qtystok_in'] : '';
            $model->qtystok_out = isset($_GET['GFInfostokobatalkesruanganV']['qtystok_out']) ? $_GET['GFInfostokobatalkesruanganV']['qtystok_out'] : '';
            //$model->stok = isset($_GET['GFInfostokobatalkesruanganV']['stok'])?$_GET['GFInfostokobatalkesruanganV']['stok']:'';
        }
        $this->render('stock/stock', array(
            'model' => $model,
        ));
    }

    public function actionPrintStock()
    {
        $model = new GFInfostokobatalkesruanganV;
        // $model->tgl_awal = date('Y-m-d 00:00:00');
        // $model->tgl_akhir = date('Y-m-d 23:59:59');
        $model->qtystok_in = '0';
        $model->qtystok_out = '0';
        $judulLaporan = 'Stock Barang';

        //Data Grafik
        $data['title'] = 'Grafik Stock';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type']  : null);
        if (isset($_REQUEST['GFInfostokobatalkesruanganV'])) {
            $model->attributes = $_GET['GFInfostokobatalkesruanganV'];
            $model->qtystok_in = isset($_GET['GFInfostokobatalkesruanganV']['qtystok_in']) ? $_GET['GFInfostokobatalkesruanganV']['qtystok_in'] : '';
            $model->qtystok_out = isset($_GET['GFInfostokobatalkesruanganV']['qtystok_out']) ? $_GET['GFInfostokobatalkesruanganV']['qtystok_out'] : '';
        }
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'stock/printStock';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameStock()
    {
        $this->layout = '//layouts/iframe';

        $model = new GFInfostokobatalkesruanganV;
        //  $model->tgl_awal = date('Y-m-d 00:00:00');
        // $model->tgl_akhir = date('Y-m-d 23:59:59');
        $model->qtystok_in = '0';
        $model->qtystok_out = '0';
        //Data Grafik
        $data['title'] = 'Grafik Stock Barang';
        $data['type'] = $_GET['type'];

        if (isset($_REQUEST['GFInfostokobatalkesruanganV'])) {
            $format = new MyFormatter;
            $model->attributes = $_GET['GFInfostokobatalkesruanganV'];
            $model->qtystok_in = isset($_GET['GFInfostokobatalkesruanganV']['qtystok_in']) ? $_GET['GFInfostokobatalkesruanganV']['qtystok_in'] : '';
            $model->qtystok_out = isset($_GET['GFInfostokobatalkesruanganV']['qtystok_out']) ? $_GET['GFInfostokobatalkesruanganV']['qtystok_out'] : '';
        }
        $searchdata = $model->searchGrafik();
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
            'searchdata' => $searchdata,
        ));
    }

    public function actionLaporanRencanaKebutuhan()
    {
        $model = new GFRencanaKebFarmasiT;
        $model->unsetAttributes();
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['GFRencanaKebFarmasiT'])) {
            $format = new MyFormatter;
            $model->attributes = $_GET['GFRencanaKebFarmasiT'];
            $model->jns_periode = $_GET['GFRencanaKebFarmasiT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFRencanaKebFarmasiT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFRencanaKebFarmasiT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFRencanaKebFarmasiT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFRencanaKebFarmasiT']['bln_akhir']);
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

        $this->render('rencanaKebutuhan/rencanaKebutuhan', array(
            'model' => $model, 'format' => $format
        ));
    }

    public function actionPrintRencanaKebutuhan()
    {
        $model = new GFRencanaKebFarmasiT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Rencana Kebutuhan';

        //Data Grafik
        $data['title'] = 'Grafik Rencana Kebutuhan';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type']  : null);
        if (isset($_REQUEST['GFRencanaKebFarmasiT'])) {
            $model->attributes = $_REQUEST['GFRencanaKebFarmasiT'];
            $model->jns_periode = $_REQUEST['GFRencanaKebFarmasiT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFRencanaKebFarmasiT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFRencanaKebFarmasiT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFRencanaKebFarmasiT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFRencanaKebFarmasiT']['bln_akhir']);
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
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'rencanaKebutuhan/printRencana';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameRencanaKebutuhan()
    {
        $this->layout = '//layouts/iframe';

        $model = new GFRencanaKebFarmasiT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Rencana Kebutuhan';
        $data['type'] = $_GET['type'];

        if (isset($_REQUEST['GFRencanaKebFarmasiT'])) {
            $format = new MyFormatter;
            $model->attributes = $_GET['GFRencanaKebFarmasiT'];
            $model->jns_periode = $_REQUEST['GFRencanaKebFarmasiT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFRencanaKebFarmasiT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFRencanaKebFarmasiT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFRencanaKebFarmasiT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFRencanaKebFarmasiT']['bln_akhir']);
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
        $searchdata = $model->searchGrafik();
        $this->render('_grafik', array(
            'format' => $format,
            'model' => $model,
            'data' => $data,
            'searchdata' => $searchdata,
        ));
    }

    // End Added //

    /* laporan stock opname */
    public function actionLaporanStockOpname()
    {
        $this->pageTitle = Yii::app()->name . " - Stock Opname";
        $model = new GFLaporanfarmasikopnameV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['GFLaporanfarmasikopnameV'])) {
            $format = new MyFormatter();
            $model->attributes = $_GET['GFLaporanfarmasikopnameV'];
            $model->jns_periode = $_GET['GFLaporanfarmasikopnameV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFLaporanfarmasikopnameV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFLaporanfarmasikopnameV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFLaporanfarmasikopnameV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFLaporanfarmasikopnameV']['bln_akhir']);
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
            if (isset($_GET['GFLaporanfarmasikopnameV']['jenisobatalkes_id'])) {
                $model->jenisobatalkes_id = $_GET['GFLaporanfarmasikopnameV']['jenisobatalkes_id'];
            }
        }

        $this->render('stockOpname/admin', array(
            'model' => $model, 'format' => $format
        ));
    }

    public function actionPrintLaporanStockOpname()
    {
        $model = new GFLaporanfarmasikopnameV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Stock Opname';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Stock Opname';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['GFLaporanfarmasikopnameV'])) {
            $format = new MyFormatter();
            $model->attributes = $_REQUEST['GFLaporanfarmasikopnameV'];
            $model->jns_periode = $_REQUEST['GFLaporanfarmasikopnameV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFLaporanfarmasikopnameV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFLaporanfarmasikopnameV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFLaporanfarmasikopnameV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFLaporanfarmasikopnameV']['bln_akhir']);
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
            if (!empty($_REQUEST['GFLaporanfarmasikopnameV']['jenisobatalkes_id'])) {
                $model->jenisobatalkes_id = $_REQUEST['GFLaporanfarmasikopnameV']['jenisobatalkes_id'];
            }
        }

        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'stockOpname/_printStockOpname';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikStockOpname()
    {
        $this->layout = '//layouts/iframe';
        $model = new GFLaporanfarmasikopnameV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Stock Opname';
        $data['type'] = $_GET['type'];
        if (isset($_GET['GFLaporanfarmasikopnameV'])) {
            $model->attributes = $_GET['GFLaporanfarmasikopnameV'];
            $format = new MyFormatter();
            $model->jns_periode = $_REQUEST['GFLaporanfarmasikopnameV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFLaporanfarmasikopnameV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFLaporanfarmasikopnameV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFLaporanfarmasikopnameV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFLaporanfarmasikopnameV']['bln_akhir']);
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
            'model' => $model, 'format' => $format,
            'data' => $data,
        ));
    }
    /* end laporan stock opname */


    /* laporan formulir opname */
    public function actionLaporanFormulirOpnameObatAlkes()
    {
        $this->pageTitle = Yii::app()->name . " - Formulir Opname Obat Alkes";
        $model = new GFInformasiformuliropnameV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['GFInformasiformuliropnameV'])) {
            $format = new MyFormatter();
            $model->attributes = $_GET['GFInformasiformuliropnameV'];
            $model->jns_periode = $_GET['GFInformasiformuliropnameV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFInformasiformuliropnameV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasiformuliropnameV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFInformasiformuliropnameV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFInformasiformuliropnameV']['bln_akhir']);
            $model->thn_awal = $_GET['GFInformasiformuliropnameV']['thn_awal'];
            $model->thn_akhir = $_GET['GFInformasiformuliropnameV']['thn_akhir'];
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
            if (!empty($_GET['GFInformasiformuliropnameV']['status'])) {
                $model->status = $_GET['GFInformasiformuliropnameV']['status'];
            }
        }

        $this->render('formulirOpnameObatAlkes/admin', array(
            'model' => $model, 'format' => $format
        ));
    }

    public function actionPrintLaporanFormulirOpnameObatAlkes()
    {
        $model = new GFInformasiformuliropnameV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Formulir Opname Obat Alkes';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Stock Opname';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['GFInformasiformuliropnameV'])) {
            $format = new MyFormatter();
            $model->attributes = $_REQUEST['GFInformasiformuliropnameV'];
            $model->jns_periode = $_REQUEST['GFInformasiformuliropnameV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFInformasiformuliropnameV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFInformasiformuliropnameV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFInformasiformuliropnameV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFInformasiformuliropnameV']['bln_akhir']);
            $model->thn_awal = $_GET['GFInformasiformuliropnameV']['thn_awal'];
            $model->thn_akhir = $_GET['GFInformasiformuliropnameV']['thn_akhir'];
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
            if (!empty($_GET['GFInformasiformuliropnameV']['status'])) {
                $model->status = $_GET['GFInformasiformuliropnameV']['status'];
            }
        }

        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'formulirOpnameObatAlkes/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikFormulirOpnameObatAlkes()
    {
        $this->layout = '//layouts/iframe';
        $model = new GFInformasiformuliropnameV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Formulir Opname Obat Alkes';
        $data['type'] = $_GET['type'];
        if (isset($_GET['GFInformasiformuliropnameV'])) {
            $model->attributes = $_GET['GFInformasiformuliropnameV'];
            $format = new MyFormatter();
            $model->jns_periode = $_REQUEST['GFInformasiformuliropnameV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFInformasiformuliropnameV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFInformasiformuliropnameV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFInformasiformuliropnameV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFInformasiformuliropnameV']['bln_akhir']);
            $model->thn_awal = $_GET['GFInformasiformuliropnameV']['thn_awal'];
            $model->thn_akhir = $_GET['GFInformasiformuliropnameV']['thn_akhir'];
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
            $model->status = $_GET['GFInformasiformuliropnameV']['status'];
        }

        $this->render('_grafik', array(
            'model' => $model, 'format' => $format,
            'data' => $data,
        ));
    }
    /* end laporan formulir opname */

    /* laporan Tanggal Kedaluwarsa */
    public function actionObatAlkesKadaluarsa()
    {
        $this->pageTitle = Yii::app()->name . " - Obat Alkes Kedaluwarsa";
        $model = new GFInfostokobatalkesruanganV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['GFInfostokobatalkesruanganV'])) {
            $format = new MyFormatter();
            $model->attributes = $_GET['GFInfostokobatalkesruanganV'];
            $model->jns_periode = $_GET['GFInfostokobatalkesruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFInfostokobatalkesruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInfostokobatalkesruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFInfostokobatalkesruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFInfostokobatalkesruanganV']['bln_akhir']);
            $model->thn_awal = $_GET['GFInfostokobatalkesruanganV']['thn_awal'];
            $model->thn_akhir = $_GET['GFInfostokobatalkesruanganV']['thn_akhir'];
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
            if (!empty($_GET['GFInfostokobatalkesruanganV']['status'])) {
                $model->status = $_GET['GFInfostokobatalkesruanganV']['status'];
            }
        }
        $grafik = $model->searchGrafikObatAlkesKadaluarsa();
        $this->render('obatAlkesKadaluarsa/admin', array(
            'model' => $model, 'format' => $format, 'grafik' => $grafik
        ));
    }

    public function actionPrintObatAlkesKadaluarsa()
    {
        $model = new GFInfostokobatalkesruanganV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Obat Alkes Kedaluwarsa';

        //Data Grafik       
        $data['title'] = 'Grafik Obat Alkes Kedaluwarsa';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['GFInfostokobatalkesruanganV'])) {
            $format = new MyFormatter();
            $model->attributes = $_REQUEST['GFInfostokobatalkesruanganV'];
            $model->jns_periode = $_REQUEST['GFInfostokobatalkesruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFInfostokobatalkesruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFInfostokobatalkesruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFInfostokobatalkesruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFInfostokobatalkesruanganV']['bln_akhir']);
            $model->thn_awal = $_GET['GFInfostokobatalkesruanganV']['thn_awal'];
            $model->thn_akhir = $_GET['GFInfostokobatalkesruanganV']['thn_akhir'];
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
            if (!empty($_GET['GFInfostokobatalkesruanganV']['status'])) {
                $model->status = $_GET['GFInfostokobatalkesruanganV']['status'];
            }
        }

        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'obatAlkesKadaluarsa/_print';
        $grafik = $model->searchGrafikObatAlkesKadaluarsa();
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $grafik);
    }

    public function actionFrameGrafikObatAlkesKadaluarsa()
    {
        $this->layout = '//layouts/iframe';
        $model = new GFInfostokobatalkesruanganV('search');
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
        $data['title'] = 'Grafik Obat Alkes Kedaluwarsa';
        $data['type'] = $_GET['type'];
        if (isset($_GET['GFInfostokobatalkesruanganV'])) {
            $model->attributes = $_GET['GFInfostokobatalkesruanganV'];
            $format = new MyFormatter();
            $model->jns_periode = $_REQUEST['GFInfostokobatalkesruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFInfostokobatalkesruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFInfostokobatalkesruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFInfostokobatalkesruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFInfostokobatalkesruanganV']['bln_akhir']);
            $model->thn_awal = $_GET['GFInfostokobatalkesruanganV']['thn_awal'];
            $model->thn_akhir = $_GET['GFInfostokobatalkesruanganV']['thn_akhir'];
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
            if (!empty($_GET['GFInfostokobatalkesruanganV']['status'])) {
                $model->status = $_GET['GFInfostokobatalkesruanganV']['status'];
            }
        }
        $grafik = $model->searchGrafikObatAlkesKadaluarsa();
        $this->render('_grafik', array(
            'model' => $model, 'format' => $format,
            'data' => $data, 'grafik' => $grafik
        ));
    }
    /* end laporan tanggal kedaluwarsa */

    /* laporan permintaan penawaran */
    public function actionLaporanPermintaanPenawaran()
    {
        $model = new GFInformasipermintaanpenawaranV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['GFInformasipermintaanpenawaranV'])) {
            $format = new MyFormatter();
            $model->attributes = $_GET['GFInformasipermintaanpenawaranV'];
            $model->jns_periode = $_GET['GFInformasipermintaanpenawaranV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFInformasipermintaanpenawaranV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasipermintaanpenawaranV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFInformasipermintaanpenawaranV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFInformasipermintaanpenawaranV']['bln_akhir']);
            $model->thn_awal = $_GET['GFInformasipermintaanpenawaranV']['thn_awal'];
            $model->thn_akhir = $_GET['GFInformasipermintaanpenawaranV']['thn_akhir'];
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
        $grafik = $model->searchGrafikLaporanInformasiPenawaran();
        $this->render('permintaanPenawaran/admin', array(
            'model' => $model, 'format' => $format, 'grafik' => $grafik
        ));
    }

    public function actionPrintLaporanPermintaanPenawaran()
    {
        $model = new GFInformasipermintaanpenawaranV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Permintaan Penawaran';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Permintaan Penawaran';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['GFInformasipermintaanpenawaranV'])) {
            $format = new MyFormatter();
            $model->attributes = $_REQUEST['GFInformasipermintaanpenawaranV'];
            $model->jns_periode = $_REQUEST['GFInformasipermintaanpenawaranV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFInformasipermintaanpenawaranV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFInformasipermintaanpenawaranV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFInformasipermintaanpenawaranV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFInformasipermintaanpenawaranV']['bln_akhir']);
            $model->thn_awal = $_GET['GFInformasipermintaanpenawaranV']['thn_awal'];
            $model->thn_akhir = $_GET['GFInformasipermintaanpenawaranV']['thn_akhir'];
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
        $grafik = $model->searchGrafikLaporanInformasiPenawaran();
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'permintaanPenawaran/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $grafik);
    }

    public function actionFrameGrafikLaporanPermintaanPenawaran()
    {
        $this->layout = '//layouts/iframe';
        $model = new GFInformasipermintaanpenawaranV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Permintaan Penawaran';
        $data['type'] = $_GET['type'];
        if (isset($_GET['GFInformasipermintaanpenawaranV'])) {
            $model->attributes = $_GET['GFInformasipermintaanpenawaranV'];
            $format = new MyFormatter();
            $model->jns_periode = $_REQUEST['GFInformasipermintaanpenawaranV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFInformasipermintaanpenawaranV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFInformasipermintaanpenawaranV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFInformasipermintaanpenawaranV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFInformasipermintaanpenawaranV']['bln_akhir']);
            $model->thn_awal = $_GET['GFInformasipermintaanpenawaranV']['thn_awal'];
            $model->thn_akhir = $_GET['GFInformasipermintaanpenawaranV']['thn_akhir'];
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
        $grafik = $model->searchGrafikLaporanInformasiPenawaran();
        $this->render('_grafik', array(
            'model' => $model, 'format' => $format,
            'data' => $data, 'grafik' => $grafik
        ));
    }
    /* end laporan permintaan penawaran */

    public function actionLaporanPermintaanPembelian()
    {
        $this->pageTitle = Yii::app()->name . " - Permintaan Pembelian";
        $model = new GFPermintaanPembelianT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['GFPermintaanPembelianT'])) {
            $format = new MyFormatter;
            $model->attributes = $_GET['GFPermintaanPembelianT'];
            $model->jns_periode = $_GET['GFPermintaanPembelianT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFPermintaanPembelianT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFPermintaanPembelianT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFPermintaanPembelianT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFPermintaanPembelianT']['bln_akhir']);
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
        $this->render('permintaanPembelian/index', array(
            'model' => $model, 'format' => $format
        ));
    }

    public function actionPrintLaporanPermintaanPembelian()
    {
        $model = new GFPermintaanPembelianT('search');
        $judulLaporan = 'Laporan Permintaan Pembelian';
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Permintaan Pembelian';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['GFPermintaanPembelianT'])) {
            $model->attributes = $_REQUEST['GFPermintaanPembelianT'];
            $model->jns_periode = $_REQUEST['GFPermintaanPembelianT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFPermintaanPembelianT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFPermintaanPembelianT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFPermintaanPembelianT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFPermintaanPembelianT']['bln_akhir']);
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

        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'permintaanPembelian/Print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
    public function actionPrintDetailLaporanPermintaanPembelian($id = null, $idPembelian = null)
    {
        $model = new GFPermintaanPembelianT();
        $modDetail = GFPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id' => $idPembelian));
        $judulLaporan = 'Laporan Permintaan Pembelian';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Permintaan Pembelian';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['GFPermintaanPembelianT'])) {
            $model->attributes = $_REQUEST['GFPermintaanPembelianT'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFPermintaanPembelianT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFPermintaanPembelianT']['tgl_akhir']);
        }

        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'permintaanPembelian/detailPrint';

        $format = new MyFormatter();
        $periode = $this->parserTanggal($model->tgl_awal) . ' s/d ' . $this->parserTanggal($model->tgl_akhir);

        $this->layout = '//layouts/printWindows';
        $this->render($target, array('model' => $model, 'modDetail' => $modDetail, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    }

    public function actionFrameGrafikLaporanPermintaanPembelian()
    {
        $this->layout = '//layouts/iframe';

        $model = new GFPermintaanPembelianT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Permintaan Pembelian';
        $data['type'] = $_GET['type'];

        if (isset($_GET['GFPermintaanPembelianT'])) {
            $format = new MyFormatter();
            $model->attributes = $_GET['GFPermintaanPembelianT'];
            $model->jns_periode = $_GET['GFPermintaanPembelianT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFPermintaanPembelianT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFPermintaanPembelianT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFPermintaanPembelianT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFPermintaanPembelianT']['bln_akhir']);
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
     * end Laporan Permintaan Pembelian
     */

    public function actionLaporanPenerimaanJenisItems()
    {
        $model = new GFPenerimaanBarangT('searchPenerimaanItems');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['GFPenerimaanBarangT'])) {
            $format = new MyFormatter;
            $model->attributes = $_GET['GFPenerimaanBarangT'];
            $model->jns_periode = $_GET['GFPenerimaanBarangT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFPenerimaanBarangT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFPenerimaanBarangT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFPenerimaanBarangT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFPenerimaanBarangT']['bln_akhir']);
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
        $this->render('penerimaanJenisItems/index', array(
            'format' => $format,
            'model' => $model,
            'tgl_awal' => $model->tgl_awal,
            'tgl_akhir' => $model->tgl_akhir,
        ));
    }
    public function actionPrintLaporanPenerimaanJenisItems()
    {
        $model = new GFPenerimaanBarangT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $sumberdana = 0;
        $jenisobat = 0;
        if (!empty($_GET['GFPenerimaanBarangT']['sumberdana_id'])) {
            $sumberdana = SumberdanaM::model()->findByPk($_GET['GFPenerimaanBarangT']['sumberdana_id']);
        }
        if (!empty($_GET['GFPenerimaanBarangT']['jenisobatalkes_id'])) {
            $jenisobat = JenisobatalkesM::model()->findByPk($_GET['GFPenerimaanBarangT']['jenisobatalkes_id']);
        }


        if (!empty($sumberdana)) {
            $kondisi = $sumberdana->sumberdana_nama;
        } else if (!empty($jenisobat)) {
            $kondisi = $jenisobat->jenisobatalkes_nama;
        } else {
            $kondisi = '-';
        }
        $judulLaporan = 'Laporan Penerimaan Items Berdasarkan Kelompok : Obat ' . $kondisi . '';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Penerimaan Items Berdasarkan Jenis ';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['GFPenerimaanBarangT'])) {
            $model->attributes = $_REQUEST['GFPenerimaanBarangT'];
            $model->jns_periode = $_REQUEST['GFPenerimaanBarangT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFPenerimaanBarangT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFPenerimaanBarangT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFPenerimaanBarangT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFPenerimaanBarangT']['bln_akhir']);
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

        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'penerimaanJenisItems/Print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
    public function actionPrintDetLapTerimaJenis($idTerimaBarang = null)
    {
        $model = GFPenerimaanBarangT::model()->findByPk($idTerimaBarang);
        $modDetail = GFPenerimaanDetailT::model()->findAllByAttributes(array('penerimaanbarang_id' => $model->penerimaanbarang_id));

        $judulLaporan = 'Laporan Penerimaan Items Berdasarkan Kelompok : Obat';

        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'penerimaanJenisItems/detailPrint';

        $format = new MyFormatter();
        $periode = $this->parserTanggal($model->tgl_awal) . ' s/d ' . $this->parserTanggal($model->tgl_akhir);

        $this->layout = '//layouts/printWindows';
        $this->render($target, array('model' => $model, 'modDetail' => $modDetail, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    }
    public function actionFrameGrafikLaporanPenerimaanJenisItems()
    {
        $this->layout = '//layouts/iframe';

        $model = new GFPenerimaanBarangT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Penerimaan Items Berdasarkan Jenis ';
        $data['type'] = $_GET['type'];

        if (isset($_GET['GFPenerimaanBarangT'])) {
            $format = new MyFormatter();
            $model->attributes = $_GET['GFPenerimaanBarangT'];
            $model->jns_periode = $_GET['GFPenerimaanBarangT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFPenerimaanBarangT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFPenerimaanBarangT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFPenerimaanBarangT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFPenerimaanBarangT']['bln_akhir']);
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
            'format' => $format,
            'model' => $model,
            'data' => $data,
        ));
    }
    /*
     * end Laporan Penerimaan Items Berdasarkan Jenis
     */
    /* ============================= Keperluan function laporan ======================================== */
    protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target, $grafik = '', $periode = '')
    {
        $format = new MyFormatter();
        //        $model->tgl_awal = date('Y-m-d h:i:s',strtotime($model->tgl_awal));
        //        $model->tgl_akhir = date('Y-m-d h:i:s',strtotime($model->tgl_akhir));
        //var_dump($periode);die;
        //var_dump($grafik);die;
        if (empty($periode)) {
            $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
        }
        //        var_dump($model->tgl_awal);
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('grafik' => $grafik, 'model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ((isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null) == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
            $mpdf->WriteHTML($formatkonten, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $period = '';

            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

    protected function parserTanggal($tgl)
    {
        $tgl = date('Y-m-d h:i:s', strtotime($tgl));
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
     * awal laporan pemakaian obat
     */

    public function actionPemakaianObat()
    {
        $this->pageTitle = Yii::app()->name . " - Pemakaian Obat";
        $model = new GFLaporanpenjualanobatV();
        $format = new MyFormatter();
        $model->bulan = (int)date("m");
        $model->tahun = date("Y");
        $model->tabmenu = 'pakai-obat';
        //        $model->unsetAttributes();
        if (isset($_REQUEST['GFLaporanpenjualanobatV'])) {
            $model->attributes = $_REQUEST['GFLaporanpenjualanobatV'];
            $model->tahun = $_REQUEST['GFLaporanpenjualanobatV']['tahun'];
            $model->bulan = $_REQUEST['GFLaporanpenjualanobatV']['bulan'];
            $model->status = isset($_REQUEST['GFLaporanpenjualanobatV']['status']) ? $_REQUEST['GFLaporanpenjualanobatV']['status'] : null;
            $model->tabmenu = $_REQUEST['GFLaporanpenjualanobatV']['tabmenu'];

            if ($model->tabmenu == 'pakai-menu') {
                $data['title'] = 'Laporan Rekapitulasi Pemakaian Obat';
            }
        }


        $this->render($this->path_view_gudang . 'pemakaianObat/admin', array(
            'model' => $model,
        ));
    }

    public function actionPrintPemakaianObat()
    {
        $model = new GFLaporanpenjualanobatV('search');
        $judulLaporan = 'Laporan Pemakaian Obat';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Pemakaian Obat';
        $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
        $periode = '';
        $grafik = '';
        if (isset($_REQUEST['GFLaporanpenjualanobatV'])) {
            $model->attributes = $_REQUEST['GFLaporanpenjualanobatV'];
            $format = new MyFormatter();
            $model->tahun = $_REQUEST['GFLaporanpenjualanobatV']['tahun'];
            $model->bulan = $_REQUEST['GFLaporanpenjualanobatV']['bulan'];
            $model->status = isset($_REQUEST['GFLaporanpenjualanobatV']['status']) ? $_REQUEST['GFLaporanpenjualanobatV']['status'] : null;

            $periode .= MyFormatter::getMonthId($model->bulan) . ' ' . $model->tahun;

            $model->tabmenu = $_REQUEST['GFLaporanpenjualanobatV']['tabmenu'];

            if ($model->tabmenu == 'rekap-pakai-obat') {
                $data['title'] = 'Grafik Laporan Rekapitulasi Pemakaian Obat';
                $grafik = $model->frameGrafikRekapPakaiObat();
                $judulLaporan = 'Laporan Rekapitulasi Pemakaian Obat';
            }
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view_gudang . 'pemakaianObat/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $grafik, $periode);
    }

    public function actionFrameGrafikPemakaianObat()
    {
        $this->layout = '//layouts/iframe';
        $model = new GFLaporanpenjualanobatV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        //Data Grafik
        $data['title'] = 'Grafik Pemakaian Obat';
        $data['type'] = $_GET['type'];

        $grafik = null;

        if (isset($_GET['GFLaporanpenjualanobatV'])) {
            $model->attributes = $_GET['GFLaporanpenjualanobatV'];
            $format = new MyFormatter();
            $model->tahun = $_REQUEST['GFLaporanpenjualanobatV']['tahun'];
            $model->bulan = $_REQUEST['GFLaporanpenjualanobatV']['bulan'];
            $model->status = isset($_REQUEST['GFLaporanpenjualanobatV']['status']) ? $_REQUEST['GFLaporanpenjualanobatV']['status'] : null;
            $model->tabmenu = $_REQUEST['GFLaporanpenjualanobatV']['tabmenu'];

            if ($model->tabmenu == 'rekap-pakai-obat') {
                $data['title'] = 'Grafik Laporan Rekapitulasi Pemakaian Obat';
                $grafik = $model->frameGrafikRekapPakaiObat();
            }
        }

        $this->render($this->path_view_gudang . 'pemakaianObat/_grafik', array(
            'model' => $model,
            'data' => $data,
            'grafik' => $grafik
        ));
    }

    /**
     * akhir laporan pemakaian obat
     */
}
