<?php

class BaSerahTerimaJaringanController extends MyAuthController
{
    public function actionIndex($pasienmasukpenunjang_id){
        
        $this->layout = '//layouts/iframe';
        
        if (empty($pasienmasukpenunjang_id)){
            echo 'pasien bukan pasien bedah';exit;
        }
        
        $format = new MyFormatter;
        
        $model = new SerahterimajaringanT;
        $modPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);        
        $modPasien = PasienM::model()->findByPk($modPenunjang->pasien_id);
        $modDaftar = PendaftaranT::model()->findByPk($modPenunjang->pendaftaran_id);
        
        $cek = SerahterimajaringanT::model()->findByAttributes([
           'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
        ]);
        if (!empty($cek)){
            $model = $cek;            
        }
                
        $model->pihakpenerima = $model->namapasien = $modPasien->nama_pasien;        
        $model->alamat = $modPasien->alamat_pasien;
        $model->nomor_rm = $modPasien->no_rekam_medik;
        $model->create_time = date('y-m-d H:i:s');        
        
        $diagnosa = PasienmorbiditasT::model()->findByAttributes([
            'pendaftaran_id'=>$modDaftar->pendaftaran_id,
            'kelompokdiagnosa_id'=>Params::KELOMPOKDIAGNOSA_UTAMA
        ]);
        $model->diagnosa = !empty($diagnosa)?$diagnosa->diagnosa->diagnosa_nama:'-';
        
        $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $model->petugas_nama = $peg->namaLengkap;
        $model->petugas_id = $peg->pegawai_id;
        $model->jabatan_nama = !empty($peg->jabatan)?$peg->jabatan->jabatan_nama:'';
        $model->jabatan = !empty($peg->jabatan_id)?$peg->jabatan_id:null;
        
                        
        $modPj = PenanggungjawabM::model()->findByPk($modDaftar->penanggungjawab_id);
        if (!empty($modPj)){
            $model->nama_kepenanggungjawab = $model->pihakmenyerahkan = $modPj->nama_pj;            
        }        
                
        if (isset($_POST['SerahterimajaringanT'])){
            $post = $_POST['SerahterimajaringanT'];
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                
                $post = array_merge($post, [
                    'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id,
                    'pendaftaran_id'=>$modDaftar->pendaftaran_id,                   
                ]);

                $proses = SerahterimajaringanT::simpanData($model, $post);
                $ok &= $proses['sukses'];
                
                if ($ok){                                                            
                    Yii::app()->user->setFlash('success', "Data berhasil gagal disimpan ! ");
                    $trans->commit();
                    
                    $this->redirect(['index','pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id,'sukses'=>1]);
                }else{
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! ");
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
        
        $model = SerahterimajaringanT::model()->findByPk($id);       
        
        $model->loadInput();
        
        $this->render('print', array(
            'model'=>$model
        ));
    }
}
