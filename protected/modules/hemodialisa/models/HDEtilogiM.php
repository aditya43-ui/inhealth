<?php

/**
 * This is the model class for table "etilogi_m".
 *
 * The followings are the available columns in table 'etilogi_m':
 * @property integer $etilogi_id
 * @property string $etilogi_kode
 * @property string $etilogi_nama
 * @property string $etilogi_namalain
 * @property boolean $etilogi_aktif
 */
class HDEtilogiM extends EtilogiM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EtilogiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('etilogi_id',$this->etilogi_id);
		$criteria->compare('LOWER(etilogi_kode)',strtolower($this->etilogi_kode),true);
		$criteria->compare('LOWER(etilogi_nama)',strtolower($this->etilogi_nama),true);
		$criteria->compare('LOWER(etilogi_namalain)',strtolower($this->etilogi_namalain),true);
		$criteria->compare('etilogi_aktif',$this->etilogi_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('etilogi_id',$this->etilogi_id);
		$criteria->compare('LOWER(etilogi_kode)',strtolower($this->etilogi_kode),true);
		$criteria->compare('LOWER(etilogi_nama)',strtolower($this->etilogi_nama),true);
		$criteria->compare('LOWER(etilogi_namalain)',strtolower($this->etilogi_namalain),true);
		$criteria->compare('etilogi_aktif',$this->etilogi_aktif);
        $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>false,
		));
	}
}