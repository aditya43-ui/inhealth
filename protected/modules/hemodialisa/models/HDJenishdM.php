<?php

/**
 * This is the model class for table "jenishd_m".
 *
 * The followings are the available columns in table 'jenishd_m':
 * @property integer $jenishd_id
 * @property string $jenishd_nama
 * @property string $jenishd_namalain
 * @property string $jenishd_deskripsi
 * @property boolean $jenishd_aktif
 */
class HDJenishdM extends JenishdM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenishdM the static model class
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

		$criteria->compare('jenishd_id',$this->jenishd_id);
		$criteria->compare('jenishd_nama',$this->jenishd_nama,true);
		$criteria->compare('jenishd_namalain',$this->jenishd_namalain,true);
		$criteria->compare('jenishd_deskripsi',$this->jenishd_deskripsi,true);
		$criteria->compare('jenishd_aktif',$this->jenishd_aktif);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
}