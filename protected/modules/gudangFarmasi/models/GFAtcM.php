<?php

/**
 * This is the model class for table "atc_m".
 *
 * The followings are the available columns in table 'atc_m':
 * @property integer $atc_id
 * @property string $atc_kode
 * @property string $atc_nama
 * @property string $atc_namalain
 * @property string $atc_singkatan
 * @property string $atc_ddd
 * @property string $atc_units
 * @property string $atc_admr
 * @property string $atc_note
 * @property boolean $atc_aktif
 *
 * The followings are the available model relations:
 * @property ObatalkesM[] $obatalkesMs
 */
class GFAtcM extends AtcM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AtcM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->atc_id)){
			$criteria->addCondition('atc_id = '.$this->atc_id);
		}
		$criteria->compare('LOWER(atc_kode)',strtolower($this->atc_kode),true);
		$criteria->compare('LOWER(atc_nama)',strtolower($this->atc_nama),true);
		$criteria->compare('LOWER(atc_namalain)',strtolower($this->atc_namalain),true);
		$criteria->compare('LOWER(atc_singkatan)',strtolower($this->atc_singkatan),true);
		$criteria->compare('LOWER(atc_ddd)',strtolower($this->atc_ddd),true);
		$criteria->compare('LOWER(atc_units)',strtolower($this->atc_units),true);
		$criteria->compare('LOWER(atc_admr)',strtolower($this->atc_admr),true);
		$criteria->compare('LOWER(atc_note)',strtolower($this->atc_note),true);
		//$criteria->compare('atc_aktif',$this->atc_aktif);
		$criteria->compare('atc_aktif',isset($this->atc_aktif)?$this->atc_aktif:true);

		return $criteria;
	}
        
}