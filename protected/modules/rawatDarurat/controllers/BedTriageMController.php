<?php

/**
 *   - digunakan sebagai url utama untuk mengelola master bed triage
 *   @author	Refi Fadholi <refifadholi@gmail.com>
 *   
 */
class BedTriageMController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';
    public $path_view = 'rawatDarurat.views.bedTriageM.';
    public $successSaveObatAlkes = false;
    public $succesSaveModObatAlkesDetail = false;
    public $obatSupplierTersimpan = true;
    public $therapiObatTersimpan = true;
    public $lockJenis = false;
    public $defaultJenis;

    public function actionCekOtoritas() {
        if (Yii::app()->request->isAjaxRequest) {
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $idLoginPemakai = 'null';
            $modLoginPemakai = GFLoginPemakaiK::model()->find('nama_pemakai=\'' . $username . '\' AND katakunci_pemakai=\'' . $password . '\'');
            if ($modLoginPemakai) {//Jika Username dan Passwordnya Bnear
                if ($this->checkAccess(array("loginpemakai_id" => $modLoginPemakai->loginpemakai_id, "action" => Params::DEFAULT_UPDATE))) {
                    $message = 'Supervisor';
                    $idLoginPemakai = $modLoginPemakai->loginpemakai_id;
                } else {//Jika username yang dimasukan tidak mempunyai hak akses supervisor
                    $message = 'Anda Tidak Diijinkan Untuk Mengubah Harga Obat';
                }
            } else {//Jika Usename atau password salah
                $message = 'Terjadi Kesalahan dan memasukan Username atau Password';
            }
            $data['message'] = $message;
            $data['loginpemakai_id'] = $idLoginPemakai;
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

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

        $model = new BedTriageM();

        if (isset($_POST['BedTriageM'])) {

            $transaction = Yii::app()->db->beginTransaction();

            try {
                $model->attributes = $_POST['BedTriageM'];
                $model->is_aktif = $_POST['BedTriageM']['is_aktif'] == "1" ? true : false;
                $model->create_time = date("Y-m-d H:i:s");
                $model->create_loginpemakai_id = Yii::app()->user->id;

                if ($model->save()) {

                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Bed Triage berhasil disimpan");
                    $this->redirect(array('admin', 'sukses' => 1));
                } else {
                    Yii::app()->user->setFlash('error', "Data Bed Triage gagal disimpan");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
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

        $model = BedTriageM::model()->findByPk($id);

        if (isset($_POST['BedTriageM'])) {

            $transaction = Yii::app()->db->beginTransaction();

            try {
                $model->attributes = $_POST['BedTriageM'];
                $model->is_aktif = $_POST['BedTriageM']['is_aktif'] == "1" ? true : false;
                $model->update_time = date("Y-m-d H:i:s");
                $model->update_loginpemakai_id = Yii::app()->user->id;

                if ($model->save()) {

                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Bed Triage berhasil disimpan");
                    $this->redirect(array('admin', 'sukses' => 1));
                } else {
                    Yii::app()->user->setFlash('error', "Data Bed Triage gagal disimpan");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
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
        $dataProvider = new CActiveDataProvider('RDObatAlkesM');
        $this->render($this->path_view . 'index', array(
            'dataProvider' => $dataProvider,
        ));
    }
 
    /**
     * Manages all models.
     */
    public function actionAdmin() {

        $model = new BedTriageM('searchBedTriage');
        $model->unsetAttributes();
        $model->is_aktif = true;

        // clear any default values

        if (isset($_GET['BedTriageM'])) {
            $model->attributes = $_GET['BedTriageM'];
            $model->is_aktif = $_GET['BedTriageM']['is_aktif'];
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
        $model = BedTriageM::model()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'bed-triage-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionDelete() {
        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            $obatAlkes = BedTriageM::model()->findByPk($id);

            $obatAlkes->delete();

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
     * @param type $id
     */
    public function actionRemoveTemporary() {
        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
        //                    SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif'=>false));
        //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = BedTriageM::model()->updateByPk($id, array('is_aktif' => false,
                'update_time' => date('Y-m-d H:i:s'), 'update_loginpemakai_id' => Yii::app()->user->id));
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
     * untuk print obat alkes pada menu master
     */
    public function actionPrint()
    {
        $model = new BedTriageM('searchBedTriage');
        $model->unsetAttributes();
        $model->is_aktif = true;

        // clear any default values

        if (isset($_GET['BedTriageM'])) {
            $model->attributes = $_GET['BedTriageM'];
            $model->is_aktif = $_GET['BedTriageM']['is_aktif'];
        }

        $judulLaporan = 'Data Bed Triage';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', [
                'model' => $model,
                'judulLaporan' => $judulLaporan,
                'caraPrint' => $caraPrint,
            ]);
        } elseif ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', [
                'model' => $model,
                'judulLaporan' => $judulLaporan,
                'caraPrint' => $caraPrint,
            ]);
        } elseif ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');

            //Posisi L->Landscape,P->Portait
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            ////$mpdf->useOddEven = 2;
            // $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
            //                        echo '<pre>';var_dump(new MyPDF('', $ukuranKertasPDF)); die();

            $mpdf->WriteHTML(
                $this->renderPartial(
                    'Print',
                    [
                        'model' => $model,
                        'judulLaporan' => $judulLaporan,
                        'caraPrint' => $caraPrint,
                    ],
                    true
                )
            );
            $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
        }
    }

    /**
     * @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     *
     * - digunakan untuk membuat notifikasi, jika ada obat baru
     * @param type $modObat
     * @return type
     */
    public function notifObatBaru($modObat) {

        $judul = 'Obat & Alkes Baru';

        $isi = $modObat->obatalkes_kode . ' ' . $modObat->obatalkes_nama;

        return CustomFunction::broadcastNotif($judul, $isi, array(
                    array('instalasi_id' => Params::INSTALASI_ID_KEUANGAN, 'ruangan_id' => Params::RUANGAN_ID_KASIR, 'modul_id' => Params::MODUL_ID_BILLINGKASIR),
                    array('instalasi_id' => Params::INSTALASI_ID_KEUANGAN, 'ruangan_id' => Params::RUANGAN_ID_BENDAHARA, 'modul_id' => Params::MODUL_ID_KEUANGAN),
                    array('instalasi_id' => Params::INSTALASI_ID_KEUANGAN, 'ruangan_id' => Params::RUANGAN_ID_FINANCE, 'modul_id' => Params::MODUL_ID_KEUANGAN),
        ));
    }

}
