<?php
Yii::import('application.components.Params');
Yii::import('application.components.BridgingKemenkes');
Yii::import('application.components.MyFormatter');
class BridgingKemenkesLaporanCommand extends CConsoleCommand {
    public function actionKemenkesLaporanPasienMasuk() {
        $modKofig = KonfigsystemK::model()->find();
        if (isset($modKofig->is_kemenkes) && $modKofig->is_kemenkes == true) {
            $tanggal = MyFormatter::formatDateTimeForDb(date('Y-m-d')); 
            $igdKonfirmLK = 0;
            $igdKonfirmPR = 0;
            $igdSuspectLK = 0;
            $igdSuspectPR = 0;
            
            $riKonfirmLK = 0;
            $riKonfirmPR = 0;
            $riSuspectLK = 0;
            $riSuspectPR = 0;
                            
            $criterianPend = new CDbCriteria();
            $criterianPend->addCondition("date(tgl_pendaftaran) = '".$tanggal."'");
            $criterianPend->addCondition('pasienpulang_id IS NULL AND pasienadmisi_id IS NULL');

            $modPendaftaran = PendaftaranT::model()->findAll($criterianPend); 
            
            if(count($modPendaftaran) > 0){
                foreach ($modPendaftaran as $i => $dataPend) {
                    $modJenisKasusPenyakit = JeniskasuspenyakitM::model()->findByPk($dataPend->jeniskasuspenyakit_id);
                    
                    if(isset($modJenisKasusPenyakit)){
                        if($modJenisKasusPenyakit->jeniskasuspenyakit_id == 90){ // Terkonfirm
                            if($dataPend->pasien->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI){
                                $igdKonfirmLK += 1;
                            }else if($dataPend->pasien->jeniskelamin == Params::JENIS_KELAMIN_PEREMPUAN){
                                $igdKonfirmPR += 1;
                            }
                        }else if($modJenisKasusPenyakit->jeniskasuspenyakit_id == 92 || $modJenisKasusPenyakit->jeniskasuspenyakit_id == 89 || $modJenisKasusPenyakit->jeniskasuspenyakit_id == 18){ // Suspect
                            if($dataPend->pasien->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI){
                                $igdSuspectLK += 1;
                            }else if($dataPend->pasien->jeniskelamin == Params::JENIS_KELAMIN_PEREMPUAN){
                                $igdSuspectPR += 1;
                            }
                        }
                    }   
                }
            }
            
            $criteriaAdm = new CDbCriteria();
            $criteriaAdm->select = "t.pasienadmisi_id, df.jeniskasuspenyakit_id, pas.pasien_id, pas.jeniskelamin";
            $criteriaAdm->group = $criteriaAdm->select;
            $criteriaAdm->join = "JOIN pendaftaran_t df ON df.pendaftaran_id = t.pendaftaran_id "
                    . "JOIN pasien_m pas ON pas.pasien_id = t.pasien_id ";
            $criteriaAdm->addCondition("date(t.tgladmisi) = '".$tanggal."'");
            $criteriaAdm->addCondition('t.pasienpulang_id IS NULL');
            
            $pasienAdmisi = PasienadmisiT::model()->findAll($criteriaAdm);
            
            if(count($pasienAdmisi) > 0){
                foreach ($pasienAdmisi as $i => $dataAdmsi) {
                    $modJenisKasusPenyakit = JeniskasuspenyakitM::model()->findByPk($dataAdmsi->jeniskasuspenyakit_id);
                    
                    if(isset($modJenisKasusPenyakit)){
                        if($modJenisKasusPenyakit->jeniskasuspenyakit_id == 90){ // Terkonfirm
                            if($dataAdmsi->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI){
                                $riKonfirmLK += 1;
                            }else if($dataAdmsi->jeniskelamin == Params::JENIS_KELAMIN_PEREMPUAN){
                                $riKonfirmPR += 1;
                            }
                        }else if($modJenisKasusPenyakit->jeniskasuspenyakit_id == 92 || $modJenisKasusPenyakit->jeniskasuspenyakit_id == 89 || $modJenisKasusPenyakit->jeniskasuspenyakit_id == 18){ // Suspect
                            if($dataAdmsi->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI){
                                $riSuspectLK += 1;
                            }else if($dataAdmsi->jeniskelamin == Params::JENIS_KELAMIN_PEREMPUAN){
                                $riSuspectPR += 1;
                            }
                        }
                    }   
                }
            }
            
            $brigingKemenkes = new BridgingKemenkes();
                $queryInsert = '{
                    "tanggal": "'.$tanggal.'",
                    "igd_suspect_l": "'.$igdKonfirmLK.'" ,
                    "igd_suspect_p": "'.$igdKonfirmPR.'",
                    "igd_confirm_l": "'.$igdSuspectLK.'" ,
                    "igd_confirm_p": "'.$igdSuspectPR.'",
                    "rj_suspect_l": "0" ,
                    "rj_suspect_p": "0",
                    "rj_confirm_l": "0" ,
                    "rj_confirm_p": "0",
                    "ri_suspect_l": "'.$riKonfirmLK.'" ,
                    "ri_suspect_p": "'.$riKonfirmPR.'",
                    "ri_confirm_l": "'.$riSuspectLK.'" ,
                    "ri_confirm_p": "'.$riSuspectPR.'"
                    }';
            
            $dataBridgingKemenkes = $brigingKemenkes->createUpdateLapv2PasienMasuk($queryInsert);
            $decodeJsonKemenkes  = json_decode($dataBridgingKemenkes);
            
             if(isset($decodeJsonKemenkes)){
                $checksimpan = false;

                if(is_array($decodeJsonKemenkes->RekapPasienMasuk)){
                    if($decodeJsonKemenkes->RekapPasienMasuk[0]->status == '200'){
                        $checksimpan = true;
                    }
                }else{
                    if(isset($decodeJsonKemenkes->RekapPasienMasuk)){
                        if($decodeJsonKemenkes->RekapPasienMasuk->status == '200'){
                            $checksimpan = true;
                        }
                    }
                }

                if($checksimpan){
                    echo 'sukses data tersimpan di laporan pasien Masuk kemenkes';
                }
            }
            
        }
    }
    
    public function actionKemenkesLaporanPasienKeluar() {
        $modKofig = KonfigsystemK::model()->find();
        if (isset($modKofig->is_kemenkes) && $modKofig->is_kemenkes == true) {
            $tanggal = MyFormatter::formatDateTimeForDb(date('Y-m-d')); 
            $sembuh = 0;
            $meninggalKomor = 0;
            $meninggalTanpaKomor = 0;
            $isman = 0;
            $dirujuk = 0;
            
            $probusia_6hr = 0;
            $probusia_28hr = 0;
            $probusia_1th = 0;
            $probusia_4th = 0;
            $probusia_18th = 0;
            $probusia_40th = 0;
            $probusia_60th = 0;
            $probusia_60lb = 0;
            
            
            $probusia_6hr_tanpkom = 0;
            $probusia_28hr_tanpkom = 0;
            $probusia_1th_tanpkom = 0;
            $probusia_4th_tanpkom = 0;
            $probusia_18th_tanpkom = 0;
            $probusia_40th_tanpkom = 0;
            $probusia_60th_tanpkom = 0;
            $probusia_60lb_tanpkom = 0;
            
            $criterianPul = new CDbCriteria();
            $criterianPul->select = "t.pasienpulang_id, t.pasien_id, t.carakeluar_id, t.kondisikeluar_id, df.jeniskasuspenyakit_id, pas.tanggal_lahir, pas.kelompokumur_id";
            $criterianPul->group = $criterianPul->select;
            $criterianPul->join = "JOIN pendaftaran_t df ON df.pendaftaran_id = t.pendaftaran_id "
                    . " JOIN pasien_m pas ON pas.pasien_id = t.pasien_id ";
            $criterianPul->addCondition("date(t.tglpasienpulang) = '".$tanggal."'");

            $modPulang = PasienpulangT::model()->findAll($criterianPul); 
           
            if(count($modPulang) > 0){
                foreach ($modPulang as $i => $dataPull) {
                    
                    $modJenisKasusPenyakit = JeniskasuspenyakitM::model()->findByPk($dataPull->jeniskasuspenyakit_id);
                    $jeniskasus = "";
                    
                    if(isset($modJenisKasusPenyakit)){
                        $jeniskasus = $modJenisKasusPenyakit->jeniskasuspenyakit_id;
                    }
                    
                    if($dataPull->carakeluar_id == 1 && $dataPull->kondisikeluar_id == 1){
                        $sembuh += 1;
                    }
                    
                    if($dataPull->carakeluar_id == 2 && $dataPull->kondisikeluar_id == 2){
                        $dirujuk += 1;
                    }
                    
                    if($dataPull->carakeluar_id == 3 && $dataPull->kondisikeluar_id == 13){
                        $isman += 1;
                    }
                    
                    $modPasiMorbd = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id'=>$dataPull->pendaftaran_id,'kelompokdiagnosa_id'=>3));
                    
                    if(!empty($jeniskasus)){
                        if($dataPull->carakeluar_id == 4){
                            if(isset($modPasiMorbd)){
                                if($jeniskasus == 90){
                                    $meninggalKomor += 1;
                                }
                                if($jeniskasus == 91){
                                    if($dataPull->kelompokumur_id = 6){
                                        $probusia_6hr += 1;
                                    }else if($dataPull->kelompokumur_id = 5){
                                        $probusia_1th += 1;
                                    }else if($dataPull->kelompokumur_id = 1){
                                        $probusia_4th_tanpkom += 1;
                                    }else if($dataPull->kelompokumur_id = 2){
                                        $probusia_18th += 1;
                                    }else if($dataPull->kelompokumur_id = 3){
                                        $probusia_60th += 1;
                                    }else if($dataPull->kelompokumur_id = 4){
                                        $probusia_60lb += 1;
                                    }
                                }
                                
                            }else{
                                if($jeniskasus == 90){
                                    $meninggalTanpaKomor += 1;
                                }
                                
                                if($jeniskasus == 91){
                                    if($dataPull->kelompokumur_id = 6){
                                        $probusia_6hr_tanpkom += 1;
                                    }else if($dataPull->kelompokumur_id = 5){
                                        $probusia_1th_tanpkom += 1;
                                    }else if($dataPull->kelompokumur_id = 1){
                                        $probusia_4th += 1;
                                    }else if($dataPull->kelompokumur_id = 2){
                                        $probusia_18th_tanpkom += 1;
                                    }else if($dataPull->kelompokumur_id = 3){
                                        $probusia_60th_tanpkom += 1;
                                    }else if($dataPull->kelompokumur_id = 4){
                                        $probusia_60lb_tanpkom += 1;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            
            
            $brigingKemenkes = new BridgingKemenkes();
                $queryInsert = '{
                    "tanggal": "'.$tanggal.'",
                    "sembuh": "'.$sembuh.'" ,
                    "discarded": "0",
                    "meninggal_komorbid": "'.$meninggalKomor.'" ,
                    "meninggal_tanpa_komorbid": "'.$meninggalTanpaKomor.'",
                    "meninggal_prob_pre_komorbid": "'.$probusia_6hr.'" ,
                    "meninggal_prob_neo_komorbid": "'.$probusia_28hr.'",
                    "meninggal_prob_bayi_komorbid": "'.$probusia_1th.'",
                    "meninggal_prob_balita_komorbid": "'.$probusia_4th.'",
                    "meninggal_prob_anak_komorbid": "'.$probusia_18th.'",
                    "meninggal_prob_remaja_komorbid": "'.$probusia_40th.'",
                    "meninggal_prob_dws_komorbid": "'.$probusia_60th.'",
                    "meninggal_prob_lansia_komorbid": "'.$probusia_60lb.'",
                    "meninggal_prob_pre_tanpa_komorbid": "'.$probusia_6hr_tanpkom.'",
                    "meninggal_prob_neo_tanpa_komorbid": "'.$probusia_28hr_tanpkom.'",
                    "meninggal_prob_bayi_tanpa_komorbid": "'.$probusia_1th_tanpkom.'",
                    "meninggal_prob_balita_tanpa_komorbid": "'.$probusia_4th_tanpkom.'",
                    "meninggal_prob_anak_tanpa_komorbid": "'.$probusia_18th_tanpkom.'",
                    "meninggal_prob_remaja_tanpa_komorbid": "'.$probusia_40th_tanpkom.'",
                    "meninggal_prob_dws_tanpa_komorbid": "'.$probusia_60th_tanpkom.'",
                    "meninggal_prob_lansia_tanpa_komorbid": "'.$probusia_60lb_tanpkom.'",
                    "meninggal_discarded_komorbid": "0",
                    "meninggal_discarded_tanpa_komorbid": "0",
                    "dirujuk": "'.$dirujuk.'",
                    "isman": "'.$isman.'",
                    "aps": "0"
                    }';
            
            $dataBridgingKemenkes = $brigingKemenkes->createUpdateLapv2PasienKeluar($queryInsert);
            $decodeJsonKemenkes  = json_decode($dataBridgingKemenkes);
            
             if(isset($decodeJsonKemenkes)){
                $checksimpan = false;

                if(is_array($decodeJsonKemenkes->RekapPasienKeluar)){
                    if($decodeJsonKemenkes->RekapPasienKeluar[0]->status == '200'){
                        $checksimpan = true;
                    }
                }else{
                    if(isset($decodeJsonKemenkes->RekapPasienKeluar)){
                        if($decodeJsonKemenkes->RekapPasienKeluar->status == '200'){
                            $checksimpan = true;
                        }
                    }
                }

                if($checksimpan){
                    echo 'sukses data tersimpan di laporan pasien Keluar kemenkes';
                }
            }
            
        }
    }
}
