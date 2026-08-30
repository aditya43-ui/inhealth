<?php
class PPTarifTindakanPerdaRuanganV  extends TariftindakanperdaruanganV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TariftindakanperdaruanganV the static model class
	 */
    public $komponenunit_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function getInstalasiRuangan(){
            return $this->instalasi_nama."  /   ".$this->ruangan_nama;
        }
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if (!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(daftartindakan_nama)',  strtolower($this->daftartindakan_nama),true);
		if (!empty($this->kategoritindakan_id)){
			$criteria->addCondition('kategoritindakan_id ='.$this->kategoritindakan_id);
		}
		if (!empty($this->ruangan_id)){
			if (is_array($this->ruangan_id)){
				$criteria->addInCondition('ruangan_id',$this->ruangan_id);
			}else{
				$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
			}
		}
		if (!empty($this->instalasi_id)){
			if (is_array($this->instalasi_id)){
				$criteria->addInCondition('instalasi_id',$this->instalasi_id);
			}else{
				$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
			}
		}
		if(!empty($this->jenistarif_id)){
			$criteria->addCondition('jenistarif_id = '.$this->jenistarif_id);
		}
                $criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
                $criteria->compare('LOWER(komponenunit_nama)',strtolower($this->komponenunit_nama),true);
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//                        'pagination'=>false,
		));
	}
        
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if (!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(daftartindakan_nama)',  strtolower($this->daftartindakan_nama),true);
		if (!empty($this->kategoritindakan_id)){
			$criteria->addCondition('kategoritindakan_id ='.$this->kategoritindakan_id);
		}
		if (!empty($this->ruangan_id)){
			if (is_array($this->ruangan_id)){
				$criteria->addInCondition('ruangan_id',$this->ruangan_id);
			}else{
				$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
			}
		}
		if (!empty($this->instalasi_id)){
			if (is_array($this->instalasi_id)){
				$criteria->addInCondition('instalasi_id',$this->instalasi_id);
			}else{
				$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
			}
		}
		if(!empty($this->jenistarif_id)){
			$criteria->addCondition('jenistarif_id = '.$this->jenistarif_id);
		}
                $criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
                $criteria->compare('LOWER(komponenunit_nama)',strtolower($this->komponenunit_nama),true);
//		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
        /**
         * Mengambil daftar semua ruangan
         * @return CActiveDataProvider 
         */
        public function getRuanganItems($instalasi_id=null)
        {
            $criteria = new CDbCriteria();
			if (!empty($instalasi_id)){
				$criteria->addCondition('instalasi_id ='.$instalasi_id);
			}
            $criteria->addCondition('ruangan_aktif = true');
            $criteria->order = "ruangan_nama ASC";
            return RuanganM::model()->findAll($criteria);
        }
        
        /**
         * Mengambil daftar semua instalasi
         * @return CActiveDataProvider 
         */
        public function getInstalasiItems()
        {
            $criteria = new CDbCriteria();
            $criteria->addCondition('instalasi_aktif = true');
            $criteria->order = "instalasi_nama ASC";
            return InstalasiM::model()->findAll($criteria);
        }
        
        public function searchTarifPrint() {
            $provider = $this->searchPrint();
            $provider->criteria->order = "jenistarif_nama ASC, instalasi_nama ASC, ruangan_nama ASC, kategoritindakan_nama ASC, kelaspelayanan_nama ASC, daftartindakan_nama ASC";
           
            return $provider;
        }
}

