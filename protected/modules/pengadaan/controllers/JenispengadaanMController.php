
<?php
/**
 * Controller untuk master Jenis Pengadaan
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 */
class JenispengadaanMController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';

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
        $model = new JenispengadaanM;

        if (isset($_POST['JenispengadaanM'])) {
            $model->attributes = $_POST['JenispengadaanM'];
            $model->jenispengadaan_aktif = true;
            $model->create_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin'));
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


        if (isset($_POST['JenispengadaanM'])) {
            $model->attributes = $_POST['JenispengadaanM'];
            if (empty($model->jenispengadaan_aktif)) {
                $model->jenispengadaan_aktif = false;
            } else {
                $model->jenispengadaan_aktif = true;
            }
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
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
            $update = JenispengadaanM::model()->updateByPk($id, array('jenispengadaan_aktif' => false));
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
            $update = JenispengadaanM::model()->updateByPk($id, array('jenispengadaan_aktif' => true));
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
        $dataProvider = new CActiveDataProvider('JenispengadaanM');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Pengaturan data.
     */
    public function actionAdmin() {
        $model = new JenispengadaanM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['JenispengadaanM'])) {
            $model->attributes = $_GET['JenispengadaanM'];
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
        $model = JenispengadaanM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'jenispengadaan-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint() {
        $model = new JenispengadaanM;
        $model->attributes = $_REQUEST['JenispengadaanM'];
        $judulLaporan = 'Data Jenis Pengadaan';
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

}
