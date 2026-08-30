<?php

/**
 * Master Tanda Gejala
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.sistemAdministrator
 * @subpackage controllers
 */
class TandaGejalaController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $simpan = true;
    public $path_view = 'sistemAdministrator.views.tandaGejala.';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = TandagejalaM::model()->findByAttributes(array('tandagejala_id' => $id));

        $this->render($this->path_view . 'view', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new SATandagejalaM();
        $modDetail = new SATandagejalaM;
        $modDet = new TandagejalaM;
        if (isset($_POST['TandagejalaM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                foreach ($_POST['TandagejalaM'] as $key => $val) {
                    if (!empty($val['tandagejala_id'])) {
                        $model = TandagejalaM::model()->findByPk($val['tandagejala_id']);
                    } else {
                        $model = new TandagejalaM;
                    }
                    $model->attributes = $val;
                    $model->diagnosakep_id = $val['diagnosakep_id'];
                    $model->tandagejala_aktif = $val['tandagejala_aktif'];
                    $model->kelompoktandagejaladaftar_id = $val['kelompoktandagejaladaftar_id'];

                    $ok = $ok && $model->save();
                }

                if ($ok) {
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
        $model = $this->loadModel($id);
        $cekKelompok = KelompoktandagejaladaftarM::model()->findByPk($model->kelompoktandagejaladaftar_id);
        $model->jenistandagejala = $cekKelompok->jenistandagejala_id;

        $modDet = new TandagejalaM;
        if (isset($_POST['TandagejalaM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                foreach ($_POST['TandagejalaM'] as $key => $val) {
                    if (!empty($val['tandagejala_id'])) {
                        $model = TandagejalaM::model()->findByPk($val['tandagejala_id']);
                    } else {
                        $model = new TandagejalaM;
                    }
                    $model->attributes = $val;
                    $model->diagnosakep_id = $val['diagnosakep_id'];
                    $model->tandagejala_aktif = $val['tandagejala_aktif'];
                    $model->kelompoktandagejaladaftar_id = $val['kelompoktandagejaladaftar_id'];

                    $ok = $ok && $model->save();
                }

                if ($ok) {
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
            'modDet' => $modDet
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('SATandagejalaM');
        $this->render($this->path_view . 'index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new SATandagejalaM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SATandagejalaM'])) {
            $model->attributes = $_GET['SATandagejalaM'];
            $model->jenistandagejala_id = isset($_GET['SATandagejalaM']['jenistandagejala_id']) ? $_GET['SATandagejalaM']['jenistandagejala_id'] : NULL;
            $model->tandagejala_daftar_nama = isset($_GET['SATandagejalaM']['tandagejala_daftar_nama']) ? $_GET['SATandagejalaM']['tandagejala_daftar_nama'] : NULL;
            $model->diagnosakep_nama = isset($_GET['SATandagejalaM']['diagnosakep_nama']) ? $_GET['SATandagejalaM']['diagnosakep_nama'] : NULL;
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

        $model = SATandagejalaM::model()->findBySql('SELECT tandagejala_m.*,diagnosakep_m.diagnosakep_nama
			FROM tandagejala_m
			JOIN diagnosakep_m ON diagnosakep_m.diagnosakep_id = tandagejala_m.diagnosakep_id
			WHERE tandagejala_m.tandagejala_id =' . $id);

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
     * Fungsi Print
     */
    public function actionPrint() {
        $model = new SATandagejalaM;
        $model->attributes = $_REQUEST['SATandagejalaM'];
        $model->jenistandagejala_id = isset($_REQUEST['SATandagejalaM']['jenistandagejala_id']) ? $_REQUEST['SATandagejalaM']['jenistandagejala_id'] : NULL;
        $model->tandagejala_daftar_nama = isset($_REQUEST['SATandagejalaM']['tandagejala_daftar_nama']) ? $_REQUEST['SATandagejalaM']['tandagejala_daftar_nama'] : NULL;
        $model->diagnosakep_nama = isset($_REQUEST['SATandagejalaM']['diagnosakep_nama']) ? $_REQUEST['SATandagejalaM']['diagnosakep_nama'] : NULL;
        $judulLaporan = 'Data Tanda dan Gejala';
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
     * @param type $jenistandagejala
     */
    public function actionGetLookup($diagnosakep_id, $jenistandagejala) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new TandagejalaM();
            $data['form'] = "";
            $models = $this->loadModelByType($diagnosakep_id, $jenistandagejala);
            if (count($models) > 0) {
                foreach ($models AS $i => $model) {
                    $modDet = TandagejalaM::model()->findAllByAttributes(array('tandagejala_id' => $model->tandagejala_id), array('order' => 'tandagejala_id'));
                    if (count($modDet) > 0) {
                        foreach ($modDet as $det) {
                            $cekkelompok = KelompoktandagejaladaftarM::model()->findByPk($det->kelompoktandagejaladaftar_id);
                            if (!empty($cekkelompok->tandagejala_daftar_id)) {
                                $cekJenis = TandagejalaDaftarM::model()->findByPk($cekkelompok->tandagejala_daftar_id);
                                if (!empty($cekJenis)) {
                                    $det->tandagejala_daftar_nama = $cekJenis->tandagejala_daftar_nama;
                                }
                            }
                            $data['form'] .= $this->renderPartial($this->path_view . '_rowKelompok', array('model' => $det), true);
                        }
                    }
                }
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Load model by diagnosaaskep
     * @param type $diagnosakep_id
     * @param type $jenistandagejala
     * @return type
     * @throws CHttpException
     */
    private function loadModelByType($diagnosakep_id, $jenistandagejala) {
        $criteria = new CDbCriteria();
        $criteria->join = 'JOIN kelompoktandagejaladaftar_m ON kelompoktandagejaladaftar_m.kelompoktandagejaladaftar_id = t.kelompoktandagejaladaftar_id';
        $criteria->addCondition('t.diagnosakep_id = ' . $diagnosakep_id);
        $criteria->addCondition('kelompoktandagejaladaftar_m.jenistandagejala_id = ' . $jenistandagejala);
        $criteria->order = 'tandagejala_id';
        $model = SATandagejalaM::model()->findAll($criteria);
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
            $det = TandagejaladetM::model()->findByAttributes(array('tandagejala_id' => $id));
            $model = TandagejalaM::model()->findByPk($id);
            if(!empty($det) && !empty($model)){
                if(TandagejaladetM::model()->deleteAllByAttributes(array('tandagejala_id' => $id)) && TandagejalaM::model()->deleteByPk($id)){
                    if (Yii::app()->request->isAjaxRequest) {
                        echo CJSON::encode(array(
                            'status' => 'proses_form',
                            'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
                        ));
                        exit;
                    }
                }else{
                    if (Yii::app()->request->isAjaxRequest) {
                        echo CJSON::encode(array(
                            'status' => 'gagal_form',
                            'div' => "<div class='flash-success'>Data gagal dihapus, karena dipakai dipakai di tabel lain.</div>",
                        ));
                        exit;
                    }
                }
            }else if(empty($det) && !empty($model)){
                if(TandagejalaM::model()->deleteByPk($id)){
                    if (Yii::app()->request->isAjaxRequest) {
                        echo CJSON::encode(array(
                            'status' => 'proses_form',
                            'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
                        ));
                        exit;
                    }
                }else{
                    if (Yii::app()->request->isAjaxRequest) {
                        echo CJSON::encode(array(
                            'status' => 'gagal_form',
                            'div' => "<div class='flash-success'>Data gagal dihapus, karena dipakai dipakai di tabel lain.</div>",
                        ));
                        exit;
                    }
                }
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
     * Mengubah status aktif menjadi nonaktif
     * @param type $id 
     */
    public function actionremoveTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = TandagejalaM::model()->updateByPk($id, array('tandagejala_aktif' => false));
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
     * Mengubah status nonaktif menjadi aktif
     * @param type $id 
     */
    public function actionaddTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = TandagejalaM::model()->updateByPk($id, array('tandagejala_aktif' => true));
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
     * Generate spesimen 
     */
    public function actionGetKelompok() {
        if (Yii::app()->request->isAjaxRequest) {
            $kelompoktandagejaladaftar_id = isset($_POST['kelompoktandagejaladaftar_id']) ? $_POST['kelompoktandagejaladaftar_id'] : null;
            $status = isset($_POST['status']) ? $_POST['status'] : null;
            $diagnosakep_id = isset($_POST['diagnosakep_id']) ? $_POST['diagnosakep_id'] : null;

            $cri = new CDbCriteria();
            if (is_array($kelompoktandagejaladaftar_id)) {
                $cri->addInCondition("t.kelompoktandagejaladaftar_id", $kelompoktandagejaladaftar_id);
            } else {
                $cri->addCondition("t.kelompoktandagejaladaftar_id = '" . $kelompoktandagejaladaftar_id . "' ");
            }
            $modKelompok = KelompoktandagejaladaftarM::model()->findAll($cri);

            $tr = '';
            foreach ($modKelompok as $det) {
                $model = new TandagejalaM();
                $model->diagnosakep_id = $diagnosakep_id;
                $model->tandagejala_aktif = $status;
                $model->kelompoktandagejaladaftar_id = $det->kelompoktandagejaladaftar_id;
                $model->tandagejala_daftar_nama = $det->tandagejalaDaftar->tandagejala_daftar_nama;
                $tr .= $this->renderPartial($this->path_view . '_rowKelompok', array('model' => $model), true);
            }
            echo json_encode($tr);
            Yii::app()->end();
        }
    }

}
