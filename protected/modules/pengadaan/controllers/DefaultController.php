<?php

/**
 * Halaman beranda berisikan Statistik dan Grafik
 * @author Wahyu Wicaksono <wahyuwicaksono.@gmail.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class DefaultController extends MyAuthController {

    /**
     * Halaman Index
     */
    public function actionIndex() {
        $this->render('index', []);
    }

    /**
     * Halaman beranda
     */
    public function actionBeranda() {
        $model = new ADBeranda();
        $modDashboard = new DashboardperjalanandokumenpengadaanV(); 
        if (isset($_GET['DashboardperjalanandokumenpengadaanV'])) {
            $modDashboard->attributes = $_GET['DashboardperjalanandokumenpengadaanV'];
        }
        $model->periodeanggaran_id = PeriodeanggaranK::model()->findByAttributes(array('tahunanggaran' => date('Y')))->periodeanggaran_id;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $data = $model->search();

        $pejabat = $model->getPejabat();
        $periode = $model->getPeriode();
        $count = $data['count'];
        $load = $data['load'];
        
        $this->render('beranda', [
            'model' => $model,
            'modDashboard' => $modDashboard, 
            'pejabat' => $pejabat,
            'periode' => $periode,
            'count' => $count,
            'load' => $load,
            ''
        ]);
    }

    /**
     * Load Pencarian Dashboard 
     */
    public function actionCariData() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new ADBeranda();
            $model->periodeanggaran_id = $_POST['periode'];
            $model->pejabatpengadaan_id = $_POST['pejabat'];
            $model->sumberbiaya = $_POST['sumberbiaya'];
            $model->pegawaikpa_id = $_POST['pegawaikpa_id'];
            $model->pptk_id = $_POST['pptk_id'];
            $data = $model->search();
            echo json_encode($data);
        }
    }
    
    /**
     * Digunakan untuk cetak laporan
     */
    public function actionPrint() {
        $model = new DashboardperjalanandokumenpengadaanV('searchDashboard');
        $format = new MyFormatter();
        $judulLaporan = 'Data Pengadaan';
        $data['title'] = 'Data Pengadaan';
        if (isset($_GET['DashboardperjalanandokumenpengadaanV'])) {
            $model->attributes = $_GET['DashboardperjalanandokumenpengadaanV'];
        }
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'Print';

        $this->printFunction($model, $caraPrint, $judulLaporan, $target, $data);
    }

    /**
     * Fungsi untuk mencetak laporan
     * @param type $model
     * @param type $caraPrint
     * @param type $judulLaporan
     * @param type $target
     * @param type $data
     */
    protected function printFunction($model, $caraPrint, $judulLaporan, $target, $data) {
        $format = new MyFormatter();

        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows3';
            $this->render($target, array('model' => $model, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $kertas = Params::getUkuranKertas();
            $mpdf = new MyPDF('', $kertas['F4']);
//            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf->SetHTMLFooter($this->renderPartial('application.views.headerReport.footerLaporanBukuRegister', array('judulLaporan' => $judulLaporan, 'colspan' => 10), true));
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI_LANDSCAPE, '', '', '', '', 20, 20, 20, 55, 20, 20);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

}
