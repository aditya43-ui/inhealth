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
class PostMController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout = '//layouts/iframe';
    public $path_view = 'sistemAdministrator.views.postM.';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $data = $this->loadModel($id);
        $modul = LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id);
        if (!empty($modul->nama_pemakai)) {
            $data->loginpemakai = $modul->nama_pemakai;
        }

        $this->render('view', array(
            'model' => $data,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new PostM;
        $modDetail = new PostgambarM;
        // Uncomment the following line if AJAX validation is needed


        if (isset($_POST['PostM'])) {

            try {
                $ok = true;
                $trans = Yii::app()->db->beginTransaction();
                $model->attributes = $_POST['PostM'];
                $random = rand(0000000, 9999999);
                $model->post_gambar = CUploadedFile::getInstance($model, 'post_gambar');
                $gambar = $model->post_gambar;

                // Yii::import("ext.EPhpThumb.EPhpThumb");
                Yii::import("application.extensions.EPhpThumb.EPhpThumb");
                $thumb = new EPhpThumb();
                $thumb->init();
                if (!empty($model->post_gambar)) {

                    $model->post_gambar = strtolower(str_replace(" ", "_", $random . $model->post_gambar));
                    $rand_gambar = $model->post_gambar;
                    $fullImgName = $rand_gambar;
                    $fullImgSource = Params::pathBeritaGambar() . $fullImgName;
                    $fullThumbSource = Params::pathTumbsBeritaGambar() . $fullImgName;
                    $model->post_gambar = $fullImgName;
                    $ok = $ok && $gambar->saveAs($fullImgSource);
                    $cropimg = $thumb->create($fullImgSource)->adaptiveResize(400, 200);
                    $ok = $ok && $cropimg->save($fullThumbSource);
                    
                }
                $model->post_tgl = date("Y-m-d");
                $model->create_time = date("Y-m-d");
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $ok = $ok && $model->save();
                // print_r($ok);die;
                if ($ok) {
                    if (!empty($_POST['PostgambarM'])) {
                        foreach ($_POST['PostgambarM'] as $i => $postDetail) {
                            $modelDetail = new PostgambarM;

                            if (!empty(CUploadedFile::getInstance($modelDetail, '[' . $i . ']pathgambar'))) {
                                $modelDetail->pathgambar = CUploadedFile::getInstance($modelDetail, '[' . $i . ']pathgambar');
                                $imageInfo = getimagesize(CUploadedFile::getInstance($modelDetail, '[' . $i . ']pathgambar')->getTempName());
                                //validasi dimensi 
                                if ($imageInfo[0] <= 400 || $imageInfo[1] <= 200) {
                                    $ok = false;
                                    Yii::app()->user->setFlash('error', "File Tidak Sesuai Ketentuan/Bukan Format Gambar" . CHtml::errorSummary($model));
                                    $this->redirect(array('admin'));
                                }
                                $gambar = $modelDetail->pathgambar;
                                $random = rand(0000000, 9999999);

                                Yii::import("ext.EPhpThumb.EPhpThumb");
                                $thumb = new EPhpThumb();
                                $thumb->init();

                                $modelDetail->pathgambar = strtolower(str_replace(" ", "_", $random . $modelDetail->pathgambar));
                                $rand_gambar = $modelDetail->pathgambar;
                                $fullImgName = $rand_gambar;
                                $fullImgSource = Params::pathBeritaGambar() . $fullImgName;
                                $fullThumbSource = Params::pathTumbsBeritaGambar() . $fullImgName;
                                $modelDetail->pathgambar = $fullImgName;
                                $modelDetail->post_id = $model->post_id;
                                $modelDetail->update_loginpemakai_id = Yii::app()->user->id;
                                $ok = $ok && $gambar->saveAs($fullImgSource);
                                $cropimg = $thumb->create($fullImgSource)->adaptiveResize(400, 200);
                                $ok = $ok && $cropimg->save($fullThumbSource);
                                $ok = $ok && $modelDetail->save();
                            }
                        }
                    }
                }

                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('admin'));
                } else {

                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpannnnnn " . CHtml::errorSummary($model));
                }
            } catch (Exception $e) {
                $trans->rollback();
                // print_r($e);die;
                Yii::app()->user->setFlash('error', "Data gagal disimpan---- " . CHtml::errorSummary($model));
                //Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render('create', array(
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
        $modDetail = $this->loadModelGambar($id);
        
        $temp_path_gambar = $model->post_gambar;

        if (empty($_POST['PostM'])) {
            $model->post_gambar = $temp_path_gambar;
        }

        if (isset($_POST['PostM'])) {
            try {
                $ok = true;
                $trans = Yii::app()->db->beginTransaction();
                $model->attributes = $_POST['PostM'];

                if (empty(CUploadedFile::getInstance($model, 'post_gambar'))) {//jika tidak upload data baru
                    $model->post_gambar = $temp_path_gambar;
                    $ok = $model->save();
                } else {//jika upload data baru
                    $model->post_gambar = CUploadedFile::getInstance($model, 'post_gambar');
                    $imageInfo = getimagesize(CUploadedFile::getInstance($model, 'post_gambar')->getTempName());
                    //validasi dimensi 
                    if ($imageInfo[0] <= 400 || $imageInfo[1] <= 200) {
                        $ok = false;
                        Yii::app()->user->setFlash('error', "File Tidak Sesuai Ketentuan/Bukan Format Gambar" . CHtml::errorSummary($model));
                        $this->redirect(array('admin'));
                    }

                    $gambar = $model->post_gambar;
                    $random = rand(0000000, 9999999);

                    Yii::import("ext.EPhpThumb.EPhpThumb");
                    $thumb = new EPhpThumb();
                    $thumb->init();
                    if (isset($model->post_gambar) && ($model->post_gambar != $temp_path_gambar)) {//jika data lama dan baru tidaksama;
                        if (!empty($temp_path_gambar)) {
                            if (file_exists(Params::pathBeritaGambar() . $temp_path_gambar)) {
                                unlink(Params::pathBeritaGambar() . $temp_path_gambar);
                            }
                            if (file_exists(Params::pathTumbsBeritaGambar() . $temp_path_gambar)) {
                                unlink(Params::pathTumbsBeritaGambar() . $temp_path_gambar);
                            }
                        }
                        $model->post_gambar = strtolower(str_replace(" ", "_", $random . $model->post_gambar));
                        $rand_gambar = $model->post_gambar;
                        $fullImgName = $rand_gambar;
                        $fullImgSource = Params::pathBeritaGambar() . $fullImgName;
                        $fullThumbSource = Params::pathTumbsBeritaGambar() . $fullImgName;
                        $model->post_gambar = $fullImgName;
                    }



                    $ok = $ok && $gambar->saveAs($fullImgSource);
                    $cropimg = $thumb->create($fullImgSource)->adaptiveResize(400, 200);
                    $ok = $ok && $cropimg->save($fullThumbSource);
                }

                $model->post_tgl = date("Y-m-d");
                $model->update_time = date("Y-m-d");
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $ok = $ok && $model->save();

                if (!empty($_POST['PostgambarM'])) {//jika tidak upload data baru
                    //jika upload data baru
                    if ($ok) {
                        if (!empty($_POST['PostgambarM'])) {
                            foreach ($_POST['PostgambarM'] as $i => $postDetail) {
                                $modelDetail = new PostgambarM;
                                if (!empty(CUploadedFile::getInstance($modelDetail, '[' . $i . ']pathgambar'))) {

                                    $modelDetail->pathgambar = CUploadedFile::getInstance($modelDetail, '[' . $i . ']pathgambar');
                                    $imageInfo = getimagesize(CUploadedFile::getInstance($modelDetail, '[' . $i . ']pathgambar')->getTempName());
                                    //validasi dimensi 
                                    if ($imageInfo[0] <= 400 || $imageInfo[1] <= 200) {
                                        $ok = false;
                                        Yii::app()->user->setFlash('error', "File Tidak Sesuai Ketentuan/Bukan Format Gambar" . CHtml::errorSummary($model));
                                        $this->redirect(array('admin'));
                                    }

                                    $gambar = $modelDetail->pathgambar;
                                    $random = rand(0000000, 9999999);

                                    Yii::import("ext.EPhpThumb.EPhpThumb");
                                    $thumb = new EPhpThumb();
                                    $thumb->init();

                                    $modelDetail->pathgambar = strtolower(str_replace(" ", "_", $random . $modelDetail->pathgambar));
                                    $rand_gambar = $modelDetail->pathgambar;
                                    $fullImgName = $rand_gambar;
                                    $fullImgSource = Params::pathBeritaGambar() . $fullImgName;
                                    $fullThumbSource = Params::pathTumbsBeritaGambar() . $fullImgName;
                                    $modelDetail->pathgambar = $fullImgName;
                                    $modelDetail->post_id = $model->post_id;
                                    $modelDetail->update_loginpemakai_id = Yii::app()->user->id;
                                    $ok = $ok && $gambar->saveAs($fullImgSource);
                                    $cropimg = $thumb->create($fullImgSource)->adaptiveResize(400, 200);
                                    $ok = $ok && $cropimg->save($fullThumbSource);
                                    $ok = $ok && $modelDetail->save();
                                }
                            }
                        }
                    }
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
            'modDetail' => $modDetail
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            try {
                $ok = true;
                $trans = Yii::app()->db->beginTransaction();
                $dir_gambar = PostM::model()->findByPk($id);
                if (!empty($dir_gambar->post_gambar)) {
                    // hapus gambar dari direktori
                    if (file_exists(Params::pathBeritaGambar() . $dir_gambar->post_gambar)) {
                        unlink(Params::pathBeritaGambar() . $dir_gambar->post_gambar);
                    }
                    if (file_exists(Params::pathTumbsBeritaGambar() . $dir_gambar->post_gambar)) {
                        unlink(Params::pathTumbsBeritaGambar() . $dir_gambar->post_gambar);
                    }
                }
                $ok = $this->loadModel($id)->delete();

                if ($ok) {
                    $modDetail = $this->loadModelGambar($id);
                    foreach ($modDetail as $dir_gambar) {

                        if (!empty($dir_gambar->pathgambar)) {
                            // hapus gambar dari direktori
                            if (file_exists(Params::pathBeritaGambar() . $dir_gambar->pathgambar)) {
                                $ok = $ok && unlink(Params::pathBeritaGambar() . $dir_gambar->pathgambar);
                            }
                            if (file_exists(Params::pathTumbsBeritaGambar() . $dir_gambar->pathgambar)) {
                                $ok = $ok && unlink(Params::pathTumbsBeritaGambar() . $dir_gambar->pathgambar);
                            }
                        }
                    }
                    if ($ok) {
                        $hapuspostgambar = PostgambarM::model()->deleteAll('post_id=' . $id . '');
                    }
                }

                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil dihapus");
                    $this->redirect(array('admin'));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal dihapus ");
                }
            } catch (Exception $e) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal dihapus ");
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteGambar() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            $dir_gambar = PostgambarM::model()->findByPk($id);
            if (!empty($dir_gambar->pathgambar)) {
                // hapus gambar dari direktori
                if (file_exists(Params::pathBeritaGambar() . $dir_gambar->pathgambar)) {
                    unlink(Params::pathBeritaGambar() . $dir_gambar->pathgambar);
                }
                if (file_exists(Params::pathTumbsBeritaGambar() . $dir_gambar->pathgambar)) {
                    unlink(Params::pathTumbsBeritaGambar() . $dir_gambar->pathgambar);
                }
            }
            PostgambarM::model()->deleteByPk($id);
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'sukses' => 1,
                    'pesan' => "<div class='flash-success'>Data berhasil dihapus.</div>",
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
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('PostM');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        //$this->layout = '//layouts/iframe';
        $model = new PostM;
        $model->unsetAttributes();  // clear any default values
        if (!empty($_GET['PostM'])) {
            $model->attributes = $_GET['PostM'];
            $model->post_judul = $_GET['PostM']['post_judul'];
            $model->post_desc = $_GET['PostM']['post_desc'];
            $model->kategoripost_nama = $_GET['PostM']['kategoripost_nama'];
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
        $model = PostM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadModelGambar($id) {
        $model = PostgambarM::model()->findAllByAttributes(array('post_id' => $id));
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


            $update = PostM::model()->updateByPk($id, array('post_aktif' => false));

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
        $model = new PostM;
        $model->attributes = $_REQUEST['PostM'];
        $judulLaporan = 'Post Berita';
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
