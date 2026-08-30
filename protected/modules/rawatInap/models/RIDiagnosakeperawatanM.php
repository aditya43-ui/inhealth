<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class RIDiagnosakeperawatanM extends DiagnosakeperawatanM
{
    public $diagnosa_nama;
    public $diagnosakeperawatan_kode;
    public $kriteriahasil_nama;
    public $kriteriahasil_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosatindakanM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
                public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		if(!empty($this->diagnosakeperawatan_id)){
			$criteria->addCondition("diagnosakeperawatan_id = ".$this->diagnosakeperawatan_id); 	
		}
		if(!empty($this->diagnosa_id)){
			$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id); 	
		}
		$criteria->compare('LOWER(diagnosakeperawatan_kode)',strtolower($this->diagnosakeperawatan_kode),true);
		$criteria->compare('LOWER(diagnosa_medis)',strtolower($this->diagnosa_medis),true);
		$criteria->compare('LOWER(diagnosa_keperawatan)',strtolower($this->diagnosa_keperawatan),true);
		$criteria->compare('LOWER(diagnosa_tujuan)',strtolower($this->diagnosa_tujuan),true);
                                $criteria->with=array('diagnosa');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
}

?>
