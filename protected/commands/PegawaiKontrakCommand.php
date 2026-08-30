<?php

/**   command ini digunakan pada cronjob (realtime proses), fungsi ini digunakan untuk memberikan notifikasi ke modul kepegawaian
 *	untuk memberitahukan list pegawai siapa saja yang kontrak pegawainya hampir habis dihitung dari 1 bulan sebelum masa kontrak habis
 * 
 *	@category	Notifikasi
 *	@author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *	@website	<https://piindonesia.co.id>
 */

class PegawaiKontrakCommand extends CConsoleCommand {
	public function run($args) {		
	
		$ok = true;
		$tgl = CustomFunction::getWeek();

		$cri = new CDbCriteria();
		$cri->addCondition(" pegawai_aktif = TRUE ");
		$cri->addInCondition("date(tglmasaaktifpeg_sd)", $tgl);
		$cri->addCondition(" LOWER(kategoripegawai) = '".strtolower(Params::KATEGORI_PEGAWAI_TIDAK_TETAP)."' ");
		$cri->order = " nama_pegawai ASC "; 
		$pegawai = PegawaiM::model()->findAll($cri);
		if (count($pegawai) > 0){
			$ok = $ok && $this->kirim_notifikasi($pegawai);

			if ($ok){
				echo "Notifikasi Pegawai Kontrak Sudah Dikirim pada ".date('Y-m-d H:i:s');
			}else{
				echo "Notifikasi Pegawai Kontrak Gagal Dikirim pada ".date('Y-m-d H:i:s');
			}
		}
	}
	
	public function kirim_notifikasi($model){
		$judul = 'Masa Berlaku Pegawai Kontrak';
                    						
		$isi = "Berikut adalah Pegawai yang  hampir habis masa kontraknya : <br> ";
		
		$i=1;			
		foreach ($model as $peg){
			$isi .= $i.".  <span style='color:red;'>".$peg->nama_pegawai.'</span> masa aktif pegawai berakhir pada '.' ('.  MyFormatter::formatDateTimeForUser($peg->tglmasaaktifpeg_sd).') - <span style="color:red;">'.CustomFunction::hitungHari(date('Y-m-d'),$peg->tglmasaaktifpeg_sd).' hari lagi </span><br/>';
			$i++;
		}

		$ok = CustomFunction::broadcastNotifCron($judul, $isi, array(
			array('instalasi_id'=>Params::INSTALASI_ID_KEPEGAWAIAN, 'ruangan_id'=>  Params::RUANGAN_ID_KEPEGAWAIAN, 'modul_id'=>Params::MODUL_ID_KEPEGAWAIAN ),							
		));   
		die;
		return $ok;
	}
	
	
}
