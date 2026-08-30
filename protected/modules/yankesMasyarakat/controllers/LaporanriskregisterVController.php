<?php

/**
 * Digunakan untuk mengakses Laporan Risk Register
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 */
class LaporanriskregisterVController extends MyAuthController {

    /**
     * Digunakan untuk mengakses menu laporan Risk Register
     */
    public function actionIndex() {
        $model = new YKMLaporanriskregisterV('search');
        if (isset($_POST['YKMLaporanriskregisterV'])) {
            $model->attributes = $_POST['YKMLaporanriskregisterV'];
            $model->ruangan_id = isset($_POST['YKMLaporanriskregisterV']['ruangan_id']) ? $_POST['YKMLaporanriskregisterV']['ruangan_id'] : null;
            $model->perioderiskregister_id = isset($_POST['YKMLaporanriskregisterV']['perioderiskregister_id']) ? $_POST['YKMLaporanriskregisterV']['perioderiskregister_id'] : null;
            $model->sumber_resiko = isset($_POST['YKMLaporanriskregisterV']['sumber_resiko']) ? $_POST['YKMLaporanriskregisterV']['sumber_resiko'] : null;
            
        }
        
        $data = $model->generateLaporan(); 
        $tabel = $data['tabel'];
        $pages = $data['pages'];

        $this->render('index', array(
            'model' => $model,
            'tabel' => $tabel,
            'pages' => $pages,
        ));
    }
    /**
     * Fungsi cetak laporan Risk Register
     */
    public function actionPrintLaporanInsiden() {
        $model = new YKMLaporanriskregisterV('search');
        $judulLaporan = 'Laporan Risk Register';
        //Data Grafik
        $data['title'] = 'Grafik Laporan Risk Register';
        
        $data['type'] = isset($_GET['type'])?$_GET['type']:'';
        if (isset($_GET['YKMLaporanriskregisterV'])) {
            $model->attributes = $_GET['YKMLaporanriskregisterV'];
            $format = new MyFormatter();
            $model->ruangan_id = isset($_GET['YKMLaporanriskregisterV']['ruangan_id']) ? $_GET['YKMLaporanriskregisterV']['ruangan_id'] : null;
            $model->perioderiskregister_id = isset($_GET['YKMLaporanriskregisterV']['perioderiskregister_id']) ? $_GET['YKMLaporanriskregisterV']['perioderiskregister_id'] : null;
            $model->sumber_resiko = isset($_GET['YKMLaporanriskregisterV']['sumber_resiko']) ? $_GET['YKMLaporanriskregisterV']['sumber_resiko'] : null;
            $model->tingkatrisiko_id = isset($_GET['YKMLaporanriskregisterV']['tingkatrisiko_id']) ? $_GET['YKMLaporanriskregisterV']['sumber_resiko'] : null;
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target = '_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    /**
     * Fungsi print 
     * @param type $model
     * @param type $data
     * @param type $caraPrint
     * @param type $judulLaporan
     * @param type $target
     * @param type $tab
     * @param type $variabel
     */
    protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab = 'rs', $variabel = array()) {
        $format = new MyFormatter();
        $data_tabel = $model->generateLaporan(); 
        $tabel = $data_tabel['tabel'];
        $periode = '';
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows3';
            $this->render($target, array('model' => $model, 'tabel' => $tabel, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'tabel' => $tabel, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $kertas = Params::getUkuranKertas();
            $mpdf = new MyPDF('', $kertas['F4']);
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf->SetHTMLFooter($this->renderPartial('application.views.headerReport.footerLaporanBukuRegister', array('judulLaporan' => $judulLaporan, 'colspan' => 10), true));
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI_LANDSCAPE, '', '', '', '', 20, 20, 20, 30, 20, 20);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'tabel' => $tabel, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

}
