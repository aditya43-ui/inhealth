<?php

class SuratAkadIjarahController extends MyAuthController
{
    public function actionIndex($pasienadmisi_id){
        
        $this->layout = '//layouts/iframe';
       
        if (empty($pasienadmisi_id) || $pasienadmisi_id == "undefined"){
            echo 'pasien bukan pasien rawat inap';exit;
        }
        $format = new MyFormatter;
        $model = new SuratakadijarahT;
        $modAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);        
        $modPasien = PasienM::model()->findByPk($modAdmisi->pasien_id);
        $modDaftar = PendaftaranT::model()->findByPk($modAdmisi->pendaftaran_id);
        
        $cek = SuratakadijarahT::model()->findByAttributes([
           'pendaftaran_id' => $modDaftar->pendaftaran_id 
        ]);
        if (!empty($cek)){
            $model = $cek;
            $model->rencana_uangmuka = $format->formatNumberForPrint($model->rencana_uangmuka);
            $model->tambah_uangmuka = $format->formatNumberForPrint($model->tambah_uangmuka);
        }
                
        $model->nama_pasien = $modPasien->nama_pasien;
        $pecah = (explode(' ',$modDaftar->umur));
        $model->umur_pasien = $pecah[0].' tahun';
        $model->jeniskelamin = $modPasien->jeniskelamin;
        $model->alamat_pasien = $modPasien->alamat_pasien;
        $model->jenisidentitas = $modPasien->jenisidentitas;
        $model->no_identitas_pasien = $modPasien->no_identitas_pasien;
        $model->tgl_masuk = $format->formatDateTimeForUser($modDaftar->tgl_pendaftaran);
        $model->no_rekam_medik = $modPasien->no_rekam_medik;
        $model->no_identitas_pasien = $modPasien->no_identitas_pasien;
        $model->noteleponpasien = !empty($modPasien->no_telepon_pasien)?$modPasien->no_telepon_pasien:$modPasien->no_mobile_pasien;
        
        $model->carabayar_nama = $modAdmisi->carabayar->carabayar_nama;
        $model->kelaspelayanan_nama = $modAdmisi->kelaspelayanan->kelaspelayanan_nama;
        $model->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
        $model->kamarruangan_nama = !empty($modAdmisi->kamarruangan)?$modAdmisi->kamarruangan->kamarruangan_nokamar:'-';
        $model->doktermerawat = $modAdmisi->dokter->namaLengkap;
        $model->tgl_tambahuangmuka = date("Y-m-d", strtotime($modAdmisi->tgladmisi.'+2 hours'));
        
        $diagnosa = LaporantindaklanjutrjV::model()->findByAttributes([
            'pendaftaran_id' => $modDaftar->pendaftaran_id
        ]);
        $model->diagnosa_nama = !empty($diagnosa)?$diagnosa->diagnosa_nama:'-';
        
        $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $model->pihakpertama = $peg->namaLengkap;
        
        
        
        
        $modPj = PenanggungjawabM::model()->findByPk($modDaftar->penanggungjawab_id);
        if (!empty($modPj)){
            $model->pihakkedua = $model->nama_pj = $modPj->nama_pj;
            if (!empty($modPj->tgllahir_pj)){
                $pecah = (explode(' ',CustomFunction::getUmur($modPj->tgllahir_pj)));
                $model->umur_pj = !empty($modPj->tgllahir_pj)?$pecah[0].' tahun':'';
            }
            $model->pekerjaan_pj = '-';
            $model->alamat_pj = $modPj->alamat_pj;
            $model->no_telponpj = !empty($modPj->no_teleponpj)?$modPj->no_teleponpj:$modPj->no_mobilepj;
            $model->jenisidentitas_pj = $modPj->jenisidentitas;
            $model->no_identitas = $modPj->no_identitas;
            $model->hubungankeluarga = $modPj->hubungankeluarga;
            $model->jeniskelamin_pj = $modPj->jeniskelamin;
        }        
                
        if (isset($_POST['SuratakadijarahT'])){
            $post = $_POST['SuratakadijarahT'];
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                
                $post = array_merge($post, [
                    'pasien_id'=>$modAdmisi->pasien_id,
                    'pendaftaran_id'=>$modAdmisi->pendaftaran_id,
                    'penanggungjawab_id'=>$modDaftar->penanggungjawab_id,
                    'ruang_id'=>$modAdmisi->ruangan_id,
                    'dokter_dpjp1'=>$modAdmisi->pegawai_id,
                    'namapegawai_id'=>$peg->pegawai_id
                ]);

                $proses = SuratakadijarahT::simpanData($model, $post);
                $ok &= $proses['sukses'];
                
                if ($ok){                                                            
                    Yii::app()->user->setFlash('success', "Data berhasil gagal disimpan ! ");
                    $trans->commit();
                    
                    $this->redirect(['index','pasienadmisi_id'=>$pasienadmisi_id,'sukses'=>1]);
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
        
        $model = SuratakadijarahT::model()->findByPk($id);       
        
        $model->loadInput();
        
        $this->render('print', array(
            'model'=>$model
        ));
    }
}
