<?php

class RKPenyebabLuarCederaM extends PenyebabLuarCederaM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchPenyebabLuarCedera()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->penyebabluarcedera_id)){
			$criteria->addCondition("penyebabluarcedera_id = ".$this->penyebabluarcedera_id);			
		}
		$criteria->compare('LOWER(penyebabluarcedera_nama)',strtolower($this->penyebabluarcedera_nama),true);
		$criteria->compare('LOWER(penyebabluarcedera_namalainnya)',strtolower($this->penyebabluarcedera_namalainnya),true);
		$criteria->compare('LOWER(penyebabluarcedera_aktif)',  strtolower($this->penyebabluarcedera_aktif), true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}