<?php
class FACopyResepR extends CopyresepR
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public function searchCopyResep()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->copyresep_id)){
			$criteria->addCondition("copyresep_id = ".$this->copyresep_id);						
		}
		if(!empty($this->reseptur_id)){
			$criteria->addCondition("reseptur_id = ".$this->reseptur_id);						
		}
		if(!empty($this->penjualanresep_id)){
			$criteria->addCondition("penjualanresep_id = ".$this->penjualanresep_id);						
		}
		$criteria->compare('LOWER(tglcopy)',strtolower($this->tglcopy),true);
		$criteria->compare('LOWER(keterangancopy)',strtolower($this->keterangancopy),true);
		$criteria->compare('jmlcopy',$this->jmlcopy);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}