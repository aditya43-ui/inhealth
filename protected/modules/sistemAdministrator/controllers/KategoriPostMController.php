<?php

/**
 * digunakan untuk modul portal rs post berita
 * RSST-2443
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package         application.modules.pendidikanKlinis
 * @subpackage      controllers
 */
class KategoriPostMController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout = '//layouts/iframe';
    public $path_view = 'sistemAdministrator.views.kategoriPostM.';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $data = $this->loadModel($id);
        $this->render('view', array(
            'model' => $data,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new KategoripostM;

        // Uncomment the following line if AJAX validation is needed


        if (isset($_POST['KategoripostM'])) {

            try {
                $ok = true;

                $trans = Yii::app()->db->beginTransaction();
                $model->attributes = $_POST['KategoripostM'];
                
                if (!empty(CUploadedFile::getInstance($model, 'kategoripost_gambar'))) {
                    $model->kategoripost_gambar = CUploadedFile::getInstance($model, 'kategoripost_gambar');
                    $imageInfo = getimagesize(CUploadedFile::getInstance($model, 'kategoripost_gambar')->getTempName());
                    if ($imageInfo[0] <= 420 && $imageInfo[1] <= 154) {
                    $ok = false;
                     Yii::app()->user->setFlash('error', "File Tidak Sesuai Ketentuan/Bukan Format Gambar" . CHtml::errorSummary($model));
                    $this->redirect(array('admin'));
                }

                $gambar = $model->kategoripost_gambar;
                    
                }
                //validasi dimensi 
                
                $random = rand(0000000, 9999999);

                Yii::import("ext.EPhpThumb.EPhpThumb");
                $thumb = new EPhpThumb();
                $thumb->init();
                if (!empty($model->kategoripost_gambar)) {

                    $model->kategoripost_gambar = strtolower(str_replace(" ", "_", $random . $model->kategoripost_gambar));
                    $rand_gambar = $model->kategoripost_gambar;
                    $fullImgName = $rand_gambar;
                    $fullImgSource = Params::pathKategoriBeritaGambar() . $fullImgName;
                    $fullThumbSource = Params::pathTumbsKategoriBeritaGambar() . $fullImgName;
                    $model->kategoripost_gambar = $fullImgName;
                    $ok = $ok && $gambar->saveAs($fullImgSource);
                    $cropimg = $thumb->create($fullImgSource)->adaptiveResize(420, 154);
                    $ok = $ok && $cropimg->save($fullThumbSource);
                    
                   
                }

                $model->create_time = date("Y-m-d");
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $ok = $ok && $model->save();
                



                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('admin'));
                } else {

                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $e) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                //Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render('create', array(
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

        $temp_path_gambar = $model->kategoripost_gambar;

        if (empty($_POST['KategoripostM'])) {
            $model->kategoripost_gambar = $temp_path_gambar;
        }

        if (isset($_POST['KategoripostM'])) {
            try {
                $ok = true;
                $trans = Yii::app()->db->beginTransaction();
                $model->attributes = $_POST['KategoripostM'];

                if (empty(CUploadedFile::getInstance($model, 'kategoripost_gambar'))) {//jika tidak upload data baru
                    $model->kategoripost_gambar = $temp_path_gambar;
                    $ok = $model->save();
                } else {//jika upload data baru
                    $model->kategoripost_gambar = CUploadedFile::getInstance($model, 'kategoripost_gambar');
                    $imageInfo = getimagesize(CUploadedFile::getInstance($model, 'kategoripost_gambar')->getTempName());
                    //validasi dimensi 
                    if ($imageInfo[0] <= 420 && $imageInfo[1] <= 154) {
                        $ok = false;
                        Yii::app()->user->setFlash('error', "File Tidak Sesuai Ketentuan/Bukan Format Gambar" . CHtml::errorSummary($model));
                        $this->redirect(array('admin'));
                    }

                    $gambar = $model->kategoripost_gambar;
                    $random = rand(0000000, 9999999);

                    Yii::import("ext.EPhpThumb.EPhpThumb");
                    $thumb = new EPhpThumb();
                    $thumb->init();
                    if (isset($model->kategoripost_gambar) && ($model->kategoripost_gambar != $temp_path_gambar)) {//jika data lama dan baru tidaksama;
                        if (!empty($temp_path_gambar)) {
                            if (file_exists(Params::pathKategoriBeritaGambar() . $temp_path_gambar)) {
                                unlink(Params::pathKategoriBeritaGambar() . $temp_path_gambar);
                            }
                            if (file_exists(Params::pathTumbsKategoriBeritaGambar() . $temp_path_gambar)) {
                                unlink(Params::pathTumbsKategoriBeritaGambar() . $temp_path_gambar);
                            }
                        }
                        $model->kategoripost_gambar = strtolower(str_replace(" ", "_", $random . $model->kategoripost_gambar));
                        $rand_gambar = $model->kategoripost_gambar;
                        $fullImgName = $rand_gambar;
                        $fullImgSource = Params::pathKategoriBeritaGambar() . $fullImgName;
                        $fullThumbSource = Params::pathTumbsKategoriBeritaGambar() . $fullImgName;
                        $model->kategoripost_gambar = $fullImgName;
                    }



                    $model->update_time = date("Y-m-d");
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $ok = $ok && $model->save();
                    $ok = $ok && $gambar->saveAs($fullImgSource);
                    $cropimg = $thumb->create($fullImgSource)->adaptiveResize(420, 154);
                    $ok = $ok && $cropimg->save($fullThumbSource);
                }
                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('admin'));
                } else {
                    
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $e) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                //Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // identifikasi gambar
            $dir_gambar = KategoripostM::model()->findByPk($id);
            if (!empty($dir_gambar->kategoripost_gambar)) {
                // hapus gambar dari direktori
                if (file_exists(Params::pathKategoriBeritaGambar() . $dir_gambar->kategoripost_gambar)) {
                    unlink(Params::pathKategoriBeritaGambar() . $dir_gambar->kategoripost_gambar);
                }
                if (file_exists(Params::pathTumbsKategoriBeritaGambar() . $dir_gambar->kategoripost_gambar)) {
                    unlink(Params::pathTumbsKategoriBeritaGambar() . $dir_gambar->kategoripost_gambar);
                }
            }
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('KategoripostM');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        //$this->layout = '//layouts/iframe';
        $model = new KategoripostM;
        $model->unsetAttributes();  // clear any default values
        if (!empty($_GET['KategoripostM'])) {
            $model->attributes = $_GET['KategoripostM'];
            $model->kategoripost_nama = $_GET['KategoripostM']['kategoripost_nama'];
            $model->kategoripost_namalain = $_GET['KategoripostM']['kategoripost_namalain'];
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = KategoripostM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'penilaianiki-aspekuraian-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    /**
     * digunakan untuk non aktif data sementara 
     */
    public function actionRemoveTemporary() {

        $id = $_GET['id'];

        if (isset($_GET['id'])) {

            //if (isset($_GET['add'])):
            // $update = REDiagnosaM::model()->updateByPk($id,array('diagnosa_aktif'=>true));
            // else:    
            $update = KategoripostM::model()->updateByPk($id, array('kategoripost_aktif' => false));
            //endif;
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
     * digunakan untuk cetak laporan
     */
    public function actionPrint() {
//             if(!Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                         
        $model = new KategoripostM;
        $model->attributes = $_REQUEST['KategoripostM'];
        $judulLaporan = 'Kategori Berita';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {

            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);

            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

}
