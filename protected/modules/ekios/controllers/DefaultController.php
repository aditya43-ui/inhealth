<?php

class DefaultController extends Controller
{

    public $layout = '//layouts/kiosAntrian';

    public function actionIndex()
    {
        $this->layout = '//layouts/kiosAntrian';



        $this->render('index');
    }
    public function actionBooking()
    {
        $this->layout = '//layouts/kiosAntrian';
        $carabayar = CarabayarM::model()->findAllByAttributes(array('carabayar_aktif' => True));
        // echo "<pre>";
        // var_dump($carabayar);die;

        //$model = new PasienM();
        //$model->unsetAttributes();

        // $prov = $model->searchDashboardStatus();
        // $prov->pagination = false;

        $data = array();
        // foreach ($prov->data as $item) {
        //     $pasien_id = $item->pasien_id;

        //     $racikan = RacikanM::model()->findByPk($item->racikan_id);

        //     if (!empty($pasien_id)){
        //         $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['nama_pasien'] = $item->nama_pasien;
        //         $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['no_rekam_medik'] = $item->no_rekam_medik;
        //         $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['tanggal_lahir'] = $item->tanggal_lahir;
        //         $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['obatalkes_nama'] = $item->obatalkes_nama;
        //         $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['racikan_nama'] = $racikan->racikan_nama;
        //         //$data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['qty_oa'] = $item->qty_oa;
        //         //$data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['signa_oa'] = $item->signa_oa;
        //         $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['statusobat'] = $item->statusobat;

        //         if (empty($data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['obat'])) {
        //             $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['obat'] = array();   
        //         }

        //         $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['obat'][] = array(
        //             'obatalkes_id'=>$item->obatalkes_id,
        //             'obatalkes_nama'=>$item->obatalkes_nama,
        //             'qty_oa'=>$item->qty_oa,
        //             'signa_oa'=>$item->signa_oa,
        //             'statusobat'=>$item->statusobat,
        //         );
        //     }
        //}
        $format = new MyFormatter;

        $modPPBuatJanjiPoli = new PPBuatJanjiPoliT;
        $modPasien = new PPPasienM;
        $modPasien->isPasienLama = false;
        $modPasien->agama = Params::DEFAULT_AGAMA;
        $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;

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

        if (!empty($id)) {
            $modPPBuatJanjiPoli = PPBuatJanjiPoliT::model()->findByPk($id);
            if (!empty($modPPBuatJanjiPoli)) {
                $modPasien = PPPasienM::model()->findByPk($modPPBuatJanjiPoli->pasien_id);
            } else {
                $modPasien = new PPPasienM;
            }
        }


        if (isset($_POST['PPBuatJanjiPoliT'])) {

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modPPBuatJanjiPoli->attributes = $_POST['PPBuatJanjiPoliT'];
                $modPPBuatJanjiPoli->tglbuatjanji = date('Y-m-d H:i:s');
                $modPPBuatJanjiPoli->tgljadwal = $format->formatDateTimeForDb($_POST['PPBuatJanjiPoliT']['tgljadwal']);
                $modPPBuatJanjiPoli->create_time = date('Y-m-d H:i:s');
                $modPPBuatJanjiPoli->update_time = date('Y-m-d H:i:s');
                $modPPBuatJanjiPoli->update_loginpemakai_id = Yii::app()->user->id;
                $modPPBuatJanjiPoli->create_loginpemakai_id = Yii::app()->user->id;
                $modPPBuatJanjiPoli->create_ruangan = Yii::app()->user->getState('ruangan_id');

                // if (!isset($_POST['isPasienLama'])) {   //Jika Pasiennya Lama
                //     $modPasien = $this->savePasien($_POST['PPPasienM']);
                //     $modPPBuatJanjiPoli->pasien_id = $modPasien->pasien_id;
                // } else {
                //     $modPPBuatJanjiPoli->no_rekam_medik = $_POST['no_rekam_medik'];
                //     $modPasien = PPPasienM::model()->findByAttributes(array('no_rekam_medik' => $_POST['no_rekam_medik']));
                //     $modPPBuatJanjiPoli->pasien_id = $modPasien->pasien_id;
                // }

                if ($modPPBuatJanjiPoli->validate()) {
                    $modPPBuatJanjiPoli->save();

                    // SMS GATEWAY
                    $modPegawai = $modPPBuatJanjiPoli->pegawai;
                    $modRuangan = $modPPBuatJanjiPoli->ruangan;
                    $modPasien = $modPPBuatJanjiPoli->pasien;
                    $sms = new Sms();
                    $smspasien = 1;
                    $smsdokter = 1;
                    foreach ($modSmsgateway as $i => $smsgateway) {
                        $isiPesan = $smsgateway->templatesms;

                        $attributes = $modPasien->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modPPBuatJanjiPoli->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modPegawai->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modRuangan->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);

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
                        }
                    }
                    // END SMS GATEWAY

                    //Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data Pasien Dan Janji Kunjungan berhasil disimpan.');

                    $transaction->commit();
                    $this->redirect(array('index', 'id' => $modPPBuatJanjiPoli->buatjanjipoli_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter));
                    $modPPBuatJanjiPoli->isNewRecord = FALSE;
                } else {
                    die();
                    $transaction->rollback();

                    Yii::app()->user->setFlash('error', 'Data Gagal disimpan ');
                }
            } catch (Exception $exc) {
                var_dump($exc->getMessage());
                die();
                $transaction->rollback();
                Yii::app()->user->setFlash('error', 'Data Gagal disimpan' . MyExceptionMessage::getMessage($exc, true) . '');
            }
        }


        $this->render('booking', array('model' => $modPPBuatJanjiPoli, 'modPasien' => $modPasien, 'carabayar' => $carabayar));
    }
    public function actionValidasiUtama()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $norekam = $_POST['id'];
            // if (!empty($_POST['tgllahir'])) {
            //     $tgllahir = $_POST['tgllahir'];
            //     $tgllahirdb = $format->formatDateTimeForDb($tgllahir);
            //     $tgl = $tgllahirdb;
            // }
            // if (!empty($_POST['tglrekammedik'])) {
            //     $tglrekammedik = $_POST['tglrekammedik'];
            //     $tglrekammedikdb = $format->formatDateTimeForDb($tglrekammedik);
            //     $tgl = $tglrekammedikdb;
            // }
           
            $criteria1 = new CDbCriteria();
          
            //$criteria->addCondition(" modul_id = '".Yii::app()->user->getState('modul_id')."' ");
            if (!empty($norekam)) {
                $criteria1->join = "left join asuransipasien_m a on a.pasien_id = t.pasien_id";
                $criteria1->addCondition("t.no_rekam_medik ='" . $norekam . "'or a.nokartuasuransi='". $norekam."'or t.no_identitas_pasien ='" . $norekam . "'");
                $criteria1->limit = 1;
                // if (!empty($_POST['tgllahir'])) {
                //     $criteria1->addCondition("tanggal_lahir ='" . $tgl . "'");
                // }
                // if (!empty($_POST['tglrekammedik'])) {
                //     $criteria1->addCondition("tgl_rekam_medik ='" . $tgl . "'");
                // }
                $models = PasienM::model()->findAll($criteria1);
                // var_dump($models);die;
                // var_dump($models);die;
                $hitung = PasienM::model()->count($criteria1);


                if (!empty($models)) {
                    foreach ($models as $i => $model) {
                        //                        $modtempatkerja = new TempatbekerjaM();
                   
                        $pendaftaran = EKPendaftaranT::model()->findByAttributes(array("pasien_id" => $model->pasien_id), array("order" => 'pendaftaran_id DESC'));
                        $returnVal["nama_pasien"] = $model->nama_pasien;
                        $returnVal["jeniskelamin"] = $model->jeniskelamin;
                        $returnVal["tanggal_lahir"] = MyFormatter::formatDateTimeForUser($model->tanggal_lahir);
                        $returnVal["umur"] = CustomFunction::getUmur($model->tanggal_lahir);
                        $returnVal["no_mobile_pasien"] = $model->no_mobile_pasien;
                        $returnVal["no_telepon_pasien"] = $model->no_telepon_pasien;
                        $returnVal["alamatemail"] = $model->alamatemail;
                        $returnVal["alamatemail"] = $model->alamatemail;
                        $returnVal["propinsi_id"] = $model->propinsi_id;
                        $returnVal["kabupaten_id"] = $model->kabupaten_id;
                        $returnVal["kecamatan_id"] = $model->kecamatan_id;
                        $returnVal["kelurahan_id"] = $model->kelurahan_id;
                        $returnVal["agama"] = $model->agama;
                        $returnVal["no_rekam_medik"] = $model->no_rekam_medik;
                        $returnVal["tgl_rekam_medik"] = MyFormatter::formatDateTimeForUser($model->tgl_rekam_medik);
                        $returnVal["alamat_pasien"] = $model->alamat_pasien;
                       
                        // $returnVal["pendaftaran_id"] = $pendaftaran->pendaftaran_id;
                        $returnVal["golongandarah"] = $model->golongandarah;
                        
                        $returnVal["status"] = true;
                        
                        $returnVal["tempatbekerja_id"] = "";
                        $returnVal["tempatbekerja_nama"] = "";
                       
                        //                        if (!empty($model->tempatbekerja_id)) {
                        //                            $modtempatkerja = TempatbekerjaM::model()->findByPk($model->tempatbekerja_id);
                        //                            $returnVal["tempatbekerja_id"] = $modtempatkerja->tempatbekerja_id;
                        //                            $returnVal["tempatbekerja_nama"] = $modtempatkerja->tempatbekerja_nama;
                        //                        }
                        $returnVal["pasien_id"] = $model->pasien_id;
                        //var_dump($returnVal);
                    }
                } else {
                    $returnVal["status"] = false;
                }
                echo CJSON::encode($returnVal);
            }
        }
        Yii::app()->end();
    }
    public function actionCreate($buatjanjipoli_id = null)
    {
        $this->layout = '//layouts/kiosAntrian';
        $this->pageTitle = Yii::app()->name . " - Pembuatan Janji Poliklinik";
        $model = new PPBuatJanjiPoliT;
        $modPasien = new PPPasienM;
        $modPegawai = new PPPegawaiM;

        $model->jamjadwal = date('H:i:00');
        $carabayar = CarabayarM::model()->findAllByAttributes(array('carabayar_aktif' => True));
        
        if (isset($buatjanjipoli_id)) {
            $model = $this->loadModel($buatjanjipoli_id);
            $model->pegawai_id = $model->pegawai_id;
            $modPasien = PPPasienM::model()->findByPk($model->pasien_id);
            $modPegawai = PPPegawaiM::model()->findByPk($modPasien->pegawai_id);

            $arr_jadwal = array(date('Y-m-d', strtotime($model->tgljadwal)), date('H:i', strtotime($model->tgljadwal)));
            $model->tgljadwal = $arr_jadwal;
            // var_dump($model->attributes); die;
        } else {
            $jadwalKosong = array('', '');
            $model->tgljadwal = $jadwalKosong;
        }


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

        $format = new MyFormatter;
        if (isset($_POST['PPBuatJanjiPoliT'])) {
       
            $transaction = Yii::app()->db->beginTransaction();
            // var_dump($_POST);die;
            // die;
            try {
                $model = new PPBuatJanjiPoliT;
                $model->attributes = $_POST['PPBuatJanjiPoliT'];
                $model->tglbuatjanji = date('Y-m-d H:i:s');

                $model->tgljadwal = $model->tgljadwal . " " . $_POST['PPBuatJanjiPoliT']['waktumulai'];
                $model->tgljadwal = $format->formatDateTimeForDb($model->tgljadwal);
                $model->ruangan_id = $_POST['PPBuatJanjiPoliT']['ruangan_id'];
                $model->no_antrianjanji = !isset($_POST['PPBuatJanjiPoliT']['no_antrianjanji']) ? MyGenerator::noAntrianJanjiPoli($model->ruangan_id) : str_pad($_POST['PPBuatJanjiPoliT']['no_antrianjanji'], 3, '0', STR_PAD_LEFT);
                $model->no_buatjanji = MyGenerator::noJanjiPoli("JP");
                $model->create_time = date('Y-m-d H:i:s');
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->penjamin_id = $_POST['PPBuatJanjiPoliT']['penjamin_id'];
                $nokartu = AsuransipasienM::model()->findByAttributes(array('pasien_id' => $_POST['PPBuatJanjiPoliT']['pasien_id']));
             
                $model->no_kartu_bpjs = ($nokartu)?$nokartu->nokartuasuransi : null;
                if (!empty($model->no_kartu_bpjs)) {
                    $bpjs = new BpjsVklaim();

                    $res = CJSON::decode($bpjs->search_rujukan_pcare_multi($model->no_kartu_bpjs));
                    $res_all = array(
                        'metaData' => array(
                            'code' => 200,
                            'message' => 'OK',
                        ),
                        "response" => null,
                    );
                    // var_dump($res['response']['rujukan'][0]['noKunjungan']);die;
                    $model->nomorreferensijkn = $res['response']['rujukan'][0]['noKunjungan'];
                    $model->jenisreferensi = 1;
                    //
                    // echo "<pre>";
                    // var_dump(CJSON::encode($res['response']['rujukan'][0]['noKunjungan']));
                    // die;
                }
             
                if (empty($model->no_kartu_bpjs)){
                    $crJanji = new CDbCriteria;
                    $crJanji->addCondition("(pasien_id = :pasien_id)");
                                                $crJanji->params[':pasien_id'] = $_POST['PPBuatJanjiPoliT']['pasien_id'];
                    $crJanji->order = "buatjanjipoli_id desc";
                    $crJanji->limit = 1;

                    $modJanjiPoli = BuatjanjipoliT::model()->find($crJanji);
                   
                    $model->no_kartu_bpjs = !empty($modJanjiPoli->no_kartu_bpjs) ?$modJanjiPoli->no_kartu_bpjs : null ;
                }

                // if (!isset($_POST['isPasienLama'])) {   //Jika Pasiennya Lama
                //     $modPasien = $this->savePasien($_POST['PPPasienM']);
                //     $model->pasien_id = $modPasien->pasien_id;
                //     $model->no_rekam_medik = $modPasien->no_rekam_medik;
                // } else {
                //     $modPasien = PPPasienM::model()->findByAttributes(array('no_rekam_medik' => $_POST['no_rekam_medik']));
                //     $modPasien->no_mobile_pasien = $_POST['PPPasienM']['no_mobile_pasien'];
                //     $modPasien->save(false);
                //     $model->pasien_id = $modPasien->pasien_id;
                //     $model->no_rekam_medik = $modPasien->no_rekam_medik;
                // }

                // var_dump($model->attributes);die;
                if ($model->validate()) {
                    $model->save();
                    $modPasien = PPPasienM::model()->findByPk($_POST["PPBuatJanjiPoliT"]['pasien_id']);

                    // SMS GATEWAY
                    $modPegawai = $model->pegawai;
                    $modRuangan = $model->ruangan;
                    $sms = new Sms();
                    $smspasien = 1;
                    $smsdokter = 1;
                    foreach ($modSmsgateway as $i => $smsgateway) {
                        $isiPesan = $smsgateway->templatesms;

                        $attributes = $modPasien->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $model->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modPegawai->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modRuangan->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                     
                        $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);
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
                        }
                    }
                    //                        echo '<pre>';
                    //                        print_r();
                    //                        exit();
                    // END SMS GATEWAY
                    //Insert Notifikasi_r untuk modul Pendaftaran 
                    $judul = 'Pemberitahuan Janji Poli';
                    $isi = 'bahwa besok akan ada jadwal pemeriksaan pasien ' . $modPasien->nama_pasien . "<br/>"
                        . "Tanggal Janji Poli : " . MyFormatter::formatDateTimeForUser($model->tgljadwal);
                    $modNotifikasiR = array();
                    $tglNotif = date('Y-m-d', strtotime("-1 day", strtotime($model->tgljadwal)));

                    $timeNotif = date('H:i:s');
                    $modNotifikasiR['tglnotifikasi'] = $tglNotif . ' ' . $timeNotif;
                    $modNotifikasiR['create_time'] = date('Y-m-d H:i:s');
                    $modNotifikasiR['create_loginpemakai_id'] = Yii::app()->user->id;
                    $modNotifikasiR['judulnotifikasi'] = $judul;
                    $modNotifikasiR['isinotifikasi'] = $isi;
                    $modNotifikasiR['instalasi_id'] = Params::INSTALASI_ID_RM;
                    $modNotifikasiR['modul_id'] = Params::MODUL_ID_PENDAFTARAN;
                    $modNotifikasiR['create_ruangan'] = Params::RUANGAN_ID_LOKET_PENDAFTARAN;

                    CustomFunction::insertNotifikasiCron($modNotifikasiR);
                    //Insert Notifikasi_r untuk modul Informasi
                    $modNotifikasiRInformasi = array();
                    $modNotifikasiRInformasi['tglnotifikasi'] = $tglNotif . ' ' . $timeNotif;
                    $modNotifikasiRInformasi['create_time'] = date('Y-m-d H:i:s');
                    $modNotifikasiRInformasi['create_loginpemakai_id'] = Yii::app()->user->id;
                    $modNotifikasiRInformasi['judulnotifikasi'] = $judul;
                    $modNotifikasiRInformasi['isinotifikasi'] = $isi;
                    $modNotifikasiRInformasi['instalasi_id'] = Params::INSTALASI_ID_RM;
                    $modNotifikasiRInformasi['modul_id'] = Params::MODUL_ID_INFORMASI;
                    $modNotifikasiRInformasi['create_ruangan'] = Params::RUANGAN_ID_INFORMASI;

                    CustomFunction::insertNotifikasiCron($modNotifikasiRInformasi);

                    // if ($model->whatsapp) {
                        $profil = ProfilrumahsakitM::model()->find();

                        $msg = "
Assalamualaikum.Wr.Wb
Terimakasih telah melakukan Perjanjian di ((nama_rs))
            
((nama_pasien)) memiliki perjanjian dengan No Perjanjian ((no_buatjanji)) untuk tanggal kunjungan ((jgljadwal)) Ke ((ruangan_nama)) - ((nama_pegawai)) dengan Nomor Antrian ((no_antrian))
            
            
*Membawa Surat Rujukan Online dari PPK 1 yang masih berlaku/ RS Tipe C (BPJS)
*Sebelum memasuki rumah sakit Semua pengunjung harus mengisi screening online di link berikut: http://sariasihciputat.com/screening\n 
*Untuk melihat Live Antrian dapat mengunjungi : https://sariasihgroup.com/salive/antrian
            
            
Terimakasih
Syafakumullah
            
Wassalamualaikum.Wr.Wb
";
                        $msg = str_replace("((nama_rs))", $profil->nama_rumahsakit, $msg);
                        $msg = str_replace("((nama_pasien))", $modPasien->namadepan . $modPasien->nama_pasien, $msg);
                        $msg = str_replace("((no_rekam_medik))", $modPasien->no_rekam_medik, $msg);
                        $msg = str_replace("((no_buatjanji))", $model->no_buatjanji, $msg);
                        $msg = str_replace("((jgljadwal))", MyFormatter::formatDateTimeForUser($model->tgljadwal), $msg);
                        $msg = str_replace("((ruangan_nama))", $model->ruangan->ruangan_nama, $msg);
                        $msg = str_replace("((nama_pegawai))", $model->pegawai->namaLengkap, $msg);
                        $msg = str_replace("((no_antrian))", $model->ruangan->ruangan_singkatan . "-" . $model->no_antrianjanji, $msg);

                        // var_dump($msg."\n", $model->attributes); die;
                        // die;

                    // }

                    //                         $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                    //                            array('instalasi_id'=> Params::INSTALASI_ID_RM, 'ruangan_id'=> Params::RUANGAN_ID_LOKET_PENDAFTARAN, 'modul_id'=> Params::MODUL_ID_PENDAFTARAN),
                    //                        )); 
                    // var_dump($model->attributes, $_POST); die;
                    // var_dump($_POST);die;
                    $transaction->commit();

                    if (!empty($modPasien->no_mobile_pasien)) {
                        // echo "Kirim: ".$model->no_buatjanji." - ".$modPasien->no_mobile_pasien."\n";
                        $wa = new WhatsApp();

                        $wa->kirimIndividu($modPasien->no_mobile_pasien, $msg);

                        // var_dump($res);
                    }
                    //Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('index', 'buatjanjipoli_id' => $model->buatjanjipoli_id, 'sukses' => 1));
                } else {
                    var_dump($model->getErrors());
                    die;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                }
            } catch (Exception $exc) {
                var_dump($exc->getMessage());
                die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
            }
        }

        // $tgl = explode('-', date('Y-m-d'));
        // $day = cal_days_in_month(CAL_GREGORIAN, $tgl[1], $tgl[0]);
        // $grid = $this->createGrid($day, $tgl[1], $tgl[0]);

        $this->render('booking', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPegawai' => $modPegawai,
            'carabayar' => $carabayar,
            //'grid' => $grid
        ));
    }

   

    public function loadModel($id)
    {
        $model = PPBuatJanjiPoliT::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    public function actionLoadDokter()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $noruangan = $_POST['id'];
            $criteria1 = new CDbCriteria();
            $returnVal = array();
            $str = '';
            //$criteria->addCondition(" modul_id = '".Yii::app()->user->getState('modul_id')."' ");
            if (!empty($noruangan)) {
                $data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $noruangan), array('order' => 'nama_pegawai'));
                // $jadwal = JadwaldokterM::model()->findAllByAttributes(array(
                //     'jadwaldokter_tgl' => date('Y-m-d'),
                //     'ruangan_id' => $noruangan,
                // ), array(
                //     'order' => 'pegawai_id asc'
                // ));
                foreach ($data as $i => $model) {
                    //                        $modtempatkerja = new TempatbekerjaM();
                    $pegawai = PegawaiM::model()->findByPk($model->pegawai_id);
                    $path = Params::pathPegawaiTumbsDirectory() . "kecil_" . $pegawai->photopegawai;
                    //$pendaftaran = EKPendaftaranT::model()->findByAttributes(array("pasien_id" => $model->pasien_id), array("order" => 'pendaftaran_id DESC'));
                    $ruangan = RuanganM::model()->findByPk($noruangan);
                    $returnVal[$i]['ruangan_nama'] = $ruangan->ruangan_nama;
                  
                    $returnVal[$i]['nama_pegawai'] = $pegawai->namaLengkap;
                    $returnVal[$i]['photopegawai'] = !empty($pegawai->photopegawai) && file_exists($path)? $path :(($pegawai->jeniskelamin == 'LAKI-LAKI')? Yii::app()->getBaseUrl('webroot').'/images/dokter/dr_pria.png' : Yii::app()->getBaseUrl('webroot').'/images/dokter/dr_wanita.png');
                    $returnVal[$i]['jeniskelamin'] = $pegawai->jeniskelamin;
                    $returnVal[$i]['pegawai_id'] = $model->pegawai_id;
                    $returnVal[$i]['ruangan_id'] = $noruangan;
                    //$str.=`<div style="margin:10px;color:white;font-weight:bold;" onclick="$('#pegawai_id').val('".$model->pegawai_id."');$('#ruangan_id').val('".$noruangan."');getjadwal();AmbilHari();"><p style="margin-top:10px;font-size:24px"><u>`.$ruangan->ruangan_nama. `</u></p><div>`. CHtml::image(Params::urlPegawaiDirectory().$pegawai->photopegawai, 'Foto Pegawai', array('width'=>120)).`</div><div style="margin-top:50px;">`.$pegawai->namaLengkap.`</div></div>`;
                    // $returnVal 
                    
                    // $returnVal= array('ruangan_nama'=>$ruangan->ruangan_nama, 'nama_pegawai'=> $pegawai->namaLengkap);
                    // var_dump("return". $returnVal[$i]['nama_pegawai']);
                }

                echo CJSON::encode($returnVal);
            }
        }
        Yii::app()->end();
    }
    public function actionLoadJadwal()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $pegawai_id = $_POST['pegawai_id'];
            $ruangan_id = $_POST['ruangan_id'];
            $criteria1 = new CDbCriteria();
            
            $tanggal = MyFormatter::formatDateTimeForDb($_POST['tanggal']);

            //$criteria->addCondition(" modul_id = '".Yii::app()->user->getState('modul_id')."' ");
            if (!empty($pegawai_id)) {
                //$data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $noruangan), array('order' => 'nama_pegawai'));
                $jadwal = JadwaldokterM::model()->findAllByAttributes(array(
                    'jadwaldokter_tgl' => $tanggal,
                    'pegawai_id' => $pegawai_id,
                ), array(
                    'order' => 'pegawai_id asc'
                ));
                $tabel = "";
                $returnVal = array();
                $pegawai = PegawaiM::model()->findByAttributes(array("pegawai_id" => $pegawai_id));
                $namadokter = $pegawai->namaLengkap;
                foreach ($jadwal as $i => $model) {
                    //                        $modtempatkerja = new TempatbekerjaM();

                    //$pendaftaran = EKPendaftaranT::model()->findByAttributes(array("pasien_id" => $model->pasien_id), array("order" => 'pendaftaran_id DESC'));
                    
                    $returnVal[$i]['jadwaldokter_mulai'] = $model->jadwaldokter_mulai;
                    $returnVal[$i]['jadwaldokter_tutup'] = $model->jadwaldokter_tutup;
                    $returnVal[$i]['jadwaldokter_hari'] = $model->jadwaldokter_hari;
                    // $returnVal= array('ruangan_nama'=>$ruangan->ruangan_nama, 'nama_pegawai'=> $pegawai->namaLengkap);
                    // var_dump("return". $returnVal[$i]['nama_pegawai']);
                    // var_dump($returnVal[$i]['jadwaldokter_hari']);
                    $tabel .= "<tr><td>" . ($i + 1) . "</td><td>" . $model->jadwaldokter_mulai . "</td><td>" . $model->jadwaldokter_tutup . "</td><td>" . CHtml::button('PILIH', array(
                        "id" => 'chtmlbutton',
                        "class" => 'chtmlbuttonclass',
                        "style" => 'font-size:20px; background-color:#3E6F3E;; border-radius:8px; padding:10px;color:white;font-weight:bold;',
                        "onClick" => "$(\"#dialogJadwal\").dialog(\"open\");sasa('" . $model->jadwaldokter_mulai . "','" . $model->jadwaldokter_tutup . "','" . $model->jadwaldokter_tgl . "')"
                    )) . "</td></tr>";
                }
                // s
                echo CJSON::encode(array('tabel' => $tabel, 'namadokter' => $namadokter));
                // echo CJSON::encode($namadokter);
            }
        }
        Yii::app()->end();
    }
    public function actionCariJadwal()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $pegawai_id = $_POST['pegawai_id'];
            $ruangan_id = $_POST['ruangan_id'];
            //$tanggal = $_POST['tanggal'];
            $tanggal = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($_POST['tanggal'])));
            $criteria1 = new CDbCriteria();
            $criteria1->addCondition("tgljadwal::date = '" . $tanggal . "'");
            $criteria1->addCondition("pegawai_id = '" . $pegawai_id . "'");
            $criteria1->addCondition("ruangan_id = '" . $ruangan_id . "'");
            $returnVal = array();
            $jadwal = BuatjanjipoliT::model()->findAll($criteria1);

            //$criteria->addCondition(" modul_id = '".Yii::app()->user->getState('modul_id')."' ");
            //if (!empty($pegawai_id)) {
            //$data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $noruangan), array('order' => 'nama_pegawai'));
            // $jadwal = JadwaldokterM::model()->findAllByAttributes(array(
            //     'jadwaldokter_tgl' => $tanggal,
            //     'pegawai_id' => $pegawai_id,
            // ), array(
            //     'order' => 'pegawai_id asc'
            // ));
            // $tabel = "";
            foreach ($jadwal as $i => $model) {
                //                        $modtempatkerja = new TempatbekerjaM();

                //$pendaftaran = EKPendaftaranT::model()->findByAttributes(array("pasien_id" => $model->pasien_id), array("order" => 'pendaftaran_id DESC'));
                $namapasien = PasienM::model()->findByPk($model->pasien_id);
                $returnVal[$i]['pasien_id'] = $model->pasien_id;
                $returnVal[$i]['tgljadwal'] = $model->tgljadwal;
                $returnVal[$i]['no'] = $model->no_antrianjanji;
                $returnVal[$i]['nama_pasien'] = $namapasien;
                // $returnVal= array('ruangan_nama'=>$ruangan->ruangan_nama, 'nama_pegawai'=> $pegawai->namaLengkap);
                // var_dump("return". $returnVal[$i]['nama_pegawai']);
                // var_dump($returnVal[$i]['jadwaldokter_hari']);
                // $tabel .= "<tr><td>" . ($i + 1) . "</td><td>Shift 1</td><td>" . $model->jadwaldokter_mulai . "</td><td>" . $model->jadwaldokter_tutup . "</td><td>" . CHtml::button('PILIH', array(
                //     "id" => 'chtmlbutton',
                //     "class" => 'chtmlbuttonclass',
                //     "onClick" => "$(\"#dialogJadwal\").dialog(\"open\");sasa('" . $model->jadwaldokter_mulai . "','" . $model->jadwaldokter_tutup . "')"
                // )) . "</td></tr>";
            }
            // s
            echo CJSON::encode($returnVal);
            //}
        }
        Yii::app()->end();
    }

    public function actionGetHari()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $format = new MyFormatter();
            $tanggalWaktu = $_POST['tanggal'];
            // var_dump($tanggalWaktu);die;
            //$tanggal = trim(substr($tanggalWaktu, 0, -8)); //Menampilkan Tanggal Tanpa Jam

            $tanggalDB = $format->formatDateTimeForDb($tanggalWaktu); //Mengubah Tanggal inputan ke tanggal database
            $hari = date('l', strtotime($tanggalDB)); //Mendapatkan nilai hari dari tanggal yang dipilih

            if (strtolower($hari) == 'sunday') {
                $hari = 'Minggu';
            } else if (strtolower($hari) == 'monday') {
                $hari = 'Senin';
            } else if (strtolower($hari) == 'tuesday') {
                $hari = 'Selasa';
            } else if (strtolower($hari) == 'wednesday') {
                $hari = 'Rabu';
            } else if (strtolower($hari) == 'thursday') {
                $hari = 'Kamis';
            } else if (strtolower($hari) == 'friday') {
                $hari = 'Jumat';
            } else if (strtolower($hari) == 'saturday') {
                $hari = 'Sabtu';
            }
            $data['hari'] = $hari;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionGetKuotaJanjiPoli()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $pegawai_id = $_POST['pegawai_id'];
        $ruangan_id = $_POST['ruangan_id'];
        $tanggal = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($_POST['tgl'])));

        $kuota = 0;
        $dipakai = 0;
        $sisa = 0;
        $msg = "";
        $is_penuh = 0;
        $no_luarjadwal = 1;

        $peg = PegawaiM::model()->findByPk($pegawai_id);
        $ruangan = RuanganM::model()->findByPk($ruangan_id);

        $jadwals = JadwaldokterM::model()->findAllByAttributes(array(
            'pegawai_id' => $pegawai_id,
            'ruangan_id' => $ruangan_id,
            'jadwaldokter_tgl' => $tanggal
        ));

        $str = '<option value="">-- Pilih --</option>';

        $list_jadwal = array();

        foreach ($jadwals as $jadwal) {
            // var_dump($jadwal->attributes); die;
            $no_luarjadwal = 1;

            $kuota += $jadwal->maksbuatjanji;

            $waktu_mulai = new DateTime(MyFormatteR::formatDateTimeForDb($jadwal->jadwaldokter_tgl) . " " . $jadwal->jadwaldokter_mulai);
            $waktu_selesai = new DateTime(MyFormatteR::formatDateTimeForDb($jadwal->jadwaldokter_tgl) . " " . $jadwal->jadwaldokter_tutup);

            $dataJanji = array();
            $dataJadwal = array();
            $arr_waktu = array();

            $period = new DatePeriod(
                $waktu_mulai,
                new DateInterval('PT' . $jadwal->estimasipelayanan . 'M'),
                $waktu_selesai
            );

            foreach ($period as $item) {
                $value_awal = $item->format('H:i:s');

                $arr_waktu[] = $tanggal . " " . $value_awal;
            }

            $janji_dipakai = BuatjanjipoliT::model()->findAllByAttributes(array(
                'pegawai_id' => $pegawai_id,
                'ruangan_id' => $ruangan_id,
                'tgljadwal' => $arr_waktu,
            ), array(
                'condition' => 'pendaftaran_id is null',
            ));

            $jadwal_dipakai = PendaftaranT::model()->findAllByAttributes(array(
                'pegawai_id' => $pegawai_id,
                'ruangan_id' => $ruangan_id,
                'tgl_pendaftaran' => $arr_waktu,
            ));

            foreach ($janji_dipakai as $item) {
                $waktu = date('H:i', strtotime($item->tgljadwal));
                $dataJanji[$waktu] = $item;
            }

            foreach ($jadwal_dipakai as $item) {
                $waktu = date('H:i', strtotime($item->tgl_pendaftaran));
                $dataJadwal[$waktu] = $item;
            }





            $idx_slot = 1;
            foreach ($period as $idx => $item) {
                $terisi = 0;
                $terisi_jadwal = 0;
                $pasien_id = "";
                $value_awal = $item->format('H:i');

                $value_akhir = date('H:i', strtotime($value_awal . ":00") + ($jadwal->estimasipelayanan * 60));

                $label = ($idx + 1) . " - " . $value_awal . " - " . $value_akhir;

                if (!empty($dataJadwal[$value_awal])) {
                    $terisi_jadwal = 1;
                    $terisi = 1;
                    $label .= " -- " . $ruangan->ruangan_singkatan . "-" . $dataJadwal[$value_awal]->no_urutantri;
                    $label .= " -- " . $dataJadwal[$value_awal]->pasien->nama_pasien;
                    $pasien_id = $dataJadwal[$value_awal]->pasien->pasien_id;
                    $dipakai++;
                } else if (!empty($dataJanji[$value_awal])) {
                    $terisi = 1;
                    $label .= " -- " . $ruangan->ruangan_singkatan . "-" . (str_pad($idx + 1, 3, "0", STR_PAD_LEFT));
                    $label .= " -- " . $dataJanji[$value_awal]->pasien->nama_pasien;
                    $pasien_id = $dataJanji[$value_awal]->pasien->pasien_id;
                    $dipakai++;
                }

                $str .= '<option value="' . $value_awal . '" data-terisi="' . $terisi . '" data-terisi-jadwal="' . $terisi_jadwal . '" data-slot="' . ($idx_slot) . '" data-jadwal="' . $jadwal->jadwaldokter_mulai . '" data-pasien="' . $pasien_id . '" data-item="1">' . $label . '</option>';
                $idx_slot++;
                $no_luarjadwal++;
            }

            /*
      $dipakai = BuatjanjipoliT::model()->countByAttributes(array(
        'pegawai_id' => $pegawai_id,
        'ruangan_id' => $ruangan_id,
        'tgljadwal' => $tanggal,
      ));
      */

            $list_jadwal[$jadwal->jadwaldokter_mulai] = date('H:i', strtotime($jadwal->jadwaldokter_mulai)) . " - " . date('H:i', strtotime(($jadwal->jadwaldokter_tutup)));
        }

        $checkbox_jadwal = CHtml::radioButtonList('ceklis_jadwal', null, $list_jadwal, array(
            'class' => 'ceklis_jadwal', 'uncheckValue' => 'null', 'onclick' => 'setCeklisJadwalDokter()',
        ));

        $sisa = $kuota - $dipakai;

        /*
    if ($kuota != 0 && $sisa == 0) {
      $is_penuh = 1;
      $msg = "Maaf untuk dokter " . $peg->namaLengkap . " dan ruangan " . $ruangan->ruangan_nama . ", sisa kuota untuk buat janji sudah habis.";
    }
    */

        echo CJSON::encode(array(
            'kuota' => $kuota,
            'sisa' => $sisa,
            'slot' => $str,
            'is_penuh' => $is_penuh,
            'msg' => $msg,
            'checkbox_jadwal' => $checkbox_jadwal,
            'no_luarjadwal' => $no_luarjadwal,
        ));
    }

    public function actionGetJadwal(){
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
          }
          
          $pegawai_id = $_POST['pegawai_id'];
          $ruangan_id = $_POST['ruangan_id'];
          $awal = $_POST['awal'];
          $tutup = $_POST['tutup'];

        //   var_dump($_POST);die;
        //  var_dump( $_POST);die;
          $tanggal = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($_POST['tanggal'])));
      
          $kuota = 0;
          $dipakai = 0;
          $sisa = 0;
          $msg = "";
          $is_penuh = 0;
          $no_luarjadwal = 1;
      
          $peg = PegawaiM::model()->findByPk($pegawai_id);
          $ruangan = RuanganM::model()->findByPk($ruangan_id);
        
          $jadwals = JadwaldokterM::model()->findAllByAttributes(array(
            'pegawai_id' => $pegawai_id,
            'ruangan_id' => $ruangan_id,
            'jadwaldokter_tgl' => $tanggal,
            'jadwaldokter_mulai' =>  $awal,
            'jadwaldokter_tutup' =>  $tutup,

          ));
         
          $str = '';
          
          $list_jadwal = array();
        //   var_dump($jadwals );die;
          
          foreach ($jadwals as $jadwal) {
            // var_dump($jadwal->attributes); die;
            $no_luarjadwal = 1;
      
            $kuota += $jadwal->maksbuatjanji;
      
            $waktu_mulai = new DateTime(MyFormatteR::formatDateTimeForDb($jadwal->jadwaldokter_tgl)." ".$jadwal->jadwaldokter_mulai);
            $waktu_selesai = new DateTime(MyFormatteR::formatDateTimeForDb($jadwal->jadwaldokter_tgl)." ".$jadwal->jadwaldokter_tutup);
      
            $dataJanji = array();
            $dataJadwal = array();
            $arr_waktu = array();
            $data = array();
            $period = new DatePeriod(
              $waktu_mulai,
              new DateInterval('PT'.$jadwal->estimasipelayanan.'M'),
              $waktu_selesai
            );
            // var_dump($period);die;
            foreach ($period as $item) {
              $value_awal = $item->format('H:i:s');
      
              $arr_waktu[] = $tanggal." ".$value_awal;
            }
         
            $janji_dipakai = BuatjanjipoliT::model()->findAllByAttributes(array(
              'pegawai_id' => $pegawai_id,
              'ruangan_id' => $ruangan_id,
              'tgljadwal' => $arr_waktu,
            ), array(
              'condition'=>'pendaftaran_id is null',
            ));
      
            $jadwal_dipakai = PendaftaranT::model()->findAllByAttributes(array(
              'pegawai_id' => $pegawai_id,
              'ruangan_id' => $ruangan_id,
              'tgl_pendaftaran' => $arr_waktu,
            ));

     
          
            foreach ($janji_dipakai as $item) {
              $waktu = date('H:i', strtotime($item->tgljadwal));
              $dataJanji[$waktu] = $item;
            }
      
            foreach ($jadwal_dipakai as $item) {
              $waktu = date('H:i', strtotime($item->tgl_pendaftaran));
              $dataJadwal[$waktu] = $item;
            }
            
            $idx_slot = 1;
            foreach ($period as $idx => $item) {
              $terisi = 0;
              $terisi_jadwal = 0;
              $pasien_id = "";
              $value_awal = $item->format('H:i');
              
              $value_akhir = date('H:i', strtotime($value_awal.":00") + ($jadwal->estimasipelayanan * 60));
      
              $label = $value_awal." - ".$value_akhir;
      
              if (!empty($dataJadwal[$value_awal])) {
                $terisi_jadwal = 1;
                $terisi = 1;
                // $label .= " -- ".$ruangan->ruangan_singkatan."-".$dataJadwal[$value_awal]->no_urutantri;
                // $label .= " -- ".$dataJadwal[$value_awal]->pasien->nama_pasien;
                $pasien_id = $dataJadwal[$value_awal]->pasien->pasien_id;
                $dipakai++;
              } else if (!empty($dataJanji[$value_awal])) {
                $terisi = 1;
                // $label .= " -- ".$ruangan->ruangan_singkatan."-".(str_pad($idx + 1, 3, "0", STR_PAD_LEFT));
                // $label .= " -- ".$dataJanji[$value_awal]->pasien->nama_pasien;
                $pasien_id = $dataJanji[$value_awal]->pasien->pasien_id;
                $dipakai++;
              }
              $data['waktumulai'] = $jadwal->jadwaldokter_mulai;
              $str .= '<tr><td>'.($idx+1).'</td><td><option value="'.$value_awal.'" data-terisi="'.$terisi.'" data-terisi-jadwal="'.$terisi_jadwal.'" data-slot="'.($idx_slot).'" data-jadwal="'.$jadwal->jadwaldokter_mulai.'" data-pasien="'.$pasien_id.'" data-item="1">'.$label.'</option></td><td>'.(($idx+1 <= 10)?"Sudah Terisi":(($terisi)?"Sudah Terisi":"")).'</td><td>'.(($idx+1 <=10 )?"Sudah Terisi":(($terisi)?"Sudah Terisi":'<input class="hide"= value="'.$value_awal.'" id="'.($idx+1).'"></input><button type ="submit" class = "btn" style = "font-size:24px; background-color:#3E6F3E; border-radius:8px; padding:10px;color:white;font-weight:bold;"onclick ="create(`'.$value_awal.'`)">Pilih</button>')).'</td></tr>';
            //   $str .= '<tr><td>'.($idx + 1).'</td><td>'.$label.'</td><td>'.($terisi?"Tersedia":"");
              $idx_slot++;
              $no_luarjadwal++;
            }
            // var_dump($str);die;
            
            /*
            $dipakai = BuatjanjipoliT::model()->countByAttributes(array(
              'pegawai_id' => $pegawai_id,
              'ruangan_id' => $ruangan_id,
              'tgljadwal' => $tanggal,
            ));
            */
      
            $list_jadwal[$jadwal->jadwaldokter_mulai] = date('H:i', strtotime($jadwal->jadwaldokter_mulai))." - ".date('H:i', strtotime(($jadwal->jadwaldokter_tutup)));
          }

          echo CJSON::encode(array(
            'data' => $data,
            'str' => $str,
            'is_penuh' => $is_penuh,
            'msg' => $msg,
          ));
        }
    

    public function actionPrintKarcis($buatjanjipoli_id)
    {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $model = PPBuatJanjiPoliT::model()->findByPk($buatjanjipoli_id);
        $modPasien = PasienM::model()->findByPk($model->pasien_id);
        $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->id);


        $judul_print = 'Karcis Janji Poliklinik';
        $this->render('printKarcis', array(
            'format' => $format,
            'model' => $model,
            'judul_print' => $judul_print,
            'modPasien' => $modPasien,
            'modPegawai' => $modPegawai,
        ));
    }
}
