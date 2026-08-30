<?php
/**
* digunakan untuk Master pasal perjanjian
* @author Elham Budianto <elhambudianto1@gmail.com>
* @package application.modules.pengadaan
* @subpackage controllers
**/
class PasalperjanjianMController extends MyAuthController {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $defaultAction = 'admin';
    public $path_view = 'pengadaan.views.pasalperjanjianM.';
    public $path_tips = 'pengadaan.views.tips.';
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
        $model = new PasalperjanjianM;


        if (isset($_POST['PasalperjanjianM'])) {
            $model->attributes = $_POST['PasalperjanjianM'];
            $model->create_time = date('Y-m-d');
            $model->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
            $model->update_time = date('Y-m-d');
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin', 'id' => $model->pasalperjanjian_id));
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
        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
        $model = $this->loadModel($id);
        if ($model->pasalperjanjian_aktif == false) {
            $model->pasalperjanjian_aktif = 0;
        } else {
            $model->pasalperjanjian_aktif = 1;
        }
        if (isset($_POST['PasalperjanjianM'])) {
            $model->attributes = $_POST['PasalperjanjianM'];
            $status_aktif = $_POST['PasalperjanjianM']['pasalperjanjian_aktif'];
            if ($status_aktif == 0) {
                $model->pasalperjanjian_aktif = false;
            } else {
                $model->pasalperjanjian_aktif = true;
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin', 'id' => $model->pasalperjanjian_id));
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

        $model = new PasalperjanjianM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PasalperjanjianM']))
            $model->attributes = $_GET['PasalperjanjianM'];

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
        $model = PasalperjanjianM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pasalperjanjian-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
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
     * @param type $id 
     */
    public function actionRemoveTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = PasalperjanjianM::model()->updateByPk($id, array('pasalperjanjian_aktif' => false));
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
     * @param type $id 
     */
    public function actionAktifkan()
    {
        $id = $_POST['id'];   
        if(isset($_POST['id']))
        {
           $update = PasalperjanjianM::model()->updateByPk($id,array('pasalperjanjian_aktif'=>true));
           if($update)
            {
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        ));
                    exit;               
                }
             }
        } else {
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        ));
                    exit;               
                }
        }

    }
    /**
     * Mencetak Dokumen
     */
    public function actionPrint() {
        $model = new PasalperjanjianM;
        if (isset($_REQUEST['PasalperjanjianM'])) {
            $model->attributes = $_REQUEST['PasalperjanjianM'];
        }
        $judulLaporan = 'Data Pasal Perjanjian';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');      //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');         //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
        }
    }

}
