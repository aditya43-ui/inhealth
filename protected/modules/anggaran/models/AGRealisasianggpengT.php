<?php

class AGRealisasianggpengT extends RealisasianggpengT{
	public $pegawaimengetahui_nama,$pegawaimenyetujui_nama,$deskripsiperiode,$programkerja,$subkegiatanprogram_nama,$bulanUser,$bulanDb,$sumberanggarannama;
	public $totalpengeluaran,$totalrealisasi;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTglPeriode()
	{
		$date = date("Y-m-d");
		$criteria = new CDbCriteria();
		// $criteria->addCondition('DATE(tglrencanaanggaran) <=\''.$date.'\'');
		// $criteria->addCondition('DATE(sd_tglrencanaanggaran) >= \''.$date.'\'');
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		$criteria->compare('LOWER(deskripsiperiode)',strtolower($this->deskripsiperiode),true);
		$criteria->order = "sd_tglanggaran";
		$criteria->addCondition("isclosing_anggaran IS FALSE");
        $periodes = KonfiganggaranK::model()->findAll($criteria);
		foreach($periodes as $i => $periode){
			$periodes[$i]->deskripsiperiode = $periode->deskripsiperiode;
		}
		return $periodes;
	}
	
	public function getTglPeriodeRealisasi()
	{
		$tahun = date("Y");
		$criteria = new CDbCriteria();
		// $criteria->addCondition('date_part(\'year\', tglanggaran) <=\''.$tahun.'\'');
		// $criteria->addCondition('date_part(\'year\', sd_tglanggaran) >= \''.$tahun.'\'');
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		$criteria->compare('LOWER(deskripsiperiode)',strtolower($this->deskripsiperiode),true);
		$criteria->order = "sd_tglanggaran";
		$criteria->addCondition("isclosing_anggaran IS FALSE");
        $periodes = KonfiganggaranK::model()->findAll($criteria);
		foreach($periodes as $i => $periode){
			$periodes[$i]->deskripsiperiode = $periode->deskripsiperiode;
		}
		return $periodes;
	}
	
	public function searchInformasiRealisasiAnggPeng(){
		$criteria = new CDbCriteria;
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		if(!empty($this->unitkerja_id)){
			$criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
		}
		$criteria->group = 'konfiganggaran_id,unitkerja_id,realisasimengetahui_id,realisasimenyetujui_id';
		$criteria->select = $criteria->group.', sum(nilaialokasi_pengeluaran) as nilaialokasi_pengeluaran, sum(nilairealisasi_pengeluaran) as nilairealisasi_pengeluaran';
		return new CActiveDataProvider($this, array(
													'criteria'=>$criteria,
											));
	}
}
