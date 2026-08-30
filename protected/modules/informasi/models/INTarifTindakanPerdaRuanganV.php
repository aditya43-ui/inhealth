<?php
class INTarifTindakanPerdaRuanganV  extends TariftindakanperdaruanganV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TariftindakanperdaruanganV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function getInstalasiRuangan(){
            return $this->instalasi_nama."  /   ".$this->ruangan_nama;
        }
        
        public function searchInformasi()
	{
                $criteria=new CDbCriteria;
                if(!empty($this->kelaspelayanan_id))
                { 
                    $criteria->addCondition("t.kelaspelayanan_id = ".$this->kelaspelayanan_id); 
                } 
                $criteria->compare('LOWER(t.daftartindakan_nama)',  strtolower($this->daftartindakan_nama),true);
                if(!empty($this->kategoritindakan_id))
                { 
                    $criteria->addCondition("t.kategoritindakan_id = ".$this->kategoritindakan_id); 
                }
                if(!empty($this->instalasi_id))
                { 
                    $criteria->addCondition("t.instalasi_id = ".$this->instalasi_id); 
                } 
                if(!empty($this->ruangan_id))
                { 
                    $criteria->addCondition("t.ruangan_id = ".$this->ruangan_id); 
                } 
				if(!empty($this->jenistarif_id)){
					$criteria->addCondition('t.jenistarif_id = '.$this->jenistarif_id);
				}				
				if(!empty($this->carabayar_id)){
					$criteria->addCondition('t.carabayar_id = '.$this->carabayar_id);
				}
				if(!empty($this->penjamin_id)){
					$criteria->addCondition('t.penjamin_id = '.$this->penjamin_id);
				}
                
                $criteria->join = 'join ruangan_m r on r.ruangan_id = t.ruangan_id';
                $criteria->addCOndition('r.ruangan_aktif = true');
                
                $criteria->limit = 10;
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
         public function criteriaInformasiTarif()
                {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                                $criteria->select = 'instalasi_nama,ruangan_nama,kelompoktindakan_nama,kategoritindakan_nama,daftartindakan_nama';
                                $criteria->order = 'instalasi_nama';
                                $criteria->group = 'instalasi_nama,ruangan_nama,kelompoktindakan_nama,kategoritindakan_nama,daftartindakan_nama';
                                $criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
                                if(!empty($this->kategoritindakan_id))
                                { 
                                    $criteria->addCondition("kategoritindakan_id = ".$this->kategoritindakan_id); 
                                } 
                                if(!empty($this->instalasi_id))
                                { 
                                    $criteria->addCondition("instalasi_id = ".$this->instalasi_id); 
                                } 
                                if(!empty($this->kelaspelayanan_id))
                                { 
                                    $criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id); 
                                } 
                                
                                return $criteria;
                }
                public function searchInformasiPrint()
	{
		return new CActiveDataProvider($this, array(
			'criteria'=>$this->criteriaInformasiTarif(),
                                                'pagination'=>array(
                                                    'pageSize'=>1000,
                                                )
		));
	}
        
        public function getInstalasiItems()
        {
            return InstalasiM::model()->findAll('instalasi_aktif=TRUE  ORDER BY instalasi_nama');
        }
		
		/**
         * Mengambil daftar semua ruangan
         * @return CActiveDataProvider 
         */
        public function getRuanganItems($instalasi_id=null)
        {
            $criteria = new CDbCriteria();
            if(!empty($instalasi_id))
            { 
                $criteria->addCondition("instalasi_id = ".$instalasi_id); 
            } 
            $criteria->addCondition('ruangan_aktif = true');
            $criteria->order = "ruangan_nama";
            return RuanganM::model()->findAll($criteria);
        }
        

	
}

