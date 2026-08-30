
<?php

class LoketPendaftaranPoliController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */    
    public $defaultAction = 'admin';
    public $path_view = 'pendaftaranPenjadwalan.views.loketPendaftaranPoli.';
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
        $model = new LoketpendaftaranpoliM();


        if (isset($_POST['LoketpendaftaranpoliM'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
               
                $dataRuangan = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;

                $loket = LoketM::model()->findByPk($_POST['LoketpendaftaranpoliM']['loket_id']);
                
                $arrRAda = [];
                if (!empty($dataRuangan)) {                  
                    foreach ($dataRuangan as $i => $r) {
                      $dataR = new LoketpendaftaranpoliM;
                      $cekR = LoketpendaftaranpoliM::model()->findByAttributes([
                          'loket_id' => $loket->loket_id,
                          'ruangan_id' => $r
                      ]);
                      if (!empty($cekR)){
                          $dataR = $cekR;
                      }
                      $dataR->loket_id = $loket->loket_id;
                      $dataR->loket_nama = $loket->loket_nama;
                      $dataR->ruangan_id = $r;
                      $dataR->ruangan_nama = $dataR->ruangan->ruangan_nama;
                      $ok &= $dataR->save();
                      
                      $arrRAda[$r] = $r;
                    }
                    
                    $model = $dataR;
                }
                
                if (!empty($arrRAda)){
                    $criDel = new CDbCriteria;
                    $criDel->addNotInCondition("ruangan_id", $arrRAda);
                    $criDel->addCondition(" loket_id = ".$loket->loket_id);
                    $del = LoketpendaftaranpoliM::model()->deleteAll($criDel);
                }else{
                    $del = LoketpendaftaranpoliM::model()->deleteAll(" loket_id = ".$loket->loket_id);
                }
                
               
                if ($ok) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $trans->commit();
                    $this->redirect(array('admin', 'loketpendaftaranpoli_id' => $model->loketpendaftaranpoli_id, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan");
                }
            } catch (Exception $ex) {
                var_dump($ex->getMessage());die;
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
        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
        $model = $this->loadModel($id);

        if (isset($_POST['LoketpendaftaranpoliM'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                
                $dataRuangan = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;

                $loket = LoketM::model()->findByPk($_POST['LoketpendaftaranpoliM']['loket_id']);
                
                $arrRAda = [];
                if (!empty($dataRuangan)) {                  
                    foreach ($dataRuangan as $i => $r) {
                      $dataR = new LoketpendaftaranpoliM;
                      $cekR = LoketpendaftaranpoliM::model()->findByAttributes([
                          'loket_id' => $loket->loket_id,
                          'ruangan_id' => $r
                      ]);
                      if (!empty($cekR)){
                          $dataR = $cekR;
                      }
                      $dataR->loket_id = $loket->loket_id;
                      $dataR->loket_nama = $loket->loket_nama;
                      $dataR->ruangan_id = $r;
                      $dataR->ruangan_nama = $dataR->ruangan->ruangan_nama;
                      $ok &= $dataR->save();
                      
                      $arrRAda[$r] = $r;
                    }
                    
                    $model = $dataR;
                }
                
                if (!empty($arrRAda)){
                    $criDel = new CDbCriteria;
                    $criDel->addNotInCondition("ruangan_id", $arrRAda);
                    $criDel->addCondition(" loket_id = ".$loket->loket_id);
                    $del = LoketpendaftaranpoliM::model()->deleteAll($criDel);
                }else{
                    $del = LoketpendaftaranpoliM::model()->deleteAll(" loket_id = ".$loket->loket_id);
                }
                
                
                if ($ok) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $trans->commit();
                    $this->redirect(array('admin', 'loketpendaftaranpoli_id' => $model->loketpendaftaranpoli_id, 'sukses' => 1));
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

        $model = new LoketpendaftaranpoliM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['LoketpendaftaranpoliM'])) {
            $model->attributes = $_GET['LoketpendaftaranpoliM'];
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
        $model = LoketpendaftaranpoliM::model()->findByAttributes(['loket_id'=>$id]);
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
            $update = BJRakbankjaringanM::model()->updateByPk($id, array('rakstemcell_aktif' => false));
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
            $update = LoketpendaftaranpoliM::model()->updateByPk($id, array('rakstemcell_aktif' => true));
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
        $model = new LoketpendaftaranpoliM();
         if (isset($_GET['LoketpendaftaranpoliM'])) {
            $model->attributes = $_GET['LoketpendaftaranpoliM'];  
        }
        
        $judulLaporan = 'Data Loket Pendaftaran Poli';
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
    
    /**
     * load list model dan loket
     */
    public function actionLoadPoliklinik(){
        if (Yii::app()->request->isAjaxRequest){
            
            $data = array();
            $loket_id = isset($_POST['loket_id'])?$_POST['loket_id']:null;
            
            $arrAdaPoli= array();                                    
            
            if (!empty($loket_id)){
                $cri = new CDbCriteria();
                $cri->select = "t.ruangan_id";
                $cri->addCondition(" loket_id = '".$loket_id."'  ");               
                $cekLoketPoli = LoketpendaftaranpoliM::model()->findAll($cri);
                foreach($cekLoketPoli as $det){
                    $arrAdaPoli[$det->ruangan_id] = $det->ruangan_id;
                }
            }
           
            $htmlPoli = '';
            
                       
            $mod = RuanganM::model()->findAll(" instalasi_id = ".Params::INSTALASI_ID_RJ." AND ruangan_aktif = TRUE ORDER BY ruangan_nama ASC ");
            foreach($mod as $m){
                $cek = isset($arrAdaPoli[$m->ruangan_id])?'selected':'';
                $htmlPoli .= "<option  ".$cek."  value='".$m->ruangan_id."'>".$m->ruangan_nama."</option>";
            }
                                   
            
            $data['sukses'] = 1;
            $data['ruangan'] = $htmlPoli;
            
            echo json_encode($data);
            Yii::app()->end();
        }
    }  

}
