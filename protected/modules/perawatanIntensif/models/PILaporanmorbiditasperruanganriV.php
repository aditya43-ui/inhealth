<?php

/**
 * This is the model class for table "laporanmorbiditasperruanganri_v".
 *
 * The followings are the available columns in table 'laporanmorbiditasperruanganri_v':
 * @property string $tglpulang
 * @property string $diagnosa_kode
 * @property string $diagnosa_nama
 * @property string $umur_0_6hr_lakilaki
 * @property string $umur_0_6hr_perempuan
 * @property string $umur_6_28hr_lakilaki
 * @property string $umur_6_28hr_perempuan
 * @property string $umur_28hr_1thn_lakilaki
 * @property string $umur_28hr_1thn_perempuan
 * @property string $umur_1_4thn_lakilaki
 * @property string $umur_1_4thn_perempuan
 * @property string $umur_5_14thn_lakilaki
 * @property string $umur_5_14thn_perempuan
 * @property string $umur_15_24thn_lakilaki
 * @property string $umur_15_24thn_perempuan
 * @property string $umur_25_44thn_lakilaki
 * @property string $umur_25_44thn_perempuan
 * @property string $umur_45_64thn_lakilaki
 * @property string $umur_45_64thn_perempuan
 * @property string $umur_65_lakilaki
 * @property string $umur_65_perempuan
 * @property string $lakilaki_kasusbaru
 * @property string $perempuan_kasusbaru
 * @property string $jml_kasusbaru
 * @property string $lakilaki_kasuslama
 * @property string $perempuan_kasuslama
 * @property string $jml_kasuslama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 */
class PILaporanmorbiditasperruanganriV extends LaporanmorbiditasperruanganriV
{
        public $tgl_awal,$tgl_akhir,$is_nursestation;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanmorbiditasperruanganriV the static model class
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

		$criteria->compare('LOWER(tglpulang)',strtolower($this->tglpulang),true);
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(umur_0_6hr_lakilaki)',strtolower($this->umur_0_6hr_lakilaki),true);
		$criteria->compare('LOWER(umur_0_6hr_perempuan)',strtolower($this->umur_0_6hr_perempuan),true);
		$criteria->compare('LOWER(umur_6_28hr_lakilaki)',strtolower($this->umur_6_28hr_lakilaki),true);
		$criteria->compare('LOWER(umur_6_28hr_perempuan)',strtolower($this->umur_6_28hr_perempuan),true);
		$criteria->compare('LOWER(umur_28hr_1thn_lakilaki)',strtolower($this->umur_28hr_1thn_lakilaki),true);
		$criteria->compare('LOWER(umur_28hr_1thn_perempuan)',strtolower($this->umur_28hr_1thn_perempuan),true);
		$criteria->compare('LOWER(umur_1_4thn_lakilaki)',strtolower($this->umur_1_4thn_lakilaki),true);
		$criteria->compare('LOWER(umur_1_4thn_perempuan)',strtolower($this->umur_1_4thn_perempuan),true);
		$criteria->compare('LOWER(umur_5_14thn_lakilaki)',strtolower($this->umur_5_14thn_lakilaki),true);
		$criteria->compare('LOWER(umur_5_14thn_perempuan)',strtolower($this->umur_5_14thn_perempuan),true);
		$criteria->compare('LOWER(umur_15_24thn_lakilaki)',strtolower($this->umur_15_24thn_lakilaki),true);
		$criteria->compare('LOWER(umur_15_24thn_perempuan)',strtolower($this->umur_15_24thn_perempuan),true);
		$criteria->compare('LOWER(umur_25_44thn_lakilaki)',strtolower($this->umur_25_44thn_lakilaki),true);
		$criteria->compare('LOWER(umur_25_44thn_perempuan)',strtolower($this->umur_25_44thn_perempuan),true);
		$criteria->compare('LOWER(umur_45_64thn_lakilaki)',strtolower($this->umur_45_64thn_lakilaki),true);
		$criteria->compare('LOWER(umur_45_64thn_perempuan)',strtolower($this->umur_45_64thn_perempuan),true);
		$criteria->compare('LOWER(umur_65_lakilaki)',strtolower($this->umur_65_lakilaki),true);
		$criteria->compare('LOWER(umur_65_perempuan)',strtolower($this->umur_65_perempuan),true);
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
        
        public function getRuanganNurse(){
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modRuangNurse = NursestationruanganM::model()->find('ruangan_id = '.$ruangan_id);
            $arayRuangan = array();
            if(isset($modRuangNurse->nursestation_id)){
                $modNurse = NursestationruanganM::model()->findAll('nursestation_id = '.$modRuangNurse->nursestation_id);
                foreach ($modNurse as $value) {
                    $arayRuangan[] = $value->ruangan_id;
                }
            }
            $criteria=new CDbCriteria;
            $criteria->addInCondition('ruangan_id', $arayRuangan);
            return $criteria;
        }
}