<?php

class RDRencanaKeperawatanM extends RencanakeperawatanM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AgamaM the static model class
     */
    public static function model($className=__CLASS__)
    {
		return parent::model($className);
            
    }
    public function searchData()
    {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->rencanakeperawatan_id)){
			$criteria->addCondition("rencanakeperawatan_id = ".$this->rencanakeperawatan_id);				
		}
		if(!empty($this->diagnosakeperawatan_id)){
			$criteria->addCondition("diagnosakeperawatan_id = ".$this->diagnosakeperawatan_id);				
		}
		$criteria->compare('LOWER(rencana_kode)',strtolower($this->rencana_kode),true);
		$criteria->compare('LOWER(rencana_intervensi)',strtolower($this->rencana_intervensi),true);
		$criteria->compare('LOWER(rencana_rasionalisasi)',strtolower($this->rencana_rasionalisasi),true);
		$criteria->compare('iskolaborasiintervensi',$this->iskolaborasiintervensi);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
    }
        
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

	   $criteria=new CDbCriteria;

		if(!empty($this->rencanakeperawatan_id)){
			$criteria->addCondition("rencanakeperawatan_id = ".$this->rencanakeperawatan_id);				
		}
		if(!empty($this->diagnosakeperawatan_id)){
			$criteria->addCondition("diagnosakeperawatan_id = ".$this->diagnosakeperawatan_id);				
		}
		$criteria->compare('LOWER(rencana_kode)',strtolower($this->rencana_kode),true);
		$criteria->compare('LOWER(rencana_intervensi)',strtolower($this->rencana_intervensi),true);
		$criteria->compare('LOWER(rencana_rasionalisasi)',strtolower($this->rencana_rasionalisasi),true);
		$criteria->compare('iskolaborasiintervensi',isset($this->iskolaborasiintervensi)?$this->iskolaborasiintervensi:true);
		// $criteria->with=array('diagnosakeperawatan');
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
}
?>