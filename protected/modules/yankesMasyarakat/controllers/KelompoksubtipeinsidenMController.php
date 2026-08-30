<?php
/**
* digunakan untuk Master Kelompok Sub Tipe Insiden
* @author Elham Budianto <elhambudianto1@gmail.com>
* @package application.modules.yankesMasyarakat
* @subpackage controllers
**/
class KelompoksubtipeinsidenMController extends MyAuthController {
    
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $simpan = false;
    public $path_view = 'yankesMasyarakat.views.kelompoksubtipeinsidenM.';
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
        $model = new KelompoksubtipeinsidenM;
        if (isset($_POST['KelompoksubtipeinsidenM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($_POST['KelompoksubtipeinsidenM'] as $i => $post) {
                    $model = new KelompoksubtipeinsidenM();
                    $model->attributes = $post;
                    if ($post['kelompoksubtipeinsiden_aktif'] == 'Aktif') {
                        $model->kelompoksubtipeinsiden_aktif = true;
                    } else {
                        $model->kelompoksubtipeinsiden_aktif = false;
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
        if ($model->kelompoksubtipeinsiden_aktif == false) {
            $model->kelompoksubtipeinsiden_aktif = 0;
        } else {
            $model->kelompoksubtipeinsiden_aktif = 1;
        }
        
        if (isset($_POST['KelompoksubtipeinsidenM'])) {
            $model->attributes = $_POST['KelompoksubtipeinsidenM'];
            $status_aktif = $_POST['KelompoksubtipeinsidenM']['kelompoksubtipeinsiden_aktif'];
            if ($status_aktif == 0) {
                $model->kelompoksubtipeinsiden_aktif = false;
            } else {
                $model->kelompoksubtipeinsiden_aktif = true;
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin', 'id' => $model->kelompoksubtipeinsiden_id));
            }
        }

        $this->render($this->path_view . 'update', array(
            'model' => $model,
        ));
    }
    
    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('KelompoksubtipeinsidenM');
        $this->render($this->path_view . 'index', array(
            'dataProvider' => $dataProvider,
        ));
    }
    
    /**
     * Manages all models.
     */
    public function actionAdmin() {

        $model = new KelompoksubtipeinsidenM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['KelompoksubtipeinsidenM']))
            $model->attributes = $_GET['KelompoksubtipeinsidenM'];

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
        $model = KelompoksubtipeinsidenM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'kelompoksubtipeinsiden-m-form') {
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
            $update = KelompoksubtipeinsidenM::model()->updateByPk($id, array('kelompoksubtipeinsiden_aktif' => false));
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
           $update = KelompoksubtipeinsidenM::model()->updateByPk($id,array('kelompoksubtipeinsiden_aktif'=>true));
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
        $model = new KelompoksubtipeinsidenM;
        if (isset($_REQUEST['KelompoksubtipeinsidenM'])) {
            $model->attributes = $_REQUEST['KelompoksubtipeinsidenM'];
        }
        $judulLaporan = 'Data Kelompok Subtipe Insiden';
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
    
    /**
     * Mendapatkan data kelompok subtipe insiden dari inputan user
     */
    public function actionGetTabel() {
        if (Yii::app()->request->isAjaxRequest) {
            //get data post
            $tipeinsiden_id = $_POST['tipeinsiden_id'];
            $nama = $_POST['nama'];
            $namalain = $_POST['namalain'];
            $aktif = $_POST['aktif'];
            if ($aktif == 1) {
                $aktif = 'Aktif';
            } else {
                $aktif = 'Tidak Aktif';
            }
            
            $criteria = new CDbCriteria();
            $criteria->addCondition("tipeinsiden_id =".$tipeinsiden_id);
            $criteria->compare("LOWER(kelompoksubtipeinsiden_nama)", strtolower($nama),true);
            $cekKelompok = KelompoksubtipeinsidenM::model()->find($criteria);
            
            if(empty($cekKelompok)){
            //set new model
            $model = new KelompoksubtipeinsidenM();
            $tipeinsiden = TipeinsidenM::model()->findByPk($tipeinsiden_id);
            $model->tipeinsiden_id = $tipeinsiden_id;
            $model->tipeinsiden_nama = $tipeinsiden->tipeinsiden_nama;
            $model->kelompoksubtipeinsiden_nama = $nama;
            $model->kelompoksubtipeinsiden_namalainnya = $namalain;
            $model->kelompoksubtipeinsiden_aktif = $aktif;

                $return = $this->renderPartial("_rowTabel", array('model' => $model, 'i' => 1), true);
                $message = 'sukses';
            }else{
                $return = '';
                $message = 'gagal';
            }
            $data['return'] = $return;
            $data['message'] = $message;
            $data['tipeinsiden_id'] = $tipeinsiden_id;
            $data['nama'] = $nama;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
}
