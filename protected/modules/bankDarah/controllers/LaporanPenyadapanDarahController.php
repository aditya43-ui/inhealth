<?php

/**
 * Digunakan sebagai Laporan Penyadapan Darah
 * @author  Andyka Putra<andykaputra@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 * */
class LaporanPenyadapanDarahController extends MyAuthController {

    public $path_view = 'bankDarah.views.laporanPenyadapanDarah.';

    /**
     * Fungsi load halaman laporan pengujian darah
     */
    public function actionIndex() {
        $model = new LappenyadapandarahV();
        $format = new MyFormatter();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

        if (isset($_GET['LappenyadapandarahV'])) {

            $model->attributes = $_GET['LappenyadapandarahV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LappenyadapandarahV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LappenyadapandarahV']['tgl_akhir']);
        }

        $this->render('admin', array(
            'model' => $model
        ));
    }

    /**
     * Fungsi cetak data laporan pengujian darah
     */
    public function actionPrint() {

        $model = new LappenyadapandarahV();
        $model->attributes = $_REQUEST['LappenyadapandarahV'];

        $format = new MyFormatter();
        if (!empty($_REQUEST['LappenyadapandarahV']['tgl_awal'])) {
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['LappenyadapandarahV']['tgl_awal']);
        }
        if (!empty($_REQUEST['LappenyadapandarahV']['tgl_awal'])) {
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['LappenyadapandarahV']['tgl_akhir']);
        }
        $judulLaporan = 'Laporan Penyadapan Darah';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $kertas = Params::getUkuranKertas();
            $mpdf = new MyPDF('', $kertas['F4']);
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait                
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI_LANDSCAPE, '', '', '', '', 20, 20, 20, 20, 20, 20);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

}
