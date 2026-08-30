<?php

/**
 * Untuk mengakses halaman Master Indikator OPPE Keperawatan
 * @author  Andyka <andykaputra@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage controllers
 */
class IndikatoroppekeperawatanMController extends MyAuthController {

    public $defaultAction = 'admin';
    public $path_view = 'asuhanKeperawatan.views.indikatoroppekeperawatanM.';

    /**
     * Melihat daftar data.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('IndikatoroppekeperawatanM');
        $this->render($this->path_view . 'index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Pengaturan data.
     */
    public function actionAdmin() {
        $model = new IndikatoroppekeperawatanM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['IndikatoroppekeperawatanM'])) {
            $model->attributes = $_GET['IndikatoroppekeperawatanM'];
        }
        $this->render($this->path_view . 'admin', array(
            'model' => $model,
        ));
    }

    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = IndikatoroppekeperawatanM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param type $model
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'indikatorevaluasi-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Menampilkan detail data.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $this->render($this->path_view . 'view', array(
            'model' => $model,
        ));
    }

    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionCreate() {
        $model = new IndikatoroppekeperawatanM;
        if (isset($_POST['IndikatoroppekeperawatanM'])) {
            $model->attributes = $_POST['IndikatoroppekeperawatanM'];
            $model->create_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai_id = Yii::app()->user->id;
            if($_POST['IndikatoroppekeperawatanM']['is_aktif'] == 0){
                $model->is_aktif = false;
            }else if($_POST['IndikatoroppekeperawatanM']['is_aktif'] == 1){
                $model->is_aktif = true;
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin', 'sukses' => 1));
            }
        }

        $this->render($this->path_view . 'create', array(
            'model' => $model,
        ));
    }

    /**
     * Memanggil dan Mengubah sebagian data.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->standar_nilai = str_replace(".", ",", $model->standar_nilai);
        // Uncomment the following line if AJAX validation is needed
        if (isset($_POST['IndikatoroppekeperawatanM'])) {
            $model->attributes = $_POST['IndikatoroppekeperawatanM'];
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai_id = Yii::app()->user->id;
            if($_POST['IndikatoroppekeperawatanM']['is_aktif'] == 0){
                $model->is_aktif = false;
            }else if($_POST['IndikatoroppekeperawatanM']['is_aktif'] == 1){
                $model->is_aktif = true;
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin', 'sukses' => 1));
            }
        }

        $this->render($this->path_view . 'update', array(
            'model' => $model,
        ));
    }

    /**
     * Menghapus data.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Menonaktifkan status 
     */
    public function actionNonActive($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;
            $model = $this->loadModel($id);
            // set non-active this
            // example: 
            $model->is_aktif = false;
            if ($model->save()) {
                $data['sukses'] = 1;
            }
            echo CJSON::encode($data);
        }
    }

    /**
     * Mengaktifkan status 
     * @param type $id
     */
    public function actionActive($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;
            $model = $this->loadModel($id);
            // set non-active this
            // example: 
            $model->is_aktif = true;
            if ($model->save()) {
                $data['sukses'] = 1;
            }
            echo CJSON::encode($data);
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint() {
        $model = new IndikatoroppekeperawatanM;
        $model->attributes = $_REQUEST['IndikatoroppekeperawatanM'];
        $judulLaporan = 'Data Indikator OPPE Keperawatan';
        $caraPrint = $_REQUEST['caraPrint'];

        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

}
