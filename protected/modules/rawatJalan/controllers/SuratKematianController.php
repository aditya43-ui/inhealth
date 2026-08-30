<?php

class SuratKematianController extends MyAuthController
{
    public function actionIndex($pendaftaran_id){
        
        $this->layout = '//layouts/iframe';       
        
        $format = new MyFormatter;
        
        $model = new SuratketerangankematianT;        
        $modDaftar = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modDaftar->pasien_id);
        
        $cek = SuratketerangankematianT::model()->findByAttributes([
           'pendaftaran_id' => $modDaftar->pendaftaran_id 
        ]);
        if (!empty($cek)){
            $model = $cek;  
            $dpjp = $modDaftar->pegawai->namaLengkap ?? '';
            $model->dpjp_nama = $dpjp;

            // load diagnosa pasien
            $diagnosa = PasienmorbiditasT::model()->find(" pendaftaran_id = ".$pendaftaran_id." AND kelompokdiagnosa_id = ".Params::KELOMPOKDIAGNOSA_UTAMA);
            $diagnosa2 = PasienmorbiditasT::model()->find(" pendaftaran_id = ".$pendaftaran_id." AND kelompokdiagnosa_id != ".Params::KELOMPOKDIAGNOSA_UTAMA);
            
            $model->diagnosa_nama = !empty($diagnosa)?$diagnosa->diagnosa->diagnosa_nama:'';
            $model->diagnosa_nama2 = !empty($diagnosa2)?$diagnosa2->diagnosa->diagnosa_nama:'';

        }else{                
            $cekMeninggal = DaftarpasienmeninggalV::model()->findByAttributes([
                'pendaftaran_id' => $pendaftaran_id
            ]);
            
            $model->pendaftaran_id = $modDaftar->pendaftaran_id;
            $model->pasien_nama = $modPasien->nama_pasien;
            $model->pasien_jeniskelamin = $modPasien->jeniskelamin;
            $model->pasien_tanggal_lahir = $modPasien->tanggal_lahir;
            $model->pasien_no_rekam_medik = $modPasien->no_rekam_medik;
            $model->pasien_alamat = $modPasien->alamat_pasien;
            $model->pasien_tempat_lahir = $modPasien->tempat_lahir;
            $model->tanggal_meninggal = !empty($cekMeninggal->tgl_meninggal) ? $cekMeninggal->tgl_meninggal : date('Y-m-d H:i:s');            
            $model->tanggal_pemeriksaan = date('Y-m-d');       
            
            $diagnosa = PasienmorbiditasT::model()->find(" pendaftaran_id = ".$pendaftaran_id." AND kelompokdiagnosa_id = ".Params::KELOMPOKDIAGNOSA_UTAMA);
            $diagnosa2 = PasienmorbiditasT::model()->find(" pendaftaran_id = ".$pendaftaran_id." AND kelompokdiagnosa_id != ".Params::KELOMPOKDIAGNOSA_UTAMA);
            
            $model->diagnosa_nama = !empty($diagnosa)?$diagnosa->diagnosa->diagnosa_nama:'';
            $model->diagnosa_nama2 = !empty($diagnosa2)?$diagnosa2->diagnosa->diagnosa_nama:'';
            
            $dpjp = $modDaftar->pegawai->namaLengkap;
            $model->dpjp_nama = $dpjp;
        }
                
        if (isset($_POST['SuratketerangankematianT'])){
            $post = $_POST['SuratketerangankematianT'];
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            $pesan = '';
            try{
                
                $post = array_merge($post, [
                    'pendaftaran_id'=>$modDaftar->pendaftaran_id,                   
                ]);

                $proses = SuratketerangankematianT::simpanData($model, $post);
                $ok &= $proses['sukses'];
                $pesan .= $proses['pesan'];
                
                if ($ok){                                                            
                    Yii::app()->user->setFlash('success', "Data berhasil gagal disimpan ! ");
                    $trans->commit();
                    
                    $this->redirect(['index','pendaftaran_id'=>$pendaftaran_id,'sukses'=>1]);
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
            'model'=>$model
        ]);
    }
    
    public function actionPrintSurat($id){
        $this->layout = '//layouts/printWindows';
        
        $model = SuratketerangankematianT::model()->findByPk($id);       
        
        $model->loadInput();

        // load diagnosa pasien
        $diagnosa = PasienmorbiditasT::model()->find(" pendaftaran_id = ".$model->pendaftaran_id." AND kelompokdiagnosa_id = ".Params::KELOMPOKDIAGNOSA_UTAMA);
        $diagnosa2 = PasienmorbiditasT::model()->find(" pendaftaran_id = ".$model->pendaftaran_id." AND kelompokdiagnosa_id != ".Params::KELOMPOKDIAGNOSA_UTAMA);
        
        $model->diagnosa_nama = !empty($diagnosa)?$diagnosa->diagnosa->diagnosa_nama:'';
        $model->diagnosa_nama2 = !empty($diagnosa2)?$diagnosa2->diagnosa->diagnosa_nama:'';
        
        $this->render('print', array(
            'model'=>$model
        ));
    }
}
