<?php

/**
 * This is the model class for table "generik_m".
 *
 * The followings are the available columns in table 'generik_m':
 * @property integer $generik_id
 * @property string $generik_nama
 * @property string $generik_namalain
 * @property boolean $generik_aktif
 */
class SAGenerikM extends GenerikM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GenerikM the static model class
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
		if(!empty($this->generik_id)){
			$criteria->addCondition('generik_id = '.$this->generik_id);
		}        
		$criteria->compare('LOWER(generik_nama)',strtolower($this->generik_nama),true);
		$criteria->compare('LOWER(generik_namalain)',strtolower($this->generik_namalain),true);
		$criteria->compare('generik_aktif',isset($this->generik_aktif)?$this->generik_aktif:true);
		$criteria->order='generik_nama';
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
}