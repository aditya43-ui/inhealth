<?php
/**
 * Digunakan untuk mencatat master dari Peluang
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 */
class PeluangMController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $simpan = false;
    public $path_tips = 'yankesMasyarakat.views.peluangM.';

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
        $model = new PeluangM;
        if (isset($_POST['PeluangM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($_POST['PeluangM'] as $i => $post) {
                    $model = new PeluangM();
                    $model->attributes = $post;
                    if ($post['peluang_aktif'] == 'Aktif') {
                        $model->peluang_aktif = true;
                    } else {
                        $model->peluang_aktif = false;
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


        if (isset($_POST['PeluangM'])) {
            $model->attributes = $_POST['PeluangM'];
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
            $update = PeluangM::model()->updateByPk($id, array('peluang_aktif' => false));
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
            $update = PeluangM::model()->updateByPk($id, array('peluang_aktif' => true));
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
        $dataProvider = new CActiveDataProvider('PeluangM');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Pengaturan data.
     */
    public function actionAdmin() {
        $model = new PeluangM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PeluangM'])) {
            $model->attributes = $_GET['PeluangM'];
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
        $model = PeluangM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'peluang-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint() {
        $model = new PeluangM;
        $model->attributes = $_REQUEST['PeluangM'];
        $judulLaporan = 'Data Peluang';
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
     * Mendapatkan data peluang dari inputan user
     */
    public function actionGetTabel() {
        if (Yii::app()->request->isAjaxRequest) {
            //get data post
            $peluang_descriptor = $_POST['peluang_descriptor'];
            $peluang_bobotdescriptor = $_POST['peluang_bobotdescriptor'];
            $peluang_deskripsi = $_POST['peluang_deskripsi'];
            $peluang_frekuensi = $_POST['peluang_frekuensi'];
            $peluang_kemungkinan = $_POST['peluang_kemungkinan'];
            $aktif = $_POST['aktif'];
            if ($aktif == 1) {
                $aktif = 'Aktif';
            } else {
                $aktif = 'Tidak Aktif';
            }
            //set new model
            $model = new PeluangM();

            $model->peluang_descriptor = $peluang_descriptor;
            $model->peluang_bobotdescriptor = $peluang_bobotdescriptor;
            $model->peluang_deskripsi = $peluang_deskripsi;
            $model->peluang_frekuensi = $peluang_frekuensi;
            $model->peluang_kemungkinan = $peluang_kemungkinan;
            $model->peluang_aktif = $aktif;

            $return = $this->renderPartial("_rowTabel", array('model' => $model, 'i' => 1), true);

            $data['return'] = $return;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

}
