<?php
/**
 * Controller untuk Laporan Insiden Ditolak
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 * @category controllers
 */
class LaporanInsidenDitolakController extends MyAuthController {

    /**
     * Halaman Index Laporan Insiden Ditolak
     */
    public function actionIndex() {
        $model = new YKMInsidenRST();
        $model->tgl_awal = date("d M Y");
        $model->tgl_akhir = date("d M Y");
        if (isset($_GET['YKMInsidenRST'])) {
            $model->attributes = $_GET['YKMInsidenRST'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['YKMInsidenRST']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['YKMInsidenRST']['tgl_akhir']);
            $model->kategoripenolakan = $_GET['YKMInsidenRST']['kategoripenolakan'];
            $model->ruangan_id = isset($_GET['YKMInsidenRST']['ruangan_id']) ? $_GET['YKMInsidenRST']['ruangan_id'] : null;
        }
        $this->render('index', array('model' => $model));
    }

    /**
     * Digunakan untuk cetak laporan
     */
    public function actionPrint() {
        $model = new YKMInsidenRST('search');

        $format = new MyFormatter();
        $judulLaporan = 'Laporan Insiden Ditolak';
        if (isset($_GET['YKMInsidenRST'])) {
            $model->attributes = $_GET['YKMInsidenRST'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['YKMInsidenRST']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['YKMInsidenRST']['tgl_akhir']);
            $model->kategoripenolakan = $_GET['YKMInsidenRST']['kategoripenolakan'];
            $model->ruangan_id = isset($_GET['YKMInsidenRST']['ruangan_id']) ? $_GET['YKMInsidenRST']['ruangan_id'] : null;
        }
        $data['type'] = $_REQUEST['type'];
        $data['title'] = 'Grafik Laporan Insiden Ditolak';

        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'Print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    /**
     * Fungsi untuk mencetak laporan
     * @param type $model
     * @param type $caraPrint
     * @param type $judulLaporan
     * @param type $target
     */
    protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target) {
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);

        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows3';
            $this->render($target, array('model' => $model, 'data' => $data ,'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $kertas = Params::getUkuranKertas();
            $mpdf = new MyPDF('', $kertas['F4']);
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf->SetHTMLFooter($this->renderPartial('application.views.headerReport.footerLaporanBukuRegister', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 10), true));
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI, '', '', '', '', 20, 20, 20, 55, 20, 20);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

    /**
     * digunakan unyuk menampilkan grafik laporan penunjang
     */
    public function actionFrameGrafikLaporanInsidenDitolak() {
        $this->layout = '//layouts/iframe';
        $model = new YKMInsidenRST('search');
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
        $data['title'] = 'Grafik Laporan Insiden Ditolak';
        $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
        if (isset($_GET['YKMInsidenRST'])) {
            $model->attributes = $_GET['YKMInsidenRST'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['YKMInsidenRST']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['YKMInsidenRST']['tgl_akhir']);
            $model->kategoripenolakan = $_GET['YKMInsidenRST']['kategoripenolakan'];
            $model->ruangan_id = isset($_GET['YKMInsidenRST']['ruangan_id']) ? $_GET['YKMInsidenRST']['ruangan_id'] : null;
        }

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
}
