<?php
/**
 * Master intervensi
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.sistemAdministrator
 * @subpackage controllers
 * @category controller 
 */
class IntervensiController extends MyAuthController {

    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $simpan = true;
    public $path_view = 'sistemAdministrator.views.intervensi.';
    public $path_views = 'sistemAdministrator.views.';
    public $hasTab = false;

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
        $model = new SAIntervensiM;
        $modDetail = new SAIntervensidetM;
        if (isset($_POST['SAIntervensiM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['SAIntervensiM'];
                $model->intervensi_nama = $_POST['SAIntervensiM']['intervensi_nama'];

                $batkar = SAIntervensiM::model()->findByAttributes(array('diagnosakep_id' => $_POST['SAIntervensiM']['diagnosakep_id'], 'intervensi_nama' => $_POST['SAIntervensiM']['intervensi_nama']));
                if (!empty($batkar)) {
                    $this->simpanBatasDetail($batkar->intervensi_id, $_POST['SAIntervensidetM']);
                } else {
                    if ($model->save()) {
                        $this->simpanBatasDetail($model->intervensi_id, $_POST['SAIntervensidetM']);
                    }
                }

                if ($this->simpan) {
                    $transaction->commit();
                    $this->redirect(array('admin', 'sukses' => 1, 'tab' => ($this->hasTab == TRUE) ? 'frame' : null));
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
        $modDetail = new SAIntervensidetM;
        if (isset($_POST['SAIntervensiM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->updateByPk($id, array('diagnosakep_id' => $_POST['SAIntervensiM']['diagnosakep_id'], 'intervensi_nama' => $_POST['SAIntervensiM']['intervensi_nama']));
                SAIntervensidetM::model()->deleteAllByAttributes(array('intervensi_id' => $id));
                $this->simpanBatasDetail($id, $_POST['SAIntervensidetM']);
                if ($this->simpan) {
                    $transaction->commit();
                    $this->redirect(array('admin', 'sukses' => 1, 'tab' => ($this->hasTab == TRUE) ? 'frame' : null));
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
        $dataProvider = new CActiveDataProvider('SAIntervensiM');
        $this->render($this->path_view . 'index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new SAIntervensidetM('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['SAIntervensidetM'])) {
            $model->attributes = $_GET['SAIntervensidetM'];
            $model->diagnosakep_nama = isset($_GET['SAIntervensidetM']['diagnosakep_nama']) ? $_GET['SAIntervensidetM']['diagnosakep_nama'] : "";
            $model->intervensi_nama = isset($_GET['SAIntervensidetM']['intervensi_nama']) ? $_GET['SAIntervensidetM']['intervensi_nama'] : "";
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

        $model = SAIntervensiM::model()->findBySql('SELECT intervensi_m.*,diagnosakep_m.diagnosakep_nama
			FROM intervensi_m
			JOIN diagnosakep_m ON diagnosakep_m.diagnosakep_id = intervensi_m.diagnosakep_id
			WHERE intervensi_m.intervensi_id =' . $id);

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
     * Simpan ke intervensi_m
     * @param type $post
     */
    public function simpanBatas($post) {
        $model = new SAIntervensiM;
        $model->attributes = $post;
        $model->intervensi_nama = $post['intervensi_nama'];

        if (!$model->save()) {
            $this->simpan &= false;
        }
    }

    /**
     * Simpan detail baru 
     * @param type $intervensi_id
     * @param type $post
     */
    public function simpanBatasDetail($intervensi_id, $post) {
        foreach ($post as $i => $row) {
            $model = new SAIntervensidetM;
            $model->attributes = $row;
            $model->intervensi_id = $intervensi_id;
            $model->intervensidet_indikator = $row['intervensidet_indikator'];
            $model->intervensidet_aktif = $row['intervensidet_aktif'];
            if (!$model->save()) {
                $this->simpan &= false;
            }
        }
    }

    /**
     * Cetak 
     */
    public function actionPrint() {
        $model = new SAIntervensidetM;
        $model->attributes = $_REQUEST['SAIntervensidetM'];
        $judulLaporan = 'Data Intervensi';
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
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

    /**
     * Load data berdasarkan diagnosa dan intervensi_nama 
     * @param type $diagnosakep_id
     * @param type $intervensi_nama
     */
    public function actionGetLookup($diagnosakep_id, $intervensi_nama) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new SAIntervensidetM();
            $batkar = SAIntervensiM::model()->findByAttributes(array('diagnosakep_id' => $diagnosakep_id, 'intervensi_nama' => $intervensi_nama));
            $data['form'] = "";
            if (isset($batkar->intervensi_id)) {
                $models = $this->loadModelByType($batkar->intervensi_id);
            } else if (isset($_POST['intervensi_id'])) {
                $models = $this->loadModelByType($_POST['intervensi_id']);
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
     * Load data berdasarkan intervensi_id
     * @param type $intervensi_id
     * @return type
     * @throws CHttpException
     */
    private function loadModelByType($intervensi_id) {
        $model = SAIntervensidetM::model()->findAllByAttributes(array('intervensi_id' => $intervensi_id), array('order' => 'intervensi_id'));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Hapus data
     * @throws CHttpException
     */
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            SAIntervensidetM::model()->deleteByPk($id);
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
    public function actionRemoveTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = SAIntervensidetM::model()->updateByPk($id, array('intervensidet_aktif' => false));
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
     * Autocomplete jenis intervensi
     */
    public function actionGetJenisIntervensi() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();

            $criteria->addCondition("jenisintervensi_aktif is TRUE");
            $criteria->order = 'jenisintervensi_nama';
            if (isset($_GET['term'])) {
                                $criteria->compare('LOWER(jenisintervensi_nama)', strtolower($_GET['term']), true);

            }
            $models = JenisintervensiM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->jenisintervensi_nama;
                $returnVal[$i]['value'] = $model->jenisintervensi_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

}
