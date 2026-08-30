<?php

class SASumberdanaM extends SumberdanaM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SumberdanaM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition('sumberdana_id = '.$this->sumberdana_id);
		}
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('LOWER(sumberdana_namalainnya)',strtolower($this->sumberdana_namalainnya),true);
		$criteria->compare('sumberdana_aktif',isset($this->sumberdana_aktif)?$this->sumberdana_aktif:true);
//		$criteria->compare('sumberdana_aktif',$this->sumberdana_aktif);
		$criteria->order='sumberdana_nama';
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}


}