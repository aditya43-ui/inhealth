<?php

/**
 * This is the model class for table "aksesvaskular_m".
 *
 * The followings are the available columns in table 'aksesvaskular_m':
 * @property integer $aksesvaskular_id
 * @property string $aksesvaskular_nama
 * @property string $aksesvaskular_namalain
 * @property string $aksesvaskular_deskripsi
 * @property boolean $aksesvaskular_aktif
 */
class HDAksesvaskularM extends AksesvaskularM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AksesvaskularM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('aksesvaskular_id',$this->aksesvaskular_id);
		$criteria->compare('aksesvaskular_nama',$this->aksesvaskular_nama,true);
		$criteria->compare('aksesvaskular_namalain',$this->aksesvaskular_namalain,true);
		$criteria->compare('aksesvaskular_deskripsi',$this->aksesvaskular_deskripsi,true);
		$criteria->compare('aksesvaskular_aktif',$this->aksesvaskular_aktif);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
}