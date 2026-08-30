<?php
/**
 * Master Petunjuk Transaksi 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 * @category controller
 */
class PetunjuktransaksiMController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';
    public $petunjukTersimpan = 'true';

    /**
     * Menampilkan detail data.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionCreate() {
        $model = new YKMPetunjuktransaksiM();
        $modDetail = new PetunjuktransaksiM();
        if (isset($_POST['PetunjuktransaksiM'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $this->simpanPetunjuk($_POST['YKMPetunjuktransaksiM']['petunjuktransaksi_type'], $_POST['PetunjuktransaksiM']);
                if ($this->petunjukTersimpan) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('admin', 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'modDetail' => $modDetail
        ));
    }

    /**
     * Load row dokumen
     */
    public function actionGetPetunjuk() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new PetunjuktransaksiM;
            $data['form'] = "";
            $models = PetunjuktransaksiM::model()->findAllByAttributes(array('petunjuktransaksi_type' => $_POST['tipe']));
            if (count($models) > 0) {
                foreach ($models AS $i => $model) {
                    $model->temp_file = $model->petunjuktransaksi_image;
                    $data['form'] .= $this->renderPartial('_rowPetunjuk', array('model' => $model), true);
                }
            } else {
                $data['form'] .= $this->renderPartial('_rowPetunjuk', array('model' => $model), true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Simpan 
     * @param type $tipe
     * @param type $post
     */
    public function simpanPetunjuk($tipe, $post) {
        $ok = true;
        foreach ($post as $i => $data) {
            if (empty($data['petunjuktransaksi_id'])) {
                $model = new PetunjuktransaksiM();
                $model->attributes = $data;
                $model->petunjuktransaksi_type = $tipe;
                $model->petunjuktransaksi_image = CUploadedFile::getInstance($model, '[' . $i . ']petunjuktransaksi_image');
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                $dokumen_pendukung = $model->petunjuktransaksi_image;

                if (!empty($dokumen_pendukung)) {
                    $fullImgName = str_replace(' ', '_', strtolower(date('dmY_s') . $dokumen_pendukung));
                    $fullImgSource = Params::pathPetunjukTransaksiDirectory() . $fullImgName;
                    $model->petunjuktransaksi_image = $fullImgName;
                }

                $ok = $ok && $model->save();
            } else {
                $model = PetunjuktransaksiM::model()->findByPk($data['petunjuktransaksi_id']);
                $model->attributes = $data;
                $model->petunjuktransaksi_type = $tipe;
                $temp = $data['temp_file'];

                $model->petunjuktransaksi_image = CUploadedFile::getInstance($model, '[' . $i . ']petunjuktransaksi_image');
                if (!empty($model->petunjuktransaksi_image)) {
                    $dokumen_pendukung = $model->petunjuktransaksi_image;

                    $fullImgName = str_replace(' ', '_', strtolower(date('dmY_s') . $dokumen_pendukung));
                    $fullImgSource = Params::pathPetunjukTransaksiDirectory() . $fullImgName;
                    $model->petunjuktransaksi_image = $fullImgName;
                } else {
                    $model->petunjuktransaksi_image = $temp;
                }
                $ok = $ok && $model->save();
            }
            if ($ok) {

                if (!empty($dokumen_pendukung)) {
                    
                    if (!file_exists(Params::pathPetunjukTransaksiDirectory())){
                        mkdir(Params::pathPetunjukTransaksiDirectory(), 0775, true);
                    }
                    
                    if (!empty($temp)) {
                        if ($model->petunjuktransaksi_image != $temp) {
                            if (!empty($model->petunjuktransaksi_image)) {
                                if (file_exists(Params::pathPetunjukTransaksiDirectory() . $temp)) {
                                    unlink(Params::pathPetunjukTransaksiDirectory() . $temp);
                                }
                            }
                        }
                    }

                    $dokumen_pendukung->saveAs($fullImgSource);
                }
            }
        }
    }

    /**
     * Memanggil dan Mengubah sebagian data.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $modDetail = new PetunjuktransaksiM;

        if (isset($_POST['PetunjuktransaksiM'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $this->simpanPetunjuk($_POST['YKMPetunjuktransaksiM']['petunjuktransaksi_type'], $_POST['PetunjuktransaksiM']);
                if ($this->petunjukTersimpan) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('admin', 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'modDetail' => $modDetail
        ));
    }

    /**
     * Hapus data 
     * @throws CHttpException
     */
    public function actionDeleteRow() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            // we only allow deletion via POST request
            $data['sukses'] = 0;
            $data['pesan'] = "Data gagal dihapus!";
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if ($this->loadModel($id)->delete()) {
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                } else {
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data tidak dapat dihapus";
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data tidak dapat dihapus";
            }
            echo CJSON::encode($data);
            Yii::app()->end();

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
            $update = PetunjuktransaksiM::model()->updateByPk($id, array('petunjuktransaksi_aktif' => false));
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
            $update = PetunjuktransaksiM::model()->updateByPk($id, array('petunjuktransaksi_aktif' => true));
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
     * Melihat daftar data.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('PetunjuktransaksiM');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Pengaturan data.
     */
    public function actionAdmin() {
        $model = new PetunjuktransaksiM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PetunjuktransaksiM'])) {
            $model->attributes = $_GET['PetunjuktransaksiM'];
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = YKMPetunjuktransaksiM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'petunjuktransaksi-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint() {
        $model = new PetunjuktransaksiM;
        $model->attributes = $_REQUEST['PetunjuktransaksiM'];
        $judulLaporan = 'Data Petunjuk Penggunaan';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }
    
    /**
     * Fungsi unduh dokumen pendukung
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = PetunjuktransaksiM::model()->findByPk($id);
        $path = Params::pathPetunjukTransaksiDirectory()."/".$filename->petunjuktransaksi_image;
        if (!empty($filename->petunjuktransaksi_image)) {
            if (file_exists($path)) {
                Yii::app()->getRequest()->sendFile($filename->petunjuktransaksi_image, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Params::pathPetunjukTransaksiDirectory().'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Params::pathPetunjukTransaksiDirectory().'file_tidak_ditemukan.txt'));   
        }
    }

}
