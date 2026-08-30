<?php

class AGRencanggaranpengT extends RencanggaranpengT{
	public $namaunitkerja;
	public $pegawaimengetahui_nama,$pegawaimenyetujui_nama;
	public $konfiganggaran_id,$tglrencana,$nilairencpengeluaran,$programkerja,$deskripsiperiode;
	public $tglanggaran,$sd_tglanggaran,$digitnilai,$tglapprrencanggaran,$ygmerevisi_id,$pegawaimerevisi_nama;
	public $subkegiatanprogram_id;
	
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
		$criteria->order = "deskripsiperiode ASC";
		$criteria->addCondition("isclosing_anggaran IS FALSE");
        $periodes = KonfiganggaranK::model()->findAll($criteria);
		foreach($periodes as $i => $periode){
			$periodes[$i]->deskripsiperiode = $periode->deskripsiperiode;
		}
		return $periodes;
	}
	
	public function getSearchTglPeriode()
	{
		$date = date("Y-m-d");
		$criteria = new CDbCriteria();
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		$criteria->order = "sd_tglanggaran";
		$criteria->addCondition("isclosing_anggaran IS FALSE");
        $periodes = KonfiganggaranK::model()->findAll($criteria);
		foreach($periodes as $i => $periode){
			$periodes[$i]->sd_tglanggaran = MyFormatter::formatDateTimeForUser($periode->tglanggaran). " - " .  MyFormatter::formatDateTimeForUser($periode->sd_tglanggaran);
		}
		return $periodes;
	}
	
	public function searchInformasiRencAnggPeng(){
		$criteria = new CDbCriteria;
		$criteria->with = array('konfiganggaran');
		if(!empty($this->rencanggaranpeng_id)){
			$criteria->addCondition('rencanggaranpeng_id = '.$this->rencanggaranpeng_id);
		}
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('t.konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		if(!empty($this->unitkerja_id)){
			$criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
		}
		$criteria->compare('LOWER(konfiganggaran.tglanggaran)',strtolower($this->tglanggaran),true);
		$criteria->compare('LOWER(konfiganggaran.sd_tglanggaran)',strtolower($this->sd_tglanggaran),true);
		$criteria->compare('LOWER(rencanggaranpeng_no)',strtolower($this->rencanggaranpeng_no),true);
		$criteria->order = 'rencanggaranpeng_no';
		$criteria->limit=10;

            return new CActiveDataProvider($this, array(
														'criteria'=>$criteria,
												));
	}
	
	public function getIsApprove(){
		$status = false;
		$criteria = new CDbCriteria;
		if(!empty($this->rencanggaranpeng_id)){
			$criteria->addCondition('rencanggaranpeng_id = '.$this->rencanggaranpeng_id);
		}
		$criteria->addCondition('apprrencanggaran_id IS NOT NULL');
		$approve = AGRencanggaranpengdetailT::model()->find($criteria);
			if ($approve)
			$status = true;
						
		return $status;
	}
	
	public function getIsRevisi(){
		$status = false;
		//load apprrrencanggaran_id dari tabel detail
		$criteriaDetail = new CDbCriteria;
		if(!empty($this->rencanggaranpeng_id)){
			$criteriaDetail->addCondition('rencanggaranpeng_id = '.$this->rencanggaranpeng_id);
		}
		$criteriaDetail->addCondition('apprrencanggaran_id IS NOT NULL');
		$approves = AGRencanggaranpengdetailT::model()->findAll($criteriaDetail);
			foreach ($approves as $i => $approve){
				$criteriaApprove = new CDbCriteria;
				if(!empty($approve->apprrencanggaran_id)){
					$criteriaApprove->addCondition('apprrencanggaran_id = '.$approve->apprrencanggaran_id);
				}
				$criteriaApprove->addCondition('revisirencanggpeng_id IS NOT NULL');
				$revisi = AGApprrencanggaranT::model()->find($criteriaApprove);
			}
		if ($revisi)
		$status = true;
						
		return $status;
	}
	
	public function getIsTglRevisi(){
		$status = false;
		$date = date("Y-m-d");
		$criteria = new CDbCriteria;
		if(!empty($this->konfiganggaran->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran->konfiganggaran_id);
		}
		$criteria->addCondition('DATE(tglrevisianggaran) <=\''.$date.'\'');
		$criteria->addCondition('DATE(sd_tglrevisianggaran) >= \''.$date.'\'');
		$revisi = AGKonfiganggaranK::model()->find($criteria);
			if ($revisi)
			$status = true;
						
		return $status;
	}
	
	
	public function searchInformasiProgramKerjaUnit(){
		$criteria = new CDbCriteria;
		if(!empty($this->rencanggaranpeng_id)){
			$criteria->addCondition('rencanggaranpeng_id = '.$this->rencanggaranpeng_id);
		}
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('t.konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		if(!empty($this->unitkerja_id)){
			$criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
		}
		$criteria->compare('LOWER(konfiganggaran.tglanggaran)',strtolower($this->tglanggaran),true);
		$criteria->compare('LOWER(konfiganggaran.sd_tglanggaran)',strtolower($this->sd_tglanggaran),true);
		$criteria->compare('LOWER(rencanggaranpeng_no)',strtolower($this->rencanggaranpeng_no),true);
		$criteria->join = "JOIN rencanggaranpengdetail_t on t.rencanggaranpeng_id = rencanggaranpengdetail_t.rencanggaranpeng_id";
		$criteria->order = 'rencanggaranpeng_no';
		$criteria->limit=10;
		return new CActiveDataProvider($this, array(
							'criteria'=>$criteria,
					));
	}
	public function getTotalPengeluaran(){
		$total = 0;
		$criteria = new CDbCriteria;
		$criteria->addCondition('rencanggaranpeng_id = '.$this->rencanggaranpeng_id);
		$criteria->addCondition('apprrencanggaran_id is not null');
		$details = AGRencanggaranpengdetailT::model()->findAll($criteria);
		foreach($details as $i => $detail){
			$total += $detail->nilairencpengeluaran;
		}
		return $total;
	}
}
