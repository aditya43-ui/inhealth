<?php

/**
 * Digunakan untuk mengakses informasi risk register
 * @author     Andyka Putra <andykaputra@.com>
 * @package    application.modules.yankesMasyarakat
 * @subpackage controllers
 * RSST-4361
 */
class InformasiRiskRegisterController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $defaultAction = 'index';
    public $path_view = 'yankesMasyarakat.views.informasiRiskRegister.';

    /**
     * Digunakan untuk mengakses halaman utama informasi risk register
     */
    public function actionIndex() {
        $this->layout = '//layouts/mainNeonSidebar';

        $model = new YKMRiskregisterM();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->tgl_awal2 = date('Y-m-d');
        $model->tgl_akhir2 = date('Y-m-d');

        if (isset($_GET['YKMRiskregisterM'])) {
            $model->attributes = $_GET['YKMRiskregisterM'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['YKMRiskregisterM']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['YKMRiskregisterM']['tgl_akhir']);
            $model->tgl_awal2 = MyFormatter::formatDateTimeForDb($_GET['YKMRiskregisterM']['tgl_awal2']);
            $model->tgl_akhir2 = MyFormatter::formatDateTimeForDb($_GET['YKMRiskregisterM']['tgl_akhir2']);
            $model->penanggungjawab = $_GET['YKMRiskregisterM']['penanggungjawab'];
            $model->sumber_riskregister = $_GET['YKMRiskregisterM']['sumber_riskregister'];
            $model->tiperesiko_id = $_GET['YKMRiskregisterM']['tiperesiko_id'];
            $model->status_riskregister = $_GET['YKMRiskregisterM']['status_riskregister'];
        }

        $this->render($this->path_view . 'index', array('model' => $model));
    }

    /**
     * Memanggil data risk register dari model.
     * @param type $id
     * @return type
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = RiskregisterM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Menghapus data risk register
     * @throws CHttpException
     */
    public function actionDeleteRecord() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            $model = RiskregisterM::model()->findByPk($id);
            $model->delete();
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'proses_form',
                    'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
                ));
                exit;
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Digunakan untuk mencetak data
     */
    public function actionPrint() {
        $model = new YKMRiskregisterM();

        if (isset($_GET['YKMRiskregisterM'])) {
            $model->attributes = $_GET['YKMRiskregisterM'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['YKMRiskregisterM']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['YKMRiskregisterM']['tgl_akhir']);
            $model->tgl_awal2 = MyFormatter::formatDateTimeForDb($_GET['YKMRiskregisterM']['tgl_awal2']);
            $model->tgl_akhir2 = MyFormatter::formatDateTimeForDb($_GET['YKMRiskregisterM']['tgl_akhir2']);
            $model->penanggungjawab = $_GET['YKMRiskregisterM']['penanggungjawab'];
            $model->sumber_riskregister = $_GET['YKMRiskregisterM']['sumber_riskregister'];
            $model->tiperesiko_id = $_GET['YKMRiskregisterM']['tiperesiko_id'];
            $model->status_riskregister = $_GET['YKMRiskregisterM']['status_riskregister'];
        }

        $judulLaporan = 'Data Risk Register';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $kertas = Params::getUkuranKertas();
            $mpdf = new MyPDF('', $kertas['F4']);
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf->SetHTMLFooter($this->renderPartial('application.views.headerReport.footerLaporanBukuRegister', array('judulLaporan' => $judulLaporan, 'colspan' => 10), true));
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI_LANDSCAPE, '', '', '', '', 20, 20, 20, 30, 20, 20);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

}
