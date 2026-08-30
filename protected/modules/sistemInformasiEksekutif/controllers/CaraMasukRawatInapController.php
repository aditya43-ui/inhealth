<?php
/**
 * Controller untuk dashboard cara masuk rawat inap
 * 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.sistemInformasiEksekutif 
 * @subpackage controllers
 * @category controller
 */
class CaraMasukRawatInapController extends MyAuthController {

    public $path_view = 'sistemInformasiEksekutif.views.caraMasukRawatInap.';
    
    /**
     * Load halaman index
     */
    public function actionIndex() {
        $model = new SERicaramasukR();
        $this->render('index', array('model' => $model));
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
        $model = new SERicaramasukR();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['SERicaramasukR'])) {
            $model->attributes = $_GET['SERicaramasukR'];
            $model->jns_periode = $_GET['SERicaramasukR']['jns_periode'];
            $model->instalasi_id = !empty($_GET['SERicaramasukR']['instalasi_id']) ? $_GET['SERicaramasukR']['instalasi_id'] : null;
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['SERicaramasukR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SERicaramasukR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['SERicaramasukR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['SERicaramasukR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal = $_GET['SERicaramasukR']['thn_awal'];
            $model->thn_akhir = $_GET['SERicaramasukR']['thn_akhir'];
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
        
        $data = $model->generateLaporanCaraMasuk();
        $this->render('dashboard', array(
            'model' => $model,
            'load' => $data,
            'format' => $format
        ));
    }

    /**
     * Mencari data sesuai dengan periode 
     */
    public function actionCariData() {
        if (Yii::app()->request->isAjaxRequest) {
            $tgl_awal = isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : null;
            $tgl_akhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : null;
            $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;

            $model = new SERicaramasukR();
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($tgl_awal);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($tgl_akhir);
            $model->instalasi_id = $instalasi_id;
            
            $data = $model->generateLaporanCaraMasuk();

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
        $model = new SERicaramasukR('searchDashboard');
        $format = new MyFormatter();
        $judulLaporan = 'Data Rawat Inap Berdasarkan Cara Masuk';
        $data['title'] = 'Data  Rawat Inap Berdasarkan Cara Masuk';
        if (isset($_GET['SERicaramasukR'])) {
            $model->attributes = $_GET['SERicaramasukR'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['SERicaramasukR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SERicaramasukR']['tgl_akhir']);
            $model->instalasi_id = !empty($_GET['SERicaramasukR']['instalasi_id']) ? $_GET['SERicaramasukR']['instalasi_id'] : null;
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

?>