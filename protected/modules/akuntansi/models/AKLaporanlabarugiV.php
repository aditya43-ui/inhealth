<?php
class AKLaporanlabarugiV extends LaporanlabarugiV
{
	public $tgl_awal,$tgl_akhir, $thn_awal, $bulan;
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
		if(!empty($this->laporansaldoakhirberjalan_id)){
			$criteria->addCondition('laporansaldoakhirberjalan_id = '.$this->laporansaldoakhirberjalan_id);
		}
		if(!empty($this->laporansaldoakhirberjalandetail_id)){
			$criteria->addCondition('laporansaldoakhirberjalandetail_id = '.$this->laporansaldoakhirberjalandetail_id);
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
		$criteria->compare('jumlah',$this->jumlah);
		//$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		//$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		//$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		//$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		//$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		//$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		//$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		//$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		//$criteria->compare('LOWER(keterangansaldoakhirberjalan)',strtolower($this->keterangansaldoakhirberjalan),true);
	//	$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	public function searchLaporanPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->rekperiod_id)){
			$criteria->addCondition('rekperiod_id = '.$this->rekperiod_id);
		}
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
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
		if(!empty($this->nourutrek)){
			$criteria->addCondition('nourutrek = '.$this->nourutrek);
		}
		
		if(!empty($this->bukubesar_id)){
			$criteria->addCondition('bukubesar_id = '.$this->bukubesar_id);
		}
		$criteria->compare('jumlah',$this->jumlah);
		/*$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);*/
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	public function getLabaRugi($periodeposting_id,$rekening1_id=null,$kolom = null){
		$format = new MyFormatter();
		$criteria= new CDbCriteria;
		$criteria->group = 'periodeposting_id,rekening1_id';
		$criteria->select = $criteria->group.', sum(saldoakhirberjalan) as saldoakhirberjalan';
		
		if(!empty($periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$periodeposting_id);
		}
		
		if($kolom == 'operasional'){
			$criteria->addCondition("nmrekening1 = 'Pendapatan Operasional'");
		}else if($kolom == 'non_operasional'){
			$criteria->addCondition("nmrekening1 = 'Pendapatan Non Operasional'");
		}else{
			$criteria->addCondition('rekening1_id = '.$rekening1_id);
		}
		$modLabaRugi = AKLaporanlabarugiV::model()->findAll($criteria);

		$jml = 0;
		foreach($modLabaRugi as $saldo){
			$jml += $saldo->saldoakhirberjalan;
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
    
    public function criteriaSearch() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
//		if(isset($this->thn_awal)) {
//			$criteria->addCondition('tglperiodeposting_awal', $this->thn_awal);
//		}
		if (!empty($this->bulan)) {
			if (is_array($this->bulan)) {
				$tgl_awal = array();
				$str = array();
				foreach ($this->bulan as $data) {
					array_push($str, $data." between (extract (month from tglperiodeposting_awal)) and (extract (month from tglperiodeposting_akhir))");
					//$temp_tgl = $this->thn_awal . '-' . $data . '-01';
					//array_push($tgl_awal, $temp_tgl);
				}
				$criteria->addCondition("(". implode(" or ", $str).")");
//			echo json_encode($tgl_awal);exit;
				//$criteria->addInCondition('tglperiodeposting_awal', $tgl_awal);
			} else {
				$criteria->addCondition($this->bulan." between (extract (month from tglperiodeposting_awal)) and (extract (month from tglperiodeposting_akhir))");
				//$criteria->compare('tglperiodeposting_awal', $tgl_awal);
			}
		}else{
			$tgl_awal = $this->thn_awal; // . '-01-01';
			$criteria->compare('extract (year from tglperiodeposting_awal)', $tgl_awal);
		}
		
		// var_dump($criteria);
		
		return $criteria;
	}

	public function searchLaporan2() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->criteriaSearch();
		$criteria->group = "periodeposting_id, tglperiodeposting_awal";
		$criteria->select = $criteria->group;
//		$criteria->order = "tglperiodeposting_awal DESC"; 
		$criteria->order = "periodeposting_id, tglperiodeposting_awal ASC";
		return $criteria;
	}
}