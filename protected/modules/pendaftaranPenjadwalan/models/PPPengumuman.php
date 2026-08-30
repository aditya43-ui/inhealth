<?php

class PPPengumuman extends Pengumuman 
{
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pengumuman the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPengumumanWidget()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pengumuman_id)){
			$criteria->addCondition("pengumuman_id= ".$this->pengumuman_id);			
		}
		$criteria->compare('LOWER(judul)',strtolower($this->judul),true);
		$criteria->compare('LOWER(isi)',strtolower($this->isi),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition("create_loginpemakai_id= ".$this->create_loginpemakai_id);			
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition("update_loginpemakai_id= ".$this->update_loginpemakai_id);			
		}
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->publish_loginpemakai_id)){
			$criteria->addCondition("publish_loginpemakai_id= ".$this->publish_loginpemakai_id);			
		}
		$criteria->AddCondition('status_publish = 1');
                $criteria->limit = 5;
                $criteria->order = "update_time DESC, create_time DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array('pageSize'=>5),
		));
	}
}