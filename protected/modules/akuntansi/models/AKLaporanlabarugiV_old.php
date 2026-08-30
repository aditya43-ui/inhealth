<?php
class AKLaporanlabarugiV_old extends LaporanlabarugiV
{
	public $tgl_awal,$tgl_akhir;
	public $saldo;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanlabarugiV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->rekperiod_id)){
			$criteria->addCondition('rekperiod_id = '.$this->rekperiod_id);
		}
		$criteria->compare('LOWER(perideawal)',strtolower($this->perideawal),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
		$criteria->compare('isclosing',$this->isclosing);
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		$criteria->compare('LOWER(deskripsiperiode)',strtolower($this->deskripsiperiode),true);
		$criteria->compare('LOWER(tglanggaran)',strtolower($this->tglanggaran),true);
		$criteria->compare('LOWER(sd_tglanggaran)',strtolower($this->sd_tglanggaran),true);
		$criteria->compare('LOWER(tglrencanaanggaran)',strtolower($this->tglrencanaanggaran),true);
		$criteria->compare('LOWER(sd_tglrencanaanggaran)',strtolower($this->sd_tglrencanaanggaran),true);
		$criteria->compare('LOWER(tglrevisianggaran)',strtolower($this->tglrevisianggaran),true);
		$criteria->compare('LOWER(sd_tglrevisianggaran)',strtolower($this->sd_tglrevisianggaran),true);
		$criteria->compare('LOWER(digitnilaianggaran)',strtolower($this->digitnilaianggaran),true);
		$criteria->compare('isclosing_anggaran',$this->isclosing_anggaran);
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
		}
		$criteria->compare('LOWER(periodeposting_nama)',strtolower($this->periodeposting_nama),true);
		$criteria->compare('LOWER(tglperiodeposting_awal)',strtolower($this->tglperiodeposting_awal),true);
		$criteria->compare('LOWER(tglperiodeposting_akhir)',strtolower($this->tglperiodeposting_akhir),true);
		$criteria->compare('LOWER(deskripsiperiodeposting)',strtolower($this->deskripsiperiodeposting),true);
		$criteria->compare('periodeposting_aktif',$this->periodeposting_aktif);
		if(!empty($this->laporanlabarugi_id)){
			$criteria->addCondition('laporanlabarugi_id = '.$this->laporanlabarugi_id);
		}
		if(!empty($this->laporanlabarugidetail_id)){
			$criteria->addCondition('laporanlabarugidetail_id = '.$this->laporanlabarugidetail_id);
		}
		if(!empty($this->rekening1_id)){
			$criteria->addCondition('rekening1_id = '.$this->rekening1_id);
		}
		$criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
		$criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
		if(!empty($this->rekening2_id)){
			$criteria->addCondition('rekening2_id = '.$this->rekening2_id);
		}
		$criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
		$criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
		if(!empty($this->rekening3_id)){
			$criteria->addCondition('rekening3_id = '.$this->rekening3_id);
		}
		$criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
		$criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
		if(!empty($this->rekening4_id)){
			$criteria->addCondition('rekening4_id = '.$this->rekening4_id);
		}
		$criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
		$criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
		if(!empty($this->rekening5_id)){
			$criteria->addCondition('rekening5_id = '.$this->rekening5_id);
		}
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		$criteria->compare('LOWER(rekening5_nb)',strtolower($this->rekening5_nb),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		if(!empty($this->nourutrek)){
			$criteria->addCondition('nourutrek = '.$this->nourutrek);
		}
		$criteria->compare('LOWER(kelompokrek)',strtolower($this->kelompokrek),true);
		$criteria->compare('sak',$this->sak);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		if(!empty($this->bukubesar_id)){
			$criteria->addCondition('bukubesar_id = '.$this->bukubesar_id);
		}
		$criteria->compare('pendapatanoperasional',$this->pendapatanoperasional);
		$criteria->compare('pendapatannonoperasional',$this->pendapatannonoperasional);
		$criteria->compare('pendapatan',$this->pendapatan);
		$criteria->compare('bebanoperasional',$this->bebanoperasional);
		$criteria->compare('bebannonoperasional',$this->bebannonoperasional);
		$criteria->compare('beban',$this->beban);
		$criteria->compare('labarugisebelumpajak',$this->labarugisebelumpajak);
		$criteria->compare('pajak',$this->pajak);
		$criteria->compare('labarugi',$this->labarugi);
		$criteria->compare('LOWER(keteranganlabarugi)',strtolower($this->keteranganlabarugi),true);
		$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	public function getRuangan(){
		$format = new MyFormatter();
		$criteria= new CDbCriteria;
		$criteria->group = 'ruangan_id, ruangan_nama';
		$criteria->select = $criteria->group;

		$modRuangans = LaporanlabarugiV::model()->findAll($criteria);
		return $modRuangans;
	}
        
	public function getSaldoRuangan($nmrekening, $ruangan_id=null, $tiperekening=null,$kolom = null){
		$format = new MyFormatter();
		$criteria= new CDbCriteria;
		$criteria->group = 'periodeposting_id';
		$criteria->select = $criteria->group.', sum(saldodebit) as saldodebit, sum(saldokredit) as saldokredit, sum(pendapatanoperasional) as pendapatanoperasional,'
				. ' sum(pendapatannonoperasional) as pendapatannonoperasional, sum(pendapatan) as pendapatan, sum(bebanoperasional) as bebanoperasional, sum(bebannonoperasional) as bebannonoperasional, sum(beban) as beban,'
				. ' sum(labarugisebelumpajak) as labarugisebelumpajak, sum(pajak) as pajak, sum(labarugi) as labarugi';
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
		}
		if ($tiperekening == 'rekening1'){
			$criteria->compare('nmrekening1',$nmrekening);
		} else if ($tiperekening == 'rekening3'){
			$criteria->compare('nmrekening3',$nmrekening);
		} else if ($tiperekening == 'rekening4'){
			$criteria->compare('nmrekening4',$nmrekening);
		}

		$modRuangans = AKLaporanlabarugiV::model()->findAll($criteria);

		$jml = 0;
		foreach($modRuangans as $ruangan){
			$jml += $ruangan->$kolom;
		}
		return $jml;
	}
	
	public function getSaldoPosting($rekening_id,$tiperekening=null,$periodeposting_id = null, $kolom = null){
		$format = new MyFormatter();
		$criteria= new CDbCriteria;
		$criteria->group = 'periodeposting_id';
		$criteria->select = $criteria->group.', sum(saldodebit) as saldodebit, sum(saldokredit) as saldokredit, sum(pendapatanoperasional) as pendapatanoperasional,'
				. ' sum(pendapatannonoperasional) as pendapatannonoperasional, sum(pendapatan) as pendapatan, sum(bebanoperasional) as bebanoperasional, sum(bebannonoperasional) as bebannonoperasional, sum(beban) as beban,'
				. ' sum(labarugisebelumpajak) as labarugisebelumpajak, sum(pajak) as pajak, sum(labarugi) as labarugi, sum(saldoakhirberjalan) as saldoakhirberjalan';
		
		$this->periodeposting_id = isset($periodeposting_id) ? $periodeposting_id : null;
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
		}
		
		if ($tiperekening == 'rekening1'){
			$criteria->addCondition('rekening1_id = '.$rekening_id);
		} else if ($tiperekening == 'rekening2'){
			$criteria->addCondition('rekening2_id = '.$rekening_id);
		} else if ($tiperekening == 'rekening3'){
			$criteria->addCondition('rekening3_id = '.$rekening_id);
		} else if ($tiperekening == 'rekening4'){
			$criteria->addCondition('rekening4_id = '.$rekening_id);
		}

		$modSaldoPosting = AKLaporanlabarugiV::model()->findAll($criteria);

		$jml = 0;
		foreach($modSaldoPosting as $saldo){
			$jml += $saldo->$kolom;
		}
		return $jml;
	}
	
	public function getSaldoPostingDetail($rekening2_id,$rekening_id,$tiperekening=null,$periodeposting_id,$kolom = null){
		$format = new MyFormatter();
		$criteria= new CDbCriteria;
		$criteria->group = 'rekening3_id,rekening2_id,periodeposting_id';
		$criteria->select = $criteria->group.', sum(saldodebit) as saldodebit, sum(saldokredit) as saldokredit, sum(pendapatanoperasional) as pendapatanoperasional,'
				. ' sum(pendapatannonoperasional) as pendapatannonoperasional, sum(pendapatan) as pendapatan, sum(bebanoperasional) as bebanoperasional, sum(bebannonoperasional) as bebannonoperasional, sum(beban) as beban,'
				. ' sum(labarugisebelumpajak) as labarugisebelumpajak, sum(pajak) as pajak, sum(labarugi) as labarugi, sum(saldoakhirberjalan) as saldoakhirberjalan';
		
		$this->periodeposting_id = isset($periodeposting_id) ? $periodeposting_id : null;
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
		}
		
		if(!empty($rekening2_id)){
			$criteria->addCondition('rekening2_id = '.$rekening2_id);
		}
		
		if ($tiperekening == 'rekening1'){
			$criteria->addCondition('rekening1_id = '.$rekening_id);
		} else if ($tiperekening == 'rekening2'){
			$criteria->addCondition('rekening2_id = '.$rekening_id);
		} else if ($tiperekening == 'rekening3'){
			$criteria->addCondition('rekening3_id = '.$rekening_id);
		} else if ($tiperekening == 'rekening4'){
			$criteria->addCondition('rekening4_id = '.$rekening_id);
		}

		$modSaldoPosting = AKLaporanlabarugiV::model()->findAll($criteria);

		$jml = 0;
		foreach($modSaldoPosting as $saldo){
			$jml += $saldo->$kolom;
		}
		return $jml;
	}
	
	public function getLabaRugi($periodeposting_id,$kolom = null){
		$format = new MyFormatter();
		$criteria= new CDbCriteria;
		$criteria->group = 'periodeposting_id';
		$criteria->select = $criteria->group.', sum(saldodebit) as saldodebit, sum(saldokredit) as saldokredit, sum(pendapatanoperasional) as pendapatanoperasional,'
				. ' sum(pendapatannonoperasional) as pendapatannonoperasional, sum(pendapatan) as pendapatan, sum(bebanoperasional) as bebanoperasional, sum(bebannonoperasional) as bebannonoperasional, sum(beban) as beban,'
				. ' sum(labarugisebelumpajak) as labarugisebelumpajak, sum(pajak) as pajak, sum(labarugi) as labarugi, sum(saldoakhirberjalan) as saldoakhirberjalan';
		
		if(!empty($periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$periodeposting_id);
		}
		
		$modSaldoPosting = AKLaporanlabarugiV::model()->findAll($criteria);

		$jml = 0;
		foreach($modSaldoPosting as $saldo){
			$jml += $saldo->$kolom;
		}
		return $jml;
	}
	
	public function getTglPeriode($rekperiod_id = null)
	{
		$next_year = date('Y-m-d',mktime(0, 0, 0, date("m"),   date("d"),   date("Y")));
		$criteria = new CDbCriteria();
//		$criteria->addCondition('DATE(tglperiodeposting_awal) <=\''.$next_year.'\'');
//		$criteria->addCondition('DATE(tglperiodeposting_akhir) >= \''.$next_year.'\'');
		$criteria->compare('LOWER(deskripsiperiodeposting)',strtolower($this->deskripsiperiodeposting),true);
		$criteria->order = "tglperiodeposting_akhir";
		if(!empty($rekperiod_id)){
			$criteria->addCondition('rekperiode_id = '.$rekperiod_id);
		}
		return self::model()->find($criteria);

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
}