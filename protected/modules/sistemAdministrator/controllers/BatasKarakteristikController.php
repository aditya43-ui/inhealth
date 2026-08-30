<?php

/**
 * Master Batas Karakteristik / Faktor Penyebab
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.sistemAdministrator
 * @subpackage controllers
 */
class BatasKarakteristikController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $simpan = true;
    public $path_view = 'sistemAdministrator.views.batasKarakteristik.';

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
        $model = new SABataskarakteristikM;
        $modDetail = new SABataskarakteristikdetM;
        if (isset($_POST['SABataskarakteristikM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['SABataskarakteristikM'];
                $model->bataskarakteristik_nama = $_POST['SABataskarakteristikM']['bataskarakteristik_nama'];

                $batkar = SABataskarakteristikM::model()->findByAttributes(array('diagnosakep_id' => $_POST['SABataskarakteristikM']['diagnosakep_id'], 'bataskarakteristik_nama' => $_POST['SABataskarakteristikM']['bataskarakteristik_nama']));
                if (!empty($batkar)) {
                    $this->simpanBatasDetail($batkar->bataskarakteristik_id, $_POST['SABataskarakteristikdetM']);
                } else {
                    if ($model->save()) {
                        $this->simpanBatasDetail($model->bataskarakteristik_id, $_POST['SABataskarakteristikdetM']);
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
        $modDetail = new SABataskarakteristikdetM;
        if (isset($_POST['SABataskarakteristikM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->updateByPk($id, array('diagnosakep_id' => $_POST['SABataskarakteristikM']['diagnosakep_id'], 'bataskarakteristik_nama' => $_POST['SABataskarakteristikM']['bataskarakteristik_nama']));
                SABataskarakteristikdetM::model()->deleteAllByAttributes(array('bataskarakteristik_id' => $model->bataskarakteristik_id));
                $this->simpanBatasDetail($id, $_POST['SABataskarakteristikdetM']);

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
        $dataProvider = new CActiveDataProvider('SABataskarakteristikM');


        $this->render($this->path_view . 'index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new SABataskarakteristikdetM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SABataskarakteristikdetM'])) {
            $model->attributes = $_GET['SABataskarakteristikdetM'];
            $model->diagnosakep_nama = $_GET['SABataskarakteristikdetM']['diagnosakep_nama'];
            $model->bataskarakteristik_nama = $_GET['SABataskarakteristikdetM']['bataskarakteristik_nama'];
            $model->faktorpenyebab_daftar_id = $_GET['SABataskarakteristikdetM']['faktorpenyebab_daftar_id'];
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

        $model = SABataskarakteristikM::model()->findBySql('SELECT bataskarakteristik_m.*,diagnosakep_m.diagnosakep_nama
                FROM bataskarakteristik_m
                JOIN diagnosakep_m ON diagnosakep_m.diagnosakep_id = bataskarakteristik_m.diagnosakep_id
                WHERE bataskarakteristik_m.bataskarakteristik_id =' . $id);

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
     * Simpan batas karakteristik
     * @param type $post
     */
    public function simpanBatas($post) {
        $model = new SABataskarakteristikM;
        $model->attributes = $post;
        $model->bataskarakteristik_nama = $post['bataskarakteristik_nama'];

        if (!$model->save()) {
            $this->simpan &= false;
        }
    }

    /**
     * Simpan detail batas karakteristik
     * @param type $bataskarakteristik_id
     * @param type $post
     */
    public function simpanBatasDetail($bataskarakteristik_id, $post) {
        foreach ($post as $i => $row) {
            // if (!empty($row['bataskarakteristikdet_id'])) {
            // 	SABataskarakteristikdetM::model()->updateByPk($row['bataskarakteristikdet_id'], array('bataskarakteristikdet_indikator' => $row['bataskarakteristikdet_indikator'],
            //		'bataskarakteristikdet_aktif' => $row['bataskarakteristikdet_aktif']));
            // 	$this->simpan &= true;
            // } else {
            $model = new SABataskarakteristikdetM;
            $model->attributes = $row;
            $model->bataskarakteristik_id = $bataskarakteristik_id;
            $model->bataskarakteristikdet_indikator = !empty($row['faktorpenyebab_daftar_nama']) ? $row['faktorpenyebab_daftar_nama'] : "";
            $model->bataskarakteristikdet_aktif = $row['bataskarakteristikdet_aktif'];
            if (!$model->save()) {
                $this->simpan &= false;
            }
            
            //}
        }
    }

    /**
     * Update detail batas karakteristik
     * @param type $lookup_type
     * @param type $post
     */
    public function updateBatasDetail($lookup_type, $post) {
        foreach ($post as $i => $lookup) {

            if (!empty($lookup['lookup_id'])) {
                $model = new SABataskarakteristikdetM;
                $model->attributes = $lookup;
                $model->lookup_type = $lookup_type;
                SALookupM::model()->updateByPk($lookup['lookup_id'], array('lookup_name' => $model->lookup_name,
                    'lookup_value' => $model->lookup_value,
                    'lookup_kode' => $model->lookup_kode,
                    'lookup_urutan' => $model->lookup_urutan));
            }
        }
    }

    /**
     * Fungsi Print
     */
    public function actionPrint() {
        $model = new SABataskarakteristikdetM;
        $model->attributes = $_REQUEST['SABataskarakteristikdetM'];
        $judulLaporan = 'Data Faktor Penyebab';
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
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

    /**
     * Fungsi untuk mendapatkan data lookup
     * @param type $diagnosakep_id
     * @param type $bataskarakteristik_nama
     */
    public function actionGetLookup($diagnosakep_id, $bataskarakteristik_nama) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new SABataskarakteristikdetM;
            $batkar = SABataskarakteristikM::model()->findByAttributes(array('diagnosakep_id' => $diagnosakep_id, 'bataskarakteristik_nama' => $bataskarakteristik_nama));
            $data['form'] = "";
            if (isset($batkar->bataskarakteristik_id)) {
                $models = $this->loadModelByType($batkar->bataskarakteristik_id);
            } else if (isset($_POST['bataskarakteristik_id'])) {
                $models = $this->loadModelByType($_POST['bataskarakteristik_id']);
            } else {
                $models = array();
            }
            if (count($models) > 0) {
                foreach ($models AS $i => $model) {
                    $model->faktorpenyebab_daftar_nama = $model->bataskarakteristikdet_indikator;
                    $data['form'] .= $this->renderPartial($this->path_view . '_rowLookup', array('model' => $model), true);
                }
            } else {
                $model->faktorpenyebab_daftar_nama = $model->bataskarakteristikdet_indikator;
                $data['form'] .= $this->renderPartial($this->path_view . '_rowLookup', array('model' => $model), true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * load model berdasarkan tipe
     * @param type $batkar_id
     * @return type
     * @throws CHttpException
     */
    private function loadModelByType($batkar_id) {
        $model = SABataskarakteristikdetM::model()->findAllByAttributes(array('bataskarakteristik_id' => $batkar_id), array('order' => 'bataskarakteristik_id'));
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
            SABataskarakteristikdetM::model()->deleteByPk($id);
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
            $update = SABataskarakteristikdetM::model()->updateByPk($id, array('bataskarakteristikdet_aktif' => false));
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
     * Autocomplete Diagnosa Keperawatan
     */
    public function actionAutoCompleteDiagnosaKeperawatan() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $term = isset($_GET['term']) ? $_GET['term'] : null;
            $criteria = new CDbCriteria();
            $criteria = new CDbCriteria();
//                $criteria->compare('LOWER(nmrincianobyek)', strtolower($_GET['term']), true);
            $term = strtolower(trim($_GET['term']));

            $condition = "LOWER(diagnosakep_kode) LIKE '%" . $term . "%' OR LOWER(diagnosakep_nama) LIKE '%" . $term . "%'";
            $criteria->addCondition($condition);
            $criteria->order = 'diagnosakep_nama';
            $criteria->limit = 5;

            $models = SADiagnosakepM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->diagnosakep_kode;
                $returnVal[$i]['value'] = $model->diagnosakep_nama;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete Faktor Penyebab
     */
    public function actionAutoCompleteFaktorPenyebab() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(faktorpenyebab_daftar_nama)', strtolower($_GET['term']), true);
            $criteria->addCondition('faktorpenyebab_daftar_aktif is true');
            $criteria->limit = 5;
            $models = FaktorpenyebabDaftarM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->faktorpenyebab_daftar_nama;
                $returnVal[$i]['value'] = $model->faktorpenyebab_daftar_id;
                $returnVal[$i]['faktorpenyebab_daftar_nama'] = $model->faktorpenyebab_daftar_nama;
                $returnVal[$i]['faktorpenyebab_daftar_id'] = $model->faktorpenyebab_daftar_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
}
