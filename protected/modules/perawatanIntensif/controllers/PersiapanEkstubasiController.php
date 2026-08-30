<?php

class PersiapanEkstubasiController extends MyAuthController
{
    public function actionIndex($pendaftaran_id, $pasienadmisi_id = null, $id = null){       
        
        $this->layout = '//layouts/iframe';
        
        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                
                if ($ajax == 'daftar-petugas-grid'){
                    $path = 'grid/_daftar_petugas';
                    $model = null;
                }else if ($ajax == 'daftar-riwayat-grid'){
                    $path = 'grid/_daftarRiwayat';
                    $model = new PendaftaranT;
                    $model->pendaftaran_id = $pendaftaran_id;
                }
                
                $this->renderPartial($path, ['model'=>$model]);
                exit;
            }            
        }
        
        if (empty($pendaftaran_id)){
            echo 'pasien belum terdaftar';exit;
        }
        
        $format = new MyFormatter;
        
        $modDaftar = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modDaftar->pasien_id);
        
        if (empty($id)){
            $model = new EkstubasipasienT;
            $model->tgl_tindakan = date('Y-m-d H:i:s');   
            $model->pasien_id = $modPasien->pasien_id;
            $model->nama_pasien = $modPasien->nama_pasien;
            
            $morbiditas = PasienmorbiditasT::model()->findByAttributes([
                'pendaftaran_id' =>  $pendaftaran_id,
                'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA
            ]);
            
            if (!empty($morbiditas)){
                $model->diagnosa_nama = $morbiditas->diagnosa->diagnosa_nama;
                $model->diagnosa_id = $morbiditas->diagnosa_id;                                
            }
            
            $model->dpjp_id = $modDaftar->pegawai_id;
            $model->dpjp_nama = $modDaftar->pegawai->namaLengkap;
            
        }else{
            $model = EkstubasipasienT::model()->findByPk($id);
            $model->loadInput();
        }
      
        
        if (isset($_POST['EkstubasipasienT'])){
            $pesan = '';
            
            $post = $_POST['EkstubasipasienT'];
           
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                
                $post = array_merge($post, [
                    'pasien_id'=>$modPasien->pasien_id
                ]);
                
                $proses = EkstubasipasienT::simpanData($model, $post);
                $ok &= $proses['sukses'];
                $model = $proses['model'];
                $pesan .= $proses['pesan'];
                                               
                if ($ok){                                                            
                    Yii::app()->user->setFlash('success', "Data berhasil gagal disimpan ! ");
                    $trans->commit();
                    
                    $this->redirect(['index','pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id,'sukses'=>1, 'id'=>$model->ekstubasipasien_id]);
                }else{
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! ".$pesan);
                }
            }catch(Exception $e){
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $e->getMessage());
            }
        }
        
        $this->render('index',[
            'model'=>$model,
        ]);
    }
       
    public function actionCetak($id){
        $this->layout = '//layouts/printWindows';
        
        $model = EkstubasipasienT::model()->findByPk($id);       
        
        $model->loadInput();
        
        $this->render('print/index', array(
            'model'=>$model
        ));
    }
    
    public function actionDetail($id){
        $this->layout = '//layouts/iframe';
        
        $model = EkstubasipasienT::model()->findByPk($id);       
        
        $model->loadInput();
        
        $this->render('print/index', array(
            'model'=>$model
        ));
    }
    
    public function actionHapusEkstubasi(){
        if (Yii::app()->request->isAjaxRequest){
            $id = isset($_POST['id'])?$_POST['id']:null;
            $sukses = 0;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $del = EkstubasipasienT::model()->deleteByPk($id);
                
                if ($del){
                    $trans->commit();
                    $sukses = 1;
                }else{
                    $trans->rollback();
                }
            }catch(Exception $e){
                $trans->rollback();
            }
            
            echo json_encode([
                'sukses'=>$sukses
            ]);
        }
    }
}
