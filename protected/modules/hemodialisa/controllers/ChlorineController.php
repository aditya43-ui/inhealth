
<?php

class ChlorineController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */    
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $path_view = 'hemodialisa.views.chlorine.';
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
        $model = new HDHdChlorineT();
        $model->tgl_monitoring = date('Y-m-d');

        if (isset($_POST['HDHdChlorineT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['HDHdChlorineT'];
                $model->tgl_monitoring = !empty($model->tgl_monitoring)?MyFormatter::formatDateTimeForDb($model->tgl_monitoring):null;
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                $ok &= $model->save();
                if ($ok) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');                    
                    $trans->commit();
                    $this->redirect(array('admin', 'hd_chlorine_id' => $model->hd_chlorine_id, 'sukses' => 1));
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
        $model->pegawai_shift1_nama = !empty($model->pegawaiShift1->namaLengkap)?$model->pegawaiShift1->namaLengkap:null;
        $model->pegawai_shift2_nama = !empty($model->pegawaiShift2->namaLengkap)?$model->pegawaiShift2->namaLengkap:null;
        $model->pegawai_lateshift_nama = !empty($model->pegawaiLateshift->namaLengkap)?$model->pegawaiLateshift->namaLengkap:null;

        if (isset($_POST['HDHdChlorineT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['HDHdChlorineT'];
                $model->tgl_monitoring = !empty($model->tgl_monitoring)?MyFormatter::formatDateTimeForDb($model->tgl_monitoring):null;
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->update_ruangan_id = Yii::app()->user->getState('ruangan_id');
                
                if (!$model->is_shift1)
                    $model->pegawai_shift1_id = null;
                
                if (!$model->is_shift2)
                    $model->pegawai_shift2_id = null;
                
                if (!$model->is_lateshift)
                    $model->pegawai_lateshift_id = null;
                
                $ok &= $model->save();
                if ($ok) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $trans->commit();
                    $this->redirect(array('admin', 'hd_chlorine_id' => $model->hd_chlorine_id, 'sukses' => 1));
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

        $model = new HDHdChlorineT('search');
        $model->unsetAttributes();  // clear any default values
        $model->tgl_awal = date('Y-m-01');
        $model->tgl_akhir = date('Y-m-d');
        if (isset($_GET['HDHdChlorineT'])) {
            $model->attributes = $_GET['HDHdChlorineT'];
            $model->tgl_awal = isset($_GET['HDHdChlorineT']['tgl_awal'])?MyFormatter::formatDateTimeForDb($_GET['HDHdChlorineT']['tgl_awal']):null;
            $model->tgl_akhir = isset($_GET['HDHdChlorineT']['tgl_akhir'])?MyFormatter::formatDateTimeForDb($_GET['HDHdChlorineT']['tgl_akhir']):null;
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
        $model = HDHdChlorineT::model()->findByPk($id);
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
            $update = HDHdChlorineT::model()->updateByPk($id, array('jaringansumberbiomaterial_aktif' => false));
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
            $update = HDHdChlorineT::model()->updateByPk($id, array('jaringansumberbiomaterial_aktif' => true));
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
     * prinout
     */
    public function actionPrint() {
        $this->layout = '//layouts/_auto';
        
        $model = new HDHdChlorineT();
         if (isset($_GET['HDHdChlorineT'])) {
            $model->attributes = $_GET['HDHdChlorineT'];  
            $model->tgl_awal = isset($_GET['HDHdChlorineT']['tgl_awal'])?MyFormatter::formatDateTimeForDb($_GET['HDHdChlorineT']['tgl_awal']):null;
            $model->tgl_akhir = isset($_GET['HDHdChlorineT']['tgl_akhir'])?MyFormatter::formatDateTimeForDb($_GET['HDHdChlorineT']['tgl_akhir']):null;
        }
        
        $judulLaporan = 'Water Treatment Quality Plant Control<br/>Total Chlorine Routine Sampling<br/>For Preetreatment Series-1 & 2';
        $caraPrint = $_REQUEST['caraPrint'];
        
        $data = [
            'judul_laporan' => $judulLaporan,
            'no_dok' => 'Form. WTP-IHD 01',
            'alias' => '',
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
