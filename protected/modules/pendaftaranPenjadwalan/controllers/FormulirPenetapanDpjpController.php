<?php

class FormulirPenetapanDpjpController extends MyAuthController
{
    public function actionIndex($pasienadmisi_id){
        
        $this->layout = '//layouts/iframe';
        
        $modAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);      
        
        if (empty($pasienadmisi_id)){
            echo 'pasien bukan pasien rawat inap';exit;
        }else{
            if (empty($modAdmisi->kamarruangan_id)){
                echo 'pasien belum masuk kamar';exit;
            }
        }
        
        $format = new MyFormatter;
        
        $model = new SuratpenetapandpjpT;
          
        $modPasien = PasienM::model()->findByPk($modAdmisi->pasien_id);
        $modDaftar = PendaftaranT::model()->findByPk($modAdmisi->pendaftaran_id);
        
        
        
        $cek = SuratpenetapandpjpT::model()->findByAttributes([
           'pendaftaran_id' => $modDaftar->pendaftaran_id 
        ]);
        if (!empty($cek)){
            $model = $cek;           
        }else{
            
            $dokAdmisi = PegawaiM::model()->findByPk($modAdmisi->pegawai_id);
            if (!empty($dokAdmisi)){
                $model->dokter_dpjp1 = $dokAdmisi->pegawai_id;
                $model->dokter_dpjp1_nama = $dokAdmisi->namaLengkap;
            }
            
            $model->nama_depan = $modPasien->namadepan;
            $model->nama_pasien = $modPasien->nama_pasien;
            $model->tempat_lahir = $modPasien->tempat_lahir;
            $model->tanggal_lahir = $modPasien->tanggal_lahir;
            $model->jeniskelamin = $modPasien->jeniskelamin;
            $model->alamat_pasien = $modPasien->alamat_pasien;
            $model->tgl_masuk = $format->formatDateTimeForUser($modDaftar->tgl_pendaftaran);
            $model->no_rekam_medik = $modPasien->no_rekam_medik;      
            $model->kamarruangan_id = $modAdmisi->kamarruangan_id;            
            $model->kelaspelayanan_id = $modAdmisi->kelaspelayanan_id;
            $model->kelaspelayanan_nama = $modAdmisi->kelaspelayanan->kelaspelayanan_nama;
            $model->tgl_pendaftaran = $modDaftar->tgl_pendaftaran;
            
            $pecah = (explode(' ',$modDaftar->umur));
            $model->umur_pasien = $pecah[0].' tahun';
            
            $kamarruangan = KamarruanganM::model()->findByPk($modAdmisi->kamarruangan_id);
            $model->kamarruangan_nama = !empty($modAdmisi->kamarruangan_id)?$kamarruangan->kamarruangan_nokamar.' - '.$kamarruangan->kamarruangan_nobed:'-';
                      
            $modPj = PenanggungjawabM::model()->findByPk($modDaftar->penanggungjawab_id);
            if (!empty($modPj) && empty($cek)){
                $model->nama_pj = $modPj->nama_pj;
                $model->tempatlahir_pj = $modPj->tempatlahir_pj;
                $model->tgllahir_pj = $modPj->tgllahir_pj;
                $model->hubungankeluarga = $modPj->hubungankeluarga;            
                $model->penanggungjawab_id = $modPj->penanggungjawab_id;
            }
                        
            $suratpersetujuan = SuratpersetujuanumumT::model()->findByAttributes([
                'pendaftaran_id' => $modDaftar->pendaftaran_id 
            ]);
            $model->saksi_kebutuhanprivasi = !empty($suratpersetujuan)?$suratpersetujuan->saksi_pasien:'';
            $model->petugas_admisi = !empty($suratpersetujuan)?$suratpersetujuan->petugas_admisi:'';
                    
            $model->kebutuhanprivasi = "<ol><li></li><li></li><li></li><li></li></ol>";
        }                   
                
        if (isset($_POST['SuratpenetapandpjpT'])){
            $post = $_POST['SuratpenetapandpjpT'];
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                
                $post = array_merge($post, [
                    'pasien_id'=>$modAdmisi->pasien_id,
                    'pendaftaran_id'=>$modAdmisi->pendaftaran_id,
                    'penanggungjawab_id'=>$modDaftar->penanggungjawab_id,                 
                ]);

                $proses = SuratpenetapandpjpT::simpanData($model, $post);
                $ok &= $proses['sukses'];
                
                if ($ok){                                                            
                    Yii::app()->user->setFlash('success', "Data berhasil gagal disimpan ! ");
                    $trans->commit();
                    
                    $this->redirect(['index','pasienadmisi_id'=>$pasienadmisi_id,'sukses'=>1]);
                }else{
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! ".$proses['pesan']);
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
        
        $model = SuratpenetapandpjpT::model()->findByPk($id);       
        
        $model->loadInput();
        
        $this->render('print', array(
            'model'=>$model
        ));
    }

    public function actionPrintGabung($id){
        $this->layout = '//layouts/printWindows';
        $modPendaftaran = PendaftaranT::model()->findByPk($id);
        // var_dump($modPendaftaran);die;       
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id); 
        if(!empty($modPendaftaran->pasienadmisi_id)){
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        }else{
            $modAdmisi = new PasienadmisiT();
        }
        $dok=PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
        $surat = SuratpenetapandpjpT::model()->findAllByAttributes(['pendaftaran_id'=>$modPendaftaran->pendaftaran_id]);
        if(empty($surat)){
           $surat = new SuratpenetapandpjpT(); 
        }

        $modSurat =  SuratpersetujuanrdokterT::model()->findAllByAttributes(['pendaftaran_id'=>$modPendaftaran->pendaftaran_id]);
        if(empty($modSurat)){
           $modSurat = new SuratpersetujuanrdokterT(); 
        }  
        // $model = SuratpenetapandpjpT::model()->findByPk($id);       
        
        // $model->loadInput();
        
        // $model->loadInput();
        
        $this->render('printNewAll', array(
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'modAdmisi'=>$modAdmisi,
            'dok' =>$dok,
            'surat' => $surat,
            'modSurat' => $modSurat
        ));
    }
}
