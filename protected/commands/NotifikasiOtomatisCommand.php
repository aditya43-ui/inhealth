<?php
/**   command ini digunakan pada cronjob (realtime proses), fungsi ini digunakan untuk memberikan notifikasi 
 * 
 *	@category	Notifikasi
 *	@author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *	@website	<https://piindonesia.co.id>
 */

class NotifikasiOtomatisCommand extends CConsoleCommand {
  
    /**
     * Notifikasi reminder SMS pada Jadwal Rehab dan 
     */
    public function actionReminderJadwalRehabHemo() {
        
        $sms = new Sms();
        
        $ok = true;
        
        $profil = ProfilrumahsakitM::model()->find();
        $jadwalRehab = JadwalrehabmedisT::model()->findAllByAttributes(array(
            'jadwalrehabmedis_tgl_ke'=>date('Y-m-d', strtotime('+1 day')),
        ), array(
            'condition'=>'pendaftaran_id is null',
        ));
        
        $jadwalHemo = JadwalhemodialisaT::model()->findAllByAttributes(array(
            'jadwalhemodialisa_tgl_ke'=>date('Y-m-d', strtotime('+1 day')),
        ), array(
            'condition'=>'pendaftaran_id is null',
        ));
        
        $ruanganFisio = RuanganM::model()->findByPk(Params::RUANGAN_ID_FISIOTERAPI);
        $ruanganHemo = RuanganM::model()->findByPk(Params::RUANGAN_ID_HEMODIALISA);
        
        foreach ($jadwalRehab as $item) {

            $pasien = PasienM::model()->findByPk($item->pasien_id);
            $shift = ShiftM::model()->findByPk($item->shift_id);

            $jam_awal = empty($shift) ? '08:00:00' : $shift->shift_jamawal;

            $this->kirimSMSFisioHemo(
                $sms,
                $pasien, 
                "Fisioterapi", 
                $item->jadwalrehabmedis_hari, 
                $item->jadwalrehabmedis_tgl_ke, 
                $jam_awal, 
                $profil->nama_rumahsakit,
                $ruanganFisio
            );
        }


        foreach ($jadwalHemo as $item) {

            $pasien = PasienM::model()->findByPk($item->pasien_id);
            $shift = ShiftM::model()->findByPk($item->shift_id);

            $jam_awal = empty($shift) ? '08:00:00' : $shift->shift_jamawal;
            $this->kirimSMSFisioHemo(
                $sms,
                $pasien, 
                "Hemodialisa", 
                $item->jadwalhemodialisa_hari, 
                $item->jadwalhemodialisa_tgl_ke, 
                $jam_awal, 
                $profil->nama_rumahsakit,
                $ruanganHemo
            );
        }
        
    }
    
    public function kirimSMSFisioHemo($sms, $pasien, $nama_ruangan, $hari, $tanggal, $jam_awal, $profil_rs, $ruangan) {
        $format = 'Selamat pagi, {nama_pasien} ({no_rekam_medik}). Besok adalah jadwal Anda mendaftar ke {ruangan} pada {hari} {tgl} jam {shift_jamawal}. Terima Kasih. '.$profil_rs;
        
        $formatNotif = "Pasien : {nama_pasien} ({no_rekam_medik})<br/>Waktu Daftar : {hari} {tgl} jam {shift_jamawal}<br/>Ruangan : {ruangan}";
        $judulNotif = "Jadwal Daftar Pasien {ruangan} untuk Besok";
        
        try {

            foreach ($pasien->attributes as $param => $value) {
                $format = str_replace('{'.$param.'}', $value, $format);
                $formatNotif = str_replace('{'.$param.'}', $value, $formatNotif);
            }

            $format = str_replace('{ruangan}', $nama_ruangan, $format);
            $format = str_replace('{hari}', $hari, $format);
            $format = str_replace('{tgl}', MyFormatter::formatDateTimeForUser($tanggal), $format);
            $format = str_replace('{shift_jamawal}', $jam_awal, $format);
            
            
            $judulNotif = str_replace('{ruangan}', $nama_ruangan, $judulNotif);
            
            $formatNotif = str_replace('{ruangan}', $nama_ruangan, $formatNotif);
            $formatNotif = str_replace('{hari}', $hari, $formatNotif);
            $formatNotif = str_replace('{tgl}', MyFormatter::formatDateTimeForUser($tanggal), $formatNotif);
            $formatNotif = str_replace('{shift_jamawal}', $jam_awal, $formatNotif);

            
            
            
            if (!empty($pasien->no_mobile_pasien)) {
                $sms->kirimOtomatis($pasien->no_mobile_pasien, $format);
                print_r("Kirim SMS : OK -- ".$pasien->nama_pasien." - ".$pasien->no_rekam_medik." - ".$pasien->no_mobile_pasien."\n");
            } else {
                print_r("Kirim SMS : NO -- ".$pasien->nama_pasien." - ".$pasien->no_rekam_medik." - Nomor tidak ada.\n");
            }
            
            
            $ok = CustomFunction::broadcastNotifCron($judulNotif, $formatNotif, array(
                    array('instalasi_id'=>$ruangan->instalasi_id, 'ruangan_id'=>$ruangan->ruangan_id, 'modul_id'=> $ruangan->modul_id),
            ));
            
        
        } catch (Exception $e) {
            print_r($e->getTraceAsString());
        }
    }
    
    /**
    * - digunakan untuk mengirim notifikasi ke kasir dan loket pendaftaran, 
    *   jika penjamin umum yang sudah berencana akan pindah ke BPJS pada saat pendaftaran.
    *   sudah mendekati hari H waktu batas untuk melakukan perubahan ke BPJS
    *   biasanya dihitung 1 x 24 jam
    */
    public function actionPenjaminUmumKeBpjs() {
        $date = date('Y-m-d',strtotime('-1 day', strtotime(date('Y-m-d'))));
        
        $pen = PendaftaranT::model()->findAll(" isumumkebpjs = TRUE AND DATE(tgl_pendaftaran) = '".$date."' ");
        
        $judul = " Konfirmasi Pasien Penjamin Umum Ke BPJS ";
        
        if (count($pen)>0){
            foreach ($pen as $dt){
                $isi =      "No. Pendaftaran ".$dt->no_pendaftaran.", atas nama ".$dt->pasien->nama_pasien." "
                        .   "dengan nomor rekam medik ".$dt->pasien->no_rekam_medik.", diharapkan untuk melakukan konfirmasi perubahan ke penjamin BPJS";
                
                $ok = CustomFunction::broadcastNotifCron($judul, $isi, array(
                        array('instalasi_id'=>Params::INSTALASI_ID_RM, 'ruangan_id'=> Params::RUANGAN_ID_LOKET, 'modul_id'=> Params::MODUL_ID_PENDAFTARAN),
                        array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=> Params::MODUL_ID_BILLINGKASIR),
                ));  
            }
            
            print_r("Notifikasi Konfirmasi Pasien Penjamin Umum ke BPJS sudah dikirimkan pada tanggal ".MyFormatter::formatDateTimeForUser(date('Y-m-d'))." \n");
        }else{
            print_r("....\n");
        }
        
        
    }
    
    /**
    * - digunakan untuk mengirim notifikasi ke gudang farmasi dan apotek farmasi, 
    *   jika obat alkes dalam 3 bulan lagi akan menuju tanggal kedaluwarsa, maka
    *   notifikasi akan dikirimkan
    *   
    */
    public function actionObatAlkesKadaluarsa() {
        $date = date('Y-m-d',strtotime('+3 month', strtotime(date('Y-m-d'))));
        
        $cri = new CDbCriteria;
        $cri->select = "ruangan_id,harganetto,instalasi_nama, ruangan_nama,obatalkes_id,obatalkes_nama,obatalkes_golongan,obatalkes_kategori,jenisobatalkes_id,jenisobatalkes_nama,obatalkes_kode,satuankecil_nama, tglkadaluarsa";                                        
        $cri->addCondition(" DATE(tglkadaluarsa) = '".$date."' ");
        $cri->group = 'ruangan_id,harganetto,instalasi_nama, ruangan_nama,obatalkes_id, obatalkes_nama,obatalkes_golongan,obatalkes_kategori, jenisobatalkes_id,jenisobatalkes_nama,obatalkes_kode,satuankecil_nama, tglkadaluarsa';
        
        $expired = InfostokobatalkesruanganV::model()->findAll($cri);
        
        $judul = " Obat dan Alkes Kedaluwarsa ";
        
        if (count($expired)>0){
            $isi =  "Berikut daftar list obat & alkes, yang akan kedaluwarsa 3 bulan lagi (".MyFormatter::formatDateTimeForUser($date)."), yaitu :";
            $isi .= "<ol>";
            foreach ($expired as $dt){
                $isi .= "<li>".$dt->obatalkes_nama." (".$dt->ruangan_nama.")</li>";
                                 
            }
            $isi .= "</ol>";
            $ok = CustomFunction::broadcastNotifCron($judul, $isi, array(
                    array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=> Params::RUANGAN_ID_GUDANG_FARMASI, 'modul_id'=> Params::MODUL_ID_GUDANGFARMASI),
                    array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_1, 'modul_id'=> Params::MODUL_ID_APOTEK),
            )); 
            
            print_r("Notifikasi Obat dan Alkes Kedaluwarsa sudah dikirimkan pada tanggal ".MyFormatter::formatDateTimeForUser(date('Y-m-d'))." \n");
        }else{
            print_r("....\n");
        }
        
        
    }
    
    /**
    * - digunakan untuk mengirim notifikasi ke kasir dan rawat inap, 
    *   jika pasien rawat inap sudah menginap lebih dari 3 hari.
    *   
    *   
    */
    public function actionRawatInapDeposit() {
        $date = date('Y-m-d H:i:00',strtotime('-3 day', strtotime(date('Y-m-d H:i:00'))));
        
        $pen = InfopasienmasukkamarV::model()->findAll(" date(tglmasukkamar) = '".date('Y-m-d',strtotime($date))."' ");
        	
        $judul = " Pasien Rawat Inap Lebih dari 3 hari ";
        $kirim = false;
        
        if (count($pen)>0){
            
            foreach ($pen as $dt){
                //print_r(date('Y-m-d H:i:00', strtotime($dt->tglmasukkamar)));
                if (date('Y-m-d H:i:00', strtotime($dt->tglmasukkamar)) == $date){
                    
                    $isi =      "Pasien Admisi, atas nama ".$dt->nama_pasien." (".$dt->no_pendaftaran.") "
                            .   "dengan nomor rekam medik ".$dt->no_rekam_medik.", diharapkan untuk melakukan konfirmasi pengisian deposit";

                    $r = RuanganM::model()->findByPk($dt->ruangan_id);
                    
                    $ok = CustomFunction::broadcastNotifCron($judul, $isi, array(
                            array('instalasi_id'=>$dt->instalasi_id, 'ruangan_id'=> $dt->ruangan_id, 'modul_id'=> $r->modul_id),
                            array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=> Params::MODUL_ID_BILLINGKASIR),
                    ));  
                    $kirim = true;
                }
            }
            if ($kirim){
                print_r("Notifikasi Pemberitahuan Pasien Rawat Inap sudah lebih dari 3 hari Pasien sudah dikirimkan pada tanggal ".MyFormatter::formatDateTimeForUser(date('Y-m-d'))."  \n");
            }else{
                print_r("....\n");
            }
        }else{
            print_r("....\n");
        }
        
        
    }
    
    
     /**
    * - digunakan untuk mengirim notifikasi ke kasir, 
    *   jika penagihan/pengajuan klaim piutang sudah mencapai 5jt
    */
    public function actionEarlyKlaimPiutang() {
        $cekAsuransi = PengajuanklaimdetailT::model()->getAllAsutansi();
        if (count($cekAsuransi)>0){                                                    
            $judul = "Penagihan Klaim Piutang";
            $isi =      "Berikut list penjamin asuransi, yang sudah mencapat limit 5jt untuk penagihan klaim piutang, pada tanggal ".MyFormatter::formatDateTimeForUser(date('Y-m-d')).' :';                                                                                                    
            $isi .="<ol>";
            $count = 0;
            foreach ($cekAsuransi as $ck){
                $kurang = $ck->piutang - $ck->telahbayar;
                if ($kurang > 5000000){
                    $isi .= '<li>'.$ck->penjamin_nama.'</li>';
                    $count = $count + 1;
                }else{
                    $count = $count + 0;
                }
            }
            $isi .="</ol>";            
            
            if ($count > 0){
                $ok = CustomFunction::broadcastNotifCron($judul, $isi, array(
                    array('instalasi_id'=> Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_FINANCE, 'modul_id'=> Params::MODUL_ID_KEUANGAN),                                                        
                ));  
                
                print_r("Notifikasi penagihan klaim piutang sudah dikirim\n");
            }else{
                print_r("...\n");
            }
            
            
        }else{
            print_r("...\n");
        }
        
        
    }
	
	
	/**
    * - digunakan untuk mengirim notifikasi ke kepegawaian
    *   jika pegawai kontrak masa aktifnya sudah habis
    *   notifikasi akan dikirimkan
    *   
    */
    public function actionHabisPegawaiKontrak() {
        $date = date('Y-m-d');
        
       $cri = new CDbCriteria();
		$cri->addCondition(" pegawai_aktif = TRUE ");
		$cri->addCondition("date(tglmasaaktifpeg_sd) < '".$date."' " );
		$cri->addCondition(" LOWER(kategoripegawai) = '".strtolower(Params::KATEGORI_PEGAWAI_KONTRAK)."' ");		
		$cri->order = " nama_pegawai ASC "; 
		$pegawai = PegawaiM::model()->findAll($cri);
        
        $judul = " Masa Aktif Kerja Pegawai Sudah Habis ";
        
        if (count($pegawai)>0){
			$i = 1;
			$isi =  "Berikut list pegawai kontrak yang masa aktif kerjanya sudah habis, yaitu :<br/>";
			foreach ($pegawai as $peg){
				$isi .= $i.". ".$peg->nomorindukpegawai.' '.$peg->nama_pegawai.' - (</span> masa aktif kerja pegawai berakhir pada '.' - '.  MyFormatter::formatDateTimeForUser($peg->tglmasaaktifpeg_sd).')<br/>';
				$i++;
			}
			
            
           
            $ok = CustomFunction::broadcastNotifCron($judul, $isi, array(
                    array('instalasi_id'=>Params::INSTALASI_ID_KEPEGAWAIAN, 'ruangan_id'=> Params::RUANGAN_ID_KEPEGAWAIAN, 'modul_id'=>Params::MODUL_ID_KEPEGAWAIAN ),										   			   
            )); 
            
            print_r("Notifikasi pegawai kontrak sudah melebihi hari aktif kerjanya, sudah dikirimkan pada tanggal ".MyFormatter::formatDateTimeForUser(date('Y-m-d'))." \n");
        }else{
            print_r("....\n");
        }                
    }
	
	/**
    * - digunakan untuk mengirim notifikasi ke kepegawaian
    *   jika pegawai tidak hadir pada hari kemarin
    *   notifikasi akan dikirimkan
    *   
    */
    public function actionPegawaiTidakHadir() {
        $date = date('Y-m-d');
        
		$cri = new CDbCriteria();
		
		$tgl = date('Y-m-d', strtotime('-1 days'));
		
		$harilibur = HariliburM::model()->findAll(" harilibur_aktif = TRUE AND DATE(tglharilibur) = '".$tgl."' ");
		//var_dump(count($harilibur));
		
		$sqlPresensi = "select 
					pg.pegawai_id,
					pg.jabatan_id,
					peg.tgl,
					pg.kelompokpegawai_id,
					hr.periodeharikerjaawl,
					hr.periodeharikerjaakhir, 
					peg.statusscan_id,
					peg.shift_id
				from 
					pegawai_m pg
				LEFT JOIN (
					select 
						p.pegawai_id, 
						p.kelompokpegawai_id,
						date(pr.tglpresensi) as tgl,
						pr.statusscan_id,
						pr.shift_id
					from 
						pegawai_m p
					JOIN 
						presensi_t pr On pr.pegawai_id = p.pegawai_id    
					WHERE 
						date(pr.tglpresensi) = '".$tgl."' AND pr.statusscan_id = ".Params::STATUSSCAN_MASUK."
					group by
						p.pegawai_id, 
						p.kelompokpegawai_id,
						date(pr.tglpresensi),
						pr.statusscan_id,
						pr.shift_id
				ORDER BY p.pegawai_id
				) as peg ON peg.pegawai_id = pg.pegawai_id
				LEFT JOIN harikerjagol_m hr ON hr.kelompokpegawai_id = pg.kelompokpegawai_id				
				";
		
		$qPresensi = Yii::app()->db->createCommand($sqlPresensi)->queryAll();
		
		$sqlJadwal = "select
							pg.pegawai_id,
							pg.jabatan_id,
							peg.tgl,
							pg.kelompokpegawai_id,
							hr.periodeharikerjaawl,
							hr.periodeharikerjaakhir 
						from 
							pegawai_m pg
						LEFT JOIN (
							select 
								p.pegawai_id, 
								p.kelompokpegawai_id,
								date(pr.tgljadwalpegawai) as tgl
							from 
								pegawai_m p
							JOIN 
								penjadwalandetail_t pr On pr.pegawai_id = p.pegawai_id    
							WHERE 
								date(pr.tgljadwalpegawai) = '".$tgl."'
							group by
								p.pegawai_id, 
								p.kelompokpegawai_id,
								date(pr.tgljadwalpegawai)
						ORDER BY p.pegawai_id
						) as peg ON peg.pegawai_id = pg.pegawai_id
					LEFT JOIN harikerjagol_m hr ON hr.kelompokpegawai_id = pg.kelompokpegawai_id";
		
		$qJadwal = Yii::app()->db->createCommand($sqlJadwal)->queryAll();
		
		$sqlDokter = "select
							pg.pegawai_id,
							pg.jabatan_id,
							peg.tgl,
							pg.kelompokpegawai_id,
							hr.periodeharikerjaawl,
							hr.periodeharikerjaakhir 
						from 
							pegawai_m pg
						LEFT JOIN (
							select 
								p.pegawai_id, 
								p.kelompokpegawai_id,
								date(pr.jadwaldokter_tgl) as tgl
							from 
								pegawai_m p
							JOIN 
								jadwaldokter_m pr On pr.pegawai_id = p.pegawai_id    
							WHERE 
								date(pr.jadwaldokter_tgl) = '".$tgl."'
							group by
								p.pegawai_id, 
								p.kelompokpegawai_id,
								date(pr.jadwaldokter_tgl)
						ORDER BY p.pegawai_id
						) as peg ON peg.pegawai_id = pg.pegawai_id
					LEFT JOIN harikerjagol_m hr ON hr.kelompokpegawai_id = pg.kelompokpegawai_id";
		
		$qDokter = Yii::app()->db->createCommand($sqlDokter)->queryAll();
						
		
		foreach($qPresensi as $det){
			$data[$det['pegawai_id']]['pegawai_id'] = $det['pegawai_id'];
			$data[$det['pegawai_id']]['jabatan_id'] = $det['jabatan_id'];
			$data[$det['pegawai_id']]['tglpresensi'] = $det['tgl'];
			$data[$det['pegawai_id']]['kelompokpegawai_id'] = $det['kelompokpegawai_id'];
			$data[$det['pegawai_id']]['awal'] = $det['periodeharikerjaawl'];
			$data[$det['pegawai_id']]['akhir'] = $det['periodeharikerjaakhir'];
			$data[$det['pegawai_id']]['statusscan_id'] = $det['statusscan_id'];
			$data[$det['pegawai_id']]['shift_id'] = $det['shift_id'];
		}
		
		foreach($qJadwal as $det){
			$data[$det['pegawai_id']]['tgljadwal'] = $det['tgl'];
		}
		
		foreach($qDokter as $det){
			$data[$det['pegawai_id']]['tgljadwaldokter'] = $det['tgl'];
		}
		
		
		$peg_id = array();
		
		foreach ($data as $cek){
			
			if (empty($cek['tglpresensi'])){				
				if ($cek['kelompokpegawai_id'] != Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP){
					
					if ($cek['jabatan_id'] != Params::JABATAN_ID_DIREKTUR){						
						$awal = Params::getNumberByDays($cek['awal']);
						$akhir = Params::getNumberByDays($cek['akhir']);
						$now = date('w', strtotime($tgl));
						
						if ($now == 0){
							$now = 7;
						}												
						
						if (empty($cek['statusscan_id'])){
							if ($now >= $awal || $now <= $akhir ){							
								if (count($harilibur) < 1){
									$peg_id[] = $cek['pegawai_id'];						
								}
							}else{								
								if ($cek['tgljadwal'] == $tgl){
									$peg_id[] = $cek['pegawai_id'];
								}elseif ($cek['tgljadwaldokter'] == $tgl){
									$peg_id[] = $cek['pegawai_id'];
								}
							}							
						}
						
					}
				}else{							
					//if ($cek['tgljadwal'] == $tgl){						
						//$peg_id[] = $cek['pegawai_id'];
					//}elseif ($cek['tgljadwaldokter'] == $tgl){												
						//$peg_id[] = $cek['pegawai_id'];
					//}
				}
			}else{			
				
				if ($cek['kelompokpegawai_id'] != Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP){										
					if ($cek['jabatan_id'] != Params::JABATAN_ID_DIREKTUR){												
						if (!empty($cek['shift_id'])){													
							$shift = ShiftM::model()->findByPk($cek['shift_id']);
							$presensi = PresensiT::model()->find(" pegawai_id = '".$cek['pegawai_id']."' AND date(tglpresensi) = '".$cek['tglpresensi']."' AND statusscan_id = '".Params::STATUSSCAN_MASUK."'  ORDER BY tglpresensi ASC ");

							if (!empty($presensi)){
								if (date('H:i:s', strtotime($presensi->tglpresensi)) > date('H:i:s', strtotime('09:00:00 +1 hours'))){
									$peg_id[] = $cek['pegawai_id'];
								}
							}
						}		
					}
				}
			}
			
		}
		
		$cri = new CDbCriteria();
		$cri->addInCondition(" pegawai_id ", $peg_id);
		$cri->addCondition(" pegawai_aktif = TRUE ");
		$cri->order = " nama_pegawai ASC "; 
		$pegawai = PegawaiM::model()->findAll($cri);
        
        $judul = " Pegawai Tidak Hadir ";
        
        if (count($pegawai)>0){
			$i = 1;
			$isi =  "Berikut list pegawai yang tidak hadir pada tanggal ".MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime("-1 days"))).", yaitu :<br/>";
			foreach ($pegawai as $peg){
				if (!empty($peg->nama_pegawai)){
					$isi .= $i.". ".$peg->nomorindukpegawai.' '.$peg->namaLengkap.'<br/>';
					$i++;
				}
			}
			                       
            $ok = CustomFunction::broadcastNotifCron($judul, $isi, array(
                    array('instalasi_id'=>Params::INSTALASI_ID_KEPEGAWAIAN, 'ruangan_id'=> Params::RUANGAN_ID_KEPEGAWAIAN, 'modul_id'=>Params::MODUL_ID_KEPEGAWAIAN ),										   			   
            )); 
            
            print_r("Notifikasi pegawai tidak hadir, sudah dikirimkan pada tanggal ".MyFormatter::formatDateTimeForUser(date('Y-m-d'))." \n");
        }else{
            print_r("....\n");
        }
        
        
    }
    
}
