<?php

class AsesmenPraAnestesiController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */    
    public $defaultAction = 'index';
    public $path_view = 'rawatInap.views.asesmenPraAnestesi.';
    public $path_tips = 'sistemAdministrator.views.tips.';  
    public $layout = '//layouts/iframe';
 

    /**
     * 
     * @param type $id merupakan kolom asesmenpraanestesi_id
     */
    public function actionIndex($pendaftaran_id, $id = null) {   
        
        if(empty($pendaftaran_id)) {
            echo 'Tidak ada kunjungan pada pasien tersebut';
            die;
        }
       
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $criteria = new CDbCriteria;
        if (!empty($pendaftaran_id)) {
            $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
            $criteria->select = 't.*, pasienmorbiditas_t.tglmorbiditas, pasienmorbiditas_t.pegawai_id, pasienmorbiditas_t.kelompokdiagnosa_id, pasienmorbiditas_t.ruangan_id';
            $criteria->join = 'JOIN pasienmorbiditas_t ON pasienmorbiditas_t.pasienmorbiditas_id = t.pasienmorbiditas_id';
        }
        $model_ix = Pasienicd9cmT::model()->findAll($criteria);
        
        if (empty($id)){
            $model = new AsesmenpraanestesiT();
            $model->pendaftaran_id = $pendaftaran_id;  
            $model->pasien_id = $modPendaftaran->pasien_id;  
            $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

            $anamnesa = AnamnesaT::model()->find("pasien_id is not null order by anamesa_id desc");

            $model->riwayatpenyakit = $anamnesa->riwayatpenyakitterdahulu;
            $model->riwayatpengobatan = $anamnesa->pengobatanygsudahdilakukan;
            $model->riwayatalergimakanan = $anamnesa->riwayatmakanan;
            $model->riwayatalergiobat = $anamnesa->riwayatalergiobat;
            $model->keluhanutama = $anamnesa->keluhanutama;
            
            if (empty($model->dropListPermintaan)){
                echo 'Pasien Belum Memiliki Permintaan ke Bedah Sentral';
                exit;
            }else{
                if (count($model->dropListPermintaan) == 1){
                    foreach($model->dropListPermintaan as $k => $v){
                        $model->pasienkirimkeunitlain_id = $k;
                        break;
                    }
                }
            }
            
            $model->setAwal();           
        }else{
            $model = AsesmenpraanestesiT::model()->findByPk($id);
            $model->loadInput();            
        }
        
        $modFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'create_time DESC', 'limit' => 1));
        if(!empty($modFisik)) {
            $model->gcs_eye_id = $modFisik->gcs_eye;
            $model->gcs_verbal_id = $modFisik->gcs_verbal;
            $model->gcs_motorik_id = $modFisik->gcs_motorik;
        }
        $modAnamnesa = AnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'create_time DESC', 'limit' => 1));
        if(!empty($modAnamnesa)) {
            $model->riwayatpengobatan = $modAnamnesa->pengobatanygsudahdilakukan;
            $model->riwayatalergimakanan = $modAnamnesa->riwayatmakanan;
            $model->riwayatalergiobat = $modAnamnesa->riwayatalergiobat;
            $model->keluhanutama = $modAnamnesa->keluhanutama;
            if($modAnamnesa->statusmerokok == true) {
                $model->is_konsumsirokok = 1;
            } else {
                $model->is_konsumsirokok = 0;
            }
        }

        $this->setAjaxReload($model);
                
        if (isset($_POST['AsesmenpraanestesiT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            $pesan = '';            
            try {                
                $_POST['AsesmenpraanestesiT']['pendaftaran_id'] = $modPendaftaran->pendaftaran_id;
                $_POST['AsesmenpraanestesiT']['pasienadmisi_id'] = $modPendaftaran->pasienadmisi_id;
                $_POST['AsesmenpraanestesiT']['pasien_id'] = $modPendaftaran->pasien_id;
                $proses = AsesmenpraanestesiT::simpanData($model, $_POST['AsesmenpraanestesiT']);
                $model = $proses['model'];
                $ok &= $proses['sukses'];
                $pesan .= $proses['pesan'];                                                                                     
                                                                                                   
                
                if ($ok) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $trans->commit();
                    $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id, 'id' => $model->asesmenpraanestesi_id,'sukses'=>1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan".$pesan);
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan" . MyExceptionMessage::getMessage($ex, true));
            }
        }                                
        
        $this->render($this->path_view . 'index', array(
            'model' => $model, 'model_ix' => $model_ix
        ));
    }         
    
    /**
     * 
     * @param type $id
     */
    public function actionUbah($id) {

        if( isset($_GET['frame']) ) {
            $this->layout = '//layouts/iframe';
        }
        $model = AsesmenpraanestesiT::model()->findByPk($id);
        $model->loadInput();                
                    
        $this->setAjaxReload($model);
        
        if (isset($_POST['AsesmenpraanestesiT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            $pesan = '';            
            try {                
               
                $proses = AsesmenpraanestesiT::simpanData($model, $_POST['AsesmenpraanestesiT']);
                $model = $proses['model'];
                $ok &= $proses['sukses'];
                $pesan .= $proses['pesan'];                                                                                     
               
                if ($ok) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $trans->commit();
                    $this->redirect(array('index','pendaftaran_id'=>$model->pendaftaran_id, 'id' => $model->asesmenpraanestesi_id,'sukses'=>1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan".$pesan);
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan" . MyExceptionMessage::getMessage($ex, true));
            }
        }
                        
        $this->render($this->path_view . 'index', array(
            'model' => $model,     
        ));
    } 
    
    /**
     * 
     * @param type $id
     */
    public function actionDetail($id) {

        if( isset($_GET['frame']) ) {
            $this->layout = '//layouts/iframe';
        }

        $model = AsesmenpraanestesiT::model()->findByPk($id);
        $model->loadInput();
              
                        
        $this->render($this->path_view . 'index', array(
            'model' => $model,     
            'detail' => 1
        ));
    } 
    
    /**
     * 
     * @param type $id
     */
    public function actionSalin($id) {

        if( isset($_GET['frame']) ) {
            $this->layout = '//layouts/iframe';
        }

        $model = AsesmenpraanestesiT::model()->findByPk($id);
        $model->loadInput();
        
        $this->setAjaxReload($model);                  
        
        if (isset($_POST['AsesmenpraanestesiT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            $pesan = '';            
            try {                
                $model->jnstransaksi = 'salin';
                $proses = AsesmenpraanestesiT::simpanData($model, $_POST['AsesmenpraanestesiT']);
                $model = $proses['model'];
                $ok &= $proses['sukses'];
                $pesan .= $proses['pesan'];                                                                                     
                                                               
                if ($ok) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $trans->commit();
                    $this->redirect(array('index','pendaftaran_id'=>$model->pendaftaran_id, 'id' => $model->asesmenpraanestesi_id,'dukses'=>1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan".$pesan);
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan" . MyExceptionMessage::getMessage($ex, true));
            }
        }
                        
        $this->render($this->path_view . 'index', array(
            'model' => $model,                 
        ));
    } 
    
    public function actionHapus(){
        if (Yii::app()->request->isAjaxRequest){
            
            $id = $_POST['id'];
            $trans = Yii::app()->db->beginTransaction();
            try{
                $model = AsesmenpraanestesiT::model()->findByPk($id);                
                $del = $model->delete();
                                
                $trans->commit();                                
            }catch(Exception $e){
                $trans->rollback();
            }
            
            echo json_encode($this->createUrl('index',['pendaftaran_id'=>$model->pendaftaran_id]));
            Yii::app()->end();
        }
    }
    
    /**
     * @param type $id
     */
    public function actionCetak($id) {
        $this->layout = '//layouts/_auto_pdf';
        
        $model = AsesmenpraanestesiT::model()->findByPk($id);
        $model->loadInput();
        
        $modPasien = PasienM::model()->findByPk($model->pasien_id);

        $judul_print = '<b>ASESMEN PRA BEDAH</b>';
        $alias = '';
        
         
        $ukuranKertasPDF = Params::getUkuranKertas();                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF['F4']);
        //$mpdf->useOddEven = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/global-prinout-pdf.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
        $mpdf->WriteHTML($this->renderPartial('print/index', array(            
            'model'=>$model,            
            'judul_print' => $judul_print,
            'alias' => $alias,
            'modPasien' => $modPasien,
            'model' => $model,
            'koderm'=>'RM. 023'
        ), true));
        $mpdf->SetHTMLFooter("&nbsp;");
        $mpdf->Output();                 
    }
    
    public function actionMasterKeluhan() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria;
            $criteria->compare('LOWER(keluhananamnesis_nama)', strtolower($_GET['tag']), true);
            $criteria->order = "keluhananamnesis_nama ASC";
            $keluhans = KeluhananamnesisM::model()->findAll($criteria);
            $data = array();
            foreach ($keluhans as $i => $keluhan) {
                $data[$i] = array(
                    'key' => $keluhan->keluhananamnesis_nama,
                    'value' => $keluhan->keluhananamnesis_nama
                );
            }

            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function setAjaxReload(&$model){
        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];

                if ($ajax == 'daftar-obat-grid')
                    $path = $this->path_view.'grid/_daftarObat';                
                else if ($ajax == 'daftar-petugas-ruangan-grid')
                    $path = $this->path_view.'grid/_daftarPetugasRuangan';
                else if ($ajax == 'daftar-diagnosa-grid')
                    $path = $this->path_view.'grid/_daftarDiagnosa';   
                else if ($ajax == 'riwayat-grid')
                    $path = $this->path_view.'grid/_daftarRiwayat';   
                else if ($ajax == 'riwayat-morbiditas-grid')
                    $path = $this->path_view.'grid/_daftarRiwayatMorbiditas';   
                else if ($ajax == 'riwayat-permintaan-grid')
                    $path = $this->path_view.'grid/_daftarRiwayatPermintaan';   

                $this->renderPartial($path,['model'=>$model]);
            }
            exit;
        }
    }
}
