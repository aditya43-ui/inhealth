<?php
class AKLaporanbukubesarV extends LaporanbukubesarV
{
	public $getSaldoAkhir,$totSaldo,$getTotalDebit,$getTotalKredit,$getTotSaldo;
	public $jeniskode;
	public $tglperiodeposting_akhir;
	public $struktur_nb;
        public $tiperekening_id, $rekening1_id, $kdrekening1, $nmrekening1;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanbukubesarV the static model class
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

		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
		}
		$criteria->compare('LOWER(periodeposting_nama)',strtolower($this->periodeposting_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		
		if(!empty($this->rekening5_id)){
			$criteria->addCondition('rekening5_id = '.$this->rekening5_id);
		}
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		// $criteria->compare('LOWER(rekening5_nb)',strtolower($this->rekening5_nb),true);

		//LAST

		// if(!empty($this->rekeninglast_id)){
		// 	$criteria->addCondition('rekeninglast_id = '.$this->rekeninglast_id);
		// }
		// $criteria->compare('LOWER(kdrekeninglast)',strtolower($this->kdrekeninglast),true);
		// $criteria->compare('LOWER(nmrekeninglast)',strtolower($this->nmrekeninglast),true);
		// $criteria->compare('LOWER(rekeninglast_nb)',strtolower($this->rekeninglast_nb),true);

		
		$criteria->compare('LOWER(tgljurnalpost)',strtolower($this->tgljurnalpost),true);
		$criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);
		$criteria->compare('LOWER(no_referensi)',strtolower($this->no_referensi),true);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('LOWER(tglbukubesar)',strtolower($this->tglbukubesar),true);
		$criteria->compare('saldo',$this->saldo);
		$criteria->compare('LOWER(koderekening)',strtolower($this->koderekening),true);
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	public function searchTable()
	{	
				$criteria=new CDbCriteria;
				if(!empty($this->rekening5_id)){
					$criteria->addCondition('t.rekening5_id = '.$this->rekening5_id);
				}

				$criteria->compare('t.tiperekening_id',$this->tiperekening_id);
				$criteria->compare('LOWER(t.uraiantransaksi)',strtolower($this->uraiantransaksi),true);
            
				$criteria->compare('t.saldodebit',$this->saldodebit);
				$criteria->compare('t.saldokredit',$this->saldokredit);
            
				$criteria->compare('LOWER(t.noreferensi)',strtolower($this->noreferensi),true);
			$criteria->compare('t.unitkerja_id', $this->unitkerja_id);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
	
	
	/** 
	 * added By Muhammad Iqbal Laksana  (3 Agusuts 2017)
	 * @return \CActiveDataProvider
	 */
	public function searchTable2() {
        
		$prov = $this->searchTable(false);
		$prov->criteria->select = " t.bukubesar_id, t.jurnalrekening_id, t.tglperiodeposting_akhir, t.kdrekening5,t.nmrekening5, "
            . "t.rekening5_id,t.periodeposting_id,t.saldonormal,t.saldokredit, t.saldodebit, "
            . "DATE(case when t.saldoawal_id is not null then t.tglperiodeposting_awal else t.tglbukubesar end) as tglbuktijurnal, t.tglbukubesar, "
            . "t.noreferensi,t.uraiantransaksi, t.jeniskode, "
            . "t.saldoawal_id, t.tiperekening_id, t.kelrekening_id, t.saldonormal_kelrek ";
		
			
		$prov->criteria->order = 't.kdrekening5, t.saldoawal_id, t.tglbuktijurnal asc, t.noreferensi';
        $prov->criteria->addBetweenCondition('DATE(case when t.saldoawal_id is not null then t.tglperiodeposting_awal else t.tglbukubesar end)',$this->tgl_awal, $this->tgl_akhir); 
		$prov->pagination = false;
        
        
        $res = array();
		$tot = $this->getTotalDebit = $this->getTotalKredit = 0;
        
        $cnt = 1;
		foreach ($prov->data as $item) {
            
            $ref_group = $item->bukubesar_id; 
            
            
            if (empty($res[$ref_group])) {
                $res[$ref_group] = $item->attributes;
                $res[$ref_group]['saldo_semua'] = 0;
                // $res[$ref_group]['jeniskode'] = $item->jeniskode;
				$res[$ref_group]['tglperiodeposting_akhir'] = $item->tglperiodeposting_akhir;
            } else {
                $res[$ref_group]['saldodebit'] += $item->saldodebit;
                $res[$ref_group]['saldokredit'] += $item->saldokredit;
            }
            
            $res[$ref_group]['saldo_semua'] += $item->saldodebit - $item->saldokredit;
            
            
			$tot += $item->saldodebit - $item->saldokredit;
			$this->getTotalDebit += $item->saldodebit;
			$this->getTotalKredit += $item->saldokredit;
		
		}
        
        
        foreach ($res as $idx => $item) {
            $res[$idx]['saldo_semua'] = ($res[$idx]['saldo_semua'] < 0) ? "(".MyFormatter::formatNumberForPrint(abs($res[$idx]['saldo_semua'])).")":MyFormatter::formatNumberForPrint($res[$idx]['saldo_semua']);
        }
        
		$this->getTotSaldo = $tot;
		
		return new CArrayDataProvider($res, array(
			'keyField'=>'bukubesar_id',
            'id'=>'data_laporan',
		));
	}
    
	
	/** 
	 * added By Muhammad Iqbal Laksana  (3 Agusuts 2017)
	 * @return \CActiveDataProvider
	 */
    public function searchTablePrint()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->addBetweenCondition('tgljurnalpost',$this->tgl_awal, $this->tgl_akhir); 
            
            $criteria->compare('rekening1_id',$this->rekening1_id);            
            $criteria->compare('rekening2_id',$this->rekening2_id);            
            $criteria->compare('rekening3_id',$this->rekening3_id);            
            $criteria->compare('rekening4_id',$this->rekening4_id);            
            $criteria->compare('rekening5_id',$this->rekening5_id);
            $term = $_GET['AKLaporanBukuBesarV']['namaRekening'];
            $termKode = $_GET['AKLaporanBukuBesarV']['kodeRekening'];
//            var_dump($termKode);
//            exit;
            $condition  = "LOWER(nmrekening5) ILIKE '%". $term ."%' OR LOWER(nmrekening4) ILIKE '%". $term ."%' OR LOWER(nmrekening3) ILIKE '%". $term ."%'";
            $condition2 ="LOWER(kdrekening5) ILIKE '%".$termKode."%' OR LOWER(kdrekening4) ILIKE '%".$termKode."%' OR LOWER(kdrekening3) ILIKE '%".$termKode."%'";
            $criteria->addCondition($condition);
            $criteria->addCondition($condition2);
            
            $criteria->compare('tiperekening_id',$this->tiperekening_id);
            $criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
            $criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);
            
            $criteria->compare('saldodebit',$this->saldodebit);
            $criteria->compare('saldokredit',$this->saldokredit);
            
            $criteria->compare('jurnalposting_id',$this->jurnalposting_id);
            $criteria->compare('LOWER(noreferensi)',strtolower($this->noreferensi),true);
            
            $criteria->order = 'jurnalposting_id ASC , nourut ASC';
            $criteria->limit = -1;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }
	
	/** 
	 * 
	 * added By Muhammad Iqbal Laksana  (3 Agusuts 2017)
	 * @return \CActiveDataProvider
	 */
	public function searchGrafik(){
               
        if($this->rekening5_id){
            $criteria = CustomFunction::criteriaGrafikBukuKas($this,'data', array('tick'=>'nmrekening5'));
            $criteria->order = 'nmrekening5';
        }else{
            if($this->rekening4_id){
                $criteria = CustomFunction::criteriaGrafikBukuKas($this,'data', array('tick'=>'nmrekening4'));
                $criteria->order = 'nmrekening4';
            }else{
                $criteria = CustomFunction::criteriaGrafikBukuKas($this,'data', array('tick'=>'nmrekening3'));
                $criteria->order = 'nmrekening3';
            }
        }
        
        $criteria->addBetweenCondition('tgljurnalpost',$this->tgl_awal, $this->tgl_akhir); 

        $criteria->compare('rekening1_id',$this->rekening1_id);            
        $criteria->compare('rekening2_id',$this->rekening2_id);            
        $criteria->compare('rekening3_id',$this->rekening3_id);            
        $criteria->compare('rekening4_id',$this->rekening4_id);            
        $criteria->compare('rekening5_id',$this->rekening5_id);
        $term = $_GET['AKLaporanBukuBesarV']['namaRekening'];
        $termKode = $_GET['AKLaporanBukuBesarV']['kodeRekening'];
    //            var_dump($termKode);
    //            exit;
        $condition  = "LOWER(nmrekening5) ILIKE '%". $term ."%' OR LOWER(nmrekening4) ILIKE '%". $term ."%' OR LOWER(nmrekening3) ILIKE '%". $term ."%'";
        $condition2 ="LOWER(kdrekening5) ILIKE '%".$termKode."%' OR LOWER(kdrekening4) ILIKE '%".$termKode."%' OR LOWER(kdrekening3) ILIKE '%".$termKode."%'";
        $criteria->addCondition($condition);
        $criteria->addCondition($condition2);

        $criteria->compare('tiperekening_id',$this->tiperekening_id);
        $criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
        $criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);

        $criteria->compare('saldodebit',$this->saldodebit);
        $criteria->compare('saldokredit',$this->saldokredit);

        $criteria->compare('jurnalposting_id',$this->jurnalposting_id);
        $criteria->compare('LOWER(noreferensi)',strtolower($this->noreferensi),true);


            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
   
	/**
	 * added By Muhammad Iqbal Laksana  (3 Agusuts 2017)
	 * @return type
	 */
    public function getKodeRekDebit()
    {
            $criteria = new CDbCriteria;
            $criteria->compare('struktur_id',$this->rekening1_id);
            $criteria->compare('kelompok_id',$this->rekening2_id);
            $criteria->compare('jenis_id',$this->rekening3_id);
            $criteria->compare('obyek_id',$this->rekening4_id);
            $criteria->compare('rincianobyek_id',$this->rekening5_id);
            $result = AKRekeningakuntansiV::model()->find($criteria);
            
            if(isset($result['rincianobyek_id']))
            {
                $kode_rekening = $result['nmrincianobyek'];
            }else{
                if(isset($result['obyek_id']))
                {
                    $kode_rekening = $result['nmobyek'];
                }else{
                    $kode_rekening = $result['nmjenis'];
                }
            }
            return ($this->saldokredit == 0 ? $kode_rekening : "-") ;
    }
	
	/**
	 * added By Muhammad Iqbal Laksana  (3 Agusuts 2017)
	 * @param type $rekperiod_id
	 * @return type
	 */
	public function getTglPeriode($rekperiod_id = null)
	{
//		$next_year = date('Y-m-d',mktime(0, 0, 0, date("m"),   date("d"),   date("Y")));
		$criteria = new CDbCriteria();
//		$criteria->addCondition('DATE(tglperiodeposting_awal) <=\''.$next_year.'\'');
//		$criteria->addCondition('DATE(tglperiodeposting_akhir) >= \''.$next_year.'\'');
		$criteria->compare('LOWER(periodeposting_nama)',strtolower($this->periodeposting_nama),true);
//		$criteria->order = "tglperiodeposting_akhir";
		if(!empty($rekperiod_id)){
			$criteria->addCondition('rekperiode_id = '.$rekperiod_id);
		}
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('rekperiode_id = '.$this->periodeposting_id);
		}
		
		return self::model()->find($criteria);
	}
	
	/**
	 * added By Muhammad Iqbal Laksana  (3 Agusuts 2017)
	 * @return string
	 */
	
	public function getKodeRekening(){
		$kodeRekening = '';
        if(isset($this->rekening5_id)){
            $kodeRekening = $this->kdrekening1." - ".$this->kdrekening2." - ".$this->kdrekening3." - ".$this->kdrekening4." - ".$this->kdrekening5;
        }else{
            if(isset($this->rekening4_id)){
                $kodeRekening = $this->kdrekening1." - ".$this->kdrekening2." - ".$this->kdrekening3." - ".$this->kdrekening4;
            }else if($this->rekening3_id){
                $kodeRekening = $this->kdrekening1." - ".$this->kdrekening2." - ".$this->kdrekening3;
            }
        }
        return $kodeRekening;
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
		$nama_rekening = '';
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
	
	public function getNamaRekeningJurnal(){
        if(!empty($this->rekeningjurnal5_id)){
			$nama_rekening = $this->rekeningjurnal5_nama;
		}else if(!empty($this->rekeningjurnal4_id)){
			$nama_rekening = $this->rekeningjurnal4_nama;
		}else if(!empty($this->rekeningjurnal3_id)){
			$nama_rekening = $this->rekeningjurnal3_nama;
		}else if(!empty($this->rekeningjurnal2_id)){
			$nama_rekening = $this->rekeningjurnal2_nama;
		}
        
        return $nama_rekening;
    }
	
	public function getRekeningJurnal(){
        if(!empty($this->rekeningjurnal5_id)){
			$rekening_id = $this->rekeningjurnal5_id;
		}else if(!empty($this->rekeningjurnal4_id)){
			$rekening_id = $this->rekeningjurnal4_id;
		}else if(!empty($this->rekeningjurnal3_id)){
			$rekening_id = $this->rekeningjurnal3_id;
		}else if(!empty($this->rekeningjurnal2_id)){
			$rekening_id = $this->rekeningjurnal2_id;
		}
        
        return $rekening_id;
    }
	
	/**
	 *  added By Muhammad Iqbal Laksana  (3 Agusuts 2017)
	 * @return int
	 */
	public function getSaldoAkhir()
    {   
            $totDebit = $this->saldodebit;
            $totKredit = $this->saldokredit;

            $totSaldo = $totDebit - $totKredit;

            if($totSaldo < 0){
                $totSaldo = 0;
            }
            
        return $totSaldo;
    }
    
	/**
	 *  added By Muhammad Iqbal Laksana  (3 Agusuts 2017)
	 * @return type
	 */
    public function getTotSaldo(){
         $criteria=$this->criteriaTable();
         $criteria->select = 'SUM(saldodebit - saldokredit)';
         return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
    }
    
	/**
	 *  added By Muhammad Iqbal Laksana  (3 Agusuts 2017)
	 * @return \CDbCriteria
	 */
    public function criteriaTable()
    {
        $criteria=new CDbCriteria;

        $criteria->select ='SUM(saldodebit) AS saldodebit,
                SUM(saldokredit) AS saldokredit';
        return $criteria;
    }
}