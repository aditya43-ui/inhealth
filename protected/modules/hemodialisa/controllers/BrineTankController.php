
<?php

class BrineTankController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */    
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $path_view = 'hemodialisa.views.brineTank.';
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
        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
        $model = new HDHdBrinetankT();
        $model->tgl_minitoring = date('Y-m-d H:i:s');

        if (isset($_POST['HDHdBrinetankT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['HDHdBrinetankT'];
                $model->tgl_minitoring = !empty($model->tgl_minitoring)?MyFormatter::formatDateTimeForDb($model->tgl_minitoring):null;
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                $ok &= $model->save();
                if ($ok) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');                    
                    $trans->commit();
                    $this->redirect(array('admin', 'hd_brinetank_id' => $model->hd_brinetank_id, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan");
                }
            } catch (Exception $ex) {                
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan" . MyExceptionMessage::getMessage($ex, true));
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
        $model->nama_pegawai = !empty($model->pegawai->namaLengkap)?$model->pegawai->namaLengkap:null;

        if (isset($_POST['HDHdBrinetankT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['HDHdBrinetankT'];
                $model->tgl_minitoring = !empty($model->tgl_minitoring)?MyFormatter::formatDateTimeForDb($model->tgl_minitoring):null;
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->update_ruangan_id = Yii::app()->user->getState('ruangan_id');
                $ok &= $model->save();
                if ($ok) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $trans->commit();
                    $this->redirect(array('admin', 'hd_brinetank_id' => $model->hd_brinetank_id, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan");
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan" . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_view . 'update', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {

        $model = new HDHdBrinetankT('search');
        $model->unsetAttributes();  // clear any default values
        $model->tgl_awal = date('Y-m-01');
        $model->tgl_akhir = date('Y-m-d');
        if (isset($_GET['HDHdBrinetankT'])) {
            $model->attributes = $_GET['HDHdBrinetankT'];
            $model->tgl_awal = isset($_GET['HDHdBrinetankT']['tgl_awal'])?MyFormatter::formatDateTimeForDb($_GET['HDHdBrinetankT']['tgl_awal']):null;
            $model->tgl_akhir = isset($_GET['HDHdBrinetankT']['tgl_akhir'])?MyFormatter::formatDateTimeForDb($_GET['HDHdBrinetankT']['tgl_akhir']):null;
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
        $model = HDHdBrinetankT::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sagolongan-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionDelete() {
        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
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
     * Mengubah status aktif
     * @param type $id 
     */
    public function actionRemoveTemporary() {       
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = HDHdBrinetankT::model()->updateByPk($id, array('jaringansumberbiomaterial_aktif' => false));
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
    
    public function actionAktif() {       
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = HDHdBrinetankT::model()->updateByPk($id, array('jaringansumberbiomaterial_aktif' => true));
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

    public function actionPrint() {
        $this->layout = '//layouts/_auto';
        
        $model = new HDHdBrinetankT();
         if (isset($_GET['HDHdBrinetankT'])) {
            $model->attributes = $_GET['HDHdBrinetankT'];  
            $model->tgl_awal = isset($_GET['HDHdBrinetankT']['tgl_awal'])?MyFormatter::formatDateTimeForDb($_GET['HDHdBrinetankT']['tgl_awal']):null;
            $model->tgl_akhir = isset($_GET['HDHdBrinetankT']['tgl_akhir'])?MyFormatter::formatDateTimeForDb($_GET['HDHdBrinetankT']['tgl_akhir']):null;
        }
        
        $judulLaporan = 'Water Treatment Quality Plant Control';
        $caraPrint = $_REQUEST['caraPrint'];
        
        $data = [
            'judul_laporan' => $judulLaporan,
            'no_dok' => 'Form. WTP-IHD 05',
            'alias' => 'BRINE TANK MAINTANCE',
            'nama_lengkap' => '',
            'no_rm' => '',
            'tanggal_lahir' => '',
        ];
        
       
        if ($caraPrint == 'PRINT') {
            $this->render($this->path_view . 'Print', array(
                'data'=>$data,
                'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->render($this->path_view . 'Print', array(
                'data'=>$data,
                'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Params::getUkuranKertas();
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF['F4']);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/global-prinout-pdf.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 10, 10, 10);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array(
                'data'=>$data,
                'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date("Y/m/d") . '.pdf', 'I');
        }
    }

}
