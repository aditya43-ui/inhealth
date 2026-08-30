<?php

class GULaporanReturPenerimaanT extends ReturpenerimaanT{
    public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchReturPenerimaan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->addBetweenCondition('tglreturterima',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->returpenerimaan_id)){
			$criteria->addCondition("returpenerimaan_id = ".$this->returpenerimaan_id);			
		}
		if(!empty($this->terimapersediaan_id)){
			$criteria->addCondition("terimapersediaan_id = ".$this->terimapersediaan_id);			
		}
		$criteria->compare('LOWER(noreturterima)',strtolower($this->noreturterima),true);
		$criteria->compare('LOWER(alasanreturterima)',strtolower($this->alasanreturterima),true);
		$criteria->compare('LOWER(keterangan_retur)',strtolower($this->keterangan_retur),true);
		$criteria->compare('totalretur',$this->totalretur);
		if(!empty($this->peg_retur_id)){
			$criteria->addCondition("peg_retur_id = ".$this->peg_retur_id);			
		}
		if(!empty($this->peg_mengetahui_id)){
			$criteria->addCondition("peg_mengetahui_id = ".$this->peg_mengetahui_id);			
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchReturPenerimaanPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('tglreturterima',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->returpenerimaan_id)){
			$criteria->addCondition("returpenerimaan_id = ".$this->returpenerimaan_id);			
		}
		if(!empty($this->terimapersediaan_id)){
			$criteria->addCondition("terimapersediaan_id = ".$this->terimapersediaan_id);			
		}
		$criteria->compare('LOWER(noreturterima)',strtolower($this->noreturterima),true);
		$criteria->compare('LOWER(alasanreturterima)',strtolower($this->alasanreturterima),true);
		$criteria->compare('LOWER(keterangan_retur)',strtolower($this->keterangan_retur),true);
		$criteria->compare('totalretur',$this->totalretur);
		if(!empty($this->peg_retur_id)){
			$criteria->addCondition("peg_retur_id = ".$this->peg_retur_id);			
		}
		if(!empty($this->peg_mengetahui_id)){
			$criteria->addCondition("peg_mengetahui_id = ".$this->peg_mengetahui_id);			
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
         public function searchTable() {
            $criteria = new CDbCriteria();
            $criteria = $this->functionCriteria();
            $criteria->order = 'tglreturterima';

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
         }
     
        protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('tglreturterima',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->returpenerimaan_id)){
			$criteria->addCondition("returpenerimaan_id = ".$this->returpenerimaan_id);			
		}
		if(!empty($this->terimapersediaan_id)){
			$criteria->addCondition("terimapersediaan_id = ".$this->terimapersediaan_id);			
		}
        $criteria->compare('LOWER(noreturterima)',strtolower($this->noreturterima),true);
        $criteria->compare('LOWER(alasanreturterima)',strtolower($this->alasanreturterima),true);
        $criteria->compare('LOWER(keterangan_retur)',strtolower($this->keterangan_retur),true);
        $criteria->compare('totalretur',$this->totalretur);
		if(!empty($this->peg_retur_id)){
			$criteria->addCondition("peg_retur_id = ".$this->peg_retur_id);			
		}
		if(!empty($this->peg_mengetahui_id)){
			$criteria->addCondition("peg_mengetahui_id = ".$this->peg_mengetahui_id);			
		}
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

        return $criteria;
    }
     
     public function searchReturpenerimaangrafik()
     {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

            $criteria=new CDbCriteria;
            
            $criteria->select = 'count(returpenerimaan_id) as jumlah, date(tglreturterima) as data';
            $criteria->group = 'date(tglreturterima)';
            $criteria->addBetweenCondition('tglreturterima',$this->tgl_awal,$this->tgl_akhir,true);
			if(!empty($this->returpenerimaan_id)){
				$criteria->addCondition("returpenerimaan_id = ".$this->returpenerimaan_id);			
			}
			if(!empty($this->terimapersediaan_id)){
				$criteria->addCondition("terimapersediaan_id = ".$this->terimapersediaan_id);			
			}
            $criteria->compare('LOWER(noreturterima)',strtolower($this->noreturterima),true);
            $criteria->compare('LOWER(alasanreturterima)',strtolower($this->alasanreturterima),true);
            $criteria->compare('LOWER(keterangan_retur)',strtolower($this->keterangan_retur),true);
            $criteria->compare('totalretur',$this->totalretur);
			if(!empty($this->peg_retur_id)){
				$criteria->addCondition("peg_retur_id = ".$this->peg_retur_id);			
			}
			if(!empty($this->peg_mengetahui_id)){
				$criteria->addCondition("peg_mengetahui_id = ".$this->peg_mengetahui_id);			
			}
            $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
            $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
            $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
            $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
               
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
               // $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    
    public function Criteria()
	{
		$criteria = new CDbCriteria;
		
		if(!empty($this->returpenerimaan_id)){
			$criteria->addCondition("returpenerimaan_id = ".$this->returpenerimaan_id);			
		}
		$criteria->addBetweenCondition('tglreturterima',$this->tgl_awal,$this->tgl_akhir);
		return $criteria;
	}  
	public function getTotalRetur()
	{
		$criteria=$this->Criteria();
		$criteria->select = 'SUM(totalretur)';
		return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
	}
        
}

?>
