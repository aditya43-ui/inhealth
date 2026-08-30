<?php

/**
 * digunakan untuk Master Grading Risiko
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 * */
class GradingrisikoRiskregisterMController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $simpan = true;
    public $path_view = 'yankesMasyarakat.views.gradingrisikoRiskregisterM.';
    public $path_tips = 'sistemAdministrator.views.tips.';

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
        $model = new GradingrisikoRiskregisterM;
        if (isset($_POST['GradingrisikoRiskregisterM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($_POST['GradingrisikoRiskregisterM'] as $i => $post) {
                    if (empty($post['gradingrisiko_riskregister_id'])) {
                        $model = new GradingrisikoRiskregisterM();
                        $model->attributes = $post;
                        if ($post['gradingrisiko_aktif'] == 'Aktif') {
                            $model->gradingrisiko_aktif = true;
                        } else {
                            $model->gradingrisiko_aktif = false;
                        }
                        $model->create_time = date('Y-m-d H:i:s');
                        $model->create_loginpemakai_id = Yii::app()->user->id;
                        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $this->simpan = $model->save() && true;
                    }
                }
                if ($this->simpan) {
                    $transaction->commit();
                    Yii::app()->user->setFlash("success", "Data berhasil Disimpan");
                    $this->redirect(array('admin'));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash("error", "Data Gagal Disimpan");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash("error", "Data Gagal Disimpan");
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
        $tingkatRisiko = TingkatrisikoRiskregisterM::model()->findByPk($model->tingkatrisiko_riskregister_id);
        $model->warnarisiko = $tingkatRisiko->tingkatrisiko_warna;
        if ($model->gradingrisiko_aktif == false) {
            $model->gradingrisiko_aktif = 0;
        } else {
            $model->gradingrisiko_aktif = 1;
        }

        if (isset($_POST['GradingrisikoRiskregisterM'])) {
            $model->attributes = $_POST['GradingrisikoRiskregisterM'];
            $status_aktif = $_POST['GradingrisikoRiskregisterM']['gradingrisiko_aktif'];
            if ($status_aktif == 0) {
                $model->gradingrisiko_aktif = false;
            } else {
                $model->gradingrisiko_aktif = true;
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin', 'id' => $model->gradingrisiko_riskregister_id));
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
        $dataProvider = new CActiveDataProvider('GradingrisikoRiskregisterM');
        $this->render($this->path_view . 'index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {

        $model = new GradingrisikoRiskregisterM('search');
        $model->unsetAttributes();  // clear any default values
        $model->gradingrisiko_aktif = 1;
        if (isset($_GET['GradingrisikoRiskregisterM']))
            $model->attributes = $_GET['GradingrisikoRiskregisterM'];

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
        $model = GradingrisikoRiskregisterM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'gradingrisiko-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Menghapus Data
     */
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            $this->loadModel($id)->delete();
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'proses_form',
                    'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
                ));
                exit;
            }
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Mengubah status menjadi nonaktif
     */
    public function actionRemoveTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = GradingrisikoRiskregisterM::model()->updateByPk($id, array('gradingrisiko_aktif' => false));
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
            $update = GradingrisikoRiskregisterM::model()->updateByPk($id, array('gradingrisiko_aktif' => true));
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
     * Mencetak Dokumen
     */
    public function actionPrint() {
        $model = new GradingrisikoRiskregisterM;
        if (isset($_REQUEST['GradingrisikoRiskregisterM'])) {
            $model->attributes = $_REQUEST['GradingrisikoRiskregisterM'];
        }
        $judulLaporan = 'Data Grading Risiko';
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
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
        }
    }

    /**
     * Mendapatkan data grading risiko dari inputan user
     */
    public function actionGetTabel() {
        if (Yii::app()->request->isAjaxRequest) {
            //get data post
            $peluang_id = $_POST['peluang_id'];
            $konsekuensi_id = $_POST['konsekuensi_id'];
            $detectability_id = $_POST['detectability_id'];
            $tingkatrisiko_riskregister_id = $_POST['tingkatrisiko_riskregister_id'];
            $warnarisiko = $_POST['warnarisiko'];
            $aktif = $_POST['aktif'];
            if ($aktif == 1) {
                $aktif = 'Aktif';
            } else {
                $aktif = 'Tidak Aktif';
            }

            $criteria = new CDbCriteria();
            $criteria->addCondition("peluang_id =" . $peluang_id);
            $criteria->addCondition("konsekuensi_id =" . $konsekuensi_id);
            $criteria->addCondition("detectability_id =" . $detectability_id);
            $criteria->addCondition("tingkatrisiko_riskregister_id =" . $tingkatrisiko_riskregister_id);
            $cekGrading = GradingrisikoRiskregisterM::model()->find($criteria);

            if (empty($cekGrading)) {

                $peluang = PeluangM::model()->findByPk($peluang_id);
                $konsekuensi = KonsekuensiM::model()->findByPk($konsekuensi_id);
                $tingkatrisiko = TingkatrisikoRiskregisterM::model()->findByPk($tingkatrisiko_riskregister_id);
                $detectability = DetectabilityM::model()->findByPk($detectability_id);

                //set new model
                $model = new GradingrisikoRiskregisterM();
                $model->peluang_id = $peluang_id;
                $model->peluang_descriptor = $peluang->peluang_descriptor;
                $model->konsekuensi_id = $konsekuensi_id;
                $model->konsekuensi_namabobot = $konsekuensi->konsekuensi_namabobot;
                $model->detectability_id = $detectability_id;
                $model->detectability_deskripsi = $detectability->detectability_deskripsi;
                $model->tingkatrisiko_riskregister_id = $tingkatrisiko_riskregister_id;
                $model->tingkatrisiko_nama = $tingkatrisiko->tingkatrisiko_nama;
                $model->warnarisiko = $warnarisiko;
                $model->gradingrisiko_aktif = $aktif;

                $return = $this->renderPartial("_rowTabel", array('model' => $model, 'i' => 1), true);
                $message = 'sukses';
            } else {
                $return = '';
                $message = 'gagal';
            }
            $data['return'] = $return;
            $data['message'] = $message;
            $data['peluang_id'] = $peluang_id;
            $data['konsekuensi_id'] = $konsekuensi_id;
            $data['detectability_id'] = $detectability_id;
            $data['tingkatrisiko_riskregister_id'] = $tingkatrisiko_riskregister_id;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Mendapatkan data subtipe insiden dari inputan user
     */
    public function actionSetTabel() {
        if (Yii::app()->request->isAjaxRequest) {
            //get data post
            $data['form'] = "";
            $tipeinsiden_id = $_POST['tipeinsiden_id'];
            $kelompokgradingrisiko_riskregister_id = $_POST['kelompokgradingrisiko_riskregister_id'];

            $criteria = new CDbCriteria();
            $criteria->addCondition("tipeinsiden_id =" . $tipeinsiden_id);
            $criteria->addCondition("kelompokgradingrisiko_riskregister_id =" . $kelompokgradingrisiko_riskregister_id);
            $models = SubtipeinsidenM::model()->findAll($criteria);

            if (count($models) > 0) {
                $a = 1;
                foreach ($models AS $i => $model) {
                    if ($model->gradingrisiko_aktif == 1) {
                        $aktif = 'Aktif';
                    } else {
                        $aktif = 'Tidak Aktif';
                    }
                    $model->gradingrisiko_riskregister_id = $model->gradingrisiko_riskregister_id;
                    $model->tipeinsiden_id = $model->tipeinsiden_id;
                    $model->kelompokgradingrisiko_riskregister_id = $model->kelompokgradingrisiko_riskregister_id;
                    $model->gradingrisiko_nama = $model->gradingrisiko_nama;
                    $model->gradingrisiko_namalainnya = $model->gradingrisiko_namalainnya;
                    $model->gradingrisiko_aktif = $aktif;

                    $data['form'] .= $this->renderPartial('_rowTabelInsiden', array('model' => $model, 'i' => $a), true);
                    $a++;
                }
            } else {
                $model = new SubtipeinsidenM();
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Mendapatkan data subtipe insiden dari inputan user
     */
    public function actionGetWarnaRisiko() {
        if (Yii::app()->request->isAjaxRequest) {
            //get data post
            $tingkatrisiko_riskregister_id = $_POST['tingkatrisiko_riskregister_id'];
            if (!empty($tingkatrisiko_riskregister_id)) {
                $criteria = new CDbCriteria();
                $criteria->addCondition("tingkatrisiko_riskregister_id =" . $tingkatrisiko_riskregister_id);
                $tingkatrisiko = TingkatrisikoRiskregisterM::model()->find($criteria);
                if (!empty($tingkatrisiko)) {
                    $return = $tingkatrisiko->tingkatrisiko_warna;
                    $message = 'sukses';
                } else {
                    $return = '';
                    $message = 'gagal';
                }
            } else {
                $return = '';
                $message = 'gagal';
            }
            $data['return'] = $return;
            $data['message'] = $message;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

}
