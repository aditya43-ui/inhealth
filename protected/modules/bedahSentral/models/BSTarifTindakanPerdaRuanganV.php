<?php
class BSTarifTindakanPerdaRuanganV  extends TariftindakanperdaruanganV
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
        
       public function searchInformasi()
	{
		$criteria=new CDbCriteria;
		
		if (!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('t.kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}		
		if (!empty($this->kategoritindakan_id)){
			$criteria->addCondition('t.kategoritindakan_id ='.$this->kategoritindakan_id);
		}
		$criteria->addCondition('t.ruangan_id ='.Yii::app()->user->getState('ruangan_id'));
		if(!empty($this->jenistarif_id)){
			$criteria->addCondition('t.jenistarif_id = '.$this->jenistarif_id);
		}
                if(!empty($this->kelompoktindakan_id)){
			$criteria->addCondition('t.kelompoktindakan_id = '.$this->kelompoktindakan_id);
		}
                if(!empty($this->komponenunit_id)){
			$criteria->addCondition('t.komponenunit_id = '.$this->komponenunit_id);
		}
                
		$criteria->compare('LOWER(t.daftartindakan_nama)',  strtolower($this->daftartindakan_nama), TRUE);
		$criteria->limit = 10;
		$criteria->order = "jenistarif_nama ASC, kelompoktindakan_nama ASC, komponenunit_nama ASC, kategoritindakan_nama ASC, kelaspelayanan_nama ASC, daftartindakan_nama ASC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchTarifPrint() {
            $provider = $this->searchInformasi();
			$provider->criteria->limit = -1;
            $provider->pagination = false;
            
            return $provider;
        }
        
        

	
}

