<?php

Yii::import("pendaftaranPenjadwalan.models.*");

class DaftarBPJSMandiriController extends Controller {

    public $layout = '//layouts/kiosAntrian';

    public function actionIndex() {

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

            $modSep->jenisrujukan_kode = (isset($_POST['PPSepT']['jenisfaskes']) ? $_POST['PPSepT']['jenisfaskes'] : 2);
            $modSep->jenisrujukan_nama = ($modSep->jenisrujukan_kode == 1) ? "PCare" : "Rumah Sakit";

            if (isset($_POST['PPRujukanbpjsT'])) {
                $modSep->tglrujukan = empty($_POST['PPRujukanbpjsT']['tanggal_rujukan']) ? null : MyFormatter::formatDateTimeForDB($_POST['PPRujukanbpjsT']['tanggal_rujukan']);
                $modSep->norujukan = empty($_POST['PPRujukanbpjsT']['no_rujukan']) ? null : $_POST['PPRujukanbpjsT']['no_rujukan'];
            }

            $data_pasien = null;
            $data_rujukan = null;
            $penjamin = null;
            if (isset($_POST['data_pasien'])) {
                $data_pasien = CJSON::decode($_POST['data_pasien']);
                // var_dump($data_pasien); die;
                $modSep->klsrawat = $data_pasien['bpjs']['peserta']['hakKelas']['kode'];
                $modPasien = PPPasienM::model()->findByPk($data_pasien['pasien']['pasien_id']);
                $penjamin = $data_pasien['pendaftaran']['penjamin_id'];
                $model = PPPendaftaranT::model()->findByPk($data_pasien['pendaftaran']['pendaftaran_id']);
                //modAsuransiPasienBpjs

            }
            $modSep->tglpulang = date('Y-m-d H:i:s');
            $modSep->create_time = date('Y-m-d H:i:s');
            $modSep->create_loginpemakai_id = 1;
            $modSep->create_ruangan = 1;


            if (isset($_POST['data_rujukan'])) {
                $data_rujukan = CJSON::decode($_POST['data_rujukan']);
                // echo '<pre>';
                // var_dump($data_rujukan, $_POST); die;
                if(!empty($data_rujukan)) {
                    $modSep->diagnosaawal = $data_rujukan['rujukan']['diagnosa']['kode'];
                    $modSep->nama_diagnosaawal = $data_rujukan['rujukan']['diagnosa']['nama'];
                }
            }

            $lakalantas = 0;
            $asalRujukan = $modSep->jenisrujukan_kode;
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
            $noSurat = $modSep->no_surat;
            $kodeDPJP = $modSep->kode_dpjp;
            $katarak = 0;

            try {

                $bpjs = new BpjsVklaim;

                if (!empty($noSurat)) {
                    $res_kontrol = CJSON::decode($bpjs->search_no_surat_kontrol($noSurat));
                    if (!empty($res_kontrol['response']) && $res_kontrol['response']['jnsKontrol'] == 2) {
                        $tgl_kontrol = $res_kontrol['response']['tglRencanaKontrol'];

                        $selisih = (strtotime($tgl_kontrol) - strtotime($modSep->tglsep)) / (24 * 3600);

                        // var_dump($res_kontrol); die;

                        if ($selisih > 0) {
                            throw new CException("Tanggal tidak sesuai dengan Tanggal Rencana Kontrol");
                        } else if ($selisih < 0) {
                            if (abs($selisih) <= 7) {
                                $tgl_update = date('Y-m-d');

                                $noSep = $res_kontrol['response']['sep']['noSep'];
                                $kode_dokter = $res_kontrol['response']['kodeDokter'];
                                $poli_kontrol = $res_kontrol['response']['poliTujuan'];
                                $user = "sysadmin";

                                // var_dump($noSurat, $noSep, $kode_dokter, $poli_kontrol, $tgl_update, $user);

                                $res_update = CJSON::decode($bpjs->update_rencana_kontrol($noSurat, $noSep, $kode_dokter, $poli_kontrol, $tgl_update, $user));

                                if (empty($res_update['response'])) {
                                    throw new CException($res_update['metaData']['code']." - ".$res_update['metaData']['message']);
                                }
                            } else {
                                throw new CException("Surat Kontrol sudah melewati rencana kontrol lebih dari 7 hari.");
                            }

                            // var_dump($res_update); die;
                        }
                    }


                    // var_dump($res_kontrol);
                }
                // die;

            


                $reqSep = json_decode($bpjs->create_sep_new($modSep->nokartuasuransi, $modSep->tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $asalRujukan, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDPJP, $katarak, $modSep), true);
                // var_dump($reqSep); die;
                if (isset($reqSep['metaData']['code']) && !empty($reqSep['metaData']['code'])) {
                    if ($reqSep['metaData']['code'] == 200) {
                        // var_dump($reqSep); die;
                        $modSep->nosep = $reqSep['response']['sep']['noSep'];
                        $modSep->polirujukan = $reqSep['response']['sep']['poli'];
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

                        $name = date('YmdHis') . '_' . $modSep->nosep;
                        $file = '';
                        if(count($_POST['SepT']) > 0){
                            foreach ($_POST['SepT'] as $key => $img) {
                                if (!file_exists(Params::pathSignSepDirectory())){
                                    mkdir(Params::pathSignSepDirectory(),0775,true);
                                }
                                $image_text = str_replace('data:image/png;base64,', '', $img['ttd_text']);
                                $image_text = str_replace(' ', '+', $image_text);
                                $image_text = base64_decode($image_text);
                                $file = Params::pathSignSepDirectory() . $name . '.png';
                                $success = file_put_contents($file, $image_text);
                                $source_img = imagecreatefromstring($image_text);
                                $modSep->ttd_link = $name . '.png';
                    
                                imagedestroy($source_img);
                            }
                        }

                        if ($modSep->save()) {
                            $img_arr = array();
                            // $this->septersimpan = true;
                            PendaftaranT::model()->updateByPk($model->pendaftaran_id, array(
                                'sep_id'=>$modSep->sep_id,
                            ));
                            $trans->commit();
                            $this->logBpjs($model, $reqSep);
                            Yii::app()->user->setFlash('success', 'SEP Berhasil dibuat');
                            $this->redirect(array('sukses', 'sep_id'=>$modSep->sep_id));
                        } else {
                            $trans->rollback();
                            $this->logBpjs($model, $reqSep);
                            $this->redirect(array('index'));
                        }
                    } else {
                        $trans->rollback();
                        $this->logBpjs($model, $reqSep);
                        Yii::app()->user->setFlash('error', 'BPJS Error ' . $reqSep['metaData']['code'] . ': ' . $reqSep['metaData']['message']);
                        $this->redirect(array('index'));
                    }
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', 'Terjadi kesalahan ketika pembuatan SEP.');
                    $this->redirect(array('index'));
                    // $this->logBpjs($model, $reqSep);
                }
            } catch (Exception $e) {
                $trans->rollback(); // var_dump($e->getMessage()); die;
                Yii::app()->user->setFlash('error', $e->getMessage());
                $this->redirect(array('index'));
            }


            // var_dump($modSep->attributes, $data_pasien, $data_rujukan, $_POST); die;
        }

        $this->render('index', array(
            'modSep'=>$modSep,
            'modAsuransiPasien'=>$modAsuransiPasien,
            'model'=>$model,
            'modPasien'=>$modPasien,
            'modRujukanBpjs'=>$modRujukanBpjs,
        ));
    }

    public function actionSukses($sep_id) {
        $modSep = PPSepT::model()->findByPk($sep_id);

        $this->render('sukses', array(
            'modSep'=>$modSep,
        ));
    }

    public function actionPrintSep($sep_id) {
        $this->pageTitle = Yii::app()->name . " - Cetak Surat Eligibilitas Peserta";
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modRujukanBpjs = new ARRujukanbpjsT;
        $modSep = ARSepT::model()->findByPk($sep_id);
        if (isset($modSep->print_ke) && !empty($modSep->print_ke)) {
            $modSep->print_ke++;
            ARSepT::model()->updateByPk($modSep->sep_id, array('print_ke'=>$modSep->print_ke));
            // $modSep->update(array('print_ke'));
        } else {
            $modSep->print_ke = 1;
            ARSepT::model()->updateByPk($modSep->sep_id, array('print_ke'=>$modSep->print_ke));
            // $modSep->update(array('print_ke'));
        }

        $modAsuransiPasienBpjs = ARAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta' => $modSep->nokartuasuransi),array('order'=>'asuransipasien_id DESC'));
        $modJenisPeserta = ARJenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
        if (isset($modSep->norujukan)) {
            $modRujukanBpjs = ARRujukanbpjsT::model()->findByAttributes(array('no_rujukan' => $modSep->norujukan));
        }
        $modAdmisi = PasienadmisiT::model()->findByAttributes(array('sep_id' => $modSep->sep_id));
            
        if(!empty($modAdmisi)){
            $modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $modAdmisi->pendaftaran_id));
        }else{
            $modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('sep_id' => $modSep->sep_id));
        }
        // $modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('sep_id' => $modSep->sep_id));        
        $modPasien = ARPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modRujukan = RujukanT::model()->findByPk($modPendaftaran->rujukan_id);
        
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
        ));
    }

    function logBpjs($model, $reqSep) {
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

    public function actionGetPasienDariNomorPesertaNIK() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $asuransi = null;
        $pasien = null;
        $janjipoli = null;

        $nomor = trim($_POST['nomor']);
        // load janji poli

        $crJanji = new CDbCriteria;
        $crJanji->join = "left join penjaminpasien_m p on p.penjamin_id = t.penjamin_id";
        $crJanji->join = "left join pasien_m n on n.pasien_id = t.pasien_id";
        $crJanji->addCondition("(t.no_buatjanji = '" . $nomor . "' or t.no_kartu_bpjs = '" . $nomor . "' or n.no_rekam_medik = '" . $nomor . "' or n.no_identitas_pasien = '" . $nomor . "' or n.no_mobile_pasien= '" . $nomor . "')");
        // $crJanji->addCondition("(t.no_buatjanji = '".$nomor."' or t.no_kartu_bpjs = '".$nomor."') and (p.carabayar_id = ".Params::CARABAYAR_ID_BPJS." or t.carabayar_id = ".Params::CARABAYAR_ID_BPJS.")");
        $crJanji->addCondition("t.tgljadwal::date <= current_date");
        $crJanji->order = "tgljadwal desc, buatjanjipoli_id desc";


        $janjipoli = BuatjanjipoliT::model()->find($crJanji);

        if (empty($janjipoli)) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Data Tidak Ditemukan dari tabel buatjanjipoli_t. [123]',
            ));
            Yii::app()->end();
        }

        if (!empty($janjipoli)) {

            // var_dump($janjipoli->attributes); die;

            $pasien = PasienM::model()->findByPk($janjipoli->pasien_id);

            $pendaftaran = null;

            if (!$janjipoli->is_checkin) {
                $janjipoli->is_checkin = true;
                $janjipoli->waktucheckin = date('Y-m-d H:i:s');
                $janjipoli->save(false, array('is_checkin', 'waktucheckin'));
            }

            if (!empty($janjipoli->pendaftaran_id)) {
                $pendaftaran = PendaftaranT::model()->findByPk($janjipoli->pendaftaran_id);
            } else {
                $res = Yii::app()->db->createCommand("select ins_buatjanjipolitopendaftaran_dari_id(".$janjipoli->buatjanjipoli_id.") as res")->queryRow();

                // reload janjipoli
                $janjipoli = BuatjanjipoliT::model()->findByPk($janjipoli->buatjanjipoli_id);

                if (!empty($janjipoli->pendaftaran_id)) {
                    $pendaftaran = PendaftaranT::model()->findByPk($janjipoli->pendaftaran_id);
                }
            }

            /*
            $pendaftaran = PendaftaranT::model()->findByAttributes(array(
                'pasien_id'=>$pasien->pasien_id,
                'carabayar_id'=>Params::CARABAYAR_ID_BPJS,
                'instalasi_id'=>Params::INSTALASI_ID_RJ,
            ), array(
                'condition'=>'asuransipasien_id is not null',
                'order'=>'pendaftaran_id desc',
            ));
            */

            if (empty($pendaftaran)) {
                echo CJSON::encode(array(
                    'ok'=>0,
                    'msg'=>'Data Tidak Ditemukan dari pendaftaran_t. [211]',
                ));
                Yii::app()->end();
            }

            $asuransi = AsuransipasienM::model()->findByPk($pendaftaran->asuransipasien_id);

        }


        if (empty($asuransi)) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Data asuransi Tidak Ditemukan dari asuransipasien_m. [3]',
            ));
            Yii::app()->end();
        }

        


        $bpjs = new BpjsVklaim;
        $res = CJSON::decode($bpjs->search_kartu($asuransi->nokartuasuransi));

        if ($res["metaData"]["code"] != 200) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Error '.$res["metaData"]["code"]." - ".["metaData"]["message"],
            ));
            Yii::app()->end();
        }

        // var_dump($janjipoli->attributes); die;

        // load janji poli
        $res_rujukan = null;
        $is_normal = 0;
        $referensi_sep = null;
        $referensi_kontrol = null;
        $konfig = KonfigsystemK::model()->find();
        $ref_kontrol = null;
        $is_jkn = 0;

        if (!empty($janjipoli) && !empty($janjipoli->nomorreferensijkn)) {

            $no_rujukan = $janjipoli->nomorreferensijkn;
            $no_kontrol = null;

            if ($janjipoli->jenisreferensi == 3) {
                $ref_kontrol = CJSON::decode($bpjs->search_no_surat_kontrol($janjipoli->nomorreferensijkn));

                if (!empty($ref_kontrol['response'])) {
                    $no_rujukan = $ref_kontrol['response']['sep']['provPerujuk']['noRujukan'];
                    $no_kontrol = $janjipoli->nomorreferensijkn;
                    $janjipoli->nomorreferensijkn = $no_rujukan;
                } else {
                    echo CJSON::encode(array(
                        'ok'=>0,
                        'msg'=>'Error '.$res["metaData"]["code"]." - ".["metaData"]["message"]." Nomor : ".$janjipoli->nomorreferensijkn,
                    ));
                    Yii::app()->end();
                }

                // var_dump($ref_kontrol); die;
            }

            // die;
            


            $hari_riwayat = $konfig->bpjs_riwayatsep_hari ?? 90;

            $period = new DatePeriod(
                new DateTime(date('Y-m-d', strtotime('-'.$hari_riwayat.' days'))),
                new DateInterval('P5D'),
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

                // $res_temp = CJSON::decode($bpjs->search_monitoring_historipelayanan($asuransi->nokartuasuransi, $tgl_histori[$idx + 1], $tgl_histori[$idx]));
                // if (!empty($res_temp['response']['histori'])) {
                //     $res_histori = array_merge($res_histori, $res_temp['response']['histori']);
                    

                    $res_temp = CJSON::decode($bpjs->search_monitoring_historipelayanan($janjipoli->no_kartu_bpjs, $tgl_histori[$idx + 1], $tgl_histori[$idx]));	
                    // var_dump($res_temp);	
                    if (!empty($res_temp['response']['histori'])) {	
                        foreach ($res_temp['response']['histori'] as $item_detail) {	
                            $res_histori[$item_detail['noSep']] = $item_detail;	
                        }	
                        // var_dump($res_temp['response']['histori']);	
                        // $res_histori = array_merge($res_histori, $res_temp['response']['histori']);

                }
            }
            krsort($res_histori);
            // var_dump($res_histori); die;

            // $res_riwayat = CJSON::decode($bpjs->search_monitoring_historipelayanan($asuransi->nokartuasuransi, date('Y-m-d', strtotime('-3 months')), date('Y-m-d')));
            
            $ref_data = array();

            $ruangan_daftar = RuanganM::model()->findByPk($pendaftaran->ruangan_id);
            $res_rujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan($no_rujukan));
            if ($res_rujukan["metaData"]["code"] != 200) {
                $res_rujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan_rs($no_rujukan));
            }
            if (($janjipoli->keteranganbuatjanji == "Pendaftaran via Mobile JKN" && $janjipoli->jenisreferensi == 1)) {	
                $is_jkn = 1;	
            } else {

            // var_dump($janjipoli->nomorreferensijkn); die;
            // if (!empty($res_riwayat['response']['histori'])) {
                foreach ($res_histori as $item_sep) {
                    // var_dump($item_sep);
                    if ($item_sep['noRujukan'] == $no_rujukan) {

                        $poli_kode = CJSON::decode($bpjs->search_poli(str_replace(" ", "%20", $item_sep['poli'])));
                        $nama_poli_kode = "";

                        // vaR_dump($poli_kode); 

                        if (!empty($poli_kode['response']['poli'])) {
                            foreach ($poli_kode['response']['poli'] as $item_poli) {
                                // var_dump($item_poli);
                                if ($item_poli['nama'] == $item_sep['poli']) {
                                    $nama_poli_kode = $item_poli['kode'];
                                }
                            }
                        }

                        // var_dump("R ".$res_rujukan['response']['rujukan']['poliRujukan']['kode'], "P ".$item_sep['poli'], "K ".$nama_poli_kode);

                        if (!empty($res_rujukan['response']['rujukan']['poliRujukan']['kode'])
                        && !empty($poli_kode['response']['poli'][0]['nama']) 
                        && $res_rujukan['response']['rujukan']['poliRujukan']['kode'] == $nama_poli_kode) {
                            $is_normal = 1;
                            $arr_diag = !empty($item_sep['diagnosa']) ? explode(" ", $item_sep['diagnosa']) : array();
                            $referensi_sep = array(
                                'tglSep'=>$item_sep['tglSep'],
                                'noSep'=>$item_sep['noSep'],
                                'noRujukan'=>$item_sep['noRujukan'],
                                'poli'=>$item_sep['poli'],
                                'diagnosa'=>empty($arr_diag[0]) ? "" : $arr_diag[0],
                            );
                        } else if ($ruangan_daftar->kode_bpjs == $nama_poli_kode) {
                            $is_normal = 2;
                            $arr_diag = !empty($item_sep['diagnosa']) ? explode(" ", $item_sep['diagnosa']) : array();
                            $referensi_sep = array(
                                'tglSep'=>$item_sep['tglSep'],
                                'noSep'=>$item_sep['noSep'],
                                'noRujukan'=>$item_sep['noRujukan'],
                                'poli'=>$item_sep['poli'],
                                'diagnosa'=>empty($arr_diag[0]) ? "" : $arr_diag[0],
                            );
                        }
                    }
                }
            }
            // }
            // die;
            // surat kontrol

            
            // var_dump($res_kontrol); die;

            //$res_riwayat = CJSON::decode($bpjs->search_kartu($asuransi->nokartuasuransi));
        }

        if ($is_normal != 0) {

            if (!empty($ref_kontrol['response'])) {
                $referensi_kontrol = $ref_kontrol['response'];
            } else {
                $res_kontrol = CJSON::decode($bpjs->list_rencana_kontrol2(date('m'), date('Y'), $asuransi->nokartuasuransi, 2));
                
                if (!empty($res_kontrol['response']['list']) && !empty($res_rujukan['response'])) {
                    foreach($res_kontrol['response']['list'] as $item) {
                        if ($ruangan_daftar->kode_bpjs == $item['poliTujuan']) {	
                            $referensi_kontrol = $item;	
                        } else if ($res_rujukan['response']['rujukan']['poliRujukan']['kode'] == $item['poliTujuan']) {
                            
                            $referensi_kontrol = $item;
                        }
                    }
                } // else {
                ///    if (!empty($res_kontrol['response']['list'][0])) {
                //        $referensi_kontrol = $res_kontrol['response']['list'][0];
                //    }
                //}

            }


        }

        $ruangan_rujukan = !empty($res_rujukan['response']['rujukan']['poliRujukan']['kode']) 
            ? $res_rujukan['response']['rujukan']['poliRujukan']['kode']
            : $ruangan_daftar->kode_bpjs;
        $diag_rujukan = !empty($res_rujukan['response']['rujukan']['diagnosa']['kode'])
            ? $res_rujukan['response']['rujukan']['diagnosa']['kode']
            : "";

        if (empty($res_rujukan['response']['rujukan']['poliRujukan']['kode']) || $res_rujukan['response']['rujukan']['poliRujukan']['kode'] != $ruangan_daftar->kode_bpjs) {
            $is_normal = 0;
            $referensi_kontrol = null; 
        }

        if (empty($referensi_sep)) {
            $referensi_sep = array(
                'tglSep'=>null,
                'noSep'=>null,
                'noRujukan'=>$no_rujukan,
                'poli'=>$ruangan_rujukan,
                'diagnosa'=>$diag_rujukan,
            );
        }

        // var_dump($referensi_sep); die;

        $res_janjipoli = $janjipoli->attributes;
        if (!empty($janjipoli->pegawai_id)) {
            $peg_janji = PegawaiM::model()->findByPk($janjipoli->pegawai_id);
            $res_janjipoli['nama_pegawai'] = empty($peg_janji) ? "" : $peg_janji->namaLengkap;
            $res_janjipoli['kode_dokter'] = empty($peg_janji) ? "" : $peg_janji->kodedokter_bpjs;
        }




        $res_data = array();
        $res_data['asuransi'] = $asuransi->attributes;
        $res_data['pasien'] = $pasien->attributes;
        $res_data['bpjs'] = $res['response'];
        $res_data['pendaftaran'] = $pendaftaran->attributes;
        $res_data['pendaftaran']['kode_ruangan_bpjs'] = $pendaftaran->ruangan->kode_bpjs;
        $res_data['pendaftaran']['dokter'] = $pendaftaran->pegawai->namaLengkap;
        $res_data['pendaftaran']['ruangan'] = $pendaftaran->ruangan->ruangan_nama;
        $res_data['is_janjipoli'] = empty($janjipoli) ? 0 : 1;
        $res_data['is_janjipolinormal'] = $is_normal;
        $res_data['is_janjipoliref'] = $referensi_sep;
        $res_data['is_janjipolikontrol'] = $referensi_kontrol;
        $res_data['janjipoli'] = empty($res_janjipoli) ? null : $res_janjipoli;
        $res_data['is_jkn'] = $is_jkn;

        


        $res_data['ok'] = 1;
        $res_data['msg'] = "OK";

        echo CJSON::encode($res_data);
        

        // load asuransi, jika tidak ditemukan maka load pasien
        
    }


    /**
     * set bpjs Interface
     */
    public function actionBpjsInterface() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            if (empty($_GET['param']) OR $_GET['param'] === '') {
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
    public function actionSetFormDokterMelayani() {
        if (Yii::app()->request->isAjaxRequest) {
            $dokterList = $_POST['diagnosaList'];
            $form = '';
            $pesan = '';
            if (count($dokterList) > 0) {
                foreach ($dokterList AS $i => $dokter) {
                    $kode = $dokter['kode'];
                    $nama = $dokter['nama'];
                    $mod = PegawaiM::model()->findByAttributes(array(
                        'kodedokter_bpjs'=>$kode,
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

    public function actionTandaTangan() {
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
            ), true)));
            Yii::app()->end();
        }
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

?>