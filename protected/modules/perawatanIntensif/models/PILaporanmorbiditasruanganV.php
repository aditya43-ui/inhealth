<?php

/**
 * This is the model class for table "laporanmorbiditasruangan_v".
 *
 * The followings are the available columns in table 'laporanmorbiditasruangan_v':
 * @property string $tgl_pendaftaran
 * @property string $diagnosa_kode
 * @property string $diagnosa_nama
 * @property string $umur_0_6hr
 * @property string $umur_6_28hr
 * @property string $umur_28hr_1thn
 * @property string $umur_1_4thn
 * @property string $umur_5_14thn
 * @property string $umur_15_24thn
 * @property string $umur_25_44thn
 * @property string $umur_45_64thn
 * @property string $umur_65
 * @property string $lakilaki_kasusbaru
 * @property string $perempuan_kasusbaru
 * @property string $jml_kasusbaru
 * @property string $lakilaki_kasuslama
 * @property string $perempuan_kasuslama
 * @property string $jml_kasuslama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 */
class PILaporanmorbiditasruanganV extends LaporanmorbiditasruanganV
{
        public $tgl_awal,$tgl_akhir;
                
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanmorbiditasruanganV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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

		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(umur_0_6hr)',strtolower($this->umur_0_6hr),true);
		$criteria->compare('LOWER(umur_6_28hr)',strtolower($this->umur_6_28hr),true);
		$criteria->compare('LOWER(umur_28hr_1thn)',strtolower($this->umur_28hr_1thn),true);
		$criteria->compare('LOWER(umur_1_4thn)',strtolower($this->umur_1_4thn),true);
		$criteria->compare('LOWER(umur_5_14thn)',strtolower($this->umur_5_14thn),true);
		$criteria->compare('LOWER(umur_15_24thn)',strtolower($this->umur_15_24thn),true);
		$criteria->compare('LOWER(umur_25_44thn)',strtolower($this->umur_25_44thn),true);
		$criteria->compare('LOWER(umur_45_64thn)',strtolower($this->umur_45_64thn),true);
		$criteria->compare('LOWER(umur_65)',strtolower($this->umur_65),true);
		$criteria->compare('LOWER(lakilaki_kasusbaru)',strtolower($this->lakilaki_kasusbaru),true);
		$criteria->compare('LOWER(perempuan_kasusbaru)',strtolower($this->perempuan_kasusbaru),true);
		$criteria->compare('LOWER(jml_kasusbaru)',strtolower($this->jml_kasusbaru),true);
		$criteria->compare('LOWER(lakilaki_kasuslama)',strtolower($this->lakilaki_kasuslama),true);
		$criteria->compare('LOWER(perempuan_kasuslama)',strtolower($this->perempuan_kasuslama),true);
		$criteria->compare('LOWER(jml_kasuslama)',strtolower($this->jml_kasuslama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);

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
}