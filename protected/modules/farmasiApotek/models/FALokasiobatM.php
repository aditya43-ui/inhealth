<?php

/**
 * This is the model class for table "lokasiobat_m".
 *
 * The followings are the available columns in table 'lokasiobat_m':
 * @property integer $lokasiobat_id
 * @property string $lokasiobat_nama
 * @property string $lokasiobat_namalain
 * @property boolean $lokasiobat_aktif
 *
 * The followings are the available model relations:
 * @property StokobatalkesT[] $stokobatalkesTs
 */
class FALokasiobatM extends LokasiobatM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LokasiobatM the static model class
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

		if(!empty($this->lokasiobat_id)){
			$criteria->addCondition('lokasiobat_id = '.$this->lokasiobat_id);
		}
		$criteria->compare('LOWER(lokasiobat_nama)',strtolower($this->lokasiobat_nama),true);
		$criteria->compare('LOWER(lokasiobat_namalain)',strtolower($this->lokasiobat_namalain),true);
		$criteria->compare('lokasiobat_aktif',isset($this->lokasiobat_aktif)?$this->lokasiobat_aktif:true);

		return $criteria;
	}
	
}