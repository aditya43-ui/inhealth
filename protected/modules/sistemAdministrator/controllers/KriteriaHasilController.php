<?php

/**
 * Digunakan untuk mengakses master SLKI
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.sistemAdministrator
 * @subpackage controllers
 * @category controller
 */
class KriteriaHasilController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $simpan = false;
    public $path_view = 'sistemAdministrator.views.kriteriaHasil.';

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
        $model = new SAKriteriahasilM;
        $modDetail = new SAKriteriahasildetM;
        if (isset($_POST['SAKriteriahasilM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['SAKriteriahasilM'];
                $model->kriteriahasil_nama = $_POST['SAKriteriahasilM']['kriteriahasil_nama'];
                $model->kriteriahasil_namalain = strtoupper($_POST['SAKriteriahasilM']['kriteriahasil_nama']);
                $model->diagnosakep_id = null;
                $model->rangekriteriahasil = strtoupper($_POST['SAKriteriahasilM']['rangekriteriahasil']);
                $model->luarankeperawatan_id = strtoupper($_POST['SAKriteriahasilM']['luarankeperawatan_id']);

                $batkar = SAKriteriahasilM::model()->findByAttributes(array('luarankeperawatan_id' => $_POST['SAKriteriahasilM']['luarankeperawatan_id'], 'kriteriahasil_nama' => $_POST['SAKriteriahasilM']['kriteriahasil_nama'], 'rangekriteriahasil' => $_POST['SAKriteriahasilM']['rangekriteriahasil']));
                
                if (!empty($batkar)) {
                    $this->simpanBatasDetail($batkar->kriteriahasil_id, $_POST['SAKriteriahasildetM']);
                } else {

                    if ($model->validate()) {
                        $model->save();
                        $this->simpanBatasDetail($model->kriteriahasil_id, $_POST['SAKriteriahasildetM']);
                    } else {
                        var_dump($model->errors);
                        die;
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
                var_dump($exc->getMessage());
                die;
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
        $modDetail = new SAKriteriahasildetM;
        if (isset($_POST['SAKriteriahasilM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->updateByPk($id, array('luarankeperawatan_id' => $_POST['SAKriteriahasilM']['luarankeperawatan_id'], 'kriteriahasil_nama' => $_POST['SAKriteriahasilM']['kriteriahasil_nama'], 'rangekriteriahasil' => $_POST['SAKriteriahasilM']['rangekriteriahasil']));
                $model->save();
                $this->simpanBatasDetail($id, $_POST['SAKriteriahasildetM']);

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
        $dataProvider = new CActiveDataProvider('SAKriteriahasilM');
        $this->render($this->path_view . 'index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new SAKriteriahasildetM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SAKriteriahasildetM'])) {
            $model->attributes = $_GET['SAKriteriahasildetM'];
            //$model->diagnosakep_nama = isset($_GET['SAKriteriahasildetM']['diagnosakep_nama']) ? $_GET['SAKriteriahasildetM']['diagnosakep_nama'] : "";
            $model->kriteriahasil_nama = isset($_GET['SAKriteriahasildetM']['kriteriahasil_nama']) ? $_GET['SAKriteriahasildetM']['kriteriahasil_nama'] : "";
            $model->luarankeperawatan_id = isset($_GET['SAKriteriahasildetM']['luarankeperawatan_id']) ? $_GET['SAKriteriahasildetM']['luarankeperawatan_id'] : null;
            //$model->aktif = isset($_GET['aktif']) ? $_GET['aktif'] : NULL;
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

        $model = SAKriteriahasilM::model()->findBySql('SELECT kriteriahasil_m.*,luarankeperawatan_m.luarankeperawatan_id, luarankeperawatan_m.luarankeperawatan_nama
			FROM kriteriahasil_m
			JOIN luarankeperawatan_m ON luarankeperawatan_m.luarankeperawatan_id = kriteriahasil_m.luarankeperawatan_id
			WHERE kriteriahasil_m.kriteriahasil_id =' . $id);

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

    public function simpanBatas($post) {
        $model = new SAKriteriahasilM;
        $model->attributes = $post;
        $model->kriteriahasil_nama = $post['kriteriahasil_nama'];

        if ($model->save()) {
            $this->simpan = true;
        }
    }

    public function simpanBatasDetail($kriteriahasil_id, $post) {
        foreach ($post as $i => $row) {

            if (!empty($row['kriteriahasildet_id'])) {
                $modDetail = SAKriteriahasildetM::model()->findByPk($row['kriteriahasildet_id']);
                $modDetail->kriteriahasil_id = $kriteriahasil_id;
                $modDetail->kriteriahasildet_indikator = $row['kriteriahasildet_indikator'];
                $modDetail->kriteriahasildet_aktif = $row['kriteriahasildet_aktif'];
                if ($modDetail->validate()) {
                    $modDetail->save();
                    $this->simpan = true;
                }
            } else {
                $model = new SAKriteriahasildetM;
                $model->attributes = $row;
                $model->kriteriahasil_id = $kriteriahasil_id;
                $model->kriteriahasildet_indikator = $row['kriteriahasildet_indikator'];
                $model->kriteriahasildet_aktif = $row['kriteriahasildet_aktif'];

                if ($model->validate()) {
                    $model->save();
                    $this->simpan = true;
                }
            }
        }
    }

    public function actionPrint() {
        $model = new SAKriteriahasildetM;
        $model->attributes = $_REQUEST['SAKriteriahasildetM'];
        $judulLaporan = 'Data Kriteria Hasil';
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
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

    public function actionGetLookup($luarankeperawatan_id, $kriteriahasil_nama, $rangekriteriahasil) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new SAKriteriahasildetM();
            $batkar = SAKriteriahasilM::model()->findByAttributes(array('luarankeperawatan_id' => $luarankeperawatan_id, 'kriteriahasil_nama' => $kriteriahasil_nama, 'rangekriteriahasil' => $rangekriteriahasil));
            $data['form'] = "";
            if (isset($batkar->kriteriahasil_id)) {
                $models = $this->loadModelByType($batkar->kriteriahasil_id);
            } else if (isset($_POST['kriteriahasil_id'])) {
                $models = $this->loadModelByType($_POST['kriteriahasil_id']);
            } else {
                $models = array();
            }
            if (count($models) > 0) {
                foreach ($models AS $i => $model) {
                    if ($model->kriteriahasildet_aktif == true) {
                        $model->kriteriahasildet_aktif = 'aktif';
                    } else {
                        $model->kriteriahasildet_aktif = 'tidak aktif';
                    }
                    $data['form'] .= $this->renderPartial($this->path_view . '_rowLookup', array('model' => $model), true);
                }
            } else {
                $model->kriteriahasildet_aktif = 'aktif';
                $data['form'] .= $this->renderPartial($this->path_view . '_rowLookup', array('model' => $model), true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    private function loadModelByType($kriteriahasil_id) {
        $model = SAKriteriahasildetM::model()->findAllByAttributes(array('kriteriahasil_id' => $kriteriahasil_id), array('order' => 'kriteriahasil_id'));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            SAKriteriahasildetM::model()->deleteByPk($id);
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
     * Mengubah status aktif menjadi nonaktif
     * @param type $id 
     */
    public function actionRemoveTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = SAKriteriahasildetM::model()->updateByPk($id, array('kriteriahasildet_aktif' => 0));
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
            $update = SAKriteriahasildetM::model()->updateByPk($id, array('kriteriahasildet_aktif' => 1));
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
     * Autocompelete luaran
     */
    public function actionAutoCompleteLuaranKeperawatan() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $term = isset($_GET['term']) ? $_GET['term'] : null;
            $criteria = new CDbCriteria();
            $criteria = new CDbCriteria();
            $term = strtolower(trim($_GET['term']));

            $criteria->compare('LOWER(luarankeperawatan_nama)', strtolower($_GET['term']), true);
            $criteria->addCondition('luarankeperawatan_aktif is true');
            $criteria->order = 'luarankeperawatan_nama';
            $criteria->limit = 5;

            $models = LuarankeperawatanM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->luarankeperawatan_nama;
                $returnVal[$i]['value'] = $model->luarankeperawatan_nama;
                $returnVal[$i]['luarankeperawatan_id'] = $model->luarankeperawatan_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

}
