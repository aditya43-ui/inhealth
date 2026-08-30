<?php
/**
 * Controller untuk Tindak Lanjut IGD
 * 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.sistemInformasiEksekutif
 * @subpackage controllers
 * @category controller
 */
class TindakLanjutRDController extends MyAuthController {

    public $path_view = 'sistemInformasiEksekutif.views.tindakLanjutRD.';

    /**
     * Load halaman index
     */
    public function actionIndex() {
        $this->render('index');
    }

    /**
     * menampilkan halaman dashboard (iframe)
     * beberapa menggunakan DAO (createCommand) agar lebih cepat
     */
    public function actionSetIFrameDashboard() {
        $this->layout = '//layouts/iframeNeon';
        $format = new MyFormatter();
        //=== start 4 kolom ===
        $dataPie = array();
        $dataPieChart = array();
        $dataBarLineChart = array();

        $format = new MyFormatter();
        $model = new SETindaklanjutigdR();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['SETindaklanjutigdR'])) {
            $model->attributes = $_GET['SETindaklanjutigdR'];
            $model->jns_periode = $_GET['SETindaklanjutigdR']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['SETindaklanjutigdR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SETindaklanjutigdR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['SETindaklanjutigdR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['SETindaklanjutigdR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal = $_GET['SETindaklanjutigdR']['thn_awal'];
            $model->thn_akhir = $_GET['SETindaklanjutigdR']['thn_akhir'];
            $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
            switch ($model->jns_periode) {
                case 'bulan' : $model->tgl_awal = $model->bln_awal . "-01";
                    $model->tgl_akhir = $bln_akhir;
                    break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal . "-01-01";
                    $model->tgl_akhir = $thn_akhir;
                    break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal;
            $model->tgl_akhir = $model->tgl_akhir;
        }

        $data = $model->generateTindakLanjutRD();

        $this->render('dashboard', array(
            'model' => $model,
            'load' => $data
        ));
    }

    /**
     * Load data 
     */
    public function actionCariData() {
        if (Yii::app()->request->isAjaxRequest) {
            $tgl_awal = isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : null;
            $tgl_akhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : null;

            $model = new SETindaklanjutigdR();
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($tgl_awal);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($tgl_akhir);


            $data = $model->generateTindakLanjutRD();

            $return['sukses'] = 1;
            $return['tile'] = $data['tile'];
            $return['grafik'] = $data['grafik'];

            echo json_encode($return);
            Yii::app()->end();
        }
    }
    
    /**
     * Digunakan untuk cetak laporan
     */
    public function actionPrint() {
        $model = new SETindaklanjutigdR();
        $format = new MyFormatter();
        $judulLaporan = 'Data Tindak Lanjut IGD';
        $data['title'] = 'Data Tindak Lanjut IGD';
        if (isset($_GET['SETindaklanjutigdR'])) {
            $model->attributes = $_GET['SETindaklanjutigdR'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['SETindaklanjutigdR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SETindaklanjutigdR']['tgl_akhir']);
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
        $periode = 
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

?>