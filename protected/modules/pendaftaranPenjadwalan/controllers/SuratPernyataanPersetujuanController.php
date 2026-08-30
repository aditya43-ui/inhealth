<?php

class SuratPernyataanPersetujuanController extends MyAuthController
{
    public function actionIndex($pendaftaran_id){
        
        $modDaftar = PendaftaranT::model()->findByPk($pendaftaran_id);
        if (empty($modDaftar)){
            echo 'pasien belum terdaftar';
            exit;
        }
        
        $this->layout = '//layouts/iframe';                
        
        $format = new MyFormatter;
        
        $model = new SuratpersetujuanrdokterT;        
        $modPasien = PasienM::model()->findByPk($modDaftar->pasien_id);
                
        $cek = SuratpersetujuanrdokterT::model()->findByAttributes([
           'pendaftaran_id' => $modDaftar->pendaftaran_id 
        ]);
        if (!empty($cek)){
            $model = $cek;   
            $model->loadInput();
        }else{
            $model->penjamin_nama = $modDaftar->penjamin->penjamin_nama;
            $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));            
            $model->create_loginpemakai_nama = !empty($peg)?$peg->namaLengkap:'';
            $model->pasien_nama = $modPasien->nama_pasien;            
            $model->pasien_jeniskelamin = $modPasien->jeniskelamin;
            $model->pasien_tglmasukrs = $format->formatDateTimeForUser($modDaftar->tgl_pendaftaran);
            $model->pasien_tanggal_lahir = $format->formatDateTimeForUser($modPasien->tanggal_lahir);
            $model->pasien_no_rekam_medik = $modPasien->no_rekam_medik;

            $peg = PegawaiM::model()->findByPk($modDaftar->pegawai_id);
            $model->dokterpenanggungjawab = !empty($peg->namaLengkap)?$peg->namaLengkap:'';

            $modPj = PenanggungjawabM::model()->findByPk($modDaftar->penanggungjawab_id);
            if (!empty($modPj)){                                    
                $model->tandatangan_nama = $modPj->nama_pj;            
                $model->tandatangan_telepon = $modPj->no_teleponpj;
                $model->tandatangan_hubungan = $modPj->hubungankeluarga;
            }        

            $modAsuransi = AsuransipasienM::model()->findByPk($modDaftar->asuransipasien_id);
            if (!empty($modAsuransi)){

            }
            
            $model->kamarruangan_nokamar = !empty($modDaftar->pasienadmisi->kamarruangan)?$modDaftar->pasienadmisi->kamarruangan->kamarruangan_nokamar:'-';
        }         
        
        $umur = CustomFunction::getUmurTahun($modPasien->tanggal_lahir, date('Y-m-d'));
        $model->umur = $umur.' tahun';
                
        if (isset($_POST['SuratpersetujuanrdokterT'])){
            $post = $_POST['SuratpersetujuanrdokterT'];
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                
                $post = array_merge($post, [
                    'tgl_persetujuan'=>date('Y-m-d H:i:s'),
                    'pendaftaran_id'=>$modDaftar->pendaftaran_id,                   
                ]);

                $proses = SuratpersetujuanrdokterT::simpanData($model, $post);
                $ok &= $proses['sukses'];
                
                if ($ok){                                                            
                    Yii::app()->user->setFlash('success', "Data berhasil gagal disimpan ! ");
                    $trans->commit();
                    
                    $this->redirect(['index','pendaftaran_id'=>$pendaftaran_id,'sukses'=>1]);
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
    
    public function actionCetakSurat($id){
        $this->layout = '//layouts/printWindows';
        
        $model = SuratpersetujuanrdokterT::model()->findByPk($id);       
        
        $model->loadInput();
        
        $this->render('print', array(
            'model'=>$model
        ));
    }

    public function actionPrintDPJP($pendaftaran_id = null)
    {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasienAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $pasien_id = (isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien_id : null);
        $modPasien =  PasienM::model()->findByPk($pasien_id);
        $judul_print = 'Kunjungan Rawat Inap';
        $this->render('_printNewDpjp', array(
        'format' => $format,
        'modPasienAdmisi' => $modPasienAdmisi,
        'modPendaftaran' => $modPendaftaran,
        'judul_print' => $judul_print,
        'modPasien' => $modPasien,
        // 'modTindakan' => $modTindakan,
        ));
    }
}
