<?php

/**
 * This is the model class for table "pemeriksaanalatrad_m".
 *
 * The followings are the available columns in table 'pemeriksaanalatrad_m':
 * @property integer $pemeriksaanalatrad_id
 * @property integer $alatmedis_id
 * @property string $pemeriksaanalatrad_kode
 * @property string $pemeriksaanalatrad_nama
 * @property string $pemeriksaanalatrad_namalain
 * @property string $pemeriksaanalatrad_aetitle
 * @property boolean $pemeriksaanalatrad_aktif
 */
class SAPemeriksaanalatradM extends PemeriksaanalatradM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanalatradM the static model class
	 */
	public $alatmedis_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pemeriksaanalatrad_id)){
			$criteria->addCondition('pemeriksaanalatrad_id = '.$this->pemeriksaanalatrad_id);
		}
		if(!empty($this->alatmedis_id)){
			$criteria->addCondition('alatmedis_id = '.$this->alatmedis_id);
		}
		$criteria->compare('LOWER(alatmedis.alatmedis_nama)',strtolower($this->alatmedis_nama),true); 
		$criteria->compare('LOWER(pemeriksaanalatrad_kode)',strtolower($this->pemeriksaanalatrad_kode),true);
		$criteria->compare('LOWER(pemeriksaanalatrad_nama)',strtolower($this->pemeriksaanalatrad_nama),true);
		$criteria->compare('LOWER(pemeriksaanalatrad_namalain)',strtolower($this->pemeriksaanalatrad_namalain),true);
		$criteria->compare('LOWER(pemeriksaanalatrad_aetitle)',strtolower($this->pemeriksaanalatrad_aetitle),true);
		$criteria->compare('pemeriksaanalatrad_aktif',isset($this->pemeriksaanalatrad_aktif)?$this->pemeriksaanalatrad_aktif:true);
		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
		
		 public function searchDialog()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

		if(!empty($this->pemeriksaanalatrad_id)){
			$criteria->addCondition('pemeriksaanalatrad_id = '.$this->pemeriksaanalatrad_id);
		}
		if(!empty($this->alatmedis_id)){
			$criteria->addCondition('alatmedis_id = '.$this->alatmedis_id);
		}
		$criteria->compare('LOWER(alatmedis.alatmedis_nama)',strtolower($this->alatmedis_nama),true); 
		$criteria->compare('LOWER(pemeriksaanalatrad_kode)',strtolower($this->pemeriksaanalatrad_kode),true);
		$criteria->compare('LOWER(pemeriksaanalatrad_nama)',strtolower($this->pemeriksaanalatrad_nama),true);
		$criteria->compare('LOWER(pemeriksaanalatrad_namalain)',strtolower($this->pemeriksaanalatrad_namalain),true);
		$criteria->compare('LOWER(pemeriksaanalatrad_aetitle)',strtolower($this->pemeriksaanalatrad_aetitle),true);
        $criteria->compare('pemeriksaanalatrad_aktif',isset($this->pemeriksaanalatrad_aktif)?$this->pemeriksaanalatrad_aktif:true); 
		$criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
		public function getAlatmedisItems()
		{
			 return AlatmedisM::model()->findAll('alatmedis_aktif=TRUE ORDER BY alatmedis_nama');
		}

}