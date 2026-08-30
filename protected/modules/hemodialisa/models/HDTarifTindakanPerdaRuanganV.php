<?php
class HDTarifTindakanPerdaRuanganV  extends TariftindakanperdaruanganV
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
			$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(daftartindakan_nama)',  strtolower($this->daftartindakan_nama),true);
		if (!empty($this->kategoritindakan_id)){
			$criteria->addCondition('kategoritindakan_id ='.$this->kategoritindakan_id);
		}
		$criteria->addCondition('ruangan_id ='.Yii::app()->user->getState('ruangan_id'));
		if(!empty($this->jenistarif_id)){
			$criteria->addCondition('jenistarif_id = '.$this->jenistarif_id);
		}
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        

	
}

