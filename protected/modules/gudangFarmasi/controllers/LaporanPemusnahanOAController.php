<?php

class LaporanPemusnahanOAController extends MyAuthController
{
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'gudangFarmasi.views.laporanPemusnahanOA.';

    public function actionIndex()
    {
        $this->pageTitle = Yii::app()->name . " - Pemusnahan Obat dan Alkes";
        $model = new GFLaporanpemusnahanoaV;
        $model->unsetAttributes();
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['GFLaporanpemusnahanoaV'])) {
            $model->attributes = $_GET['GFLaporanpemusnahanoaV'];
            $model->jns_periode = $_GET['GFLaporanpemusnahanoaV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFLaporanpemusnahanoaV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFLaporanpemusnahanoaV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFLaporanpemusnahanoaV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFLaporanpemusnahanoaV']['bln_akhir']);
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

        $this->render('index', array('format' => $format, 'model' => $model));
    }

    /**
     * untuk print data pemusnahan OA
     */
    public function actionPrint()
    {
        $model = new GFLaporanpemusnahanoaV;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Pemusnahan Obat dan Alkes';

        //Data Grafik
        $data['title'] = 'Grafik Pemusnahan Obat dan Alkes';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type']  : null);
        if (isset($_REQUEST['GFLaporanpemusnahanoaV'])) {
            $model->attributes = $_REQUEST['GFLaporanpemusnahanoaV'];
            $model->jns_periode = $_REQUEST['GFLaporanpemusnahanoaV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFLaporanpemusnahanoaV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFLaporanpemusnahanoaV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFLaporanpemusnahanoaV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFLaporanpemusnahanoaV']['bln_akhir']);
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
        $target = 'print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFramePemusnahanOA()
    {
        $this->layout = '//layouts/iframe';

        $model = new GFLaporanpemusnahanoaV;
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
        $data['title'] = 'Grafik Pemusnahan Obat dan Alkes';
        $data['type'] = $_GET['type'];

        if (isset($_REQUEST['GFLaporanpemusnahanoaV'])) {
            $format = new MyFormatter;
            $model->attributes = $_GET['GFLaporanpemusnahanoaV'];
            $model->jns_periode = $_REQUEST['GFLaporanpemusnahanoaV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFLaporanpemusnahanoaV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFLaporanpemusnahanoaV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFLaporanpemusnahanoaV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFLaporanpemusnahanoaV']['bln_akhir']);
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

    /* ============================= Keperluan function laporan ======================================== */
    protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target)
    {
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
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
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }
}
