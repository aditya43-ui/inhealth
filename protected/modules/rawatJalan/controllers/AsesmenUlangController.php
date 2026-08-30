<?php

class AsesmenUlangController extends MyAuthController {
   
    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'rawatJalan.views.asesmenUlang.';

    /**
     * Lists all models.
     */
    public function actionIndex($pendaftaran_id, $pasienadmisi_id = null, $jenis = '') {                
        
        $this->render('index', array(
            
        ));
    }
    
    public function actionRJRD(){
        if (Yii::app()->request->isAjaxRequest){
            
            $pendaftaran_id = isset($_POST['pendaftaran_id'])?$_POST['pendaftaran_id']:null;
            $pasienadmisi_id = isset($_POST['pasienadmisi_id'])?$_POST['pasienadmisi_id']:null;
            
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                if ($ajax == 'daftar-riwayat-grid'){
                    $path = $this->path_view.'spiritualUlangRJRD/grid/_daftarRiwayat';
                }
                
                $model = new PendaftaranT;
                $model->pendaftaran_id = $pendaftaran_id;
                $this->renderPartial($path,['model'=>$model]);
                exit;
            }                       
                                        
            $jenis = $_POST['jenis'];
            
            $sukses = 1;
            $pesan = '';
            
            $model = new AsesmenspiritualUlangpasienrajalT;
            $modDet = new AsesmenspiritualUlangpasienrajaldetT;
            $modDet->tanggal = date('Y-m-d H:i:s');
            
            $r = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
            $modDet->ruangan_id = $r->ruangan_id;
            $modDet->ruangan_nama = $r->ruangan_nama;
            
            $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            $modDet->petugas_id = $peg->pegawai_id;
            $modDet->petugas_nama = $peg->namaLengkap;
            
            $modDaftar = PendaftaranT::model()->findByPk($pendaftaran_id);
            
            if ($jenis != 'setform'){
                parse_str($_POST['form'], $arr);
                                
                $ok = true;
                $post = $arr['AsesmenspiritualUlangpasienrajaldetT'];
                
                $trans = Yii::app()->db->beginTransaction();
                try{
                    
                    $proses = AsesmenspiritualUlangpasienrajalT::simpanData($model, [
                        'pasien_id' => $modDaftar->pasien_id,  
                        'pendaftaran_id' => $modDaftar->pendaftaran_id,
                    ]);
                    $sukses &= $proses['sukses'];
                    $pesan .= $proses['pesan'];
                    $model = $proses['model'];
                
                    $post['pendaftaran_id'] = $model->pendaftaran_id;
                    $post['pasien_id'] = $model->pasien_id;
                    $post['ruangan_id'] = $modDet->ruangan_id;
                    $post['petugas_id'] = $modDet->petugas_id;
                    $post['tanggal'] = $modDet->tanggal;
                    $post['asesmenspiritual_ulangpasienrajal_id'] = $model->asesmenspiritual_ulangpasienrajal_id;
                   
                    
                    $proses = AsesmenspiritualUlangpasienrajaldetT::simpanData($modDet, $post);
                    $sukses &= $proses['sukses'];
                    $pesan .= $proses['pesan'];
                    
                    if ($sukses){
                        $trans->commit();
                    }else{
                        $sukses = 0;
                        $trans->rollback();
                    }
                }catch(Exception $e){   
                    $sukses = 0;
                    $trans->rollback();                    
                }
            }
                        
            $html = $this->renderPartial($this->path_view.'spiritualUlangRJRD/index', ['model'=>$model, 'modDet'=>$modDet], true);
            
            echo json_encode([
                'html' => $html,
                'sukses' => $sukses
            ]);
            Yii::app()->end();
        }
    }
    
    public function actionRI(){
        if (Yii::app()->request->isAjaxRequest){
            
            $pendaftaran_id = isset($_POST['pendaftaran_id'])?$_POST['pendaftaran_id']:null;
            $pasienadmisi_id = isset($_POST['pasienadmisi_id'])?$_POST['pasienadmisi_id']:null;                                  
            
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                if ($ajax == 'daftar-riwayat-grid'){
                    $path = $this->path_view.'spiritualUlangRI/grid/_daftarRiwayat';
                }
                                                
                $this->renderPartial($path,[]);
                exit;
            }                       
                                        
            $modDaftar = PendaftaranT::model()->findByPk($pendaftaran_id);            
            if (empty($modDaftar->pasienadmisi_id)){
                echo json_encode([
                    'sukses' => 2,
                    'pesan' => 'Pendaftaran pasien ini, belum didaftarkan ke rawat inap'
                ]);
                Yii::app()->end();
            }  
            
            $jenis = $_POST['jenis'];
            
            $sukses = 1;
            $pesan = '';
            
            $model = new AsesmenspiritualUlangpasienT;
            $modDet = new AsesmenspiritualUlangpasiendetT;
            $modDet->tanggal = date('Y-m-d H:i:s');
            
            $r = KamarruanganM::model()->findByPk($modDaftar->pasienadmisi->kamarruangan_id);
            if (!empty($r)){
                $modDet->kamarruangan_id = $r->kamarruangan_id;
                $modDet->kamarruangan_nama = $r->kamarruangan_nokamar.' - '.$r->kamarruangan_nobed;
            }
                             
            
            if ($jenis != 'setform'){                
                parse_str($_POST['form'], $arr);
                                
                $ok = true;
                $post = $arr['AsesmenspiritualUlangpasiendetT'];
                
                $trans = Yii::app()->db->beginTransaction();
                try{                    
                    $proses = AsesmenspiritualUlangpasienT::simpanData($model, [
                        'pasien_id' => $modDaftar->pasien_id,  
                        'pendaftaran_id' => $modDaftar->pendaftaran_id,
                        'pasienadmisi_id' => $modDaftar->pasienadmisi_id,
                        'kamarruangan_id' => $modDet->kamarruangan_id
                    ]);
                    $sukses &= $proses['sukses'];
                    $pesan .= $proses['pesan'];
                    $model = $proses['model'];
                
                    $post['kamarruangan_id'] = $modDet->kamarruangan_id;
                    $post['asesmenspiritual_ulangpasien_id'] = $model->asesmenspiritual_ulangpasien_id;
                    $post['tanggal'] = date('Y-m-d H:i:s');
                    
                    $proses = AsesmenspiritualUlangpasiendetT::simpanData($modDet, $post);
                    $sukses &= $proses['sukses'];
                    $pesan .= $proses['pesan'];                    
                    if ($sukses){
                        $trans->commit();
                    }else{
                        $sukses = 0;
                        $trans->rollback();
                    }
                }catch(Exception $e){   
                    var_dump($e->getMessage());die;
                    $sukses = 0;
                    $trans->rollback();                    
                }
            }
                        
            $html = $this->renderPartial($this->path_view.'spiritualUlangRI/index', ['model'=>$model, 'modDet'=>$modDet], true);
            
            echo json_encode([
                'html' => $html,
                'sukses' => $sukses
            ]);
            Yii::app()->end();
        }
    }

    public function actionHapus($jenis){
        if (Yii::app()->request->isAjaxRequest){
            $id = isset($_POST['id'])?$_POST['id']:null;
            $sukses = 0;
            $trans = Yii::app()->db->beginTransaction();
            try{
                
                if ($jenis == 'spiritualUlangRJRD'){               
                    $delDet = AsesmenspiritualUlangpasienrajaldetT::model()->deleteAll(" asesmenspiritual_ulangpasienrajal_id = ".$id); 
                    $del = AsesmenspiritualUlangpasienrajalT::model()->deleteByPk($id);
                }else if ($jenis == 'spiritualUlangRI'){ 
                    $delDet = AsesmenspiritualUlangpasiendetT::model()->deleteAll(" asesmenspiritual_ulangpasien_id = ".$id); 
                    $del = AsesmenspiritualUlangpasienT::model()->deleteByPk($id);
                }
                
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
    
    public function actionCetak($id, $jenis){
        if (!isset($_GET['detail'])){
            $this->layout = '//layouts/printWindows';
        }else{
            $this->layout = '//layouts/iframe';
        }
        
        if ($jenis == 'spiritualUlangRI'){
            $model = AsesmenspiritualUlangpasiendetT::model()->find(" asesmenspiritual_ulangpasien_id = ".$id);         
        }else if ($jenis == 'spiritualUlangRJRD'){
            $model = AsesmenspiritualUlangpasienrajaldetT::model()->find(" asesmenspiritual_ulangpasienrajal_id = ".$id);                     
        }
        
        $model->loadInput();
        $model->jenis = $jenis;
        
        $this->render($this->path_view.$jenis.'/print/index', array(
            'model'=>$model
        ));
    }
    
   
}
