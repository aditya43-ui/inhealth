<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */



Yii::import("pendaftaranPenjadwalan.models.*");

/**
 * Description of AnjunganPasienMandiriController
 *
 * @author Deni Hamdani <denihamdani@.com>
 */
class AnjunganPasienMandiriController extends Controller
{

    public $layout = '//layouts/kiosAntrian';

    public $pasientersimpan = true;
    public $pendaftarantersimpan = true;
    public $penanggungjawabtersimpan = true;
    public $karcistersimpan = true;
    public $komponentindakantersimpan = true;
    public $rujukantersimpan = true;
    public $asuransipasientersimpan = true;
    public $septersimpan = true;
    public $skptersimpan = true;
    public $is_rm_manual = false;

    public $is_pasien_baru = false;
    public $bpjs_error = "";


    public function actionIndex()
    {

        $this->render("index", array());
    }

    public function actionUmumSukses($id)
    {

        $this->layout = '//layouts/iframe';

        $model = PendaftaranT::model()->findByPk($id);

        if (empty($model)) {
            echo "Kunjungan tidak dapat ditemukan";
            Yii::app()->end();
        }

        $modPasien = $model->pasien;

        $this->render('umumSukses', array(
            'model' => $model,
            'modPasien' => $modPasien,
        ));
    }

    public function actionPilihAnjungan()
    {

        $this->layout = '//layouts/iframe';

        $model = new PPPendaftaranT;
        $modPasien = new PPPasienM;

        $modSep = new PPSepT;
        $modAsuransiPasienBpjs = new PPAsuransipasienbpjsM;
        $modRujukanBpjs = new PPRujukanbpjsT;

        $modSep->jenisfaskes = 1;


        if (isset($_POST['PPPendaftaranT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modPasien = $this->simpanPasien($modPasien, $_POST['PPPasienM']);
                //var_dump($this->is_rm_manual);
                /*
                    if($_POST['PPPendaftaranT']['is_adapjpasien']){
                        if(isset($_POST['PPPenanggungJawabM'])){
                            $modPenanggungJawab = $this->simpanPenanggungjawab($modPenanggungJawab, $_POST['PPPenanggungJawabM']);
                        }
                    }else{
                        $this->penanggungjawabtersimpan = true;
                    }

                    if (isset($_POST['PPPasienM']['pegawai_penanggungjawab_id'])) {
                        $modPenanggungJawab = $this->simpanPenanggungjawabDokter($modPenanggungJawab, $_POST['PPPasienM']['pegawai_penanggungjawab_id']);
                    }

                    if($_POST['PPPendaftaranT']['is_pasienrujukan']){
                        if(isset($_POST['PPRujukanT'])){
                            // $modRujukan = $this->simpanRujukan($modRujukan, $_POST['PPRujukanT']);
                        }
                    }else{
                        $this->rujukantersimpan = true;
                    }
                    */

                /*
                    if($_POST['PPPendaftaranT']['is_bpjs']){
                        if(isset($_POST['PPRujukanbpjsT'])){
                            // $modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['PPRujukanbpjsT']);
                        }
                    }else{
                        $this->rujukantersimpan = true;
                    }

                    
                    
                    */

                $post_pendaftaran = $_POST['PPPendaftaranT'];
                $ppenjamin = null;
                if (isset($_POST['PPPendaftaranT']['carabayar_id'])) {
                    $ppenjamin = PenjaminpasienM::model()->findByAttributes(array(
                        'carabayar_id' => $_POST['PPPendaftaranT']['carabayar_id'],
                        'penjamin_aktif' => true,
                    ), array(
                        'order' => 'penjamin_id asc',
                    ));

                    if (!empty($ppenjamin)) {
                        $post_pendaftaran['penjamin_id'] = $ppenjamin->penjamin_id;
                    }
                }




                if (isset($_POST['PPAsuransipasienbpjsM'])) {
                    if (isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
                        if (!empty($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
                            $modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
                        }
                    }
                    $modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $post_pendaftaran, $modPasien, $_POST['PPAsuransipasienbpjsM']);
                } else {
                    $this->asuransipasientersimpan = true;
                }

                /*
                    if($_POST['PPPendaftaranT']['is_bpjs']){
                        $model = $this->simpanPendaftaran($model,$modPasien,$modRujukanBpjs,$modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'],$modAsuransiPasienBpjs);
                        $modSep = $this->simpanSep($model,$modPasien,$modRujukanBpjs,$modAsuransiPasienBpjs,$_POST['PPSepT']);
                        //var_dump($modSep->attributes);
                        $model->sep_id = $modSep->sep_id;
                        $model->update();
                    }else{ */
                //    if (isset($_POST['PPSepInhealthT'])) { //simpan pendaftaran ketika brigin dengan inhealth
                //        $model = $this->simpanPendaftaran($model, $modPasien, $modRujukanInhealth, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $modAsuransiPasienInhealth);
                //    } else {
                $model = $this->simpanPendaftaran($model, $modPasien, null, null, $post_pendaftaran, $_POST['PPPasienM'], null);
                //    }

                // }



                // var_dump($modAsuransiPasienBpjs->attributes, $modAsuransiPasienBpjs->errors, $_POST);
                // die;
                // var_dump($model->carabayar_id);

                if (isset($_POST['PPSepT']) && $model->carabayar_id == Params::CARABAYAR_ID_BPJS) {
                    $modSep = $this->simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $_POST['PPSepT']);
                    $model->sep_id = $modSep->sep_id;
                    $model->update();
                }

                // var_dump($_POST); die;
                $this->karcistersimpan = true;
                $this->komponentindakantersimpan = true;
                if (isset($_POST['PPPendaftaranT']['is_adakarcis'])) {
                    if (isset($_POST['PPTindakanPelayananT'])) {
                        if (count((array)$_POST['PPTindakanPelayananT']) > 0) {
                            foreach ($_POST['PPTindakanPelayananT'] as $i => $karcis) {
                                if ($karcis['is_pilihtindakan']) {
                                    $modTindakan = new TindakanpelayananT();
                                    $dataTindakans[$i] = $this->simpanKarcis($modTindakan, $model, $karcis);
                                    $model->karcis_id = $dataTindakans[$i]->karcis_id;
                                    $model->save();
                                }
                            }
                        }
                        if (isset($_POST['PPPendaftaranT']['is_bayarkarcis'])) { //fitur belum ada >> RND-666
                            if ($_POST['PPPendaftaranT']['is_bayarkarcis']) { //jika di ceklis
                            }
                        }
                    }
                }


                if (isset($_POST['scan'])) {
                    $this->simpanScanPasien($model, $_POST['scan']);
                }

                $judul = 'Pendaftaran Pasien';

                if ($model->statuspasien == 'PENGUNJUNG LAMA') {
                    $judul .= " Lama";
                } else $judul .= " Baru";

                $judul .= " Rawat Jalan";

                $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;


                $cek = DokrekammedisM::model()->findByAttributes(array('pasien_id' => $model->pasien_id));

                if ($cek) {
                    $link = $this->createUrl('/rekamMedis/PengirimanBerkasRekamMedis/Index', array(
                        'RKDokumenpasienrmlamaV[no_pendaftaran]' => $model->no_pendaftaran,
                        'RKDokumenpasienrmlamaV[no_rekam_medik]' => $model->pasien->no_rekam_medik,
                        'RKDokumenpasienrmlamaV[tgl_rekam_medik]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
                        'RKDokumenpasienrmlamaV[tgl_rekam_medik_akhir]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
                        'RKDokumenpasienrmlamaV[nama_pasien]' => $model->pasien->nama_pasien
                    ));
                } else {
                    $link = $this->createUrl('/rekamMedis/PembuatanDokumenRK/Create', array(
                        'pasien_id' => $model->pasien_id
                    ));
                }

                $link_rj = $this->createUrl('/rawatJalan/DaftarPasien/Index', array(
                    'RJInfokunjunganrjV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
                    'RJInfokunjunganrjV[tgl_akhir]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
                    'RJInfokunjunganrjV[no_pendaftaran]' => substr($model->no_pendaftaran, 2),
                    'RJInfokunjunganrjV[nama_pasien]' => $model->pasien->nama_pasien,
                    'RJInfokunjunganrjV[no_rekam_medik]' => $model->pasien->no_rekam_medik,
                    'RJInfokunjunganrjV[ceklis]' => false,
                    'RJInfokunjunganrjV[tgl_awall]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
                    'RJInfokunjunganrjV[tgl_akhirl]' => date('Y-m-d', strtotime($model->tgl_pendaftaran))
                ));


                //var_dump($link_rj);die;

                $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                    array('instalasi_id' => Params::INSTALASI_ID_RJ, 'ruangan_id' => $model->ruangan_id, 'modul_id' => 5,  'link_proses' => $link_rj), //, 'link_proses'=>$link_rj
                    //array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_1, 'modul_id'=>10),
                    //array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
                    array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_REKAM_MEDIS, 'modul_id' =>  Params::MODUL_ID_REKAMMEDIS, 'link_proses' => $link), //, 'link_proses' => $link
                ));

                $ok_vaksinasi = true;



                //Di set di form >> Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
                //                      RND-666 >>>  $this->redirect(array('view','id'=>$model->pendaftaran_id,'sukses'=>1));
                $smspasien = 1;
                $smsdokter = 1;
                $smspenanggungjawab = 1;


                // die;
                // END SMS GATEWAY


                // var_dump($ok_vaksinasi , $this->pasientersimpan , $this->pendaftarantersimpan , $this->penanggungjawabtersimpan , $this->rujukantersimpan , $this->karcistersimpan , $this->komponentindakantersimpan , $this->asuransipasientersimpan);
                // die;
                if ($ok_vaksinasi && $this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan && $this->asuransipasientersimpan) {
                    // echo "Kick"; die;
                    if (isset($_POST['is_whatsapp']) && $_POST['is_whatsapp'] == 1) {
                        $this->kirimWhatsApp($model, $modPasien);
                    }
                    //                        die;
                    $transaction->commit();

                    $this->redirect(array('umumSukses', 'id' => $model->pendaftaran_id));

                    /*
                        if($this->septersimpan){
                            $this->redirect(array('index','id'=>$model->pendaftaran_id,'idSep'=>$modSep->sep_id,'sukses'=>1,'smspasien'=>$smspasien,'smsdokter'=>$smsdokter,'smspenanggungjawab'=>$smspenanggungjawab));
                        }else if ($this->skptersimpan) {
                            $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'idSkp' => $modSkp->skp_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter, 'smspenanggungjawab' => $smspenanggungjawab));
                        }else{
                            $this->redirect(array('index','id'=>$model->pendaftaran_id,'sukses'=>1,'smspasien'=>$smspasien,'smsdokter'=>$smsdokter,'smspenanggungjawab'=>$smspenanggungjawab));
                        }
                        */
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data pasien gagal disimpan !");
                }
            } catch (Exception $exc) {
                var_dump($exc->getMessage(), $exc->getTraceAsString());
                die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $exc->getMessage());
            }
        }


        $this->render('pilihAnjungan', array(
            'model' => $model,
            'modPasien' => $modPasien,

            'modSep' => $modSep,
            'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
            'modRujukanBpjs' => $modRujukanBpjs,
        ));
    }

    /**
     * simpan asuransi pasien
     * @param type $modAsuransiPasien
     * @param type $postPendaftaran
     * @param type $postPasien
     * @param type $postAsuransiPasien
     * @return type
     */
    public function simpanAsuransiPasien($modAsuransiPasien, $postPendaftaran, $postPasien, $postAsuransiPasien, $postAdmisi = null)
    {
        // var_dump($postAdmisi); die;

        $format = new MyFormatter();

        $carabayar = isset($postPendaftaran['carabayar_id']) ? $postPendaftaran['carabayar_id'] : null;
        if (empty($carabayar)) $carabayar = isset($postAdmisi['carabayar_id']) ? $postAdmisi['carabayar_id'] : null;

        $penjamin = isset($postPendaftaran['penjamin_id']) ? $postPendaftaran['penjamin_id'] : null;
        if (empty($penjamin)) $penjamin = isset($postAdmisi['penjamin_id']) ? $postAdmisi['penjamin_id'] : null;

        $modAsuransiPasien->attributes = $postAsuransiPasien;
        $modAsuransiPasien->pasien_id = isset($postPasien['pasien_id']) ? $postPasien['pasien_id'] : null;
        $modAsuransiPasien->penjamin_id = $penjamin;
        $modAsuransiPasien->carabayar_id = $carabayar;
        $modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
        $modAsuransiPasien->create_time = date("Y-m-d H:i:s");
        $modAsuransiPasien->tgl_konfirmasi = $format->formatDateTimeForDb($modAsuransiPasien->tgl_konfirmasi);
        $modAsuransiPasien->hubkeluarga = isset($postAsuransiPasien['hubkeluarga']) ? $postAsuransiPasien['hubkeluarga'] : '';
        $modAsuransiPasien->nominal_tanggungan = isset($postAsuransiPasien['nominal_tanggungan']) ? $postAsuransiPasien['nominal_tanggungan'] : 0;
        //var_dump($postAsuransiPasien['nominal_tanggungan']);die;
        // var_dump($postPendaftaran);
        // var_dump($postPasien->attributes);
        if ($carabayar == Params::CARABAYAR_ID_JAMKESPA) {
            $modAsuransiPasien->nopeserta = $postPasien->no_rekam_medik;
            // $modAsuransiPasien->status_konfirmasi = 1;
        } else if ($carabayar == Params::CARABAYAR_ID_BPJS) {
            // var_dump($modAsuransiPasien->attributes, $_POST); die;
            $kelas = KelaspelayananM::model()->findByAttributes(array('kelasbpjs_id' => $modAsuransiPasien->kelastanggunganasuransi_id));
            if (!empty($kelas)) {
                $modAsuransiPasien->kelastanggunganasuransi_id = $kelas->kelaspelayanan_id;
            }
            $modAsuransiPasien->status_konfirmasi = 1;
            $modAsuransiPasien->tgl_konfirmasi = date('Y-m-d H:i:s');
            $modAsuransiPasien->namaperusahaan = 'BPJS';
            //var_dump($modAsuransiPasien->kelastanggunganasuransi_id);die;
        }
        if (empty($postAsuransiPasien['nokartuasuransi'])) {
            $modAsuransiPasien->nokartuasuransi = $modAsuransiPasien->nopeserta;
        }

        if ($modAsuransiPasien->status_konfirmasi == 1) {
            $modAsuransiPasien->status_konfirmasi = "SUDAH DIKONFIRMASI";
        } else if ($modAsuransiPasien->status_konfirmasi == 0) {
            $modAsuransiPasien->status_konfirmasi = "BELUM DIKONFIRMASI";
        }

        $modAsuransiPasien->nominal_tanggungan = !is_numeric($modAsuransiPasien->nominal_tanggungan) ? str_replace(",", "", $modAsuransiPasien->nominal_tanggungan) : $modAsuransiPasien->nominal_tanggungan;
        $modAsuransiPasien->create_loginpemakai_id = 1;
        //            var_dump($modAsuransiPasien->attributes); die;
        //var_dump($modAsuransiPasien->validate(), $modAsuransiPasien->errors); die;
        if ($modAsuransiPasien->validate() && $modAsuransiPasien->save()) {
            $this->asuransipasientersimpan = true;
        }
        //var_dump($modAsuransiPasien->save());die;
        //var_dump($modAsuransiPasien->attributes);die;
        return $modAsuransiPasien;
    }

    public function simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $postSep, $isRI = false)
    {
        $reqSep = null;
        $modSep = new PPSepT;
        $modSep->attributes = $postSep;

        $bpjs = new BpjsVklaim();
        $kelas = KelaspelayananM::model()->findByPk($modAsuransiPasienBpjs->kelastanggunganasuransi_id);

        // var_dump($kelas->attributes, $modAsuransiPasienBpjs->attributes); die;

        $profil = ProfilrumahsakitM::model()->find();

        $modSep->tglsep = empty($modSep->tglsep) ? date("Y-m-d") : MyFormatter::formatDateTimeForDb($modSep->tglsep);
        $modSep->nokartuasuransi = $modAsuransiPasienBpjs->nopeserta;
        $modSep->tglrujukan = $modRujukanBpjs->tanggal_rujukan;
        if (empty($modSep->tglrujukan)) $modSep->tglrujukan = $modSep->tglsep;
        $modSep->norujukan = $modRujukanBpjs->no_rujukan;
        if (isset($postSep['ppkrujukan'])) $modSep->ppkrujukan = $postSep['ppkrujukan'];
        else $modSep->ppkrujukan = $profil->ppkpelayanan;
        $modSep->ppkpelayanan = $profil->ppkpelayanan;
        $modSep->jnspelayanan = ($model->instalasi_id == Params::INSTALASI_ID_RI || $isRI) ? Params::JENISPELAYANAN_RI : Params::JENISPELAYANAN_RJ;
        $modSep->catatansep = $postSep['catatansep'];
        $data_diagnosa = explode(', ', $modRujukanBpjs->kddiagnosa_rujukan);
        $data_diagnosa_nama = explode(', ', $modRujukanBpjs->diagnosa_rujukan);

        $modSep->diagnosaawal = isset($data_diagnosa[0]) ? $data_diagnosa[0] : '';
        $modSep->nama_diagnosaawal = isset($data_diagnosa_nama[0]) ? $data_diagnosa_nama[0] : '';
        $modSep->politujuan = $isRI ? "" : (empty($model->ruangan->kode_bpjs) ? $model->ruangan->ruangan_singkatan : $model->ruangan->kode_bpjs);
        $modSep->klsrawat = $kelas->kelasbpjs_id;
        $modSep->tglpulang = date('Y-m-d H:i:s');
        $modSep->create_time = date('Y-m-d H:i:s');
        $modSep->create_loginpemakai_id = Yii::app()->user->id;
        $modSep->create_ruangan = 1; //Yii::app()->user->getState('ruangan_id');
        $modSep->jenisrujukan_kode = (isset($postSep['jenisfaskes']) ? $postSep['jenisfaskes'] : 2);
        $modSep->jenisrujukan_nama = ($modSep->jenisrujukan_kode == 1) ? "PCare" : "Rumah Sakit";
        $modSep->no_telpon_peserta = (isset($postSep['no_telpon_peserta']) ? $postSep['no_telpon_peserta'] : null);
        $modSep->no_surat = (isset($postSep['no_surat']) ? $postSep['no_surat'] : null);
        $modSep->kode_dpjp = (isset($postSep['kode_dpjp']) ? $postSep['kode_dpjp'] : null);
        $modSep->nama_dpjp = (isset($postSep['nama_dpjp']) ? $postSep['nama_dpjp'] : null);

        if ($isRI) {

            $modSep->dpjpygmelayani_nama = null;
            $modSep->dpjpygmelayani_kode = null;
            $modSep->jenisrujukan_kode = 2;
            $modSep->ppkrujukan = $profil->ppkpelayanan;

            $sp_ranap = null;
            if (!empty($modSep->no_surat)) {
                $sp_ranap = SuratperintahranapT::model()->findByAttributes(array(
                    'pendaftaran_id' => $model->pendaftaran_id,
                    'nomorsurat' => $modSep->no_surat
                ));
            }

            if (empty($sp_ranap)) {
                $sp_ranap = SuratperintahranapT::model()->findByAttributes(array(
                    'pendaftaran_id' => $model->pendaftaran_id
                ));
            }


            if (!empty($sp_ranap)) {
                $modSep->tglrujukan = $sp_ranap->tgl_suratperintahranap;
                $modSep->norujukan = $sp_ranap->nomorspri_bpjs;
            }
        }

        if (isset($postSep['klsRawatNaik'])) {
            $modSep->klsRawatNaik = $postSep['klsRawatNaik'];
        }

        $lakalantas = 0;
        $asalRujukan = $modSep->jenisrujukan_kode;
        $eksekutif = 0;
        $cob = null;
        $penjamin = $model->penjamin_id;
        $lokasiLaka = null;
        $noTelp = $modSep->no_telpon_peserta;
        $user = null;
        $peg_user = PegawaiM::model()->findByPk(1);
        if (isset($peg_user)) {
            $user = $peg_user->nama_pegawai;
        }
        $tglKejadian = null;
        $keterangan = $modSep->catatansep;
        $suplesi = 0;
        $noSepSuplesi = null;
        $kdPropinsi = null;
        $kdKabupaten = null;
        $kdKecamatan = null;
        $noSurat = $modSep->no_surat;
        $kodeDPJP = $modSep->kode_dpjp;
        $katarak = 0;

        //            $model->no_telpon_peserta = $postSep['no_telpon_peserta'];

        if (isset($_POST['PPPasienkecelakaanT'])) {
            $lakalantas = 1;
        }

        // var_dump($modSep->attributes, $postSep); die;

        // var_dump($modSep->klsrawat); die;
        // var_dump($modSep->attributes); die;
        if (isset($_POST['isSepManual'])) {
            if ($_POST['isSepManual'] == false) {
                $reqSep = json_decode($bpjs->create_sep_new($modSep->nokartuasuransi, $modSep->tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $asalRujukan, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDPJP, $katarak, $modSep), true);
                //                    $reqSep = json_decode($bpjs->create_sep($modSep->nokartuasuransi, $modSep->tglsep, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $modSep->klsrawat, Yii::app()->user->id, $modPasien->no_rekam_medik, $model->pendaftaran_id, $lakalantas),true);
                //var_dump($reqSep); die;
                if ($reqSep['metaData']['code'] == 200) {
                    $modSep->nosep = $reqSep['response']['sep']['noSep'];
                    if (empty($modSep->norujukan)) $modSep->norujukan = "-";
                    if (empty($modSep->diagnosaawal)) $modSep->diagnosaawal = "-";
                    if ($modSep->save()) {
                        $this->septersimpan = true;
                        RujukandariM::model()->updateByPk($modRujukanBpjs->rujukandari_id, array(
                            'ppkrujukan' => $modSep->ppkrujukan,
                        ));
                        $this->logBpjs($model, $reqSep);
                    }
                } else {
                    $this->logBpjs($model, $reqSep);
                    // Yii::app()->user->setFlash('error', 'BPJS Error '.$reqSep['metaData']['code'].': '.$reqSep['metaData']['message']);
                }
            } else {
                $modSep->nosep = $_POST['PPSepT']['nosep'];
                if ($modSep->save()) {
                    $this->septersimpan = true;
                }
            }
        } else {
            $reqSep = json_decode($bpjs->create_sep_new($modSep->nokartuasuransi, $modSep->tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $asalRujukan, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDPJP, $katarak, $modSep), true);
            //var_dump($reqSep); die;

            /*
            $reqSep = array(
                'metaData' => array(
                    'code' => 200,
                ),
                'response' => array(
                    'sep' => array(
                        'noSep' => '0301R0011117V000338',
                        'poli' => 'INT',
                        'informasi' => array(
                            'dinsos' => null,
                            'prolanisPRB' => null,
                            'noSKTM' => null,
                        )
                    )
                )
            );
            */

            if (isset($reqSep['metaData']['code']) && !empty($reqSep['metaData']['code'])) {
                if ($reqSep['metaData']['code'] == 200) {
                    // var_dump($reqSep); die;
                    $modSep->nosep = $reqSep['response']['sep']['noSep'];
                    $modSep->polirujukan = $reqSep['response']['sep']['poli'];
                    if (empty($modSep->norujukan)) $modSep->norujukan = "-";
                    if (empty($modSep->diagnosaawal)) $modSep->diagnosaawal = "-";

                    $modAsuransiPasienBpjs->bpjs_pesertadinsos = $reqSep['response']['sep']['informasi']['dinsos'];
                    $modAsuransiPasienBpjs->bpjs_prolanisprb = $reqSep['response']['sep']['informasi']['prolanisPRB'];
                    $modAsuransiPasienBpjs->bpjs_nosktm = $reqSep['response']['sep']['informasi']['noSKTM'];
                    $modAsuransiPasienBpjs->save();

                    if ($modSep->save()) {
                        $this->septersimpan = true;
                        RujukandariM::model()->updateByPk($modRujukanBpjs->rujukandari_id, array(
                            'ppkrujukan' => $modSep->ppkrujukan,
                        ));
                        $this->logBpjs($model, $reqSep);
                    }
                } else {
                    $this->logBpjs($model, $reqSep);
                    // Yii::app()->user->setFlash('error', 'BPJS Error '.$reqSep['metaData']['code'].': '.$reqSep['metaData']['message']);
                }
            } else {
            }
        }

        $modSep->no_surat = !empty($modSep->no_surat) ? $modSep->no_surat : null;
        $modSep->kode_dpjp = !empty($modSep->kode_dpjp) ? $modSep->kode_dpjp : null;
        $modSep->nama_dpjp = !empty($modSep->nama_dpjp) ? $modSep->nama_dpjp : null;
        $modSep->create_loginpemakai_id = 1;

        $modSep->save();
        // var_dump($modSep->attributes, $modSep->errors); die;

        return $modSep;
    }


    /**
     * proses simpan / ubah data pasien
     * @param type $modPasien
     * @param type $post
     * @return type
     */
    public function simpanPasien($modPasien, $post)
    {
        $format = new MyFormatter();
        $snrm = "";
        if (isset($post['pasien_id']) && (!empty($post['pasien_id']))) {
            $load = new $modPasien;
            $modPasien = $load->findByPk($post['pasien_id']);
            $snrm = $modPasien->no_rekam_medik;
        }

        $modPasien->attributes = $post;

        if (isset($modPasien->fingerprint_data)) {
            unset($modPasien->fingerprint_data);
        }
        //var_dump($modPasien->fingerprint_data);die;
        $modPasien->tanggal_lahir = $format->formatDateTimeForDb($modPasien->tanggal_lahir);
        $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);

        if (empty($modPasien->pasien_id)) {
            $this->is_pasien_baru = true;
            $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
            $modPasien->profilrs_id = Params::getDefaultProfilRS();
            $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
            $modPasien->ispasienluar = FALSE;
            $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modPasien->create_loginpemakai_id = Yii::app()->user->id;
            $modPasien->create_time = date('Y-m-d H:i:s');
            if (empty($modPasien->no_rekam_medik) || trim($modPasien->no_rekam_medik) == "") {
                if (isset($_POST['generateNoRM'])) {
                    if (!empty($_POST['generateNoRM'])) {
                        $modPasien->no_rekam_medik = MyGenerator::noRekamMedik('', 'FALSE', $_POST['generateNoRM']);
                    }
                } else {
                    $modPasien->no_rekam_medik = MyGenerator::noRekamMedik();
                }
            } else {
                $this->is_rm_manual = true;
            }
        } else {
            $modPasien->update_loginpemakai_id = Yii::app()->user->id;
            $modPasien->update_time = date('Y-m-d H:i:s');
            $modPasien->no_rekam_medik = $snrm;
        }
        $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id) ? $modPasien->kelurahan_id : null);
        $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;

        // simpan gambar
        if (isset($post['is_ambilfoto']) && $post['is_ambilfoto'] == 1) {
            $nama_file = "pasien_" . date('YmdHis') . "_" . (str_replace(".", "_", microtime(true))) . ".png";
            $fullImgSource = Params::pathPasienDirectory() . $nama_file;
            $fullThumbSource = Params::pathPasienTumbsDirectory() . 'kecil_' . $nama_file;

            $file = fopen($fullImgSource, "wb");
            $data_foto = explode(",", $modPasien->photopasien);

            fwrite($file, base64_decode($data_foto[1]));
            fclose($file);

            // thumbnail
            Yii::import("ext.EPhpThumb.EPhpThumb");
            $thumb = new EPhpThumb();
            $thumb->init();
            $thumb->create($fullImgSource)
                ->resize(200, 200)
                ->save($fullThumbSource);

            $modPasien->photopasien = $nama_file;
        }

        $modPasien->create_loginpemakai_id = 1;


        if ($modPasien->save()) {
            $this->pasientersimpan = true;
        }

        // var_dump($modPasien->errors, $modPasien->attributes); die;

        return $modPasien;
    }


    /**
     * proses simpan / ubah data pendaftaran
     * @return type
     */
    public function simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $post, $postPasien, $modAsuransiPasien)
    {
        $format = new MyFormatter();
        $modP = PendaftaranT::model()->findByAttributes(array(
            'pasien_id' => $modPasien->pasien_id,
        ), array(
            'condition' => 'pasienbatalperiksa_id is null',
        ));
        $model->attributes = $post;
        $model->pasien_id = $modPasien->pasien_id;
        // $model->penanggungjawab_id = $modPenanggungJawab->penanggungjawab_id;
        // $model->rujukan_id = $modRujukan->rujukan_id;
        $model->instalasi_id = (isset($model->ruangan_id) ? $model->ruangan->instalasi_id : null);
        $model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
        $model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
        $model->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;

        // $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);

        if (empty($postPasien['pasien_id']) || empty($modP)) {
            $model->statuspasien = Params::STATUSPASIEN_BARU;
            $model->kunjungan = Params::STATUSKUNJUNGAN_BARU;
        } else if ($this->is_rm_manual) {
            $model->statuspasien = Params::STATUSPASIEN_LAMA;
            $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
        } else {
            $model->statuspasien = Params::STATUSPASIEN_LAMA;
            $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
        }
        /*
        $model->statuspasien = (empty($postPasien['pasien_id'] || empty($modP)) ? Params::STATUSPASIEN_BARU : Params::STATUSPASIEN_LAMA);
        $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);

        if ($this->is_rm_manual) {
            $model->statuspasien = Params::STATUSPASIEN_LAMA;
            $model->kunjungan = Params::STATUSKUNJUNGAN_LAMA;
        } */

        $model->shift_id = Yii::app()->user->getState('shift_id');
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_time = date("Y-m-d H:i:s");
        // if(Yii::app()->user->getState('tgltransaksimundur') && !empty($model->tgl_pendaftaran)){
        $model->tgl_pendaftaran = $format->formatDateTimeForDb($model->tgl_pendaftaran);
        // }else{
        //	$model->tgl_pendaftaran = date("Y-m-d H:i:s");
        // }
        $model->no_pendaftaran = MyGenerator::noPendaftaran($model->instalasi_id, $model->tgl_pendaftaran);
        $model->kelompokumur_id = (!empty($modPasien->kelompokumur_id) ? $modPasien->kelompokumur_id : CustomFunction::getKelompokUmur($modPasien->tanggal_lahir));
        $model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
        $model->tgl_konfirmasi = $format->formatDateTimeForDb($model->tgl_konfirmasi);
        $model->tglselesaiperiksa = $format->formatDateTimeForDb($model->tglselesaiperiksa);
        $model->tglrenkontrol = $format->formatDateTimeForDb($model->tglrenkontrol);
        $model->asuransipasien_id = empty($modAsuransiPasien) ? null : $modAsuransiPasien->asuransipasien_id;
        $model->keterangan_pendaftaran = isset($post['keterangan_pendaftaran']) ? $post['keterangan_pendaftaran'] : null;
        $model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id, $model->tgl_pendaftaran);

        $modRuangan = PPRuanganM::model()->findByPk($model->ruangan_id);
        $estimasipelayanan = isset($modRuangan->estimasipelayanan) ? $modRuangan->estimasipelayanan : 15;

        $tgl_awal = date('Y-m-d');
        $tgl_akhir = date('Y-m-d');
        $criteria = new CDbCriteria();
        $criteria->addCondition('ruangan_id = ' . $model->ruangan_id);
        $criteria->addCondition("tgl_pendaftaran::date = '" . $tgl_awal . "'");
        $criteria->order = 'tgl_pendaftaran DESC';
        $dataPendaftaran = PPPendaftaranT::model()->find($criteria);
        // var_dump($estimasipelayanan, $dataPendaftaran->attributes); die;



        $tgldaftar = new DateTime($model->tgl_pendaftaran);
        if (!empty($dataPendaftaran) && !empty($dataPendaftaran->tglakandilayani)) {
            $tglakandilayani = new DateTime($dataPendaftaran->tglakandilayani);

            if ($tgldaftar < $tglakandilayani) {
                $tglakandilayani->add(new DateInterval("PT" . $estimasipelayanan . "M"));
                $model->tglakandilayani = $tglakandilayani->format('Y-m-d H:i:s');
            } else {
                $tgldaftar->add(new DateInterval("PT" . $estimasipelayanan . "M"));
                $model->tglakandilayani = $tgldaftar->format('Y-m-d H:i:s');
            }
        } else {
            $tgldaftar->add(new DateInterval("PT" . $estimasipelayanan . "M"));
            $model->tglakandilayani = $tgldaftar->format('Y-m-d H:i:s');
        }

        if (isset($post['buatjanjipoli_id'])) {
            $model->buatjanjipoli_id = $post['buatjanjipoli_id'];

            $janjipoli = BuatjanjipoliT::model()->findByPk($model->buatjanjipoli_id);

            $model->tglakandilayani = $model->tgl_pendaftaran;

            if (!empty($janjipoli) && $janjipoli->ruangan_id == $model->ruangan_id) {
                $model->no_urutantri = $janjipoli->no_antrianjanji;
            }
        }

        $model->tgl_pendaftaran = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = 1;
        $model->penjamin_id = !empty($model->penjamin_id) ? $model->penjamin_id : Params::PENJAMIN_ID_UMUM;
        $model->carabayar_id = $model->penjamin->carabayar_id;
        $model->kelaspelayanan_id = !empty($model->kelaspelayanan_id) ? $model->kelaspelayanan_id : Params::KELASPELAYANAN_ID_TANPA_KELAS;
        $model->jeniskasuspenyakit_id = Params::JENIS_KASUSPENYAKIT_ID_UMUM;


        if ($model->save()) {
            if (!empty($model->antrian_id)) {
                PPAntrianT::model()->updateByPk($model->antrian_id, array('pendaftaran_id' => $model->pendaftaran_id));
            }
            $this->pendaftarantersimpan = true;
        } else {
            $this->pendaftarantersimpan = false;
        }

        // var_dump($model->errors, $model->attributes); die;

        return $model;
    }








    /**
     * Set Tanggal, Wilayah, dan Jenis Kelamin berdasarkan No KTP
     */
    public function actionInputDariNoKTP()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $no_ktp = $_POST['no_ktp'];
        $str_lens = strlen($no_ktp);

        $res = array(
            'propinsi_id' => null,
            'kabupaten_id' => null,
            'kecamatan_id' => null,
            'tanggal_lahir' => null,
            'tanggal_lahir_format' => null,
            'jeniskelamin' => '',
        );

        if ($str_lens >= 2) {
            $prop = PropinsiM::model()->findByAttributes(array(
                'kode_propinsi' => substr($no_ktp, 0, 2),
            ));

            if (!empty($prop)) {
                $res['propinsi_id'] = $prop->propinsi_id;

                if ($str_lens >= 4) {
                    $kab = KabupatenM::model()->findByAttributes(array(
                        'propinsi_id' => $prop->propinsi_id,
                        'kode_kabupaten' => substr($no_ktp, 2, 2),
                    ));

                    if (!empty($kab)) {
                        $res['kabupaten_id'] = $kab->kabupaten_id;

                        if ($str_lens >= 6) {
                            $kec = KecamatanM::model()->findByAttributes(array(
                                'kabupaten_id' => $kab->kabupaten_id,
                                'kode_kecamatan' => substr($no_ktp, 4, 2),
                            ));

                            if (!empty($kec)) {
                                $res['kecamatan_id'] = $kec->kecamatan_id;
                            }
                        }
                    }
                }
            }
        }

        if ($str_lens >= 12) {
            $str_tgl = substr($no_ktp, 6, 6);

            $tgl = substr($str_tgl, 0, 2);
            $bln = substr($str_tgl, 2, 2);
            $thn = substr($str_tgl, 4, 2);

            $thn_min = "19" . $thn;
            $thn_max = "20" . $thn;
            $thn_real = $thn_max;

            if (($thn_real) > (date('Y') - 16)) {
                $thn_real = $thn_min;
            }


            $bln = ((int)$bln > 12) ? "01" : $bln;

            $hari_limit = date('t', strtotime($thn_real . "-" . $bln . "-01"));
            $tgl = ($tgl > $hari_limit) ? "01" : $tgl;

            $res['tanggal_lahir'] = $thn_real . "-" . $bln . "-" . $tgl;
            $res['tanggal_lahir_format'] = $tgl . "/" . $bln . "/" . $thn_real;

            // jenis kelamin
            $res_jk = (int)$tgl - 40;

            if ($res_jk < 0) {
                $res['jeniskelamin'] = 'LAKI-LAKI';
            } else {
                $res['jeniskelamin'] = 'PEREMPUAN';
            }
        }

        echo CJSON::encode($res);
    }

    /**
     * Mengatur dropdown kabupaten
     * @param type $encode jika = true maka return array jika false maka set Dropdown
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownKabupaten($encode = false, $model_nama = '', $attr = '')
    {
        if (Yii::app()->request->isAjaxRequest) {
            $modPasien = new PPPasienM;
            if ($model_nama !== '' && $attr == '') {
                $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
            } elseif ($model_nama == '' && $attr !== '') {
                $propinsi_id = $_POST["$attr"];
            } elseif ($model_nama !== '' && $attr !== '') {
                $propinsi_id = $_POST["$model_nama"]["$attr"];
            }
            $kabupaten = null;
            if ($propinsi_id) {
                $kabupaten = $modPasien->getKabupatenItems($propinsi_id);
                $kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');
            }
            if ($encode) {
                echo CJSON::encode($kabupaten);
            } else {
                if (empty($kabupaten)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($kabupaten as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
    /**
     * Mengatur dropdown kecamatan
     * @param type $encode jika = true maka return array jika false maka set Dropdown
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownKecamatan($encode = false, $model_nama = '', $attr = '')
    {
        if (Yii::app()->request->isAjaxRequest) {
            $modPasien = new PPPasienM;
            if ($model_nama !== '' && $attr == '') {
                $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
            } elseif ($model_nama == '' && $attr !== '') {
                $kabupaten_id = $_POST["$attr"];
            } elseif ($model_nama !== '' && $attr !== '') {
                $kabupaten_id = $_POST["$model_nama"]["$attr"];
            }
            $kecamatan = null;
            if ($kabupaten_id) {
                $kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
                $kecamatan = CHtml::listData($kecamatan, 'kecamatan_id', 'kecamatan_nama');
            }

            if ($encode) {
                echo CJSON::encode($kecamatan);
            } else {
                if (empty($kecamatan)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($kecamatan as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
    /**
     * Mengatur dropdown kelurahan
     * @param type $encode jika = true maka return array jika false maka set Dropdown
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownKelurahan($encode = false, $model_nama = '', $attr = '')
    {
        if (Yii::app()->request->isAjaxRequest) {
            $modPasien = new PPPasienM;
            if ($model_nama !== '' && $attr == '') {
                $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
            } elseif ($model_nama == '' && $attr !== '') {
                $kecamatan_id = $_POST["$attr"];
            } elseif ($model_nama !== '' && $attr !== '') {
                $kecamatan_id = $_POST["$model_nama"]["$attr"];
            }
            $kelurahan = null;
            if ($kecamatan_id) {
                $kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
                //                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
                $kelurahan = CHtml::listData($kelurahan, 'kelurahan_id', 'kelurahan_nama');
            }

            if ($encode) {
                echo CJSON::encode($kelurahan);
            } else {
                if (empty($kelurahan)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($kelurahan as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * set dropdown daerah pasien berdasarkan
     * propinsi_id
     * kabupaten_id
     * kecamatan_id
     * kelurahan_id
     * pasien_id
     */
    public function actionSetDropdownDaerahPasien()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $modPasien = new PPPasienM;
            $propinsi_id = $_POST['propinsi_id'];
            $kabupaten_id = $_POST['kabupaten_id'];
            $kecamatan_id = $_POST['kecamatan_id'];
            $kelurahan_id = (isset($_POST['kelurahan_id']) ? $_POST['kelurahan_id'] : null);

            $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE');
            $propinsis = CHtml::listData($propinsis, 'propinsi_id', 'propinsi_nama');
            $propinsiOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
            foreach ($propinsis as $value => $name) {
                if ($value == $propinsi_id)
                    $propinsiOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
                else
                    $propinsiOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }

            if (empty($propinsi_id)) {
                $kabupatens = array();
            } else {
                $kabupatens = $modPasien->getKabupatenItems($propinsi_id);
                //                $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true,));
                $kabupatens = CHtml::listData($kabupatens, 'kabupaten_id', 'kabupaten_nama');
            }

            $kabupatenOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
            foreach ($kabupatens as $value => $name) {
                if ($value == $kabupaten_id)
                    $kabupatenOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
                else
                    $kabupatenOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }


            if (empty($kabupaten_id)) {
                $kecamatans = array();
            } else {
                $kecamatans = $modPasien->getKecamatanItems($kabupaten_id);
                //                $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$kabupaten_id,'kecamatan_aktif'=>true,));
                $kecamatans = CHtml::listData($kecamatans, 'kecamatan_id', 'kecamatan_nama');
            }
            $kecamatanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
            foreach ($kecamatans as $value => $name) {
                if ($value == $kecamatan_id)
                    $kecamatanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
                else
                    $kecamatanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }

            if (empty($kecamatan_id)) {
                $kelurahans = array();
            } else {
                $kelurahans = $modPasien->getKelurahanItems($kecamatan_id);
                $kelurahans = CHtml::listData($kelurahans, 'kelurahan_id', 'kelurahan_nama');
            }

            $kelurahanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
            foreach ($kelurahans as $value => $name) {
                if ($value == $kelurahan_id)
                    $kelurahanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
                else
                    $kelurahanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }

            $dataList['listPropinsi'] = $propinsiOption;
            $dataList['listKabupaten'] = $kabupatenOption;
            $dataList['listKecamatan'] = $kecamatanOption;
            $dataList['listKelurahan'] = $kelurahanOption;

            echo json_encode($dataList);
            Yii::app()->end();
        }
    }

    /**
     * set umur dari tanggal lahir (date)
     */
    public function actionSetUmur()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data['umur'] = null;
            if (isset($_POST['tanggal_lahir']) && !empty($_POST['tanggal_lahir'])) {
                $data['umur'] = CustomFunction::hitungUmur($_POST['tanggal_lahir']);
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionLoadPoli()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        echo $this->renderPartial('_poliLoad', array(), true);
    }

    public function actionLoadDokter()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $ruangan_id = $_POST['ruangan_id'];
        $jadwal = JadwaldokterM::model()->findAllByAttributes(array(
            'jadwaldokter_tgl' => date('Y-m-d'),
            'ruangan_id' => $ruangan_id,
        ), array(
            'order' => 'pegawai_id asc'
        ));

        echo $this->renderPartial('_dokterLoad', array(
            'jadwal' => $jadwal,
        ), true);
    }


    /**
     * @author Deni Hamdani <denihamdani@piindonesia.co.id>
     *
     * Sebelum dialog verifikasi dimunculkan maka dilakukan validasi Pasien,
     * khususnya yang memiliki No KTP, dan Nama Ibu+Tgl. Lahir. Jika Nomor KTP
     * tidak ditemukan pada Pasien Lain, maka akan dilanjutkan dengan validasi
     * Nama Ibu+Tgl lahir
     */
    public function actionValidasiPasien()
    {
        $ok = 1;
        $msg = "";

        // print_r($_POST); die;


        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        if (!isset($_POST['PPPasienM'])) {
            $msg = "Form Pasien belum Lengkap";
            Yii::app()->end();
        }



        if (isset($_POST['PPPasienM']['pasien_id']) && !empty($_POST['PPPasienM']['pasien_id'])) goto prints;

        if (
            isset($_POST['PPPasienM']['no_identitas_pasien'])
            && !empty($_POST['PPPasienM']['no_identitas_pasien'])
            && $_POST['PPPasienM']['no_identitas_pasien'] != ''
        ) {
            // ktp
            $pasien = PasienM::model()->findByAttributes(array(
                'jenisidentitas' => 'KTP',
                'no_identitas_pasien' => $_POST['PPPasienM']['no_identitas_pasien'],
            ));



            if (!empty($pasien)) {
                $ok = 0;
                $msg = "KTP dengan Nomor " . $pasien->no_identitas_pasien . " sudah terdaftar atas Nama " . $pasien->nama_pasien . " - " . $pasien->no_rekam_medik;

                goto prints;
            }
        }


        prints:
        echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
    }



    /**
     * form verifikasi sebelum submit
     * @param type $id
     */
    public function actionVerifikasi()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $ok = 1;
            $msg = '';

            $this->layout = '//layouts/iframe';
            if (isset($_POST['PPPendaftaranT'])) {
                $format = new MyFormatter();
                $model = new PPPendaftaranT;
                $modPasien = new PPPasienM;
                $modPegawai = new PPPegawaiM;
                $modPenanggungJawab = null;
                $modRujukan = null;
                $modTindakan = array();

                $model->attributes = $_POST['PPPendaftaranT'];
                $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
                $model->jeniskasuspenyakit_id = Params::JENIS_KASUSPENYAKIT_ID_UMUM;
                $model->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
                $model->penjamin_id = Params::PENJAMIN_ID_UMUM;
                $model->keterangan_pendaftaran = "Pendaftaran via Anjungan Mandiri";


                $modPasien->attributes = $_POST['PPPasienM'];


                if (!empty($modPasien->pegawai_id)) {
                    $modPegawai->attributes = $modPasien->pegawai->attributes;
                }

                //if($_POST['PPPendaftaranT']['is_adakarcis']){
                if (isset($_POST['PPTindakanPelayananT'])) {
                    if (count((array)$_POST['PPTindakanPelayananT']) > 0) {
                        foreach ($_POST['PPTindakanPelayananT'] as $i => $karcis) {
                            if ($karcis['is_pilihtindakan']) {
                                $modTindakan[$i] = new PPTindakanPelayananT;
                                $modTindakan[$i]->attributes = $karcis;
                                $modTindakan[$i]->tarif_satuan = str_replace(',', '', $karcis['tarif_satuan']);
                                $modTindakan[$i]->karcis_id = $karcis['karcis_id'];
                            }
                        }
                    }
                }
                //}

            }


            echo CJSON::encode(array(
                'ok' => $ok,
                'msg' => $msg,
                'content' => $this->renderPartial('_verifikasi', array(
                    'model' => $model,
                    'modPasien' => $modPasien,
                    'modPegawai' => $modPegawai,
                    'modPenanggungJawab' => $modPenanggungJawab,
                    'modRujukan' => $modRujukan,
                    'modTindakan' => $modTindakan,
                    'format' => $format,
                ), true)
            ));
            Yii::app()->end();
        }
    }

    /**
     * menampilkan karcis
     */
    public function actionSetKarcis()
    {
        if (Yii::app()->request->isAjaxRequest) {

            $konfig = KonfigsystemK::model()->find();

            $format = new MyFormatter();
            $modTindakan = new PPTindakanPelayananT;
            $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
            $ruangan_id = $_POST['ruangan_id'];
            $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
            $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : "";
            $penjamin_id = $_POST['penjamin_id'];
            $form = '';

            $is_pasienbaru = 'true';
            if (!empty($ruangan_id)) {
                if (!empty($pasien_id)) {
                    $modP = PendaftaranT::model()->findByAttributes(array(
                        'pasien_id' => $pasien_id,
                    ), array(
                        'condition' => 'pasienbatalperiksa_id is null',
                    ));
                    $modPasien = PasienM::model()->findByPk($pasien_id);
                    if (isset($modPasien)) {
                        $is_pasienbaru = ($modPasien->statusrekammedis == Params::STATUSREKAMMEDIS_AKTIF && !empty($modP)) ? 'false' : 'true';
                    }
                } else if (trim($no_rekam_medik) != "") {
                    $is_pasienbaru = 'false';
                }
                $criteria = new CdbCriteria();
                $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
                $criteria->addCondition("ruangan_id = " . $ruangan_id);
                $criteria->addCondition("penjamin_id = " . $penjamin_id);
                $modKarcisAll = KarcisV::model()->findAll($criteria);

                if (Yii::app()->user->getState('karcisbarulama')) { //RND-7737
                    $criteria->addCondition("pasienbaru_karcis = $is_pasienbaru");
                }

                $modKarcisV = KarcisV::model()->findAll($criteria);

                // susun karcis global
                $modKarcisFinal = array();
                $modKarcisAda = array();
                foreach ($modKarcisAll as $item) {
                    if (empty($modKarcisAda[$item->daftartindakan_id])) {
                        $modKarcisAda[$item->daftartindakan_id] = 1;
                        $modKarcisFinal[] = $item;
                    }
                }


                $form = $this->renderPartial('_formKarcis', array('modKarcisAll' => $modKarcisFinal, 'modKarcisV' => $modKarcisV, 'modTindakan' => $modTindakan, 'format' => $format), true);
                $data['listKarcis'] = $form;
                echo json_encode($data);
                Yii::app()->end();
            }
            $data['listKarcis'] = $form;
            echo json_encode($data);
            Yii::app()->end();
        }
    }


    /**
     * proses simpan karcis
     * @param type $modTindakan
     * @param type $post
     * @return type
     */
    public function simpanKarcis($modTindakan, $model, $post)
    {
        $modTindakan->attributes = $post;
        $modTindakan->create_time = date("Y-m-d H:i:s");
        $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
        //$modTindakan->instalasi_id=Yii::app()->user->getState("instalasi_id");
        $modTindakan->instalasi_id = $model->instalasi_id;
        //$modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modTindakan->ruangan_id = $model->ruangan_id;
        $modTindakan->pendaftaran_id = $model->pendaftaran_id;
        $modTindakan->kelaspelayanan_id = $model->kelaspelayanan_id;
        $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
        $modTindakan->carabayar_id = $model->carabayar_id;
        $modTindakan->penjamin_id = $model->penjamin_id;
        $modTindakan->jeniskasuspenyakit_id = $model->jeniskasuspenyakit_id;
        $modTindakan->pasien_id = $model->pasien_id;
        $modTindakan->dokterpemeriksa1_id = $model->pegawai_id;
        $modTindakan->karcis_id = $post['karcis_id'];
        $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
        $modTindakan->qty_tindakan = 1;
        $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan();
        $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
        $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
        $modTindakan->cyto_tindakan = 0;
        $modTindakan->tarifcyto_tindakan = 0;
        $modTindakan->discount_tindakan = 0;
        $modTindakan->subsidiasuransi_tindakan = 0;
        $modTindakan->subsidipemerintah_tindakan = 0;
        $modTindakan->subsisidirumahsakit_tindakan = 0;
        $modTindakan->iurbiaya_tindakan = 0;
        $modTindakan->tarif_rsakomodasi = 0;
        $modTindakan->tarif_medis = 0;
        $modTindakan->tarif_paramedis = 0;
        $modTindakan->tarif_bhp = 0;

        if (!empty($modTindakan->karcis_id)) {
            $modTindakan->tipepaket_id = $this->tipePaketKarcis($model, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
        }

        if ($modTindakan->save()) {
            $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
            $this->karcistersimpan = true;
        } else {
            $this->karcistersimpan = false;
        }

        return $modTindakan;
    }


    /**
     * Mengurai data pasien berdasarkan pasien_id
     * @throws CHttpException
     */
    public function actionGetDataPasien()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $tgl_lahir = isset($_POST['tgl']) ? MyFormatter::formatDateTimeForDb($_POST['tgl']) : null;
            $no_rekam_medik = isset($_POST['no_rm']) ? $_POST['no_rm'] : null;
            $returnVal = array();

            $returnVal['kosong'] = false;

            if (!empty($no_rekam_medik) && !empty($tgl_lahir)) {
                //var_dump($no_rekam_medik); die;
                $p = PasienM::model()->findByAttributes(array(
                    'no_rekam_medik' => trim($no_rekam_medik),
                    'tanggal_lahir' => $tgl_lahir,
                ), array(
                    'order' => 'pasien_id desc'
                ));

                if (empty($p)) {
                    $returnVal['kosong'] = true;
                } else {
                    //var_dump($p->pasien_id); die;
                    $pendaftaran = PendaftaranT::model()->findByAttributes(array(
                        'pasien_id' => $p->pasien_id,
                    ), array(
                        'condition' => 'pasienbatalperiksa_id is null',
                        'order' => 'pendaftaran_id desc',
                    ));
                    if (empty($pendafaran)) {
                        $pendaftaran = PendaftaranT::model()->findByAttributes(array(
                            'pasien_id' => $p->pasien_id,
                        ), array(
                            'condition' => 'pasienbatalperiksa_id is null',
                            'order' => 'tgl_pendaftaran desc',
                        ));
                    }
                }
            } else {
                $pendaftaran = null;
            }

            $returnVal['lebih'] = false;
            $returnVal['adaDaftar'] = false;

            $pp = null;
            if (!empty($pendaftaran)) {
                $returnVal['listDaftar'] = $pendaftaran->attributes;
                $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien;
                $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan;
                $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi;

                $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                $pp = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);

                if (!empty($admisi)) {
                    $this->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal);
                } else {
                    //var_dump($pendaftaran->attributes);die;
                    switch ($pendaftaran->instalasi_id) {
                        case Params::INSTALASI_ID_RJ:
                            $this->periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, $returnVal);
                            break;
                        case Params::INSTALASI_ID_MCU:
                            $this->periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, $returnVal);
                            break;
                        case Params::INSTALASI_ID_HD:
                            $this->periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, $returnVal);
                            break;
                        case Params::INSTALASI_ID_RD:
                            $this->periksaValidasiPasienRD($pendaftaran, $admisi, $pp, $returnVal);
                            break;
                        case Params::INSTALASI_ID_RI:
                            $this->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal);
                            break;
                        case Params::INSTALASI_ID_ICU:
                            $this->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal);
                            break;
                        default:
                            $this->periksaValidasiPasienPenunjang($pendaftaran, $admisi, $pp, $returnVal);
                            break;
                    }
                }
                //die;
            }

            $returnVal['listDaftar']['pasien']['fingerprint_data'] = null;

            if (isset($_POST['is_manual']) && $_POST['is_manual'] == true) {
                $rm_last = PasienM::model()->find(array(
                    'condition' => 'ispasienluar = false',
                    'order' => 'no_rekam_medik desc'
                ));
                //echo $no_rekam_medik." ".$rm_last->no_rekam_medik; die;
                if ((int)$no_rekam_medik > (int)$rm_last->no_rekam_medik) {
                    $returnVal['lebih'] = true;
                    echo CJSON::encode($returnVal);
                    Yii::app()->end();
                }
            }


            $criteria = new CDbCriteria();
            if (!empty($pasien_id)) {
                $criteria->addCondition("pasien_id = " . $pasien_id);
            }
            if (!empty($no_rekam_medik)) {
                $criteria->addCondition("no_rekam_medik = '" . $no_rekam_medik . "'");
            }
            $criteria->addCondition('ispasienluar = FALSE');
            $model = PasienM::model()->find($criteria);
            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["fingerprint_data"] = null;
            $returnVal["tanggal_lahir"] = date("d/m/Y", strtotime($model->tanggal_lahir));
            if (!empty($model->pegawai_id)) {
                $returnVal['nomorindukpegawai'] = $model->pegawai->nomorindukpegawai;
                $returnVal['nama_pegawai'] = $model->pegawai->nama_pegawai;
                $returnVal['gelardepan'] = $model->pegawai->gelardepan;
                $returnVal['unit_perusahaan'] = $model->pegawai->unit_perusahaan;
                $returnVal['gelarbelakang_nama'] = isset($model->pegawai->gelarbelakang->gelarbelakang_nama) ? $model->pegawai->gelarbelakang->gelarbelakang_nama : "";
                $returnVal['jabatan_nama'] = isset($model->pegawai->jabatan->jabatan_nama) ? $model->pegawai->jabatan->jabatan_nama : "";
                $returnVal["nomorindukpegawai"] = $model->pegawai->nomorindukpegawai;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    function periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, &$returnVal)
    {   //var_dump($pendaftaran->attributes);
        if (!empty($pendaftaran->pasienpulang_id)) {
            // echo "Kick"; die;
            $pp = PasienpulangT::model()->findByPk($pendaftaran->pasienpulang_id);
            if ($pp->carakeluar_id == Params::CARAKELUAR_ID_RAWATINAP) {
                $returnVal['adaDaftar'] = true;
                $returnVal['listDaftar'] = $pendaftaran->attributes;
                $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
                $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
                $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
                if (!empty($pendaftaran->pasienadmisi_id)) {
                    $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                    $returnVal['adaInap'] = true;
                    $returnVal['listDaftar']['ruangan'] = $admisi->ruangan->attributes;
                } else {
                    $returnVal['tindakLanjut'] = true;
                }
            }
        } else {
            $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                'pendaftaran_id' => $pendaftaran->pendaftaran_id,
            ), array(
                'condition' => 'tindakansudahbayar_id is null  and qty_tindakan <> 0',
            ));
            $oa = ObatalkespasienT::model()->findByAttributes(array(
                'pendaftaran_id' => $pendaftaran->pendaftaran_id,
            ), array(
                'condition' => 'oasudahbayar_id is null and qty_oa <> 0',
            ));

            $isAda = false;
            if (!empty($oa) || !empty($tindakan)) {
                if (empty($pendaftaran->pembayaranpelayanan_id))
                    $isAda = true;
            }

            // var_dump($isAda); die;
            if ($isAda && !in_array($pendaftaran->statusperiksa, array(Params::STATUSPERIKSA_SUDAH_DIPERIKSA, Params::STATUSPERIKSA_SUDAH_PULANG))) {
                $returnVal['adaDaftar'] = true;
                $returnVal['listDaftar'] = $pendaftaran->attributes;
                $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
                $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
                $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
            }
        }
    }

    function periksaValidasiPasienRD($pendaftaran, $admisi, $pp, &$returnVal)
    {
        if (!empty($pendaftaran->pasienpulang_id)) {
            $pp = PasienpulangT::model()->findByPk($pendaftaran->pasienpulang_id);
            if ($pp->carakeluar_id == Params::CARAKELUAR_ID_RAWATINAP) {
                $returnVal['adaDaftar'] = true;
                $returnVal['listDaftar'] = $pendaftaran->attributes;
                $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
                $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
                $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
                if (!empty($pendaftaran->pasienadmisi_id)) {
                    $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                    $returnVal['adaInap'] = true;
                    $returnVal['listDaftar']['ruangan'] = $admisi->ruangan->attributes;
                } else {
                    $returnVal['tindakLanjut'] = true;
                }
            }
        } else {
            $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                'pendaftaran_id' => $pendaftaran->pendaftaran_id,
            ), array(
                'condition' => 'tindakansudahbayar_id is null and qty_tindakan <> 0',
            ));
            $oa = ObatalkespasienT::model()->findByAttributes(array(
                'pendaftaran_id' => $pendaftaran->pendaftaran_id,
            ), array(
                'condition' => 'oasudahbayar_id is null and qty_oa <> 0',
            ));

            $isAda = false;
            if (!empty($oa) || !empty($tindakan)) {
                if (empty($pendaftaran->pembayaranpelayanan_id))
                    $isAda = true;
            }

            if ($isAda || !in_array($pendaftaran->statusperiksa, array(Params::STATUSPERIKSA_SUDAH_PULANG))) {
                $returnVal['adaDaftar'] = true;
                $returnVal['listDaftar'] = $pendaftaran->attributes;
                $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
                $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
                $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
            }
        }
    }

    function periksaValidasiPasienRI($pendaftaran, $admisi, $pp, &$returnVal)
    {
        if (empty($pendaftaran->pasienpulang_id)) {
            $returnVal['adaDaftar'] = true;
            $returnVal['listDaftar'] = $pendaftaran->attributes;
            $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
            $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
            $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
            $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
            if (!empty($admisi)) {

                if ($pendaftaran->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG || $pendaftaran->statusperiksa == Params::STATUSPERIKSA_BATAL_PERIKSA) {
                    $returnVal['adaDaftar'] = false;
                } else {
                    $returnVal['adaInap'] = true;
                    $returnVal['listDaftar']['ruangan'] = $admisi->ruangan->attributes;
                }
            } else {
                if ($pendaftaran->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG || $pendaftaran->statusperiksa == Params::STATUSPERIKSA_BATAL_PERIKSA) {
                    $returnVal['adaDaftar'] = false;
                }
                //var_dump($admisi);
            }
        } else {
            //var_dump($pendaftaran->statusperiksa);
            if ($pendaftaran->statusperiksa != Params::STATUSPERIKSA_SUDAH_PULANG && $pendaftaran->statusperiksa != Params::STATUSPERIKSA_BATAL_PERIKSA) {
                //var_dump($pendaftaran->statusperiksa);
                $returnVal['adaDaftar'] = true;
                $returnVal['listDaftar'] = $pendaftaran->attributes;
                $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
                $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
                $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
                $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                if (!empty($admisi)) {
                    $returnVal['adaInap'] = true;
                    $returnVal['listDaftar']['ruangan'] = $admisi->ruangan->attributes;
                } else {
                    $returnVal['adaDaftar'] = false;
                }
            } else {
                $returnVal['adaDaftar'] = false;
            }
        }
        //var_dump($pendaftaran->pasienpulang_id);die;
    }

    function periksaValidasiPasienPenunjang($pendaftaran, $admisi, $pp, &$returnVal)
    {
        if (date('Y-m-d', time()) == date('Y-m-d', strtotime($pendaftaran->tgl_pendaftaran))) {
            $returnVal['adaDaftar'] = true;
            $returnVal['listDaftar'] = $pendaftaran->attributes;
            $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
            $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
            $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
        }
    }


    public function actionPrintStruk($id)
    {

        $this->layout = '//layouts/printWindows';

        $model = PendaftaranT::model()->findByPk($id);
        $pasien = $model->pasien;

        $this->render('printStruk', array(
            'model' => $model, 'pasien' => $pasien,
        ));
    }

    public function actionPrintKartu($id)
    {
        $this->layout = '//layouts/printWindows';
        $modPasien = PasienM::model()->findByPk($id);
        $judul_print = 'Kartu Pasien';
        $this->render(
            'pendaftaranPenjadwalan.views.pendaftaranRawatJalan.printKartuPasienKen',
            array(
                'modPasien' => $modPasien,
                'judul_print' => $judul_print
            )
        );
    }

    public function actionPrintHak()
    {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;

        $hak = new HakpasienM;
        //$modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));


        $judul_print = 'HAK DAN KEWAJIBAN PASIEN';
        $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatJalan.printHak', array(
            'format' => $format,
            'hak' => $hak,
            //'modLogin' => $modLogin,
            'judul_print' => $judul_print,
        ));
    }


    public function actionBpjsInterface()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            if (empty($_GET['param']) or $_GET['param'] === '') {
                die('param can\'not empty value');
            } else {
                $param = $_GET['param'];
            }
            $bpjs = new BpjsVklaim();

            switch ($param) {
                case '1':
                    $query = $_GET['query'];
                    print_r($bpjs->search_kartu($query));
                    break;
                case '2':
                    $query = $_GET['query'];
                    print_r($bpjs->search_nik($query));
                    break;

                case '3':
                    $query = $_GET['query'];
                    print_r($bpjs->search_rujukan_no_rujukan($query));
                    break;
                case '4':
                    $query = $_GET['query'];
                    $suksesrujukan = false;
                    $dataRujukan = json_decode($bpjs->search_rujukan_no_bpjs($query));

                    if (isset($dataRujukan->metaData)) {
                        if ($dataRujukan->metaData->message == 'OK') {
                            $suksesrujukan = true;
                        }
                    }

                    if ($suksesrujukan) {
                        print_r(json_encode($dataRujukan));
                    } else {
                        print_r($bpjs->search_kartu($query));
                    }
                    break;
                case '5':
                    $query = $_GET['query'];
                    $start = $_GET['start'];
                    $limit = $_GET['limit'];
                    print_r($bpjs->list_rujukan_tanggal($query, $start, $limit));
                    break;
                case '13':
                    $query = $_GET['query'];
                    print_r($bpjs->search_rujukan_pcare_multi($query));
                    break;
                case '17':
                    $query1 = $_GET['katakunci1'];
                    $query2 = MyFormatter::formatDateTimeForDb($_GET['katakunci2']);
                    $query3 = (!empty($_GET['katakunci3']) ? $_GET['katakunci3'] : "");
                    $query = $query1 . "/tglPelayanan/" . $query2 . "/Spesialis/" . $query3;
                    $start = 1;
                    $limit = 10;
                    print_r($bpjs->search_dpjp($query, $start, $limit));
                    break;
                default:
                    die('error number, please check your parameter option');
                    break;
            }
            Yii::app()->end();
        }
    }

    public function actionCekPasienBerdasarkanNoAsuransi()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $nomor = $_POST['nomor'];

        $asuransi = AsuransipasienM::model()->findByAttributes(array(
            'nopeserta' => $nomor,
        ), array(
            'order' => 'asuransipasien_id desc'
        ));

        $ok = 0;
        $pasien_id = null;
        $no_rekam_medik = null;
        $tgl_lahir = null;

        if (!empty($asuransi)) {
            $pasien_id = $asuransi->pasien_id;
            $no_rekam_medik = $asuransi->pasien->no_rekam_medik;
            $tgl_lahir = $asuransi->pasien->tanggal_lahir;
            $ok = 1;
        }

        echo CJSON::encode(array(
            'ok' => $ok,
            'pasien_id' => $pasien_id,
            'no_rekam_medik' => $no_rekam_medik,
            'tgl_lahir' => $tgl_lahir,
        ));
    }


    public function actionGetRujukanDariBpjs()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $kodeppk = $_POST['kodeppk'];
            $asarujukan = (isset($_POST['asarujukan']) ? $_POST['asarujukan'] : null);
            $data['rujukandari'] = "";
            $data['asalrujukan'] = "";

            $criteria = new CDbCriteria();

            if (!empty($asarujukan)) {
                $criteria->addCondition('asalrujukan_id = ' . $asarujukan);
            }
            $criteria->compare('kodeppk', $kodeppk, true);


            $model = RujukandariM::model()->find($criteria);

            if (isset($model)) {
                $data['rujukandari'] = $model->rujukandari_id;
                $data['asalrujukan'] = $model->asalrujukan_id;

                $modRujukanDari = RujukandariM::model()->findAll('asalrujukan_id = ' . $model->asalrujukan_id . ' ORDER BY namaperujuk ASC');

                if (count((array)$modRujukanDari) > 0) {
                    $option = "";
                    $dataRujukan = CHtml::listData($modRujukanDari, 'rujukandari_id', 'namaperujuk');
                    foreach ($dataRujukan as $value => $name) {
                        $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                    $data['datarujukandari'] = $option;
                }
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionSetFormDokter()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $dokterList = $_POST['diagnosaList'];
            $form = '';
            $pesan = '';
            if (count((array)$dokterList) > 0) {
                foreach ($dokterList as $i => $dokter) {
                    $kode = $dokter['kode'];
                    $nama = $dokter['nama'];
                    $form .= "<tr>
                        <td>
                            <a class='btn-small' href='javascript:void(0);' onclick=\" $('#PPSepT_nama_dpjp').val('" . $nama . "');$('#PPSepT_kode_dpjp').val('" . $kode . "');$('#dialogDpjp').dialog('close'); \">
                            <i class='icon-form-check'></i></a>
                        </td>
                        <td>
                            <span id='kdPoli' name=[ii][kdPoli]'>" . $kode . "</span>
                        </td>
                        <td>
                            <span id='nmPoli' name=[ii][nmPoli]'>" . $nama . "</span>
                        </td>
                    </tr>";
                }
            } else {
                $pesan = "Data tidak ada!";
            }

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }

    public function actionSetFormDokterMelayani()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $dokterList = $_POST['diagnosaList'];
            $form = '';
            $pesan = '';
            if (count($dokterList) > 0) {
                foreach ($dokterList as $i => $dokter) {
                    $kode = $dokter['kode'];
                    $nama = $dokter['nama'];
                    $form .= "<tr>
                        <td>
                            <a class='btn-small' href='javascript:void(0);' onclick=\" $('#PPSepT_dpjpygmelayani_nama').val('" . $nama . "');$('#PPSepT_dpjpygmelayani_kode').val('" . $kode . "');$('#dialogDpjpMelayani').dialog('close'); \">
                            <i class='icon-form-check'></i></a>
                        </td>
                        <td>
                            <span id='kdPoli' name=[ii][kdPoli]'>" . $kode . "</span>
                        </td>
                        <td>
                            <span id='nmPoli' name=[ii][nmPoli]'>" . $nama . "</span>
                        </td>
                    </tr>";
                }
            } else {
                $pesan = "Data tidak ada!";
            }

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }

    /**
     * @param type $sep_id
     */
    public function actionPrintSep($sep_id, $pendaftaran_id)
    {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modRujukanBpjs = new PPRujukanbpjsT;
        $modSep = PPSepT::model()->findByPk($sep_id);
        $modSep->print_ke++;
        $modSep->update(array('print_ke'));
        $bpjs = new Bpjs();
        $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta' => $modSep->nokartuasuransi));
        $modJenisPeserta = PPJenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
        if (isset($modSep->norujukan)) {
            $modRujukanBpjs = PPRujukanbpjsT::model()->findByAttributes(array('no_rujukan' => $modSep->norujukan));
        }
        $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modRujukan = RujukanT::model()->findByPk($modPendaftaran->rujukan_id);


        $judul_print = 'SURAT ELIGIBILITAS PESERTA';
        $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatJalan.printSep_baru', array(
            'format' => $format,
            'modSep' => $modSep,
            'judul_print' => $judul_print,
            'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
            'modRujukanBpjs' => $modRujukanBpjs,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modJenisPeserta' => $modJenisPeserta,
            'modRujukan' => $modRujukan,
        ));
    }
}
