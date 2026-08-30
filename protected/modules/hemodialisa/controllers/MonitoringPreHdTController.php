<?php
Yii::import('laboratorium.controllers.PencatatanHasilPemeriksaanController');
Yii::import('laboratorium.models.LBPasienMasukPenunjangV');
Yii::import('laboratorium.models.LBHasilPemeriksaanLabT');
Yii::import('laboratorium.models.LBDetailHasilPemeriksaanLabT');

/**
 * controller utama untuk mengakses menu monitoring pre hemodialisa
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.hemodialisa
 * @subpackage controllers
 */
class MonitoringPreHdTController extends MyAuthController {

    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $simpanpemeriksaanfisik = false;
    public $simpanpemeriksaangambar = true;
    public $asesmenawalmedissimpansimpan = true; //dilooping
    public $riwayatobatsimpan = true; //looping
    public $path_view = 'hemodialisa.views.monitoringPreHdT.';

    /**
     * Action utama ini, digunakan sebagai default untuk masuk ke menu monitoring pre hemodialisa
     * @param type $pendaftaran_id
     * @param type $id
     * @param type $salin_id
     */
    public function actionIndex($pendaftaran_id, $id = null, $salin_id = null, $konsulpoli_id=null) {
        $this->layout = '//layouts/iframe';
        $pasienadmisi_id = (isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null);

        $format = new MyFormatter();
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        $model = new MonitoringPreHdT();       
        $model->pasien_id = $modPasien->pasien_id; 
        $model->waktu = $format::formatDateTimeForUser(date('Y-m-d H:i:s'));
        $model->dpjp_id = !empty($modPendaftaran) ? $modPendaftaran->pegawai_id : null;
        $model->dpjp_nama = !empty($modPendaftaran) ? $modPendaftaran->pegawai->namaLengkap : null;
        $model->gol_darah = !empty($modPasien) ? $modPasien->golongandarah : null;
        $cekJadwalHD = JadwalhemodialisaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $model->hemodialisis_ke = !empty($cekJadwalHD) ? $cekJadwalHD->jadwalhemodialisa_ke : null;
        

        $cekPerawat = PegawaiM::model()->findByAttributes(array('pegawai_id' => Yii::app()->user->getState('pegawai_id'), 'kelompokpegawai_id' => 2));
        $model->perawat1_nama = !empty($cekPerawat) ? $cekPerawat->namaLengkap : '';
        $model->perawat1_id = !empty($cekPerawat) ? $cekPerawat->pegawai_id : '';

        $cekMonitoringPostHd = MonitoringPostHdT::model()->findByAttributes(array('pasien_id' => $model->pasien_id), array('order' => 'create_time DESC'));
        $cekMonitoringPreHd = MonitoringPreHdT::model()->findByAttributes(array('pasien_id' => $model->pasien_id), array('order' => 'create_time DESC'));
        $model->berat_badan_post_hd = !empty($cekMonitoringPostHd) ? number_format($cekMonitoringPostHd->berat_badan, 2, ",", ".") : number_format(0, 2, ",", ".");
        $model->tinggi_badan = !empty($cekMonitoringPreHd) ? number_format($cekMonitoringPreHd->tinggi_badan, 2, ",", ".") : number_format(0, 2, ",", ".");

        $modPrescription = new PrescriptionHdT;
        $modMonitoringPostHd = new MonitoringPostHdT;
        $modMasalahKeperawatan = new MasalahKeperawatanPreHdT;
        $modIntervensiKeperawatan = new IntervensiKeperawatanPreHdT;
        $modAksesVaskular = new AksesVaskularT;
        $modLabEks = new HasilpemeriksaanlabeksternalT;

        if (!empty($id)) {
            $cek = MonitoringPreHdT::model()->findByPk($id);            
            if (!empty($cek)){
                $model = $cek;
                $model->perawat1_nama = !empty($model->perawat1_id) ? $model->perawat1->namaLengkap : '';
                $model->perawat2_nama = !empty($model->perawat2_id) ? $model->perawat2->namaLengkap : '';
                $model->dpjp_nama = !empty($model->dpjp_id) ? $model->dpjp->namaLengkap : '';
                $model->diagnosa_nama = !empty($model->diagnosa_id) ? $model->diagnosa->diagnosa_nama : '';
            }
        }
        
        if (empty($model->monitoring_pre_hd_id)){            
            $model->pendaftaran_id = $pendaftaran_id;
        }        
        $model->set_akses_vaskular = $model->loadAksesVaskular();  
        $model->set_periksa_internal_lab = $model->loadPemeriksaanLab();
        $model->set_periksa_lab_dari_luar = $model->loadLabPeriksaDariLuar();
        
             

        if (isset($_GET['MonitoringPreHdT'])) {
            $modRiwayatAwalMedis->attributes = $_GET['MonitoringPreHdT'];
        }

        if (isset($_POST['MonitoringPreHdT'])) {
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if (!empty($id)) {
                    $model = MonitoringPreHdT::model()->findByPk($id);
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $model->update_time = date('Y-m-d H:i:s');
                } else {
                    $model = new MonitoringPreHdT();
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date('Y-m-d H:i:s');
                }
                $model->attributes = $_POST['MonitoringPreHdT'];
                $model->waktu = $format->formatDateTimeForDb($_POST['MonitoringPreHdT']['waktu']);
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $ok = $ok && $model->save();

                // Update status periksa 
                $this->ubah_status($pendaftaran_id, $konsulpoli_id);
//                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
//                if ($modPendaftaran->instalasi_id == Params::INSTALASI_ID_HEMODIALISAGRAHA || $modPendaftaran->instalasi_id == Params::INSTALASI_ID_HEMODIALISA) {
//                    $modKonsul = KonsulpoliT::model()->findByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
//                    if (!empty($modKonsul)) {
//                        $modKonsul->statusperiksa = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
//                        $modKonsul->update_time = date("Y-m-d H:i:s");
//                        $modKonsul->update_loginpemakai_id = Yii::app()->user->id;
//                        $ok = $ok && $modKonsul->save();
//                    } else {
//                        $modPendaftaran->status_hd = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
//                        $modPendaftaran->update_time = date("Y-m-d H:i:s");
//                        $modPendaftaran->update_loginpemakai_id = Yii::app()->user->id;
//                        $ok = $ok && $modPendaftaran->save();
//                    }
//                }

                //Akses Vaskular
               if (isset($_POST['AksesVaskularT'])){
                    foreach($_POST['AksesVaskularT'] as $key => $det){
                        $cek = AksesVaskularT::model()->findByPk($det['akses_vaskular_id']);
                        $modAk = new AksesVaskularT;
                        if (!empty($cek)){
                            $modAk = $cek;
                        }
                        $modAk->attributes = $det;
                        
                        $modAk->pendaftaran_id = $model->pendaftaran_id;
                        $modAk->pasien_id = $model->pasien_id;
                        $modAk->monitoring_pre_hd_id = $model->monitoring_pre_hd_id;
                        if ($modAk->nama_akses_vaskular == 'HD Kateter'){
                            if (!empty($modAk->hd_kateter)){
                                $ok &= $modAk->save();                        
                            }
                        }else{
                            $ok &= $modAk->save();                        
                        }
                    }
                }
                
                if (isset($_POST['akses_hapus'])){
                    
                    $cri = new CDbCriteria();
                    $cri->addInCondition('akses_vaskular_id', $_POST['akses_hapus']);
                    
                    AksesVaskularT::model()->deleteAll($cri);
                }
                
                if (isset($_POST['HasilpemeriksaanlabeksternalT'])){
                    foreach($_POST['HasilpemeriksaanlabeksternalT'] as $det){
                        $cek = HasilpemeriksaanlabeksternalT::model()->findByPk($det['hasilpemeriksaanlabeksternal_id']);
                        $modEks = new HasilpemeriksaanlabeksternalT;
                        if (!empty($cek)){
                            $modEks = $cek;
                        }else{
                            $modEks->pendaftaran_id = $model->pendaftaran_id;
                            $modEks->pasien_id = $model->pasien_id;
                            $modEks->pasienadmisi_id = $pasienadmisi_id;
                            $modEks->monitoring_pre_hd_id = $model->monitoring_pre_hd_id;
                        }
                        $modEks->attributes = $det;
                        
                        $modEks->tgl_pemeriksaan = !empty($modEks->tgl_pemeriksaan)?$modEks->tgl_pemeriksaan:null;
                        if (!empty($modEks->hasilpemeriksaanlabeksternal_id)){
                            $modEks->update_time = date('Y-m-d H:i:s');
                            $modEks->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                        }else{
                            $modEks->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                            $modEks->create_time = date('Y-m-d H:i:s');
                            $modEks->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        }
                        
                        $ok &= $modEks->save();                                                
                    }
                }
                
                if (isset($_POST['hasileks_hapus'])){
                    $cri = new CDbCriteria();
                    $cri->addInCondition('hasilpemeriksaanlabeksternal_id', $_POST['hasileks_hapus']);
                    
                    HasilpemeriksaanlabeksternalT::model()->deleteAll($cri);
                }

                //Masalah Keperawatan
                if (isset($_POST['MasalahKeperawatanPreHdT'])) {
                    if (count($_POST['MasalahKeperawatanPreHdT']) > 0) {
                        foreach ($_POST['MasalahKeperawatanPreHdT'] as $key => $value) {
                            if (!empty($value['is_ceklis'])) {
                                $modMasalahKeperawatan = new MasalahKeperawatanPreHdT;
                                $modMasalahKeperawatan->attributes = $value;
                                $modMasalahKeperawatan->monitoring_pre_hd_id = $model->monitoring_pre_hd_id;
                                $modMasalahKeperawatan->pendaftaran_id = $pendaftaran_id;
                                $modMasalahKeperawatan->pasien_id = $modPasien->pasien_id;
                                $modMasalahKeperawatan->create_loginpemakai_id = Yii::app()->user->id;
                                $modMasalahKeperawatan->ruangan_id = Yii::app()->user->getState('ruangan_id');
                                $modMasalahKeperawatan->create_time = date('Y-m-d H:i:s');
                                $ok = $ok && $modMasalahKeperawatan->save();
                            }
                        }
                    }

                    if (!empty($_POST['MasalahKeperawatanPreHdT']['lainnya'])) {
                        $modMasalahKeperawatanLain = new MasalahKeperawatanPreHdT;
                        $modMasalahKeperawatanLain->nama_masalah_keperawatan = $_POST['MasalahKeperawatanPreHdT']['lainnya']['nama_masalah_keperawatan_lainnya'];
                        $modMasalahKeperawatanLain->monitoring_pre_hd_id = $model->monitoring_pre_hd_id;
                        $modMasalahKeperawatanLain->pendaftaran_id = $pendaftaran_id;
                        $modMasalahKeperawatanLain->pasien_id = $modPasien->pasien_id;
                        $modMasalahKeperawatanLain->create_loginpemakai_id = Yii::app()->user->id;
                        $modMasalahKeperawatanLain->ruangan_id = Yii::app()->user->getState('ruangan_id');
                        $modMasalahKeperawatanLain->create_time = date('Y-m-d H:i:s');
                        $ok = $ok && $modMasalahKeperawatanLain->save();
                    }
                }

                //Intervensi Keperawatan
                if (isset($_POST['IntervensiKeperawatanPreHdT'])) {
                    if (count($_POST['IntervensiKeperawatanPreHdT']) > 0) {
                        foreach ($_POST['IntervensiKeperawatanPreHdT'] as $key => $value) {
                            if (!empty($value['is_ceklis'])) {
                                $modIntervensiKeperawatan = new IntervensiKeperawatanPreHdT;
                                $modIntervensiKeperawatan->attributes = $value;
                                $modIntervensiKeperawatan->monitoring_pre_hd_id = $model->monitoring_pre_hd_id;
                                $modIntervensiKeperawatan->pendaftaran_id = $pendaftaran_id;
                                $modIntervensiKeperawatan->pasien_id = $modPasien->pasien_id;
                                $modIntervensiKeperawatan->create_loginpemakai_id = Yii::app()->user->id;
                                $modIntervensiKeperawatan->ruangan_id = Yii::app()->user->getState('ruangan_id');
                                $modIntervensiKeperawatan->create_time = date('Y-m-d H:i:s');
                                $ok = $ok && $modIntervensiKeperawatan->save();
                            }
                        }
                    }

                    if (!empty($_POST['IntervensiKeperawatanPreHdT']['lainnya'])) {
                        $modIntervensiKeperawatanLain = new IntervensiKeperawatanPreHdT;
                        $modIntervensiKeperawatanLain->nama_intervensi_keperawatan_pre = $_POST['IntervensiKeperawatanPreHdT']['lainnya']['nama_intervensi_keperawatan_pre_lainnya'];
                        $modIntervensiKeperawatanLain->monitoring_pre_hd_id = $model->monitoring_pre_hd_id;
                        $modIntervensiKeperawatanLain->pendaftaran_id = $pendaftaran_id;
                        $modIntervensiKeperawatanLain->pasien_id = $modPasien->pasien_id;
                        $modIntervensiKeperawatanLain->create_loginpemakai_id = Yii::app()->user->id;
                        $modIntervensiKeperawatanLain->ruangan_id = Yii::app()->user->getState('ruangan_id');
                        $modIntervensiKeperawatanLain->create_time = date('Y-m-d H:i:s');
                        $ok = $ok && $modIntervensiKeperawatanLain->save();
                    }
                }

                $t = true;
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
                    $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'id' => $model->monitoring_pre_hd_id, 'sukses' => 1,'konsulpoli_id'=>$konsulpoli_id));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan !");
                    if (!(isset($_POST['IntervensiKeperawatanPreHdT']))) {
                        Yii::app()->user->setFlash('error', 'Silakan pilih minimal 1 intervensi keperawatan');
                    }
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data pemakaian Bahan gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modPrescription' => $modPrescription,
            'modMonitoringPostHd' => $modMonitoringPostHd,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modMasalahKeperawatan' => $modMasalahKeperawatan,
            'modIntervensiKeperawatan' => $modIntervensiKeperawatan,
            'modAksesVaskular' => $modAksesVaskular,
            'modLabEks'=>$modLabEks
        ));
    }
    
    public function ubah_status($pendaftaran_id, $konsulpoli_id){
        $pen = PendaftaranT::model()->findByPk($pendaftaran_id);
        $pen->status_hd = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
        $pen->save();
        
        $konsul = KonsulpoliT::model()->findByPk($konsulpoli_id);
        
        if (!empty($konsul)){            
            if (in_array($konsul->poliasal->instalasi_id, RuanganrawatinapV::loadInstalasi())){
                $konsul->statusperiksa = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                $konsul->save();
            }
        }                
    }

    /**
     * Autocomplete perawat
     */
    public function actionAutocompletePerawat() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition('kelompokpegawai_id = 2');
            $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = PegawairuanganV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->namaLengkap;
                $returnVal[$i]['value'] = $model->pegawai_id;
                $returnVal[$i]['pegawai_id'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Load data asesmen nyeri
     */
    public function actionGetDataFromRiwayat() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $model = MonitoringPreHdT::model()->findByPk($id);

            if (isset($model)) {
                $data['status'] = true;
                $data['diagnosa_nama'] = $model->diagnosa->diagnosa_nama;
                $data['diagnosa_id'] = $model->diagnosa_id;
                $data['nomor_mesin'] = $model->nomor_mesin;
                $data['gol_darah'] = $model->gol_darah;
                $data['hemodialisis_ke'] = $model->hemodialisis_ke;
                $data['dialiser'] = $model->dialiser;
                $data['kendala_komunikasi_tidakada'] = $model->kendala_komunikasi_tidakada;
                $data['kendala_komunikasi_ada'] = $model->kendala_komunikasi_ada;
                $data['kendala_komunikasi_keterangan'] = $model->kendala_komunikasi_keterangan;
                $data['alergi_obat_tidak'] = $model->alergi_obat_tidak;
                $data['alergi_obat_ya'] = $model->alergi_obat_ya;
                $data['alergi_obat_keterangan'] = $model->alergi_obat_keterangan;
                $data['hbsag_tidak'] = $model->hbsag_tidak;
                $data['hbsag_ya'] = $model->hbsag_ya;
                $data['hbsag_keterangan'] = $model->hbsag_keterangan;
                $data['hcv_tidak'] = $model->hcv_tidak;
                $data['hcv_ya'] = $model->hcv_ya;
                $data['hcv_keterangan'] = $model->hcv_keterangan;
                $data['hiv_tidak'] = $model->hiv_tidak;
                $data['hiv_ya'] = $model->hiv_ya;
                $data['hiv_keterangan'] = $model->hiv_keterangan;
                $data['kondisi_saat_ini_tenang'] = $model->kondisi_saat_ini_tenang;
                $data['kondisi_saat_ini_gelisah'] = $model->kondisi_saat_ini_gelisah;
                $data['kondisi_saat_ini_takut_tindakan'] = $model->kondisi_saat_ini_takut_tindakan;
                $data['kondisi_saat_ini_marah'] = $model->kondisi_saat_ini_marah;
                $data['kondisi_saat_ini_tersinggung'] = $model->kondisi_saat_ini_tersinggung;
                $data['asesmentnyeri_id'] = $model->asesmentnyeri_id;
            } else {
                $data['status'] = false;
                $data['pesan'] = 'Riwayat Tidak Ditemukan!';
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk menghapus riwayat
     */
    public function actionDeleteriwayat() {
        if (Yii::app()->request->isAjaxRequest) {
            //MonitoringPreHdT
            $id = $_POST['id'];
            $model = MonitoringPreHdT::model()->findByPk($id);            
            $trans = Yii::app()->db->beginTransaction();
            try{
                $cri = new CDbCriteria();
                $cri->addCondition("monitoring_pre_hd_id = '" . $id . "' ");
                $up2 = AksesVaskularT::model()->deleteAll($cri);
                $up1 = MasalahKeperawatanPreHdT::model()->deleteAll($cri);
                $up = IntervensiKeperawatanPreHdT::model()->deleteAll($cri);


                if ($model->delete()) {
                    $trans->commit();
                    $data['status'] = 'sukses';
                } else {
                    $trans->rollback();
                    $data['status'] = 'gagal';
                }
            }catch(Exception $e){
                $trans->rollback();
                $data['status'] = 'gagal';
            }


            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function actionPrintPK($pasienmasukpenunjang_id){        
        
        $con = new PencatatanHasilPemeriksaanController('MonitoringPreHdTController', Yii::app()->getModule('hemodialisa'));
        $frame=1;
        return $con->actionPrint($pasienmasukpenunjang_id,$frame);
    }

    /**
     * 
     * @param type $id
     */
    public function actionPrint($id) {        
        $this->layout = '//layouts/_auto';
        $format = new MyFormatter;         
        
        $model = MonitoringPreHdT::model()->findByAttributes([
            'monitoring_pre_hd_id' => $id
        ]);
        
        $modMasalah = MasalahKeperawatanPreHdT::model()->findAllByAttributes([
            'monitoring_pre_hd_id' => $id
        ]);
        
        $modAkses = AksesVaskularT::model()->findAllByAttributes([
            'monitoring_pre_hd_id' => $id
        ]);
        
        $modIntervensi = IntervensiKeperawatanPreHdT::model()->findAllByAttributes([
            'monitoring_pre_hd_id' => $id
        ]);
        
        $masalah = [];
        foreach($modMasalah as $det){
            $init = trim($det->nama_masalah_keperawatan);
            $masalah[$init] = $init;
        }
        
        $intervensi = [];
        foreach($modIntervensi as $det){
            $init = trim($det->nama_intervensi_keperawatan_pre);
            $intervensi[$init] = $init;
        }
        
        
        $akses = [];
        foreach($modAkses as $det){
            $nama = trim($det->nama_akses_vaskular);
            $htt = trim($det->hd_kateter);
            $akses[$nama]['nama'] = $nama;
            if (!empty($htt)){
                $akses[$nama]['hd'][$htt] = $htt;
            }
        }
              
        $no_dok = 'RM 01 HD';
        $view = 'print/_print';
            
        $judullaporan = 'MONITORING PASIEN HEMODIALISIS';
        $alias = '';
        
        $pasien = $model->pasien;
        
        $data = [
            'judul_laporan' => $judullaporan,
            'no_dok' => $no_dok,
            'alias' => $alias,
            'nama_lengkap' => $pasien->nama_pasien,
            'no_rm' => $pasien->no_rekam_medik,
            'tanggal_lahir' => date('d/m/Y', strtotime($pasien->tanggal_lahir)),
        ];
          
        $model->set_periksa_internal_lab = $model->loadPemeriksaanLab();
        $model->set_periksa_lab_dari_luar = $model->loadLabPeriksaDariLuar();
        
//        echo $this->render($view, array(
//            'format' => $format,
//            'model' => $model,
//            'judullaporan' => $judullaporan,
//            'data' => $data,        
//        ), true);
        //Start MPdf
        $kertas = Params::getUkuranKertas();
        $mpdf = new MyPDF('', $kertas['A4']);
        $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI, '', '', '', '', 15, 10, 7, 5, 15, 15);        
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/global-prinout-pdf.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($this->renderPartial($view, array(
            'format' => $format,
            'model' => $model,
            'modMasalah' => $modMasalah,
            'intervensi' => $intervensi,
            'masalah' => $masalah,
            'akses' => $akses,
            'judullaporan' => $judullaporan,
            'data' => $data,        
        ), true));
        // Saves file on the server as 'filename.pdf'
        $mpdf->Output();
        die;
    }
}
