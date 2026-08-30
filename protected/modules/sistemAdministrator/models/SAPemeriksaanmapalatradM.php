<?php

/**
 * This is the model class for table "pemeriksaanmapalatrad_m".
 *
 * The followings are the available columns in table 'pemeriksaanmapalatrad_m':
 * @property integer $pemeriksaanalatrad_id
 * @property integer $pemeriksaanrad_id
 */
class SAPemeriksaanmapalatradM extends PemeriksaanmapalatradM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanmapalatradM the static model class
	 */
	public $pemeriksaanrad_nama;
	public $jenispemeriksaanrad_nama;
	public $pemeriksaanrad_namalain;
	public $pemeriksaanalatrad_nama;
	public $daftartindakan_id, $daftartindakan_nama;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('pemeriksaanalatrad','pemeriksaanrad');
		if(!empty($this->pemeriksaanalatrad_id)){
			$criteria->addCondition('pemeriksaanalatrad_id = '.$this->pemeriksaanalatrad_id);
		}
		if(!empty($this->pemeriksaanrad_id)){
			$criteria->addCondition('pemeriksaanrad_id = '.$this->pemeriksaanrad_id);
		}
		$criteria->compare('LOWER(pemeriksaanalatrad.pemeriksaanalatrad_nama)', strtolower($this->pemeriksaanalatrad_nama), true);
		$criteria->compare('LOWER(pemeriksaanrad.daftartindakan.daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
		$criteria->compare('LOWER(pemeriksaaanrad.jenispemeriksaanrad.jenispemeriksaanrad_nama)', strtolower($this->jenispemeriksaanrad_nama), true);
		$criteria->compare('LOWER(pemeriksaaanrad.pemeriksaanrad_nama)', strtolower($this->pemeriksaanrad_nama), true);
		$criteria->compare('LOWER(pemeriksaaanrad.pemeriksaanrad_namalain)', strtolower($this->pemeriksaanrad_namalain), true);

		return $criteria;
	}
	
	public function search()
	{
		$criteria=$this->criteriaSearch();
		$criteria->limit=10;
        return new CActiveDataProvider($this, array(
												'criteria'=>$criteria,
											));
	}
	
	public function searchTabel()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
            
		$criteria=new CDbCriteria;
        $criteria->with = array('pemeriksaanalatrad','pemeriksaanrad');
        $criteria->order = 't.pemeriksaanalatrad_id';
        if(!empty($this->pemeriksaanalatrad_id)){
			$criteria->addCondition('t.pemeriksaanalatrad_id = '.$this->pemeriksaanalatrad_id);
		}             
	    $criteria->compare('LOWER(pemeriksaanalatrad.pemeriksaanalatrad_nama)',strtolower($this->pemeriksaanalatrad_nama),true);
	    $criteria->compare('LOWER(pemeriksaanrad.pemeriksaanrad_nama)',strtolower($this->pemeriksaanrad_nama),true);
		if(!empty($this->pemeriksaanrad_id)){
			$criteria->addCondition('t.pemeriksaanrad_id = '.$this->pemeriksaanrad_id);
		}    
		
		return new CActiveDataProvider($this, array(
												'criteria'=>$criteria,
                        'sort'=>array(
                            'attributes'=>array(
                                'pemeriksaanalatrad_nama'=>array(
                                    'asc'=>'pemeriksaanalatrad.pemeriksaanalatrad_nama',
                                    'desc'=>'pemeriksaanalatrad.pemeriksaanalatrad_nama DESC',
                                ),
                                '*',
                            ),
                        ),
											));
	}

	public function searchPrint ()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
        $criteria->with = array('pemeriksaanalatrad','pemeriksaanrad');
        $criteria->order = 't.pemeriksaanalatrad_id';
        
		if(!empty($this->pemeriksaanalatrad_id)){
			$criteria->addCondition('pemeriksaanalatrad_id = '.$this->pemeriksaanalatrad_id);
		}
		if(!empty($this->pemeriksaanrad_id)){
			$criteria->addCondition('pemeriksaanrad_id = '.$this->pemeriksaanrad_id);
		}    
	    $criteria->compare('LOWER(pemeriksaanalatrad.pemeriksaanalatrad_nama)',strtolower($this->pemeriksaanalatrad_nama),true);
	    $criteria->compare('LOWER(pemeriksaanrad.pemeriksaanrad_nama)',strtolower($this->pemeriksaanrad_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                            'attributes'=>array(
                                'pemeriksaanalatrad_nama'=>array(
                                    'asc'=>'pemeriksaanalatrad.pemeriksaanalatrad_nama',
                                    'desc'=>'pemeriksaanalatrad.pemeriksaanalatrad_nama DESC',
                                ),
                                '*',
                            ),
                        ),
                        'pagination'=>false,
		));
	}
	
	public function getPemeriksaanradItems()
		{
			 return PemeriksaanradM::model()->findAll('pemeriksaanrad_aktif=TRUE ORDER BY pemeriksaanrad_nama');
		}
	
	public function getPemeriksaanalatradItems()
		{
			 return PemeriksaanalatradM::model()->findAll('pemeriksaanalatrad_aktif=TRUE ORDER BY pemeriksaanalatrad_id');
		}
		

}