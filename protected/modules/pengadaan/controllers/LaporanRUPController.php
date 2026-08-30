<?php
/**
 * Controller untuk Laporan RUP 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class LaporanRUPController extends MyAuthController {

    public $path_view = 'pengadaan.views.laporanRUP.';

    /**
     * Halaman Index Laporan 
     */
    public function actionIndex() {
        $model = new LaporanrencanaumumpengadaanV();
        
        if (!empty($_GET['LaporanrencanaumumpengadaanV'])) {
            $model->attributes = $_GET['LaporanrencanaumumpengadaanV'];
        }
        $this->render($this->path_view . 'index', array(
            'model' => $model));
    }
    
    
    /**
     * Cetak Laporan RUP 
     * @param type $caraPrint
     */
    public function actionPrint($caraPrint = null) {
        $this->layout = '//layouts/printWindows';
        $model = new LaporanrencanaumumpengadaanV('search');
        $model->unsetAttributes();  // clear any default values

        if (!empty($_GET['LaporanrencanaumumpengadaanV'])) {
            $model->attributes = $_GET['LaporanrencanaumumpengadaanV'];
        }
        
        $periode = "";
        if (!empty($model->periodeanggaran_id)) {
            $modPeriode = PeriodeanggaranK::model()->findByPk($model->periodeanggaran_id);
            $periode = $modPeriode->tahunanggaran ." - ".$modPeriode->anggaran_nama;
        }
        $judulLaporan = "Laporan Rencana Umum Pengadaan";

        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array(
                'model' => $model,
                'judulLaporan' => $judulLaporan,
                'periode' => $periode,
                'caraPrint' => $caraPrint
            ));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array(
                'model' => $model,
                'judulLaporan' => $judulLaporan,
                'periode' => $periode,
                'caraPrint' => $caraPrint
            ));
        } else if ($caraPrint == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Params::DEFAULT_KERTAS_POSISI_LANDSCAPE;                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array(
                        'model' => $model,
                        'judulLaporan' => $judulLaporan,
                        'periode' => $periode,
                        'caraPrint' => $caraPrint
                            ), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

}
