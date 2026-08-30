<?php

class MCDiagnosaM extends DiagnosaM
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function searchKeluhanPenyakit()
    {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->diagnosa_id)){
			$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id); 			
		}
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('LOWER(diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
//            $criteria->with=array('dtdDiagnosa');
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
//                         'pagination'=>10,
		));
    }
    
    public function searchImunisasi()
    {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->diagnosa_id)){
			$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id); 			
		}
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('LOWER(diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
		$criteria->condition = "diagnosa_imunisasi = true";
		$criteria->with=array('dtdDiagnosa');

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
//                         'pagination'=>10,
		));
    }
}

?>