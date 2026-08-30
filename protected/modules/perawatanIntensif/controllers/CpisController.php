<?php

class CpisController extends MyAuthController
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
        
        if (empty($id)){
            $model = new CpispasienT;
            $model->tanggalpengkajian = date('Y-m-d H:i:s');   
            $model->pendaftaran_id = $pendaftaran_id;
            $model->pasienadmisi_id = $pasienadmisi_id;
        }else{
            $model = CpispasienT::model()->findByPk($id);
            $model->loadInput();
        }
        
        $modDet = new CpispasiendetT;
        $modDet->cpispasien_id = $model->cpispasien_id;
        $model->setLoadCpisPoint = $modDet->loadDetail();        
        
        if (isset($_POST['CpispasienT'])){
            $pesan = '';
            $post = $_POST['CpispasienT'];
            
            $hasil_vap = '';
            if (isset($_POST['CpispasiendetT']['hasil_vap'])){
                $hasil_vap = $_POST['CpispasiendetT']['hasil_vap'];
                unset($_POST['CpispasiendetT']['hasil_vap']);
            }
            
            $postDet = $_POST['CpispasiendetT'];
            
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                
                $post = array_merge($post, [
                    'pendaftaran_id'=>$pendaftaran_id,
                    'pasienadmisi_id'=>$pasienadmisi_id,  
                    'dpjp_id'=>!empty($pasienadmisi_id)?$modDaftar->pasienadmisi->pegawai_id:$modDaftar->pegawai_id
                ]);
                                

                $proses = CpispasienT::simpanData($model, $post);
                $ok &= $proses['sukses'];
                $model = $proses['model'];
                $pesan .= $proses['pesan'];
                
                
                foreach($postDet as $key => $val){
                    $postDet[$key]['cpispasien_id'] = $model->cpispasien_id;
                    $postDet[$key]['hasil_vap'] = $hasil_vap;
                }                                
                        
                $proses = CpispasiendetT::simpanData($modDet, $postDet, true);
                $ok &= $proses['sukses'];
                $pesan .= $proses['pesan'];                                
                
                if ($ok){                                                            
                    Yii::app()->user->setFlash('success', "Data berhasil gagal disimpan ! ");
                    $trans->commit();
                    
                    $this->redirect(['index','pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id,'sukses'=>1, 'id'=>$model->cpispasien_id]);
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
            'modDet'=>$modDet
        ]);
    }
    
    public function actionDetail($id){       
        
        $this->layout = '//layouts/iframe';
        
        
        $model = CpispasienT::model()->findByPk($id);        
        $model->loadInput();
        
        $modDet = new CpispasiendetT;
        $modDet->cpispasien_id = $id;
        
        $model->setLoadCpisPoint = $modDet->loadDetail();                        
        
        $modDet->hasil_vap = $model->setLoadCpisPoint[0]->hasil_vap;
        $modDet->hasil_kultur = $model->setLoadCpisPoint[0]->hasil_kultur;
        
        if (isset($_POST['CpispasiendetT'])){
            $pesan = '';
            
            $hasil_kultur = '';
            if (isset($_POST['CpispasiendetT']['hasil_kultur'])){
                $hasil_kultur = $_POST['CpispasiendetT']['hasil_kultur'];
                unset($_POST['CpispasiendetT']['hasil_kultur']);
            }
            
            $postDet = $_POST['CpispasiendetT'];
            
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            try{                                   

                foreach($postDet as $key => $val){
                    $postDet[$key]['hasil_kultur'] = $hasil_kultur;
                }                                
                        
                $proses = CpispasiendetT::simpanData($modDet, $postDet, true);
                $ok &= $proses['sukses'];
                $pesan .= $proses['pesan'];                   
                
                if ($ok){                                                            
                    Yii::app()->user->setFlash('success', "Data berhasil gagal disimpan ! ");
                    $trans->commit();
                    
                    $this->redirect(['detail','id'=>$id]);
                }else{
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! ".$pesan);
                }
            }catch(Exception $e){
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $e->getMessage());
            }
        }
        
                
        $this->render('detail',[
            'model'=>$model,
            'modDet'=>$modDet
        ]);
    }
    
    public function actionCetak($id){
        $this->layout = '//layouts/printWindows';
        
        $model = CpispasienT::model()->findByPk($id);       
        
        $model->loadInput();
        
        $this->render('print/index', array(
            'model'=>$model
        ));
    }
    
    public function actionHapusCpis(){
        if (Yii::app()->request->isAjaxRequest){
            $id = isset($_POST['id'])?$_POST['id']:null;
            $sukses = 0;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $delDet = CpispasiendetT::model()->deleteAll(" cpispasien_id = ".$id); 
                $del = CpispasienT::model()->deleteByPk($id);
                
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
