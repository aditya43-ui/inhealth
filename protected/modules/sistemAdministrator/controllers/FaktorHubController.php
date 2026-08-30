<?php

/**
 * Master Faktor yang Berhubungan / Kondisi Klinis Terkait
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.sistemAdministrator
 * @subpackage controllers
 */
class FaktorHubController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $simpan = true;
    public $path_view = 'sistemAdministrator.views.faktorHub.';

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
        $model = new SAFaktorhubM;
        $modDetail = new SAFaktorhubdetM;
        if (isset($_POST['SAFaktorhubM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['SAFaktorhubM'];
                $model->faktorhub_nama = $_POST['SAFaktorhubM']['faktorhub_nama'];

                $batkar = SAFaktorhubM::model()->findByAttributes(array('diagnosakep_id' => $_POST['SAFaktorhubM']['diagnosakep_id'], 'faktorhub_nama' => $_POST['SAFaktorhubM']['faktorhub_nama']));
                if (!empty($batkar)) {
                    $this->simpanBatasDetail($batkar->faktorhub_id, $_POST['SAFaktorhubdetM']);
                } else {
                    if ($model->save()) {
                        $this->simpanBatasDetail($model->faktorhub_id, $_POST['SAFaktorhubdetM']);
                    }
                }

                if ($this->simpan) {
                    $transaction->commit();
                    $this->redirect(array('admin', 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!');
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!' . MyExceptionMessage::getMessage($exc));
            }
        }
        $this->render($this->path_view . 'create', array(
            'model' => $model,
            'modDetail' => $modDetail
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $modDetail = new SAFaktorhubdetM;
        if (isset($_POST['SAFaktorhubM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->updateByPk($id, array('diagnosakep_id' => $_POST['SAFaktorhubM']['diagnosakep_id'], 'faktorhub_nama' => $_POST['SAFaktorhubM']['faktorhub_nama']));
                SAFaktorhubdetM::model()->deleteAllByAttributes(array('faktorhub_id' => $id));
                $this->simpanBatasDetail($id, $_POST['SAFaktorhubdetM']);
                
                if ($this->simpan) {
                    $transaction->commit();
                    $this->redirect(array('admin', 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!');
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!' . MyExceptionMessage::getMessage($exc));
            }
        }

        $this->render($this->path_view . 'update', array(
            'model' => $model,
            'modDetail' => $modDetail
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('SAFaktorhubM');
        $this->render($this->path_view . 'index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new SAFaktorhubdetM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SAFaktorhubdetM'])) {
            $model->attributes = $_GET['SAFaktorhubdetM'];
            $model->diagnosakep_nama = isset($_GET['SAFaktorhubdetM']['diagnosakep_nama']) ? $_GET['SAFaktorhubdetM']['diagnosakep_nama'] : "";
            $model->faktorhub_nama = isset($_GET['SAFaktorhubdetM']['faktorhub_nama']) ? $_GET['SAFaktorhubdetM']['faktorhub_nama'] : "";
            $model->aktif = isset($_GET['aktif']) ? $_GET['aktif'] : NULL;
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

        $model = SAFaktorhubM::model()->findBySql('SELECT faktorhub_m.*,diagnosakep_m.diagnosakep_nama
			FROM faktorhub_m
			JOIN diagnosakep_m ON diagnosakep_m.diagnosakep_id = faktorhub_m.diagnosakep_id
			WHERE faktorhub_m.faktorhub_id =' . $id);

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'salookup-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Simpan Faktor
     * @param type $post
     */
    public function simpanBatas($post) {
        $model = new SAFaktorhubM;
        $model->attributes = $post;
        $model->faktorhub_nama = $post['faktorhub_nama'];

        if (!$model->save()) {
            $this->simpan &= false;
        }
    }

    /**
     * Simpan detail
     * @param type $faktorhub_id
     * @param type $post
     */
    public function simpanBatasDetail($faktorhub_id, $post) {
        foreach ($post as $i => $row) {

            // if (!empty($row['faktorhubdet_id'])) {
            // 	SAFaktorhubdetM::model()->updateByPk($row['faktorhubdet_id'], array('faktorhubdet_indikator' => $row['faktorhubdet_indikator'],
            // 		'faktorhubdet_aktif' => $row['faktorhubdet_aktif']));
            // 	$this->simpan &= true;
            // } else {
            $model = new SAFaktorhubdetM;
            $model->attributes = $row;
            $model->faktorhub_id = $faktorhub_id;
            $model->faktorhubdet_indikator = $row['faktorhubdet_indikator'];
            $model->faktorhubdet_aktif = $row['faktorhubdet_aktif'];
            if (!$model->save()) {
                $this->simpan &= false;
            }
            // }
        }
    }

    /**
     * Fungsi Print
     */
    public function actionPrint() {
        $model = new SAFaktorhubdetM;
        $model->attributes = $_REQUEST['SAFaktorhubdetM'];
        $judulLaporan = 'Data Kondisi Klinis Terkait';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

    /**
     * Get data lookup
     * @param type $diagnosakep_id
     * @param type $faktorhub_nama
     */
    public function actionGetLookup($diagnosakep_id, $faktorhub_nama) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new SAFaktorhubdetM();
            $batkar = SAFaktorhubM::model()->findByAttributes(array('diagnosakep_id' => $diagnosakep_id, 'faktorhub_nama' => $faktorhub_nama));
            $data['form'] = "";
            if (isset($batkar->faktorhub_id)) {
                $models = $this->loadModelByType($batkar->faktorhub_id);
            } else if (isset($_POST['faktorhub_id'])) {
                $models = $this->loadModelByType($_POST['faktorhub_id']);
            } else {
                $models = array();
            }
            if (count($models) > 0) {
                foreach ($models AS $i => $model) {
                    $data['form'] .= $this->renderPartial($this->path_view . '_rowLookup', array('model' => $model), true);
                }
            } else {
                $data['form'] .= $this->renderPartial($this->path_view . '_rowLookup', array('model' => $model), true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Load model berdasarkan tipe
     * @param type $faktorhub_id
     * @return type
     * @throws CHttpException
     */
    private function loadModelByType($faktorhub_id) {
        $model = SAFaktorhubdetM::model()->findAllByAttributes(array('faktorhub_id' => $faktorhub_id), array('order' => 'faktorhub_id'));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Fungsi hapus
     * @throws CHttpException
     */
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            $det = SAFaktorhubdetM::model()->findByPk($id);
            $model = SAFaktorhubM::model()->findByPk($det->faktorhub_id);
            SAFaktorhubdetM::model()->deleteByPk($id);

            $det = SAFaktorhubdetM::model()->findByAttributes(array('faktorhub_id' => $model->faktorhub_id));
            if (empty($det)) {
                SAFaktorhubM::model()->deleteByPk($model->faktorhub_id);
            }
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
     * Mengubah status aktif
     */
    public function actionremoveTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = SAFaktorhubdetM::model()->updateByPk($id, array('faktorhubdet_aktif' => false));
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

}
