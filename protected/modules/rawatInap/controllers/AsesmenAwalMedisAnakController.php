<?php

/**
 * controller utama untuk mengakses menu asesmen awal medis anak beserta fungsi - fungsi lainnya

 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 * @package application.modules.rawatInap
 * @subpackage controllers
 */
class AsesmenAwalMedisAnakController extends MyAuthController {

    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $simpanpemeriksaanfisik = false;
    public $simpanpemeriksaangambar = true;
    public $asesmenawalmedissimpansimpan = true; //dilooping
    public $riwayatobatsimpan = true; //looping
    public $path_view = 'rawatInap.views.asesmenAwalMedisAnak.';
    public $init = '';

    /**
     * action utama ini, digunakan sebagai default untuk masuk ke menu asesmen awal medis
     * @param type $id, $dpjp_id
     */
    public function actionIndex($id = null, $dpjp_id = null)  {
        $this->layout = '//layouts/iframe';
        $pendaftaran_id = (isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null);
        $pasienadmisi_id = (isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null);
        $asesmenawalmedis_id = (isset($_GET['asesmenawalmedis_id']) ? $_GET['asesmenawalmedis_id'] : null);
        $salin_id = (isset($_GET['salin_id']) ? $_GET['salin_id'] : null);
        $id = (isset($_GET['id']) ? $_GET['id'] : null);
        $format = new MyFormatter();
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        
        
        if (!empty($id)) {      
            $modAsesmenAwalMedis = RIAsesmenAwalMedisT::model()->findByPk($id);
            $modAsesmenAwalMedis->konsultan_nefrologi_nama = $modAsesmenAwalMedis->konsultan_nefrologi_id;
            if(!empty($modAsesmenAwalMedis->konsultan_nefrologi_id)){
                $modAsesmenAwalMedis->konsultan_nefrologi_nama = $modAsesmenAwalMedis->konsultannefrologi->nama_pegawai;
            }
            
            if(!empty($modAsesmenAwalMedis->diagnosa_id)){
                $modAsesmenAwalMedis->diagnosa_nama = $modAsesmenAwalMedis->diagnosa->diagnosa_nama;
            }
            if(!empty($modAsesmenAwalMedis->bodymassindex_id)){
                $modAsesmenAwalMedis->bodymassindex_nama = $modAsesmenAwalMedis->bodymassaindex->bmi_defenisi;
            }
            
            $modPemeriksaanGambar= RIPemeriksaangambarawalmedisT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'asesmen_awal_medis_id'=>$modAsesmenAwalMedis->asesmen_awal_medis_id));
            $modRiwayatObatSblm = RIRiwayatobatsebelumnyaT::model()->findAllByAttributes(array('asesmen_awal_medis_id'=>$modAsesmenAwalMedis->asesmen_awal_medis_id));
            $modAsesmenAwalMedis->dokterpemeriksa_id = $modPendaftaran->pegawai_id;
            $modAsesmenAwalMedis->dokterpemeriksa_nama = $modPendaftaran->pegawai->nama_pegawai;
            
            $modAsesmenAwalMedis->ruangan_asal_id = $modPendaftaran->ruangan_id;
            $modAsesmenAwalMedis->ruangan_asal_nama = $modPendaftaran->ruangan->ruangan_nama;
            $modAsesmenAwalMedis->masalah_perkawinan_keterangan_1 = (!empty($modAsesmenAwalMedis->masalah_perkawinan_keterangan)) ? $modAsesmenAwalMedis->masalah_perkawinan_keterangan : "";
            
            
            $modPasienMorbiditas = PasienmorbiditasT::model()->find('asesmen_awal_medis_id = '.$modAsesmenAwalMedis->asesmen_awal_medis_id);
            if(!empty($modPasienMorbiditas->diagnosa_id)){
                $modPasienMorbiditas->diagnosa_nama = $modPasienMorbiditas->diagnosa->diagnosa_nama;
                $modPasienMorbiditas->diagnosa_kode = $modPasienMorbiditas->diagnosa->diagnosa_kode;
                $modPasienMorbiditas->diagnosa_nama1 = $modPasienMorbiditas->diagnosa->diagnosa_nama;
            }
//            print_r($modPasienMorbiditas);die;
            if(empty($modPasienMorbiditas)){
                $modPasienMorbiditas = new PasienmorbiditasT(); 
                $modPasienMorbiditas->diagnosa_id = '';
                $modPasienMorbiditas->diagnosa_nama = '';
                $modPasienMorbiditas->tglmorbiditas = '';
                $modPasienMorbiditas->kelompokdiagnosa_id = '';
                $modPasienMorbiditas->kasusdiagnosa = '';
                $modPasienMorbiditas->diagnosa_kode = '';
                $modPasienMorbiditas->diagnosa_nama1 = '';
                $modPasienMorbiditas->tglmorbiditas = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
            }else{
                $diagnosa = DiagnosaM::model()->findByPk($modPasienMorbiditas->diagnosa_id);
//                print_r($diagnosa);die;
            }
        } else {
            $modAsesmenAwalMedis = new RIAsesmenAwalMedisT();
            $modPasienMorbiditas = new PasienmorbiditasT();
            $modPasienMorbiditas->tglmorbiditas = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
            if(empty($dpjp_id)) {
                $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                $modAsesmenAwalMedis->dokterdpjp_nama = $modPegawai->namaLengkap;
                $modAsesmenAwalMedis->dokterdpjp_id = $modPegawai->pegawai_id;

            }else{
                $modAsesmenAwalMedis = RIAsesmenAwalMedisT::model()->findByPk($dpjp_id);
            }  
            $modAsesmenAwalMedis->ppds_nama = $modAsesmenAwalMedis->dokterdpjp_nama;
            $modAsesmenAwalMedis->ppds_id = $modAsesmenAwalMedis->dokterdpjp_id;
            
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
            
            $pasienmasukpenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            $pasienmasukpenunjang_id = isset($pasienmasukpenunjang['ruanganasal_id']) ? $pasienmasukpenunjang['ruanganasal_id'] : null;
            $ruanganasal = RuanganM::model()->findByPk($pasienmasukpenunjang_id);
            
            $modAsesmenAwalMedis->dokterpemeriksa_id = $modPendaftaran->pegawai_id;
            $modAsesmenAwalMedis->dokterpemeriksa_nama = $modPendaftaran->pegawai->nama_pegawai;
            
            $modAsesmenAwalMedis->ruangan_asal_id = $modPendaftaran->ruangan_id;
            $modAsesmenAwalMedis->ruangan_asal_nama = $modPendaftaran->ruangan->ruangan_nama;
                
            $modPemeriksaanGambar= null;
            $modRiwayatObatSblm = new RIRiwayatobatsebelumnyaT();
            //$this->actionSetFormRiwayatObat();
        }
        
        if (!empty($pendaftaran_id) && empty($id)) {
            $cekAsesmenMedis = RIAsesmenAwalMedisT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasien_id' => $modPendaftaran->pasien_id), array('order' => 'tgl_pemeriksaan DESC'));
            if (!empty($cekAsesmenMedis)) {
                $modAsesmenAwalMedis = $cekAsesmenMedis;
                $modPemeriksaanGambar= RIPemeriksaangambarawalmedisT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'asesmen_awal_medis_id'=>$modAsesmenAwalMedis->asesmen_awal_medis_id));
                $modRiwayatObatSblm = RIRiwayatobatsebelumnyaT::model()->findAllByAttributes(array('asesmen_awal_medis_id'=>$modAsesmenAwalMedis->asesmen_awal_medis_id));
                $modAsesmenAwalMedis->diagnosa_nama = !empty($modAsesmenAwalMedis->diagnosa_id) ? $cekAsesmenMedis->diagnosa->diagnosa_nama : "";
                
                $modAsesmenAwalMedis->dokterpemeriksa_id = $modPendaftaran->pegawai_id;
                $modAsesmenAwalMedis->dokterpemeriksa_nama = $modPendaftaran->pegawai->nama_pegawai;

                $modAsesmenAwalMedis->ruangan_asal_id = $modPendaftaran->ruangan_id;
                $modAsesmenAwalMedis->ruangan_asal_nama = $modPendaftaran->ruangan->ruangan_nama;                
            } else {
                $modAsesmenAwalMedis->atropometri_usia = substr($modPendaftaran->umur, 0, 2);
                $modAsesmenAwalKeperawatan = RIAsesmenAwalKeperawatanT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'asesmen_awal_keperawatan_id DESC'));
                if (!empty($modAsesmenAwalKeperawatan)) {
                    if (!empty($modAsesmenAwalKeperawatan->diagnosa_masuk)) {
                        $criteria = new CDbCriteria();
                        $criteria->compare("LOWER(diagnosa_nama)", strtolower($modAsesmenAwalKeperawatan->diagnosa_masuk), true);
                        $diagnosa = DiagnosaM::model()->find($criteria);
                        if (!empty($criteria)) {
                            if(empty($diagnosa->diagnosa_id)){
                            $modAsesmenAwalMedis->diagnosa_id = $diagnosa->diagnosa_id;
                            $modAsesmenAwalMedis->diagnosa_nama = $diagnosa->diagnosa_nama;
                            }
                        }
                    }
                    $modAsesmenAwalMedis->kesadarankuantitatif_gcs_eye = $modAsesmenAwalKeperawatan->persarafan_gcs_eye;
                    $modAsesmenAwalMedis->kesadarankuantitatif_gcs_verbal = $modAsesmenAwalKeperawatan->persarafan_gcs_verb;
                    $modAsesmenAwalMedis->kesadarankuantitatif_gcs_motorik = $modAsesmenAwalKeperawatan->persarafan_gcs_motorik;
                    $modAsesmenAwalMedis->riwayat_penyakit_sekarang = $modAsesmenAwalKeperawatan->riwayat_kesehatan;                    
                    $modAsesmenAwalMedis->tekanandarah_sistolok = $modAsesmenAwalKeperawatan->sirkulasi_tensi_sistolik;
                    $modAsesmenAwalMedis->tekanandarah_diastolik = $modAsesmenAwalKeperawatan->sirkulasi_tensi_diastolik;
                    $modAsesmenAwalMedis->nadi = $modAsesmenAwalKeperawatan->sirkulasi_nadi;
                    $modAsesmenAwalMedis->pernafasan = $modAsesmenAwalKeperawatan->pernafasan_respiratorrate;
                    $modAsesmenAwalMedis->suhu = $modAsesmenAwalKeperawatan->suhu;
                    
                    $cekAsesmenGizi = RIAsesmenawalgiziT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasien_id' => $modPendaftaran->pasien_id));
                    if (!empty($cekAsesmenGizi)) {
                        
                        $modAsesmenAwalMedis->beratbadan = $cekAsesmenGizi->beratbadan;
                        $modAsesmenAwalMedis->tinggibadan = $cekAsesmenGizi->tinggibadan;
                        $modAsesmenAwalMedis->nilai_bmi = $cekAsesmenGizi->nilai_imt;
                    }
                } else {
                    $cekAsesmenGizi = RIAsesmenawalgiziT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasien_id' => $modPendaftaran->pasien_id));
                    if (!empty($cekAsesmenGizi)) {
                        if (!empty($cekAsesmenGizi->diagnosa_medis)) {
                            $criteria = new CDbCriteria();
                            $criteria->compare("LOWER(diagnosa_nama)", strtolower($cekAsesmenGizi->diagnosa_medis), true);
                            $diagnosa = DiagnosaM::model()->find($criteria);
                            if (!empty($criteria)) {
                                $modAsesmenAwalMedis->diagnosa_id = $diagnosa->diagnosa_id;
                                $modAsesmenAwalMedis->diagnosa_nama = $diagnosa->diagnosa_nama;
                            }
                        }
                        $modAsesmenAwalMedis->tekanandarah_sistolok = $cekAsesmenGizi->tekanandarah_sistolik;
                        $modAsesmenAwalMedis->tekanandarah_diastolik = $cekAsesmenGizi->tekanandarah_diastolik;
                        $modAsesmenAwalMedis->beratbadan = $cekAsesmenGizi->beratbadan;
                        $modAsesmenAwalMedis->tinggibadan = $cekAsesmenGizi->tinggibadan;
                        $modAsesmenAwalMedis->nilai_bmi = $cekAsesmenGizi->nilai_imt;
                    }
                }
            }
        }

        if (isset($modPendaftaran->pasienadmisi_id)) {
            $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $instalasi_asal = $modPendaftaran->instalasi_id;
            if ($instalasi_asal == Params::INSTALASI_ID_RD) {
                $modAsesmenAwalMedis->pasiendari_igd = true;
            } else if ($instalasi_asal == PARAMS::INSTALASI_ID_RJ ) {
                $modAsesmenAwalMedis->pasiendari_irj = true;
            } else {
                $modAsesmenAwalMedis->pasiendari_lainnya = true;
            }
        } else {
            $modPasienAdmisi = new PasienadmisiT();
            $instalasi_asal = '';
        }
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        $modAsesmenAwalMedis->tglmasuk_rs = $format::formatDateTimeForDb(date('Y-m-d H:i:s'));
        $modAsesmenAwalMedis->tgl_pemeriksaan = $format::formatDateTimeForDb(date('Y-m-d H:i:s'));
        
        $modGambarTubuh = new RIGambartubuhM();
        $modBagianTubuh = new RIBagiantubuhM();
        $Riwayatobat = array();

        $modRiwayatAwalMedis = RIAsesmenAwalMedisT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modAsesmenAwalMedis->pasien_id = $modPasien->pasien_id;
        $modAsesmenAwalMedis->set_obat_alkes_pasien = $modAsesmenAwalMedis->loadObatAlkesPasien('daftar_terakhir');
        $modAsesmenAwalMedis->set_riwayat_obat_sebelum = $modAsesmenAwalMedis->loadRiwayatObatSebelum();
        $modAsesmenAwalMedis->set_periksa_lab_dari_luar = $modAsesmenAwalMedis->loadLabPeriksaDariLuar();
        $modAsesmenAwalMedis->set_akses_vaskular = $modAsesmenAwalMedis->loadAksesVaskular();
        $modAsesmenAwalMedis->riwayat_sakit_skr_tidakada = true;        
        $modVas = new AksesVaskularT;
        $modLabEks = new HasilpemeriksaanlabeksternalT;
        
        if (isset($_GET['RIAsesmenAwalMedisT'])) {
            $modRiwayatAwalMedis->attributes = $_GET['RIAsesmenAwalMedisT'];
            if(empty($modRiwayatAwalMedis->atropometri_beratbadan2)){
                $modRiwayatAwalMedis->atropometri_beratbadan2 = $modRiwayatAwalMedis->atropometri_beratbadan;
            }
            if(empty($modRiwayatAwalMedis->atropometri_tinggibadan2)) {
                $modRiwayatAwalMedis->atropometri_tinggibadan2 = $modRiwayatAwalMedis->atropometri_tinggibadan;
            }
        }

        if (isset($_POST['RIAsesmenAwalMedisT'])) {
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if(!empty($id) && empty($salin_id)){
                    $modAsesmenAwalMedis = RIAsesmenAwalMedisT::model()->findByPk($id);
                    
                }else{
                    $modAsesmenAwalMedis = new RIAsesmenAwalMedisT();
                    
                }
                $modAsesmenAwalMedis->attributes = $_POST['RIAsesmenAwalMedisT'];
                
                $modAsesmenAwalMedis->tgl_pemeriksaan = MyFormatter::formatDateTimeForDb($_POST['RIAsesmenAwalMedisT']['tgl_pemeriksaan']);
                $modAsesmenAwalMedis->dialisis_pertama_pada = !empty($modAsesmenAwalMedis->dialisis_pertama_pada) ? $format->formatDateTimeForDb($modAsesmenAwalMedis->dialisis_pertama_pada) : null;
                if (!empty($modAsesmenAwalMedis->tglmasuk_rs)) {
                    $modAsesmenAwalMedis->tglmasuk_rs = $format->formatDateTimeForDb($_POST['RIAsesmenAwalMedisT']['tglmasuk_rs']);
                }
                $modAsesmenAwalMedis->pendaftaran_id = $pendaftaran_id;
                $modAsesmenAwalMedis->pasien_id = $modPasien->pasien_id;
                $modAsesmenAwalMedis->riwayat_nutrisi_asi_eksklusif = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_asi_eksklusif']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_asi_eksklusif'] : '';
                $modAsesmenAwalMedis->konsultan_nefrologi_id = isset($_POST['RIAsesmenAwalMedisT']['konsultan_nefrologi_id']) ? $_POST['RIAsesmenAwalMedisT']['konsultan_nefrologi_id'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_asi_durasi = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_asi_durasi']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_asi_durasi'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_asi_frekuensi = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_asi_frekuensi']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_asi_frekuensi'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_susuformula_usia = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_susuformula_usia']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_susuformula_usia'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_susuformula_frekuensi = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_susuformula_frekuensi']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_susuformula_frekuensi'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_bubutsusu_usia = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_bubutsusu_usia']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_bubutsusu_usia'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_bubursusu_frekuensi = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_bubursusu_frekuensi']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_bubursusu_frekuensi'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_nasitim_usia = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_nasitim_usia']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_nasitim_usia'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_nasitim_frekuensi = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_nasitim_frekuensi']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_nasitim_frekuensi'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_makanandewasa_usia = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_makanandewasa_usia']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_makanandewasa_usia'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_makanandewasa_frekuensi = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_makanandewasa_frekuensi']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_makanandewasa_frekuensi'] : '';
                $modAsesmenAwalMedis->riwayat_persalinan_beratbadan = isset($_POST['RIAsesmenAwalMedisT']['riwayat_persalinan_beratbadan']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_persalinan_beratbadan'] : '';
                $modAsesmenAwalMedis->riwayat_persalinan_tinggibadan = isset($_POST['RIAsesmenAwalMedisT']['riwayat_persalinan_tinggibadan']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_persalinan_tinggibadan'] : '';
                $modAsesmenAwalMedis->riwayat_persalinan_lingkarkepala = isset($_POST['RIAsesmenAwalMedisT']['riwayat_persalinan_lingkarkepala']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_persalinan_lingkarkepala'] : '';
                $modAsesmenAwalMedis->beratbadan = isset($_POST['RIAsesmenAwalMedisT']['beratbadan']) ? $_POST['RIAsesmenAwalMedisT']['beratbadan'] : '';
                $modAsesmenAwalMedis->tinggi_badan = isset($_POST['RIAsesmenAwalMedisT']['tinggi_badan']) ? $_POST['RIAsesmenAwalMedisT']['tinggi_badan'] : '';
                $modAsesmenAwalMedis->tinggibadan = isset($_POST['RIAsesmenAwalMedisT']['tinggibadan']) ? $_POST['RIAsesmenAwalMedisT']['tinggibadan'] : '';
                $modAsesmenAwalMedis->suhu = isset($_POST['RIAsesmenAwalMedisT']['suhu']) ? $_POST['RIAsesmenAwalMedisT']['suhu'] : '';
                $modAsesmenAwalMedis->luasbadan = isset($_POST['RIAsesmenAwalMedisT']['luasbadan']) ? $_POST['RIAsesmenAwalMedisT']['luasbadan'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_asi_eksklusif = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_asi_eksklusif']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_asi_eksklusif'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_asi_durasi = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_asi_durasi']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_asi_durasi'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_asi_frekuensi = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_asi_frekuensi']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_asi_frekuensi'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_susuformula_usia = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_susuformula_usia']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_susuformula_usia'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_susuformula_frekuensi = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_susuformula_frekuensi']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_susuformula_frekuensi'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_bubutsusu_usia = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_bubutsusu_usia']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_bubutsusu_usia'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_bubursusu_frekuensi = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_bubursusu_frekuensi']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_bubursusu_frekuensi'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_nasitim_usia = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_nasitim_usia']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_nasitim_usia'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_nasitim_frekuensi = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_nasitim_frekuensi']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_nasitim_frekuensi'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_makanandewasa_usia = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_makanandewasa_usia']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_makanandewasa_usia'] : '';
                $modAsesmenAwalMedis->riwayat_nutrisi_makanandewasa_frekuensi = isset($_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_makanandewasa_frekuensi']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_nutrisi_makanandewasa_frekuensi'] : '';
                $modAsesmenAwalMedis->riwayat_persalinan_beratbadan = isset($_POST['RIAsesmenAwalMedisT']['riwayat_persalinan_beratbadan']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_persalinan_beratbadan'] : '';
                $modAsesmenAwalMedis->riwayat_persalinan_tinggibadan = isset($_POST['RIAsesmenAwalMedisT']['riwayat_persalinan_tinggibadan']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_persalinan_tinggibadan'] : '';
                $modAsesmenAwalMedis->riwayat_persalinan_lingkarkepala = isset($_POST['RIAsesmenAwalMedisT']['riwayat_persalinan_lingkarkepala']) ? $_POST['RIAsesmenAwalMedisT']['riwayat_persalinan_lingkarkepala'] : '';
                $modAsesmenAwalMedis->atropometri_beratbadan = isset($_POST['RIAsesmenAwalMedisT']['atropometri_beratbadan']) ? $_POST['RIAsesmenAwalMedisT']['atropometri_beratbadan'] : '';
                $modAsesmenAwalMedis->atropometri_tinggibadan = isset($_POST['RIAsesmenAwalMedisT']['atropometri_tinggibadan']) ? $_POST['RIAsesmenAwalMedisT']['atropometri_tinggibadan'] : '';
                if (!empty($_POST['RIAsesmenAwalMedisT']['atropometri_beratbadan2'])) {
                    $modAsesmenAwalMedis->atropometri_beratbadan2 = !empty($_POST['RIAsesmenAwalMedisT']['atropometri_beratbadan2']) ? $_POST['RIAsesmenAwalMedisT']['atropometri_beratbadan2'] : null;
                } else {
                    $modAsesmenAwalMedis->atropometri_beratbadan = !empty($_POST['RIAsesmenAwalMedisT']['atropometri_beratbadan']) ? $_POST['RIAsesmenAwalMedisT']['atropometri_beratbadan'] : null;
                }
                if (!empty($_POST['RIAsesmenAwalMedisT']['atropometri_tinggibadan2'])) {
                    $modAsesmenAwalMedis->atropometri_tinggibadan = !empty($_POST['RIAsesmenAwalMedisT']['atropometri_tinggibadan']) ? $_POST['RIAsesmenAwalMedisT']['atropometri_tinggibadan'] : null;
                } else {
                    $modAsesmenAwalMedis->atropometri_tinggibadan2 = !empty($_POST['RIAsesmenAwalMedisT']['atropometri_tinggibadan2']) ? $_POST['RIAsesmenAwalMedisT']['atropometri_tinggibadan2'] : null;
                }
                $modAsesmenAwalMedis->atropometri_usia = isset($_POST['RIAsesmenAwalMedisT']['atropometri_usia']) ? $_POST['RIAsesmenAwalMedisT']['atropometri_usia'] : '';
                $modAsesmenAwalMedis->atropometri_beratbadanideal = isset($_POST['RIAsesmenAwalMedisT']['atropometri_beratbadanideal']) ? $_POST['RIAsesmenAwalMedisT']['atropometri_beratbadanideal'] : '';
                $modAsesmenAwalMedis->atropometri_statusnutris = isset($_POST['RIAsesmenAwalMedisT']['atropometri_statusnutris']) ? $_POST['RIAsesmenAwalMedisT']['atropometri_statusnutris'] : '';
                $modAsesmenAwalMedis->atropometri_lingkarkepala = isset($_POST['RIAsesmenAwalMedisT']['atropometri_lingkarkepala']) ? $_POST['RIAsesmenAwalMedisT']['atropometri_lingkarkepala'] : '';
                $modAsesmenAwalMedis->atropometri_lingkardada = isset($_POST['RIAsesmenAwalMedisT']['atropometri_lingkardada']) ? $_POST['RIAsesmenAwalMedisT']['atropometri_lingkardada'] : '';
                $modAsesmenAwalMedis->atropometri_lingkarlenganatas = isset($_POST['RIAsesmenAwalMedisT']['atropometri_lingkarlenganatas']) ? $_POST['RIAsesmenAwalMedisT']['atropometri_lingkarlenganatas'] : '';
                //$modAsesmenAwalMedis->diagnosisawal = isset($_POST['RIAsesmenAwalMedisT']['diagnosisawal']) ? $_POST['RIAsesmenAwalMedisT']['diagnosisawal'] : '';
                
                
                $modAsesmenAwalMedis->pemeriksaanlab_hb = isset($_POST['RIAsesmenAwalMedisT']['pemeriksaanlab_hb']) ? $_POST['RIAsesmenAwalMedisT']['pemeriksaanlab_hb'] : '';
                $modAsesmenAwalMedis->pemeriksaanlab_k = isset($_POST['RIAsesmenAwalMedisT']['pemeriksaanlab_k']) ? $_POST['RIAsesmenAwalMedisT']['pemeriksaanlab_k'] : '';
                $modAsesmenAwalMedis->pemeriksaanlab_bun = isset($_POST['RIAsesmenAwalMedisT']['pemeriksaanlab_bun']) ? $_POST['RIAsesmenAwalMedisT']['pemeriksaanlab_bun'] : '';
                $modAsesmenAwalMedis->pemeriksaanlab_na = isset($_POST['RIAsesmenAwalMedisT']['pemeriksaanlab_na']) ? $_POST['RIAsesmenAwalMedisT']['pemeriksaanlab_na'] : '';
                $modAsesmenAwalMedis->pemeriksaanlab_sk = isset($_POST['RIAsesmenAwalMedisT']['pemeriksaanlab_sk']) ? $_POST['RIAsesmenAwalMedisT']['pemeriksaanlab_sk'] : '';
                $modAsesmenAwalMedis->pemeriksaanlab_p = isset($_POST['RIAsesmenAwalMedisT']['pemeriksaanlab_p']) ? $_POST['RIAsesmenAwalMedisT']['pemeriksaanlab_p'] : '';
                $modAsesmenAwalMedis->pemeriksaanlab_ca = isset($_POST['RIAsesmenAwalMedisT']['pemeriksaanlab_ca']) ? $_POST['RIAsesmenAwalMedisT']['pemeriksaanlab_ca'] : '';
                $modAsesmenAwalMedis->pemeriksaanlab_cl = isset($_POST['RIAsesmenAwalMedisT']['pemeriksaanlab_cl']) ? $_POST['RIAsesmenAwalMedisT']['pemeriksaanlab_cl'] : '';
                $modAsesmenAwalMedis->no_status_dialisis = isset($_POST['RIAsesmenAwalMedisT']['no_status_dialisis']) ? $_POST['RIAsesmenAwalMedisT']['no_status_dialisis'] : '';
                $modAsesmenAwalMedis->no_status_transpalantasi = isset($_POST['RIAsesmenAwalMedisT']['no_status_transpalantasi']) ? $_POST['RIAsesmenAwalMedisT']['no_status_transpalantasi'] : '';
                $modAsesmenAwalMedis->penanggungjawab_perawatanrumah = isset($_POST['RIAsesmenAwalMedisT']['penanggungjawab_perawatanrumah']) ? $_POST['RIAsesmenAwalMedisT']['penanggungjawab_perawatanrumah'] : '';
                
                $modAsesmenAwalMedis->statusgizi_kehilanganberatbadan = isset($_POST['statusgizi_kehilanganberatbadan']) ? $_POST['statusgizi_kehilanganberatbadan'] : 0;
                $modAsesmenAwalMedis->statusgizi_asupanmakankurang = isset($_POST['statusgizi_asupanmakankurang']) ? $_POST['statusgizi_asupanmakankurang'] : 0;
                $modAsesmenAwalMedis->statusgizi_menderitapenyakitberat = isset($_POST['statusgizi_menderitapenyakitberat']) ? $_POST['statusgizi_menderitapenyakitberat'] : 0;
                $modAsesmenAwalMedis->kebiasaan_merokok = isset($_POST['RIAsesmenAwalMedisT']['kebiasaan_merokok']) ? $_POST['RIAsesmenAwalMedisT']['kebiasaan_merokok'] : 0;
                $modAsesmenAwalMedis->kebiasaan_alkohol = isset($_POST['RIAsesmenAwalMedisT']['kebiasaan_alkohol']) ? $_POST['RIAsesmenAwalMedisT']['kebiasaan_alkohol'] : 0;
                $modAsesmenAwalMedis->kebiasaan_obat = isset($_POST['RIAsesmenAwalMedisT']['kebiasaan_obat']) ? $_POST['RIAsesmenAwalMedisT']['kebiasaan_obat'] : 0;
                $modAsesmenAwalMedis->kebiasaan_obat_keterangan = isset($_POST['RIAsesmenAwalMedisT']['kebiasaan_obat_keterangan']) ? $_POST['RIAsesmenAwalMedisT']['kebiasaan_obat_keterangan'] : '';
                
                $modAsesmenAwalMedis->perilaku_agresif = isset($_POST['RIAsesmenAwalMedisT']['perilaku_agresif']) ? $_POST['RIAsesmenAwalMedisT']['perilaku_agresif'] : 0;
                $modAsesmenAwalMedis->perilaku_tidakkooperatif = isset($_POST['RIAsesmenAwalMedisT']['perilaku_tidakkooperatif']) ? $_POST['RIAsesmenAwalMedisT']['perilaku_tidakkooperatif'] : 0;
                $modAsesmenAwalMedis->masalah_perkawinan_tidak_ada = isset($_POST['RIAsesmenAwalMedisT']['masalah_perkawinan_tidak_ada']) ? $_POST['RIAsesmenAwalMedisT']['masalah_perkawinan_tidak_ada'] : 0;
                $modAsesmenAwalMedis->masalah_perkawinan_ada = isset($_POST['RIAsesmenAwalMedisT']['masalah_perkawinan_ada']) ? $_POST['RIAsesmenAwalMedisT']['masalah_perkawinan_ada'] : 0;
                $modAsesmenAwalMedis->masalah_perkawinan_keterangan = isset($_POST['RIAsesmenAwalMedisT']['masalah_perkawinan_keterangan']) ? $_POST['RIAsesmenAwalMedisT']['masalah_perkawinan_keterangan'] : '';
                $modAsesmenAwalMedis->masalah_perkawinan_keterangan = isset($_POST['RIAsesmenAwalMedisT']['masalah_perkawinan_keterangan_1']) ? $_POST['RIAsesmenAwalMedisT']['masalah_perkawinan_keterangan_1'] : '';
                $modAsesmenAwalMedis->kekerasan_fisik_tidak_ada = isset($_POST['RIAsesmenAwalMedisT']['kekerasan_fisik_tidak_ada']) ? $_POST['RIAsesmenAwalMedisT']['kekerasan_fisik_tidak_ada'] : 0;
                $modAsesmenAwalMedis->kekerasan_fisik_ada = isset($_POST['RIAsesmenAwalMedisT']['kekerasan_fisik_ada']) ? $_POST['RIAsesmenAwalMedisT']['kekerasan_fisik_ada'] : 0;
                $modAsesmenAwalMedis->mencederai_orang_pernah = isset($_POST['RIAsesmenAwalMedisT']['mencederai_orang_pernah']) ? $_POST['RIAsesmenAwalMedisT']['mencederai_orang_pernah'] : 0;
                $modAsesmenAwalMedis->mencederai_orang_tidak_pernah = isset($_POST['RIAsesmenAwalMedisT']['mencederai_orang_tidak_pernah']) ? $_POST['RIAsesmenAwalMedisT']['mencederai_orang_tidak_pernah'] : 0;
                $modAsesmenAwalMedis->trauma_kehidupan_tidak_ada = isset($_POST['RIAsesmenAwalMedisT']['trauma_kehidupan_tidak_ada']) ? $_POST['RIAsesmenAwalMedisT']['trauma_kehidupan_tidak_ada'] : 0;
                $modAsesmenAwalMedis->trauma_kehidupan_ada = isset($_POST['RIAsesmenAwalMedisT']['trauma_kehidupan_ada']) ? $_POST['RIAsesmenAwalMedisT']['trauma_kehidupan_ada'] : 0;
                $modAsesmenAwalMedis->trauma_kehidupan_ada_keterangan = isset($_POST['RIAsesmenAwalMedisT']['trauma_kehidupan_ada_keterangan']) ? $_POST['RIAsesmenAwalMedisT']['trauma_kehidupan_ada_keterangan'] : '';
                $modAsesmenAwalMedis->gangguan_tidur_tidak_ada = isset($_POST['RIAsesmenAwalMedisT']['gangguan_tidur_tidak_ada']) ? $_POST['RIAsesmenAwalMedisT']['gangguan_tidur_tidak_ada'] : 0;
                $modAsesmenAwalMedis->gangguan_tidur_ada = isset($_POST['RIAsesmenAwalMedisT']['gangguan_tidur_ada']) ? $_POST['RIAsesmenAwalMedisT']['gangguan_tidur_ada'] : 0;
                $modAsesmenAwalMedis->konsultasi_psikiater_tidak_ada = isset($_POST['RIAsesmenAwalMedisT']['konsultasi_psikiater_tidak_ada']) ? $_POST['RIAsesmenAwalMedisT']['konsultasi_psikiater_tidak_ada'] : 0;
                $modAsesmenAwalMedis->konsultasi_psikiater_ada = isset($_POST['RIAsesmenAwalMedisT']['konsultasi_psikiater_ada']) ? $_POST['RIAsesmenAwalMedisT']['konsultasi_psikiater_ada'] : 0;
                $modAsesmenAwalMedis->tempattinggal_rumahpribadi = isset($_POST['RIAsesmenAwalMedisT']['tempattinggal_rumahpribadi']) ? $_POST['RIAsesmenAwalMedisT']['tempattinggal_rumahpribadi'] : 0;
                $modAsesmenAwalMedis->tempattinggal_rumahkeluarga = isset($_POST['RIAsesmenAwalMedisT']['tempattinggal_rumahkeluarga']) ? $_POST['RIAsesmenAwalMedisT']['tempattinggal_rumahkeluarga'] : 0;
                $modAsesmenAwalMedis->tempattinggal_kontrak = isset($_POST['RIAsesmenAwalMedisT']['tempattinggal_kontrak']) ? $_POST['RIAsesmenAwalMedisT']['tempattinggal_kontrak'] : 0;
                $modAsesmenAwalMedis->tempattinggal_panti = isset($_POST['RIAsesmenAwalMedisT']['tempattinggal_panti']) ? $_POST['RIAsesmenAwalMedisT']['tempattinggal_panti'] : 0;
                $modAsesmenAwalMedis->tempattinggal_lainnya = isset($_POST['RIAsesmenAwalMedisT']['tempattinggal_lainnya']) ? $_POST['RIAsesmenAwalMedisT']['tempattinggal_lainnya'] : 0;
                $modAsesmenAwalMedis->tempattinggal_lainnya_keterangan = isset($_POST['RIAsesmenAwalMedisT']['tempattinggal_lainnya_keterangan']) ? $_POST['RIAsesmenAwalMedisT']['tempattinggal_lainnya_keterangan'] : '';
                $modAsesmenAwalMedis->tinggalbersama_suamiistri = isset($_POST['RIAsesmenAwalMedisT']['tinggalbersama_suamiistri']) ? $_POST['RIAsesmenAwalMedisT']['tinggalbersama_suamiistri'] : 0;
                $modAsesmenAwalMedis->tinggalbersama_anak = isset($_POST['RIAsesmenAwalMedisT']['tinggalbersama_anak']) ? $_POST['RIAsesmenAwalMedisT']['tinggalbersama_anak'] : 0;
                $modAsesmenAwalMedis->tinggalbersama_orangtua = isset($_POST['RIAsesmenAwalMedisT']['tinggalbersama_orangtua']) ? $_POST['RIAsesmenAwalMedisT']['tinggalbersama_orangtua'] : 0;
                $modAsesmenAwalMedis->tinggalbersama_sendiri = isset($_POST['RIAsesmenAwalMedisT']['tinggalbersama_sendiri']) ? $_POST['RIAsesmenAwalMedisT']['tinggalbersama_sendiri'] : 0;
                $modAsesmenAwalMedis->tinggalbersama_lainnya = isset($_POST['RIAsesmenAwalMedisT']['tinggalbersama_lainnya']) ? $_POST['RIAsesmenAwalMedisT']['tinggalbersama_lainnya'] : 0;
                $modAsesmenAwalMedis->tinggalbersama_lainnya_keterangan = isset($_POST['RIAsesmenAwalMedisT']['tinggalbersama_lainnya_keterangan']) ? $_POST['RIAsesmenAwalMedisT']['tinggalbersama_lainnya_keterangan'] : '';
                
                $modAsesmenAwalMedis->create_loginpemakai_id = Yii::app()->user->id;
                $modAsesmenAwalMedis->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modAsesmenAwalMedis->create_time = date ('Y-m-d H:i:s');
                $modAsesmenAwalMedis->keluhan_utama = '-';
                $modAsesmenAwalMedis->is_asesmenawalmedisdewasa = False;               
      
                $ok = $ok && $modAsesmenAwalMedis->save();                                                
                
                if (isset($_POST['AksesVaskularT'])){
                    foreach($_POST['AksesVaskularT'] as $key => $det){
                        $cek = AksesVaskularT::model()->findByPk($det['akses_vaskular_id']);
                        $modAk = new AksesVaskularT;
                        if (!empty($cek)){
                            $modAk = $cek;
                        }
                        $modAk->attributes = $det;
                        
                        $modAk->pendaftaran_id = $modAsesmenAwalMedis->pendaftaran_id;
                        $modAk->pasien_id = $modAsesmenAwalMedis->pasien_id;
                        $modAk->asesmen_awal_medis_id = $modAsesmenAwalMedis->asesmen_awal_medis_id;
                        if ($modAk->nama_akses_vaskular == 'HD Kateter'){
                            if (!empty($modAk->hd_kateter)){
                                $ok &= $modAk->save();                        
                            }
                        }else{
                            $ok &= $modAk->save();                        
                        }
                    }
                }


                
                if (isset($_POST['HasilpemeriksaanlabeksternalT'])){
                    foreach($_POST['HasilpemeriksaanlabeksternalT'] as $det){
                        $cek = HasilpemeriksaanlabeksternalT::model()->findByPk($det['hasilpemeriksaanlabeksternal_id']);
                        $modEks = new HasilpemeriksaanlabeksternalT;
                        if (!empty($cek)){
                            $modEks = $cek;
                        }
                        $modEks->attributes = $det;
                        $modEks->pendaftaran_id = $modAsesmenAwalMedis->pendaftaran_id;
                        $modEks->pasien_id = $modAsesmenAwalMedis->pasien_id;
                        $modEks->pasienadmisi_id = $modAsesmenAwalMedis->pasienadmisi_id;
                        $modEks->asesmen_awal_medis_id = $modAsesmenAwalMedis->asesmen_awal_medis_id;
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
                
                if (isset($_POST['obatsebelum_hapus'])){
                    $cri = new CDbCriteria();
                    $cri->addInCondition('riwayatobatsebelumnya_id', $_POST['obatsebelum_hapus']);
                    
                    RiwayatobatsebelumnyaT::model()->deleteAll($cri);
                }
                
                if (isset($_POST['akses_hapus'])){
                    
                    $cri = new CDbCriteria();
                    $cri->addInCondition('akses_vaskular_id', $_POST['akses_hapus']);
                    
                    AksesVaskularT::model()->deleteAll($cri);
                }
                 
                
                if (isset($_POST['RIRiwayatobatsebelumnyaT'])) {                                                                                                              
                    foreach ($_POST['RIRiwayatobatsebelumnyaT'] AS $i => $postDetail) {
                        $cek = RIRiwayatobatsebelumnyaT::model()->findByPk($postDetail['riwayatobatsebelumnya_id']);
                        $modDetails[$i] = new RIRiwayatobatsebelumnyaT;
                        if (!empty($cek)){
                            $modDetails[$i] = $cek;
                        }                        
                        $modDetails[$i]->attributes = $postDetail;
                        $modDetails[$i]->tglpemberian = !empty($modDetails[$i]->tglpemberian)?MyFormatter::formatDateTimeForDb($modDetails[$i]->tglpemberian) : date ('Y-m-d H:i:s');
                        $modDetails[$i]->asesmen_awal_medis_id = $modAsesmenAwalMedis->asesmen_awal_medis_id;
                        $ok &= $modDetails[$i]->save();                       
                    }                                                    					
                }



                if (isset($_POST['RIPemeriksaangambarawalmedisT'])) {
                    if(!empty($id) && empty($salin_id)){
                        $hapusPemeriksaangambarawalmedis = RIPemeriksaangambarawalmedisT::model()->find("asesmen_awal_medis_id = " . $id);
                        if (!empty($hapusPemeriksaangambarawalmedis)) {
                            $ok = $ok && RIPemeriksaangambarawalmedisT::model()->deleteAll("asesmen_awal_medis_id = " . $id);
                        }
                    }
                    foreach ($_POST['RIPemeriksaangambarawalmedisT'] as $gbr => $dtGbr) {
                        $skalanyeri = 0;

                        if (empty($dtGbr['Pemeriksaangambarawalmedis_id'])) {
                            $modLokasi = new RIPemeriksaangambarawalmedisT;
                            $modLokasi->attributes = $_POST['RIPemeriksaangambarawalmedisT'][$gbr];
                            $modLokasi->asesmen_awal_medis_id = $modAsesmenAwalMedis->asesmen_awal_medis_id;
                            $modLokasi->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                            $modLokasi->pasien_id = $modPendaftaran->pasien_id;
                            $modLokasi->tglpemeriksaan = date('Y-m-d H:i:s');
                            $modLokasi->create_time = date('Y-m-d H:i:s');
                            $modLokasi->create_loginpemakai_id = Yii::app()->user->id;
                            $modLokasi->create_ruangan = Yii::app()->user->getState('ruangan_id');

                            $ok = $ok && $modLokasi->save();
                        }
                    }
                }


                
                if(isset($_POST['PasienmorbiditasT'])){
                    // if(!empty($id) && empty($salin_id)){
                    //     $modPasienmorbiditas = PasienmorbiditasT::model()->find("asesmen_awal_medis_id = " . $id);
                        
                    // }else{
                        $modPasienmorbiditas = new PasienmorbiditasT();
                        
                    
                    $modPasienmorbiditas->attributes = $_POST['PasienmorbiditasT'];
                    $modPasienmorbiditas->ruangan_id = Yii::app()->user->getState('ruangan_id');
                    $modPasienmorbiditas->pegawai_id = $modPendaftaran->pegawai_id;
                    $modPasienmorbiditas->pasien_id = $modPendaftaran->pasien_id;
                    $modPasienmorbiditas->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                    $modPasienmorbiditas->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
                    $modPasienmorbiditas->golonganumur_id = $modPendaftaran->golonganumur_id;
                    $modPasienmorbiditas->kelompokumur_id = $modPasien->kelompokumur_id;
                    $modPasienmorbiditas->asesmen_awal_medis_id = $modAsesmenAwalMedis->asesmen_awal_medis_id;

                    
                    $ok = $ok && $modPasienmorbiditas->save();
                    // var_dump($modPasienmorbiditas->errors, $modPasienmorbiditas->attributes); 
                }

                // die;
                
                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
                if ($modPendaftaran->instalasi_id == Params::INSTALASI_ID_HEMODIALISA) {
                    $modKonsul = KonsulpoliT::model()->findByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
                    if (!empty($modKonsul)) {
                        $modKonsul->update_time = date("Y-m-d h:i:s");
                        $modKonsul->statusperiksa = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                        $ok = $ok&& $modKonsul->save(); 
                    } else {
                        $modPendaftaran->update_time = date("Y-m-d h:i:s");
                        $modPendaftaran->status_hd = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                        $ok = $ok && $modPendaftaran->save(); 
                    }
                }

                // var_dump($ok); die;
                if ($ok) {
                    $p = PendaftaranT::model()->findByPk($modAsesmenAwalMedis->pendaftaran_id);
                    $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
                    
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
                    if (!empty($_GET['from'])) {
                        $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'id'=>$modAsesmenAwalMedis->asesmen_awal_medis_id, 'from' => $_GET['from'], 'sukses' => 1, 'update'=>'update'));
                    } else {
                        $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'id'=>$modAsesmenAwalMedis->asesmen_awal_medis_id, 'sukses' => 1, 'update'=>'update'));
                    }
                } else {
                    $transaction->rollback();
//                    Yii::app()->user->setFlash('error', "Data gagal disimpan !");
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($modPasienmorbiditas));
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data pemakaian Bahan gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
            }
        }
        
        $cri = new CDbCriteria();
        $cri->select = "rad.pemeriksaanrad_nama as daftartindakan_nama, t.tglpemeriksaanrad, t.pasienmasukpenunjang_id";
        $cri->join = "JOIN pemeriksaanrad_m rad ON rad.pemeriksaanrad_id = t.pemeriksaanrad_id ";
        $cri->addCondition("t.pasien_id = ".$modPendaftaran->pasien_id);
        $loadHasilPemeriksaanRad = HasilpemeriksaanradT::model()->findAll($cri);
        
        $crit = new CDbCriteria();
        $crit->group = " t.tglhasilpemeriksaanlab, t.pasienmasukpenunjang_id, t.hasilpemeriksaanlab_id ";
        $crit->select = " array_to_string(array_agg(distinct lab.pemeriksaanlab_nama),', ') as daftartindakan_nama, t.tglhasilpemeriksaanlab, t.pasienmasukpenunjang_id, t.hasilpemeriksaanlab_id";
        $crit->join = "LEFT JOIN detailhasilpemeriksaanlab_t b ON t.hasilpemeriksaanlab_id = b.hasilpemeriksaanlab_id ".
                    "LEFT JOIN pemeriksaanlab_m lab ON lab.pemeriksaanlab_id = b.pemeriksaanlab_id";
        $crit->addCondition("t.pasien_id = ".$modPendaftaran->pasien_id);
        $loadHasilPemeriksaanLab = HasilpemeriksaanlabT::model()->findAll($crit);


        $this->render($this->path_view . 'index', array(
            'modAsesmenAwalMedis' => $modAsesmenAwalMedis,
            'modRiwayatAwalMedis' => $modRiwayatAwalMedis,
            'modRiwayatObatSblm' => $modRiwayatObatSblm,
            'modPemeriksaanGambar' => $modPemeriksaanGambar,
            'modGambarTubuh' => $modGambarTubuh,
            'modBagianTubuh' => $modBagianTubuh,
            'modPendaftaran' => $modPendaftaran,
            'modPasienAdmisi' => $modPasienAdmisi,
            'instalasi_asal' => $instalasi_asal,
            'loadHasilPemeriksaanRad' => $loadHasilPemeriksaanRad,
            'loadHasilPemeriksaanLab' => $loadHasilPemeriksaanLab,
            'modPasienMorbiditas'=>$modPasienMorbiditas,
            'modVas'=>$modVas,
            'modLabEks'=>$modLabEks
        ));
    }

    /**
     * set tabel riwayat obat
     */
    public function actionSetFormRiwayatObat() {
        if (Yii::app()->request->isAjaxRequest) {
            $nama_obat = isset($_POST['nama_obat']) ? $_POST['nama_obat'] : '';
            $dosis_obat = isset($_POST['dosis_obat']) ? $_POST['dosis_obat'] : '';
            $carapemberian = isset($_POST['carapemberian']) ? $_POST['carapemberian'] : '';
            $tglpemberian = isset($_POST['tglpemberian']) ? $_POST['tglpemberian'] : '';
            $readonly = isset($_POST['readonly']) ? ($_POST['readonly'] == 1) ? true : false : false;
//            echo $readonly;die;
                    
            $form = "";
            $pesan = "";
            $format = new MyFormatter();
            $modRiwayatobatsebelumnya = new RIRiwayatobatsebelumnyaT;

            $modRiwayatobatsebelumnya->nama_obat = $nama_obat;
            $modRiwayatobatsebelumnya->dosis_obat = $dosis_obat;
            $modRiwayatobatsebelumnya->carapemberian = $carapemberian;
            $modRiwayatobatsebelumnya->tglpemberian = $tglpemberian;

            $form .= $this->renderPartial($this->path_view . '_formAddRiwayatObat', array('modRiwayatobatsebelumnya' => $modRiwayatobatsebelumnya, 'readonly'=>$readonly
                    ), true);
            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }
    

    /**
     * untuk mengenerate secara otomatis, bagian tubuh sesuai koordinat yang dipilih
     */
    public function actionGetBagianTubuhId() {
        if (Yii::app()->request->isAjaxRequest) {
            $pesan = '';
            $data = array();
            $kordinat_x = $_POST['kordinat_x'];
            $kordinat_y = $_POST['kordinat_y'];
            $gambartubuh_id = $_POST['gambartubuh_id'];
//				$loadPemeriskaanGamabr = RJPemeriksaangambarT::model()->findByPk($_POST['pemeriksaangambar_id']);
            $sql = "select bagiantubuh_id, namabagtubuh from bagiantubuh_m where (" .$kordinat_x . " <= kordinat_x4 AND ".$kordinat_x . " >= kordinat_x3 AND ".$kordinat_x . " <= kordinat_x2 AND " . $kordinat_x . " >= kordinat_x) AND (" . $kordinat_y . " <= kordinat_y4 AND ". $kordinat_y . " <= kordinat_y3 AND ". $kordinat_y . " >= kordinat_y AND " . $kordinat_y . " >= kordinat_y2) AND (gambartubuh_id =".$gambartubuh_id.")";
            $result = Yii::app()->db->createCommand($sql)->queryRow();


            if ($result) {
                $data['pesan'] = '';
                $data['namabagtubuh'] = $result['namabagtubuh'];
                $data['bagiantubuh_id'] = $result['bagiantubuh_id'];
                echo json_encode($data);

            } else {
                $pesan = "Bagian tubuh belum disetting!";
                echo CJSON::encode(array('pesan' => $pesan));
            }
        }
        Yii::app()->end();
    }

    /**
     * menambahkan data bagian tubuh yang sudah dipilih, tempat sementara data sebelum disimpan sesuai jumlah data yang ditambahkan
     */
    public function actionTambahBagianTubuh() {
        if (Yii::app()->request->isAjaxRequest) {
            $pesan = '';
            $form = '';
            if (!empty($_POST['bagiantubuh_id'])) {
                $modPemeriksaanGbr = new RIPemeriksaangambarawalmedisT();
                $modPemeriksaanGbr->bagiantubuh_id = $_POST['bagiantubuh_id'];
                $modPemeriksaanGbr->namabagtubuh = $modPemeriksaanGbr->bagiantubuh->namabagtubuh;
                $modPemeriksaanGbr->keterangan_periksa_gbr = $_POST['keterangan'];
                $modPemeriksaanGbr->kordinat_tubuh_x = $_POST['pic_x'];
                $modPemeriksaanGbr->kordinat_tubuh_y = $_POST['pic_y'];
                $modPemeriksaanGbr->gambartubuh_id = $_POST['gambartubuh_id'];
                $form = $this->renderPartial($this->path_view . '_rowDetail', array('modPemeriksaanGbr' => $modPemeriksaanGbr), true);
                $axis['x'] = $modPemeriksaanGbr->kordinat_tubuh_x;
                $axis['y'] = $modPemeriksaanGbr->kordinat_tubuh_y;
                echo CJSON::encode(array('pesan' => $pesan, 'form' => $form, 'axis' => $axis, 'bagiantubuh_id' => $modPemeriksaanGbr->bagiantubuh_id));
            } else {
                $pesan = 'Bagian tubuh tidak boleh kosong!';
                echo CJSON::encode(array('pesan' => $pesan));
            }
        }
        Yii::app()->end();
    }

    /**
     * digunakan untuk menampilkan detail riwayat asesmen awal medis
     * terdapat pada menu pengkajian keperawatan & kebidanan (modul asuhan keperawatan)
     * issue RSST-2176
     * @param type $id
     */
    public function actionLihatRiwayat($id) {
        $modAwalMedis = RIAsesmenAwalMedisT::model()->findByPk($id);
        $modRiwayatObat = RIRiwayatobatsebelumnyaT::model()->findAllByAttributes(array('asesmen_awal_medis_id' => $id));

        $this->render($this->path_view . 'printRiwayat', array(
            'model' => $modAwalMedis,
            'modObat' => $modRiwayatObat,
        ));
    }

    /**
     * Digunakan untuk mencetak asesmen awal medis 
     * @author Andyka Putra <andykaputra@.com>
     * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
     * @param type $id
     */
    public function actionPrint($id) {
        $this->layout = '//layouts/printWindows';
        $model = RIAsesmenAwalMedisT::model()->findByPk($id);
        $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modRiwayatObat = RIRiwayatobatsebelumnyaT::model()->findAllByAttributes(array('asesmen_awal_medis_id' => $id));
        $cekAsesmen = RIAsesmenAwalMedisT::model()->findByAttributes(array('pendaftaran_id' => $id, 'pasien_id' => $modPendaftaran->pasien_id));
        $modGambar = RIPemeriksaangambarawalmedisT::model()->findAllByAttributes(array('asesmen_awal_medis_id' => $id));

        if (!empty($cekAsesmen)) {
            $model = $cekAsesmen;
            $model->dpjp_nama = $model->dpjp->namaLengkap;
            $model->perawat_nama = $model->perawat->namaLengkap;
        }

        $this->render($this->path_view . 'Print', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'modObat' => $modRiwayatObat,
            'modGambar' => $modGambar,
        ));
    }
    
    public function actionPrintAnak($id) {
        $this->layout = '//layouts/printWindows';
        $model = RIAsesmenAwalMedisT::model()->findByPk($id);
        $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modRiwayatObat = RIRiwayatobatsebelumnyaT::model()->findAllByAttributes(array('asesmen_awal_medis_id' => $id));
        $cekAsesmen = RIAsesmenAwalMedisT::model()->findByAttributes(array('pendaftaran_id' => $id, 'pasien_id' => $modPendaftaran->pasien_id));
        $modGambar = RIPemeriksaangambarawalmedisT::model()->findAllByAttributes(array('asesmen_awal_medis_id' => $id));

        if (!empty($cekAsesmen)) {
            $model = $cekAsesmen;
            $model->dpjp_nama = $model->dpjp->namaLengkap;
            $model->perawat_nama = $model->perawat->namaLengkap;
        }

        $this->render($this->path_view . 'Print_anak', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'modObat' => $modRiwayatObat,
            'modGambar' => $modGambar,
        ));
    }
    
    /**
     * digunakan untuk menghapus bagian tubuh yang pada tabel
     */
    public function actionHapusBagianTubuh()
    {
        if(Yii::app()->request->isAjaxRequest) {
    $pesan = '';
    $ok = 0;
            $del = true;
            
            

            
            $ok = RIPemeriksaangambarawalmedisT::model()->findByAttributes(
                    array(
                            'pemeriksaangambarawalmedis_id' => $_POST['pemeriksaangambarawalmedis_id'],
                            'gambartubuh_id' => $_POST['gambartubuh_id'],
                            'bagiantubuh_id' =>$_POST['bagiantubuh_id'],                            
                            'keterangan_periksa_gbr' => $_POST['keterangan_periksa_gbr'],
                    )
            );

            if (!empty($ok)){
                    $del = $del && $ok->delete();
            }
            
            

            if($del){
                    $pesan = 'Data Berhasil Dihapus dari database';
                    $ok = 1;
                    echo CJSON::encode(array('pesan'=>$pesan, 'ok'=>$ok));
            }else{
                    $ok = 0;
                    $pesan = "Bagian Tubuh gagal dihapus!";
                    echo CJSON::encode(array('pesan'=>$pesan, 'ok'=>$ok));
            }
        }
        Yii::app()->end();
    }
    
    public function actionAddRowRiwayatObat() {
        if (Yii::app()->request->isAjaxRequest) {
//            $nama_obat = isset($_POST['nama_obat']) ? $_POST['nama_obat'] : '';
//            $dosis_obat = isset($_POST['dosis_obat']) ? $_POST['dosis_obat'] : '';
//            $carapemberian = isset($_POST['carapemberian']) ? $_POST['carapemberian'] : '';
//            $tglpemberian = isset($_POST['tglpemberian']) ? $_POST['tglpemberian'] : '';
            
            $form = "";
            $pesan = "";
            $format = new MyFormatter();
            $modRiwayatobatsebelumnya = new RIRiwayatobatsebelumnyaT;

//            $modRiwayatobatsebelumnya->nama_obat = $nama_obat;
//            $modRiwayatobatsebelumnya->dosis_obat = $dosis_obat;
//            $modRiwayatobatsebelumnya->carapemberian = $carapemberian;
//            $modRiwayatobatsebelumnya->tglpemberian = $tglpemberian;

            $form .= $this->renderPartial($this->path_view . '_formAddRiwayatObatHemodialisa', array('model' => $modRiwayatobatsebelumnya
                    ), true);
            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }
    
    public function actionHapusRiwayat() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['id'];
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $hapusRiwayatobatsebelumnya = RIRiwayatobatsebelumnyaT::model()->find("asesmen_awal_medis_id = " . $id);
                if (!empty($hapusRiwayatobatsebelumnya)) {
                    $ok = $ok && RIRiwayatobatsebelumnyaT::model()->deleteAll("asesmen_awal_medis_id = " . $id);
                }
                
                $hapusPemeriksaangambarawalmedis = RIPemeriksaangambarawalmedisT::model()->find("asesmen_awal_medis_id = " . $id);
                if (!empty($hapusPemeriksaangambarawalmedis)) {
                    $ok = $ok && RIPemeriksaangambarawalmedisT::model()->deleteAll("asesmen_awal_medis_id = " . $id);
                }
                
                $hapusPasienmorbiditas = PasienmorbiditasT::model()->find("asesmen_awal_medis_id = " . $id);
                if (!empty($hapusPasienmorbiditas)) {
                    $ok = $ok && PasienmorbiditasT::model()->deleteAll("asesmen_awal_medis_id = " . $id);
                }

                $ok = $ok && RIAsesmenAwalMedisT::model()->deleteByPk($id);
                if ($ok) {
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Data Berhasil Dihapus';
                    $transaction->commit();
                } else {
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Data Gagal Dihapus';
                    $transaction->rollback();
                }
            } catch (Exception $ex) {
                $data['sukses'] = 0;
                $data['pesan'] = 'Data Gagal Dihapus';
                $transaction->rollback();
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    public function actionGetKonsultanNefrologi()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
//                $criteria->order = 'daftartindakan_nama';
//                $criteria->limit = 10;
            $models = PegawaiM::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nama_pegawai;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    public function actionGetDiagnosaMasukRS()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
//            $criteria->compare('LOWER(diagnosa_kode)', strtolower($_GET['term']), true);
            $criteria->compare('LOWER(diagnosa_nama)', strtolower($_GET['term']), true);
//                $criteria->order = 'daftartindakan_nama';
//                $criteria->limit = 10;
            $models = DiagnosaM::model()->findAll($criteria);
//            if(!empty($models)){
                foreach($models as $i=>$model)
                {
//                    $attributes = $model->attributeNames();
//                    foreach($attributes as $j=>$attribute) {
//                        $returnVal[$i]["$attribute"] = $model->$attribute;
//                    }
                    $returnVal[$i]['label'] = $model->diagnosa_nama;
                    $returnVal[$i]['value'] = $model->diagnosa_id;
                }
//            }else{
//                $returnVal = [];
//            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

}
