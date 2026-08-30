<?php
class JadwalPemberianObatController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */    
    public $defaultAction = 'admin';
    public $path_view = 'gudangFarmasi.views.jadwalPemberianObat.';
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
        
        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                if ($ajax == 'signa-oa-grid'){
                    $this->renderPartial($this->path_view.'grid/_daftarSignaOa',[]);
                }else if($ajax == 'subjenis-oa-grid'){
                    $this->renderPartial($this->path_view.'grid/_daftarSubJenisObat',[]);
                }                
                exit;
            }   
        }
        
        $model = new JadwalpemberianobatM();


        if (isset($_POST['JadwalpemberianobatM'])) {
            $ok = true;
            $pesan = '';
            $trans = Yii::app()->db->beginTransaction();
            try {                
                $proses = JadwalpemberianobatM::simpanData($model, $this->setPost($_POST), true);
                $ok &= $proses['sukses'];
                $pesan .= $proses['pesan'];     
                
                $this->hapusJadwal($_POST);
                
                if ($ok) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $trans->commit();
                    $this->redirect(array('admin', 'jadwalpemberianobat_id' => $model->jadwalpemberianobat_id, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan".$pesan);
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
        $model->subjenis_nama = !empty($model->subjenis)?$model->subjenis->subjenis_nama:'';        

        if (isset($_POST['JadwalpemberianobatM'])) {
            $ok = true;
            $pesan = '';
            $trans = Yii::app()->db->beginTransaction();
            try {                
                
                $proses = JadwalpemberianobatM::simpanData($model, $this->setPost($_POST), true);
                $ok &= $proses['sukses'];
                $pesan .= $proses['pesan'];           
                
                $this->hapusJadwal($_POST);
                
                if ($ok) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $trans->commit();
                    $this->redirect(array('admin', 'jadwalpemberianobat_id' => $model->jadwalpemberianobat_id, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan".$pesan);
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

        $model = new JadwalpemberianobatM('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['JadwalpemberianobatM'])) {
            $model->attributes = $_GET['JadwalpemberianobatM'];
        }

        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                
                $this->renderPartial($this->path_view.'_table',['model'=>$model]);
                exit;
            }   
        }else{        
            $this->render($this->path_view . 'admin', array(
                'model' => $model,
            ));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = JadwalpemberianobatM::model()->findByPk($id);
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
            $update = JadwalpemberianobatM::model()->updateByPk($id, array('jadwalpemberianobat_aktif' => false));
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
            $update = JadwalpemberianobatM::model()->updateByPk($id, array('jadwalpemberianobat_aktif' => true));
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
        $model = new JadwalpemberianobatM();
         if (isset($_GET['JadwalpemberianobatM'])) {
            $model->attributes = $_GET['JadwalpemberianobatM'];  
        }
        
        $judulLaporan = 'Data Jadwal Pemberian Obat';
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
    
    public function actionLoadJadwal($subjenis_id = null, $signaoa = null){
        if (Yii::app()->request->isAjaxRequest){
            
            $cri = new CDbCriteria;
            if (!empty($subjenis_id)){
                $cri->addCondition("subjenis_id = ".$subjenis_id);
            }else{
                $cri->addCondition(" subjenis_id is null ");
            }
            if (!empty($signaoa)){
                $cri->addCondition("signa_oa = '".$signaoa."' ");
            }else{
                $cri->addCondition(" signa_oa is null OR signa_oa = '' ");
            }
            $load = JadwalpemberianobatM::model()->findAll($cri);
                        
            $row = '';
            $listjadwal = LookupM::getItems('jammonitoring');
                        
            if (!empty($load)){
                foreach($load as $key => $val){
                    $row .= $this->renderPartial($this->path_view.'_rowJadwal',['model'=>$val, 'i'=>$key, 'listjadwal'=>$listjadwal], true);
                }
            }else{
                $row .= $this->renderPartial($this->path_view.'_rowJadwal',['model'=>new JadwalpemberianobatM, 'i'=>0, 'listjadwal'=>$listjadwal], true);
            }
            
            echo json_encode($row);
            Yii::app()->end();
        }
    }
    
    public function setPost($post){
        $arr = [];              
        $post = $post['JadwalpemberianobatM'];
        foreach($post as $key => $val){            
            if (is_numeric($key)){
                foreach($val as $k => $v){
                    $arr[$key][$k] = $v;
                }     
                
                $arr[$key]['subjenis_id'] = $post['subjenis_id'];
                $arr[$key]['signa_oa'] = $post['signa_oa'];
                $arr[$key]['jadwalpemberianobat_id'] = $val['jadwalpemberianobat_id'];                
            }
        }     
      
        return $arr;
    }
    
    public function hapusJadwal($post){
        
        if (isset($post['jadwal_hapus'])){
            $cri = new CDbCriteria;
            $cri->addInCondition("jadwalpemberianobat_id", $post['jadwal_hapus']);
            $del = JadwalpemberianobatM::model()->deleteAll($cri);
        }
                
    }

}
