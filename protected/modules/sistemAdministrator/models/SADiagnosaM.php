<?php

/**
 * This is the model class for table "diagnosa_m".
 *
 * The followings are the available columns in table 'diagnosa_m':
 * @property integer $diagnosa_id
 * @property string $diagnosa_kode
 * @property string $diagnosa_nama
 * @property string $diagnosa_namalainnya
 * @property string $diagnosa_katakunci
 * @property integer $diagnosa_nourut
 * @property boolean $diagnosa_imunisasi
 * @property boolean $diagnosa_aktif
 */
class SADiagnosaM extends DiagnosaM
{
       
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosaM the static model class
	 */        
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
		
	}
        
        public function getNamaModel(){
            return __CLASS__;
        }


        /**
	 * searchDiagnosis() berfungsi untuk menampilkan nama-nama diagnosa yang diinginkan	
	 * @author David Y | 19-05-2014		 
	 */
	public function searchDiagnosis()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		if (!empty($this->diagnosa_id)){
			$criteria->addCondition('diagnosa_id ='.$this->diagnosa_id);
		}
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('LOWER(diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
		$criteria->compare('diagnosa_nourut',$this->diagnosa_nourut);
		$criteria->compare('diagnosa_imunisasi',$this->diagnosa_imunisasi);
		//$criteria->compare('dtd_id',$this->dtd_id);
                $criteria->with=array('dtdDiagnosa');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//                         'pagination'=>10,
		));
	}
        
        


}