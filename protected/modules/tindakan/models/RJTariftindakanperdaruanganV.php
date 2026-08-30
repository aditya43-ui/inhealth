<?php
class RJTariftindakanperdaruanganV extends TariftindakanperdaruanganV
{
	public $is_pilih = 0;
	public $tipepaket_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TariftindakanperdaruanganV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchInformasiMcu()
	{
		$criteria=new CDbCriteria;
				if(!empty($this->kelaspelayanan_id)){ $criteria->addCondition('kelaspelayanan_id ='. $this->kelaspelayanan_id); }
                $criteria->compare('LOWER(daftartindakan_nama)',  strtolower($this->daftartindakan_nama),true);
				if(!empty($this->kategoritindakan_id)){ $criteria->addCondition('kategoritindakan_id ='. $this->kategoritindakan_id); }
                if(!empty($this->jenistarif_id)){
					$criteria->addCondition('jenistarif_id = '.$this->jenistarif_id);
				}
                                $criteria->compare('kelompoktindakan_id', $this->kelompoktindakan_id);
                                $criteria->compare('komponenunit_id', $this->komponenunit_id);
				$criteria->addCondition('ruangan_id ='.Yii::app()->user->getState('ruangan_id'));
                $criteria->limit = 10;
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	                               
        
        public function searchTarifMcuPrint() {
            $provider = $this->searchInformasiMcu();			
            $provider->criteria->limit = -1;
            $provider->pagination = false;
            
            return $provider;
        }
        
}