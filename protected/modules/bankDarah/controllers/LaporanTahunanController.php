<?php

/**
 * Controller untuk Laporan Tahunan
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 * @category controller
 */
class LaporanTahunanController extends MyAuthController {

    public $path_view = 'bankDarah.views.laporan.laporanTahunan.';

    /**
     * Halaman index Laporan Tahunan
     */
    public function actionIndex() {
        $this->layout = '//layouts/iframe';
        
        $this->render($this->path_view . 'index', array());
    }

    /**
     * Digunakan untuk load printout laporan tahunan
     */
    public function actionPrint() {
        $criteria = new CDbCriteria();
        
        $caraPrint = $_GET['caraPrint'];
        $target = $this->path_view . '_print';

        $this->printFunction($caraPrint, $target, '');
    }

    /**
     * Fungsi print 
     * @param type $caraPrint
     * @param type $target
     * @param type $tab
     */
    protected function printFunction($caraPrint, $target, $tab = 'rs') {
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows3';
            $this->render($target, array('caraPrint' => $caraPrint, 'tab' => $tab));
        } else if ($caraPrint == 'PDF') {
            $kertas = Params::getUkuranKertas();
            $mpdf = new MyPDF('', $kertas['F4']);
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI_LANDSCAPE, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('caraPrint' => $caraPrint, 'tab' => $tab), true));
            $mpdf->Output('Laporan Tahunan_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

}
