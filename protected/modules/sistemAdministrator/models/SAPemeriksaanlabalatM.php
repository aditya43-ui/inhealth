<?php

/**
 * This is the model class for table "pemeriksaanlabalat_m".
 *
 * The followings are the available columns in table 'pemeriksaanlabalat_m':
 * @property integer $pemeriksaanlabalat_id
 * @property integer $alatmedis_id
 * @property string $pemeriksaanlabalat_kode
 * @property string $pemeriksaanlabalat_nama
 * @property string $pemeriksaanlabalat_namalain
 * @property boolean $pemeriksaanlabalat_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $createruangan
 */
class SAPemeriksaanlabalatM extends PemeriksaanlabalatM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanlabalatM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanlabalat_id' => 'ID',
			'alatmedis_id' => 'Alat Medis',
			'pemeriksaanlabalat_kode' => 'Kode',
			'pemeriksaanlabalat_nama' => 'Nama Alat Lab.',
			'pemeriksaanlabalat_namalain' => 'Nama Lain',
			'pemeriksaanlabalat_aktif' => 'Alat Lab. Aktif',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'createruangan' => 'Createruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pemeriksaanlabalat_id)){
			$criteria->addCondition('pemeriksaanlabalat_id = '.$this->pemeriksaanlabalat_id);
		}
		if(!empty($this->alatmedis_id)){
			$criteria->addCondition('alatmedis_id = '.$this->alatmedis_id);
		}
		$criteria->compare('LOWER(pemeriksaanlabalat_kode)',strtolower($this->pemeriksaanlabalat_kode),true);
		$criteria->compare('LOWER(pemeriksaanlabalat_nama)',strtolower($this->pemeriksaanlabalat_nama),true);
		$criteria->compare('LOWER(pemeriksaanlabalat_namalain)',strtolower($this->pemeriksaanlabalat_namalain),true);
		$criteria->compare('pemeriksaanlabalat_aktif',isset($this->pemeriksaanlabalat_aktif)?$this->pemeriksaanlabalat_aktif:true);

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

            $criteria=$this->criteriaSearch();
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