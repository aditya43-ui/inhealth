<?php

class AKJurnalrekeningT extends JurnalrekeningT {

    public $rekening_nama;
    public $tgl_awal;
    public $tgl_akhir;
    public $rekening1_id;
    public $rekening2_id;
    public $rekening3_id;
    public $rekening4_id;
    public $rekening5_id;
    public $jurnaldetail_id;
    public $saldodebit;
    public $saldokredit;
    public $jenisjurnal_nama;
    public $rekperiode_nama;
	public $unitkerja_id;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchByFilter() {
        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition('DATE(tglbuktijurnal)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->with = 'jenisJurnal';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchWithJurDetail() {
        $criteria = new CDbCriteria;
        /*
          $criteria->compare('LOWER(jurnalrekening_t.nobuktijurnal)',strtolower($this->nobuktijurnal),true);
          $criteria->compare('LOWER(jurnalrekening_t.kodejurnal)',strtolower($this->kodejurnal),true);
         * 
         */
        $criteria->addCondition('jurnalposting_id IS NULL');
        $criteria->addBetweenCondition('DATE("jurnalRekening".tglbuktijurnal)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->with = 'jurnalRekening';
        return new CActiveDataProvider("JurnaldetailT", array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }
	
	public function searchPostingJurnal() {
        $criteria = new CDbCriteria;
		
		$criteria->select = 't.*,jurnaldetail_t.*,unitkerjaruangan_m.*,unitkerja_m.*';
        $criteria->addBetweenCondition('DATE(tglbuktijurnal)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(nobuktijurnal)', strtolower($this->nobuktijurnal), true);
        $criteria->compare('LOWER(kodejurnal)', strtolower($this->kodejurnal), true);
		$criteria->compare('LOWER(urianjurnal)', strtolower($this->urianjurnal), true);
		$criteria->compare('LOWER(rekening5_m.nmrekening5)', strtolower($this->rekening_nama), true);
		
		if(!empty($this->unitkerja_id)){
			$criteria->addCondition('unitkerja_m.unitkerja_id = '.$this->unitkerja_id);
		}   
		$criteria->addCondition('jurnaldetail_t.jurnalposting_id is null or jurnalposting_t.jurnalposting_id is null');
		$criteria->join= 'JOIN jurnaldetail_t ON jurnaldetail_t.jurnalrekening_id=t.jurnalrekening_id'
				. ' LEFT JOIN unitkerjaruangan_m ON unitkerjaruangan_m.ruangan_id = t.ruangan_id'
				. ' LEFT JOIN unitkerja_m ON unitkerja_m.unitkerja_id = unitkerjaruangan_m.unitkerja_id'
            . ' left join jurnalposting_t on jurnalposting_t.jurnaldetail_id = jurnaldetail_t.jurnaldetail_id '
			. ' LEFT JOIN rekening5_m ON rekening5_m.rekening5_id = jurnaldetail_t.rekening5_id ';
        
                $criteria->order = 't.tglbuktijurnal, jurnaldetail_t.nourut';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }
	
	public function getKodeRekening()
    {
		$criteria = new CDbCriteria;
		if(!empty($this->rekening1_id)){
			$criteria->addCondition("rekening1_id = ".$this->rekening1_id);			
		}
		if(!empty($this->rekening2_id)){
			$criteria->addCondition("rekening2_id = ".$this->rekening2_id);			
		}
		if(!empty($this->rekening3_id)){
			$criteria->addCondition("rekening3_id = ".$this->rekening3_id);			
		}
		if(!empty($this->rekening4_id)){
			$criteria->addCondition("rekening4_id = ".$this->rekening4_id);			
		}
		if(!empty($this->rekening5_id)){
			$criteria->addCondition("rekening5_id = ".$this->rekening5_id);			
		}
		$result = AKInformasijurnaltransaksiV::model()->find($criteria);

		if(!empty($result['rekening5_id'])){
			return $result->kdrekening5;
		}else if(!empty($result['rekening4_id'])){
			return $result->kdrekening4;
		}else if(!empty($result['rekening3_id'])){
			return $result->kdrekening3;
		}else if(!empty($result['rekening2_id'])){
			return $result->kdrekening2;
		}
		
		return isset($kode_rekening) ? $kode_rekening : "-";
    }
    
    public function getNamaRekening()
    {
		$criteria = new CDbCriteria;
		if(!empty($this->rekening1_id)){
			$criteria->addCondition("rekening1_id = ".$this->rekening1_id);			
		}
		if(!empty($this->rekening2_id)){
			$criteria->addCondition("rekening2_id = ".$this->rekening2_id);			
		}
		if(!empty($this->rekening3_id)){
			$criteria->addCondition("rekening3_id = ".$this->rekening3_id);			
		}
		if(!empty($this->rekening4_id)){
			$criteria->addCondition("rekening4_id = ".$this->rekening4_id);			
		}
		if(!empty($this->rekening5_id)){
			$criteria->addCondition("rekening5_id = ".$this->rekening5_id);			
		}
		$result = AKInformasijurnaltransaksiV::model()->find($criteria);

		if(!empty($result['rekening5_id'])){
			$nama_rekening = $result->nmrekening5;
		}else if(!empty($result['rekening4_id'])){
			$nama_rekening = $result->nmrekening4;
		}else if(!empty($result['rekening3_id'])){
			$nama_rekening = $result->nmrekening3;
		}else if(!empty($result['rekening2_id'])){
			$nama_rekening = $result->nmrekening2;
		}
		
		return isset($nama_rekening) ? $nama_rekening : "-";
    }    

}

?>
