<?php

class RINRuanganM extends TindakanruanganM
{
    public $daftartindakan_id,$instalasi_nama,$ruangan_nama, $kategoritindakan_nama, $daftartindakan_kode, $daftartindakan_nama;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TabularlistM the static model class
	 */
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
		$criteria->with = array('ruangan','daftartindakan','daftartindakan.kategoritindakan');
		
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("t.ruangan_id = ".$this->ruangan_id); 	
		}
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition("t.daftartindakan_id = ".$this->daftartindakan_id); 	
		}
		$criteria->compare('LOWER(ruangan.ruangan_nama)',  strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(kategoritindakan.kategoritindakan_nama)',  strtolower($this->kategoritindakan_nama), true);
		$criteria->compare('LOWER(daftartindakan.daftartindakan_kode)',  strtolower($this->daftartindakan_kode), true);
		$criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',  strtolower($this->daftartindakan_nama), true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}