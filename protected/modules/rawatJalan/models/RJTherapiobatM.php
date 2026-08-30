<?php

/**
 * This is the model class for table "therapiobat_m".
 *
 * The followings are the available columns in table 'therapiobat_m':
 * @property integer $therapiobat_id
 * @property string $therapiobat_nama
 * @property string $therapiobat_namalain
 * @property boolean $therapiobat_aktif
 */
class RJTherapiobatM extends TherapiobatM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TherapiobatM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('therapiobat_id',$this->therapiobat_id);
		$criteria->compare('LOWER(therapiobat_nama)',strtolower($this->therapiobat_nama),true);
		$criteria->compare('LOWER(therapiobat_namalain)',strtolower($this->therapiobat_namalain),true);
		$criteria->compare('therapiobat_aktif',isset($this->therapiobat_aktif)?$this->therapiobat_aktif:true);
		//$criteria->limit = 5;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			//'pagination' => false,
		));
	}
}