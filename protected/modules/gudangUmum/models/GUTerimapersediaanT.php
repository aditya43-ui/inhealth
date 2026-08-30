<?php

class GUTerimapersediaanT extends TerimapersediaanT{
    
    public $sumberdana, $instalasi_nama, $ruanganpenerima_nama;
    public $totalkeseluruhan;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                        $criteria->addBetweenCondition('date(tglterima)', $this->tgl_awal, $this->tgl_akhir);
                }else{
                    if (!empty($this->tglterima))
                    {
                        $criteria->addBetweenCondition('date(tglterima)', MyFormatter::formatDateTimeForDb($this->tglterima), MyFormatter::formatDateTimeForDb($this->tglterima));
                    }
                }
		if(!empty($this->terimapersediaan_id)){
			$criteria->addCondition("terimapersediaan_id = ".$this->terimapersediaan_id);			
		}
		if(!empty($this->pembelianbarang_id)){
			$criteria->addCondition("pembelianbarang_id = ".$this->pembelianbarang_id);			
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);			
		}
		if(!empty($this->returpenerimaan_id)){
			$criteria->addCondition("returpenerimaan_id = ".$this->returpenerimaan_id);			
		}
		$criteria->compare('LOWER(nopenerimaan)',strtolower($this->nopenerimaan),true);
		$criteria->compare('LOWER(tglsuratjalan)',strtolower($this->tglsuratjalan),true);
		$criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
		$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(keterangan_persediaan)',strtolower($this->keterangan_persediaan),true);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('pajakpph',$this->pajakpph);
		$criteria->compare('pajakppn',$this->pajakppn);
		$criteria->compare('LOWER(nofakturpajak)',strtolower($this->nofakturpajak),true);
		if(!empty($this->peg_penerima_id)){
			$criteria->addCondition("peg_penerima_id = ".$this->peg_penerima_id);			
		}
		if(!empty($this->peg_mengetahui_id)){
			$criteria->addCondition("peg_mengetahui_id = ".$this->peg_mengetahui_id);			
		}
		if(!empty($this->ruanganpenerima_id)){
			$criteria->addCondition("ruanganpenerima_id = ".$this->ruanganpenerima_id);			
		}
                
                if (!empty($this->supplier_id)){
                    $criteria->addCondition("supplier_id = ".$this->supplier_id);			
                }
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('DATE(tgljatuhtempo)',$this->tgljatuhtempo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getNamaModel(){
            return __CLASS__;
        }
}

?>
