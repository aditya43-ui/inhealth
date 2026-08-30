<?php
/**
 * Digunakan untuk mencatat master dari Tipe Resiko
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 */
class TiperesikoMController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $simpan = false;
    public $path_tips = 'yankesMasyarakat.views.tiperesikoM.';

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
        $model = new TiperesikoM;
        if (isset($_POST['TiperesikoM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($_POST['TiperesikoM'] as $i => $post) {
                    $model = new TiperesikoM();
                    $model->attributes = $post;
                    if ($post['tiperesiko_aktif'] == 'Aktif') {
                        $model->tiperesiko_aktif = true;
                    } else {
                        $model->tiperesiko_aktif = false;
                    }
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $this->simpan = $model->save() && true;
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
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Memanggil dan Mengubah sebagian data.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed


        if (isset($_POST['TiperesikoM'])) {
            $model->attributes = $_POST['TiperesikoM'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Digunakan untuk menghapus data
     * @throws CHttpException
     */
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];

            $delete = $this->loadModel($id)->delete();
            if ($delete) {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'proses_form',
                        'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
                    ));
                    exit;
                }
            }
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Mengubah status aktif menjadi nonaktif
     */
    public function actionRemoveTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = TiperesikoM::model()->updateByPk($id, array('tiperesiko_aktif' => false));
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
     */
    public function actionAktifkan() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = TiperesikoM::model()->updateByPk($id, array('tiperesiko_aktif' => true));
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
        $dataProvider = new CActiveDataProvider('TiperesikoM');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Pengaturan data.
     */
    public function actionAdmin() {
        $model = new TiperesikoM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TiperesikoM'])) {
            $model->attributes = $_GET['TiperesikoM'];
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
        $model = TiperesikoM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'jawabanquisioner-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint() {
        $model = new TiperesikoM;
        $model->attributes = $_REQUEST['TiperesikoM'];
        $judulLaporan = 'Data Tipe Risiko';
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
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

    /**
     * Mendapatkan data tipe resiko dari inputan user
     */
    public function actionGetTabel() {
        if (Yii::app()->request->isAjaxRequest) {
            //get data post
            $nama = $_POST['nama'];
            $namalain = $_POST['namalain'];
            $kode = $_POST['kode'];
            $keterangan = $_POST['keterangan'];
            $aktif = $_POST['aktif'];
            if ($aktif == 1) {
                $aktif = 'Aktif';
            } else {
                $aktif = 'Tidak Aktif';
            }
            //set new model
            $model = new TiperesikoM();

            $model->tiperesiko_nama = $nama;
            $model->tiperesiko_namalain = $namalain;
            $model->tiperesiko_kode = $kode;
            $model->tiperesiko_keterangan = $keterangan;
            $model->tiperesiko_aktif = $aktif;

            $return = $this->renderPartial("_rowTabel", array('model' => $model, 'i' => 1), true);

            $data['return'] = $return;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

}
