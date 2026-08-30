<?php
class AKLaporanaruskasV extends LaporanaruskasV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanaruskasV the static model class
	 */
	public $saldoinstalasi,$saldoPerRek;
	public $tgl_awal, $tgl_akhir, $thn_awal, $thn_akhir;
	public $unitkerja_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
    /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchArusKas()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if (!empty($this->periodeposting_id)){
			$criteria->addCondition("  ( DATE(tglperiodeposting_awal) BETWEEN '".$this->tgl_awal."') AND tglperiodeposting_awal is null )");
		}else{
			$criteria->addCondition(" ( DATE(tglperiodeposting_awal) BETWEEN '".$this->tgl_awal."') AND tglperiodeposting_awal is null )");
		}
		
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
		}

		$criteria->select ='sum(saldodebit) as saldodebit, sum(saldokredit) as saldokredit, sum(saldo) as saldo, issaldoawal, rekening1_id';
		$criteria->compare('DATE(perideawal)',$this->tglAwal);
		$criteria->compare('DATE(sampaidgn)',$this->tglAkhir);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->group = 'rekening1_id, issaldoawal';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
                
	public function getTableHeader(){
		$criteriaTableHeader=new CDbCriteria;
		$criteriaTableHeader->group = 'instalasi_id, instalasi_nama, ruangan_id, ruangan_nama'; 
		$criteriaTableHeader->select = 'instalasi_id, instalasi_nama, ruangan_id, ruangan_nama';
		$dataTableHeader = AKLaporanaruskasV::model()->findAll($criteriaTableHeader);
		return $dataTableHeader;
	}
                
	public function getLabaRugi($periodeposting_id = null, $ruangan_id = null){
		$total_laba = 0;
		$criteria=new CDbCriteria;
		$criteria->group = 'periodeposting_id, labarugi';
		$criteria->select = $criteria->group;
		if(!empty($periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$periodeposting_id);
		}
		
		if(!empty($ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$ruangan_id);
		}
		$data = $this->findAll($criteria);
		if(count((array)$data) > 0){
			foreach($data as $value){
				$total_laba += $value->labarugi;
			}
		}
		
		return $total_laba;
	}	
	
	public function getSelisihKewajibanLancar($periodeposting_id = null, $ruangan_id = null){
		$total_kewajiban = 0;
		$criteria=new CDbCriteria;
		$criteria->group = 'periodeposting_id, kewajiban';
		$criteria->select = $criteria->group;
		if(!empty($periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$periodeposting_id);
		}
		if(!empty($ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$ruangan_id);
		}
		$data = $this->findAll($criteria);
		if(isset($data)){
			foreach($data as $value){
				$total_kewajiban += $value->kewajiban;
			}
		}
		
		return $total_kewajiban;
	}	
	
	public function getSelisihAktivaLancarNonKas($periodeposting_id = null, $ruangan_id = null){
		$total_aktiva = 0;
		$criteria=new CDbCriteria;
		$criteria->group = 'periodeposting_id, selisihaktivalancarnonkas';
		$criteria->select = $criteria->group;
		if(!empty($periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$periodeposting_id);
		}
		if(!empty($ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$ruangan_id);
		}
		$data = $this->findAll($criteria);
		if(isset($data)){
			foreach($data as $value){
				$total_aktiva += $value->selisihaktivalancarnonkas;
			}
		}
		
		return $total_aktiva;
	}	
	
	public function getPenyusutanAmortisasi($periodeposting_id = null, $ruangan_id = null){
		$total_penyusutan = 0;
		$criteria=new CDbCriteria;
		$criteria->group = 'periodeposting_id, penyusutandanamortisasi';
		$criteria->select = $criteria->group;
		if(!empty($periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$periodeposting_id);
		}
		if(!empty($ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$ruangan_id);
		}
		$criteria->addCondition('kelrekening_id = 5');
		$criteria->addCondition('rekening1_id = 13');
		$criteria->addInCondition('rekening2_id',array(60,61));
		$data = $this->findAll($criteria);
		if(isset($data)){
			foreach($data as $value){
				$total_penyusutan += $value->penyusutandanamortisasi	;
			}
		}
		
		return $total_penyusutan;
	}		
	
	public function getBeban($periodeposting_id = null, $ruangan_id = null){
		$total_beban = 0;
		$criteria=new CDbCriteria;
		$criteria->group = 'periodeposting_id, bebandibayardimuka';
		$criteria->select = $criteria->group;
		if(!empty($periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$periodeposting_id);
		}
		if(!empty($ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$ruangan_id);
		}
		$criteria->addCondition('kelrekening_id = 5');
		$data = $this->findAll($criteria);
		if(isset($data)){
			foreach($data as $value){
				$total_beban += $value->bebandibayardimuka;
			}
		}
		
		return $total_beban;
	}		
	
	public function getPendapatan($periodeposting_id = null, $ruangan_id = null){
		$total_pendapatan = 0;
		$criteria=new CDbCriteria;
		$criteria->group = 'periodeposting_id, pendapatannonoperasional';
		$criteria->select = $criteria->group;
		if(!empty($periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$periodeposting_id);
		}
		if(!empty($ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$ruangan_id);
		}
		$criteria->addCondition('kelrekening_id = 4');
		$data = $this->findAll($criteria);
		if(isset($data)){
			foreach($data as $value){
				$total_pendapatan += $value->pendapatannonoperasional;
			}
		}
		
		return $total_pendapatan;
	}	
	
	public function getEkuitas($periodeposting_id = null, $ruangan_id = null){
		$total_ekuitas = 0;
		$criteria=new CDbCriteria;
		$criteria->group = 'periodeposting_id, ekuitas';
		$criteria->select = $criteria->group;
		if(!empty($periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$periodeposting_id);
		}
		if(!empty($ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$ruangan_id);
		}
		$criteria->addCondition('kelrekening_id = 3');
		$data = $this->findAll($criteria);
		if(isset($data)){
			foreach($data as $value){
				$total_ekuitas += $value->ekuitas;
			}
		}
		
		return $total_ekuitas;
	}		
	
	public function getTotalAktifasiOperasi($periodeposting_id = null, $ruangan_id = null){
		$total = 0;
		$labarugi				= $this->getLabaRugi($periodeposting_id, $ruangan_id);
		$selisihkewajiban		= $this->getSelisihKewajibanLancar($periodeposting_id, $ruangan_id);
		$selisihaktiva			= $this->getSelisihAktivaLancarNonKas($periodeposting_id, $ruangan_id);
		$penyusutanamortisasi	= $this->getPenyusutanAmortisasi($periodeposting_id, $ruangan_id);
		$total = $labarugi+$selisihkewajiban+$selisihaktiva+$penyusutanamortisasi;
		return $total;
	}
	
	public function getTotalAktifasiInvestasi($periodeposting_id = null, $ruangan_id = null){
		$total = 0;
		$beban					= $this->getBeban($periodeposting_id, $ruangan_id);
		$pendapatan				= $this->getPendapatan($periodeposting_id, $ruangan_id);
		$total = $beban + $pendapatan;
		return $total;
	}
	
	public function getTotalAktifasiPendanaan($periodeposting_id = null, $ruangan_id = null){
		$total = 0;
		$ekuitas	= $this->getEkuitas($periodeposting_id, $ruangan_id);
		$total = $ekuitas;
		return $total;
	}
	
	public function getTotalKenaikanPeriode($periodeposting_id = null, $ruangan_id = null){
		$total = 0;
		$operasi	= $this->getTotalAktifasiOperasi($periodeposting_id, $ruangan_id);
		$investasi	= $this->getTotalAktifasiInvestasi($periodeposting_id, $ruangan_id);
		$pendanaan	= $this->getTotalAktifasiPendanaan($periodeposting_id, $ruangan_id);
		$total = $operasi + $investasi + $pendanaan;
		return $total;
	}
	
	public function getSaldoAwalPeriode($periodeposting_id = null, $ruangan_id = null){		
		$total_saldoawal = 0;
		$criteria=new CDbCriteria;
		$criteria->group = 'periodeposting_id, saldoawalperiode';
		$criteria->select = $criteria->group;
		if(!empty($periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$periodeposting_id);
		}
		if(!empty($ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$ruangan_id);
		}
		$data = $this->findAll($criteria);
		if(isset($data)){
			foreach($data as $value){
				$total_saldoawal += $value->saldoawalperiode;
			}
		}
		
		return $total_saldoawal;
	}
	
	public function getSaldoAkhirPeriode($periodeposting_id = null, $ruangan_id = null){
		$total_saldoakhir = 0;
		$criteria=new CDbCriteria;
		$criteria->group = 'periodeposting_id, saldoakhirperiode';
		$criteria->select = $criteria->group;
		if(!empty($periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$periodeposting_id);
		}
		if(!empty($ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$ruangan_id);
		}
		$data = $this->findAll($criteria);
		if(isset($data)){
			foreach($data as $value){
				$total_saldoakhir += $value->saldoakhirperiode;
			}
		}
		
		return $total_saldoakhir;
	}
	
	public function getRekening(){
        if(!empty($this->rekening5_id)){
			$rekening_id = $this->rekening5_id;
		}else if(!empty($this->rekening4_id)){
			$rekening_id = $this->rekening4_id;
		}else if(!empty($this->rekening3_id)){
			$rekening_id = $this->rekening3_id;
		}else if(!empty($this->rekening2_id)){
			$rekening_id = $this->rekening2_id;
		}
        
        return $rekening_id;
    }
	
	public function getNamaRekening(){
        if(!empty($this->rekening5_id)){
			$nama_rekening = $this->nmrekening5;
		}else if(!empty($this->rekening4_id)){
			$nama_rekening = $this->nmrekening4;
		}else if(!empty($this->rekening3_id)){
			$nama_rekening = $this->nmrekening3;
		}else if(!empty($this->rekening2_id)){
			$nama_rekening = $this->nmrekening2;
		}
        
        return $nama_rekening;
    }
	
	public function getTglPeriode($rekperiod_id = null)
	{
		$next_year = date('Y-m-d',mktime(0, 0, 0, date("m"),   date("d"),   date("Y")));
		$criteria = new CDbCriteria();
		$criteria->addCondition('DATE(tglperiodeposting_awal) <=\''.$next_year.'\'');
		$criteria->addCondition('DATE(tglperiodeposting_akhir) >= \''.$next_year.'\'');
		$criteria->compare('LOWER(deskripsiperiodeposting)',strtolower($this->deskripsiperiodeposting),true);
		$criteria->order = "tglperiodeposting_akhir";
		if(!empty($rekperiod_id)){
			$criteria->addCondition('rekperiode_id = '.$rekperiod_id);
		}
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('rekperiode_id = '.$this->periodeposting_id);
		}
		
		return self::model()->find($criteria);
	}
	
	public function searchLaporan2() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->criteriaSearch();
		$criteria->group = "tglperiodeposting_awal";
		$criteria->select = $criteria->group;
		$criteria->order = "tglperiodeposting_awal DESC";
		return $criteria;
	}
	
}
