<?php
/**
 * Master Diagnosa Keperawatan
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.sistemAdministrator
 * @subpackage controllers
 * @category controller
 */
class DiagnosakepMController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $path_view = 'sistemAdministrator.views.diagnosaKep.';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render($this->path_view . 'view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new SADiagnosakepM;

        // Uncomment the following line if AJAX validation is needed

        if (isset($_POST['SADiagnosakepM'])) {
            $model->attributes = $_POST['SADiagnosakepM'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin', 'id' => $model->diagnosakep_id));
            }
        }

        $this->render($this->path_view . 'create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed

        if (isset($_POST['SADiagnosakepM'])) {
            $model->attributes = $_POST['SADiagnosakepM'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin', 'id' => $model->diagnosakep_id));
            }
        }

        $this->render($this->path_view . 'update', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('SADiagnosakepM');
        $this->render($this->path_view . 'index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new SADiagnosakepM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SADiagnosakepM'])) {
            $model->attributes = $_GET['SADiagnosakepM'];
            $model->aktif = (isset($_GET['aktif']) ? $_GET['aktif'] : NULL );
        }
        $this->render($this->path_view . 'admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = SADiagnosakepM::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sajenisnapza-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Hapus seluruh data yang berkaitan dengan diagnosa keperawatan 
     * @throws CHttpException
     */
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];

            //Hapus bataskarakteristikdet_m
            $heads = SABataskarakteristikM::model()->findAllByAttributes(array('diagnosakep_id' => $id));
            foreach ($heads as $i => $head) {
                SABataskarakteristikdetM::model()->deleteAllbyAttributes(array('bataskarakteristik_id' => $head->bataskarakteristik_id));
            }
            //Hapus bataskarakteristik_m
            SABataskarakteristikM::model()->deleteAllbyAttributes(array('diagnosakep_id' => $id));

            //Hapus faktorrisikodet_m
            $heads = SAFaktorrisikoM::model()->findAllByAttributes(array('diagnosakep_id' => $id));
            foreach ($heads as $i => $head) {
                SAFaktorrisikodetM::model()->deleteAllbyAttributes(array('faktorrisiko_id' => $head->faktorrisiko_id));
            }
            //Hapus faktorrisiko_m
            SAFaktorrisikoM::model()->deleteAllbyAttributes(array('diagnosakep_id' => $id));

            //Hapus faktorhubdet_m
            $heads = SAFaktorhubM::model()->findAllByAttributes(array('diagnosakep_id' => $id));
            foreach ($heads as $i => $head) {
                SAFaktorhubdetM::model()->deleteAllbyAttributes(array('faktorhub_id' => $head->faktorhub_id));
            }
            //Hapus faktorhub_m
            SAFaktorhubM::model()->deleteAllbyAttributes(array('diagnosakep_id' => $id));

            //Hapus faktorhubdet_m
            $heads = SAFaktorhubM::model()->findAllByAttributes(array('diagnosakep_id' => $id));
            foreach ($heads as $i => $head) {
                SAFaktorhubdetM::model()->deleteAllbyAttributes(array('faktorhub_id' => $head->faktorhub_id));
            }
            //Hapus faktorhub_m
            SAFaktorhubM::model()->deleteAllbyAttributes(array('diagnosakep_id' => $id));

            //Hapus tujuan_m
            SATujuanM::model()->deleteAllbyAttributes(array('diagnosakep_id' => $id));

            //Hapus kriteriahasildet_m
            $heads = SAKriteriahasilM::model()->findAllByAttributes(array('diagnosakep_id' => $id));
            foreach ($heads as $i => $head) {
                SAKriteriahasildetM::model()->deleteAllbyAttributes(array('kriteriahasil_id' => $head->kriteriahasil_id));
            }
            //Hapus kriteriahasil_m
            SAKriteriahasilM::model()->deleteAllbyAttributes(array('diagnosakep_id' => $id));

            //Hapus tandagejala_m
            SATandagejalaM::model()->deleteAllbyAttributes(array('diagnosakep_id' => $id));

            //Hapus intervensidet_m
            $heads = SAIntervensiM::model()->findAllByAttributes(array('diagnosakep_id' => $id));
            foreach ($heads as $i => $head) {
                SAIntervensidetM::model()->deleteAllbyAttributes(array('intervensi_id' => $head->intervensi_id));
            }
            //Hapus kriteriahasil_m
            SAIntervensiM::model()->deleteAllbyAttributes(array('diagnosakep_id' => $id));

            //Hapus alternatifdx_m
            SAAlternatifdxM::model()->deleteAllbyAttributes(array('diagnosakep_id' => $id));

            $this->loadModel($id)->delete();
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'proses_form',
                    'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
                ));
                exit;
            }
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Mengubah status menjadi nonaktif
     */
    public function actionRemoveTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = DiagnosakepM::model()->updateByPk($id, array('diagnosakep_aktif' => false));
            if ($update) {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'proses_form',
                    ));
                    exit;
                }
            }
        } else {
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'proses_form',
                ));
                exit;
            }
        }
    }

    /**
     * Mengubah status menjadi aktif
     */
    public function actionAktifkan() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = DiagnosakepM::model()->updateByPk($id, array('diagnosakep_aktif' => true));
            if ($update) {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'proses_form',
                    ));
                    exit;
                }
            }
        } else {
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'proses_form',
                ));
                exit;
            }
        }
    }

    /**
     * Cetak Diagnosa Keperawatan
     */
    public function actionPrint() {
        $model = new SADiagnosakepM;
        $model->attributes = $_REQUEST['SADiagnosakepM'];
        $judulLaporan = 'Diagnosa Keperawatan';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');      //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');         //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

}
