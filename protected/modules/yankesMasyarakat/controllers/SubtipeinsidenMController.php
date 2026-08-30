<?php
/**
* digunakan untuk Master Sub Tipe Insiden
* @author Elham Budianto <elhambudianto1@gmail.com>
* @package application.modules.yankesMasyarakat
* @subpackage controllers
**/
class SubtipeinsidenMController extends MyAuthController {
    
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $simpan = true;
    public $path_view = 'yankesMasyarakat.views.subtipeinsidenM.';
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
        $model = new SubtipeinsidenM;
        if (isset($_POST['SubtipeinsidenM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($_POST['SubtipeinsidenM'] as $i => $post) {
                    if(empty($post['subtipeinsiden_id'])){
                        $model = new SubtipeinsidenM();
                        $model->attributes = $post;
                        if ($post['subtipeinsiden_aktif'] == 'Aktif') {
                            $model->subtipeinsiden_aktif = true;
                        } else {
                            $model->subtipeinsiden_aktif = false;
                        }
                        $model->create_time = date('Y-m-d H:i:s');
                        $model->create_loginpemakai_id = Yii::app()->user->id;
                        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $this->simpan = $model->save() && true;
                    }
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
        if ($model->subtipeinsiden_aktif == false) {
            $model->subtipeinsiden_aktif = 0;
        } else {
            $model->subtipeinsiden_aktif = 1;
        }
        
        if (isset($_POST['SubtipeinsidenM'])) {
            $model->attributes = $_POST['SubtipeinsidenM'];
            $status_aktif = $_POST['SubtipeinsidenM']['subtipeinsiden_aktif'];
            if ($status_aktif == 0) {
                $model->subtipeinsiden_aktif = false;
            } else {
                $model->subtipeinsiden_aktif = true;
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin', 'id' => $model->subtipeinsiden_id));
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
        $dataProvider = new CActiveDataProvider('SubtipeinsidenM');
        $this->render($this->path_view . 'index', array(
            'dataProvider' => $dataProvider,
        ));
    }
    
    /**
     * Manages all models.
     */
    public function actionAdmin() {

        $model = new SubtipeinsidenM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SubtipeinsidenM']))
            $model->attributes = $_GET['SubtipeinsidenM'];

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
        $model = SubtipeinsidenM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'subtipeinsiden-m-form') {
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
     * Menghapus Data
     */
    public function actionDeleteSubtipe($id) {
        if (Yii::app()->request->isPostRequest) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if($this->loadModel($id)->delete()){
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data gagal dihapus";
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data gagal dihapus";
            }
            echo CJSON::encode($data);
            Yii::app()->end();
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
            $update = SubtipeinsidenM::model()->updateByPk($id, array('subtipeinsiden_aktif' => false));
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
           $update = SubtipeinsidenM::model()->updateByPk($id,array('subtipeinsiden_aktif'=>true));
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
        $model = new SubtipeinsidenM;
        if (isset($_REQUEST['SubtipeinsidenM'])) {
            $model->attributes = $_REQUEST['SubtipeinsidenM'];
        }
        $judulLaporan = 'Data Subtipe Insiden';
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
     * Mendapatkan data subtipe insiden dari inputan user
     */
    public function actionGetTabel() {
        if (Yii::app()->request->isAjaxRequest) {
            //get data post
            $tipeinsiden_id = $_POST['tipeinsiden_id'];
            $kelompoksubtipeinsiden_id = $_POST['kelompoksubtipeinsiden_id'];
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
            $criteria->addCondition("kelompoksubtipeinsiden_id =".$kelompoksubtipeinsiden_id);
            $criteria->compare("LOWER(subtipeinsiden_nama)", strtolower($nama),true);
            $cekKelompok = SubtipeinsidenM::model()->find($criteria);
            
            if(empty($cekKelompok)){
            //set new model
            $model = new SubtipeinsidenM();
            $model->tipeinsiden_id = $tipeinsiden_id;
            $model->kelompoksubtipeinsiden_id = $kelompoksubtipeinsiden_id;
            $model->subtipeinsiden_nama = $nama;
            $model->subtipeinsiden_namalainnya = $namalain;
            $model->subtipeinsiden_aktif = $aktif;

                $return = $this->renderPartial("_rowTabel", array('model' => $model, 'i' => 1), true);
                $message = 'sukses';
            }else{
                $return = '';
                $message = 'gagal';
            }
            $data['return'] = $return;
            $data['message'] = $message;
            $data['kelompoksubtipeinsiden_id'] = $kelompoksubtipeinsiden_id;
            $data['tipeinsiden_id'] = $tipeinsiden_id;
            $data['nama'] = $nama;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Mendapatkan data subtipe insiden dari inputan user
     */
    public function actionSetTabel() {
        if (Yii::app()->request->isAjaxRequest) {
            //get data post
            $data['form'] = "";
            $tipeinsiden_id = $_POST['tipeinsiden_id'];
            $kelompoksubtipeinsiden_id = $_POST['kelompoksubtipeinsiden_id'];
            
            $criteria = new CDbCriteria();
            $criteria->addCondition("tipeinsiden_id =".$tipeinsiden_id);
            $criteria->addCondition("kelompoksubtipeinsiden_id =".$kelompoksubtipeinsiden_id);
            $models = SubtipeinsidenM::model()->findAll($criteria);
            
            if(count($models) > 0){
                $a = 1;
                foreach ($models AS $i=>$model){
                    if ($model->subtipeinsiden_aktif == 1) {
                        $aktif = 'Aktif';
                    } else {
                        $aktif = 'Tidak Aktif';
                    }
                    $model->subtipeinsiden_id= $model->subtipeinsiden_id;
                    $model->tipeinsiden_id= $model->tipeinsiden_id;
                    $model->kelompoksubtipeinsiden_id= $model->kelompoksubtipeinsiden_id;
                    $model->subtipeinsiden_nama= $model->subtipeinsiden_nama;
                    $model->subtipeinsiden_namalainnya= $model->subtipeinsiden_namalainnya;
                    $model->subtipeinsiden_aktif= $aktif;
                    
                    $data['form'] .= $this->renderPartial('_rowTabelInsiden',array('model'=>$model, 'i'=>$a),true);
                    $a++;
                }
				
            }else{
                $model = new SubtipeinsidenM();
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
}
