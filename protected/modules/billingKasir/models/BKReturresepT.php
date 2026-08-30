<?php

class BKReturresepT extends ReturresepT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReturresepT the static model class
	 */
        public $tgl_awal, $tgl_akhir, $noResep, $noPendaftaran, $noRm,$namaPasien; //untuk pencarian
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->with = array('pasien', 'penjualanresep', 'pendaftaran', 'pasienadmisi');
		$criteria->addBetweenCondition('tglretur',$this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->returresep_id)){
			$criteria->addCondition("returresep_id = ".$this->returresep_id);					
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);					
		}
		if(!empty($this->penjualanresep_id)){
			$criteria->addCondition("penjualanresep_id = ".$this->penjualanresep_id);					
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);					
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);					
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id);					
		}
		$criteria->compare('LOWER(tglretur)',strtolower($this->tglretur),true);
		$criteria->compare('LOWER(noreturresep)',strtolower($this->noreturresep),true);
		$criteria->compare('LOWER(alasanretur)',strtolower($this->alasanretur),true);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition("mengetahui_id = ".$this->mengetahui_id);					
		}
		if(!empty($this->pegretur_id)){
			$criteria->addCondition("pegretur_id = ".$this->pegretur_id);					
		}
		$criteria->compare('totalretur',$this->totalretur);                
		$criteria->compare('LOWER(penjualanresep.noresep)',strtolower($this->noResep),true);
		$criteria->compare('LOWER(pendaftaran.no_pendaftaran)',strtolower($this->noPendaftaran),true);
		$criteria->compare('LOWER(pasien.no_rekam_medik)',strtolower($this->noRm),true);
		$criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->namaPasien),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getTotalOaSudahBayar(){
            $criteria = new CDbCriteria();
            
            $criteria->group = 'returresep_id';
            $criteria->select = $criteria->group.", sum(t.qty_retur * t.hargasatuan) as totaloasudahbayar";
            $criteria->addCondition('returresep_id ='.$this->returresep_id);
            $criteria->addCondition('obatalkespasien_t.oasudahbayar_id IS NOT NULL');
            $criteria->join = 'JOIN obatalkespasien_t ON obatalkespasien_t.obatalkespasien_id = t.obatalkespasien_id';
            
            $model = BKReturresepdetT::model()->find($criteria);
            
            if(isset($model)){
                return $model->totaloasudahbayar;
            }else{
                return 0;
            }
            
        }
	
}