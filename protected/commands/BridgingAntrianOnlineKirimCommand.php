<?php

class BridgingAntrianOnlineKirimCommand extends CConsoleCommand {

    public function actionKirimOnline() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('statuskirim = false');
        $criteria->addCondition('waktutunggu_mil IS NOT NULL AND waktutunggu_rs IS NOT NULL');
        $criteria->order = "create_time ASC, task_id ASC";
        $modWaktu = WaktutunggupelayananT::model()->findAll($criteria);

        $loadWaktu = array();
        if(!empty($modWaktu)){
            foreach($modWaktu as $waktutunggu){
                $modPendaftaran = PendaftaranT::model()->findByPk($waktutunggu->pendaftaran_id);
                $indextask = $waktutunggu->kode_booking.'-'.$waktutunggu->task_id;

                $cekbookingnot = false;

                if($waktutunggu->task_id == 3 && $waktutunggu->statuskirim == false && strtolower($waktutunggu->response_list) == 'kode booking tidak ditemukan'){
                    $cekbookingnot = true; 
                }

                if((!empty($modPendaftaran) && $modPendaftaran->statuskirim_wsbpjs == false) || $cekbookingnot == true){
                    $loadWaktu[$indextask]['istambahantrian'] = false;
                }else{
                    $loadWaktu[$indextask]['istambahantrian'] = true;
                }
                $loadWaktu[$indextask]['pendaftaran_id'] = $waktutunggu->pendaftaran_id;
                $loadWaktu[$indextask]['task_id'] = $waktutunggu->task_id;
                $loadWaktu[$indextask]['tanggal'] = $waktutunggu->tanggal;
                $loadWaktu[$indextask]['kode_booking'] = $waktutunggu->kode_booking;
                $loadWaktu[$indextask]['waktutunggu'] = $waktutunggu->waktutunggu;
                $loadWaktu[$indextask]['waktutunggu_rs'] = $waktutunggu->waktutunggu_rs;
                $loadWaktu[$indextask]['waktutunggu_mil'] = $waktutunggu->waktutunggu_mil;
                $loadWaktu[$indextask]['waktutunggupelayanan_id'] = $waktutunggu->waktutunggupelayanan_id;
            }
        }
        ksort($loadWaktu);

        if(!empty($loadWaktu)){
            foreach($loadWaktu as $waktu){
                $modPendaftaran = PendaftaranT::model()->findByPk($waktu['pendaftaran_id']);
                if(empty($modPendaftaran)){
                    continue;
                }
                $antrianonlinebpjs = new AntrianOnlineBpjs();
                $kodebooking = $waktu['kode_booking'];

                if($waktu['istambahantrian'] == false){
                    $jenispasien = (($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS) ? "JKN" : "NON JKN");

                    $nomorkartu = "";
                    $nomorreferensi = "";
                    $modSep = SepT::model()->findByPk($modPendaftaran->sep_id);
                    if(!empty($modSep)){
                        $nomorkartu = (!empty($modSep->nokartuasuransi)?$modSep->nokartuasuransi:"");
                        $nomorreferensi = (!empty($modSep->norujukan)?$modSep->norujukan :"");
                    }
                    $nik = $modPendaftaran->pasien->no_identitas_pasien;
                    $nohp = $modPendaftaran->pasien->no_mobile_pasien;

                    $kodepoli = (!empty($modPendaftaran->ruangan)?$modPendaftaran->ruangan->kode_bpjs : "");
                    $namapoli = (!empty($modPendaftaran->ruangan)?$modPendaftaran->ruangan->ruangan_nama : "");
                    $pasienbaru = (($modPendaftaran->statuspasien == Params::STATUSPASIEN_BARU) ? 1: 0);
                    $norm = $modPendaftaran->pasien->no_rekam_medik;
                    $tanggalperiksa = date('Y-m-d',strtotime($modPendaftaran->tgl_pendaftaran));
                    $kodedokter = (!empty($modPendaftaran->pegawai)?$modPendaftaran->pegawai->kodedokter_bpjs : "");
                    $namadokter = (!empty($modPendaftaran->pegawai)?$modPendaftaran->pegawai->nama_pegawai : "");

                    $jadwaldokter = JadwaldokterM::model()->findByAttributes(array('pegawai_id'=>$modPendaftaran->pegawai_id,'jadwaldokter_tgl'=>$tanggalperiksa));

                    $jampraktek = "";
                    $sisakuotajkn = 50;
                    $kuotajkn = 100;
                    $sisakuotanonjkn = 0;
                    $kuotanonjkn = 0;

                    if(!empty($jadwaldokter)){
                        $jam = $jadwaldokter->jadwaldokter_buka;
                        $jamArray = explode(" ", $jam);
                        $jamArray[1]= "-";
                        $jamArray[0]= substr($jamArray[0],0,5);
                        $jamArray[2]= substr($jamArray[2],0,5);
                        $jamArray = implode('', $jamArray);
                        $jampraktek = $jamArray;

                        $sisakuotajkn = $jadwaldokter->maximumbpjsantrian;
                        $kuotajkn = $jadwaldokter->maximumbpjsantrian;
                        $sisakuotanonjkn = $jadwaldokter->maximumantrian;
                        $kuotanonjkn = $jadwaldokter->maximumantrian;
                    }
                    $jeniskunjungan = 1;
                    $nomorantrean = number_format($modPendaftaran->no_urutantri);
                    $angkaantrean = number_format($modPendaftaran->no_urutantri);
                    $estimasidilayani = $modPendaftaran->tglakandilayani;
                    $stampwaktuantrian = strtotime($estimasidilayani);
                    $estimasidilayani = $stampwaktuantrian*1000;
                    
                    $keterangan = "Peserta harap 30 menit lebih awal guna pencatatan administrasi.";
                    
                    $bodytambah = array("kodebooking"=>$kodebooking, "jenispasien"=>$jenispasien, "nomorkartu"=>$nomorkartu, "nik"=>$nik,"nohp"=>$nohp, "kodepoli"=>$kodepoli, "namapoli"=>$namapoli, "pasienbaru"=>$pasienbaru, "norm"=>$norm, "tanggalperiksa"=>$tanggalperiksa, "kodedokter"=>$kodedokter, "namadokter"=>$namadokter, "jampraktek"=>$jampraktek, "jeniskunjungan"=>$jeniskunjungan, "nomorreferensi"=>$nomorreferensi, "nomorantrean"=>$nomorantrean, "angkaantrean"=>$angkaantrean, "estimasidilayani"=>$estimasidilayani, "sisakuotajkn"=>$sisakuotajkn, "kuotajkn"=>$kuotajkn, "sisakuotanonjkn"=>$sisakuotanonjkn, "kuotanonjkn"=>$kuotanonjkn, "keterangan"=>$keterangan);
                    $res_tambah = CJSON::decode($antrianonlinebpjs->tambah_antrian($bodytambah));

                    if(!empty($res_tambah['metaData']['code']) && $res_tambah['metaData']['code'] == '200'){
                        PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,array('respons_wsbpjs'=>null,'statuskirim_wsbpjs'=>true,'update_loginpemakai_id'=>1,'update_time'=>date('Y-m-d H:i:s')));
                        echo 'Sukses Kirim Tambah Antrian';
                    }else{
                        PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,array('statuskirim_wsbpjs'=>false,'respons_wsbpjs'=>(!empty($res_tambah['metaData']['message'])?$res_tambah['metaData']['message']:null)));
                        echo 'Gagal Kirim Tambah Antrian ('.(!empty($res_tambah['metaData']['message'])?$res_tambah['metaData']['message']:null).')';
                    }
                }

                $body_update = array("kodebooking"=>$kodebooking, "taskid"=>$waktu['task_id'], "waktu"=>$waktu['waktutunggu_mil']);
                $res_update = CJSON::decode($antrianonlinebpjs->update_waktu($body_update));
                if(!empty($res_update['metaData']['code']) && $res_update['metaData']['code'] == '200'){
                    WaktutunggupelayananT::model()->updateByPk($waktu['waktutunggupelayanan_id'], array('response_list'=>null,'statuskirim'=>true,'update_loginpemakai_id'=>1,'update_time'=>date('Y-m-d H:i:s')));
                    echo 'Sukses Kirim Update Task Antrian';
                }else{
                    $pesan = "";
                    
                    if(!empty($res_update['metaData']['code'])){
                        WaktutunggupelayananT::model()->updateByPk($waktu['waktutunggupelayanan_id'], array('response_list'=>$res_update['metaData']['message']));
                        $pesan = $res_update['metaData']['message'];
                    }
                    echo 'Gagal Kirim Update Task Antrian ('.$pesan.')';
                }


            }
        }
    }
    
}
