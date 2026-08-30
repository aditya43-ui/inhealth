<?php

/**
 * @package application.modules.pendaftaranPenjadwalan
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class PendaftaranRehabMedisController extends MyAuthController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = "pendaftaranPenjadwalan.views.pendaftaranRehabMedis.";

    public $pasientersimpan = false;
    public $pendaftarantersimpan = false;
    public $penanggungjawabtersimpan = false;
    public $karcistersimpan = false;
    public $komponentindakantersimpan = false;
    public $rujukantersimpan = false;
    public $asuransipasientersimpan = false;
    public $septersimpan = false;
    public $skptersimpan = false;
    public $is_rm_manual = false;
    public $pendaftaranmultipolitersimpan = false;

    public $is_pasien_baru = false;
    public $bpjs_error = "";

    public $is_simpanpaket = true;
    public $isjanjipoli = false;

    /**
     * menampilkan detail pendaftaran
     * @param type $id
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $modPasien = PPPasienM::model()->findByPk($model->pasien_id);
        $modPegawai = new PPPegawaiM;
        if (!empty($modPasien->pegawai_id)) {
            $modPegawai = PPPegawaiM::model()->findByPk($modPasien->pegawai_id);
        }
        $modPenanggungJawab = null;
        $modRujukan = null;

        if (!empty($model->penanggungjawab_id)) {
            $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
        }
        if (!empty($model->rujukan_id)) {
            $modRujukan = PPRujukanT::model()->findByPk($model->rujukan_id);
        }
        $modTindakan = PPTindakanPelayananT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
        $this->render('view', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPenanggungJawab' => $modPenanggungJawab,
            'modRujukan' => $modRujukan,
            'modTindakan' => $modTindakan,
        ));
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
            $cekNoKarcis = true;
            $is_kunjungan = $_POST['PPPendaftaranT']['is_kunjungan'];
            // var_dump( $_POST['PPPendaftaranT']);die;

            $this->layout = '//layouts/iframe';

            if (isset($_POST['PPPendaftaranT'])) {
                $format = new MyFormatter();
                $model = new PPPendaftaranT;
                $modPasien = new PPPasienM;
                $modPegawai = new PPPegawaiM;
                $modPenanggungJawab = null;
                $modRujukan = null;
                $modTindakan = null;


                // $kodebooking = '';
                // $jenispasien = '';
                // $nomorkartu = '';
                // $nik = '';
                // $nohp = '';
                // $kodepoli = '';
                // $namapoli = '';
                // $pasienbaru = '';
                // $norm = '';
                // $tanggalperiksa = '';
                // $kodedokter = '';
                // $namadokter = '';
                // $jamprakter = '';
                // $jeniskunjungan = '';
                // $nomorreferensi = '';
                // $nomorantrean = '';
                // $angkaantrean = '';
                // $estimasidilayani = '';
                // $sisakuotajkn = '';
                // $kuotajkn = '';
                // $sisakuotanonjkn = '';
                // $kuotanonjkn = '';
                // $keterangan = '';
                $is_adapjpasien = 1;

                $model->attributes = $_POST['PPPendaftaranT'];
                $model->keluhan = $_POST['PPPendaftaranT']['keluhan'];
                $model->keterangan_pendaftaran = $_POST['PPPendaftaranT']['keterangan_pendaftaran'];
                $model->diagnosamasuk = $_POST['PPPendaftaranT']['diagnosamasuk'];

                $model->is_kunjungan = $is_kunjungan;
                $modPasien->attributes = $_POST['PPPasienM'];
                $modPasien->nama_bin = $_POST['PPPasienM']['nama_bin'];
                $modPasien->kepercayaan = $_POST['PPPendaftaranT']['kepercayaan'];
                $modPasien->alamat_domisili_pasien =  $_POST['PPPasienM']['alamat_domisili_pasien'];
                //  $modPasien->diagnosamasuk =  $_POST['PPPendaftaranT']['diagnosamasuk'];

                $modPasien->no_rekam_medik = $_POST['cari_no_rekam_medik'];

                if (!empty($modPasien->pegawai_id)) {
                    $modPegawai->attributes = $modPasien->pegawai->attributes;
                }
                // var_dump($modPasien->no_rekam_medik);die;
                if ($is_kunjungan == 1) {
                    if ($_POST['PPPendaftaranT']['is_adapjpasien']) {
                        if (isset($_POST['PPPenanggungJawabM'])) {
                            $modPenanggungJawab = new PPPenanggungJawabM;
                            $modPenanggungJawab->attributes = $_POST['PPPenanggungJawabM'];
                        }
                    }

                    if ($_POST['PPPendaftaranT']['is_pasienrujukan']) {
                        if (isset($_POST['PPRujukanT'])) {
                            $modRujukan = new PPRujukanT;
                            $modRujukan->attributes = $_POST['PPRujukanT'];
                            $modRujukan->rujukandari_id = !empty($modRujukan->rujukandari_id) ? $modRujukan->rujukandari_id : null;
                        }
                    }
                    if ($_POST['PPPendaftaranT']['is_adakarcis']) {
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
                    }
                }
            }
            if ($is_kunjungan == 1) {
                if (isset($_POST['PPTindakanPelayananT'])) {

                    if (count((array)$_POST['PPTindakanPelayananT']) > 0) {
                        foreach ($_POST['PPTindakanPelayananT'] as $i => $karcis) {
                            if ($karcis['is_pilihtindakan']) {
                                if (!empty($karcis['karcis_id'])) {
                                    $cekNoKarcis = $cekNoKarcis && false;
                                } else {
                                    $cekNoKarcis = $cekNoKarcis && true;
                                }
                            }
                        }
                    }
                }

                if ($cekNoKarcis == true) {
                    // $ok = 0;
                    // $msg = "Maaf, Karcis tidak ditemukan";
                }
            } else {
                // $ok = 0;
                // $msg = "Maaf, Karcis tidak ditemukan";
            }


            // print_r($modTindakan);exit();
            //                 foreach ($modTindakan as $key => $f ) {
            //                     # code...
            // print_r($f->tarif_satuan);exit();

            //                 }

            echo CJSON::encode(array(
                'ok' => $ok,
                'msg' => $msg,
                'content' => $this->renderPartial('verifikasi', array(
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
     * load dara rujukan dari
     * @param type $encode
     * @param type $namaModel
     */
    public function actionGetRujukanDari($encode = false, $namaModel = '')
    {
        if (Yii::app()->request->isAjaxRequest) {
            $asalrujukan_id = $_POST["$namaModel"]['asalrujukan_id'];

            if ($encode) {
                echo CJSON::encode($rujukandari);
            } else {
                if (empty($asalrujukan_id)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    $rujukandari = RujukandariM::model()->findAllByAttributes(array('asalrujukan_id' => $asalrujukan_id), array('order' => 'namaperujuk'));
                    $rujukandari = CHtml::listData($rujukandari, 'rujukandari_id', 'namaperujuk');
                    foreach ($rujukandari as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * load ppk rujukan
     */
    public function actionGetPPKRujukan()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['rujukan_id'])) {
                $rujukan = RujukandariM::model()->findByPk($_POST['rujukan_id']);
                echo $rujukan->ppkrujukan;
            } else {
                echo "";
            }
        }
    }

    /**
     * Index transaksi pendaftaran
     * @param type $id
     * @param type $idSep
     * @param type $idAntrian
     * @param type $sk_id
     */
    public function actionIndex($id = null, $idSep = null, $idAntrian = null, $sk_id = null)
    {


        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_GET['ajax'])) {
                $ajax = $_GET['ajax'];
                if ($ajax == 'daftar-antrian-grid') {
                    $this->renderPartial($this->path_view . 'grid/_listAntrian', []);
                    exit;
                }
            }
        }

        // if (Yii::app()->request->isAjaxRequest){
        //     if (isset($_GET['ajax'])){
        //         $ajax = $_GET['ajax'];
        //         if ($ajax == 'daftar-list-antrian-grid'){
        //             $this->renderPartial($this->path_view.'grid/_listAntrian',[]);
        //             Yii::app()->end();
        //         }
        //     }
        // }

        $format = new MyFormatter();
        $model = new PPPendaftaranT;
        $modPasien = new PPPasienM;
        $modPegawai = new PPPegawaiM;
        $modPenanggungJawab = new PPPenanggungJawabM;
        $modRujukan = new PPRujukanT;
        $modRujukanBpjs = new PPRujukanbpjsT;
        $modTindakan = new PPTindakanPelayananT;
        $modPembayaran = new PPPembayaranpelayananT();

        $modAntrian = new PPAntrianT;
        $modAsuransiPasien = new PPAsuransipasienM;
        $modAsuransiPasienBpjs = new PPAsuransipasienbpjsM;
        $modAsuransiPasienBadak = new PPAsuransipasienbadakM();
        $modAsuransiPasienDepartemen = new PPAsuransipasiendepartemenM();
        $modAsuransiPasienPekerja = new PPAsuransipasienpegawaiM();
        $modPendaftaranMultiPoli = new PPPendaftaranMultipoli();




        $modRujukanInhealth = new PPRujukanInhealthT;
        $modRujukanInhealth->tanggal_rujukan = date('Y-m-d H:i:s');
        $model->slotantrian = true;
        $modAsuransiPasienInhealth = new PPAsuransipasieninhealthM;
        $modSkpInhealthT = new PPSkpInhealthT;
        $modSkpInhealthT->tglskp = date('Y-m-d H:i:s');
        $modSkpInhealthT->jnspelayanan = 3; //defaul RJTL

        $modSepInhealthT = new PPSepInhealthT;
        $modSepInhealthT->tglsep = date('Y-m-d H:i:s');
        $modSepInhealthT->jnspelayanan = 3; //defaul RJTL

        $modSkp = new PPSkpT;
        $modSkp->tglskp = date('Y-m-d H:i:s');
        $modSkp->jnspelayanan = 2; //defaul rajal
        $modSkp->poli_eksekutif = 0;
        $modSkp->cob = 0;
        $modSkp->lakalantas = 0;
        $modSkp->jenisfaskes = 2; //default RS
        $modSkp->katarak = 0;
        $modSkp->suplesi_jasaraharja = 0;
        $modSkp->status_noskp = "TIDAK";
        $modProfilRS = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $modSkp->ppkpelayanan = $modProfilRS->ppkpelayanan;
        $modSkp->pelayanan = 'RJ';

        // floor($data['terlambat_mnt'] / 3600).' Jam '.(($data['terlambat_mnt'] / 60) % 60).' Menit '.($data['terlambat_mnt'] % 60).' Detik';

        $modSep = new PPSepT;
        $dataTindakans = array();
        $modKarcisV = array();
        $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
        $modPegawaiPJ = new PPPegawaiM;
        //$modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
        //$modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
        //$modPasien->kelurahan_id = Yii::app()->user->getState('kelurahan_id');
        $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
        //$modPasien->agama = Params::DEFAULT_AGAMA;
        $model->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
        $model->is_bpjs = 0;
        $model->is_asubadak = 0;
        $model->is_asudepartemen = 0;
        $model->is_asupekerja = 0;
        $model->is_adapjpasien = 0;
        $model->tgl_pendaftaran = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
        $model->instalasi_id = Params::INSTALASI_ID_REHAB;
        $model->jeniskasuspenyakit_id = 459;
        $model->ruangan_id = 1065;

        $modSep->jenis_kunjungan = "0";
        $modSep->asesmen_pelayanan = "";
        $modSep->tgl_awal = date('Y-m-d', strtotime('-90 Days'));
        $modSep->tgl_akhir = date('Y-m-d');

        $nama_modul = Yii::app()->controller->module->id;
        $nama_controller = Yii::app()->controller->id;
        $nama_action = Yii::app()->controller->action->id;
        $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
        $criteria = new CDbCriteria;
        $criteria->compare('modul_id', $modul_id);
        $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
        $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
        if (isset($_POST['tujuansms'])) {
            $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
        }
        $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

        //Check if is bridging false or true
        $konfig = KonfigsystemK::model()->find();
        if ($konfig->isbridging == false) {
            $model->is_bpjs_manual = 1;
        } else {
            $model->is_bpjs_manual = 0;
        }

        $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;


        if (!empty($_GET['antrian_id'])) {
            $modAntrian = PPAntrianT::model()->findByPk($_GET['antrian_id']);
        }


        if (isset($_POST['buatjanjipoli_id'])) { //dari informasi janji poli
            if (!empty($_POST['buatjanjipoli_id'])) {
                $modJanjipoli = PPBuatJanjiPoliT::model()->findByPk($_POST['buatjanjipoli_id']);

                if (!empty($modJanjipoli->pasien_id)) {
                    $modPasien = PPPasienM::model()->findByPk($modJanjipoli->pasien_id);
                    // $model->norm_buatpolik = $modPasien->no_rekam_medik;
                    //$modPasien->tanggal_lahir = date('d/m/Y',strtotime($modPasien->tanggal_lahir));
                    if ($modPasien->ispasienluar == TRUE) {
                        $modPasien->no_rekam_medik = null;
                        //$modPasien->pasien_id = null;
                    }
                }
                $model->no_urutantri = $modJanjipoli->no_antrianjanji;
                $model->buatjanjipoli_id = $_POST['buatjanjipoli_id'];
                if (!empty($modJanjipoli->ruangan_id)) {
                    $model->ruangan_id = $modJanjipoli->ruangan_id;
                }

                if (!empty($modJanjipoli->pegawai_id)) {
                    $model->pegawai_id = $modJanjipoli->pegawai_id;
                    $model->nama_pegawai = (!empty($modJanjipoli->pegawai) ? $modJanjipoli->pegawai->namaLengkap : null);
                }

                $model->no_urutantri = $modJanjipoli->no_antrianjanji;
                $model->buatjanjipoli_id = $_POST['buatjanjipoli_id'];
                $model->tgl_pendaftaran = MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modJanjipoli->tgljadwal)));

                if (!empty($modJanjipoli->penjamin_id)) {
                    $model->penjamin_id = $modJanjipoli->penjamin_id;
                    $model->carabayar_id = (!empty($modJanjipoli->penjamin) ? $modJanjipoli->penjamin->carabayar_id : null);
                }
                $model->jeniskasuspenyakit_id = $modJanjipoli->jeniskasuspenyakit_id;
            }
        }

        //==load data

        if (!empty($idAntrian)) {
            $modAntrian = PPAntrianT::model()->findByPk($idAntrian, array(
                'condition' => 'pendaftaran_id is null',
            ));
            if (empty($modAntrian)) {
                $modAntrian = new PPAntrianT;
            } else {
                $model->antrian_id = $modAntrian->antrian_id;
            }
        }

        if (isset($id)) {
            $model = $this->loadModel($id);

            if (isset($idSep)) {
                $Sep = SepT::model()->findByPk($idSep);
                $model->is_bpjs = isset($Sep->is_inhealth) ? 0 : 1;
                if ($Sep->is_inhealth) {
                    $modRujukanInhealth = PPRujukanInhealthT::model()->findByPk($model->rujukan_id);
                    $modAsuransiPasienInhealth = PPAsuransipasieninhealthM::model()->findByPk($model->asuransipasien_id);
                    $modSepInhealthT = PPSepInhealthT::model()->findByPk($idSep);
                } else {
                    $modRujukanBpjs = PPRujukanbpjsT::model()->findByPk($model->rujukan_id);
                    $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByPk($model->asuransipasien_id);
                    $modSep = PPSepT::model()->findByPk($idSep);
                }
            }
            $modPasien = PPPasienM::model()->findByPk($model->pasien_id);
            $modPasien->tanggal_lahir = date('d/m/Y', strtotime($modPasien->tanggal_lahir));
            // var_dump($modPasien);die;
            if (!empty($model->penanggungjawab_id)) {
                $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
                if (!empty($modPenanggungJawab->pegawai_id)) {
                    $modPasien->pegawai_penanggungjawab_id = $modPenanggungJawab->pegawai_id;
                    $modPegawaiPJ = PPPegawaiM::model()->findByPk($modPenanggungJawab->pegawai_id);
                }
            }
            if (!empty($model->rujukan_id)) {
                $modRujukan = PPRujukanT::model()->findByPk($model->rujukan_id);
            }
            $dataTindakans = PPTindakanPelayananT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
            $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
        }

        if (isset($idSep)) {
            $modSep = PPSepT::model()->findByPk($idSep);
        }
        // var_dump( $modPasien->tanggal_lahir);die;
        $pasien_id = (isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null);
        if (!empty($pasien_id)) {
            $modPasien = PPPasienM::model()->findByPk($pasien_id);
            $modPasien->tanggal_lahir = date('d/m/Y', strtotime($modPasien->tanggal_lahir));
            // var_dump($modPasien->tanggal_lahir);
            // die;
        }
        if (!empty($modPasien->pegawai_id)) {
            $modPegawai->attributes = $modPasien->pegawai->attributes;
        }

        $ruangan = null;
        if (!empty($sk_id)) {
            $sk = SuratketeranganR::model()->findByPk($sk_id);
            $p = PendaftaranT::model()->findByPk($sk->pendaftaran_id);
            $ruangan = $p->ruangankontrol_id;

            if ($p->carabayar_id == Params::CARABAYAR_ID_BPJS) {
                $asuransi = PPAsuransipasienbpjsM::model()->findByPk($p->asuransipasien_id);
                if (empty($asuransi)) $asuransi = PPAsuransipasienbpjsM::model()->findByAttributes(array(
                    'pasien_id' => $p->pasien_id,
                    'carabayar_id' => $p->carabayar_id,
                ));
                if (!empty($asuransi)) {
                    $rujuk = RujukandariM::model()->findByPk(Params::RUJUKANDARI_ID_ABE);
                    $modAsuransiPasienBpjs->nopeserta = $asuransi->nopeserta;
                    $modRujukanBpjs->asalrujukan_id = Params::ASALRUJUKAN_ID_RS;

                    if (!empty($rujuk)) {
                        $modRujukanBpjs->rujukandari_id = $rujuk->rujukandari_id;
                        $modRujukanBpjs->nama_perujuk = $rujuk->namaperujuk;
                        $modRujukanBpjs->tanggal_rujukan = date('Y-m-d H:i:s');
                        $modRujukanBpjs->no_rujukan = date('dmYHi', strtotime($p->tglrenkontrol) + (3600 * 24 * 3));
                        $modSep->ppkrujukan = $rujuk->ppkrujukan;

                        // var_dump($modRujukanBpjs->attributes); die;
                    }
                }
            }
        }

        if (isset($_GET['id'])) {
            $modelPendaftaran = PendaftaranT::model()->findByPk($_GET['id']);
            $sep_id = isset($_GET['sep_id']) ? $_GET['sep_id'] : '';
            $this->tambahAntrian($modelPendaftaran, $sep_id);
        }



        if (isset($_POST['PPPendaftaranT'])) {

            $is_kunjungan = $_POST['PPPendaftaranT']['is_kunjungan'];

            if ($is_kunjungan == 0) {
                $modPasien = $this->simpanPasien($modPasien, $_POST['PPPasienM'], $_POST['PPPendaftaranT']);
                $this->redirect(array('index', 'pasien_id' => $modPasien->pasien_id, 'sukses' => 1));
            } else {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    // var_dump($_POST);die;

                    $modPasien = $this->simpanPasien($modPasien, $_POST['PPPasienM'], $_POST['PPPendaftaranT']);

                    if ($_POST['PPPendaftaranT']['is_adapjpasien']) {
                        if (isset($_POST['PPPenanggungJawabM'])) {
                            $modPenanggungJawab = $this->simpanPenanggungjawab($modPenanggungJawab, $_POST['PPPenanggungJawabM']);
                        }
                    } else {
                        $this->penanggungjawabtersimpan = true;
                    }

                    if (isset($_POST['PPPasienM']['pegawai_penanggungjawab_id'])) {
                        $modPenanggungJawab = $this->simpanPenanggungjawabDokter($modPenanggungJawab, $_POST['PPPasienM']['pegawai_penanggungjawab_id']);
                    }

                    if ($_POST['PPPendaftaranT']['is_pasienrujukan']) {
                        if (isset($_POST['PPRujukanT'])) {
                            $modRujukan = $this->simpanRujukan($modRujukan, $_POST['PPRujukanT']);
                        }
                    } else {
                        $this->rujukantersimpan = true;
                    }

                    if (isset($_POST['PPPendaftaranT']['is_bpjs_rj']) && $_POST['PPPendaftaranT']['is_bpjs_rj']) {
                        if (isset($_POST['PPRujukanbpjsT'])) {
                            $modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['PPRujukanbpjsT']);
                        }
                    } else {
                        $this->rujukantersimpan = true;
                    }

                    /* Untuk penjamin inhealth */
                    if (isset($_POST['PPRujukanInhealthT'])) {
                        $modRujukanInhealth = $this->simpanRujukanBpjs($modRujukanInhealth, $_POST['PPRujukanInhealthT']);
                    }

                    if (isset($_POST['PPAsuransipasienM'])) {
                        if (isset($_POST['PPAsuransipasienM']['asuransipasien_id'])) {
                            if (!empty($_POST['PPAsuransipasienM']['asuransipasien_id'])) {
                                $modAsuransiPasien = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienM']['asuransipasien_id']);
                            }
                        }
                        $modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienM']);
                    } else {
                        $this->asuransipasientersimpan = true;
                    }

                    if (isset($_POST['PPAsuransipasienbpjsM'])) {
                        if (isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
                            if (!empty($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
                                $modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
                            }
                        }
                        $modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbpjsM']);
                    } else {
                        $this->asuransipasientersimpan = true;
                    }

                    /* Untuk penjamin inhealth */
                    if (isset($_POST['PPAsuransipasieninhealthM'])) {
                        if (isset($_POST['PPAsuransipasieninhealthM']['asuransipasien_id'])) {
                            if (!empty($_POST['PPAsuransipasieninhealthM']['asuransipasien_id'])) {
                                $modAsuransiPasienInhealth = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasieninhealthM']['asuransipasien_id']);
                            }
                        }
                        $modAsuransiPasienInhealth = $this->simpanAsuransiPasien($modAsuransiPasienInhealth, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasieninhealthM']);
                    } else {
                        $this->asuransipasientersimpan = true;
                    }

                    if ($_POST['PPPendaftaranT']['carabayar_id'] == Params::CARABAYAR_ID_JAMKESPA || $_POST['PPPendaftaranT']['carabayar_id'] == Params::CARABAYAR_ID_JAMKESDA) {
                        $model = $this->simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $modAsuransiPasien);
                        //                    if (isset($_POST['PPSkpT'])) {
                        $modSkp = $this->simpanSkp($model, $modPasien, $modRujukan, $modAsuransiPasien);
                        $model->skp_id = $modSkp->skp_id;
                        $model->no_rujukan = $modSkp->norujukan;
                        $model->update();
                        //                    }
                    }
                    // echo "<pre>";
                    // var_dump($_POST);
                    // die;
                    if ($_POST['PPPendaftaranT']['is_bpjs_rj']) {
                        $model = $this->simpanPendaftaran($model, $modPasien, $modRujukanBpjs, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $modAsuransiPasienBpjs);
                        $this->karcistersimpan = true;
                        $this->komponentindakantersimpan = true;
                    } else {
                        if (isset($_POST['PPSepInhealthT']) && isset($_POST['PPRujukanInhealthT'])) { //simpan pendaftaran ketika brigin dengan inhealth
                            $model = $this->simpanPendaftaran($model, $modPasien, $modRujukanInhealth, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $modAsuransiPasienInhealth);
                        } else {
                            if (isset($_POST['PPSepInhealthT']) && isset($_POST['PPRujukanInhealthT'])) { //simpan pendaftaran ketika brigin dengan inhealth
                                $model = $this->simpanPendaftaran($model, $modPasien, $modRujukanInhealth, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $modAsuransiPasienInhealth);
                            } else {
                                $model = $this->simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $modAsuransiPasien);
                            }
                        }
                    }

                    /* Untuk penjamin inhealth */
                    // var_dump($_POST); die;
                    if (isset($_POST['PPSepInhealthT']) && isset($_POST['PPRujukanInhealthT'])) {
                        $modSep = $this->simpanSep($model, $modPasien, $modRujukanInhealth, $modAsuransiPasienInhealth, $_POST['PPSepInhealthT']);
                        $model->sep_id = $modSep->sep_id;
                        $model->ket_bridging = 'Sukses';
                        PPSepInhealthT::model()->updateByPk($modSep->sep_id, array('is_inhealth' => true));
                        $model->update();
                    }

                    if (isset($_POST['PPAsuransipasienbadakM'])) {
                        if (isset($_POST['PPAsuransipasienbadakM']['asuransipasien_id'])) {
                            if (!empty($_POST['PPAsuransipasienbadakM']['asuransipasien_id'])) {
                                $modAsuransiPasienBadak = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbadakM']['asuransipasien_id']);
                            }
                        }
                        $modAsuransiPasienBadak = $this->simpanAsuransiPasien($modAsuransiPasienBadak, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbadakM']);
                    } else {
                        $this->asuransipasientersimpan = true;
                    }

                    if (isset($_POST['PPAsuransipasiendepartemenM'])) {
                        if (isset($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id'])) {
                            if (!empty($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id'])) {
                                $modAsuransiPasienDepartemen = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id']);
                            }
                        }
                        $modAsuransiPasienDepartemen = $this->simpanAsuransiPasien($modAsuransiPasienDepartemen, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasiendepartemenM']);
                    } else {
                        $this->asuransipasientersimpan = true;
                    }

                    if (isset($_POST['PPAsuransipasienpegawaiM'])) {
                        if (isset($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id'])) {
                            if (!empty($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id'])) {
                                $modAsuransiPasienPekerja = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id']);
                            }
                        }
                        $modAsuransiPasienPekerja = $this->simpanAsuransiPasien($modAsuransiPasienPekerja, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienpegawaiM']);
                    } else {
                        $this->asuransipasientersimpan = true;
                    }

                    $this->karcistersimpan = true;
                    $this->komponentindakantersimpan = true;

                    if ($_POST['PPPendaftaranT']['is_adakarcis']) {
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


                    if (!empty($_POST['PPPendaftaranT']['buatjanjipoli_id'])) {
                        $modJanjipoli = PPBuatJanjiPoliT::model()->findByPk($_POST['PPPendaftaranT']['buatjanjipoli_id']);
                        $modJanjipoli->pendaftaran_id = $model->pendaftaran_id;
                        $modJanjipoli->save();
                    }

                    if (!empty($_POST['PPPendaftaranT']['buatjanjipoli_id'])) {
                        $modJanjipoli = PPBuatJanjiPoliT::model()->findByPk($_POST['PPPendaftaranT']['buatjanjipoli_id']);
                        $modJanjipoli->pendaftaran_id = $model->pendaftaran_id;
                        $modJanjipoli->save();
                    }

                    if (!empty($sk_id)) { // untuk rencana kontrol pendaftaran
                        $renKontrol = new PPBuatJanjiPoliT;
                        $renKontrol->pegawai_id = $model->pegawai_id;
                        $renKontrol->ruangan_id = $model->ruangan_id;
                        $renKontrol->pasien_id = $model->pasien_id;
                        $renKontrol->tglbuatjanji = $sk->create_time;
                        $renKontrol->harijadwal = MyFormatter::getDayUser(date('w'));
                        $renKontrol->tgljadwal = $p->tglrenkontrol;
                        $renKontrol->keteranganbuatjanji = Params::KETERANGAN_BUAT_JANJI_RENKONTROL;
                        $renKontrol->create_time = date('Y-m-d H:i:s');
                        $renKontrol->create_loginpemakai_id = Yii::app()->user->id;
                        $renKontrol->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $renKontrol->no_antrianjanji = MyGenerator::noAntrianJanjiPoli($model->ruangan_id);
                        $renKontrol->no_buatjanji = MyGenerator::noJanjiPoli("JP");
                        $renKontrol->pendaftaran_id = $model->pendaftaran_id;
                        $renKontrol->suratketerangan_id = $sk_id;

                        $renKontrol->save();
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
                        'RJInfokunjunganrjV[no_pendaftaran]' => '',
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


                    if ($_POST['PPPendaftaranT']['is_vaksinasi'] && isset($_POST['RiwayatvaksinasipasienT']['detail'])) {
                        $ok_vaksinasi = RiwayatvaksinasipasienT::simpanRiwayat($model->pendaftaran_id, $model->pasien_id, $_POST['RiwayatvaksinasipasienT']['detail']);
                    }


                    //Di set di form >> Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
                    //                      RND-666 >>>  $this->redirect(array('view','id'=>$model->pendaftaran_id,'sukses'=>1));
                    $smspasien = 1;
                    $smsdokter = 1;
                    $smspenanggungjawab = 1;
                    $noururtantri_antrian = $model->no_urutantri;


                    if (Yii::app()->user->getState('issmsgateway')) {
                        // SMS GATEWAY
                        $modPegawai = $model->pegawai;
                        $modRuangan = $model->ruangan;
                        $sms = new Sms();
                        $smspasien = 1;
                        $smsdokter = 1;
                        $smspenanggungjawab = 1;

                        $var_tgl_pendaftaran = MyFormatter::formatDateTimeForUser($model->tgl_pendaftaran);
                        $model->no_urutantri = $model->ruangan->ruangan_singkatan . "-" . $model->no_urutantri;

                        $modPegawai->nama_pegawai = $modPegawai->namaLengkap;



                        foreach ($modSmsgateway as $i => $smsgateway) {

                            if (isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
                                $isiPesan = $smsgateway->templatesms;
                                $isiPesan = "${isiPesan}";

                                $attributes = $modPasien->getAttributes();
                                foreach ($attributes as $attributes => $value) {
                                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                                }
                                $attributes = $modPenanggungJawab->getAttributes();
                                foreach ($attributes as $attributes => $value) {
                                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                                }
                                $attributes = $modPegawai->getAttributes();
                                foreach ($attributes as $attributes => $value) {
                                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                                }
                                $attributes = $model->getAttributes();
                                foreach ($attributes as $attributes => $value) {
                                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                                }
                                $attributes = $modRuangan->getAttributes();
                                foreach ($attributes as $attributes => $value) {
                                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                                }
                                $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($var_tgl_pendaftaran), $isiPesan);
                                $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);
                                $isiPesan = str_replace("\\n", hex2bin("0a"), $isiPesan);

                                // var_dump($smsgateway->tujuansms);

                                if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                                    if (!empty($modPasien->no_mobile_pasien)) {
                                        $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                                    } else {
                                        $smspasien = 0;
                                    }
                                } elseif ($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms) {
                                    if (!empty($modPegawai->nomobile_pegawai)) {
                                        $sms->kirim($modPegawai->nomobile_pegawai, $isiPesan);
                                    } else {
                                        $smsdokter = 0;
                                    }
                                } elseif ($smsgateway->tujuansms == Params::TUJUANSMS_PENANGGUNGJAWAB && $smsgateway->statussms) {
                                    if (!empty($modPenanggungJawab->no_mobilepj)) {
                                        $sms->kirim($modPenanggungJawab->no_mobilepj, $isiPesan);
                                    } else {
                                        $smspenanggungjawab = 0;
                                    }
                                }
                            }
                        }
                    } else {
                        $model->no_urutantri = $model->ruangan->ruangan_singkatan . "-" . $model->no_urutantri;
                    }



                    //multi poli 
                    $multiPoliResponse = array();

                    if ($_POST['PPPendaftaranT']['is_multipoli']) {
                        if (isset($_POST['PPPendaftaranMultipoli'])) {
                            foreach ($_POST['PPPendaftaranMultipoli'] as $keymultipoli => $postmultipoli) {
                                if (!empty($postmultipoli['ruangan_id'])) {
                                    $modPendaftaranMultiPoli = $this->simpanPendaftaranMultiPoli($modPendaftaranMultiPoli, $model, $modPasien, $modRujukan, $modPenanggungJawab, $postmultipoli, $_POST['PPPasienM'], $modAsuransiPasien);
                                    echo '== ' . $modPendaftaranMultiPoli->ruangan_id;
                                    if ($this->pendaftaranmultipolitersimpan) {
                                        $multiPoliResponse[] = array('pendaftaran_id' => $modPendaftaranMultiPoli->pendaftaran_id, 'instalasi_id' => $modPendaftaranMultiPoli->instalasi_id, 'tgl_pendaftaran' => $modPendaftaranMultiPoli->tgl_pendaftaran);
                                    }
                                }
                            }
                        }
                    } else {
                        $this->pendaftaranmultipolitersimpan = true;
                    }

                    // paket
                    if (isset($_POST['paket_medis'])) {
                        $this->simpanTindakanObatPaket($model, $_POST['paket_medis']);
                    }
                    // var_dump($this->is_simpanpaket); die;
                    // echo "<pre>";
                    // var_dump($this->is_simpanpaket, $ok_vaksinasi, $this->pasientersimpan, $this->pendaftarantersimpan, $this->penanggungjawabtersimpan, $this->rujukantersimpan, $this->karcistersimpan, $this->komponentindakantersimpan, $this->asuransipasientersimpan, $this->pendaftaranmultipolitersimpan);
                    // die;
                    if ($this->is_simpanpaket && $ok_vaksinasi && $this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan && $this->asuransipasientersimpan && $this->pendaftaranmultipolitersimpan) {
                        if ($this->is_pasien_baru) {
                            $this->cleanUpSessionPasienSudahBaca($model->pendaftaran_id);
                        }
                        if (isset($_POST['is_whatsapp']) && $_POST['is_whatsapp'] == 1) {
                            $this->kirimWhatsApp($model, $modPasien);
                        }
                        //                        
                        $transaction->commit();
                        if ($modPasien->is_random) {
                            $modPasien->generateNoRMDanSimpan();
                        }
                        $model->generateNoPendaftaranDanSimpan();

                        if (!empty($multiPoliResponse)) {
                            foreach ($multiPoliResponse as $rsp_multipoli) {
                                $model->generateNoPendaftaranMultipoli($rsp_multipoli['pendaftaran_id'], $rsp_multipoli['instalasi_id'], $rsp_multipoli['tgl_pendaftaran']);
                            }
                        }

                        if (isset($_POST['PPPendaftaranT']['is_bpjs_rj']) && $_POST['PPPendaftaranT']['is_bpjs_rj'] == 1) {
                            $modSep = $this->simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $_POST['PPSepT']);
                            $model->sep_id = $modSep->sep_id;
                            PendaftaranT::model()->updateByPk($model->pendaftaran_id, array('sep_id' => $modSep->sep_id));
                        }



                        if ($this->septersimpan) {
                            $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'idSep' => $modSep->sep_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter, 'smspenanggungjawab' => $smspenanggungjawab));
                        } else if ($this->skptersimpan) {
                            $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'idSkp' => $modSkp->skp_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter, 'smspenanggungjawab' => $smspenanggungjawab));
                        } else {
                            $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter, 'smspenanggungjawab' => $smspenanggungjawab));
                        }
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data pasien gagal disimpan !");
                        //                        echo "-".$this->pasientersimpan."<br>";
                        //                        echo "-".$this->pendaftarantersimpan."<br>";
                        //                        echo "-".$this->penanggungjawabtersimpan."<br>";
                        //                        echo "-".$this->rujukantersimpan."<br>";
                        //                        echo "-".$this->karcistersimpan."<br>";
                        //                        echo "-".$this->komponentindakantersimpan."<br>";
                        //                        exit;
                    }
                } catch (Exception $exc) {
                    var_dump($exc->getMessage(), $exc->getTraceAsString());
                    die;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $exc->getMessage());
                }
            }
        }

        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                if ($ajax == 'dokter-v-grid'){
                    $this->renderPartial($this->path_view . '_dialogPencarianDokter', ['model' => $model]);
                    Yii::app()->end();
                }
            }
        }


        $this->render('index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPegawai' => $modPegawai,
            'modPenanggungJawab' => $modPenanggungJawab,
            'modRujukan' => $modRujukan,
            'modRujukanBpjs' => $modRujukanBpjs,
            'modTindakan' => $modTindakan,
            'modAntrian' => $modAntrian,
            'modAsuransiPasien' => $modAsuransiPasien,
            'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
            'modAsuransiPasienBadak' => $modAsuransiPasienBadak,
            'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja,
            'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen,
            'dataTindakans' => $dataTindakans,
            'modSep' => $modSep,
            'modSmsgateway' => $modSmsgateway,
            'modKarcisV' => $modKarcisV,
            'ruangan' => $ruangan,
            'modPegawaiPJ' => $modPegawaiPJ,
            'modRujukanInhealth' => $modRujukanInhealth,
            'modAsuransiPasienInhealth' => $modAsuransiPasienInhealth,
            'modSepInhealthT' => $modSepInhealthT,
            'modSkpInhealthT' => $modSkpInhealthT,
            'modPendaftaranMultiPoli' => $modPendaftaranMultiPoli
        ));
    }

    public function tambahAntrian($model, $sep_id)
    {
        $trans = Yii::app()->db->beginTransaction();
        $noururtantri_antrian = $model->no_urutantri;
        $modPasien = PasienM::model()->findByPk($model->pasien_id);
        $tambahattr_antrianol = array();
        $antrianonline_arr = array();
        $index_antrianol = 0;

        $kodebooking = $model->no_pendaftaran;

        if (!empty($modJanjipoli)) {
            if (!empty($modJanjipoli->no_buatjanji)) {
                $kodebooking = $modJanjipoli->no_buatjanji;
            }
        }

        $jenispasien = (($model->carabayar_id == Params::CARABAYAR_ID_BPJS) ? "JKN" : "NON JKN");

        $nomorkartu = "";
        $nomorreferensi = "";

        if (!empty($modSep)) {
            $nomorkartu = (!empty($modSep->nokartuasuransi) ? $modSep->nokartuasuransi : "");
            $nomorreferensi = (!empty($modSep->norujukan) ? $modSep->norujukan : "");
        }
        $nik = $modPasien->no_identitas_pasien;
        $nohp = $modPasien->no_mobile_pasien;
        $norm = $modPasien->no_rekam_medik;

        $kodepoli = (!empty($model->ruangan) ? $model->ruangan->kode_bpjs : "");
        $namapoli = (!empty($model->ruangan) ? $model->ruangan->ruangan_nama : "");
        $pasienbaru = (($model->statuspasien == Params::STATUSPASIEN_BARU) ? 1 : 0);
        $tanggalperiksa = date('Y-m-d', strtotime($model->tgl_pendaftaran));
        $kodedokter = (!empty($model->pegawai) ? $model->pegawai->kodedokter_bpjs : "");
        $namadokter = (!empty($model->pegawai) ? $model->pegawai->nama_pegawai : "");

        $jadwaldokter = JadwaldokterM::model()->findByAttributes(array('pegawai_id' => $model->pegawai_id, 'jadwaldokter_tgl' => $tanggalperiksa));

        $jampraktek = "";
        $sisakuotajkn = 50;
        $kuotajkn = 100;
        $sisakuotanonjkn = 0;
        $kuotanonjkn = 0;

        if (!empty($jadwaldokter)) {
            $jam = $jadwaldokter->jadwaldokter_buka;
            $jamArray = explode(" ", $jam);
            $jamArray[1] = "-";
            $jamArray[0] = substr($jamArray[0], 0, 5);
            $jamArray[2] = substr($jamArray[2], 0, 5);
            $jamArray = implode('', $jamArray);
            $jampraktek = $jamArray;

            $sisakuotajkn = $jadwaldokter->maximumbpjsantrian;
            $kuotajkn = $jadwaldokter->maximumbpjsantrian;
            $sisakuotanonjkn = $jadwaldokter->maximumantrian;
            $kuotanonjkn = $jadwaldokter->maximumantrian;
        }
        $jeniskunjungan = 1;
        $nomorantrean = number_format($noururtantri_antrian);
        $angkaantrean = number_format($noururtantri_antrian);
        $estimasidilayani = $model->tglakandilayani;
        $stampwaktuantrian = strtotime($estimasidilayani);
        $estimasidilayani = $stampwaktuantrian * 1000;

        $keterangan = "Peserta harap 30 menit lebih awal guna pencatatan administrasi.";

        $antrianonlinebpjs = new AntrianOnlineBpjs();

        //tambah antrian
        $tambahattr_antrianol = array('typeantrian' => 'create', 'kodebooking' => $kodebooking, 'jenispasien' => $jenispasien, 'nomorkartu' => $nomorkartu, 'nik' => $nik, 'nohp' => $nohp, 'kodepoli' => $kodepoli, 'namapoli' => $namapoli, 'pasienbaru' => $pasienbaru, 'norm' => $norm, 'tanggalperiksa' => $tanggalperiksa, 'kodedokter' => $kodedokter, 'namadokter' => $namadokter, 'jampraktek' => $jampraktek, 'jeniskunjungan' => $jeniskunjungan, 'nomorreferensi' => $nomorreferensi, 'nomorantrean' => $nomorantrean, 'angkaantrean' => $angkaantrean, 'estimasidilayani' => $estimasidilayani, 'sisakuotajkn' => $sisakuotajkn, 'kuotajkn' => $kuotajkn, 'sisakuotanonjkn' => $sisakuotanonjkn, 'kuotanonjkn' => $kuotanonjkn, 'keterangan' => $keterangan);

        $cekAntrean = CJSON::decode($antrianonlinebpjs->antreanPerKodeBooking($kodebooking));

        if ($cekAntrean['metaData']['code'] == 200) {
            PendaftaranT::model()->updateByPk($model->pendaftaran_id, array('statuskirim_wsbpjs' => true));
        } else {
            if ($model->carabayar_id != Params::CARABAYAR_ID_BPJS) {
                $res_tambah = CJSON::decode($antrianonlinebpjs->tambah_antrian($tambahattr_antrianol));
                if ($res_tambah['metaData']['code'] == 200) {
                    PendaftaranT::model()->updateByPk($model->pendaftaran_id, array('statuskirim_wsbpjs' => true, 'respons_antrol' => $res_tambah['request_vars']));
                } else {
                    if (!empty($res_tambah['metaData']['message'])) {
                        PendaftaranT::model()->updateByPk($model->pendaftaran_id, array('respons_wsbpjs' => $res_tambah['metaData']['message'], 'respons_antrol' => $res_tambah['request_vars']));
                    }
                }
            }
        }

        if ($this->id == "pendaftaranRawatJalan") {
            if ($model->statuspasien == Params::STATUSPASIEN_BARU) {
                $modAntrianOri = AntrianT::model()->findByPk($model->antrian_id);
                $waktutunggupelayanan_1 = new WaktutunggupelayananT();
                $waktutunggupelayanan_1->pendaftaran_id = $model->pendaftaran_id;
                $waktutunggupelayanan_1->pasien_id = $model->pasien_id;
                $waktutunggupelayanan_1->task_id = 1;
                $lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type' => 'taskid', 'lookup_value' => $waktutunggupelayanan_1->task_id));
                $waktutunggupelayanan_1->task_name = (!empty($lookup_waktutunggu) ? $lookup_waktutunggu->lookup_name : null);
                $dateNowAntrian = date('c', strtotime(date("Y-m-d H:i:s", strtotime("-15 minutes"))));
                $waktutunggupelayanan_1->waktutunggu_rs = date("Y-m-d H:i:s", strtotime("-15 minutes"));
                $waktutunggupelayanan_1->tanggal = $waktutunggupelayanan_1->waktutunggu_rs;
                $waktutunggupelayanan_1->kode_booking = $model->no_pendaftaran;
                $waktutunggupelayanan_1->create_time = $waktutunggupelayanan_1->waktutunggu_rs;
                $waktutunggupelayanan_1->create_loginpemakai_id = Yii::app()->user->id;
                $waktutunggupelayanan_1->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                $waktutunggupelayanan_1->waktutunggu_mil = (strtotime($dateNowAntrian) * 1000);

                $body = array(
                    "kodebooking" => $kodebooking, "taskid" => $waktutunggupelayanan_1->task_id, "waktu" => $waktutunggupelayanan_1->waktutunggu_mil
                );
                $response = CJSON::decode($antrianonlinebpjs->update_waktu($body));
                if (
                    !empty($response['metaData']['code']) && $response['metaData']['code'] == '200'
                ) {
                    $waktutunggupelayanan_1->statuskirim = 1;
                    $waktutunggupelayanan_1->update_loginpemakai_id = Yii::app()->user->id;
                    $waktutunggupelayanan_1->update_time = date('Y-m-d H:i:s');
                } else {
                    $waktutunggupelayanan_1->statuskirim = 0;
                    $waktutunggupelayanan_1->response_list = $response['metaData']['message'];
                }
                $waktutunggupelayanan_1->save();

                $waktutunggupelayanan_2 = new WaktutunggupelayananT();
                $waktutunggupelayanan_2->pendaftaran_id = $model->pendaftaran_id;
                $waktutunggupelayanan_2->pasien_id = $model->pasien_id;
                $waktutunggupelayanan_2->task_id = 2;
                $lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type' => 'taskid', 'lookup_value' => $waktutunggupelayanan_2->task_id));
                $waktutunggupelayanan_2->task_name = (!empty($lookup_waktutunggu) ? $lookup_waktutunggu->lookup_name : null);
                $dateNowPanggil = date('c', strtotime(date("Y-m-d H:i:s", strtotime("-5 minutes"))));
                $waktutunggupelayanan_2->waktutunggu_rs = date("Y-m-d H:i:s", strtotime("-5 minutes"));
                $waktutunggupelayanan_2->tanggal = $waktutunggupelayanan_2->waktutunggu_rs;
                $waktutunggupelayanan_2->kode_booking = $model->no_pendaftaran;
                $waktutunggupelayanan_2->create_time = $waktutunggupelayanan_2->waktutunggu_rs;
                $waktutunggupelayanan_2->create_loginpemakai_id = Yii::app()->user->id;
                $waktutunggupelayanan_2->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                $waktutunggupelayanan_2->waktutunggu_mil = (strtotime($dateNowPanggil) * 1000);

                //update task_id
                $body = array(
                    "kodebooking" => $kodebooking, "taskid" => $waktutunggupelayanan_2->task_id, "waktu" => $waktutunggupelayanan_2->waktutunggu_mil
                );
                $response = CJSON::decode($antrianonlinebpjs->update_waktu($body));
                if (
                    !empty($response['metaData']['code']) && $response['metaData']['code'] == '200'
                ) {
                    $waktutunggupelayanan_2->statuskirim = 1;
                    $waktutunggupelayanan_2->update_loginpemakai_id = Yii::app()->user->id;
                    $waktutunggupelayanan_2->update_time = date('Y-m-d H:i:s');
                } else {
                    $waktutunggupelayanan_2->statuskirim = 0;
                    $waktutunggupelayanan_2->response_list = $response['metaData']['message'];
                }
                $waktutunggupelayanan_2->save();
            }

            $waktutunggupelayanan_3 = new WaktutunggupelayananT();
            $waktutunggupelayanan_3->pendaftaran_id = $model->pendaftaran_id;
            $waktutunggupelayanan_3->pasien_id = $model->pasien_id;
            $waktutunggupelayanan_3->task_id = 3;
            $lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type' => 'taskid', 'lookup_value' => $waktutunggupelayanan_3->task_id));
            $waktutunggupelayanan_3->task_name = (!empty($lookup_waktutunggu) ? $lookup_waktutunggu->lookup_name : null);
            $dateNow = date('c', strtotime(date('Y-m-d H:i:s')));
            $waktutunggupelayanan_3->waktutunggu_rs = date('Y-m-d H:i:s', strtotime($dateNow));
            $waktutunggupelayanan_3->tanggal = $waktutunggupelayanan_3->waktutunggu_rs;
            $waktutunggupelayanan_3->kode_booking = $model->no_pendaftaran;
            $waktutunggupelayanan_3->create_time = $waktutunggupelayanan_3->waktutunggu_rs;
            $waktutunggupelayanan_3->create_loginpemakai_id = Yii::app()->user->id;
            $waktutunggupelayanan_3->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
            $waktutunggupelayanan_3->waktutunggu_mil = (strtotime($dateNow) * 1000);

            //update task_id
            $body = array(
                "kodebooking" => $kodebooking, "taskid" => $waktutunggupelayanan_3->task_id, "waktu" => $waktutunggupelayanan_3->waktutunggu_mil
            );
            $response = CJSON::decode($antrianonlinebpjs->update_waktu($body));

            if (
                !empty($response['metaData']['code']) && $response['metaData']['code'] == '200'
            ) {
                $waktutunggupelayanan_3->statuskirim = 1;
                $waktutunggupelayanan_3->update_loginpemakai_id = Yii::app()->user->id;
                $waktutunggupelayanan_3->update_time = date('Y-m-d H:i:s');
            } else {
                $waktutunggupelayanan_3->statuskirim = 0;
                $waktutunggupelayanan_3->response_list = $response['metaData']['message'];
            }
            $waktutunggupelayanan_3->save();
        }
        $trans->commit();
        // akhir antrean
    }

    public function simpanTindakanObatPaket($model, $post, $admisi = null)
    {

        $ok = true;

        // var_dump($post); die;

        foreach ($post as $paketbmhp_id) {

            $tindakans = PaketbmhptindakanM::model()->findAllByAttributes(array(
                'paketbmhp_id' => $paketbmhp_id,
            ), array(
                'order' => 'paketbmhp_id asc'
            ));
            $obats = PaketbmhpobatM::model()->findAllByAttributes(array(
                'paketbmhp_id' => $paketbmhp_id,
            ), array(
                'order' => 'paketbmhp_id asc'
            ));

            // tindakan

            $tindakan_penunjang = array(
                Params::RUANGAN_ID_LAB_KLINIK => array('penunjang' => null, 'detail' => array()),
                Params::RUANGAN_ID_LAB_ANATOMI => array('penunjang' => null, 'detail' => array()),
                Params::RUANGAN_ID_RAD => array('penunjang' => null, 'detail' => array()),
                Params::RUANGAN_ID_FISIOTERAPI => array('penunjang' => null, 'detail' => array()),
            );


            foreach ($tindakans as $idx => $item) {

                $ruanganpenunjang_id = null;
                $periksa = null;
                $lab = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id' => $item->daftartindakan_id));
                if (!empty($lab)) {
                    //echo "Lab"; die;
                    $periksa = $lab;
                    $ruanganpenunjang_id = Params::RUANGAN_ID_LAB_KLINIK;
                }

                $rad = PemeriksaanradM::model()->findByAttributes(array('daftartindakan_id' => $item->daftartindakan_id));
                if (!empty($rad)) {
                    // echo "Rad"; die;
                    $periksa = $rad;
                    $ruanganpenunjang_id = Params::RUANGAN_ID_RAD;
                }

                $rehab = TindakanrmM::model()->findByAttributes(array('daftartindakan_id' => $item->daftartindakan_id));
                if (!empty($rehab)) {
                    // echo "Rehab"; die;
                    $periksa = $rehab;
                    $ruanganpenunjang_id = Params::RUANGAN_ID_FISIOTERAPI;
                }

                if (!empty($ruanganpenunjang_id)) {
                    if (empty($tindakan_penunjang[$ruanganpenunjang_id]['penunjang'])) {
                        $tindakan_penunjang[$ruanganpenunjang_id]['penunjang'] = $this->simpanPasienMasukPenunjang($model, $ruanganpenunjang_id);
                    }
                    $tindakan_penunjang[$ruanganpenunjang_id]['detail'][] = array('tindakan' => $item, 'periksa' => $periksa);
                    unset($tindakans[$idx]);
                }
            }

            foreach ($tindakan_penunjang as $ruangan_id => $item) {
                // var_dump($item['penunjang']);die;
                if ($ruangan_id == Params::RUANGAN_ID_LAB_KLINIK) {
                    $modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($model->pasien, $item['penunjang']);
                    // var_dump($modHasilPemeriksaan->attributes);

                    foreach ($item['detail'] as $item2) {
                        $tindakan = $this->simpanTindakanBMHP($model, $item2['tindakan'], $ruangan_id, $admisi);
                        $tindakan->pasienmasukpenunjang_id = $item['penunjang']->pasienmasukpenunjang_id;
                        $tindakan->save(false);
                        // var_dump($tindakan->attributes);
                        // var_dump($tindakan->attributes);
                    }

                    if (!empty($modHasilPemeriksaan)) {
                        $sysmex = new Sysmex;
                        $sysmex->kirim_tambah($modHasilPemeriksaan->hasilpemeriksaanlab_id);
                    }
                } else if ($ruangan_id == Params::RUANGAN_ID_RAD) {
                    foreach ($item['detail'] as $item2) {
                        $tindakan = $this->simpanTindakanBMHP($model, $item2['tindakan'], $ruangan_id, $admisi);
                        $this->simpanHasilPemeriksaanRad($item['penunjang'], $tindakan, $item2['periksa']);
                        // var_dump($tindakan->attributes);
                    }
                } else if ($ruangan_id == Params::RUANGAN_ID_FISIOTERAPI) {
                    foreach ($item['detail'] as $item2) {
                        $tindakan = $this->simpanTindakanBMHP($model, $item2['tindakan'], $ruangan_id, $admisi);
                        $hasil = $this->simpanHasilPemeriksaanRehab($item['penunjang'], $tindakan, $item2['periksa']);

                        $tindakan->pasienmasukpenunjang_id = $item['penunjang']->pasienmasukpenunjang_id;
                        $tindakan->hasilpemeriksaanrm_id = $hasil->hasilpemeriksaanrm_id;
                        $tindakan->save(false);
                        // var_dump($tindakan->attributes);
                    }
                }
            }

            // */
            // var_dump($this->is_simpanpaket); die;
            // die;
            // var_dump($tindakan_penunjang);
            // echo "Kick"; die;


            foreach ($tindakans as $item) {

                $this->simpanTindakanBMHP($model, $item, null, $admisi);
                // var_dump($modTindakan->attributes, $modTindakan->validate(), $modTindakan->errors);

                // var_dump($modTindakan->attributes);
            }

            // var_dump($this->is_simpanpaket); die;

            // obat
            foreach ($obats as $item) {
                $oa = ObatalkesM::model()->findByPk($item->obatalkes_id);

                $obat = new ObatalkespasienT;
                $obat->obatalkes_id = $item->obatalkes_id;
                $obat->tipepaket_id = $item->paketbmhp->tipepaket_id;
                $obat->qty_oa = $item->qty;
                $obat->harganetto_oa = $oa->harganetto;
                $obat->hargasatuan_oa = $item->tarifsatuan;
                $obat->hargajual_oa = $obat->hargasatuan_oa * $obat->qty_oa;
                $obat->sumberdana_id = $oa->sumberdana_id;
                $obat->racikan_id = Params::RACIKAN_ID_NONRACIKAN;
                //$obat->instalasi_id = $model->instalasi_id;
                //$obat->ruangan_id = Yii::app()->user->getState('ruangan_id');

                $obat->ruangan_id = Params::RUANGAN_ID_APOTEK_1;

                if (!empty($admisi)) {
                    $obat->pegawai_id = !empty($admisi->pegawai_id) ? $admisi->pegawai_id : $model->pegawai_id;
                    $obat->kelaspelayanan_id = $admisi->kelaspelayanan_id;
                    $obat->carabayar_id = $admisi->carabayar_id;
                    $obat->penjamin_id = $admisi->penjamin_id;
                } else {
                    $obat->pegawai_id = $model->pegawai_id;
                    $obat->kelaspelayanan_id = $model->kelaspelayanan_id;
                    $obat->carabayar_id = $model->carabayar_id;
                    $obat->penjamin_id = $model->penjamin_id;
                }


                $obat->pendaftaran_id = $model->pendaftaran_id;
                $obat->shift_id = Yii::app()->user->getState('shift_id');
                $obat->pasien_id = $model->pasien_id;
                $obat->tglpelayanan = date('Y-m-d H:i:s');
                $obat->pasienmasukpenunjang_id = $model->pasienmasukpenunjang_id;
                $obat->pasienadmisi_id = $model->pasienadmisi_id;
                $obat->satuankecil_id = $oa->satuankecil_id;
                $obat->qty_jual = $item->qty;
                $obat->is_paketbmhp = true;
                $obat->paketbmhp_id = $item->paketbmhp_id;

                if ($obat->validate()) {
                    $this->is_simpanpaket = $this->is_simpanpaket && $obat->save();
                    $this->simpanStokObatAlkesOut2($obat);

                    // vaR_dump($obat->attributes);


                } else {
                    $this->is_simpanpaket = false;
                }
            }
        }

        // vaR_dump($this->is_simpanpaket); die;

        // die;
    }

    protected function simpanStokObatAlkesOut2($modObatAlkesPasien)
    {
        $oa = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id);
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $oa->attributes;
        $modStokOaNew->attributes = $modObatAlkesPasien->attributes; //duplicate

        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = $modObatAlkesPasien->qty_oa;
        $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;

        $modStokOaNew->create_time = date('Y-m-d H:i:s');
        $modStokOaNew->update_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
        $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

        $modStokOaNew->tglterima = $modObatAlkesPasien->tglpelayanan;
        $modStokOaNew->tglstok_out = $modObatAlkesPasien->tglpelayanan;

        if ($modStokOaNew->validate()) {
            $modStokOaNew->save();
        } else {
            $this->is_simpanpaket = false;
        }
        return $modStokOaNew;
    }

    public function simpanTindakanBMHP($model, $tindakan_bmhp, $ruangan_id = null, $admisi = null)
    {


        $modTindakan = new TindakanpelayananT;

        $modTindakan->daftartindakan_id = $tindakan_bmhp->daftartindakan_id;
        $modTindakan->tipepaket_id = $tindakan_bmhp->paketbmhp->tipepaket_id;
        $modTindakan->create_time = date("Y-m-d H:i:s");
        $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
        //$modTindakan->instalasi_id=Yii::app()->user->getState("instalasi_id");
        //$modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modTindakan->pendaftaran_id = $model->pendaftaran_id;
        $modTindakan->pasien_id = $model->pasien_id;
        $modTindakan->jeniskasuspenyakit_id = $model->jeniskasuspenyakit_id;

        if (!empty($admisi)) {
            $modTindakan->instalasi_id = $admisi->ruangan->instalasi_id;
            $modTindakan->ruangan_id = $admisi->ruangan_id;
            $modTindakan->kelaspelayanan_id = $admisi->kelaspelayanan_id;
            $modTindakan->carabayar_id = $admisi->carabayar_id;
            $modTindakan->penjamin_id = $admisi->penjamin_id;
            $modTindakan->dokterpemeriksa1_id = !empty($admisi->pegawai_id) ? $admisi->pegawai_id : $model->pegawai_id;
        } else {
            $modTindakan->instalasi_id = $model->instalasi_id;
            $modTindakan->ruangan_id = $model->ruangan_id;
            $modTindakan->kelaspelayanan_id = $model->kelaspelayanan_id;
            $modTindakan->carabayar_id = $model->carabayar_id;
            $modTindakan->penjamin_id = $model->penjamin_id;
            $modTindakan->dokterpemeriksa1_id = $model->pegawai_id;
        }

        if (!empty($ruangan_id)) {
            $modTindakan->ruangan_id = $ruangan_id;
            $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
        }

        $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
        $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
        $modTindakan->qty_tindakan = $tindakan_bmhp->qty;
        $modTindakan->tarif_satuan = $tindakan_bmhp->tarifsatuan; // $modTindakan->getTarifSatuan();
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
        $modTindakan->is_paketbmhp = true;
        $modTindakan->paketbmhp_id = $tindakan_bmhp->paketbmhp_id;

        if ($modTindakan->validate()) {
            $this->is_simpanpaket = $this->is_simpanpaket && $modTindakan->save();
        } else {
            $this->is_simpanpaket = false;
        }

        return $modTindakan;
    }


    /**
     * Fungsi untuk menyimpan data ke model MCPasienmasukpenunjangT
     * @param type $modPendaftaran
     * @param type $modPasien
     * @return MCPasienmasukpenunjangT
     */
    public function simpanPasienMasukPenunjang($modPendaftaran, $ruangan_id)
    {
        $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modPasienMasukPenunjang = new PasienmasukpenunjangT;
        $modPasienMasukPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modPasienMasukPenunjang->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        $modPasienMasukPenunjang->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
        $modPasienMasukPenunjang->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $modPasienMasukPenunjang->pegawai_id = $modPendaftaran->pegawai_id;
        $modPasienMasukPenunjang->pasien_id = $modPendaftaran->pasien_id;
        $modPasienMasukPenunjang->ruangan_id = $ruangan_id;
        $modPasienMasukPenunjang->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
        $instalasi_id = $modPasienMasukPenunjang->ruangan->instalasi_id;
        $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
        $modPasienMasukPenunjang->kunjungan = CustomFunction::getKunjungan($modPasien, $modPasienMasukPenunjang->ruangan_id);
        $modPasienMasukPenunjang->statusperiksa = $modPendaftaran->statusperiksa;
        $modPasienMasukPenunjang->tglmasukpenunjang = $modPendaftaran->tgl_pendaftaran;
        $modPasienMasukPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($modPasienMasukPenunjang->ruangan_id, $modPasienMasukPenunjang->tglmasukpenunjang);
        //        RSSP-3041 - cek comment
        //        $modPasienMasukPenunjang->tglmasukpenunjang = date("Y-m-d H:i:s");

        $modPasienMasukPenunjang->no_urutperiksa = MyGenerator::noAntrianPenunjang($modPasienMasukPenunjang->ruangan_id);
        $modPasienMasukPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
        $modPasienMasukPenunjang->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modPasienMasukPenunjang->create_loginpemakai_id = Yii::app()->user->id;
        $modPasienMasukPenunjang->create_time = date('Y-m-d H:i:s');
        $modPasienMasukPenunjang->panggilantrian = false;

        if ($modPasienMasukPenunjang->validate()) {
            $modPasienMasukPenunjang->save();
            //     $this->pasienpenunjangtersimpan &= true;
        } else {
            //    $this->pasienpenunjangtersimpan &= false;
        }
        return $modPasienMasukPenunjang;
    }

    /**
     * simpan LBHasilPemeriksaanLabT
     */
    public function simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjang)
    {
        if (empty($modPasienMasukPenunjang)) {
            return null;
        }
        $modHasilPemeriksaan = new HasilpemeriksaanlabT;
        $modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
        $modHasilPemeriksaan->nohasilperiksalab = MyGenerator::noHasilPemeriksaanLK();
        $modHasilPemeriksaan->tglhasilpemeriksaanlab = $modPasienMasukPenunjang->tglmasukpenunjang;
        $modHasilPemeriksaan->hasil_kelompokumur = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
        $modHasilPemeriksaan->hasil_jeniskelamin = $modPasien->jeniskelamin;
        $modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_BELUM;
        //		$modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;
        $modHasilPemeriksaan->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if ($modHasilPemeriksaan->validate()) {
            $this->is_simpanpaket = $this->is_simpanpaket && $modHasilPemeriksaan->save();
        } else {
            $this->is_simpanpaket = false;
        }
        return $modHasilPemeriksaan;
    }

    public function simpanHasilPemeriksaanRad($modPasienMasukPenunjang, $modTindakan, $modPemeriksaanRad)
    {
        if (empty($modPasienMasukPenunjang)) {
            return null;
        }
        $modHasilPemeriksaan = new HasilpemeriksaanradT;
        $modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
        $modHasilPemeriksaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
        $modHasilPemeriksaan->pemeriksaanrad_id = isset($modPemeriksaanRad->pemeriksaanrad_id) ? $modPemeriksaanRad->pemeriksaanrad_id : null;
        $modHasilPemeriksaan->tglpemeriksaanrad = $modPasienMasukPenunjang->tglmasukpenunjang;
        $modHasilPemeriksaan->create_time = date("Y-m-d H:i:s");
        $modHasilPemeriksaan->create_loginpemakai_id = Yii::app()->user->id;
        $modHasilPemeriksaan->create_ruangan = Yii::app()->user->getState('ruangan_id');;
        //		$modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;

        if ($modHasilPemeriksaan->validate()) {
            $this->is_simpanpaket = $this->is_simpanpaket && $modHasilPemeriksaan->save();
            //RND-8272
            $dataBroker = $modHasilPemeriksaan->getDataBroker();
            if (!empty($dataBroker)) {
                CustomFunction::postHL7Broker("ADD", $dataBroker);
            }

            $modTindakan->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
            $modTindakan->hasilpemeriksaanrad_id = $modHasilPemeriksaan->hasilpemeriksaanrad_id;
            $this->is_simpanpaket = $this->is_simpanpaket && $modTindakan->save(false);
        } else {
            //($modHasilPemeriksaan->getErrors());die;
            //($modTindakan->getErrors());die;
            $this->is_simpanpaket = false;
        }
    }

    /**
     * simpan LBHasilPemeriksaanLabT
     */
    public function simpanHasilPemeriksaanRehab($modPasienMasukPenunjang, $tindakan, $pemeriksaan)
    {
        if (empty($modPasienMasukPenunjang)) {
            return null;
        }
        $modHasilPemeriksaan = new HasilpemeriksaanrmT;
        $modHasilPemeriksaan->attributes = $tindakan->attributes;
        $modHasilPemeriksaan->kunjunganke = 1;
        $modHasilPemeriksaan->tglpemeriksaanrm = $tindakan->tgl_tindakan;
        $modHasilPemeriksaan->nohasilrm = MyGenerator::noHasilPemeriksaanRM();
        $modHasilPemeriksaan->pegawai_id = $tindakan->dokterpemeriksa1_id;

        if (!empty($pemeriksaan)) {
            $modHasilPemeriksaan->tindakanrm_id = $pemeriksaan->tindakanrm_id;
            $modHasilPemeriksaan->jenistindakanrm_id = $pemeriksaan->jenistindakanrm_id;
        }

        $modHasilPemeriksaan->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modHasilPemeriksaan->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;

        // //($modHasilPemeriksaan->attributes, $modHasilPemeriksaan->validate(), $modHasilPemeriksaan->errors, $modPasienMasukPenunjang->attributes); die;


        if ($modHasilPemeriksaan->validate()) {
            $this->is_simpanpaket = $this->is_simpanpaket && $modHasilPemeriksaan->save();
        } else {
            $this->is_simpanpaket = false;
            // var_dump($modHasilPemeriksaan->errors);
        }
        return $modHasilPemeriksaan;
    }

    public function kirimWhatsApp($model, $modPasien)
    {
        $str = "
  
Selamat Datang di ((nama_rs))

((nama_pasien))  terdaftar sebagai pasien pada tanggal ((tgl_pendaftaran)) dan akan melakukan pemeriksaan di ((ruangan_nama)) dengan No. Antrian ((no_antrian))
        
Live Antrian dapat mengunjungi : https://sariasihgroup.com/salive/antrian
        
Terimakasih

((nama_rs)) - ((lokasi))       
";

        $str = str_replace("((nama_rs))", ucwords(strtolower((Yii::app()->user->getState('nama_rumahsakit')))), $str);
        $str = str_replace("((nama_pasien))", $modPasien->namadepan . $modPasien->nama_pasien, $str);
        $str = str_replace("((tgl_pendaftaran))", MyFormatter::formatDateTimeForUser($model->tgl_pendaftaran), $str);
        $str = str_replace("((ruangan_nama))", $model->ruangan->ruangan_nama, $str);
        $str = str_replace("((no_antrian))", $model->no_urutantri, $str);
        $str = str_replace("((lokasi))", Yii::app()->user->getState('kabupaten_nama'), $str);


        // var_dump($str); die;

        $wa = new WhatsApp();
        $res = $wa->kirimIndividu($modPasien->no_mobile_pasien, $str);
        //            $res = $wa->kirimIndividu("085606615990", $str);

        //            var_dump($res, $str, $model->attributes, $modPasienAdmisi->attributes, $modPasien->attributes);
        //            die;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = PPPendaftaranT::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */





    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pppendaftaran-t-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * proses simpan / ubah data pasien
     * @param type $modPasien
     * @param type $post
     * @return type
     */
    public function simpanPasien($modPasien, $post)
    {
        // var_dump($post); die;
        $format = new MyFormatter();
        $snrm = "";
        $dataPasien = PPPasienM::model()->findByAttributes(array('no_rekam_medik' => $post['no_rekam_medik']));
        if (isset($post['pasien_id']) && (!empty($post['pasien_id']))) {
            $load = new $modPasien;
            $modPasien = $load->findByPk($post['pasien_id']);
            $snrm = $modPasien->no_rekam_medik;

            // var_dump($modPasien->attributes);
        }
        if (!empty($dataPasien) && empty($modPasien)) {
            $modPasien = PPPasienM::model()->findByPk($dataPasien->pasien_id);
            $snrm = $post['no_rekam_medik'];
        }
        if (!empty($_POST['PPPendaftaranT']['buatjanjipoli_id'])) {
            $this->isjanjipoli = true;
        }

        $darijanjipoli = ($this->isjanjipoli && strpos($modPasien->no_rekam_medik, "JP") === 0);

        $no_rm = $modPasien->no_rekam_medik;
        // var_dump($modPasien->pasien_id, $no_rm);

        $modPasien->attributes = $post;

        if (empty($modPasien->no_rekam_medik)) {
            $modPasien->no_rekam_medik = $no_rm;
        }

        $modPasien->nama_bin = $post['nama_bin'];
        $modPasien->alamat_domisili_pasien = isset($post['alamat_domisili_pasien']) ? $post['alamat_domisili_pasien'] : "";


        // echo "<pre>";        var_dump($post['nama_bin']);die();
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
                    $modPasien->no_rekam_medik = $modPasien->generateNoRandom(); //MyGenerator::noRekamMedik();
                    $modPasien->is_random = true;
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

        if ($darijanjipoli) {
            $modPasien->ispasienluar = false;
        }

        // var_dump($modPasien->attributes); die;

        if ($modPasien->save()) {
            $this->pasientersimpan = true;

            if ($darijanjipoli) {
                $modPasien->generateNoRMDanSimpan();
                $modPasien->no_rekam_medik = $modPasien->normbaru;
            }
        }
        //         var_dump($modPasien->getErrors()); die;

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
        $model->penanggungjawab_id = $modPenanggungJawab->penanggungjawab_id;
        $model->rujukan_id = $modRujukan->rujukan_id;
        $model->instalasi_id = (isset($model->ruangan_id) ? $model->ruangan->instalasi_id : null);
        $model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
        // $model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
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
        $model->kelompokumur_id = (!empty($modPasien->kelompokumur_id) ? $modPasien->kelompokumur_id : CustomFunction::getKelompokUmur($modPasien->tanggal_lahir));
        $model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
        $model->tgl_konfirmasi = $format->formatDateTimeForDb($model->tgl_konfirmasi);
        $model->tglselesaiperiksa = $format->formatDateTimeForDb($model->tglselesaiperiksa);
        $model->tglrenkontrol = $format->formatDateTimeForDb($model->tglrenkontrol);
        $model->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;
        $model->keterangan_pendaftaran = isset($post['keterangan_pendaftaran']) ? $post['keterangan_pendaftaran'] : null;
        //$model->alamat_domisili_pasien = isset($post['alamat_domisili_pasien']) ? $post['alamat_domisili_pasien'] : null;
        $model->diagnosamasuk = isset($post['diagnosamasuk']) ? $post['diagnosamasuk'] : null;
        $model->keluhan = isset($post['keluhan']) ? $post['keluhan'] : null;
        $model->kepercayaan = isset($post['kepercayaan']) ? $post['kepercayaan'] : null;
        //$model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id, $model->tgl_pendaftaran);
        $model->diagnosamasuk_id = isset($post['diagnosamasuk_id']) ? $post['diagnosamasuk_id'] : null;
        $model->is_kecelakaan = isset($post['is_kecelakaan']) ? $post['is_kecelakaan'] : null;


        if (
            $this->id == "pendaftaranRawatJalan"
            && isset($_POST['waktu_jadwal'])
            && !empty($_POST['waktu_jadwal'])
        ) {
            $model->tgl_pendaftaran .= " " . $_POST['waktu_jadwal'] . ":00";
        }
        // var_dump($_POST); die;

        $model->no_luarjadwal = isset($_POST['PPPendaftaranT']['no_luarjadwal']) ? $_POST['PPPendaftaranT']['no_luarjadwal'] : 0;

        if ($this->id == "pendaftaranRawatJalan" && !empty($model->no_urutantri)) {
            $model->no_urutantri = str_pad((int)$model->no_urutantri, 3, "0", STR_PAD_LEFT);
        } else {
            if ($this->id == "pendaftaranRawatJalan") {
                $model->tgl_pendaftaran .= " " . date('H:i:s');
            }
            $ins_rj = RuanganrawatjalanV::arrIns();
            if (in_array($model->instalasi_id, $ins_rj)) {
                $model->no_urutantri = MyGenerator::noAntrianJanjiPoliBaru($model->pasien_id, $model->pegawai_id, $model->ruangan_id, $model->tgl_pendaftaran, '', '', $model->no_luarjadwal);
            } else {
                $model->no_urutantri = MyGenerator::noAntrianJanjiPoliBaru($model->pasien_id, null, $model->ruangan_id, $model->tgl_pendaftaran, '', '', $model->no_luarjadwal);
            }
        }

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

        $sisaAntrian = $model->no_urutantri - 1;
        $totalEstimasiPelayanan = $estimasipelayanan * $sisaAntrian;

        /*
        $tgldaftar = new DateTime($model->tgl_pendaftaran);
        if (!empty($dataPendaftaran) && !empty($dataPendaftaran->tglakandilayani)) {
            $tglakandilayani = new DateTime($dataPendaftaran->tglakandilayani);

            if ($tgldaftar < $tglakandilayani) {
                $tgldaftar->add(new DateInterval("PT" . $totalEstimasiPelayanan . "M"));
                $model->tglakandilayani = $tgldaftar->format('Y-m-d H:i:s');
            } else {
                $tgldaftar->add(new DateInterval("PT" . $totalEstimasiPelayanan . "M"));
                $model->tglakandilayani = $tgldaftar->format('Y-m-d H:i:s');
            }
        } else {

            $tgldaftar->add(new DateInterval("PT" . $totalEstimasiPelayanan . "M"));
            $model->tglakandilayani = $tgldaftar->format('Y-m-d H:i:s');
        }
        */
        $model->tglakandilayani = $model->tgl_pendaftaran;

        if (!empty($post['buatjanjipoli_id'])) {
            $model->buatjanjipoli_id = $post['buatjanjipoli_id'];

            $janjipoli = BuatjanjipoliT::model()->findByPk($model->buatjanjipoli_id);

            $model->tglakandilayani = $model->tgl_pendaftaran;

            // if (!empty($janjipoli) && $janjipoli->ruangan_id == $model->ruangan_id) {
            //     $model->no_urutantri = $janjipoli->no_antrianjanji;
            // }
            if (!empty($janjipoli)) {
                $tgl_poli = date('Y-m-d', strtotime($janjipoli->tgljadwal));
                $tgl_daftar = date('Y-m-d', strtotime($model->tgl_pendaftaran));

                if (!empty($janjipoli) && $janjipoli->ruangan_id == $model->ruangan_id && $janjipoli->pegawai_id == $model->pegawai_id && $tgl_poli == $tgl_daftar) {
                    $model->no_urutantri = $janjipoli->no_antrianjanji;
                }
            }
        }

        // if (!empty($model->nursestation_id)) {
        //     $model->statuspemeriksaan_nursestation = Params::STATUSPERIKSA_ANTRIAN;
        //     $model->nourut_antriannursestation = MyGenerator::noAntrianNursestation($model->nursestation_id);
        // }

        //			var_dump($model->buatjanjipoli_id, $model->attributes);die;

        //             var_dump($model->validate(), $model->errors); die;
        $model->no_pendaftaran = $model->generateNoRandom(); //MyGenerator::noPendaftaran($model->instalasi_id, $model->tgl_pendaftaran);
        $model->kategoriasalpasien = isset($post['kategoriasalpasien']) ? $post['kategoriasalpasien'] : '';
        if (isset($post['is_bpjs_rj'])) {
            $model->is_nonbridging = $post['is_bpjs_rj'] == 0 ? 1 : 0;
        } else if (isset($post['is_bpjs'])) {
            $model->is_nonbridging = $post['is_bpjs'] == 0 ? 1 : 0;
        }

        // echo '<pre>'; var_dump($model->attributes, $post); die;

        if ($model->save()) {
            if (!empty($model->antrian_id)) {
                PPAntrianT::model()->updateByPk($model->antrian_id, array('pendaftaran_id' => $model->pendaftaran_id));
            }
            /* if(!empty($model->pendaftaran_id)) {
                    $mod2 = PPPendaftaranT::model()->findByPk($model->pendaftaran_id);
                    $model = $mod2;
                } */
            $this->pendaftarantersimpan = true;
        } else {
            $this->pendaftarantersimpan = false;
        }
        return $model;
    }
    /**
     * proses simpan data penanggungjawab pasien
     * @param type $modPenanggungjawab
     * @param type $post
     * @return type
     */
    public function simpanPenanggungjawab($modPenanggungjawab, $post)
    {
        $format = new MyFormatter;
        $modPenanggungjawab->attributes = $post;
        $modPenanggungjawab->tgllahir_pj = $format->formatDateTimeForDb($modPenanggungjawab->tgllahir_pj);

        if ($modPenanggungjawab->save()) {
            $this->penanggungjawabtersimpan = true;
        }
        return $modPenanggungjawab;
    }
    public function simpanPenanggungjawabDokter($modPenanggungjawab, $pegawai_id)
    {
        $format = new MyFormatter;
        $peg = PegawaiM::model()->findByPk($pegawai_id);

        // $modPenanggungjawab = new PPPenanggungJawabM;
        $modPenanggungjawab->pengantar = Params::PENGANTAR_PEGAWAI_RS;
        $modPenanggungjawab->jenisidentitas = $peg->jenisidentitas;
        $modPenanggungjawab->no_identitas = $peg->noidentitas;
        $modPenanggungjawab->no_identitas_pj = $peg->noidentitas;
        $modPenanggungjawab->nama_pj = $peg->namaLengkap;
        $modPenanggungjawab->tempatlahir_pj = $peg->tempatlahir_pegawai;
        $modPenanggungjawab->tgllahir_pj = $peg->tgl_lahirpegawai;
        $modPenanggungjawab->jeniskelamin = $peg->jeniskelamin;
        $modPenanggungjawab->alamat_pj = $peg->alamat_pegawai;
        $modPenanggungjawab->no_teleponpj = $peg->notelp_pegawai;
        $modPenanggungjawab->no_mobilepj = str_replace(" ", "", $peg->nomobile_pegawai);
        $modPenanggungjawab->pegawai_id = $pegawai_id;
        $modPenanggungjawab->hubungankeluarga = "";

        if ($modPenanggungjawab->save()) {
            $this->penanggungjawabtersimpan = true;
        } else {
            $this->penanggungjawabtersimpan = false;
        }

        return $modPenanggungjawab;
    }
    /**
     * proses simpan data rujukan
     * @param type $modRujukan
     * @param type $post
     * @return type
     */
    public function simpanRujukan($modRujukan, $post)
    {
        $format = new MyFormatter();
        $modRujukan->attributes = $post;
        $modRujukan->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? ((count((array)$post['kddiagnosa_rujukan']) > 0) ? implode(', ', $post['kddiagnosa_rujukan']) : '') : '';
        $modRujukan->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? ((count((array)$post['diagnosa_rujukan']) > 0) ? implode(', ', $post['diagnosa_rujukan']) : '') : '';
        $modRujukan->tanggal_rujukan = $format->formatDateTimeForDb($modRujukan->tanggal_rujukan);

        if ($modRujukan->save()) {
            $this->rujukantersimpan = true;
        }
        return $modRujukan;
    }
    /**
     * proses simpan data rujukan
     * @param type $modRujukan
     * @param type $post
     * @return type
     */
    public function simpanRujukanBpjs($modRujukanBpjs, $post)
    {
        $format = new MyFormatter();
        $modRujukanBpjs->attributes = $post;
        $modRujukanBpjs->no_rujukan = $modRujukanBpjs->no_rujukan ?? "0000000000";
        $modRujukanBpjs->asalrujukan_id = (isset($post['asalrujukan_id']) ? $post['asalrujukan_id'] : 4);

        if (empty($modRujukanBpjs->rujukandari_id) && !empty($modRujukanBpjs->asalrujukan_id)) {
            $modRujukandari = RujukandariM::model()->findByAttributes(array('asalrujukan_id' => $modRujukanBpjs->asalrujukan_id));
            $modRujukanBpjs->rujukandari_id = (!empty($modRujukandari) ? $modRujukandari->rujukandari_id : null);
        }

        $modRujukanBpjs->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? ((count((array)$post['kddiagnosa_rujukan']) > 0) ? implode(', ', $post['kddiagnosa_rujukan']) : '') : '';
        $modRujukanBpjs->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? ((count((array)$post['diagnosa_rujukan']) > 0) ? implode(', ', $post['diagnosa_rujukan']) : '') : '';
        $modRujukanBpjs->tanggal_rujukan = $format->formatDateTimeForDb($modRujukanBpjs->tanggal_rujukan);

        if ($modRujukanBpjs->save()) {
            $this->rujukantersimpan = true;
        }

        return $modRujukanBpjs;
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
        $modTindakan->nopelayanan = '001';

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
        $nokartu_asuransi = isset($_POST['PPSepT']['nopeserta']) ? $_POST['PPSepT']['nopeserta'] : "";
        $modAsuransiPasien->attributes = $postAsuransiPasien;
        $modAsuransiPasien->nopeserta = !empty($postAsuransiPasien['nokartuasuransi']) ? $postAsuransiPasien['nokartuasuransi'] : $nokartu_asuransi;
        $modAsuransiPasien->tglcetakkartuasuransi = date('Y-m-d H:i:s');
        $modAsuransiPasien->pasien_id = isset($postPasien['pasien_id']) ? $postPasien['pasien_id'] : null;
        $modAsuransiPasien->penjamin_id = $penjamin;
        $modAsuransiPasien->carabayar_id = $carabayar;
        $modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
        $modAsuransiPasien->create_time = date("Y-m-d H:i:s");
        $modAsuransiPasien->tgl_konfirmasi = $format->formatDateTimeForDb($modAsuransiPasien->tgl_konfirmasi);
        if(isset($postAsuransiPasien['tgl_konfirmasi2'])) {
            $modAsuransiPasien->tgl_konfirmasi = $format->formatDateTimeForDb($postAsuransiPasien['tgl_konfirmasi2']);
        }
        $modAsuransiPasien->hubkeluarga = isset($postAsuransiPasien['hubkeluarga']) ? $postAsuransiPasien['hubkeluarga'] : '';
        $modAsuransiPasien->nominal_tanggungan = isset($postAsuransiPasien['nominal_tanggungan']) ? $postAsuransiPasien['nominal_tanggungan'] : 0;
        $modAsuransiPasien->kodefeskestk1 = isset($_POST['PPSepT']['ppkrujukan']) ? $_POST['PPSepT']['ppkrujukan'] : "";
        $modAsuransiPasien->nama_feskestk1 = isset($_POST['PPSepT']['ppkrujukan_nama']) ? $_POST['PPSepT']['ppkrujukan_nama'] : "";
        //var_dump($postAsuransiPasien['nominal_tanggungan']);die;
        // var_dump($postPendaftaran);
        // var_dump($postPasien->attributes);
        if ($carabayar == Params::CARABAYAR_ID_JAMKESPA) {
            $modAsuransiPasien->nopeserta = $postPasien->no_rekam_medik;
            // $modAsuransiPasien->status_konfirmasi = 1;
        } else if ($carabayar == Params::CARABAYAR_ID_BPJS) {
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

        //            var_dump($modAsuransiPasien->attributes); die;
        // echo "<pre>";
        // var_dump($modAsuransiPasien->attributes,
        //     $modAsuransiPasien->validate(),
        //     $modAsuransiPasien->getErrors(),

        // );
        // die;

        // echo "<pre>";
        // var_dump($modAsuransiPasien->attributes);
        // die;
        if ($modAsuransiPasien->validate() && $modAsuransiPasien->save()) {
            $this->asuransipasientersimpan = true;
        }

        // var_dump($modAsuransiPasien->attributes);die;
        return $modAsuransiPasien;
    }

    public function simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $postSep, $isRI = false)
    {
        $reqSep = null;
        $modSep = new PPSepT;
        $modSep->attributes = $postSep;
        $bpjs = new BpjsVklaim();
        $kelas = KelaspelayananM::model()->findByPk($modAsuransiPasienBpjs->kelastanggunganasuransi_id);
        $modSep->tglsep = empty($modSep->tglsep) ? date("Y-m-d") : MyFormatter::formatDateTimeForDb($modSep->tglsep);

        $nopesertasep = isset($postSep['nopeserta']) ? $postSep['nopeserta'] : null;
        $modSep->nokartuasuransi = !empty($modAsuransiPasienBpjs->nopeserta) ? $modAsuransiPasienBpjs->nopeserta : $nopesertasep;
        $modSep->tglrujukan = $modRujukanBpjs->tanggal_rujukan;
        if (empty($modSep->tglrujukan)) $modSep->tglrujukan = $modSep->tglsep;
        $modSep->norujukan = $modRujukanBpjs->no_rujukan;
        if (isset($postSep['ppkrujukan'])) $modSep->ppkrujukan = $postSep['ppkrujukan'];
        else $modSep->ppkrujukan = Yii::app()->user->getState('ppkpelayanan');
        $modSep->ppkpelayanan = Yii::app()->user->getState('ppkpelayanan');
        $modSep->jnspelayanan = ($model->instalasi_id == Params::INSTALASI_ID_RI || $isRI) ? Params::JENISPELAYANAN_RI : Params::JENISPELAYANAN_RJ;
        $modSep->catatansep = $postSep['catatansep'];
        if (isset($_POST['PPRujukanbpjsT']['kddiagnosa_rujukan'])) {
            $data_diagnosa =  $_POST['PPRujukanbpjsT']['kddiagnosa_rujukan'][0];
            $data_diagnosa_nama = $_POST['PPRujukanbpjsT']['diagnosa_rujukan'][0];
            $modSep->diagnosaawal = $data_diagnosa;
            $modSep->nama_diagnosaawal = $data_diagnosa_nama;
        } else {
            $data_diagnosa = explode(', ', $modRujukanBpjs->kddiagnosa_rujukan);
            $data_diagnosa_nama = explode(', ', $modRujukanBpjs->diagnosa_rujukan);
            $modSep->diagnosaawal = isset($data_diagnosa[0]) ? $data_diagnosa[0] : $postSep['diagnosaawal'];
            if ($modSep->diagnosaawal == "") {
                $modSep->diagnosaawal = isset($postSep['diagnosaawal']) ? $postSep['diagnosaawal'] : null;
            }
            $modSep->nama_diagnosaawal = isset($data_diagnosa_nama[0]) ? $data_diagnosa_nama[0] : $postSep['nama_diagnosaawal'];
            if ($modSep->nama_diagnosaawal == "") {
                $modSep->nama_diagnosaawal = isset($postSep['nama_diagnosaawal']) ? $postSep['nama_diagnosaawal'] : null;
            }
        }

        if(!empty($modSep->tanggal_kejadian)) {
            $modSep->tanggal_kejadian = MyFormatter::formatDateTimeForDb($modSep->tanggal_kejadian);
        }


        $politujuan_input = !empty($postSep['politujuan']) ? $postSep['politujuan'] : (empty($model->ruangan->kode_bpjs) ? $model->ruangan->ruangan_singkatan : $model->ruangan->kode_bpjs);




        $modSep->politujuan = $isRI ? "" : $politujuan_input;
        $klsrawatsep = isset($postSep['klsrawat']) ? $postSep['klsrawat'] : null;
        $modSep->klsrawat = !empty($kelas->kelasbpjs_id) ? $kelas->kelasbpjs_id : $klsrawatsep;
        $modSep->tglpulang = date('Y-m-d H:i:s');
        $modSep->create_time = date('Y-m-d H:i:s');
        $modSep->create_loginpemakai_id = Yii::app()->user->id;
        $modSep->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modSep->jenisrujukan_kode = (isset($postSep['jenisfaskes']) ? $postSep['jenisfaskes'] : 2);
        $modSep->jenisrujukan_nama = ($modSep->jenisrujukan_kode == 1) ? "PCare" : "Rumah Sakit";
        $modSep->no_telpon_peserta = (isset($postSep['no_telpon_peserta']) ? $postSep['no_telpon_peserta'] : null);
        $modSep->no_surat = (isset($postSep['no_surat']) ? $postSep['no_surat'] : null);
        $modSep->kode_dpjp = (isset($postSep['kode_dpjp']) ? $postSep['kode_dpjp'] : null);
        $modSep->nama_dpjp = (isset($postSep['nama_dpjp']) ? $postSep['nama_dpjp'] : null);

        $modSep->programprb_nama = $_POST['bpjs_prolanis'];

        // echo "<pre>";
        // var_dump($_POST['PPRujukanbpjsT']['kddiagnosa_rujukan'][0], $data_diagnosa, $modSep->attributes, $postSep);
        // die;

        if ($isRI) {

            $modSep->dpjpygmelayani_nama = null;
            $modSep->dpjpygmelayani_kode = null;
            $modSep->jenisrujukan_kode = 2;
            $modSep->ppkrujukan = Yii::app()->user->getState('ppkpelayanan');

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

            $modSep->norujukan = MyGenerator::noReferensiLokalBpjs();
            $modSep->politujuan = '';
        }

        if (isset($postSep['klsRawatNaik'])) {
            $modSep->klsRawatNaik = $postSep['klsRawatNaik'];
        }
        // var_dump($this->id);die;
        if ($this->id == "pendaftaranRawatInapDariRJRD") {

            $modSep->norujukan = MyGenerator::noReferensiLokalBpjs();
            $modSep->politujuan = '';
            $modSep->jnspelayanan = 1;
            $modSep->jenis_kunjungan = 0;
        }
        if (in_array($this->id, array("pendaftaranBayiBaruLahir", "pendaftaranRawatDarurat"))) {

            $modSep->norujukan = "";
            $modSep->tglrujukan = date("Y-m-d");
            $modSep->politujuan = "IGD";
        }


        $lakalantas = 0;
        $asalRujukan = $modSep->jenisrujukan_kode;
        $eksekutif = 0;
        $cob = null;
        $penjamin = $model->penjamin_id;
        $lokasiLaka = null;
        $noTelp = $modSep->no_telpon_peserta;
        $user = null;
        $peg_user = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
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



        //tambah antrian
        if ($this->id == "pendaftaranRawatJalan") {
            $kodebooking = $model->no_pendaftaran;
            $jenispasien = (($model->carabayar_id == Params::CARABAYAR_ID_BPJS) ? "JKN" : "NON JKN");
            $nomorkartu = $_POST['nomor_cari']; //$nopesertasep;
            $nik = $model->pasien->no_identitas_pasien;
            $nohp = $model->pasien->no_mobile_pasien;
            $keterangan_antrol = "Peserta harap 30 menit lebih awal guna pencatatan administrasi.";
            $kodepoli = (!empty($model->ruangan) ? $model->ruangan->kode_bpjs : "");
            $namapoli = (!empty($model->ruangan) ? $model->ruangan->ruangan_nama : "");
            $pasienbaru = (($model->statuspasien == Params::STATUSPASIEN_BARU) ? 1 : 0);
            $norm = $model->pasien->no_rekam_medik;
            $tanggalperiksa = date('Y-m-d', strtotime($model->tgl_pendaftaran));
            $kodedokter = (!empty($model->pegawai) ? $model->pegawai->kodedokter_bpjs : "");
            $namadokter = (!empty($model->pegawai) ? $model->pegawai->nama_pegawai : "");
            $jampraktek = "";
            $sisakuotajkn = 50;
            $kuotajkn = 100;
            $sisakuotanonjkn = 0;
            $kuotanonjkn = 0;
            $jadwaldokter = JadwaldokterM::model()->findByAttributes(array('pegawai_id' => $model->pegawai_id, 'jadwaldokter_tgl' => $tanggalperiksa));
            // echo "<pre>";
            // var_dump($jadwaldokter);die;

            if (!empty($jadwaldokter)) {
                $jam = $jadwaldokter->jadwaldokter_buka;
                $jamArray = explode(" ", $jam);
                $jamArray[1] = "-";
                $jamArray[0] = substr($jamArray[0], 0, 5);
                $jamArray[2] = substr($jamArray[2], 0, 5);
                $jamArray = implode('', $jamArray);
                $jampraktek = $jamArray;

                $sisakuotajkn = $jadwaldokter->maximumbpjsantrian;
                $kuotajkn = $jadwaldokter->maximumbpjsantrian;
                $sisakuotanonjkn = $jadwaldokter->maximumantrian;
                $kuotanonjkn = $jadwaldokter->maximumantrian;
            }
            if ($postSep['jenis_kunjungan'] == 0) {
                if ($postSep['asesmen_pelayanan'] != "" || !empty($postSep['asesmen_pelayanan'])) {
                    $jeniskunjungan = 2;
                    $nomorreferensi = MyGenerator::noRujukanLokalBpjs();
                } else {
                    if ($asalRujukan == '2') {
                        if (!empty($noSurat)) {
                            $jeniskunjungan = 3;
                            $nomorreferensi = $noSurat;
                        } else {
                            $jeniskunjungan = 4;
                            $nomorreferensi = $modSep->norujukan;
                        }
                    } else {
                        if (!empty($noSurat)) {
                            $jeniskunjungan = 3;
                            $nomorreferensi = $noSurat;
                        } else {
                            $jeniskunjungan = 1;
                            $nomorreferensi = $modSep->norujukan;
                        }
                    }
                }
            } else if ($postSep['jenis_kunjungan'] == 2) {
                $jeniskunjungan = 3;
                $nomorreferensi = $noSurat;
            } else {
                $jeniskunjungan = 2;
                $nomorreferensi = MyGenerator::noRujukanLokalBpjs();
            }
            $nomorantrean = number_format((int)$model->no_urutantri);
            $angkaantrean = number_format((int)$model->no_urutantri);
            $estimasidilayani = $model->tglakandilayani;
            $stampwaktuantrian = strtotime($estimasidilayani);
            $estimasidilayani = $stampwaktuantrian * 1000;

            $bodytambah = array("kodebooking" => $kodebooking, "jenispasien" => $jenispasien, "nomorkartu" => $nomorkartu, "nik" => $nik, "nohp" => $nohp, "kodepoli" => $kodepoli, "namapoli" => $namapoli, "pasienbaru" => $pasienbaru, "norm" => $norm, "tanggalperiksa" => $tanggalperiksa, "kodedokter" => $kodedokter, "namadokter" => $namadokter, "jampraktek" => $jampraktek, "jeniskunjungan" => $jeniskunjungan, "nomorreferensi" => $nomorreferensi, "nomorantrean" => $nomorantrean, "angkaantrean" => $angkaantrean, "estimasidilayani" => $estimasidilayani, "sisakuotajkn" => $sisakuotajkn, "kuotajkn" => $kuotajkn, "sisakuotanonjkn" => $sisakuotanonjkn, "kuotanonjkn" => $kuotanonjkn, "keterangan" => $keterangan_antrol);
            $antrianonlinebpjs = new AntrianOnlineBpjs();
            $res_tambah = CJSON::decode($antrianonlinebpjs->tambah_antrian($bodytambah));

            if ($res_tambah['metaData']['code'] == 200) {
                PendaftaranT::model()->updateByPk($model->pendaftaran_id, array('statuskirim_wsbpjs' => true));
            } else {
                if (!empty($res_tambah['metaData']['message'])) {
                    PendaftaranT::model()->updateByPk($model->pendaftaran_id, array('respons_wsbpjs' => $res_tambah['metaData']['message'], 'respons_antrol' => $res_tambah['request_vars']));
                }
            }
        }
        if (isset($_POST['isSepManual'])) {
            if ($_POST['isSepManual'] == false) {
                $reqSep = json_decode($bpjs->create_sep_new($modSep->nokartuasuransi, $modSep->tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $asalRujukan, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDPJP, $katarak, $modSep), true);
                if ($reqSep['metaData']['code'] == 200) {
                    $modSep->nosep = $reqSep['response']['sep']['noSep'];
                    if (empty($modSep->norujukan)) $modSep->norujukan = "-";
                    if (empty($modSep->diagnosaawal)) $modSep->diagnosaawal = "-";
                    if(!empty($modSep->tanggal_kejadian)) {
                        $modSep->tanggal_kejadian = MyFormatter::formatDateTimeForDb($modSep->tanggal_kejadian);
                    }
                    if ($modSep->save()) {
                        $this->septersimpan = true;
                        RujukandariM::model()->updateByPk($modRujukanBpjs->rujukandari_id, array(
                            'ppkrujukan' => $modSep->ppkrujukan,
                        ));
                        $this->logBpjs($model, $reqSep, $bpjs->server_new['create_sep_2']);
                    }
                } else {
                    $this->logBpjs($model, $reqSep, $bpjs->server_new['create_sep_2']);
                }
            } else {
                $modSep->nosep = $_POST['PPSepT']['nosep'];
                if(!empty($modSep->tanggal_kejadian)) {
                    $modSep->tanggal_kejadian = MyFormatter::formatDateTimeForDb($modSep->tanggal_kejadian);
                }
                if ($modSep->save()) {
                    $this->septersimpan = true;
                }
            }
        } else {
            $reqSep = json_decode($bpjs->create_sep_new($modSep->nokartuasuransi, $modSep->tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $asalRujukan, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDPJP, $katarak, $modSep), true);
           
            if (isset($reqSep['metaData']['code']) && !empty($reqSep['metaData']['code'])) {
                if ($reqSep['metaData']['code'] == 200) {
                    $modSep->nosep = $reqSep['response']['sep']['noSep'];
                    $modSep->polirujukan = $reqSep['response']['sep']['poli'];
                    if (empty($modSep->norujukan)) $modSep->norujukan = "-";
                    if (empty($modSep->diagnosaawal)) $modSep->diagnosaawal = "-";

                    $modAsuransiPasienBpjs->bpjs_pesertadinsos = $reqSep['response']['sep']['informasi']['dinsos'];
                    $modAsuransiPasienBpjs->bpjs_prolanisprb = $reqSep['response']['sep']['informasi']['prolanisPRB'];
                    $modAsuransiPasienBpjs->bpjs_nosktm = $reqSep['response']['sep']['informasi']['noSKTM'];
                    $modAsuransiPasienBpjs->save();
                    if(!empty($modSep->tanggal_kejadian)) {
                        $modSep->tanggal_kejadian = MyFormatter::formatDateTimeForDb($modSep->tanggal_kejadian);
                    }
                    if ($modSep->save()) {
                        $this->septersimpan = true;
                        RujukandariM::model()->updateByPk($modRujukanBpjs->rujukandari_id, array(
                            'ppkrujukan' => $modSep->ppkrujukan,
                        ));
                        $this->logBpjs($model, $reqSep, $bpjs->server_new['create_sep_2']);
                    }
                } else {
                    // echo "<pre>";
                    // var_dump($reqSep);
                    // die;
                    $this->logBpjs($model, $reqSep, $bpjs->server_new['create_sep_2']);
                }
            } else {
                // echo "<pre>";
                // var_dump($reqSep);
                // die;
            }
        }

        $modSep->no_surat = !empty($modSep->no_surat) ? $modSep->no_surat : null;
        $modSep->kode_dpjp = !empty($modSep->kode_dpjp) ? $modSep->kode_dpjp : null;
        $modSep->nama_dpjp = !empty($modSep->nama_dpjp) ? $modSep->nama_dpjp : null;

        if(!empty($modSep->tanggal_kejadian)) {
            $modSep->tanggal_kejadian = MyFormatter::formatDateTimeForDb($modSep->tanggal_kejadian);
        }
        $modSep->save();

        return $modSep;
    }


    function logBpjs($model, $reqSep, $api = null, $response_time = null)
    {
        $log = new BpjslogR;
        $log->tgl_log = date('Y-m-d H:i:s');
        $log->code = $reqSep['metaData']['code'];
        $log->loginpemakai_id = Yii::app()->user->id;
        if (isset($reqSep['metaData']['message'])) {
            $log->pesan = $reqSep['metaData']['message'];
        }
        if (!empty($reqSep['request_vars'])) {
            $log->json_request_respose = $reqSep['request_vars'];
        }
        $log->pendaftaran_id = $model->pendaftaran_id ?? '';
        $request = Yii::app()->request;
        $ipAddress = $request->getUserHostAddress();
        $log->ip_address = $ipAddress;
        $log->api = $api;
        $log->save();
    }

    function flashBpjs($id)
    {
        $log = BpjslogR::model()->findByAttributes(
            array(
                'pendaftaran_id' => $id
            ),
            array(
                'order' => 'bpjslog_id desc'
            )
        );
        $template = '<div class="alert alert-block alert-{key}{class}"><a class="close" data-dismiss="alert">&times;</a>{message}</div>';
        if (!empty($log) && $log->code != 200) {
            echo strtr($template, array(
                '{class}' => '',
                '{key}' => 'error',
                '{message}' => 'BPJS Error ' . $log->code . ': ' . $log->pesan,
            ));
            // Yii::app()->user->setFlash('error', 'BPJS Error '.$log->code.': '.$log->pesan);
        }
    }

    /**
     * menentukan tipepaket_id
     * @param type $modPendaftaran
     * @param type $karcis_id
     * @param type $idTindakan
     * @return type
     */
    public function tipePaketKarcis($modPendaftaran, $karcis_id, $tindakan_id)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('tipepaket');
        $criteria->addCondition("daftartindakan_id = " . $tindakan_id);
        $criteria->addCondition("tipepaket.carabayar_id = " . $modPendaftaran->carabayar_id);
        $criteria->addCondition("tipepaket.penjamin_id = " . $modPendaftaran->penjamin_id);
        $criteria->addCondition("tipepaket.kelaspelayanan_id = " . $modPendaftaran->kelaspelayanan_id);
        $paket = PaketpelayananM::model()->find($criteria);
        $result = Params::TIPEPAKET_ID_NONPAKET;
        // if (isset($paket)) $result = $paket->tipepaket_id;

        return $result;
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
     * untuk menampilkan pasien lama dari autocomplete
     * 1. no_rekam_medik
     * 2. no_identitas_pasien
     * 3. nama_pasien
     * 4. nama_bin (alias)
     */
    public function actionAutocompletePasienLama()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
            $no_identitas_pasien = isset($_GET['no_identitas_pasien']) ? $_GET['no_identitas_pasien'] : null;
            $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
            $tanggal_lahir = isset($_GET['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['tanggal_lahir']) : null;
            $no_badge = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;

            if (empty($no_badge)) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
                $criteria->compare('LOWER(no_identitas_pasien)', strtolower($no_identitas_pasien), true);
                $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
                $criteria->compare('tanggal_lahir', $tanggal_lahir);
                if ($this->id == "pendaftaranPersalinan") {
                    $criteria->compare('jeniskelamin', Params::JENIS_KELAMIN_PEREMPUAN);
                }
                $criteria->addCondition('ispasienluar = FALSE');
                $criteria->order = 'no_rekam_medik, nama_pasien';
                $criteria->limit = 50;
                $models = PasienM::model()->findAll($criteria);
                foreach ($models as $i => $model) {
                    $attributes = $model->attributeNames();
                    foreach ($attributes as $j => $attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->no_identitas_pasien . " - "  . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "") . " - " . $format->formatDateTimeForUser($model->tanggal_lahir);
                    $returnVal[$i]['value'] = $model->no_rekam_medik;
                }
            } else {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)', strtolower($no_badge), true);
                $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id";
                $criteria->order = 'pegawai_m.nomorindukpegawai, t.nama_pasien';
                $criteria->limit = 50;
                $models = PPPasienM::model()->findAll($criteria);
                foreach ($models as $i => $model) {
                    $attributes = $model->attributeNames();
                    foreach ($attributes as $j => $attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->pegawai->nomorindukpegawai .
                        ' - ' . $model->no_rekam_medik .
                        ' - ' . $model->nama_pasien .
                        ' - (' . $model->pegawai->nama_pegawai .
                        ') - ' . $format->formatDateTimeForUser($model->tanggal_lahir);
                    $returnVal[$i]['value'] = $model->no_rekam_medik;
                }
            }


            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }
    public function actionAutocompleteAsuransi()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $nopeserta = isset($_GET['nopeserta']) ? $_GET['nopeserta'] : '';
            $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
            $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nopeserta)', strtolower($nopeserta), true);
            $criteria->addCondition('penjamin_id=' . $penjamin_id);
            $criteria->addCondition('asuransipasien_aktif is true');
            if ($_GET['pasien_id'] == "") {
                $criteria->addCondition('pasien_id is null');
            } else {
                $criteria->addCondition('pasien_id=' . $pasien_id);
            }
            $criteria->order = 'namapemilikasuransi';
            $criteria->limit = 5;
            $models = PPAsuransipasienM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nopeserta . ' - ' . $model->namapemilikasuransi;
                $returnVal[$i]['value'] = $model->nopeserta;
                $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
                $returnVal[$i]['nokartuasuransi'] = $model->nokartuasuransi;
                $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
                $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
                $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
                $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
                $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
                $returnVal[$i]['nominal_tanggungan'] = $model->nominal_tanggungan;
            }


            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

    public function actionAutocompleteAsuransiKartu()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $nokartuasuransi = isset($_GET['nokartuasuransi']) ? $_GET['nokartuasuransi'] : '';
            $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
            $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nokartuasuransi)', strtolower($nokartuasuransi), true);
            $criteria->addCondition('penjamin_id=' . $penjamin_id);
            if ($_GET['pasien_id'] == "") {
                $criteria->addCondition('pasien_id is null');
            } else {
                $criteria->addCondition('pasien_id=' . $pasien_id);
            }
            $criteria->order = 'namapemilikasuransi';
            $criteria->limit = 5;
            $models = PPAsuransipasienM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nokartuasuransi . ' - ' . $model->namapemilikasuransi;
                $returnVal[$i]['value'] = $model->nokartuasuransi;
                $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
                $returnVal[$i]['nopeserta'] = $model->nopeserta;
                $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
                $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
                $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
                $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
                $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
                $returnVal[$i]['nominal_tanggungan'] = $model->nominal_tanggungan;
            }


            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

    public function actionAutocompleteAsuransiBadak()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $nopeserta = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : '';
            $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
            $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nopeserta)', strtolower($nopeserta), true);
            if (!empty($pasien_id)) {
                $criteria->addCondition('pasien_id=' . $pasien_id);
            }
            if (!empty($penjamin_id)) {
                $criteria->addCondition('penjamin_id=' . $penjamin_id);
            }
            $criteria->order = 'namapemilikasuransi';
            $criteria->limit = 5;
            $models = PPAsuransipasienM::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nopeserta . ' - ' . $model->namapemilikasuransi;
                $returnVal[$i]['value'] = $model->nopeserta;
                $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
                //				$returnVal[$i]['nopeserta'] = $model->nopeserta;
                $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
                $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
                $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
                $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
                $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;

                $modPegawai = '';
                $modPegawai = PPPegawaiM::model()->findByPk($model->pasien->pegawai_id);
                $returnVal[$i]['alamat_pegawai'] = !empty($modPegawai) ? $modPegawai->alamat_pegawai : '';
                $returnVal[$i]['notelp_pegawai'] = !empty($modPegawai) ? $modPegawai->notelp_pegawai : '';
            }
            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }


    public function actionGetDataPasienNIK()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $nik = $_POST['nik'];

            $id = 0;
            $pasien = PasienM::model()->findByAttributes(array(
                'no_identitas_pasien' => $nik,
            ));

            if (!empty($pasien))
                $id = $pasien->pasien_id;

            echo CJSON::encode(array('id' => $id));
        }
    }

    /**
     * Mengurai data pasien berdasarkan pasien_id
     * @throws CHttpException
     */
    public function actionGetDataPasien()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
            $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
            $returnVal = array();
            if (!empty($pasien_id)) {
                $p = PasienM::model()->findByPk($pasien_id);
                $pendaftaran = PendaftaranT::model()->findByAttributes(array(
                    'pasien_id' => $pasien_id,
                ), array(
                    'condition' => 'pasienbatalperiksa_id is null'
                ));
                if (empty($pendafaran)) {
                    $pendaftaran = PendaftaranT::model()->findByAttributes(array(
                        'pasien_id' => $pasien_id,
                    ), array(
                        'condition' => 'pasienbatalperiksa_id is null',
                        'order' => 'tgl_pendaftaran desc',
                    ));
                }
            } else if (!empty($no_rekam_medik)) {
                //var_dump($no_rekam_medik); die;
                $p = PasienM::model()->findByAttributes(array('no_rekam_medik' => trim($no_rekam_medik)));
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
            } else {
                $pendaftaran = null;
            }

            $returnVal['lebih'] = false;
            $returnVal['adaDaftar'] = false;
            $returnVal['is_kabur'] = false;

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

            if (empty($p) && isset($_POST['is_manual']) && $_POST['is_manual'] == true) {
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
            if ($pp->carakeluar_id == Params::CARAKELUAR_ID_MELARIKANDIRI) {
                $returnVal['is_kabur'] = true;
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
            // RSIH-486
            // penambahan kondisi pasien sedang di periksa 23/Mei/2022
            if ($isAda && !in_array($pendaftaran->statusperiksa, array(Params::STATUSPERIKSA_SUDAH_DIPERIKSA, Params::STATUSPERIKSA_SUDAH_PULANG, Params::STATUSPERIKSA_ANTRIAN, Params::STATUSPERIKSA_SEDANG_PERIKSA))) {
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
            if ($pp->carakeluar_id == Params::CARAKELUAR_ID_MELARIKANDIRI) {
                $returnVal['is_kabur'] = true;
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
        // RSIH - 1971
        $isAda = false;
        // if (date('Y-m-d', time()) == date('Y-m-d', strtotime($pendaftaran->tgl_pendaftaran))) {
        if ($isAda && !in_array($pendaftaran->statusperiksa, array(Params::STATUSPERIKSA_SUDAH_DIPERIKSA, Params::STATUSPERIKSA_SUDAH_PULANG, Params::STATUSPERIKSA_ANTRIAN))) {
            $returnVal['adaDaftar'] = true;
            $returnVal['listDaftar'] = $pendaftaran->attributes;
            $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
            $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
            $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
        }
    }


    /**
     * Mengurai data pasien berdasarkan pasien_id
     * @throws CHttpException
     */
    public function actionGetRuanganPoliklinikPasien()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
            $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
            $returnVal = array();
            if (!empty($pasien_id)) {
                $criteria = new CDbCriteria();
                if (!empty($pasien_id)) {
                    $criteria->addCondition("pasien_id = " . $pasien_id);
                }
                if (!empty($ruangan_id)) {
                    $criteria->addCondition("ruangan_id = '" . $ruangan_id . "'");
                }
                $tgl_awal = date('Y-m-d');
                $tgl_akhir = date('Y-m-d');
                $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_awal, $tgl_akhir);
                $model = InfokunjunganrjV::model()->findAll($criteria);
                //                echo count((array)$model);exit;
                if (count((array)$model) > 0) {
                    $returnVal['status'] = 'Ya';
                    $returnVal['pesan']  = "Pasien sudah mendaftarkan sebelumnya ke Poliklinik : <br/>";
                    $returnVal['pesan'] .= "<ol type=1>";
                    foreach ($model as $i => $ruangan) {
                        $returnVal['pesan'] .= "<li>" . $ruangan->ruangan_nama . " - " . ($format->formatDateTimeForUser($ruangan->tgl_pendaftaran)) . "</li>";
                    }
                    $returnVal['pesan'] .= "</ol>";
                } else {
                    $returnVal['status'] = 'Tidak';
                }
            }
            //

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
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
     * set tanggal lahir dari umur (__ Thn __ Bln __ Hr)
     */
    public function actionSetTanggalLahir()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data['tanggal_lahir'] = date("d/m/Y", strtotime(CustomFunction::getTanggalUmur($_POST['umur'])));

            echo json_encode($data);
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
    /**
     * set dropdown dokter
     */
    public function actionSetDropdownDokter()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new PPPendaftaranT;
            $konfig = KonfigsystemK::model()->find();

            $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            if (!empty($_POST['ruangan_id'])) {

                $ruangan_id = $_POST['ruangan_id'];
                if (empty($konfig->dokterruangan) || !$konfig->dokterruangan) {
                    $ruangan_id = null;
                }

                $data = $model->getDokterItems($ruangan_id);
                $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');
                foreach ($data as $value => $name) {
                    $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            }
            $dataList['listDokter'] = $option;
            echo json_encode($dataList);
            Yii::app()->end();
        }
    }

    /**
     * set dropdown jenis kasus penyakit
     */
    public function actionSetDropdownJeniskasuspenyakit()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new PPPendaftaranT;
            $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            if (!empty($_POST['ruangan_id'])) {
                $modRuangan = RuanganM::model()->findByPk($_POST['ruangan_id']);
                if (!empty($modRuangan)) {
                    if ($modRuangan->instalasi_id != Params::INSTALASI_ID_RJ && $modRuangan->instalasi_id != Params::INSTALASI_ID_RD) {
                        $data = $model->getJenisKasusPenyakitItemsRI($_POST['ruangan_id']);
                    } else {
                        $data = $model->getJenisKasusPenyakitItems($_POST['ruangan_id']);
                    }
                } else {
                    $data = $model->getJenisKasusPenyakitItems($_POST['ruangan_id']);
                }

                $data = CHtml::listData($data, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');
                foreach ($data as $value => $name) {
                    $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            }
            $dataList['listKasuspenyakit'] = $option;
            echo json_encode($dataList);
            Yii::app()->end();
        }
    }

    public function actionsetDropDownRuangan()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new PPPendaftaranT;
            $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            if (!empty($_POST['jeniskasuspenyakit_id'])) {
                if (!empty($_POST['instalasi_id'])) {
                    $data = $model->getRuanganPenyakitItems($_POST['jeniskasuspenyakit_id'], $_POST['instalasi_id']);
                    $data = CHtml::listData($data, 'ruangan_id', 'ruangan_nama');
                    foreach ($data as $value => $name) {
                        $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
            $dataList['listRuangan'] = $option;
            echo json_encode($dataList);
            Yii::app()->end();
        }
    }

    public function actionsetSMF()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new PPPendaftaranT;
            $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            $dataList = array();
            if (!empty($_POST['kodePenyakit'])) {
                $data = $model->getSMF($_POST['kodePenyakit']);
                $dataList['listSMF'] = $data[0]['jeniskasuspenyakit_id'];
            }
            // $dataList['listSMF'] = $option;
            echo json_encode($dataList);
            Yii::app()->end();
        }
    }
    /**
     * set dropdown penjamin pasien dari carabayar_id
     * @param type $encode
     * @param type $namaModel
     */
    public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '')
    {
        if (Yii::app()->request->isAjaxRequest) {
            $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
            if ($encode) {
                echo CJSON::encode($penjamin);
            } else {
                if (empty($carabayar_id)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
                    if (count((array)$penjamin) > 1) {
                        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    }
                    $penjamin_list = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
                    $penjamin_jenis = CHtml::listData($penjamin, 'penjamin_id', 'jenispeserta_bpjs');
                    $i = 1;
                    foreach ($penjamin_list as $value => $name) {
                        if ($i == 1) {
                            echo CHtml::tag('option selected', array('value' => $value, 'data-jenis' => $penjamin_jenis[$value]), CHtml::encode($name), true);
                        } else {
                            echo CHtml::tag('option', array('value' => $value, 'data-jenis' => $penjamin_jenis[$value]), CHtml::encode($name), true);
                        }
                        $i++;
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /*
         * Mencari kelas pelayanan berdasarkan ruangan_id di tabel KelasruanganM
         * and open the template in the editor.
         */
    public function actionSetDropdownKelasPelayanan($encode = false, $namaModel = '')
    {
        if (Yii::app()->request->isAjaxRequest) {
            $ruangan_id = $_POST["$namaModel"]['ruangan_id'];
            $kelasPelayanan = null;
            if ($ruangan_id) {
                $kelasPelayanan = KelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id=' . $ruangan_id . ' and kelaspelayanan_aktif = true');
                $kelasPelayanan = CHtml::listData($kelasPelayanan, 'kelaspelayanan_id', 'kelaspelayanan.kelaspelayanan_nama');
            }
            if (empty($kelasPelayanan)) {
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            } else {
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                foreach ($kelasPelayanan as $value => $name) {
                    echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * set antrian ruangan
     */
    public function actionSetAntrianRuangan()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $ruangan_id = $_POST['ruangan_id'];
            $data = array();
            $data['maxantrianruangan'] = null;
            $data['no_urutantri'] = '001';
            $data['sisaantrian'] = 0;
            if (!empty($ruangan_id)) {
                $hari = strtolower(MyFormatter::getDayUser(date('w')));
                //                    $data['no_urutantri'] = MyGenerator::noAntrian($ruangan_id);
                $data['no_urutantri'] = MyGenerator::noAntrianPPKonsul($ruangan_id); //fungsi diganti karena no antrian duplikat ketika ada konsul poli ke ruangan.
                $criteria = new CDbCriteria;
                $criteria->addCondition("ruangan_id = " . $ruangan_id);
                $criteria->compare('lower(hari)', $hari);
                $modJadwalBukaPoli = JadwalbukapoliM::model()->findAll($criteria);
                $ruangan = RuanganM::model()->findByPk($ruangan_id);

                $tgl = date('Y-m-d');
                $criteria2 = new CDbCriteria;
                $criteria2->addCondition("ruangan_id = " . $ruangan_id);
                $criteria2->addCondition("DATE(tgl_pendaftaran) ='" . $tgl . "'");
                $modSisaAntrian = PPPendaftaranT::model()->findAll($criteria2);
                if (count((array)$modJadwalBukaPoli) > 0) {
                    foreach ($modJadwalBukaPoli as $key => $antrian) {
                        $data['maxantrianruangan'] = $antrian->maxantiranpoli;
                        // $data['jammulai'] = date('Y-m-d')." ".$antrian->jammulai;
                        // $data['jamtutup'] = date('Y-m-d')." ".$antrian->jamtutup;
                        // $data['jammulai_a'] = $antrian->jammulai;
                        // $data['jamtutup_a'] = $antrian->jamtutup;
                        $data['jammulaipendaftaran'] = date('Y-m-d') . " " . $antrian->jammulaipendaftaran;
                        $data['jamakhirpendaftaran'] = date('Y-m-d') . " " . $antrian->jamakhirpendaftaran;
                        $data['jammulai_a'] = $antrian->jammulaipendaftaran;
                        $data['jamtutup_a'] = $antrian->jamakhirpendaftaran;
                        $data['nama_ruangan'] = $ruangan->ruangan_nama;
                    }
                }
                $data['sisaantrian'] = count((array)$modSisaAntrian);
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    /**
     * set antrian dokter
     */
    public function actionSetAntrianDokter()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $ruangan_id = $_POST['ruangan_id'];
            $pegawai_id = $_POST['pegawai_id'];
            $data = array();
            $data['maxantriandokter'] = 0;
            $data['sisaantriandokter'] = 0;
            if (!empty($ruangan_id) && !empty($pegawai_id)) {
                $criteria = new CDbCriteria;
                $criteria->addCondition("ruangan_id = " . $ruangan_id);
                $criteria->addCondition("pegawai_id = " . $pegawai_id);
                $modJadwalDokter = JadwaldokterM::model()->findAll($criteria);
                $tgl = date('Y-m-d');
                $criteria2 = new CDbCriteria;
                $criteria2->addCondition("ruangan_id = " . $ruangan_id);
                $criteria2->addCondition("pegawai_id = " . $pegawai_id);
                $criteria2->addCondition("DATE(tgl_pendaftaran) ='" . $tgl . "'");
                //$criteria2->addCondition("tgl_pendaftaran = ".$tgl);
                $modSisaAntrianDokter = PPPendaftaranT::model()->findAll($criteria2);
                //$modSisaAntrianDokter= PPPendaftaranT::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'pegawai_id'=>$pegawai_id, 'tgl_pendaftaran' => $tgl ));
                if (count((array)$modJadwalDokter) > 0) {
                    foreach ($modJadwalDokter as $key => $antrian) {
                        $data['maxantriandokter'] = !empty($antrian->maximumantrian) ? ($antrian->maximumantrian + $antrian->maximumbpjsantrian) : 0;
                    }
                }
                $data['sisaantriandokter'] = count((array)$modSisaAntrianDokter);
            }
            echo json_encode($data);
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
            $asalRujukan_id = isset($_POST['asalrujukan_id']) ? $_POST['asalrujukan_id'] : null;

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
                if (!empty($asalRujukan_id)) {
                    $criteria->addCondition("asalrujukan_id = " . $asalRujukan_id);
                } else {
                    $criteria->addCondition("asalrujukan_id is null ");
                }
                if (!empty($pasien_id)) {
                    $is_pasien = 'false';
                } else if (empty($pasien_id)) {
                    $is_pasien = 'true';
                }

                //if (Yii::app()->user->getState('karcisbarulama')) { //RND-7737
                $criteria->addCondition("pasienbaru_karcis = $is_pasien");
                //}
                $modKarcisAll = KarcisV::model()->findAll($criteria);
                $modKarcisV = KarcisV::model()->findAll($criteria);
                // echo "<pre>"; print_r($modKarcisV);die;
                // susun karcis global
                $modKarcisFinal = array();
                $modKarcisAda = array();
                foreach ($modKarcisAll as $item) {
                    if (empty($modKarcisAda[$item->daftartindakan_id])) {
                        $modKarcisAda[$item->daftartindakan_id] = 1;
                        $modKarcisFinal[] = $item;
                    }
                }


                // echo "<pre>";
                // print_r(count((array)$modKarcisFinal));
                // exit;
                $form = $this->renderPartial($this->path_view . '_formKarcis', array('modKarcisAll' => $modKarcisFinal, 'modKarcisV' => $modKarcisV, 'modTindakan' => $modTindakan, 'format' => $format, 'is_pasien' => $is_pasien), true);
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
     * set tabel riwayat kunjungan pasien
     */
    public function actionSetRiwayatKunjunganPasien()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $data['table'] = "";
            $modPasien = new PPPasienM;
            $modPasien->pasien_id = $_POST['pasien_id'];
            $data['table'] = $this->renderPartial($this->path_view . '_tableRiwayatPasien', array(
                'modPasien' => $modPasien,
            ), true);
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * @param type $pendaftaran_id
     */
    public function actionPrintStatus($pendaftaran_id)
    {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modPenanggungjawab = array();
        if (!empty($modPendaftaran->penanggungjawab_id)) {
            $modPenanggungjawab = PPPenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
        }
        $karcis_id = null;
        $modTindakan =  TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), "karcis_id IS NOT NULL");
        $judul_print = 'Kunjungan Rawat Jalan';
        $this->render($this->path_view . 'printStatus', array(
            'format' => $format,
            'modPendaftaran' => $modPendaftaran,
            'modPenanggungjawab' => $modPenanggungjawab,
            'judul_print' => $judul_print,
            'modPasien' => $modPasien,
            'modTindakan' => $modTindakan,
        ));
    }

    public function actionPrintSjp($pendaftaran_id)
    {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        //  $modPenanggungjawab = array();
        //  if(!empty($modPendaftaran->penanggungjawab_id)){
        //    $modPenanggungjawab=PPPenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
        //  }
        // $karcis_id = null;
        //  $modTindakan =  TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), "karcis_id IS NOT NULL");
        //  $judul_print = 'Kartu Papua Sehat';
        $this->render($this->path_view . 'printSjp', array(
            'format' => $format,
            'modPendaftaran' => $modPendaftaran,
            //'modPenanggungjawab'=>$modPenanggungjawab,
            //  'judul_print'=>$judul_print,
            'modPasien' => $modPasien,
            //  'modTindakan'=>$modTindakan,
        ));
    }
    /**
     * @param type $pendaftaran_id
     */

    public function actionPrintKlaim($pendaftaran_id)
    {
        $this->layout = '//layouts/printWindows';

        $format = new MyFormatter;
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        // var_dump($modPendaftaran->carabayar_id)
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modAsuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
        $modPenanggungjawab = PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
        $modPegawai = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
        $modPenjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);
        // echo "<pre>";
        // var_dump($modPegawai);die;

        $judulLaporan = '';
        // var_dump($_REQUEST);die;

        // $caraPrint = $_REQUEST['caraPrint'];
        // if ($caraPrint == 'PRINT') {
        //     $this->layout = '//layouts/printWindows';
        // }
        $this->render($this->path_view . 'printKlaim', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modAsuransi'   => $modAsuransi,
            'modPenanggungjawab' => $modPenanggungjawab,
            'format' => $format,
            'modPegawai' => $modPegawai,
            'modPenjamin' => $modPenjamin,

            //'model' => $model,
            'judulLaporan' => $judulLaporan,
            //'caraPrint' => $caraPrint
        ));
    }

    public function actionPrintKarcis($pendaftaran_id)
    {

        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        // var_dump($modPendaftaran->carabayar_id)
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $lp = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);

        if (!empty($lp)) $modPegawai = PegawaiM::model()->findByPk($lp->pegawai_id);
        else $modPegawai = new PegawaiM;

        $karcis_id = null;
        $modTindakan =  TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), "karcis_id IS NOT NULL");
        $judul_print = 'Kunjungan ' . $modPendaftaran->ruangan->instalasi->instalasi_nama;

        $posisi = 'P'; //Posisi L->Landscape,P->Portait
        // $mpdf = new MyPDF60('',array(140,180));
        $mpdf = new MyPDF60('', array(76, 110));
        // $mpdf->mirrorMargins = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->SetHTMLFooter('<span></span>');
        $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/STRUCK.css');
        $mpdf->WriteHTML($formatkonten, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->WriteHTML(
            $this->renderPartial($this->path_view . 'printKarcis', array(
                'format' => $format,
                'modPendaftaran' => $modPendaftaran,
                'judul_print' => $judul_print,
                'modPasien' => $modPasien,
                'modTindakan' => $modTindakan,
                'modPegawai' => $modPegawai,
            ), true)
        );
        //                $mpdf->SetJS('this.print();');
        $mpdf->Output();
    }
    /**
     * print kartu pasien
     * @param type $pasien_id
     * RND-9125
     */
    public function actionPrintKartuPasien($pasien_id)
    {
        $this->layout = '//layouts/printWindows';
        $modPasien = PasienM::model()->findByPk($pasien_id);
        //            echo '<pre>';
        //            print_r($modPasien);
        //            exit();
        $judul_print = 'Kartu Pasien';
        $this->render(
            $this->path_view . 'printKartuPasienKen',
            array(
                'modPasien' => $modPasien,
                'judul_print' => $judul_print
            )
        );
    }

    /**
     * Catat print kartu
     * @param type $model PasienM data Pasien
     */
    public function catatPrintKartu($model)
    {
        $pk = new KartupasienR();
        $pk->pasien_id = $model->pasien_id;
        $pk->tglprintkartu = date('Y-m-d H:i:s');
        $pk->statusprintkartu = true;
        $pk->create_time = date('Y-m-d');
        $pk->create_loginpemakai_id = Yii::app()->user->id;

        if ($pk->validate()) {
            $pk->save();
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
        if (isset($modSep->print_ke) && !empty($modSep->print_ke)) {
            $modSep->print_ke++;
            ARSepT::model()->updateByPk($modSep->sep_id, array('print_ke' => $modSep->print_ke));
            // $modSep->update(array('print_ke'));
        } else {
            $modSep->print_ke = 1;
            ARSepT::model()->updateByPk($modSep->sep_id, array('print_ke' => $modSep->print_ke));
            // $modSep->update(array('print_ke'));
        }
        $bpjs = new Bpjs();
        $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta' => $modSep->nokartuasuransi));
        $modJenisPeserta = PPJenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
        if (isset($modSep->norujukan)) {
            $modRujukanBpjs = PPRujukanbpjsT::model()->findByAttributes(array('no_rujukan' => $modSep->norujukan));
        }
        $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modRujukan = RujukanT::model()->findByPk($modPendaftaran->rujukan_id);
        $bpjs = new BpjsVklaim;
        $dataSep = CJSON::decode($bpjs->search_sep($modSep->nosep));
        if ($dataSep['metaData']['code'] == 200) {
            $dataSep_new = $dataSep['response'];
        }
        // echo "<pre>";
        // var_dump($dataSep);die;
        $judul_print = 'SURAT ELIGIBILITAS PESERTA';
        $this->render($this->path_view . 'printSep_baru3', array(
            'format' => $format,
            'modSep' => $modSep,
            'judul_print' => $judul_print,
            'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
            'modRujukanBpjs' => $modRujukanBpjs,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modJenisPeserta' => $modJenisPeserta,
            'modRujukan' => $modRujukan,
            'data_sep' => $dataSep_new
        ));
    }

    public function actionPrintHak($pendaftaran_id)
    {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;

        $hak = new HakpasienM;
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));


        $judul_print = 'HAK DAN KEWAJIBAN PASIEN';
        $this->render($this->path_view . 'printHak', array(
            'format' => $format,
            'hak' => $hak,
            'modLogin' => $modLogin,
            'judul_print' => $judul_print,
            'modPendaftaran' => $modPendaftaran
        ));
    }

    /**
     * action ketika tombol panggil di klik
     */
    public function actionPanggil($antrian_id, $loket_id, $ket = null, $no_antrian = null)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $data = array();
            $data['pesan'] = "";

            if (!empty($no_antrian)) {
                $cr = new CDbCriteria;
                $cr->join = "join modelantrian_m m on m.modelantrian_id = t.modelantrian_id 
                    JOIn ruangan_m r ON r.ruangan_id = t.ruangan_id 
                ";
                $cr->compare('DATE(t.tglantrian)', date("Y-m-d"));
                $cr->compare("m.modelantrian_singkatan || '-' || t.noantrian", trim($no_antrian));
                $modAntrian = PPAntrianT::model()->find($cr);
                if ($modAntrian == null) {
                    $modAntrian =  PPAntrianT::model()->findByPk($antrian_id);
                }
            } else {
                $modAntrian =  PPAntrianT::model()->findByPk($antrian_id);
            }

            if (isset($modAntrian)) {
                if ($modAntrian->panggil_flaq == true) {
                    if ($ket == "batal") {
                        $modAntrian->panggil_flaq = false;
                        if ($modAntrian->update()) {
                            //                            $data['pesan'] = "Pemanggilan no. antrian ".$modAntrian->noantrian." dibatalkan !";
                        }
                    } //else{
                    // $data['pesan'] = "No. antrian ".$modAntrian->noantrian." sudah dipanggil sebelumnya !";
                    // }
                } else {
                    $modAntrian->tglpanggil = date("Y-m-d H:i:s");
                    $modAntrian->status_panggil = ParamsConst::STATUSPANGGIL_ANTRIAN_TUNGGU;
                    $modAntrian->status_barcode = ParamsConst::STATUSBARCODE_ANTRIAN_PROSES;
                    $modAntrian->panggil_flaq = true;
                    if (empty($modAntrian->loket_id)) {
                        $modAntrian->loket_id = $loket_id;
                    }
                    if ($modAntrian->update()) {
                        //                        $data['pesan'] = "No. antrian ".$modAntrian->noantrian." dipanggil !";
                    }
                }

                // if($this->id == "pendaftaranRawatJalan"){
                //     $tglantrian = (!empty($modAntrian->tglantrian)? MyFormatter::formatDateTimeForDb($modAntrian->tglantrian) : date("Y-m-d H:i:s"));
                //     $tglsekarangPanggilan = date("Y-m-d H:i:s");
                //     Yii::app()->user->setState('settgl_ambilantrian',$tglantrian);
                //     Yii::app()->user->setState('settgl_panggilantrian',$tglsekarangPanggilan); 
                // }
            }
            $attributes = $modAntrian->attributeNames();
            foreach ($attributes as $i => $attribute) {
                $data["$attribute"] = $modAntrian->$attribute;
            }


            echo CJSON::encode($data);
            Yii::app()->end();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * menampilkan form antrian dari request ajax
     * @param type $record
     * @param type $noantrian
     * @throws CHttpException
     */
    public function actionSetFormAntrian()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $data = array();
            $data['pesan'] = "";
            $record = (isset($_POST['record']) ? $_POST['record'] : "");
            $noantrian = (isset($_POST['noantrian']) ? $_POST['noantrian'] : "");
            $loket_id = (isset($_POST['loket_id']) ? $_POST['loket_id'] : null);
            $modelantrian_id = (isset($_POST['modelantrian_id']) ? $_POST['modelantrian_id'] : null);
            $antrianId = isset($_POST['antrianId']) ? $_POST['antrianId'] : null;

            $modelLoket = ModelantrianM::model()->findByPk($loket_id);

            $data['antrian_prev'] = "X-0000";
            $data['antrian_next'] = "X-0000";

            if (empty($noantrian)) { //antrian baru

                // ambil antrian yang fastrack dulu 
                $criteria = new CDbCriteria();
                $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
                $criteria->addCondition("pendaftaran_id IS NULL");
                $criteria->addCondition("jenis_kunjungan='" . "Fast Track'");
                if ($record == "reset") {
                    $criteria->addCondition("panggil_flaq = false");
                }
                if (!empty($loket_id)) {
                    $criteria->addCondition("loket_id = " . $loket_id);
                }
                if (!empty($modelantrian_id)) {
                    $criteria->addCondition("modelantrian_id = " . $modelantrian_id);
                }
                $criteria->order = "noantrian::integer ASC";
                $criteria->limit = 1;
                $modAntrian =  PPAntrianT::model()->find($criteria);
                // echo '<pre>';
                // var_dump($modAntrian);die;
                if (empty($modAntrian)) {
                    $criteria = new CDbCriteria();
                    $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
                    $criteria->addCondition("pendaftaran_id IS NULL");
                    if ($record == "reset") {
                        $criteria->addCondition("panggil_flaq = false");
                    }
                    if (!empty($loket_id)) {
                        $criteria->addCondition("loket_id = " . $loket_id);
                    }
                    if (!empty($modelantrian_id)) {
                        $criteria->addCondition("modelantrian_id = " . $modelantrian_id);
                    }
                    $criteria->order = "noantrian::integer ASC";
                    $criteria->limit = 1;
                    $modAntrian =  PPAntrianT::model()->find($criteria);
                }
            } else {
                $criteria = new CDbCriteria();
                $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
                $criteria->compare("noantrian", trim($noantrian));
                $criteria->addCondition("pendaftaran_id IS NULL");
                $criteria->addCondition("jenis_kunjungan='" . "Fast Track'");
                $criteria->addCondition("panggil_flaq = false");
                if (!empty($loket_id)) {
                    $criteria->addCondition("loket_id = " . $loket_id);
                }
                if (!empty($modelantrian_id)) {
                    $criteria->addCondition("modelantrian_id = " . $modelantrian_id);
                }
                $cari =  PPAntrianT::model()->find($criteria);

                if (empty($cari)) {
                    $criteria = new CDbCriteria();
                    $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
                    $criteria->compare("noantrian", trim($noantrian));
                    $criteria->addCondition("pendaftaran_id IS NULL");
                    if (!empty($loket_id)) {
                        $criteria->addCondition("loket_id = " . $loket_id);
                    }
                    if (!empty($modelantrian_id)) {
                        $criteria->addCondition("modelantrian_id = " . $modelantrian_id);
                    }
                    $cari =  PPAntrianT::model()->find($criteria);
                }

                if (!empty($loket_id)) {
                    if ($record == 'next') {
                        $cari->loket_id = $loket_id;
                        if ($cari->jenis_kunjungan == 'Fast Track') {
                            $modAntrian = $cari->AntrianBerikutFast;

                            if ($modAntrian == null) {
                                $modAntrian = $cari->AntrianTerkecil;
                            }
                        } else {
                            $modAntrian = $cari->AntrianBerikut;
                        }
                    } else if ($record == 'prev') {
                        $cari->loket_id = $loket_id;
                        $modAntrian = $cari->AntrianSebelum;
                    } else {
                        $modAntrian = $cari;
                    }
                }
            };
            if (!empty($antrianId)) {
                $modAntrian = PPAntrianT::model()->findByPk($antrianId);
            }

            if (!isset($modAntrian)) {
                $modAntrian = new PPAntrianT;
                $data['pesan'] = "Antrian Habis !";
            }
            $antrianPrev = $modAntrian->AntrianSebelum;
            $antrianNext = $modAntrian->AntrianBerikut;
            $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);

            $viewAntrian = "_formPanggilAntrian";
            if (isset($_POST['menu']) && $_POST['menu'] == 1) {
                $viewAntrian = "_formPanggilAntrian2";
                $data['antrian_prev'] = empty($antrianPrev) ? "X-0000" : (empty($modelLoket->modelantrian_id) ? "X" : $modelLoket->modelantrian_singkatan) . "-" . (empty($antrianPrev->noantrian) ? "0000" : $antrianPrev->noantrian);
                $data['antrian_next'] = empty($antrianNext) ? "X-0000" : (empty($modelLoket->modelantrian_id) ? "X" : $modelLoket->modelantrian_singkatan) . "-" . (empty($antrianNext->noantrian) ? "0000" : $antrianNext->noantrian);
            }

            $data['form_antrian'] = $this->renderPartial($this->path_view . $viewAntrian, array('modAntrian' => $modAntrian), true);
            $data['antrianId'] = !empty($modAntrian) ? $modAntrian->antrian_id : null;
            $data['panggil'] = !empty($modAntrian) ? $modAntrian->panggil_flaq : false;
            $data['statuspanggil'] = !empty($modAntrian) ? $modAntrian->status_panggil : '';

            echo CJSON::encode($data);
            Yii::app()->end();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * untuk menampilkan data diagnosa dari autocomplete
     * 1. diagnosa_kode
     * 2. diagnosa_nama
     */
    public function actionAutocompleteDiagnosaRujukan()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $diagnosa_nama = isset($_GET['diagnosa_rujukan']) ? $_GET['diagnosa_rujukan'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(diagnosa_nama)', strtolower($diagnosa_nama), true);
            $criteria->order = 'diagnosa_nama';
            $criteria->limit = 5;
            $models = DiagnosaM::model()->findAll($criteria);
            $data = array();
            foreach ($models as $i => $model) {
                $data[$i] = array(
                    'key' => $model->diagnosa_kode,
                    'value' => $model->diagnosa_nama
                );
            }

            echo CJSON::encode($data);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

    public function actionDiagnosa()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(diagnosa_kode)', strtolower($_GET['term']), true);
            // $criteria->diagnosa_aktif = true;
            $criteria->order = 'diagnosa_kode';
            $criteria->limit = 10;
            $models = DiagnosaM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->diagnosa_kode . '-' . $model->diagnosa_nama;
                $returnVal[$i]['value'] = $model->diagnosa_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    /**
     * set bpjs Interface
     */
    public function actionBpjsInterface()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            if (empty($_GET['param']) or $_GET['param'] === '') {
                die('param can\'not empty value');
            } else {
                $param = $_GET['param'];
            }

            //                if(empty( $_GET['server'] ) OR $_GET['server'] === ''){
            //
            //                }else{
            //                    $server = 'http://'.$_GET['server'];
            //                }

            //                $bpjs = new Bpjs();
            $bpjs = new BpjsVklaim();

            switch ($param) {
                case '1':
                    $query = $_GET['query'];
                    //                        echo '<pre>';
                    print_r($bpjs->search_kartu($query));
                    //                        exit();
                    break;
                case '2':
                    $query = $_GET['query'];
                    print_r($bpjs->search_nik($query));
                    break;
                case '3':
                    $query = $_GET['query'];
                    $res = CJSON::decode($bpjs->search_rujukan_no_rujukan($query));
                    if (empty($res['response'])) {
                        $res = CJSON::decode($bpjs->search_rujukan_no_rujukan_rs($query));
                    }

                    $kode = $res['response']['rujukan']['diagnosa']["kode"];
                    $nama = $res['response']['rujukan']['diagnosa']["nama"];

                    $q = "diagnosa_kode = '$kode' AND diagnosa_nama = '$nama'";

                    $diagnosa = DiagnosaM::model()->find($q);

                    $res['response']['rujukan']['diagnosa']['id'] = (!empty($diagnosa) ? $diagnosa->diagnosa_id : '');

                    print_r(CJSON::encode($res));
                    break;
                case '4':
                    $query = $_GET['query'];
                    $tgl = isset($_GET['tgl']) ? MyFormatter::formatDateTimeForDb($_GET['tgl']) : null;
                    $suksesrujukan = false;
                    $dataRujukan = json_decode($bpjs->search_rujukan_rs_no_bpjs($query)); // search no rujukan by no kartu rs

                    if ($dataRujukan->metaData->code != 200) {
                        print_r($bpjs->search_rujukan_no_bpjs($query)); // search no rujukan pcare

                    } else {
                        print_r($bpjs->search_rujukan_rs_no_bpjs($query));
                    }

                    // $dataRujukan = json_decode($bpjs->search_rujukan_no_bpjs($query));

                    // if (isset($dataRujukan->metaData)) {
                    //     if ($dataRujukan->metaData->message == 'OK') {
                    //         $suksesrujukan = true;
                    //     }
                    // }

                    // if ($suksesrujukan) {
                    //     print_r(json_encode($dataRujukan));
                    // } else {
                    //     print_r($bpjs->search_kartu($query, $tgl));
                    // }
                    break;
                case '5':
                    $query = $_GET['query'];
                    $start = $_GET['start'];
                    $limit = $_GET['limit'];
                    print_r($bpjs->list_rujukan_tanggal($query, $start, $limit));
                    break;
                case '6':
                    $modPoli = RuanganM::model()->findByPk($_GET['poli_tujuan']);
                    $nokartu = $_GET['no_kartu'];
                    $tglsep = MyFormatter::formatDateTimeForDb($_GET['tgl_sep']);
                    $tglrujukan = MyFormatter::formatDateTimeForDb($_GET['tgl_rujukan']);
                    if ($_GET['jns_pelayanan'] == 1) {
                        $norujukan = $_GET['no_mr'];
                    } else {
                        $norujukan = $_GET['no_rujukan'];
                    }
                    $ppkrujukan = $_GET['ppk_rujukan'];
                    $ppkpelayanan = $_GET['ppk_pelayanan'];
                    $jnspelayanan = $_GET['jns_pelayanan'];
                    $lakalantas = isset($_GET['lakalantas']) ? $_GET['lakalantas'] : null;
                    $catatan = $_GET['catatan'];
                    $diagawal = $_GET['diag_awal'];
                    $politujuan = (!empty($modPoli->kode_ruanganpoli) ? $modPoli->kode_ruanganpoli : "");
                    $klsrawat = $_GET['kls_rawat'];
                    $user = $_GET['user'];
                    $nomr = (!empty($_GET['no_mr']) ? $_GET['no_mr'] : 0);
                    $notrans = $_GET['no_trans'];

                    $noTelp = isset($_GET['noTelp']) ? $_GET['noTelp'] : null;
                    $asalRujukan = $_GET['asalRujukan'];
                    $eksekutif = isset($_GET['eksekutif']) ? $_GET['eksekutif'] : null;
                    $cob = $_GET['cob'];
                    $penjamin = $_GET['penjamin'];
                    $lokasiLaka = isset($_GET['lokasiLaka']) ? $_GET['lokasiLaka'] : null;

                    $kelaspelayanan_id = $_GET['kelaspelayanan_id'];
                    if (!empty($kelaspelayanan_id)) {
                        $modKelas = KelaspelayananM::model()->findByPk($kelaspelayanan_id);
                        if (!empty($modKelas->kodekelaspelayanan_bpjs)) {
                            if ($modKelas->kodekelaspelayanan_bpjs <= $klsrawat) {
                                $klsrawat = $klsrawat;
                            } else {
                                $klsrawat = $modKelas->kodekelaspelayanan_bpjs;
                            }
                        }
                    }
                    if ($jnspelayanan == Params::JENISPELAYANAN_RJ) {
                        $klsrawat = 3;
                    }

                    $tglKejadian = isset($_GET['tglKejadian']) ? MyFormatter::formatDateTimeForDb($_GET['tglKejadian']) : null;
                    $keterangan = isset($_GET['keterangan']) ? $_GET['keterangan'] : null;
                    $suplesi = isset($_GET['suplesi']) ? $_GET['suplesi'] : null;
                    $noSepSuplesi = isset($_GET['noSepSuplesi']) ? $_GET['noSepSuplesi'] : null;
                    $kdPropinsi = isset($_GET['kdPropinsi']) ? $_GET['kdPropinsi'] : null;
                    $kdKabupaten = isset($_GET['kdKabupaten']) ? $_GET['kdKabupaten'] : null;
                    $kdKecamatan = isset($_GET['kdKecamatan']) ? $_GET['kdKecamatan'] : null;
                    $noSurat = isset($_GET['noSurat']) ? $_GET['noSurat'] : null;
                    $kodeDPJP = isset($_GET['kodeDPJP']) ? $_GET['kodeDPJP'] : null;
                    $katarak = isset($_GET['katarak']) ? $_GET['katarak'] : null;

                    print_r($bpjs->create_sep_new($nokartu, $tglsep, $ppkpelayanan, $jnspelayanan, $klsrawat, $nomr, $asalRujukan, $tglrujukan, $norujukan, $ppkrujukan, $catatan, $diagawal, $politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDPJP, $katarak));
                    //                        $nokartu = $_GET['no_kartu'];
                    //                        $tglsep = $_GET['tgl_sep'];
                    //                        $tglrujukan = $_GET['tgl_rujukan'];
                    //                        $norujukan = $_GET['no_rujukan'];
                    //                        $ppkrujukan = $_GET['ppk_rujukan'];
                    //                        $ppkpelayanan = $_GET['ppk_pelayanan'];
                    //                        $jnspelayanan = $_GET['jns_pelayanan'];
                    //                        $catatan = $_GET['catatan'];
                    //                        $diagawal = $_GET['diag_awal'];
                    //                        $politujuan = $_GET['poli_tujuan'];
                    //                        $klsrawat = $_GET['kls_rawat'];
                    //                        $user = $_GET['user'];
                    //                        $nomr = $_GET['no_mr'];
                    //                        $notrans = $_GET['no_trans'];
                    //                        print_r( $bpjs->create_sep_new($nokartu, $tglsep, $tglrujukan, $norujukan, $ppkrujukan, $ppkpelayanan, $jnspelayanan, $catatan, $diagawal, $politujuan, $klsrawat, $user, $nomr, $notrans) );
                    break;
                case '7':
                    $nosep = $_GET['nosep'];
                    $tglpulang = $_GET['tglpulang'];
                    $ppkpelayanan = $_GET['ppkpelayanan'];
                    print_r($bpjs->update_tanggal_pulang_sep($nosep, $tglpulang, $ppkpelayanan));
                    break;
                case '8':
                    $nosep = $_GET['nosep'];
                    $notrans = $_GET['notrans'];
                    $ppkpelayanan = $_GET['ppkpelayanan'];
                    print_r($bpjs->mapping_trans($nosep, $notrans, $ppkpelayanan));
                    break;
                case '9':
                    $nosep = $_GET['nosep'];
                    $ppkpelayanan = $_GET['ppkpelayanan'];
                    print_r($bpjs->delete_transaksi($nosep, $ppkpelayanan));
                    break;
                case '10':
                    $nokartu = $_GET['nokartu'];
                    print_r($bpjs->riwayat_terakhir($nokartu));
                    break;
                case '11':
                    $nosep = $_GET['nosep'];
                    print_r($bpjs->detail_sep($nosep));
                    break;
                case '12':
                    $query = $_GET['ppkrujukan'];
                    $query = explode(" ", $query);
                    $query = $query[0];
                    $query1 = '2';
                    $query1 = explode(" ", $query1);
                    $query1 = $query1[0];
                    $start = 1;
                    $limit = 10;
                    if ($query != '' && $query1 == '') {
                        $query = $query;
                    } else if ($query != '' && $query1 != '') {
                        $query = $query . '/' . $query1;
                    } else if ($query == '' && $query1 != '') {
                        $query = $query . '/' . $query1;
                    }
                    $str = $bpjs->fasilitas_kesehatan($query, $start, $limit);
                    if (!empty($str)) {
                        $json = CJSON::decode($str);
                        if (!empty($json['response']) && $json['response'] != "") {
                            $modRujukanDari = RujukandariM::model()->findByAttributes(array('kodeppk' => $json['response']['faskes'][0]['kode']));
                            $json['response']['faskes'][0]['asalrujukan_id'] =  $modRujukanDari->asalrujukan_id;
                            // echo "<pre>";
                            // var_dump($modRujukanDari);die;
                        }
                    }
                    print_r(CJSON::encode($json));
                    break;
                case '13':
                    $query = $_GET['query'];
                    // $tipe = isset($_GET['query2']) ? $_GET['query2'] : null;
                    $konfig = KonfigsystemK::model()->find();
                    if ($konfig->jenisrujukan == 2) {
                        $search = json_decode($bpjs->search_rujukan_multi_rs_list($query));
                        if ($search->metaData->code != 200) {
                            print_r($bpjs->search_rujukan_pcare_multi($query));
                        } else {
                            print_r($bpjs->search_rujukan_multi_rs_list($query));
                        }
                    } else if ($konfig->jenisrujukan == 1) {
                        $search = json_decode($bpjs->search_rujukan_pcare_multi($query));
                        if ($search->metaData->code != 200) {
                            print_r($bpjs->search_rujukan_multi_rs_list($query));
                        } else {
                            print_r($bpjs->search_rujukan_pcare_multi($query));
                        }
                        // print_r( $bpjs->search_rujukan_pcare_multi($query) );
                    }
                    // if ($tipe == 1) {
                    //     print_r( $bpjs->search_rujukan_pcare_multi($query) );
                    // } else if ($tipe == 2) {
                    //     print_r( $bpjs->search_rujukan_multi_rs_list($query) );
                    // }
                    break;
                case '16':
                    $query = $_GET['kodeppkpelayanan'];
                    $query = explode(" ", $query);
                    $query = $query[0];
                    $query1 = $_GET['jenis_rujukan'];
                    $query1 = explode(" ", $query1);
                    $query1 = $query1[0];
                    $start = 1;
                    $limit = 10;
                    if ($query != '' && $query1 == '') {
                        $query = $query;
                    } else if ($query != '' && $query1 != '') {
                        $query = $query . '/' . $query1;
                    } else if ($query == '' && $query1 != '') {
                        $query = $query . '/' . $query1;
                    }
                    print_r($bpjs->fasilitas_kesehatan($query, $start, $limit));
                    break;
                case '17':
                    $query1 = $_GET['katakunci1'];
                    $query2 = MyFormatter::formatDateTimeForDb($_GET['katakunci2']);
                    $query3 = (!empty($_GET['katakunci3']) ? $_GET['katakunci3'] : "");
                    $config = KonfigsystemK::model()->find();
                    if ($config->tipe_bridging == 1) {
                        $query = $query1 . "/tglPelayanan/" . $query2 . "/Spesialis/" . $query3;
                    } else {
                        $query = $query1 . "/" . $query2 . "/" . $query3;
                    }
                    $start = 1;
                    $limit = 10;
                    print_r($bpjs->search_dpjp($query, $start, $limit));
                    break;
                case '18':
                    $query = $_GET['query'];

                    $str = $bpjs->search_no_surat_kontrol($query);
                    if (!empty($str)) {
                        $json = CJSON::decode($str);
                        if (!empty($json['response']) && $json['response'] != "") {
                            $json['response']['poli_tujuan'] = "-";
                            $json['response']['sep']['peserta']['tglLahir'] = date('d/m/Y', strtotime($json['response']['sep']['peserta']['tglLahir']));
                            $json['response']['sep']['tglSep'] = date('d/m/Y', strtotime($json['response']['sep']['tglSep']));
                            $json['response']['tglTerbit'] = date('d/m/Y', strtotime($json['response']['tglTerbit']));
                            // var_dump($json); die;

                            $tgl_rencana =  $json['response']['tglRencanaKontrol'];

                            $date_rencana = new DateTime($tgl_rencana);
                            $date_sekarang = new DateTime(date('Y-m-d'));

                            $status = 0;
                            if ($date_sekarang > $date_rencana) {
                                $status = 1;
                            } else if ($date_sekarang < $date_rencana) {
                                $status = -1;
                            }

                            $json['response']['status_kontrol'] = $status;
                            $json['response']['tglRencanaKontrol'] = date('d/m/Y', strtotime($json['response']['tglRencanaKontrol']));

                            $ruangan = RuanganM::model()->findByAttributes(array(
                                'kode_bpjs' => $json['response']['poliTujuan'],
                                'ruangan_aktif' => true,
                            ));

                            if (!empty($ruangan)) {
                                $json['response']['poli_tujuan'] = $ruangan->ruangan_nama;
                            }
                        }

                        print_r(CJSON::encode($json));
                    }

                    break;

                case '19': // khususu untuk mencari data spri
                    $query = $_GET['query'];
                    $no_kartu = $_GET['nokartu'];

                    $str = $bpjs->search_no_surat_kontrol($query);
                    $dataPeserta = CJSON::decode($bpjs->search_kartu($no_kartu));
                    if (!empty($str)) {
                        $json = CJSON::decode($str);

                        if (!empty($json['response']) && $json['response'] != "") {

                            $json['response']['sep']['peserta']['nama'] = $dataPeserta['response']['peserta']['nama'];
                            $json['response']['sep']['peserta']['kelamin'] = $dataPeserta['response']['peserta']['sex'];
                            $json['response']['sep']['peserta']['tglLahir'] = date('d/m/Y', strtotime($dataPeserta['response']['peserta']['tglLahir']));
                            $json['response']['sep']['tglSep'] = '';
                            $json['response']['tglTerbit'] = date('d/m/Y', strtotime($json['response']['tglTerbit']));


                            $tgl_rencana =  $json['response']['tglRencanaKontrol'];

                            $date_rencana = new DateTime($tgl_rencana);
                            $date_sekarang = new DateTime(date('Y-m-d'));

                            $status = 0;
                            if ($date_sekarang > $date_rencana) {
                                $status = 0;
                            } else if ($date_sekarang < $date_rencana) {
                                $status = -1;
                            }

                            $modSuratRI = SuratperintahranapT::model()->findByAttributes(array('nomorspri_bpjs' => $query));
                            if (!empty($modSuratRI)) {
                                $modPasienMoribiditas = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $modSuratRI->pendaftaran_id));
                                if (!empty($modPasienMoribiditas)) {
                                    $json['response']['diagnosa_kode'] = $modPasienMoribiditas->diagnosa->diagnosa_kode;
                                    $json['response']['diagnosa_nama'] = $modPasienMoribiditas->diagnosa->diagnosa_nama;
                                }
                            } else {
                                $json['response']['diagnosa_kode'] = "0";
                                $json['response']['diagnosa_nama'] = "0";
                            }

                            $json['response']['status_kontrol'] = $status;
                            $json['response']['tglRencanaKontrol'] = date('d/m/Y', strtotime($json['response']['tglRencanaKontrol']));
                        }

                        print_r(CJSON::encode($json));
                    }

                    break;
                case '99':
                    $bpjs->identity_magic();
                    break;
                case '100':
                    print_r($bpjs->help());
                    break;
                default:
                    die('error number, please check your parameter option');
                    break;
            }
            Yii::app()->end();
        }
    }

    /**
     * set Inhealth Interface
     */
    public function actionInhealthInterface()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            if (empty($_GET['param']) or $_GET['param'] === '') {
                die('param can\'not empty value');
            } else {
                $param = $_GET['param'];
            }

            $inhealth = new Inhealth(); //service briging inhealth

            switch ($param) {
                case '1':
                    $nokainhealth = $_GET['nokainhealth'];
                    $tglpelayanan = $_GET['tglpelayanan'];
                    $jenispelayanan = $_GET['jenispelayanan'];
                    $poli = $_GET['poli'];
                    $modPoli = RuanganM::model()->findByPk($poli);
                    $poli = (!empty($modPoli->kode_poliinhealth) ? $modPoli->kode_poliinhealth : "");
                    print_r($inhealth->EligibilitasPeserta($nokainhealth, date('Y-m-d', strtotime($tglpelayanan)), $jenispelayanan, $poli));
                    break;
                case '2':
                    $tanggalpelayanan = date('Y-m-d', strtotime($_GET['tanggalpelayanan']));
                    $jenispelayanan = $_GET['jenispelayanan'];
                    $nokainhealth = $_GET['nokainhealth'];
                    $nomormedicalreport = $_GET['nomormedicalreport'];
                    $nomorasalrujukan = $_GET['nomorasalrujukan'];
                    $kodeproviderasalrujukan = $_GET['kodeproviderasalrujukan'];
                    $tanggalasalrujukan = date('Y-m-d', strtotime($_GET['tanggalasalrujukan']));
                    $kodediagnosautama = $_GET['kodediagnosautama'];
                    $poli = $_GET['poli'];
                    $informasitambahan = $_GET['informasitambahan'];
                    $kodediagnosatambahan = $_GET['kodediagnosatambahan'];
                    $kecelakaankerja = $_GET['kecelakaankerja'];
                    $kelasrawat = $_GET['klsrawat'];
                    $kelaspelayanan_id = $_GET['kelaspelayanan_id'];

                    if (!empty($kelaspelayanan_id)) {
                        $klsInhealth = KelaspelayananM::model()->findByPk($kelaspelayanan_id);
                        if (!empty($klsInhealth->kode_kelas_inhealth)) {
                            $kelaspelayanan_id = $klsInhealth->kode_kelas_inhealth;
                            $kelasrawat = $kelaspelayanan_id;
                        }
                    }

                    $modPoli = RuanganM::model()->findByPk($poli);
                    $poli = (!empty($modPoli->kode_poliinhealth) ? $modPoli->kode_poliinhealth : "");
                    $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->id);
                    $username = isset($modPegawai->nama_pegawai) ? $modPegawai->nama_pegawai : '-';
                    $kodejenpelruangrawat = null;

                    print_r($inhealth->SimpanSJP($tanggalpelayanan, $jenispelayanan, $nokainhealth, $nomormedicalreport, $nomorasalrujukan, $kodeproviderasalrujukan, $tanggalasalrujukan, $kodediagnosautama, $poli, $username, $informasitambahan, $kodediagnosatambahan, $kecelakaankerja, $kelasrawat, $kodejenpelruangrawat));
                    break;
                case 3:
                    $SEP = PPSepInhealthT::model()->findByPk($_GET['sep_id']);
                    $tkp = $_GET['tkp'];

                    print_r($inhealth->CetakSJP($SEP->nosep, $tkp));
                    break;
                default:
                    die('error number, please check your parameter option');
                    break;
            }
        }
    }

    public function actionGetRujukanDariBpjs()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $kodeppk = $_POST['kodeppk'];
            $jenisfaskes =  (isset($_POST['jenisfaskes']) ? $_POST['jenisfaskes'] : 2);
            $nama = (isset($_POST['nama']) ? $_POST['nama'] : null);
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
                if ($jenisfaskes == 1) {
                    $data['asalrujukan'] = 4;
                } else {
                    $data['asalrujukan'] = 6;
                }
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
            } else {
                $modRujukanDari = new RujukandariM;
                if ($jenisfaskes == 1) {
                    $modRujukanDari->asalrujukan_id = 4;
                    $modRujukanDari->namaperujuk = $nama;
                    $modRujukanDari->kodeppk = $kodeppk;
                    $modRujukanDari->ppkrujukan = $kodeppk;
                    $modRujukanDari->fee_rujukan = 0;
                } else {
                    $modRujukanDari->asalrujukan_id = 6;
                    $modRujukanDari->namaperujuk = $nama;
                    $modRujukanDari->kodeppk = $kodeppk;
                    $modRujukanDari->ppkrujukan = $kodeppk;
                    $modRujukanDari->fee_rujukan = 0;
                }
                $data['rujukandari'] = $modRujukanDari->rujukandari_id;
                $data['asalrujukan'] = $modRujukanDari->asalrujukan_id;
                $modRujukanDari->save();
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }


    /**
     * menampilkan data asuransi terakhir pasien
     * @throws CHttpException
     */
    public function actionSetAsuransiPasienLama()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data = array();
            $data['isBpjs'] = false;
            $criteria = new CDbCriteria();
            $criteria->addCondition("pasien_id = " . $_POST['pasien_id']);
            $criteria->order = 'asuransipasien_id DESC';
            $model = AsuransipasienM::model()->find($criteria);
            if (!empty($model)) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $data["$attribute"] = $model->$attribute;
                }

                if ($data['carabayar_id'] == Params::CARABAYAR_ID_BPJS) {
                    $data['isBpjs'] = true;
                    $kelasbpjs_id = KelaspelayananM::model()->findByPk($data['kelastanggunganasuransi_id']);
                    if (!empty($kelasbpjs_id)) {
                        $data['kelastanggunganasuransi_id'] = $kelasbpjs_id->kelasbpjs_id;
                    }
                }
                //if($model->carabayar_id == Params::CARABAYAR_ID_BADAK){
                //	$data["penjamin_nama"] = $model->carabayar->carabayar_nama;
                //}else{
                $data["penjamin_nama"] = $model->penjamin->penjamin_nama;
                //}
                $data['listPenjamin'] = "";
                $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $model->carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
                if (count((array)$penjamin) > 1) {
                    $data['listPenjamin'] .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                }
                $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
                foreach ($penjamin as $value => $name) {
                    $data['listPenjamin'] .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            } else {
                $data = null;
            }
            echo CJSON::encode($data);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

    /**
     * untuk menampilkan data pegawai
     */
    public function actionAutocompletePegawai()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $nomorindukpegawai = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
            $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nomorindukpegawai)', strtolower($nomorindukpegawai), true);
            $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
            $criteria->order = 'nomorindukpegawai, nama_pegawai';
            $criteria->limit = 5;
            $models = PPPegawaiM::model()->findAll($criteria);
            if (count((array)$models) > 0) {
                foreach ($models as $i => $model) {
                    $returnVal[$i] = $model->attributes;
                    if (!empty($nomorindukpegawai)) {
                        $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai;
                    } else {
                        $returnVal[$i]['label'] = $model->nama_pegawai;
                    }
                    $returnVal[$i]['value'] = $model->pegawai_id;
                    $returnVal[$i]['jabatan_nama'] = !empty($model->jabatan_id) ? $model->jabatan->jabatan_nama : "";
                    $returnVal[$i]['gelarbelakang_nama'] = !empty($model->gelarbelakang_id) ? $model->gelarbelakang->gelarbelakang_nama : "";
                }
            }
            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

    /**
     * Cek keaktifan pegawai jika penjamin pt badak
     * @param type $encode
     * @param type $namaModel
     */
    public function actionCekCaraBayarBadak()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $pasien_id = $_POST['pasien_id'];
            $pegawai_id = $_POST['pegawai_id'];
            $pesan = '';
            $status = false;
            $modPegawai = PPPegawaiM::model()->findByPk($pegawai_id);
            if (!empty($modPegawai)) {
                if ($modPegawai->pegawai_aktif) {
                    $status = true;
                } else {
                    $status = false;
                    $pesan = 'Data Pegawai tidak aktif';
                }
            } else {
                $status = false;
                $pesan = 'Data tidak ditemukan';
            }
            echo CJSON::encode(array('status' => $status, 'pesan' => $pesan));
        }
        Yii::app()->end();
    }

    /**
     * Cek kategori pegawai untuk menentukan asuransi pasien
     * @param type $encode
     * @param type $namaModel
     */
    public function actionCekValiditasPenjamin()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : '';
            $penjamin_id =  isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : '';
            $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : '';
            $penj = '';
            $pesan = '';
            $status = '';
            $html = '';
            $data = null;
            switch ($_POST['type']) {
                case "badak":

                    $modPegawai = PPPegawaiM::model()->findByPk($pegawai_id);
                    $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => Params::CARABAYAR_ID_BADAK, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
                    $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
                    $html .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($penjamin as $value => $name) {
                        $html .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }

                    if (!empty($modPegawai)) {
                        if ($modPegawai->kategoripegawai == "") {
                            $status = "Empty";
                            $pesan = 'Data Kategori pegawai penanggung jawab pasien tidak ditemukan!<br>Lakukan pengaturan kategori pegawai di modul kepegawaian';
                        } else {
                            if ($penjamin_id == Params::PENJAMIN_ID_PISA) {
                                $penj = Params::PENJAMIN_ID_PISA;
                                if ($modPegawai->kategoripegawai == "Tidak Tetap") {
                                    $status = "Tidak Tetap";
                                    $pesan = 'Tidak dapat memilih penjamin PISA. <br> Karena pegawai penanggung jawab pasien adalah pegawai tidak tetap / telah pensiun';
                                }
                            } else if ($penjamin_id == Params::PENJAMIN_ID_PROKESPEN) {
                                $penj = Params::PENJAMIN_ID_PROKESPEN;
                            }
                        }
                    } else {
                        $status = "Fail";
                        $pesan = 'Data tidak ditemukan';
                    }
                    break;

                case "departemen":

                    $modPenjamin = PenjaminpasienM::model()->findByPk($penjamin_id);
                    $data['penjamin_nama'] = $modPenjamin->penjamin_nama;
                    break;
            }

            echo CJSON::encode(array('status' => $status, 'pesan' => $pesan, 'html' => $html, 'penj' => $penj, 'data' => $data));
        }
        Yii::app()->end();
    }

    /**
     * Ngeset data asuransi badak jika pasien telah memiliki data di asuransipasien_m
     * @param type $encode
     * @param type $namaModel
     */
    public function actionSetAsuransiBadak()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data = array();

            if ((!empty($_POST['pasien_id'])) && (!empty($_POST['penjamin_id']))) {
                $criteria = new CDbCriteria();
                $criteria->addCondition("pasien_id = " . $_POST['pasien_id']);
                $criteria->addCondition("penjamin_id = " . $_POST['penjamin_id']);
                $criteria->order = 'asuransipasien_id DESC';
                $model = AsuransipasienM::model()->find($criteria);
                if (!empty($model)) {
                    $attributes = $model->attributeNames();
                    foreach ($attributes as $j => $attribute) {
                        $data["$attribute"] = $model->$attribute;
                    }
                    $data['listPenjamin'] = "";
                    $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $model->carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
                    if (count((array)$penjamin) > 1) {
                        $data['listPenjamin'] .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    }
                    $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
                    foreach ($penjamin as $value => $name) {
                        $data['listPenjamin'] .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                } else {
                    $data = null;
                    $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : '';
                    if (!empty($pegawai_id)) {
                        $modPegawai = PPPegawaiM::model()->findByPk($pegawai_id);
                        $data['nopeserta'] = $modPegawai->nomorindukpegawai;
                        $data['namaperusahaan'] = $modPegawai->unit_perusahaan;
                        $data['namapemilikasuransi'] = $modPegawai->nama_pegawai;
                        $data['namaperusahaan'] = 'PT. Badak LNG';
                    }
                }
            } else {
                $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : '';
                if (!empty($pegawai_id)) {
                    $modPegawai = PPPegawaiM::model()->findByPk($pegawai_id);
                    $data['nopeserta'] = $modPegawai->nomorindukpegawai;
                    $data['namaperusahaan'] = $modPegawai->unit_perusahaan;
                    $data['namapemilikasuransi'] = $modPegawai->nama_pegawai;
                    $data['namaperusahaan'] = 'PT. Badak LNG';
                }
            }
            echo CJSON::encode($data);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

    /**
     * set dropdown jenis kasus penyakit
     */
    public function actionSetDropdownStatushubungankeluarga()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $penjamin_id = $_POST['penjamin_id'];
            $modAsuransiPasienBadak = new PPAsuransipasienbadakM();
            $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            if (!empty($penjamin_id)) {
                $data = $modAsuransiPasienBadak->getDropdownStatushubungankeluarga($penjamin_id);
                $data = CHtml::listData($data, 'lookup_value', 'lookup_name');
                foreach ($data as $value => $name) {
                    $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            }
            $dataList['statushubungankeluarga'] = $option;
            echo json_encode($dataList);
            Yii::app()->end();
        }
    }


    public function actionCekSEP()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $nosep = $_POST['nosep'];
            $bpjs = new Bpjs();
            $res = CJSON::decode($bpjs->detail_sep($nosep));


            $res["rujukan"] = array(
                "rujukandari_id" => "",
            );

            if (isset($res["metadata"]) && $res["metadata"]["code"] == "200" && !empty($res["response"]["provRujukan"])) {

                $rujukan = RujukandariM::model()->findByAttributes(array(
                    "ppkrujukan" => $res["response"]["provRujukan"]["kdProvider"]
                ));
                if (!empty($rujukan)) {
                    $rujukans = CHtml::listData(RujukandariM::model()->findAllByAttributes(array(
                        "asalrujukan_id" => $rujukan->asalrujukan_id,
                    ), array(
                        "order" => "namaperujuk"
                    )), "rujukandari_id", "namaperujuk");

                    $op = "";
                    foreach ($rujukans as $idx => $item) {
                        $op .= '<option value="' . $idx . '">' . $item . '</option>';
                    }

                    $res["rujukan"]["rujukandari_id"] = $rujukan->rujukandari_id;
                    $res["rujukan"]["asalrujukan_id"] = $rujukan->asalrujukan_id;
                    $res["rujukan"]["listrujukandari_id"] = $op;
                }
            }

            print_r(CJSON::encode($res));
        }
    }

    public function actionVerifikasiFP()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }



            $host = Yii::app()->user->getState('telnet_host');  //'192.168.0.5' ip debuga
            $port = CustomFunction::incPortFinger($ip);

            $batal = isset($_POST['batal']) ? $_POST['batal'] : null;
            set_time_limit(0);


            // create socket
            $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");


            if (!socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1)) {
                echo socket_strerror(socket_last_error($socket));
                exit;
            }


            // bind socket to port
            $result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
            // start listening for connections
            $result = socket_listen($socket, SOMAXCONN) or die("Could not set up socket listener\n");
            // accept incoming connections
            // spawn another socket to handle communication
            $spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
            // read client input


            if (false ===  ($buf = @socket_read($spawn, 10000, PHP_NORMAL_READ))) {
                $data['pesan'] = 'clientclose';
            } else {
                //  $input = socket_read($spawn, 10000, PHP_NORMAL_READ) or die("Could not read input\n");
                $input = trim($buf); //(pasien_id[0] /// no rekam medik[1] /// nofingerprint[2] /// ip[3])
                $ipfinger = explode(" /// ", $input);
                $data = array();
                if ($ipfinger[3] == $ip) {
                    $data['no_rekam_medik'] = $ipfinger[1];
                    $data['pasien_id'] = $ipfinger[0];
                    $data['nofingerprint'] = $ipfinger[2];
                    $data['pesan'] = 'sukses';
                } else {
                    $data['pesan'] = 'gagal';
                }
            }

            socket_close($spawn);
            socket_close($socket);

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionPendaftaranFP()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }

            $data = array();

            $no_rm = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
            $host    = $ip;
            $port    = CustomFunction::incPortFinger($ip);

            if ($no_rm == null) {
                $data['pesan'] = 'gagal-norm';
            } else {
                // create socket
                $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
                // connect to server
                socket_connect($socket, $host, $port) or die("Could not connect to server\n");
                // send string to server
                $cek = @socket_write($socket, $no_rm); // or die("Could not send data to server\n")

                if ($cek !== false) {
                    socket_close($socket);
                    $data['pesan'] = 'kirim';
                }
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * - digunakan untuk mencetak sticker
     * @param type $pendaftaran_id
     */
    public function actionPrintLabel($pendaftaran_id)
    {
        // $this->layout='//layouts/printWindows';
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        //        $this->render($this->path_view.'printLabel',
        //            array(
        //                'modPendaftaran'=>$modPendaftaran,
        //            )
        //        );
        $posisi = 'L'; //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', array(40, 60));
        $mpdf->mirrorMargins = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->SetHTMLFooter('<span></span>');
        $mpdf->WriteHTML(
            $this->renderPartial($this->path_view . 'printLabel', array(
                'modPendaftaran' => $modPendaftaran,
            ), true)
        );
        //                $mpdf->SetJS('this.print();');
        $mpdf->Output();
    }

    public function actionPrintStiker($pendaftaran_id)
    {
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $posisi = 'P'; //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', array(100, 135));
        $mpdf->mirrorMargins = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->SetHTMLFooter('<span></span>');
        $mpdf->WriteHTML(
            $this->renderPartial($this->path_view . 'printStiker', array(
                'modPendaftaran' => $modPendaftaran,
            ), true)
        );
        //                $mpdf->SetJS('this.print();');
        $mpdf->Output();
    }


    public function actionPrintCasemix($pendaftaran_id)
    {

        $format = new MyFormatter;
        $modDaftar = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modDaftar->pasien_id);
        $modProfil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());

        $posisi = 'P'; //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60();
        // $mpdf->mirrorMargins = 1;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->SetHTMLFooter('<span></span>');
        $mpdf->WriteHTML(
            $this->renderPartial($this->path_view . 'printCasemix', array(
                'modDaftar' => $modDaftar,
                'modProfil' => $modProfil,
                'modPasien' => $modPasien,
                'format' => $format
            ), true)
        );
        //                $mpdf->SetJS('this.print();');
        $mpdf->Output();
    }

    public function actionPrintLabelRD($pendaftaran_id)
    {
        // $this->layout='//layouts/printWindows';
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        //        $this->render($this->path_view.'printLabel',
        //            array(
        //                'modPendaftaran'=>$modPendaftaran,
        //            )
        //        );
        $posisi = 'L'; //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', array(40, 60));
        $mpdf->mirrorMargins = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->SetHTMLFooter('<span></span>');
        $mpdf->WriteHTML(
            $this->renderPartial($this->path_view . 'printLabelRD', array(
                'modPendaftaran' => $modPendaftaran,
            ), true)
        );
        //                $mpdf->SetJS('this.print();');
        $mpdf->Output();
    }



    /**
     * - digunakan untuk mencetak sticker
     * @param type $pendaftaran_id
     */
    public function actionPrintLabelRM($pendaftaran_id)
    {
        $this->layout = '//layouts/printWindows';
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        //        $this->render($this->path_view.'printLabel',
        //            array(
        //                'modPendaftaran'=>$modPendaftaran,
        //            )
        //        );
        $posisi = 'L'; //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', array(70, 60));
        $mpdf->mirrorMargins = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->WriteHTML(
            $this->renderPartial($this->path_view . 'printLabelRM', array(
                'modPendaftaran' => $modPendaftaran,
            ), true)
        );
        $mpdf->SetJS('this.print();');
        $mpdf->Output();
    }

    public function actionPrintLabelHD($pendaftaran_id)
    {
        // $this->layout='//layouts/printWindows';
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        //        $this->render($this->path_view.'printLabel',
        //            array(
        //                'modPendaftaran'=>$modPendaftaran,
        //            )
        //        );
        $posisi = 'L'; //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', array(40, 60));
        $mpdf->mirrorMargins = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->SetHTMLFooter('<span></span>');
        $mpdf->WriteHTML(
            $this->renderPartial($this->path_view . 'printLabelHD', array(
                'modPendaftaran' => $modPendaftaran,
            ), true)
        );
        //                $mpdf->SetJS('this.print();');
        $mpdf->Output();
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
     * Tampil dialog label gelang pasien
     */
    public function actionLabelGelang()
    {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $datatable = '';
        $pendaftaran_id = $_GET['pendaftaran_id'];
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._labelGelang', array(
            'modPendaftaran' => $modPendaftaran,
        ));
    }


    /**
     * generate print label gelang
     * @param type $pendaftaran_id
     */
    public function actionPrintLabelGelang($pendaftaran_id, $tipe = null)
    {

        $format = new MyFormatter();
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        $judul_print = '';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if ($caraPrint == 'PRINT') {
            //            $this->layout='//layouts/printWindows';
        }
        $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
        $posisi = 'P'; //Posisi L->Landscape,P->Portait

        $gelang_tipe = 0;

        if (empty($tipe)) {

            if ($modPendaftaran->pasien->kelompokumur_id == Params::KELOMPOKUMUR_ANAK || $modPendaftaran->pasien->kelompokumur_id == Params::KELOMPOKUMUR_BAYI || $modPendaftaran->pasien->kelompokumur_id == Params::KELOMPOKUMUR_BARU_LAHIR) {
                // panjang : 29 -> 2,9cm , lebar: 155->15.5 cm
                // $mpdf = new MyPDF60('', array(29, 155));
                $mpdf = new MyPDF60('', array(165, 20));
                $gelang_tipe = 1;
            } else {
                // panjang : 29 -> 2,9cm , lebar: 265 ->26,5 cm
                //$mpdf = new MyPDF60('', array(25, 285));
                $gelang_tipe = 0;
                $this->layout = '//layouts/printWindows';
                $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatJalan.printLabelGelangAnak', array(
                    'format' => $format,
                    'modPendaftaran' => $modPendaftaran,
                    'modPasien' => $modPasien,
                    'gelang_tipe' => $gelang_tipe,
                ));
            }
        } else {
            if ($tipe == 1) {
                //$mpdf = new MyPDF60('', array(25, 285));
                $gelang_tipe = 0;
                $this->layout = '//layouts/printWindows';
                $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatJalan.printLabelGelangAnak', array(
                    'format' => $format,
                    'modPendaftaran' => $modPendaftaran,
                    'modPasien' => $modPasien,
                    'gelang_tipe' => $gelang_tipe,
                ));
                // $mpdf = new MyPDF60('', array(25, 285));
                //     $gelang_tipe = 1;
            } else {
                // if($modPendaftaran->pasien->kelompokumur_id == Params::KELOMPOKUMUR_BAYI || $modPendaftaran->pasien->kelompokumur_id == Params::KELOMPOKUMUR_BARU_LAHIR){
                // panjang : 25 -> 2,5cm , lebar: 40->4 cm
                //    $mpdf = new MyPDF60('', array(25, 40));
                //    $gelang_tipe = 2;
                //} else {
                // panjang : 29 -> 2,9cm , lebar: 155->15.5 cm
                // $mpdf = new MyPDF60('', array(29, 155));
                $mpdf = new MyPDF60('', array(25, 285));
                $gelang_tipe = 1;
                //}
            }
        }
        /*
        echo  $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan.printLabelGelang', array(
                'format' => $format,
                'modPendaftaran' => $modPendaftaran,
                'modPasien' => $modPasien,
                'gelang_tipe' => $gelang_tipe,
                    ), true); die;
         *
         */

        if ($gelang_tipe == 1) {

            ob_clean();
            // $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
            $mpdf->SetHTMLFooter('<span></span>');
            $mpdf->WriteHTML(
                $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan.printLabelGelangAnak', array(
                    'format' => $format,
                    'modPendaftaran' => $modPendaftaran,
                    'modPasien' => $modPasien,
                    'gelang_tipe' => $gelang_tipe,
                ), true)
            );
            $mpdf->SetJS('this.print();');
            $mpdf->Output();
        }
    }


    public function actionAutocompletePegawaiUntukPasienBaru($nip = null)
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $cr = new CDbCriteria;
        $cr->compare('lower(nomorindukpegawai)', strtolower("" . $nip . ""), true);
        $cr->addCondition('pegawai_aktif = true');
        $cr->order = 'nama_pegawai asc';

        $model = PegawaiM::model()->findAll($cr);
        $res = array();

        foreach ($model as $item) {
            $p = PasienM::model()->findByAttributes(array(
                'pegawai_id' => $item->pegawai_id
            ));

            $sub = array(
                'label' => $item->nomorindukpegawai . " - " . $item->namaLengkap,
                'pegawai_id' => $item->pegawai_id,
                'nip' => $item->nomorindukpegawai,
                'nama_pegawai' => $item->namaLengkap,
                'sudah_ada' => !empty($p),
            );

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

    public function actionGetDataPegawaiUntukPasienBaru()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $pegawai_id = $_POST['pegawai_id'] == "null" ? null : $_POST['pegawai_id'];
        $nip = $_POST['nip'];

        $cr = new CDbCriteria();

        if (!empty($pegawai_id)) {
            $cr->compare('pegawai_id', $pegawai_id);
        } else if (!empty($nip)) {
            $cr->compare('lower(nomorindukpegawai)', strtolower($nip));
        }
        $cr->addCondition('pegawai_aktif = true');

        $model = PegawaiM::model()->find($cr);

        $ok = 1;
        $msg = "";
        $res = array();
        if (empty($model)) {
            $ok = 0;
            $msg = "Pegawai dengan nip " . $nip . " tidak ditemukan";
        } else {
            $pasien = PasienM::model()->findByAttributes(array(
                'pegawai_id' => $model->pegawai_id,
            ));

            if (!empty($pasien)) {
                $ok = 0;
                $msg = "Pegawai dengan nip " . $nip . " sudah didaftarkan sebagai pasien. Mohon cari pegawai di pasien lama.";
            }

            $model->nomobile_pegawai = str_replace(" ", "", $model->nomobile_pegawai);
            $model->tgl_lahirpegawai = date('d/m/Y', strtotime($model->tgl_lahirpegawai));
            $res = $model->attributes;
        }

        echo CJSON::encode(array('ok' => $ok, 'msg' => $msg, 'res' => $res));
    }


    public function actionCatatCeklisHakPasien()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $res = array();
        if (isset($_POST['ceklis'])) {
            $res = $_POST['ceklis'];
            Yii::app()->user->setState('ceklis_hak_pasien_' . $this->id, $_POST['ceklis']);
        } else {
            Yii::app()->user->setState('ceklis_hak_pasien_' . $this->id, $res);
        }

        echo CJSON::encode(array('ok' => 1, 'data' => $res));
    }

    public function actionCatatCeklisKewajibanPasien()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $res = array();
        if (isset($_POST['ceklis'])) {
            $res = $_POST['ceklis'];
            Yii::app()->user->setState('ceklis_kewajiban_pasien_' . $this->id, $_POST['ceklis']);
        } else {
            Yii::app()->user->setState('ceklis_kewajiban_pasien_' . $this->id, $res);
        }

        echo CJSON::encode(array('ok' => 1, 'data' => $res));
    }

    public function actionSetSudahDibaca()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $pendaftaran = isset($_POST['pendaftaran_id']) && $_POST['pendaftaran_id'] != 0 ? $_POST['pendaftaran_id'] : null;

        if (!empty($pendaftaran)) {
            PendaftaranT::model()->updateByPk($pendaftaran, array(
                'isbacahakpasien' => true,
            ));
            Yii::app()->user->setState('hak_pasien_sudah_baca_' . $this->id, null);
            Yii::app()->user->setState('ceklis_hak_pasien_' . $this->id, null);
            Yii::app()->user->setState('kewajiban_pasien_sudah_baca_' . $this->id, null);
            Yii::app()->user->setState('ceklis_kewajiban_pasien_' . $this->id, null);
            Yii::app()->user->setState('cetakHak' . $this->id, null);
        } else {
            Yii::app()->user->setState('hak_pasien_sudah_baca_' . $this->id, 1);
            Yii::app()->user->setState('kewajiban_pasien_sudah_baca_' . $this->id, 1);
            Yii::app()->user->setState('cetakHak' . $this->id, 1);
        }

        echo CJSON::encode(['ok' => 1]);
    }

    public function cleanUpSessionPasienSudahBaca($id = null)
    {

        if (!empty(Yii::app()->user->getState('hak_pasien_sudah_baca_' . $this->id)) && Yii::app()->user->getState('hak_pasien_sudah_baca_' . $this->id) == 1 && !empty(Yii::app()->user->getState('kewajiban_pasien_sudah_baca_' . $this->id)) && Yii::app()->user->getState('kewajiban_pasien_sudah_baca_' . $this->id) == 1) {
            Yii::app()->user->setState('hak_pasien_sudah_baca_' . $this->id, null);
            Yii::app()->user->setState('ceklis_hak_pasien_' . $this->id, null);
            Yii::app()->user->setState('kewajiban_pasien_sudah_baca_' . $this->id, null);
            Yii::app()->user->setState('ceklis_kewajiban_pasien_' . $this->id, null);
            if (!empty($id)) {
                PendaftaranT::model()->updateByPk($id, array(
                    'isbacahakpasien' => true,
                ));
            }
        }

        // if (!empty(Yii::app()->user->getState('kewajiban_pasien_sudah_baca_'.$this->id)) && Yii::app()->user->getState('kewajiban_pasien_sudah_baca_'.$this->id) == 1) {
        //     Yii::app()->user->setState('kewajiban_pasien_sudah_baca_'.$this->id, null);
        //     Yii::app()->user->setState('ceklis_kewajiban_pasien_'.$this->id, null);
        //     if (!empty($id)) {
        //         PendaftaranT::model()->updateByPk($id, array(
        //             'isbacahakpasien'=>true,
        //         ));
        //     }
        // }
    }

    public function actionValidasiBpjs()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $pasien_id = isset($_POST['pasien_id'])  ? $_POST['pasien_id'] : null;
            $carabayar_id = $_POST['carabayar_id'] ?? null;
            // $ms
            $data['message'] = '';

            $modCarabayar = CarabayarM::model()->findByPk($carabayar_id);

            $konfig = KonfigsystemK::model()->find();

            if (in_array(strtolower($this->id), array('pendaftaranrawatdarurat', 'pendaftaranrawatjalan')) && !empty($modCarabayar) && $modCarabayar->carabayar_id == Params::CARABAYAR_ID_BPJS) {
                if ($pasien_id) {
                    //                $criteria = new CDbCriteria();
                    //                $criteria->addCondition('pasien_id ='.$pasien_id);
                    //                $criteria->addCondition('carabayar_id ='.$carabayar_id);
                    //                $criteria->addCondition('tgl_pendaftaran::date ='."'".date('Y-m-d')."'");
                    //                $criteria->addCondition('pasienbatalperiksa_id is null');
                    //                $criteria->compare('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD));
                    //                $modPendaftaran = PendaftaranT::model()->findAll($criteria);
                    //                if (count($modPendaftaran) > 0) {
                    //                    $data['message'] = 'Pasien sudah didaftarkan menggunakan BPJS Sebelumnya, Silakan gunakan pembayaran lain.';
                    //                }else{
                    $criteria2 = new CDbCriteria();
                    $criteria2->addCondition('pasien_id =' . $pasien_id);
                    $criteria2->addCondition('carabayar_id =' . $carabayar_id);
                    $criteria2->addCondition('pasienbatalperiksa_id is null');
                    $criteria2->compare('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD));
                    $criteria2->order = 'tgl_pendaftaran DESC';
                    $modLastestPendaftaran = PendaftaranT::model()->find($criteria2);

                    if (!empty($modLastestPendaftaran)) {

                        $regulasi_hari = 3;
                        $is_rj = false;
                        $is_rd = false;
                        if ($modLastestPendaftaran->instalasi_id == Params::INSTALASI_ID_RJ) {
                            $regulasi_hari = $konfig->regulasibpjs_rj;
                            $is_rj = $konfig->regulasibpjs_rj_isrj;
                            $is_rd = $konfig->regulasibpjs_rj_isrd;
                        }
                        if ($modLastestPendaftaran->instalasi_id == Params::INSTALASI_ID_RD) {
                            $regulasi_hari = $konfig->regulasibpjs_rj;
                            $is_rj = $konfig->regulasibpjs_rd_isrj;
                            $is_rd = $konfig->regulasibpjs_rd_isrd;
                        }

                        $is_cocok = false;
                        if (strtolower($this->id) == 'pendaftaranrawatjalan') {
                            $is_cocok = $is_rj;
                        }
                        if (strtolower($this->id) == 'pendaftaranrawatdarurat') {
                            $is_cocok = $is_rd;
                        }

                        $earlier = new DateTime($modLastestPendaftaran->tgl_pendaftaran);
                        $later = new DateTime(date('Y-m-d'));

                        $pos_diff = $earlier->diff($later)->format("%r%a");

                        if ($pos_diff <= $regulasi_hari && $is_cocok) {
                            $data['message'] = 'Pasien dapat melakukan pembayaran dengan BPJS Setelah ' . $regulasi_hari . ' Hari dari tanggal ' . MyFormatter::formatDateTimeForUser($modLastestPendaftaran->tgl_pendaftaran);
                        }
                    }
                    //                }

                    // $criteria2 = new CDbCriteria();
                    // $criteria2->addCondition('pasien_id ='.$pasien_id);
                    // $criteria2->addCondition('carabayar_id ='.$carabayar_id);
                    // $criteria2->order = 'tgl_pendaftaran DESC';
                    // $modLastestPendaftaran = PendaftaranT::model()->find($criteria2);

                    // $earlier = new DateTime($modLastestPendaftaran->tgl_pendaftaran);
                    // $later = new DateTime(date('Y-m-d'));

                    // $pos_diff = $earlier->diff($later)->format("%r%a"); //3
                    // $neg_diff = $later->diff($earlier)->format("%r%a"); //-3
                    // var_dump($pos_diff);die;
                }
            }

            // $data['message'] = 'Pasien dapat melakukan pembayaran dengan BPJS Setelah 2 Hari dari tanggal ' .MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));

            // var_dump($carabayar_id);
            // var_dump($pasien_id);die;
            echo CJSON::encode($data);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }
    public function actionSetDropdownLoket()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $id_nama_loket = $_POST["idModelantrian"];
            $data = array();
            $data['diLoket_antrian'] = '';
            if (empty($id_nama_loket)) {
                $data['diLoket_antrian'] = CHtml::dropDownList('namaLoket', 'namaLoket', array(), array('class' => 'span2', 'empty' => '-- Pilih --', 'style' => 'width:200px;'));
            } else {
                $data['diLoket_antrian'] = CHtml::dropDownList('namaLoket', 'namaLoket', CHtml::listData(LoketM::model()->findAllByAttributes(array('modelantrian_id' => $id_nama_loket, 'ispendaftaran' => TRUE, 'loket_aktif' => TRUE), array('order' => 'loket_nourut::integer ASC')), 'loket_id', 'loket_nama'), array('class' => 'span2', 'empty' => '-- Pilih --', 'style' => 'width:200px;', 'onchange' => 'setFormAntrian("reset");'));
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    public function actionAjaxLoadPhotoScan()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $mips = new MIPS;
        $response = $mips->newFindRecords(date('Y-m-d H:i', strtotime('now - 1 month')), date('Y-m-d H:i', strtotime('now + 1 day')));

        if ($response['success'] != true) {
            echo CJSON::encode(array(
                'ok' => 0,
                'msg' => 'Error. Data tidak dapat di ambil',
            ));

            Yii::app()->end();
        }

        if (count((array)$response['data']) == 0) {
            echo CJSON::encode(array(
                'ok' => 0,
                'msg' => 'Data belum ada',
            ));
            Yii::app()->end();
        }

        $res_dat = $response['data'];
        $sort_time = array();

        foreach ($res_dat as $key => $item) {
            $sort_time[$key] = $item['currentTime'];
        }

        array_multisort($sort_time, SORT_DESC, $res_dat);

        $res = $res_dat[0];

        $res_img = $mips->getRecordImg($res['imageName']);

        $pasien_id = "";
        $no_rm = "";

        if ($res['type'] == MIPS::REG_PASIEN) {
            $no_rm = substr($res['idCardNum'], 1);
            $pasien = PasienM::model()->findByAttributes(array(
                'no_rekam_medik' => $no_rm,
            ));

            if (!empty($pasien)) {
                $pasien_id = $pasien->pasien_id;
            } else {
                $no_rm = "";
            }
        }

        if ($res_img['success'] != true) {
            echo CJSON::encode(array(
                'ok' => 0,
                'msg' => 'Gambar tidak ditemukan',
            ));
            Yii::app()->end();
        }

        echo CJSON::encode(array(
            'ok' => 1,
            'msg' => '',
            'no_rm' => $no_rm,
            'pasien_id' => $pasien_id,
            'html' => $this->renderPartial($this->path_view . "_fotoScan", array(
                'res' => $res,
                'res_img' => $res_img,

            ), true),
        ));
    }

    protected function simpanScanPasien($modPendaftaran, $post)
    {

        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        $model = new ScanpasiendarialatT();
        $model->attributes = $post;
        $model->pake_masker = $model->pake_masker == 1;
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;

        if ($model->save()) {
            $modPendaftaran->suhu_tubuh = $model->suhu_tubuh;
            $modPendaftaran->save();

            if (!empty($model->data_gambar)) {
                $modPasien->setFotoPasienDariPerangkatMIPS($model->data_gambar);
            }
        }

        $response = $this->registerScanMIPS($model, $modPasien);

        //        if ($response['success'] != true) {
        //            Yii::app()->user->setFlash('warning', 'Scan Foto gagal didaftarkan');
        //        }

        // die;
    }


    protected function registerScanMIPS($model, $modPasien)
    {

        $person = array(
            'age' => $modPasien->umurTahun,
            'name' => $modPasien->nama_pasien,
            'prescription' => date('Y-m-d H:i') . ", " . date('Y-m-d H:i', strtotime('now + 1 year')),
            'sex' => $modPasien->jeniskelamin == 'LAKI-LAKI' ? 0 : 1,
            'type' => MIPS::REG_PASIEN,
            'vipID' => "1" . $modPasien->no_rekam_medik,
            'welCome' => '',
            'idCard' => "1" . $modPasien->no_rekam_medik,
            'card' => "1" . $modPasien->no_rekam_medik,
            'wn' => '',
            'imgBase64' => $model->data_gambar,
        );

        $mips = new MIPS();
        $response = $mips->register($person);

        // var_dump($response, $person); die;



        //var_dump($response, $person); die;
        //var_dump($model->attributes, $modPasien->attributes); die;
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


    public function actionLoadKTP()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        //$path = "/var/tmp_ektp/ektp_data.json" ;
        $ok = 1;
        $data_res = array();
        try {

            $name = "";

            // cek IP Lokal
            $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
            socket_connect($sock, "8.8.8.8", 53);
            socket_getsockname($sock, $name); // $name passed by reference

            // load IP Publik
            $ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];

            // load data RM
            $alat = AlatscanktppenggunaM::model()->findByAttributes(array(
                'user_ip' => $ip,
            ))
                ?? AlatscanktppenggunaM::model()->findByAttributes(array(
                    'user_ip' => $name,
                ));

            //            var_dump($alat->attributes); die;

            $data = null;

            if (!empty($alat)) {
                $cr = new CDbCriteria();
                $cr->addCondition("trim(host) = '" . trim($alat->id_perangkat) . "'");
                $cr->order = 'dataktp_id desc';
                $data = DataktpR::model()->find($cr);
            }

            // var_dump($data->attributes); die; 


            //            var_dump($cr, $ip); die;


            if (!empty($data)) {

                $data_res = CJSON::decode($data->data);
                $pasien = PasienM::model()->findByAttributes(array(
                    'no_identitas_pasien' => $data_res['nik'],
                ));

                if (!empty($data_res)) {

                    $tgl_arr = explode("-", $data_res['tanggal_lahir']);
                    $tgl_arr[0] = str_pad($tgl_arr[0], 2, "0", STR_PAD_LEFT);
                    $tgl_arr[1] = str_pad($tgl_arr[1], 2, "0", STR_PAD_LEFT);

                    $data_res['tanggal_lahir'] = implode("/", $tgl_arr);

                    if (empty($pasien)) {
                        $data_res['pasien_baru'] = 1;
                        $data_res['pasien_id'] = null;
                    } else {
                        $data_res['pasien_baru'] = 0;
                        $data_res['pasien_id'] = $pasien->pasien_id;
                    }



                    // propinsi
                    $crPropinsi = new CDbCriteria();
                    $crPropinsi->compare('lower(propinsi_nama)', strtolower($data_res['provinsi']), true);
                    $crPropinsi->addCondition('propinsi_aktif = true');


                    $htmlKabData = '<option value="">-- Pilih --</option>';
                    $htmlKecData = '<option value="">-- Pilih --</option>';
                    $htmlKelData = '<option value="">-- Pilih --</option>';

                    $propinsi = PropinsiM::model()->find($crPropinsi);
                    $kabupaten = null;
                    $kecamatan = null;
                    $kelurahan = null;



                    if (!empty($propinsi)) {
                        $crKab = new CDbCriteria();
                        $crKab->compare('propinsi_id', $propinsi->propinsi_id);
                        $crKab->addCondition('kabupaten_aktif = true');
                        $crKab->order = 'kabupaten_nama asc';

                        $list_kab = CHtml::listData(KabupatenM::model()->findAll($crKab), 'kabupaten_id', 'kabupaten_nama');
                        foreach ($list_kab as $id => $label) {
                            $htmlKabData .= '<option value="' . $id . '">' . $label . '</option>';
                        }

                        $crKab->compare('lower(kabupaten_nama)', strtolower($data_res['kotakabupten']), true);

                        $kabupaten = KabupatenM::model()->find($crKab);

                        if (!empty($kabupaten)) {

                            $crKec = new CDbCriteria();
                            $crKec->compare('kabupaten_id', $kabupaten->kabupaten_id);
                            $crKec->addCondition('kecamatan_aktif = true');
                            $crKec->order = 'kecamatan_nama asc';

                            $list_kec = CHtml::listData(KecamatanM::model()->findAll($crKec), 'kecamatan_id', 'kecamatan_nama');
                            foreach ($list_kec as $id => $label) {
                                $htmlKecData .= '<option value="' . $id . '">' . $label . '</option>';
                            }

                            $crKec->compare('lower(kecamatan_nama)', strtolower($data_res['kecamatan']), true);

                            $kecamatan = KecamatanM::model()->find($crKec);

                            if (!empty($kecamatan)) {

                                $crKel = new CDbCriteria();
                                $crKel->compare('kecamatan_id', $kecamatan->kecamatan_id);
                                $crKel->addCondition('kelurahan_aktif = true');
                                $crKel->order = 'kelurahan_nama asc';

                                $list_kel = CHtml::listData(KelurahanM::model()->findAll($crKel), 'kelurahan_id', 'kelurahan_nama');
                                foreach ($list_kel as $id => $label) {
                                    $htmlKelData .= '<option value="' . $id . '">' . $label . '</option>';
                                }

                                $crKel->compare('lower(kelurahan_nama)', strtolower($data_res['desakelurahan']), true);

                                $kelurahan = KelurahanM::model()->find($crKel);
                            }
                        }
                    }

                    $pekerjaan = isset($data_res['pekerjaan']) ? trim($data_res['pekerjaan']) : null;
                    $data_res['pekerjaan_id'] = null;

                    if (!empty($pekerjaan)) {
                        $crKerja = new CDbCriteria();
                        $crKerja->compare('lower(pekerjaan_nama)', strtolower($pekerjaan), true);
                        $crKerja->addCondition('pekerjaan_aktif = true');
                        $kerja = PekerjaanM::model()->find($crKerja);

                        $data_res['pekerjaan_id'] = empty($kerja) ? null : $kerja->pekerjaan_id;
                    }



                    $data_res['propinsi_id'] = empty($propinsi) ? null : $propinsi->propinsi_id;
                    $data_res['kabupaten_id'] = empty($kabupaten) ? null : $kabupaten->kabupaten_id;
                    $data_res['kecamatan_id'] = empty($kecamatan) ? null : $kecamatan->kecamatan_id;
                    $data_res['kelurahan_id'] = empty($kelurahan) ? null : $kelurahan->kelurahan_id;

                    $data_res['kabupaten_list'] = $htmlKabData;
                    $data_res['kecamatan_list'] = $htmlKecData;
                    $data_res['kelurahan_list'] = $htmlKelData;

                    $preview_foto = '<img id="photo-preview" src="data:image/png;base64, ' . $data_res['foto64'] . '" width="84px"/><br/>';
                    $preview_tandatangan = '<img id="tandatangan-preview" src="data:image/png;base64, ' . $data_res['tandatangan64'] . '" width="84px"/>';

                    $data_res['foto'] = $preview_foto . $preview_tandatangan;
                    $data_res['foto_bin'] = 'data:image/png;base64, ' . $data_res['foto64'];
                    $data_res['foto_sign_bin'] = 'data:image/png;base64, ' . $data_res['tandatangan64'];

                    DataktpR::model()->deleteByPk($data->dataktp_id);

                    //                    DataktpR::model()->deleteAllByAttributes(array(
                    //                        'host' => $ip
                    //                    ));

                } else {
                    $ok = 0;
                }
            } else {
                $ok = 0;
            }
        } catch (Exception $ex) {
            // var_dump($ex->getMessage()); die;
            $ok = 0;
        }


        echo CJSON::encode(array('ok' => $ok, 'ktp' => $data_res));
    }

    public function actionCekPasienBerdasarkanNoAsuransi()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $nomor = $_POST['nomor'];

        $asuransi = AsuransipasienM::model()->findByAttributes(array(
            'nopeserta' => $nomor,
        ));

        $ok = 0;
        $pasien_id = null;
        $no_rekam_medik = null;

        if (!empty($asuransi)) {
            $pasien_id = $asuransi->pasien_id;
            $no_rekam_medik = $asuransi->pasien->no_rekam_medik;
            $ok = 1;
        }

        echo CJSON::encode(array(
            'ok' => $ok,
            'pasien_id' => $pasien_id,
            'no_rekam_medik' => $no_rekam_medik,
        ));
    }

    public function actionCekRuanganBerdasarkanPoliBPJS()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $kode_ruangan = $_POST['kode_ruangan'];

        $ruangan = RuanganM::model()->findByAttributes(array(
            'kode_bpjs' => $kode_ruangan,
        ));

        $ok = 0;
        $ruangan_id = null;

        if (!empty($ruangan)) {
            $ok = 1;
            $ruangan_id = $ruangan->ruangan_id;
        }

        echo CJSON::encode(array(
            'ok' => $ok,
            'ruangan_id' => $ruangan_id,
        ));
    }

    public function actionCekPasienDariJenisNomor()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $jenis = $_POST['jenis'];
        $nomor = $_POST['nomor'];

        $cr = new CDbCriteria();
        $cr->join = 'left join pegawai_m p on p.pegawai_id = t.pegawai_id';
        $cr->addCondition('pegawai_aktif = true');

        if ($jenis == "nip") {
            $cr->compare('lower(p.nomorindukpegawai)', strtolower($nomor));
        }

        $pasien = PasienM::model()->find($cr);

        $cr2 = new CDbCriteria();
        $cr2->addCondition('t.pegawai_aktif = true');
        if ($jenis == "nip") {
            $cr2->compare('lower(t.nomorindukpegawai)', strtolower($nomor));
        }

        $peg = PegawaiM::model()->find($cr2);

        $ok = 0;
        $ok_pasien = 0;
        $pasien_id = null;
        $pegawai_id = null;
        $pegawai_data = array();
        $no_rekam_medik = null;


        if (!empty($peg)) {
            $ok = 1;
            $pegawai_id = $peg->pegawai_id;
            $pegawai_data = $peg->attributes;

            if (!empty($pasien)) {
                $ok_pasien = 1;
                $pasien_id = $pasien->pasien_id;
                $no_rekam_medik = $pasien->no_rekam_medik;
            }
        }


        echo CJSON::encode(array(
            'ok' => $ok,
            'pegawai_id' => $pegawai_id,
            'pegawai_data' => $pegawai_data,
            'ok_pasien' => $ok_pasien,
            'pasien_id' => $pasien_id,
            'no_rekam_medik' => $no_rekam_medik,
        ));
    }

    public function actionAjaxListJenisVaksin()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $list = JenisvaksinM::model()->findAllByAttributes(array(
            'jenisvaksin_aktif' => true,
        ), array(
            'order' => 'jenisvaksin_nama',
        ));

        $res = '<option value="">-- Pilih --</option>';
        foreach ($list as $item) {
            $res .= '<option value="' . $item->jenisvaksin_id . '">' . $item->jenisvaksin_nama . '</option>';
        }

        echo CJSON::encode(array(
            'html' => $res,
        ));
    }

    public function actionAjaxListVaksin()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $jenisvaksin_id = $_POST['jenisvaksin_id'];

        $list = VaksinM::model()->findAllByAttributes(array(
            'jenisvaksin_id' => $jenisvaksin_id,
            'vaksin_aktif' => true,
        ), array(
            'order' => 'imunisasi_program',
        ));

        $res = '<option value="">-- Pilih --</option>';
        foreach ($list as $item) {
            $res .= '<option value="' . $item->vaksin_id . '">' . $item->imunisasi_program . '</option>';
        }

        echo CJSON::encode(array(
            'html' => $res,
        ));
    }

    public function actionAjaxListDaftarVaksin()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $vaksin_id = $_POST['vaksin_id'];

        $list = DaftarvaksinM::model()->findAllByAttributes(array(
            'vaksin_id' => $vaksin_id,
            'daftarvaksin_aktif' => true,
        ), array(
            'order' => 'daftarvaksin_nama',
        ));

        $res = '<option value="">-- Pilih --</option>';
        foreach ($list as $item) {
            $res .= '<option value="' . $item->daftarvaksin_id . '">' . $item->daftarvaksin_nama . '</option>';
        }

        echo CJSON::encode(array(
            'html' => $res,
        ));
    }


    public function actionSimpanJenisVaksin()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Jenis Vaksin Berhasil Ditambah";

        try {
            $model = new JenisvaksinM;
            $model->attributes = $_POST['JenisvaksinM'];

            if (empty($model->isadakelompok_vaksin) || $model->isadakelompok_vaksin != 1) {
                $model->isadakelompok_vaksin = false;
            }

            $model->create_time = $model->update_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai = $model->update_loginpemakai = Yii::app()->user->id;
            $model->create_petugaspengisi_id = Yii::app()->user->getState('pegawai_id');
            $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');

            if ($model->save()) {
                $trans->commit();
            } else {
                $trans->rollback();
                $ok = 0;
                $msg = "Jenis Vaksin Gagal Ditambah. ";
            }
        } catch (Exception $ex) {
            $trans->rollback();
            $ok = 0;
            $msg = "Jenis Vaksin Gagal Ditambah. " . $ex->getMessage();
        }

        echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
    }

    public function actionSimpanVaksin()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Program Vaksin Berhasil Ditambah";

        try {
            $model = new VaksinM;
            $model->attributes = $_POST['VaksinM'];

            $model->create_time = $model->update_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai = $model->update_loginpemakai = Yii::app()->user->id;
            $model->create_petugaspengisi_id = Yii::app()->user->getState('pegawai_id');
            $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');

            if ($model->save()) {
                $trans->commit();
            } else {
                $trans->rollback();
                $ok = 0;
                $msg = "Program Vaksin Gagal Ditambah. ";
            }
        } catch (Exception $ex) {
            $trans->rollback();
            $ok = 0;
            $msg = "Program Vaksin Gagal Ditambah. " . $ex->getMessage();
        }

        echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
    }

    public function actionSimpanDaftarVaksin()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Vaksin Berhasil Ditambah";

        try {
            $model = new DaftarvaksinM;
            $model->attributes = $_POST['DaftarvaksinM'];


            $list = DaftarvaksinM::model()->findByAttributes(array(
                'vaksin_id' => $model->vaksin_id,
            ), array(
                'condition' => 'urutan is not null',
                'order' => 'urutan desc',
            ));

            if (empty($list)) {
                $model->urutan = 1;
            } else {
                $model->urutan = $list->urutan + 1;
            }

            $model->create_time = $model->update_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai_id = $model->update_loginpemakai_id = Yii::app()->user->id;
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

            // var_dump($model->attributes); die;


            if ($model->save()) {
                $trans->commit();
            } else {
                $trans->rollback();
                $ok = 0;
                $msg = "Vaksin Gagal Ditambah. ";
            }
        } catch (Exception $ex) {
            $trans->rollback();
            $ok = 0;
            $msg = "Vaksin Gagal Ditambah. " . $ex->getMessage();
        }

        echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
    }

    public function actionLoadRiwayatVaksinasi()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $pasien_id = $_POST['pasien_id'];

        $models = RiwayatvaksinasipasienT::model()->findAllByAttributes(array(
            'pasien_id' => $pasien_id,
        ), array(
            'order' => 'vaksinasi_tanggal',
        ));

        $html = "";
        foreach ($models as $idx => $model) {
            $model->vaksinasi_tanggal = MyFormatter::formatDateTimeForUser($model->vaksinasi_tanggal);
            $model->vaksin_id = $model->daftarvaksin->vaksin_id;
            $model->jenisvaksin_id = $model->daftarvaksin->vaksin->jenisvaksin_id;

            $html .= $this->renderPartial($this->path_view . "vaksinasi/_rowVaksinasi", array(
                'model' => $model,
            ), true);
        }

        echo CJSON::encode(array("ok" => 1, "html" => $html));
    }

    public function actionUpdateRiwayatVaksinasi($pendaftaran_id)
    {

        $this->layout = '//layouts/iframe';

        $model = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($model->pasien_id);
        $admisi = null;

        if (!empty($model->pasienadmisi_id)) {
            $admisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
            $model->ruangan_id = $admisi->ruangan_id;
            $model->kelaspelayanan_id = $admisi->kelaspelayanan_id;
        }

        $modPasien->tanggal_lahir = MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir);


        if (isset($_POST['RiwayatvaksinasipasienT']['detail'])) {
            $trans = Yii::app()->db->beginTransaction();

            try {

                if (RiwayatvaksinasipasienT::simpanRiwayat($model->pendaftaran_id, $model->pasien_id, $_POST['RiwayatvaksinasipasienT']['detail'])) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data riwayat vaksinasi berhasil disimpan ! ");
                    $this->redirect(array('updateRiwayatVaksinasi', 'pendaftaran_id' => $model->pendaftaran_id));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data riwayat vaksinasi gagal disimpan ! ");
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data riwayat vaksinasi gagal disimpan ! " . $ex->getMessage());
            }
        }

        $this->render($this->path_view . "vaksinasi.update", array(
            'model' => $model,
            'modPasien' => $modPasien,
            'admisi' => $admisi,
        ));
    }

    public function actionPemanggilanAntrian()
    {

        $this->layout = "//layouts/iframe";

        $modAntrian = new PPAntrianT;

        $this->render($this->path_view . '_formAntrianMenu', array(
            'modAntrian' => $modAntrian,
        ));
    }

    public function simpanSkp($model, $modPasien, $modRujukan, $modAsuransiPasien)
    {
        $reqSkp = null;
        $modSkp = new PPSkpT;
        //        $modSkp->attributes = $postSkp;
        $modSkp->tglskp = date('Y-m-d H:i:s');

        if (!empty($model->pasienadmisi_id)) {
            $modAdmisi = PPPasienAdmisiT::model()->findByPk($model->pasienadmisi_id);
            $modSkp->tglskp = $modAdmisi->tgladmisi;
            $modKelas = KelaspelayananM::model()->findByPk($modAdmisi->kelaspelayanan_id);
        } else {
            $modKelas = KelaspelayananM::model()->findByPk($model->kelaspelayanan_id);
            $modSkp->tglskp = $model->tgl_pendaftaran;
        }

        if (!empty($modKelas->kelasbpjs_id)) {
            if ($modKelas->kelasbpjs_id >= $modAsuransiPasien->kelastanggunganasuransi_id) {
                $modSkp->klsrawat = $modAsuransiPasien->kelastanggunganasuransi_id;
            } else {
                $modSkp->klsrawat = $modKelas->kelasbpjs_id;
            }
        } else {
            $modSkp->klsrawat = $modAsuransiPasien->kelastanggunganasuransi_id;
        }
        //        $modSkp->jnspelayanan = isset($postSkp['jnspelayanan']) ? $postSkp['jnspelayanan'] : 3;
        if ($modSkp->jnspelayanan == 2) {
            $modSkp->klsrawat = 3; //default kelas rawat 3
        }
        $modSkp->nokartuasuransi = $modAsuransiPasien->nopeserta;
        $modSkp->tglrujukan = $modRujukan->tanggal_rujukan;
        $modSkp->norujukan = $modRujukan->no_rujukan;
        //        $modSkp->ppkrujukan = $postSkp['ppkrujukan'];
        $modProfilRS = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $modSkp->ppkpelayanan = $modProfilRS->ppkpelayanan;
        //        $modSkp->catatanskp = $postSkp['catatanskp'];
        if ($model->carabayar_id == Params::CARABAYAR_ID_JAMKESPA) {
            $modSkp->noskp = MyGenerator::noSKM();
        } else if ($model->carabayar_id == Params::CARABAYAR_ID_JAMKESDA) {
            $modSkp->noskp = MyGenerator::noSKP($model->penjamin_id);
        }
        //        $modSkp->noskp = isset($postSkp['noskp']) ? $postSkp['noskp'] : "";
        $modSkp->diagnosaawal = $modRujukan->kddiagnosa_rujukan;
        $modSkp->nama_diagnosaawal = $modRujukan->diagnosa_rujukan;
        $modPoli = RuanganM::model()->findByPk($model->ruangan_id);
        $modSkp->politujuan = (!empty($modPoli->kode_bpjs) ? $modPoli->kode_bpjs : "-");
        $modSkp->hakkelas_kode = $modAsuransiPasien->kelastanggunganasuransi_id;
        $modSkp->kelasrawat_kode = $modSkp->klsrawat;
        //        $modSkp->jenisrujukan_kode = isset($postSkp['jenisfaskes']) ? $postSkp['jenisfaskes'] : null;
        $modSkp->jenisrujukan_nama = ($modSkp->jenisrujukan_kode == 1) ? "PCare" : "Rumah Sakit";
        $modSkp->tglpulang = date('Y-m-d H:i:s');
        $modSkp->no_telpon_peserta = $modPasien->no_mobile_pasien;
        //        $modSkp->lakalantas = isset($postSkp['lakalantas']) ? $postSkp['lakalantas'] : 0;
        //        $modSkp->penjamin_lakalantas = (isset($postSkp['penjamin_lakalantas']) && $modSkp->lakalantas == 1) ? $postSkp['penjamin_lakalantas'] : "";
        //        $modSkp->lokasi_lakalantas = (isset($postSkp['lokasi_lakalantas']) && $modSkp->lakalantas == 1) ? $postSkp['lokasi_lakalantas'] : "";
        //        $modSkp->poli_eksekutif = isset($postSkp['poli_eksekutif']) ? $postSkp['poli_eksekutif'] : null;
        //        $modSkp->namaasuransi_cob = isset($postSkp['namaasuransi_cob']) ? $postSkp['namaasuransi_cob'] : null;
        //        $modSkp->no_asuransi_cob = isset($postSkp['no_asuransi_cob']) ? $postSkp['no_asuransi_cob'] : null;
        //        $modSkp->cob = isset($postSkp['cob']) ? $postSkp['cob'] : null;
        $modSkp->create_time = date('Y-m-d H:i:s');
        $modSkp->create_loginpemakai_id = Yii::app()->user->id;
        $modSkp->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($modSkp->save()) {
            $this->skptersimpan = true;
        }
        return $modSkp;
    }

    public function actionPrintSkp($skp_id, $pendaftaran_id)
    {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modSkp = PPSkpT::model()->findByPk($skp_id);
        $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modRujukan = RujukanT::model()->findByPk($modPendaftaran->rujukan_id);
        $modAsuransi = AsuransipasienM::model()->findByAttributes(array('pasien_id' => $modPasien->pasien_id));

        $judul_print = "SURAT KEABSAHAN PESERTA (SKP) DAN FORM INA-CBG's <br> RUMAH SAKIT UMUM DAERAH DOKTER SOETOMO";
        $this->render($this->path_view . 'printSkp', array(
            'format' => $format,
            'modSkp' => $modSkp,
            'judul_print' => $judul_print,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modRujukan' => $modRujukan,
            'modAsuransi' => $modAsuransi
        ));
    }

    /**
     * Pencarian / autocomplete diagnosa untuk inhealth
     * @param string $term
     * @param string $param
     */
    public function actionGetDiagnosaInhealth($term = "", $param = "")
    {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria;
            $returnVal = array();

            if ($param == "kode") {
                $criteria->compare('LOWER(diagnosa_kode)', strtolower($term), true);
            } elseif ($param == "nama") {
                $criteria->compare('LOWER(diagnosa_nama)', strtolower($term), true);
            } elseif ($param == "lainnya") {
                $criteria->compare('LOWER(diagnosa_namalainnya)', strtolower($term), true);
            } elseif ($param == "mixed") {
                $criteria->addCondition(
                    ""
                        . "(lower(diagnosa_kode) ilike '%" . $term . "%' or "
                        . "lower(diagnosa_nama) ilike '%" . $term . "%' or "
                        . " lower(diagnosa_namalainnya) ilike '%" . $term . "%'"
                        . ")"
                );
            }

            $criteria->order = 'diagnosa_kode, diagnosa_nama';
            $criteria->addCondition("diagnosa_aktif = true");
            $models = DiagnosaM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = ($model->diagnosa_kode . ' - ' . $model->diagnosa_nama);
                $returnVal[$i]['value'] = $model->diagnosa_nama;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionProsesSJP($pendaftaran_id = null, $pasien_id = null, $idSep = null)
    {
        $this->layout = '//layouts/iframe';
        $pendaftaran_id = isset($pendaftaran_id) ? $pendaftaran_id : null;
        $pasien_id = isset($pasien_id) ? $pasien_id : null;

        $format = new MyFormatter();

        $model = new PPPendaftaranT;
        $modPasien = new PPPasienM;
        $modAdmisi = new PPPasienAdmisiT;
        $modPenanggungJawab = new PPPenanggungJawabM;
        $modPegawai = new PPPegawaiM;
        $modRujukan = new PPRujukanT;
        $modRujukanInhealth = new PPRujukanInhealthT;
        $modAsuransiPasien = new PPAsuransipasienM;
        $modAsuransiPasienInhealth = new PPAsuransipasieninhealthM;
        $modProfilRS = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $modSepInhealthT = new PPSepInhealthT;
        $modSepInhealthT->tglsep = date('Y-m-d H:i:s');
        $modSepInhealthT->ppkpelayanan = $modProfilRS->ppkpelayanan;
        $model->is_bpjs = 0;
        $modSepInhealthT->jnspelayanan = 3; //defaul rajal
        $modSepInhealthT->suplesi_jasaraharja = 0;
        $modSepInhealthT->status_nosep = "TIDAK";
        $modRujukanInhealth->tanggal_rujukan = date('Y-m-d H:i:s');
        $modRujukanInhealth->no_rujukan = "-";
        if (isset($_GET['jnspelayanan']) && !empty($_GET['jnspelayanan'])) { //untuk kondisi dari RI/RD/RJ
            if ($_GET['jnspelayanan'] == "RJ" || $_GET['jnspelayanan'] == "RD") {
                $modSepInhealthT->jnspelayanan = 3;
            } else {
                $modSepInhealthT->jnspelayanan = 4;
            }
        }

        if (!empty($pendaftaran_id)) {
            $model = PPPendaftaranT::model()->findByPk($pendaftaran_id);
            $idSep = isset($model->sep_id) ? $model->sep_id : null;
            $pasien_id = $model->pasien_id;
            if (!empty($model->pasienadmisi_id)) {
                $modAdmisi = PPPasienAdmisiT::model()->findByPk($model->pasienadmisi_id);
                $model->ruangan_nama = isset($modAdmisi->ruangan_id) ? $modAdmisi->ruangan->ruangan_nama : "";
            } else {
                $model->ruangan_nama = isset($model->ruangan_id) ? $model->ruangan->ruangan_nama : "";
            }
            if (!empty($model->pasienadmisi_id)) {
                $modAdmisi = PPPasienAdmisiT::model()->findByPk($model->pasienadmisi_id);
            }
        }

        if (!empty($pasien_id)) {
            $modPasien = PPPasienM::model()->findByPk($pasien_id);
        }

        if (isset($idSep)) {
            $modSepInhealthT = PPSepInhealthT::model()->findByPk($idSep);
            $model->is_bpjs = ($modSepInhealthT->is_inhealth) ? 0 : 1;
            if (isset($model->rujukan_id)) {
                $modRujukanInhealth = PPRujukanInhealthT::model()->findByPk($model->rujukan_id);
            }
            if (isset($model->asuransipasien_id)) {
                $modAsuransiPasienInhealth = PPAsuransipasieninhealthM::model()->findByPk($model->asuransipasien_id);
                $modJenisPeserta = JenispesertaM::model()->findByPk($modAsuransiPasienInhealth->jenispeserta_id);
                if (!empty($modJenisPeserta)) {
                    $modAsuransiPasienInhealth->jenispeserta_nama = isset($modJenisPeserta->jenispeserta_nama) ? $modJenisPeserta->jenispeserta_nama : '-';
                }
                $modAsuransiPasienInhealth->kelastanggunganasuransi_nama = $modAsuransiPasienInhealth->kelastanggunganasuransi_id;
            }
        }

        if (isset($_POST['PPPendaftaranT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if (isset($_POST['PPRujukanInhealthT'])) {
                    $modRujukanInhealth = $this->simpanRujukanBpjs($modRujukanInhealth, $_POST['PPRujukanInhealthT']);
                } else {
                    $this->rujukantersimpan = true;
                }

                if (isset($_POST['PPAsuransipasieninhealthM'])) {
                    if (isset($_POST['PPAsuransipasieninhealthM']['asuransipasien_id'])) {
                        if (!empty($_POST['PPAsuransipasieninhealthM']['asuransipasien_id'])) {
                            $modAsuransiPasienInhealth = PPAsuransipasieninhealthM::model()->findByPk($_POST['PPAsuransipasieninhealthM']['asuransipasien_id']);
                        }
                    }
                    $modAsuransiPasienInhealth = $this->simpanAsuransiPasien($modAsuransiPasienInhealth, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasieninhealthM']);
                } else {
                    $this->asuransipasientersimpan = true;
                }

                if (isset($_POST['PPSepInhealthT'])) {

                    $modSepInhealthT = $this->simpanSep($model, $modPasien, $modRujukanInhealth, $modAsuransiPasienInhealth, $_POST['PPSepInhealthT']);
                    if ($modSepInhealthT) {
                        $model = PPPendaftaranT::model()->findByPk($pendaftaran_id);
                        $model->sep_id = $modSepInhealthT->sep_id;
                        $model->rujukan_id = isset($modRujukanInhealth->rujukan_id) ? $modRujukanInhealth->rujukan_id : null;
                        $model->asuransipasien_id = isset($modAsuransiPasienInhealth->asuransipasien_id) ? $modAsuransiPasienInhealth->asuransipasien_id : null;
                        $model->save();
                        PPSepInhealthT::model()->updateByPk($modSepInhealthT->sep_id, array('is_inhealth' => true));
                    }
                }

                if ($this->rujukantersimpan && $this->asuransipasientersimpan) {
                    $transaction->commit();
                    if ($this->septersimpan) {
                        $this->redirect(array('ProsesSJP', 'pendaftaran_id' => $model->pendaftaran_id, 'pasien_id' => $model->pasien_id, 'idSep' => $modSepInhealthT->sep_id, 'pelayanan' => $_GET['pelayanan'], 'sukses' => 1));
                    } else {
                        $this->redirect(array('ProsesSJP', 'pendaftaran_id' => $model->pendaftaran_id, 'pasien_id' => $model->pasien_id, 'pelayanan' => $_GET['pelayanan'], 'sukses' => 1));
                    }
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data SJP gagal disimpan !");
                }
            } catch (Exception $ex) {
                echo $ex;
                exit;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data SEP gagal disimpan !" . $ex);
            }
        }

        $this->render('_formAsuransiInhealthSJP', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPegawai' => $modPegawai,
            'modRujukan' => $modRujukan,
            'modRujukanInhealth' => $modRujukanInhealth,
            'modAsuransiPasien' => $modAsuransiPasien,
            'modAsuransiPasienInhealth' => $modAsuransiPasienInhealth,
            'modSepInhealthT' => $modSepInhealthT,
            'modPenanggungJawab' => $modPenanggungJawab,
            'modAdmisi' => $modAdmisi,
            'pelayanan' => $_GET['pelayanan'],
        ));
    }

    public function actionAutocompleteDokter()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : '';
            $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
            $criteria->addCondition('ruangan_id=' . $ruangan_id);

            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = PPDokterV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->NamaLengkap;
                $returnVal[$i]['value'] = $model->NamaLengkap;
                $returnVal[$i]['pegawai_id'] = $model->pegawai_id;
                $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
            }

            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
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
                    $mod = PegawaiM::model()->findByAttributes(array(
                        'kodedokter_bpjs' => $kode,
                    ));



                    $form .= "<tr>
                        <td>
                            <a class='btn-small' href='javascript:void(0);' onclick=\" 
                                $('#PPSepT_dpjpygmelayani_nama').val('" . $nama . "');
                                $('#PPSepT_dpjpygmelayani_kode').val('" . $kode . "');
                        ";
                    if (!empty($mod)) {
                        $form .= "$('#PPPendaftaranT_pegawai_id').val('" . $mod->pegawai_id . "');";
                        $form .= "$('#PPPendaftaranT_nama_pegawai').val('" . $mod->namaLengkap . "');";
                    }
                    $form .= "
                                $('#dialogDpjpMelayani').dialog('close'); $('#dialogDpjpMelayaniIGD').dialog('close'); \">
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

    public function actionGetRuanganSpesialisBPJS()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $r = RuanganM::model()->findByPk($_POST['ruangan_id']);
        $ok = 1;
        $kode = "";

        if (empty($r) || empty($r->kode_bpjs)) {
            $ok = 0;
        } else {
            $kode = $r->kode_bpjs;
        }

        echo CJSON::encode(array(
            'ok' => $ok,
            'kode' => $kode,
        ));
    }

    public function serviceTambahAntreanWSBPJS($kodebooking, $jenispasien, $nomorkartu, $nik, $nohp, $kodepoli, $namapoli, $pasienbaru, $norm, $tanggalperiksa, $kodedokter, $namadokter, $jampraktek, $jeniskunjungan, $nomorreferensi, $nomorantrean, $angkaantrean, $estimasidilayani, $sisakuotajkn, $kuotajkn, $sisakuotanonjkn, $kuotanonjkn, $keterangan)
    {
        $body = array("kodebooking" => $kodebooking, "jenispasien" => $jenispasien, "nomorkartu" => $nomorkartu, "nik" => $nik, "nohp" => $nohp, "kodepoli" => $kodepoli, "namapoli" => $namapoli, "pasienbaru" => $pasienbaru, "norm" => $norm, "tanggalperiksa" => $tanggalperiksa, "kodedokter" => $kodedokter, "namadokter" => $namadokter, "jampraktek" => $jampraktek, "jeniskunjungan" => $jeniskunjungan, "nomorreferensi" => $nomorreferensi, "nomorantrean" => $nomorantrean, "angkaantrean" => $angkaantrean, "estimasidilayani" => $estimasidilayani, "sisakuotajkn" => $sisakuotajkn, "kuotajkn" => $kuotajkn, "sisakuotanonjkn" => $sisakuotanonjkn, "kuotanonjkn" => $kuotanonjkn, "keterangan" => $keterangan);

        $antrianonlinebpjs = new AntrianOnlineBpjs();
        $response = CJSON::decode($antrianonlinebpjs->tambah_antrian($body));

        $status = 0;
        $pesan = "";
        if (!empty($response['metaData']['code']) && $response['metaData']['code'] == '200') {
            $status = 1;
        } else {
            $cekAntrean = CJSON::decode($antrianonlinebpjs->antreanPerKodeBooking($kodebooking));
            if ($cekAntrean['metaData']['code'] == '200') {
                $status = 1;
            } else {
                $status = 0;
                if (!empty($response['metaData']['message'])) {
                    $pesan = $response['metaData']['message'];
                }
            }
        }

        $resp['status'] = $status;
        $resp['pesan'] = $pesan;

        return $resp;
    }

    public function serviceUpdateAntreanWSBPJS($kodebooking, $taskid, $waktu)
    {

        $body = array("kodebooking" => $kodebooking, "taskid" => $taskid, "waktu" => $waktu);
        $antrianonlinebpjs = new AntrianOnlineBpjs();
        $response = CJSON::decode($antrianonlinebpjs->update_waktu($body));

        $status = 0;
        $pesan = "";
        if (!empty($response['metaData']['code']) && $response['metaData']['code'] == '200') {
            $status = 1;
        } else {
            $cekAntrean = CJSON::decode($antrianonlinebpjs->antreanPerKodeBooking($kodebooking));
            if ($cekAntrean['metaData']['code'] == '200') {
                $status = 1;
            } else {
                $status = 0;
                if (!empty($response['metaData']['message'])) {
                    $pesan = $response['metaData']['message'];
                }
            }
        }

        $resp['status'] = $status;
        $resp['pesan'] = $pesan;
        return $resp;
    }

    function actionGetPJPasien()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
            $returnValPP = array();
            if (!empty($pasien_id)) {
                $pendaftaran = PendaftaranT::model()->findByAttributes(array(
                    'pasien_id' => $pasien_id,
                ), array(
                    'condition' => 'penanggungjawab_id is not null'
                ));
                if (!empty($pendaftaran)) {
                    $penanggungJP = PenanggungjawabM::model()->findByAttributes(array(
                        'penanggungjawab_id' => $pendaftaran->penanggungjawab_id,
                    ));

                    $returnValPP['pengantar'] = $penanggungJP->pengantar;
                    $returnValPP['nama_pj'] = $penanggungJP->nama_pj;
                    $returnValPP['jeniskelamin'] = $penanggungJP->jeniskelamin;
                    $returnValPP['jenisidentitas'] = $penanggungJP->jenisidentitas;
                    $returnValPP['no_identitas'] = $penanggungJP->no_identitas;
                    $returnValPP['no_teleponpj'] = $penanggungJP->no_teleponpj;
                    $returnValPP['no_mobilepj'] = $penanggungJP->no_mobilepj;
                    $returnValPP['hubungankeluarga'] = $penanggungJP->hubungankeluarga;
                    $returnValPP['tempatlahir_pj'] = $penanggungJP->tempatlahir_pj;
                    $returnValPP['tgllahir_pj'] = date('d/m/Y', strtotime($penanggungJP->tgllahir_pj));
                    $returnValPP['alamat_pj'] = $penanggungJP->alamat_pj;
                } else {
                    $returnValPP = null;
                }
            }
            echo CJSON::encode($returnValPP);
            Yii::app()->end();
        }
    }


    public function actionLoadListPaketBMHP()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $id = $_POST['id'];

        $models = PaketbmhpM::model()->findAllByAttributes(array(
            'tipepaket_id' => $id,
        ), array(
            'order' => 'paketbmhp_nama',
            'condition' => "paketbmhp_nama is not null and paketbmhp_nama <> ''"
        ));

        $html = '<option value="">-- Pilih --</option>';
        foreach ($models as $item) {
            $html .= '<option value="' . $item->paketbmhp_id . '">' . $item->paketbmhp_nama . '</option>';
        }

        echo CJSON::encode(array(
            'html' => $html,
        ));
    }

    public function actionLoadPaketBMHP()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $id = $_POST['id'];

        $paket = PaketbmhpM::model()->findByPk($id);
        if (empty($paket)) {
            echo CJSON::encode(array('ok' => 0, 'msg' => 'Paket tidak ditemukan'));
        }

        echo CJSON::encode(array(
            'ok' => 1,
            'msg' => '',
            'html' => $this->renderPartial($this->path_view . "paket/_rowPaket", array(
                'paket' => $paket,
            ), true)
        ));
    }

    public function simpanPendaftaranMultiPoli($modPendaftaranMultiPoli, $modPendaftaran, $modPasien, $modRujukan, $modPenanggungJawab, $post, $postPasien, $modAsuransiPasien)
    {
        $format = new MyFormatter();
        $modP = PendaftaranT::model()->findByAttributes(array(
            'pasien_id' => $modPasien->pasien_id,
        ), array(
            'condition' => 'pasienbatalperiksa_id is null',
        ));
        $modPendaftaranMultiPoli = new PPPendaftaranMultipoli();
        $modPendaftaranMultiPoli->attributes = $modPendaftaran->attributes;
        $modPendaftaranMultiPoli->attributes = $post;
        $modPendaftaranMultiPoli->pasien_id = $modPasien->pasien_id;
        $modPendaftaranMultiPoli->penanggungjawab_id = $modPenanggungJawab->penanggungjawab_id;
        $modPendaftaranMultiPoli->rujukan_id = $modRujukan->rujukan_id;
        $modPendaftaranMultiPoli->instalasi_id = (isset($modPendaftaranMultiPoli->ruangan_id) ? $modPendaftaranMultiPoli->ruangan->instalasi_id : null);
        $modPendaftaranMultiPoli->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
        $modPendaftaranMultiPoli->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
        $modPendaftaranMultiPoli->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;


        if (empty($postPasien['pasien_id']) || empty($modP)) {
            $modPendaftaranMultiPoli->statuspasien = Params::STATUSPASIEN_BARU;
            $modPendaftaranMultiPoli->kunjungan = Params::STATUSKUNJUNGAN_BARU;
        } else if ($this->is_rm_manual) {
            $modPendaftaranMultiPoli->statuspasien = Params::STATUSPASIEN_LAMA;
            $modPendaftaranMultiPoli->kunjungan = CustomFunction::getKunjungan($modPasien, $modPendaftaranMultiPoli->ruangan_id);
        } else {
            $modPendaftaranMultiPoli->statuspasien = Params::STATUSPASIEN_LAMA;
            $modPendaftaranMultiPoli->kunjungan = CustomFunction::getKunjungan($modPasien, $modPendaftaranMultiPoli->ruangan_id);
        }


        $modPendaftaranMultiPoli->shift_id = Yii::app()->user->getState('shift_id');
        $modPendaftaranMultiPoli->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modPendaftaranMultiPoli->create_loginpemakai_id = Yii::app()->user->id;
        $modPendaftaranMultiPoli->create_time = date("Y-m-d H:i:s");
        $modPendaftaranMultiPoli->tgl_pendaftaran = $format->formatDateTimeForDb($modPendaftaranMultiPoli->tgl_pendaftaran);

        $modPendaftaranMultiPoli->kelompokumur_id = (!empty($modPasien->kelompokumur_id) ? $modPasien->kelompokumur_id : CustomFunction::getKelompokUmur($modPasien->tanggal_lahir));
        $modPendaftaranMultiPoli->statusmasuk = (!empty($modPendaftaranMultiPoli->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
        $modPendaftaranMultiPoli->tgl_konfirmasi = $format->formatDateTimeForDb($modPendaftaranMultiPoli->tgl_konfirmasi);
        $modPendaftaranMultiPoli->tglselesaiperiksa = $format->formatDateTimeForDb($modPendaftaranMultiPoli->tglselesaiperiksa);
        $modPendaftaranMultiPoli->tglrenkontrol = $format->formatDateTimeForDb($modPendaftaranMultiPoli->tglrenkontrol);
        $modPendaftaranMultiPoli->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;
        $modPendaftaranMultiPoli->keterangan_pendaftaran = isset($post['keterangan_pendaftaran']) ? $post['keterangan_pendaftaran'] : null;

        $ins_rj = RuanganrawatjalanV::arrIns();
        if (in_array($modPendaftaranMultiPoli->instalasi_id, $ins_rj)) {
            $modPendaftaranMultiPoli->no_urutantri = MyGenerator::noAntrianJanjiPoliBaru($modPendaftaranMultiPoli->pasien_id, $modPendaftaranMultiPoli->pegawai_id, $modPendaftaranMultiPoli->ruangan_id, $modPendaftaranMultiPoli->tgl_pendaftaran);
        } else {
            $modPendaftaranMultiPoli->no_urutantri = MyGenerator::noAntrianJanjiPoliBaru($modPendaftaranMultiPoli->pasien_id, null, $modPendaftaranMultiPoli->ruangan_id, $modPendaftaranMultiPoli->tgl_pendaftaran);
        }

        $modRuangan = PPRuanganM::model()->findByPk($modPendaftaranMultiPoli->ruangan_id);
        $estimasipelayanan = isset($modRuangan->estimasipelayanan) ? $modRuangan->estimasipelayanan : 15;

        $tgl_awal = date('Y-m-d');
        $criteria = new CDbCriteria();
        $criteria->addCondition('ruangan_id = ' . $modPendaftaranMultiPoli->ruangan_id);
        $criteria->addCondition("tgl_pendaftaran::date = '" . $tgl_awal . "'");
        $criteria->order = 'tgl_pendaftaran DESC';
        $dataPendaftaran = PPPendaftaranT::model()->find($criteria);

        $sisaAntrian = $modPendaftaranMultiPoli->no_urutantri - 1;
        $totalEstimasiPelayanan = $estimasipelayanan * $sisaAntrian;

        $tgldaftar = new DateTime($modPendaftaranMultiPoli->tgl_pendaftaran);
        if (!empty($dataPendaftaran) && !empty($dataPendaftaran->tglakandilayani)) {
            $tglakandilayani = new DateTime($dataPendaftaran->tglakandilayani);

            if ($tgldaftar < $tglakandilayani) {
                $tgldaftar->add(new DateInterval("PT" . $totalEstimasiPelayanan . "M"));
                $modPendaftaranMultiPoli->tglakandilayani = $tgldaftar->format('Y-m-d H:i:s');
            } else {
                $tgldaftar->add(new DateInterval("PT" . $totalEstimasiPelayanan . "M"));
                $modPendaftaranMultiPoli->tglakandilayani = $tgldaftar->format('Y-m-d H:i:s');
            }
        } else {

            $tgldaftar->add(new DateInterval("PT" . $totalEstimasiPelayanan . "M"));
            $modPendaftaranMultiPoli->tglakandilayani = $tgldaftar->format('Y-m-d H:i:s');
        }

        if (!empty($post['buatjanjipoli_id'])) {
            $modPendaftaranMultiPoli->buatjanjipoli_id = $post['buatjanjipoli_id'];

            $janjipoli = BuatjanjipoliT::model()->findByPk($modPendaftaranMultiPoli->buatjanjipoli_id);

            $modPendaftaranMultiPoli->tglakandilayani = $modPendaftaranMultiPoli->tgl_pendaftaran;

            if (!empty($janjipoli)) {
                $tgl_poli = date('Y-m-d', strtotime($janjipoli->tgljadwal));
                $tgl_daftar = date('Y-m-d', strtotime($modPendaftaranMultiPoli->tgl_pendaftaran));

                if (!empty($janjipoli) && $janjipoli->ruangan_id == $modPendaftaranMultiPoli->ruangan_id && $janjipoli->pegawai_id == $modPendaftaranMultiPoli->pegawai_id && $tgl_poli == $tgl_daftar) {
                    $modPendaftaranMultiPoli->no_urutantri = $janjipoli->no_antrianjanji;
                }
            }
        }

        if (!empty($modPendaftaranMultiPoli->nursestation_id)) {
            $modPendaftaranMultiPoli->statuspemeriksaan_nursestation = Params::STATUSPERIKSA_ANTRIAN;
            $modPendaftaranMultiPoli->nourut_antriannursestation = MyGenerator::noAntrianNursestation($modPendaftaranMultiPoli->nursestation_id);
        }
        $modPendaftaranMultiPoli->no_pendaftaran = $modPendaftaranMultiPoli->generateNoRandom();

        if ($modPendaftaranMultiPoli->save()) {
            if (!empty($modPendaftaranMultiPoli->antrian_id)) {
                PPAntrianT::model()->updateByPk($modPendaftaranMultiPoli->antrian_id, array('pendaftaran_id' => $modPendaftaranMultiPoli->pendaftaran_id));
            }

            $this->pendaftaranmultipolitersimpan = true;
        } else {
            $this->pendaftaranmultipolitersimpan = false;
        }
        return $modPendaftaranMultiPoli;
    }

    /**
     * @param type $pendaftaran_id
     */
    public function actionPrintRM1($id)
    {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        // $model = PasienadmisiT::model()->findByPk($id);
        $modDaftar = PendaftaranT::model()->findByPk($id);
        $modPasien = PasienM::model()->findByPk($modDaftar->pasien_id);
        $modPPJ = new PPPenanggungJawabM;
        if (!empty($modDaftar->penanggungjawab_id)) {
            $modPPJ = PPPenanggungJawabM::model()->findByPk($modDaftar->penanggungjawab_id);
        }
        $modProfil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());

        $diagMasuk = PasienmorbiditasT::model()->findByAttributes([
            'pendaftaran_id' => $id,
            'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_MASUK
        ], ['order' => 'create_time ASC']);

        $diagAkhir = PasienmorbiditasT::model()->findByAttributes([
            'pendaftaran_id' => $id,
            'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA
        ], ['order' => 'create_time DESC']);

        //  $model->diagnosisutama_masuk = !empty($diagMasuk) ? $diagMasuk->diagnosa->diagnosa_nama : '-';
        // $model->diagnosisutama_akhir = !empty($diagAkhir) ? $diagAkhir->diagnosa->diagnosa_nama : '-';

        $judul_print = 'LAMBAR MASUK DAN KELUAR (RM 1)';

        $this->render($this->path_view . 'printRM1', array(
            'format' => $format,
            'judul_print' => $judul_print,
            //   'model' => $model,
            'modDaftar' => $modDaftar,
            'modPPJ' => $modPPJ,
            'modPasien' => $modPasien,
            'diagMasuk' => $diagMasuk,
            'diagAkhir' => $diagAkhir,
            'modProfil' => $modProfil

        ));
    }

    public function actionPrintCasemixIdentitas($id)
    {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        // $model = PasienadmisiT::model()->findByPk($id);
        $modDaftar = PendaftaranT::model()->findByPk($id);
        $modPasien = PasienM::model()->findByPk($modDaftar->pasien_id);

        $judul_print = 'LAMBAR MASUK DAN KELUAR (RM 1)';

        $this->render($this->path_view . 'printRMCasemixIden', array(
            'format' => $format,
            'judul_print' => $judul_print,
            'modDaftar' => $modDaftar,
            'modPasien' => $modPasien,

        ));
    }

    /**
     * 
     */
    public function actionStatusBarcodeAntrian()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $antrianId = isset($_POST['antrianID']) ? $_POST['antrianID'] : null;
        $no = isset($_POST['no']) ? $_POST['no'] : null;

        /**
         *  no 1 = Pending/Belum Barcode => Selesai Pending
         * no 2 = Selesai Pending => Pending/Belum Barcode               
         * 
         * no 3 = Terlambat => Terlambat  
         * no 4 = Aktifkan => Pending/Belum Barcode
         *                  
         */
        $trans = Yii::app()->db->beginTransaction();
        $ok = true;
        try {
            $model = AntrianT::model()->findByPk($antrianId);

            if ($no == 1) {
                $model->status_barcode = ParamsConst::STATUSBARCODE_ANTRIAN_PENDING;
                $model->status_panggil = ParamsConst::STATUSPANGGIL_ANTRIAN_TUNGGU;
            } else if ($no == 2) {
                $model->status_barcode = ParamsConst::STATUSBARCODE_ANTRIAN_BELUMBARCODE;
                $model->status_panggil = $model->status_panggil;
            } else if ($no == 3) {
                $model->status_barcode = ParamsConst::STATUSBARCODE_ANTRIAN_TERLAMBAT;
                $model->status_panggil = $model->status_panggil;
            } else if ($no == 4) {
                $model->status_barcode = ParamsConst::STATUSBARCODE_ANTRIAN_BELUMBARCODE;
                $model->status_panggil = $model->status_panggil;
            } else if ($no == 7) {
                $model->status_barcode = $model->status_barcode;
                $model->status_panggil = ParamsConst::STATUSPANGGIL_ANTRIAN_SELESAI;
            }

            $ok &= $model->update(['status_barcode', 'status_panggil']);

            if ($ok) {
                $trans->commit();
            } else {
                $trans->rollback();
            }
        } catch (Exception $e) {
            $trans->rollback();
        }

        echo json_encode([
            'sukses' => $ok
        ]);
    }

    public function actionSrkGetLoadRiwayatSEP()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $ok = 1;
        $msg = "";

        $nokartu = $_POST['nokartu'];

        $bpjs = new BpjsVklaim;


        $konfig = KonfigsystemK::model()->find();
        $hari_riwayat = $konfig->bpjs_riwayatsep_hari ?? 90;
        $period = new DatePeriod(
            new DateTime(date('Y-m-d', strtotime('-' . $hari_riwayat . ' days'))),
            new DateInterval('P30D'),
            new DateTime(date('Y-m-d'))
        );

        $res_histori = array();
        $tgl_histori = array();

        $terakhir = null;
        foreach ($period as $item) {
            $tgl_histori[] = $item->format('Y-m-d');
            $terakhir = $item->format('Y-m-d');
        }

        if (!empty($tgl_histori[count($tgl_histori) - 1]) && $tgl_histori[count($tgl_histori) - 1] != date('Y-m-d')) {
            $tgl_histori[] = date('Y-m-d');
        }
        $tgl_histori = array_reverse($tgl_histori);

        foreach ($tgl_histori as $idx => $item) {
            if (empty($tgl_histori[$idx + 1])) {
                continue;
            }

            $res_temp = CJSON::decode($bpjs->search_monitoring_historipelayanan($nokartu, $tgl_histori[$idx + 1], $tgl_histori[$idx]));
            if (!empty($res_temp['response']['histori'])) {
                $res_histori = array_merge($res_histori, $res_temp['response']['histori']);
            }
        }

        // $res = JSON::decode($bpjs->search_monitoring_historipelayanan($nokartu, '2015-01-01', date('Y-m-d')));

        /*
        if (empty($res) || empty($res['metaData']['code'])) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Terjadi Kesalahan ketika melihat Riwayat SEP.',
                'html'=>'',
            ));
            Yii::app()->end();
        }

        if ($res['metaData']['code'] != 200) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Error BPJS '.$res['metaData']['code']." - ".$res['metaData']['message'],
                'html'=>'',
            ));
            Yii::app()->end();
        } */

        $list = $res_histori; //$res['response']['histori'];
        $html = "";

        $cnt = 0;
        foreach ($list as $item) {
            $html .= $this->renderPartial($this->path_view . "form.srk._rowSEP", array(
                'detail' => $item
            ), true);
            $cnt++;
            if ($cnt >= 15) {
                break;
            }
        }

        echo CJSON::encode(array(
            'ok' => 1,
            'msg' => '',
            'html' => $html,
        ));


        // var_dump($res); die;
    }

    public function actionSrkLoadSEP()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $nomor = $_POST['nosep'];
        $spesialis_id = $_POST['spesialis_id'];
        $bpjs = new BpjsVklaim;

        $res = CJSON::decode($bpjs->search_sep($nomor));
        $pegawaiM = PegawaiM::model()->findByAttributes(array('kodedokter_bpjs' => $res['response']['kontrol']['kdDokter']));
        // echo "<pre>";
        // var_dump($res);die;
        if (empty($pegawaiM)) {
            echo CJSON::encode(array(
                'ok' => 0,
                'msg' => 'SEP tidak bisa dipilih karena dokter ' . $res['response']['kontrol']['nmDokter'] . 'dengan kode ' . $res['response']['kontrol']['kdDokter'] . ' belum terdaftar di SIMRS',
            ));
            Yii::app()->end();
        }
        $dokter = $pegawaiM->pegawai_id;

        $ok = 1;

        if (empty($res['response'])) {
            echo CJSON::encode(array(
                'ok' => 0,
                'msg' => 'Error ' . $res['metaData']['code'] . " - " . $res['metaData']['message'],
            ));
            Yii::app()->end();
        }

        $poli_satu = empty($res['response']['poli']) ? "" : explode(" ", $res['response']['poli'])[0];
        $res_poli = CJSON::decode($bpjs->search_poli($poli_satu));
        $html_dpjp = '<option value="">-- Pilih --</option>';

        if (!empty($res_poli['response']['poli'])) {
            foreach ($res_poli['response']['poli'] as $item) {
                if ($item['nama'] == $res['response']['poli']) {
                    $res['response']['poli'] = $item['kode'];
                    $sp = SpesialissubspesialisM::model()->findByAttributes(array(
                        'spesialissubspesialis_kodebpjs' => $item['kode'],
                        'spesialissubspesialis_aktif' => True
                    ));

                    if (!empty($sp)) {
                        $tanggalKontrol = isset($_POST['tgl']) ? MyFormatter::formatDateTimeForDb($_POST['tgl']) : date('Y-m-d');
                        $dataDokter = CJSON::decode($bpjs->search_jadwal_dokter_kontrol(2, $item['kode'], $tanggalKontrol));
                        $peg_list = array();


                        if (isset($dataDokter['response']) && $dataDokter['metaData']['code'] == 200) {
                            foreach ($dataDokter['response']['list'] as $item) {
                                if ($item['kapasitas'] == 0) {
                                    continue;
                                }
                                $peg = PegawaiM::model()->findByAttributes(array(
                                    'kodedokter_bpjs' => $item['kodeDokter'],
                                ));

                                if (empty($peg)) {
                                    continue;
                                }

                                if (in_array($peg->pegawai_id, $peg_list)) {
                                    continue;
                                }

                                $peg_list[] = $peg->pegawai_id;

                                $html_dpjp .= '<option value="' . $peg->pegawai_id . '"' . ($peg->pegawai_id == $dokter ? "selected" : null) . '>' . $peg->namaLengkap . '</option>';
                            }
                        }
                        // else {
                        //     $peg = PegawaiM::model()->findAllByAttributes(array(
                        //         'spesialissubspesialis_id' => $sp->spesialissubspesialis_id,
                        //     ));
                        //     foreach ($peg as $item_peg) {
                        //         $html_dpjp .= '<option value="' . $item_peg->pegawai_id . '" data-kode="' . $item_peg->kodedokter_bpjs . '">' . $item_peg->namaLengkap . '</option>';
                        //     }
                        // }
                    }
                }
            }
        } else {
            $sp = SpesialissubspesialisM::model()->findByPk($spesialis_id);
            if (!empty($sp)) {
                $tanggalKontrol = isset($_POST['tgl']) ? MyFormatter::formatDateTimeForDb($_POST['tgl']) : date('Y-m-d');
                $dataDokter = CJSON::decode($bpjs->search_jadwal_dokter_kontrol(2, $sp->spesialissubspesialis_kodebpjs, $tanggalKontrol));
                $peg_list = array();


                if (isset($dataDokter['response']) && $dataDokter['metaData']['code'] == 200) {
                    foreach ($dataDokter['response']['list'] as $item) {
                        if ($item['kapasitas'] == 0) {
                            continue;
                        }
                        $peg = PegawaiM::model()->findByAttributes(array(
                            'kodedokter_bpjs' => $item['kodeDokter'],
                        ));

                        if (empty($peg)) {
                            continue;
                        }

                        if (in_array($peg->pegawai_id, $peg_list)) {
                            continue;
                        }

                        $peg_list[] = $peg->pegawai_id;

                        $html_dpjp .= '<option value="' . $peg->pegawai_id . '"' . ($peg->pegawai_id == $dokter ? "selected" : null) . '>' . $peg->namaLengkap . '</option>';
                    }
                }
            }
        }

        // var_dump($res_poli); die;

        echo CJSON::encode(array(
            'ok' => 1,
            'sepData' => $res['response'],
            'html_dpjp' => $html_dpjp,
        ));
    }

    public function actionRskSimpan()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        if (isset($_POST['SuratketeranganR'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            $iok = 1;
            $msg = "";
            $model = new SuratketeranganR;
            $model->attributes = $_POST['SuratketeranganR'];
            $model->tglkontrol = MyFormatter::formatDateTimeForDb($model->tglkontrol);
            $model->jenissurat_id = 2;
            $model->tglsurat = date('Y-m-d');
            $model->nourutsurat = 1;
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->profilrs_id = 1;
            $model->nokartu_asuransi = isset($_POST['SuratketeranganR']['nokartu_asuransi']) ? $_POST['SuratketeranganR']['nokartu_asuransi'] : null;
            $model->nama_pasien = isset($_POST['SuratketeranganR']['nama_pasien']) ? $_POST['SuratketeranganR']['nama_pasien'] : null;
            $model->nosep = isset($_POST['SuratketeranganR']['nosep']) ? $_POST['SuratketeranganR']['nosep'] : null;
            $model->tglsep = isset($_POST['SuratketeranganR']['tglsep']) ? $_POST['SuratketeranganR']['tglsep'] : null;
            $model->tglrenkontrol = isset($_POST['SuratketeranganR']['tglkontrol']) ? MyFormatter::formatDateTimeForDb($_POST['SuratketeranganR']['tglkontrol']) : null;

            $model->create_time = date('Y-m-d');
            $model->update_time = date('Y-m-d');
            $model->create_loginpemakai_id = Yii::app()->user->id;
            $model->update_loginpemakai_id = Yii::app()->user->id;
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $model->nomorsurat = MyGenerator::noSuratKontrol(2, Yii::app()->user->getState('ruangan_id'));

            $judul = JenissuratM::model()->findByAttributes(array('jenissurat_id' => 2));
            $model->judulsurat = $judul->jenissurat_nama;


            $spe = SpesialissubspesialisM::model()->findByPk($_POST['SuratketeranganR']['spesialissubspesialis_id']);
            if (!empty($spe)) {
                $model->polikontrol = $spe->spesialissubspesialis_kodebpjs;
            }

            $peg = PegawaiM::model()->findByPk($_POST['SuratketeranganR']['doktertujuankontrol_id']);
            if (!empty($peg)) {
                $model->kodedokterkontrol = $peg->kodedokter_bpjs;
                $model->namadokterkontrol = $peg->namaLengkap;
            }

            if ($model->validate() && $model->save()) {
                $ok = true;
            } else {
                $ok = false;
                $iok = 0;
                $msg = "SRK gagal disimpan";

                echo CJSON::encode(array(
                    'ok' => $iok,
                    'msg' => $msg,
                ));
                Yii::app()->end();
            }

            // simpan ke bpjs
            $kontrol_tgl_rencana = MyFormatter::formatDateTimeForDb($_POST['SuratketeranganR']['tglkontrol']); //$model->tglkontrol;
            $user = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            $kontrol_user_res = empty($user) ? "" : trim($user->namaLengkap);
            $kontrol_no_sep = $_POST['SuratketeranganR']['nosep']; //$model->nosep;
            $kode_dokter = $model->kodedokterkontrol;
            $kontrol_poli = $model->polikontrol;

            $bpjs = new BpjsVklaim;

            $res_kontrol = CJSON::decode($bpjs->create_rencana_kontrol($kontrol_no_sep, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res));
            /*
            $res_kontrol = array(
                "response"=>array(
                    "noSuratKontrol"=>"0301R0110520K000013",
                )
            );
            // */
            // var_dump($res_kontrol); die;
            // var_dump($ok, $_POST, $model->errors, $model->attributes); die;

            if (!empty($res_kontrol['response'])) {
                $model->nomorsurat_bpjs = $res_kontrol['response']['noSuratKontrol'];
                $model->save();
                $this->logBpjs($model, $res_kontrol, $bpjs->server_new['create_rencana_kontrol']);

                $trans->commit();

                echo CJSON::encode(array(
                    'ok' => 1,
                    'msg' => $msg,
                    'nomor_kontrol' => $model->nomorsurat_bpjs,
                    'kode_dpjp' => $model->kodedokterkontrol,
                    'nama_dpjp' => $model->namadokterkontrol,
                    'suratketerangan_id' => $model->suratketerangan_id,
                ));
                Yii::app()->end();
            } else {
                $trans->rollback();
                $iok = 0;
                $msg = "Error " . $res_kontrol['metaData']['code'] . " - " . $res_kontrol['metaData']['message'];

                $this->logBpjs($model, $res_kontrol, $bpjs->server_new['create_rencana_kontrol']);
                echo CJSON::encode(array(
                    'ok' => $iok,
                    'msg' => $msg,
                ));
                Yii::app()->end();
            }
        }
    }

    public function actionPrintSRK($id)
    {

        $model = SuratketeranganR::model()->findByPk($id);
        $judul = JenissuratM::model()->findByAttributes(array('jenissurat_id' => $model->jenissurat_id));
        $judulLaporan = '';
        $modDiagnosa = null;
        $modTambahan = array();

        $this->layout = '//layouts/printWindows';
        $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatJalan.form.srk.PrintRencanaKonsulSRK', array(
            //'modPendaftaran' => $modPendaftaran,
            'judul' => $judul,
            'caraPrint' => "PRINT",
            'model' => $model,
            //'modPasien' => $modPasien,
            //'modRuangan' => $modRuangan,
            'judulLaporan' => $judulLaporan,
            'modDiagnosa' => $modDiagnosa,
            'modTambahan' => $modTambahan
        ));
    }

    public function actionBpjsLoadSuratKontrolDariRujukanRuangan()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $no_kartu = $_POST['no_kartu'];
        $no_rujukan = $_POST['no_rujukan'];
        $ruangan_daftar = RuanganM::model()->findByAttributes(array('kode_bpjs' => $_POST['ruangan_id']));
        $ruangan_id = $ruangan_daftar->ruangan_id; //$_POST['ruangan_id'];
        $form_sep = isset($_POST['form_sep']) ? $_POST['form_sep'] : 0;

        $bpjs = new BpjsVklaim;
        $res = CJSON::decode($bpjs->search_kartu($no_kartu));

        if ($res["metaData"]["code"] != 200) {
            echo CJSON::encode(array(
                'ok' => 0,
            ));
            Yii::app()->end();
        }

        // histori riwayat sep
        $konfig = KonfigsystemK::model()->find();

        $hari_riwayat = $konfig->bpjs_riwayatsep_hari ?? 90;

        $ref_data = array();

        if ($form_sep == 1) {

            $total_1 = CJSON::decode($bpjs->jmlsep_rujukan($no_rujukan, 1));
            $total_2 = CJSON::decode($bpjs->jmlsep_rujukan($no_rujukan, 2));

            $total_kunjungan = 0;

            if (!empty($total_1['metaData']['code']) && $total_1['metaData']['code'] == 200) {
                $total_kunjungan += $total_1['response']['jumlahSEP'];
            }
            if (!empty($total_2['metaData']['code']) && $total_2['metaData']['code'] == 200) {
                $total_kunjungan += $total_2['response']['jumlahSEP'];
            }

            // var_dump($total_1, $total_2, $total_kunjungan); die;
            if ($total_kunjungan == 0) {
                goto end_res;
            }

            $ruangan_daftar = RuanganM::model()->findByPk($ruangan_id);
            $res_rujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan($no_rujukan));
            if (empty($res_rujukan['response'])) {
                $res_rujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan_rs($no_rujukan));
            }
        } else {
            $res_rujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan($no_rujukan));
            if (empty($res_rujukan['response'])) {
                $res_rujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan_rs($no_rujukan));
            }
        }



        $res_kontrol = CJSON::decode($bpjs->list_rencana_kontrol2(date('m'), date('Y'), $no_kartu, 2));
        // $res_kontrol2 =  CJSON::decode($bpjs->list_rencana_kontrol2(date('m', strtotime('-1 month')), date('Y', strtotime('-1 month')), $no_kartu, 2));

        $referensi_kontrol = array();
        if (!empty($res_kontrol['response']['list']) && !empty($res_rujukan['response'])) {
            foreach ($res_kontrol['response']['list'] as $item) {
                if ($ruangan_daftar->kode_bpjs == $item['poliTujuan']) {
                    $referensi_kontrol = $item;
                } else if ($res_rujukan['response']['rujukan']['poliRujukan']['kode'] == $item['poliTujuan']) {
                    $referensi_kontrol = $item;
                }
            }
        } else {
            $res_kontrol = CJSON::decode($bpjs->list_rencana_kontrol2(date('m', strtotime('-1 month')), date('Y', strtotime('-1 month')), $no_kartu, 2));

            if (!empty($res_kontrol['response']['list']) && !empty($res_rujukan['response'])) {
                foreach ($res_kontrol['response']['list'] as $item) {
                    if ($ruangan_daftar->kode_bpjs == $item['poliTujuan']) {
                        $referensi_kontrol = $item;
                    } else if ($res_rujukan['response']['rujukan']['poliRujukan']['kode'] == $item['poliTujuan']) {
                        $referensi_kontrol = $item;
                    }
                }
            }
        }

        // var_dump($res_kontrol, $referensi_kontrol); die;

        end_res:

        $res = array(
            "no_surat" => "",
            "nama_dpjp" => "",
            "kode_dpjp" => "",
        );

        if (!empty($referensi_kontrol['noSuratKontrol'])) {
            $res["no_surat"] = $referensi_kontrol["noSuratKontrol"];
            $res["nama_dpjp"] = $referensi_kontrol["namaDokter"];
            $res["kode_dpjp"] = $referensi_kontrol["kodeDokter"];
        }

        echo CJSON::encode(array(
            'ok' => 1, 'kontrol' => $res,
        ));


        // var_dump($referensi_kontrol, $res_rujukan, $res_histori); die;   


    }

    public function actionAutocompleteNoAntrian()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $model = new AntrianT;
        $model->noantrian = $_GET['term'];
        $load = $model->searchRiwayatPanggil();
        $load->criteria->limit = 10;
        $load->pagination = false;

        $data = [];
        foreach ($load->getData() as $key => $val) {
            $data[$key]['label'] = $val->noantrian;
            $data[$key]['value'] = $val->antrian_id;
            $data[$key]['noantrian'] = $val->noantrian;
            $data[$key]['modelantrian_id'] = $val->modelantrian_id;
            $data[$key]['loket_id'] = $val->loket_id;
            $data[$key]['antrian_id'] = $val->antrian_id;
        }

        echo json_encode($data);
    }

    public function actionUpdateFlaq()
    {
        if (isset($_POST)) {
            $antrian_id = $_POST['antrian_id'];
            $no_antrian = $_POST['noantrian'];
            $loket_id = $_POST['loket_id'];
            $data['pesan'] = "Gagal";
            $data['success'] = 0;

            if (!empty($no_antrian)) {
                $cr = new CDbCriteria;
                $cr->join = "join modelantrian_m m on m.modelantrian_id = t.modelantrian_id 
                    JOIn ruangan_m r ON r.ruangan_id = t.ruangan_id 
                ";
                $cr->compare('DATE(t.tglantrian)', date("Y-m-d"));
                $cr->compare("m.modelantrian_singkatan || '-' || t.noantrian", trim($no_antrian));
                $modAntrian = PPAntrianT::model()->find($cr);
            } else {
                $modAntrian =  PPAntrianT::model()->findByPk($antrian_id);
            }

            if (isset($modAntrian)) {

                $modAntrian->tglpanggil = date("Y-m-d H:i:s");
                $modAntrian->status_panggil = ParamsConst::STATUSPANGGIL_ANTRIAN_TUNGGU;
                $modAntrian->status_barcode = ParamsConst::STATUSBARCODE_ANTRIAN_PROSES;
                $modAntrian->panggil_flaq = true;
                if (empty($modAntrian->loket_id)) {
                    $modAntrian->loket_id = $loket_id;
                }
                if ($modAntrian->update()) {
                    $data['pesan'] = "No. antrian " . $modAntrian->noantrian . " Dipilih !";
                    $data['success'] = 1;
                } else {
                    $data['pesan'] = "Gagal Memilih Antrian";
                }
            } else {
                $data['pesan'] = 'Gagal MEMILIH ANTRIAN';
            }

            echo json_encode($data);
        }
    }

    public function actionCekVClaimSpesialis()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $html = '<option value="">-- Pilih --</option>';
        // $sep_id = $_POST['sep_id'];
        $no_kartu = $_POST['no_kartu'];
        $spesialis_id = $_POST['spesialis_id'];
        $tgl = MyFormatter::formatDateTimeForDB($_POST['tgl']);

        // $modSep = SepT::model()->findByPk($sep_id);
        $modSpesialis = SpesialissubspesialisM::model()->findByPk($spesialis_id);


        if (empty($modSpesialis)) {
            echo CJSON::encode(array(
                'ok' => 0,
                'msg' => 'Data Spesialis tidak Ditemukan',
                'html' => $html,
            ));
            Yii::app()->end();
        }

        // $no_kartu = $modSep->nokartuasuransi;

        $bpjs = new Bpjs_Vklaim;
        $res = $bpjs->search_spesialtik_kontrol(1, $no_kartu, $tgl);

        if (!$res) {
            echo CJSON::encode(array(
                'ok' => 0,
                'msg' => 'Terjadi kesalahan dalam pengecekan Ruangan VClaim',
                'html' => $html,
            ));
            Yii::app()->end();
        }


        $res_json = CJSON::decode($res);
        // vaR_dump($no_kartu, $tgl, $modSpesialis->attributes, $res_json); die;
        if ($res_json['metaData']['code'] != 200) {
            echo CJSON::encode(array(
                'ok' => 0,
                'msg' => $res_json['metaData']['message'],
                'html' => $html,
            ));
            Yii::app()->end();
        }

        $is_ada = false;
        foreach ($res_json['response']['list'] as $item) {
            if (
                $modSpesialis->spesialissubspesialis_kode == $item['kodePoli']
                || $modSpesialis->spesialissubspesialis_kodebpjs == $item['kodePoli']
            ) {
                $is_ada = true;


                break;
            }
        }

        if (!$is_ada) {
            echo CJSON::encode(array(
                'ok' => 0,
                'msg' => 'Spesilis/Subspesialis tidak tersedia di BPJS',
                'html' => $html,
            ));
            Yii::app()->end();
        }

        $html = '<option value="">-- Pilih --</option>';
        $tanggalKontrol = isset($_POST['tglkontrol']) ? MyFormatter::formatDateTimeForDb($_POST['tglkontrol']) : date('Y-m-d');
        $dataDokter = CJSON::decode($bpjs->search_jadwal_dokter_kontrol(2, $modSpesialis->spesialissubspesialis_kode, $tanggalKontrol));
        $peg_list = array();



        if (isset($dataDokter['response']) && $dataDokter['metaData']['code'] == 200) {
            foreach ($dataDokter['response']['list'] as $item) {
                if ($item['kapasitas'] == 0) {
                    continue;
                }
                $peg = PegawaiM::model()->findByAttributes(array(
                    'kodedokter_bpjs' => $item['kodeDokter'],
                ));

                if (empty($peg)) {
                    continue;
                }

                if (in_array($peg->pegawai_id, $peg_list)) {
                    continue;
                }

                $peg_list[] = $peg->pegawai_id;
                $html .= '<option value="' . $peg->pegawai_id . '">' . $peg->namaLengkap . '</option>';
                // $html .= '<option value="' . $peg->pegawai_id . '"' . ($peg->pegawai_id == $dokter ? "selected" : null) . '>' . $peg->namaLengkap . '</option>';
            }
        } 
        // else {
        //     // DOKTER

        //     $peg = PegawaiM::model()->findAllByAttributes(array(
        //         'spesialissubspesialis_id' => $modSpesialis->spesialissubspesialis_id
        //     ), array(
        //         'order' => 'nama_pegawai asc',
        //     ));

        //     $html = '<option value="">-- Pilih --</option>';

        //     foreach ($peg as $item) {
        //         if (empty($item->kodedokter_bpjs)) {
        //             continue;
        //         }
        //         $html .= '<option value="' . $item->pegawai_id . '">' . $item->namaLengkap . '</option>';
        //     }
        // }


        echo CJSON::encode(array(
            'ok' => 1,
            'msg' => '-',
            'html' => $html,
        ));
    }

    public function actionLoadRiwayatSEP2()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $nomor = $_POST['nomor'];
        $tgl_awal = MyFormatter::formatDateTimeForDb($_POST['tgl_awal']);
        $tgl_akhir = MyFormatter::formatDateTimeForDb($_POST['tgl_akhir']);
        $ok = 1;
        $msg = "";

        $bpjs = new BpjsVklaim;
        $html = "";

        $period = new DatePeriod(
            new DateTime(date('Y-m-d', strtotime('-90 days'))),
            new DateInterval('P30D'),
            new DateTime(date('Y-m-d'))
        );

        $res_histori = array();
        $tgl_histori = array();

        $terakhir = null;
        foreach ($period as $item) {
            $tgl_histori[] = $item->format('Y-m-d');
            $terakhir = $item->format('Y-m-d');
        }

        if (!empty($terakhir) && $terakhir != date('Y-m-d')) {
            $tgl_histori[] = date('Y-m-d');
        }
        $tgl_histori = array_reverse($tgl_histori);

        $res_temp = CJSON::decode($bpjs->search_monitoring_historipelayanan($nomor, $tgl_awal, $tgl_akhir));

        if (!empty($res_temp['response']['histori'])) {
            $res_histori = array_merge($res_histori, $res_temp['response']['histori']);
        }

        $cnt = 0;
        if (!empty($res_histori)) {
            foreach ($res_histori as $item) {
                // var_dump($item);die;
                $html .= $this->renderPartial($this->path_view . "form.srk._rowSEP", array(
                    'detail' => $item
                ), true);
                $cnt++;
                if ($cnt >= 15) {
                    break;
                }
            }
        } else {
            $ok = 0;
            $msg = "Data SEP Tidak Ditemukan";
        }
        // echo "<pre>";
        // var_dump($res_histori);
        // die;

        // var_dump($res); die;
        echo CJSON::encode(array(
            'html' => $html,
            'ok' => $ok,
            'msg' => $msg,
        ));
    }

    public function actionSrkGetLoadRiwayatSEPRI()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $ok = 1;
        $msg = "";

        $nokartu = $_POST['nokartu'];

        $bpjs = new BpjsVklaim;


        $konfig = KonfigsystemK::model()->find();
        $hari_riwayat = $konfig->bpjs_riwayatsep_hari ?? 90;
        $period = new DatePeriod(
            new DateTime(date('Y-m-d', strtotime('-' . $hari_riwayat . ' days'))),
            new DateInterval('P30D'),
            new DateTime(date('Y-m-d'))
        );

        $res_histori = array();
        $tgl_histori = array();

        $terakhir = null;
        foreach ($period as $item) {
            $tgl_histori[] = $item->format('Y-m-d');
            $terakhir = $item->format('Y-m-d');
        }

        if (!empty($tgl_histori[count($tgl_histori) - 1]) && $tgl_histori[count($tgl_histori) - 1] != date('Y-m-d')) {
            $tgl_histori[] = date('Y-m-d');
        }
        $tgl_histori = array_reverse($tgl_histori);

        foreach ($tgl_histori as $idx => $item) {
            if (empty($tgl_histori[$idx + 1])) {
                continue;
            }

            $res_temp = CJSON::decode($bpjs->search_monitoring_historipelayanan($nokartu, $tgl_histori[$idx + 1], $tgl_histori[$idx]));
            if (!empty($res_temp['response']['histori'])) {
                $res_histori = array_merge($res_histori, $res_temp['response']['histori']);
            }
        }

        $list = $res_histori; //$res['response']['histori'];
        $html = "";

        $cnt = 0;

        foreach ($list as $item) {
            if ($item['jnsPelayanan'] == 1) {
                $html .= $this->renderPartial($this->path_view . "form.srk._rowSEPRI", array(
                    'detail' => $item
                ), true);
                $cnt++;
            } else {
                continue;
            }

            if ($cnt >= 15) {
                break;
            }
        }

        echo CJSON::encode(array(
            'ok' => 1,
            'msg' => '',
            'html' => $html,
        ));


        // var_dump($res); die;
    }

    public function actionCekSepRujukan()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }


        $nokartu = $_POST['no_kartu'];
        $norujukan = $_POST['norujukan'];
        $bpjs = new BpjsVklaim;

        $konfig = KonfigsystemK::model()->find();
        $hari_riwayat = $konfig->bpjs_riwayatsep_hari ?? 90;
        $period = new DatePeriod(
            new DateTime(date('Y-m-d', strtotime('-' . $hari_riwayat . ' days'))),
            new DateInterval('P30D'),
            new DateTime(date('Y-m-d'))
        );

        $res_histori = array();
        $tgl_histori = array();

        $terakhir = null;
        foreach ($period as $item) {
            $tgl_histori[] = $item->format('Y-m-d');
            $terakhir = $item->format('Y-m-d');
        }

        if (!empty($tgl_histori[count($tgl_histori) - 1]) && $tgl_histori[count($tgl_histori) - 1] != date('Y-m-d')) {
            $tgl_histori[] = date('Y-m-d');
        }
        $tgl_histori = array_reverse($tgl_histori);

        foreach ($tgl_histori as $idx => $item) {
            if (empty($tgl_histori[$idx + 1])) {
                continue;
            }

            $res_temp = CJSON::decode($bpjs->search_monitoring_historipelayanan($nokartu, $tgl_histori[$idx + 1], $tgl_histori[$idx]));
            if (!empty($res_temp['response']['histori'])) {
                $res_histori = array_merge($res_histori, $res_temp['response']['histori']);
            }
        }

        $list = $res_histori; //$res['response']['histori'];

        $cnt = 0;
        $ok = 0;
        foreach ($list as $item) {
            if ($item['noRujukan'] == $norujukan) {
                $ok = 1;
                break;
            }
        }

        echo CJSON::encode(array(
            'ok' => $ok
        ));
    }
}
