<?php

/**
 * This is the model class for table "jamkerja_m".
 *
 * The followings are the available columns in table 'jamkerja_m':
 * @property integer $jamkerja_id
 * @property integer $shift_id
 * @property string $jamkerja_nama
 * @property string $jammasuk
 * @property string $jampulang
 * @property string $jamisitrahat
 * @property string $jammasukistirahat
 * @property string $jammulaiscanmasuk
 * @property string $jamakhirscanmasuk
 * @property string $jammulaiscanplng
 * @property string $jamakhirscanplng
 * @property integer $toleransiterlambat
 * @property integer $toleransiplgcpt
 * @property boolean $jamkerja_aktif
 */
class KPJamkerjaM extends JamkerjaM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JamkerjaM the static model class
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
//	$criteria->compare('jamkerja_id',$this->jamkerja_id);
//	$criteria->compare('shift_id',$this->shift_id);
	if(!empty($this->jamkerja_id)){
			$criteria->addCondition('jamkerja_id = '.$this->jamkerja_id);
	}
	if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
	}
	$criteria->compare('LOWER(jamkerja_nama)',strtolower($this->jamkerja_nama),true);
	$criteria->compare('LOWER(jammasuk)',strtolower($this->jammasuk),true);
	$criteria->compare('LOWER(jampulang)',strtolower($this->jampulang),true);
	$criteria->compare('LOWER(jamisitrahat)',strtolower($this->jamisitrahat),true);
	$criteria->compare('LOWER(jammasukistirahat)',strtolower($this->jammasukistirahat),true);
	$criteria->compare('LOWER(jammulaiscanmasuk)',strtolower($this->jammulaiscanmasuk),true);
	$criteria->compare('LOWER(jamakhirscanmasuk)',strtolower($this->jamakhirscanmasuk),true);
	$criteria->compare('LOWER(jammulaiscanplng)',strtolower($this->jammulaiscanplng),true);
	$criteria->compare('LOWER(jamakhirscanplng)',strtolower($this->jamakhirscanplng),true);
	$criteria->compare('toleransiterlambat',$this->toleransiterlambat);
	$criteria->compare('toleransiplgcpt',$this->toleransiplgcpt);
	$criteria->compare('jamkerja_aktif',$this->jamkerja_aktif);
			// Klo limit lebih kecil dari nol itu berarti ga ada limit 
			$criteria->limit=-1; 

			return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
					'pagination'=>false,
			));
	}
	}
