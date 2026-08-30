<?php

/**
 * controller ini digunakan untuk mengakses menu model antrian 
 * 
 * @package application.modules.bankDarah
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class ModelAntrianController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';
    public $path_view = 'sistemAdministrator.views.modelAntrian.';
    public $path_tips = 'sistemAdministrator.views.tips.';

    /**
     * Menampilkan detail data.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $this->render($this->path_view . 'view', array(
            'model' => $model,
        ));
    }

    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionCreate() {
        $model = new SAModelantrianM;

        if (isset($_POST['SAModelantrianM'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['SAModelantrianM'];
                $model->modelantrian_gambartombol = CUploadedFile::getInstance($model, 'modelantrian_gambartombol');
                $model->modelantrian_buka = !empty($model->modelantrian_buka) ? $model->modelantrian_buka : null;
                $model->modelantrian_tutup = !empty($model->modelantrian_tutup) ? $model->modelantrian_tutup : null;
                $file = null;
                if (!empty($model->modelantrian_gambartombol)) {

                    $file = $model->modelantrian_gambartombol;
                    $name = date('His') . "_" . $file;
                    if (!empty($file)) {
                        $model->modelantrian_gambartombol = $name;
                    } else {
                        $model->modelantrian_gambartombol = null;
                    }
                }

                $ok = $ok && $model->save();

                if ($ok) {
                    if (!empty($file)) {
                        $target_dir = Params::pathAntrianCustomDirectory();
                        $antrian_dir = Params::pathAntrianDirectory();

                        if (!file_exists($antrian_dir)) {
                            mkdir($antrian_dir, 0777, true);                            
                        }

                        if (!file_exists($target_dir)) {
                            mkdir($target_dir, 0777, true);
                        }

                        $fullImgName = $model->modelantrian_gambartombol;
                        $fullImgSource = Params::pathAntrianCustomDirectory() . $fullImgName;
                        $file->saveAs($fullImgSource);
                    }

                    $trans->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('admin'));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $exc) {
                echo '<pre>'; var_dump($exc); die;
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_view . 'create', array(
            'model' => $model,
        ));
    }

    /**
     * Memanggil dan Mengubah sebagian data.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->modelantrian_temp = $model->modelantrian_gambartombol;

        if (isset($_POST['SAModelantrianM'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['SAModelantrianM'];
                $model->modelantrian_gambartombol = CUploadedFile::getInstance($model, 'modelantrian_gambartombol');
                $model->modelantrian_buka = !empty($model->modelantrian_buka) ? $model->modelantrian_buka : null;
                $model->modelantrian_tutup = !empty($model->modelantrian_tutup) ? $model->modelantrian_tutup : null;

                $file = null;
                if (!empty($model->modelantrian_gambartombol)) {

                    $file = $model->modelantrian_gambartombol;
                    $name = date('His') . "_" . $file;
                    if (!empty($file)) {
                        $model->modelantrian_gambartombol = $name;
                    } else {
                        $model->modelantrian_gambartombol = null;
                    }
                } else {
                    $model->modelantrian_gambartombol = $model->modelantrian_temp;
                }

                $ok = $ok && $model->save();

                if ($ok) {
                    if (!empty($file)) {
                        $target_dir = Params::pathAntrianCustomDirectory();
                        if (!file_exists($target_dir)) {
                            mkdir($target_dir, 0755, true);
                        }

                        $fullImgName = $model->modelantrian_gambartombol;
                        $fullImgSource = Params::pathAntrianCustomDirectory() . $fullImgName;
                        $file->saveAs($fullImgSource);

                        if (!empty($model->modelantrian_temp)) {
                            if ($model->modelantrian_temp != $model->modelantrian_gambartombol) {
                                if (file_exists(Params::pathAntrianCustomDirectory() . $model->modelantrian_temp)) {
                                    unlink(Params::pathAntrianCustomDirectory() . $model->modelantrian_temp);
                                }
                            }
                        }
                    }

                    $trans->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('admin'));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $exc) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_view . 'update', array(
            'model' => $model,
        ));
    }

    /**
     * Mengubah status aktif
     * @param type $id 
     */
    public function actionRemoveTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = ModelantrianM::model()->updateByPk($id, array('modelantrian_aktif' => false));
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
     * Memanggil dan menonaktifkan status 
     */
    public function actionDelete() {
        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;
            $data['pesan'] = '';
            $model = $this->loadModel($_POST['id']);
            
            $antrian = AntrianT::model()->findByAttributes(array('modelantrian_id' => $model->modelantrian_id));
            $loket = LoketM::model()->findByAttributes(array('modelantrian_id' => $model->modelantrian_id));
            if (!empty($antrian)){
                $data['pesan'] = ' Model antrian ini sudah digunakan di tabel lain';
            }elseif (!empty($loket)){
                $data['pesan'] = ' Model antrian ini sudah digunakan di tabel lain';            
            }elseif ($model->delete()) {
                
                $data['sukses'] = 1;
            }
           
            
            echo CJSON::encode($data);
        }
    }

    /**
     * Pengaturan data.
     */
    public function actionAdmin() {
        $model = new SAModelantrianM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SAModelantrianM'])) {
            $model->attributes = $_GET['SAModelantrianM'];
        }
        $this->render($this->path_view . 'admin', array(
            'model' => $model,
        ));
    }

    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = SAModelantrianM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'saloket-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint() {
        $model = new SAModelantrianM();
        $model->attributes = $_REQUEST['SAModelantrianM'];
        $judulLaporan = 'Data Model Antrian';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            // $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

}