<?php

/**
 * This is the model class for table "jenisobatalkes_m".
 *
 * The followings are the available columns in table 'jenisobatalkes_m':
 * @property integer $jenisobatalkes_id
 * @property string $jenisobatalkes_nama
 * @property string $jenisobatalkes_namalain
 * @property boolean $jenisobatalkes_aktif
 */
class SAJenisobatalkesM extends JenisobatalkesM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisobatalkesM the static model class
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

		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(jenisobatalkes_namalain)',strtolower($this->jenisobatalkes_namalain),true);
		$criteria->compare('jenisobatalkes_aktif',isset($this->jenisobatalkes_aktif)?$this->jenisobatalkes_aktif:true);
		$criteria->compare('jenisobatalkes_farmasi', $this->jenisobatalkes_farmasi);
		$criteria->addCondition('jenisobatalkes_farmasi is true');
		$criteria->order='jenisobatalkes_id';
//		$criteria->compare('jenisobatalkes_aktif',$this->jenisobatalkes_aktif);
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}


}