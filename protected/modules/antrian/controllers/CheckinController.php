<?php

Yii::import("pendaftaranPenjadwalan.models.*");

class CheckinController extends Controller
{

    public $layout = '//layouts/kiosAntrian';

    public function actionIndex()
    {
        $this->layout = '//layouts/kiosAntrian';
        $modSep = new PPSepT;
        $modAsuransiPasien = new PPAsuransipasienbpjsM;
        $model = new PPPendaftaranT;
        $modPasien = new PPPasienM;
        $modRujukanBpjs = new PPRujukanbpjsT;
        $profil = ProfilrumahsakitM::model()->find();

        if (isset($_POST['PPSepT'])) {
            $trans = Yii::app()->db->beginTransaction();
            $modSep->attributes = $_POST['PPSepT'];
            $modSep->tglsep = MyFormatter::formatDateTimeForDB($modSep->tglsep);
            $modSep->jnspelayanan = 2;
            $modSep->ppkpelayanan = $profil->ppkpelayanan;
            $modSep->catatansep = "SEP baru dari Form SEP Mandiri";
            $modSep->no_telpon_peserta = $_POST['PPSepT']['no_telpon_peserta'];
            $modSep->statuskecelakaan_kode = "0";
            $modSep->cob = "0";
            $modSep->poli_eksekutif = "0";
            $modSep->katarak = "0";
            $modSep->tglpulang = date('Y-m-d H:i:s');
            $modSep->create_time = date('Y-m-d H:i:s');
            $modSep->create_loginpemakai_id = 1;
            $modSep->create_ruangan = 1;
            $lakalantas = 0;
            $asalRujukan = 1; //$modSep->jenisrujukan_kode;
            $eksekutif = 0;
            $cob = null;
            $lokasiLaka = null;
            $noTelp = $modSep->no_telpon_peserta;
            $user = "pasien_mandiri";
            $tglKejadian = null;
            $keterangan = $modSep->catatansep;
            $suplesi = 0;
            $noSepSuplesi = null;
            $kdPropinsi = null;
            $kdKabupaten = null;
            $kdKecamatan = null;
            $noSurat = '';
            $tgl_kontrol = ''; //$modSep->no_surat;
            $kodeDPJP = $modSep->kode_dpjp;
            $katarak = 0;
            $janji_poli = BuatjanjipoliT::model()->findByPk($_POST['PPPendaftaranT']['buatjanjipoli_id']);
            $ruangan = RuanganM::model()->findByPk($janji_poli->ruangan_id);
            $pegawai = PegawaiM::model()->findByPk($janji_poli->pegawai_id);
            $penjamin = "";
            $bpjs = new BpjsVklaim;
            $dataPeserta = CJSON::decode($bpjs->search_kartu($janji_poli->no_kartu_bpjs));
            $noTelp = !empty($dataPeserta['response']['peserta']['mr']['noTelepon']) ? $dataPeserta['response']['peserta']['mr']['noTelepon'] : "000000000000";
            $modSep->no_telpon_peserta = $noTelp;
            try {
                if($janji_poli->carabayar_id != Params::CARABAYAR_ID_BPJS){
                    $res = Yii::app()->db->createCommand("select ins_buatjanjipolitopendaftaran_dari_id(" . $janji_poli->buatjanjipoli_id . ") as res")->queryRow();
                    // var_dump($res);die;
                    if($res['res'] == True){
                        $janji_poli->is_checkin = true;
                        $janji_poli->save();
                        $trans->commit();
                        $modPendaftaran = PendaftaranT::model()->findByAttributes(array('buatjanjipoli_id'=> $janji_poli->buatjanjipoli_id));
                        $this->tambahAntrian($modPendaftaran, '');
                        Yii::app()->user->setFlash('success', 'Pasien Berhasil Check in');
                        $this->redirect(array('AmbilTiket/IndexAntrianPasien', 'pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'sukses' => 1, 'buatjanjipoli_id'=> $janji_poli->buatjanjipoli_id));
                    }else{
                        $trans->rollback();
                        Yii::app()->user->setFlash('error', 'Pasien Gagal CheckIn');
                        $this->redirect(array('index'));
                    }
                }else{
                    //update no rekam medik RSSACPT-2963
                $modPasien = PasienM::model()->findByPk($janji_poli->pasien_id);
                if (!empty($janji_poli) && !empty($modPasien)) {
                    if (strpos($modPasien->no_rekam_medik, "JP") === 0) {
                        $modPasien->generateNoRMDanSimpan();
                        $modPasien->ispasienluar = false;
                        $modPasien->update(['ispasienluar']);

                        $modPasien->no_rekam_medik = $modPasien->normbaru;
                    }
                }
                $tglsep = date('Y-m-d');
                $is_sep = false;
                $modSep2 = SepT::model()->findByAttributes(array('nokartuasuransi' => $janji_poli->no_kartu_bpjs), array('limit' => 1, 'order' => 'sep_id desc'));
                if (
                    isset($modSep2)
                    && isset($modSep2->nokartuasuransi)
                    && date('Y-m-d', strtotime($modSep2->tglsep)) == date('Y-m-d')
                ) {

                    $modPendaftaran = PendaftaranT::model()->findByAttributes(array('sep_id' => $modSep2->sep_id));
                    if (empty($janji_poli->pendaftaran_id)) {
                        $janji_poli->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                    }
                    $modPendaftaran_new = PendaftaranT::model()->findByAttributes(array('sep_id' => $modSep2->sep_id));
                    $this->tambahAntrian($modPendaftaran_new, $modSep2->sep_id);
                    Yii::app()->user->setFlash('success', 'SEP Berhasil dibuat');
                    $this->redirect(array('AmbilTiket/IndexAntrianPasien', 'sep_id' => $modSep2->sep_id, 'pendaftaran_id' => $janji_poli->pendaftaran_id, 'sukses' => 1, 'buatjanjipoli_id' => $janji_poli->buatjanjipoli_id));
                } else {
                    $bpjs = new BpjsVklaim;
                    $konfig = KonfigsystemK::model()->find();
                    $tglakhir = date("Y-m-d");
                    $hari_riwayat = $konfig->bpjs_riwayatsep_hari ?? 90;
                    $tglawal = date('Y-m-d', strtotime('-' . $hari_riwayat . ' days'));

                    //tambah antrian
                    $modPendaftaran_new = PendaftaranT::model()->findByPk($janji_poli->pendaftaran_id);


                    //mulai cari rujukan online
                    $noRujukan = "";
                    $no_sep = '';
                    $noSurat = '';
                    $listRujukan = CJSON::decode($bpjs->search_rujukan_pcare_multi($janji_poli->no_kartu_bpjs));
                    if ($listRujukan['metaData']['code'] != 200) {
                        $listRujukan = CJSON::decode($bpjs->search_rujukan_multi_rs_list($janji_poli->no_kartu_bpjs));
                    }
                    if ($listRujukan['metaData']['code'] != 200) {
                        $trans->rollback();
                        Yii::app()->user->setFlash('error', 'BPJS Error create SEP' . $listRujukan['metaData']['code'] . ': ' . $listRujukan['metaData']['message']);
                        $this->redirect(array('index'));
                    } else {
                        $modSep->jenisrujukan_kode = $listRujukan['response']['asalFaskes'];
                        $modSep->jenisrujukan_nama = ($modSep->jenisrujukan_kode == 1) ? "PCare" : "Rumah Sakit";
                        foreach ($listRujukan['response']['rujukan'] as $value) {
                            if ($value['poliRujukan']['kode'] == $ruangan->kode_bpjs) {
                                $noRujukan = $value['noKunjungan'];
                                $janji_poli->nomorreferensijkn = $noRujukan;
                            }
                        }
                    }

                    // echo "<pre>";
                    // var_dump($listRujukan);die;

                    //cari di monitoring histori pelayanan
                    $dataPoli = CJSON::decode($bpjs->search_poli($ruangan->kode_bpjs));
                    foreach ($dataPoli['response']['poli'] as $value) {
                        if ($value['kode'] == $ruangan->kode_bpjs) {
                            $dataPoli = $value['nama'];
                        }
                    }
                    // echo "<pre>";
                    // var_dump($noRujukan);die;
                    $monitoring = CJSON::decode($bpjs->monitoring_histori_pelayanan($janji_poli->no_kartu_bpjs, $tglawal, $tglakhir));
                    if ($monitoring['metaData']['code'] == 200) {
                        $histori = $monitoring['response']['histori'];
                        foreach ($histori as $items) {
                            if ($janji_poli->nomorreferensijkn == $items['noRujukan']) {
                                $no_sep = $items['noSep'];
                                $noRujukan = $items['noRujukan'];
                                break;
                            } else if ($ruangan->kode_bpjs == 'IRM') {
                                $no_sep = $items['noSep'];
                                $janji_poli->nomorreferensijkn = $items['noRujukan'];
                                $noRujukan = $items['noRujukan'];
                                break;
                            } else if ($dataPoli == $items['poli']) {
                                $no_sep = $items['noSep'];
                                $janji_poli->nomorreferensijkn = $items['noRujukan'];
                                $noRujukan = $items['noRujukan'];
                                break;
                            } else {
                                $no_sep = 'internal';
                                $janji_poli->nomorreferensijkn = $histori[0]['noRujukan'];
                                $noRujukan = $histori[0]['noRujukan'];
                            }
                        }
                        if ($no_sep == 'internal') {
                            // $janji_poli->nomorreferensijkn = $listRujukan['response']['rujukan'][0]['noKunjungan'];
                            // $noRujukan = $histori[0]['noRujukan'];
                        }
                    } else {
                        $no_sep = '';
                    }
                    if ($noRujukan == "") {
                        $janji_poli->nomorreferensijkn = $listRujukan['response']['rujukan'][0]['noKunjungan'];
                        $noRujukan = $listRujukan['response']['rujukan'][0]['noKunjungan'];
                        $no_sep = 'internal';
                    }

                    //cari spesifik rujukan
                    $dataRujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan($noRujukan));
                    if ($dataRujukan['metaData']['code'] == 202) {
                        $janji_poli->nomorreferensijkn = $listRujukan['response']['rujukan'][0]['noKunjungan'];
                        $noRujukan = $listRujukan['response']['rujukan'][0]['noKunjungan'];
                        $no_sep = 'internal';
                        $dataRujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan($noRujukan));
                    }
                    if ($dataRujukan['metaData']['code'] != 200) {
                        $dataRujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan_rs($janji_poli->nomorreferensijkn));
                    }
                    if ($dataRujukan['metaData']['code'] == 201) {
                        $janji_poli->nomorreferensijkn = $listRujukan['response']['rujukan'][0]['noKunjungan'];
                        $noRujukan = $listRujukan['response']['rujukan'][0]['noKunjungan'];
                        $no_sep = 'internal';
                        $dataRujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan($noRujukan));
                        if ($dataRujukan['metaData']['code'] != 200) {
                            $dataRujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan_rs($janji_poli->nomorreferensijkn));
                        }
                    }
                    if ($dataRujukan['metaData']['code'] != 200) {
                        $trans->rollback();
                        Yii::app()->user->setFlash('error', 'BPJS Error create SEP' . $dataRujukan['metaData']['code'] . ': ' . $dataRujukan['metaData']['message']);
                        $this->redirect(array('index'));
                    }
                    if ($dataRujukan['metaData']['code'] == 200) {
                        $modSep->jenisrujukan_kode = $dataRujukan['response']['asalFaskes'];
                        $modSep->jenisrujukan_nama = ($modSep->jenisrujukan_kode == 1) ? "PCare" : "Rumah Sakit";
                        $dataRujukan = $dataRujukan['response']['rujukan'];
                        $modSep->norujukan = $dataRujukan['noKunjungan'];
                        $janji_poli->nomorreferensijkn = $dataRujukan['noKunjungan'];
                        $poli_rujukan = $dataRujukan['poliRujukan']["kode"];
                        $kode_ppkrujukan = $dataRujukan['provPerujuk']['kode'];
                        $kode_pelayanan = $dataRujukan['pelayanan']['kode'];
                        $diagnosa = $dataRujukan['diagnosa']['kode'];
                        $nama_diagnosa = $dataRujukan['diagnosa']['nama'];
                        $tgl_rujukan = $dataRujukan['tglKunjungan'];
                        $modSep->tglrujukan = $tgl_rujukan;
                        $modSep->diagnosaawal = $diagnosa;
                        $modSep->nama_diagnosaawal = $nama_diagnosa;
                        $modSep->klsrawat = $dataRujukan['peserta']['hakKelas']['kode'];
                        $modSep->polirujukan = $dataRujukan['poliRujukan']["nama"];
                    }
                    // echo "<pre>";
                    // var_dump($noRujukan, $dataRujukan, $no_sep, $ruangan->kode_bpjs);
                    // die;

                    //rujukan internal
                    if ($no_sep == 'internal') {
                        $modSep->jenis_kunjungan = 0;
                        $modSep->asesmen_pelayanan = 1;
                        $kodeDpjp = "";
                        $modSep->dpjpygmelayani_kode = $pegawai->kodedokter_bpjs;

                        $kodebooking = $janji_poli->no_buatjanji;
                        $jenispasien = (($janji_poli->carabayar_id == Params::CARABAYAR_ID_BPJS) ? "JKN" : "NON JKN");
                        $nomorkartu = $janji_poli->no_kartu_bpjs;
                        $nik = $janji_poli->pasien->no_identitas_pasien;
                        $nohp = $janji_poli->pasien->no_mobile_pasien;
                        $keterangan_antrol = "Peserta harap 30 menit lebih awal guna pencatatan administrasi.";
                        $kodepoli = (!empty($janji_poli->ruangan) ? $janji_poli->ruangan->kode_bpjs : "");
                        $namapoli = (!empty($janji_poli->ruangan) ? $janji_poli->ruangan->ruangan_nama : "");
                        $pasienbaru = 0;
                        $norm = $janji_poli->pasien->no_rekam_medik;
                        $tanggalperiksa = date('Y-m-d');
                        $kodedokter = (!empty($janji_poli->pegawai) ? $janji_poli->pegawai->kodedokter_bpjs : "");
                        $namadokter = (!empty($janji_poli->pegawai) ? $janji_poli->pegawai->nama_pegawai : "");
                        $jampraktek = "";
                        $sisakuotajkn = 50;
                        $kuotajkn = 100;
                        $sisakuotanonjkn = 0;
                        $kuotanonjkn = 0;
                        $jadwaldokter = JadwaldokterM::model()->findByAttributes(array('pegawai_id' => $janji_poli->pegawai_id, 'jadwaldokter_tgl' => $tanggalperiksa));

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
                        if ($modSep->jenis_kunjungan == 0) {
                            $jeniskunjungan = 1;
                            $nomorreferensi = $modSep->norujukan;
                        } else if ($modSep->jenis_kunjungan == 2) {
                            $jeniskunjungan = 3;
                            $nomorreferensi = $noSurat;
                        } else {
                            $jeniskunjungan = 2;
                            $nomorreferensi = $modSep->norujukan;
                        }
                        $antrian =$janji_poli->no_buatjanji;
                        $nomorantrean = number_format($antrian);
                        $angkaantrean = number_format($antrian);
                        $estimasidilayani = $janji_poli->tglbuatjanji;
                        $stampwaktuantrian = strtotime($estimasidilayani);
                        $estimasidilayani = $stampwaktuantrian * 1000;

                        $bodytambah = array("kodebooking" => $kodebooking, "jenispasien" => $jenispasien, "nomorkartu" => $nomorkartu, "nik" => $nik, "nohp" => $nohp, "kodepoli" => $kodepoli, "namapoli" => $namapoli, "pasienbaru" => $pasienbaru, "norm" => $norm, "tanggalperiksa" => $tanggalperiksa, "kodedokter" => $kodedokter, "namadokter" => $namadokter, "jampraktek" => $jampraktek, "jeniskunjungan" => $jeniskunjungan, "nomorreferensi" => $nomorreferensi, "nomorantrean" => $nomorantrean, "angkaantrean" => $angkaantrean, "estimasidilayani" => $estimasidilayani, "sisakuotajkn" => $sisakuotajkn, "kuotajkn" => $kuotajkn, "sisakuotanonjkn" => $sisakuotanonjkn, "kuotanonjkn" => $kuotanonjkn, "keterangan" => $keterangan_antrol);
                        $antrianonlinebpjs = new AntrianOnlineBpjs();
                        $res_tambah = CJSON::decode($antrianonlinebpjs->tambah_antrian($bodytambah));

                        

                        $reqSep = json_decode($bpjs->create_sep_new2($janji_poli->no_kartu_bpjs, $tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $modSep->jenisrujukan_kode, $tgl_rujukan, $janji_poli->nomorreferensijkn, $kode_ppkrujukan, $modSep->catatansep, $diagnosa, $ruangan->kode_bpjs, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDpjp, $katarak, $modSep), true);

                        if ($reqSep['metaData']['code'] != 200) {
                            // echo "<pre>";
                            // var_dump($reqSep);die;
                            $modSep->jenis_kunjungan = 0;
                            $modSep->asesmen_pelayanan = 2;
                            $reqSep = json_decode($bpjs->create_sep_new2($janji_poli->no_kartu_bpjs, $tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $modSep->jenisrujukan_kode, $tgl_rujukan, $janji_poli->nomorreferensijkn, $kode_ppkrujukan, $modSep->catatansep, $diagnosa, $ruangan->kode_bpjs, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDpjp, $katarak, $modSep), true);

                            if ($reqSep['metaData']['code'] != 200) {
                                $modSep->jenis_kunjungan = 0;
                                $modSep->asesmen_pelayanan = 3;
                                $reqSep = json_decode($bpjs->create_sep_new2($janji_poli->no_kartu_bpjs, $tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $modSep->jenisrujukan_kode, $tgl_rujukan, $janji_poli->nomorreferensijkn, $kode_ppkrujukan, $modSep->catatansep, $diagnosa, $ruangan->kode_bpjs, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDpjp, $katarak, $modSep), true);

                                if ($reqSep['metaData']['code'] != 200) {
                                    $modSep->jenis_kunjungan = 0;
                                    $modSep->asesmen_pelayanan = "";
                                    $kodeDpjp = "";
                                    $modSep->dpjpygmelayani_kode = $pegawai->kodedokter_bpjs;
                                    $reqSep = json_decode($bpjs->create_sep_new2($janji_poli->no_kartu_bpjs, $tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $modSep->jenisrujukan_kode, $tgl_rujukan, $janji_poli->nomorreferensijkn, $kode_ppkrujukan, $modSep->catatansep, $diagnosa, $ruangan->kode_bpjs, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDpjp, $katarak, $modSep), true);

                                    if ($reqSep['metaData']['code'] != 200) {
                                        // echo "<pre>";
                                        // var_dump($reqSep);
                                        // die;
                                        $trans->rollback();
                                        Yii::app()->user->setFlash('error', 'BPJS Error create SEP' . $reqSep['metaData']['code'] . ': ' . $reqSep['metaData']['message']);
                                        $this->redirect(array('index'));
                                    }
                                }
                            }
                        }
                        $modSep->no_surat = Null;
                        $modSep->politujuan = $reqSep['response']['sep']['poli'];
                        // $modSep->polirujukan = $kode_ppkrujukan;
                    } else if ($no_sep == '') {
                        $modSep->jenis_kunjungan = 0;
                        $modSep->asesmen_pelayanan = "";
                        $kodeDpjp = "";
                        $modSep->dpjpygmelayani_kode = $pegawai->kodedokter_bpjs;

                        $kodebooking = $janji_poli->no_buatjanji;
                        $jenispasien = (($janji_poli->carabayar_id == Params::CARABAYAR_ID_BPJS) ? "JKN" : "NON JKN");
                        $nomorkartu = $janji_poli->no_kartu_bpjs;
                        $nik = $janji_poli->pasien->no_identitas_pasien;
                        $nohp = $janji_poli->pasien->no_mobile_pasien;
                        $keterangan_antrol = "Peserta harap 30 menit lebih awal guna pencatatan administrasi.";
                        $kodepoli = (!empty($janji_poli->ruangan) ? $janji_poli->ruangan->kode_bpjs : "");
                        $namapoli = (!empty($janji_poli->ruangan) ? $janji_poli->ruangan->ruangan_nama : "");
                        $pasienbaru = 0;
                        $norm = $janji_poli->pasien->no_rekam_medik;
                        $tanggalperiksa = date('Y-m-d');
                        $kodedokter = (!empty($janji_poli->pegawai) ? $janji_poli->pegawai->kodedokter_bpjs : "");
                        $namadokter = (!empty($janji_poli->pegawai) ? $janji_poli->pegawai->nama_pegawai : "");
                        $jampraktek = "";
                        $sisakuotajkn = 50;
                        $kuotajkn = 100;
                        $sisakuotanonjkn = 0;
                        $kuotanonjkn = 0;
                        $jadwaldokter = JadwaldokterM::model()->findByAttributes(array('pegawai_id' => $janji_poli->pegawai_id, 'jadwaldokter_tgl' => $tanggalperiksa));

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
                        if ($modSep->jenis_kunjungan == 0) {
                            $jeniskunjungan = 1;
                            $nomorreferensi = $modSep->norujukan;
                        } else if ($modSep->jenis_kunjungan == 2) {
                            $jeniskunjungan = 3;
                            $nomorreferensi = $noSurat;
                        } else {
                            $jeniskunjungan = 2;
                            $nomorreferensi = $modSep->norujukan;
                        }
                        $antrian = $janji_poli->no_buatjanji;
                        $nomorantrean = number_format($antrian);
                        $angkaantrean = number_format($antrian);
                        $estimasidilayani = $janji_poli->tglbuatjanji;
                        $stampwaktuantrian = strtotime($estimasidilayani);
                        $estimasidilayani = $stampwaktuantrian * 1000;

                        $bodytambah = array("kodebooking" => $kodebooking, "jenispasien" => $jenispasien, "nomorkartu" => $nomorkartu, "nik" => $nik, "nohp" => $nohp, "kodepoli" => $kodepoli, "namapoli" => $namapoli, "pasienbaru" => $pasienbaru, "norm" => $norm, "tanggalperiksa" => $tanggalperiksa, "kodedokter" => $kodedokter, "namadokter" => $namadokter, "jampraktek" => $jampraktek, "jeniskunjungan" => $jeniskunjungan, "nomorreferensi" => $nomorreferensi, "nomorantrean" => $nomorantrean, "angkaantrean" => $angkaantrean, "estimasidilayani" => $estimasidilayani, "sisakuotajkn" => $sisakuotajkn, "kuotajkn" => $kuotajkn, "sisakuotanonjkn" => $sisakuotanonjkn, "kuotanonjkn" => $kuotanonjkn, "keterangan" => $keterangan_antrol);
                        $antrianonlinebpjs = new AntrianOnlineBpjs();
                        $res_tambah = CJSON::decode($antrianonlinebpjs->tambah_antrian($bodytambah));


                        $reqSep = json_decode($bpjs->create_sep_new2($janji_poli->no_kartu_bpjs, $tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $modSep->jenisrujukan_kode, $tgl_rujukan, $janji_poli->nomorreferensijkn, $kode_ppkrujukan, $modSep->catatansep, $diagnosa, $ruangan->kode_bpjs, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDpjp, $katarak, $modSep), true);

                        if ($reqSep['metaData']['code'] != 200) {
                            $trans->rollback();
                            Yii::app()->user->setFlash('error', 'BPJS Error create SEP' . $reqSep['metaData']['code'] . ': ' . $reqSep['metaData']['message']);
                            $this->redirect(array('index'));
                        }
                        $modSep->no_surat = Null;
                        $modSep->politujuan = $reqSep['response']['sep']['poli'];
                        $modSep->polirujukan = Null;
                    } else {
                        //cari surat kontrol
                        $tglakhir = date("Y-m-d");
                        $hari_riwayat = 29;
                        $tglawal = date('Y-m-d', strtotime('-' . $hari_riwayat . ' days'));
                        $listSRK = CJSON::decode($bpjs->list_rencana_kontrol3($tglawal, $tglakhir, 2));
                        $listSurat = $listSRK['response']['list'];
                        // echo "<pre>";
                        // var_dump($listSurat);die;
                        foreach ($listSurat as $items) {
                            if ($ruangan->kode_bpjs == $items['poliTujuan'] && $janji_poli->no_kartu_bpjs == $items['noKartu']) {
                                $noSurat = $items['noSuratKontrol'];
                                $kodeDPJP = $items['kodeDokter'];
                                if ($items['terbitSEP'] == 'Sudah') {
                                    $reqKontrol = CJSON::decode($bpjs->create_rencana_kontrol($no_sep, $pegawai->kodedokter_bpjs, $ruangan->kode_bpjs, date('Y-m-d', strtotime($janji_poli->tgljadwal)), $user));
                                    if ($reqKontrol['metaData']['code'] == 200) {
                                        $noSurat = $reqKontrol['response']['noSuratKontrol'];
                                        $kodeDPJP = $pegawai->kodedokter_bpjs;
                                    } else {
                                        // echo "<pre>";
                                        // var_dump($reqKontrol);
                                        // die;
                                    }
                                }
                                break;
                            }
                        }
                        if ($noSurat == "" || $noSurat == NULL) {
                            $dataSep = CJSON::decode($bpjs->search_sep($no_sep));
                            $dataSep = $dataSep['response'];
                            $noSurat = $dataSep['dpjp']['kdDPJP'];
                            $kodeDPJP = $dataSep['kontrol']['noSurat'];
                        }
                        if ($noSurat == "" || $noSurat == NULL) {
                            $reqKontrol = CJSON::decode($bpjs->create_rencana_kontrol($no_sep, $pegawai->kodedokter_bpjs, $ruangan->kode_bpjs, date('Y-m-d', strtotime($janji_poli->tgljadwal)), $user));
                            if ($reqKontrol['metaData']['code'] == 200) {
                                $noSurat = $reqKontrol['response']['noSuratKontrol'];
                                $kodeDPJP = $pegawai->kodedokter_bpjs;
                            } else {
                                $noSurat = "";
                                // echo "<pre>";
                                // var_dump($reqKontrol);
                                // die;
                            }
                        } else {
                            $dataKontrol = CJSON::decode($bpjs->search_no_surat_kontrol($noSurat));
                            // echo "<pre>";
                            // var_dump($dataKontrol, $noSurat);
                            // die;
                            if ($dataKontrol['metaData']['code'] != 200) {
                                $reqKontrol = CJSON::decode($bpjs->create_rencana_kontrol($no_sep, $pegawai->kodedokter_bpjs, $ruangan->kode_bpjs, date('Y-m-d', strtotime($janji_poli->tgljadwal)), $user));
                                if ($reqKontrol['metaData']['code'] == 200) {
                                    $noSurat = $reqKontrol['response']['noSuratKontrol'];
                                    $kodeDPJP = $pegawai->kodedokter_bpjs;
                                } else {
                                    $noSurat = "";
                                    // echo "<pre>";
                                    // var_dump($reqKontrol);
                                    // die;
                                }
                            } else {
                                $noSurat = $noSurat;
                            }
                            // echo "<pre>";
                            // var_dump($dataKontrol, $noSurat);
                            // die;
                        }
                        if ($ruangan->kode_bpjs == 'IRM') {
                            if ($noSurat == "" || $noSurat == NULL) {
                                $modSep->jenis_kunjungan = 0;
                                $modSep->flag_procedure = "";
                                $modSep->kode_penunjang = "";
                                $modSep->asesmen_pelayanan = 1;
                                $modSep->dpjpygmelayani_kode = $dataSep['dpjp']['kdDPJP'];
                                $modSep->dpjpygmelayani_nama = $dataSep['dpjp']['nmDPJP'];
                                $reqSep = json_decode($bpjs->create_sep_new2($janji_poli->no_kartu_bpjs, $tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $modSep->jenisrujukan_kode, $tgl_rujukan, $janji_poli->nomorreferensijkn, $kode_ppkrujukan, $modSep->catatansep, $diagnosa, $ruangan->kode_bpjs, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDPJP, $katarak, $modSep), true);

                                $kodebooking = $janji_poli->no_buatjanji;
                                $jenispasien = (($janji_poli->carabayar_id == Params::CARABAYAR_ID_BPJS) ? "JKN" : "NON JKN");
                                $nomorkartu = $janji_poli->no_kartu_bpjs;
                                $nik = $janji_poli->pasien->no_identitas_pasien;
                                $nohp = $janji_poli->pasien->no_mobile_pasien;
                                $keterangan_antrol = "Peserta harap 30 menit lebih awal guna pencatatan administrasi.";
                                $kodepoli = (!empty($janji_poli->ruangan) ? $janji_poli->ruangan->kode_bpjs : "");
                                $namapoli = (!empty($janji_poli->ruangan) ? $janji_poli->ruangan->ruangan_nama : "");
                                $pasienbaru = 0;
                                $norm = $janji_poli->pasien->no_rekam_medik;
                                $tanggalperiksa = date('Y-m-d');
                                $kodedokter = (!empty($janji_poli->pegawai) ? $janji_poli->pegawai->kodedokter_bpjs : "");
                                $namadokter = (!empty($janji_poli->pegawai) ? $janji_poli->pegawai->nama_pegawai : "");
                                $jampraktek = "";
                                $sisakuotajkn = 50;
                                $kuotajkn = 100;
                                $sisakuotanonjkn = 0;
                                $kuotanonjkn = 0;
                                $jadwaldokter = JadwaldokterM::model()->findByAttributes(array('pegawai_id' => $janji_poli->pegawai_id, 'jadwaldokter_tgl' => $tanggalperiksa));

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
                                if ($modSep->jenis_kunjungan == 0) {
                                    $jeniskunjungan = 1;
                                    $nomorreferensi = $modSep->norujukan;
                                } else if ($modSep->jenis_kunjungan == 2) {
                                    $jeniskunjungan = 3;
                                    $nomorreferensi = $noSurat;
                                } else {
                                    $jeniskunjungan = 2;
                                    $nomorreferensi = $modSep->norujukan;
                                }
                                $antrian = $janji_poli->no_buatjanji;
                                $nomorantrean = number_format($antrian);
                                $angkaantrean = number_format($antrian);
                                $estimasidilayani = $janji_poli->tglbuatjanji;
                                $stampwaktuantrian = strtotime($estimasidilayani);
                                $estimasidilayani = $stampwaktuantrian * 1000;

                                $bodytambah = array("kodebooking" => $kodebooking, "jenispasien" => $jenispasien, "nomorkartu" => $nomorkartu, "nik" => $nik, "nohp" => $nohp, "kodepoli" => $kodepoli, "namapoli" => $namapoli, "pasienbaru" => $pasienbaru, "norm" => $norm, "tanggalperiksa" => $tanggalperiksa, "kodedokter" => $kodedokter, "namadokter" => $namadokter, "jampraktek" => $jampraktek, "jeniskunjungan" => $jeniskunjungan, "nomorreferensi" => $nomorreferensi, "nomorantrean" => $nomorantrean, "angkaantrean" => $angkaantrean, "estimasidilayani" => $estimasidilayani, "sisakuotajkn" => $sisakuotajkn, "kuotajkn" => $kuotajkn, "sisakuotanonjkn" => $sisakuotanonjkn, "kuotanonjkn" => $kuotanonjkn, "keterangan" => $keterangan_antrol);
                                $antrianonlinebpjs = new AntrianOnlineBpjs();
                                $res_tambah = CJSON::decode($antrianonlinebpjs->tambah_antrian($bodytambah));

                                if ($reqSep['metaData']['code'] != 200) {
                                    // echo "<pre>";
                                    // var_dump($reqSep);
                                    // die;
                                    $trans->rollback();
                                    Yii::app()->user->setFlash('error', 'BPJS Error create SEP' . $reqSep['metaData']['code'] . ': ' . $reqSep['metaData']['message']);
                                    $this->redirect(array('index'));
                                }
                                $modSep->politujuan = $reqSep['response']['sep']['poli'];
                            } else {
                                $modSep->jenis_kunjungan = 1;
                                $modSep->flag_procedure = 1;
                                $modSep->kode_penunjang = 3;
                                $modSep->asesmen_pelayanan = "";
                                $modSep->dpjpygmelayani_kode = $kodeDPJP;

                                $kodebooking = $janji_poli->no_buatjanji;
                                $jenispasien = (($janji_poli->carabayar_id == Params::CARABAYAR_ID_BPJS) ? "JKN" : "NON JKN");
                                $nomorkartu = $janji_poli->no_kartu_bpjs;
                                $nik = $janji_poli->pasien->no_identitas_pasien;
                                $nohp = $janji_poli->pasien->no_mobile_pasien;
                                $keterangan_antrol = "Peserta harap 30 menit lebih awal guna pencatatan administrasi.";
                                $kodepoli = (!empty($janji_poli->ruangan) ? $janji_poli->ruangan->kode_bpjs : "");
                                $namapoli = (!empty($janji_poli->ruangan) ? $janji_poli->ruangan->ruangan_nama : "");
                                $pasienbaru = 0;
                                $norm = $janji_poli->pasien->no_rekam_medik;
                                $tanggalperiksa = date('Y-m-d');
                                $kodedokter = (!empty($janji_poli->pegawai) ? $janji_poli->pegawai->kodedokter_bpjs : "");
                                $namadokter = (!empty($janji_poli->pegawai) ? $janji_poli->pegawai->nama_pegawai : "");
                                $jampraktek = "";
                                $sisakuotajkn = 50;
                                $kuotajkn = 100;
                                $sisakuotanonjkn = 0;
                                $kuotanonjkn = 0;
                                $jadwaldokter = JadwaldokterM::model()->findByAttributes(array('pegawai_id' => $janji_poli->pegawai_id, 'jadwaldokter_tgl' => $tanggalperiksa));

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
                                if ($modSep->jenis_kunjungan == 0) {
                                    $jeniskunjungan = 1;
                                    $nomorreferensi = $modSep->norujukan;
                                } else if ($modSep->jenis_kunjungan == 2) {
                                    $jeniskunjungan = 3;
                                    $nomorreferensi = $noSurat;
                                } else {
                                    $jeniskunjungan = 2;
                                    $nomorreferensi = $modSep->norujukan;
                                }
                                $antrian = $janji_poli->no_buatjanji;
                                $nomorantrean = number_format($antrian);
                                $angkaantrean = number_format($antrian);
                                $estimasidilayani = $janji_poli->tglbuatjanji;
                                $stampwaktuantrian = strtotime($estimasidilayani);
                                $estimasidilayani = $stampwaktuantrian * 1000;

                                $bodytambah = array("kodebooking" => $kodebooking, "jenispasien" => $jenispasien, "nomorkartu" => $nomorkartu, "nik" => $nik, "nohp" => $nohp, "kodepoli" => $kodepoli, "namapoli" => $namapoli, "pasienbaru" => $pasienbaru, "norm" => $norm, "tanggalperiksa" => $tanggalperiksa, "kodedokter" => $kodedokter, "namadokter" => $namadokter, "jampraktek" => $jampraktek, "jeniskunjungan" => $jeniskunjungan, "nomorreferensi" => $nomorreferensi, "nomorantrean" => $nomorantrean, "angkaantrean" => $angkaantrean, "estimasidilayani" => $estimasidilayani, "sisakuotajkn" => $sisakuotajkn, "kuotajkn" => $kuotajkn, "sisakuotanonjkn" => $sisakuotanonjkn, "kuotanonjkn" => $kuotanonjkn, "keterangan" => $keterangan_antrol);
                                $antrianonlinebpjs = new AntrianOnlineBpjs();
                                $res_tambah = CJSON::decode($antrianonlinebpjs->tambah_antrian($bodytambah));


                                $reqSep = json_decode($bpjs->create_sep_new2($janji_poli->no_kartu_bpjs, $tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $modSep->jenisrujukan_kode, $tgl_rujukan, $janji_poli->nomorreferensijkn, $kode_ppkrujukan, $modSep->catatansep, $diagnosa, $ruangan->kode_bpjs, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDPJP, $katarak, $modSep), true);

                                if ($reqSep['metaData']['code'] != 200) {
                                    // echo "<pre>";
                                    // var_dump($reqSep);
                                    // die;
                                    $trans->rollback();
                                    Yii::app()->user->setFlash('error', 'BPJS Error create SEP' . $reqSep['metaData']['code'] . ': ' . $reqSep['metaData']['message']);
                                    $this->redirect(array('index'));
                                }

                                $modSep->no_surat = $noSurat;
                                $modSep->politujuan = $reqSep['response']['sep']['poli'];
                            }
                        } else {
                            if ($noSurat == "" || $noSurat == NULL) {
                                $modSep->jenis_kunjungan = 0;
                                $modSep->asesmen_pelayanan = 1;
                                $kodeDpjp = "";
                                $modSep->dpjpygmelayani_kode = $pegawai->kodedokter_bpjs;

                                $reqSep = json_decode($bpjs->create_sep_new2($janji_poli->no_kartu_bpjs, $tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $modSep->jenisrujukan_kode, $tgl_rujukan, $janji_poli->nomorreferensijkn, $kode_ppkrujukan, $modSep->catatansep, $diagnosa, $ruangan->kode_bpjs, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDpjp, $katarak, $modSep), true);

                                if ($reqSep['metaData']['code'] != 200) {
                                    $modSep->jenis_kunjungan = 0;
                                    $modSep->asesmen_pelayanan = 2;
                                    $reqSep = json_decode($bpjs->create_sep_new2($janji_poli->no_kartu_bpjs, $tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $modSep->jenisrujukan_kode, $tgl_rujukan, $janji_poli->nomorreferensijkn, $kode_ppkrujukan, $modSep->catatansep, $diagnosa, $ruangan->kode_bpjs, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDpjp, $katarak, $modSep), true);

                                    if ($reqSep['metaData']['code'] != 200) {
                                        $modSep->jenis_kunjungan = 0;
                                        $modSep->asesmen_pelayanan = 3;
                                        $reqSep = json_decode($bpjs->create_sep_new2($janji_poli->no_kartu_bpjs, $tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $modSep->jenisrujukan_kode, $tgl_rujukan, $janji_poli->nomorreferensijkn, $kode_ppkrujukan, $modSep->catatansep, $diagnosa, $ruangan->kode_bpjs, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDpjp, $katarak, $modSep), true);

                                        if ($reqSep['metaData']['code'] != 200) {
                                            $modSep->jenis_kunjungan = 0;
                                            $modSep->asesmen_pelayanan = "";
                                            $kodeDpjp = "";
                                            $modSep->dpjpygmelayani_kode = $pegawai->kodedokter_bpjs;
                                            $reqSep = json_decode($bpjs->create_sep_new2($janji_poli->no_kartu_bpjs, $tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $modSep->jenisrujukan_kode, $tgl_rujukan, $janji_poli->nomorreferensijkn, $kode_ppkrujukan, $modSep->catatansep, $diagnosa, $ruangan->kode_bpjs, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDpjp, $katarak, $modSep), true);

                                            if ($reqSep['metaData']['code'] != 200) {
                                                // echo "<pre>";
                                                // var_dump($reqSep);
                                                // die;
                                                $trans->rollback();
                                                Yii::app()->user->setFlash('error', 'BPJS Error create SEP' . $reqSep['metaData']['code'] . ': ' . $reqSep['metaData']['message']);
                                                $this->redirect(array('index'));
                                            }
                                        }
                                    }
                                }
                                $modSep->no_surat = Null;
                                $modSep->politujuan = $reqSep['response']['sep']['poli'];
                                // $modSep->polirujukan = $kode_ppkrujukan;
                            } else {
                                $modSep->jenis_kunjungan = '2';
                                $modSep->asesmen_pelayanan = '5';
                                $modSep->dpjpygmelayani_kode = $pegawai->kodedokter_bpjs;

                                $kodebooking = $janji_poli->no_buatjanji;
                                $jenispasien = (($janji_poli->carabayar_id == Params::CARABAYAR_ID_BPJS) ? "JKN" : "NON JKN");
                                $nomorkartu = $janji_poli->no_kartu_bpjs;
                                $nik = $janji_poli->pasien->no_identitas_pasien;
                                $nohp = $janji_poli->pasien->no_mobile_pasien;
                                $keterangan_antrol = "Peserta harap 30 menit lebih awal guna pencatatan administrasi.";
                                $kodepoli = (!empty($janji_poli->ruangan) ? $janji_poli->ruangan->kode_bpjs : "");
                                $namapoli = (!empty($janji_poli->ruangan) ? $janji_poli->ruangan->ruangan_nama : "");
                                $pasienbaru = 0;
                                $norm = $janji_poli->pasien->no_rekam_medik;
                                $tanggalperiksa = date('Y-m-d');
                                $kodedokter = (!empty($janji_poli->pegawai) ? $janji_poli->pegawai->kodedokter_bpjs : "");
                                $namadokter = (!empty($janji_poli->pegawai) ? $janji_poli->pegawai->nama_pegawai : "");
                                $jampraktek = "";
                                $sisakuotajkn = 50;
                                $kuotajkn = 100;
                                $sisakuotanonjkn = 0;
                                $kuotanonjkn = 0;
                                $jadwaldokter = JadwaldokterM::model()->findByAttributes(array('pegawai_id' => $janji_poli->pegawai_id, 'jadwaldokter_tgl' => $tanggalperiksa));

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
                                if ($modSep->jenis_kunjungan == 0) {
                                    $jeniskunjungan = 1;
                                    $nomorreferensi = $modSep->norujukan;
                                } else if ($modSep->jenis_kunjungan == 2) {
                                    $jeniskunjungan = 3;
                                    $nomorreferensi = $noSurat;
                                } else {
                                    $jeniskunjungan = 2;
                                    $nomorreferensi = $modSep->norujukan;
                                }
                                $antrian = $janji_poli->no_buatjanji;
                                $nomorantrean = number_format($antrian);
                                $angkaantrean = number_format($antrian);
                                $estimasidilayani = $janji_poli->tglbuatjanji;
                                $stampwaktuantrian = strtotime($estimasidilayani);
                                $estimasidilayani = $stampwaktuantrian * 1000;

                                $bodytambah = array("kodebooking" => $kodebooking, "jenispasien" => $jenispasien, "nomorkartu" => $nomorkartu, "nik" => $nik, "nohp" => $nohp, "kodepoli" => $kodepoli, "namapoli" => $namapoli, "pasienbaru" => $pasienbaru, "norm" => $norm, "tanggalperiksa" => $tanggalperiksa, "kodedokter" => $kodedokter, "namadokter" => $namadokter, "jampraktek" => $jampraktek, "jeniskunjungan" => $jeniskunjungan, "nomorreferensi" => $nomorreferensi, "nomorantrean" => $nomorantrean, "angkaantrean" => $angkaantrean, "estimasidilayani" => $estimasidilayani, "sisakuotajkn" => $sisakuotajkn, "kuotajkn" => $kuotajkn, "sisakuotanonjkn" => $sisakuotanonjkn, "kuotanonjkn" => $kuotanonjkn, "keterangan" => $keterangan_antrol);
                                $antrianonlinebpjs = new AntrianOnlineBpjs();
                                $res_tambah = CJSON::decode($antrianonlinebpjs->tambah_antrian($bodytambah));


                                $reqSep = json_decode($bpjs->create_sep_new2($janji_poli->no_kartu_bpjs, $tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $modSep->jenisrujukan_kode, $tgl_rujukan, $janji_poli->nomorreferensijkn, $kode_ppkrujukan, $modSep->catatansep, $diagnosa, $ruangan->kode_bpjs, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDPJP, $katarak, $modSep), true);

                                if ($reqSep['metaData']['code'] != 200) {
                                    // echo "<pre>";
                                    // var_dump($reqSep);
                                    // die;
                                    $noSurat = "";
                                    $modSep->jenis_kunjungan = 0;
                                    $modSep->asesmen_pelayanan = 1;
                                    $kodeDpjp = "";
                                    $modSep->dpjpygmelayani_kode = $pegawai->kodedokter_bpjs;

                                    $reqSep = json_decode($bpjs->create_sep_new2($janji_poli->no_kartu_bpjs, $tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $modSep->jenisrujukan_kode, $tgl_rujukan, $janji_poli->nomorreferensijkn, $kode_ppkrujukan, $modSep->catatansep, $diagnosa, $ruangan->kode_bpjs, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDpjp, $katarak, $modSep), true);

                                    if ($reqSep['metaData']['code'] != 200) {
                                        $modSep->jenis_kunjungan = 0;
                                        $modSep->asesmen_pelayanan = 2;
                                        $reqSep = json_decode($bpjs->create_sep_new2($janji_poli->no_kartu_bpjs, $tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $modSep->jenisrujukan_kode, $tgl_rujukan, $janji_poli->nomorreferensijkn, $kode_ppkrujukan, $modSep->catatansep, $diagnosa, $ruangan->kode_bpjs, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDpjp, $katarak, $modSep), true);

                                        if ($reqSep['metaData']['code'] != 200) {
                                            $modSep->jenis_kunjungan = 0;
                                            $modSep->asesmen_pelayanan = 3;
                                            $reqSep = json_decode($bpjs->create_sep_new2($janji_poli->no_kartu_bpjs, $tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $modSep->jenisrujukan_kode, $tgl_rujukan, $janji_poli->nomorreferensijkn, $kode_ppkrujukan, $modSep->catatansep, $diagnosa, $ruangan->kode_bpjs, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDpjp, $katarak, $modSep), true);

                                            if ($reqSep['metaData']['code'] != 200) {
                                                // echo "<pre>";
                                                // var_dump($reqSep);
                                                // die;
                                                $modSep->jenis_kunjungan = 0;
                                                $modSep->asesmen_pelayanan = "";
                                                $kodeDpjp = "";
                                                $modSep->dpjpygmelayani_kode = $pegawai->kodedokter_bpjs;
                                                $reqSep = json_decode($bpjs->create_sep_new2($janji_poli->no_kartu_bpjs, $tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $modSep->jenisrujukan_kode, $tgl_rujukan, $janji_poli->nomorreferensijkn, $kode_ppkrujukan, $modSep->catatansep, $diagnosa, $ruangan->kode_bpjs, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDpjp, $katarak, $modSep), true);

                                                if ($reqSep['metaData']['code'] != 200) {
                                                    // echo "<pre>";
                                                    // var_dump($reqSep);
                                                    // die;
                                                    $trans->rollback();
                                                    Yii::app()->user->setFlash('error', 'BPJS Error create SEP' . $reqSep['metaData']['code'] . ': ' . $reqSep['metaData']['message']);
                                                    $this->redirect(array('index'));
                                                }
                                            }
                                        }
                                    }
                                    $modSep->no_surat = Null;
                                    $modSep->politujuan = $reqSep['response']['sep']['poli'];
                                }
                            }

                            $modSep->no_surat = $noSurat;
                            $modSep->politujuan = $reqSep['response']['sep']['poli'];
                        }
                    }
                }
                if (isset($reqSep['metaData']['code']) && !empty($reqSep['metaData']['code'])) {
                    if ($reqSep['metaData']['code'] == 200) {
                        $modSep->nosep = $reqSep['response']['sep']['noSep'];
                        $modSep->politujuan = $reqSep['response']['sep']['poli'];
                        $modSep->json_response = CJSON::encode($reqSep);
                        if (empty($modSep->norujukan))
                            $modSep->norujukan = "-";
                        if (empty($modSep->diagnosaawal))
                            $modSep->diagnosaawal = "-";

                        $modAsuransiPasien->bpjs_pesertadinsos = $reqSep['response']['sep']['informasi']['dinsos'];
                        $modAsuransiPasien->bpjs_prolanisprb = $reqSep['response']['sep']['informasi']['prolanisPRB'];
                        $modAsuransiPasien->bpjs_nosktm = $reqSep['response']['sep']['informasi']['noSKTM'];
                        $modAsuransiPasien->jenispeserta_bpjs = $reqSep['response']['sep']['peserta']['jnsPeserta'];
                        $modAsuransiPasien->save();

                        if ($reqSep['response']['sep']['informasi']['prolanisPRB'] == NULL) {
                            $modSep->is_prolanisprb = False;
                        } else {
                            $modSep->is_prolanisprb = True;
                        }
                        $modSep->programprb_kode = $reqSep['response']['sep']['informasi']['prolanisPRB'];
                        $modSep->programprb_nama = $reqSep['response']['sep']['informasi']['prolanisPRB'];


                        if ($modSep->save()) {
                            $res = Yii::app()->db->createCommand("select ins_buatjanjipolitopendaftaran_dari_id(" . $janji_poli->buatjanjipoli_id . ", " . $modSep->sep_id . ") as res")->queryRow();
                            if (!$janji_poli->is_checkin) {
                                $janji_poli->is_checkin = true;
                                $janji_poli->waktucheckin = date('Y-m-d H:i:s');

                                $janji_poli->save(false, array('is_checkin', 'waktucheckin'));
                            }

                            $modPendaftaran = PendaftaranT::model()->findByAttributes(array('sep_id' => $modSep->sep_id));
                            $trans->commit();
                            $this->tambahAntrian($modPendaftaran, $modSep->sep_id);
                            $this->logBpjs($janji_poli, $reqSep);
                            Yii::app()->user->setFlash('success', 'SEP Berhasil dibuat');
                            $this->redirect(array('/antrian/AmbilTiket/IndexUmumAsuransiNew', 'sep_id' => $modSep->sep_id, 'pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'sukses' => 1, 'buatjanjipoli_id' => $janji_poli->buatjanjipoli_id));
                        } else {
                            // var_dump($modSep->getErrors());
                            die;
                            $trans->rollback();
                            $this->logBpjs($janji_poli, $reqSep);
                            $this->redirect(array('index'));
                        }
                    } else {
                        $trans->rollback();
                        $this->logBpjs($janji_poli, $reqSep);
                        Yii::app()->user->setFlash('error', 'BPJS Error ' . $reqSep['metaData']['code'] . ': ' . $reqSep['metaData']['message']);
                        $this->redirect(array('index'));
                    }
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', 'Terjadi kesalahan ketika pembuatan SEP.');
                    $this->redirect(array('index'));
                    // $this->logBpjs($model, $reqSep);
                }
                }
                
            } catch (Exception $e) {
                var_dump($e->getMessage());die;
                $trans->rollback();
                Yii::app()->user->setFlash('error', $e->getMessage());
                $this->redirect(array('index'));
            }
        }

        $this->render('index', array(
            'modSep' => $modSep,
            'modAsuransiPasien' => $modAsuransiPasien,
            'model' => $model,
            'modPasien' => $modPasien,
            'modRujukanBpjs' => $modRujukanBpjs,
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

        $modSep = SepT::model()->findByPk($sep_id);

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
            $res_tambah = CJSON::decode($antrianonlinebpjs->tambah_antrian($tambahattr_antrianol));
            if ($res_tambah['metaData']['code'] == 200) {
                PendaftaranT::model()->updateByPk($model->pendaftaran_id, array('statuskirim_wsbpjs' => true));
            } else {
                PendaftaranT::model()->updateByPk($model->pendaftaran_id, array('statuskirim_wsbpjs' => false, 'respons_wsbpjs' => (!empty($res_tambah['metaData']['message']) ? $res_tambah['metaData']['message'] : null)));
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
            $status = 0;
            if (!empty($response['metaData']['message'])) {
                $pesan = $response['metaData']['message'];
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
            $status = 0;
            if (!empty($response['metaData']['code'])) {
                $pesan = $response['metaData']['message'];
            }
        }

        $resp['status'] = $status;
        $resp['pesan'] = $pesan;
        return $resp;
    }

    public function actionSukses($sep_id)
    {
        $modSep = PPSepT::model()->findByPk($sep_id);

        $this->render('sukses', array(
            'modSep' => $modSep,
        ));
    }

    public function actionPrintSep($sep_id)
    {
        $this->pageTitle = Yii::app()->name . " - Cetak Surat Eligibilitas Peserta";
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modRujukanBpjs = new ARRujukanbpjsT;
        $modSep = ARSepT::model()->findByPk($sep_id);
        if (isset($modSep->print_ke) && !empty($modSep->print_ke)) {
            $modSep->print_ke++;
            ARSepT::model()->updateByPk($modSep->sep_id, array('print_ke' => $modSep->print_ke));
            // $modSep->update(array('print_ke'));
        } else {
            $modSep->print_ke = 1;
            ARSepT::model()->updateByPk($modSep->sep_id, array('print_ke' => $modSep->print_ke));
            // $modSep->update(array('print_ke'));
        }

        $modAsuransiPasienBpjs = ARAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta' => $modSep->nokartuasuransi), array('order' => 'asuransipasien_id DESC'));
        $modJenisPeserta = ARJenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
        if (isset($modSep->norujukan)) {
            $modRujukanBpjs = ARRujukanbpjsT::model()->findByAttributes(array('no_rujukan' => $modSep->norujukan));
        }
        $modAdmisi = PasienadmisiT::model()->findByAttributes(array('sep_id' => $modSep->sep_id));
        if (!empty($modAdmisi)) {
            $modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $modAdmisi->pendaftaran_id));
        } else {
            $modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('sep_id' => $modSep->sep_id));
        }
        // $modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('sep_id' => $modSep->sep_id));        
        $modPasien = ARPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modRujukan = RujukanT::model()->findByPk($modPendaftaran->rujukan_id);
        // $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        // var_dump($modPendaftaran->carabayar_id)
        // $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modAsuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
        $modPenanggungjawab = PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
        $modPegawai = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);

        $bpjs = new BpjsVklaim;
        $data_sep = CJSON::decode($bpjs->search_sep($modSep->nosep));
        if ($data_sep['metaData']['code'] == 200) {
            $data_sep = $data_sep['response'];
        }
        $data_rujukan = json_decode($bpjs->search_rujukan_no_rujukan($modSep->norujukan));
        if ($data_rujukan->metaData->code != 200) {
            $data_rujukan = json_decode($bpjs->search_rujukan_no_rujukan_rs($modSep->norujukan));
        }
        $data_rujukan = $data_rujukan->response;
        if ($modSep->politujuan != $data_sep['poli']) {
            SepT::model()->updateByPk($sep_id, array('politujuan' => $data_sep['poli'], 'polirujukan' => $data_rujukan->rujukan->poliRujukan->nama));
        }
        //cari nopeserta 
        $dataPeserta = CJSON::decode($bpjs->search_kartu($modSep->nokartuasuransi));
        $dataPeserta = $dataPeserta['response']['peserta'];
        if ($dataPeserta['informasi']['prolanisPRB'] != NULL || $dataPeserta['informasi']['prolanisPRB'] != "") {
            $modSep->is_prolanisprb = True;
        } else {
            $modSep->is_prolanisprb = False;
        }
        $modSep->programprb_kode = $dataPeserta['informasi']['prolanisPRB'];
        $modSep->programprb_nama = $dataPeserta['informasi']['prolanisPRB'];
        SepT::model()->updateByPk($sep_id, array('programprb_kode' => $modSep->programprb_kode, 'programprb_nama' => $modSep->programprb_nama, 'is_prolanisprb' => $modSep->is_prolanisprb));

        $judul_print = 'SURAT ELIGIBILITAS PESERTA';
        $this->render('printSep', array(
            //$this->render('pendaftaranPenjadwalan.views.pendaftaranRawatJalan.printSep_baru2', array(
            'format' => $format,
            'modSep' => $modSep,
            'judul_print' => $judul_print,
            'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
            'modRujukanBpjs' => $modRujukanBpjs,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modJenisPeserta' => $modJenisPeserta,
            'modRujukan' => $modRujukan,
            'modAsuransi' => $modAsuransi,
            'modPenanggungjawab' => $modPenanggungjawab,
            'modPegawai' => $modPegawai,
            'data_sep' => $data_sep,
            'data_rujukan' => $data_rujukan,
        ));
    }
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
            $this->renderPartial('printLabel', array(
                'modPendaftaran' => $modPendaftaran,
            ), true)
        );
        //                $mpdf->SetJS('this.print();');
        $mpdf->Output();
    }

    function logBpjs($model, $reqSep)
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
        $log->pendaftaran_id = $model->pendaftaran_id;
        $log->save();
    }

    public function actionGetPasienDariNomorPesertaNIK()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        //search in buatjanjipoli_t
        $nomor = $_POST['nomor'];
        $crJanji = new CDbCriteria;
        $crJanji->join = "left join penjaminpasien_m p on p.penjamin_id = t.penjamin_id";
        $crJanji->join = "left join pasien_m n on n.pasien_id = t.pasien_id";
        $crJanji->addCondition("(t.no_buatjanji = '" . $nomor . "' or t.no_kartu_bpjs = '" . $nomor . "' or n.no_rekam_medik = '" . $nomor . "' or n.no_identitas_pasien = '" . $nomor . "')");
        $crJanji->addCondition("t.tgljadwal::date = current_date");
        $crJanji->order = "buatjanjipoli_id desc";
        $janjipoli = BuatjanjipoliT::model()->find($crJanji);
        $nama_pasien = "";
        $no_Mr = "";

        $bpjs = new BpjsVklaim();
        $dataPasien = CJSON::decode($bpjs->search_kartu($nomor));
        // var_dump($dataPasien);die;
        if (isset($dataPasien['metaData']) && $dataPasien['metaData']['code'] == 200) {
            $nama_pasien = $dataPasien['response']['peserta']['nama'];
            $no_Mr = $dataPasien['response']['peserta']['mr']['noMR'];
            // var_dump('as');die;
        }
        if (empty($janjipoli)) {
            // var_dump('as2');die;

            echo CJSON::encode(array(
                'isRm' => 0,
                'ok' => 0,
                'nama' => $nama_pasien,
                'rm' => $no_Mr,
            ));
            Yii::app()->end();
        }
        $res_data = array();

        $modRuangan = RuanganM::model()->findByPk($janjipoli->ruangan_id);
        $pasien = PasienM::model()->findByPk($janjipoli->pasien_id);
        $res_data['no_kartu_bpjs'] = $janjipoli->no_kartu_bpjs;
        $res_data['janjipoli'] =  $janjipoli->attributes;
        $res_data['pendaftaran']['kode_ruangan_bpjs'] = !empty($modRuangan->kode_bpjs) ? $modRuangan->kode_bpjs : null;
        $res_data['pendaftaran']['dokter'] = $janjipoli->pegawai->namaLengkap;
        $res_data['pendaftaran']['ruangan'] = $janjipoli->ruangan->ruangan_nama;
        $res_data['is_janjipoli'] = empty($janjipoli) ? 0 : 1;
        // $res_data['janjipoli'] = empty($res_janjipoli) ? null : $res_janjipoli;

        $res_data['pasien'] = $pasien->attributes;

        $res_data['ok'] = 1;
        $res_data['msg'] = "OK";
        // echo '<pre>';
        // var_dump($res_data['msg']);die;
        echo CJSON::encode($res_data);
    }

    public function actionUpdateNoBpjsAjax()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {


            $nomor = $_POST['nomor'];
            $nomor_rm = $_POST['nomor_rm'];


            $modPasien = PasienM::model()->findByAttributes(array('no_rekam_medik' => $nomor_rm));
            if (!empty($modPasien)) {
                $crJanji = new CDbCriteria;
                $crJanji->join = "left join penjaminpasien_m p on p.penjamin_id = t.penjamin_id";
                $crJanji->join = "left join pasien_m n on n.pasien_id = t.pasien_id";
                $crJanji->addCondition("(n.no_rekam_medik = '" . $nomor_rm . "')");
                // $crJanji->addCondition('t.is_checkin is null');

                $crJanji->order = "buatjanjipoli_id desc";
                $crJanji->limit = 1;
                $modJanjiPoli = BuatjanjipoliT::model()->find($crJanji);
                // $modJanjiPoli = BuatjanjipoliT::model()->findByAttributes(array('pasien_id' => $modPasien->pasien_id));
                $modJanjiPoli->no_kartu_bpjs = $nomor;
                $modJanjiPoli->save();
            }
            echo CJSON::encode(array(
                'status' => 'ok'
            ));
            Yii::app()->end();
        }
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

                    $res_all = array(
                        'metaData' => array(
                            'code' => 200,
                            'message' => 'OK',
                        ),
                        "response" => null,
                    );

                    if (empty($res['metaData']['code']) || $res['metaData']['code'] != 200) {
                        $res = CJSON::decode($bpjs->search_rujukan_no_rujukan_rs($query));

                        $res_all['metaData'] = $res['metaData'];

                        if (empty($res['metaData']['code']) || $res['metaData']['code'] != 200) {
                            $res_all['metaData'] = $res['metaData'];
                        } else {
                            $res_all['metaData'] = $res['metaData'];
                            $res_all['response'] = $res['response'];
                        }
                    } else {
                        $res_all['metaData'] = $res['metaData'];
                        $res_all['response'] = $res['response'];

                        if (!empty($res_all['response']['rujukan']['tglKunjungan'])) {
                            $res_all['response']['rujukan']['tglKunjungan'] = MyFormatter::formatDateTimeForUser($res_all['response']['rujukan']['tglKunjungan']);
                        }
                    }


                    print_r(CJSON::encode($res_all));
                    break;
                case '4':
                    //                        $query = $_GET['query'];
                    //                        print_r( $bpjs->search_rujukan_no_bpjs($query) );
                    $query = $_GET['query'];
                    $tgl = isset($_GET['tgl']) ? MyFormatter::formatDateTimeForDb($_GET['tgl']) : null;
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
                        print_r($bpjs->search_kartu($query, $tgl));
                    }
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
                    $tglrujukan = isset($_GET['tgl_rujukan']) ? MyFormatter::formatDateTimeForDb($_GET['tgl_rujukan']) : null;
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
                    // $ppkpelayanan = $_GET['ppkrujukan'];
                    // $start = $_GET['start'];
                    // $limit = $_GET['limit'];
                    // print_r( $bpjs->detail_ppk_rujukan($ppkpelayanan, $start, $limit) );
                    print_r($bpjs->fasilitas_kesehatan($query, $start, $limit));
                    break;
                case '13':
                    $query = $_GET['query'];

                    $res = CJSON::decode($bpjs->search_rujukan_pcare_multi($query));
                    $res2 = CJSON::decode($bpjs->search_rujukan_rs_multi($query));

                    $res_data = array();

                    $res_all = array(
                        'metaData' => array(
                            'code' => 200,
                            'message' => 'OK',
                        ),
                        "response" => array(
                            'rujukan' => array(),
                        ),
                    );

                    if ($res['metaData']['code'] == 200) {
                        foreach ($res['response']['rujukan'] as $item) {
                            $item['asalFaskes'] = 1;
                            $res_data[] = $item;
                        }
                    }

                    if ($res2['metaData']['code'] == 200) {
                        foreach ($res2['response']['rujukan'] as $item) {
                            $item['asalFaskes'] = 2;
                            $res_data[] = $item;
                        }
                    }

                    if (count($res_data) == 0) {
                        $res_all['metaData']['code'] = 201;
                        $res_all['metaData']['message'] = "Rujukan Tidak Ada";
                    } else {
                        $res_all["response"]["rujukan"] = $res_data;
                    }

                    print_r(json_encode($res_all));
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
                    $query = $query1 . "/tglPelayanan/" . $query2 . "/Spesialis/" . $query3;
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

                            $tgl_rencana = $json['response']['tglRencanaKontrol'];

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
                                $('#dialogDpjpMelayani').dialog('close'); \">
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

    public function actionTandaTangan()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $ok = 1;
            $msg = '';
            $no_surat = !empty($_POST['no_surat']) ? $_POST['no_surat'] : null;

            $this->layout = '//layouts/iframe';
            $format = new MyFormatter();
            $modSep = new PPSepT;

            echo CJSON::encode(array(
                'ok' => $ok,
                'msg' => $msg,
                'content' => $this->renderPartial('_tandatangan', array(
                    'no_surat' => $no_surat,
                    'modSep' => $modSep,
                ), true)
            ));
            Yii::app()->end();
        }
    }

    public function actionGetDataLabel()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        $res_data = array();

        $id = $_POST['id'];
        $modPendaftaran = PendaftaranT::model()->findByPk($id);
        $res_data['no_urut'] = $modPendaftaran->ruangan->ruangan_singkatan . '-' . $modPendaftaran->no_urutantri;
        $res_data['no_reg'] = $modPendaftaran->no_pendaftaran;
        $res_data['nik'] = $modPendaftaran->pasien->no_rekam_medik;
        $res_data['nama']  = $modPendaftaran->pasien->nama_pasien;
        $res_data['mr'] = $modPendaftaran->pasien->no_rekam_medik . ' TL : ' . date('d/m/Y', strtotime($modPendaftaran->pasien->tanggal_lahir)) . ' ' . $modPendaftaran->umur;
        $res_data['poli'] = $modPendaftaran->ruangan->ruangan_nama;
        $res_data['dr'] = $modPendaftaran->pegawai->namaLengkap;
        $res_data['pnj'] = $modPendaftaran->penjamin->penjamin_nama;
        $res_data['nama_printer'] = 'STIKER1';

        echo CJSON::encode($res_data);
    }

    public function actionSimpanImage()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $image_text = isset($_POST['image_text']) ? $_POST['image_text'] : null;
            $no_surat = isset($_POST['no_surat']) ? $_POST['no_surat'] : null;

            $modSep = new SepT();
            $modSep->ttd_text = $image_text;
            $modSep->ttd_link = $no_surat . '_' . date('YmdHis');

            $row = $this->renderPartial('_rowImage', array('modSep' => $modSep), true);


            $data['pesan'] = '';
            $data['html'] = $row;

            echo json_encode($data);


            Yii::app()->end();
        }
    }
}
