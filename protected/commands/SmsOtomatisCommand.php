<?php
Yii::import('application.models.PasienM');
Yii::import('application.models.PegawaiM');
Yii::import('application.models.RuanganM');
Yii::import('application.models.BuatjanjipoliT');
Yii::import('application.models.ProfilrumahsakitM');
Yii::import('application.models.BookingkamarT');
Yii::import('application.models.PendaftaranT');
Yii::import('application.models.SmsgatewayM');
Yii::import('application.models.Outbox');
Yii::import('application.models.OutboxMultipart');
Yii::import('application.components.Params');
Yii::import('application.components.Sms');
Yii::import('application.components.MyFormatter');
class SmsOtomatisCommand extends CConsoleCommand {
 
 
		public function actionUlangtahunPasien() {
				$smsgateway = SmsgatewayM::model()->findByPk(Params::SMSGATEWAY_ULANGTAHUN_PASIEN);

				$sql = "SELECT * FROM pasien_m WHERE DATE_PART('DAY', tanggal_lahir) = DATE_PART('DAY', CURRENT_DATE) AND DATE_PART('MONTH', tanggal_lahir) = DATE_PART('MONTH', CURRENT_DATE)";
				$modPasien = Yii::app()->db->createCommand($sql)->queryAll();

				if(count($modPasien) > 0){
					// SMS GATEWAY
					foreach ($modPasien as $i => $pasien) {
						$sms = new Sms();
						$isiPesan = $smsgateway->templatesms;
						$modelPasien = PasienM::model()->findByPk($pasien['pasien_id']);
						$attributes = $modelPasien->getAttributes();
						foreach($attributes as $attributes => $value){
							$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
						}
						$isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modelPasien->tanggal_lahir),$isiPesan);
						
						if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
							if(!empty($modelPasien->no_mobile_pasien)){
								$sms->kirimOtomatis($modelPasien->no_mobile_pasien,$isiPesan);
							}
						}
					}
					// END SMS GATEWAY
				}
		}

		public function actionUlangtahunPegawai() {
				$smsgateway = SmsgatewayM::model()->findByPk(Params::SMSGATEWAY_ULANGTAHUN_PEGAWAI);

				$sql = "SELECT * FROM pegawai_m WHERE DATE_PART('DAY', tgl_lahirpegawai) = DATE_PART('DAY', CURRENT_DATE) AND DATE_PART('MONTH', tgl_lahirpegawai) = DATE_PART('MONTH', CURRENT_DATE)";
				$modPegawai = Yii::app()->db->createCommand($sql)->queryAll();

				if(count($modPegawai) > 0){
					// SMS GATEWAY
					foreach ($modPegawai as $i => $pegawai) {
						$sms = new Sms();
						$isiPesan = $smsgateway->templatesms;
						$modelPegawai = PegawaiM::model()->findByPk($pegawai['pegawai_id']);
						$attributes = $modelPegawai->getAttributes();
						foreach($attributes as $attributes => $value){
							$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
						}
						$isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modelPegawai->tgl_lahirpegawai),$isiPesan);
						
						if($smsgateway->tujuansms == Params::TUJUANSMS_PEGAWAI && $smsgateway->statussms){
							if(!empty($modelPegawai->nomobile_pegawai)){
								$sms->kirimOtomatis($modelPegawai->nomobile_pegawai,$isiPesan);
							}
						}
					}
					// END SMS GATEWAY
				}
		}

		public function actionPemberitahuanJanjiPoliPasien() {
			$smsgateway = SmsgatewayM::model()->findByPk(Params::SMSGATEWAY_PEMBERITAHUAN_JANJI_POLIKLINIK_PASIEN);

			$sql = "select *
					from buatjanjipoli_t 
					WHERE DATE_PART('DAY',tgljadwal) = DATE_PART('DAY', CURRENT_DATE) 
					AND DATE_PART('MONTH', tgljadwal) = DATE_PART('MONTH', CURRENT_DATE) 
					AND DATE_PART('YEAR', tgljadwal) = DATE_PART('YEAR', CURRENT_DATE)";
			$modJanjiPoli = Yii::app()->db->createCommand($sql)->queryAll();

			if(count($modJanjiPoli) > 0){
				// SMS GATEWAY
				foreach ($modJanjiPoli as $i => $janjiPoli) {
					$sms = new Sms();
					$isiPesan = $smsgateway->templatesms;
					$modelPegawai = PegawaiM::model()->findByPk($janjiPoli['pegawai_id']);
					$attributes = $modelPegawai->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					$modelPasien = PasienM::model()->findByPk($janjiPoli['pasien_id']);
					$attributes = $modelPasien->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					$modelRuangan = RuanganM::model()->findByPk($janjiPoli['ruangan_id']);
					$attributes = $modelRuangan->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					$modelJanjiPoli = BuatjanjipoliT::model()->findByPk($janjiPoli['buatjanjipoli_id']);
					$attributes = $modelJanjiPoli->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					$modelProfil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
					$attributes = $modelProfil->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}

					if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
						if(!empty($modelPasien->no_mobile_pasien)){
							$sms->kirimOtomatis($modelPasien->no_mobile_pasien,$isiPesan);
						}
					}
				}
				// END SMS GATEWAY
			}
		}

		public function actionPemberitahuanJanjiPoliPegawai() {
			$smsgateway = SmsgatewayM::model()->findByPk(Params::SMSGATEWAY_PEMBERITAHUAN_JANJI_POLIKLINIK_DOKTER);

			$sql = "select *
					from buatjanjipoli_t 
					WHERE DATE_PART('DAY',tgljadwal) = DATE_PART('DAY', CURRENT_DATE) 
					AND DATE_PART('MONTH', tgljadwal) = DATE_PART('MONTH', CURRENT_DATE) 
					AND DATE_PART('YEAR', tgljadwal) = DATE_PART('YEAR', CURRENT_DATE)";
			$modJanjiPoli = Yii::app()->db->createCommand($sql)->queryAll();

			if(count($modJanjiPoli) > 0){
				// SMS GATEWAY
				foreach ($modJanjiPoli as $i => $janjiPoli) {
					$sms = new Sms();
					$isiPesan = $smsgateway->templatesms;
					$modelPegawai = PegawaiM::model()->findByPk($janjiPoli['pegawai_id']);
					$attributes = $modelPegawai->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					$modelPasien = PasienM::model()->findByPk($janjiPoli['pasien_id']);
					$attributes = $modelPasien->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					$modelRuangan = RuanganM::model()->findByPk($janjiPoli['ruangan_id']);
					$attributes = $modelRuangan->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					$modelJanjiPoli = BuatjanjipoliT::model()->findByPk($janjiPoli['buatjanjipoli_id']);
					$attributes = $modelJanjiPoli->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					$modelProfil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
					$attributes = $modelProfil->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					
					if($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms){
						if(!empty($modelPegawai->nomobile_pegawai)){
							$sms->kirimOtomatis($modelPegawai->nomobile_pegawai,$isiPesan);
						}
					}
				}
				// END SMS GATEWAY
			}
		}

		public function actionStatusPesanKamar() {
			$smsgateway = SmsgatewayM::model()->findByPk(Params::SMSGATEWAY_STATUS_KONFIMASI_PESAN_KAMAR);

			$sql = "select *
					from bookingkamar_t 
					WHERE DATE_PART('DAY',tglbookingkamar) = DATE_PART('DAY', CURRENT_DATE) 
					AND DATE_PART('MONTH', tglbookingkamar) = DATE_PART('MONTH', CURRENT_DATE) 
					AND DATE_PART('YEAR', tglbookingkamar) = DATE_PART('YEAR', CURRENT_DATE)";
			$modBookingKamar = Yii::app()->db->createCommand($sql)->queryAll();

			if(count($modBookingKamar) > 0){
				// SMS GATEWAY
				foreach ($modBookingKamar as $i => $bookingKamar) {
					$sms = new Sms();
					$isiPesan = $smsgateway->templatesms;
	
					$modelPasien = PasienM::model()->findByPk($bookingKamar['pasien_id']);
					$attributes = $modelPasien->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					$modelRuangan = RuanganM::model()->findByPk($bookingKamar['ruangan_id']);
					$attributes = $modelRuangan->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					$modelBookingKamar = BookingkamarT::model()->findByPk($bookingKamar['bookingkamar_id']);
					$attributes = $modelBookingKamar->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					$modelProfil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
					$attributes = $modelProfil->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}

					$isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modelPendaftaran->tglbookingkamar),$isiPesan);
					
					if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $modelBookingKamar->statussms){
						if(!empty($modelPasien->no_mobile_pasien)){
							$sms->kirimOtomatis($modelPasien->no_mobile_pasien,$isiPesan);
						}
					}
				}
				// END SMS GATEWAY
			}
		}

		public function actionRencanaKontrolPasien() {
                    $smsgateway = SmsgatewayM::model()->findByPk(Params::SMSGATEWAY_RENCANAKONTROL_PASIEN);

                    $date = date('Y-m-d', strtotime('-1 day'));                    
                    //$sql = "select *
                      //              from pendaftaran_t 
                        //            WHERE DATE_PART('DAY',tglrenkontrol) = DATE_PART('DAY', CURRENT_DATE) 
                          //          AND DATE_PART('MONTH', tglrenkontrol) = DATE_PART('MONTH', CURRENT_DATE) 
                            //        AND DATE_PART('YEAR', tglrenkontrol) = DATE_PART('YEAR', CURRENT_DATE)";
                    
                    
                   // $modRencanaKontrol = Yii::app()->db->createCommand($sql)->queryAll();
                    
                    $sql = "select *
                                    from pendaftaran_t 
                                    WHERE DATE(tglrenkontrol) = '".$date."' ";
                    
                    
                   $modRencanaKontrol = Yii::app()->db->createCommand($sql)->queryAll();
                                        

                    if(count($modRencanaKontrol) > 0){
                            // SMS GATEWAY
                            foreach ($modRencanaKontrol as $i => $rencanaKontrol) {
                                    $sms = new Sms();
                                    $isiPesan = $smsgateway->templatesms;
                                    $modelPegawai = PegawaiM::model()->findByPk($rencanaKontrol['pegawai_id']);
                                    $attributes = $modelPegawai->getAttributes();
                                    foreach($attributes as $attributes => $value){
                                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                    }
                                    $modelPasien = PasienM::model()->findByPk($rencanaKontrol['pasien_id']);
                                    $attributes = $modelPasien->getAttributes();
                                    foreach($attributes as $attributes => $value){
                                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                    }
                                    $modelRuangan = RuanganM::model()->findByPk($rencanaKontrol['ruangan_id']);
                                    $attributes = $modelRuangan->getAttributes();
                                    foreach($attributes as $attributes => $value){
                                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                    }
                                    $modelPendaftaran = PendaftaranT::model()->findByPk($rencanaKontrol['pendaftaran_id']);
                                    $attributes = $modelPendaftaran->getAttributes();
                                    foreach($attributes as $attributes => $value){
                                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                    }
                                    $modelProfil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
                                    $attributes = $modelProfil->getAttributes();
                                    foreach($attributes as $attributes => $value){
                                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                    }

                                    $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modelPendaftaran->tglrenkontrol),$isiPesan);

                                    if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                            if(!empty($modelPasien->no_mobile_pasien)){
                                                    $sms->kirimOtomatis($modelPasien->no_mobile_pasien,$isiPesan);
                                            }
                                    }
                            }
                            // END SMS GATEWAY
                            
                           
                    }                                              
		}

		public function actionRencanaKontrolPegawai() {
			$smsgateway = SmsgatewayM::model()->findByPk(Params::SMSGATEWAY_RENCANAKONTROL_DOKTER);

			$sql = "select *
					from pendaftaran_t 
					WHERE DATE_PART('DAY',tglrenkontrol) = DATE_PART('DAY', CURRENT_DATE) 
					AND DATE_PART('MONTH', tglrenkontrol) = DATE_PART('MONTH', CURRENT_DATE) 
					AND DATE_PART('YEAR', tglrenkontrol) = DATE_PART('YEAR', CURRENT_DATE)";
			$modRencanaKontrol = Yii::app()->db->createCommand($sql)->queryAll();

			if(count($modRencanaKontrol) > 0){
				// SMS GATEWAY
				foreach ($modRencanaKontrol as $i => $rencanaKontrol) {
					$sms = new Sms();
					$isiPesan = $smsgateway->templatesms;
					$modelPegawai = PegawaiM::model()->findByPk($rencanaKontrol['pegawai_id']);
					$attributes = $modelPegawai->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					$modelPasien = PasienM::model()->findByPk($rencanaKontrol['pasien_id']);
					$attributes = $modelPasien->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					$modelRuangan = RuanganM::model()->findByPk($rencanaKontrol['ruangan_id']);
					$attributes = $modelRuangan->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					$modelPendaftaran = PendaftaranT::model()->findByPk($rencanaKontrol['pendaftaran_id']);
					$attributes = $modelPendaftaran->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					$modelProfil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
					$attributes = $modelProfil->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}

					$isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modelPendaftaran->tglrenkontrol),$isiPesan);

					if($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms){
						if(!empty($modelPegawai->nomobile_pegawai)){
							$sms->kirimOtomatis($modelPegawai->nomobile_pegawai,$isiPesan);
						}
					}
				}
				// END SMS GATEWAY
			}
		}

		public function actionJatuhTempoPinjaman() {
			$smsgateway = SmsgatewayM::model()->findByPk(Params::SMSGATEWAY_JATUHTEMPO_PINJAMAN);
			$sql = "select *
				from pinjamanpeg_t 
				WHERE DATE_PART('DAY',tgljatuhtempo) = DATE_PART('DAY', CURRENT_DATE) 
				AND DATE_PART('MONTH', tgljatuhtempo) = DATE_PART('MONTH', CURRENT_DATE) 
				AND DATE_PART('YEAR', tgljatuhtempo) = DATE_PART('YEAR', CURRENT_DATE)";
			$modPinjaman = Yii::app()->db->createCommand($sql)->queryAll();

			if(count($modPinjaman) > 0){
				// SMS GATEWAY
				foreach ($modPinjaman as $i => $pinjaman) {
					$sms = new Sms();
					$isiPesan = $smsgateway->templatesms;
					$modelPegawai = PegawaiM::model()->findByPk($pinjaman['pegawai_id']);
					$attributes = $modelPegawai->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					$attributes = $pinjaman;
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}

					$isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($pinjaman['tgljatuhtempo']),$isiPesan);
					
					if($smsgateway->tujuansms == Params::TUJUANSMS_PEGAWAI && $smsgateway->statussms){
						if(!empty($modelPegawai->nomobile_pegawai)){
							$sms->kirimOtomatis($modelPegawai->nomobile_pegawai,$isiPesan);
						}
					}
				}
				// END SMS GATEWAY
			}
		}

		public function actionJatuhTempoHutang() {
			$smsgateway = SmsgatewayM::model()->findByPk(Params::SMSGATEWAY_JATUHTEMPO_HUTANG);

			$sql = "select *
				from pembayaranpelayanan_t 
				WHERE DATE_PART('DAY',tgljatuhtempo) = DATE_PART('DAY', CURRENT_DATE) 
				AND DATE_PART('MONTH', tgljatuhtempo) = DATE_PART('MONTH', CURRENT_DATE) 
				AND DATE_PART('YEAR', tgljatuhtempo) = DATE_PART('YEAR', CURRENT_DATE)";
			$modHutang = Yii::app()->db->createCommand($sql)->queryAll();

			if(count($modHutang) > 0){
				// SMS GATEWAY
				foreach ($modHutang as $i => $hutang) {
					$sms = new Sms();
					$isiPesan = $smsgateway->templatesms;
					$modelPasien = PasienM::model()->findByPk($hutang['pasien_id']);
					$attributes = $modelPasien->getAttributes();
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					$attributes = $hutang;
					foreach($attributes as $attributes => $value){
						$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
					}
					
					$isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($hutang['tgljatuhtempo']),$isiPesan);
					if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
						if(!empty($modelPasien->no_mobile_pasien)){
							$sms->kirimOtomatis($modelPasien->no_mobile_pasien,$isiPesan);
						}
					}
				}
				// END SMS GATEWAY
			}
		}
                
    public function actionPasienPulang() {
        $smsgateway = SmsgatewayM::model()->findByPk(Params::SMSGATEWAY_JATUHTEMPO_HUTANG);

        $sql = "select *
                from pembayaranpelayanan_t 
                WHERE DATE_PART('DAY',tgljatuhtempo) = DATE_PART('DAY', CURRENT_DATE) 
                AND DATE_PART('MONTH', tgljatuhtempo) = DATE_PART('MONTH', CURRENT_DATE) 
                AND DATE_PART('YEAR', tgljatuhtempo) = DATE_PART('YEAR', CURRENT_DATE)";
        $modHutang = Yii::app()->db->createCommand($sql)->queryAll();

        if(count($modHutang) > 0){
                // SMS GATEWAY
                foreach ($modHutang as $i => $hutang) {
                        $sms = new Sms();
                        $isiPesan = $smsgateway->templatesms;
                        $modelPasien = PasienM::model()->findByPk($hutang['pasien_id']);
                        $attributes = $modelPasien->getAttributes();
                        foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }
                        $attributes = $hutang;
                        foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }

                        $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($hutang['tgljatuhtempo']),$isiPesan);
                        if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                if(!empty($modelPasien->no_mobile_pasien)){
                                        $sms->kirimOtomatis($modelPasien->no_mobile_pasien,$isiPesan);
                                }
                        }
                }
                // END SMS GATEWAY
        }
}
                
 
}