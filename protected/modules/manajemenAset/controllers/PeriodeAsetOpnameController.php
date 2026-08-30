
<?php

class PeriodeAsetOpnameController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */    
    public $defaultAction = 'admin';
    public $path_view = 'manajemenAset.views.periodeAsetOpname.';
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
        $model = new MAPeriodeasetopnameK();


        if (isset($_POST['MAPeriodeasetopnameK'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['MAPeriodeasetopnameK'];
                $model->tanggal_awal = !empty($model->tanggal_awal)? MyFormatter::formatDateTimeForDb($model->tanggal_awal):null;
                $model->tanggal_akhir = !empty($model->tanggal_akhir)? MyFormatter::formatDateTimeForDb($model->tanggal_akhir):null;
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $ok &= $model->save();
                if ($ok) {
                    
                    $update = MAPeriodeasetopnameK::model()->updateAll([
                        'periodeasetopname_aktif' => false
                    ]," periodeasetopname_id != ".$model->periodeasetopname_id." ");
                    
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');                    
                    $trans->commit();
                    $this->redirect(array('admin', 'periodeasetopname_id' => $model->periodeasetopname_id, 'sukses' => 1));
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
        $model->tanggal_awal = !empty($model->tanggal_awal)? MyFormatter::formatDateTimeForUser($model->tanggal_awal):null;
        $model->tanggal_akhir = !empty($model->tanggal_akhir)? MyFormatter::formatDateTimeForUser($model->tanggal_akhir):null;

        if (isset($_POST['MAPeriodeasetopnameK'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['MAPeriodeasetopnameK'];
                $model->tanggal_awal = !empty($model->tanggal_awal)? MyFormatter::formatDateTimeForDb($model->tanggal_awal):null;
                $model->tanggal_akhir = !empty($model->tanggal_akhir)? MyFormatter::formatDateTimeForDb($model->tanggal_akhir):null;
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                
                $ok &= $model->save();
                if ($ok) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $trans->commit();
                    $this->redirect(array('admin', 'periodeasetopname_id' => $model->periodeasetopname_id, 'sukses' => 1));
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

        $model = new MAPeriodeasetopnameK('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MAPeriodeasetopnameK'])) {
            $model->attributes = $_GET['MAPeriodeasetopnameK'];     
            $model->tanggal_awal = !empty($model->tanggal_awal)? MyFormatter::formatDateTimeForDb($model->tanggal_awal):null;
            $model->tanggal_akhir = !empty($model->tanggal_akhir)? MyFormatter::formatDateTimeForDb($model->tanggal_akhir):null;
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
        $model = MAPeriodeasetopnameK::model()->findByPk($id);
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
            $update = MAPeriodeasetopnameK::model()->updateByPk($id, array('periodeasetopname_aktif' => false));
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
            $update = MAPeriodeasetopnameK::model()->updateByPk($id, array('periodeasetopname_aktif' => true));
            
            $update = MAPeriodeasetopnameK::model()->updateAll([
                'periodeasetopname_aktif' => false
            ]," periodeasetopname_id != ".$id." ");
                        
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
        $model = new MAPeriodeasetopnameK();
         if (isset($_GET['MAPeriodeasetopnameK'])) {
            $model->attributes = $_GET['MAPeriodeasetopnameK'];  
            $model->tanggal_awal = !empty($model->tanggal_awal)? MyFormatter::formatDateTimeForDb($model->tanggal_awal):null;
            $model->tanggal_akhir = !empty($model->tanggal_akhir)? MyFormatter::formatDateTimeForDb($model->tanggal_akhir):null;
        }
        
        $judulLaporan = 'Periode Aset Opname';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 20, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date("Y/m/d") . '.pdf', 'I');
        }
    }

}
