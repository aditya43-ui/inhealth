<?php

/**
 * Master Tautan SDKI-SLKI
 * 
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage controllers
 */
class TautansdkiSlkiMController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $simpan = true;
    public $path_view = 'asuhanKeperawatan.views.tautansdkiSlkiM.';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = TautansdkiSlkiDetM::model()->findByAttributes(array('tautansdki_slki_det_id' => $id));
        
        $this->render($this->path_view . 'view', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new TautansdkiSlkiM();
        $modDetail = new TautansdkiSlkiDetM;
        $modDet = new TautansdkiSlkiDetM;
        if (isset($_POST['TautansdkiSlkiM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['TautansdkiSlkiM'];
                $model->save();

                $this->simpanBatasDetail($model->tautansdki_slki_id, $_POST['TautansdkiSlkiDetM']);

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
            'modDetail' => $modDetail,
            'modDet' => $modDet
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $modDetail = new TautansdkiSlkiDetM;
        $modDet = TautansdkiSlkiDetM::model()->findByPk($id);
        $model = $this->loadModel($modDet->tautansdki_slki_id);
        if (isset($_POST['TautansdkiSlkiM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['TautansdkiSlkiM'];
                $model->save();

                $this->simpanBatasDetail($model->tautansdki_slki_id, $_POST['TautansdkiSlkiDetM']);

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
            'modDetail' => $modDetail,
            'modDet' => $modDet
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('TautansdkiSlkiM');
        $this->render($this->path_view . 'index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new TautansdkiSlkiM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TautansdkiSlkiM'])) {
            $model->attributes = $_GET['TautansdkiSlkiM'];
            $model->diagnosakep_nama = isset($_GET['TautansdkiSlkiM']['diagnosakep_nama']) ? $_GET['TautansdkiSlkiM']['diagnosakep_nama'] : NULL;
            $model->luarankeperawatan_nama = isset($_GET['TautansdkiSlkiM']['luarankeperawatan_nama']) ? $_GET['TautansdkiSlkiM']['luarankeperawatan_nama'] : NULL;
            $model->tautansdki_slki_aktif = isset($_GET['TautansdkiSlkiM']['tautansdki_slki_aktif']) ? $_GET['TautansdkiSlkiM']['tautansdki_slki_aktif'] : NULL;
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

        $model = TautansdkiSlkiM::model()->findBySql('SELECT tautansdki_slki_m.*,diagnosakep_m.diagnosakep_nama
			FROM tautansdki_slki_m
			JOIN diagnosakep_m ON diagnosakep_m.diagnosakep_id = tautansdki_slki_m.diagnosakep_id
			WHERE tautansdki_slki_m.tautansdki_slki_id =' . $id);

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
     * Simpan detail
     * @param type $tautansdki_slki_id
     * @param type $post
     */
    public function simpanBatasDetail($tautansdki_slki_id, $post) {
        foreach ($post as $i => $row) {
            if (is_numeric($i)) {
                if (!empty($row['tautansdki_slki_det_id'])) {
                    TautansdkiSlkiDetM::model()->updateByPk($row['tautansdki_slki_det_id'], array('tautansdki_slki_id' => $row['tautansdki_slki_id'],
                        'luarankeperawatan_id' => $row['luarankeperawatan_id'],
                        'luarankeperawatan_nama' => $row['luarankeperawatan_nama'],
                        'tautansdki_slki_aktif' => $row['tautansdki_slki_aktif']));
                    $this->simpan &= true;
                } else {
                    $model = new TautansdkiSlkiDetM;
                    $model->attributes = $row;
                    $model->tautansdki_slki_id = $tautansdki_slki_id;
                    if (!$model->save()) {
                        $this->simpan &= false;
                    }
                }
            }
        }
    }

    /**
     * Fungsi Print
     */
    public function actionPrint() {
        $model = new TautansdkiSlkiM;
        $model->attributes = $_REQUEST['TautansdkiSlkiM'];
        $judulLaporan = 'Data Tautan SDKI-SLKI';
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
     * Get data
     * @param type $diagnosakep_id
     * @param type $tingkatluarankeperawatan
     */
    public function actionGetLookup($diagnosakep_id, $tingkatluarankeperawatan) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new TautansdkiSlkiDetM();
            $data['form'] = "";
            $models = $this->loadModelByType($diagnosakep_id, $tingkatluarankeperawatan);
            if (count($models) > 0) {
                foreach ($models AS $i => $model) {
                    $modDet = TautansdkiSlkiDetM::model()->findAllByAttributes(array('tautansdki_slki_id' => $model->tautansdki_slki_id), array('order' => 'tautansdki_slki_id'));
                    if (count($modDet) > 0) {
                        foreach ($modDet as $det) {
                            $data['form'] .= $this->renderPartial($this->path_view . '_rowLookup', array('model' => $det), true);
                        }
                    } else {
                        $modDet = new TautansdkiSlkiDetM();
                        $data['form'] .= $this->renderPartial($this->path_view . '_rowLookup', array('model' => $modDet), true);
                    }
                }
            } else {
                $data['form'] .= $this->renderPartial($this->path_view . '_rowLookup', array('model' => $model), true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Load model by diagnosaaskep
     * @param type $diagnosakep_id
     * @param type $tingkatluarankeperawatan
     * @return type
     * @throws CHttpException
     */
    private function loadModelByType($diagnosakep_id, $tingkatluarankeperawatan) {
        $model = TautansdkiSlkiM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep_id,'tingkatluarankeperawatan' => $tingkatluarankeperawatan), array('order' => 'tautansdki_slki_id'));
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Fungsi hapus
     * @throws CHttpException
     */
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            TautansdkiSlkiDetM::model()->deleteByPk($id);
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
     * @param type $id 
     */
    public function actionremoveTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = TautansdkiSlkiDetM::model()->updateByPk($id, array('tautansdki_slki_aktif' => false));
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
     * @param type $id 
     */
    public function actionaddTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = TautansdkiSlkiDetM::model()->updateByPk($id, array('tautansdki_slki_aktif' => true));
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
     * Autocomplete luaran keperawatan
     */
    public function actionAutocompleteLuaranKeperawatan() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(luarankeperawatan_nama)', strtolower($_GET['term']), true);
            $criteria->addCondition('luarankeperawatan_aktif is true');
            $criteria->limit = 5;
            $models = LuarankeperawatanM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->luarankeperawatan_nama;
                $returnVal[$i]['value'] = $model->luarankeperawatan_id;
                $returnVal[$i]['luarankeperawatan_nama'] = $model->luarankeperawatan_nama;
                $returnVal[$i]['luarankeperawatan_id'] = $model->luarankeperawatan_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Autocomplete Diagnosa Keperawatan
     */
    public function actionAutoCompleteDiagnosaKeperawatan() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(diagnosakep_nama)', strtolower($_GET['term']), true);
            $criteria->addCondition('diagnosakep_aktif is true');
            $criteria->limit = 5;
            $models = DiagnosakepM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->diagnosakep_nama;
                $returnVal[$i]['value'] = $model->diagnosakep_id;
                $returnVal[$i]['diagnosakep_nama'] = $model->diagnosakep_nama;
                $returnVal[$i]['diagnosakep_id'] = $model->diagnosakep_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
}
